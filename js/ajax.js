$(function() {
    $('#visitorSubmit').on('click', function() {

        var data = {
            date: $('#visitorCal').datepicker('getFormattedDate'),
            fromTime: $('#fromHours').val() + ':' + $('#fromMinutes').val(),
            toTime: $('#toHours').val() + ':' + $('#toMinutes').val()
        }

        $.ajax(({
            method: "post",
            url: "ajax/availability.php",
            data: data,
            success: function($return) {
                $('#speechBubbleContent').append($return)
            }
        }))
    })
})