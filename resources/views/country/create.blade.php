@include('includes.header')

<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0">Create New Country</h5>
            </div>
        </div>
    </div>

    <div class="card-body bg-body-tertiary">
        <form onsubmit="submitForm(event)">
            <div class="row">
                <!-- Country Name -->
                <div class="col-md-8">
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" id="name" placeholder="Country Name" name="name"/>
                        <label for="name">Country Name</label>
                    </div>
                </div>

                <!-- Country Code -->
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" id="code" placeholder="Country Name" name="code"/>
                        <label for="code">Country Code</label>
                    </div>
                </div>

                <!-- Submit Button -->
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
                url: '{{ route('country.store') }}',
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
                    location.assign("{{ route('country.index') }}");
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
