@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ translate('result_Managment') }}
@endsection
@section('css')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-pass {
            background-color: #d1fae5;
            color: #059669;
        }

        .status-fail {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .status-warning {
            background-color: #fef3c7;
            color: #ca8a04;
        }
    </style>
@endsection
@php
    $reportSections = [
        'header_information' => [
            'company_logo',
            'company_name',
            'laboratory_accreditation',
            'coa_number',
            'lims_number',
            'report_date',
        ],
        'sample_information' => [
            'sample_plant',
            'sample_subplant',
            'sample_point',
            'sample_description',
            'batch_lot_number',
            'date_received',
            'date_analyzed',
            'date_authorized',
        ],
        'test_results' => [
            'component_name',
            'specification',
            'test_method',
            'pass_fail_status',
            'results',
            'analyst',
            'unit',
        ],
        'authorization' => ['analyzed_by', 'authorized_by', 'digital_signature', 'comments'],
        'footer_information' => ['disclaimer_text', 'laboratory_contact_information', 'page_numbers'],
    ];

@endphp
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('coa_template_designer') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ translate('dashboard.home') }} </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ translate('dashboard.dashboard') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>






    {{-- <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('template_settings') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">{{ translate('dashboard.home') }} </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ translate('template_settings') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="mt-5"></div>
    <section class="section">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('coa_settings.store') }}" method="Post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                              @if (empty($role))
                                        <div class="form-group col-6 @error('name') is-invalid @enderror">
                                            <label>{{ translate('name') }}</label>
                                            <input type="text"  name="name" class="form-control"
                                                 placeholder="" /> 
                                        </div>

                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    @endif


                            <div class="form-group" id="sections">
                                <div class="mt-3"></div>
                                <div class="row">
                                    @foreach ($reportSections as $sectionName => $section)
                                        {{-- @php
                                            $database_section = App\Models\COASettings::where(
                                                'type',
                                                $sectionName,
                                            )->first();
                                        @endphp --}}
                                        <div class="section-card  col-12 col-md-6 col-lg-4 ">
                                            <div class="card card-primary section-box">
                                                <div class="card-header">
                                                    <input type="checkbox" name="{{ $sectionName }}" id="permissions"
                                                        value="1"
                                                        {{-- {{ isset($database_section) && $database_section->value == 1 ? 'checked' : '' }} --}}
                                                        class="form-check-input mt-0 section-parent">
                                                    <label
                                                        class="form-check-label font-16 font-weight-bold cursor-pointer {{ session()->get('locale') == 'en' ? '' : 'mr-4' }}"
                                                        for="permissions">
                                                        {{ translate( $sectionName) }}
                                                    </label>
                                                </div>

                                                @if (is_array($section))
                                                    <div class="card-body">

                                                        @foreach ($section as $key => $child)
                                                            {{-- @php
                                                                $database_sub_section = App\Models\COASettings::where(
                                                                    'type',
                                                                    $child,
                                                                )->first();
                                                            @endphp --}}
                                                            <div class="form-check mt-1">
                                                                <input type="checkbox" name="{{ $child }}"
                                                                    id="permissions_{{ $child }}" value="1"
                                                                    {{-- {{ isset($database_sub_section) && $database_sub_section->value == 1 ? 'checked' : '' }} --}}
                                                                    class="form-check-input section-child">
                                                                <label
                                                                    class="form-check-label cursor-pointer mt-0 {{ session()->get('locale') == 'en' ? '' : 'mr-4' }}"
                                                                    for="permissions_{{ $child }}">
                                                                    {{ translate( $child) }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                {{-- @endcan --}}
                            </div>

                            <div class=" mt-4">
                                <button class="btn btn-primary">{{ trans('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>
    </section>







    <div class="container bg-white p-4 shadow rounded mb-5">
        <div data-section="header_information" style="display: none;">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                <div>
                    <div data-child="company_logo" style="display: none;">
                        <img width="80px" src="{{ asset(main_path() . 'assets/images/logo.png') }}" alt="Logo"
                            class="mb-2">
                    </div>
                    <div data-child="company_name" style="display: none;">
                        <h6 class="mb-0 fw-bold">Laboratory Excellence Corp.</h6>
                    </div>
                    <div data-child="laboratory_accreditation" style="display: none;">
                        <small class="text-muted">ISO/IEC 17025:2017 Accredited Laboratory</small><br>
                        <small class="text-muted">Cert No. LAB-2025-001</small>
                    </div>
                </div>
                <div class="text-end">
                    <div data-child="lims_number" style="display: none;">
                        <h6 class="text-primary fw-bold">Certificate of Analysis</h6>
                    </div>
                    <div data-child="coa_number" style="display: none;">
                        <small>Report No: <b>COA-2025-001</b></small><br>
                    </div>
                    <div data-child="report_date" style="display: none;">
                        <small>Date: <b>January 15, 2025</b></small>
                    </div>
                </div>
            </div>
        </div>

        <div data-section="sample_information" style="display: none;">
            <!-- Sample Info -->
            <h6 class="fw-bold mb-2">Sample Information</h6>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div data-child="batch_lot_number" style="display: none;">
                        <p class="mb-1"><b>Sample ID:</b> SP-2025-001</p>
                    </div>
                    <div data-child="sample_description" style="display: none;">
                        <p class="mb-1"><b>Sample Type:</b> Process Water</p>
                    </div>
                    <div data-child="sample_point" style="display: none;">
                        <p class="mb-1"><b>Sample Point:</b> Plant A - Inlet Water</p>
                    </div>
                    <div data-child="sample_plant" style="display: none;">
                        <p class="mb-1"><b>Sample Plant:</b> Plant A</p>
                    </div>
                    <div data-child="sample_subplant" style="display: none;">
                        <p class="mb-1"><b>Sample Subplant:</b> Subplant 1</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div data-child="date_authorized" style="display: none;">
                        <p class="mb-1"><b>Sampling Date:</b> Jan 15, 2025 09:30</p>
                    </div>
                    <div data-child="date_received" style="display: none;">
                        <p class="mb-1"><b>Received Date:</b> Jan 15, 2025 10:00</p>
                    </div>
                    <div data-child="date_analyzed" style="display: none;">
                        <p class="mb-1"><b>Analysis Date:</b> Jan 15, 2025 11:30</p>
                    </div>
                </div>
            </div>
        </div>
        <div data-section="test_results" style="display: none;">
            <!-- Test Results -->
            <h6 class="fw-bold mb-2">Test Results</h6>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th data-child="component_name" style="display: none;">Parameter</th>
                        <th data-child="test_method" style="display: none;">Method</th>
                        <th data-child="results" style="display: none;">Result</th>
                        <th data-child="unit" style="display: none;">Units</th>
                        <th data-child="specification" style="display: none;">Specification</th>
                        <th data-child="pass_fail_status" style="display: none;">Status</th>
                        <th data-child="analyst" style="display: none;">Analyst</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-child="component_name" style="display: none;">pH</td>
                        <td data-child="test_method" style="display: none;">ASTM D1293</td>
                        <td data-child="results" style="display: none;">7.5</td>
                        <td data-child="unit" style="display: none;">-</td>
                        <td data-child="specification" style="display: none;">6.5 - 8.5</td>
                        <td data-child="pass_fail_status" style="display: none;"><span class="status-badge status-pass">Pass</span></td>
                        <td data-child="analyst" style="display: none;">Mike Johnson</td>
                    </tr>
                    <tr>
                        <td data-child="component_name" style="display: none;">Conductivity</td>
                        <td data-child="test_method" style="display: none;">ASTM D1125</td>
                        <td data-child="results" style="display: none;">452</td>
                        <td data-child="unit" style="display: none;">µS/cm</td>
                        <td data-child="specification" style="display: none;">&lt; 500</td>
                        <td data-child="pass_fail_status" style="display: none;"><span class="status-badge status-warning">Warning</span></td>
                        <td data-child="analyst" style="display: none;">Mike Johnson</td>
                    </tr>
                    <tr>
                        <td data-child="component_name" style="display: none;">Sodium (Na)</td>
                        <td data-child="test_method" style="display: none;">-</td>
                        <td data-child="results" style="display: none;">23.5</td>
                        <td data-child="unit" style="display: none;">mg/L</td>
                        <td data-child="specification" style="display: none;">&lt; 30.0</td>
                        <td data-child="pass_fail_status" style="display: none;"><span class="status-badge status-pass">Pass</span></td>
                        <td data-child="analyst" style="display: none;">Mike Johnson</td>
                    </tr>
                    <tr>
                        <td data-child="component_name" style="display: none;">Potassium (K)</td>
                        <td data-child="test_method" style="display: none;">EPA 200.7</td>
                        <td data-child="results" style="display: none;">4.2</td>
                        <td data-child="unit" style="display: none;">mg/L</td>
                        <td data-child="specification" style="display: none;">&lt; 5.0</td>
                        <td data-child="pass_fail_status" style="display: none;"><span class="status-badge status-pass">Pass</span></td>
                        <td data-child="analyst" style="display: none;">Mike Johnson</td>
                    </tr>
                    <tr>
                        <td data-child="component_name" style="display: none;">Calcium (Ca)</td>
                        <td data-child="test_method" style="display: none;">-</td>
                        <td data-child="results" style="display: none;">40.1</td>
                        <td data-child="unit" style="display: none;">mg/L</td>
                        <td data-child="specification" style="display: none;">&lt; 40.0</td>
                        <td data-child="pass_fail_status" style="display: none;"><span class="status-badge status-fail">Fail</span></td>
                        <td data-child="analyst" style="display: none;">Mike Johnson</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div data-section="authorization" style="display: none;">
            <!-- Analysis Info -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-2">Analysis Information</h6>
                    <div data-child="analyzed_by" style="display: none;">
                        <p class="mb-1"><b>Analyzed by:</b> Mike Johnson<br><small>Senior Analyst</small></p>
                    </div>
                    <div data-child="authorized_by" style="display: none;">
                        <p class="mb-1"><b>Verified by:</b> John Doe<br><small>Lab Supervisor</small></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold mb-2">Approval</h6>
                    <div data-child="authorized_by" style="display: none;">
                        <p class="mb-1"><b>Approved by:</b> Dr. Robert Smith<br><small>Laboratory Director</small></p>
                        <p class="mb-1"><small>Date: Jan 15, 2025</small></p>
                    </div>
                    <div data-child="digital_signature" style="display: none;">
                         <img width="150px" height="150px" id="signature_img"
                                            src="{{ asset(main_path() . 'signature/' . auth()->user()?->signature) }}" alt="Signature">
                    </div>
                    <div data-child="comments" style="display: none;">
                        <p class="mb-1"><b>Comments:</b> All tests completed successfully.</p>
                    </div>
                </div>
            </div>
        </div>
        <div data-section="footer_information" style="display: none;">
            <!-- Footer -->
            <div class="mt-4 text-muted small border-top pt-3">
                <div data-child="disclaimer_text" style="display: none;">
                    <p>This report relates only to the sample(s) tested and shall not be reproduced except in full, without
                        written
                        approval of the laboratory.</p>
                </div>
                <div data-child="page_numbers" style="display: none;">
                    <p class="mb-0">End of Report - Page 1 of 1</p>
                </div>
                <div data-child="laboratory_contact_information" style="display: none;">
                    <p class="mb-0">Laboratory Excellence Corp. | 123 Lab Street, Science City, ST 12345</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset(main_path() . 'js/roles.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Handle section parent checkboxes (main sections)
            $('.section-parent').on('change', function() {
                const sectionName = $(this).attr('name');
                const isChecked = $(this).is(':checked');
                
                // Find all elements with data-section attribute matching this section
                $(`[data-section="${sectionName}"]`).toggle(isChecked);
                
                // Also handle child checkboxes
                const sectionCard = $(this).closest('.section-card');
                const childCheckboxes = sectionCard.find('.section-child');
                childCheckboxes.prop('checked', isChecked);
                childCheckboxes.trigger('change');
            });

            // Handle section child checkboxes (sub-sections)
            $('.section-child').on('change', function() {
                const childName = $(this).attr('name');
                const isChecked = $(this).is(':checked');
                
                // Find all elements with data-child attribute matching this child
                $(`[data-child="${childName}"]`).toggle(isChecked);
            });

            // Initialize visibility on page load
            $('.section-parent').each(function() {
                const sectionName = $(this).attr('name');
                const isChecked = $(this).is(':checked');
                $(`[data-section="${sectionName}"]`).toggle(isChecked);
            });

            $('.section-child').each(function() {
                const childName = $(this).attr('name');
                const isChecked = $(this).is(':checked');
                $(`[data-child="${childName}"]`).toggle(isChecked);
            });
        });
    </script>
@endsection
