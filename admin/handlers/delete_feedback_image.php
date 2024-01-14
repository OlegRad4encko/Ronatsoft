<?php

require_once("check_session_part.php");
require_once('findXSS.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
    {
        echo build_error_block('Form submission error');
        exit;
    }

    if(!isset($_POST['feedback_id'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    
    
    $feedback_id = findXSS($_POST['feedback_id']);


    $history_data_old = $db->query("SELECT `user_first_name`, 
    `user_second_name`, `image_name`, `user_type`, 
    `publish_date`, `users_text` from `feedbacks` 
    where SHA2(`feedback_id`, 256) = :feedback_id", [
        'feedback_id' => $feedback_id
    ]);


    $uploadDirectory = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'site-images'.DIRECTORY_SEPARATOR.'feedback_users_images'.DIRECTORY_SEPARATOR;

    $get_image_name = $db->query("SELECT `image_name` from `feedbacks` WHERE SHA2(`feedback_id`, 256) = :feedback_id",[
        'feedback_id' => $feedback_id
    ]);

    $full_path = $uploadDirectory.$get_image_name[0]['image_name'];
    if (!file_exists($full_path)) {
        echo build_error_block('Unknown Error');
        exit;
    } 
    if (!unlink($full_path)) {
        echo build_error_block('Unknown Error');
        exit;
    } 

    $update_feedback_data = $db->query("UPDATE `feedbacks` SET `image_name` = NULL WHERE SHA2(`feedback_id`, 256) = :feedback_id", [
        'feedback_id' => $feedback_id
    ]);

    $history_data_new = $db->query("SELECT `user_first_name`, 
    `user_second_name`, `image_name`, `user_type`, 
    `publish_date`, `users_text` from `feedbacks` 
    where SHA2(`feedback_id`, 256) = :feedback_id", [
        'feedback_id' => $feedback_id
    ]);

    $new_data = array_encode_json($history_data_new[0]);
    $old_data = array_encode_json($history_data_old[0]);

    add_history([
        'id_user' => get_unhashed_user_id(),
        'action_type' => 11,
        'last_value' => $old_data,
        'new_value' => $new_data,
        'additional_info' => NULL
    ]);

    echo "success";

}

?>