@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale');
    $currentUrl = url()->current();
    $array = explode('/', $currentUrl);
    $id = end($array);
    ?>

    {{ translate('COA_Template_Assignment') }}
@endsection
@section('css')
    <link href="{{ asset(main_path() . 'css/select2.min.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #dedede;
            border: 1px solid #dedede;
            border-radius: 2px;
            color: #222;
            display: flex;
            gap: 4px;
            align-items: center;
        }
    </style>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-pass {
            background-color: #d1fae5;
            color: #059669;
        }

        .status-fail {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .status-warning {
            background-color: #fef3c7;
            color: #ca8a04;
        }
    </style>
@endsection

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('coa_template_designer') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ translate('home') }} </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ translate('dashboard') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>





    <div class="mt-5"></div>
    <section class="section">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.assign_template_designer') }}" method="Post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="coa_temp_id" value="{{ $id }}">

                            <div class="row">
                                <!-- Plant Assignment Section -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0">
                                                <i class="bi bi-building"></i> {{ translate('Plant_Assignment') }}
                                            </h5>
                                            <small>{{ translate('Assign_to_all_samples_in_plant') }}</small>
                                        </div>
                                        <div class="card-body">
                                            @if($plants->count() > 0)
                                                @foreach ($plants as $plant_item)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input plant-checkbox" 
                                                            type="checkbox" 
                                                            name="plant_id[]" 
                                                            id="plant_{{ $plant_item->id }}"
                                                            value="{{ $plant_item->id }}"
                                                            data-plant-id="{{ $plant_item->id }}">
                                                        <label class="form-check-label" for="plant_{{ $plant_item->id }}">
                                                            <strong>{{ $plant_item->name }}</strong>
                                                            <span class="text-muted">({{ translate('All_Sample_Points') }})</span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-muted">{{ translate('No_plants_available_for_assignment') }}</p>
                                            @endif

                                            @error('plant_id')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Sample Point Assignment Section -->
                                <div class="col-md-6 mb-4">
                                    <div class="card border-info">
                                        <div class="card-header bg-info text-white">
                                            <h5 class="mb-0">
                                                <i class="bi bi-geo-alt-fill"></i> {{ translate('Sample_Point_Assignment') }}
                                            </h5>
                                            <small>{{ translate('Assign_to_specific_sample_points') }}</small>
                                        </div>
                                        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                                            @if($samples->count() > 0)
                                                <div class="mb-2">
                                                    <input type="checkbox" id="select_all_samples" class="form-check-input">
                                                    <label for="select_all_samples" class="form-check-label">
                                                        <strong>{{ translate('Select_All') }}</strong>
                                                    </label>
                                                </div>
                                                <hr>
                                                @foreach ($samples as $sample_item)
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input sample-checkbox @error('sample_id') is-invalid @enderror"
                                                            type="checkbox" 
                                                            name="sample_id[]" 
                                                            id="sample_{{ $sample_item->id }}"
                                                            value="{{ $sample_item->id }}"
                                                            data-plant-id="{{ $sample_item->plant_id ?? '' }}">
                                                        <label class="form-check-label" for="sample_{{ $sample_item->id }}">
                                                            {{ $sample_item->sample_plant->name ?? 'N/A' }}
                                                            @if($sample_item->plant_main)
                                                                <small class="text-muted">({{ $sample_item->plant_main->name }})</small>
                                                            @endif
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-muted">{{ translate('No_samples_available_for_assignment') }}</p>
                                            @endif

                                            @error('sample_id')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                <strong>{{ translate('Note') }}:</strong> 
                                {{ translate('Sample_specific_assignments_take_priority_over_plant_level_assignments') }}
                            </div>

                            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}">


                            <div class="form-group col-6 @error('sample') is-invalid @enderror">
                                <label>{{ translate('sample') }}</label>
                                @foreach ($samples as $sample_item)
                                <input name="sample_id[]" class="form-control "  type="checkbox" required>
                                        <option value="{{ $sample_item->id }}">
                                            {{ $sample_item->sample_plant->name }}
                                        </option>
                                    </select>
                                    @endforeach

                                <input type="hidden" name="coa_temp_id" value="{{ $id }}">
                            </div> --}}
                            {{-- <div class="form-group col-6 @error('sample') is-invalid @enderror">
                                <label>{{ translate('sample') }}</label>
                                <select type="text" name="sample_id[]" class="form-control js-select2-custom" required
                                    multiple="multiple">
                                    <option value="" disabled selected>{{ translate("select_Sample") }}</option>

                                    @foreach ($samples as $sample_item)
                                        <option value="{{ $sample_item->id }}">{{ $sample_item->sample_plant->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="coa_temp_id" value="{{ $id }}">
                            </div> --}}

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $error }}
                                </div>
                            @enderror





                            <div class="mt-4 text-end">
                                <a href="{{ route('admin.template_designer') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> {{ translate('Cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> {{ translate('Save') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>







@endsection
@section('js')
    <script src="{{ asset(main_path() . 'js/select2.min.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <s cript src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            // Select all samples functionality
            $('#select_all_samples').on('change', function() {
                $('.sample-checkbox').prop('checked', $(this).is(':checked'));
            });

            // Warn if both plant and sample from same plant are selected
            $('.plant-checkbox, .sample-checkbox').on('change', function() {
                var selectedPlantIds = $('.plant-checkbox:checked').map(function() {
                    return $(this).data('plant-id');
                }).get();

                $('.sample-checkbox').each(function() {
                    var samplePlantId = $(this).data('plant-id');
                    if (selectedPlantIds.includes(samplePlantId.toString()) && $(this).is(':checked')) {
                        // Sample-specific takes priority, so this is fine
                        // But we can show a warning
                        console.log('Sample-specific assignment will take priority over plant-level assignment');
                    }
                });
            });

            // Form validation
            $('form').on('submit', function(e) {
                var hasPlantSelection = $('.plant-checkbox:checked').length > 0;
                var hasSampleSelection = $('.sample-checkbox:checked').length > 0;

                if (!hasPlantSelection && !hasSampleSelection) {
                    e.preventDefault();
                    alert('{{ translate('Please_select_at_least_one_plant_or_sample_point') }}');
                    return false;
                }
            });
        });
    </script>
@endsection
