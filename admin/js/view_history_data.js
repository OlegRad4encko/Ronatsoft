$(document).ready(function () {
    $('[name=history_additional_info]').on('click', function(){
        $.ajax({
            type: 'POST',
            url: 'templates/history_additional.php',
            data: $(this),
            success: function(response) {
                if(response.indexOf('error') != -1) {
                    $('.popup-error').remove();
                    $('.popup-success').remove();
                    $(response).appendTo($('body'));

                    $('.popup-error').css('top', $(window).scrollTop() + 80);
                    $('.cross-popup').on('click', function(){
                        $('.popup-error').remove();
                    });
                } else {
                    $(response).appendTo($('body'));
                    $('.cross-form').on('click', function(){
                        $('.add-edit-form').remove();
                    });
                    $('.add-edit-form').css('top', $(window).scrollTop()+($(window).height() / 2)-1);
                    
                    $(window).scroll(function() {
                        $('.add-edit-form').css('top', $(window).scrollTop()+($(window).height() / 2)-1);
                    })
                }
            }
        });
    });
});