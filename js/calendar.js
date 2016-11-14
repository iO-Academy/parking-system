$(function() {

    $date = new Date();
    $month = $date.getMonth();

    $fromDate = $('#fromCal')
    $toDate = $('#toCal')

    $fromDate.datepicker({
        multidate: true,
        todayHighlight: true,
        clearBtn: true,
        defaultViewDate: { month: $month }});

    $fromDate.on("changeDate", function() {
        $('#fromSpan').text(
            $fromDate.datepicker('getFormattedDate')
        );
    });

    $toDate.datepicker({
        multidate: true,
        todayHighlight: true,
        clearBtn: true,
        defaultViewDate: { month: $month + 1 }});

    $toDate.on("changeDate", function() {
        $('#toSpan').text(
            $toDate.datepicker('getFormattedDate')
        );
    });

})