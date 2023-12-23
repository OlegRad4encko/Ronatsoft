$(document).ready(function () {
    console.log($('#client-application'));
    $('#client-application').on('submit', function (event){
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'client_application_handler.php',
            data: $(this).serialize(),
            success: function(data) {
                if(data.indexOf('error') != undefined) {
                    $(data).prependTo($('#client-application'));
                    $('.cross-popup').on('click', function(){
                        $('.form-error').remove();
                        $('.form-success').remove();
                    });
                }

                
                console.log(data);
            }
            
        });
    });
});