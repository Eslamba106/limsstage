@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ __('roles.'.$route.'_management') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.'.$route.'_management') }}</h4>
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
                        

 
                        
                        @can('create_unit')
                            <a href="{{ route('admin.'.$route.'.create') }}" class="btn btn-secondary mt-3 mr-2">
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
                            <th class="text-center" scope="col">{{ __('roles.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($main as $main_item)
                       
                            <tr> 
                                    <th scope="row" >
                                        <label>
                                            <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                                value="{{ $main_item->id }}" />
                                            <span class="text-muted">#{{ $loop->index + 1 }}</span>
                                        </label>
                                    </th> 
                                 
                                <td class="text-center">{{ $main_item->name }}</td>
                                
                                    <td class="text-center"  >
                                        @can('delete_'.$route.'')
                                            <a href="{{ route('admin.'.$route.'.delete', $main_item->id) }}"
                                                class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i class="fa fa-trash"></i></a>
                                        @endcan
                                        @can('edit_'.$route.'')
                                            <a href="{{ route('admin.'.$route.'.edit', $main_item->id) }}"
                                                class="btn btn-outline-info btn-sm" title="@lang('dashboard.edit')"><i class="mdi mdi-pencil"></i> </a>
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
