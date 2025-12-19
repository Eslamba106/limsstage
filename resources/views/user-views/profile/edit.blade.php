@extends('layouts.dashboard')

@section('title', translate('profile_Settings'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <!-- Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="mb-3">
            <div class="row gy-2 align-items-center">
                <div class="col-sm">
                    <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                        <img src="{{ asset('/public/assets/back-end/img/support-ticket.png') }}" alt="">
                        {{ translate('settings') }}
                    </h2>
                </div>
                <!-- End Page Title -->

                <div class="col-sm-auto">
                    <a class="btn btn-primary" href=" ">
                        <i class="tio-home mr-1"></i> {{ translate('dashboard') }}
                    </a>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <div class="row">
            <div class="col-lg-3">
                <!-- Navbar -->
                <div class="navbar-vertical navbar-expand-lg mb-3 mb-lg-5">
                    <!-- Navbar Toggle -->
                    <button type="button" class="navbar-toggler btn btn-block btn-white mb-3"
                        aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu"
                        data-toggle="collapse" data-target="#navbarVerticalNavMenu">
                        <span class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">{{ translate('nav_menu') }}</span>

                            <span class="navbar-toggle-default">
                                <i class="tio-menu-hamburger"></i>
                            </span>

                            <span class="navbar-toggle-toggled">
                                <i class="tio-clear"></i>
                            </span>
                        </span>
                    </button>
                    <!-- End Navbar Toggle -->

                    <div id="navbarVerticalNavMenu" class="collapse navbar-collapse">
                        <!-- Navbar Nav -->
                        <ul id="navbarSettings"
                            class="js-sticky-block js-scrollspy navbar-nav navbar-nav-lg nav-tabs card card-navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript:" id="generalSection">
                                    <i class="tio-user-outlined nav-icon"></i>{{ translate('basic_Information') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:" id="passwordSection">
                                    <i class="tio-lock-outlined nav-icon"></i> {{ translate('password') }}
                                </a>
                            </li>
                        </ul>
                        <!-- End Navbar Nav -->
                    </div>
                </div>
                <!-- End Navbar -->
            </div>

            <div class="col-lg-9">
                <form id="signature-form" action="{{ route('profile.update', [$data->id]) }}" method="post"
                    enctype="multipart/form-data" id="seller-profile-form">
                    @csrf
                    <!-- Card -->

                    <!-- End Card -->

                    <!-- Card -->
                    <div class="card mb-3 mb-lg-5">
                        <div class="card-header">
                            <h5 class="mb-0">{{ translate('basic_Information') }}</h5>
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <!-- Form -->
                            <!-- Form Group -->
                            <div class="row">
                                <label for="firstNameLabel"
                                    class="col-sm-3 col-form-label input-label">{{ translate('full_Name') }}
                                    <i class="tio-help-outlined text-body ml-1" data-toggle="tooltip" data-placement="top"
                                        title="Display name"></i></label>

                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="title-color">{{ translate('name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" value="{{ $data->name }}"
                                                class="form-control" id="name" required>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="row">
                                <label for="phoneLabel"
                                    class="col-sm-3 col-form-label input-label">{{ translate('phone') }} </label>

                                <div class="col-sm-9 mb-3">
                                    <div class="text-info mb-2">( * {{ translate('country_code_is_must_like_for_BD_880') }}
                                        )</div>
                                    <input type="text" class="form-control" name="phone" id="phoneLabel"
                                        placeholder="+(880)00-000-00000" value="{{ $data->phone }}"
                                        oninput="this.value = this.value.replace(/[^0-9+]/g, '')" required>


                                </div>
                            </div>
                            <!-- End Form Group -->

                            <div class="row form-group">
                                <label for="newEmailLabel"
                                    class="col-sm-3 col-form-label input-label">{{ translate('email') }}</label>

                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email" id="newEmailLabel"
                                        value="{{ $data->email }}"
                                        placeholder="{{ translate('enter_new_email_address') }}"
                                        aria-label="Enter new email address" readonly>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="newEmailLabel"
                                    class="col-sm-3 col-form-label input-label">{{ translate('user_name') }}</label>

                                <div class="col-sm-9">
                                    <input type="user_name" class="form-control" name="user_name" id="newEmailLabel"
                                        value="{{ $data->user_name }}"
                                        placeholder="{{ translate('enter_new_user_name_address') }}"
                                        aria-label="Enter new user_name address" readonly>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="newEmailLabel"
                                    class="col-sm-3 col-form-label input-label">{{ translate('slug_For_Sub_Domain') }}</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="slug" id="slug"
                                        value="{{ $data->slug }}" placeholder="{{ translate('enter_new_slug') }}"
                                        aria-label="Enter new slug"
                                        oninput="this.value = this.value.replace(/[^a-zA-Z0-9\-]/g, '')">

                                </div>
                            </div>
                            @isset($data->signature)
                                <div class="row form-group">
                                    <label for="newEmailLabel"
                                        class="col-sm-3 col-form-label input-label">{{ translate('your_Singature') }}</label>

                                    <div class="col-sm-9">

                                        <img width="150px" height="150px" id="signature_img"
                                            src="{{ asset(main_path() . 'signature/' . $data->signature) }}" alt="Signature">


                                    </div>

                                </div>
                            @endisset


                            <div class="row form-group">
                                <label for="newEmailLabel" class="col-sm-3 col-form-label input-label"><a
                                        id="add-signature-pad"
                                        class="btn btn-primary mb-2">{{ translate('add_signature') }}</a></label>

                                <div id="signature-pads-container" class="col-sm-9">


                                </div>

                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" {{-- onclick="form_alert('seller-profile-form','Want to update your info ?')" --}}
                                    class="btn btn-primary">{{ translate('save_changes') }}
                                </button>
                            </div>

                            <!-- End Form -->
                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->
                </form>

                <!-- Card -->
                <div id="passwordDiv" class="card mb-3 mb-lg-5">
                    <div class="card-header">
                        <h5 class="mb-0">{{ translate('change_your_password') }}</h5>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Form -->
                        <form id="changePasswordForm" action="{{ route('profile.settings-password') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- Form Group -->
                            <div class="row form-group">
                                <label for="newPassword" class="col-sm-3 col-form-label input-label">
                                    {{ translate('new_Password') }}</label>

                                <div class="col-sm-9">
                                    <input type="password" class="js-pwstrength form-control" name="password"
                                        id="newPassword" placeholder="{{ translate('enter_new_password') }}"
                                        aria-label="Enter new password"
                                        data-hs-pwstrength-options='{
                                           "ui": {
                                             "container": "#changePasswordForm",
                                             "viewports": {
                                               "progress": "#passwordStrengthProgress",
                                               "verdict": "#passwordStrengthVerdict"
                                             }
                                           }
                                         }'>

                                    <p id="passwordStrengthVerdict" class="form-text mb-2"></p>

                                    <div id="passwordStrengthProgress"></div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="row form-group">
                                <label for="confirmNewPasswordLabel" class="col-sm-3 col-form-label input-label pt-0">
                                    {{ translate('confirm_Password') }} </label>

                                <div class="col-sm-9">
                                    <div class="mb-3">
                                        <input type="password" class="form-control" name="confirm_password"
                                            id="confirmNewPasswordLabel"
                                            placeholder="{{ translate('confirm_your_new_password') }}"
                                            aria-label="Confirm your new password">
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <div class="d-flex justify-content-end">
                                <button type="button"
                                    onclick="{{ env('APP_MODE') != 'demo' ? "form_alert('changePasswordForm','Want to update admin password ?')" : 'call_demo()' }}"
                                    class="btn btn-primary">{{ translate('save_changes') }}</button>
                            </div>
                        </form>
                        <!-- End Form -->
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->

                <!-- Sticky Block End Point -->
                <div id="stickyBlockEndPoint"></div>
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Content -->
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <script>
        document.getElementById('add-signature-pad').addEventListener('click', () => {
            createSignaturePad();
        });

        function createSignaturePad() {
            const padContainer = document.createElement('div');
            padContainer.classList.add('signature-pad-container');

            const canvas = document.createElement('canvas');
            canvas.width = 400;
            canvas.height = 200;
            canvas.style.border = '1px solid #000';

            const clearButton = document.createElement('a');
            clearButton.textContent = "Clear";
            clearButton.classList.add('btn', 'btn-danger', 'm-1');

            const deleteButton = document.createElement('a');
            deleteButton.textContent = "Delete";
            deleteButton.classList.add('btn', 'btn-warning');

            padContainer.appendChild(canvas);
            padContainer.appendChild(clearButton);
            padContainer.appendChild(deleteButton);
            document.getElementById('signature-pads-container').appendChild(padContainer);

            const signaturePad = new SignaturePad(canvas);

            const inputElement = document.createElement('input');
            inputElement.type = 'hidden';
            inputElement.name = 'signature';

            document.querySelector('#signature-form').appendChild(inputElement);

            signaturePad.onEnd = () => {
                if (!signaturePad.isEmpty()) {
                    inputElement.value = signaturePad.toDataURL('image/png');
                }
            };

            clearButton.addEventListener('click', () => {
                signaturePad.clear();
                inputElement.value = '';
            });

            deleteButton.addEventListener('click', () => {
                padContainer.remove();
                inputElement.remove();
            });
        }

        // document.getElementById('add-signature-pad').addEventListener('click', () => {
        //     createSignaturePad();
        // });

        // function createSignaturePad() {

        //     const padContainer = document.createElement('div');
        //     padContainer.classList.add('signature-pad-container');

        //     const canvas = document.createElement('canvas');
        //     canvas.width = 400;
        //     canvas.height = 200;
        //     canvas.style.border = '1px solid #000';

        //     const clearButton = document.createElement('a');
        //     clearButton.textContent = "{{ __('general.clear') }}";
        //     clearButton.classList.add('btn', 'btn-danger', 'm-1');
        //     clearButton.addEventListener('click', () => {
        //         signaturePad.clear();
        //         inputElement.value = '';
        //     });

        //     const deleteButton = document.createElement('a');
        //     deleteButton.textContent = "{{ __('general.delete') }}";
        //     deleteButton.classList.add('btn', 'btn-warning');
        //     deleteButton.addEventListener('click', () => {
        //         padContainer.remove();
        //     });

        //     padContainer.appendChild(canvas);
        //     padContainer.appendChild(clearButton);
        //     padContainer.appendChild(deleteButton);
        //     document.getElementById('signature-pads-container').appendChild(padContainer);

        //     const signaturePad = new SignaturePad(canvas);

        //     const inputElement = document.createElement('input');
        //     inputElement.type = 'hidden';
        //     inputElement.name = 'signature';

        //     document.getElementById('signature-form').appendChild(inputElement);

        //     signaturePad.onEnd = () => {
        //         inputElement.value = signaturePad.toDataURL('image/png');
        //     };
        // }
        // document.getElementById('add-signature-pad').addEventListener('click', () => {
        //     let signature_img = document.getElementById('signature_img');
        //     let seal_image = document.getElementById('seal_image');
        //     if(signature_img){ 
        //         signature_img.classList.add('d-none');
        //         seal_image.classList.add('d-none');
        //     }
        //     if(seal_image){  
        //         seal_image.classList.add('d-none');
        //     }
        //     createSignaturePad();
        // });

        // function createSignaturePad() {

        //     const padContainer = document.createElement('div');
        //     let add_btn = document.getElementById('add-signature-pad');
        //     add_btn.setAttribute('hidden', '');
        //     padContainer.classList.add('signature-pad-container');

        //     const canvas = document.createElement('canvas');
        //     canvas.width = 400;
        //     canvas.height = 200;
        //     canvas.style.border = '1px solid #000';

        //     const clearButton = document.createElement('a');
        //     clearButton.textContent = "{{ __('Clear') }}";
        //     clearButton.classList.add('btn', 'btn-danger', 'm-1');
        //     clearButton.addEventListener('click', () => {
        //         signaturePad.clear();
        //         inputElement.value = '';
        //     });
        //     // signature_img
        //     const deleteButton = document.createElement('a');
        //     deleteButton.textContent = "{{ __('Delete') }}";
        //     deleteButton.classList.add('btn', 'btn-warning');
        //     deleteButton.addEventListener('click', () => {
        //         padContainer.remove();
        //         add_btn.removeAttribute('hidden');
        //         let seal_image = document.getElementById('seal_image');
        //         if(seal_image){  
        //         seal_image.classList.remove('d-none');
        //     }
        //     });

        //     padContainer.appendChild(canvas);
        //     padContainer.appendChild(clearButton);
        //     padContainer.appendChild(deleteButton);
        //     document.getElementById('signature-pads-container').appendChild(padContainer);

        //     const signaturePad = new SignaturePad(canvas);

        //     const inputElement = document.createElement('input');
        //     inputElement.type = 'hidden';
        //     inputElement.name = 'signature';

        //     document.getElementById('signature-form').appendChild(inputElement);

        //     signaturePad.onEnd = () => {
        //         inputElement.value = signaturePad.toDataURL('image/png');
        //     };
        // }
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function() {
            readURL(this);
        });
    </script>

    <script>
        $("#generalSection").click(function() {
            $("#passwordSection").removeClass("active");
            $("#generalSection").addClass("active");
            $('html, body').animate({
                scrollTop: $("#generalDiv").offset().top
            }, 2000);
        });

        $("#passwordSection").click(function() {
            $("#generalSection").removeClass("active");
            $("#passwordSection").addClass("active");
            $('html, body').animate({
                scrollTop: $("#passwordDiv").offset().top
            }, 2000);
        });
    </script>
@endsection
