<script type="text/javascript">
    $('#all_btn_tab').on( 'click', function () {
        $('.select_all_checkbox').prop('checked',false);
        if($(this).hasClass('active')){
            $('.multiple_restore').hide()
            $('#datatable').DataTable().ajax.reload();
        }else{

        }
    })

    $('#deleted_btn_tab').on( 'click', function () {
        $('.select_all_checkbox').prop('checked',false);
        if($('#all_btn_tab').hasClass('active')){

        }else{
            $('.multiple_restore').show()
            $('#deleted_list_datatable').DataTable().ajax.reload();
        }
    })
</script>
