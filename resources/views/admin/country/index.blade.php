@extends('admin.layouts.master')

@section('title') @lang('common.index',['model' => trans('country.country')]) @endsection

@section('css')

@endsection

@section('thead')
    <tr>
        <th width="5%">#</th>
        <th>@lang('common.name',['model' => trans('country.country')])</th>
        <th>@lang('common.bn_name',['model' => trans('country.country')])</th>
        <th>@lang('country.code')</th>
        <th width="5%">@lang('common.status',['model' => trans('country.country')])</th>
        <th width="12%">@lang('common.action',['model' => trans('country.country')])</th>
    </tr>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title')@lang('common.index',['model' => trans('country.country')])@endslot
        @slot('create_button')
            <a href="{{route('country.create')}}" class="btn btn-primary btn-sm waves-effect waves-light">
                <i class="fa fa-plus-circle"></i> @lang('common.create',['model' => trans('country.country')])
            </a>
        @endslot
    @endcomponent

    <ul class="nav nav-tabs" id="Tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active text-primary" id="all_btn_tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">@lang('common.index_list',['model' => trans('country.country')])</button>
        </li>
        @if(\App\Helpers\MenuHelper::CustomElementPermission('deleted_list'))
            <li class="nav-item" role="presentation">
                <button class="nav-link text-primary" id="deleted_btn_tab" data-bs-toggle="tab" data-bs-target="#deleted_list" type="button" role="tab" aria-controls="deleted_list" aria-selected="false">@lang('common.deleted_list',['model' => trans('country.country')])</button>
            </li>
        @endif
    </ul>
    <div class="tab-content" id="TabContent">
        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <table id="datatable" class="table table-bordered table-hover dt-responsive nowrap w-100">
                                <thead class="thead-dark">
                                    @yield('thead')
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="deleted_list" role="tabpanel" aria-labelledby="deleted_list_tab">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <table id="deleted_list_datatable" class="table table-bordered table-hover dt-responsive nowrap w-100">
                                <thead class="thead-dark">
                                    @yield('thead')
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        let datatable_columns = [
            {data: 'DT_RowIndex',name:"DT_RowIndex", orderable: false, searchable: false},
            {data: 'name',name: 'name',},
            {data: 'bn_name',name: 'bn_name',},
            {data: 'code',name: 'code',},
            {data: 'status',name: 'status',},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]

        let datatable_columns_defs = [
            {'bSortable': true, 'aTargets': [0,1,2,3]},
            {'bSearchable': false, 'aTargets': [0]},
            { className: 'text-center', targets: [0,3,4] },
        ]
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
                url: '{{ route('country.index') }}',
                type: 'get',
                dataType: 'JSON',
                cache: true,
            },
            columns: datatable_columns,
            search: {
                "regex": true
            },
            columnDefs: datatable_columns_defs,
        });

        @if(\App\Helpers\MenuHelper::CustomElementPermission('deleted_list'))
            $('#deleted_list_datatable').DataTable({
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
                    url: '{{ route('country.deleted_list') }}',
                    type: 'get',
                    dataType: 'JSON',
                    cache: true,
                },
                columns: datatable_columns,
                search: {
                    "regex": true
                },
                columnDefs: datatable_columns_defs,
            });
        @endif

        function statusChange(id){
            statusUpdate(id, '{{route('country.status')}}')
        }
    </script>
    @include('components.delete_script')
@endsection
