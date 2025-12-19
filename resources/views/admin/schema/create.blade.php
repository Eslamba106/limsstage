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

    @php
        $modules = [
            'scan_barcode' => 'Scan Barcode',
            'test_method_management' => 'Test Method Management',
            'unit' => 'Unit',
            'result_types' => 'Result Types',
            'sample_management' => 'Sample Management',
            'assig_test_to_sample' => 'Assign Test to Sample',
            'plants' => 'Plants',
            'create_sample' => 'Create Sample',
            'toxic_degree' => 'Toxic Degree',
            'submissions_management' => 'Submissions Management',
            'sample_routine_scheduler' => 'Sample Routine Scheduler',
            'frequencies' => 'Frequencies',
            'results' => 'Results',
            'template_designer_list' => 'Template Designer',
            'coa_generation_settings' => 'COA Generation Settings',
            'certificate_management' => 'Certificate Management',
            'emails' => 'Emails',
            'users' => 'Users',
            'clients' => 'Clients',
            'roles' => 'Roles',
            'system_setup' => 'System Setup',
        ];

        $countFields = [
            'test_method_count' => 'Test Method Count',
            'unit_count' => 'Unit Count',
            'result_types_count' => 'Result Types Count',
            'sample_count' => 'Sample Count',
            'plants_count' => 'Plants Count',
            'create_sample_count' => 'Create Sample Count',
            'toxic_degree_count' => 'Toxic Degree Count',
            'submissions_count' => 'Submissions Count',
            'sample_routine_scheduler_count' => 'Sample Routine Scheduler Count',
            'frequencies_count' => 'Frequencies Count',
            'results_count' => 'Results Count',
            'template_designer_count' => 'Template Designer Count',
            'coa_generation_settings_count' => 'COA Generation Settings Count',
            'certificate_count' => 'Certificate Count',
            'emails_count' => 'Emails Count',
            'users_count' => 'Users Count',
            'clients_count' => 'Clients Count',
        ];
    @endphp

    <div class="mb-5"></div>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <form action="{{ route('admin.schema.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-6 col-lg-4 col-xl-6">

                                    <div class="form-group">
                                        <label for="">{{ translate('name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" required />

                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="price">{{ translate('price') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="price" id="price" class="form-control"
                                            value="{{ old('price') }}" required>
                                        @error('price')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="currency">{{ translate('currency') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="currency" id="currency" class="form-control"
                                            value="{{ old('currency') }}" required>
                                        @error('currency')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="display">{{ translate('display') }}</label>
                                        <input type="text" name="display" id="display" class="form-control"
                                            value="{{ old('display') }}">
                                        @error('display')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="status">{{ translate('status') }}</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                                {{ translate('Active') }}</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                {{ translate('Inactive') }}</option>
                                        </select>
                                        @error('status')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($countFields as $field => $label)
                                    <div class="col-md-6 col-lg-3 col-xl-3">
                                        <div class="form-group">
                                            <label for="{{ $field }}">{{ translate($label) }}</label>
                                            <input type="number" name="{{ $field }}" id="{{ $field }}"
                                                class="form-control" min="0" value="{{ old($field) }}" />

                                            @error($field)
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group" id="sections">
                                <div class="d-flex gap-4 flex-wrap align-items-center">
                                    <label for="name"
                                        class="title-color font-weight-bold mb-0">{{ translate('module_permission') }}
                                    </label>

                                    <div class="form-group d-flex align-items-center gap-2 mb-0">
                                        <input type="checkbox" id="select_all" class="cursor-pointer">
                                        <label class="title-color mb-0 cursor-pointer" for="select_all">
                                            {{ translate('select_All') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="mt-3"></div>
                                <div class="row">

                                    <div class="row">
                                        @foreach ($modules as $key => $label)
                                            <div class="section-card col-12 col-md-3 col-lg-4">
                                                <div class="card card-primary section-box">
                                                    <div class="card-header">
                                                        <input type="checkbox" name="modules[]"
                                                            id="module_{{ $key }}" value="{{ $key }}"
                                                            class="form-check-input module-schema mt-0 section-parent">
                                                        <label
                                                            class="form-check-label font-16 font-weight-bold cursor-pointer {{ session()->get('locale') == 'en' ? '' : 'mr-4' }}"
                                                            for="module_{{ $key }}">
                                                            {{ translate($label) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                                {{-- @endcan --}}
                            </div>
                        </div>
                        <div class="form-group mt-2"
                            @if (session()->get('locale') == 'ar') style="text-align: left;" @else style="text-align: right;" @endif>
                            <button type="submit" class="btn btn-primary mt-2">{{ translate('save') }}</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $("#select_all").on('change', function() {
            if ($("#select_all").is(":checked") === true) {
                // console.log($("#select_all").is(":checked"));
                $(".module-schema").prop("checked", true);
            } else {
                $(".module-schema").removeAttr("checked");
            }
        });

        function checkbox_selection_check() {
            let nonEmptyCount = 0;
            $(".module-permission").each(function() {
                if ($(this).is(":checked") !== true) {
                    nonEmptyCount++;
                }
            });
            if (nonEmptyCount == 0) {
                $("#select_all").prop("checked", true);
            } else {
                $("#select_all").removeAttr("checked");
            }
        }

        $('.module-permission').click(function() {
            checkbox_selection_check();
        });
    </script>
    <script src="{{ asset(main_path() . 'js/roles.min.js') }}"></script>
@endsection
