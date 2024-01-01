<?php 

require_once("check_session_part.php");
require_once('findXSS.php');

if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
{
    echo build_error_block('Form submission error');
    exit;
}

if (!isset($_POST['id_user'])) 
{
    echo build_error_block('Form submission error');
    exit;
}


$checking_for_availability = $db->query("SELECT count(*) as `count` FROM `administration`
    WHERE SHA2(`id_user`, 256) = :id_user", [
        ':id_user' => findXSS($_POST['id_user'])
    ]);


if ($checking_for_availability[0]['count'] != 1) 
{
    echo build_error_block('Update page and try delete user again.');
    exit;
}


if(current_user() == $_POST['id_user']) 
{
    echo build_error_block('You can`t delete yourself!');
    exit;
}


$user_id_name = $db->query("SELECT `id_name`, `user_role` FROM `administration`
    WHERE SHA2(`id_user`, 256) = :id_user", [
        'id_user' => findXSS($_POST['id_user'])
    ]);

$get_user_name_for_history = $db->query("SELECT `first_name`, `second_name`, `patronymic` from `administrator_names` 
    WHERE `id_name` = :id_name", [
        'id_name' => findXSS($user_id_name[0]['id_name'])
    ]);

$full_user_name = $get_user_name_for_history[0]['second_name'].' '
    .$get_user_name_for_history[0]['first_name'].' '
    .$get_user_name_for_history[0]['patronymic'];

add_history([
    'id_user' => get_unhashed_user_id(),
    'action_type' => 3,
    'last_value' => findXSS('['.$user_id_name[0]['user_role'].'] '.$full_user_name),
    'new_value' => NULL,
    'additional_info' => NULL
]);

$delete_user_name = $db->query("DELETE FROM `administrator_names` 
    WHERE `id_name` = :id_name", [
        'id_name' => findXSS($user_id_name[0]['id_name'])
    ]);

$delete_user = $db->query("DELETE FROM `administration` 
    WHERE SHA2(`id_user`, 256) = :id_user", [
        'id_user' => findXSS($_POST['id_user'])
    ]);



echo "success";

?>