@extends('admin.layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ translate('tenant_management') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('tenant_management') }}</h4>
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
                        <div class="remv_control mr-2">
                            <select name="status" class="mr-3 mt-3 form-control ">
                                <option value="">{{ translate('set_status') }}</option>
                                <option value="active">{{ translate('active') }}</option>
                                <option value="inactive">{{ translate('disactive') }}</option>
                            </select>
                        </div>



                        <button type="submit" name="bulk_action_btn" value="update_status"
                            class="btn btn-primary mt-3 mr-2">
                            <i class="la la-refresh"></i> {{ translate('update') }}
                        </button> 
                        <button type="submit" name="bulk_action_btn" value="delete"
                            class="btn btn-danger delete_confirm mt-3 mr-2"> <i class="la la-trash"></i>
                            {{ translate('delete') }}</button> 
                        <a href="{{ route('admin.tenant_management.create') }}" class="btn btn-secondary mt-3 mr-2">
                            <i class="la la-refresh"></i> {{ translate('create') }}
                        </a> 
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input class="bulk_check_all" type="checkbox" /></th>
                            <th class="text-center" scope="col">{{ translate('name') }}</th>
                            <th class="text-center" scope="col">{{ translate('delete_data_after') }}</th>
                            <th class="text-center" scope="col">{{ translate('company_id') }}</th>
                            <th class="text-center" scope="col">{{ translate('status') }}</th>
                            <th class="text-center" scope="col">{{ translate('subscription_ends_at') }}</th>
                            <th class="text-center" scope="col">{{ translate('Plan') }}</th>
                            <th class="text-center" scope="col">{{ translate('email') }}</th>
                            <th class="text-center" scope="col">{{ translate('Phone') }}</th>
                            <th class="text-center" scope="col">{{ translate('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tenants as $tenant_items)
                            <tr @if (\Carbon\Carbon::parse($tenant_items->expire) <= now()->addDays(2)) style="background-color: red;color:white" @endif>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                            value="{{ $tenant_items->id }}" />
                                        <span class="text-muted">#{{ $tenant_items->id }}</span>
                                    </label>
                                </th>
                                <td class="text-center">{{ $tenant_items->name }}</td>
                                <td class="text-center">{{ $tenant_items->tenant_delete_days }}</td>
                                <td class="text-center">{{ $tenant_items->tenant_id }} </td>
                                <td class="text-center"> <span
                                        class="badge badge-pill {{ $tenant_items->status == 'active' ? 'badge-success' : 'badge-danger' }}">{{ $tenant_items->status }}</span>
                                </td>
                                <td class="text-center">{{ $tenant_items->expire }} </td>
                                <td class="text-center">{{ $tenant_items->schema?->name ?? translate('Not_Available') }}
                                </td>
                                <td class="text-center">{{ $tenant_items->email }} </td>
                                <td class="text-center">{{ $tenant_items->phone }} </td>

                                <td class="text-center"> 
                                    <a href="{{ route('admin.tenant_management.edit', $tenant_items->id) }}"
                                        class="btn btn-outline-info btn-sm" title="@lang('dashboard.edit')"><i
                                            class="mdi mdi-pencil"></i> </a>
                                    <a href="{{ route('admin.tenant_management.show', $tenant_items->id) }}"
                                        class="btn btn-outline-info btn-sm" title="{{ translate('show') }}"><i
                                            class="mdi mdi-eye"></i> </a>

                                </td>
                            </tr>
                        @empty
                        @endforelse


                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center mt-3">

                {{ $tenants->withQueryString()->appends(['search' => 1])->links() }} 
            </div>
        </div>
    </form>
@endsection
