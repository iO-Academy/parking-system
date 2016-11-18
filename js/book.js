$(function() {


    /**
     * Takes a string in the format DD/MM/YYYY and returns it in the format YYYY-MM-DD
     *
     * @param date STRING DD/MM/YYYY
     * @returns STRING YYYY-MM-DD
     */
    function dateConvert(date) {
        return date.split('/').reverse().join('-')
    }


    /**
     * Takes a date and time, passes the date to dateConvert and returns a formatted datetime string
     *
     * @param date STRING DD/MM/YYYY
     * @param time STRING HH:MM
     * @param seconds STRING SS
     * @returns STRING YYYY-MM-DD HH:MM:SS
     */
    function changeToDateTime(date, time, seconds) {
        return dateConvert(date) + ' ' + time + ':' + seconds
    }


    /**
     * Sends a POST ajax request to createBooking.php with passed in details of a booking
     *
     * @param data OBJECT contains the carpark id and datetime boundaries for a booking
     */
    function makeBooking(data) {
        $.ajax({
            method: "POST",
            url: "../ajax/createBooking.php",
            data: data,
            success: function() {} // need to talk with Ali about making his modal indicate success.
            //remember to update docblock after writing success function
        })
    }


    /**
     * Puts selected date(s) (and times) into datetime format and puts into ajax data object, along with carParkId
     *
     * @param carParkId NUMBER
     * @param carParkType STRING 'visitor' or 'staff'
     * @returns OBJECT {carPark: STRING carParkId, fromDateTime: STRING, toDateTime: STRING}
     */
    //
    function createAjaxData(carParkId, carParkType) {

        var visitorDate,
            visitorFromTime,
            visitorToTime,

            staffFromDate,
            staffToDate,

            fromDateTime,
            toDateTime,

            data

        if (carParkType == 'visitor') { // getting visitor selected date and times into a 'to' and 'from' datetime variable

            visitorDate = $('#visitorCal').datepicker('getFormattedDate')
            visitorFromTime = $('#fromHours').val() + ':' + $('#fromMinutes').val()
            visitorToTime = $('#toHours').val() + ':' + $('#toMinutes').val()

            fromDateTime = changeToDateTime(visitorDate, visitorFromTime, '00')
            toDateTime = changeToDateTime(visitorDate, visitorToTime, '00')

        } else { // getting staff selected date and times into a 'to' and 'from' datetime variable

            staffFromDate = $('#fromCal').datepicker('getFormattedDate')
            staffToDate = $('#toCal').datepicker('getFormattedDate')

            fromDateTime = changeToDateTime(staffFromDate, '00:00', '00')
            toDateTime = changeToDateTime(staffToDate, '23:59', '59')

        }

        data = {
            carParkId: carParkId,
            fromDateTime: fromDateTime,
            toDateTime: toDateTime
        }

        return data

    }


    // sends ajax request when carpark4 (visitor:rich tea) book button is clicked
    $('.book-button').click(function() {
        makeBooking(
            createAjaxData(
                $(this).data('carparkId'),
                $(this).data('isVisitor')
            )
        )
    })

})

