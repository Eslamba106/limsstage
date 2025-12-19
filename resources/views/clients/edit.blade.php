@extends('layouts.dashboard')
@section('page-title')
    {{ translate('edit_Client') }}
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

    <style>
        .select2-container--default .select2-selection--multiple .select2-selectiontranslatechoice {
            background-color: #dedede;
            border: 1px solid #dedede;
            border-radius: 2px;
            color: #222;
            display: flex;
            gap: 4px;
            align-items: center;
        }
    </style>
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('edit_Client') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">{{ translate('dashboard.home') }} </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ translate('dashboard.dashboard') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <div class="mb-5"></div>
    <div class="container-fluid">


        <form action="{{ route('client.update' , $client->id) }}" method="POST">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex gap-2">
                                <h4 class="mb-0">{{ translate('basic_information') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6 col-lg-4 col-lg-6">

                                    <div class="form-group">
                                        <label for="">{{ translate('name') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name"  value="{{ $client->name }}" class="form-control" />

                                        @error('name')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4 col-lg-6">

                                    <div class="form-group">
                                        <label for="">{{ translate('email') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" value="{{ $client->email }}" class="form-control" />

                                        @error('email')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-4 col-lg-6">

                                    <div class="form-group">
                                        <label for="">{{ translate('phone') }} <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="phone" value="{{ $client->phone }}" class="form-control" />

                                        @error('phone')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                            </div>


                        </div>
                    </div>


                </div>
            </div>
            <div>
                <div class="form-group mt-2"
                    @if (session()->get('locale') == 'ar') style="text-align: left;" @else style="text-align: right;" @endif>
                    <button type="submit" class="btn btn-primary mt-2">{{ translate('save') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/select2.min.js') }}"></script>
@endsection
