@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale');
    $currentUrl = url()->current();
    $array = explode('/', $currentUrl);
    $id = end($array);
    ?>

    {{ translate('COA_Template_Assignment') }}
@endsection
@section('content')
    {{-- <div class="page-breadcrumb">
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
    </div> --}}

    {{-- <section class="section"> --}}
    <div class="mb-5"></div>
    <div class="container-fluid">

        <h2 class="mb-4">{{ translate('COA_Generation_Settings') }}</h2>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('coa-settings.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">{{ translate('Setting_Name') }}</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">{{ translate('Frequency') }}</label>
                            <select name="frequency" class="form-select" required>
                                <option value="every_4_hours">{{ translate('Every 4 Hours') }}</option>
                                <option value="daily">{{ translate('Daily') }}</option>
                                <option value="weekly">{{ translate('Weekly') }}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ translate('Day') }}</label>
                            <select name="day" class="form-select" required>
                                <option value="every_day">{{ translate('Every_Day') }}</option>
                                <option value="monday">{{ translate('Monday') }}</option>
                                <option value="tuesday">{{ translate('Tuesday') }}</option>
                                <!-- Add rest of days -->
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ translate('Execution_Time') }}</label>
                            <input type="time" name="execution_time" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ translate('Generation_Conditions') }}</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="condition" value="authorized_email"
                                required>
                            <label class="form-check-label">{{ translate('Generate_&_email_COA_when_status_is_authorized') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="condition"
                                value="authorized_and_within_spec_email">
                            <label class="form-check-label">{{ translate('Generate_&_email_COA_only_if_authorized_and_all_test_methods_are_within_spec') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="condition" value="authorized">
                            <label class="form-check-label">{{ translate('Generate_COA_when_status_is_authorized') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="condition"
                                value="authorized_and_within_spec">
                            <label class="form-check-label">{{ translate('Generate_COA_only_if_authorized_and_all_test_methods_are_within_spec') }}</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ translate('Sample_Points') }}</label>
                        <select name="sample_points[]" class="form-select" multiple required>
                            @foreach ($samplePoints as $point)
                                <option value="{{ $point->id }}">{{ $point->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Recipients</label>
                        <input type="email" name="email_recipients" class="form-control"
                            placeholder="Comma-separated emails" required>
                    </div>

                    <div class=" mt-4 text-end">
                        <button class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- </section> --}}
@endsection
@section('js')
@endsection
