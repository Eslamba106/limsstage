@extends('layouts.dashboard')
@section('title')
    {{ translate('COA_Template_Assignment') }}
@endsection
@section('css')
    <link href="{{ asset(main_path() . 'css/select2.min.css') }}" rel="stylesheet" />
    <style>
        .assignment-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: box-shadow 0.3s;
        }
        .assignment-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .badge-active {
            background-color: #28a745;
            color: white;
        }
        .badge-inactive {
            background-color: #6c757d;
            color: white;
        }
        .badge-plant {
            background-color: #007bff;
            color: white;
        }
        .badge-sample {
            background-color: #17a2b8;
            color: white;
        }
    </style>
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('COA_Template_Assignment') }}</h4>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ translate('home') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ translate('COA_Template_Assignment') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Templates Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ translate('COA_Templates') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>{{ translate('Template_Name') }}</th>
                                <th>{{ translate('Plant_Assignments') }}</th>
                                <th>{{ translate('Sample_Point_Assignments') }}</th>
                                <th>{{ translate('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($templates as $template)
                                <tr>
                                    <td>
                                        <strong>{{ $template->name }}</strong>
                                    </td>
                                    <td>
                                        @php
                                            $plantAssignments = $template->plants;
                                        @endphp
                                        @if($plantAssignments->count() > 0)
                                            @foreach($plantAssignments as $plant)
                                                <span class="badge badge-plant me-1 mb-1">
                                                    {{ $plant->name }}
                                                    @if($plant->pivot->is_active)
                                                        <span class="badge badge-active">Active</span>
                                                    @else
                                                        <span class="badge badge-inactive">Inactive</span>
                                                    @endif
                                                    <a href="{{ route('admin.toggle_plant_assignment', [$template->id, $plant->id]) }}" 
                                                       class="text-white ms-1" title="Toggle Status">
                                                        <i class="bi bi-toggle-{{ $plant->pivot->is_active ? 'on' : 'off' }}"></i>
                                                    </a>
                                                    <a href="{{ route('admin.delete_plant_assignment', [$template->id, $plant->id]) }}" 
                                                       class="text-white ms-1" 
                                                       onclick="return confirm('{{ translate('Are_you_sure_you_want_to_delete_this_assignment') }}?')"
                                                       title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">{{ translate('No_Plant_Assignments') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $sampleAssignments = $template->samples;
                                        @endphp
                                        @if($sampleAssignments->count() > 0)
                                            @foreach($sampleAssignments as $sample)
                                                <span class="badge badge-sample me-1 mb-1">
                                                    {{ $sample->sample_plant->name ?? 'N/A' }}
                                                    @if($sample->pivot->is_active)
                                                        <span class="badge badge-active">Active</span>
                                                    @else
                                                        <span class="badge badge-inactive">Inactive</span>
                                                    @endif
                                                    <a href="{{ route('admin.toggle_sample_assignment', [$template->id, $sample->id]) }}" 
                                                       class="text-white ms-1" title="Toggle Status">
                                                        <i class="bi bi-toggle-{{ $sample->pivot->is_active ? 'on' : 'off' }}"></i>
                                                    </a>
                                                    <a href="{{ route('admin.delete_sample_assignment', [$template->id, $sample->id]) }}" 
                                                       class="text-white ms-1" 
                                                       onclick="return confirm('{{ translate('Are_you_sure_you_want_to_delete_this_assignment') }}?')"
                                                       title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">{{ translate('No_Sample_Assignments') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.assign_template_designer_page', $template->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-plus-circle"></i> {{ translate('Assign') }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">{{ translate('No_Templates_Found') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset(main_path() . 'js/select2.min.js') }}"></script>
@endsection
