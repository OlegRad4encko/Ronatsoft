<?php

require_once("check_session_part.php");
require_once('findXSS.php');

if (isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] == @$_POST['csrf_token']) 
{
    
    if (isset($_POST['id_user']) and
        isset($_POST['first_name']) and
        isset($_POST['second_name']) and
        isset($_POST['patronymic']) and
        isset($_POST['user_login']) and
        isset($_POST['user_role'])) {

            
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
                    `password_hashed` = :old_password",[
                        'id_user' => findXSS($_POST['id_user']),
                        'old_password' => hash("sha256",hash("sha256",$_POST['old_password'])),
                    ]);


                    if($check_old_pass[0]['count'] != 1) {
                        echo '<div class="popup-error"><div class="inline"><h2>Error</h2><i class="cross-popup fa-regular fa-circle-xmark"></i></div><p>Password mismatch</p></div>';
                        exit;
                    }
                }
            }

            if($_POST['new_password'] == '') {
                echo '<div class="popup-error"><div class="inline"><h2>Error</h2><i class="cross-popup fa-regular fa-circle-xmark"></i></div><p>Empty password</p></div>';
                exit;
            }

            if(isset($_POST['new_password']) and $_POST['new_password'] != '') {
                $update_user_password = $db->query("UPDATE `administration` SET 
                `password_hashed` = :new_password WHERE 
                SHA2(`id_user`, 256) = :id_user", [
                    'new_password' => hash("sha256",hash("sha256",findXSS($_POST['new_password']))),
                    'id_user' => findXSS($_POST['id_user'])
                ]);
            } 
            

            echo "success";
            exit;


    } else {
        echo '<div class="popup-error"><div class="inline"><h2>Error</h2><i class="cross-popup fa-regular fa-circle-xmark"></i></div><p>Form submission error</p></div>';
        exit;
    }
} else {
    echo '<div class="popup-error"><div class="inline"><h2>Error</h2><i class="cross-popup fa-regular fa-circle-xmark"></i></div><p>Form submission error</p></div>';
}



?>