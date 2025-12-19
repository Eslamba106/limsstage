<!DOCTYPE html>
<html @if (session()->has('locale') && session()->get('locale') == 'ar') dir="rtl" lang="ar" @else dir="ltr" lang="en" @endif>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Title -->
    <title>Lims Stage Platform</title>

    <!-- Meta Description -->
    <meta name="description" content="منصة تعليمية تقدم محتوى علمي، دورات تدريبية، وشروحات مميزة للطلاب والمتعلمين.">

    <!-- Keywords -->
    <meta name="keywords" content="تعليم, منصة تعليمية, دروس, شروحات, تعليم اونلاين, تعلم, كورسات, educational website, learning platform, tutorials">

    <!-- Author -->
    <meta name="author" content="Lims Stage">

    <!-- Category -->
    <meta name="classification" content="Education">
    <meta name="category" content="Educational">

    <!-- Open Graph (Social Media SEO) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Educational Platform – منصة تعليمية">
    <meta property="og:description" content="موقع تعليمي يقدم شروحات ودروس وكورسات.">
    <meta property="og:site_name" content="Educational Platform">
    <meta property="og:locale" content="ar_AR">

    <!-- Schema.org (Structured Data for Educational Website) -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "EducationalOrganization",
      "name": "Educational Platform",
      "url": "https://yourwebsite.com",
      "description": "منصة تعليمية تقدم محتوى علمي وشروحات وكورسات.",
      "logo": "https://yourwebsite.com/logo.png"
    }
    </script>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/logo.png') }}">
    <title> @yield('title', 'Dashboard') </title>
    <!-- Custom CSS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset(main_path() . 'css/select2.min.css') }}">

    <link href="{{ asset(main_path() . 'assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset(main_path() . 'css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset(main_path() . 'assets/extra-libs/c3/c3.min.css') }}" rel="stylesheet">
    <link href="{{ asset(main_path() . 'assets/libs/morris.js/morris.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> --}}

    <link rel="stylesheet" href="{{ asset(main_path() . 'css/toastr.css') }}">

    <link href="{{ asset(main_path() . 'dist/css/style.min.css') }}" rel="stylesheet">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    @yield('css')
        
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>


    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        @include('layouts.header')
        @include('layouts.sidebar')
        <div class="page-wrapper">
            @yield('content')
            @include('layouts.toggle_status_modal')
            @include('layouts.footer')
        </div>

    </div>


    @if (Session::has('success'))
        <script>
            swal("Message", "{{ Session::get('success') }}", 'success', {
                button: true,
                button: "Ok",
                timer: 3000,
            })
        </script>
    @endif
    @if (Session::has('info'))
        <script>
            swal("Message", "{{ Session::get('info') }}", 'info', {
                button: true,
                button: "Ok",
                timer: 3000,
            })
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            swal("Message", "{{ Session::get('error') }}", 'error', {
                button: true,
                button: "Ok",
                timer: 3000,
            })
        </script>
    @endif






    <script src="{{ asset(main_path() . 'assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset(main_path() . 'assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset(main_path() . 'assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- apps -->
    <script src="{{ asset(main_path() . 'dist/js/app.min.js') }}"></script>
    <script src="{{ asset(main_path() . 'dist/js/app.init.js') }}"></script>
    <script src="{{ asset(main_path() . 'dist/js/app-style-switcher.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset(main_path() . 'assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset(main_path() . 'assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset(main_path() . 'dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset(main_path() . 'dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset(main_path() . 'dist/js/custom.min.js') }}"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="{{ asset(main_path() . 'assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset(main_path() . 'assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}">
    </script>
    <!--c3 charts -->
    <script src="{{ asset(main_path() . 'assets/extra-libs/c3/d3.min.js') }}"></script>
    <script src="{{ asset(main_path() . 'assets/extra-libs/c3/c3.min.js') }}"></script>
    <!--chartjs -->
    <script src="{{ asset(main_path() . 'assets/libs/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset(main_path() . 'assets/libs/morris.js/morris.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script> --}}
    <script src="{{ asset(main_path() . 'js/select2.min.js') }}"></script>

    <script src="{{ asset('dist/js/pages/dashboards/dashboard1.js') }}"></script>
    <script src="{{ asset(main_path() . 'js/sweet_alert.js') }}"></script>

    <script>
         function form_alert(id, message) {
            Swal.fire({
                title: '{{ translate('are_you_sure') }}?',
                text: message,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '{{ translate('no') }}',
                confirmButtonText: '{{ translate('yes') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $('#' + id).submit()
                }
            })
        }
        $(document).on('change', '.bulk_check_all', function() {
            $('input.check_bulk_item:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
        <script src="{{ asset(main_path() . 'js/toastr.js') }}"></script>
    {!! Toastr::message() !!}

    <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-left",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    </script>

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}', Error, {
                    CloseButton: true,
                    ProgressBar: true
                });
            @endforeach
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('.js-select2-custom').select2({
                width: '100%',
                allowClear: true
            });
        });

        function toogleStatusModal(e, toggle_id, on_image, off_image, on_title, off_title, on_message, off_message) {
            e.preventDefault();
            $('.toggle-modal-img-box .status-icon').attr('src', '');
            if ($('#' + toggle_id).is(':checked')) {
                $('#toggle-status-title').empty().append(on_title);
                $('#toggle-status-message').empty().append(on_message);
                $('#toggle-status-image').attr('src', "{{ asset('/public/assets/images/modal') }}/" + on_image);
                $('#toggle-status-ok-button').attr('toggle-ok-button', toggle_id);
            } else {
                $('#toggle-status-title').empty().append(off_title);
                $('#toggle-status-message').empty().append(off_message);
                $('#toggle-status-image').attr('src', "{{ asset('/public/assets/images/modal') }}/" + off_image);
                $('#toggle-status-ok-button').attr('toggle-ok-button', toggle_id);
            }
            $('#toggle-status-modal').modal('show');
        }

        function confirmToggle() {
            var toggle_id = $('#toggle-ok-button').attr('toggle-ok-button');
            if ($('#' + toggle_id).is(':checked')) {
                $('#' + toggle_id).prop('checked', false);
            } else {
                $('#' + toggle_id).prop('checked', true);
            }
            $('#toggle-modal').modal('hide');

            if (toggle_id == 'email_verification') {
                if ($("#email_verification").is(':checked')) {
                    $('#otp_verification').removeAttr('checked');
                }
            }

            if (toggle_id == 'otp_verification') {
                if ($("#otp_verification").is(':checked')) {
                    $('#email_verification').removeAttr('checked');
                }
            }
        }

        function confirmStatusToggle() {
            var toggle_id = $('#toggle-status-ok-button').attr('toggle-ok-button');
            if ($('#' + toggle_id).is(':checked')) {
                $('#' + toggle_id).prop('checked', false);
                $('#' + toggle_id).val(0);
            } else {
                $('#' + toggle_id).prop('checked', true);
                $('#' + toggle_id).val(1);
            }
            $('#' + toggle_id + '_form').submit();
        }
    </script>

    @yield('js')
</body>

</html>
