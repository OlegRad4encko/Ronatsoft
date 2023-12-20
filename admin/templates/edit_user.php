<?php 

    require_once('../handlers/check_session_part.php');
    require_once('../handlers/findXSS.php');

    if(isset($_POST['edit_user'])) {

        $user_data = $db->query("SELECT `first_name`, 
        SHA2(`id_user`, 256) as 'id_user', 
        `second_name`, 
        `patronymic`, 
        `user_login`, 
        `user_role`, 
        SHA2(`id_user`, 256) as 'user_id'  
        FROM `administrator_names` inner join `administration` on 
        `administrator_names`.`id_name` = `administration`.`id_name` 
        WHERE SHA2(`id_user`, 256) = :id_user",
        [
            ':id_user' => $_POST['edit_user']
        ]);

        if(!empty($user_data)) {
            $token = generate_form_token();

?> 

    <div class="add-edit-form">
        <form class="modal-content" id="edit_user">
            <div class="modal-header">
                <h1>Edit User</h1>
                <i class="cross-form fa-regular fa-circle-xmark"></i>
            </div>
            
            <input name="csrf_token" type="hidden" value="<?php echo $token; ?>" />
            <input name="id_user" type="hidden" value="<?php echo $user_data[0]['id_user']; ?>" />
            <table>
                <tr>
                    <td>First Name *</td>
                    <td><input type="text" name="first_name" value="<?php echo $user_data[0]['first_name']; ?>" minlength="6" maxlength="50"></td>
                </tr>
                <tr>
                    <td>Second Name</td>
                    <td><input type="text" name="second_name" value="<?php echo $user_data[0]['second_name']; ?>"></td>
                </tr>
                <tr>
                    <td>User Patronymic</td>
                    <td><input type="text" name="patronymic" value="<?php echo $user_data[0]['patronymic']; ?>"></td>
                </tr>
                <tr>
                    <td>User Login *</td>
                    <td><input type="text" name="user_login" value="<?php echo $user_data[0]['user_login']; ?>" minlength="6" maxlength="50"></td>
                </tr>
                <tr>
                    <td>User Role</td>
                    <td>
                        <select name="user_role">
                            <option value="admin" <?php echo ($user_data[0]['user_role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                            <option value="moderator" <?php echo ($user_data[0]['user_role'] == 'moderator') ? 'selected' : '' ?>>Moderator</option>
                        </select>
                    </td>
                </tr>
                <?php 
                
                if (current_user() == $user_data[0]['user_id']) {
                    ?> 
                    
                    <tr>
                        <td>Old Password</td>
                        <td><input type="password" name="old_password" value="" minlength="6" maxlength="50"></td>
                    </tr>
                    
                    <?php
                }

                ?> 
                <tr>
                    <td>New Password</td>
                    <td><input type="password" name="new_password" value="" minlength="6" maxlength="50"></td>
                </tr>
            </table>
            <div class="form-controls">
                <button type="submit" name="save_user" value="save_user">
                    Save <i class="fa-regular fa-floppy-disk"></i>
                </button>
            </div>
        </form>
        <form class="delete-section" id="delete_user">
            <input name="csrf_token" type="hidden" value="<?php echo $token; ?>" />
            <input name="id_user" type="hidden" value="<?php echo $user_data[0]['id_user']; ?>" />
            <button type="submit" name="delete_user" value="delete_user">
                Delete <i class="fa-sharp fa-solid fa-trash"></i>
            </button>
        </form>
    </div>

<?php
        } else {
            echo '<div class="popup-error"><div class="inline"><h2>Error</h2><i class="cross-popup fa-regular fa-circle-xmark"></i></div><p>Unknown error</p></div>';
            exit;
        }
    }
    

?>