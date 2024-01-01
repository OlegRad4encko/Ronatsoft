<?php

require_once("check_session_part.php");
require_once('findXSS.php');


if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
{
    echo build_error_block('Form submission error');
    exit;
}

if (!isset($_POST['application_id'])) {
    echo build_error_block('Form submission error');
    exit;
}

if (!check_application_id($_POST['application_id'])) {
    echo build_error_block('Form submission error');
    exit;
}

$change_state = $db->query("UPDATE `applications` SET `application_state` = 'solved', `id_user` = :id_user WHERE SHA2(`id_application`, 256) = :id_application",
    [
        'id_user' => get_unhashed_user_id(),
        'id_application' => findXSS($_POST['application_id'])
    ]);

add_history([
    'id_user' => get_unhashed_user_id(),
    'action_type' => 5,
    'last_value' => NULL,
    'new_value' => findXSS($_POST['application_id']),
    'additional_info' => NULL
    ]);

echo 'success';


?>