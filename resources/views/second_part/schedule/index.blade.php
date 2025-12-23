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
                            <button type="submit" name="bulk_action_btn" value="delete"
                                class="btn btn-danger delete_confirm mt-3 mr-2"> <i class="la la-trash"></i>
                                {{ __('dashboard.delete') }}</button>
                        @endcan
                        @can('create_submission')
                            <a href="{{ route('admin.submission.schedule.create') }}" class="btn btn-secondary mt-3 mr-2">
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
                                <td class="text-center">{{ $submission_item->submission_number }} </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($submission_item->sampling_date_and_time)->format('M d, Y h:i A') }}
                                </td>
                                <td class="text-center">{{ $submission_item->plant->name }} </td>
                                <td class="text-center">{{ $submission_item->sample->sample_plant->name }} </td>

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
                                                'in progress' => 'bg-warning text-dark',
                                                'pending' => 'bg-secondary text-white',
                                                'completed' => 'bg-success text-white',
                                            ];
                                        @endphp
                                        <td class="text-center">
                                        <span
                                            class="badge {{ $statusColors[$submission_item->status] ?? 'bg-yellow text-dark' }}">
                                            {{ $submission_item->status }}
                                        </span>
                                {{--  --}}</td>

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
                                            class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i
                                                class="fa fa-trash"></i></a>
                                    @endcan
                                    @can('edit_submission')
                                        <a href="{{ route('admin.submission.schedule.edit', $submission_item->id) }}"
                                            class="btn btn-outline-info btn-sm" title="@lang('dashboard.edit')"><i
                                                class="mdi mdi-pencil"></i> </a>
                                    @endcan
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
        // $('#statusSwitch').on('change', function() {
        //     if ($(this).is(':checked')) {
        //         console.log('Status: ON');
        //     } else {
        //         console.log('Status: OFF');
        //     }
        // });
        
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
    </script>
@endsection
