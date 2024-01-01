<?php 

require_once("check_session_part.php");
require_once('findXSS.php');


if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
{
    echo build_error_block('Form submission error');
    exit;
}


if (!isset($_POST['first_name']) and !isset($_POST['user_login']) 
    and !isset($_POST['password']) and !isset($_POST['confirm_password'])) 
{
    echo build_error_block('Form submission error');
    exit;
}


if($_POST['password'] != $_POST['confirm_password']) 
{
    echo build_error_block('Password mismatch');
    exit; 
}

    
if(strlen($_POST['password']) < 6) 
{
    echo build_error_block('Password length is less than 6 characters');
    exit;
}


if($_POST['user_login'] == '') 
{
    echo build_error_block('Login length is less than 6 characters');
    exit;
}


if($_POST['first_name'] == '' or $_POST['first_name'] == ' ') {
    echo build_error_block('Fist name can`t be empty');
}


if ($_POST['user_role'] != 'admin' and $_POST['user_role'] != 'moderator')
{
    echo build_error_block('Form submission error. Please Update the page.');
    exit;
}


$check_login_user = $db->query("SELECT count(*) as `count` FROM `administration`
    WHERE `user_login` = :user_login", [
        'user_login' => findXSS($_POST['user_login'])
    ]);    
if ($check_login_user[0]['count'] != 0) {
    echo build_error_block('This login already exists.');
    exit;
}

if (empty(trim($_POST['first_name'])) || empty(trim($_POST['user_login'])) || 
    empty(trim($_POST['password']))) 
{
    echo build_error_block('Please fill in all required fields.');
    exit;
}
    
    
$add_user_name = $db->query("INSERT INTO `administrator_names` 
    (`first_name`, `second_name`, `patronymic`) 
    VALUES 
    (:first_name, :second_name, :patronymic)", [
        'first_name' => findXSS($_POST['first_name']),
        'second_name' => findXSS($_POST['second_name']),
        'patronymic' => findXSS($_POST['patronymic'])
    ]);

$get_last_user_name = $db->query("SELECT max(`id_name`) as `id_name` from `administrator_names`", []);


$add_user = $db->query("INSERT INTO `administration` 
    (`id_name`, `user_role`, `user_login`, `password_hashed`) 
    VALUES 
    (:id_name, :user_role, :user_login, :password_hashed)", [
        'id_name' => findXSS($get_last_user_name[0]['id_name']),
        'user_role' => findXSS($_POST['user_role']),
        'user_login' => findXSS($_POST['user_login']),
        'password_hashed' => hash("sha256",hash("sha256",$_POST['password']))
    ]);


$full_user_name = $_POST['second_name'].' '.$_POST['first_name'].' '.$_POST['patronymic'];
add_history([
    'id_user' => get_unhashed_user_id(),
    'action_type' => 2,
    'last_value' => NULL,
    'new_value' => findXSS('['.$_POST['user_role'].'] '.$full_user_name),
    'additional_info' => NULL
]);

echo "success";
                   


?>