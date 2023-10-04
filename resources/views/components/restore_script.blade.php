{{-- code for destroy --}}
<script type="text/javascript">
    $('table tbody').on( 'click', '.restore', function () {
        event.preventDefault();
        var tr = $(this).parent().parent();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: '@lang('common.are_you_sure_to_restore')',
            /*text: "You won't be able to recover this!",*/
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '@lang('common.yes_restore')',
            cancelButtonText: '@lang('common.no_cancel')',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: $(this).attr('href'),
                    type: 'GET',
                    dataType: 'JSON',
                    cache: false,
                    success: function (response) {
                        toastr["success"](response.message, "@lang('common.restore_success')");
                        tr.remove();
                    },
                    error: function (xhr) {
                        toastr["error"]('@lang('common.not_restored')', "@lang('common.sorry')");
                    }
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                toastr["error"]("@lang('common.safe')", "@lang('common.cancelled')");

            }
        })
    });
</script>

{{-- code for multiple restore --}}
<script type="text/javascript">
    $(document).on('click', '.multiple_restore', function(){
        event.preventDefault();
        let url = $(this).attr('href')
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        var ids = [];
        $('.multi_checkbox:checked').each(function(){
            ids.push($(this).val());
        });
        if(ids.length > 0){
            swalWithBootstrapButtons.fire({
                title: '@lang('common.are_you_sure_to_restore')',
                /*text: "You won't be able to recover this!",*/
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '@lang('common.yes_restore')',
                cancelButtonText: '@lang('common.no_cancel')',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        type: 'post',
                        dataType: 'JSON',
                        cache: false,
                        data:{ids:ids},
                        success: function (response) {
                            toastr["success"](response.message, "@lang('common.restore_success')");
                            $('#datatable').DataTable().ajax.reload();
                            $('#deleted_list_datatable').DataTable().ajax.reload();
                        },
                        error: function (xhr) {
                            toastr["error"]('@lang('common.not_restored')', "@lang('common.sorry')");
                        }
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    toastr["error"]("@lang('common.safe')", "@lang('common.cancelled')");
                }
            })
        }else{
            swalWithBootstrapButtons.fire({
                title: "Failed !",
                text: 'Select at least one row',
                dangerMode: true,
                icon: "error",
                showConfirmButton: true,
                timer: 4000
            });
        }
    });
</script>
