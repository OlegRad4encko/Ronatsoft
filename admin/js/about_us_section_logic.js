
function about_us_section_logic() {
    if ($('[name=image_set]').prop('checked')) {
        $('.about-us-image').css('display','flex');
    } else {
        $('.about-us-image').css('display','none');
    }

    switch ($('[name=about_us_image_type]').val()){
        case '1':
            $('.about-us-image-file').css('display','flex');
            $('.about-us-image-link').css('display','none');
            break;
        case '2':
            $('.about-us-image-file').css('display','none');
            $('.about-us-image-link').css('display','flex');
            break;
    
        default:
            console.log('Error');
            break;
    }
}

function image_set() {
    if ($(this).prop('checked')) {
        $('.about-us-image').css('display','flex');
    } else {
        $('.about-us-image').css('display','none');
    }
}

function change_image_type() {
    switch ($(this).val()) {
        case '1':
            $('.about-us-image-file').css('display','flex');
            $('.about-us-image-link').css('display','none');
            break;
        case '2':
            $('.about-us-image-file').css('display','none');
            $('.about-us-image-link').css('display','flex');
            break;
    
        default:
            console.log('Error');
            break;
    }
}


$(document).ready(function () {
    about_us_section_logic();

    $('[name=image_set]').on('change', image_set);
    $('[name=about_us_image_type]').on('change', change_image_type);

    $('#about_us_section_form').on('submit', function(event) {
        event.preventDefault();
        var formData = new FormData($('#about_us_section_form')[0]);
        $.ajax({
            url: 'handlers/edit_about_us_section.php',
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