<?php

require_once("check_session_part.php");
require_once('findXSS.php');

if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
{
    echo build_error_block('Form submission error');
    exit;
}

    
if (!isset($_POST['id_user']) and
    !isset($_POST['first_name']) and
    !isset($_POST['second_name']) and
    !isset($_POST['patronymic']) and
    !isset($_POST['user_login']) and
    !isset($_POST['user_role'])) {
        echo build_error_block('Form submission error');
        exit;
}

$get_user_old_data = $db->query("SELECT `administrator_names`.`first_name` as 'first_name', 
    `administrator_names`.`second_name` as 'second_name', 
    `administrator_names`.`patronymic` as 'patronymic', 
    `administration`.`user_role` as 'user_role', 
    `administration`.`user_login` as 'user_login' 
    from `administrator_names` join `administration` on 
    `administrator_names`.`id_name` = `administration`.`id_name` 
    where SHA2(`administration`.`id_user`, 256) = :id_user",[
        'id_user' => findXSS($_POST['id_user'])
]);
            
$update_user_admin_data = $db->query("UPDATE `administration` SET 
    `user_role` = :user_role, 
    `user_login` = :user_login 
    WHERE SHA2(`id_user`, 256) = :id_user",[
        ':user_role' => findXSS($_POST['user_role']),
        ':user_login' => findXSS($_POST['user_login']),
        'id_user' => findXSS($_POST['id_user'])
    ]);


$user_id_name = $db->query("SELECT `id_name` FROM `administration`
    WHERE SHA2(`id_user`, 256) = :id_user", [
    'id_user' => findXSS($_POST['id_user'])
    ]);




$update_user_name_data = $db->query("UPDATE `administrator_names` SET 
    `first_name` = :first_name,
    `second_name` = :second_name, 
    `patronymic` = :patronymic 
    WHERE `id_name` = :id_name", 
    [
        'id_name' => findXSS($user_id_name[0]['id_name']),
        'first_name' => findXSS($_POST['first_name']),
        'second_name' => findXSS($_POST['second_name']),
        'patronymic' => findXSS($_POST['patronymic'])
    ]);


if(current_user() == $_POST['id_user']) {
    if(isset($_POST['old_password']) and $_POST['old_password'] != '') {

        $check_old_pass = $db->query("SELECT count(*) as `count` FROM `administration` WHERE 
            SHA2(`id_user`, 256) = :id_user AND
            password_hashed` = :old_password",[
                'id_user' => findXSS($_POST['id_user']),
                'old_password' => hash("sha256",hash("sha256",$_POST['old_password'])),
            ]);


        if($check_old_pass[0]['count'] != 1) {
            echo build_error_block('Password mismatch');
            exit;
        }
    }
}


if(isset($_POST['new_password']) and $_POST['new_password'] != '') {
    $update_user_password = $db->query("UPDATE `administration` SET 
        `password_hashed` = :new_password WHERE 
        SHA2(`id_user`, 256) = :id_user", [
            'new_password' => hash("sha256",hash("sha256",findXSS($_POST['new_password']))),
            'id_user' => findXSS($_POST['id_user'])
        ]);
} 


$get_user_new_data = $db->query("SELECT `administrator_names`.`first_name` as 'first_name', 
    `administrator_names`.`second_name` as 'second_name', 
    `administrator_names`.`patronymic` as 'patronymic', 
    `administration`.`user_role` as 'user_role', 
    `administration`.`user_login` as 'user_login' 
    from `administrator_names` join `administration` on 
    `administrator_names`.`id_name` = `administration`.`id_name` 
    where SHA2(`administration`.`id_user`, 256) = :id_user",[
        'id_user' => findXSS($_POST['id_user'])
    ]);

$old_data = array_encode_json($get_user_old_data[0]);
$new_data = array_encode_json($get_user_new_data[0]);


add_history([
    'id_user' => get_unhashed_user_id(),
    'action_type' => 1,
    'last_value' => $old_data,
    'new_value' => $new_data,
    'additional_info' => NULL
]);


echo "success";
exit;




?>