@extends('layouts.dashboard')
@section('title')
    {{ translate('add_report_generation_setting') }}
@endsection
@section('css')
    <link href="{{ asset(main_path() . 'css/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('add_report_generation_setting') }}</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ translate('home') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ translate('dashboard') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-5"></div>

    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('report_generation_setting.store') }}" method="POST">
                    @csrf
                    
                    <!-- Setting Name -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ translate('Setting_Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="{{ translate('Setting_Name') }}" required>
                    </div>

                    <!-- Frequency and Execution Time -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ translate('Frequency') }} <span class="text-danger">*</span></label>
                            <select class="form-select" name="frequency_id" required>
                                <option value="">{{ translate('Select_Frequency') }}</option>
                                @foreach ($frequencies as $frequency_item)
                                    <option value="{{ $frequency_item->id }}">{{ $frequency_item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{ translate('Execution_Time') }} <span class="text-danger">*</span></label>
                            <input type="time" name="execution_time" class="form-control" value="07:00" required>
                        </div>
                    </div>

                    <!-- Generation Conditions -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ translate('Generation_Conditions') }} <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="1" name="generation_condition" id="cond1" required>
                            <label class="form-check-label" for="cond1">
                                {{ translate('Generate_Report_when_status_is_completed') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="2" name="generation_condition" id="cond2" checked>
                            <label class="form-check-label" for="cond2">
                                {{ translate('Generate_Report_only_if_completed_and_all_test_methods_are_within_spec') }}
                            </label>
                        </div>
                    </div>

                    <!-- Report Type -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ translate('Report_Type') }} <span class="text-danger">*</span></label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="1" name="report_type" id="type1" required>
                            <label class="form-check-label" for="type1">
                                {{ translate('All_Results') }}
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="2" name="report_type" id="type2" checked>
                            <label class="form-check-label" for="type2">
                                {{ translate('Out_of_Spec_Results_Only') }}
                            </label>
                        </div>
                    </div>

                    <!-- Sample Points -->
                    <div class="mb-4">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">{{ translate('Sample_Plants') }}</label>
                                <select class="form-select" name="plant_id" id="plant_id">
                                    <option value="">{{ translate('All_Plants') }}</option>
                                    @foreach ($plants as $plant_item)
                                        <option value="{{ $plant_item->id }}">{{ $plant_item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="sample_points" class="form-label fw-bold">
                                        {{ translate('Sample_Points') }} <span class="text-danger">*</span>
                                    </label>
                                    <select id="sample_points" name="sample_points[]"
                                        class="form-select js-select2-custom form-control" multiple required>
                                        @foreach ($samples as $sample_item)
                                            <option value="{{ $sample_item->id }}">
                                                {{ $sample_item->sample_plant?->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Recipients -->
                    <div class="col-md-12 mb-4">
                        <div class="form-group">
                            <label for="emails" class="form-label fw-bold">
                                {{ translate('Email_Recipients') }} <span class="text-danger">*</span>
                            </label>
                            <select id="emails" name="emails[]" class="form-select js-select2-custom form-control" multiple required>
                                @foreach ($emails as $email_item)
                                    <option value="{{ $email_item->id }}">
                                        {{ $email_item->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-2">
                        <a href="{{ route('report_generation_setting.list') }}" class="btn btn-secondary me-2">
                            {{ translate('Cancel') }}
                        </a>
                        <button class="btn btn-success" type="submit">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset(main_path() . 'js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.js-select2-custom').select2();
        });
        
        $(document).on('change', 'select[name=plant_id]', function() {
            var select = $(this);
            if (select.val()) {
                $.ajax({
                    url: "{{ route('admin.sample.get_sample_from_plant', ':id') }}".replace(':id', select.val()),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="sample_points[]"]').empty();
                        if (data.samples && data.samples.length > 0) {
                            data.samples.forEach(function(sample) {
                                $('select[name="sample_points[]"]').append(
                                    `<option value="${sample.id}">${sample.name}</option>`
                                );
                            });
                        }
                        $('#sample_points').trigger('change');
                    },
                    error: function() {
                        alert("{{ translate('Error_loading_samples') }}");
                    }
                });
            } else {
                // Reload all samples
                location.reload();
            }
        });
    </script>
@endsection
