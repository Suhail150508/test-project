<div class="row mb-2">
    <div class="col-sm-4">
        <span class="border-bottom border-dark font-size-15">@lang('user.label_basic_information')</span>
    </div>
</div>

<div class="row mb-3">
    <div class="col-sm-4 mb-3">
        @php /** @var string $errors */
            $error_class = $errors->has('mobile') ? 'parsley-error ' : ''; @endphp
        <label for="mobile" class="form-label">@lang('user.label_mobile')</label>
        <div class="form-group">
            {{ Form::text('mobile',null, ['class' => $error_class.'form-control', 'id' => 'mobile']) }}
            @if ($errors->has('mobile'))
                <p class="text-danger">{{$errors->first('mobile')}}</p>
            @endif
        </div>
    </div>
    <div class="col-sm-4 mb-3">
        @php /** @var string $errors */
            $error_class = $errors->has('name') ? 'parsley-error ' : ''; @endphp
        <label for="name" class="form-label">@lang('user.label_name')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::text('name', null, ['class' => $error_class.'form-control', 'id' => 'name', 'required' => 1]) }}
            @if ($errors->has('name'))
                <p class="text-danger">{{$errors->first('name')}}</p>
            @endif
        </div>
    </div>
    <div class="col-sm-4 mb-3">
        @php /** @var string $errors */
            $error_class = $errors->has('bn_name') ? 'parsley-error ' : ''; @endphp
        <label for="bn_name" class="form-label">@lang('user.label_bn_name')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::text('bn_name', null, ['class' => $error_class.'form-control', 'id' => 'bn_name', 'required' => 1]) }}
            @if ($errors->has('bn_name'))
                <p class="text-danger">{{$errors->first('bn_name')}}</p>
            @endif
        </div>
    </div>
    <div class="col-sm-4 mb-3">
        @php /** @var string $errors */
            $error_class = $errors->has('phone_no') ? 'parsley-error ' : ''; @endphp
        <label for="phone_no" class="form-label">@lang('user.label_phone_no')</label>
        <div class="form-group">
            {{ Form::text('phone_no', null, ['class' => $error_class.'form-control', 'id' => 'phone_no']) }}
            @if ($errors->has('phone_no'))
                <p class="text-danger">{{$errors->first('phone_no')}}</p>
            @endif
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-sm-4">
        <span class="border-bottom border-dark font-size-15">@lang('user.label_login_information')</span>
    </div>
</div>

<div class="row mb-3">
    <div class="col-sm-6 mb-3">
        @php /** @var string $errors */
            $error_class = $errors->has('email') ? 'parsley-error ' : ''; @endphp
        <label for="email" class="form-label">@lang('user.label_email')</label>
        {{--<sup class="text-danger">*</sup>--}}
        <div class="form-group">
            {{ Form::email('email', null, ['class' => $error_class.'form-control', 'id' => 'email', 'required' => false]) }}
            @if ($errors->has('email'))
                <p class="text-danger">{{$errors->first('email')}}</p>
            @endif
        </div>
    </div>
    <div class="col-sm-6 mb-3">
        @php /** @var string $errors */
            $error_class = $errors->has('username') ? 'parsley-error ' : ''; @endphp
        <label for="username" class="form-label">@lang('user.label_username')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::text('username', null, ['class' => $error_class.'form-control', 'id' => 'username', 'required' => 1]) }}
            @if ($errors->has('username'))
                <p class="text-danger">{{$errors->first('username')}}</p>
            @endif
        </div>
    </div>
    <div class="col-sm-3 mb-3">
        @php /** @var string $errors */
            $error_class = $errors->has('password') ? 'parsley-error ' : ''; @endphp
        <label for="password" class="form-label">@lang('user.label_password')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::password('password', ['class' => $error_class.'form-control', 'id' => 'password', 'autocomplete' => 'new-password', 'required' => false]) }}
            @if ($errors->has('password'))
                <p class="text-danger">{{$errors->first('password')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-3 mb-3">
        @php /** @var string $errors */
            $error_class = $errors->has('password_confirm') ? 'parsley-error ' : ''; @endphp
        <label for="password_confirm" class="form-label">@lang('user.label_password_confirm')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::password('password_confirm', ['class' => $error_class.'form-control', 'id' => 'password_confirm', 'autocomplete' => 'new-password', 'required' => false]) }}
            @if ($errors->has('password_confirm'))
                <p class="text-danger">{{$errors->first('password_confirm')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-3 mb-3">
        @php /** @var string $errors */
            $error_class = $errors->has('role_id') ? 'parsley-error ' : ''; @endphp
        <label for="role_id" class="form-label">@lang('user.label_role_id')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::select('role_id', $roles,null, ['class' => $error_class.'form-control select2', 'id' => 'role_id','placeholder'=>trans('user.label_role_id_select'), 'required' => 1]) }}
            @if ($errors->has('role_id'))
                <p class="text-danger">{{$errors->first('role_id')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-3 mb-3">
        @php /** @var string $errors */
            $error_class = $errors->has('status') ? 'parsley-error ' : ''; @endphp
        <label for="status" class="form-label">@lang('user.label_status')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group form-group-check pl-4">
            <div class="form-check-custom">
                {{ Form::radio('status', 'Active',null, ['class' => 'form-check-input', 'id' => 'active', 'required' => 1, 'checked' => 1]) }}
                <label class="form-check-label" for="active">
                    @lang('user.label_status_active')
                </label>
            </div>

            <div class="form-check-custom">
                {{ Form::radio('status', 'Inactive',null, ['class' => 'form-check-input', 'id' => 'inactive', 'required' => 1]) }}
                <label class="form-check-label" for="inactive">
                    @lang('user.label_status_inactive')
                </label>
            </div>
            @if ($errors->has('status'))
                <p class="text-danger">{{$errors->first('status')}}</p>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-primary waves-effect waves-light">
            <i class="fa fa-save"></i> @lang('user.label_submit_button')
        </button>
    </div>
</div>

@section('script')
    <script src="{{ URL::asset('/assets/common/libs/parsleyjs/parsleyjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/common/js/pages/form-validation.init.js') }}"></script>

    <script src="{{ asset('vue-js/vue/dist/vue.js') }}"></script>
    <script src="{{ asset('vue-js/axios/dist/axios.min.js') }}"></script>

    <script>

        $(function () {
            Vue.directive('select', {
                twoWay: true,
                bind: function (el, binding, vnode) {
                    $(el).select2().on("select2:select", (e) => {
                        // v-model looks for
                        //  - an event named "change"
                        //  - a value with property path "$event.target.value"
                        el.dispatchEvent(new Event('change', {target: e.target}));
                    });
                },
            });

            let vue_office_type = new Vue({
                el: '#office_type',
                data: {
                    office_id: '',
                    fire_station_id: '',
                    division_id: '',
                    district_id: '',
                    department_id: '',
                    isDepartment:false,
                    isStation:true,
                    isDistrict:true,
                    isDivision:true,
                },
                methods: {
                    fetch_office_type() {

                        let vm = this;
                        let slug = vm.office_id;
                        $('#loader').show();
                        axios.get('/fetch_office_type/' + slug).then(function (response) {
                            let office_type = response.data.office_type;

                            if(office_type=="station"){
                                vm.isStation=true;
                                vm.isDistrict=true;
                                vm.isDivision=true;
                                vm.isDepartment=false;
                            } else if(office_type=="district"){
                                vm.isDistrict=true;
                                vm.isStation=false;
                                vm.isDivision=true;
                                vm.isDepartment=false;
                            } else if(office_type=="division"){
                                vm.isDistrict=false;
                                vm.isStation=false;
                                vm.isDivision=true;
                                vm.isDepartment=false;
                            } else if(office_type=="department"){
                                vm.isDistrict=false;
                                vm.isStation=false;
                                vm.isDivision=false;
                                vm.isDepartment=true;
                            }

                            setTimeout(function(){
                                $('#loader').hide();
                            }, 300);
                        }).catch(function (error) {
                            toastr.error('Something went wrong: '+error, {
                                closeButton: true,
                                progressBar: true,
                            });

                            setTimeout(function(){
                                $('#loader').hide();
                            }, 300);
                            return false;
                        });
                    },
                },
                created() {
                },
                mounted() {
                    $('.select2vue').select2({});
                },
                updated() {
                    $('.select2vue').select2({});
                },
            });

        });

        function GetDistrictFromDivision() {
            let division_id = $("#division_id").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('get_district_from_division')}}',
                type: 'POST',
                dataType: 'JSON',
                cache: false,
                data:{
                    division_id : division_id,
                },
                success: function (response) {
                    let district_id = $('#district_id');

                    //success data
                    district_id.empty();
                    district_id.append("<option value=''>{{trans('user.label_select_one')}}</option>");
                    $.each(response, function (index, subcatObj) {
                        district_id.append("<option value='" + subcatObj.id + "'>" + subcatObj.bn_name + "</option>");
                    });
                },
                error: function (response, error) {
                    console.log(error)
                }
            });
        }

    </script>

@endsection
