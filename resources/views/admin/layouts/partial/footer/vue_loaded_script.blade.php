<script>
    $(document).on('vue-loaded', function () {
        $('.select2vue').select2({});
        $(".bn_language_vue").bnKb({
            'switchkey': {"mozilla": "m", "chrome": "m"},
            'driver': phonetic
        });
        $(".datepicker").datepicker({
            format: "dd-mm-yyyy",
            setDate: new Date('now'),
        })

        $(".yearpicker").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        })

        $('.show_calendar').click(function () {
            $(this).parent().find('.datepicker').datepicker('show');
        })

        $('.show_year_calendar').click(function () {
            $(this).parent().find('.yearpicker').datepicker('show');
        })
    });
</script>
