@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ __('roles.' . $route . '_management') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.' . $route . '_management') }}</h4>
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

    <div class="col-md-12 mb-3">
        <div class="card">
            <div class="card-header">
                {{ __('roles.create_plant') }}
            </div>
            <div class="card-body" style="text-align: {{ Session::get('locale') === 'ar' ? 'right' : 'left' }};">
                <form action="{{ route('admin.plant.store') }}" method="post">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-sm-8 col-md-6 col-lg-6">
                            <div class="form-group">
                                <input type="hidden" id="id">
                                <label class="title-color" for="name">{{ __('roles.name') }}<span
                                        class="text-danger">*</span> </label>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6   col-lg-6">
                            <div class="form-group">
                                <label for="">{{ __('samples.main_plant_name') }} <span
                                        class="text-danger">*</span></label>
                                <select name="plant_id" class="form-control"  >
                                    <option value="">{{ __('samples.select_plant') }}</option>
                                    @foreach ($plant_master as $plant_item)
                                        <option value="{{ $plant_item->id }}">{{ $plant_item->name }}</option>
                                    @endforeach
                                </select>
                                @error('plant_id')
                                    <span class="error text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary">{{ __('general.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <form action="" method="get">

        <div class="col-12">
     
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input class="bulk_check_all" type="checkbox" /></th>
                            <th class="text-center" scope="col">{{ __('roles.name') }}</th>
                            <th class="text-center" scope="col">{{ __('samples.main_plant_name') }}</th> 
                            <th class="text-center" scope="col">{{ __('roles.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @forelse ($main as $main_item)
                            <tr>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                            value="{{ $main_item->id }}" />
                                        <span class="text-muted">#{{ $loop->index + 1 }}</span>
                                    </label>
                                </th>

                                <td class="text-center">{{ $main_item->name }}</td>
                                @if ($main_item->plant_id != null) 
                                    <td class="text-center">{{ $main_item->mainPlant->name }}</td>
                                @else
                                    <td class="text-center">Master</td>
                                    
                                @endif 
                                <td class="text-center">
                                    @can('delete_' . $route . '')
                                        <a href="{{ route('admin.' . $route . '.delete', $main_item->id) }}"
                                            class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i
                                                class="fa fa-trash"></i></a>
                                    @endcan
                                    @can('edit_' . $route . '')
                                        <a href="{{ route('admin.' . $route . '.edit', $main_item->id) }}"
                                            class="btn btn-outline-info btn-sm" title="@lang('dashboard.edit')"><i
                                                class="mdi mdi-pencil"></i> </a>
                                    @endcan
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">@lang('No data found')</td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </form>
@endsection
