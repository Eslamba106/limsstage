@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>
    {{ __('roles.submission_managment') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.submission_managment') }}</h4>
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
                    <div class="input-group mb-3 d-flex justify-content-end">

                        @can('change_submissions_role')
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
                        @can('delete_submission')
                            <button type="submit" name="bulk_action_btn" value="delete"
                                class="btn btn-danger delete_confirm mt-3 mr-2"> <i class="la la-trash"></i>
                                {{ __('dashboard.delete') }}</button>
                        @endcan
                        @can('create_submission')
                            <a href="{{ route('admin.submission.create') }}" class="btn btn-secondary mt-3 mr-2">
                                <i class="la la-refresh"></i> {{ __('dashboard.create') }}
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input class="bulk_check_all" type="checkbox" /></th>
                            <th class="text-center" scope="col">{{ translate('sample_id') }}</th>
                            {{-- <th class="text-center" scope="col">{{ translate('barcode') }}</th> --}}
                            <th class="text-center" scope="col">{{ translate('collection_date') }}</th>
                            <th class="text-center" scope="col">{{ translate('plant') }}</th>
                            <th class="text-center" scope="col">{{ translate('sample_point') }}</th>
                            <th class="text-center" scope="col">{{ translate('status') }}</th>
                            <th class="text-center" scope="col">{{ translate('priority') }}</th>
                            <th class="text-center" scope="col">{{ translate('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submissions as $submission_master)
                            <tr>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                            value="{{ $submission_master->id }}" />
                                        <span class="text-muted">#{{ $loop->index + 1 }}</span>
                                    </label>
                                </th>
                                @if ($submission_master->status == 'first_step')
                                    <td class="text-center"><img width="40px"
                                            src="{{ asset(main_path() . 'assets/images/flask_gray.png') }}" alt="">
                                        {{ $submission_master->submission_number }}
                                    </td>
                                @elseif($submission_master->status == 'second_step')
                                    <td class="text-center"><img width="40px"
                                            src="{{ asset(main_path() . 'assets/images/flask_half_gray.png') }}"
                                            alt="">
                                        {{ $submission_master->submission_number }}
                                    </td>
                                @elseif($submission_master->status == 'third_step')
                                    <td class="text-center"><img width="40px"
                                            src="{{ asset(main_path() . 'assets/images/blue_flask.png') }}" alt="">
                                        {{ $submission_master->submission_number }}
                                    </td>
                                @elseif($submission_master->status == 'fourth_step')
                                    <td class="text-center"><img width="40px"
                                            src="{{ asset(main_path() . 'assets/images/' . getFlaskImage($submission_master->id)) }}"
                                            alt="">
                                        {{ $submission_master->submission_number }}
                                    </td>
                                @elseif($submission_master->status == 'fifth_step')
                                    <td class="text-center">
                                        {{-- <i class="fas fa-check text-success"></i>
                                        <i class="fas fa-flask text-warning"></i> --}}
                                        {{-- <i class="fas fa-flask text-success"></i> --}}
                                        {{-- <i class="fas fa-flask-vial text-primary"></i> --}}

                                        <img width="40px"
                                            src="{{ asset(main_path() . 'assets/images/' . getFlaskImageFifthStatus($submission_master->id)) }}"
                                            alt="">
                                        {{ $submission_master->submission_number }}
                                    </td>
                                    @else
                                    <td class="text-center">{{ $submission_master->submission_number }}</td>
                                @endif
                                {{-- <td class="text-center" id="barcode-{{ $submission_master->id }}">{!! $submission_master->barcode_image !!} --}}


                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($submission_master->sampling_date_and_time)->format('M d, Y h:i A') }}
                                </td>
                                <td class="text-center">{{ $submission_master->plant->name }} </td>
                                <td class="text-center">{{ optional($submission_master->sample_main)->name }} </td>

                                <td class="text-center">

                                    <span class="badge bg-warning text-dark">
                                        @if ($submission_master->status == 'first_step')
                                            {{ translate('has_not_arrived_yet') }}
                                        @elseif($submission_master->status == 'second_step')
                                            {{ translate('Not_yet_worked_on') }}
                                        @elseif($submission_master->status == 'third_step')
                                            {{ translate('It_is_being_worked_on') }}
                                        @elseif($submission_master->status == 'fourth_step')
                                            {{ translate('Some_results_have_been_entered.') }}
                                        @elseif($submission_master->status == 'fifth_step')
                                            {{ translate('finished') }}
                                        @endif
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
                                        class="badge {{ $priorityColors[$submission_master->priority] ?? 'bg-light text-dark' }}">
                                        {{ $submission_master->priority }}
                                    </span>
                                </td>



                                <td class="text-center">
                                    @can('delete_submission')
                                        <a href="{{ route('admin.submission.delete', $submission_master->id) }}"
                                            class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i
                                                class="fa fa-trash"></i></a>
                                    @endcan
                                    @can('edit_submission')
                                        <a href="{{ route('admin.submission.edit', $submission_master->id) }}"
                                            class="btn btn-outline-info btn-sm" title="@lang('dashboard.edit')"><i
                                                class="mdi mdi-pencil"></i> </a>
                                    @endcan
                                    @if ($submission_master->status == 'second_step')
                                        @can('create_result')
                                            <a href="{{ route('admin.submission.change_status', [$submission_master->id, 'third_step']) }}"
                                                class="btn btn-outline-warning text-dark  btn-sm">{{ translate('start_work') }}</a>
                                        @endcan
                                    @endif
                                    @if ($submission_master->status == 'first_step')
                                        @can('create_result')
                                            <a href="{{ route('admin.submission.change_status_without_qr', [$submission_master->id ]) }}"
                                                class="btn btn-outline-warning text-dark  btn-sm">{{ translate('start_work_without_qr_code') }}</a>
                                        @endcan
                                    @endif
                                    {{-- @if (!isset($submission_master->result) && $submission_master->status == 'third_step') --}}
                                    @if ($submission_master->status == 'third_step' || $submission_master->status == 'fourth_step')
                                        @can('create_result')
                                            @php
                                                $hasItemWithoutResult = $submission_master->submission_test_method_items->contains(
                                                    function ($item) {
                                                        return !$item->result;
                                                    },
                                                );
                                            @endphp

                                            @if ($hasItemWithoutResult)
                                                <a href="{{ route('admin.result.create', [$submission_master->id, 'submission']) }}"
                                                    class="btn btn-outline-warning text-dark btn-sm"
                                                    title="@lang('results.add_result')">
                                                    @lang('results.add_result')
                                                </a>
                                            @endif
                                        @endcan
                                    @endif

                                    <button type="button" class="btn btn-sm btn-primary"
                                        onclick="printBarcode('barcode-{{ $submission_master->id }}', '{{ $submission_master->submission_number }}')">
                                        {{ translate('print_barcode') }}
                                    </button>
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
@endsection
@section('js')
    <script>
        function printBarcode(barcodeId, submissionNumber) {
            let barcodeDiv = document.getElementById(barcodeId);

            if (!barcodeDiv) {
                alert("لم يتم العثور على عنصر الباركود!");
                return;
            }

            let barcodeHtml = barcodeDiv.innerHTML;

            let printWindow = window.open('', '', 'width=400,height=300');
            printWindow.document.write(`
        <html>
        <head>
            <title>Print Barcode</title>
            <style>
                body {
                    margin: 0;
                    padding: 10px;
                    text-align: center;
                    font-family: Arial, sans-serif;
                }
                .barcode-container {
                    display: inline-block;
                    padding: 5px;
                }
                h3 {
                    margin-bottom: 10px;
                    font-size: 14px; 
                }
                img {
                    width: 700px;  /* ←   barcode width */
                    height: 100px;  /* ←  barcode height  */
                }
 
                @page {
                    size: 80mm 40mm; /* ← vol page */
                    margin: 2mm;
                }
            </style>
        </head>
        <body>
            <div class="barcode-container">
                <h3>${submissionNumber}</h3>
                <div>${barcodeHtml}</div>
            </div>
            <script>
                window.onload = function() {
                    window.print();
                    window.close();
                }
            <\/script>
        </body>
        </html>
    `);
            printWindow.document.close();
        }
    </script>
@endsection
