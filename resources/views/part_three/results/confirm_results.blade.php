@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ __('roles.result_managment') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.result_managment') }}</h4>
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

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><input class="bulk_check_all" type="checkbox" /></th>
                                <th class="text-center" scope="col">{{ translate('sample_id')  }}</th>
                                <th class="text-center" scope="col">{{ translate('plant') }} </th>
                                <th class="text-center" scope="col">{{ translate('last_change_by') }} </th>
                                <th class="text-center" scope="col">{{ translate('Actions')  }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                            value="{{ $result->id }}" />
                                    </label>
                                </th>
                                <td class="text-center">{{ $result->submission->submission_number }} </td>
                                <td class="text-center">
                                    {{ optional(optional($result->submission)->plant)->name . ' - ' . optional($result->plant_sample)->name }}
                                </td>
                                <td class="text-center">{{ optional($result->user)->name }} </td>
                                <td class="text-center">
                                    @can('edit_result')
                                        <a href="{{ route('admin.result.edit', $result->id) }}"
                                            class="btn btn-outline-info btn-sm" title="@lang('dashboard.edit')"><i
                                                class="mdi mdi-pencil"></i> </a>
                                    @endcan
                                    @if ($result->status == 'pending')
                                        
                                    
                                    @can('edit_result')
                                        <a href="{{ route('admin.result.approve_confirm_results', $result->id) }}"
                                            class="btn btn-outline-success btn-sm" title="@lang('results.confirm_results')"><i
                                                class="mdi mdi-check"></i> </a>
                                    @endcan
                                    @can('edit_result')
                                        <a href="{{ route('admin.result.cancel_confirm_results', $result->id) }}"
                                            class="btn btn-outline-danger btn-sm" title="@lang('results.confirm_results')"><i
                                                class="mdi mdi-close"></i> </a>
                                    @endcan
                                    @endif
                                </td>



                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @foreach ($result->result_test_method_items as $result_test_method)
        <div class="row gx-2 gy-3 m-2">
            <div class="col-lg-12 col-xl-12">
                <!-- Card -->
                <div class="card h-100">
                    <!-- Body -->
                    <div class="card-header">
                        <div class="d-flex gap-2">
                            <h4 class="mb-0">
                                {{ $result_test_method->test_method->name }}
                            </h4>
                        </div>
                    </div>
                    <div class="card-body bg-light">
                        <input type="hidden" name="sample_test_method_id[]" {{-- value="{{ $item_test_method->sample_test_method->id }}" --}}>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">{{ translate('component')  }}</th>
                                        <th class="text-center" scope="col">{{ translate('unit') }} </th>
                                        <th class="text-center" scope="col">{{ translate('result') }} </th>
                                        <th class="text-center" scope="col">{{ translate('warning_limit') }}</th>
                                        <th class="text-center" scope="col">{{ translate('action_limit') }}</th>
                                        <th class="text-center" scope="col">{{ translate('status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- {{dd($result_test_method)}} --}}
                                    @foreach ($result_test_method->result_test_method_items as $result_test_method_item)
                                        <tr>
                                            <td class="text-center">
                                                {{ $result_test_method_item->main_test_method_item->name }} </td>
                                          
                                            <td class="text-center">
                                                {{ $result_test_method_item->main_test_method_item->main_unit->name }}
                                            </td>
                                              <td class="text-center">
                                                {{ $result_test_method_item->result }} </td>
                                            <td class="text-center">
                                                {{ get_warning_limit_and_type(  $result_test_method_item->test_method_item_id) }} </td>
                                            <td class="text-center">
                                                {{ get_action_limit_and_type(  $result_test_method_item->test_method_item_id) }} </td>
                                                @php
                                                    $result_status = getStatus( $result_test_method_item->result ,$result_test_method_item->test_method_item_id)
                                                @endphp
                                            <td class="text-center @if ($result_status == 'warning')
                                                text-warning @elseif($result_status == 'danger') text-danger
                                            @endif">
                                                {{ getStatus( $result_test_method_item->result ,$result_test_method_item->test_method_item_id) }} </td>
                                            <td class="text-center">
                                                {{ $result_test_method_item->main_test_method_item->action_limit }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End Body -->
                    @if (test_method_result($result_test_method->id) == 'pending')
                        <div class="card-footer">
                            <div class="d-flex justify-content-end">
                                @can('edit_result')
                                    <a href="{{ route('admin.result.approve_confirm_results_by_item', $result_test_method->id) }}"
                                        class="btn-outline-success mr-2 ml-2" title="@lang('results.confirm_results')"><i
                                            class="mdi mdi-check  mdi-24px   "></i> </a>
                                @endcan
                                @can('edit_result')
                                    <a href="{{ route('admin.result.cancel_confirm_results_by_item', $result_test_method->id) }}"
                                        class="btn-outline-danger mr-2 ml-2" title="@lang('results.cancel_results')"><i
                                            class="mdi mdi-close mdi-24px"></i> </a>
                                @endcan
                            </div>
                        </div>
                    @endif
                </div>
                <!-- End Card -->
            </div>
        </div>
    @endforeach
@endsection
