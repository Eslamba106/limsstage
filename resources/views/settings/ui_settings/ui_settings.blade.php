@extends('admin.layouts.dashboard')

@section('title', translate('ui_settings'  ))
@php
    $lang = Session::get('locale'); 
@endphp
@push('css_or_js')
<link href="{{ asset('public/assets/back-end') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ asset('assets/back-end') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ asset('assets/back-end/css/croppie.css') }}" rel="stylesheet">


    <!-- Custom styles for this page -->

    <style>
        #dataTable_wrapper>.row:nth-child(1) {
            display: flex;
        }

        #dataTable_wrapper>.row:nth-child(1) #dataTable_length {
            display: none;
        }

        [dir="rtl"] div.dataTables_wrapper div.dataTables_filter {
            text-align: left !important;
            padding-inline-end: 0px !important;
        }

        [dir="rtl"] div.table-responsive>div.dataTables_wrapper>div.row>div[class^="col-"]:last-child {
            padding-left: 0;
        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex gap-2">
                {{-- <img src="{{ asset(main_path() . 'back-end/img/inhouse-product-list.png') }}" alt=""> --}}
                {{ translate('ui_settings' ) }}
            </h2>
        </div> 
        <div class="row __mt-20">
            <div class="col-md-12">
                <div class="card" style="text-align: {{ Session::get('direction') === 'rtl' ? 'right' : 'left' }};">
                    <div class="card-header">
                        <h5>{{ translate('language_content_table' ,'ui_settings') }}</h5>
                        <a href="{{ route('admin.business-settings.language.index') }}"
                            class="btn btn-sm btn-danger btn-icon-split float-right">
                            <span class="text text-capitalize">{{ translate('back' ,'ui_settings') }}</span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="max-width: 100px">{{ translate('SL' ,'ui_settings') }}</th>
                                        <th style="width: 400px">{{ translate('key' ,'ui_settings') }}</th>
                                        <th style="min-width: 300px">{{ translate('value' ,'ui_settings') }}</th>
                                        <th style="max-width: 150px">{{ translate('update' ,'ui_settings') }}</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $lang = session()->get(
            'locale'
        ) ?? 'en';
    @endphp
@endsection


@push('script')
    <!-- Page level plugins -->
    {{-- <script src="{{ asset('public/assets/back-end') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('assets/back-end') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script> --}}
  
    <!-- Page level custom scripts -->
    <script>
        function update_lang(key, value) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.settings.ui_settings.update-submit', $position) }}",
                method: 'POST',
                data: {
                    key: key,
                    value: value
                },
                beforeSend: function() {
                    $('#loading').fadeIn();
                },
                success: function(response) {
                    toastr.success('{{ translate('text_updated_successfully') }}');
                },
                complete: function() {
                    $('#loading').fadeOut();
                },
            });
        }

        function remove_key(key, id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.settings.ui_settings.remove-key', [$position]) }}",
                method: 'POST',
                data: {
                    key: key
                },
                beforeSend: function() {
                    $('#loading').fadeIn();
                },
                success: function(response) {
                    toastr.success('{{ translate('key_removed_successfully' ) }}');
                    $('#lang-' + id).hide();
                },
                complete: function() {
                    $('#loading').fadeOut();
                },
            });
        }

        function auto_translate(key, id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.settings.ui_settings.auto-translate', [$position]) }}",
                method: 'POST',
                data: {
                    key: key
                },
                beforeSend: function() {
                    $('#loading').fadeIn();
                },
                success: function(response) {
                    toastr.success('{{ translate('key_translated_successfully' ) }}');
                    console.log(response.translated_data)
                    $('#value-' + id).val(response.translated_data);
                    //$('#value-' + id).text(response.translated_data);
                },
                complete: function() {
                    $('#loading').fadeOut();
                },
            });
        }
    </script>
 
     
<script>
    $(document).ready(function() {
        // Assume $position is available as a JavaScript variable, or passed from Blade
        // For example, if you pass it from Blade:
        const currentPosition = "{{ $position ?? 'default_position' }}"; // Replace 'default_position' with a sensible default or ensure it's always set

        $('#dataTable').DataTable({
            "processing": true, // Show a "Processing..." indicator
            "serverSide": false, // Set to true if you are doing server-side processing for large datasets
                               // For now, based on your controller, it seems client-side (all data at once)
            "pageLength": {{ \App\helper\Helpers::pagination_limit() ?? 10 }}, // Using your helper, with a fallback
            ajax: {
                type: "GET",
                // Construct the URL using your route and the position
                url: "{{ route('admin.settings.ui_settings.translate.list', ['position' => ':position']) }}".replace(':position', currentPosition),
                dataSrc: '' // Your controller returns a direct array of objects
            },
            language: {
                info: "{{ translate('Showing','ui_settings') }} _START_ {{ translate('To','ui_settings') }} _END_ {{ translate('Of','ui_settings') }} _TOTAL_ {{ translate('Entries','ui_settings') }}",
                infoEmpty: "{{ translate('Showing','ui_settings') }} 0 {{ translate('To','ui_settings') }} 0 {{ translate('Of','ui_settings') }} 0 {{ translate('Entries','ui_settings') }}",
                infoFiltered: "({{ translate('Filtered','ui_settings') }} _MAX_ {{ translate('Total_entries','ui_settings') }})",
                emptyTable: "{{ translate('No_data_found','ui_settings') }}",
                zeroRecords: "{{ translate('No_matching_data_found','ui_settings') }}",
                search: "{{ translate('Search','ui_settings') }}:",
                lengthMenu: "{{ translate('Show','ui_settings') }} _MENU_ {{ translate('Entries','ui_settings') }}",
                paginate: {
                    first: "{{ translate('First','ui_settings') }}",
                    last: "{{ translate('Last','ui_settings') }}",
                    next: "{{ translate('Next','ui_settings') }}",
                    previous: "{{ translate('Previous','ui_settings') }}"
                },
            },
            columns: [{
                    data: null, // For sequential number
                    className: "text-center",
                    render: function(data, type, row, meta) {
                        return meta.row + 1; // SL (Serial Number)
                    },
                    orderable: false, // Prevent sorting on SL column
                    searchable: false // Prevent searching on SL column
                },
                {
                    data: 'key', // Maps directly to $item->key
                    className: "text-center break-all" // Apply your classes
                },
                {
                    data: 'value', // Maps directly to $item->value
                    className: "text-center",
                    render: function(data, type, row, meta) {
                        // Render an input field for the 'value' column
                        // You'll need `meta.row` to create unique IDs for inputs
                        return `<input class="form-control w-100" id="value-${meta.row + 1}" value="${data}">`;
                    }
                },
                {
                    data: null, // For action buttons
                    className: "text-center",
                    orderable: false, // Actions column shouldn't be sortable
                    searchable: false, // Actions column shouldn't be searchable
                    render: function(data, type, row, meta) {
                        // `row` contains the full data object for the current row {key: '...', value: '...'}
                        return `
                            <div class="d-flex justify-content-center">
                                
                                <button type="button" onclick="update_lang('${row.key}', $('#value-${meta.row + 1}').val())"
                                        class="btn btn--primary">
                                    <i class="tio-save-outlined"></i> {{ translate('Save' ) }}
                                </button>
                            </div>
                        `;
                    }
                },
            ],
            // Optional: Adjust column widths to match your header if needed
            // "columnDefs": [
            //     { "width": "100px", "targets": 0 }, // SL
            //     { "width": "400px", "targets": 1 }, // Key
            //     { "width": "300px", "targets": 2 }, // Value
            //     { "width": "150px", "targets": 3 }  // Actions
            // ]
        });
    });

    // Make sure these functions are defined globally or before the script that uses them
    function auto_translate(key, rowId) {
        // Implement your auto-translate logic here
        // Example: Fetch translation from an API and update the input field
        console.log(`Auto-translating key: ${key} for row: ${rowId}`);
        // $('#value-' + rowId).val('New Auto-Translated Value');
        alert("Auto-translate function called for key: " + key);
    }

     function update_lang(key, value) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.settings.ui_settings.translate-submit',[$position])}}",
                method: 'POST',
                data: {
                    key: key,
                    value: value
                },
                beforeSend: function () {
                    $('#loading').fadeIn();
                },
                success: function (response) {
                    toastr.success('{{translate("text_updated_successfully" )}}');
                },
                complete: function () {
                    $('#loading').fadeOut();
                },
            });
        }
       
    </script>
@endpush
