$(function(){

    $('.toggle-user-form').click(function (){
        $('#email').val('')
        $('#passowrd').val('')
        $('.user-account-content').slideToggle()
    })

    $('#update-form').submit(function(e) {
        e.preventDefault()

        //if user confirms alert?

        //put user data into an object
        var userData = {}

        //put in switch for each loop for all form input?
        if($('#email').val() != ''){
            userData['newEmail'] = $('#email').val()
        }
        if($('#password').val() != ''){
            userData['newPassword'] = $('#password').val()
        }


        $.ajax(({
            method: "post",
            url: "account.php",
            data: userData,
            success: function() {
                $(".user-account-content").slideToggle()
                if($('#email').val() != ""){
                    $("#email-field span").text($('#email').val())
                }
                if($('#password').val() != ""){
                    $("#password-field span").text($('#password').val())
                }
            }
        }))

    })
})