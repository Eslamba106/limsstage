@extends('layouts.dashboard')
@section('title')
    {{ translate('report_generation_settings') }}
@endsection
@section('css')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('report_generation_settings') }}</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ translate('home') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ translate('dashboard') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="input-group mb-3 d-flex justify-content-end">
                    @can('coa_generation_settings')
                        <a href="{{ route('report_generation_setting.create') }}" class="btn btn-secondary mt-3 mr-2">
                            <i class="la la-plus"></i> {{ translate('create') }}
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
                        <th class="text-center" scope="col">{{ translate('setting_Name') }}</th>
                        <th class="text-center" scope="col">{{ translate('Frequency') }}</th>
                        <th class="text-center" scope="col">{{ translate('Execution_Time') }}</th>
                        <th class="text-center" scope="col">{{ translate('Report_Type') }}</th>
                        <th class="text-center" scope="col">{{ translate('Sample_Points') }}</th>
                        <th class="text-center" scope="col">{{ translate('Email_Recipients') }}</th>
                        <th class="text-center" scope="col">{{ translate('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($report_generation_settings as $setting)
                        <tr>
                            <th scope="row">
                                <label>
                                    <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                        value="{{ $setting->id }}" />
                                    <span class="text-muted">#{{ $loop->index + 1 }}</span>
                                </label>
                            </th>
                            <td class="text-center">{{ $setting->name }}</td>
                            <td class="text-center">{{ $setting->frequency_master?->name }}</td>
                            <td class="text-center">{{ $setting->execution_time }}</td>
                            <td class="text-center">
                                @if($setting->report_type == 1)
                                    <span class="badge bg-info">{{ translate('All_Results') }}</span>
                                @else
                                    <span class="badge bg-warning">{{ translate('Out_of_Spec_Only') }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @foreach ($setting->samples as $sample)
                                    {{ $sample->sample_plant?->name }}<br>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @foreach ($setting->emails as $email)
                                    {{ $email->email }}<br>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @can('coa_generation_settings')
                                    <a href="{{ route('report_generation_setting.edit', $setting->id) }}"
                                        class="btn btn-outline-info btn-sm" title="{{ translate('edit') }}">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <a href="{{ route('report_generation_setting.delete', $setting->id) }}"
                                        class="btn btn-danger btn-sm" 
                                        onclick="return confirm('{{ translate('Are_you_sure') }}?')"
                                        title="{{ translate('delete') }}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">{{ translate('No_Report_Generation_Settings_Found') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-3">
            {{ $report_generation_settings->links() }}
        </div>
    </div>
@endsection
