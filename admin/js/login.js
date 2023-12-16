$(document).ready(function () {
    $('#login').on('submit', function (event){
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'handlers/login.php',
            data: $(this).serialize(),
            success: function(data) {
                if(data.indexOf('error') != undefined) {
                    $(data).appendTo($('body'));
                }
                console.log(data);
            }
            
        });
    });
});