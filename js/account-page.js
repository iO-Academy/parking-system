$(function(){

    $('#edit').click(function (){
        $('.user-account-content').slideToggle()
    })

    $('form').submit(function(e) {
        e.preventDefault();
        // do ajax
        // in ajax calllback
        $(".user-account-content").slideToggle()
        $("#email-field span").text($('#email').val())
    })
})
