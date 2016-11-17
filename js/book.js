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


    // DOCBLOCK ME
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

            vd = $('#visitorCal').datepicker('getFormattedDate')
            vft = $('#fromHours').val() + ':' + $('#fromMinutes').val()
            vtt = $('#toHours').val() + ':' + $('#toMinutes').val()

            fdt = changeToDateTime(vd, vft)
            tdt = changeToDateTime(vd, vtt)

        } else { // getting staff selected date and times into a 'to' and 'from' datetime variable

            sfd = $('#fromCal').datepicker('getFormattedDate')
            std = $('#toCal').datepicker('getFormattedDate')

            fdt = changeToDateTime(sfd, "00:00")
            tdt = changeToDateTime(std, "23:59")

        }

        data = {
            carPark: carParkId,
            fromDateTime: fdt,
            toDateTime: tdt
        }

        return data


    }


    // sends ajax request when carpark4 (visitor:rich tea) book button is clicked
    $('#carpark4').click(function () {

       createAjaxData(4)
        makeBooking(data)
    })


    // sends ajax request when staff carpark1 (staff:hobnob) book button is clicked
    $('#carpark1').click(function () {

        createAjaxData(1)
        makeBooking(data)
    })


    // sends ajax request when staff carpark3 (staff:digestive) book button is clicked
    $('#carpark3').click(function () {

        createAjaxData(3)
        makeBooking(data)
    })

})

