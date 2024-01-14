$(document).ready(function () {
    $('[name=add_feedback]').on('click', function(){
        $.ajax({
            type: 'POST',
            url: 'templates/add_feedback.php',
            data: $(this),
            success: function(data) {
                
                if(data.indexOf('error') != -1) {
                    $('.popup-error').remove();
                    $('.popup-success').remove();
                    $(data).appendTo($('body'));

                    $('.popup-error').css('top', $(window).scrollTop() + 80);
                    $('.cross-popup').on('click', function(){
                        $('.popup-error').remove();
                    });
                } else {
                    $(data).appendTo($('body'));
                    $('.cross-form').on('click', function(){
                        $('.add-edit-form').remove();
                    });
                }
                
                $('#add_feedback').on('submit', function(event){
                    event.preventDefault();
                    var formData = new FormData($('#add_feedback')[0]);
                    $.ajax({
                        type: 'POST',
                        url: 'handlers/add_feedback.php',
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
                                location.reload();
                            }
                        }
                    });
                });

                $('[name=image_name]').change(function(){
                    var fileInput = this;
                    if (fileInput.files && fileInput.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            var imageUrl = e.target.result;
                            $('.feedback-image').find('img').prop('src', imageUrl);
                            $('.feedback-image').css('display','flex');
                            $('.feedback-default').css('display','none');
                        };
                        reader.readAsDataURL(fileInput.files[0]);
                    }
                    
                    
                });
            }
        });
    });

    $('[name=edit_feedback]').on('click', function(){
        $.ajax({
            type: 'POST',
            url: 'templates/edit_feedback.php',
            data: $(this),
            success: function(data) {
                if(data.indexOf('popup-error') != -1) {
                    $('.popup-error').remove();
                    $('.popup-success').remove();
                    $(data).appendTo($('body'));

                    $('.popup-error').css('top', $(window).scrollTop() + 80);
                    $('.cross-popup').on('click', function(){
                        $('.popup-error').remove();
                    });
                } else {
                    $(data).appendTo($('body'));
                    $('.cross-form').on('click', function(){
                        $('.add-edit-form').remove();
                    });

                    $('#save_feedback').on('submit', function(event){
                        event.preventDefault();
                        var formData = new FormData($('#save_feedback')[0]);
                        $.ajax({
                            type: 'POST',
                            url: 'handlers/edit_feedback.php',
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
                                    location.reload();
                                }
                            }
                        });
                    });

                    $('[name=image_name]').change(function(){
                        var fileInput = this;
                        if (fileInput.files && fileInput.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                var imageUrl = e.target.result;
                                $('.feedback-image').find('img').prop('src', imageUrl);
                                $('.feedback-image').css('display','flex');
                                $('.feedback-default').css('display','none');
                            };
                            reader.readAsDataURL(fileInput.files[0]);
                        }
                    });

                    $('.delete-image').on('click', function(){
                        if(confirm("Are you sure you want to delete the feedback image?")) {
                            var formData = new FormData($('#save_feedback')[0]);
                            $.ajax({
                                type: 'POST',
                                url: 'handlers/delete_feedback_image.php',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    console.log(response);
                                    if(response.indexOf('success') != -1) {
                                        $('.feedback-image').find('img').prop('src', '');
                                        $('.feedback-image').css('display','none');
                                        $('.feedback-image').removeClass('delete-image');
                                        $('.feedback-default').css('display','flex');
                                    }
                                    if(response.indexOf('error') != -1) {
                                        $('.popup-error').remove();
                                        $('.popup-success').remove();
                                        $(response).appendTo($('body'));
                    
                                        $('.popup-error').css('top', $(window).scrollTop() + 80);
                                        $('.cross-popup').on('click', function(){
                                            $('.popup-error').remove();
                                        });
                                    }
                                    
                                }
                            });
                        }
                        
                    });

                    $('#delete_feedback').on('submit', function(event){
                        event.preventDefault();
                        if(confirm("Are you sure you want to delete the feedback?")){
                            $.ajax({
                                type: 'POST',
                                url: 'handlers/delete_feedback.php',
                                data: $(this).serialize(),
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
                                        location.reload();
                                    }
                                }
                            });
                        }
                    })
                }
                


            }
        })
    });


});