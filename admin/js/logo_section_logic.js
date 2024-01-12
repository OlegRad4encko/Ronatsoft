function init_logo_section_logic() {
    let background_type = $('[name=logo_section_background]:checked').val();
    switch (background_type) {
        case '1':
            $('.logo-background-image').css('display', 'flex');
            $('.logo-background-color').css('display', 'none');
            break;
        case '2':
            $('.logo-background-image').css('display', 'none');
            $('.logo-background-color').css('display', 'flex');
            break;
    
        default:
            console.log('none');
            break;
    }
}

function change_background_type() {
    let background_type = $(this).val();
    switch (background_type) {
        case '1':
            $('.logo-background-image').css('display', 'flex');
            $('.logo-background-color').css('display', 'none');
            break;
        case '2':
            $('.logo-background-image').css('display', 'none');
            $('.logo-background-color').css('display', 'flex');
            break;
    
        default:
            console.log('none');
            break;
    }
}

$(document).ready(function () {
    init_logo_section_logic();

    $('[name=logo_section_background]').on('change', change_background_type);

    $('#logo_section_form').on('submit', function(event) {
        event.preventDefault();
        var formData = new FormData($('#logo_section_form')[0]);
        $.ajax({
            url: 'handlers/edit_logo_section.php',
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

    $(window).scroll(function() {
        $('.popup-success').css('top', $(window).scrollTop() + 80);
        $('.popup-error').css('top', $(window).scrollTop() + 80);
    });
});