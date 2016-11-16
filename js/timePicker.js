$(function() {

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



})