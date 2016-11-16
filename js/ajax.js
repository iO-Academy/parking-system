$(function() {
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