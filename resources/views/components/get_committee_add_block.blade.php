<div class="border border-top mb-3 p-3">
    <div class="row committee_row">
        <div class="col-sm-4 col-md-4 my-2">
            @php /** @var string $errors */
                $error_class = $errors->has('office_id') ? 'parsley-error ' : ''; @endphp
            <label for="office_id" class="form-label">@lang('application.office_id')</label>
            <sup class="text-danger">*</sup>
            <div class="form-group">
                {{ Form::select('office_id[]', $offices, null, ['class' => $error_class.'form-control office_id', 'placeholder' => trans('application.select_one'), 'id' => 'office_id', 'required' => true]) }}
                @if ($errors->has('office_id'))
                    <p class="text-danger">{{$errors->first('office_id')}}</p>
                @endif
            </div>
        </div>

        <div class="col-sm-4 col-md-4 my-2">
            @php /** @var string $errors */
                $error_class = $errors->has('district_id') ? 'parsley-error ' : ''; @endphp
            <label for="district_id" class="form-label">@lang('application.district_id')</label>
            <div class="form-group">
                {{ Form::select('district_id[]', [], null, ['class' => $error_class.'form-control district_id select2', 'placeholder' => trans('application.select_one'), 'required' => false]) }}
                @if ($errors->has('district_id'))
                    <p class="text-danger">{{$errors->first('district_id')}}</p>
                @endif
            </div>
        </div>

        <div class="col-sm-4 col-md-4 my-2 text-right">
            <br>
            <a href="javascript:" class="btn btn-danger mt-2 remove_committee_add_block"><i class="fa fa-trash"></i> Remove</a>
        </div>

        <div class="col-sm-4 col-md-4 my-2">
            @php /** @var string $errors */
                $error_class = $errors->has('fire_station_id') ? 'parsley-error ' : ''; @endphp
            <label for="fire_station_id" class="form-label">@lang('application.fire_station_id')</label>
            <div class="form-group">
                {{ Form::select('fire_station_id[]', [], null, ['class' => $error_class.'form-control fire_station_id select2', 'placeholder' => trans('application.select_one'), 'required' => false]) }}
                @if ($errors->has('fire_station_id'))
                    <p class="text-danger">{{$errors->first('fire_station_id')}}</p>
                @endif
            </div>
        </div>

        <div class="col-sm-4 col-md-4 my-2">
            @php /** @var string $errors */
                    $error_class = $errors->has('user_id') ? 'parsley-error ' : ''; @endphp
            <label for="user_id" class="form-label">@lang('application.user_id')</label>
            <sup class="text-danger">*</sup>
            <div class="form-group">
                {{ Form::select('user_id[]', [], null, ['class' => $error_class.'form-control user_id select2', 'placeholder' => trans('application.select_one'), 'required' => true]) }}
                @if ($errors->has('user_id'))
                    <p class="text-danger">{{$errors->first('user_id')}}</p>
                @endif
            </div>
        </div>

        <div class="col-sm-4 col-md-4 my-2">
            @php /** @var string $errors */
                    $error_class = $errors->has('membership_id') ? 'parsley-error ' : ''; @endphp
            <label for="membership_id" class="form-label">@lang('application.membership_id')</label>
            <sup class="text-danger">*</sup>
            <div class="form-group">
                {{ Form::select('membership_id[]', $memberships, null, ['class' => $error_class.'form-control select2', 'placeholder' => trans('application.select_one'), 'required' => true]) }}
                @if ($errors->has('membership_id'))
                    <p class="text-danger">{{$errors->first('membership_id')}}</p>
                @endif
            </div>
        </div>

    </div>
</div>
