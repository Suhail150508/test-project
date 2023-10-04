<!-- JAVASCRIPT -->
<script src="{{ URL::asset('assets/common/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ URL::asset('assets/common/libs/bootstrap/bootstrap.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script src="{{ URL::asset('assets/common/libs/metismenu/metismenu.min.js')}}"></script>
<script src="{{ URL::asset('assets/common/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ URL::asset('assets/common/libs/node-waves/node-waves.min.js')}}"></script>
<script src="{{ URL::asset('assets/common/libs/select2/select2.min.js')}}"></script>
<!-- toastr plugin -->
<script src="{{ URL::asset('/assets/common/libs/toastr/toastr.min.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ URL::asset('/assets/common/libs/datatables/datatables.jquery.min.js') }}"></script>
<script src="{{ URL::asset('/assets/common/libs/datatables/datatables.min.js') }}"></script>
<!-- Sweet Alerts js -->
<script src="{{ URL::asset('/assets/common/libs/sweetalert2/sweetalert2.min.js') }}"></script>
{{--tinymce editor--}}
<script src="{{ URL::asset('/assets/common/libs/tinymce/tinymce.min.js') }}"></script>

<script src="{{ URL::asset('/assets/common/js/pages/form-editor.init.js') }}"></script>

<!-- toastr init -->
<script src="{{ URL::asset('/assets/common/js/pages/toastr.init.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/tooltip.js" >
</script>

<script src="{{ URL::asset('assets/common/js/phonetic/driver.phonetic.js')}}"></script>
<script src="{{ URL::asset('assets/common/js/phonetic/engine.js')}}"></script>
<script src="{{ URL::asset('assets/common/js/bangla_script.js')}}"></script>
{!! Toastr::message() !!}

@include('admin.layouts.partial.footer.footer_element')

@yield('script')
@stack('script')

<!-- App js -->
<script src="{{ URL::asset('assets/common/js/app.min.js')}}"></script>
<script>
    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
</script>
<script>
    function make_bangla(){
        //numbers conversion from 1-0 to ১-০
        $("[lang='bang']").text(function(i, val) {
            return val.replace(/\d/g, function(v) {
                return String.fromCharCode(v.charCodeAt(0) + 0x09B6);
            });
        });
    }

    $(function () {
        make_bangla()
    })
</script>

@yield('script-bottom')
