<div class="row mb-3">


    <div class="col-sm-4">
        @php $name_err_class = $errors->has('name') ? 'parsley-error ' : ''; @endphp
        <label for="name" class="form-label">@lang('menu_action/attribute.label_name')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::text('name', null, ['class' => $name_err_class.'form-control', 'id' => 'name', 'required' => 1]) }}
            @if ($errors->has('name'))
                <p class="text-danger">{{$errors->first('name')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        @php $icon_err_class = $errors->has('icon') ? 'parsley-error ' : ''; @endphp
        <label for="icon" class="form-label">@lang('menu_action/attribute.label_icon')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::text('icon',null, ['class' => $icon_err_class.'form-control', 'id' => 'icon', 'placeholder' => 'fa fa-bars','required' => true]) }}
            @if ($errors->has('icon'))
                <p class="text-danger">{{$errors->first('icon')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        @php $button_class_err_class = $errors->has('button_class') ? 'parsley-error ' : ''; @endphp
        <label for="button_class" class="form-label">@lang('menu_action/attribute.label_button_class')</label>
        <div class="form-group">
            {{ Form::text('button_class',null, ['class' => $button_class_err_class.'form-control', 'id' => 'button_class', 'placeholder' => 'btn btn-primary', 'required' => false]) }}
            @if ($errors->has('button_class'))
                <p class="text-danger">{{$errors->first('button_class')}}</p>
            @endif
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-sm-4">
        @php $slug_err_class = $errors->has('slug') ? 'parsley-error ' : ''; @endphp
        <label for="slug" class="form-label">@lang('menu_action/attribute.label_slug')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::text('slug',null, ['class' => $slug_err_class.'form-control', 'id' => 'slug', 'placeholder' => 'add', 'required' => true]) }}
            @if ($errors->has('slug'))
                <p class="text-danger">{{$errors->first('slug')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        @php $order_by_err_class = $errors->has('order_by') ? 'parsley-error ' : ''; @endphp
        <label for="order_by" class="form-label">@lang('menu_action/attribute.label_order_by')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::number('order_by', null, ['class' => $order_by_err_class.'form-control', 'min' => 1, 'id' => 'order_by', 'required' => 1]) }}
            @if ($errors->has('order_by'))
                <p class="text-danger">{{$errors->first('order_by')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-4">
        @php $status_err_class = $errors->has('status') ? 'parsley-error ' : ''; @endphp
        <label for="status" class="form-label">@lang('menu_action/attribute.label_status')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group form-group-check pl-4">
            <div class="form-check-custom">
                {{ Form::radio('status', '1',null, ['class' => 'form-check-input', 'id' => 'active', 'required' => 1, 'checked' => 1]) }}
                <label class="form-check-label" for="active">
                    @lang('menu_action/attribute.label_status_active')
                </label>
            </div>

            <div class="form-check-custom">
                {{ Form::radio('status', '0',null, ['class' => 'form-check-input', 'id' => 'inactive', 'required' => 1]) }}
                <label class="form-check-label" for="inactive">
                    @lang('menu_action/attribute.label_status_inactive')
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
            <i class="fa fa-save"></i> @lang('menu_action/attribute.label_submit_button')
        </button>
    </div>
</div>

@section('script')
    <script src="{{ URL::asset('/assets/common/libs/parsleyjs/parsleyjs.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/common/js/pages/form-validation.init.js') }}"></script>
@endsection
