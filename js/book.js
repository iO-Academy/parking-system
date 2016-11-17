$(function() {

    // getting visitor selected date and times into a 'to' and 'from' datetime variable
    var vd = 'DD/MM/YYYY',//$('#visitorCal').datepicker('getFormattedDate'), // visitor date
        vft = '11:11',//$('#fromHours').val() + ':' + $('#fromMinutes').val(), // visitor from time
        vtt = '22:22',//$('#toHours').val() + ':' + $('#toMinutes').val(), // visitor to time
        fdt, // from date time
        tdt, // to date time
        data

    function dateConvert(date) {
        return date.split('/').reverse().join('-')
    }

    function toDateTime(date, time) {
        return dateConvert(date) + ' ' + time + ':00'
    }

    fdt = toDateTime(vd, vft)
    tdt = toDateTime(vd, vtt)

    data = {
        carPark: 'visitor', //needs to be a variable (or a different literal for staff)
        fromDateTime: fdt,
        toDateTime: tdt
    }

    console.log(data)

    function makeBooking(data) {

        $.ajax({
            method: "POST",
            url: "../ajax/createBooking.php",
            data: data,
            success: function() {} // need to talk with Ali about making his modal indicate success
        })
    }

})
