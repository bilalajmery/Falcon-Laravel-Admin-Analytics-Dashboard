@include('includes.header')

<div class="row mb-2">
    <div class="col-sm-6 col-md-3 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="row flex-between-center">
                    <div class="col d-md-flex d-lg-block flex-between-center">
                        <h6 class="mb-md-0 mb-lg-2">Total</h6><span class="badge rounded-pill badge-subtle-warning"><i
                                class="fas fa-user-shield"></i></span>
                    </div>
                    <div class="col-auto">
                        <h4 class="fs-6 fw-normal text-700" id="total">0</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="row flex-between-center">
                    <div class="col d-md-flex d-lg-block flex-between-center">
                        <h6 class="mb-md-0 mb-lg-2">Public</h6><span class="badge rounded-pill badge-subtle-success"><i
                                class="fas fa-lock-open"></i></span>
                    </div>
                    <div class="col-auto">
                        <h4 class="fs-6 fw-normal text-700" id="public">0</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="row flex-between-center">
                    <div class="col d-md-flex d-lg-block flex-between-center">
                        <h6 class="mb-md-0 mb-lg-2">Private</h6><span class="badge rounded-pill badge-subtle-danger"><i
                                class="fas fa-lock"></i></span>
                    </div>
                    <div class="col-auto">
                        <h4 class="fs-6 fw-normal text-700" id="private">0</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="row flex-between-center">
                    <div class="col d-md-flex d-lg-block flex-between-center">
                        <h6 class="mb-md-0 mb-lg-2">Trash</h6><span class="badge rounded-pill badge-subtle-danger"><i
                                class="fas fa-trash-alt"></i></span>
                    </div>
                    <div class="col-auto">
                        <h4 class="fs-6 fw-normal text-700" id="trash">0</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0">Employee Management</h5>
            </div>
            <div class="col-auto ms-auto">
                <a href="/employee/create">
                    <button class="btn btn-primary"><i class="fas fa-plus"></i></button>
                </a>
                <button class="btn btn-primary" onclick="getTableData()"><i class="fas fa-undo"></i></button>
            </div>
        </div>
    </div>
    <div class="card-body bg-body-tertiary">
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div class="col-md-4">
                <div class="form-floating mb-3">
                    <select class="form-select" id="roleId" name="roleId" aria-label="Floating label select example">
                    </select>
                    <label for="roleId">Role</label>
                </div>
            </div>

            <div class="col-md-4 px-3">
                <div class="form-floating mb-3">
                    <input class="form-control" type="search" placeholder="Bilal Ajmery" name="search" id="search" />
                    <label for="floatingInput">Search</label>
                </div>
            </div>


            <div class="col-md-4 d-flex justify-content-end align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="trashEmployee" id="trashEmployee" value="1">
                    <label class="form-check-label" for="trashEmployee">Show Only Trashed Employees</label>
                </div>
            </div>
        </div>

        <div class="table-responsive scrollbar">
            <table class="table table-striped table-bordered overflow-hidden" id="employeeTable">
                <thead>
                    <tr class="btn-reveal-trigger">
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Role</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Status</th>
                        <th scope="col"><span class="text-nowrap">Date & Time</span></th>
                        <th class="text-end" scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <td colspan="7">
                        <div class="d-flex justify-items-center justify-content-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
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
    getRole();

    function getTableData(page = 1, perPage = 10) {
        const thCount = $('#employeeTable thead tr th').length;
        const $tbody = $('#employeeTable tbody');
        const $search = $('#search');
        const $pagination = $('#pagination');

        $.ajax({
            method: 'GET',
            url: '{{ route('employee.index') }}',
            data: {
                search: $search.val(),
                page: page,
                per_page: perPage,
                roleId: $("#roleId").val(),
                trashEmployee: $('#trashEmployee').is(':checked') ? 1 : 0,
            },
            beforeSend: function() {
                $tbody.html(`
                    <tr>
                        <td colspan="${thCount}">
                            <div class="d-flex justify-items-center justify-content-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                `);
                $pagination.html('');
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $tbody.html(response.data);
                renderPagination(response.pagination);
                $("#total").text(response.stats.total);
                $("#public").text(response.stats.public);
                $("#private").text(response.stats.private);
                $("#trash").text(response.stats.trash);
            },
            error: function(xhr) {
                const errorMessage = xhr.responseJSON?.message || 'Failed to load employees.';
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
        const {
            total,
            per_page,
            current_page,
            last_page
        } = pagination;

        if (last_page <= 1) {
            $pagination.html('');
            return;
        }

        let paginationHtml = `
            <nav aria-label="Page navigation">
                <ul class="flex items-center justify-center space-x-2">
        `;

        // Previous button
        paginationHtml += `
            <li>
                <button class="px-3 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-primary hover:text-white ${current_page === 1 ? 'opacity-50 cursor-not-allowed' : ''}"
                    ${current_page === 1 ? 'disabled' : ''} data-page="${current_page - 1}">
                    <span>« Prev</span>
                </button>
            </li>
        `;

        // Page numbers
        const maxPagesToShow = 5;
        const startPage = Math.max(1, current_page - Math.floor(maxPagesToShow / 2));
        const endPage = Math.min(last_page, startPage + maxPagesToShow - 1);

        for (let i = startPage; i <= endPage; i++) {
            paginationHtml += `
                <li>
                    <button class="px-3 py-2 rounded-lg ${i === current_page ? 'bg-primary text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-primary hover:text-white'}"
                        data-page="${i}">${i}</button>
                </li>
            `;
        }

        // Next button
        paginationHtml += `
            <li>
                <button class="px-3 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-primary hover:text-white ${current_page === last_page ? 'opacity-50 cursor-not-allowed' : ''}"
                    ${current_page === last_page ? 'disabled' : ''} data-page="${current_page + 1}">
                    <span>Next »</span>
                </button>
            </li>
        `;

        paginationHtml += `
                </ul>
                <div class="text-center mt-2 text-gray-500 dark:text-gray-400">
                    Showing ${pagination.from || 0} to ${pagination.to || 0} of ${total} entries
                </div>
            </nav>
        `;

        $pagination.html(paginationHtml);

        // Attach click handlers for pagination buttons
        $pagination.find('button[data-page]').on('click', function() {
            const page = $(this).data('page');
            if (page && !$(this).prop('disabled')) {
                getTableData(page, per_page);
            }
        });
    }

    // Initialize search, checkbox handler, and load initial data
    $(document).ready(function() {
        getTableData();

        let searchTimeout;
        $('#search').on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => getTableData(), 300);
        });

        $('#trashEmployee, #roleId').on('change', function() {
            getTableData();
        });
    });
</script>
