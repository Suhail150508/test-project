    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="mdi mdi-block-helper me-2"></i>
        @lang('safety_firm.inactive_message_alert',['link' => route('safety_owner_profile.edit',@auth()->user()->company->id)])
    </div>

