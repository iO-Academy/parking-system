$date = new Date()
$month = $date.getMonth()
$toStartDate = $date

$(function() {

    $fromDate = $('#fromCal')
    $toDate = $('#toCal')

    $fromDate.datepicker({
        todayHighlight: true,
        clearBtn: true,
        startDate: $date,
        todayBtn: true,
        defaultViewDate: { month: $month }})

    $toDate.datepicker({
        todayHighlight: true,
        clearBtn: true,
        startDate: $toStartDate,
        todayBtn: true,
        defaultViewDate: { month: $month + 1 }
    })

    $fromDate.on("changeDate", function() {
        $('#fromSpan').text(
            $fromDate.datepicker('getFormattedDate')
        )
        $toDate.datepicker('setStartDate', $fromDate.datepicker('getFormattedDate'))
    })

    $toDate.on("changeDate", function() {
        $('#toSpan').text(
            $toDate.datepicker('getFormattedDate')
        )
    })
})