function add_new_block(link_id, icon, label, link, token) {
    var block_string = '<div class="social-block" id="soc_'+ link_id +'"><div>';
    block_string += '<input class="social_link" type="text" name="label" placeholder="Social name (alias)" value="'+ label +'" disabled required>';
    block_string += '<input class="social_link" type="text" name="icon" placeholder="icon class" value="'+ icon +'" disabled required>';
    block_string += '<input class="social_link" type="text" name="link" placeholder="social link" value="'+ link +'" disabled required>';
    block_string += '<input name="csrf_token" type="hidden" value="'+ token +'" />';
    block_string += '</div><div><div class="icon-preview">';
    block_string += 'Preview: <i class="'+ icon +'"></i>';
    block_string += '</div>';
    block_string += '<button name="delete_social" value="'+ link_id +'"><i class="fa-solid fa-trash"></i></button>';
    block_string += '</div></div>';
    
    var newBlock = $(block_string);
    $('.add-social').before(newBlock);
}

function delete_social() {
    if(confirm('Are you sure?')) {
        let delete_data = {
            "id_link": $(this).val(),
            "csrf_token": $(this).parent().parent().find('input[name=csrf_token]').val()
        }
        let request_data = $.param(delete_data);
        $.ajax({
            type: 'POST',
            url: 'handlers/delete_social.php',
            data: request_data,
            success: function(data) {
                if(data.indexOf('error') != -1) {
                    $('.popup-error').remove();
                    $(data).appendTo($('body'));

                    $('.cross-popup').on('click', function(){
                        $('.popup-error').remove();
                    });
                }
                if(data.indexOf('success') != -1) {
                    $('#soc_' + delete_data['id_link']).remove();
                }
            }
        });
    }
}

function make_preview() {
    $(this).parent().parent().find('[name=preview]').attr('class', $(this).val());
}

function save_changes() {
    let update_data = {
        "id_link": $(this).val(),
        "csrf_token": $(this).parent().parent().find('input[name=csrf_token]').val(),
        "label": $(this).parent().parent().find('input[name=label]').val(),
        "icon": $(this).parent().parent().find('input[name=icon]').val(),
        "link": $(this).parent().parent().find('input[name=link]').val()
    };
    let request_data = $.param(update_data);
    $.ajax({
        type: 'POST',
        url: 'handlers/update_social.php',
        data: request_data,
        success: function(data) {
            if(data.indexOf('error') != -1) {
                $('.popup-error').remove();
                $(data).appendTo($('body'));

                $('.cross-popup').on('click', function(){
                    $('.popup-error').remove();
                });
            }

            if(data.indexOf('success') != -1) {
                $('#soc_'+update_data['id_link']).find('.social_link').prop('disabled', true);
                $('#soc_'+update_data['id_link']).find('[name=save_social]').off('click', save_changes);
                $('#soc_'+update_data['id_link']).find('[name=save_social]').prop('name', 'delete_social');
                $('#soc_'+update_data['id_link']).find('[name=delete_social]').html('<i class="fa-solid fa-trash"></i>');
                $('#soc_'+update_data['id_link']).find('[name=delete_social]').on('click', delete_social);
            }
        }
    });
}

function edit_social() {
    $(this).prop('disabled', false);
    $(this).siblings('input.social_link').prop('disabled', false);
    $(this).parent().parent().find('button').prop('name', 'save_social');
    $(this).parent().parent().find('button').html('<i class="fa-regular fa-floppy-disk"></i>');
    $(this).parent().parent().find('button').off('click', delete_social);
    $(this).parent().parent().find('[name=save_social]').on('click', save_changes);
}

$(document).ready(function () {

    // add social
    $('.add-social').on('submit', function (event){
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'handlers/add_social.php',
            data: $(this).serialize(),
            success: function(data) {
                if(data.indexOf('error') != -1) {
                    $('.popup-error').remove();
                    $(data).appendTo($('body'));

                    $('.cross-popup').on('click', function(){
                        $('.popup-error').remove();
                    });
                } else {
                    var link_data = $.parseJSON(data);
                    add_new_block(link_data['hached_id'], link_data['icon'], link_data['label'], link_data['link'], link_data['csrf_token']);
                    $('#soc_'+link_data['hached_id']).find('[name=delete_social]').on('click', delete_social);
                    $('#soc_'+link_data['hached_id']).find('.social_link').dblclick(edit_social);
                    $('form.add-social').find('input[type=text]').val('');
                }           
            }
        });
    });

    // set preview icon on the add social link form
    $('.social-block').on('input', 'input[name="icon"]', make_preview);

    // delete social link
    $('[name=delete_social]').on('click', delete_social);

    // edit social link
    $('.social_link').dblclick(edit_social);
});