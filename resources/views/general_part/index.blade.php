@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ translate($route) }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate($route) }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ translate('home') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ translate('dashboard') }}</li>
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
                    <div class="input-group mb-3 d-flex justify-content-end">




                        @can('create_unit')
                            <div class="m-2">
                                <a href="" class="btn btn-sm btn-outline-primary mr-2" href="#" data-add_unit=""
                                    data-toggle="modal" data-target="#add_unit">{{ translate('create_' . $route) }}</a>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input class="bulk_check_all" type="checkbox" /></th>
                            <th class="text-center" scope="col">
                                @if ($route == 'email')
                                    {{ translate('email') }}
                                @else
                                    {{ translate('name') }}
                                @endif
                            </th>
                            @if ($route == 'frequency')
                                <th class="text-center" scope="col">{{ translate('time_by_hours') }} </th>
                            @endif
                            <th class="text-center" scope="col">{{ translate('Actions') }}</th>
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

                                <td class="text-center">
                                    @if ($route == 'email')
                                        {{ $main_item->email }}
                                    @else
                                        {{ $main_item->name }}
                                    @endif
                                </td>
                                @if ($route == 'frequency')
                                    <td class="text-center">{{ $main_item->time_by_hours }} H</td>
                                @endif
                                <td class="text-center">
                                    @can('delete_' . $route)
                                        <a href="{{ route('admin.' . $route . '.delete', $main_item->id) }}"
                                            class="btn btn-danger btn-sm" title="{{ translate('delete') }}"><i
                                                class="fa fa-trash"></i></a>
                                    @endcan
                                    @can('edit_' . $route)
                                        <a href="{{ route('admin.' . $route . '.edit', $main_item->id) }}"
                                            class="btn btn-outline-info btn-sm" title="{{ translate('edit') }}"><i
                                                class="mdi mdi-pencil"></i> </a>
                                    @endcan
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">{{ translate('No_data_found') }}</td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </form>

    <div class="modal fade" id="add_unit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('create_' . $route) }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <form action="{{ route('admin.' . $route . '.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-md-6 col-lg-12 col-xl-12">
                                                    {{-- {{ dd($route) }} --}}
                                                    <div class="form-group">
                                                        <label for="">
                                                            @if ($route == 'email')
                                                                {{ translate('email') }}
                                                            @else
                                                                {{ translate('name') }}
                                                            @endif
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" name="name" class="form-control" />

                                                        @error('name')
                                                            <span class="error text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                @if ($route == 'frequency')
                                                    <div class="col-md-6 col-lg-12 col-xl-12">

                                                        <div class="form-group">
                                                            <label for="">{{ translate('time_by_hours') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="number" name="time_by_hours"
                                                                class="form-control" />

                                                            @error('time_by_hours')
                                                                <span class="error text-danger">{{ $error }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endif
                                            {{-- متعة لا تخلو من الازعاج لانه المتعه وحدها بدون وتنبيه للعقل هي تخدير  --}}
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
