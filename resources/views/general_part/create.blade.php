@extends('layouts.dashboard')
@section('title')
    {{ __('roles.create_test_method') }}
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
                <h4 class="page-title">{{ __('roles.create_test_method') }}</h4>
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
        <form action="{{ route('admin.' . $route . '.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4 class="mb-0">{{ __('roles.basic_information') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6 col-lg-4 col-lg-6">

                                    <div class="form-group">
                                        <label for="">{{ __('roles.name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" />

                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-lg-6">

                                    <div class="form-group">
                                        <label for="">{{ __('samples.sub_plant_count') }} </label>
                                        <input type="number" onkeyup="add_sub_plant(this)" name="sub_plant_count"
                                            class="form-control" />

                                        @error('sub_plant_count')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-lg-6">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-primary form-control"
                                            onclick="add_sample()">{{ __('samples.add_sample') }}</button>
                                    </div>
                                </div>
                                <div class="card-body" id="main_sample_content">
                                </div>
                            </div>

                        </div>

                    </div>
                    <div id="main-content"></div>
                    <div>
                        <div class="form-group mt-2"
                            @if (session()->get('locale') == 'ar') style="text-align: left;" @else style="text-align: right;" @endif>
                            <button type="submit" class="btn btn-primary mt-2">{{ __('general.save') }}</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        function add_sub_plant(element) {
            const sub_plant_count = $(element).val();
            const container = document.getElementById('main-content');

            container.innerHTML = '';

            for (let i = 1; i <= sub_plant_count; i++) {
                const bladeContent = `
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4 class="mb-0">{{ __('roles.basic_information') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-4 col-lg-6">

                                    <div class="form-group">
                                        <label for="">{{ __('roles.name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="sub_plant_name-${i}" class="form-control" />

                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4 col-xl-12">
                                    <div class="form-group">
                                        <label for=""> </label>
                                        <button type="button" class="btn btn-primary form-control" onclick="add_samples(${i})">{{ __('samples.add_sample') }}</button>
                                    </div>
                                </div>
                                   <div class="card-body" id="main_sample_content-${i}">

                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', bladeContent);
            };
        }
    </script>
    <script>
        function add_sample() {
            const container = document.getElementById('main_sample_content');
            const bladeContent = `
        <div class="row mt-1 bg-primary border rounded p-2 position-relative" id="sample_name">
            <div class="col-md-6 col-lg-4 col-lg-12">
                <div class="form-group">
                    <label for="sample_name[]">{{ __('samples.sample_name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="sample_name[]" class="form-control" />
                    @error('name')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px;" onclick="removeSample(this)">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    `;
            container.insertAdjacentHTML('beforeend', bladeContent);
        }

        function removeSample(button) {
            button.closest('.row').remove();
        }
    </script>
    <script>
        const counters = {};

        function add_samples(i) {

            const container = document.getElementById('main_sample_content-' + i);
            if (!counters[i]) {
                counters[i] = 0;
            }
            counters[i]++;

            let counterInput = document.getElementById('sample_counter-' + i);
            if (!counterInput) {

                const formContainer = document.createElement('div');
                formContainer.innerHTML = `
                    <input type="hidden" id="sample_counter-${i}" name="sample_counter[${i}]" value="${counters[i]}">
                    `;
                container.appendChild(formContainer);
            } else {

                counterInput.value = counters[i];
            }
            const bladeContent = `
                <div class="row mt-1 bg-primary border rounded p-2 position-relative" id="sample_name">
                    <div class="col-md-6 col-lg-4 col-lg-12">
                        <div class="form-group">
                            <label for="sample_name-${i}-${counters[i]}">{{ __('samples.sample_name') }} <span class="text-danger">*</span></label>
                            <input type="text" name="sample_name-${i}-${counters[i]}" class="form-control" />
                            @error('name')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 5px; right: 5px;" onclick="removeSample(this)">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', bladeContent);
        }

        function removeSample(button) {
            button.closest('.row').remove();
        }
    </script>
@endsection
