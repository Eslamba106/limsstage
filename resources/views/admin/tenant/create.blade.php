@extends('admin.layouts.dashboard')
@section('title')
    {{ __('roles.create_tenant') }}
@endsection
@section('css')
    {{-- <link href="{{ asset('css/tags-input.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #dedede;
            border: 1px solid #dedede;
            border-radius: 2px;
            color: #222;
            display: flex;
            gap: 4px;
            align-items: center;
        }
    </style>
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.create_tenant') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('dashboard.home') }} </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('dashboard.dashboard') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <div class="mb-5"></div>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <form action="{{ route('admin.tenant_management.store_tenant') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6 col-lg-4 col-xl-6">

                                    <div class="form-group">
                                        <label for="">{{ __('roles.name') }} <span
                                                class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" required />
                                         
                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                             
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="tenant_id" class="title-color">{{ __('tenants.company_id') }} <span
                                                class="text-danger"> *</span></label>
                                        <input type="text" class="form-control" required name="tenant_id"   >
                                        {{-- <input type="text" class="form-control"  name="tenant_id" value="{{ company_id() }}" > --}}
                                    </div>
                                </div>
                                {{-- <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="name" class="title-color">{{ __('tenants.user_count') }}<span
                                                class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control" name="user_count">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="">{{ __('login.phone') }}</label>
                                        <input type="text" name="phone" class="form-control">
                                        @error('phone')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="name"
                                            class="title-color">{{ __('tenants.monthly_subscription_user') }}<span
                                                class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control" name="monthly_subscription_user">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="name" class="title-color">{{ __('tenants.setup_cost') }}<span
                                                class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control" name="setup_cost">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="name" class="title-color">{{ __('tenants.creation_date') }}<span
                                                class="text-danger"> *</span>
                                        </label>
                                        <input type="date" class="form-control creation_date" name="creation_date">
                                    </div>
                                </div>
                                
                             
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="name"
                                            class="title-color">{{ __('tenants.company_applicable_date') }}<span
                                                class="text-danger"> *</span>
                                        </label>
                                        <input type="date" class="form-control company_applicable_date"
                                            name="tenant_applicable_date">
                                    </div>
                                </div> --}}
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label class="title-color">{{ __('tenants.user_name') }}<span class="text-danger">
                                                *</span></label>
                                        <input type="text" class="form-control" name="user_name">
                                    </div>
                                </div>
                                {{-- <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label class="title-color">{{ __('tenants.email') }}<span class="text-danger">
                                                *</span></label>
                                        <input type="text" class="form-control" name="email">
                                    </div>
                                </div> --}}
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <label class="title-color">{{ __('tenants.password') }}<span class="text-danger">
                                            *</span></label>
    
                                    <div class="form-group input-group input-group-merge">
    
                                        <input type="password" class="js-toggle-password form-control" name="password"
                                            id="signupSrPassword" placeholder="{{ __('8+_characters_required') }}"
                                            aria-label="8+ characters required" required
                                            data-msg="Your password is invalid. Please try again."
                                            data-hs-toggle-password-options='{
                                                    "target": "#changePassTarget",
                                                    "defaultClass": "tio-hidden-outlined",
                                                    "showClass": "tio-visible-outlined",
                                                    "classChangeTarget": "#changePassIcon"
                                                    }'>
                                        <div id="changePassTarget" class="input-group-append">
                                            <a class="input-group-text" href="javascript:">
                                                <i id="changePassIcon" class="tio-visible-outlined"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-2" @if(session()->get('locale') == 'ar')  style="text-align: left;" @else style="text-align: right;" @endif>
                                <button type="submit" class="btn btn-primary mt-2">{{ __('dashboard.save') }}</button>
                              </div>
                              
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    
    
@endsection
