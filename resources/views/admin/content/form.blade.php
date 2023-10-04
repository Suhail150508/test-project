<div class="row mb-3">
    <div class="col-sm-4 col-md-4 my-2">
        @php $error_class = $errors->has('name') ? 'parsley-error ' : ''; @endphp
        <label for="name" class="form-label">@lang('content.label_name')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::select('name', \App\Models\Content::contentTypes() ,null, ['class' => $error_class.'form-control', 'id' => 'member_id','placeholder' => trans('membership.label_member_id_select'), 'required' => true]) }}
            @if ($errors->has('name'))
                <p class="text-danger">{{$errors->first('name')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-12 my-2">
        @php $error_class = $errors->has('content_1') ? 'parsley-error ' : ''; @endphp
        <label for="content_1" class="form-label">@lang('content.label_content_1')</label>
        <sup class="text-danger">*</sup>
        <div class="form-group">
            {{ Form::textarea('content_1', null, ['class' => $error_class.'form-control editor', 'id' => 'content_1', 'required' => 1]) }}
            @if ($errors->has('content_1'))
                <p class="text-danger">{{$errors->first('content_1')}}</p>
            @endif
        </div>
    </div>

    <div class="col-sm-12 col-md-12 my-2">
        @php $error_class = $errors->has('content_2') ? 'parsley-error ' : ''; @endphp
        <label for="content_2" class="form-label">@lang('content.label_content_2')</label>
        <div class="form-group">
            {{ Form::textarea('content_2', null, ['class' => $error_class.'form-control editor', 'id' => 'content_2', 'required' => false]) }}
            @if ($errors->has('content_2'))
                <p class="text-danger">{{$errors->first('content_2')}}</p>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-right">
        <button type="submit" class="btn btn-primary waves-effect waves-light">
            <i class="fa fa-save"></i> @lang('content.label_submit_button')
        </button>
    </div>
</div>

@section('script')
    <script src="{{ URL::asset('/assets/common/libs/parsleyjs/parsleyjs.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/common/js/pages/form-validation.init.js') }}"></script>
@endsection
