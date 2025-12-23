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

    <form action="" method="get">

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
                                    
                                     <a href="{{ route('admin.result.review', $certificate_item->result?->id) }}"
                                            class="btn btn-outline-success btn-sm" title="@lang('results.confirm_results')"><i
                                                class="mdi mdi-file"></i> </a>
                                     
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
        $(document).on('click', '#export_certificate', function() {
            var certificate_id = $(this).data('id');
            $('input[name="certificate_id"]').val(certificate_id);
        });
    </script>
@endsection
