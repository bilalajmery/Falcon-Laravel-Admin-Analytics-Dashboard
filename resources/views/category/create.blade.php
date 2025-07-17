@include('includes.header')

<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor" id="example">Create New Category</h5>
            </div>
        </div>
    </div>

    <div class="card-body bg-body-tertiary">
        <form onsubmit="submitForm(event)">
            <div class="row">
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" id="name" placeholder="Category Name" name="name" />
                        <label for="name">Category Name</label>
                    </div>
                </div>

                <div class="col-md-4 mt-md-0 mt-4">
                    <!-- Image Upload Card -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title mb-0">Category Image</h5>
                                <label for="image-upload" class="btn btn-sm btn-light border">
                                    <i class="fas fa-plus"></i>
                                </label>
                                <input id="image-upload" type="file" accept="image/*" class="d-none"
                                    onchange="handleFileUpload(event, 'image-preview', 'image-message', 'image-error')" name="image" />
                            </div>

                            <div class="border border-dashed rounded d-flex align-items-center justify-content-center p-3"
                                style="height: 13rem; position: relative;">
                                <img id="image-preview" class="d-none" style="width: 100%; height: 100%; object-fit: contain;" alt="Image Preview" />
                                <div id="image-message" class="text-center text-muted">
                                    <i class="bi bi-image fs-1"></i>
                                    <p class="mt-2 small">Upload Category Image</p>
                                </div>
                            </div>

                            <p id="image-error" class="d-none text-danger small mt-2"></p>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-5 text-end">
                    <button class="btn btn-primary me-1 mb-1" type="submit" id="formSubmitButton">
                        Create
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('includes.footer')

<script>
    function submitForm(event) {
        event.preventDefault();

        const $form = $(event.target);
        const $submitButton = $('#formSubmitButton');
        const formData = new FormData(event.target);

        const validation = requiredValidate(formData);
        if (validation.error) {
            createToast('error', validation.message);
            return;
        }

        $.ajax({
                method: 'POST',
                url: '/category',
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
                    location.assign("/category");
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
                $submitButton.prop('disabled', false).html('Create');
            });
    }
</script>
