@php $i = 1; @endphp
@forelse ($data as $d)
    <tr class="btn-reveal-trigger">
        <td>{{ $i }}</td>
        <td class="d-flex align-items-center gap-2">
            <div>
                <img src="{{ asset($d->image ?? 'assets/img/default-image.png') }}" alt="Sub Type Image"
                    style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px;">
            </div>
            <span>{{ $d->name }}</span>
        </td>
        <td>{{ $d->type?->name ?? '—' }}</td>
        <td>
            <span class="badge rounded-pill badge-subtle-{{ $d->status ? 'success' : 'danger' }}">
                {{ $d->status ? 'Public' : 'Private' }}
            </span>
        </td>
        <td>{{ $d->created_at->format('M d, Y - h:i A') }}</td>
        <td class="text-end">
            <div class="dropdown font-sans-serif position-static">
                <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal" type="button"
                    data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false">
                    <span class="fas fa-ellipsis-h fs-10"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-end border py-0">
                    <div class="py-2">
                        <a class="dropdown-item" href="/subType/{{ $d->uid }}/edit" target="_blank">
                            <i class="fas fa-edit"></i> &nbsp; Edit
                        </a>

                        <a class="dropdown-item text-{{ $d->status ? 'danger' : 'success' }} status-btn" href="#"
                            data-id="{{ $d->uid }}" data-status="{{ $d->status ? 'public' : 'private' }}">
                            <i class="fas {{ $d->status ? 'fa-lock' : 'fa-lock-open' }}"></i> &nbsp;
                            {{ $d->status ? 'Make Private' : 'Make Public' }}
                        </a>

                        <a class="dropdown-item text-{{ $d->deleted_at ? 'success' : 'danger' }} delete-btn"
                            data-id="{{ $d->uid }}" href="#">
                            <i class="fas fa-trash"></i> &nbsp; {{ $d->deleted_at ? 'Restore' : 'Delete' }}
                        </a>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    @php $i++; @endphp
@empty
    <tr class="text-center">
        <td colspan="6">No Sub Types Found</td>
    </tr>
@endforelse

<script>
    $(document).ready(function () {
        const showError = (message) => {
            Swal.fire({
                title: 'Error!',
                text: message || 'An error occurred.',
                icon: 'error',
                confirmButtonColor: '#3085d6'
            });
        };

        // Delete or Restore
        $('.delete-btn').on('click', function () {
            const id = $(this).data('id');
            const $row = $(this).closest('tr');
            const isRestore = $(this).text().trim().toLowerCase() === 'restore';

            Swal.fire({
                title: 'Are you sure?',
                text: `You want to ${isRestore ? 'restore' : 'delete'} this sub type?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: `Yes, ${isRestore ? 'restore' : 'delete'} it!`
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/subType/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (!response.error) {
                                $row.fadeOut(300, function () {
                                    $(this).remove();
                                    getTableData();
                                });

                                Swal.fire({
                                    title: isRestore ? 'Restored!' : 'Deleted!',
                                    text: response.message,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            } else {
                                showError(response.message);
                            }
                        },
                        error: function () {
                            showError(`An error occurred while trying to ${isRestore ? 'restore' : 'delete'} the sub type.`);
                        }
                    });
                }
            });
        });

        // Status Toggle
        $('.status-btn').on('click', function () {
            const $btn = $(this);
            const id = $btn.data('id');
            const currentStatus = $btn.data('status') === 'public';

            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to ${currentStatus ? 'make Private' : 'make Public'} this sub type?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: `Yes, ${currentStatus ? 'make Private' : 'make Public'}`
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/subType/${id}/status`,
                        type: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (!response.error) {
                                getTableData();
                                Swal.fire({
                                    title: 'Success!',
                                    text: `Sub Type is now ${currentStatus ? 'Private' : 'Public'}.`,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            } else {
                                showError(response.message);
                            }
                        },
                        error: function () {
                            showError('An error occurred while updating sub type status.');
                        }
                    });
                }
            });
        });
    });
</script>
