@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale');
    
    $currentUrl = url()->current();
    $segments = explode('/', $currentUrl);
    $submission = $segments[count($segments) - 2];
    ?>

    {{ translate('submission_managment') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('submission_managment') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ translate('home') }} </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ translate('dashboard') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div style="  display: flex; justify-content: center ">
        <div class="d-flex flex-wrap gap-10 justify-content-between mb-4">
            <div class="d-flex flex-column  gap-10">

                <div class="d-flex justify-content-between align-items-center" style="gap: 20px;">
                    <p class="text-capitalize mb-0">
                        {{ translate('sample_id') }} : {{ $sample->submission_number }}
                    </p>
                    <p class="text-capitalize mb-0">
                        {{ translate('collection_date') }} :
                        {{ \Carbon\Carbon::parse($sample->sampling_date_and_time)->format('M d, Y h:i A') }}
                    </p>
                </div>

                <div class="">
                    <i class="tio-date-range"></i>
                </div>
            </div>

        </div>
    </div>

    <form action="{{ route('admin.result.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        {{-- {{ dd($sample->master_sample) }} --}}
        <input type="hidden" name="sample_id" value="{{ $sample->master_sample->id }}">
        <input type="hidden" name="submission_id" value="{{ $sample->id }}">
        @foreach ($sample->submission_test_method_items as $item_test_method)
            <div class="row gx-2 gy-3 m-2">
                <div class="col-lg-8 col-xl-9">
                    <!-- Card -->
                    <div class="card h-100">
                        <!-- Body -->
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4 class="mb-0">{{ $item_test_method->sample_test_method->master_test_method->name }}
                                </h4>
                            </div>
                        </div>
                        <input type="hidden" name="sample_test_method_items[]"
                            value="{{ $item_test_method->sample_test_method->master_test_method->id }}">
                        <div class="card-body bg-light">
                            <input type="hidden" name="sample_test_method_id[]"
                                value="{{ $item_test_method->sample_test_method->id }}">
                            <hr>

                            @foreach ($item_test_method->sample_test_method->sample_test_method_items as $sample_test_method_item)
                                {{-- @foreach ($item_test_method->sample_test_method as $sample_test_method_item)  --}}
                                <div class="row">
                                    <div class="col-md-6 col-lg-2 col-xl-3">
                                        <span class="title-color break-all"> {{ translate('component') }} :
                                            <strong> </strong></span>

                                        <div class="form-group">
                                            <input type="text" class="form-control" style="border-radius: 5%" readonly
                                                value="{{ $sample_test_method_item->test_method_item->name }}">
                                            <input type="text" class="form-control" style="border-radius: 5%"
                                                name="test_method_items[]" hidden readonly
                                                value="{{ $sample_test_method_item->test_method_item->id }}">

                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <span class="title-color break-all"> {{ translate('result') }} :
                                            <strong> </strong></span>

                                        <div class="form-group">
                                            <input type="text" class="form-control" style="border-radius: 5%"
                                                name="result-{{ $sample_test_method_item->test_method_item->id . '-' . $item_test_method->sample_test_method->master_test_method->id }}"
                                                id="result-{{ $sample_test_method_item->id }}" >
                                        </div>
                                        @error("result-{{ $sample_test_method_item->test_method_item->id }}")
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-md-3 col-lg-2 col-xl-3">
                                        <span class="title-color break-all"> {{ translate('unit') }} :
                                            <strong> </strong></span>
                                        @php
                                            $main_unit = $units->find($sample_test_method_item->test_method_item->unit);
                                        @endphp
                                        <div class="form-group">
                                            <input type="text" class="form-control" readonly
                                                value="{{ optional($main_unit)->name }}">
                                        </div>
                                        @error("result-{{ $sample_test_method_item->test_method_item->id }}")
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    {{-- <div class="col-md-3 col-lg-2 col-xl-3">
                                        <span class="title-color break-all"> {{ translate('roles.status') }} :
                                            <strong> </strong></span>

                                        <span class="badge bg-success"><i class="fa-solid fa-check-circle me-1"></i>
                                            {{ translate('results.in_range') }}</span>
                                        {{-- <span class="badge bg-danger"><i class="fa-solid fa-xmark-circle me-1"></i>
                                        {{ translate('results.out_of_range') }}</span> 
                                    </div> --}}



                                </div>
                            @endforeach

                        </div>
                        <!-- End Body -->
                    </div>
                    <!-- End Card -->
                </div>

                <div class="col-lg-4 col-xl-3">
                    <!-- Card -->
                    <div class="card">

                        <!-- Body -->
                        @if ($sample)
                            @foreach ($item_test_method->sample_test_method->sample_test_method_items as $sample_test_method_item)
                                <div class="card-body d-none" id="card-{{ $sample_test_method_item->id }}">


                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="p-3 rounded" style="background-color: #fff8dc;">
                                                <small class="text-muted d-block">Warning Limit</small>
                                                <span class="text-warning fw-bold"
                                                    id="warning_limit_type-{{ $sample_test_method_item->id }}">
                                                    @if ($sample_test_method_item->warning_limit_type == '8646')
                                                        {{ $sample_test_method_item->warning_limit . '     ' }}&#8646;{{ '     ' . $sample_test_method_item->warning_limit_end }}
                                                    @else
                                                        {{ $sample_test_method_item->warning_limit_type . ' ' . $sample_test_method_item->warning_limit }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <div class="p-3 rounded" style="background-color: #ffeeee;">
                                                <small class="text-muted d-block">Action Limit</small>
                                                <span class="text-danger fw-bold"
                                                    id="action_limit_type-{{ $sample_test_method_item->id }}">
                                                    @if ($sample_test_method_item->action_limit_type == '8646')
                                                        {{ $sample_test_method_item->action_limit . '    ' }} &#8646;
                                                        {{ '    ' . $sample_test_method_item->action_limit_end }}
                                                    @else
                                                        {{ $sample_test_method_item->action_limit_type . ' ' . $sample_test_method_item->action_limit }}
                                                    @endif

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="card-body">
                                <div class="media align-items-center">
                                    <span>{{ translate('user_not_found') }}</span>
                                </div>
                            </div>
                        @endif
                        <!-- End Body -->

                    </div>
                    <!-- End Card -->
                </div>
            </div>
        @endforeach

        <div class="row gx-2 gy-3 m-2">
            <div class="col-lg-6 col-xl-6">
                <div class="from-group">
                    <label for="">{{ translate('internal_comment') }}</label>
                    <textarea name="internal_comment" class="form-control"
                        placeholder="{{ translate('add_internal_notes_visible_only_to_lab_staff') }}"></textarea>
                </div>
            </div>
            <div class="col-lg-6 col-xl-6">
                <div class="from-group">
                    <label for="">{{ translate('external_comment') }}</label>
                    <textarea name="external_comment" class="form-control"
                        placeholder="{{ translate('add_comments_visibley_to_clients') }}"></textarea>
                </div>
            </div>
        </div>
        <div>
            <div class="form-group mt-2"
                @if (session()->get('locale') == 'ar') style="text-align: left;" @else style="text-align: right;" @endif>
                <button type="submit" class="btn btn-primary mt-2">{{ translate('add_result') }}</button>
            </div>
        </div>
    </form>
    {{-- <div class="col-lg-12 col-xl-12">
        <!-- Card -->
        <div class="card">
            <div class="card-header">
                <h4>{{ translate('results.recent_results') }}</h4>
            </div>
            <div class="card-body ">


                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><input class="bulk_check_all" type="checkbox" /></th>
                                        <th class="text-center" scope="col">{{ translate('samples.sample_id') }}</th>
                                        <th class="text-center" scope="col">@lang('results.collection_date')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recent_results as $recent_results_item)
                                        @foreach ($recent_results_item->result_test_method_items as $result_test_method_item)
                                        
                                        <tr>
                                            <th scope="row">
                                                <label>
                                                    <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                                        value="{{ $recent_results_item->id }}" />
                                                    <span class="text-muted">#{{ $loop->index + 1 }}</span>
                                                </label>
                                            </th>
                                            <td class="text-center">
                                                {{ $result_test_method_item->result }}
                                            </td>
                                            <td class="text-center">

                                            </td>
                                        </tr>
                                        @endforeach
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('input[id^="result-"]').on('focus', function() {
                var inputId = $(this).attr('id');
                var uniqueId = inputId.split('-')[1];
                $('#card-' + uniqueId).removeClass('d-none');
            });
            $('input[id^="result-"]').on('blur', function() {
                var inputId = $(this).attr('id');
                var uniqueId = inputId.split('-')[1];
                $('#card-' + uniqueId).addClass('d-none');
            });

        });
    </script>
@endsection
