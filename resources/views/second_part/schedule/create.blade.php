@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ __('roles.submission_managment') }}
@endsection
@section('css')
    <style>
        .card-header {
            cursor: pointer;
        }

        .toggle-switch {
            width: 40px;
            height: 20px;
        }

        .test-toggle {
            margin-left: auto;
        }

        .test-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .test-method {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-lab {
            color: #0d6efd;
        }
    </style>
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.submission_managment') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ __('dashboard.home') }} </a>
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
        <form action="{{ route('admin.submission.schedule.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4 class="mb-0">{{ __('roles.sample_information') }}</h4>
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <div class="row ">

                                <div class="col-md-6   col-lg-6">
                                    <div class="form-group">
                                        <label for="">{{ __('samples.plant_name') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="plant_id" class="form-control" required>
                                            <option value="">{{ __('samples.select_plant') }}</option>
                                            @foreach ($plants as $plant_item)
                                                <option value="{{ $plant_item->id }}">{{ $plant_item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('plant_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6   col-lg-6">
                                    <div class="form-group">
                                        <label for="">{{ __('samples.sub_plant_name') }} </label>
                                        <select name="sub_plant_id" class="form-control" disabled>
                                            <option value="">{{ __('samples.select_sub_plant') }}</option>
                                        </select>
                                        @error('sub_plant_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row align-items-center mb-3 ">
                                <div class="col-md-6   col-lg-6">
                                    <div class="form-group">
                                        <label for="">{{ __('samples.sample_name') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="plant_sample_id" class="form-control" required disabled
                                            onchange="add_test_methods(this)">
                                            <option value="">{{ __('samples.select_sub_plant') }}</option>
                                        </select>
                                        @error('plant_sample_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div> --}}


                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4><i class="bi bi-geo-alt-fill text-primary"></i> Sample Points</h4>
                            </div>
                        </div>

                        <div class="card-body bg-light">
                            <div class="row " id="sample-point-form">
                                {{-- <div class="container bg-white p-4 rounded shadow   col-lg-12"> 
                                    <div class="card mb-3">
                                        <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                            <div>
                                                <strong>Water Treatment Plant</strong><br>
                                                <small class="text-muted">Location: Building A</small>
                                            </div>
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="badge bg-primary">4 Tests</span>
                                                <div class="form-check form-switch m-0">
                                                    <input class="form-check-input" type="checkbox">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-2">
                                            <div class="row text-muted mb-2">
                                                <div class="col-3">Test Method</div>
                                                <div class="col-3">Frequency</div>
                                                <div class="col-3">Schedule</div>
                                                <div class="col-3">Status</div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <div class="col-3 test-method">
                                                    <i class="bi bi-beaker icon-lab"></i> pH Analysis
                                                </div>
                                                <div class="col-3">Every 2 Hours</div>
                                                <div class="col-3">08:00, 14:00</div>
                                                <div class="col-3 d-flex align-items-center">
                                                    <div class="form-check form-switch me-2">
                                                        <input class="form-check-input" type="checkbox">
                                                    </div>
                                                    <i class="bi bi-gear-fill"></i>
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="col-3 test-method">
                                                    <i class="bi bi-beaker icon-lab"></i> Turbidity Test
                                                </div>
                                                <div class="col-3">Daily</div>
                                                <div class="col-3">09:00</div>
                                                <div class="col-3 d-flex align-items-center">
                                                    <div class="form-check form-switch me-2">
                                                        <input class="form-check-input" type="checkbox">
                                                    </div>
                                                    <i class="bi bi-gear-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                    </div>
                    <div>
                        <div class="form-group mt-2"
                            @if (session()->get('locale') == 'ar') style="text-align: left;" @else style="text-align: right;" @endif>
                            <button type="submit" class="btn btn-primary mt-2">{{ __('general.save') }}</button>
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
        $(document).on('change', 'select[name=plant_id]', function() {
            var select = $(this);
            var methodsContainer = $('#sample-point-form');

            if (select.val()) {
                $.ajax({
                    url: "{{ route('admin.submission.schedule.get_sample_by_plant_id', ':id') }}".replace(
                        ':id', select.val()),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        methodsContainer.empty();

                        data.all_samples.forEach(function(sample, sampleIndex) {
                            var id = 'test_method_' + sampleIndex;
                            let testMethodsHtml = '';
                            sample.test_methods.forEach((test_method_item, testIndex) => {
                                testMethodsHtml += `
                            <div class="row align-items-center mb-2">
                                <div class="col-3 test-method">
                                    <i class="bi bi-beaker icon-lab"></i> ${testIndex + 1}. ${test_method_item.master_test_method.name}
                                </div> 
                                
                                <div class="col-3">   
                                    <select name="frequency_id-${sample.id}-${test_method_item.master_test_method.id}" class="form-control" required>
                                        @foreach ($frequencies as $frequency)
                                            <option value="{{ $frequency->id }}">{{ $frequency->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <input class="form-control" name="schedule_hour-${sample.id}-${test_method_item.master_test_method.id}" type="time"  step="60">
                                </div>
                                <div class="col-3 d-flex align-items-center">
                                    <div class="  me-2">
                                        <input class="form-check-input" type="checkbox" value="${test_method_item.master_test_method.id}" name="test_method_id[${sample.id}][]">
                                    </div>
                                    <i class="bi bi-gear-fill"></i>
                                </div>
                            </div>
                        `;
                            });

                            var methodHtml = `
                        <div class="container bg-white p-4 rounded shadow col-lg-12"> 
                            <div class="card mb-3">
                                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                    <div>
                                        <strong>${sample.sample_plant?.name}</strong><br>
                                        <small class="text-muted">Location:  </small>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge bg-primary">  Tests</span>
                                        <div class="  m-0">
                                            <input class="form-check-input" type="checkbox" name="sample_points[]"   value="${sample.id} " id="${id}">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-2">
                                    <div class="row text-muted mb-2">
                                        <div class="col-3">{{ __('test_method.test_method') }}</div>
                                        <div class="col-3">Frequency</div>
                                        <div class="col-3">Schedule</div>
                                        <div class="col-3">Status</div>
                                    </div>
                                    ${testMethodsHtml}
                                </div>
                            </div>
                        </div>
                    `;

                            methodsContainer.append(methodHtml);
                        });
                    },
                    error: function() {
                        methodsContainer.html(
                        '<p class="text-danger">Failed to load test methods.</p>');
                    }
                });
            } else {
                methodsContainer.empty();
            }
        });

        $(document).on('change', 'select[name=sub_plant_id]', function() {
            var select = $(this);
            if (select.val()) {
                var methodsContainer = $('#sample-point-form');

                $.ajax({
                    url: "{{ route('admin.submission.schedule.get_sample_by_plant_id', ':id') }}".replace(
                        ':id',
                        select.val()),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                        methodsContainer.empty();
                        data.all_samples.forEach(function(sample, sampleIndex) {
                            var id = 'test_method_' + sampleIndex;
                            let testMethodsHtml = '';
                            sample.test_methods.forEach((test_method_item, testIndex) => {
                                testMethodsHtml += `
                            <div class="row align-items-center mb-2">
                                <div class="col-3 test-method">
                                    <i class="bi bi-beaker icon-lab"></i> ${testIndex + 1}. ${test_method_item.master_test_method.name}
                                </div> 
                                <div class="col-3">   
                                    <select name="frequency_id-${test_method_item.master_test_method.id}-${sample.id}" class="form-control" required>
                                        @foreach ($frequencies as $frequency)
                                            <option value="{{ $frequency->id }}">{{ $frequency->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <input class="form-control" name="schedule_hour-${test_method_item.master_test_method.id}-${sample.id}" type="time"  step="60">
                                </div>
                                <div class="col-3 d-flex align-items-center">
                                    <div class=" me-2 m-1">
                                        <input class="form-check-input" type="checkbox" value="${test_method_item.master_test_method.id}" name="test_method_id-${test_method_item.id}[]">
                                    </div>
                                    <i class="bi bi-gear-fill"></i>
                                </div>
                            </div>
                        `;
                            });

                            var methodHtml = `
                        <div class="container bg-white p-4 rounded shadow col-lg-12"> 
                            <div class="card mb-3">
                                <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                    <div>
                                        <strong>${sample.sample_plant?.name}</strong><br>
                                        <small class="text-muted">Location:  </small>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="badge bg-primary">  Tests</span>
                                        <div class="m-1 m-0">
                                            <input class="form-check-input" type="checkbox" name="sample_points[]" checked value="${sample.id}" id="${id}">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-2">
                                    <div class="row text-muted mb-2">
                                        <div class="col-3">{{ __('test_method.test_method') }}</div>
                                        <div class="col-3">Frequency</div>
                                        <div class="col-3">Schedule</div>
                                        <div class="col-3">Status</div>
                                    </div>
                                    ${testMethodsHtml}
                                </div>
                            </div>
                        </div>
                    `;

                            methodsContainer.append(methodHtml);
                        });

                    },
                    error: function() {
                        methodsContainer.html(
                            '<p class="text-danger">Failed to load test methods.</p>');
                    }
                });
            } else {
                var methodsContainer = $('#sample-point-form');
                methodsContainer.empty();
            }
        });
    </script>
    <script>
        $('select[name=plant_id]').on('change', function() {
            var tenant_id = $(this).val();
            if (tenant_id) {
                $.ajax({
                    url: "{{ route('admin.sample.get_sub_from_plant', ':id') }}".replace(':id',
                        tenant_id),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('select[name="sub_plant_id"]').empty().prop('disabled', true);
                            $('select[name="plant_sample_id"]').empty().prop('disabled', true);
                            if (data && data.plants && data.plants.length > 0) {
                                $('select[name="sub_plant_id"]').empty().prop('disabled', false);
                                var select = $('select[name="sub_plant_id"]');
                                select.empty().prop('disabled', false);
                                select.append(
                                    '<option value="">{{ __('samples.select_sub_plant') }}</option>'
                                );
                                $.each(data.plants, function(index, plant) {
                                    select.append('<option value="' + plant.id + '">' + plant
                                        .name + '</option>');
                                });
                                if (data.samples && data.samples.length > 0) {
                                    var select = $('select[name="plant_sample_id"]');
                                    select.empty().prop('disabled', false);
                                    select.append(
                                        '<option value="">{{ __('samples.select_sample') }}</option>'
                                    );

                                    $.each(data.samples, function(index, sample) {
                                        select.append('<option value="' + sample.id + '">' +
                                            sample
                                            .name + '</option>');
                                    });

                                }
                            } else if (data && data.samples && data.samples.length > 0) {
                                $('select[name="plant_sample_id"]').empty().prop('disabled', false);
                                var select = $('select[name="plant_sample_id"]');
                                select.empty().prop('disabled', false);
                                select.append(
                                    '<option value="">{{ __('samples.select_sample') }}</option>'
                                );
                                $.each(data.samples, function(index, sample) {
                                    select.append('<option value="' + sample.id + '">' + sample
                                        .name + '</option>');
                                });

                            }


                        } else {}
                    },
                    error: function(xhr, status, error) {
                        console.error('Error occurred:', error);
                    }
                });
            }
        })
        $('select[name=sub_plant_id]').on('change', function() {
            var tenant_id = $(this).val();
            if (tenant_id) {
                $.ajax({
                    url: "{{ route('admin.sample.get_sample_from_plant', ':id') }}".replace(':id',
                        tenant_id),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('select[name="plant_sample_id"]').empty().prop('disabled', true);
                            if (data && data.samples && data.samples.length > 0) {
                                $('select[name="plant_sample_id"]').empty().prop('disabled', false);
                                var select = $('select[name="plant_sample_id"]');
                                select.empty().prop('disabled', false);
                                select.append(
                                    '<option value="">{{ __('samples.select_sample') }}</option>');
                                $.each(data.samples, function(index, sample) {
                                    select.append('<option value="' + sample.id + '">' + sample
                                        .name + '</option>');
                                });

                            }


                        } else {}
                    },
                    error: function(xhr, status, error) {
                        console.error('Error occurred:', error);
                    }
                });
            }
        })
    </script>
@endsection 
