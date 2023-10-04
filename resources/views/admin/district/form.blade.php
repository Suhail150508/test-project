<div class="row mb-3">
    <div class="col-md-6 col-sm-6 col-xs-12 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('division_id') ? 'parsley-error ' : ''; @endphp
        <label for="bn_name" class="form-label">@lang('division.division')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::select('division_id', $divisions, null, ['class' => $error_class.'form-control select2', 'placeholder' => 'Select One', 'id' => 'division_id', 'required' => 1]) }}
            @if ($errors->has('division_id'))
                <p class="text-danger">{{$errors->first('division_id')}}</p>
            @endif
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('name') ? 'parsley-error ' : ''; @endphp
        <label for="name" class="form-label">@lang('district.label_name')</label>
        <div class="form-group">
            {{ Form::text('name', null, ['class' => $error_class.'form-control', 'id' => 'name', 'required' => false]) }}
            @if ($errors->has('name'))
                <p class="text-danger">{{$errors->first('name')}}</p>
            @endif
        </div>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('bn_name') ? 'parsley-error ' : ''; @endphp
        <label for="bn_name" class="form-label">@lang('district.label_bn_name')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::text('bn_name', null, ['class' => $error_class.'form-control', 'id' => 'bn_name', 'required' => 1]) }}
            @if ($errors->has('bn_name'))
                <p class="text-danger">{{$errors->first('bn_name')}}</p>
            @endif
        </div>
    </div>
    {{--<div class="col-md-6 col-sm-6 col-xs-12 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('greater_district_id') ? 'parsley-error ' : ''; @endphp
        <label for="bn_name" class="form-label">@lang('greater_district.label_bn_name')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::select('greater_district_id', $greater_districts, null, ['class' => $error_class.'form-control select2', 'placeholder' => 'Select One', 'id' => 'greater_district_id', 'required' => 1]) }}
            @if ($errors->has('greater_district_id'))
                <p class="text-danger">{{$errors->first('greater_district_id')}}</p>
            @endif
        </div>
    </div>--}}
    <div class="col-md-6 col-sm-6 col-xs-12 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('status') ? 'parsley-error ' : ''; @endphp
        <label for="status" class="form-label">@lang('district.label_status')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group form-group-check pl-4">
            <div class="form-check-custom">
                {{ Form::radio('status', 'Active',null, ['class' => 'form-check-input', 'id' => 'active', 'required' => 1, 'checked' => 1]) }}
                <label class="form-check-label" for="active">
                    @lang('district.label_status_active')
                </label>
            </div>

            <div class="form-check-custom">
                {{ Form::radio('status', 'Inactive',null, ['class' => 'form-check-input', 'id' => 'inactive', 'required' => 1]) }}
                <label class="form-check-label" for="inactive">
                    @lang('district.label_status_inactive')
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
            <i class="fa fa-save"></i> @lang('district.label_submit_button')
        </button>
    </div>
</div>

@section('script')
    <script src="{{ URL::asset('/assets/common/libs/parsleyjs/parsleyjs.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/common/js/pages/form-validation.init.js') }}"></script>
@endsection
