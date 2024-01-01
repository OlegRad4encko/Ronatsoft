$(document).ready(function(){
    $('#change_state').on('submit', function(event){
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'handlers/edit_application_state.php',
            data: $(this).serialize() ,
            success: function(data) {
                if(data.indexOf('error') != -1) {
                    $('.popup-error').remove();
                    $(data).appendTo($('body'));

                    $('.cross-popup').on('click', function(){
                        $('.popup-error').remove();
                    });
                }
                if(data.indexOf('success') != -1) {
                    $('#state').html('solved');
                    $('#controll_solved_block').html('');
                }
            }

        });
    });

    $('#delete_application').on('submit', function(event){
        event.preventDefault();
        console.log('delete_application');
        $.ajax({
            type: 'POST',
            url: 'handlers/delete_application.php',
            data: $(this).serialize() ,
            success: function(data) {
                if(data.indexOf('error') != -1) {
                    $('.popup-error').remove();
                    $(data).appendTo($('body'));

                    $('.cross-popup').on('click', function(){
                        $('.popup-error').remove();
                    });
                }
                if(data.indexOf('success') != -1) {
                    $('.controll').children().prop('disabled', true);
                    $('.popup-error').remove();
                    $(data).appendTo($('body'));
                    $('.cross-popup').on('click', function(){
                        $('.popup-success').remove();
                    });
                    setTimeout(function() {
                        $(location).attr('href', 'home.php?page=applications');
                    }, 3000);
                }
            }

        });
    });
});