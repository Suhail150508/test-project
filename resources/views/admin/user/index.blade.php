@extends('admin.layouts.master')

@section('title') @lang('user.index_title') @endsection

@section('css')
    [data-route~="user.destroy"][data-id~="{{auth()->user()->id}}"] {
        display: none;
    }

    .status_{{auth()->user()->id}}{
        display: none;
    }
@endsection

@section('thead')
    <tr>
        <th width="5%">#</th>
        <th>@lang('user.label_role_id')</th>
        <th>@lang('user.label_bn_name')</th>
        <th>@lang('user.label_email')</th>
        <th width="5%">@lang('user.label_status')</th>
        <th width="15%">@lang('user.label_action')</th>
    </tr>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title')@lang('user.index_title')@endslot
        @slot('create_button')
            <a href="{{route('user.create')}}" class="btn btn-primary btn-sm waves-effect waves-light">
                <i class="fa fa-plus-circle"></i> @lang('user.create_button_title')
            </a>
        @endslot
    @endcomponent
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
    <script src="{{ URL::asset('/assets/common/libs/datatables/datatables.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/common/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script type="text/javascript">
        window.onload = function(e){
            $(".destroy[data-id='{{Auth::user()->id}}']").hide()
        }

        let url = '';
        function clicked(id){
            url = '{{ route("user.index",["type" => '+id+']) }}';
        }

        let datatable_columns = [
            {data: 'DT_RowIndex',name:"DT_RowIndex", orderable: false, searchable: false},
            {data: 'role.bn_name',name: 'role.bn_name',defaultContent:''},
            {data: 'bn_name',name: 'bn_name',},
            {data: 'email',name: 'email',},
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
            { className: 'text-center', targets: [0,4,5] },
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
                url: '{{ route('user.index') }}',
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
                    url: '{{ route('user.deleted_list') }}',
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

        function statusChange(id){
            statusUpdate(id, '{{route('user.status')}}')
        }
    </script>

    @include('components.delete_script')

@endsection
