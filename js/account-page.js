$(function(){

    $('#edit').click(function (){
        $('.user-account-content').slideToggle()
    })

    $('form').submit(function(e) {
        e.preventDefault();
        $('.user-account-content').slideToggle()
    })
})
