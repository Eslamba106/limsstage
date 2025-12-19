@extends('admin.layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ translate('conversation_requests') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('conversation_requests') }}</h4>
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

                        <button type="submit" name="bulk_action_btn" value="delete"
                            class="btn btn-danger delete_confirm mt-3 mr-2"> <i class="la la-trash"></i>
                            {{ translate('delete') }}</button>

                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input class="bulk_check_all" type="checkbox" /></th>
                            <th class="text-center" scope="col">{{ translate('name') }}</th>
                            <th class="text-center" scope="col">{{ translate('phone') }}</th>
                            <th class="text-center" scope="col">{{ translate('email') }}</th>
                            <th class="text-center" scope="col">{{ translate('message') }}</th>
                            <th class="text-center" scope="col">{{ translate('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($conversation_requests as $conversation_request_items)
                            <tr>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                            value="{{ $conversation_request_items->id }}" />
                                        <span class="text-muted">#{{ $conversation_request_items->id }}</span>
                                    </label>
                                </th>
                                <td class="text-center">{{ $conversation_request_items->name }}</td>
                                <td class="text-center">{{ $conversation_request_items->phone }} </td>
                                <td class="text-center">{{ $conversation_request_items->email }} </td>
                                <td class="text-center">{{ $conversation_request_items->message }} </td>
                                <td class="text-center"  >
                                    <a href="{{ route('admin.conversation_requests.delete', $conversation_request_items->id) }}"
                                        class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i
                                            class="fa fa-trash"></i></a>


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
