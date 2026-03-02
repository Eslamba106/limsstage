@extends('layouts.dashboard')
@section('title')
<?php $lang = Session::get('locale'); ?>

    {{ __('roles.user_managment') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.user_managment') }}</h4>
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
                        {{-- @can('change_users_status')
                            <div class="remv_control mr-2">
                                <select name="status" class="mr-3 mt-3 form-control ">
                                    <option value="">{{ __('dashboard.set_status') }}</option>
                                    <option value="1">{{ __('dashboard.active') }}</option>
                                    <option value="2">{{ __('dashboard.disactive') }}</option>
                                </select>
                            </div>
                        @endcan --}}
                        @can('change_users_role')
                            <div class="remv_control mr-2">
                                <select name="role" class="mr-3 mt-3 form-control">
                                    <option value="">{{ __('roles.set_role') }}</option>
                                    @foreach ($roles as $item_role) 
                                    <option value="{{ $item_role->id }}">{{ $item_role->name }}</option>
                                    @endforeach
 
                                </select>
                            </div>
                       
                        
                        <button type="submit" name="bulk_action_btn" value="update_status"
                            class="btn btn-primary mt-3 mr-2">
                            <i class="la la-refresh"></i> {{ __('dashboard.update') }}
                        </button>
                         @endcan
                        @can('delete_user') 
                        <button type="button" name="bulk_action_btn" value="delete"
                            class="btn btn-danger delete-bulk-confirm mt-3 mr-2" id="bulk-delete-btn">
                            <i class="la la-trash"></i>
                            {{ __('dashboard.delete') }}
                        </button>
                        @endcan
                        @can('create_user')
                        <a href="{{ route('user_managment.create') }}" class="btn btn-secondary mt-3 mr-2">
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
                            <th class="text-center" scope="col">{{ __('roles.name') }}</th>
                            <th class="text-center" scope="col">@lang('login.user_name')</th>
                            <th class="text-center" scope="col">@lang('roles.role_name')</th>
                            <th class="text-center" scope="col">{{ __('roles.email') }}</th>
                            <th class="text-center" scope="col">{{ __('roles.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                            value="{{ $user->id }}" />
                                        <span class="text-muted">#{{ $user->id }}</span>
                                    </label>
                                </th>
                                <td class="text-center">{{ $user->name }}</td>
                                <td class="text-center"> {{ $user->user_name }}</span>
                                </td>
                                <td class="text-center">{{ $user->role_name }} </td>
                                <td class="text-center">{{ $user->email ?? $user->user_name }}</td>
                              
                                <td class="text-center">
                                    @can('delete_user') 
                                        <a href="{{ route('user_managment.delete', $user->id) }}"
                                            class="btn btn-danger btn-sm delete-single-confirm" 
                                            title="@lang('dashboard.delete')"
                                            data-user-name="{{ $user->name }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    @endcan
                                    @can('edit_user') 
                                        <a href="{{ route('user_managment.edit', $user->id) }}"
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
        // Sweet Alert for single delete
        $(document).on('click', '.delete-single-confirm', function(e) {
            e.preventDefault();

            const deleteUrl = $(this).attr('href');
            const userName = $(this).data('user-name') || '';

            Swal.fire({
                title: '{{ translate('are_you_sure') }}?',
                text: '{{ translate('you_will_not_be_able_to_revert_this') }}' + (userName ? ' (' + userName + ')' : ''),
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
