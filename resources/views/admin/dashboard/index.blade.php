@extends('admin.layouts.master')

@section('title') @lang('translation.Dashboards') @endsection

@section('css')
    #map {
        border: solid #00feff 2px;
        padding: 5px;
        height: 300px;
        position: relative !important;
    }
@endsection

@section('content')

    @component('components.breadcrumb')
        @slot('li_1') Dashboards @endslot
        @slot('title') Dashboard @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-truck"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">demo</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12" id="map">

        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="card" style="min-height: 350px;">
                <div class="card-body">
                    <h4 class="card-title mb-4">@lang('dashboard.active_users')</h4>
                    <div class="table-responsive">
                        <table class="table align-middle table-nowrap mb-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">#</th>
                                    <th>@lang('user.label_bn_name')</th>
                                    <th>@lang('user.label_email')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($active_users as $active_user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $active_user->bn_name }}</td>
                                    <td>{{ $active_user->email }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>


@endsection

<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDP_EyRuWJPXWmbSWJOmtzfDl25jCp9khg&callback=initMap&libraries=&v=weekly" async></script>

{{--<script>
    let map;

    let markers = @json($locations); //this should dump a javascript array object which does not need any extra interperting.
    let marks = []; //just incase you want to be able to manipulate this later

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 23.897, lng: 90.644 },
            zoom: 6.2,
        });

        for(var i = 0; i < markers.length; i++){
            marks[i] = addMarker(markers[i]);
        }
    }

    function addMarker(marker){
        var content = marker.nazivMarkera;
        var address = marker.adresa;
        var grad = marker.nazivGrada;
        var zip = marker.postanski_broj;

        var html = "<b>" + content + "</b> <br/>" + address +",<br/>"+grad+",<br/>"+zip;


        var markerLatlng = new google.maps.LatLng(parseFloat(marker.lat),parseFloat(marker.lng));


        var mark = new google.maps.Marker({
            map: map,
            position: markerLatlng,
            icon: marker.slika
        });

        var infoWindow = new google.maps.InfoWindow;

        /*google.maps.event.addListener(mark, 'click', function(){
            infoWindow.setContent(html);
            infoWindow.open(map, mark);
        });*/

        return mark;
    }
</script>--}}

@section('script')
    {{--<!-- apexcharts -->
    <script src="{{ URL::asset('/assets/common/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/common/libs/chart.js/Chart.bundle.min.js')}}"></script>

    <!-- dashboard init -->
    <script src="{{ URL::asset('/assets/common/js/pages/dashboard.init.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ URL::asset('assets/common/libs/chart-js/chart-js.min.js')}}"></script>
    <script src="{{ URL::asset('assets/common/js/pages/chartjs.init.js')}}"></script>--}}
@endsection
