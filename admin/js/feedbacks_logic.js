$(document).ready(function () {
    $('#feedbacks_section_form').on('submit', function(event) {
        event.preventDefault();
        var formData = new FormData($('#feedbacks_section_form')[0]);
        $.ajax({
            url: 'handlers/edit_feedback_section.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.indexOf('error') != -1) {
                    $('.popup-error').remove();
                    $('.popup-success').remove();
                    $(response).appendTo($('body'));

                    $('.popup-error').css('top', $(window).scrollTop() + 80);
                    $('.cross-popup').on('click', function(){
                        $('.popup-error').remove();
                    });
                }
                if(response.indexOf('success') != -1) {
                    $('.popup-error').remove();
                    $('.popup-success').remove();
                    $(response).appendTo($('body'));

                    $('.popup-success').css('top', $(window).scrollTop() + 80);
                    $('.cross-popup').on('click', function(){
                        $('.popup-success').remove();
                    });
                }
            }
        });
    });
});