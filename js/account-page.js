$(function () {

    $('.toggle-user-form').click(function () {
        $('#email').val('')
        $('#passowrd').val('')
        $('.user-account-content').slideToggle()
        $('#errors').html('')
    })

    $('#update-form').submit(function (e) {
        e.preventDefault()

        $('#save-confirm').off('click')
        $('#save-confirm').on('click', function () {
            //put user data into an object
            var userData = {}

            //put in switch for each loop for all form input?
            if ($('#email').val() != '') {
                userData['newEmail'] = $('#email').val()
            }
            if ($('#password').val() != '') {
                userData['newPassword'] = $('#password').val()
            }

            $.ajax(({
                    method: "post",
                    url: "handle.php",
                    data: userData,
                    success: function (data) {
                        console.log(data);
                        if (!data.result) {
                            $('#errors').append(data.email)
                            console.log(data.email)
                        } else {
                            $(".user-account-content").slideToggle()
                            if ($('#email').val() != '') {
                                $("#email-field span").text($('#email').val())
                            }
                        }
                    }
            }))
        })
    })
})