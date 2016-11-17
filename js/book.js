$(function() {

    // getting visitor selected date and times into a 'to' and 'from' datetime variable
    var vd = $('#visitorCal').datepicker('getFormattedDate'), // visitor date
        vft = $('#fromHours').val() + ':' + $('#fromMinutes').val(), // visitor from time
        vtt = $('#toHours').val() + ':' + $('#toMinutes').val(), // visitor to time
        fdt, // from date time
        tdt // to date time

    function dateConvert(date) {
        return date.split('/').reverse().join('-')
    }




    /**
     * DOCBLOCK ME!
     */
    $("#visitorSubmit").click(function() {

        var x //change var name
        x = $('#visitorCal').datepicker('getFormattedDate')

        var data = {
            from:

        }

        $.ajax({
            method: "POST",
            url: "../ajax/createBooking.php",
            data: data,

        })
    })
})
