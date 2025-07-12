@php
    $i = 1;
@endphp
@forelse ($data as $d)
    <tr class="btn-reveal-trigger">
        <td>{{ $i }}</td>
        <td class="d-flex align-items-center gap-2">
            <div>
                <img src="{{ $d->profile ?? asset('assets/img/elearning/avatar/student.png') }}" alt="Profile Image"
                    style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
            </div>
            <span>{{ $d->name }}</span>
        </td>
        <td>{{ $d->email }}</td>
        <td>{{ $d->phone }}</td>
        <td>
            <span class="badge rounded-pill badge-subtle-{{ $d->status ? 'success' : 'danger' }}">{{ $d->status ? 'Public' : 'Private' }}</span>
        </td>
        <td>{{ $d->created_at->format('M d, Y - h:i A') }}</td>
        <td class="text-end">
            <div class="dropdown font-sans-serif position-static"><button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button"
                    data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"><span
                        class="fas fa-ellipsis-h fs-10"></span></button>
                <div class="dropdown-menu dropdown-menu-end border py-0">
                    <div class="py-2">
                        <a class="dropdown-item" href="/admin/{{ $d->uid }}/edit" target="_blank"><i class="fas fa-edit"></i> &nbsp; Edit</a>

                        <a class="dropdown-item text-{{ $d->status ? 'danger' : 'success' }} status-btn" href="#" data-id="{{ $d->uid }}"
                            data-status="{{ $d->status ? 'public' : 'private' }}">
                            <i class="fas {{ $d->status ? 'fa-lock' : 'fas fa-lock-open' }}"></i> &nbsp; {{ $d->status ? 'Private' : 'Public' }}
                        </a>

                        <a class="dropdown-item text-{{ $d->deleted_at ? 'success' : 'danger' }} delete-btn" data-id="{{ $d->uid }}"
                            href="#">
                            <i class="fas fa-trash"></i> &nbsp; {{ $d->deleted_at ? 'Restore' : 'Delete' }}
                        </a>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    @php
        $i++;
    @endphp
    @empty
    <tr class="text-center">
        <td colspan="6">No Admins Found</td>
    </tr>
@endforelse

<script>
    $(document).ready(function() {
        // Reusable SweetAlert error handler
        const showError = (message) => {
            Swal.fire({
                title: 'Error!',
                text: message || 'An error occurred.',
                icon: 'error',
                confirmButtonColor: '#3085d6'
            });
        };

        // Delete button handler
        $('.delete-btn').on('click', function() {
            const id = $(this).data('id');
            const $row = $(this).closest('tr');
            const isRestore = $(this).text().trim().toLowerCase() === 'restore';

            const actionText = isRestore ? 'restore' : 'delete';
            const confirmText = isRestore ? 'Yes, restore it!' : 'Yes, delete it!';
            const successText = isRestore ? 'Restored!' : 'Deleted!';
            const successMessage = isRestore ? 'The admin has been restored.' : 'The admin has been deleted.';
            const errorMessage = isRestore ? 'Failed to restore the admin.' : 'Failed to delete the admin.';

            Swal.fire({
                title: 'Are you sure?',
                text: `You want to ${actionText} this admin?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: confirmText,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (!response.error) {
                                $row.fadeOut(300, function() {
                                    $(this).remove();
                                    getTableData(); // Refresh the admin list
                                });

                                Swal.fire({
                                    title: successText,
                                    text: successMessage,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            } else {
                                showError(response.message || errorMessage);
                            }
                        },
                        error: function() {
                            showError(`An error occurred while trying to ${actionText} the admin.`);
                        }
                    });
                }
            });
        });


        // Status toggle button handler
        $('.status-btn').on('click', function() {
            const $btn = $(this);
            const id = $btn.data('id');
            const currentStatus = $btn.data('status').toLowerCase(); // "public" or "private"
            const isCurrentlyPublic = currentStatus === 'public';
            const newStatus = isCurrentlyPublic ? 0 : 1; // 0 = private, 1 = public

            const actionText = isCurrentlyPublic ? 'make Private' : 'make Public';

            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to ${actionText} this admin?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: `Yes, ${actionText}`,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/${id}/status`,
                        type: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            status: newStatus
                        },
                        success: function(response) {
                            if (!response.error) {
                                // Update button label and data
                                $btn
                                    .text(isCurrentlyPublic ? 'Public' : 'Private')
                                    .data('status', isCurrentlyPublic ? 'private' : 'public');

                                Swal.fire({
                                    title: 'Success!',
                                    text: `Admin is now ${isCurrentlyPublic ? 'Private' : 'Public'}.`,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                                // Optional: reload table or just update UI
                                getTableData();
                            } else {
                                showError(response.message || `Failed to update admin status.`);
                            }
                        },
                        error: function() {
                            showError(`An error occurred while updating admin status.`);
                        }
                    });
                }
            });
        });

    });
</script>
