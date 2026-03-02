@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ translate('certificate_managment') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('certificate_managment') }}</h4>
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

    <div class="container-fluid">
        <!-- Filters Section -->
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">{{ translate('Filters') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('certificate.list') }}" method="get">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">{{ translate('Search') }}</label>
                            <input type="text" name="search" class="form-control" 
                                   value="{{ $filters['search'] ?? '' }}" 
                                   placeholder="{{ translate('COA_Number_or_Sample') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ translate('Plant') }}</label>
                            <select name="plant_id" class="form-control">
                                <option value="">{{ translate('All_Plants') }}</option>
                                @foreach($plants as $plant)
                                    <option value="{{ $plant->id }}" 
                                            {{ ($filters['plant_id'] ?? '') == $plant->id ? 'selected' : '' }}>
                                        {{ $plant->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ translate('Client') }}</label>
                            <select name="client_id" class="form-control">
                                <option value="">{{ translate('All_Clients') }}</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" 
                                            {{ ($filters['client_id'] ?? '') == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ translate('Date_From') }}</label>
                            <input type="date" name="date_from" class="form-control" 
                                   value="{{ $filters['date_from'] ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ translate('Date_To') }}</label>
                            <input type="date" name="date_to" class="form-control" 
                                   value="{{ $filters['date_to'] ?? '' }}">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> {{ translate('Filter') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input class="bulk_check_all" type="checkbox" /></th>
                            <th class="text-center" scope="col">{{ translate('cOA_Number') }}</th>
                            <th class="text-center" scope="col">{{ translate('sample_id') }}</th>
                            <th class="text-center" scope="col">{{ translate('client') }}</th>
                            <th class="text-center" scope="col">{{ translate('generation_Date') }}</th>
                            <th class="text-center" scope="col">{{ translate('authorized_By') }}</th> 
                            <th class="text-center" scope="col">{{ translate('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($certificates as $certificate_item)
                            <tr>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                            value="{{ $certificate_item->id }}" />
                                        <span class="text-muted">#{{ $loop->index + 1 }}</span>
                                    </label>
                                </th>
                                <td class="text-center">{{ $certificate_item->coa_number }} </td>
                                <td class="text-center">{{ $certificate_item->sample?->sample_plant?->name }} </td>
                                <td class="text-center">{{ $certificate_item->client?->name ?? translate('not_Available') }} </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($certificate_item->generated_Date)->format('M d, Y') }}
                                </td> 
                                <td class="text-center">{{ $certificate_item->authorized_By?->name }} </td>
                                



                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.result.review', $certificate_item->result?->id) }}"
                                           class="btn btn-outline-info btn-sm" 
                                           title="{{ translate('View') }}">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        <a href="{{ route('certificate.download', $certificate_item->id) }}"
                                           class="btn btn-outline-primary btn-sm" 
                                           title="{{ translate('Download') }}">
                                            <i class="mdi mdi-download"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-success btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#sendEmailModal{{ $certificate_item->id }}"
                                                title="{{ translate('Send_Email') }}">
                                            <i class="mdi mdi-email"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Send Email Modal -->
                                    <div class="modal fade" id="sendEmailModal{{ $certificate_item->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ translate('Send_Certificate_via_Email') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('certificate.send_email', $certificate_item->id) }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ translate('Recipient_Email') }}</label>
                                                            <input type="email" name="email" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            {{ translate('Cancel') }}
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ translate('Send') }}
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse


                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $certificates->links() }}
            </div>
        </div>
    </div>

  
@endsection
@section('js')
    <script>
        $(document).on('click', '#export_certificate', function() {
            var certificate_id = $(this).data('id');
            $('input[name="certificate_id"]').val(certificate_id);
        });
    </script>
@endsection
