@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ translate('edit_Template') }}
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
                <h4 class="page-title">{{ translate('edit_Template') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ translate('home') }} </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ translate('dashboard') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>





 
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
                        <form action="{{ route('coa_settings.update' , $temp->id) }}" method="Post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                              @if (empty($role))
                                        <div class="form-group col-6 @error('name') is-invalid @enderror">
                                            <label>{{ translate('name') }}</label>
                                            <input type="text" value="{{ $temp->name }}"  name="name" class="form-control"
                                                 placeholder="" /> 
                                        </div>

                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $error }}
                                            </div>
                                        @enderror
                                    @endif
                                            {{-- {{ dd($temp) }} --}}

                            <div class="form-group" id="sections">
                                <div class="mt-3"></div>
                                <div class="row">
                                    @foreach ($reportSections as $sectionName => $section)
                                            {{-- {{dd($temp[$sectionName])}} --}}
                                        <div class="section-card  col-12 col-md-6 col-lg-4 ">
                                            <div class="card card-primary section-box">
                                                <div class="card-header">
                                                    <input type="checkbox" name="{{ $sectionName }}" id="permissions"
                                                        value="1"
                                                        {{  $temp[$sectionName]  == 1 ? 'checked' : '' }}
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
                                                           {{-- {{ dd($temp["company_logo"])}} --}}
                                                            <div class="form-check mt-1">
                                                                <input type="checkbox" name="{{ $child }}"
                                                                    id="permissions_{{ $child }}" value="1"
                                                                    {{   ($temp[$child] == 1) ? 'checked'  : '' }}
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
        @if (check_coa_settings('header_information'))
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                <div>
                    @if (check_coa_settings('company_logo'))
                        <img width="80px" src="{{ asset(main_path() . 'assets/images/logo.png') }}" alt="Logo"
                            class="mb-2">
                    @endif
                    @if (check_coa_settings('company_name'))
                        <h6 class="mb-0 fw-bold">Laboratory Excellence Corp.</h6>
                    @endif
                    @if (check_coa_settings('laboratory_accreditation'))
                        <small class="text-muted">ISO/IEC 17025:2017 Accredited Laboratory</small><br>
                        <small class="text-muted">Cert No. LAB-2025-001</small>
                    @endif
                </div>
                <div class="text-end">
                    @if (check_coa_settings('lims_number'))
                        <h6 class="text-primary fw-bold">Certificate of Analysis</h6>
                    @endif
                    @if (check_coa_settings('coa_number'))
                        <small>Report No: <b>COA-2025-001</b></small><br>
                    @endif
                    @if (check_coa_settings('report_date'))
                        <small>Date: <b>January 15, 2025</b></small>
                    @endif
                </div>
            </div>
        @endif

        @if (check_coa_settings('sample_information'))
            <!-- Sample Info -->
            <h6 class="fw-bold mb-2">Sample Information</h6>
            <div class="row mb-4">
                <div class="col-md-6">
                    @if (check_coa_settings('batch_lot_number'))
                        <p class="mb-1"><b>Sample ID:</b> SP-2025-001</p>
                    @endif
                    @if (check_coa_settings('sample_description'))
                        <p class="mb-1"><b>Sample Type:</b> Process Water</p>
                    @endif
                    @if (check_coa_settings('sample_point'))
                        <p class="mb-1"><b>Sample Point:</b> Plant A - Inlet Water</p>
                    @endif
                </div>
                <div class="col-md-6">
                    @if (check_coa_settings('date_authorized'))
                        <p class="mb-1"><b>Sampling Date:</b> Jan 15, 2025 09:30</p>
                    @endif
                    @if (check_coa_settings('date_received'))
                        <p class="mb-1"><b>Received Date:</b> Jan 15, 2025 10:00</p>
                    @endif
                    @if (check_coa_settings('date_analyzed'))
                        <p class="mb-1"><b>Analysis Date:</b> Jan 15, 2025 11:30</p>
                    @endif
                </div>
            </div>
        @endif
        @if (check_coa_settings('test_results'))
            <!-- Test Results -->
            <h6 class="fw-bold mb-2">Test Results</h6>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        @if (check_coa_settings('component_name'))
                            <th>Parameter</th>
                        @endif
                        @if (check_coa_settings('test_method'))
                            <th>Method</th>
                        @endif
                        @if (check_coa_settings('results'))
                            <th>Result</th>
                        @endif
                        @if (check_coa_settings('unit'))
                            <th>Units</th>
                        @endif
                        @if (check_coa_settings('specification'))
                            <th>Specification</th>
                        @endif
                        @if (check_coa_settings('pass_fail_status'))
                            <th>Status</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @if (check_coa_settings('component_name'))
                            <td>pH</td>
                        @endif
                        @if (check_coa_settings('test_method'))
                            <td>ASTM D1293</ td>
                        @endif
                        @if (check_coa_settings('results'))
                            <td>7.5</td>
                        @endif
                        @if (check_coa_settings('unit'))
                            <td>-</td>
                        @endif
                        @if (check_coa_settings('specification'))
                            <td>6.5 - 8.5</td>
                        @endif
                        @if (check_coa_settings('pass_fail_status'))
                            <td><span class="status-badge status-pass">Pass</span></td>
                        @endif
                    </tr>
                    <tr>
                        @if (check_coa_settings('component_name'))
                            <td>Conductivity</td>
                        @endif
                        @if (check_coa_settings('test_method'))
                            <td>ASTM D1125</ td>
                        @endif
                        @if (check_coa_settings('results'))
                            <td>452</td>
                        @endif
                        @if (check_coa_settings('unit'))
                            <td>µS/cm</td>
                        @endif
                        @if (check_coa_settings('specification'))
                            <td>&lt; 500</td>
                        @endif
                        @if (check_coa_settings('pass_fail_status'))
                            <td><span class="status-badge status-warning">Warning</span></td>
                        @endif
                    </tr>
                    <tr>
                        @if (check_coa_settings('component_name'))
                            <td>Sodium (Na)</td>
                        @endif
                        @if (check_coa_settings('test_method'))
                            <td>-</td>
                        @endif
                        @if (check_coa_settings('results'))
                            <td>23.5</td>
                        @endif
                        @if (check_coa_settings('unit'))
                            <td>mg/L</td>
                        @endif
                        @if (check_coa_settings('specification'))
                            <td>&lt; 30.0</td>
                        @endif
                        @if (check_coa_settings('pass_fail_status'))
                            <td><span class="status-badge status-pass">Pass</span></td>
                        @endif
                    </tr>
                    <tr>
                        @if (check_coa_settings('component_name'))
                            <td>Potassium (K)</td>
                        @endif
                        @if (check_coa_settings('test_method'))
                            <td>EPA 200.7
                        @endif
                        </td>
                        @if (check_coa_settings('results'))
                            <td>4.2</td>
                        @endif
                        @if (check_coa_settings('unit'))
                            <td>mg/L</td>
                        @endif
                        @if (check_coa_settings('specification'))
                            <td>&lt; 5.0</td>
                        @endif
                        @if (check_coa_settings('pass_fail_status'))
                            <td><span class="status-badge status-pass">Pass</span></td>
                        @endif
                    </tr>
                    <tr>
                        @if (check_coa_settings('component_name'))
                            <td>Calcium (Ca)</td>
                        @endif
                        @if (check_coa_settings('test_method'))
                            <td>-</td>
                        @endif
                        @if (check_coa_settings('results'))
                            <td>40.1</td>
                        @endif
                        @if (check_coa_settings('unit'))
                            <td>mg/L</td>
                        @endif
                        @if (check_coa_settings('specification'))
                            <td>&lt; 40.0</td>
                        @endif
                        @if (check_coa_settings('pass_fail_status'))
                            <td><span class="status-badge status-fail">Fail</span></td>
                        @endif
                    </tr>
                </tbody>
            </table>
        @endif

        @if (check_coa_settings('authorization'))
            <!-- Analysis Info -->
            <div class="row mt-4">
                <div class="col-md-6">
                    @if (check_coa_settings('authorization'))
                        <h6 class="fw-bold mb-2">Analysis Information</h6>
                    @endif
                    @if (check_coa_settings('analyzed_by'))
                        <p class="mb-1"><b>Analyzed by:</b> Mike Johnson<br><small>Senior Analyst</small></p>
                    @endif
                    @if (check_coa_settings('authorized_by'))
                        <p class="mb-1"><b>Verified by:</b> John Doe<br><small>Lab Supervisor</small></p>
                    @endif
                </div>
                <div class="col-md-6">
                    @if (check_coa_settings('authorization'))
                        <h6 class="fw-bold mb-2">Approval</h6>
                    @endif
                    @if (check_coa_settings('authorization'))
                        <p class="mb-1"><b>Approved by:</b> Dr. Robert Smith<br><small>Laboratory Director</small></p>
                    @endif
                    @if (check_coa_settings('authorization'))
                        <p class="mb-1"><small>Date: Jan 15, 2025</small></p>
                    @endif
                    @if (check_coa_settings('digital_signature'))
                         <img width="150px" height="150px" id="signature_img"
                                            src="{{ asset(main_path() . 'signature/' . auth()->user()?->signature) }}" alt="Signature">
                    @endif
                </div>
            </div>
        @endif
        @if (check_coa_settings('footer_information')) 
            <!-- Footer -->
            <div class="mt-4 text-muted small border-top pt-3">
                @if (check_coa_settings('disclaimer_text'))
                    <p>This report relates only to the sample(s) tested and shall not be reproduced except in full, without
                        written
                        approval of the laboratory.</p>
                @endif
                @if (check_coa_settings('page_numbers'))
                    <p class="mb-0">End of Report - Page 1 of 1</p>
                @endif
                @if (check_coa_settings('laboratory_contact_information'))
                    <p class="mb-0">Laboratory Excellence Corp. | 123 Lab Street, Science City, ST 12345</p>
                @endif
                @if (check_coa_settings('footer_information'))
                    <p class="mb-0">Document ID: RPT-2025-001-V1</p>
                @endif
            </div>
        @endif
    </div>
@endsection
@section('js')
    <script src="{{ asset(main_path() . 'js/roles.min.js') }}"></script>
@endsection
