@extends('admin.layouts.pdf')

@section('title') @lang('application.office_order') @endsection

@section('content')
    <div class="text-center">"@lang('application.office_order')"</div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td style="padding-bottom: -15px">
                                @lang('application.memorandum_no_title')
                                <span>{{$office_order->memorandum_no}}</span>
                            </td>
                            <td class="text-right" style="padding-bottom: -15px">
                                তারিখঃ {{ \App\Helpers\ENTOBN::convert_to_bangla(date('d-m-Y'))}} খ্রিঃ
                            </td>
                        </tr>
                    </table>

                    <table class="table">
                        <tr>
                            <td style="padding-bottom: -15px">
                                @if($application->type == 'proposed')
                                    {!! \App\Models\Content::getContent()['inspection_order']['content_1'] !!}
                                @elseif($application->type == 'existing')
                                    {!! \App\Models\Content::getContent()['inspection_order_existing']['content_1'] !!}
                                @endif
                            </td>
                        </tr>
                    </table>

                    <table class="table" style="margin-left: 10px;margin-right: 20px">
                        @foreach($application->application_committees as $key=>$committee)
                            <tr>
                                <td>
                                    {{\App\Helpers\ENTOBN::convert_to_bangla($key+1)}}.
                                    {{$committee->designation->bn_name}},
                                  
                                    @if($committee->office)
                                        {{$committee->office->bn_name}}
                                        @if($committee->district || $committee->user->division),@endif
                                    @endif

                                    @if($committee->district)
                                        {{$committee->district->bn_name}}
                                    @elseif($committee->user->division)
                                        {{$committee->user->division->bn_name}}
                                    @endif
                                </td>
                                <td class="text-right">{{$committee->membership->bn_name}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td style="padding-bottom: -15px">
                                {{\App\Helpers\ENTOBN::convert_to_bangla(($application->application_committees->count() > 0) ? @$key+2: 1)}}
                                . @lang('application.warehouse_inspector_related')
                            </td>
                            <td class="text-right"
                                style="padding-bottom: -15px">@lang('application.warehouse_member')</td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr>
                            <td style="padding-bottom: -15px">
                                @if($application->type == 'proposed')
                                    {!! \App\Models\Content::getContent()['inspection_order']['content_2'] !!}
                                @elseif($application->type == 'existing')
                                    {!! \App\Models\Content::getContent()['inspection_order_existing']['content_2'] !!}
                                @endif
                            </td>
                        </tr>
                    </table>

                    @if($application->type == 'existing')
                        <table class="table">
                            <tr>
                                <td class="text-center" style="padding-bottom: -15px">
                                    <h4>@lang('application.graph_a')</h4>
                                </td>
                            </tr>
                        </table>
                    @endif

                    <table class="table table-bordered" style="margin-bottom: 0px">
                        <tr>
                            <th class="text-center" width="80px">@lang('application.serial_no')</th>
                            <th class="text-center">@lang('application.owner_applicants_info')</th>
                            <th class="text-center">
                                @if($application->type == 'proposed')
                                    @lang('application.proposed_building_address')
                                @elseif($application->type == 'existing')
                                    @lang('application.existing_building_address')
                                @endif
                            </th>
                            @if($application->type != 'existing')
                                <th class="text-center">@lang('application.building_type')</th>
                            @endif
                        </tr>
                        <tr>
                            <td>{{\App\Helpers\ENTOBN::convert_to_bangla(1)}}.</td>
                            <td> {{ $application->owner_name ?? '' }}
                                <br>
                                {{ $application->owner_address_details ?? '' }}
                                , {{ $application->owner_address_thana->bn_name ?? '' }}
                                , {{ $application->owner_address_district->bn_name ?? '' }}
                                <br>
                                @lang('application.mobile_title')  {{\App\Helpers\ENTOBN::convert_to_bangla($application->owner_mobile)}}
                            </td>
                            <td>
                                @lang('application.building_no')- {{$application->building_no ?? trans('application.not_required')}}<br>
                                @lang('application.road_no') - {{$application->road_no ?? trans('application.not_required')}}<br>
                                @lang('application.address') - {{$application->address}} <br>
                                @lang('application.thana') - {{$application->building_thana->bn_name}},
                                @lang('application.district')- {{$application->building_district->bn_name}}
                            </td>
                            @if($application->type != 'existing')
                                <td width="200px">
                                    {{ \App\Helpers\ENTOBN::convert_to_bangla($application->existing_buildings->first()->floors) }} @lang('application.office_order_floor') - {{ $application->existing_buildings->first()->building_usage->bn_name }}
                                </td>
                            @endif
                        </tr>
                    </table>
                    @if($application->type == 'existing')
                        <span>@lang('application.include_requirement_title') @lang('application.include_requirement')</span>
                    @endif

                    <br>
                    <br>

                    <table class="table">
                        <tr>
                            <td class="text-right">{{auth()->user()->bn_name ? auth()->user()->bn_name : ''}}</td>
                        </tr>
                        <tr>
                            <td class="text-right">{{auth()->user()->designation ? auth()->user()->designation->bn_name : ''}}</td>
                        </tr>
                        <tr>
                            <td class="text-right">{{auth()->user()->office ? auth()->user()->office_bn_name : ''}}</td>
                        </tr>
                    </table>
                    <div class="row mb-2" style="padding-top: -10px">
                        <div class=" col-md-12">
                            @lang('application.for_work_and_knowledge')
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12 col-xs-12">
                            <ul style="list-style: bengali;">
                                <li class="mt-2">
                                    <span>
                                        @lang('application.deputy_director'),  @lang('application.fire_service_and_civil_defense'), {{$application->building_division->bn_name}} ।
                                    </span>
                                </li>

                                <li class="mt-2">
                                    <span>
                                        @lang('application.assistant_director'),  @lang('application.fire_service_and_civil_defense'), {{$application->building_district->bn_name}} ।
                                    </span>
                                </li>

                                <li class="mt-2">
                                    <span>
                                        @lang('application.senior_staff_officer'),  @lang('application.fire_service_and_civil_defense_department'), @lang('application.dhaka')(@lang('application.information_to_director_general')) ।
                                    </span>
                                </li>

                                @foreach($application->application_committees as $key=>$committee)
                                    <li class="mt-2">
                                            <span>
                                                {{$committee->designation->bn_name}},
                                                  
                                                @if($committee->office)
                                                    {{$committee->office->bn_name}}
                                                    @if($committee->district || $committee->user->division),@endif
                                                @endif

                                                @if($committee->district)
                                                    {{$committee->district->bn_name}}
                                                @elseif($committee->user->division)
                                                    {{$committee->user->division->bn_name}}
                                                @endif ।
                                            </span>
                                    </li>
                                @endforeach

                                <li class="mt-2">
                                        <span>
                                            @lang('application.officer_incharge_notice') ।
                                        </span>
                                </li>

                                <li class="mt-2">
                                        <span>
                                            @lang('application.warehouse_inspector'), @lang('application.fire_service_and_civil_defense')(@lang('application.related_area')) ।
                                        </span>
                                </li>

                                <li class="mt-2">
                                        <span>
                                            @lang('application.staff_officer_notice') ।
                                        </span>
                                </li>

                                <li class="mt-2">
                                        <span>
                                            {{ $application->user->bn_name ?? '' }}, {{ $application->user->address ?? '' }} । @lang('application.applicant_notice')
                                        </span>
                                    <ul style="list-style: disc;">
                                        <li class="p-1">@lang('application.paper_1')</li>
                                        <li class="p-1">@lang('application.paper_2')</li>
                                        <li class="p-1">@lang('application.paper_3')</li>
                                        <li class="p-1">@lang('application.paper_4')</li>
                                        <li class="p-1">@lang('application.paper_5')</li>
                                        <li class="p-1">@lang('application.paper_6')</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- end col -->
    </div>
@endsection
