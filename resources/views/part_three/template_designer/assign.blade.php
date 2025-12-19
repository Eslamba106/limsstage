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

                            <div class="form-group col-6">
                                <label class="form-label">{{ translate('sample') }}</label>

                                @foreach ($samples as $sample_item)
                                    <div class="form-check">
                                        <input class="form-check-input @error('sample_id') is-invalid @enderror"
                                            type="checkbox" name="sample_id[]" id="sample_{{ $sample_item->id }}"
                                            value="{{ $sample_item->id }}"  >
                                        <label class="form-check-label" for="sample_{{ $sample_item->id }}">
                                            {{ $sample_item->sample_plant->name }}
                                        </label>
                                    </div>
                                @endforeach

                                @error('sample_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <input type="hidden" name="coa_temp_id" value="{{ $id }}">
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





                            <div class=" mt-4 text-end">
                                <button class="btn btn-primary">{{ trans('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>
    </section>







@endsection
@section('js')
    <script src="{{ asset(main_path() . 'js/select2.min.js') }}"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{-- <s cript src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            $('.select-sample').select2({
                placeholder: "{{ translate('select_Sample') }}",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection
