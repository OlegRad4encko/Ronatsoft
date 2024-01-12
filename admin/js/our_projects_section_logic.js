function add_new_project_block(project_id, project_link, project_image, project_text, token) {
    var block_string = '<div class="project" id="proj_'+ project_id +'">';
    block_string += '<div class="project-data">';
    block_string += '<input name="csrf_token" type="hidden" value="'+ token +'" />';
    block_string += '<div>';
    block_string += '<label for="pr_'+ project_id +'_link">Project link</label>';
    block_string += '<input type="text" name="project_link" id="pr_'+ project_id +'_link" value="'+ project_link +'" disabled>';
    block_string += '</div>';
    block_string += '<div>';
    block_string += '<label for="pr_'+ project_id +'_image_link">Project image link</label>';
    block_string += '<input type="text" name="project_image_link" id="pr_'+ project_id +'_image_link" value="'+ project_image +'" disabled>';
    block_string += '</div><div>';
    block_string += '<label for="pr_'+ project_id +'_text">Project text</label>';
    block_string += '<input type="text" name="project_text" id="pr_1_text" value="'+ project_text +'" disabled>';
    block_string += '</div></div>';
    block_string += '<button name="delete_project" value="'+ project_id +'"><i class="fa-solid fa-trash" aria-hidden="true"></i></button></div>';

    var newBlock = $(block_string);
    $('.projects').append(newBlock);
}

function delete_project() {
    if(confirm('Are you sure?')) {
        let delete_data = {
            "project_id": $(this).val(),
            "csrf_token": $('#proj_'+$(this).val()).find('input[name=csrf_token]').val()
        }

        console.log(delete_data);

        let request_data = $.param(delete_data);
        $.ajax({
            type: 'POST',
            url: 'handlers/delete_project.php',
            data: request_data,
            success: function(data) {
                console.log(data);


                if(data.indexOf('error') != -1) {
                    $('.popup-error').remove();
                    $('.popup-success').remove();
                    $(data).appendTo($('body'));

                    $('.popup-error').css('top', $(window).scrollTop() + 80);
                    $('.cross-popup').on('click', function(){
                        $('.popup-error').remove();
                    });
                }
                if(data.indexOf('success') != -1) {
                    $('#proj_' + delete_data['id_link']).remove();
                    $('.popup-error').remove();
                    $('.popup-success').remove();
                    $(data).appendTo($('body'));

                    $('.popup-success').css('top', $(window).scrollTop() + 80);
                    $('.cross-popup').on('click', function(){
                        $('.popup-success').remove();
                    });
                    $('#proj_' + delete_data['project_id']).remove();
                }
            }
        });
    }
}

function edit_data() {
    $(this).children('div').children('input').prop('disabled', false);
    $(this).parent('.project').find('button').prop('name', 'save_project');
    $(this).parent('.project').find('button').html('<i class="fa-regular fa-floppy-disk"></i>');
    $(this).parent('.project').find('button').off('click', delete_project);
    $(this).parent('.project').find('button').on('click', save_project);
}

function save_project() {
    

    let update_data = {
        'csrf_token': $(this).parent('.project').find('input[name=csrf_token]').val(),
        'project_id': $(this).val(),
        'project_link':  $(this).parent('.project').find('input[name=project_link]').val(),
        'project_image_link': $(this).parent('.project').find('input[name=project_image_link]').val(),
        'project_text': $(this).parent('.project').find('input[name=project_text]').val()
    };

    let request_data = $.param(update_data);

    $.ajax({
        type: 'POST',
        url: 'handlers/update_project.php',
        data: request_data,
        success: function(data) {
            if(data.indexOf('error') != -1) {
                $('.popup-error').remove();
                $('.popup-success').remove();
                $(data).appendTo($('body'));

                $('.popup-error').css('top', $(window).scrollTop() + 80);
                $('.cross-popup').on('click', function(){
                    $('.popup-error').remove();
                });
            }

            if(data.indexOf('success') != -1) {
                $('#proj_'+update_data['project_id']).find('input').prop('disabled', true);
                $('#proj_'+update_data['project_id']).find('button[name=save_project]').html('<i class="fa-solid fa-trash"></i>');
                $('#proj_'+update_data['project_id']).find('button[name=save_project]').prop('name', 'delete_project');
                $('#proj_'+update_data['project_id']).find('button[name=delete_project]').off('click', save_project);
                $('#proj_'+update_data['project_id']).find('button[name=delete_project]').on('click', delete_project);


                $('.popup-error').remove();
                $('.popup-success').remove();
                $(data).appendTo($('body'));

                $('.popup-success').css('top', $(window).scrollTop() + 80);
                $('.cross-popup').on('click', function(){
                    $('.popup-success').remove();
                });
            }
        }
    })

}

$(document).ready(function () {
    $('#add_project').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: 'handlers/add_our_project.php',
            type: 'POST',
            data: $(this).serialize() ,
            success: function(response) {
                console.log(response);
                
                if(response.indexOf('error') != -1) {
                    $('.popup-error').remove();
                    $('.popup-success').remove();
                    $(response).appendTo($('body'));

                    $('.popup-error').css('top', $(window).scrollTop() + 80);
                    $('.cross-popup').on('click', function(){
                        $('.popup-error').remove();
                    });
                }
                if(response.indexOf('csrf_token') != -1) {
                    var project_data = $.parseJSON(response);
                    add_new_project_block(project_data['project_id'], project_data['project_link'], project_data['project_image'], project_data['project_text'], project_data['csrf_token']);
                    
                    $('#proj_'+project_data['project_id']).find('[name=delete_project]').on('click', delete_project);
                    $('#proj_'+project_data['project_id']).find('.project-data').dblclick(edit_data);
                    
                    $('form.add-project').find('input[type=text]').val('');
                }
            }      
        });
    });

    $('#our_projects_section_form').on('submit', function(event) {
        event.preventDefault();
        var formData = new FormData($('#our_projects_section_form')[0]);
        $.ajax({
            url: 'handlers/edit_our_projects.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                
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



    $('[name=delete_project]').on('click', delete_project);
    
    $('.project-data').dblclick(edit_data);



    // "to_color_gradient": "#6b57ff",
    // "from_color_gradient": "#c241ff",

});