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

    if(!isset($_POST['first_name'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if(empty(trim($_POST['first_name']))) {
        echo build_error_block('Fill in the first name field');
        exit;
    }

    if(!isset($_POST['second_name'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if(empty(trim($_POST['second_name']))) {
        echo build_error_block('Fill in the second name field');
        exit;
    }

    if(!isset($_POST['user_type'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if($_POST['user_type'] != 'new' and $_POST['user_type'] != 'reg') {
        echo build_error_block('Select feedback from');
        exit;
    }

    if(!isset($_POST['publish_date'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if(!isset($_POST['users_text'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if(empty(trim($_POST['users_text']))) {
        echo build_error_block('Fill in the customers text field');
        exit;
    }

    $history_data_old = $db->query("SELECT `user_first_name`, 
    `user_second_name`, `image_name`, `user_type`, 
    `publish_date`, `users_text` from `feedbacks` 
    where `feedback_id` = (SELECT max(`feedback_id`) from `feedbacks` WHERE 1)");

    $update_feedback_data = $db->query("UPDATE `feedbacks`
    set `user_first_name` = :user_first_name, 
    `user_second_name` = :user_second_name, 
    `user_type` = :user_type, 
    `publish_date` = :publish_date, 
    `users_text` = :users_text 
    where SHA2(`feedback_id`, 256) = :feedback_id",[
        'user_first_name' => findXSS($_POST['first_name']),
        'user_second_name' => findXSS($_POST['second_name']),
        'user_type' => findXSS($_POST['user_type']),
        'publish_date' => ($_POST['publish_date'] == '') ? date('Y-m-d') : findXSS($_POST['publish_date']),
        'users_text' => findXSS($_POST['users_text']),
        'feedback_id' => findXSS($_POST['feedback_id'])
    ]);

    $users_image = $_FILES['image_name'];
    if(!empty($users_image['name'])) {
        $new_image_name_query = $db->query("SELECT SHA2(concat(`feedback_id`,`users_text`), 256) as 'image_name1', `image_name` as 'image_name2' from `feedbacks` WHERE SHA2(`feedback_id`, 256) = :feedback_id",[
            'feedback_id' => findXSS($_POST['feedback_id'])
        ]);
        $new_image_name = $new_image_name_query[0]['image_name1'];

        $uploadDirectory = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'site-images'.DIRECTORY_SEPARATOR.'feedback_users_images'.DIRECTORY_SEPARATOR;
        $targetPath = $uploadDirectory . $users_image['name'];
    
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        $fileExtension = strtolower(pathinfo($users_image['name'], PATHINFO_EXTENSION));

        if($new_image_name_query[0]['image_name2'] != '') {
            $filePath = $uploadDirectory.$new_image_name_query[0]['image_name2'];;
            if (!file_exists($filePath)) {
                echo build_error_block('Unknown Error');
            } 
            if (!unlink($filePath)) {
                echo build_error_block('Unknown Error');
            } 
        
            if (!in_array($fileExtension, $allowedExtensions)) {
                echo build_error_block('File format error');
                exit;
            }
        }
                  
           
        if (!move_uploaded_file($users_image['tmp_name'], $uploadDirectory . $users_image['name'])) {
            echo build_error_block('Error uploading file');
            exit;
        } 
    
        $path_to_feedback_image = $uploadDirectory . $new_image_name.'.'.$fileExtension;
        rename($targetPath, $path_to_feedback_image);
        $update_data_query = $db->query("UPDATE `feedbacks` set `image_name`= :image_name WHERE SHA2(`feedback_id`, 256) = :feedback_id",[
            'image_name' => $new_image_name.'.'.$fileExtension,
            'feedback_id' => findXSS($_POST['feedback_id'])
        ]);
    }

    $history_data_new = $db->query("SELECT `user_first_name`, 
    `user_second_name`, `image_name`, `user_type`, 
    `publish_date`, `users_text` from `feedbacks` 
    where `feedback_id` = (SELECT max(`feedback_id`) from `feedbacks` WHERE 1)");
    

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