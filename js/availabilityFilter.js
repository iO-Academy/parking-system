$date = new Date()
$month = $date.getMonth()
$toStartDate = $date

$(function() {

    // Calendar

    $fromDate = $('#fromCal')
    $toDate = $('#toCal')
    $visitorDate = $('#visitorCal')

    $fromDate.datepicker({
        todayHighlight: true,
        // clearBtn: true,
        startDate: $date,
        // todayBtn: true,
        defaultViewDate: { month: $month }})

    $toDate.datepicker({
        todayHighlight: true,
        // clearBtn: true,
        startDate: $toStartDate,
        // todayBtn: true,
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

        //Enables button if both dates are selected.
        if($('#toSpan').text() != '') {
            $('#staffSubmit').prop('disabled', false)
        }
    })

    $toDate.on("changeDate", function() {
        $('#toSpan').text(
            $toDate.datepicker('getFormattedDate')
        )
        // $start = $('#fromCal .active.day')
        // $finish = $('#toCal .active.day')
        // rangeHighlight($start, $finish) @toDo Highlight range between selected dates.

        //Enables button if both dates are selected.
        if($('#fromSpan').text() != '') {
            $('#staffSubmit').prop('disabled', false)
        }
    })

    $visitorDate.on("changeDate", function() {
        $('#visitorSpan').text(
            $visitorDate.datepicker('getFormattedDate')
        )
        $('#time-container').animate({
            right: '10%'
        }, 1000)
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

//    ********************************************************************************
//    Animating calendar and time.

    function slideRight($el) {
        $el.animate({
            right: '10%'
        }, 1000)
    }

    function slideLeft($el) {
        $el.animate({
            right: '75%'
        }, 400)
        $('#speechBubbleContent').text('Available spaces: ')
    }

    $('#staffButton').click(function() {
        $(this).prop('disabled', true)
        $('#visitorButton').prop('disabled', false)
        if($('#visitor-container').css('right') != '0') {
            slideLeft($('#visitor-container, #time-container'))
        }
        $('#staff-container').animate({
            right: '10%'
        }, 1000)
    })

    $('#visitorButton').click(function() {
        $(this).prop('disabled', true)
        $('#staffButton').prop('disabled', false)
        if($('#staff-container').css('right') != '0') {
            slideLeft($('#staff-container'))
        }
        $('#visitor-container').animate({
            right: '35%'
        }, 1000)
        $('#time-container').animate({
            right: '40%'
        }, 1000)
    })

//    ********************************************************************************
//    Time Picker

    //declaring variables. These variables are used to record selection which can be used when unchecking full day box.
    var fromHours, toHours, fromMinutes, toMinutes

    //setting jQuery selector variables.
    var $fromHours = $('#fromHours')
    var $toHours = $('#toHours')
    var $fromMinutes = $('#fromMinutes')
    var $toMinutes = $('#toMinutes')

    //When check box for full day is toggled.
    $('#fullDay').change(function () {

        //Enables all options from dropdowns and selects first drop down option which is HH or mm.
        //If statement checks if stored previous selection had a value and if so sets value to stored selection.
        $fromHours.prop("disabled", false).find('option').first().prop('selected', true)
        if(typeof(fromHours) != 'undefined' && fromHours != null) {
            $fromHours.val(fromHours)
        }
        $toHours.prop("disabled", false).find('option').first().prop('selected', true)
        if(typeof(toHours) != 'undefined' && toHours != null) {
            $toHours.val(toHours)
        }
        $fromMinutes.prop("disabled", true).find('option').first().prop('selected', true)
        if(typeof(fromMinutes) != 'undefined' && fromMinutes != null) {
            console.log('lemon')
            $fromMinutes.val(fromMinutes).prop("disabled", false)
        }
        $toMinutes.prop("disabled", true).find('option').first().prop('selected', true)
        if(typeof(toMinutes) != 'undefined' && toMinutes != null) {
            $toMinutes.val(toMinutes).prop("disabled", false)
        }

        //When full day checkbox is toggled, sets selection to full day defaults and disables selection boxes.
        if (this.checked) {
            $fromHours.val('08').prop("disabled", true)
            $toHours.val('18').prop("disabled", true)
            $fromMinutes.val('00').prop("disabled", true)
            $toMinutes.val('00').prop("disabled", true)
        }

        $('#visitorSubmit').prop('disabled', true)
        if(typeof($fromHours.val()) == 'string' && typeof($toHours.val()) == 'string' && typeof($fromMinutes.val()) == 'string' && typeof($toMinutes.val()) == 'string') {
            console.log(typeof($('#fromHours').val()))
            console.log(typeof($('#toHours').val()))
            $('#visitorSubmit').prop('disabled', false)
        }
    })

    //When all selection boxes are changed.
    $('.timeInput').change(function() {
        //Sets new value of selections to variables.
        fromHours = $fromHours.val()
        toHours = $toHours.val()
        fromMinutes = $fromMinutes.val()
        toMinutes = $toMinutes.val()

        //When the 'to' hour is only 1 more than the 'from' hour.
        if(parseInt(toHours) == (parseInt(fromHours) + 1)) {
            //Enables all selections except MM default value.
            //Disables all options that will allow time less than an hour.
            $('#toMinutes option:not(.defaultOption)').prop("disabled", false)
            $('#toMinutes option[value="' + fromMinutes + '"]').prevAll().prop("disabled", true)
            $('#fromMinutes option:not(.defaultOption)').prop("disabled", false)
            $('#fromMinutes option[value="' + toMinutes + '"]').nextAll().prop("disabled", true)
        } else {
            //Enables all selections except MM default value.
            $('.timeInput.minutes option:not(.defaultOption)').prop("disabled", false)
        }

        if(typeof($fromHours.val()) == 'string' && typeof($toHours.val()) == 'string' && typeof($fromMinutes.val()) == 'string' && typeof($toMinutes.val()) == 'string') {
            console.log(typeof($('#fromHours').val()))
            console.log(typeof($('#toHours').val()))
            $('#visitorSubmit').prop('disabled', false)
        }
    })

    //When the from hours selection is changed.
    $fromHours.change(function() {
        //Disables options that will result in negative time and enables minute field.
        $('#toHours option[value="' + fromHours + '"]').prop("disabled", true).prevAll().prop("disabled", true)
        $fromMinutes.prop('disabled', false)
    })

    $toHours.change(function() {
        //Disables options that will result in negative time and enables minute field.
        $('#fromHours option[value="' + toHours + '"]').prop("disabled", true).nextAll().prop("disabled", true)
        $toMinutes.prop('disabled', false)
    })

//    ********************************************************************************
//    Ajax


    $('#visitorSubmit').on('click', function() {

        var data = {
            carPark: 'visitor',
            date: $('#visitorCal').datepicker('getFormattedDate'),
            fromTime: $('#fromHours').val() + ':' + $('#fromMinutes').val(),
            toTime: $('#toHours').val() + ':' + $('#toMinutes').val()
        }

        $.ajax(({
            method: "post",
            url: "ajax/availability.php",
            data: data,
            success: function($return) {
                $('#speechBubbleContent').text('Available spaces: ' + $return)
            }
        }))
    })

    $('#staffSubmit').on('click', function() {

        var data = {
            carPark: 'staff',
            fromDate: $fromDate.datepicker('getFormattedDate'),
            toDate: $toDate.datepicker('getFormattedDate'),
        }

        $.ajax(({
            method: "post",
            url: "ajax/availability.php",
            data: data,
            success: function($return) {
                $('#speechBubbleContent').text('Available spaces: ' + $return)
            }
        }))
    })
})




