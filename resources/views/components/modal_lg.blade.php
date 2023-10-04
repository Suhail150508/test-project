@section('modal_lg_content')
    <div class="modal fade" id="modal_lg" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal_content">

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        //script for show modal form
        $(document).on('click','.modal_lg_button',function(event){
            $('#loader').show();
            event.preventDefault();
            let parent_attribute = $(this).attr('parent')
            let parent = ''
            let parent_id = ''
            //check for class find
            if($(this).closest('.'+parent_attribute).length > 0){
                parent = $(this).closest('.'+parent_attribute)
            }else if($(this).find('.'+parent_attribute).length > 0){
                parent = $(this).find('.'+parent_attribute)
            }else if($(this).next('.'+parent_attribute).length > 0){
                parent = $(this).next('.'+parent_attribute)
            }else if($(this).parent().find('.'+parent_attribute).length > 0){
                parent = $(this).parent().find('.'+parent_attribute)
            }else if($(this).parent().parent().find('.'+parent_attribute).length > 0){
                parent = $(this).parent().parent().find('.'+parent_attribute)
            }else if($(this).parent().parent().parent().find('.'+parent_attribute).length > 0){
                parent = $(this).parent().parent().parent().find('.'+parent_attribute)
            }else if($(this).parent().parent().parent().parent().find('.'+parent_attribute).length > 0){
                parent = $(this).parent().parent().parent().parent().find('.'+parent_attribute)
            }else if($(this).parent().parent().parent().parent().parent().find('.'+parent_attribute).length > 0){
                parent = $(this).parent().parent().parent().parent().parent().find('.'+parent_attribute)
            }

            //check for id find
            else if($(this).closest('#'+parent_attribute).length > 0){
                parent = $(this).closest('#'+parent_attribute)
            }else if($(this).find('#'+parent_attribute).length > 0){
                parent = $(this).find('#'+parent_attribute)
            }else if($(this).next('#'+parent_attribute).length > 0){
                parent = $(this).next('#'+parent_attribute)
            }else if($(this).parent().find('#'+parent_attribute).length > 0){
                parent = $(this).parent().find('#'+parent_attribute)
            }else if($(this).parent().parent().find('#'+parent_attribute).length > 0){
                parent = $(this).parent().parent().find('#'+parent_attribute)
            }else if($(this).parent().parent().parent().find('#'+parent_attribute).length > 0){
                parent = $(this).parent().parent().parent().find('#'+parent_attribute)
            }else if($(this).parent().parent().parent().parent().find('#'+parent_attribute).length > 0){
                parent = $(this).parent().parent().parent().parent().find('#'+parent_attribute)
            }else if($(this).parent().parent().parent().parent().parent().find('#'+parent_attribute).length > 0){
                parent = $(this).parent().parent().parent().parent().parent().find('#'+parent_attribute)
            }

            if(parent != null){
                parent_id =  $(parent).val();
            }

            $.ajax({
                url: $(this).attr('href'),
                type: 'get',
                dataType: 'html',
                cache: false,
                data : {parent_id : parent_id},
                success: function (response) {
                    setTimeout(function(){
                        $('#loader').hide();
                    }, 280);

                    $('#modal_lg').find('.modal_content').html(response);
                    $('#modal_lg').modal('show');

                    element_load()
                },
                error: function (xhr) {
                    setTimeout(function(){
                        $('#loader').hide();
                    }, 280);
                }
            });
        });

        function element_load(){
            $('#modal_form').find('.select2').select2({
                tags: false,
            });
            $('.custom-validation').parsley();
            $(".bn_language").bnKb({
                'switchkey': {"mozilla": "m", "chrome": "m"},
                'driver': phonetic
            });
        }

        $(document).on('submit', '#modal_form', function (event) {
           $('#loader').show();
            let modal_error_alert = $('#modal_error_alert')
            let modal_error = modal_error_alert.find('#modal_error')
            modal_error.text('')
           modal_error_alert.addClass('d-none');
            event.preventDefault();
            let vm = $(this)
            let input_array = ['input', 'select']
            vm.find('.parsley-errors-list').remove();
            input_array.forEach(function (value, index) {
                vm.find(value).removeClass('parsley-error');
            });
            let data = $(this).serialize();
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'JSON',
                cache: false,
                data: data,
                success: function (response) {
                    if(window.vue_data && window.vue_data.getResponseDataFromAjax){
                        window.vue_data.getResponseDataFromAjax(response)
                    }
                    toastr["success"](response.message, '@lang("common.success")');
                    $('#modal_lg').modal('hide');

                    $('#example').DataTable()
                    $('#datatable').DataTable().ajax.reload();
                    setTimeout(function(){
                        $('#loader').hide();
                    }, 280);
                },
                error: function (xhr) {
                   modal_error_alert.removeClass('d-none');
                    if(xhr.status == 500 && xhr.responseJSON){
                        modal_error.text(xhr.responseJSON);
                    }

                    if(xhr.responseJSON && xhr.responseJSON.exception){
                        modal_error.text(xhr.responseJSON.message);
                    }
                    if(xhr.responseJSON && xhr.responseJSON.errors){
                        let errors = Object.entries(xhr.responseJSON.errors);
                        for(let error of errors){
                            modal_error.text(error[1]);
                            break
                        }

                        for(let error of errors){
                            input_array.forEach(function (value, index) {
                                let input = $(value+'[name='+error[0]+']');
                                vm.find(input).addClass('parsley-error');
                                vm.find(input).after(
                                    '<ul class="parsley-errors-list filled" aria-hidden="false">' +
                                    '<li class="parsley-required">'+error[1]+'</li>' +
                                    '</ul>'
                                );
                            });
                        }
                    }
                    setTimeout(function(){
                        $('#loader').hide();
                    }, 280);
                }
            });
        });

    </script>
@endpush
