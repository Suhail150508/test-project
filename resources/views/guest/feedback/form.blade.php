<div class="bg-transparent align-items-lg-center d-flex m-2 p-2">
    <div class="card bg-transparent text-white">
        <div class="card-header">
            <h4 class="text-white">@lang('feedback.person_opinion')</h4>
            <hr>
        </div>
        <div class="card-body">
            <div class="row mb-3">

                <div class="col-sm-12 col-md-6 col-lg-4 my-2">
                    @php /** @var string $errors */
            $error_class = $errors->has('name') ? 'parsley-error ' : ''; @endphp
                    <label for="name" class="form-label">@lang('feedback.person_name')</label>
                    <sup class="text-danger">*</sup>
                    <div class="form-group">
                        {{ Form::text('name', null, ['class' => $error_class.'form-control', 'id' => 'name', 'required' => false]) }}
                        @if ($errors->has('name'))
                            <p class="text-danger">{{$errors->first('name')}}</p>
                        @endif
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4 my-2">
                    @php /** @var string $errors */
            $error_class = $errors->has('mobile') ? 'parsley-error ' : ''; @endphp
                    <label for="mobile" class="form-label">@lang('feedback.person_mobile')</label>
                    <sup class="text-danger">*</sup>
                    <div class="form-group">
                        {{ Form::text('mobile', null, ['class' => $error_class.'form-control', 'id' => 'mobile', 'required' => false]) }}
                        @if ($errors->has('mobile'))
                            <p class="text-danger">{{$errors->first('mobile')}}</p>
                        @endif
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-4 my-2">
                    @php /** @var string $errors */
            $error_class = $errors->has('email') ? 'parsley-error ' : ''; @endphp
                    <label for="email" class="form-label">@lang('feedback.person_email')</label>
                    <sup class="text-danger">*</sup>
                    <div class="form-group">
                        {{ Form::text('email', null, ['class' => $error_class.'form-control', 'id' => 'email', 'required' => false]) }}
                        @if ($errors->has('email'))
                            <p class="text-danger">{{$errors->first('email')}}</p>
                        @endif
                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-12 my-2">
                    @php /** @var string $errors */
                        $error_class = $errors->has('opinion') ? 'parsley-error ' : ''; @endphp
                    <label for="bn_name" class="form-label">@lang('feedback.person_opinion')</label>
                    <sup class="text-danger">*</sup>
                    <div class="form-group">
                        {{ Form::textarea('opinion', null, ['class' => $error_class.'form-control textarea', 'placeholder' => trans('feedback.person_opinion'), 'id' => 'opinion', 'required' => false, 'rows' => 3 ]) }}
                        @if ($errors->has('opinion'))
                            <p class="text-danger">{{$errors->first('opinion')}}</p>
                        @endif
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        <i class="fa fa-save"></i> @lang('feedback.label_submit_button')
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
