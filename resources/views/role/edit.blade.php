@include('includes.header')

<div class="card mb-3">
    <div class="card-header">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor" id="example">Edit Role</h5>
            </div>
        </div>
    </div>

    <div class="card-body bg-body-tertiary">
        <form onsubmit="submitForm(event)">
            <input type="hidden" name="_method" value="PATCH">
            <div class="row">
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" id="name" placeholder="Role Name" name="name"
                            value="{{ $role->name }}" />
                        <label for="name">Role Name</label>
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
    function submitForm(event) {
        event.preventDefault();

        const $submitButton = $('#formSubmitButton');
        const formData = new FormData(event.target);

        const validation = requiredValidate(formData);
        if (validation.error) {
            createToast('error', validation.message);
            return;
        }

        $.ajax({
            method: 'POST',
            url: '{{ route('role.update', $role->uid) }}',
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
                location.assign("{{ route('role.index') }}");
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
