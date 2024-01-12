function init_header_section_logic() {
    let logo_type = $('[name=logo_type]:checked').val();
    let logo_image = $('[name=logo_image]:checked').val();
    let count_links = $('[name=count_soc_links]').val();


    switch (logo_type) {
        // 1 part logo
        case '1':
            $('.solid-logo').css('display', 'flex');
            $('.parts-logo').css('display', 'none');
            $('.image-logo').css('display', 'none');

            break;


        // 2 parts logo
        case '2':
            $('.solid-logo').css('display', 'none');
            $('.parts-logo').css('display', 'flex');
            $('.image-logo').css('display', 'none');    

            break;


        // image logo
        case '3':
            $('.solid-logo').css('display', 'none');
            $('.parts-logo').css('display', 'none');
            $('.image-logo').css('display', 'flex');    
        
            break;
    }

    switch (logo_image) {

        // logo image file
        case '1':
            $('.logo-image-file').css('display', 'block');
            $('.logo-image-link').css('display', 'none');
            break;


        // logo image link
        case '2':
            $('.logo-image-file').css('display', 'none');
            $('.logo-image-link').css('display', 'block');
            break;
    }

    switch (count_links) {
        case '1':
            $('.first-link').css('display', 'block');
            $('.second-link').css('display', 'none');
            $('.third-link').css('display', 'none');
            break;
        case '2':
            $('.first-link').css('display', 'block');
            $('.second-link').css('display', 'block');
            $('.third-link').css('display', 'none');
            break;
        case '3':
            $('.first-link').css('display', 'block');
            $('.second-link').css('display', 'block');
            $('.third-link').css('display', 'block');
            break;
    
        default:
            break;
    }


}

function radio_logo_type() {
    let logo_type = $(this).val();
        switch (logo_type) {
            // 1 part logo
            case '1':
                $('.solid-logo').css('display', 'flex');
                $('.parts-logo').css('display', 'none');
                $('.image-logo').css('display', 'none');

                break;


            // 2 parts logo
            case '2':
                $('.solid-logo').css('display', 'none');
                $('.parts-logo').css('display', 'flex');
                $('.image-logo').css('display', 'none');    

                break;


            // image logo
            case '3':
                $('.solid-logo').css('display', 'none');
                $('.parts-logo').css('display', 'none');
                $('.image-logo').css('display', 'flex');    
            
                break;


            default:
                console.log('none');
                break;
        }
}

function radio_logo_image() {
    let logo_image = $(this).val();
    switch (logo_image) {

        // logo image file
        case '1':
            $('.logo-image-file').css('display', 'block');
            $('.logo-image-link').css('display', 'none');
            break;


        // logo image link
        case '2':
            $('.logo-image-file').css('display', 'none');
            $('.logo-image-link').css('display', 'block');
            break;
    
        default:
            console.log('none');
            break;
    }
}

function header_links() {
    let count_links = $('[name=count_soc_links]').val();
    switch (count_links) {
        case '1':
            $('.first-link').css('display', 'block');
            $('.second-link').css('display', 'none');
            $('.third-link').css('display', 'none');
            break;
        case '2':
            $('.first-link').css('display', 'block');
            $('.second-link').css('display', 'block');
            $('.third-link').css('display', 'none');
            break;
        case '3':
            $('.first-link').css('display', 'block');
            $('.second-link').css('display', 'block');
            $('.third-link').css('display', 'block');
            break;
    
        default:
            break;
    }
}

$(document).ready(function () {
    init_header_section_logic();

    $('[name=logo_type]').on('change', radio_logo_type);
    $('[name=logo_image]').on('change', radio_logo_image);
    $('[name=count_soc_links]').on('change', header_links);

    $('#header_section_form').on('submit', function(event){
        event.preventDefault();
        var formData = new FormData($('#header_section_form')[0]);
        $.ajax({
            url: 'handlers/edit_header_section.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.indexOf('error') != -1) {
                    $('.popup-error').remove();
                    $(response).appendTo($('body'));

                    $('.popup-error').css('top', $(window).scrollTop() + 80);
                    $('.cross-popup').on('click', function(){
                        $('.popup-error').remove();
                    });
                }
                if(response.indexOf('success') != -1) {
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