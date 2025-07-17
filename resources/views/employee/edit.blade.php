@include('includes.header')

<style>
    .checkbox-card {
        max-width: 400px;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
    }

    .form-check-label {
        cursor: pointer;
    }

    .stats-card {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .stats-card .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #dee2e6;
    }

    .stats-card .stat-item:last-child {
        border-bottom: none;
    }
</style>

<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor" id="example">Edit Employee</h5>
            </div>
        </div>
    </div>
    <div class="card-body bg-body-tertiary">
        <form onsubmit="submitForm(event)">
            <input type="hidden" name="_method" value="PATCH">
            <div class="row">
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="roleId" name="roleId" aria-label="Floating label select example">
                        </select>
                        <label for="roleId">Role</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" id="name" placeholder="Jhon" name="name" value="{{ $employee->name }}" />
                        <label for="name">Full Name</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        @php
                            $phone = $employee->phone ?? '';
                        @endphp
                        <input class="form-control" type="text" id="phone" placeholder="**** *******" name="phone"
                            value="{{ $phone }}" />
                        <label for="phone">Phone</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input class="form-control" type="email" placeholder="name@example.com" name="email" value="{{ $employee->email }}" />
                        <label for="floatingInput">Email</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control" type="password" id="password" placeholder="Password" name="password" />
                        <label for="password">Password (leave blank to keep unchanged)</label>
                    </div>
                </div>

                <div class="col-md-6 mt-4">
                    <!-- Profile Card -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">Profile</h5>
                                <label for="image-upload" class="btn btn-sm btn-light border">
                                    <i class="fas fa-plus"></i>
                                </label>
                                <input id="image-upload" type="file" accept="image/*" class="d-none"
                                    onchange="handleFileUpload(event, 'image-preview', 'image-message', 'image-error')" name="profile" />
                            </div>

                            <div class="border border-dashed rounded d-flex align-items-center justify-content-center p-3"
                                style="height: 13rem; position: relative;">
                                <img id="image-preview" class="{{ $employee->profile ? '' : 'd-none' }}"
                                    style="width: 100%; height: 100%; object-fit: contain;" alt="Brand Preview"
                                    src="{{ $employee->profile ? $employee->profile : '' }}" />
                                <div id="image-message" class="text-center text-muted {{ $employee->profile ? 'd-none' : '' }}">
                                    <i class="bi bi-image fs-1"></i>
                                    <p class="mt-2 small">Upload Profile</p>
                                </div>
                            </div>

                            <p id="image-error" class="d-none text-danger small mt-2"></p>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-5 text-end">
                    <button class="btn btn-primary me-1 mb-1" type="submit" id="formSubmitButton">
                        Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('includes.footer')
<script>
    getRole('{{ $employee->roleId }}');
    function submitForm(event) {
        event.preventDefault();

        const $form = $(event.target);
        const $submitButton = $('#formSubmitButton');
        const formData = new FormData(event.target);

        const exception = ['profile', 'password'];
        const validation = requiredValidate(formData, exception);
        if (validation.error) {
            createToast('error', validation.message);
            return;
        }

        $.ajax({
                method: 'POST',
                url: '{{ route('employee.update', $employee->uid) }}',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $submitButton.prop('disabled', true).html(`
                    <div class="spinner-border text-white" style="width: 20px; height: 20px;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                `);
                }
            })
            .done(function(response) {
                if (!response.error) {
                    createToast('success', response.message);
                    // location.assign("/employee");
                } else {
                    createToast('error', response.message || 'An unexpected error occurred.');
                }
            })
            .fail(function(xhr) {
                const response = xhr.responseJSON || {};
                let message = 'An error occurred while submitting the form.';

                if (xhr.status === 422 && response.errors) {
                    message = Object.values(response.errors).flat().join('<br>');
                } else if (response.message) {
                    message = response.message;
                }

                createToast('error', message);
            })
            .always(function() {
                $submitButton.prop('disabled', false).html('Update');
            });
    }
</script>
