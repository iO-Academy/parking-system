$(function() {
    var fromHours, toHours, fromMinutes, toMinutes
    var $fromHours = $('#fromHours')
    var $toHours = $('#toHours')
    var $fromMinutes = $('#fromMinutes')
    var $toMinutes = $('#toMinutes')

    $('#fullDay').change(function () {

        $fromHours.prop("disabled", false).find('option').first().prop('selected', true)
        if(typeof(fromHours) != 'undefined') {
            $fromHours.val(fromHours)
        }
        $toHours.prop("disabled", false).find('option').first().prop('selected', true)
        if(typeof(toHours) != 'undefined') {
            $toHours.val(toHours)
        }
        $fromMinutes.prop("disabled", false).find('option').first().prop('selected', true)
        if(typeof(fromMinutes) != 'undefined') {
            $fromMinutes.val(fromMinutes)
        }
        $toMinutes.prop("disabled", false).find('option').first().prop('selected', true)
        if(typeof(toMinutes) != 'undefined') {
            $toMinutes.val(toMinutes)
        }

        if (this.checked) {
            $fromHours.val('08').prop("disabled", true)
            $toHours.val('18').prop("disabled", true)
            $fromMinutes.val('00').prop("disabled", true)
            $toMinutes.val('00').prop("disabled", true)
        }
    })

    $('.timeInput').change(function() {
        fromHours = $fromHours.val()
        toHours = $toHours.val()
        fromMinutes = $fromMinutes.val()
        toMinutes = $toMinutes.val()

        if(parseInt(toHours) == (parseInt(fromHours) + 1)) {
            $('#toMinutes option:not(.defaultOption)').prop("disabled", false)
            $('#toMinutes option[value="' + fromMinutes + '"]').prevAll().prop("disabled", true)

            $('#fromMinutes option:not(.defaultOption)').prop("disabled", false)
            $('#fromMinutes option[value="' + toMinutes + '"]').nextAll().prop("disabled", true)
        } else {
            console.log($('.timeInput.minutes option:not(.defaultOption)'))
            $('.timeInput.minutes option:not(.defaultOption)').prop("disabled", false)
        }
    })

    $fromHours.change(function() {
        $('#toHours option[value="' + fromHours + '"]').prop("disabled", true).prevAll().prop("disabled", true)
        $fromMinutes.prop('disabled', false)
    })

    $toHours.change(function() {
        $('#fromHours option[value="' + toHours + '"]').prop("disabled", true).nextAll().prop("disabled", true)
        $toMinutes.prop('disabled', false)
    })

})