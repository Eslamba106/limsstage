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
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <span class="btn btn-circle btn-lg bg-warning">
                                <i class="fas fa-file-invoice-dollar text-white"></i>
                            </span>
                        </div>
                        <div>
                            {{ translate('Total_Income') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $amounts . ' SAR' }}</h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <canvas id="tenantChart"></canvas>
            </div>
            <div class="col-md-6">
                <div style="width:300px; margin:auto">
                    <canvas id="subscriptionStatusChart"></canvas>
                </div>

            </div>
            <div class="col-md-6">
                <div style=" margin:auto">
                    <canvas id="subscriptionBarChart2"></canvas>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ translate('Schemas') }}</h4>
                        <h5 class="card-subtitle">{{ translate('Overview_of_Schemas') }}</h5>

                        <canvas id="schemasChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ translate('Payments') }}</h4>
                        <h5 class="card-subtitle">{{ translate('Overview_of_Payments') }}</h5>

                        <canvas id="paymentsChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
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
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <!-- title -->
                        <div class="d-md-flex align-items-center">
                            <div>
                                <h4 class="card-title">{{ translate('Last_Tenants') }}</h4>
                                <h5 class="card-subtitle">{{ translate('Overview_of_Last_Tenants') }}</h5>
                            </div>

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
                                    {{-- <th class="text-center" scope="col">{{ translate('Actions') }}</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($last_tenants as $tenant_items)
                                    <tr @if (\Carbon\Carbon::parse($tenant_items->expire) <= now()->addDays(2)) style="background-color: red;color:white" @endif>

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
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <!-- title -->
                        <div class="d-md-flex align-items-center">
                            <div>
                                <h4 class="card-title">{{ translate('Schemas') }}</h4>
                                <h5 class="card-subtitle">{{ translate('Overview_of_Schemas') }}</h5>
                            </div>

                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" scope="col">{{ translate('name') }}</th>
                                    <th class="text-center" scope="col">{{ translate('price') }}</th>
                                    <th class="text-center" scope="col">{{ translate('status') }}</th>
                                    <th class="text-center" scope="col">{{ translate('Tenants_Count') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($schemas as $schema_items)
                                    <tr>

                                        <td class="text-center">{{ $schema_items->name }}</td>
                                        <td class="text-center">{{ $schema_items->price }} </td>
                                        <td class="text-center"> <span
                                                class="badge badge-pill {{ $schema_items->status == 'active' ? 'badge-success' : 'badge-danger' }}">{{ $schema_items->status }}</span>
                                        </td>
                                        <td class="text-center">{{ $schema_items->tenants_count }} </td>

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
    <script src="{{ asset(main_path() . 'js/chart.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const ctx = document.getElementById('tenantChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($tenantsByMonth->keys()->values()) !!},
                    datasets: [{
                        label: 'New Tenants',
                        data: {!! json_encode($tenantsByMonth->values()->values()) !!},
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    }
                }
            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const ctx = document.getElementById('subscriptionStatusChart').getContext('2d');

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Active', 'Expired'],
                    datasets: [{
                        data: [
                            {{ $activeTenants }},
                            {{ $expiredTenants }}
                        ],
                        backgroundColor: [
                            '#2ecc71',
                            '#e74c3c'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const ctx = document.getElementById('subscriptionBarChart2').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($tenantNames) !!},
                    datasets: [{
                        label: 'Tenant Status (1 = Active, 0 = Expired)',
                        data: {!! json_encode($tenantStatus) !!},
                        backgroundColor: {!! json_encode($tenantColors) !!},
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                    return value === 1 ? 'Active' : 'Expired';
                                }
                            },
                            beginAtZero: true,
                            max: 1
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.raw === 1 ? 'Active' : 'Expired';
                                }
                            }
                        }
                    }
                }
            });

        });
    </script>
    <script>
        const ctx = document.getElementById('schemasChart').getContext('2d');
        const schemasChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($schemaNames),
                datasets: [{
                    label: '{{ translate('Tenants_Count') }}',
                    data: @json($tenantsCounts),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: '{{ translate('Schemas Overview') }}'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        stepSize: 1
                    }
                }
            }
        });
    </script>
 <script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('paymentsChart');

    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Payments per Month',
                data: @json($totals),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

@endsection
