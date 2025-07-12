@include('includes.header')

<div class="row mb-4">
    @foreach (['Total' => 'warning', 'Public' => 'success', 'Private' => 'danger', 'Trash' => 'danger'] as $label => $color)
        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row flex-between-center">
                        <div class="col d-md-flex d-lg-block flex-between-center">
                            <h6 class="mb-md-0 mb-lg-2">{{ $label }}</h6>
                            <span class="badge rounded-pill badge-subtle-{{ $color }}">
                                <i class="fas {{ $label === 'Trash' ? 'fa-trash-alt' : ($label === 'Public' ? 'fa-lock-open' : ($label === 'Private' ? 'fa-lock' : 'fa-layer-group')) }}"></i>
                            </span>
                        </div>
                        <div class="col-auto">
                            <h4 class="fs-6 fw-normal text-700" id="{{ strtolower($label) }}">0</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0">Role Management</h5>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('role.create') }}">
                    <button class="btn btn-primary"><i class="fas fa-plus"></i></button>
                </a>
                <button class="btn btn-primary" onclick="getTableData()"><i class="fas fa-undo"></i></button>
            </div>
        </div>
    </div>

    <div class="card-body bg-body-tertiary">
        <div class="d-flex justify-content-end align-items-center mb-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="trashCategory" id="trashCategory" value="1">
                <label class="form-check-label" for="trashCategory">Show Only Trashed Roles</label>
            </div>
        </div>

        <div class="table-responsive scrollbar">
            <table class="table table-striped table-bordered overflow-hidden" id="roleTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Role Name</th>
                        <th>Status</th>
                        <th>Date & Time</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <td colspan="5" class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </td>
                </tbody>
            </table>
        </div>
        <div id="pagination" class="mt-3"></div>
    </div>
</div>

@include('includes.footer')

<script>
    function getTableData(page = 1, perPage = 10) {
        const thCount = $('#roleTable thead tr th').length;
        const $tbody = $('#roleTable tbody');
        const $pagination = $('#pagination');

        $.ajax({
            method: 'GET',
            url: '{{ route('role.index') }}',
            data: {
                page: page,
                per_page: perPage,
                trashCategory: $('#trashCategory').is(':checked') ? 1 : 0,
            },
            beforeSend: function () {
                $tbody.html(`
                    <tr>
                        <td colspan="${thCount}">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                `);
                $pagination.html('');
            },
            success: function (response) {
                $tbody.html(response.data);
                renderPagination(response.pagination);
                $("#total").text(response.stats.total);
                $("#public").text(response.stats.public);
                $("#private").text(response.stats.private);
                $("#trash").text(response.stats.trash);
            },
            error: function (xhr) {
                const errorMessage = xhr.responseJSON?.message || 'Failed to load roles.';
                createToast('error', errorMessage);
                $tbody.html(`
                    <tr>
                        <td colspan="${thCount}">
                            <div class="text-center text-danger py-4">
                                ${errorMessage}
                            </div>
                        </td>
                    </tr>
                `);
            }
        });
    }

    function renderPagination(pagination) {
        const $pagination = $('#pagination');
        const { total, per_page, current_page, last_page, from, to } = pagination;

        if (last_page <= 1) {
            $pagination.html('');
            return;
        }

        let paginationHtml = `
            <nav aria-label="Page navigation">
                <ul class="flex items-center justify-center space-x-2">
        `;

        paginationHtml += `
            <li>
                <button class="px-3 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-primary hover:text-white ${current_page === 1 ? 'opacity-50 cursor-not-allowed' : ''}"
                    ${current_page === 1 ? 'disabled' : ''} data-page="${current_page - 1}">
                    « Prev
                </button>
            </li>
        `;

        const maxPagesToShow = 5;
        const startPage = Math.max(1, current_page - Math.floor(maxPagesToShow / 2));
        const endPage = Math.min(last_page, startPage + maxPagesToShow - 1);

        for (let i = startPage; i <= endPage; i++) {
            paginationHtml += `
                <li>
                    <button class="px-3 py-2 rounded-lg ${i === current_page ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700 hover:bg-primary hover:text-white'}"
                        data-page="${i}">${i}</button>
                </li>
            `;
        }

        paginationHtml += `
            <li>
                <button class="px-3 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-primary hover:text-white ${current_page === last_page ? 'opacity-50 cursor-not-allowed' : ''}"
                    ${current_page === last_page ? 'disabled' : ''} data-page="${current_page + 1}">
                    Next »
                </button>
            </li>
        `;

        paginationHtml += `
                </ul>
                <div class="text-center mt-2 text-gray-500">
                    Showing ${from || 0} to ${to || 0} of ${total} entries
                </div>
            </nav>
        `;

        $pagination.html(paginationHtml);

        $pagination.find('button[data-page]').on('click', function () {
            const page = $(this).data('page');
            if (page && !$(this).prop('disabled')) {
                getTableData(page, per_page);
            }
        });
    }

    $(document).ready(function () {
        getTableData();

        $('#trashCategory').on('change', function () {
            getTableData();
        });
    });
</script>
