<!-- JAVASCRIPT -->
<script src="{{ URL::asset('assets/common/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ URL::asset('assets/common/libs/bootstrap/bootstrap.min.js')}}"></script>
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

<!-- toastr init -->
<script src="{{ URL::asset('/assets/common/js/pages/toastr.init.js') }}"></script>

<script src="{{ URL::asset('assets/common/js/phonetic/driver.phonetic.js')}}"></script>
<script src="{{ URL::asset('assets/common/js/phonetic/engine.js')}}"></script>
<script src="{{ URL::asset('assets/common/js/bangla_script.js')}}"></script>

{!! Toastr::message() !!}

<script>
    $('#change-password').on('submit',function(event){
        event.preventDefault();
        var Id = $('#data_id').val();
        var current_password = $('#current-password').val();
        var password = $('#password').val();
        var password_confirm = $('#password-confirm').val();
        $('#current_passwordError').text('');
        $('#passwordError').text('');
        $('#password_confirmError').text('');
        $.ajax({
            url: "{{ url('update-password') }}" + "/" + Id,
            type:"POST",
            data:{
                "current_password": current_password,
                "password": password,
                "password_confirmation": password_confirm,
                "_token": "{{ csrf_token() }}",
            },
            success:function(response){
                $('#current_passwordError').text('');
                $('#passwordError').text('');
                $('#password_confirmError').text('');
                if(response.isSuccess == false){
                    $('#current_passwordError').text(response.Message);
                }else if(response.isSuccess == true){
                    setTimeout(function () {
                        window.location.href = "{{ route('dashboard') }}";
                    }, 1000);
                }
            },
            error: function(response) {
                $('#current_passwordError').text(response.responseJSON.errors.current_password);
                $('#passwordError').text(response.responseJSON.errors.password);
                $('#password_confirmError').text(response.responseJSON.errors.password_confirmation);
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".select2").select2({
            tags: false,
        });
    })

    //numbers conversion from 1-0 to ১-০
    $("[lang='bang']").text(function(i, val) {
        return val.replace(/\d/g, function(v) {
            return String.fromCharCode(v.charCodeAt(0) + 0x09B6);
        });
    });
</script>
@yield('script')
@stack('script')

<!-- App js -->
<script src="{{ URL::asset('assets/common/js/app.min.js')}}"></script>

@yield('script-bottom')
