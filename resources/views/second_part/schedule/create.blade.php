@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ __('roles.submission_managment') }}
@endsection
@section('css')
    <style>
        .card-header {
            cursor: pointer;
        }

        .toggle-switch {
            width: 40px;
            height: 20px;
        }

        .test-toggle {
            margin-left: auto;
        }

        .test-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .test-method {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-lab {
            color: #0d6efd;
        }
    </style>
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.submission_managment') }}</h4>
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
    <div class="mb-5"></div>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <form action="{{ route('admin.submission.schedule.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4 class="mb-0">{{ __('roles.sample_information') }}</h4>
                            </div>
                        </div>
                        <div class="card-body bg-light">
                            <div class="row ">

                                <div class="col-md-6   col-lg-6">
                                    <div class="form-group">
                                        <label for="">{{ __('samples.plant_name') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="plant_id" class="form-control" required>
                                            <option value="">{{ __('samples.select_plant') }}</option>
                                            @foreach ($plants as $plant_item)
                                                <option value="{{ $plant_item->id }}">{{ $plant_item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('plant_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6   col-lg-6">
                                    <div class="form-group">
                                        <label for="">{{ __('samples.sub_plant_name') }} </label>
                                        <select name="sub_plant_id" class="form-control" disabled>
                                            <option value="">{{ __('samples.select_sub_plant') }}</option>
                                        </select>
                                        @error('sub_plant_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row align-items-center mb-3 ">
                                <div class="col-md-6   col-lg-6">
                                    <div class="form-group">
                                        <label for="">{{ __('samples.sample_name') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="plant_sample_id" class="form-control" required disabled
                                            onchange="add_test_methods(this)">
                                            <option value="">{{ __('samples.select_sub_plant') }}</option>
                                        </select>
                                        @error('plant_sample_id')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div> --}}


                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4><i class="bi bi-geo-alt-fill text-primary"></i> Sample Points</h4>
                            </div>
                        </div>

                        <div class="card-body bg-light">
                            <div class="row " id="sample-point-form">
                                {{-- <div class="container bg-white p-4 rounded shadow   col-lg-12">
                                    <div class="card mb-3">
                                        <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                            <div>
                                                <strong>Water Treatment Plant</strong><br>
                                                <small class="text-muted">Location: Building A</small>
                                            </div>
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="badge bg-primary">4 Tests</span>
                                                <div class="form-check form-switch m-0">
                                                    <input class="form-check-input" type="checkbox">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body p-2">
                                            <div class="row text-muted mb-2">
                                                <div class="col-3">Test Method</div>
                                                <div class="col-3">Frequency</div>
                                                <div class="col-3">Schedule</div>
                                                <div class="col-3">Status</div>
                                            </div>
                                            <div class="row align-items-center mb-2">
                                                <div class="col-3 test-method">
                                                    <i class="bi bi-beaker icon-lab"></i> pH Analysis
                                                </div>
                                                <div class="col-3">Every 2 Hours</div>
                                                <div class="col-3">08:00, 14:00</div>
                                                <div class="col-3 d-flex align-items-center">
                                                    <div class="form-check form-switch me-2">
                                                        <input class="form-check-input" type="checkbox">
                                                    </div>
                                                    <i class="bi bi-gear-fill"></i>
                                                </div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="col-3 test-method">
                                                    <i class="bi bi-beaker icon-lab"></i> Turbidity Test
                                                </div>
                                                <div class="col-3">Daily</div>
                                                <div class="col-3">09:00</div>
                                                <div class="col-3 d-flex align-items-center">
                                                    <div class="form-check form-switch me-2">
                                                        <input class="form-check-input" type="checkbox">
                                                    </div>
                                                    <i class="bi bi-gear-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                    </div>
                    <div>
                        <div class="form-group mt-2"
                            @if (session()->get('locale') == 'ar') style="text-align: left;" @else style="text-align: right;" @endif>
                            <button type="submit" class="btn btn-primary mt-2">{{ __('general.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        /**
         * Render a sample card with test methods.
         * @param {Object} sample - Sample data object
         * @param {number} sampleIndex - Index for unique IDs
         * @param {string|null} subPlantName - Sub plant name if applicable
         * @returns {string} HTML string for the sample card
         */
        function renderSampleCard(sample, sampleIndex, subPlantName) {
            var id = 'sample_' + sampleIndex;
            let testMethodsHtml = '';

            // Check if test_methods exists and is an array
            if (sample.test_methods && Array.isArray(sample.test_methods) && sample.test_methods.length > 0) {
                sample.test_methods.forEach((test_method_item, testIndex) => {
                    // Safely access master_test_method
                    var testMethodName = test_method_item?.master_test_method?.name || 'Unknown';
                    var testMethodId = test_method_item?.master_test_method?.id || test_method_item
                        ?.test_method_id || '';

                    testMethodsHtml += `
                        <div class="row align-items-center mb-2">
                            <div class="col-3 test-method">
                                <i class="bi bi-beaker icon-lab"></i> ${testIndex + 1}. ${testMethodName}
                            </div>
                            <div class="col-3">
                                <select name="frequency_id-${sample.id}-${testMethodId}" class="form-control" required>
                                    @foreach ($frequencies as $frequency)
                                        <option value="{{ $frequency->id }}">{{ $frequency->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <input class="form-control" name="schedule_hour-${sample.id}-${testMethodId}" type="time" step="60">
                            </div>
                            <div class="col-3 d-flex align-items-center">
                                <div class="me-2">
                                    <input class="form-check-input test-method-checkbox" type="checkbox" value="${testMethodId}" name="test_method_id[${sample.id}][]" data-sample-id="${sample.id}">
                                </div>
                                <i class="bi bi-gear-fill"></i>
                            </div>
                        </div>
                    `;
                });
            } else {
                testMethodsHtml = '<p class="text-warning">No test methods available for this sample</p>';
            }

            var samplePlantName = sample?.sample_plant?.name || 'Unknown';
            var testCount = sample.test_methods ? sample.test_methods.length : 0;

            return `
                <div class="container bg-white p-4 rounded shadow col-lg-12 mb-3">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center bg-light">
                            <div>
                                <strong>${samplePlantName}</strong><br>
                                <small class="text-muted">Location: ${subPlantName || 'Main Plant'}</small>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge bg-primary">${testCount} Tests</span>
                                <div class="m-0">
                                    <input class="form-check-input sample-point-checkbox" type="checkbox" name="sample_points[]" value="${sample.id}" id="${id}" data-sample-id="${sample.id}" checked>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-2">
                            <div class="row text-muted mb-2">
                                <div class="col-3">{{ __('test_method.test_method') }}</div>
                                <div class="col-3">Frequency</div>
                                <div class="col-3">Schedule</div>
                                <div class="col-3">Status</div>
                            </div>
                            ${testMethodsHtml}
                        </div>
                    </div>
                </div>
            `;
        }

        $(document).on('change', 'select[name=plant_id]', function() {
            var select = $(this);
            var methodsContainer = $('#sample-point-form');
            var plantId = select.val();

            if (plantId) {
                // Show loading indicator
                methodsContainer.html(
                    '<div class="text-center p-4"><i class="fa fa-spinner fa-spin"></i> Loading samples...</div>'
                );

                $.ajax({
                    url: "{{ route('admin.submission.schedule.get_sample_by_plant_id', ':id') }}".replace(
                        ':id', plantId),
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log('AJAX Response:', response); // Debug log
                        methodsContainer.empty();

                        // Check response structure
                        if (!response || !response.success || !response.data) {
                            console.error('Invalid response:', response);
                            methodsContainer.html(
                                '<p class="text-danger">Error: Invalid response from server</p>');
                            return;
                        }

                        var sampleIndex = 0;
                        var data = response.data;

                        // Render main plant samples first (if any)
                        if (data.main_plant && data.main_plant.samples && Array.isArray(data.main_plant
                                .samples)) {
                            if (data.main_plant.samples.length > 0) {
                                var mainPlantHeader = `
                                    <div class="container bg-info bg-opacity-10 p-3 rounded mb-3">
                                        <h5 class="mb-0"><i class="bi bi-building"></i> ${data.main_plant.name} (Main Plant)</h5>
                                    </div>
                                `;
                                methodsContainer.append(mainPlantHeader);

                                data.main_plant.samples.forEach(function(sample) {
                                    console.log('Rendering main plant sample:',
                                        sample); // Debug log
                                    methodsContainer.append(renderSampleCard(sample,
                                        sampleIndex++, null));
                                });
                            }
                        }

                        // Render sub plants with their samples
                        if (data.sub_plants && Array.isArray(data.sub_plants) && data.sub_plants
                            .length > 0) {
                            data.sub_plants.forEach(function(subPlant) {
                                if (subPlant.samples && Array.isArray(subPlant.samples) &&
                                    subPlant.samples.length > 0) {
                                    var subPlantHeader = `
                                        <div class="container bg-secondary bg-opacity-10 p-3 rounded mb-3 mt-4">
                                            <h5 class="mb-0"><i class="bi bi-building-fill"></i> ${subPlant.name} (Sub Plant)</h5>
                                        </div>
                                    `;
                                    methodsContainer.append(subPlantHeader);

                                    subPlant.samples.forEach(function(sample) {
                                        console.log('Rendering sub plant sample:',
                                            sample); // Debug log
                                        methodsContainer.append(renderSampleCard(sample,
                                            sampleIndex++, subPlant.name));
                                    });
                                }
                            });
                        }

                        // If no samples found
                        if (sampleIndex === 0) {
                            methodsContainer.html(
                                '<p class="text-warning">No samples found for this plant. Please make sure the plant has samples.</p>'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', xhr, status, error);
                        methodsContainer.html(
                            '<p class="text-danger">Failed to load samples. Please try again.</p>');
                    }
                });
            } else {
                methodsContainer.empty();
            }
        });

        // Handle sub plant selection - same logic as main plant
        $(document).on('change', 'select[name=sub_plant_id]', function() {
            var select = $(this);
            var methodsContainer = $('#sample-point-form');
            var subPlantId = select.val();

            if (subPlantId) {
                // Show loading indicator
                methodsContainer.html(
                    '<div class="text-center p-4"><i class="fa fa-spinner fa-spin"></i> Loading samples...</div>'
                );

                $.ajax({
                    url: "{{ route('admin.submission.schedule.get_sample_by_plant_id', ':id') }}".replace(
                        ':id', subPlantId),
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log('AJAX Response (Sub Plant):', response); // Debug log
                        methodsContainer.empty();

                        // Check response structure
                        if (!response || !response.success || !response.data) {
                            console.error('Invalid response:', response);
                            methodsContainer.html(
                                '<p class="text-danger">Error: Invalid response from server</p>');
                            return;
                        }

                        var sampleIndex = 0;
                        var data = response.data;

                        // Render sub plant samples
                        if (data.sub_plants && Array.isArray(data.sub_plants) && data.sub_plants
                            .length > 0) {
                            data.sub_plants.forEach(function(subPlant) {
                                if (subPlant.samples && Array.isArray(subPlant.samples) &&
                                    subPlant.samples.length > 0) {
                                    var subPlantHeader = `
                                        <div class="container bg-secondary bg-opacity-10 p-3 rounded mb-3">
                                            <h5 class="mb-0"><i class="bi bi-building-fill"></i> ${subPlant.name} (Sub Plant)</h5>
                                        </div>
                                    `;
                                    methodsContainer.append(subPlantHeader);

                                    subPlant.samples.forEach(function(sample) {
                                        console.log('Rendering sub plant sample:',
                                            sample); // Debug log
                                        methodsContainer.append(renderSampleCard(sample,
                                            sampleIndex++, subPlant.name));
                                    });
                                }
                            });
                        }

                        // If no samples found
                        if (sampleIndex === 0) {
                            methodsContainer.html(
                                '<p class="text-warning">No samples found for this sub plant. Please make sure the sub plant has samples.</p>'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', xhr, status, error);
                        methodsContainer.html(
                            '<p class="text-danger">Failed to load samples. Please try again.</p>');
                    }
                });
            } else {
                methodsContainer.empty();
            }
        });

        // Enable/disable test method checkboxes and inputs based on sample point checkbox
        $(document).on('change', '.sample-point-checkbox', function() {
            var sampleId = $(this).data('sample-id');
            var isChecked = $(this).is(':checked');

            // Find all test method checkboxes and inputs for this sample
            $(this).closest('.card').find('.test-method-checkbox, select[name^="frequency_id-' + sampleId +
                '-"], input[name^="schedule_hour-' + sampleId + '-"]').prop('disabled', !isChecked);

            // Uncheck test method checkboxes if sample point is unchecked
            if (!isChecked) {
                $(this).closest('.card').find('.test-method-checkbox').prop('checked', false);
            }
        });

        // Validate form before submission
        $('form').on('submit', function(e) {
            var checkedSamplePoints = $('input[name="sample_points[]"]:checked').length;

            if (checkedSamplePoints === 0) {
                e.preventDefault();
                alert('{{ __('general.please_select_at_least_one_sample_point') }}');
                return false;
            }

            // Check if at least one test method is selected for each checked sample point
            var hasError = false;
            $('input[name="sample_points[]"]:checked').each(function() {
                var sampleId = $(this).data('sample-id');
                var checkedTestMethods = $(this).closest('.card').find('input[name="test_method_id[' +
                    sampleId + '][]"]:checked').length;

                if (checkedTestMethods === 0) {
                    hasError = true;
                    return false;
                }
            });

            if (hasError) {
                e.preventDefault();
                alert('{{ __('general.please_select_at_least_one_test_method_for_each_sample_point') }}');
                return false;
            }
        });
    </script>
    <script>
        $('select[name=plant_id]').on('change', function() {
            var tenant_id = $(this).val();
            if (tenant_id) {
                $.ajax({
                    url: "{{ route('admin.sample.get_sub_from_plant', ':id') }}".replace(':id',
                        tenant_id),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('select[name="sub_plant_id"]').empty().prop('disabled', true);
                            $('select[name="plant_sample_id"]').empty().prop('disabled', true);
                            if (data && data.plants && data.plants.length > 0) {
                                $('select[name="sub_plant_id"]').empty().prop('disabled', false);
                                var select = $('select[name="sub_plant_id"]');
                                select.empty().prop('disabled', false);
                                select.append(
                                    '<option value="">{{ __('samples.select_sub_plant') }}</option>'
                                );
                                $.each(data.plants, function(index, plant) {
                                    select.append('<option value="' + plant.id + '">' + plant
                                        .name + '</option>');
                                });
                                if (data.samples && data.samples.length > 0) {
                                    var select = $('select[name="plant_sample_id"]');
                                    select.empty().prop('disabled', false);
                                    select.append(
                                        '<option value="">{{ __('samples.select_sample') }}</option>'
                                    );

                                    $.each(data.samples, function(index, sample) {
                                        select.append('<option value="' + sample.id + '">' +
                                            sample
                                            .name + '</option>');
                                    });

                                }
                            } else if (data && data.samples && data.samples.length > 0) {
                                $('select[name="plant_sample_id"]').empty().prop('disabled', false);
                                var select = $('select[name="plant_sample_id"]');
                                select.empty().prop('disabled', false);
                                select.append(
                                    '<option value="">{{ __('samples.select_sample') }}</option>'
                                );
                                $.each(data.samples, function(index, sample) {
                                    select.append('<option value="' + sample.id + '">' + sample
                                        .name + '</option>');
                                });

                            }


                        } else {}
                    },
                    error: function(xhr, status, error) {
                        console.error('Error occurred:', error);
                    }
                });
            }
        })
        $('select[name=sub_plant_id]').on('change', function() {
            var tenant_id = $(this).val();
            if (tenant_id) {
                $.ajax({
                    url: "{{ route('admin.sample.get_sample_from_plant', ':id') }}".replace(':id',
                        tenant_id),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('select[name="plant_sample_id"]').empty().prop('disabled', true);
                            if (data && data.samples && data.samples.length > 0) {
                                $('select[name="plant_sample_id"]').empty().prop('disabled', false);
                                var select = $('select[name="plant_sample_id"]');
                                select.empty().prop('disabled', false);
                                select.append(
                                    '<option value="">{{ __('samples.select_sample') }}</option>');
                                $.each(data.samples, function(index, sample) {
                                    select.append('<option value="' + sample.id + '">' + sample
                                        .name + '</option>');
                                });

                            }


                        } else {}
                    },
                    error: function(xhr, status, error) {
                        console.error('Error occurred:', error);
                    }
                });
            }
        })
    </script>
@endsection
