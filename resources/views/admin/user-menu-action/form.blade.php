<div class="row mb-3">
    <div class="col-sm-4 my-2">
        @php $error_class = $errors->has('menu_action_id') ? 'parsley-error ' : ''; @endphp
        <label for="menu_action_id" class="form-label">@lang('user_menu_action/attribute.label_menu_action_id')</label>
        <div class="form-group">
            {{ Form::select('menu_action_id', $menu_action_list, null, ['class' => $error_class.'form-control select2', 'id' => 'menu_action_id', 'placeholder' => trans('user_menu_action/attribute.label_select_menu_action_id'), 'required' => false]) }}
            @if ($errors->has('menu_action_id'))
                <p class="text-danger">{{$errors->first('menu_action_id')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-4 my-2">
        @php $error_class = $errors->has('parent_id') ? 'parsley-error ' : ''; @endphp
        <label for="parent_id" class="form-label">@lang('user_menu_action/attribute.label_parent_id')</label>
        <div class="form-group">
            {{ Form::select('parent_id', $parent_user_menu_actions, null, ['class' => $error_class.'form-control select2', 'id' => 'parent_id', 'placeholder' => trans('user_menu_action/attribute.label_select_one'), 'required' => false]) }}
            @if ($errors->has('parent_id'))
                <p class="text-danger">{{$errors->first('parent_id')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-4 my-2">
        @php $error_class = $errors->has('name') ? 'parsley-error ' : ''; @endphp
        <label for="name" class="form-label">@lang('user_menu_action/attribute.label_name')</label>
        <div class="form-group">
            {{ Form::text('name', null, ['class' => $error_class.'form-control', 'id' => 'name', 'required' => false]) }}
            @if ($errors->has('name'))
                <p class="text-danger">{{$errors->first('name')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-4 my-2">
        @php $error_class = $errors->has('bn_name') ? 'parsley-error ' : ''; @endphp
        <label for="bn_name" class="form-label">@lang('user_menu_action/attribute.label_bn_name')</label>
        <div class="form-group">
            {{ Form::text('bn_name', null, ['class' => $error_class.'form-control', 'id' => 'bn_name', 'required' => false]) }}
            @if ($errors->has('bn_name'))
                <p class="text-danger">{{$errors->first('bn_name')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-4 my-2">
        @php $error_class = $errors->has('route_name') ? 'parsley-error ' : ''; @endphp
        <label for="route_name" class="form-label">@lang('user_menu_action/attribute.label_route_name')</label>
        <div class="form-group">
            {{ Form::text('route_name',null, ['class' => $error_class.'form-control', 'id' => 'route_name', 'required' => false]) }}
            @if ($errors->has('route_name'))
                <p class="text-danger">{{$errors->first('route_name')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-4 my-2">
        @php $error_class = $errors->has('type') ? 'parsley-error ' : ''; @endphp
        <label for="type" class="form-label">@lang('user_menu_action/attribute.label_type')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::select('type', \App\Models\UserMenuAction::type(), null, ['class' => $error_class.'form-control', 'id' => 'type', 'required' => 1]) }}
            @if ($errors->has('type'))
                <p class="text-danger">{{$errors->first('type')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-4 my-2">
        @php $error_class = $errors->has('slug') ? 'parsley-error ' : ''; @endphp
        <label for="slug" class="form-label">@lang('user_menu_action/attribute.label_slug')</label>
        <div class="form-group">
            {{ Form::text('slug',null, ['class' => $error_class.'form-control', 'id' => 'slug', 'required' => false]) }}
            @if ($errors->has('slug'))
                <p class="text-danger">{{$errors->first('slug')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-4 my-2">
        @php $error_class = $errors->has('class') ? 'parsley-error ' : ''; @endphp
        <label for="class" class="form-label">@lang('user_menu_action/attribute.label_class')</label>
        <div class="form-group">
            {{ Form::text('class',null, ['class' => $error_class.'form-control', 'id' => 'class', 'required' => false]) }}
            @if ($errors->has('class'))
                <p class="text-danger">{{$errors->first('class')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-4 my-2">
        @php $error_class = $errors->has('order_by') ? 'parsley-error ' : ''; @endphp
        <label for="order_by" class="form-label">@lang('user_menu_action/attribute.label_order_by')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::number('order_by', null, ['class' => $error_class.'form-control', 'min' => 1, 'id' => 'order_by', 'required' => 1]) }}
            @if ($errors->has('order_by'))
                <p class="text-danger">{{$errors->first('order_by')}}</p>
            @endif
        </div>
    </div>
    <div class="col-sm-4 my-2">
        @php $error_class = $errors->has('is_hidden') ? 'parsley-error ' : ''; @endphp
        <label for="is_hidden" class="form-label">@lang('menu/attribute.label_is_hidden')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group form-group-check pl-4">
            <div class="form-check-custom">
                {{ Form::radio('is_hidden', 'Yes',null, ['class' => 'form-check-input', 'id' => 'is_hidden_yes', 'required' => 1,]) }}
                <label class="form-check-label" for="is_hidden_yes">
                    @lang('menu/attribute.label_is_hidden_yes')
                </label>
            </div>

            <div class="form-check-custom">
                {{ Form::radio('is_hidden', 'No',null, ['class' => 'form-check-input', 'id' => 'is_hidden_no', 'required' => 1,'checked' => old('is_hidden') ? null : (@$user_menu_action->is_hidden == 'Yes' ? false : true)]) }}
                <label class="form-check-label" for="is_hidden_no">
                    @lang('menu/attribute.label_is_hidden_no')
                </label>
            </div>
            @if ($errors->has('is_hidden'))
                <p class="text-danger">{{$errors->first('is_hidden')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-4 my-2">
        @php $error_class = $errors->has('show_in_table') ? 'parsley-error ' : ''; @endphp
        <label for="show_in_table" class="form-label">@lang('user_menu_action/attribute.label_show_in_table')</label>
        <div class="form-group form-group-check pl-4">
            <div class="form-check-custom">
                {{ Form::radio('show_in_table', '1',null, ['class' => 'form-check-input', 'id' => 'show_in_table_active', 'required' => false,'checked' => true]) }}
                <label class="form-check-label" for="show_in_table_active">
                    @lang('user_menu_action/attribute.label_show_in_table_yes')
                </label>
            </div>

            <div class="form-check-custom">
                {{ Form::radio('show_in_table', '0',null, ['class' => 'form-check-input', 'id' => 'show_in_table_inactive', 'required' => 1 ]) }}
                <label class="form-check-label" for="show_in_table_inactive">
                    @lang('user_menu_action/attribute.label_show_in_table_no')
                </label>
            </div>
            @if ($errors->has('show_in_table'))
                <p class="text-danger">{{$errors->first('show_in_table')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-4 my-2">
        @php $error_class = $errors->has('new_tab') ? 'parsley-error ' : ''; @endphp
        <label for="new_tab" class="form-label">@lang('user_menu_action/attribute.label_new_tab')</label>
        <div class="form-group form-group-check pl-4">
            <div class="form-check-custom">
                {{ Form::radio('new_tab', '1',null, ['class' => 'form-check-input', 'id' => 'new_tab_active', 'required' => false,]) }}
                <label class="form-check-label" for="new_tab_active">
                    @lang('user_menu_action/attribute.label_new_tab_yes')
                </label>
            </div>

            <div class="form-check-custom">
                {{ Form::radio('new_tab', '0',null, ['class' => 'form-check-input', 'id' => 'new_tab_inactive', 'required' => 1 ,'checked' => @$user_menu_action->new_tab == 1 ? false : true]) }}
                <label class="form-check-label" for="new_tab_inactive">
                    @lang('user_menu_action/attribute.label_new_tab_no')
                </label>
            </div>
            @if ($errors->has('new_tab'))
                <p class="text-danger">{{$errors->first('new_tab')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-4 my-2">
        @php $error_class = $errors->has('status') ? 'parsley-error ' : ''; @endphp
        <label for="status" class="form-label">@lang('user_menu_action/attribute.label_status')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group form-group-check pl-4">
            <div class="form-check-custom">
                {{ Form::radio('status', '1',null, ['class' => 'form-check-input', 'id' => 'active', 'required' => 1, 'checked' => 1]) }}
                <label class="form-check-label" for="active">
                    @lang('user_menu_action/attribute.label_status_active')
                </label>
            </div>

            <div class="form-check-custom">
                {{ Form::radio('status', '0',null, ['class' => 'form-check-input', 'id' => 'inactive', 'required' => 1]) }}
                <label class="form-check-label" for="inactive">
                    @lang('user_menu_action/attribute.label_status_inactive')
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
            <i class="fa fa-save"></i> @lang('user_menu_action/attribute.label_submit_button')
        </button>
    </div>
</div>

@section('script')
    <script src="{{ URL::asset('/assets/common/libs/parsleyjs/parsleyjs.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/common/js/pages/form-validation.init.js') }}"></script>
@endsection
