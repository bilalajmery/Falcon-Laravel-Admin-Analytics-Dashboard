@include('includes.header')

<div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
        <div class="modal-content position-relative">
            <div class="position-absolute top-0 end-0 mt-2 me-2 z-1">
                <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form onsubmit="deleteAccount(event)">
                <div class="modal-body p-0">
                    <div class="rounded-top-3 py-3 ps-4 pe-6 bg-body-tertiary">
                        <h4 class="mb-1" id="modalExampleDemoLabel">Enter Your Account Password </h4>
                    </div>
                    <div class="p-4 pb-0">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="password" id="password" placeholder="**** *******" name="password" />
                            <label for="password">Password</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit" id="deleteAccountSubmitButton">Delete </button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card mb-3 btn-reveal-trigger">
            <div class="card-header position-relative min-vh-25 mb-8">

                <div class="cover-image">
                    <div id="coverPreview" class="bg-holder rounded-3 rounded-bottom-0"
                        style="background-image: url('{{ Session::get('adminSession.cover') ?? '../../assets/img/generic/4.jpg' }}');"></div>

                    <input class="d-none" id="upload-cover-image" type="file" />
                    <label class="cover-image-file-input" for="upload-cover-image">
                        <span class="fas fa-camera me-2"></span>
                        <span>Change cover photo</span>
                    </label>
                </div>

                <div class="avatar avatar-5xl avatar-profile shadow-sm img-thumbnail rounded-circle">
                    <div class="h-100 w-100 rounded-circle overflow-hidden position-relative">
                        <img id="profilePreview" src="{{ Session::get('adminSession.profile') ?? asset('assets/img/elearning/avatar/student.png') }}"
                            width="200" alt="Profile" />

                        <input class="d-none" id="profile-image" type="file" accept="image/*" />

                        <label class="mb-0 overlay-icon d-flex flex-center" for="profile-image">
                            <span class="bg-holder overlay overlay-0"></span>
                            <span class="z-1 text-white dark__text-white text-center fs-10">
                                <span class="fas fa-camera"></span><span class="d-block">Update</span>
                            </span>
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="row g-0">
    <div class="col-lg-8 pe-lg-2">

        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Profile Settings</h5>
            </div>
            <div class="card-body bg-body-tertiary">
                <form onsubmit="personalForm(event)" class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" id="name" placeholder="Jhon" name="name"
                                value="{{ Session::GET('adminSession.name') }}" />
                            <label for="name">Full Name</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="text" id="phone" placeholder="**** *******" name="phone"
                                value="{{ Session::GET('adminSession.phone') }}" />
                            <label for="phone">Phone</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <input class="form-control" type="email" placeholder="name@example.com" name="email"
                                value="{{ Session::GET('adminSession.email') }}" readonly />
                            <label for="floatingInput">Email</label>
                        </div>
                    </div>

                    <div class="col-12 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit" id="personalSubmitButton">Save </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-3" style="padding-bottom: 80px;">
            <div class="card-header">
                <h5 class="mb-0">Account Settings</h5>
            </div>
            <div class="card-body bg-body-tertiary">
                <div class="form-check form-switch mb-0 lh-1">
                    @if (Session::GET('adminSession.twoStepVerification'))
                        <input class="form-check-input" type="checkbox" id="twoStepVerificationCheckBox" checked="checked" />
                    @else
                        <input class="form-check-input" type="checkbox" id="twoStepVerificationCheckBox" />
                    @endif

                    <label class="form-check-label mb-0" for="twoStepVerificationCheckBox">Two Step Verification</label>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-4 ps-lg-2">
        <div class="sticky-sidebar">

            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Change Password</h5>
                </div>
                <div class="card-body bg-body-tertiary">
                    <form onsubmit="passwordForm(event)">

                        <div class="form-floating mb-3">
                            <input class="form-control" type="password" id="currentPassword" placeholder="********" name="currentPassword" />
                            <label for="currentPassword">Current Password</label>

                            <!-- Eye Icon -->
                            <i class="fa-solid fa-eye toggle-password position-absolute"
                                style="top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"
                                onclick="togglePassword(this, 'currentPassword')"></i>
                        </div>

                        <div class="form-floating mb-3">
                            <input class="form-control" type="password" id="newPassword" placeholder="********" name="password" />
                            <label for="newPassword">New Password</label>

                            <!-- Eye Icon -->
                            <i class="fa-solid fa-eye toggle-password position-absolute"
                                style="top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"
                                onclick="togglePassword(this, 'newPassword')"></i>
                        </div>

                        <div class="form-floating mb-3">
                            <input class="form-control" type="password" id="confirmPassword" placeholder="********" name="confirmPassword" />
                            <label for="confirmPassword">Confirm Password</label>

                            <!-- Eye Icon -->
                            <i class="fa-solid fa-eye toggle-password position-absolute"
                                style="top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"
                                onclick="togglePassword(this, 'confirmPassword')"></i>
                        </div>

                        <button class="btn btn-primary d-block w-100" type="submit" id="passwordSubmitButton">Change Password</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body bg-body-tertiary">
                    <h5 class="fs-9">Delete this account</h5>
                    <p class="fs-10">Once you delete a account, there is no going back. Please be certain.</p>
                    <a class="btn btn-falcon-danger d-block" href="#" data-bs-toggle="modal" data-bs-target="#error-modal">Delete
                        Account</a>
                </div>
            </div>

        </div>
    </div>
</div>
@include('includes.footer')
<script>
    function personalForm(event) {
        event.preventDefault();

        const $form = $(event.target);
        const $submitButton = $('#personalSubmitButton');
        const formData = new FormData(event.target);

        const validation = requiredValidate(formData);
        if (validation.error) {
            createToast('error', validation.message);
            return;
        }

        $.ajax({
                method: 'POST',
                url: '/setting/personal',
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
                $submitButton.prop('disabled', false).html('Save');
            });
    }

    $("#twoStepVerificationCheckBox").on('click', function() {
        try {
            const isChecked = $(this).prop('checked') ? 1 : 0;

            $.ajax({
                    method: 'POST',
                    url: '/setting/twoStepVerification',
                    data: {
                        twoStepVerification: isChecked
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .done(function(response) {
                    if (!response.error) {
                        createToast('success', `Two-step verification is ${isChecked ? 'enabled' : 'disabled'}`);
                    } else {
                        createToast('error', response.message || 'An unexpected error occurred.');
                    }
                })
                .fail(function(xhr) {
                    const response = xhr.responseJSON || {};
                    let message = 'An error occurred while submitting the request.';

                    if (xhr.status === 422 && response.errors) {
                        message = Object.values(response.errors).flat().join('<br>');
                    } else if (response.message) {
                        message = response.message;
                    }

                    createToast('error', message);
                });

        } catch (error) {
            createToast('error', error.message || 'Something went wrong');
        }
    });

    function passwordForm(event) {
        event.preventDefault();

        const $form = $(event.target);
        const $submitButton = $('#passwordSubmitButton');
        const formData = new FormData(event.target);

        const validation = requiredValidate(formData);
        if (validation.error) {
            createToast('error', validation.message);
            return;
        }

        $.ajax({
                method: 'POST',
                url: '/setting/password',
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
                    location.assign("/logout");
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
                $submitButton.prop('disabled', false).html('Save');
            });
    }

    $(document).ready(function() {
        $("#profile-image").on("change", function(e) {
            const file = e.target.files[0];

            if (!file) return;

            // Preview image
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#profilePreview").attr("src", e.target.result);
            };
            reader.readAsDataURL(file);

            // Prepare and send AJAX request
            const formData = new FormData();
            formData.append("profile", file);

            $.ajax({
                url: "/setting/profile", // Laravel route
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(response) {
                    createToast('success', response.message || 'Profile image updated');
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || "Something went wrong";
                    createToast('error', error);
                }
            });
        });
    });

    $(document).ready(function() {
        $("#upload-cover-image").on("change", function(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Preview cover image
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#coverPreview").css("background-image", `url('${e.target.result}')`);
            };
            reader.readAsDataURL(file);

            // Upload via AJAX
            const formData = new FormData();
            formData.append("cover", file);

            $.ajax({
                url: "/setting/cover", // Adjust to your Laravel route
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(response) {
                    createToast('success', response.message || 'Cover photo updated');
                },
                error: function(xhr) {
                    const error = xhr.responseJSON?.message || "Something went wrong";
                    createToast('error', error);
                }
            });
        });
    });


    function deleteAccount(event) {
        event.preventDefault();

        const $form = $(event.target);
        const $submitButton = $('#deleteAccountSubmitButton');
        const formData = new FormData(event.target);

        const validation = requiredValidate(formData);
        if (validation.error) {
            createToast('error', validation.message);
            return;
        }

        $.ajax({
                method: 'POST',
                url: '/setting/accountDelete',
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
                    location.assign("/logout");
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
                $submitButton.prop('disabled', false).html('Save');
            });
    }
</script>
