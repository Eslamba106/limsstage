@extends('layouts.dashboard')
@section('title')
    {{ __('roles.edit_test_method') }}
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
                <h4 class="page-title">{{ __('roles.edit_test_method') }}</h4>
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
        <form action="{{ route('admin.test_method.update', $testMethod->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
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

                                <div class="col-md-6 col-lg-4 col-lg-12">

                                    <div class="form-group">
                                        <label for="">{{ __('roles.name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', $testMethod->name) }}" />

                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4 col-lg-12">
                                    <div class="form-group">
                                        <label for="description" class="title-color">{{ __('test_method.description') }}
                                            <span class="text-danger"> *</span></label>
                                        <textarea name="description" class="form-control" rows="3" cols="30">{{ old('description', $testMethod->description) }}</textarea>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4 class="mb-0">{{ __('test_method.component_configration') }}</h4>
                            </div>
                        </div>
                        <div class="card-body  border border-primary">
                            <div class="row componants" id="componants">
                                @if(!empty($testMethod->test_method_items))
                                @foreach($testMethod->test_method_items as $component)
                                <div class="card p-3 mb-3 border border-primary position-relative">
                                    <a href="{{ route('admin.test_method.delete_component' , $component->id) }}" class="btn btn-danger btn-sm position-absolute" style="top: 10px; right: 10px;" onclick="this.closest('.card').remove();">
                                        <i class="mdi mdi-delete"></i>
                                    </a>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-3">
                                                <div class="form-group">
                                                    <input type="hidden" value="{{ $component->id }}" name="item_id[]"  >
                                                    <label for="">{{ __('roles.name') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="item_name-{{ $component->id }}" class="form-control" value="{{   $component->name  }}" />
                                                    @error('item_name-{{ $component->id }}')
                                                        <span class="error text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-1">
                                                <div class="form-group">
                                                    <label for="">{{ __('test_method.unit') }} <span class="text-danger">*</span></label>
                                                    <select name="unit-{{ $component->id }}" class="form-control">
                                                        <option value="">{{ __('test_method.select_unit') }}</option>
                                                        @foreach ($units as $unit_item)
                                                            <option value="{{ $unit_item->id }}" {{ ($unit_item->id == $component->unit)  ? 'selected' : '' }}>{{ $unit_item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('unit-{{ $component->id }}')
                                                        <span class="error text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-2">
                                                <div class="form-group">
                                                    <label for="">{{ __('test_method.result_type') }} <span class="text-danger">*</span></label>
                                                    <select name="result_type-{{ $component->id }}" class="form-control">
                                                        <option value="">{{ __('test_method.select_result_type') }}</option>
                                                        @foreach ($result_types as $result_type_item)
                                                            <option value="{{ $result_type_item->id }}" {{  $component->result_type  == $result_type_item->id ? 'selected' : '' }}>{{ $result_type_item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('result_type-{{ $component->id }}')
                                                        <span class="error text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-1">
                                                <div class="form-group">
                                                    <label for="">{{ __('test_method.precision') }} <span class="text-danger">*</span></label>
                                                    <input type="number" name="precision-{{ $component->id }}" class="form-control" value="{{ $component->precision }}" />
                                                    @error('precision-{{ $component->id }}')
                                                        <span class="error text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-2">
                                                <div class="form-group">
                                                    <label for="">{{ __('test_method.lower_range') }} <span class="text-danger">*</span></label>
                                                    <input type="number" name="lower_range-{{ $component->id }}" class="form-control" value="{{  $component->lower_range }}" />
                                                    @error('lower_range-{{ $component->id }}')
                                                        <span class="error text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-2">
                                                <div class="form-group">
                                                    <label for="">{{ __('test_method.upper_range') }} <span class="text-danger">*</span></label>
                                                    <input type="number" name="upper_range-{{ $component->id }}" class="form-control" value="{{  $component->upper_range  }}" />
                                                    @error('upper_range-{{ $component->id }}' )
                                                        <span class="error text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-1">
                                                <div class="form-group">
                                                    <div class="form-check mt-4">
                                                        <input type="checkbox" name="reportable-{{ $component->id }}" value="1" class="form-check-input" id="reportableCheckbox{{ $component->id }}" {{   (isset($component->reportable)  && $component->reportable == 1 ) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="reportableCheckbox{{ $component->id }}">
                                                            {{ __('test_method.reportable') }}
                                                        </label>
                                                    </div>
                                                    @error('reportable-{{ $component->id }}' )
                                                        <span class="error text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <div class="form-group mt-2"
                                @if (session()->get('locale') == 'ar') style="text-align: left;" @else style="text-align: right;" @endif>
                                <button type="button" onclick="add_service()" class="btn btn-secondary mt-2"><i
                                        class="mdi mdi-plus"></i>
                                    {{ __('test_method.add_another_component') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="form-group mt-2"
                    @if (session()->get('locale') == 'ar') style="text-align: left;" @else style="text-align: right;" @endif>
                    <button type="submit"
                        class="btn btn-primary mt-2">{{ __('test_method.update_test_method') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script>
        function add_service() {
            const container = document.getElementById('componants');

            const bladeContent = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="card p-3 mb-3 border border-primary position-relative">
    <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 10px; right: 10px;" onclick="this.closest('.card').remove();">
        <i class="mdi mdi-delete"></i>
    </button>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="form-group">
                    <label for="">{{ __('roles.name') }} <span class="text-danger">*</span></label>
                    <input type="text" name="item_name[]" class="form-control" />
                    @error('name')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-lg-1">
                <div class="form-group">
                    <label for="">{{ __('test_method.unit') }} <span class="text-danger">*</span></label>
                    <select name="unit[]" class="form-control">
                        <option value="">{{ __('test_method.select_unit') }}</option>
                        @foreach ($units as $unit_item)
                            <option value="{{ $unit_item->id }}">{{ $unit_item->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-lg-2">
                <div class="form-group">
                    <label for="">{{ __('test_method.result_type') }} <span class="text-danger">*</span></label>
                    <select name="result_type[]" class="form-control">
                        <option value="">{{ __('test_method.select_result_type') }}</option>
                        @foreach ($result_types as $result_type_item)
                            <option value="{{ $result_type_item->id }}">{{ $result_type_item->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-lg-1">
                <div class="form-group">
                    <label for="">{{ __('test_method.precision') }} <span class="text-danger">*</span></label>
                    <input type="text" name="precision[]" class="form-control" />
                    @error('precision')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-lg-2">
                <div class="form-group">
                    <label for="">{{ __('test_method.lower_range') }} <span class="text-danger">*</span></label>
                    <input type="text" name="lower_range[]" class="form-control" />
                    @error('lower_range')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-lg-2">
                <div class="form-group">
                    <label for="">{{ __('test_method.upper_range') }} <span class="text-danger">*</span></label>
                    <input type="text" name="upper_range[]" class="form-control" />
                    @error('upper_range')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-lg-1">
                <div class="form-group">
                    <div class="form-check mt-4">
                        <input type="checkbox" name="reportable[]" value="1" class="form-check-input" id="reportableCheckboxNew">
                        <label class="form-check-label" for="reportableCheckboxNew">
                            {{ __('test_method.reportable') }}
                        </label>
                    </div>
                    @error('reportable')
                        <span class="error text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
`;

            container.insertAdjacentHTML('beforeend', bladeContent);
        }
    </script>
@endsection
