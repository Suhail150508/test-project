<div id="modal_error_alert" class="d-none">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-block-helper me-2"></i>
        <span id="modal_error"></span>
    </div>
</div>
<div class="modal-header">
    <h5 class="modal-title text-info font-weight-semibold" id="modalLabel">{{$title}}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body" id="modal_body">
    @if(@$form_action && @$model)
        {!! Form::model($model,['url' => $form_action, 'method' => $method ,'class' => 'custom-validation', 'id' => 'modal_form']) !!}
    @elseif(@$form_action)
        {!! Form::open(['url' => $form_action, 'method' => $method ,'class' => 'custom-validation', 'id' => 'modal_form']) !!}
    @endif

    @if(@$body)
        {!! $body !!}
    @endif

    @if(@$included_path && $data)
        @include($included_path,$data)
    @elseif(@$included_path)
        @include($included_path,$data)
    @endif

    @if(@$form_action)
        {!! Form::close() !!}
    @endif
</div>
