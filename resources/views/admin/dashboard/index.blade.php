@extends('admin.layouts.dashboard')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('dashboard.dashboard') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ __('dashboard.home') }} </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('dashboard.dashboard') }}</li>
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
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-danger">
                                <i class="ti-clipboard text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ translate('Total_Tenants') }}
                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $tenant_counts ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card -->
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg btn-info">
                                <i class="ti-wallet text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ translate('Plans_Count') }}
                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $schemas_count ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card -->
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-success">
                                <i class="ti-shopping-cart text-white"></i>
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
            <!-- Card -->
            <!-- Card -->
            {{-- <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="m-r-10">
                                    <span class="btn btn-circle btn-lg bg-warning">
                                        <i class="mdi mdi-currency-usd text-white"></i>
                                    </span>
                                </div>
                                <div>
                                    Profit

                                </div>
                                <div class="ml-auto">
                                    <h2 class="m-b-0 font-light">63</h2>
                                </div>
                            </div>
                        </div>
                    </div> --}}
            <!-- Card -->
            <!-- Column -->


        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <!-- title -->
                        <div class="d-md-flex align-items-center">
                            <div>
                                <h4 class="card-title">{{ translate('Last_Tenants') }}</h4>
                                <h5 class="card-subtitle">{{ translate('Overview_of_Last_Tenants') }}</h5>
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
                                    <th><input class="bulk_check_all" type="checkbox" /></th>
                                    <th class="text-center" scope="col">{{ translate('name') }}</th>
                                    <th class="text-center" scope="col">{{ translate('delete_data_after') }}</th>
                                    <th class="text-center" scope="col">{{ translate('company_id') }}</th>
                                    <th class="text-center" scope="col">{{ translate('status') }}</th>
                                    <th class="text-center" scope="col">{{ translate('subscription_ends_at') }}</th>
                                    <th class="text-center" scope="col">{{ translate('Plan') }}</th>
                                    <th class="text-center" scope="col">{{ translate('email') }}</th>
                                    <th class="text-center" scope="col">{{ translate('Phone') }}</th>
                                    {{-- <th class="text-center" scope="col">{{ translate('Actions') }}</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($last_tenants as $tenant_items)
                                    <tr>
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
                                        <td class="text-center">
                                            {{ $tenant_items->schema?->name ?? translate('Not_Available') }} </td>
                                        <td class="text-center">{{ $tenant_items->email }} </td>
                                        <td class="text-center">{{ $tenant_items->phone }} </td>

                                      
                                    </tr>
                                @empty
                                @endforelse


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        Morris.Area({
            element: 'product-sales_new',
            data: [{
                    period: '2012',
                    iphone: 50,
                    ipad: 80,
                    itouch: 20
                },
                {
                    period: '2013',
                    iphone: 130,
                    ipad: 100,
                    itouch: 80
                },
                {
                    period: '2014',
                    iphone: 80,
                    ipad: 60,
                    itouch: 70
                },
                {
                    period: '2015',
                    iphone: 70,
                    ipad: 200,
                    itouch: 140
                },
                {
                    period: '2016',
                    iphone: 180,
                    ipad: 150,
                    itouch: 140
                },
                {
                    period: '2017',
                    iphone: 105,
                    ipad: 100,
                    itouch: 80
                },
                {
                    period: '2018',
                    iphone: 250,
                    ipad: 150,
                    itouch: 200
                }
            ],
            xkey: 'period',
            ykeys: ['iphone', 'ipad'],
            labels: ['iPhone', 'iPad'],
            pointSize: 2,
            fillOpacity: 0,
            pointStrokeColors: ['#ccc', '#4798e8', '#9675ce'],
            behaveLikeLine: true,
            gridLineColor: '#e0e0e0',
            lineWidth: 2,
            hideHover: 'auto',
            lineColors: ['#ccc', '#4798e8', '#9675ce'],
            resize: true
        });
    </script>
@endsection
