$(".bn_language").bnKb({
    'switchkey': {"mozilla": "m", "chrome": "m"},
    'driver': phonetic
});
//datatable init
$('.data-table-filter').DataTable();
if ($(".dataTables_filter input[type='search']").length > 0) {
    setTimeout(function () {
        $(".dataTables_filter input[type='search']").addClass('bn_language');
        $(".bn_language").bnKb({
            'switchkey': {"mozilla": "m", "chrome": "m"}, 'driver': phonetic
        });
    }, 1000);
}

//enable bangla for select2
$(document).on('click', '.select2', function() {
    if($(this).parent().children('.select2').hasClass('bn_language')){
        $('.select2-search__field').bnKb({
            'switchkey': {"mozilla": "m", "chrome": "m"},
            'driver': phonetic
        });
    }
});
