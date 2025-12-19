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

    <form action="" method="get">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 col-lg-3 col-xl-3">
                            <label for="">
                                {{ translate('sample_id') }}
                            </label>
                            <input type="text" name="sample_id" class="form-control ">

                        </div>
                        <div class="col-md-12 col-lg-3 col-xl-3">
                            <label for="">
                                {{ translate('sample_Name') }}
                            </label>
                            <input type="text" name="sample_name" class="form-control ">

                        </div>
                        <div class="col-md-12 col-lg-3 col-xl-3">
                            <label for="">
                                {{ translate('Plant') }}
                            </label>
                            <select name="plant_id" class="form-control">
                                <option value="">{{ translate('select_plant')}}</option>
                                @foreach ($plants as $plant_item)
                                    
                                <option value="{{ $plant_item->id }}">{{ $plant_item->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-12 col-lg-3 col-xl-3">
                            <label for="">
                                {{ translate('priority') }}
                            </label>
                            <select name="priority" class="form-control">
                                <option value="">{{ translate('select_priority')}}</option> 
                                <option value="normal">{{ translate('normal') }}</option> 
                                <option value="critical">{{ translate('critical') }}</option> 
                                <option value="high">{{ translate('high') }}</option> 
                            </select>

                        </div>
                        <div class="col-md-12 col-lg-3 col-xl-3">
                            <label for="">
                                {{ translate('Collection_Date') }}
                            </label>
                            <input type="date" name="collection_date" class="form-control ">

                        </div>
                    </div>
                    <div class="input-group mb-3 d-flex justify-content-end">


                        <button type="submit" class="btn btn-primary px-4 m-2" name="bulk_action_btn" value="filter">
                            {{ translate('filter') }}</button>

                        @can('change_results_role')
                            <div class="remv_control mr-2">
                                <select name="role" class="mr-3 mt-3 form-control">
                                    <option value="">{{ __('roles.set_role') }}</option>
                                    <option value="pending">{{ $item_role->name }}</option>
                                </select>
                            </div>


                            <button type="submit" name="bulk_action_btn" value="update_status"
                                class="btn btn-primary mt-3 mr-2">
                                <i class="la la-refresh"></i> {{ __('dashboard.update') }}
                            </button>
                        @endcan
                        @can('delete_result')
                            <button type="submit" name="bulk_action_btn" value="delete"
                                class="btn btn-danger delete_confirm mt-3 mr-2"> <i class="la la-trash"></i>
                                {{ __('dashboard.delete') }}</button>
                        @endcan

                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input class="bulk_check_all" type="checkbox" /></th>
                            <th class="text-center" scope="col">{{ __('samples.sample_id') }}</th>
                            <th class="text-center" scope="col">@lang('results.collection_date')</th>
                            <th class="text-center" scope="col">@lang('samples.plant')</th>
                            <th class="text-center" scope="col">@lang('results.sample_point')</th>
                            <th class="text-center" scope="col">@lang('roles.status')</th>
                            <th class="text-center" scope="col">@lang('results.priority')</th>
                            <th class="text-center" scope="col">{{ __('roles.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($results as $result_item)
                            <tr>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                            value="{{ $result_item->id }}" />
                                        <span class="text-muted">#{{ $loop->index + 1 }}</span>
                                    </label>
                                </th>
                                <td class="text-center">{{ $result_item->submission->submission_number }} </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($result_item->sampling_date_and_time)->format('M d, Y h:i A') }}
                                </td>
                                {{-- {{ dd($result_item->new_sample_main) }} --}}
                                <td class="text-center">{{ $result_item->plant->name }} </td>
                                <td class="text-center">{{ optional(optional($result_item->sample)->sample_plant)->name }}
                                </td>
                                {{-- <td class="text-center">{{ $result_item->status  }} </td>
                                <td class="text-center">{{ $result_item->priority  }} </td> --}}
                                <td class="text-center">
                                    @php
                                        $statusColors = [
                                            'in progress' => 'bg-warning text-dark',
                                            'pending' => 'bg-secondary text-white',
                                            'completed' => 'bg-success text-white',
                                        ];
                                    @endphp
                                    <span class="badge {{ $statusColors[$result_item->status] ?? 'bg-yellow text-dark' }}">
                                        {{ $result_item->status }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    @php
                                        $priorityColors = [
                                            'high' => 'bg-danger text-white',
                                            'normal' => 'bg-primary text-white',
                                            'low' => 'bg-info text-dark',
                                        ];
                                    @endphp
                                    <span
                                        class="badge {{ $priorityColors[$result_item->priority] ?? 'bg-light text-dark' }}">
                                        {{ $result_item->priority }}
                                    </span>
                                </td>



                                <td class="text-center">
                                    @can('delete_result')
                                        <a href="{{ route('admin.result.delete', $result_item->id) }}"
                                            class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i
                                                class="fa fa-trash"></i></a>
                                    @endcan
                                    {{-- @can('edit_result')
                                        <a href="{{ route('admin.result.edit', $result_item->id) }}"
                                            class="btn btn-outline-info btn-sm" title="@lang('dashboard.edit')"><i
                                                class="mdi mdi-pencil"></i> </a>
                                    @endcan --}}
                                    @if ($result_item->status == 'pending')
                                        @can('edit_result')
                                            <a href="{{ route('admin.result.confirm_results', $result_item->id) }}"
                                                class="btn btn-outline-success btn-sm" title="@lang('results.confirm_results')"><i
                                                    class="mdi mdi-check"></i> </a>
                                        @endcan
                                    @endif
                                    @can('edit_result')
                                        <a href="{{ route('admin.result.review', $result_item->id) }}"
                                            class="btn btn-outline-success btn-sm" title="@lang('results.confirm_results')"><i
                                                class="mdi mdi-file"></i> </a>
                                    @endcan
                                    <a href="" class="btn btn-sm btn-outline-primary mr-2" href="#"
                                        id="export_result" data-export="" data-toggle="modal"
                                        data-id="{{ $result_item->id }}"
                                        data-target="#export">{{ translate('export') }}</a>
                                </td>
                            </tr>
                        @empty
                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </form>

    <div class="modal fade" id="export" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('export_certificate') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form action="{{ route('certificate.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-md-6 col-lg-12 col-xl-12">
                                                    <input type="hidden" name="result_id">
                                                    <div class="form-group">
                                                        <label for="">{{ translate('client_name') }} <span
                                                                class="text-danger">*</span></label>
                                                        {{-- <input type="text" name="name" class="form-control" /> --}}
                                                        <select name="client_id" class="form-control">
                                                            @foreach ($clients as $client_item)
                                                                <option value="{{ $client_item->id }}">
                                                                    {{ $client_item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('name')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group mt-2"
                                                style="text-align: {{ Session::get('locale') == 'en' ? 'right;margin-right:10px' : 'left;margin-left:10px' }}">
                                                <button type="submit"
                                                    class="btn btn-primary mt-2">{{ translate('save') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).on('click', '#export_result', function() {
            var result_id = $(this).data('id');
            $('input[name="result_id"]').val(result_id);
        });
    </script>
@endsection
