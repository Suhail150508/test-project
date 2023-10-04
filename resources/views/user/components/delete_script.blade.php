{{-- code for destroy --}}
<script type="text/javascript">
    $('table tbody').on( 'click', '.destroy', function () {
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
            title: 'Are you sure ?',
            text: "You won't be able to recover this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete it!',
            cancelButtonText: 'No, cancel! ',
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
                    type: 'DELETE',
                    dataType: 'JSON',
                    cache: false,
                    success: function (response) {
                        toastr["success"](response.message, "Delete");
                        tr.remove();
                    },
                    error: function (xhr) {
                        toastr["error"]('Data not deleted', "Sorry");
                    }
                });
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                toastr["error"]('Your data is safe ', "Cancelled");

            }
        })
    });
</script>