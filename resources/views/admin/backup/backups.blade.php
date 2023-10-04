@extends('admin.layouts.master')

@section('title') @lang('common.index',['model' => trans('backup.index_title')]) @endsection

@section('content')

    @component('components.breadcrumb')
        @slot('title')@lang('common.index',['model' => trans('backup.index_title')])@endslot
    @endcomponent

<h3>Database Backups</h3>
<div class="row">
    <div class="col-xs-12 clearfix">
        <form action="{{ url('admin/backup/create') }}" method="GET" class="add-new-backup CreateBackupForm" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="submit" name="submit" class="theme-button btn btn-primary pull-left" style="margin-bottom:2em;" value="Create Database Backup">
        </form>

        <form action="{{ url('admin/backup/clean') }}" method="GET" class="add-new-backup CleanBackupForm" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="submit" name="submit" class="theme-button btn btn-info" style="margin-bottom:2em;" value="Clean Backups">
        </form>
    </div>
    <div class="col-xs-12">
        @if (count($backups))
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>File Name</th>
                    <th>File Size</th>
                    <th>Created Date</th>
                    <th>Created Age</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($backups as $backup)
                    <tr>
                        <td>{{ $backup['file_name'] }}</td>
                        <td>{{ \App\Http\Controllers\Admin\BackupController::humanFilesize($backup['file_size']) }}</td>
                        <td>
                            {{ date('F jS, Y, g:ia (T)',$backup['last_modified']) }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($backup['last_modified'])->diffForHumans() }}
                        </td>
                        <td class="text-right">
                            <a class="btn btn-success" href="{{ url('admin/backup/download/'.$backup['file_name']) }}"><i class="fa fa-cloud-download"></i> Download</a>
                            <a class="btn btn-danger" onclick="return confirm('Do you really want to delete this file')" data-button-type="delete" href="{{ url('admin/backup/delete/'.$backup['file_name']) }}"><i class="fa fa-trash-o"></i> Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="well">
                <h4>No backups</h4>
            </div>
        @endif
    </div>
</div>
@endsection

@if(!request()->ajax()) @section('script') @endif
<script src="{{ URL::asset('/assets/common/libs/parsleyjs/parsleyjs.min.js') }}"></script>
<script src="{{ URL::asset('/assets/common/js/pages/form-validation.init.js') }}"></script>

<script type="text/javascript">
    $(".CreateBackupForm .CleanBackupForm").on('submit',function(e){
        $('.theme-button').attr('disabled','disabled');
    });
</script>
@if(!request()->ajax()) @endsection @endif