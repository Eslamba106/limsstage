@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ __('samples.master_samples') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('samples.master_samples') }}</h4>
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
                {{ __('samples.create_master_sample') }}
            </div>
            <div class="card-body" style="text-align: {{ Session::get('locale') === 'ar' ? 'right' : 'left' }};">
                <form action="{{ route('admin.master_sample.store') }}" method="post">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-sm-8 col-md-4 col-lg-4">
                            <div class="form-group">
                                <input type="hidden" id="id">
                                <label class="title-color" for="name">{{ __('roles.name') }}<span
                                        class="text-danger">*</span> </label>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4   col-lg-4">
                            <div class="form-group">
                                <label for="">{{ __('samples.main_plant_name') }} <span
                                        class="text-danger">*</span></label>
                                <select name="plant_id" class="form-control">
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
                        <div class="col-md-4   col-lg-4">
                            <div class="form-group">
                                <label for="">{{ __('samples.sub_plant_name') }} </label>
                                <select name="sub_plant_id" class="form-control">
                                    <option value="">{{ __('samples.select_plant') }}</option>
                                </select>
                                @error('sub_plant_id')
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
                            <th class="text-center" scope="col">{{ __('samples.plant') }}</th>
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
                                <td class="text-center">{{ $main_item->mainPlant->name }}</td>

                                <td class="text-center">
                                    @can('delete_plant' )
                                        <a href="{{ route('admin.' . $route . '.delete', $main_item->id) }}"
                                            class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i
                                                class="fa fa-trash"></i></a>
                                    @endcan
                                    @can('edit_plant')
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
@section('js')
    <script>
        $(document).ready(function() {
            $('.bulk_check_all').on('click', function() {
                $('.check_bulk_item').prop('checked', this.checked);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('select[name="plant_id"]').on('change', function() {
                var plantId = $(this).val();
                if (plantId) {
                    $.ajax({
                        url: "{{ route('admin.plant.get_sub_plants') }}",
                        type: "GET",
                        data: {
                            plant_id: plantId
                        },
                        success: function(data) {
                            $('select[name="sub_plant_id"]').empty();
                            if (data.sub_plants.length > 0) {
                                 $('select[name="sub_plant_id"]').append(
                                    '<option value="">{{ __('samples.select_plant') }}</option>'
                                    );
                                $.each(data.sub_plants, function(key, value) {
                                    $('select[name="sub_plant_id"]').append(
                                        '<option value="' + value.id + '">' + value
                                        .name +
                                        '</option>');
                                });
                            } else {
                                $('select[name="sub_plant_id"]').empty();
                                $('select[name="sub_plant_id"]').append(
                                    '<option value="">{{ __('samples.select_plant') }}</option>'
                                    );
                            }

                        }
                    });
                } else {
                    $('select[name="sub_plant_id"]').empty();
                    $('select[name="sub_plant_id"]').append(
                        '<option value="">{{ __('samples.select_plant') }}</option>');
                }
            });
        });
    </script>
@endsection
