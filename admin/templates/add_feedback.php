<?php 

    require_once('../handlers/check_session_part.php');
    require_once('../handlers/findXSS.php');

    
    $token = generate_form_token();

?> 

    <div class="add-edit-form">
        <form class="modal-content" id="add_feedback" enctype="multipart/form-data">
            <div class="modal-header">
                <h1>Add Feedback</h1>
                <i class="cross-form fa-regular fa-circle-xmark"></i>
            </div>
            
            <input name="csrf_token" type="hidden" value="<?php echo $token; ?>" />
            <input name="id_user" type="hidden" value="" />
            <table>
                <tr>
                    <td colspan="2" class="center-feedback-image">
                        <div>
                            <div class="feedback-image" style="display: none">
                                <img src="" alt="">
                            </div>
                            <div class="feedback-default">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            
                        </div> 
                    </td>
                </tr>
                <tr>
                    <td>First Name *</td>
                    <td><input type="text" name="first_name" value="" placeholder="First Name"></td>
                </tr>
                <tr>
                    <td>Second Name *</td>
                    <td><input type="text" name="second_name" value="" placeholder="Second Name"></td>
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
                    <td><input type="date" name="publish_date" value="" placeholder="Publish date"></td>
                </tr>
            </table>
            <div class="form-textarea">
                Customer Text *
                <textarea name="users_text" placeholder="Customer Text"></textarea>
            </div>
            
            <div class="form-controls">
                <button type="submit" name="save_user" value="save_user">
                    Save <i class="fa-regular fa-floppy-disk"></i>
                </button>
            </div>
        </form>
        <!-- <form class="delete-section" id="delete_feedback">
            <input name="csrf_token" type="hidden" value="<?php // echo $token; ?>" />
            <input name="id_user" type="hidden" value="" />
            <button type="submit" name="delete_feedback" value="delete_feedback">
                Delete <i class="fa-sharp fa-solid fa-trash"></i>
            </button>
        </form> -->
    </div>

