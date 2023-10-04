@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show text-uppercase" role="alert">
        <i class="fa fa-check"></i>
        {{ session('success') }}
        @php
            Session::forget('success');
        @endphp
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-check"></i>
        {{ session('status') }}
        @php
            Session::forget('status');
        @endphp
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
