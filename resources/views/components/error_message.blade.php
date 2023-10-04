@if (session('error') || $errors->first())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-block-helper me-2"></i>
        {{ session('error') }}
        {{ $errors->first() }}
        @php
            Session::forget('error');
        @endphp
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div id="ajax_error_alert" class="d-none">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-block-helper me-2"></i>
        <span id="ajax_error"></span>
    </div>
</div>
