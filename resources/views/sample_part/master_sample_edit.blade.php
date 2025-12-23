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
                <form action="{{ route('admin.master_sample.update' , $main->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row align-items-center">
                        <div class="col-sm-8 col-md-4 col-lg-4">
                            <div class="form-group">
                                <input type="hidden" id="id">
                                <label class="title-color" for="name">{{ __('roles.name') }}<span
                                        class="text-danger">*</span> </label>
                                <input type="text" name="name" required value="{{ $main->name }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4   col-lg-4">
                            <div class="form-group">
                                <label for="">{{ __('samples.main_plant_name') }} <span
                                        class="text-danger">*</span></label>
                                <select name="plant_id" class="form-control" required>
                                    <option value="">{{ __('samples.select_plant') }}</option>
                                    @foreach ($plant_master as $plant_item)
                                        <option value="{{ $plant_item->id }}" {{ ($main->plant_id == $plant_item->id ) ? 'selected' : '' }}>{{ $plant_item->name }}</option>
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
                                    @foreach ($sub_plants as $sub_plant_item) 
                                        <option value="{{ $sub_plant_item->id }}" {{ ($main->plant_id == $sub_plant_item->id ) ? 'selected' : '' }}>{{ $sub_plant_item->name }}</option>
                                        
                                    @endforeach
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
@endsection
@section('js') 
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
