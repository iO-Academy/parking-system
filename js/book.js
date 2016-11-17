$(function() {

    /**
     * DOCBLOCK ME!
     */
    $("#visitorSubmit").click(function() {

        var data = {
            'from': $('#fromSpan').text(),
            'to': $('#toSpan').text(),
        }

        $.ajax({
            method: "POST",
            url: "../ajax/createBooking.php",
            data: data,

        })
    })
})
