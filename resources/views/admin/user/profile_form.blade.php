<div class="row mb-2">
    <div class="col-sm-4">
        <span class="border-bottom border-dark font-size-15">@lang('user.label_basic_information')</span>
    </div>
</div>

<div class="row mb-3" id="office_type">
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
            $error_class = $errors->has('mobile') ? 'parsley-error ' : ''; @endphp
        <label for="mobile" class="form-label">@lang('user.label_mobile')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::text('mobile',null, ['class' => $error_class.'form-control', 'id' => 'mobile', 'required' => true]) }}
            @if ($errors->has('mobile'))
                <p class="text-danger">{{$errors->first('mobile')}}</p>
            @endif
        </div>
    </div>
    <div class="col-sm-4 mb-3">
        @php /** @var string $errors */
            $error_class = $errors->has('password') ? 'parsley-error ' : ''; @endphp
        <label for="password" class="form-label">@lang('user.label_password')</label>
        <div class="form-group">
            {{ Form::password('password', ['class' => $error_class.'form-control', 'id' => 'password', 'autocomplete' => 'new-password', 'required' => false]) }}
            @if ($errors->has('password'))
                <p class="text-danger">{{$errors->first('password')}}</p>
            @endif
        </div>
    </div>
    <div class="col-sm-4 mb-3">
        @php /** @var string $errors */
            $error_class = $errors->has('password_confirm') ? 'parsley-error ' : ''; @endphp
        <label for="password_confirm" class="form-label">@lang('user.label_password_confirm')</label>
        <div class="form-group">
            {{ Form::password('password_confirm', ['class' => $error_class.'form-control', 'id' => 'password_confirm', 'autocomplete' => 'new-password', 'required' => false]) }}
            @if ($errors->has('password_confirm'))
                <p class="text-danger">{{$errors->first('password_confirm')}}</p>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 text-right">
        <div class="form-group">
            <button type="submit" class="btn btn-primary waves-effect waves-light">
                <i class="fa fa-save"></i> @lang('user.label_submit_button')
            </button>
        </div>
    </div>
</div>

@section('script')
    <script src="{{ URL::asset('/assets/common/libs/parsleyjs/parsleyjs.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/common/js/pages/form-validation.init.js') }}"></script>

@endsection
