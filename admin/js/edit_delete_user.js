$(document).ready(function(){
    $('[name=edit_user]').on('click', function(){
        $.ajax({
            type: 'POST',
            url: 'templates/edit_user.php',
            data: $(this),
            success: function(data) {

                $(data).appendTo($('body'));
                $('.cross-form').on('click', function(){
                    $('.add-edit-form').remove();
                });

                $('.cross-popup').on('click', function(){
                    $('.popup-error').remove();
                });
                
                $('#edit_user').on('submit', function(event){
                    event.preventDefault();
                    $.ajax({
                        type: 'POST',
                        url: 'handlers/edit_user.php',
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

                $('#delete_user').on('submit', function(event){
                    event.preventDefault();
            
                    if(confirm("Are you sure?")) {
                        $.ajax({
                            type: 'POST',
                            url: 'handlers/delete_user.php',
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
                    } 
                });
            }
        });
    });

    
    
});