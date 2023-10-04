{{-- code for destroy --}}
<script type="text/javascript">
    $('table tbody').on( 'click', '.destroy', function () {
        event.preventDefault();
        let url = $(this).attr('href')
        let tr = $(this).parent().parent();

        if ($('#deleted_btn_tab').hasClass('active')){
            permanently_delete_function(url,tr)
        } else {
            delete_function(url,tr)
        }

    });

    function delete_function(URL,TR) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: "@lang('common.are_you_sure')",
            text: "@lang('common.will_find_in_deleted_list')",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "@lang('common.yes_delete')",
            cancelButtonText: "@lang('common.no_cancel')",
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
                    url: URL,
                    type: 'DELETE',
                    dataType: 'JSON',
                    cache: false,
                    success: function (response) {
                        toastr["success"](response.message, "@lang('common.delete_success')");
                        TR.remove();
                    },
                    error: function (xhr) {
                        toastr["error"]("@lang('common.not_deleted')", "@lang('common.sorry')");
                    }
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                toastr["error"]("@lang('common.safe')", "@lang('common.cancelled')");
            }
        })
    }

    function permanently_delete_function(URL,TR) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: "@lang('common.are_you_sure')",
            text: "@lang('common.you_wont_be_able_to_recover_this')",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "@lang('common.yes_delete_permanently')",
            cancelButtonText: "@lang('common.no_cancel')",
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
                    url: URL,
                    type: 'DELETE',
                    dataType: 'JSON',
                    cache: false,
                    success: function (response) {
                        toastr["success"](response.message, "@lang('common.deleted_permanently')");
                        TR.remove();
                    },
                    error: function (xhr) {
                        toastr["error"]("@lang('common.not_deleted')", "@lang('common.sorry')");
                    }
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                toastr["error"]("@lang('common.safe')", "@lang('common.cancelled')");
            }
        })
    }
</script>

{{-- code for delete --}}
<script type="text/javascript">
    $('table tbody').on( 'click', '.delete', function () {
        event.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to recover this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it !',
            cancelButtonText: 'No, cancel !',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                $.ajax({
                    url: $(this).attr('href'),
                    type: 'DELETE',
                    dataType: 'JSON',
                    cache: false,

                    success: function (response) {
                        toastr["success"](response.message, "@lang('common.delete_success')");
                        $('#datatable').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        toastr["error"]("@lang('common.not_deleted')", "@lang('common.sorry')");
                    }
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your data is safe :)',
                    'error'
                )
            }
        })
    });
</script>

{{-- code for select all deleted checkbox --}}
<script type="text/javascript">
    $('.select_all_checkbox').click(function(event) {
        let parent = $(this).parent().parent().parent().parent('table')
        if(this.checked) {
            // Iterate each checkbox
            $(parent).find('.multi_checkbox').each(function() {
                this.checked = true;
            });
        } else {
            $(parent).find('.multi_checkbox').each(function() {
                this.checked = false;
            });
        }
    });
</script>

{{-- code for multiple delete --}}
<script type="text/javascript">
    $(document).on('click', '.multiple_delete', function(){
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
                title: 'Are you sure?',
                text: "You won't be able to recover this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it !',
                cancelButtonText: 'No, cancel !',
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
                            toastr["success"](response.message, "@lang('common.delete_success')");
                            $('#datatable').DataTable().ajax.reload();
                            $('#deleted_list_datatable').DataTable().ajax.reload();
                        },
                        error: function (xhr) {
                            toastr["error"]("@lang('common.not_deleted')", "@lang('common.sorry')");
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

@include('components.tab_view_script')
@include('components.restore_script')
