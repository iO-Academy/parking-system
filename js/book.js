$(function() {

    // DOBCLOCK ME
    function dateConvert(date) {
        return date.split('/').reverse().join('-')
    }
    // DOBCLOCK ME
    function toDateTime(date, time) {
        return dateConvert(date) + ' ' + time + ':00'
    }
    // DOBCLOCK ME
    function makeBooking(data) {
        $.ajax({
            method: "POST",
            url: "../ajax/createBooking.php",
            data: data,
            success: function() {} // need to talk with Ali about making his modal indicate success
        })
    }

    // sends ajax request when visitor carpark book button is clicked
    $('#carpark4').click(function () {

        // getting visitor selected date and times into a 'to' and 'from' datetime variable
        var vd = $('#visitorCal').datepicker('getFormattedDate'), // visitor date
            vft = $('#fromHours').val() + ':' + $('#fromMinutes').val(), // visitor from-time
            vtt = $('#toHours').val() + ':' + $('#toMinutes').val(), // visitor to-time
            fdt, // from-datetime
            tdt, // to-datetime
            data

        fdt = toDateTime(vd, vft)
        tdt = toDateTime(vd, vtt)

        data = {
            carPark: 'visitor', //needs to be a variable (or a different literal for staff)
            fromDateTime: fdt,
            toDateTime: tdt
        }

        makeBooking(data)
    })

    // sends ajax request when staff carpark hobnob book button is clicked
    $('#carpark1').click(function () {

        // getting staff selected date and times into a 'to' and 'from' datetime variable
        var sfd = $('#fromCal').datepicker('getFormattedDate'), // staff from-date
            std = $('#toCal').datepicker('getFormattedDate'), // staff to-date
            fdt, // from-datetime
            tdt, // to-datetime
            data

        fdt = toDateTime(vd, vft)
        tdt = toDateTime(vd, vtt)

        data = {
            carPark: 'visitor', //needs to be a variable (or a different literal for staff)
            fromDateTime: fdt,
            toDateTime: tdt
        }

        makeBooking(data)
    })

})

