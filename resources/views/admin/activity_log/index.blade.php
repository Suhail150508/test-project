@extends('admin.layouts.master')

@section('title') @lang('activity_log.index_title') @endsection

@section('css')

@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title')@lang('activity_log.index_title')@endslot
    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered table-hover dt-responsive nowrap w-100">
                            <thead class="thead-dark">
                            <tr>
                                <th width="5%">#</th>
                                <th>@lang('activity_log.subject')</th>
                                <th>@lang('activity_log.description')</th>
                                <th>@lang('activity_log.created_by')</th>
                                <th width="5%">@lang('activity_log.date_time')</th>
                                <th width="12%">@lang('activity_log.action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection

@section('script')
    {{--yajra datatable--}}
    <script type="text/javascript">
        var updateThis ;
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            serverMethod: 'get',
            lengthMenu: [10, 25, 50,100],
            order: [ 0, "asc" ],
            language: {
                'loadingRecords': '&nbsp;',
                'processing': 'Loading ...'
            },
            ajax: {
                url: '{{ route('activity_log.index') }}',
                type: 'get',
                dataType: 'JSON',
                cache: false,
            },
            columns: [
                {data: 'DT_RowIndex',name:"DT_RowIndex", orderable: false, searchable: false},
                {data: 'log_name',name: 'log_name',},
                {data: 'description',name: 'description',},
                {data: 'created_by',name: 'created_by',},
                {data: 'date_time',name: 'date_time',},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            search: {
                "regex": true
            },
            columnDefs: [
                {'bSortable': true, 'aTargets': [0,1,2,3]},
                {'bSearchable': false, 'aTargets': [0]},
                { className: 'text-center', targets: [0,4] },
            ],
        });
    </script>

    @include('components.delete_script')

@endsection
