@include('includes.header')

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .access-card {
        background-color: #f9fafb;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .access-card:hover {
        background-color: #eff6ff;
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
    }

    .access-card input[type="checkbox"] {
        transform: scale(1.4);
        accent-color: #2563eb;
        cursor: pointer;
    }

    .access-card h6 {
        font-size: 0.95rem;
        color: #111827;
        margin: 0;
        font-weight: 500;
        user-select: none;
    }

    .disabledButton {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .buttonLoader {
        border: 3px solid #ffffff;
        border-top: 3px solid #2563eb;
        border-radius: 50%;
        width: 1.5rem;
        height: 1.5rem;
        animation: spin 1s linear infinite;
        display: inline-block;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">Create New Role Permissions</h5>
    </div>

    <div class="card-body bg-body-tertiary">
        <form onsubmit="insertData(event)" id="permissionForm">
            @csrf
            <div class="row">
                @foreach (json_decode($role->permission ?? '{}') as $key => $value)
                    <div class="col-md-3 mb-3">
                        <div class="access-card">
                            <input
                                type="checkbox"
                                id="{{ $key }}"
                                name="permissions[{{ $key }}]"
                                @checked($value)
                            >
                            <label for="{{ $key }}">
                                <h6 class="mb-0">{{ str_replace('_', ' ', ucfirst($key)) }}</h6>
                            </label>
                        </div>
                    </div>
                @endforeach

                <input type="hidden" name="uid" value="{{ $role->uid }}">

                <div class="col-12 mt-4 text-end">
                    <button class="btn btn-primary" type="submit" id="formSubmitButton" data-original-text="Save">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@include('includes.footer')

<script>
    function insertData(event) {
        event.preventDefault();

        const $form = $('#permissionForm');
        const $submitButton = $('#formSubmitButton');
        const formData = new FormData($form[0]);

        $.ajax({
            method: "POST",
            url: '/role/permission',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $submitButton
                    .prop('disabled', true)
                    .addClass('disabledButton')
                    .html('<div class="buttonLoader"></div>');
            },
            success: function (response) {
                $submitButton
                    .prop('disabled', false)
                    .removeClass('disabledButton')
                    .html($submitButton.data('original-text'));

                if (response.error) {
                    createToast('error', response.message);
                } else {
                    createToast('success', response.message);
                    // Optional: window.location.reload();
                }
            },
            error: function (xhr) {
                let message = "Something went wrong.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                createToast('error', message);
                $submitButton
                    .prop('disabled', false)
                    .removeClass('disabledButton')
                    .html($submitButton.data('original-text'));
            }
        });
    }

    // Click-to-toggle the whole card (not just checkbox)
    $(document).ready(function () {
        $('.access-card').on('click', function (e) {
            if (e.target.tagName !== 'INPUT') {
                const checkbox = $(this).find('input[type="checkbox"]');
                checkbox.prop('checked', !checkbox.prop('checked'));
            }
        });
    });
</script>
