<footer class="footer">
    <div class="row g-0 justify-content-between fs-10 mt-4 mb-3">
        <div class="col-12 col-sm-auto text-center">
            <p class="mb-0 text-600">Thank you for creating with Falcon <span class="d-none d-sm-inline-block">|
                </span><br class="d-sm-none" /> 2025 &copy; <a href="https://digitalelliptical.com/">Digital
                    Elliptical</a>
            </p>
        </div>
        <div class="col-12 col-sm-auto text-center">
            <p class="mb-0 text-600">v3.24.0</p>
        </div>
    </div>
</footer>
</div>

<div class="modal fade" id="authentication-modal" tabindex="-1" role="dialog"
    aria-labelledby="authentication-modal-label" aria-hidden="true">
    <div class="modal-dialog mt-6" role="document">
        <div class="modal-content border-0">
            <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1">
                    <h4 class="mb-0 text-white" id="authentication-modal-label">Register</h4>
                    <p class="fs-10 mb-0 text-white">Please create your free Falcon account</p>
                </div>
                <div data-bs-theme="dark"><button class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button></div>
            </div>
            <div class="modal-body py-4 px-5">
                <form>
                    <div class="mb-3"><label class="form-label" for="modal-auth-name">Name</label><input
                            class="form-control" type="text" autocomplete="on" id="modal-auth-name" /></div>
                    <div class="mb-3"><label class="form-label" for="modal-auth-email">Email
                            address</label><input class="form-control" type="email" autocomplete="on"
                            id="modal-auth-email" /></div>
                    <div class="row gx-2">
                        <div class="mb-3 col-sm-6"><label class="form-label"
                                for="modal-auth-password">Password</label><input class="form-control" type="password"
                                autocomplete="on" id="modal-auth-password" /></div>
                        <div class="mb-3 col-sm-6"><label class="form-label" for="modal-auth-confirm-password">Confirm
                                Password</label><input class="form-control" type="password" autocomplete="on"
                                id="modal-auth-confirm-password" />
                        </div>
                    </div>
                    <div class="form-check"><input class="form-check-input" type="checkbox"
                            id="modal-auth-register-checkbox" /><label class="form-label"
                            for="modal-auth-register-checkbox">I
                            accept the <a href="#!">terms </a>and <a class="white-space-nowrap"
                                href="#!">privacy
                                policy</a></label></div>
                    <div class="mb-3"><button class="btn btn-primary d-block w-100 mt-3" type="submit"
                            name="submit">Register</button></div>
                </form>
                <div class="position-relative mt-5">
                    <hr />
                    <div class="divider-content-center">or register with</div>
                </div>
                <div class="row g-2 mt-2">
                    <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100"
                            href="#"><span class="fab fa-google-plus-g me-2" data-fa-transform="grow-8"></span>
                            google</a></div>
                    <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100" href="#"><span
                                class="fab fa-facebook-square me-2" data-fa-transform="grow-8"></span> facebook</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</main>

<div class="offcanvas offcanvas-end settings-panel border-0" id="settings-offcanvas" tabindex="-1"
    aria-labelledby="settings-offcanvas">
    <div class="offcanvas-header settings-panel-header justify-content-between bg-shape">
        <div class="z-1 py-1">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h5 class="text-white mb-0 me-2"><span class="fas fa-palette me-2 fs-9"></span>Settings</h5><button
                    class="btn btn-primary btn-sm rounded-pill mt-0 mb-0" data-theme-control="reset"
                    style="font-size:12px">
                    <span class="fas fa-redo-alt me-1" data-fa-transform="shrink-3"></span>Reset</button>
            </div>
            <p class="mb-0 fs-10 text-white opacity-75"> Set your own customized style</p>
        </div>
        <div class="z-1" data-bs-theme="dark"><button class="btn-close z-1 mt-0" type="button"
                data-bs-dismiss="offcanvas" aria-label="Close"></button></div>
    </div>
    <div class="offcanvas-body scrollbar-overlay px-x1 h-100" id="themeController">
        <h5 class="fs-9">Color Scheme</h5>
        <p class="fs-10">Choose the perfect color mode for your app.</p>
        <div class="btn-group d-block w-100 btn-group-navbar-style">
            <div class="row gx-2">
                <div class="col-4"><input class="btn-check" id="themeSwitcherLight" name="theme-color"
                        type="radio" value="light" data-theme-control="theme" /><label
                        class="btn d-inline-block btn-navbar-style fs-10" for="themeSwitcherLight"> <span
                            class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                src="/assets/img/generic/falcon-mode-default.jpg" alt="" /></span><span
                            class="label-text">Light</span></label></div>
                <div class="col-4"><input class="btn-check" id="themeSwitcherDark" name="theme-color"
                        type="radio" value="dark" data-theme-control="theme" /><label
                        class="btn d-inline-block btn-navbar-style fs-10" for="themeSwitcherDark"> <span
                            class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                src="/assets/img/generic/falcon-mode-dark.jpg" alt="" /></span><span
                            class="label-text">
                            Dark</span></label></div>
                <div class="col-4"><input class="btn-check" id="themeSwitcherAuto" name="theme-color"
                        type="radio" value="auto" data-theme-control="theme" /><label
                        class="btn d-inline-block btn-navbar-style fs-10" for="themeSwitcherAuto"> <span
                            class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                src="/assets/img/generic/falcon-mode-auto.jpg" alt="" /></span><span
                            class="label-text">
                            Auto</span></label></div>
            </div>
        </div>
        <hr />
        <div class="d-flex justify-content-between">
            <div class="d-flex align-items-start"><img class="me-2"
                    src="/assets/img/icons/left-arrow-from-left.svg" width="20" alt="" />
                <div class="flex-1">
                    <h5 class="fs-9">RTL Mode</h5>
                    <p class="fs-10 mb-0">Switch your language direction </p><a class="fs-10"
                        href="documentation/customization/configuration.html">RTL Documentation</a>
                </div>
            </div>
            <div class="form-check form-switch"><input class="form-check-input ms-0" id="mode-rtl" type="checkbox"
                    data-theme-control="isRTL" />
            </div>
        </div>
        <hr />
        <div class="d-flex justify-content-between">
            <div class="d-flex align-items-start"><img class="me-2" src="/assets/img/icons/arrows-h.svg"
                    width="20" alt="" />
                <div class="flex-1">
                    <h5 class="fs-9">Fluid Layout</h5>
                    <p class="fs-10 mb-0">Toggle container layout system </p><a class="fs-10"
                        href="documentation/customization/configuration.html">Fluid Documentation</a>
                </div>
            </div>
            <div class="form-check form-switch"><input class="form-check-input ms-0" id="mode-fluid" type="checkbox"
                    data-theme-control="isFluid" /></div>
        </div>
        <hr />
        <div class="d-flex align-items-start"><img class="me-2" src="/assets/img/icons/paragraph.svg"
                width="20" alt="" />
            <div class="flex-1">
                <h5 class="fs-9 d-flex align-items-center">Navigation Position</h5>
                <p class="fs-10 mb-2">Select a suitable navigation system for your web application </p>
                <div><select class="form-select form-select-sm" aria-label="Navbar position"
                        data-theme-control="navbarPosition">
                        <option value="vertical">Vertical</option>
                        <option value="top">Top</option>
                        <option value="combo">Combo</option>
                        <option value="double-top">Double Top</option>
                    </select></div>
            </div>
        </div>
        <hr />
        <h5 class="fs-9 d-flex align-items-center">Vertical Navbar Style</h5>
        <p class="fs-10 mb-0">Switch between styles for your vertical navbar </p>
        <p> <a class="fs-10" href="modules/components/navs-and-tabs/vertical-navbar.html#navbar-styles">See
                Documentation</a></p>
        <div class="btn-group d-block w-100 btn-group-navbar-style">
            <div class="row gx-2">
                <div class="col-6"><input class="btn-check" id="navbar-style-transparent" type="radio"
                        name="navbarStyle" value="transparent" data-theme-control="navbarStyle" /><label
                        class="btn d-block w-100 btn-navbar-style fs-10" for="navbar-style-transparent">
                        <img class="img-fluid img-prototype" src="/assets/img/generic/default.png"
                            alt="" /><span class="label-text">
                            Transparent</span></label></div>
                <div class="col-6"><input class="btn-check" id="navbar-style-inverted" type="radio"
                        name="navbarStyle" value="inverted" data-theme-control="navbarStyle" /><label
                        class="btn d-block w-100 btn-navbar-style fs-10" for="navbar-style-inverted">
                        <img class="img-fluid img-prototype" src="/assets/img/generic/inverted.png"
                            alt="" /><span class="label-text">
                            Inverted</span></label></div>
                <div class="col-6"><input class="btn-check" id="navbar-style-card" type="radio"
                        name="navbarStyle" value="card" data-theme-control="navbarStyle" /><label
                        class="btn d-block w-100 btn-navbar-style fs-10" for="navbar-style-card"> <img
                            class="img-fluid img-prototype" src="/assets/img/generic/card.png" alt="" /><span
                            class="label-text">
                            Card</span></label></div>
                <div class="col-6"><input class="btn-check" id="navbar-style-vibrant" type="radio"
                        name="navbarStyle" value="vibrant" data-theme-control="navbarStyle" /><label
                        class="btn d-block w-100 btn-navbar-style fs-10" for="navbar-style-vibrant"> <img
                            class="img-fluid img-prototype" src="/assets/img/generic/vibrant.png"
                            alt="" /><span class="label-text">
                            Vibrant</span></label></div>
            </div>
        </div>
    </div>
</div>

<a class="card setting-toggle" href="#settings-offcanvas" data-bs-toggle="offcanvas">
    <div class="card-body d-flex align-items-center py-md-2 px-2 py-1">
        <div class="bg-primary-subtle position-relative rounded-start" style="height:34px;width:28px">
            <div class="settings-popover"><span class="ripple"><span
                        class="fa-spin position-absolute all-0 d-flex flex-center"><span
                            class="icon-spin position-absolute all-0 d-flex flex-center"><svg width="20"
                                height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.7369 12.3941L19.1989 12.1065C18.4459 11.7041 18.0843 10.8487 18.0843 9.99495C18.0843 9.14118 18.4459 8.28582 19.1989 7.88336L19.7369 7.59581C19.9474 7.47484 20.0316 7.23291 19.9474 7.03131C19.4842 5.57973 18.6843 4.28943 17.6738 3.20075C17.5053 3.03946 17.2527 2.99914 17.0422 3.12011L16.393 3.46714C15.6883 3.84379 14.8377 3.74529 14.1476 3.3427C14.0988 3.31422 14.0496 3.28621 14.0002 3.25868C13.2568 2.84453 12.7055 2.10629 12.7055 1.25525V0.70081C12.7055 0.499202 12.5371 0.297594 12.2845 0.257272C10.7266 -0.105622 9.16879 -0.0653007 7.69516 0.257272C7.44254 0.297594 7.31623 0.499202 7.31623 0.70081V1.23474C7.31623 2.09575 6.74999 2.8362 5.99824 3.25599C5.95774 3.27861 5.91747 3.30159 5.87744 3.32493C5.15643 3.74527 4.26453 3.85902 3.53534 3.45302L2.93743 3.12011C2.72691 2.99914 2.47429 3.03946 2.30587 3.20075C1.29538 4.28943 0.495411 5.57973 0.0322686 7.03131C-0.051939 7.23291 0.0322686 7.47484 0.242788 7.59581L0.784376 7.8853C1.54166 8.29007 1.92694 9.13627 1.92694 9.99495C1.92694 10.8536 1.54166 11.6998 0.784375 12.1046L0.242788 12.3941C0.0322686 12.515 -0.051939 12.757 0.0322686 12.9586C0.495411 14.4102 1.29538 15.7005 2.30587 16.7891C2.47429 16.9504 2.72691 16.9907 2.93743 16.8698L3.58669 16.5227C4.29133 16.1461 5.14131 16.2457 5.8331 16.6455C5.88713 16.6767 5.94159 16.7074 5.99648 16.7375C6.75162 17.1511 7.31623 17.8941 7.31623 18.7552V19.2891C7.31623 19.4425 7.41373 19.5959 7.55309 19.696C7.64066 19.7589 7.74815 19.7843 7.85406 19.8046C9.35884 20.0925 10.8609 20.0456 12.2845 19.7729C12.5371 19.6923 12.7055 19.4907 12.7055 19.2891V18.7346C12.7055 17.8836 13.2568 17.1454 14.0002 16.7312C14.0496 16.7037 14.0988 16.6757 14.1476 16.6472C14.8377 16.2446 15.6883 16.1461 16.393 16.5227L17.0422 16.8698C17.2527 16.9907 17.5053 16.9504 17.6738 16.7891C18.7264 15.7005 19.4842 14.4102 19.9895 12.9586C20.0316 12.757 19.9474 12.515 19.7369 12.3941ZM10.0109 13.2005C8.1162 13.2005 6.64257 11.7893 6.64257 9.97478C6.64257 8.20063 8.1162 6.74905 10.0109 6.74905C11.8634 6.74905 13.3792 8.20063 13.3792 9.97478C13.3792 11.7893 11.8634 13.2005 10.0109 13.2005Z"
                                    fill="#2A7BE4"></path>
                            </svg></span></span></span></div>
        </div><small
            class="text-uppercase text-primary fw-bold bg-primary-subtle py-2 pe-2 ps-1 rounded-end">customize</small>
    </div>
</a>

<!-- ===============================================--><!--    JavaScripts--><!-- ===============================================-->
<script src="/vendors/popper/popper.min.js"></script>
<script src="/vendors/bootstrap/bootstrap.min.js"></script>
<script src="/vendors/anchorjs/anchor.min.js"></script>
<script src="/vendors/is/is.min.js"></script>
<script src="/vendors/echarts/echarts.min.js"></script>
<script src="/vendors/fontawesome/all.min.js"></script>
<script src="/vendors/lodash/lodash.min.js"></script>
<script src="/vendors/list.js/list.min.js"></script>
<script src="/assets/js/theme.js"></script>
<script src="/vendors/choices/choices.min.js"></script>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="/commonAssets/js/toast.js"></script>

<script>
    getSideBar();

    function getSideBar() {
        $.ajax({
                method: "GET",
                url: '/common/sidebar',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .done(function(response) {
                const relativeItems = [
                    'home',
                    'category',
                    'subCategory',
                    'type',
                    'subType',
                    'make',
                    'model',
                    'country',
                    'state',
                    'city',
                ];

                const adminOnlyItems = [
                    'admin',
                    'role',
                    'employee'
                ];

                // Show a sidebar item by removing the 'd-none' class
                const showItem = key => $('.nav-item-' + key).removeClass('d-none');

                // Remove a sidebar item
                const removeItem = key => $('.nav-item-' + key).remove();

                const {
                    admin
                } = response;

                if (admin?.type === "ADMIN") {
                    [...relativeItems, ...adminOnlyItems].forEach(showItem);
                } else if (admin?.type === "EMPLOYEE") {
                    const permissions = admin.role?.permission ? JSON.parse(admin.role.permission) : {};

                    relativeItems.forEach(key => {
                        permissions[key] ? showItem(key) : removeItem(key);
                    });

                    adminOnlyItems.forEach(key => {
                        removeItem(key);
                    });
                }
            })
            .fail(function() {
                createToast('error', 'Failed to load sidebar. Please try again.');
            });
    }



    function getCategory(categoryId = 0) {
        const $categorySelect = $("select[name='categoryId']");

        $categorySelect.prop('disabled', true).html(`<option value="">Fetching Categories...</option>`);

        $.ajax({
                method: "GET",
                url: '/common/category',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .done(function(response) {
                const categories = response.category || [];
                let options =
                    `<option value="" disabled selected>${categories.length ? "Select Category" : "No Categories found"}</option>`;
                for (const category of categories) {
                    const selected = category.uid == categoryId ? 'selected' : '';
                    options += `<option value="${category.uid}" ${selected}>${category.name}</option>`;
                }
                $categorySelect.html(options).prop('disabled', false);
            })
            .fail(function() {
                createToast('error', 'Failed to load Categories. Please try again.');
                $categorySelect.html(`<option value="" disabled selected>No categories found</option>`).prop(
                    'disabled', false);
            });
    }

    function getType(typeId = 0) {
        const $typeSelect = $("select[name='typeId']");

        $typeSelect.prop('disabled', true).html(`<option value="">Fetching Types...</option>`);

        $.ajax({
                method: "GET",
                url: '/common/type',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .done(function(response) {
                const types = response.type || [];
                let options =
                    `<option value="" disabled selected>${types.length ? "Select Type" : "No Types found"}</option>`;
                for (const type of types) {
                    const selected = type.uid == typeId ? 'selected' : '';
                    options += `<option value="${type.uid}" ${selected}>${type.name}</option>`;
                }
                $typeSelect.html(options).prop('disabled', false);
            })
            .fail(function() {
                createToast('error', 'Failed to load Types. Please try again.');
                $typeSelect.html(`<option value="" disabled selected>No types found</option>`).prop('disabled',
                    false);
            });
    }

    function getMake(makeId = 0) {
        const $makeSelect = $("select[name='makeId']");

        $makeSelect.prop('disabled', true).html(`<option value="">Fetching Makes...</option>`);

        $.ajax({
                method: "GET",
                url: '/common/make',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .done(function(response) {
                const makes = response.make || [];
                let options =
                    `<option value="" disabled selected>${makes.length ? "Select Make" : "No Makes found"}</option>`;
                for (const make of makes) {
                    const selected = make.uid == makeId ? 'selected' : '';
                    options += `<option value="${make.uid}" ${selected}>${make.name}</option>`;
                }
                $makeSelect.html(options).prop('disabled', false);
            })
            .fail(function() {
                createToast('error', 'Failed to load makes. Please try again.');
                $makeSelect.html(`<option value="" disabled selected>No makes found</option>`).prop('disabled',
                    false);
            });
    }

    function getRole(roleId = 0) {
        const $roleSelect = $("select[name='roleId']");

        $roleSelect.prop('disabled', true).html(`<option value="">Fetching Roles...</option>`);

        $.ajax({
                method: "GET",
                url: '/common/role',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .done(function(response) {
                const roles = response.role || [];
                let options =
                    `<option value="" disabled selected>${roles.length ? "Select Role" : "No Roles found"}</option>`;
                for (const role of roles) {
                    const selected = role.uid == roleId ? 'selected' : '';
                    options += `<option value="${role.uid}" ${selected}>${role.name}</option>`;
                }
                $roleSelect.html(options).prop('disabled', false);
            })
            .fail(function() {
                createToast('error', 'Failed to load roles. Please try again.');
                $roleSelect.html(`<option value="" disabled selected>No roles found</option>`).prop('disabled',
                    false);
            });
    }

    function getCountry(countryId = 0) {
        const $countrySelect = $("select[name='countryId']");

        $countrySelect.prop('disabled', true).html(`<option value="">Fetching Country...</option>`);

        $.ajax({
                method: "GET",
                url: '/common/country',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            })
            .done(function(response) {
                const countries = response.country || [];
                let options =
                    `<option value="" disabled selected>${countries.length ? "Select Country" : "No Countries found"}</option>`;
                for (const country of countries) {
                    const selected = country.uid == countryId ? 'selected' : '';
                    options += `<option value="${country.uid}" ${selected}>${country.name}</option>`;
                }
                $countrySelect.html(options).prop('disabled', false);
            })
            .fail(function() {
                createToast('error', 'Failed to load country. Please try again.');
                $countrySelect.html(`<option value="" disabled selected>No country found</option>`).prop('disabled',
                    false);
            });
    }

    function getState(countryId = 0,stateId = 0) {
        const $stateSelect = $("select[name='stateId']");

        $stateSelect.prop('disabled', true).html(`<option value="">Fetching State...</option>`);

        $.ajax({
                method: "GET",
                url: '/common/state',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    countryId: countryId == 0 ? $("#countryId").val() : countryId
                }
            })
            .done(function(response) {
                const states = response.state || [];
                let options =
                    `<option value="" disabled selected>${states.length ? "Select State" : "No States found"}</option>`;
                for (const state of states) {
                    const selected = state.uid == stateId ? 'selected' : '';
                    options += `<option value="${state.uid}" ${selected}>${state.name}</option>`;
                }
                $stateSelect.html(options).prop('disabled', false);
            })
            .fail(function() {
                createToast('error', 'Failed to load state. Please try again.');
                $stateSelect.html(`<option value="" disabled selected>No state found</option>`).prop('disabled', );
            });
    }

    function getCity(cityId = 0) {
        const $citySelect = $("select[name='cityId']");

        $citySelect.prop('disabled', true).html(`<option value="">Fetching City...</option>`);

        $.ajax({
                method: "GET",
                url: '/common/city',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    stateId: $("#stateId").val()
                }
            })
            .done(function(response) {
                const cities = response.city || [];
                let options =
                    `<option value="" disabled selected>${cities.length ? "Select City" : "No Cities found"}</option>`;
                for (const city of cities) {
                    const selected = city.uid == cityId ? 'selected' : '';
                    options += `<option value="${city.uid}" ${selected}>${city.name}</option>`;
                }
                $citySelect.html(options).prop('disabled', false);
            })
            .fail(function() {
                createToast('error', 'Failed to load city. Please try again.');
                $citySelect.html(`<option value="" disabled selected>No city found</option>`).prop('disabled',
                    false);
            });
    }
</script>

</body>

</html>
