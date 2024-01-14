<?php 

    require_once('../handlers/check_session_part.php');
    require_once('../handlers/findXSS.php');

    
    $token = generate_form_token();

    if(!isset($_POST['edit_feedback'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    $feedback_data = $db->query("SELECT SHA2(`feedback_id`, 256) as 'feedback_id', 
    `user_first_name`, `user_second_name`, 
    `image_name`, `user_type`, `publish_date`, 
    `users_text` 
    FROM `feedbacks` WHERE 
    SHA2(`feedback_id`, 256) = :feedback_id", [
        'feedback_id' => findXSS($_POST['edit_feedback'])
    ]);

    if(count($feedback_data) == 0) {
        echo build_error_block('Unknown error. Update the page');
        exit;
    }
?> 

    <div class="add-edit-form">
        <form class="modal-content" id="save_feedback" enctype="multipart/form-data">
            <div class="modal-header">
                <h1>Add Feedback</h1>
                <i class="cross-form fa-regular fa-circle-xmark"></i>
            </div>
            
            <input name="csrf_token" type="hidden" value="<?php echo $token; ?>" />
            <input name="feedback_id" type="hidden" value="<?php echo $feedback_data[0]['feedback_id'] ?>" />
            <table>
                <tr>
                    <td colspan="2" class="center-feedback-image">
                        <div>
                            <?php  
                            
                            if($feedback_data[0]['image_name'] != '') {
                                ?>
                                <div class="feedback-image delete-image" style="display: flex">
                                    <img src="../site-images/feedback_users_images/<?php echo $feedback_data[0]['image_name'] ?>" alt="">
                                </div>
                                <div class="feedback-default" style="display: none">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="feedback-image" style="display: none">
                                    <img src="" alt="">
                                </div>
                                <div class="feedback-default" style="display: flex">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <?php
                            }
                            ?>
                        </div> 
                    </td>
                </tr>
                <tr>
                    <td>First Name *</td>
                    <td><input type="text" name="first_name" value="<?php echo $feedback_data[0]['user_first_name'] ?>" placeholder="First Name"></td>
                </tr>
                <tr>
                    <td>Second Name *</td>
                    <td><input type="text" name="second_name" value="<?php echo $feedback_data[0]['user_second_name'] ?>" placeholder="Second Name"></td>
                </tr>
                <tr>
                    <td>Image</td>
                    <td><input type="file" name="image_name" accept=".gif, .jpg, .png, .jpeg"></td>
                </tr>
                <tr>
                    <td>Feedback from *</td>
                    <td>
                        <select name="user_type">
                            <option value="new">New customer</option>
                            <option value="reg">Regular customer</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td><input type="date" name="publish_date" value="<?php echo $feedback_data[0]['publish_date'] ?>" placeholder="Publish date"></td>
                </tr>
            </table>
            <div class="form-textarea">
                Customer Text *
                <textarea name="users_text" placeholder="Customer Text"><?php echo $feedback_data[0]['users_text'] ?></textarea>
            </div>
            
            <div class="form-controls">
                <button type="submit" name="save_feedback" value="save_feedback">
                    Save <i class="fa-regular fa-floppy-disk"></i>
                </button>
            </div>
        </form>
        <form class="delete-section" id="delete_feedback">
            <input name="csrf_token" type="hidden" value="<?php echo $token; ?>" />
            <input name="feedback_id" type="hidden" value="<?php echo $feedback_data[0]['feedback_id'] ?>" />
            <button type="submit" name="delete_feedback" value="delete_feedback">
                Delete <i class="fa-sharp fa-solid fa-trash"></i>
            </button>
        </form>
    </div>