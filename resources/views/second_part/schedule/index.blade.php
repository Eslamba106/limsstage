@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ __('roles.submission_managment') }}
@endsection
@section('css')
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> --}}
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
    {{-- @if (session()->has('locale'))
    {{ dd(session()->get('locale') ) }}
@endif --}}

    <form action="" method="get">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="input-group mb-3 d-flex justify-content-end">
                        {{-- @can('change_submissions_status')
                            <div class="remv_control mr-2">
                                <select name="status" class="mr-3 mt-3 form-control ">
                                    <option value="">{{ __('dashboard.set_status') }}</option>
                                    <option value="1">{{ __('dashboard.active') }}</option>
                                    <option value="2">{{ __('dashboard.disactive') }}</option>
                                </select>
                            </div>
                        @endcan --}}
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
                            <button type="button" name="bulk_action_btn" value="delete"
                                class="btn btn-danger delete-bulk-confirm mt-3 mr-2" id="bulk-delete-btn">
                                <i class="la la-trash"></i>
                                {{ __('dashboard.delete') }}
                            </button>
                        @endcan
                        @can('create_submission')
                            <a href="{{ route('admin.submission.schedule.create') }}" class="btn btn-secondary mt-3 mr-2">
                                <i class="la la-refresh"></i> {{ __('dashboard.create') }}
                            </a>
                        @endcan
                        @can('submission_management')
                            <a href="{{ route('admin.submission.schedule.scan') }}" class="btn btn-info mt-3 mr-2">
                                <i class="fa fa-barcode"></i> {{ translate('scan_barcode') }}
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
                            <th class="text-center" scope="col">{{ __('samples.sample_id') }}</th>
                            <th class="text-center" scope="col">@lang('submissions.collection_date')</th>
                            <th class="text-center" scope="col">@lang('samples.plant')</th>
                            <th class="text-center" scope="col">@lang('submissions.sample_point')</th>
                            <th class="text-center" scope="col">@lang('roles.status')</th>
                            {{-- <th class="text-center" scope="col">@lang('submissions.priority')</th> --}}
                            <th class="text-center" scope="col">{{ __('roles.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($submissions as $submission_item)
                            <tr>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                            value="{{ $submission_item->id }}" />
                                        <span class="text-muted">#{{ $loop->index + 1 }}</span>
                                    </label>
                                </th>
                                <td class="text-center">
                                    {{ $submission_item->submission_number }}
                                    {{-- Hidden barcode element for printing --}}
                                    <div style="display: none;" id="barcode-{{ $submission_item->id }}">
                                        {!! $submission_item->barcode_image ?? '' !!}
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if ($submission_item->created_at)
                                        {{ \Carbon\Carbon::parse($submission_item->created_at)->format('M d, Y h:i A') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($submission_item->plant)
                                        {{ $submission_item->plant->name }}
                                    @else
                                        <span class="text-danger">Deleted Plant</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($submission_item->sample && $submission_item->sample->sample_plant)
                                        {{ $submission_item->sample->sample_plant->name }}
                                    @else
                                        <span class="text-danger">Deleted Sample</span>
                                    @endif
                                </td>

                                {{-- <td class="text-center">{{ $submission_item->status  }} </td>
                                <td class="text-center">{{ $submission_item->priority  }} </td> --}}
                                {{-- <td class="text-center">
                                    <form action=" " method="post" id="product_status{{ $submission_item->id }}_form"
                                        class="status_form">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $submission_item->id }}">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="flexSwitchCheckChecked"   onclick="toogleStatusModal(event,'product_status{{ $submission_item->id }}',
                                                    'product-status-on.png','product-status-off.png',
                                                    '{{ __('general.Want_to_Turn_ON') }} {{ $submission_item->name }} ',
                                                    '{{ __('general.Want_to_Turn_OFF') }} {{ $submission_item->name }} ',
                                                    `<p>{{ __('general.if_enabled_this_product_will_be_available') }}</p>`,
                                                    `<p>{{ __('general.if_disabled_this_product_will_be_hidden') }}</p>`)">
                                            <label class="form-check-label" for="flexSwitchCheckChecked"> </label>
                                        </div>
                                    </form>
                                </td>  --}}
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-secondary text-white',
                                        'received' => 'bg-info text-white',
                                        'in_progress' => 'bg-warning text-dark',
                                        'completed' => 'bg-success text-white',
                                    ];
                                    
                                    $statusTranslations = [
                                        'pending' => translate('pending'),
                                        'received' => translate('received'),
                                        'in_progress' => translate('in_progress'),
                                        'completed' => translate('completed'),
                                    ];
                                @endphp
                                <td class="text-center">
                                    <span class="badge {{ $statusColors[$submission_item->status] ?? 'bg-secondary text-white' }}">
                                        {{ $statusTranslations[$submission_item->status] ?? $submission_item->status }}
                                    </span>
                                </td>

                                {{-- <td class="text-center">
                                    @php
                                        $priorityColors = [
                                            'high' => 'bg-danger text-white',
                                            'normal' => 'bg-primary text-white',
                                            'low' => 'bg-info text-dark',
                                        ];
                                    @endphp
                                    <span
                                        class="badge {{ $priorityColors[$submission_item->priority] ?? 'bg-light text-dark' }}">
                                        {{ $submission_item->priority }}
                                    </span>
                                </td> --}}



                                <td class="text-center">
                                    @can('delete_submission')
                                        <a href="{{ route('admin.submission.schedule.delete', $submission_item->id) }}"
                                            class="btn btn-danger btn-sm delete-single-confirm" title="@lang('dashboard.delete')"
                                            data-submission-number="{{ $submission_item->submission_number }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    @endcan
                                    @can('edit_submission')
                                        <a href="{{ route('admin.submission.schedule.edit', $submission_item->id) }}"
                                            class="btn btn-outline-info btn-sm" title="@lang('dashboard.edit')">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                    @endcan
                                    
                                    {{-- Start Work Button (when status is received) --}}
                                    @if ($submission_item->status === 'received')
                                        @can('create_result')
                                            <a href="{{ route('admin.submission.schedule.start-work', $submission_item->id) }}"
                                                class="btn btn-outline-warning text-dark btn-sm" title="{{ translate('start_work') }}">
                                                <i class="fa fa-play"></i> {{ translate('start_work') }}
                                            </a>
                                        @endcan
                                    @endif
                                    
                                    {{-- Add Result Button (when status is in_progress or completed) --}}
                                    @if ($submission_item->status === 'in_progress' || $submission_item->status === 'completed')
                                        @can('create_result')
                                            @php
                                                // Check if there are items without results
                                                $hasItemWithoutResult = $submission_item->sample_routine_scheduler_items->contains(
                                                    function ($item) {
                                                        return !$item->result;
                                                    }
                                                );
                                            @endphp

                                            @if ($hasItemWithoutResult)
                                                <a href="{{ route('admin.result.create', [$submission_item->id, 'schedule']) }}"
                                                    class="btn btn-outline-warning text-dark btn-sm"
                                                    title="@lang('results.add_result')">
                                                    <i class="fa fa-plus"></i> @lang('results.add_result')
                                                </a>
                                            @endif
                                        @endcan
                                    @endif
                                    
                                    {{-- Print Barcode Button --}}
                                    @if ($submission_item->submission_number)
                                        <button type="button" class="btn btn-sm btn-primary"
                                            onclick="printBarcode('{{ $submission_item->id }}', '{{ $submission_item->submission_number }}')"
                                            title="{{ translate('print_barcode') }}">
                                            <i class="fa fa-barcode"></i> {{ translate('print_barcode') }}
                                        </button>
                                    @endif
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
        /**
         * Print barcode for schedule
         */
        function printBarcode(scheduleId, submissionNumber) {
            const barcodeDiv = document.getElementById('barcode-' + scheduleId);
            
            let barcodeHtml = '';
            if (barcodeDiv && barcodeDiv.innerHTML) {
                barcodeHtml = barcodeDiv.innerHTML;
            } else {
                barcodeHtml = '<div style="font-family: monospace; font-size: 24px; padding: 20px; text-align: center;">' + submissionNumber + '</div>';
            }

            const printWindow = window.open('', '', 'width=400,height=300');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Print Barcode - ${submissionNumber}</title>
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
                            font-weight: bold;
                        }
                        img, svg {
                            max-width: 100%;
                            height: auto;
                        }
                        img {
                            width: 700px;
                            height: 100px;
                        }
                        @page {
                            size: 80mm 40mm;
                            margin: 2mm;
                        }
                        @media print {
                            body {
                                margin: 0;
                                padding: 0;
                            }
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
                            setTimeout(function() {
                                window.print();
                                setTimeout(function() {
                                    window.close();
                                }, 100);
                            }, 250);
                        }
                    <\/script>
                </body>
                </html>
            `);
            printWindow.document.close();
        }
    </script>
    <script>
        $('.status_form').on('submit', function(event) {
            event.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "",
                method: 'POST',
                data: $(this).serialize(),
                success: function(data) {
                    if (data.success == true) {
                        toastr.success('{{ __('general.updated_successfully') }}');
                    } else if (data.success == false) {
                        toastr.error(
                            '{{ __('Status_updated_failed.') }} {{ __('Product_must_be_approved') }}'
                        );
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                }
            });
        });

        // Sweet Alert for single delete
        $(document).on('click', '.delete-single-confirm', function(e) {
            e.preventDefault();

            const deleteUrl = $(this).attr('href');
            const submissionNumber = $(this).data('submission-number') || '';

            Swal.fire({
                title: '{{ translate('are_you_sure') }}?',
                text: '{{ translate('you_will_not_be_able_to_revert_this') }}' + (submissionNumber ?
                    ' ({{ translate('submission_number') }}: ' + submissionNumber + ')' : ''),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ translate('yes_delete_it') }}',
                cancelButtonText: '{{ translate('cancel') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    window.location.href = deleteUrl;
                }
            });
        });

        // Sweet Alert for bulk delete
        $(document).on('click', '#bulk-delete-btn', function(e) {
            e.preventDefault();

            const checkedItems = $('input.check_bulk_item:checked').length;
            const btn = $(this);

            if (checkedItems === 0) {
                Swal.fire({
                    title: '{{ translate('no_selection') }}',
                    text: '{{ translate('please_select_at_least_one_item') }}',
                    icon: 'warning',
                    confirmButtonText: '{{ translate('ok') }}'
                });
                return;
            }

            Swal.fire({
                title: '{{ translate('are_you_sure') }}?',
                text: '{{ translate('you_will_not_be_able_to_revert_this') }}' + ' (' + checkedItems +
                    ' {{ translate('items_selected') }})',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ translate('yes_delete_it') }}',
                cancelButtonText: '{{ translate('cancel') }}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    // Create a temporary submit button and click it
                    const form = btn.closest('form');
                    const tempBtn = $('<button>').attr({
                        type: 'submit',
                        name: 'bulk_action_btn',
                        value: 'delete',
                        style: 'display: none;'
                    });
                    form.append(tempBtn);
                    tempBtn.click();
                }
            });
        });
    </script>
@endsection
