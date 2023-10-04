<div class="row">
    <h3>@lang('employee.sync')</h3>

    @php /** @var string $errors */
         $error_class = $errors->has('sync') ? 'alert-danger' : ''; @endphp

    <div class="col-sm-12 col-md-4 my-2 {{ $error_class }}">
        <label class="font-size-15 font-weight-semibold" for="sync" style="cursor: pointer;">
            {{ Form::checkbox('sync', 'yes', false ,['id' => 'sync', 'class' => 'form-check-input']) }}
            @lang('employee.sync_from_hrm')
        </label>
        @if ($errors->has('sync'))
            <p class="text-danger">{{$errors->first('sync')}}</p>
        @endif
    </div>

    <div id="div_pin">
        <div class="col-sm-12 col-md-4 my-2">
            @php /** @var string $errors */
            $error_class = $errors->has('pin') ? 'parsley-error ' : ''; @endphp
            <label for="pin" class="form-label">@lang('employee.pin')</label>
            <sup class="text-danger">*</sup>
            <div class="form-group">
                {{ Form::text('pin', null, ['class' => $error_class.'form-control', 'id' => 'pin', 'required' => false, 'autofocus']) }}
                @if ($errors->has('pin'))
                    <p class="text-danger">{{$errors->first('pin')}}</p>
                @endif
            </div>
        </div>

        <div class="col-sm-12 col-md-4 my-2 text-right">
            <a id="search_employee" type="search" class="btn btn-info waves-effect waves-light">
                <i class="fa fa-search"></i> @lang('employee.search')
            </a>
        </div>
    </div>

</div>

<div class="row mb-3">
    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('name') ? 'parsley-error ' : ''; @endphp
        <label for="name" class="form-label">@lang('common.name')</label>
        <div class="form-group">
            {{ Form::text('name', null, ['class' => $error_class.'form-control', 'id' => 'name', 'required' => false, 'autofocus']) }}
            @if ($errors->has('name'))
                <p class="text-danger">{{$errors->first('name')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('bn_name') ? 'parsley-error ' : ''; @endphp
        <label for="bn_name" class="form-label">@lang('common.bn_name')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::text('bn_name', null, ['class' => $error_class.'form-control', 'id' => 'bn_name', 'required' => 1]) }}
            @if ($errors->has('bn_name'))
                <p class="text-danger">{{$errors->first('bn_name')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('father') ? 'parsley-error ' : ''; @endphp
        <label for="father" class="form-label">@lang('employee.father')</label>
        <div class="form-group">
            {{ Form::text('father', null, ['class' => $error_class.'form-control', 'id' => 'father', 'required' => false, 'autofocus']) }}
            @if ($errors->has('father'))
                <p class="text-danger">{{$errors->first('father')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('mother') ? 'parsley-error ' : ''; @endphp
        <label for="mother" class="form-label">@lang('employee.mother')</label>
        <div class="form-group">
            {{ Form::text('mother', null, ['class' => $error_class.'form-control', 'id' => 'mother', 'required' => false, 'autofocus']) }}
            @if ($errors->has('mother'))
                <p class="text-danger">{{$errors->first('mother')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('old_pin') ? 'parsley-error ' : ''; @endphp
        <label for="old_pin" class="form-label">@lang('employee.old_pin')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::text('old_pin', null, ['class' => $error_class.'form-control', 'id' => 'old_pin', 'required' => 1]) }}
            @if ($errors->has('old_pin'))
                <p class="text-danger">{{$errors->first('old_pin')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('new_pin') ? 'parsley-error ' : ''; @endphp
        <label for="new_pin" class="form-label">@lang('employee.new_pin')</label>
        <div class="form-group">
            {{ Form::text('new_pin', null, ['class' => $error_class.'form-control', 'id' => 'new_pin', 'required' => false]) }}
            @if ($errors->has('new_pin'))
                <p class="text-danger">{{$errors->first('new_pin')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('designation_id') ? 'parsley-error ' : ''; @endphp
        <label for="designation_id" class="form-label">@lang('employee.designation')</label>
        <div class="form-group">
            {{ Form::select('designation_id', $designations, null, ['class' => $error_class.'form-control select2', 'placeholder' => trans('common.select'), 'id' => 'designation_id', 'required' => false]) }}
            @if ($errors->has('designation_id'))
                <p class="text-danger">{{$errors->first('designation_id')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('fire_station_id') ? 'parsley-error ' : ''; @endphp
        <label for="fire_station_id" class="form-label">@lang('employee.fire_station')</label>
        <div class="form-group">
            {{ Form::select('fire_station_id', $fire_stations, null, ['class' => $error_class.'form-control select2', 'placeholder' => trans('common.select'), 'id' => 'fire_station_id', 'required' => false]) }}
            @if ($errors->has('fire_station_id'))
                <p class="text-danger">{{$errors->first('fire_station_id')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('religion') ? 'parsley-error ' : ''; @endphp
        <label for="religion" class="form-label">@lang('employee.religion')</label>
        <div class="form-group">
            {{ Form::select('religion', $religions, null, ['class' => $error_class.'form-control select2', 'placeholder' => trans('common.select'), 'id' => 'religion', 'required' => false]) }}
            @if ($errors->has('religion'))
                <p class="text-danger">{{$errors->first('religion')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('gender') ? 'parsley-error ' : ''; @endphp
        <label for="gender" class="form-label">@lang('employee.gender')</label>
        <div class="form-group">
            {{ Form::select('gender', $genders, null, ['class' => $error_class.'form-control select2', 'placeholder' => trans('common.select'), 'id' => 'gender', 'required' => false]) }}
            @if ($errors->has('gender'))
                <p class="text-danger">{{$errors->first('gender')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('id_card') ? 'parsley-error ' : ''; @endphp
        <label for="id_card" class="form-label">@lang('employee.id_card')</label>
        <div class="form-group">
            {{ Form::text('id_card', null, ['class' => $error_class.'form-control', 'id' => 'id_card', 'required' => false]) }}
            @if ($errors->has('id_card'))
                <p class="text-danger">{{$errors->first('id_card')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('nid') ? 'parsley-error ' : ''; @endphp
        <label for="nid" class="form-label">@lang('employee.nid')</label>
        <div class="form-group">
            {{ Form::text('nid', null, ['class' => $error_class.'form-control', 'id' => 'nid', 'required' => false]) }}
            @if ($errors->has('nid'))
                <p class="text-danger">{{$errors->first('nid')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
        $error_class = $errors->has('birth_date') ? 'parsley-error ' : ''; @endphp
        <label for="birth_date" class="form-label">@lang('employee.birth_date')</label>
        <div class="form-group">
            {{ Form::text('birth_date', @$employee->birth_date ? date('d-m-Y',strtotime($employee->birth_date)) : null, ['class' => $error_class.'form-control datepicker', 'id' => 'birth_date', 'autocomplete' => 'off', 'required' => false]) }}
            @if ($errors->has('birth_date'))
                <p class="text-danger">{{$errors->first('birth_date')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('mobile') ? 'parsley-error ' : ''; @endphp
        <label for="mobile" class="form-label">@lang('employee.mobile')</label>
        <div class="form-group">
            {{ Form::text('mobile', null, ['class' => $error_class.'form-control', 'id' => 'mobile', 'required' => false]) }}
            @if ($errors->has('mobile'))
                <p class="text-danger">{{$errors->first('mobile')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('email') ? 'parsley-error ' : ''; @endphp
        <label for="email" class="form-label">@lang('employee.email')</label>
        <div class="form-group">
            {{ Form::text('email', null, ['class' => $error_class.'form-control', 'id' => 'email', 'required' => false]) }}
            @if ($errors->has('email'))
                <p class="text-danger">{{$errors->first('email')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('emergency_contact') ? 'parsley-error ' : ''; @endphp
        <label for="emergency_contact" class="form-label">@lang('employee.emergency_contact')</label>
        <div class="form-group">
            {{ Form::text('emergency_contact', null, ['class' => $error_class.'form-control', 'id' => 'emergency_contact', 'required' => false]) }}
            @if ($errors->has('emergency_contact'))
                <p class="text-danger">{{$errors->first('emergency_contact')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('status') ? 'parsley-error ' : ''; @endphp
        <label for="status" class="form-label">@lang('common.status')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group form-group-check pl-4">
            <div class="form-check-custom">
                {{ Form::radio('status', 'Active',null, ['class' => 'form-check-input', 'id' => 'active', 'required' => false, 'checked' => 1]) }}
                <label class="form-check-label" for="active">
                    @lang('common.active')
                </label>
            </div>

            <div class="form-check-custom">
                {{ Form::radio('status', 'Inactive',null, ['class' => 'form-check-input', 'id' => 'inactive', 'required' => false]) }}
                <label class="form-check-label" for="inactive">
                    @lang('common.inactive')
                </label>
            </div>
            @if ($errors->has('status'))
                <p class="text-danger">{{$errors->first('status')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
                        $error_class = $errors->has('permanent_address') ? 'parsley-error ' : ''; @endphp
        <label for="bn_name" class="form-label">@lang('employee.permanent_address')</label>
        <div class="form-group">
            {{ Form::textarea('permanent_address', null, ['class' => $error_class.'form-control textarea', 'placeholder' => trans('employee.permanent_address'), 'id' => 'permanent_address', 'required' => false, 'rows' => 3 ]) }}
            @if ($errors->has('permanent_address'))
                <p class="text-danger">{{$errors->first('permanent_address')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
                        $error_class = $errors->has('present_address') ? 'parsley-error ' : ''; @endphp
        <label for="bn_name" class="form-label">@lang('employee.present_address')</label>
        <div class="form-group">
            {{ Form::textarea('present_address', null, ['class' => $error_class.'form-control textarea', 'placeholder' => trans('employee.present_address'), 'id' => 'present_address', 'required' => false, 'rows' => 3 ]) }}
            @if ($errors->has('present_address'))
                <p class="text-danger">{{$errors->first('present_address')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
                        $error_class = $errors->has('job_details') ? 'parsley-error ' : ''; @endphp
        <label for="bn_name" class="form-label">@lang('employee.job_details')</label>
        <div class="form-group">
            {{ Form::textarea('job_details', null, ['class' => $error_class.'form-control textarea', 'placeholder' => trans('employee.job_details'), 'id' => 'job_details', 'required' => false, 'rows' => 3 ]) }}
            @if ($errors->has('job_details'))
                <p class="text-danger">{{$errors->first('job_details')}}</p>
            @endif
        </div>
    </div>

</div>

<div class="row">
    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('profile_picture') ? 'parsley-error ' : ''; @endphp
        <label for="profile_picture" class="form-label">@lang('employee.profile_picture')</label>
        <div class="form-group">
            {{ Form::file('profile_picture', ['class' => $error_class.'form-control', 'required' => false, 'id' => 'profile_picture', 'onchange' => "preview_profile_picture(this)",  'accept' => "profile_picture/*"]) }}
            @if ($errors->has('profile_picture'))
                <p class="text-danger">{{$errors->first('profile_picture')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        <label class="col-form-label" for="profile_picture">@lang('employee.profile_picture_preview')</label><br>
        <img class="img-fluid" style="border: 2px solid #adb5bd;margin: 0 auto; padding: 2px; border-radius: 2%;" id="profile_picture_preview" src="{{asset('assets/common/profile_picture.png')}}" alt="Image Preview">
    </div>

    @if(Request::segment(4) == 'edit')
        <div class="col-sm-12 col-md-4 my-2">
            <label class="col-form-label">
                @lang('employee.profile_picture_existing')
                {{ Form::checkbox('remove_profile_picture', null, null, ['class' => 'form-check-input', 'id' => 'remove_profile_picture']) }}
                <label for="remove_profile_picture" class="form-label">@lang('employee.remove_profile_picture')</label>
            </label><br>
            <img class="img-fluid" style="border: 2px solid #adb5bd;margin: 0 auto; padding: 2px; border-radius: 2%;" src="{{asset($employee->profile_picture->source ?? '')}}" alt="@lang('employee.profile_picture_existing')">
        </div>
    @endif
</div>

<div class="row">
    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('signature') ? 'parsley-error ' : ''; @endphp
        <label for="signature" class="form-label">@lang('employee.signature')</label>
        <div class="form-group">
            {{ Form::file('signature', ['class' => $error_class.'form-control', 'required' => false, 'id' => 'signature', 'onchange' => "preview_signature(this)",  'accept' => "signature/*"]) }}
            @if ($errors->has('signature'))
                <p class="text-danger">{{$errors->first('signature')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-4 my-2">
        <label class="col-form-label" for="signature">@lang('employee.signature_preview')</label><br>
        <img class="img-fluid" style="border: 2px solid #adb5bd;margin: 0 auto; padding: 2px; border-radius: 2%;" id="signature_preview" src="{{asset('assets/common/signature.png')}}" alt="Image Preview">
    </div>

    @if(Request::segment(4) == 'edit')
        <div class="col-sm-12 col-md-4 my-2">
            <label class="col-form-label">
                @lang('employee.signature_existing')
                {{ Form::checkbox('remove_signature', null, null, ['class' => 'form-check-input', 'id' => 'remove_signature']) }}
                <label for="remove_signature" class="form-label">@lang('employee.remove_signature')</label>
            </label><br>
            <img class="img-fluid" style="border: 2px solid #adb5bd;margin: 0 auto; padding: 2px; border-radius: 2%;" src="{{asset($employee->signature->source ?? '')}}" alt="@lang('employee.signature_existing')">
        </div>
    @endif

</div>

<div class="row">
    <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-primary waves-effect waves-light">
            <i class="fa fa-save"></i> @lang('common.submit')
        </button>
    </div>
</div>

@section('script')
    <script src="{{ URL::asset('/assets/common/libs/parsleyjs/parsleyjs.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/common/js/pages/form-validation.init.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        //profile_picture preview
        function preview_profile_picture(input){
            let file = $("#profile_picture").get(0).files[0];

            if(file){
                let reader = new FileReader();

                reader.onload = function(){
                    $("#profile_picture_preview").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }

        //signature preview
        function preview_signature(input){
            let file = $("#signature").get(0).files[0];

            if(file){
                let reader = new FileReader();

                reader.onload = function(){
                    $("#signature_preview").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
        }

        let profile = ''
        let signature = ''
        let dt = new Date();
        let time = dt.getHours() + "-" + dt.getMinutes() + "-" + dt.getSeconds();
        let date = dt.getFullYear() + "-" + dt.getMonth() + "-" + dt.getDate();

        $(function () {
            sync_employee_toggle()
            $('#sync').change(function () {
                sync_employee_toggle()
            });

            $('#search_employee').on('click',function () {

                $('#loader').show();

                let pin = $('#pin').val()
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: 'http://fschrm.viewdemo.xyz/api/employees-for-workshop?token=3WarLFaJUF4ECSLicpdjGnjncYCP1auNrcbpt3vQTgJSXoQB6b',
                    type: 'GET',
                    dataType: 'JSON',
                    cache: false,
                    data:{
                        pin: pin
                    },
                    success: function (response) {
                        toastr.success('Success', 'Employee Found!',{
                            closeButton: true,
                            progressBar: true,
                        });

                        console.log(response)

                        $('#name').val(response.name)
                        $('#father').val(response.f_name)
                        $('#mother').val(response.m_name)
                        $('#old_pin').val(response.pin_no)
                        $('#new_pin').val(response.new_pin)
                        $('#designation_id').val(response.designation_id).trigger("change");

                        let station_code = response.job_station.code
                        let station_id = ''

                        $.ajax({
                            url: '{{ route('get_fire_station_from_code') }}',
                            type: 'POST',
                            dataType: 'JSON',
                            cache: false,
                            data:{
                                code: station_code
                            },
                            success: function (response) {
                                station_id = response.id ?? ''
                                $('#fire_station_id').val(station_id).trigger("change");
                            },
                            error: function (xhr) {
                                station_id = ''
                            }
                        });

                        let station_division_id = response.job_station.division_id
                        let workshop_id = ''

                        $.ajax({
                            url: '{{ route('get_workshop_from_division') }}',
                            type: 'POST',
                            dataType: 'JSON',
                            cache: false,
                            data:{
                                division_id: station_division_id
                            },
                            success: function (response) {
                                workshop_id = response.id ?? ''
                                $('#workshop_id').val(workshop_id).trigger("change");
                            },
                            error: function (xhr) {
                                workshop_id = ''
                            }
                        });

                        $('#religion').val(response.religion).trigger("change");
                        $('#gender').val(response.gender).trigger("change");
                        $('#id_card').val(response.id_card_no)
                        $('#nid').val(response.nid_no)
                        $('#birth_date').val(moment(response.dob).format('DD-MM-YYYY'))
                        $('#mobile').val(response.mobile_no)
                        $('#email').val(response.email)
                        $('#emergency_contact').val(response.e_contact_person_name)

                        if(response.img_url){
                            let img_url = response.img_url
                            $.ajax({
                                url: 'http://fschrm.viewdemo.xyz/api/employee-image-workshop?token=3WarLFaJUF4ECSLicpdjGnjncYCP1auNrcbpt3vQTgJSXoQB6b',
                                type: 'GET',
                                dataType: 'JSON',
                                cache: false,
                                data:{
                                    img_url: img_url
                                },
                                success: function (response) {
                                    $('#profile_picture_preview').attr('src',response.base64)
                                    profile = dataURLtoFile(response.base64,date+'_'+time+'_'+img_url)
                                },
                                error: function (xhr) {
                                    console.log(xhr)
                                }
                            });
                        }

                        if(response.signature_url){
                            let signature_url = response.signature_url
                            $.ajax({
                                url: 'http://fschrm.viewdemo.xyz/api/employee-signature-workshop?token=3WarLFaJUF4ECSLicpdjGnjncYCP1auNrcbpt3vQTgJSXoQB6b',
                                type: 'GET',
                                dataType: 'JSON',
                                cache: false,
                                data:{
                                    signature_url: signature_url
                                },
                                success: function (response) {
                                    $('#signature_preview').attr('src',response.base64)
                                    signature = dataURLtoFile(response.base64,date+'_'+time+'_'+signature_url)
                                },
                                error: function (xhr) {
                                    console.log(xhr)
                                }
                            });
                        }

                        /*if (response.parmanent_address != null){
                            let division = ''
                            let district = ''
                            let thana = ''
                            let area = ''
                            $('#permanent_address').val(area+' '+thana.bn_name+' '+district.bn_name+' '+division.bn_name)
                        }

                        if (response.present_address != null){
                            let division = ''
                            let district = ''
                            let thana = ''
                            let area = ''
                            $('#present_address').val(area+' '+thana.bn_name+' '+district.bn_name+' '+division.bn_name)
                        }*/

                        // $('#job_details').val(response.job_details)
                        // $('#profile_picture').val(response.profile_picture)
                        // $('#signature').val(response.signature)

                        setTimeout(function(){
                            $('#loader').hide();
                        }, 300);
                    },
                    error: function (xhr) {
                        setTimeout(function(){
                            $('#loader').hide();
                        }, 300);

                        let error = xhr.responseJSON.message
                        toastr.error(error, 'Employee Not Found!', {
                            closeButton: true,
                            progressBar: true,
                        });
                    }
                });
            })
        })

        function sync_employee_toggle() {
            if ($('#sync').is(':checked')){
                $('#div_pin').show(500)
                $('#pin').attr('required',true)
            } else {
                $('#div_pin').hide(300)
                $('#pin').attr('required',false)
            }
        }

        function dataURLtoFile(dataurl, filename) {
            let arr = dataurl.split(',');
                mime = arr[0].match(/:(.*?);/)[1];
                bstr = atob(arr[1]);
                n = bstr.length;
                u8arr = new Uint8Array(n);

            while(n--){
                u8arr[n] = bstr.charCodeAt(n);
            }

            return new File([u8arr], filename, {type:mime});
        }

        $(document).on('submit', '#employee_form', function (event) {
            $('#loader').show();
            let ajax_error_alert = $('#ajax_error_alert')
            let ajax_error = ajax_error_alert.find('#ajax_error')
            ajax_error.text('')
            ajax_error_alert.addClass('d-none');
            event.preventDefault();
            let vm = $(this)
            let input_array = ['input', 'select']
            vm.find('.parsley-errors-list').remove();
            input_array.forEach(function (value, index) {
                vm.find(value).removeClass('parsley-error');
            });

            let formData = new FormData(this);
            formData.append('profile_picture',profile)
            formData.append('signature',signature)
            console.log(formData)

            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    window.location.href = '{{route('employee.index')}}'
                },
                error: function (xhr) {
                    ajax_error_alert.removeClass('d-none');
                    if(xhr.status == 500 && xhr.responseJSON){
                        ajax_error.text(xhr.responseJSON);
                    }
                    if(xhr.responseJSON && xhr.responseJSON.exception){
                        ajax_error.text(xhr.responseJSON.message);
                    }
                    if(xhr.responseJSON && xhr.responseJSON.errors){
                        let errors = Object.entries(xhr.responseJSON.errors);
                        for(let error of errors){
                            ajax_error.text(error[1]);
                            break
                        }

                        let flag = 0;
                        for(let error of errors){

                            if (flag === 0){
                                $('html, body').animate({
                                    scrollTop: $('input[name='+error[0]+'], select[name='+error[0]+'], textarea[name='+error[0]+']').offset().top - 500
                                }, 500);
                                flag = 1
                            }

                            input_array.forEach(function (value, index) {
                                let input = $(value+'[name='+error[0]+']');
                                vm.find(input).addClass('parsley-error');
                                vm.find(input).after(
                                    '<ul class="parsley-errors-list filled" aria-hidden="false">' +
                                    '<li class="parsley-required">'+error[1]+'</li>' +
                                    '</ul>'
                                );
                            });
                        }
                    }
                    setTimeout(function(){
                        $('#loader').hide();
                    }, 280);
                }
            });
        });
    </script>
@endsection
