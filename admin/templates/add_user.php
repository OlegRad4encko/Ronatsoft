<?php 

require_once('../handlers/check_session_part.php');
require_once('../handlers/findXSS.php');

function random_password() {
    return substr( str_shuffle( 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM' ), 0, 10 );
}

$rand_pass = random_password();

?>

<div class="add-edit-form">
        <form class="modal-content" id="add_user">
            <div class="modal-header">
                <h1>Add User</h1>
                <i class="cross-form fa-regular fa-circle-xmark"></i>
            </div>
            
            <input name="csrf_token" type="hidden" value="<?php echo generate_form_token(); ?>" />
            <table>
                <tr>
                    <td>First Name*</td>
                    <td><input type="text" name="first_name" value=""></td>
                </tr>
                <tr>
                    <td>Second Name</td>
                    <td><input type="text" name="second_name" value=""></td>
                </tr>
                <tr>
                    <td>User Patronymic</td>
                    <td><input type="text" name="patronymic" value=""></td>
                </tr>
                <tr>
                    <td>User Login*</td>
                    <td><input type="text" name="user_login" value="" minlength="6" maxlength="50"></td>
                </tr>
                <tr>
                    <td>User Role</td>
                    <td>
                        <select name="user_role">
                            <option value="moderator">Moderator</option>
                            <option value="admin">Admin</option>
                        </select>
                    </td>
                </tr>                 
                <tr>
                    <td>Password*</td>
                    <td><input type="text" name="password" value="<?php echo $rand_pass; ?>" minlength="6" maxlength="50"></td>
                </tr>
                <tr>
                    <td>Repeat Password*</td>
                    <td><input type="text" name="confirm_password" value="<?php echo $rand_pass; ?>" minlength="6" maxlength="50"></td>
                </tr>
            </table>
            <div class="form-controls">
                <button type="submit" name="create_user" value="save_user">
                    Create User <i class="fa-solid fa-user-plus"></i>
                </button>
            </div>
        </form>
    </div>

