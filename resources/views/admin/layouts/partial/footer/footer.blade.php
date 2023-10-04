<footer class="footer-left-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-7">
                {{--{{ \App\Helpers\ENTOBN::convert_to_bangla( date('Y')) }} @--}} @lang('settings.copyright',['year' => \Illuminate\Support\Facades\Date::now()->format('Y')])
            </div>
            <div class="col-2">
                <div class="text-sm-end d-none d-sm-block">
                    <a target="_blank" href="https://www.perkyrabbit.com/"><img src="{{ URL::asset('assets/common/images/logo/perky_transparent.png') }}" title="০২-৫৫০৫৩৭০২" alt="Perky Rabbit"></a>
                </div>
            </div>
        </div>
    </div>
</footer>
