
<script>
    $(document).ready(function () {
        $('#togBtn').on('click',function () {
            if($(this).is(':checked')){
                console.log('togBtn')
            } else{

            }
        })
    })
</script>

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
        $('[data-toggle="tooltip"]').tooltip();
        $(".select2").select2({
            tags: true,
        });

        $('.show_calendar').click(function () {
            $(this).parent().find('.datepicker').datepicker('show');
        })

        $(".datepicker").datepicker({
            format: "dd-mm-yyyy",
            setDate: new Date(),
        })

        $('.show_year_calendar').click(function () {
            $(this).parent().find('.yearpicker').datepicker('show');
        })
    })

    function Print(printed_area) {
        var printContents = document.getElementById(printed_area).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();
        window.close()
        document.body.innerHTML = originalContents;

    }
</script>

<script>
    //dynamic select change
    function SelectChange(url,to_class, selectObject){
        let vm = $(selectObject)
        let to_select = ''
        let value = vm.val()
        if(vm.next('.'+to_class).length > 0){
            to_select = vm.next('.'+to_class)
        }else if(vm.parent().find('.'+to_class).length){
            to_select = vm.parent().find('.'+to_class)
        }else if(vm.parent().parent().find('.'+to_class).length){
            to_select = vm.parent().parent().find('.'+to_class)
        }else if(vm.parent().parent().parent().find('.'+to_class).length){
            to_select = vm.parent().parent().parent().find('.'+to_class)
        }else if(vm.parent().parent().parent().parent().find('.'+to_class).length){
            to_select = vm.parent().parent().parent().parent().find('.'+to_class)
        }
        to_select.addClass('dependent_select')
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $('#loader').show()
        $.ajax({
            url:  url,
            type: 'post',
            dataType: 'html',
            data : {key: value},
            cache: false,
            success: function (response) {
                to_select.html(response)
                setTimeout(function(){
                    $('#loader').hide();
                }, 280);
            },
            error: function (xhr) {
                setTimeout(function(){
                    $('#loader').hide();
                }, 280);
            }
        });
    }

    //dynamic select change
    function SelectChangeDependent(url,to_class, selectObject, filterClass){
        let vm = $(selectObject)
        let to_select = ''
        let filter_select = ''
        let value = vm.val()
        if(vm.next('.'+to_class).length > 0){
            to_select = vm.next('.'+to_class)
        }else if(vm.parent().find('.'+to_class).length){
            to_select = vm.parent().find('.'+to_class)
        }else if(vm.parent().parent().find('.'+to_class).length){
            to_select = vm.parent().parent().find('.'+to_class)
        }else if(vm.parent().parent().parent().find('.'+to_class).length){
            to_select = vm.parent().parent().parent().find('.'+to_class)
        }else if(vm.parent().parent().parent().parent().find('.'+to_class).length){
            to_select = vm.parent().parent().parent().parent().find('.'+to_class)
        }
        to_select.addClass('dependent_select')

        // to add extra filter parameter like type
        if(vm.next('.'+filterClass).length > 0){
            filter_select = vm.next('.'+filterClass)
        }else if(vm.parent().find('.'+filterClass).length){
            filter_select = vm.parent().find('.'+filterClass)
        }else if(vm.parent().parent().find('.'+filterClass).length){
            filter_select = vm.parent().parent().find('.'+filterClass)
        }else if(vm.parent().parent().parent().find('.'+filterClass).length){
            filter_select = vm.parent().parent().parent().find('.'+filterClass)
        }else if(vm.parent().parent().parent().parent().find('.'+filterClass).length){
            filter_select = vm.parent().parent().parent().parent().find('.'+filterClass)
        }
        let filter = filter_select.val()

        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $('#loader').show()
        $.ajax({
            url:  url,
            type: 'post',
            dataType: 'html',
            data : {id: value, filter: filter},
            cache: false,
            success: function (response) {
                to_select.html(response)
                setTimeout(function(){
                    $('#loader').hide();
                }, 280);
            },
            error: function (xhr) {
                setTimeout(function(){
                    $('#loader').hide();
                }, 280);
            }
        });
    }

    //dynamic clone
    function CloneItem(clone_item, clone_to){
        $('.select2').removeClass('clone_select2')
        clone_item = $('.'+clone_item+':first')
        let data = clone_item.clone();
        data.find('.select2').addClass('clone_select2')
        let clone_data = $('.'+clone_to).append(data);
        data.find('.append_delete_btn').show()
        $('.clone_select2').select2();
        $(clone_item).find('.select2').select2();
        $('.clone_select2').parent().children('.select2-container').next('.select2-container').remove()

        $(data).find('.dependent_select').find('option').not(':first').remove();
    }

    //dynamic remove
    function RemoveItem(object){
        object.remove()
    }

    //ajax status update code
    function statusUpdate(id, url) {
        $.ajax({
            type: "POST",
            url: url,
            data : {id: id},
            success: function(response) {

            },
            error: function(response) {
            }
        });
    }
</script>

