$(function() {

    /**
     * DOCBLOCK ME!
     */
    $("#visitorSubmit").click(function() {

        var data = {
            'from': $('#fromSpan').text(),
            'to': $('#fromSpan').text(),
        }

        $.ajax({
            method: "POST",
            url: "../ajax/createBooking.php",
            data: data,

        })
    })
})
