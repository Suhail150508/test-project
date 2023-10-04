<script>
    {{--function GetGreaterDistrict() {
        var division_id = $("#division_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{route('get_greater_district')}}',
            type: 'POST',
            dataType: 'JSON',
            cache: false,
            data:{
                division_id : division_id,
            },
            success: function (response) {
                var greater_district_id = $('#greater_district_id');

                //success data
                greater_district_id.empty();
                greater_district_id.append("<option value=''>{{trans('city_corporation.label_greater_district_id_select')}}</option>");
                $.each(response, function (index, subcatObj) {
                    greater_district_id.append("<option value='" + subcatObj.id + "'>" + subcatObj.bn_name + "</option>");
                });
            },
            error: function (response, error) {
                console.log(error)
            }
        });
    }--}}

    function GetDistrict() {
        var division_id = $("#division_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{route('get_district')}}',
            type: 'POST',
            dataType: 'JSON',
            cache: false,
            data:{
                division_id : division_id,
            },
            success: function (response) {
                var district_id = $('#district_id');

                //success data
                district_id.empty();
                district_id.append("<option value=''>{{trans('city_corporation.label_district_id_select')}}</option>");
                $.each(response, function (index, subcatObj) {
                    district_id.append("<option value='" + subcatObj.id + "'>" + subcatObj.bn_name + "</option>");
                });
            },
            error: function (response, error) {
                console.log(error)
            }
        });
    }


    function GetThana() {
        var district_id = $("#district_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{route('get_thana')}}',
            type: 'POST',
            dataType: 'JSON',
            cache: false,
            data:{
                district_id : district_id,
            },
            success: function (response) {
                var thana_id = $('#thana_id');

                //success data
                thana_id.empty();
                thana_id.append("<option value=''>{{trans('fire_station.select_one')}}</option>");
                $.each(response, function (index, subcatObj) {
                    thana_id.append("<option value='" + subcatObj.id + "'>" + subcatObj.bn_name + "</option>");
                });
            },
            error: function (response, error) {
                console.log(error)
            }
        });
    }
</script>
