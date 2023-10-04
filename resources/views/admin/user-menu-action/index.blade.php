@extends('admin.layouts.master')

@section('title') @lang('user_menu_action/attribute.index_title') @endsection

@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('title')@lang('user_menu_action/attribute.index_title') ( {{$menu->name}} )@endslot
        @slot('create_button')
            <a href="{{route('user_menu_action.create',$menu->id)}}" class="btn btn-primary btn-sm waves-effect waves-light">
                <i class="fa fa-plus-circle"></i> @lang('user_menu_action/attribute.create_button_title')
            </a>
        @endslot
    @endcomponent

@section('thead')
    <tr>
        <th>Parent Menu</th>
        <th>Name</th>
        <th>Route Name</th>
        <th>Type</th>
        <th>Slug</th>
        <th width="110px">Order</th>
        <th width="110px">Status</th>
        <th width="150px">Action</th>
    </tr>
@endsection
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link text-primary active" id="all_btn_tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">
                @lang('common.index_list')
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link text-primary" id="deleted_btn_tab" data-bs-toggle="tab" data-bs-target="#deleted_list" type="button" role="tab" aria-controls="deleted" aria-selected="false">
                @lang('common.deleted_list')
            </button>
        </li>
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
            {data: 'parent_menu',name: 'parent_menu',},
            {data: 'name',name: 'name',},
            {data: 'route_name',name: 'route_name',},
            {data: 'type_name',name: 'type_name',},
            {data: 'slug',name: 'slug',},
            {data: 'order_by',name: 'order_by',},
            {data: 'status',name: 'status',},
            {
                data: 'action',
                name: 'action',
                orderable: false,
            },
        ]
        let datatable_columns_defs = [
            { className: 'text-center', targets: [0,3,4,5] },
        ]
        $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            serverMethod: 'get',
            lengthMenu: [10, 25, 50,100],
            order: [ 5, "asc" ],
            language: {
                'loadingRecords': '&nbsp;',
                'processing': 'Loading ...'
            },
            ajax: {
                url: '{{ route('user_menu_action.index',$menu->id) }}',
                type: 'get',
                dataType: 'JSON',
                cache: false,
            },
            columns: datatable_columns,
            columnDefs: datatable_columns_defs,
        });

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
                url: '{{ route('user_menu_action.deleted_list',$menu->id) }}',
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

        function statusChange(id){
            statusUpdate(id, '{{route('menu.status')}}')
        }
    </script>

    @include('components.delete_script')
@endsection
