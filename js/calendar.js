$(function() {

    $('.datepicker').datepicker();
    $('#fromCal').on("changeDate", function() {
        $('#fromDate').text(
            $('#fromCal').datepicker('getFormattedDate')
        );
    });

})