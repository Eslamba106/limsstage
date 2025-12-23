@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>
    {{ translate('edit_coa_generation_setting') }}
@endsection
@section('css')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('edit_coa_generation_settings') }}</h4>
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

    <div class="mb-5"></div>

    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('coa_generation_setting.update', $coa_generation_setting->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Setting Name -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ translate('Setting_Name') }}</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $coa_generation_setting->name) }}">
                    </div>

                    <!-- Frequency, Execution Time -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">{{ translate('Frequency') }}</label>
                            <select class="form-select" name="frequency_id">
                                @foreach ($frequencies as $frequency_item)
                                    <option value="{{ $frequency_item->id }}"
                                        {{ $coa_generation_setting->frequency == $frequency_item->id ? 'selected' : '' }}>
                                        {{ $frequency_item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">{{ translate('Execution_Time') }}</label>
                            <input type="time" name="execution_time" class="form-control"
                                   value="{{ old('execution_time', $coa_generation_setting->execution_time) }}">
                        </div>
                    </div>

                    <!-- Generation Conditions -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{ translate('Generation_Conditions') }}</label>
                        @foreach ([1,2,3,4] as $cond)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="{{ $cond }}" name="generation_condition"
                                       id="cond{{ $cond }}"
                                       {{ $coa_generation_setting->generation_condition == $cond ? 'checked' : '' }}>
                                <label class="form-check-label" for="cond{{ $cond }}">
                                    {{ translate([
                                        1 => 'Generate_&_email_COA_when_status_is_authorized',
                                        2 => 'Generate_&_email_COA_only_if_authorized_and_all_test_methods_are_within_spec',
                                        3 => 'Generate_COA_when_status_is_authorized',
                                        4 => 'Generate_COA_only_if_authorized_and_all_test_methods_are_within_spec'
                                    ][$cond]) }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <!-- Sample Points -->
                    <div class="mb-4">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">{{ translate('Sample_Plants') }}</label>
                                <select class="form-select" name="plant_id">
                                    <option value="-1">{{ translate('All_Plants') }}</option>
                                    @foreach ($plants as $plant_item)
                                        <option value="{{ $plant_item->id }}"
                                            {{ $coa_generation_setting->plant_id == $plant_item->id ? 'selected' : '' }}>
                                            {{ $plant_item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-8">
                                <div class="from-group">
                                    <label for="sample_points"
                                        class="form-label fw-bold">{{ translate('Sample_Points') }}</label>
                                    <select id="sample_points" name="sample_points[]"
                                        class="form-select js-select2-custom form-control" multiple>
                                        @foreach ($samples as $sample_item)
                                            <option value="{{ $sample_item->id }}"
                                                {{ $coa_generation_setting->sample->contains($sample_item->id) ? 'selected' : '' }}>
                                                {{ $sample_item->sample_plant?->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Recipients -->
                    <div class="col-md-12">
                        <div class="from-group">
                            <label class="form-label fw-bold">{{ translate('Email_Recipients') }}</label>
                            <select name="emails[]" class="form-select js-select2-custom form-control" multiple>
                                @foreach ($emails as $email_item)
                                    <option value="{{ $email_item->id }}"
                                        {{ $coa_generation_setting->emails->contains($email_item->id) ? 'selected' : '' }}>
                                        {{ $email_item->email }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end  mt-2">
                        <button class="btn btn-success" type="submit">{{ translate('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
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
                        data.samples.forEach(function(sample) {
                            $('select[name="sample_points[]"]').append(
                                `<option value="${sample.id}">${sample.name}</option>`
                            );
                        });
                        $('#sample_points').trigger('change');
                    },
                    error: function() {
                        alert("error");
                    }
                });
            } else {
                $('#sample_points').empty().trigger('change');
            }
        });
    </script>
@endsection
