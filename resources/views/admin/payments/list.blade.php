@extends('admin.layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ translate('schema_management') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('schema_management') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ translate('home') }} </a>
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
                        {{-- @can('change_schemas_status') --}}
                        <div class="remv_control mr-2">
                            <select name="status" class="mr-3 mt-3 form-control ">
                                <option value="">{{ translate('set_status') }}</option>
                                <option value="1">{{ translate('active') }}</option>
                                <option value="2">{{ translate('disactive') }}</option>
                            </select>
                        </div>



                        <button type="submit" name="bulk_action_btn" value="update_status"
                            class="btn btn-primary mt-3 mr-2">
                            <i class="la la-refresh"></i> {{ translate('update') }}
                        </button>
                        {{-- @endcan --}}
                        {{-- @can('delete_schema_items')  --}}
                        <button type="submit" name="bulk_action_btn" value="delete"
                            class="btn btn-danger delete_confirm mt-3 mr-2"> <i class="la la-trash"></i>
                            {{ translate('delete') }}</button>
                        {{-- @endcan --}}
                        {{-- @can('create_schema_items') --}}
                        <a href="{{ route('admin.schema.create') }}" class="btn btn-secondary mt-3 mr-2">
                            <i class="la la-refresh"></i> {{ translate('create') }}
                        </a>
                        {{-- @endcan --}}
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input class="bulk_check_all" type="checkbox" /></th>
                            <th class="text-center" scope="col">{{ translate('tenant') }}</th>
                            <th class="text-center" scope="col">{{ translate('amount') }}</th>
                            <th class="text-center" scope="col">{{ translate('currency') }}</th>
                            <th class="text-center" scope="col">{{ translate('payment_date') }}</th>
                            <th class="text-center" scope="col">{{ translate('transaction_reference') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                        <!-- 
                        
                        `user_id`, `amount`, `payment_method`, `payment_date`, `status`, 
                        `transaction_id`, `notes`, `currency`, `transaction_reference`,
                        -->
                            <tr>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                            value="{{ $payment->id }}" />
                                        <span class="text-muted">#{{ $payment->id }}</span>
                                    </label>
                                </th>
                                <td class="text-center">{{ $payment->tenant?->name }}</td>
                                <td class="text-center">{{ $payment->amount }} </td>
                                <td class="text-center">{{ $payment->currency }}</td>
                                {{-- <td class="text-center">
                                    @if ($payment->status == 'paid')
                                        <span class="badge badge-success">{{ translate('paid') }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ translate('unpaid') }}</span>
                                    @endif
                                </td> --}}
                                {{-- <td class="text-center">{{ $payment->payment_method }}</td> --}}
                                <td class="text-center">{{ $payment->payment_date }}</td>
                                {{-- <td class="text-center">{{ $payment->transaction_id }}</td> --}}
                                <td class="text-center">{{ $payment->transaction_reference }}</td>
                                

                               
                             
                            </tr>
                        @empty
                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>
    </form>
@endsection
