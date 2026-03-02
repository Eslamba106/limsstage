@extends('layouts.dashboard')
@section('title')
    {{ translate('edit_sample') }}
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
                <h4 class="page-title">{{ translate('edit_sample') }}</h4>
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
        <form action="{{ route('admin.sample.update', $sample->id) }}" method="post" enctype="multipart/form-data">
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

                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="main_plant_item">
                                            {{ __('samples.plant_name') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="main_plant_item" id="main_plant_item"
                                            class="form-control @error('main_plant_item') is-invalid @enderror" required>
                                            <option value="">{{ __('samples.select_plant') }}</option>
                                            @foreach ($plants as $plant_item)
                                                <option value="{{ $plant_item->id }}"
                                                    {{ old('main_plant_item', $sample->plant_id) == $plant_item->id ? 'selected' : '' }}>
                                                    {{ $plant_item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('main_plant_item')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="sub_plant_item">
                                            {{ __('samples.sub_plant_name') }}
                                        </label>
                                        <select name="sub_plant_item" id="sub_plant_item"
                                            class="form-control @error('sub_plant_item') is-invalid @enderror">
                                            <option value="">{{ __('samples.select_sub_plant') }}</option>
                                            @foreach ($sub_plants as $sub_plants_item)
                                                <option value="{{ $sub_plants_item->id }}"
                                                    {{ old('sub_plant_item', $sample->sub_plant_id) == $sub_plants_item->id ? 'selected' : '' }}>
                                                    {{ $sub_plants_item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sub_plant_item')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="sample_name">
                                            {{ __('samples.sample_name') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="sample_name" id="sample_name"
                                            class="form-control @error('sample_name') is-invalid @enderror" required>
                                            <option value="{{ old('sample_name', $sample->plant_sample_id) }}">
                                                {{ $sample->sample_plant->name ?? __('samples.select_sample') }}
                                            </option>
                                        </select>
                                        @error('sample_name')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="toxic">
                                            {{ __('samples.toxic') }}
                                            <span class="text-danger ms-1" style="font-size: 18px;">☠</span>
                                        </label>
                                        <select name="toxic" id="toxic"
                                            class="form-control @error('toxic') is-invalid @enderror">
                                            <option value="">{{ __('samples.select_toxic_degree') }}</option>
                                            @foreach ($toxic_degrees as $toxic_degree_item)
                                                <option value="{{ $toxic_degree_item->id }}"
                                                    {{ old('toxic', $sample->toxic) == $toxic_degree_item->id ? 'selected' : '' }}>
                                                    {{ $toxic_degree_item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('toxic')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <label for="coa" class="form-label">{{ translate('coa') }}</label>
                                        <div class="form-check form-switch m-2">
                                            <input class="form-check-input" type="checkbox" id="coa" name="coa"
                                                @if (isset($sample->coa)) checked @endif>
                                        </div>
                                        @error('coa')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4 class="mb-0">{{ __('samples.associated_test_method') }}</h4>
                            </div>
                        </div>
                        <div class="card-body  border border-primary">
                            @php
                                $var = [];
                            @endphp
                            @foreach ($sample_test_methods as $sample_test_method_item)
                                <div class="row componants" id="componants">
                                    <div class="col-md-6   col-lg-6">
                                        <div class="form-group">
                                            <label for="">{{ __('test_method.test_method') }} <span
                                                    class="text-danger">*</span></label>
                                            <select name="test_method[{{ $sample_test_method_item->id }}]"
                                                onchange="test_method_master(this,{{ $sample_test_method_item->id }})"
                                                class="form-control">
                                                <option value="">{{ __('samples.select_test_method') }}</option>
                                                @foreach ($test_methods as $test_method_item)
                                                    <option value="{{ $test_method_item->id }}"
                                                        {{ $sample_test_method_item->test_method_id == $test_method_item->id ? 'selected' : '' }}>
                                                        {{ $test_method_item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('test_method')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6   col-lg-6">
                                        <div class="form-group">
                                            <label for="">{{ __('test_method.component') }} <span
                                                    class="text-danger">*</span></label>
                                            <select name="main_components[{{ $sample_test_method_item->id }}]"
                                                onchange="main_components_master(this,{{ $sample_test_method_item->id }})"
                                                class="form-control">
                                                <option value="">{{ __('samples.select_component') }}</option>
                                                <option value="-1">{{ __('samples.select_all_component') }}</option>
                                                @foreach ($sample_test_method_item->master_test_method->test_method_items as $sample_test_method_items_item)
                                                    <option value="{{ $sample_test_method_items_item->id }}"
                                                        {{ $sample_test_method_item->sample_test_method_items->contains('test_method_item_id', $sample_test_method_items_item->id) ? 'selected' : '' }}>
                                                        {{ $sample_test_method_items_item->name }}</option>
                                                @endforeach

                                            </select>
                                            @error('test_method')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="main_components  col-lg-12"
                                        id="main_components_{{ $sample_test_method_item->id }}">
                                        @foreach ($sample_test_method_item->sample_test_method_items as $sample_test_method_sub_item)
                                            <div class="container mt-4">

                                                <div class="  d-flex justify-content-between align-items-center">
                                                    <label class="form-label">{{ translate('Components_&_Limits') }}
                                                        :</label>

                                                    <a
                                                        href="{{ route('admin.sample.delete_test_method_item_from_sample', $sample_test_method_sub_item->id) }}"class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    {{-- {{ dd($sample_test_method_sub_item) }} --}}
                                                </div>
                                                <input type="hidden"
                                                    name="test_method_item_id[{{ $sample_test_method_sub_item->id }}]"
                                                    value="{{ $sample_test_method_sub_item->test_method_item_id }}">
                                                <div class="border border-primary rounded p-3 mb-3"
                                                    style="background-color: #f8f9fa;">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <div>
                                                            <input type="checkbox" id="tds"
                                                                name="component_old[{{ $sample_test_method_sub_item->id }}]"
                                                                checked>
                                                            <label for="tds"
                                                                class="fw-bold text-primary">{{ $sample_test_method_sub_item->test_method_item->name }}
                                                            </label>
                                                        </div>
                                                        <div class="text-end text-primary fw-bold">{{ translate('Unit') }}
                                                            :
                                                            {{ $sample_test_method_sub_item->test_method_item->main_unit && $sample_test_method_sub_item->test_method_item->main_unit->name ? $sample_test_method_sub_item->test_method_item->main_unit->name : 'N/A' }}

                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <div>
                                                            <label for="tds"
                                                                class="fw-bold text-primary">{{ translate('warning_limit') }}</label>
                                                            <input type="number"
                                                                name="warning_limit_old[{{ $sample_test_method_sub_item->id }}]"
                                                                id="warning_limit_old_{{ $sample_test_method_sub_item->id }}"
                                                                class="form-control"
                                                                value="{{ old("warning_limit_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->warning_limit) }}"
                                                                step="any"
                                                                onkeyup="only_one_general_change_warning_limit_type_old({{ $sample_test_method_sub_item->id }})">
                                                            <input type="number"
                                                                name="warning_limit_end_old[{{ $sample_test_method_sub_item->id }}]"
                                                                id="warning_limit_end_old_{{ $sample_test_method_sub_item->id }}"
                                                                class="form-control warning-limit-end {{ $sample_test_method_sub_item->warning_limit_end ? '' : 'd-none' }}"
                                                                value="{{ old("warning_limit_end_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->warning_limit_end) }}"
                                                                step="any"
                                                                style="{{ $sample_test_method_sub_item->warning_limit_end ? '' : 'display:none;' }}"
                                                                onkeyup="only_one_general_change_warning_limit_type_old({{ $sample_test_method_sub_item->id }})">
                                                        </div>
                                                        <div class="text-end text-primary fw-bold">
                                                            <label for="tds"
                                                                class="fw-bold text-primary">{{ translate('action_limit') }}</label>
                                                            <input type="number"
                                                                name="action_limit_old[{{ $sample_test_method_sub_item->id }}]"
                                                                id="action_limit_old_{{ $sample_test_method_sub_item->id }}"
                                                                class="form-control"
                                                                value="{{ old("action_limit_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->action_limit) }}"
                                                                step="any"
                                                                onkeyup="only_one_general_change_action_limit_type_old({{ $sample_test_method_sub_item->id }})">
                                                            <input type="number"
                                                                name="action_limit_end_old[{{ $sample_test_method_sub_item->id }}]"
                                                                id="action_limit_end_old_{{ $sample_test_method_sub_item->id }}"
                                                                class="form-control action-limit-end {{ $sample_test_method_sub_item->action_limit_end ? '' : 'd-none' }}"
                                                                value="{{ old("action_limit_end_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->action_limit_end) }}"
                                                                step="any"
                                                                style="{{ $sample_test_method_sub_item->action_limit_end ? '' : 'display:none;' }}"
                                                                onkeyup="only_one_general_change_action_limit_type_old({{ $sample_test_method_sub_item->id }})">
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <div>
                                                            <label for="tds"
                                                                class="fw-bold text-primary">{{ translate('warning_limit_type') }}</label>
                                                            <select
                                                                name="warning_limit_type_old[{{ $sample_test_method_sub_item->id }}]"
                                                                id="warning_limit_type_old_{{ $sample_test_method_sub_item->id }}"
                                                                class="form-control"
                                                                onchange="only_one_general_change_warning_limit_type_old({{ $sample_test_method_sub_item->id }})">
                                                                <option value="">
                                                                    {{ translate('select_warning_limit_type') }}</option>
                                                                <option value="="
                                                                    {{ old("warning_limit_type_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->warning_limit_type) == '=' ? 'selected' : '' }}>
                                                                    =</option>
                                                                <option value=">="
                                                                    {{ old("warning_limit_type_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->warning_limit_type) == '>=' ? 'selected' : '' }}>
                                                                    &ge;</option>
                                                                <option value="<="
                                                                    {{ old("warning_limit_type_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->warning_limit_type) == '<=' ? 'selected' : '' }}>
                                                                    &le;</option>
                                                                <option value="<"
                                                                    {{ old("warning_limit_type_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->warning_limit_type) == '<' ? 'selected' : '' }}>
                                                                    &lt;</option>
                                                                <option value=">"
                                                                    {{ old("warning_limit_type_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->warning_limit_type) == '>' ? 'selected' : '' }}>
                                                                    &gt;</option>
                                                                <option value="8646"
                                                                    {{ old("warning_limit_type_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->warning_limit_type) == '8646' ? 'selected' : '' }}>
                                                                    &#8646;</option>
                                                            </select>
                                                        </div>
                                                        <div class="text-end text-primary fw-bold">
                                                            <label for="tds"
                                                                class="fw-bold text-primary">{{ translate('action_limit_type') }}</label>

                                                            <select
                                                                name="action_limit_type_old[{{ $sample_test_method_sub_item->id }}]"
                                                                id="action_limit_type_old_{{ $sample_test_method_sub_item->id }}"
                                                                class="form-control"
                                                                onchange="only_one_general_change_action_limit_type_old({{ $sample_test_method_sub_item->id }})">
                                                                <option value="">
                                                                    {{ translate('select_action_limit_type') }}</option>
                                                                <option value="="
                                                                    {{ old("action_limit_type_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->action_limit_type) == '=' ? 'selected' : '' }}>
                                                                    =</option>
                                                                <option value=">="
                                                                    {{ old("action_limit_type_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->action_limit_type) == '>=' ? 'selected' : '' }}>
                                                                    &ge;</option>
                                                                <option value="<="
                                                                    {{ old("action_limit_type_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->action_limit_type) == '<=' ? 'selected' : '' }}>
                                                                    &le;</option>
                                                                <option value="<"
                                                                    {{ old("action_limit_type_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->action_limit_type) == '<' ? 'selected' : '' }}>
                                                                    &lt;</option>
                                                                <option value=">"
                                                                    {{ old("action_limit_type_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->action_limit_type) == '>' ? 'selected' : '' }}>
                                                                    &gt;</option>
                                                                <option value="8646"
                                                                    {{ old("action_limit_type_old.{$sample_test_method_sub_item->id}", $sample_test_method_sub_item->action_limit_type) == '8646' ? 'selected' : '' }}>
                                                                    &#8646;</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="p-3 rounded" style="background-color: #fff8dc;">
                                                                <small
                                                                    class="text-muted d-block">{{ translate('Warning_Limit') }}</small>
                                                                <span class="text-warning fw-bold"
                                                                    id="warning_limit_type_old-{{ $sample_test_method_sub_item->id }}">
                                                                    @php
                                                                        $warningLimitType = old(
                                                                            "warning_limit_type_old.{$sample_test_method_sub_item->id}",
                                                                            $sample_test_method_sub_item->warning_limit_type,
                                                                        );
                                                                        $warningLimit = old(
                                                                            "warning_limit_old.{$sample_test_method_sub_item->id}",
                                                                            $sample_test_method_sub_item->warning_limit,
                                                                        );
                                                                        $warningLimitEnd = old(
                                                                            "warning_limit_end_old.{$sample_test_method_sub_item->id}",
                                                                            $sample_test_method_sub_item->warning_limit_end,
                                                                        );
                                                                    @endphp
                                                                    @if ($warningLimitType == '8646' && $warningLimit && $warningLimitEnd)
                                                                        {{ $warningLimit . ' ' }}
                                                                        &#8646;
                                                                        {{ ' ' . $warningLimitEnd }}
                                                                    @elseif ($warningLimitType && $warningLimit)
                                                                        {{ $warningLimitType . ' ' . $warningLimit }}
                                                                    @else
                                                                        {{ translate('not_set') }}
                                                                    @endif
                                                                </span>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="p-3 rounded" style="background-color: #ffeeee;">
                                                                <small
                                                                    class="text-muted d-block">{{ translate('Action_Limit') }}</small>
                                                                <span class="text-danger fw-bold"
                                                                    id="action_limit_type_old-{{ $sample_test_method_sub_item->id }}">
                                                                    @php
                                                                        $actionLimitType = old(
                                                                            "action_limit_type_old.{$sample_test_method_sub_item->id}",
                                                                            $sample_test_method_sub_item->action_limit_type,
                                                                        );
                                                                        $actionLimit = old(
                                                                            "action_limit_old.{$sample_test_method_sub_item->id}",
                                                                            $sample_test_method_sub_item->action_limit,
                                                                        );
                                                                        $actionLimitEnd = old(
                                                                            "action_limit_end_old.{$sample_test_method_sub_item->id}",
                                                                            $sample_test_method_sub_item->action_limit_end,
                                                                        );
                                                                    @endphp
                                                                    @if ($actionLimitType == '8646' && $actionLimit && $actionLimitEnd)
                                                                        {{ $actionLimit . ' ' }}
                                                                        &#8646;
                                                                        {{ ' ' . $actionLimitEnd }}
                                                                    @elseif ($actionLimitType && $actionLimit)
                                                                        {{ $actionLimitType . ' ' . $actionLimit }}
                                                                    @else
                                                                        {{ translate('not_set') }}
                                                                    @endif
                                                                </span>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            @endforeach
                            <div class="form-group mt-2"
                                @if (session()->get('locale') == 'ar') style="text-align: left;" @else style="text-align: right;" @endif>
                                <button type="button" onclick="add_test_method()" class="btn btn-secondary mt-2"><i
                                        class="mdi mdi-plus"></i>
                                    {{ __('samples.add_another_test_method') }}</button>
                            </div>



                        </div>
                        <div id="test_methods_main"></div>
                    </div>
                </div>
            </div>
            <div>
                <div class="form-group mt-2"
                    @if (session()->get('locale') == 'ar') style="text-align: left;" @else style="text-align: right;" @endif>
                    <button type="submit" class="btn btn-primary mt-2">{{ translate('update_sample') }}</button>
                </div>
            </div>
        </form>
    </div>
    {{-- {{ dd($var) }} --}}
@endsection
@section('js')
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script>
        /**
         * Handle test method change for existing test methods
         * @param {HTMLElement} element - Select element
         * @param {number} id - Test method ID
         */
        function test_method_master(element, id) {
            const testMethodId = $(element).val();

            if (!testMethodId) {
                return;
            }

            $.ajax({
                url: "{{ route('admin.sample.get_components_by_test_method', ':id') }}".replace(':id',
                    testMethodId),
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (!data || !data.components || data.components.length === 0) {
                        return;
                    }

                    const select = $(`select[name="main_components[${id}]"]`);
                    select.empty().prop('disabled', false);
                    select.append('<option value="">{{ __('samples.select_component') }}</option>');
                    select.append('<option value="-1">{{ __('samples.select_all_component') }}</option>');

                    $.each(data.components, function(index, component) {
                        select.append(`<option value="${component.id}">${component.name}</option>`);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error loading components:', error);
                }
            });
        }
        /**
         * Handle main plant change
         */
        $('select[name=main_plant_item]').on('change', function() {
            const plantId = $(this).val();

            if (!plantId) {
                $('select[name="sub_plant_item"]').empty().prop('disabled', true);
                $('select[name="sample_name"]').empty().prop('disabled', true);
                return;
            }

            loadSubPlantsAndSamples(plantId);
        });

        /**
         * Handle sub plant change
         */
        $('select[name=sub_plant_item]').on('change', function() {
            const subPlantId = $(this).val();

            if (!subPlantId) {
                $('select[name="sample_name"]').empty().prop('disabled', true);
                return;
            }

            loadSamplesFromSubPlant(subPlantId);
        });

        /**
         * Load sub plants and samples from main plant
         */
        function loadSubPlantsAndSamples(plantId) {
            $.ajax({
                url: "{{ route('admin.sample.get_sub_from_plant', ':id') }}".replace(':id', plantId),
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if (!data) {
                        return;
                    }

                    const subPlantSelect = $('select[name="sub_plant_item"]');
                    const sampleSelect = $('select[name="sample_name"]');

                    // Reset selects
                    subPlantSelect.empty().prop('disabled', true);
                    sampleSelect.empty().prop('disabled', true);

                    // Load sub plants if available
                    if (data.plants && data.plants.length > 0) {
                        subPlantSelect.empty().prop('disabled', false);
                        subPlantSelect.append(
                            '<option value="">{{ __('samples.select_sub_plant') }}</option>');

                        $.each(data.plants, function(index, plant) {
                            subPlantSelect.append(`<option value="${plant.id}">${plant.name}</option>`);
                        });
                    }

                    // Load samples if available
                    if (data.samples && data.samples.length > 0) {
                        sampleSelect.empty().prop('disabled', false);

                        $.each(data.samples, function(index, sample) {
                            sampleSelect.append(`<option value="${sample.id}">${sample.name}</option>`);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading sub plants and samples:', error);
                }
            });
        }

        /**
         * Load samples from sub plant
         */
        function loadSamplesFromSubPlant(subPlantId) {
            $.ajax({
                url: "{{ route('admin.sample.get_sample_from_plant', ':id') }}".replace(':id', subPlantId),
                type: "GET",
                dataType: "json",
                success: function(data) {
                    const sampleSelect = $('select[name="sample_name"]');
                    sampleSelect.empty().prop('disabled', true);

                    if (data && data.samples && data.samples.length > 0) {
                        sampleSelect.empty().prop('disabled', false);

                        $.each(data.samples, function(index, sample) {
                            sampleSelect.append(`<option value="${sample.id}">${sample.name}</option>`);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading samples:', error);
                }
            });
        }
        $('select[name=test_method]').on('change', function() {
            var tenant_id = $(this).val();
            if (tenant_id) {
                $.ajax({
                    url: "{{ route('admin.sample.get_components_by_test_method', ':id') }}".replace(':id',
                        tenant_id),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                        if (data) {
                            //
                            if (data && data.components && data.components.length > 0) {
                                $('select[name="main_components"]').empty().prop('disabled', false);
                                var select = $('select[name="main_components"]');
                                select.empty().prop('disabled', false);
                                select.append(
                                    '<option value="-1">{{ __('samples.select_component') }}</option>'
                                );
                                select.append(
                                    '<option value="-1">{{ __('samples.select_all_component') }}</option>'
                                );

                                $.each(data.components, function(index, component) {
                                    select.append('<option value="' + component.id + '">' +
                                        component
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
        $('select[name=main_components]').on('change', function() {
            var component_id = $(this).val();
            var test_method_id = $('select[name=test_method]').val();
            if (component_id == -1) {
                $.ajax({
                    url: "{{ route('admin.sample.get_components_by_test_method', ':id') }}".replace(':id',
                        test_method_id),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            if (data && data.components && data.components.length > 0) {


                                $('#main_components').empty();

                                $.each(data.components, function(index, component) {

                                    $('#main_components').append(`
                                        <div class="container mt-4">
                                        <label class="form-label">Components & Limits:</label>

                                        <div class="border border-primary rounded p-3 mb-3"
                                            style="background-color: #f8f9fa;">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <input type="checkbox" id="tds" name="component[${component.id}]" checked>
                                                    <label for="tds" class="fw-bold text-primary">${component.name}</label>
                                                </div>
                                                <div class="text-end text-primary fw-bold">Unit:${component.main_unit && component.main_unit.name ? component.main_unit.name : 'N/A'}</div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <label for="tds" class="fw-bold text-primary">{{ __('samples.warning_limit') }}</label>
                                                    <input type="number"  name="warning_limit[${component.id}]" class="form-control"     onkeyup="only_one_general_change_warning_limit_type(${component.id})">
                                                    <input type="number"  name="warning_limit_end[${component.id}]" class="form-control d-none"     onkeyup="only_one_general_change_warning_limit_type(${component.id})">
                                                </div>
                                                <div class="text-end text-primary fw-bold">
                                                     <label for="tds" class="fw-bold text-primary">{{ __('samples.action_limit') }}</label>
                                                    <input type="number"  name="action_limit[${component.id}]" class="form-control"     onkeyup="only_one_general_change_action_limit_type(${component.id} )">
                                                    <input type="number"  name="action_limit_end[${component.id}]" class="form-control d-none"     onkeyup="only_one_general_change_action_limit_type(${component.id} )">
                                                    </div>
                                            </div>
                                              <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <label for="tds" class="fw-bold text-primary">{{ __('samples.warning_limit_type') }}</label>
                                                      <select name="warning_limit_type[${component.id}]" class="form-control"   onchange="only_one_general_change_warning_limit_type(${component.id})">
                                                        <option value="">{{ __('samples.select_warning_limit_type') }}</option>
                                                            <option value="=">=</option>
                                                            <option value=">=">&ge;</option>
                                                            <option value="<=">&le;</option>
                                                            <option value="<">&lt;</option>
                                                            <option value=">">&gt;</option>
                                                            <option value="8646">&#8646;</option>

                                                    </select>
                                                </div>
                                                <div class="text-end text-primary fw-bold">
                                                     <label for="tds" class="fw-bold text-primary">{{ __('samples.action_limit_type') }}</label>

                                                    <select name="action_limit_type[${component.id}]" class="form-control"   onchange="only_one_general_change_action_limit_type(${component.id})">
                                                            <option value="">{{ __('samples.select_action_limit_type') }}</option>
                                                            <option value="=">=</option>
                                                            <option value=">=">&ge;</option>
                                                            <option value="<=">&le;</option>
                                                            <option value="<">&lt;</option>
                                                            <option value=">">&gt;</option>
                                                            <option value="8646">&#8646;</option>
                                                    </select>
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="p-3 rounded" style="background-color: #fff8dc;">
                                                        <small class="text-muted d-block">Warning Limit</small>
                                                        <span class="text-warning fw-bold" id="warning_limit_type[${component.id}]"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="p-3 rounded" style="background-color: #ffeeee;">
                                                        <small class="text-muted d-block">Action Limit</small>
                                                        <span class="text-danger fw-bold" id="action_limit_type[${component.id}]"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                      `);


                                });

                            }


                        } else {}
                    },
                    error: function(xhr, status, error) {
                        console.error('Error occurred:', error);
                    }
                });

            } else {
                $.ajax({
                    url: "{{ route('admin.sample.get_one_component_by_test_method', ':id') }}".replace(
                        ':id',
                        component_id),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                        if (data) {
                            if (data && data.component) {

                                $('#main_components').empty();

                                $('#main_components').append(`
                                        <div class="container mt-4">
                                        <label class="form-label">Components & Limits:</label>

                                        <div class="border border-primary rounded p-3 mb-3"
                                            style="background-color: #f8f9fa;">

                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <input type="checkbox" id="tds" name="component[${data.component.id}]" checked>
                                                    <label for="tds" class="fw-bold text-primary">${data.component.name}</label>
                                                </div>
                                                <div class="text-end text-primary fw-bold">Unit:${data.component.main_unit && data.component.main_unit.name ? data.component.main_unit.name : 'N/A'}</div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <label for="tds" class="fw-bold text-primary">{{ __('samples.warning_limit') }}</label>
                                                    <input type="number"  name="warning_limit[${data.component.id}]" class="form-control"     onkeyup="only_one_change_warning_limit_type(${data.component.id})">
                                                    <input type="number"  name="warning_limit_end[${data.component.id}]" class="form-control d-none"     onkeyup="only_one_change_warning_limit_type(${data.component.id})">
                                                </div>
                                                <div class="text-end text-primary fw-bold">
                                                     <label for="tds" class="fw-bold text-primary">{{ __('samples.action_limit') }}</label>
                                                    <input type="number"  name="action_limit[${data.component.id}]" class="form-control"     onkeyup="only_one_change_action_limit_type(${data.component.id})">
                                                    <input type="number"  name="action_limit_end[${data.component.id}]" class="form-control d-none"     onkeyup="only_one_change_action_limit_type(${data.component.id})">
                                                    </div>
                                            </div>
                                              <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <label for="tds" class="fw-bold text-primary">{{ __('samples.warning_limit_type') }}</label>
                                                      <select name="warning_limit_type[${data.component.id}]" class="form-control"   onchange="only_one_change_warning_limit_type(${data.component.id})">
                                                        <option value="">{{ __('samples.select_warning_limit_type') }}</option>
                                                            <option value="=">=</option>
                                                            <option value=">=">&ge;</option>
                                                            <option value="<=">&le;</option>
                                                            <option value="<">&lt;</option>
                                                            <option value=">">&gt;</option>
                                                            <option value="8646">&#8646;</option>
                                                    </select>
                                                </div>
                                                <div class="text-end text-primary fw-bold">
                                                     <label for="tds" class="fw-bold text-primary">{{ __('samples.action_limit_type') }}</label>

                                                    <select name="action_limit_type[${data.component.id}]" class="form-control"   onchange="only_one_change_action_limit_type(${data.component.id})">
                                                            <option value="">{{ __('samples.select_action_limit_type') }}</option>
                                                            <option value="=">=</option>
                                                            <option value=">=">&ge;</option>
                                                            <option value="<=">&le;</option>
                                                            <option value="<">&lt;</option>
                                                            <option value=">">&gt;</option>
                                                            <option value="8646">&#8646;</option>
                                                    </select>
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="p-3 rounded" style="background-color: #fff8dc;">
                                                        <small class="text-muted d-block">Warning Limit</small>
                                                        <span class="text-warning fw-bold"  id="warning_limit_type[${data.component.id}]"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="p-3 rounded" style="background-color: #ffeeee;">
                                                        <small class="text-muted d-block">Action Limit</small>
                                                        <span class="text-danger fw-bold" id="action_limit_type[${data.component.id}]"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                      `);

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
    <script>
        function change_action_limit_type(id) {
            var action_limit_type = document.querySelector('select[name=action_limit_type-' + id + ']').value;
            var action_limit = document.querySelector('input[name=action_limit-' + id + ']').value;

            if (action_limit_type == '=') {
                document.getElementById('action_limit_type-' + id).innerHTML = '= ' + action_limit;
            } else if (action_limit_type == '>=') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&ge; ' + action_limit;
            } else if (action_limit_type == '<=') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&le; ' + action_limit;
            } else if (action_limit_type == '<') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&lt; ' + action_limit;
            } else if (action_limit_type == '>') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&gt; ' + action_limit;
            } else if (action_limit_type == '8646') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&#8646; ' + action_limit;
                let elements = document.getElementsByName('action_limit_end-' + id);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + action_limit;
                    elements[0].classList.remove('d-none');
                }


            }
        }

        function change_warning_limit_type(id) {
            var warning_limit_type = document.querySelector('select[name=warning_limit_type-' + id + ']').value;
            var warning_limit = document.querySelector('input[name=warning_limit-' + id + ']').value;

            if (warning_limit_type == '=') {
                document.getElementById('warning_limit_type-' + id).innerHTML = '= ' + warning_limit;
            } else if (warning_limit_type == '>=') {
                document.getElementById('warning_limit_type-' + id).innerHTML = '&ge; ' + warning_limit;
            } else if (warning_limit_type == '<=') {
                document.getElementById('warning_limit_type-' + id).innerHTML = '&le; ' + warning_limit;
            } else if (warning_limit_type == '<') {
                document.getElementById('warning_limit_type-' + id).innerHTML = '&lt; ' + warning_limit;
            } else if (warning_limit_type == '>') {
                document.getElementById('warning_limit_type-' + id).innerHTML = '&gt; ' + warning_limit;
            } else if (warning_limit_type == '8646') {
                document.getElementById('warning_limit_type-' + id).innerHTML = warning_limit + ' &#8646; ' +
                    warning_limit_end;
                let elements = document.getElementsByName('warning_limit_end-' + id);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + warning_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }

        function only_one_change_action_limit_type(id) {
            var action_limit_type = document.querySelector('select[name=action_limit_type-' + id + ']').value;
            var action_limit = document.querySelector('input[name=action_limit-' + id + ']').value;
            var action_limit_end = document.querySelector('input[name=action_limit_end-' + id + ']').value;

            if (action_limit_type == '=') {
                document.getElementById('action_limit_type-' + id).innerHTML = '= ' + action_limit;
            } else if (action_limit_type == '>=') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&ge; ' + action_limit;
            } else if (action_limit_type == '<=') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&le; ' + action_limit;
            } else if (action_limit_type == '<') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&lt; ' + action_limit;
            } else if (action_limit_type == '>') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&gt; ' + action_limit;
            } else if (action_limit_type == '8646') {
                document.getElementById('action_limit_type-' + id).innerHTML = action_limit + ' &#8646; ' +
                    action_limit_end;
                let elements = document.getElementsByName('action_limit_end-' + id);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + action_limit;
                    elements[0].classList.remove('d-none');
                }


            }
        }

        function only_one_change_warning_limit_type(id) {
            var warning_limit_type = document.querySelector('select[name=warning_limit_type-' + id + ']').value;
            var warning_limit = document.querySelector('input[name=warning_limit-' + id + ']').value;
            var warning_limit_end = document.querySelector('input[name=warning_limit_end-' + id + ']').value;

            if (warning_limit_type == '=') {
                document.getElementById('warning_limit_type-' + id).innerHTML = '= ' + warning_limit;
            } else if (warning_limit_type == '>=') {
                document.getElementById('warning_limit_type-' + id).innerHTML = '&ge; ' + warning_limit;
            } else if (warning_limit_type == '<=') {
                document.getElementById('warning_limit_type-' + id).innerHTML = '&le; ' + warning_limit;
            } else if (warning_limit_type == '<') {
                document.getElementById('warning_limit_type-' + id).innerHTML = '&lt; ' + warning_limit;
            } else if (warning_limit_type == '>') {
                document.getElementById('warning_limit_type-' + id).innerHTML = '&gt; ' + warning_limit;
            } else if (warning_limit_type == '8646') {
                document.getElementById('warning_limit_type-' + id).innerHTML = warning_limit + ' &#8646; ' +
                    warning_limit_end;
                let elements = document.getElementsByName('warning_limit_end-' + id);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + warning_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }

        function add_only_one_change_action_limit_type(id, test_method_id) {
            var action_limit_type = document.querySelector('select[name=action_limit_type-' + test_method_id + '-' + id +
                ']').value;
            var action_limit = document.querySelector('input[name=action_limit-' + test_method_id + '-' + id + ']').value;
            var action_limit_end = document.querySelector('input[name=action_limit_end-' + test_method_id + '-' + id + ']')
                .value;

            if (action_limit_type == '=') {
                document.getElementById('action_limit_type-' + test_method_id + '-' + id).innerHTML = '= ' + action_limit;
            } else if (action_limit_type == '>=') {
                document.getElementById('action_limit_type-' + test_method_id + '-' + id).innerHTML = '&ge; ' +
                    action_limit;
            } else if (action_limit_type == '<=') {
                document.getElementById('action_limit_type-' + test_method_id + '-' + id).innerHTML = '&le; ' +
                    action_limit;
            } else if (action_limit_type == '<') {
                document.getElementById('action_limit_type-' + test_method_id + '-' + id).innerHTML = '&lt; ' +
                    action_limit;
            } else if (action_limit_type == '>') {
                document.getElementById('action_limit_type-' + test_method_id + '-' + id).innerHTML = '&gt; ' +
                    action_limit;
            } else if (action_limit_type == '8646') {
                document.getElementById('action_limit_type-' + test_method_id + '-' + id).innerHTML = action_limit +
                    ' &#8646; ' +
                    action_limit_end;
                let elements = document.getElementsByName('action_limit_end-' + test_method_id + '-' + id);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + action_limit;
                    elements[0].classList.remove('d-none');
                }


            }
        }

        function add_only_one_change_warning_limit_type(id, test_method_id) {
            var warning_limit_type = document.querySelector('select[name=warning_limit_type-' + test_method_id + '-' + id +
                ']').value;
            var warning_limit = document.querySelector('input[name=warning_limit-' + test_method_id + '-' + id + ']').value;
            var warning_limit_end = document.querySelector('input[name=warning_limit_end-' + test_method_id + '-' + id +
                ']').value;
            if (warning_limit_type == '=') {
                document.getElementById('warning_limit_type-' + test_method_id + '-' + id).innerHTML = '= ' + warning_limit;
            } else if (warning_limit_type == '>=') {
                document.getElementById('warning_limit_type-' + test_method_id + '-' + id).innerHTML = '&ge; ' +
                    warning_limit;
            } else if (warning_limit_type == '<=') {
                document.getElementById('warning_limit_type-' + test_method_id + '-' + id).innerHTML = '&le; ' +
                    warning_limit;
            } else if (warning_limit_type == '<') {
                document.getElementById('warning_limit_type-' + test_method_id + '-' + id).innerHTML = '&lt; ' +
                    warning_limit;
            } else if (warning_limit_type == '>') {
                document.getElementById('warning_limit_type-' + test_method_id + '-' + id).innerHTML = '&gt; ' +
                    warning_limit;
            } else if (warning_limit_type == '8646') {
                document.getElementById('warning_limit_type-' + test_method_id + '-' + id).innerHTML = warning_limit +
                    ' &#8646; ' +
                    warning_limit_end;
                let elements = document.getElementsByName('warning_limit_end-' + test_method_id + '-' + id);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + warning_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }

        function general_change_action_limit_type(compnent_id, index) {
            var action_limit_type = document.querySelector('select[name="action_limit_type-' + compnent_id + '-' + index +
                '"]').value;
            var action_limit = document.querySelector('input[name=action_limit-' + compnent_id + '-' + index + ']').value;
            var action_limit_end = document.querySelector('input[name=action_limit_end-' + compnent_id + '-' + index + ']')
                .value;
            if (action_limit_type == '=') {
                document.getElementById('action_limit_type-' + compnent_id + '-' + index).innerHTML = '= ' + action_limit;
            } else if (action_limit_type == '>=') {
                document.getElementById('action_limit_type-' + compnent_id + '-' + index).innerHTML = '&ge; ' +
                    action_limit;
            } else if (action_limit_type == '<=') {
                document.getElementById('action_limit_type-' + compnent_id + '-' + index).innerHTML = '&le; ' +
                    action_limit;
            } else if (action_limit_type == '<') {
                document.getElementById('action_limit_type-' + compnent_id + '-' + index).innerHTML = '&lt; ' +
                    action_limit;
            } else if (action_limit_type == '>') {
                document.getElementById('action_limit_type-' + compnent_id + '-' + index).innerHTML = '&gt; ' +
                    action_limit;
            } else if (action_limit_type == '8646') {
                document.getElementById('action_limit_type-' + compnent_id + '-' + index).innerHTML = action_limit +
                    ' &#8646; ' +
                    action_limit_end;
                let elements = document.getElementsByName('action_limit_end-' + compnent_id + '-' + index);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + action_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }

        function general_change_warning_limit_type(compnent_id, index) {
            var warning_limit_type = document.querySelector('select[name=warning_limit_type-' + compnent_id + '-' + index +
                ']').value;
            var warning_limit = document.querySelector('input[name=warning_limit-' + compnent_id + '-' + index + ']').value;
            var warning_limit_end = document.querySelector('input[name=warning_limit_end-' + compnent_id + '-' + index +
                ']').value;
            if (warning_limit_type == '=') {
                document.getElementById('warning_limit_type-' + compnent_id + '-' + index).innerHTML = '= ' + warning_limit;
            } else if (warning_limit_type == '>=') {
                document.getElementById('warning_limit_type-' + compnent_id + '-' + index).innerHTML = '&ge; ' +
                    warning_limit;
            } else if (warning_limit_type == '<=') {
                document.getElementById('warning_limit_type-' + compnent_id + '-' + index).innerHTML = '&le; ' +
                    warning_limit;
            } else if (warning_limit_type == '<') {
                document.getElementById('warning_limit_type-' + compnent_id + '-' + index).innerHTML = '&lt; ' +
                    warning_limit;
            } else if (warning_limit_type == '>') {
                document.getElementById('warning_limit_type-' + compnent_id + '-' + index).innerHTML = '&gt; ' +
                    warning_limit;
            } else if (warning_limit_type == '8646') {
                document.getElementById('warning_limit_type-' + compnent_id + '-' + index).innerHTML = warning_limit +
                    ' &#8646; ' +
                    warning_limit_end;
                let elements = document.getElementsByName('warning_limit_end-' + compnent_id + '-' + index);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + warning_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }

        function add_general_change_action_limit_type(compnent_id, index, test_method_id) {
            var action_limit_type = document.querySelector('select[name="action_limit_type-' + test_method_id + '-' +
                compnent_id + '-' + index +
                '"]').value;
            var action_limit = document.querySelector('input[name=action_limit-' + test_method_id + '-' + compnent_id +
                '-' + index + ']').value;
            var action_limit_end = document.querySelector('input[name=action_limit_end-' + test_method_id + '-' +
                compnent_id +
                '-' + index + ']').value;
            if (action_limit_type == '=') {
                document.getElementById('action_limit_type-' + test_method_id + '-' + compnent_id + '-' + index).innerHTML =
                    '= ' + action_limit;
            } else if (action_limit_type == '>=') {
                document.getElementById('action_limit_type-' + test_method_id + '-' + compnent_id + '-' + index).innerHTML =
                    '&ge; ' +
                    action_limit;
            } else if (action_limit_type == '<=') {
                document.getElementById('action_limit_type-' + test_method_id + '-' + compnent_id + '-' + index).innerHTML =
                    '&le; ' +
                    action_limit;
            } else if (action_limit_type == '<') {
                document.getElementById('action_limit_type-' + test_method_id + '-' + compnent_id + '-' + index).innerHTML =
                    '&lt; ' +
                    action_limit;
            } else if (action_limit_type == '>') {
                document.getElementById('action_limit_type-' + test_method_id + '-' + compnent_id + '-' + index).innerHTML =
                    '&gt; ' +
                    action_limit;
            } else if (action_limit_type == '8646') {
                document.getElementById('action_limit_type-' + test_method_id + '-' + compnent_id + '-' + index).innerHTML =
                    action_limit + ' &#8646; ' +
                    action_limit_end;
                let elements = document.getElementsByName('action_limit_end-' + test_method_id + '-' + compnent_id + '-' +
                    index);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + action_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }

        function add_general_change_warning_limit_type(compnent_id, index, test_method_id) {
            var warning_limit_type = document.querySelector('select[name=warning_limit_type-' + test_method_id + '-' +
                compnent_id + '-' + index + ']').value;
            var warning_limit = document.querySelector('input[name=warning_limit-' + test_method_id + '-' + compnent_id +
                '-' + index + ']').value;
            var warning_limit_end = document.querySelector('input[name=warning_limit_end-' + test_method_id + '-' +
                compnent_id +
                '-' + index + ']').value;

            if (warning_limit_type == '=') {
                document.getElementById('warning_limit_type-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML = '= ' + warning_limit;
            } else if (warning_limit_type == '>=') {
                document.getElementById('warning_limit_type-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML = '&ge; ' +
                    warning_limit;
            } else if (warning_limit_type == '<=') {
                document.getElementById('warning_limit_type-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML = '&le; ' +
                    warning_limit;
            } else if (warning_limit_type == '<') {
                document.getElementById('warning_limit_type-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML = '&lt; ' +
                    warning_limit;
            } else if (warning_limit_type == '>') {
                document.getElementById('warning_limit_type-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML = '&gt; ' +
                    warning_limit;
            } else if (warning_limit_type == '8646') {
                document.getElementById('warning_limit_type-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML = warning_limit + ' &#8646; ' +
                    warning_limit_end;
                let elements = document.getElementsByName('warning_limit_end-' + test_method_id + '-' + compnent_id + '-' +
                    index);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + warning_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }

        function only_one_general_change_action_limit_type(compnent_id) {
            var action_limit_type = document.querySelector('select[name="action_limit_type-' + compnent_id + '"]').value;
            var action_limit = document.querySelector('input[name=action_limit-' + compnent_id + ']').value;
            var action_limit_end = document.querySelector('input[name=action_limit_end-' + compnent_id + ']').value;

            if (action_limit_type == '=') {
                document.getElementById('action_limit_type-' + compnent_id).innerHTML = '= ' + action_limit;
            } else if (action_limit_type == '>=') {
                document.getElementById('action_limit_type-' + compnent_id).innerHTML = '&ge; ' + action_limit;
            } else if (action_limit_type == '<=') {
                document.getElementById('action_limit_type-' + compnent_id).innerHTML = '&le; ' + action_limit;
            } else if (action_limit_type == '<') {
                document.getElementById('action_limit_type-' + compnent_id).innerHTML = '&lt; ' + action_limit;
            } else if (action_limit_type == '>') {
                document.getElementById('action_limit_type-' + compnent_id).innerHTML = '&gt; ' + action_limit;
            } else if (action_limit_type == '8646') {
                document.getElementById('action_limit_type-' + compnent_id).innerHTML = action_limit + ' &#8646; ' +
                    action_limit_end;
                let elements = document.getElementsByName('action_limit_end-' + compnent_id);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + action_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }

        function only_one_general_change_warning_limit_type(compnent_id) {
            var warning_limit_type = document.querySelector('select[name=warning_limit_type-' + compnent_id + ']').value;
            var warning_limit = document.querySelector('input[name=warning_limit-' + compnent_id + ']').value;
            var warning_limit_end = document.querySelector('input[name=warning_limit_end-' + compnent_id + ']').value;

            if (warning_limit_type == '=') {
                document.getElementById('warning_limit_type-' + compnent_id).innerHTML = '= ' + warning_limit;
            } else if (warning_limit_type == '>=') {
                document.getElementById('warning_limit_type-' + compnent_id).innerHTML = '&ge; ' + warning_limit;
            } else if (warning_limit_type == '<=') {
                document.getElementById('warning_limit_type-' + compnent_id).innerHTML = '&le; ' + warning_limit;
            } else if (warning_limit_type == '<') {
                document.getElementById('warning_limit_type-' + compnent_id).innerHTML = '&lt; ' + warning_limit;
            } else if (warning_limit_type == '>') {
                document.getElementById('warning_limit_type-' + compnent_id).innerHTML = '&gt; ' + warning_limit;
            } else if (warning_limit_type == '8646') {
                document.getElementById('warning_limit_type-' + compnent_id).innerHTML = warning_limit + ' &#8646; ' +
                    warning_limit_end;
                let elements = document.getElementsByName('warning_limit_end-' + compnent_id);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + warning_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }
    </script>
    <script>
        let methodIndex = 0;

        // Initialize event delegation when document is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Use event delegation for delete buttons (works with dynamically added elements)
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-test-method-btn')) {
                    e.preventDefault();
                    const button = e.target.closest('.remove-test-method-btn');
                    const methodIndex = button.getAttribute('data-method-index');
                    const testMethodElement = document.getElementById('test_method-' + methodIndex);

                    if (testMethodElement) {
                        // Show confirmation dialog
                        if (confirm('{{ __('general.are_you_sure_delete_this') }}?')) {
                            testMethodElement.remove();
                        }
                    } else {
                        console.error('Test method element not found:', 'test_method-' + methodIndex);
                    }
                }
            });
        });

        function add_test_method() {
            const container = document.getElementById('test_methods_main');
            methodIndex++;

            const bladeContent = `
        <div class="card-body border border-primary position-relative" id="test_method-${methodIndex}" style="margin-bottom: 20px;">
            <button type="button" class="btn btn-danger btn-sm position-absolute remove-test-method-btn" data-method-index="${methodIndex}" style="top: 10px; {{ session()->get('locale') == 'ar' ? 'left: 10px;' : 'right: 10px;' }}" title="{{ __('general.delete') }}">
                <i class="fa fa-trash"></i>
            </button>
            <div class="row componants" id="componants-${methodIndex}">
                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>{{ __('test_method.test_method') }} <span class="text-danger">*</span></label>
                        <select name="test_method-${methodIndex}" class="form-control" onchange="get_components(this)">
                            <option value="">{{ __('samples.select_test_method') }}</option>
                            @foreach ($test_methods as $test_method_item)
                                <option value="{{ $test_method_item->id }}">{{ $test_method_item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <label>{{ __('test_method.component') }} <span class="text-danger">*</span></label>
                        <select name="components[]" onchange="add_components(this, ${methodIndex})" class="form-control" >
                            <option value="">{{ __('samples.select_component') }}</option>
                        </select>
                    </div>
                </div>
                <div class="main_components col-lg-12" id="main_components-${methodIndex}">
                </div>
            </div>
        </div>
    `;

            container.insertAdjacentHTML('beforeend', bladeContent);
        }

        function get_components(element) {
            var test_method_id = $(element).val();
            if (test_method_id) {
                $.ajax({
                    url: "{{ route('admin.sample.get_components_by_test_method', ':id') }}".replace(':id',
                        test_method_id),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data && data.components && data.components.length > 0) {
                            var parentRow = $(element).closest('.row');
                            var select = parentRow.find('select[name="components[]"]');

                            select.empty().prop('disabled', false);
                            select.append('<option value="-1">{{ __('samples.select_component') }}</option>');
                            select.append(
                                '<option value="-1">{{ __('samples.select_all_component') }}</option>');

                            $.each(data.components, function(index, component) {
                                select.append('<option value="' + component.id + '">' + component.name +
                                    '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error occurred:', error);
                    }
                });
            }
        }
    </script>
    <script>
        function add_components(element, i) {
            var component_id = $(element).val();
            var test_method_id = $('select[name=test_method-' + i + ']').val();
            if (component_id == -1) {
                $.ajax({
                    url: "{{ route('admin.sample.get_components_by_test_method', ':id') }}".replace(':id',
                        test_method_id),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            if (data && data.components && data.components.length > 0) {


                                $('#main_components-' + i).empty();

                                $.each(data.components, function(index, component) {

                                    $('#main_components-' + i).append(`
                                        <div class="container mt-4">
                                        <label class="form-label">Components & Limits:</label>

                                        <div class="border border-primary rounded p-3 mb-3"
                                            style="background-color: #f8f9fa;">
                                            <input type="hidden" name="test_method_item_id_new[${i}-${component.id}-${index+1}]" value="${component.id}">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                     <input type="checkbox" id="tds"  name="component-${i}-${component.id}-${index+1}"  checked>
                                                    <label for="tds" class="fw-bold text-primary">${component.name}</label>
                                                </div>
                                                <div class="text-end text-primary fw-bold">Unit:${component.main_unit && component.main_unit.name ? component.main_unit.name : 'N/A'}</div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <label for="tds" class="fw-bold text-primary">{{ __('samples.warning_limit') }}</label>
                                                    <input type="number"  name="warning_limit-${i}-${component.id}-${index+1}" class="form-control"     onkeyup="add_general_change_warning_limit_type(${component.id} , ${index+1} , ${i})">
                                                    <input type="number"  name="warning_limit_end-${i}-${component.id}-${index+1}" class="form-control d-none"     onkeyup="add_general_change_warning_limit_type(${component.id} , ${index+1} , ${i})">
                                                </div>
                                                <div class="text-end text-primary fw-bold">
                                                     <label for="tds" class="fw-bold text-primary">{{ __('samples.action_limit') }}</label>
                                                    <input type="number"  name="action_limit-${i}-${component.id}-${index+1}" class="form-control"      onkeyup="add_general_change_action_limit_type(${component.id} , ${index+1} , ${i})">
                                                    <input type="number"  name="action_limit_end-${i}-${component.id}-${index+1}" class="form-control d-none"     onkeyup="add_general_change_action_limit_type(${component.id} , ${index+1} , ${i})">
                                                    </div>
                                            </div>
                                              <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <label for="tds" class="fw-bold text-primary">{{ __('samples.warning_limit_type') }}</label>
                                                      <select name="warning_limit_type-${i}-${component.id}-${index+1}" class="form-control"   onchange="add_general_change_warning_limit_type(${component.id} , ${index+1} , ${i})">
                                                        <option value="">{{ __('samples.select_warning_limit_type') }}</option>
                                                            <option value="=">=</option>
                                                            <option value=">=">&ge;</option>
                                                            <option value="<=">&le;</option>
                                                            <option value="<">&lt;</option>
                                                            <option value=">">&gt;</option>
                                                            <option value="8646">&#8646;</option>
                                                    </select>
                                                </div>
                                                <div class="text-end text-primary fw-bold">
                                                     <label for="tds" class="fw-bold text-primary">{{ __('samples.action_limit_type') }}</label>

                                                    <select name="action_limit_type-${i}-${component.id}-${index+1}" class="form-control"   onchange="add_general_change_action_limit_type(${component.id} , ${index+1} , ${i})">
                                                            <option value="">{{ __('samples.select_action_limit_type') }}</option>
                                                            <option value="=">=</option>
                                                            <option value=">=">&ge;</option>
                                                            <option value="<=">&le;</option>
                                                            <option value="<">&lt;</option>
                                                            <option value=">">&gt;</option>
                                                            <option value="8646">&#8646;</option>
                                                    </select>
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="p-3 rounded" style="background-color: #fff8dc;">
                                                        <small class="text-muted d-block">Warning Limit</small>
                                                        <span class="text-warning fw-bold" id="warning_limit_type-${i}-${component.id}-${index+1}"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="p-3 rounded" style="background-color: #ffeeee;">
                                                        <small class="text-muted d-block">Action Limit</small>
                                                        <span class="text-danger fw-bold" id="action_limit_type-${i}-${component.id}-${index+1}"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                      `);


                                });

                            }


                        } else {}
                    },
                    error: function(xhr, status, error) {
                        console.error('Error occurred:', error);
                    }
                });

            } else {
                $.ajax({
                    url: "{{ route('admin.sample.get_one_component_by_test_method', ':id') }}".replace(
                        ':id',
                        component_id),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                        if (data) {
                            if (data && data.component) {

                                $('#main_components-' + i).empty();

                                $('#main_components-' + i).append(`
                                        <div class="container mt-4">
                                        <label class="form-label">Components & Limits:</label>

                                        <div class="border border-primary rounded p-3 mb-3"
                                            style="background-color: #f8f9fa;">
                                            <input type="hidden" name="test_method_item_id_new[${i}-${data.component.id}]" value="${data.component.id}">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                     <input type="checkbox" id="tds" name="component-${i}-${data.component.id}" checked>
                                                    <label for="tds" class="fw-bold text-primary">${data.component.name}</label>
                                                </div>
                                                <div class="text-end text-primary fw-bold">Unit:${data.component.main_unit && data.component.main_unit.name ? data.component.main_unit.name : 'N/A'}</div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <label for="tds" class="fw-bold text-primary">{{ __('samples.warning_limit') }}</label>
                                                    <input type="number"  name="warning_limit-${i}-${data.component.id}" class="form-control"     onkeyup="add_only_one_change_warning_limit_type(${data.component.id},${i})">
                                                    <input type="number"  name="warning_limit_end-${i}-${data.component.id}" class="form-control d-none"     onkeyup="add_only_one_change_warning_limit_type(${data.component.id},${i})">
                                                </div>
                                                <div class="text-end text-primary fw-bold">
                                                     <label for="tds" class="fw-bold text-primary">{{ __('samples.action_limit') }}</label>
                                                    <input type="number"  name="action_limit-${i}-${data.component.id}" class="form-control"     onkeyup="add_only_one_change_action_limit_type(${data.component.id},${i})">
                                                    <input type="number"  name="action_limit_end-${i}-${data.component.id}" class="form-control d-none"     onkeyup="add_only_one_change_action_limit_type(${data.component.id},${i})">
                                                    </div>
                                            </div>
                                              <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <label for="tds" class="fw-bold text-primary">{{ __('samples.warning_limit_type') }}</label>
                                                      <select name="warning_limit_type-${i}-${data.component.id}" class="form-control"   onchange="add_only_one_change_warning_limit_type(${data.component.id},${i})">
                                                        <option value="">{{ __('samples.select_warning_limit_type') }}</option>
                                                            <option value="=">=</option>
                                                            <option value=">=">&ge;</option>
                                                            <option value="<=">&le;</option>
                                                            <option value="<">&lt;</option>
                                                            <option value=">">&gt;</option>
                                                            <option value="8646">&#8646;</option>

                                                    </select>
                                                </div>
                                                <div class="text-end text-primary fw-bold">
                                                     <label for="tds" class="fw-bold text-primary">{{ __('samples.action_limit_type') }}</label>

                                                    <select name="action_limit_type-${i}-${data.component.id}" class="form-control"   onchange="add_only_one_change_action_limit_type(${data.component.id},${i})">
                                                            <option value="">{{ __('samples.select_action_limit_type') }}</option>
                                                            <option value="=">=</option>
                                                            <option value=">=">&ge;</option>
                                                            <option value="<=">&le;</option>
                                                            <option value="<">&lt;</option>
                                                            <option value=">">&gt;</option>
                                                            <option value="8646">&#8646;</option>

                                                    </select>
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="p-3 rounded" style="background-color: #fff8dc;">
                                                        <small class="text-muted d-block">Warning Limit</small>
                                                        <span class="text-warning fw-bold"  id="warning_limit_type-${i}-${data.component.id}"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="p-3 rounded" style="background-color: #ffeeee;">
                                                        <small class="text-muted d-block">Action Limit</small>
                                                        <span class="text-danger fw-bold" id="action_limit_type-${i}-${data.component.id}"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                      `);

                            }


                        } else {}
                    },
                    error: function(xhr, status, error) {
                        console.error('Error occurred:', error);
                    }
                });
            }
        }
    </script>

    <script>
        function change_action_limit_type(id) {
            var action_limit_type = document.querySelector('select[name=action_limit_type-' + id + ']').value;
            var action_limit = document.querySelector('input[name=action_limit-' + id + ']').value;

            if (action_limit_type == '=') {
                document.getElementById('action_limit_type-' + id).innerHTML = '= ' + action_limit;
            } else if (action_limit_type == '>=') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&ge; ' + action_limit;
            } else if (action_limit_type == '<=') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&le; ' + action_limit;
            } else if (action_limit_type == '<') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&lt; ' + action_limit;
            } else if (action_limit_type == '>') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&gt; ' + action_limit;
            } else if (action_limit_type == '8646') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&#8646; ' + action_limit;
                let elements = document.getElementsByName('action_limit_end-' + id);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + action_limit;
                    elements[0].classList.remove('d-none');
                }


            }
        }

        function change_warning_limit_type(id) {
            var warning_limit_type = document.querySelector('select[name=warning_limit_type-' + id + ']').value;
            var warning_limit = document.querySelector('input[name=warning_limit-' + id + ']').value;

            if (warning_limit_type == '=') {
                document.getElementById('warning_limit_type-' + id).innerHTML = '= ' + warning_limit;
            } else if (warning_limit_type == '>=') {
                document.getElementById('warning_limit_type-' + id).innerHTML = '&ge; ' + warning_limit;
            } else if (warning_limit_type == '<=') {
                document.getElementById('warning_limit_type-' + id).innerHTML = '&le; ' + warning_limit;
            } else if (warning_limit_type == '<') {
                document.getElementById('warning_limit_type-' + id).innerHTML = '&lt; ' + warning_limit;
            } else if (warning_limit_type == '>') {
                document.getElementById('warning_limit_type-' + id).innerHTML = '&gt; ' + warning_limit;
            } else if (warning_limit_type == '8646') {
                document.getElementById('warning_limit_type-' + id).innerHTML = warning_limit + ' &#8646; ' +
                    warning_limit_end;
                let elements = document.getElementsByName('warning_limit_end-' + id);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + warning_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }

        function only_one_change_action_limit_type(id) {
            var action_limit_type = document.querySelector('select[name=action_limit_type-' + id + ']').value;
            var action_limit = document.querySelector('input[name=action_limit-' + id + ']').value;
            var action_limit_end = document.querySelector('input[name=action_limit_end-' + id + ']').value;

            if (action_limit_type == '=') {
                document.getElementById('action_limit_type-' + id).innerHTML = '= ' + action_limit;
            } else if (action_limit_type == '>=') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&ge; ' + action_limit;
            } else if (action_limit_type == '<=') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&le; ' + action_limit;
            } else if (action_limit_type == '<') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&lt; ' + action_limit;
            } else if (action_limit_type == '>') {
                document.getElementById('action_limit_type-' + id).innerHTML = '&gt; ' + action_limit;
            } else if (action_limit_type == '8646') {
                document.getElementById('action_limit_type-' + id).innerHTML = action_limit + ' &#8646; ' +
                    action_limit_end;
                let elements = document.getElementsByName('action_limit_end-' + id);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + action_limit;
                    elements[0].classList.remove('d-none');
                }


            }
        }

        function only_one_change_warning_limit_type_old(id) {
            var warning_limit_type = document.querySelector('select[name=warning_limit_type_old-' + id + ']').value;
            var warning_limit = document.querySelector('input[name=warning_limit_old-' + id + ']').value;
            var warning_limit_end = document.querySelector('input[name=warning_limit_end_old-' + id + ']').value;

            if (warning_limit_type == '=') {
                document.getElementById('warning_limit_type_old-' + id).innerHTML = '= ' + warning_limit;
            } else if (warning_limit_type == '>=') {
                document.getElementById('warning_limit_type_old-' + id).innerHTML = '&ge; ' + warning_limit;
            } else if (warning_limit_type == '<=') {
                document.getElementById('warning_limit_type_old-' + id).innerHTML = '&le; ' + warning_limit;
            } else if (warning_limit_type == '<') {
                document.getElementById('warning_limit_type_old-' + id).innerHTML = '&lt; ' + warning_limit;
            } else if (warning_limit_type == '>') {
                document.getElementById('warning_limit_type_old-' + id).innerHTML = '&gt; ' + warning_limit;
            } else if (warning_limit_type == '8646') {
                document.getElementById('warning_limit_type_old-' + id).innerHTML = warning_limit + ' &#8646; ' +
                    warning_limit_end;
                let elements = document.getElementsByName('warning_limit_end_old-' + id);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + warning_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }

        function add_only_one_change_action_limit_type_old(id, test_method_id) {
            var action_limit_type = document.querySelector('select[name=action_limit_type_old-' + test_method_id + '-' +
                id +
                ']').value;
            var action_limit = document.querySelector('input[name=action_limit_old-' + test_method_id + '-' + id + ']')
                .value;
            var action_limit_end = document.querySelector('input[name=action_limit_end_old-' + test_method_id + '-' + id +
                    ']')
                .value;

            if (action_limit_type == '=') {
                document.getElementById('action_limit_type_old-' + test_method_id + '-' + id).innerHTML = '= ' +
                    action_limit;
            } else if (action_limit_type == '>=') {
                document.getElementById('action_limit_type_old-' + test_method_id + '-' + id).innerHTML = '&ge; ' +
                    action_limit;
            } else if (action_limit_type == '<=') {
                document.getElementById('action_limit_type_old-' + test_method_id + '-' + id).innerHTML = '&le; ' +
                    action_limit;
            } else if (action_limit_type == '<') {
                document.getElementById('action_limit_type_old-' + test_method_id + '-' + id).innerHTML = '&lt; ' +
                    action_limit;
            } else if (action_limit_type == '>') {
                document.getElementById('action_limit_type_old-' + test_method_id + '-' + id).innerHTML = '&gt; ' +
                    action_limit;
            } else if (action_limit_type == '8646') {
                document.getElementById('action_limit_type_old-' + test_method_id + '-' + id).innerHTML = action_limit +
                    ' &#8646; ' +
                    action_limit_end;
                let elements = document.getElementsByName('action_limit_end_old-' + test_method_id + '-' + id);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + action_limit;
                    elements[0].classList.remove('d-none');
                }


            }
        }

        function add_only_one_change_warning_limit_type_old(id, test_method_id) {
            var warning_limit_type = document.querySelector('select[name=warning_limit_type_old-' + test_method_id + '-' +
                id +
                ']').value;
            var warning_limit = document.querySelector('input[name=warning_limit_old-' + test_method_id + '-' + id + ']')
                .value;
            var warning_limit_end = document.querySelector('input[name=warning_limit_end_old-' + test_method_id + '-' + id +
                ']').value;
            if (warning_limit_type == '=') {
                document.getElementById('warning_limit_type_old-' + test_method_id + '-' + id).innerHTML = '= ' +
                    warning_limit;
            } else if (warning_limit_type == '>=') {
                document.getElementById('warning_limit_type_old-' + test_method_id + '-' + id).innerHTML = '&ge; ' +
                    warning_limit;
            } else if (warning_limit_type == '<=') {
                document.getElementById('warning_limit_type_old-' + test_method_id + '-' + id).innerHTML = '&le; ' +
                    warning_limit;
            } else if (warning_limit_type == '<') {
                document.getElementById('warning_limit_type_old-' + test_method_id + '-' + id).innerHTML = '&lt; ' +
                    warning_limit;
            } else if (warning_limit_type == '>') {
                document.getElementById('warning_limit_type_old-' + test_method_id + '-' + id).innerHTML = '&gt; ' +
                    warning_limit;
            } else if (warning_limit_type == '8646') {
                document.getElementById('warning_limit_type_old-' + test_method_id + '-' + id).innerHTML = warning_limit +
                    ' &#8646; ' +
                    warning_limit_end;
                let elements = document.getElementsByName('warning_limit_end_old-' + test_method_id + '-' + id);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + warning_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }

        function general_change_action_limit_type_old(compnent_id, index) {
            var action_limit_type = document.querySelector('select[name="action_limit_type_old-' + compnent_id + '-' +
                index +
                '"]').value;
            var action_limit = document.querySelector('input[name=action_limit_old-' + compnent_id + '-' + index + ']')
                .value;
            var action_limit_end = document.querySelector('input[name=action_limit_end_old-' + compnent_id + '-' + index +
                    ']')
                .value;
            if (action_limit_type == '=') {
                document.getElementById('action_limit_type_old-' + compnent_id + '-' + index).innerHTML = '= ' +
                    action_limit;
            } else if (action_limit_type == '>=') {
                document.getElementById('action_limit_type_old-' + compnent_id + '-' + index).innerHTML = '&ge; ' +
                    action_limit;
            } else if (action_limit_type == '<=') {
                document.getElementById('action_limit_type_old-' + compnent_id + '-' + index).innerHTML = '&le; ' +
                    action_limit;
            } else if (action_limit_type == '<') {
                document.getElementById('action_limit_type_old-' + compnent_id + '-' + index).innerHTML = '&lt; ' +
                    action_limit;
            } else if (action_limit_type == '>') {
                document.getElementById('action_limit_type_old-' + compnent_id + '-' + index).innerHTML = '&gt; ' +
                    action_limit;
            } else if (action_limit_type == '8646') {
                document.getElementById('action_limit_type_old-' + compnent_id + '-' + index).innerHTML = action_limit +
                    ' &#8646; ' +
                    action_limit_end;
                let elements = document.getElementsByName('action_limit_end_old-' + compnent_id + '-' + index);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + action_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }

        function general_change_warning_limit_type_old(compnent_id, index) {
            var warning_limit_type = document.querySelector('select[name=warning_limit_type_old-' + compnent_id + '-' +
                index +
                ']').value;
            var warning_limit = document.querySelector('input[name=warning_limit_old-' + compnent_id + '-' + index + ']')
                .value;
            var warning_limit_end = document.querySelector('input[name=warning_limit_end_old-' + compnent_id + '-' + index +
                ']').value;
            if (warning_limit_type == '=') {
                document.getElementById('warning_limit_type_old-' + compnent_id + '-' + index).innerHTML = '= ' +
                    warning_limit;
            } else if (warning_limit_type == '>=') {
                document.getElementById('warning_limit_type_old-' + compnent_id + '-' + index).innerHTML = '&ge; ' +
                    warning_limit;
            } else if (warning_limit_type == '<=') {
                document.getElementById('warning_limit_type_old-' + compnent_id + '-' + index).innerHTML = '&le; ' +
                    warning_limit;
            } else if (warning_limit_type == '<') {
                document.getElementById('warning_limit_type_old-' + compnent_id + '-' + index).innerHTML = '&lt; ' +
                    warning_limit;
            } else if (warning_limit_type == '>') {
                document.getElementById('warning_limit_type_old-' + compnent_id + '-' + index).innerHTML = '&gt; ' +
                    warning_limit;
            } else if (warning_limit_type == '8646') {
                document.getElementById('warning_limit_type_old-' + compnent_id + '-' + index).innerHTML = warning_limit +
                    ' &#8646; ' +
                    warning_limit_end;
                let elements = document.getElementsByName('warning_limit_end_old-' + compnent_id + '-' + index);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + warning_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }

        function add_general_change_action_limit_type_old(compnent_id, index, test_method_id) {
            var action_limit_type = document.querySelector('select[name="action_limit_type_old-' + test_method_id + '-' +
                compnent_id + '-' + index +
                '"]').value;
            var action_limit = document.querySelector('input[name=action_limit_old-' + test_method_id + '-' + compnent_id +
                '-' + index + ']').value;
            var action_limit_end = document.querySelector('input[name=action_limit_end_old-' + test_method_id + '-' +
                compnent_id +
                '-' + index + ']').value;
            if (action_limit_type == '=') {
                document.getElementById('action_limit_type_old-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML =
                    '= ' + action_limit;
            } else if (action_limit_type == '>=') {
                document.getElementById('action_limit_type_old-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML =
                    '&ge; ' +
                    action_limit;
            } else if (action_limit_type == '<=') {
                document.getElementById('action_limit_type_old-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML =
                    '&le; ' +
                    action_limit;
            } else if (action_limit_type == '<') {
                document.getElementById('action_limit_type_old-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML =
                    '&lt; ' +
                    action_limit;
            } else if (action_limit_type == '>') {
                document.getElementById('action_limit_type_old-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML =
                    '&gt; ' +
                    action_limit;
            } else if (action_limit_type == '8646') {
                document.getElementById('action_limit_type_old-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML =
                    action_limit + ' &#8646; ' +
                    action_limit_end;
                let elements = document.getElementsByName('action_limit_end_old-' + test_method_id + '-' + compnent_id +
                    '-' +
                    index);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + action_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }

        function add_general_change_warning_limit_type_old(compnent_id, index, test_method_id) {
            var warning_limit_type = document.querySelector('select[name=warning_limit_type_old-' + test_method_id + '-' +
                compnent_id + '-' + index + ']').value;
            var warning_limit = document.querySelector('input[name=warning_limit_old-' + test_method_id + '-' +
                compnent_id +
                '-' + index + ']').value;
            var warning_limit_end = document.querySelector('input[name=warning_limit_end_old-' + test_method_id + '-' +
                compnent_id +
                '-' + index + ']').value;

            if (warning_limit_type == '=') {
                document.getElementById('warning_limit_type_old-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML = '= ' + warning_limit;
            } else if (warning_limit_type == '>=') {
                document.getElementById('warning_limit_type_old-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML = '&ge; ' +
                    warning_limit;
            } else if (warning_limit_type == '<=') {
                document.getElementById('warning_limit_type_old-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML = '&le; ' +
                    warning_limit;
            } else if (warning_limit_type == '<') {
                document.getElementById('warning_limit_type_old-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML = '&lt; ' +
                    warning_limit;
            } else if (warning_limit_type == '>') {
                document.getElementById('warning_limit_type_old-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML = '&gt; ' +
                    warning_limit;
            } else if (warning_limit_type == '8646') {
                document.getElementById('warning_limit_type_old-' + test_method_id + '-' + compnent_id + '-' + index)
                    .innerHTML = warning_limit + ' &#8646; ' +
                    warning_limit_end;
                let elements = document.getElementsByName('warning_limit_end_old-' + test_method_id + '-' + compnent_id +
                    '-' +
                    index);
                if (elements.length > 0) {
                    elements[0].innerHTML = '> ' + warning_limit;
                    elements[0].classList.remove('d-none');
                }
            }
        }

        /**
         * Update action limit display for existing component
         * @param {string|number} componentId - Component ID
         */
        function only_one_general_change_action_limit_type_old(componentId) {
            try {
                const selectElement = document.querySelector(`select[name="action_limit_type_old[${componentId}]"]`);
                const limitInput = document.querySelector(`input[name="action_limit_old[${componentId}]"]`);
                const limitEndInput = document.querySelector(`input[name="action_limit_end_old[${componentId}]"]`);
                const displayElement = document.getElementById(`action_limit_type_old-${componentId}`);

                if (!selectElement || !limitInput || !displayElement) {
                    console.error('Missing elements for action limit type change:', componentId);
                    return;
                }

                const limitType = selectElement.value;
                const limit = limitInput.value;
                const limitEnd = limitEndInput ? limitEndInput.value : '';

                updateLimitDisplay(displayElement, limitType, limit, limitEnd, componentId, 'action');
            } catch (e) {
                console.error('Error in only_one_general_change_action_limit_type_old for component ' + componentId + ':',
                    e);
            }
        }

        /**
         * Update warning limit display for existing component
         * @param {string|number} componentId - Component ID
         */
        function only_one_general_change_warning_limit_type_old(componentId) {
            try {
                const selectElement = document.querySelector(`select[name="warning_limit_type_old[${componentId}]"]`);
                const limitInput = document.querySelector(`input[name="warning_limit_old[${componentId}]"]`);
                const limitEndInput = document.querySelector(`input[name="warning_limit_end_old[${componentId}]"]`);
                const displayElement = document.getElementById(`warning_limit_type_old-${componentId}`);

                if (!selectElement || !limitInput || !displayElement) {
                    console.error('Missing elements for warning limit type change:', componentId);
                    return;
                }

                const limitType = selectElement.value;
                const limit = limitInput.value;
                const limitEnd = limitEndInput ? limitEndInput.value : '';

                updateLimitDisplay(displayElement, limitType, limit, limitEnd, componentId, 'warning');
            } catch (e) {
                console.error('Error in only_one_general_change_warning_limit_type_old for component ' + componentId + ':',
                    e);
            }
        }

        /**
         * Update limit display based on type
         * @param {HTMLElement} displayElement - Element to update
         * @param {string} limitType - Limit type (=, >=, <=, <, >, 8646)
         * @param {string} limit - Limit value
         * @param {string} limitEnd - Limit end value (for range)
         * @param {string|number} componentId - Component ID
         * @param {string} limitKind - 'warning' or 'action'
         */
        function updateLimitDisplay(displayElement, limitType, limit, limitEnd, componentId, limitKind) {
            const limitTypeMap = {
                '=': '= ',
                '>=': '&ge; ',
                '<=': '&le; ',
                '<': '&lt; ',
                '>': '&gt; '
            };

            // Hide limit end input by default
            const endElements = document.getElementsByName(`${limitKind}_limit_end_old[${componentId}]`);
            if (endElements.length > 0) {
                endElements[0].classList.add('d-none');
            }

            if (!limitType || !limit) {
                displayElement.innerHTML = '{{ translate('not_set') }}';
                return;
            }

            if (limitType === '8646' && limit && limitEnd) {
                displayElement.innerHTML = limit + ' &#8646; ' + limitEnd;
                if (endElements.length > 0) {
                    endElements[0].classList.remove('d-none');
                }
            } else if (limitTypeMap[limitType]) {
                displayElement.innerHTML = limitTypeMap[limitType] + limit;
            } else {
                displayElement.innerHTML = '{{ translate('not_set') }}';
            }
        }
    </script>
    <script>
        function main_components_master(element, id) {

            var component_id = $(element).val();
            // var test_method_id = $(`select[name=test_method[${id}]`).val();
            var test_method_id = $(`select[name="test_method[${id}]"]`).val();
            // console.log(  id);
            if (component_id == -1) {
                $.ajax({
                    url: "{{ route('admin.sample.get_components_by_test_method', ':id') }}".replace(':id',
                        test_method_id),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            if (data && data.components && data.components.length > 0) {
                                //<input type="hidden" name="test_method_item_id[${component.id}]" value="${component.test_method_item_id}">

                                $(`#main_components_${id}`).empty();
                                console.log((`#main_components_${id}`));
                                $.each(data.components, function(index, component) {
                                    console.log(component);
                                    $(`#main_components_${id}`).append(`
                                        <div class="container mt-4">
                                        <label class="form-label">Components & Limits:</label>


                                        <div class="border border-primary rounded p-3 mb-3"
                                            style="background-color: #f8f9fa;">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <input type="checkbox" id="tds" value="${component.id}" name="component[${component.id}]" checked>
                                                    <label for="tds" class="fw-bold text-primary">${component.name}</label>
                                                </div>
                                                <div class="text-end text-primary fw-bold">Unit:${component.main_unit && component.main_unit.name ? component.main_unit.name : 'N/A'}</div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <label for="tds" class="fw-bold text-primary">{{ __('samples.warning_limit') }}</label>
                                                    <input type="number"  name="warning_limit[${component.id}]" class="form-control"     onkeyup="only_one_general_change_warning_limit_type(${component.id})">
                                                    <input type="number"  name="warning_limit_end[${component.id}]" class="form-control d-none"     onkeyup="only_one_general_change_warning_limit_type(${component.id})">
                                                </div>
                                                <div class="text-end text-primary fw-bold">
                                                     <label for="tds" class="fw-bold text-primary">{{ __('samples.action_limit') }}</label>
                                                    <input type="number"  name="action_limit[${component.id}]" class="form-control"     onkeyup="only_one_general_change_action_limit_type(${component.id} )">
                                                    <input type="number"  name="action_limit_end[${component.id}]" class="form-control d-none"     onkeyup="only_one_general_change_action_limit_type(${component.id} )">
                                                    </div>
                                            </div>
                                              <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <label for="tds" class="fw-bold text-primary">{{ __('samples.warning_limit_type') }}</label>
                                                      <select name="warning_limit_type[${component.id}]" class="form-control"   onchange="only_one_general_change_warning_limit_type(${component.id})">
                                                        <option value="">{{ __('samples.select_warning_limit_type') }}</option>
                                                            <option value="=">=</option>
                                                            <option value=">=">&ge;</option>
                                                            <option value="<=">&le;</option>
                                                            <option value="<">&lt;</option>
                                                            <option value=">">&gt;</option>
                                                            <option value="8646">&#8646;</option>

                                                    </select>
                                                </div>
                                                <div class="text-end text-primary fw-bold">
                                                     <label for="tds" class="fw-bold text-primary">{{ __('samples.action_limit_type') }}</label>

                                                    <select name="action_limit_type[${component.id}]" class="form-control"   onchange="only_one_general_change_action_limit_type(${component.id})">
                                                            <option value="">{{ __('samples.select_action_limit_type') }}</option>
                                                            <option value="=">=</option>
                                                            <option value=">=">&ge;</option>
                                                            <option value="<=">&le;</option>
                                                            <option value="<">&lt;</option>
                                                            <option value=">">&gt;</option>
                                                            <option value="8646">&#8646;</option>
                                                    </select>
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="p-3 rounded" style="background-color: #fff8dc;">
                                                        <small class="text-muted d-block">Warning Limit</small>
                                                        <span class="text-warning fw-bold" id="warning_limit_type[${component.id}]"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="p-3 rounded" style="background-color: #ffeeee;">
                                                        <small class="text-muted d-block">Action Limit</small>
                                                        <span class="text-danger fw-bold" id="action_limit_type[${component.id}]"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                      `);


                                });

                            }


                        } else {}
                    },
                    error: function(xhr, status, error) {
                        console.error('Error occurred:', error);
                    }
                });

            } else {
                $.ajax({
                    url: "{{ route('admin.sample.get_one_component_by_test_method', ':id') }}".replace(
                        ':id',
                        component_id),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                        if (data) {
                            if (data && data.component) {

                                $(`#main_components_${id}`).empty();

                                $(`#main_components_${id}`).append(`
                                        <div class="container mt-4">
                                        <label class="form-label">Components & Limits:</label>

                                        <div class="border border-primary rounded p-3 mb-3"
                                            style="background-color: #f8f9fa;">
                                            <input type="hidden" name="test_method_item_id[${data.component.id}]" value="${data.component.test_method_item_id}">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <input type="checkbox" id="tds" name="component[${data.component.id}]" checked>
                                                    <label for="tds" class="fw-bold text-primary">${data.component.name}</label>
                                                </div>
                                                <div class="text-end text-primary fw-bold">Unit:${data.component.main_unit && data.component.main_unit.name ? data.component.main_unit.name : 'N/A'}</div>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <label for="tds" class="fw-bold text-primary">{{ __('samples.warning_limit') }}</label>
                                                    <input type="number"  name="warning_limit[${data.component.id}]" class="form-control"     onkeyup="only_one_change_warning_limit_type(${data.component.id})">
                                                    <input type="number"  name="warning_limit_end[${data.component.id}]" class="form-control d-none"     onkeyup="only_one_change_warning_limit_type(${data.component.id})">
                                                </div>
                                                <div class="text-end text-primary fw-bold">
                                                     <label for="tds" class="fw-bold text-primary">{{ __('samples.action_limit') }}</label>
                                                    <input type="number"  name="action_limit[${data.component.id}]" class="form-control"     onkeyup="only_one_change_action_limit_type(${data.component.id})">
                                                    <input type="number"  name="action_limit_end[${data.component.id}]" class="form-control d-none"     onkeyup="only_one_change_action_limit_type(${data.component.id})">
                                                    </div>
                                            </div>
                                              <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div>
                                                    <label for="tds" class="fw-bold text-primary">{{ __('samples.warning_limit_type') }}</label>
                                                      <select name="warning_limit_type[${data.component.id}]" class="form-control"   onchange="only_one_change_warning_limit_type(${data.component.id})">
                                                        <option value="">{{ __('samples.select_warning_limit_type') }}</option>
                                                            <option value="=">=</option>
                                                            <option value=">=">&ge;</option>
                                                            <option value="<=">&le;</option>
                                                            <option value="<">&lt;</option>
                                                            <option value=">">&gt;</option>
                                                            <option value="8646">&#8646;</option>
                                                    </select>
                                                </div>
                                                <div class="text-end text-primary fw-bold">
                                                     <label for="tds" class="fw-bold text-primary">{{ __('samples.action_limit_type') }}</label>

                                                    <select name="action_limit_type[${data.component.id}]" class="form-control"   onchange="only_one_change_action_limit_type(${data.component.id})">
                                                            <option value="">{{ __('samples.select_action_limit_type') }}</option>
                                                            <option value="=">=</option>
                                                            <option value=">=">&ge;</option>
                                                            <option value="<=">&le;</option>
                                                            <option value="<">&lt;</option>
                                                            <option value=">">&gt;</option>
                                                            <option value="8646">&#8646;</option>
                                                    </select>
                                                    </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="p-3 rounded" style="background-color: #fff8dc;">
                                                        <small class="text-muted d-block">Warning Limit</small>
                                                        <span class="text-warning fw-bold"  id="warning_limit_type[${data.component.id}]"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="p-3 rounded" style="background-color: #ffeeee;">
                                                        <small class="text-muted d-block">Action Limit</small>
                                                        <span class="text-danger fw-bold" id="action_limit_type[${data.component.id}]"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                      `);

                            }


                        } else {}
                    },
                    error: function(xhr, status, error) {
                        console.error('Error occurred:', error);
                    }
                });
            }

        }
    </script>
    <script>
        /**
         * Initialize form data when page loads
         */
        $(document).ready(function() {
            /**
             * Initialize warning and action limits for existing components
             */
            function initializeLimits() {
                // Initialize warning limits
                $('select[name^="warning_limit_type_old["]').each(function() {
                    const selectElement = $(this);
                    const nameAttr = selectElement.attr('name');
                    const match = nameAttr.match(/warning_limit_type_old\[(\d+)\]/);

                    if (match && match[1]) {
                        const componentId = match[1];
                        if (componentId && typeof only_one_general_change_warning_limit_type_old ===
                            'function') {
                            try {
                                only_one_general_change_warning_limit_type_old(componentId);
                            } catch (e) {
                                console.error('Error initializing warning limit for component ' +
                                    componentId + ':', e);
                            }
                        }
                    }
                });

                // Initialize action limits
                $('select[name^="action_limit_type_old["]').each(function() {
                    const selectElement = $(this);
                    const nameAttr = selectElement.attr('name');
                    const match = nameAttr.match(/action_limit_type_old\[(\d+)\]/);

                    if (match && match[1]) {
                        const componentId = match[1];
                        if (componentId && typeof only_one_general_change_action_limit_type_old ===
                            'function') {
                            try {
                                only_one_general_change_action_limit_type_old(componentId);
                            } catch (e) {
                                console.error('Error initializing action limit for component ' +
                                    componentId + ':', e);
                            }
                        }
                    }
                });
            }

            // Initialize limits multiple times to ensure all elements are loaded
            initializeLimits();
            setTimeout(initializeLimits, 200);
            setTimeout(initializeLimits, 500);

            /**
             * Load initial form data
             */
            function loadInitialFormData() {
                const mainPlantId = $('select[name="main_plant_item"]').val();
                const subPlantId = $('select[name="sub_plant_item"]').val();
                const sampleSelect = $('select[name="sample_name"]');
                const sampleId = sampleSelect.val();
                const currentSampleText = sampleSelect.find('option:selected').text();

                if (!mainPlantId) {
                    return;
                }

                loadPlantData(mainPlantId, subPlantId, sampleId, currentSampleText);
            }

            /**
             * Load plant data (sub plants and samples)
             */
            function loadPlantData(mainPlantId, subPlantId, sampleId, currentSampleText) {
                $.ajax({
                    url: "{{ route('admin.sample.get_sub_from_plant', ':id') }}".replace(':id',
                        mainPlantId),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            // Clear and populate sub_plant_item
                            if (data && data.plants && data.plants.length > 0) {
                                var subSelect = $('select[name="sub_plant_item"]');
                                subSelect.empty().prop('disabled', false);
                                subSelect.append(
                                    '<option value="">{{ __('samples.select_sub_plant') }}</option>'
                                );

                                $.each(data.plants, function(index, plant) {
                                    var selected = (subPlantId && subPlantId == plant.id) ?
                                        'selected' : '';
                                    subSelect.append('<option value="' + plant.id + '" ' +
                                        selected + '>' + plant.name + '</option>');
                                });

                                // If sub plant is selected, load samples from sub plant
                                if (subPlantId) {
                                    loadSamplesFromSubPlant(subPlantId, sampleId, currentSampleText);
                                } else if (data.samples && data.samples.length > 0) {
                                    // Load samples from main plant
                                    sampleSelect.empty().prop('disabled', false);

                                    // Preserve current sample if it exists
                                    if (sampleId && currentSampleText) {
                                        var found = false;
                                        $.each(data.samples, function(index, sample) {
                                            if (sample.id == sampleId) {
                                                found = true;
                                            }
                                        });
                                        if (!found) {
                                            sampleSelect.append('<option value="' + sampleId +
                                                '" selected>' + currentSampleText + '</option>');
                                        }
                                    }

                                    $.each(data.samples, function(index, sample) {
                                        var selected = (sampleId && sampleId == sample.id) ?
                                            'selected' : '';
                                        sampleSelect.append('<option value="' + sample.id +
                                            '" ' + selected + '>' + sample.name +
                                            '</option>');
                                    });
                                } else if (sampleId && currentSampleText) {
                                    // No samples from AJAX, but we have a current value - keep it
                                    sampleSelect.empty().prop('disabled', false);
                                    sampleSelect.append('<option value="' + sampleId + '" selected>' +
                                        currentSampleText + '</option>');
                                }
                            } else if (data && data.samples && data.samples.length > 0) {
                                // No sub plants, but has samples directly from main plant
                                sampleSelect.empty().prop('disabled', false);

                                // Preserve current sample if it exists
                                if (sampleId && currentSampleText) {
                                    var found = false;
                                    $.each(data.samples, function(index, sample) {
                                        if (sample.id == sampleId) {
                                            found = true;
                                        }
                                    });
                                    if (!found) {
                                        sampleSelect.append('<option value="' + sampleId +
                                            '" selected>' + currentSampleText + '</option>');
                                    }
                                }

                                $.each(data.samples, function(index, sample) {
                                    var selected = (sampleId && sampleId == sample.id) ?
                                        'selected' : '';
                                    sampleSelect.append('<option value="' + sample.id + '" ' +
                                        selected + '>' + sample.name + '</option>');
                                });
                            } else if (sampleId && currentSampleText) {
                                // No data from AJAX, but we have a current value - keep it
                                sampleSelect.empty().prop('disabled', false);
                                sampleSelect.append('<option value="' + sampleId + '" selected>' +
                                    currentSampleText + '</option>');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading plant data:', error);
                        // On error, keep the current values
                        if (sampleId && currentSampleText) {
                            sampleSelect.empty().prop('disabled', false);
                            sampleSelect.append('<option value="' + sampleId + '" selected>' +
                                currentSampleText + '</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading plant data:', error);
                        preserveCurrentSample(sampleId, currentSampleText);
                    }
                });
            }

            /**
             * Preserve current sample value on error
             */
            function preserveCurrentSample(sampleId, currentSampleText) {
                if (sampleId && currentSampleText) {
                    const sampleSelect = $('select[name="sample_name"]');
                    sampleSelect.empty().prop('disabled', false);
                    sampleSelect.append('<option value="' + sampleId + '" selected>' + currentSampleText +
                        '</option>');
                }
            }

            // Load initial form data
            loadInitialFormData();
        });

        /**
         * Helper function to load samples from sub plant
         */
        function loadSamplesFromSubPlant(subPlantId, sampleId, currentSampleText) {
            $.ajax({
                url: "{{ route('admin.sample.get_sample_from_plant', ':id') }}".replace(':id', subPlantId),
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var sampleSelect = $('select[name="sample_name"]');
                    sampleSelect.empty().prop('disabled', false);

                    if (data && data.samples && data.samples.length > 0) {
                        // Preserve current sample if it exists
                        if (sampleId && currentSampleText) {
                            var found = false;
                            $.each(data.samples, function(index, sample) {
                                if (sample.id == sampleId) {
                                    found = true;
                                }
                            });
                            if (!found) {
                                sampleSelect.append('<option value="' + sampleId + '" selected>' +
                                    currentSampleText + '</option>');
                            }
                        }

                        $.each(data.samples, function(index, sample) {
                            var selected = (sampleId && sampleId == sample.id) ? 'selected' : '';
                            sampleSelect.append('<option value="' + sample.id + '" ' + selected + '>' +
                                sample.name + '</option>');
                        });
                    } else if (sampleId && currentSampleText) {
                        // No samples from AJAX, but we have a current value - keep it
                        sampleSelect.append('<option value="' + sampleId + '" selected>' + currentSampleText +
                            '</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading samples:', error);
                    // On error, keep the current value
                    var sampleSelect = $('select[name="sample_name"]');
                    if (sampleId && currentSampleText) {
                        sampleSelect.empty().prop('disabled', false);
                        sampleSelect.append('<option value="' + sampleId + '" selected>' + currentSampleText +
                            '</option>');
                    }
                }
            });
        }
    </script>
@endsection
