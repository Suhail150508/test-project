@extends('admin.layouts.master')

@section('title') @lang('activity_log.show_title') @endsection

@section('css')

@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1_link'){{route('activity_log.index')}}@endslot
        @slot('li_1')@lang('activity_log.index_title')@endslot
        @slot('li_2')@lang('activity_log.show_title')@endslot
        @slot('title')@lang('activity_log.show_title')@endslot

    @endcomponent

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover dt-responsive nowrap w-100">
                            <tr>
                                <th>@lang('activity_log.date_time')</th>
                                <td colspan="3">{{date('d-m-Y  h:i a', strtotime($activity->created_at))}}</td>
                            </tr>
                            <tr>
                                <th>@lang('activity_log.subject')</th>
                                <td colspan="3">{{$activity->log_name}}</td>
                            </tr>
                            <tr>
                                <th>@lang('activity_log.created_by')</th>
                                <td colspan="3">{{$activity->causer->bn_name}}</td>
                            </tr>
                            <tr>
                                <th>@lang('activity_log.description')</th>
                                <td colspan="3">{{$activity->description}}</td>
                            </tr>
                            <tr>
                                <td>
                                    <h4>@lang('activity_log.properties_old')</h4>
                                    <table class="table table-info table-hover">
                                        <thead>
                                            <tr>
                                                <th>Field Name</th>
                                                <th>Original Value</th>
                                                {{--<th>Readable Value</th>--}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach( $activity->properties['old'] as $key => $value)
                                                @if($value != null)
                                                    <tr>
                                                        <td>{{$key}} </td>
                                                        <td>{{$value}}</td>
                                                        {{--
                                                            Getting PREVIOUS values which are already changed is problematic!!!
                                                        --}}
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>

                                <td>
                                    <h4>@lang('activity_log.properties_new')</h4>
                                    <table class="table table-info table-hover">
                                        <thead>
                                            <tr>
                                                <th>Field Name</th>
                                                <th>Original Value</th>
                                                <th>Readable Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach( $activity->properties['attributes'] as $key => $value)
                                                <tr>
                                                    <td>{{$key}} </td>
                                                    <td>{{$value}}</td>
                                                    <td>
                                                        @if(count(explode('_',$key)) > 1 && $value != null)
                                                            @if(explode('_',$key)[count(explode('_',$key))-1] == 'id')
                                                                <p>[{{ \App\Helpers\CommonHelper::find_relation($activity->subject,explode('_id',$key)[0]) }}]</p>
                                                            @elseif(explode('_',$key)[count(explode('_',$key))-1] == 'by')
                                                                <p>[{{ \App\Helpers\CommonHelper::find_relation($activity->subject,explode('_by',$key)[0].'By') }}]</p>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection
