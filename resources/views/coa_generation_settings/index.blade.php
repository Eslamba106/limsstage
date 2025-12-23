@extends('layouts.dashboard')
@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ translate('coa_generation_settings') }}
@endsection
@section('css')
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> --}}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ translate('coa_generation_settings') }}</h4>
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

    <form action="" method="get">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="input-group mb-3 d-flex justify-content-end">

                        @can('coa_generation_settings')
                            <a href="{{ route('coa_generation_setting.create') }}" class="btn btn-secondary mt-3 mr-2">
                                <i class="la la-refresh"></i> {{ translate('create') }}
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
                            {{-- <th class="text-center" scope="col">{{ translate('Generation_Conditions') }}</th> --}}
                            <th class="text-center" scope="col">{{ translate('Sample') }}</th>
                            <th class="text-center" scope="col">{{ translate('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($coa_generation_settings as $coa_generation_settings_item)
                            <tr>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                            value="{{ $coa_generation_settings_item->id }}" />
                                        <span class="text-muted">#{{ $loop->index + 1 }}</span>
                                    </label>
                                </th>
                                <td class="text-center">{{ $coa_generation_settings_item->name }} </td>

                                <td class="text-center">{{ $coa_generation_settings_item->frequency_master?->name }} </td>
                                <td class="text-center">{{ $coa_generation_settings_item->execution_time }} </td>
                                {{-- <td class="text-center">{{ $coa_generation_settings_item->execution_time }} </td> --}}
                                <td class="text-center">
                                    @foreach ($coa_generation_settings_item->sample as $sample)
                                        {{ $sample->sample_plant?->name }}<br>
                                    @endforeach
                                </td>





                                <td class="text-center">
                                    @can('delete_coa_generation_setting')
                                        <a href="{{ route('coa_generation_setting.delete', $coa_generation_settings_item->id) }}"
                                            class="btn btn-danger btn-sm" title="{{ translate('delete') }}"><i
                                                class="fa fa-trash"></i></a>
                                    @endcan
                                    @can('edit_coa_generation_setting')
                                        <a href="{{ route('coa_generation_setting.edit', $coa_generation_settings_item->id) }}"
                                            class="btn btn-outline-info btn-sm" title="{{ translate('edit') }}"><i
                                                class="mdi mdi-pencil"></i> </a>
                                    @endcan
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
        // $('#statusSwitch').on('change', function() {
        //     if ($(this).is(':checked')) {
        //         console.log('Status: ON');
        //     } else {
        //         console.log('Status: OFF');
        //     }
        // });
    </script>
    <script>
        $('.status_form').on('submit', function(event) {
            event.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "",
                method: 'POST',
                data: $(this).serialize(),
                success: function(data) {
                    if (data.success == true) {
                        toastr.success('{{ translate('updated_successfully') }}');
                    } else if (data.success == false) {
                        toastr.error(
                            '{{ translate('Status_updated_failed.') }} {{ translate('Product_must_be_approved') }}'
                        );
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    }
                }
            });
        });
    </script>
@endsection
