@extends('admin.layouts.dashboard')
@section('title')
    {{ translate('create_tenant') }}
@endsection
@section('css')
    {{-- <link href="{{ asset('css/tags-input.min.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

    <style>
        .select2-container--default .select2-selection--multiple .select2-selectiontranslatechoice {
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
                <h4 class="page-title">{{ translate('create_tenant') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ translate('home') }} </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ translate('dashboard') }}</li>
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
        <form action="{{ route('admin.tenant_management.update', $tenant->id) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <!-- Name -->
                                <div class="col-md-6 col-lg-4 col-xl-6">
                                    <div class="form-group">
                                        <label>{{ translate('name') }} <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $tenant->name) }}" required>
                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tenant ID -->
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label class="title-color">{{ translate('company_id') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="tenant_id" required
                                            value="{{ old('tenant_id', $tenant->tenant_id) }}">
                                    </div>
                                </div>
                                 <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label for="">{{ __('login.phone') }}</label>
                                        <input type="text" name="phone" class="form-control" value="{{ old('phone',$tenant->phone) }}">
                                        @error('phone')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                 <div class="col-md-4   col-lg-4">
                                    <div class="form-group">
                                        <label for="">{{ translate('schema') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="schema_id" class="form-control">
                                            <option value="">{{ translate('select_schema') }}</option>
                                            @foreach ($schemas as $schema)
                                                
                                            <option {{ ($schema->id == $tenant->schema_id) ? 'selected' : '' }} value="{{ $schema->id }}">{{ $schema->name }}</option> 
                                            @endforeach
                                        </select>
                                        @error('schema_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label class="title-color">{{ translate('delete_data_after_days') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control" name="tenant_delete_days"
                                            value="{{ old('tenant_delete_days', $tenant->tenant_delete_days) }}">
                                    </div>
                                </div>
                                 <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label class="title-color">{{ translate('Subscription_Ends_At') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" name="expire" 
                                            value="{{  old('expire', $tenant->expire) }}">
                                    </div>
                                </div>
                                 <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label class="title-color">{{ translate('tenants.email') }} </label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email' , $tenant->email) }}">
                                    </div>
                                </div>
                                <!-- User Name -->
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <div class="form-group">
                                        <label class="title-color">{{ translate('user_name') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="user_name"
                                            value="{{ old('user_name', $tenant->user_name) }}">
                                    </div>
                                </div>


                                <!-- Password -->
                                <div class="col-md-6 col-lg-4 col-xl-3">
                                    <label class="title-color">{{ translate('password') }}
                                        <span class="text-danger">*</span>
                                    </label>

                                    <div class="form-group input-group input-group-merge">
                                        <input type="password" class="js-toggle-password form-control" name="password"
                                            id="signupSrPassword" value="{{ old('password', $tenant->my_name) }}"
                                            placeholder="{{ translate('leave_blank_if_not_change') }}">

                                        <div id="changePassTarget" class="input-group-append">
                                            <a class="input-group-text" href="javascript:">
                                                <i id="changePassIcon" class="tio-visible-outlined"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group mt-2"
                                @if (session()->get('locale') == 'ar') style="text-align: left;" 
                        @else style="text-align: right;" @endif>
                                <button type="submit" class="btn btn-primary mt-2">{{ translate('update') }}</button>
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
