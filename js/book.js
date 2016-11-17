$(function() {

    // DOBCLOCK ME
    function dateConvert(date) {
        return date.split('/').reverse().join('-')
    }
    // DOBCLOCK ME
    function changeToDateTime(date, time) {
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

    // getting selected date(s) (and times) into datetime format and putting into ajax data object, along with carParkId
    function createAjaxData(carParkId) {

        var vd, // visitor date
            vft, // visitor from-time
            vtt, // visitor to-time
            sfd, // staff from-date
            std, // staff to-date
            fdt, // from-datetime
            tdt, // to-datetime
            data

        if (carParkId == 4) { // getting visitor selected date and times into a 'to' and 'from' datetime variable

            var vd = $('#visitorCal').datepicker('getFormattedDate'),
                vft = $('#fromHours').val() + ':' + $('#fromMinutes').val(),
                vtt = $('#toHours').val() + ':' + $('#toMinutes').val(),

            fdt = changeToDateTime(vd, vft)
            tdt = changeToDateTime(vd, vtt)

        } else { // getting staff selected date and times into a 'to' and 'from' datetime variable

            var sfd = $('#fromCal').datepicker('getFormattedDate'),
                std = $('#toCal').datepicker('getFormattedDate'),

            fdt = changeToDateTime(sfd, "00:00")
            tdt = changeToDateTime(std, "23:59")

        }

        data = {
            carPark: carParkId,
            fromDateTime: fdt,
            toDateTime: tdt
        }


    }

    // sends ajax request when carpark4 (visitor/rich tea) book button is clicked
    $('#carpark4').click(function () {

        // getting visitor selected date and times into a 'to' and 'from' datetime variable
        var vd = $('#visitorCal').datepicker('getFormattedDate'), // visitor date
            vft = $('#fromHours').val() + ':' + $('#fromMinutes').val(), // visitor from-time
            vtt = $('#toHours').val() + ':' + $('#toMinutes').val(), // visitor to-time
            fdt, // from-datetime
            tdt, // to-datetime
            data

        fdt = changeToDateTime(vd, vft)
        tdt = changeToDateTime(vd, vtt)

        data = {
            carPark: 4,
            fromDateTime: fdt,
            toDateTime: tdt
        }

        makeBooking(data)
    })

    // sends ajax request when staff carpark1 (hobnob) book button is clicked
    $('#carpark1').click(function () {

        // getting staff selected date and times into a 'to' and 'from' datetime variable
        var sfd = $('#fromCal').datepicker('getFormattedDate'), // staff from-date
            std = $('#toCal').datepicker('getFormattedDate'), // staff to-date
            fdt, // from-datetime
            tdt, // to-datetime
            data

        fdt = changeToDateTime(sfd, "00:00")
        tdt = changeToDateTime(std, "23:59")

        data = {
            carPark: 1,
            fromDateTime: fdt,
            toDateTime: tdt
        }

        makeBooking(data)
    })

    // sends ajax request when staff carpark3 (digestive) book button is clicked
    $('#carpark3').click(function () {

        // getting staff selected date and times into a 'to' and 'from' datetime variable
        var sfd = $('#fromCal').datepicker('getFormattedDate'), // staff from-date
            std = $('#toCal').datepicker('getFormattedDate'), // staff to-date
            fdt, // from-datetime
            tdt, // to-datetime
            data

        fdt = changeToDateTime(sfd, "00:00")
        tdt = changeToDateTime(std, "23:59")

        data = {
            carPark: 3,
            fromDateTime: fdt,
            toDateTime: tdt
        }

        makeBooking(data)
    })

})

