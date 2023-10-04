<div class="row mb-3">
    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('name') ? 'parsley-error ' : ''; @endphp
        <label for="name" class="form-label">@lang('common.name',['model' => trans('country.country')])</label>
        <div class="form-group">
            {{ Form::text('name', null, ['class' => $error_class.'form-control', 'id' => 'name', 'required' => false]) }}
            @if ($errors->has('name'))
                <p class="text-danger">{{$errors->first('name')}}</p>
            @endif
        </div>
    </div>
    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('bn_name') ? 'parsley-error ' : ''; @endphp
        <label for="bn_name" class="form-label">@lang('common.bn_name',['model' => trans('country.country')])</label>
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
            $error_class = $errors->has('code') ? 'parsley-error ' : ''; @endphp
        <label for="code" class="form-label">@lang('country.code')</label>
        <div class="form-group">
            {{ Form::text('code', null, ['class' => $error_class.'form-control', 'id' => 'code', 'required' => false]) }}
            @if ($errors->has('code'))
                <p class="text-danger">{{$errors->first('code')}}</p>
            @endif
        </div>
    </div>
    <div class="col-sm-12 col-md-4 my-2">
        @php /** @var string $errors */
            $error_class = $errors->has('status') ? 'parsley-error ' : ''; @endphp
        <label for="status" class="form-label">@lang('common.status',['model' => trans('country.country')])</label>
        <sup class="text-danger">*</sup>
        <div class="form-group form-group-check pl-4">
            <div class="form-check-custom">
                {{ Form::radio('status', 'Active',null, ['class' => 'form-check-input', 'id' => 'active', 'required' => 1, 'checked' => 1]) }}
                <label class="form-check-label" for="active">
                    @lang('common.active',['model' => trans('country.country')])
                </label>
            </div>

            <div class="form-check-custom">
                {{ Form::radio('status', 'Inactive',null, ['class' => 'form-check-input', 'id' => 'inactive', 'required' => 1]) }}
                <label class="form-check-label" for="inactive">
                    @lang('common.inactive',['model' => trans('country.country')])
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
            <i class="fa fa-save"></i> @lang('common.submit',['model' => trans('country.country')])
        </button>
    </div>
</div>

@if(!request()->ajax()) @section('script') @endif
<script src="{{ URL::asset('/assets/common/libs/parsleyjs/parsleyjs.min.js') }}"></script>

<script src="{{ URL::asset('/assets/common/js/pages/form-validation.init.js') }}"></script>
@if(!request()->ajax()) @endsection @endif
