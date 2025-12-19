@extends('layouts.dashboard')
@section('title')
    {{ __('roles.create_sample') }}
@endsection
@section('css')
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
                <h4 class="page-title">{{ __('roles.create_sample') }}</h4>
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
        <form action="{{ route('admin.submission.store') }}" method="post" enctype="multipart/form-data">
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
                            <div class="row align-items-center mb-3 ">
                                <div class="col-md-6   col-lg-6">
                                    <div class="form-group">
                                        <label for="">{{ __('samples.sample_name') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="plant_sample_id" class="form-control" required readonly
                                            onchange="add_test_methods(this)">
                                            <option value="">{{ __('samples.select_sub_plant') }}</option>
                                        </select>
                                        @error('plant_sample_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="card  " id="testing_requirements">
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4 class="mb-0"><i
                                        class="bi bi-ui-checks-grid me-2"></i>{{ __('roles.testing_requirements') }}</h4>
                            </div>
                        </div>
                        <div class="card-body bg-light">

                            <div class="container mt-4 bg-light">
                                <div class="p-3 border rounded mb-4">
                                    <h6 class="mb-3">{{ __('roles.required_test_methods') }}</h6>
                                    <div class="row g-3" id="test-methods-list">

                                    </div>

                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="p-3 border rounded">
                                            <h6 class="mb-3">{{ __('roles.priority_level') }}</h6>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" checked type="radio" name="priority"
                                                    id="normal" value="normal">
                                                <label class="form-check-label" for="normal">⚪
                                                    {{ __('roles.normal') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="priority"
                                                    id="high" value="high">
                                                <label class="form-check-label" for="high">🟠
                                                    {{ __('roles.high') }}</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="priority"
                                                    id="critical" value="critical">
                                                <label class="form-check-label" for="critical">🔺
                                                    {{ __('roles.critical') }}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="p-3 border rounded">
                                            <h6 class="mb-3">{{ __('roles.sampling_date_and_time') }}</h6>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                                <input type="datetime-local" class="form-control"
                                                    name="sampling_date_and_time" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4 class="mb-0">{{ __('roles.additional_information') }}</h4>
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <div class="row">

                                <div class="col-md-12   col-lg-12">
                                    <div class="form-group">
                                        <label for="">{{ __('roles.comment') }} <span
                                                class="text-danger">*</span></label>

                                        <textarea name="comment" id="" class="form-control" cols="30" rows="5"
                                            placeholder="Enter any additional information or comments here..."></textarea>
                                        @error('comment')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

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
        function add_test_methods(select) {
            var component_id = $(select).val();


            $.ajax({
                url: "{{ route('admin.submission.get_test_method_by_sample_id', ':id') }}".replace(':id',
                    component_id),
                type: "GET",
                dataType: "json",
                success: function(data) {


                    var methodsContainer = $('#test-methods-list');
                    methodsContainer.empty(); // Clear previous test methods
                    data.test_methods.forEach(function(method, index) {

                        var id = 'test_method_' + index;
                        var methodHtml = `
                    <div class="col-md-5 m-1 ">
                        <div class="form-check border rounded p-2">
                            <input class="form-check-input" name="sample_test_method_item_id[]" type="checkbox" value="${method.id}" id="${id}">
                            <label class="form-check-label" for="${id}">${method.master_test_method.name} </label>
                        </div>
                    </div>
                     
                    `;
                        methodsContainer.append(methodHtml);


                    });
                },
                error: function() {
                    testing_requirements.html('<p class="text-danger">Failed to load test methods.</p>');
                }
            });
        }
    </script>
    <script>
        $('select[name=plant_id]').on('change', function() {
            var tenant_id = $(this).val();
            if (tenant_id) {
                var methodsContainer = $('#test-methods-list');
                methodsContainer.empty();
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
                                // console.log(data.samples);
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
                var methodsContainer = $('#test-methods-list');
                methodsContainer.empty();
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
