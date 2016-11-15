$date = new Date()
$month = $date.getMonth()
$toStartDate = $date

$(function() {

    $fromDate = $('#fromCal')
    $toDate = $('#toCal')
    $visitorDate = $('#visitorCal')

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

    $visitorDate.datepicker({
        todayHighlight: true,
        startDate: $date,
        defaultViewDate: { month: $month }})

    $fromDate.on("changeDate", function() {
        $('#fromSpan').text(
            $fromDate.datepicker('getFormattedDate')
        )
        $toDate.datepicker()
        $toDate.datepicker('setStartDate', $fromDate.datepicker('getFormattedDate'))
        // var $start = $('#fromCal .active.day')
        // var $finish = $('#toCal .active.day')
        // rangeHighlight($start, $finish) @toDo Highlight range between selected dates.
    })

    $toDate.on("changeDate", function() {
        $('#toSpan').text(
            $toDate.datepicker('getFormattedDate')
        )
        // $start = $('#fromCal .active.day')
        // $finish = $('#toCal .active.day')
        // rangeHighlight($start, $finish) @toDo Highlight range between selected dates.
    })

    $visitorDate.on("changeDate", function() {
        $('#visitorSpan').text(
            $visitorDate.datepicker('getFormattedDate')
        )
        $toDate.datepicker()
        $toDate.datepicker('setStartDate', $fromDate.datepicker('getFormattedDate'))
    })

    function rangeHighlight($start, $finish) {
        $('.selected', $toDate).removeClass('selected')
        if (($('#fromCal .datepicker-switch').first().text()) === ($('#toCal .datepicker-switch').first().text())) {

            $fromDate.find('td:contains(' + $finish.text() + ')').addClass('selected')
            $toDate.find('td:contains(' + $start.text() + ')').addClass('selected')
        }
        if($start.length > 0 && $finish.length > 0) {
            $start.nextUntil('.selected', 'td:not(.new)').css("background-color", "#EEEEEE")
            $start.parent('tr').nextAll('tr').find('td:not(.new, .disabled)').each(function() {
                if($(this).hasClass('.selected')) {
                    return false
                } else {
                    $(this).css("background-color", "#EEEEEE")
                }
            })
            $finish.prevUntil('.selected', 'td:not(.old)').css("background-color", "#EEEEEE")
            $finish.parent('tr').prevAll('tr').find('td:not(.old, .disabled)').each(function() {
                if($(this).hasClass('.selected')) {
                    return false
                } else {
                    $(this).css("background-color", "#EEEEEE")
                }
            })
        }
    }

})


