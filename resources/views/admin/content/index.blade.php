@extends('admin.layouts.master')

@section('title') @lang('content.index_title') @endsection

@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('title')@lang('content.index_title')@endslot
        @slot('create_button')
            <a href="{{route('content.create')}}" class="btn btn-primary btn-sm waves-effect waves-light">
                <i class="fa fa-plus-circle"></i> @lang('content.create_button_title')
            </a>
        @endslot
    @endcomponent

    @section('thead')
        <tr>
            <th width="5%">#</th>
            <th>@lang('content.label_name')</th>
            <th width="12%">@lang('content.label_action')</th>
        </tr>
    @endsection

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link text-primary active" id="all_btn_tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">
                @lang('common.index_list')
            </button>
        </li>
        @if(\App\Helpers\MenuHelper::CustomElementPermission('deleted_list'))
            <li class="nav-item" role="presentation">
                <button class="nav-link text-primary" id="deleted_btn_tab" data-bs-toggle="tab" data-bs-target="#deleted_list" type="button" role="tab" aria-controls="deleted" aria-selected="false">
                    @lang('common.deleted_list')
                </button>
            </li>
        @endif
    </ul>
    <div class="tab-content" id="myTabContent">
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
    {{--yajra datatable--}}
    <script type="text/javascript">
        let datatable_columns = [
            {data: 'DT_RowIndex',name:"DT_RowIndex", orderable: false, searchable: false},
            {data: 'name',name: 'name',},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
        let datatable_columns_defs = [
            {'bSortable': true, 'aTargets': [0,1]},
            {'bSearchable': false, 'aTargets': [0]},
            { className: 'text-center', targets: [0,2] },
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
                url: '{{ route('content.index') }}',
                type: 'get',
                dataType: 'JSON',
                cache: false,
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
                url: '{{ route('content.deleted_list') }}',
                type: 'get',
                dataType: 'JSON',
                cache: false,
            },
            columns: datatable_columns,
            search: {
                "regex": true
            },
            columnDefs: datatable_columns_defs,
        });
        @endif
    </script>

    @include('components.delete_script')
@endsection
