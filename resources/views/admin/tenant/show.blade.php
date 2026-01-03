@extends('admin.layouts.dashboard')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('dashboard') }}</h4>
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
    <div class="container-fluid">
    <!-- ============================================================== -->
        <!-- Info box -->
        <!-- ============================================================== -->
        <div class="card-group">
         
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-success">
                                <i class="ti-user text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ translate('Total_Users') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $users_count ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-success">
                                <i class="ti-user text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ translate('Total_Samples') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $samples_count ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-success">
                                <i class="ti-user text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ translate('Total_Test_Methods') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $test_method_count ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-success">
                                <i class="ti-user text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ translate('Total_Submissions') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $submission_count ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="card-group">
         
           
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-success">
                                <i class="ti-user text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ translate('Result Count') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $result_count ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-success">
                                <i class="ti-user text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ translate('Pending Result Count') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $result_pending ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-success">
                                <i class="ti-user text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ translate('Completed Result Count') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $result_completed ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
             <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-success">
                                <i class="ti-user text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ translate('Total_units') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $units_count ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-group">
         
           
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-success">
                                <i class="ti-user text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ translate('Result Type Count') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $result_type_count ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-success">
                                <i class="ti-user text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ translate('Sample Routine Scheduler Count') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $schesules_count ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
           <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <!-- title -->
                        <div class="d-md-flex align-items-center">
                            <div>
                                <h4 class="card-title">{{ translate('Tenant Info') }}</h4>
                                <h5 class="card-subtitle">{{ translate('Overview_of_Tenant') }}</h5>
                            </div>
                            {{-- <div class="ml-auto">
                                <div class="dl">
                                    <select class="custom-select">
                                        <option value="0" selected="">Monthly</option>
                                        <option value="1">Daily</option>
                                        <option value="2">Weekly</option>
                                        <option value="3">Yearly</option>
                                    </select>
                                </div>
                            </div> --}}
                        </div> 
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr> 
                                    <th class="text-center" scope="col">{{ translate('name') }}</th>
                                    <th class="text-center" scope="col">{{ translate('delete_data_after') }}</th>
                                    <th class="text-center" scope="col">{{ translate('company_id') }}</th>
                                    <th class="text-center" scope="col">{{ translate('status') }}</th>
                                    <th class="text-center" scope="col">{{ translate('subscription_ends_at') }}</th>
                                    <th class="text-center" scope="col">{{ translate('Plan') }}</th>
                                    <th class="text-center" scope="col">{{ translate('email') }}</th>
                                    <th class="text-center" scope="col">{{ translate('Phone') }}</th>
                                    <th class="text-center" scope="col">{{ translate('admin_username') }}</th>
                                    <th class="text-center" scope="col">{{ translate('password') }}</th> 
                                </tr>
                            </thead>
                            <tbody> 
                                 <tr @if (\Carbon\Carbon::parse($tenant->expire) <= now()->addDays(2)) style="background-color: red;color:white" @endif>

                                        
                                        <td class="text-center">{{ $tenant->name }}</td>
                                        <td class="text-center">{{ $tenant->tenant_delete_days }}</td>
                                        <td class="text-center">{{ $tenant->tenant_id }} </td>
                                        <td class="text-center"> <span
                                                class="badge badge-pill {{ $tenant->status == 'active' ? 'badge-success' : 'badge-danger' }}">{{ $tenant->status }}</span>
                                        </td>
                                        <td class="text-center">{{ $tenant->expire }} </td>
                                        <td class="text-center">
                                            {{ $tenant->schema?->name ?? translate('Not_Available') }} </td>
                                        <td class="text-center">{{ $tenant->email }} </td>
                                        <td class="text-center">{{ $tenant->phone }} </td>
                                        <td class="text-center">{{ $user->user_name }} </td>
                                        <td class="text-center">{{ $user->my_name }} </td>

                                      
                                    </tr> 


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
  
@endsection
