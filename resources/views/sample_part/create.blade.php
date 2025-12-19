@extends('layouts.back-end.app')
@section('title', __('region.regions'))
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Title -->
    <div class="mb-3">
        <h2 class="h1 mb-0 d-flex gap-2">
            <img width="60" src="{{asset('/public/assets/back-end/img/regions.jpg')}}" alt="">
            {{__('region.regions')}}
        </h2>
    </div>
    <!-- End Page Title -->

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    {{ __('region.add_new_region')}}
                </div> 
                <div class="card-body" style="text-align: {{ Session::get('locale') === "ar" ? 'right' : 'left'}};">
                    <form action="{{route('region.store')}}" method="post">
                        @csrf

                        <div class="form-group" >
                            <input type="hidden" id="id">
                            <label class="title-color" for="name">{{ __('region.region_name')}}<span class="text-danger">*</span>  </label>
                            <input type="text" name="name" class="form-control"  
                                   placeholder="{{__('region.enter_region_name')}}" >
                        </div>
                        <div class="form-group" >
                            <input type="hidden" id="id">
                            <label class="title-color" for="name">{{ __('region.region_code')}}<span class="text-danger">*</span>  </label>
                            <input type="text" name="code" class="form-control" 
                                   placeholder="{{__('region.enter_region_code')}}" >
                        </div>


                        <div class="d-flex flex-wrap gap-2 justify-content-end">
                            <button type="reset" class="btn btn-secondary">{{__('general.reset')}}</button>
                            <button type="submit" class="btn btn--primary">{{__('general.submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="px-3 py-4">
                    <div class="row align-items-center">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="mb-0 d-flex align-items-center gap-2">{{ __('region.region_list')}}
                                    <span class="badge badge-soft-dark radius-50 fz-12"> </span>
                                </h5>
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <!-- Search -->
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-custom input-group-merge">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="datatableSearch_" type="search" name="search" class="form-control"
                                            placeholder="{{ __('region.search_by_region_name') }}" aria-label="Search" value="{{ $search }}" required>
                                        <button type="submit" class="btn btn--primary">{{ __('general.search')}}</button>
                                    </div>
                                </form>
                                <!-- End Search -->
                            </div>
                        </div>
                </div>
                <div style="text-align: {{Session::get('locale') === "ar" ? 'right' : 'left'}};">
                    <div class="table-responsive">
                        <table id="datatable"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                            <thead class="thead-light thead-50 text-capitalize">
                                <tr>
                                    <th>{{ __('general.sl')}}</th>
                                    <th class="text-center">{{ __('region.region_name')}} </th>
                                    <th class="text-center">{{ __('region.region_code')}} </th>
                                    <th class="text-center">{{ __('general.actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($regions as $key => $region)
                                <tr>
                                    <td>{{$regions->firstItem()+$key}}</td>
                                    <td class="text-center">{{ ($region->name)}}</td>
                                    <td class="text-center">{{ ($region->code)}}</td>
                                    <td>
                                       <div class="d-flex justify-content-center gap-2">
                                            <a class="btn btn-outline-info btn-sm square-btn"
                                                title="{{ __('general.edit')}}"
                                                href="{{ route('region.edit' , $region->id) }}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm delete square-btn"
                                                title="{{ __('general.delete')}}"
                                                id="{{ $region['id'] }}">
                                                <i class="tio-delete"></i>
                                            </a>
                                       </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <div class="d-flex justify-content-lg-end">
                        <!-- Pagination -->
                        {!! $regions->links() !!}
                    </div>
                </div>

                @if(count($regions)==0)
                    <div class="text-center p-4">
                        <img class="mb-3 w-160" src="{{asset('public/assets/back-end')}}/svg/illustrations/sorry.svg" alt="Image Description">
                        <p class="mb-0">{{ __('general.no_data_to_show')}}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
 
 
@endpush

{{-- @extends('layouts.dashboard')
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
@endsection --}}
