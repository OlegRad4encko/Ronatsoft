$(document).ready(function(){
    $('[name=add_user]').on('click', function(){
        $.ajax({
            type: 'POST',
            url: 'templates/add_user.php',
            data: $(this),
            success: function(data) {
                $(data).appendTo($('body'));
                $('.cross-form').on('click', function(){
                    $('.add-edit-form').remove();
                });

                $('#add_user').on('submit', function(event){
                    event.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: 'handlers/add_user.php',
                        data: $(this).serialize(),
                        success: function(data) {
                            if(data.indexOf('error') != -1) {
                                $('.popup-error').remove();
                                $(data).appendTo($('body'));

                                $('.cross-popup').on('click', function(){
                                    $('.popup-error').remove();
                                });
                            }
                            if(data.indexOf('success') != -1) {
                                location.reload();
                            }
                        }
                    });
                });
            }
        });
    });
});