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
                            {{ translate('Total_Tenants') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $tenant_counts ?? 0 }}</h2>
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
                            {{ translate('Name') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $schema->name ?? 0 }}</h2>
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
                            {{ translate('Price') }}

                        </div>
                        <div class="ml-auto">
                            <h2 class="m-b-0 font-light">{{ $schema->price ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row">

            @foreach ($countFields as $field => $label)
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h6 class="mb-1">{{ translate($label) }}</h6>
                            <p class="mb-0 fw-bold" style="font-size: 1.2rem;">
                                {{ data_get($schema, $field) ?? 0 }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-1 fw-bold">{{ $schema->name }}</h3>
                        <p class="mb-0" style="font-size: 1.2rem;">
                            {{ translate('Tenants') }}: {{ $schema->tenants_count }}
                        </p>
                    </div>
                    <div class="card-body">
                        <p style="font-size: 1.2rem;"><strong>{{ translate('Price') }}:</strong> {{ $schema->price }}
                            {{ $schema->currency }}</p>

                        @if (!empty($schema->display))
                            <p style="font-size: 1.2rem;"><strong>{{ translate('Display') }}:</strong>
                                {{ $schema->display }}</p>
                        @endif

                        <p style="font-size: 1.2rem;"><strong>{{ translate('Status') }}:</strong>
                            <span class="badge {{ $schema->status == 'active' ? 'badge-success' : 'badge-danger' }} p-2"
                                style="font-size: 1rem;">
                                {{ $schema->status }}
                            </span>
                        </p>

                        <hr>

                        <h5>{{ translate('Modules') }}</h5>
                        <div class="d-flex flex-column">
                            @foreach ($modules as $key => $label)
                                @if ($schema->$key)
                                    <span class="badge bg-info m-1"
                                        style="font-size: 1rem; padding: 0.5em 0.8em; color:black; width: fit-content;">
                                        {{ translate($label) }}
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
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
                                @forelse ($schema?->tenants as $tenant_items)
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
        </div>

    </div>
@endsection
@section('js')
@endsection
