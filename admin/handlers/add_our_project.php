<?php

require_once("check_session_part.php");
require_once('findXSS.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
    {
        echo build_error_block('Form submission error');
        exit;
    }

    if (!isset($_POST['project_link'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if (!isset($_POST['project_image_link'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if (!isset($_POST['project_text'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if(!empty($_POST['project_text']) and !empty($_POST['project_image_link'])) {
        echo build_error_block('Fill in project image link OR project text');
        exit;
    }

    $project_link = $_POST['project_link'];
    $project_image_link = $_POST['project_image_link'];
    $project_text = $_POST['project_text'];

    $add_project_query = $db->query("INSERT INTO `our_projects` (`project_link`, `project_image`, `project_text`) values 
    (:project_link, :project_image_link, :project_text)", [
        'project_link' => findXSS($project_link),
        'project_image_link' => findXSS($project_image_link),
        'project_text' => findXSS($project_text)
    ]);

    $history_data = $db->query("SELECT `project_link`, 
    `project_image`, `project_text` from `our_projects` 
    where `id_project` = (SELECT max(`id_project`) from `our_projects` WHERE 1)");

    $new_data = array_encode_json($history_data[0]);
    add_history([
        'id_user' => get_unhashed_user_id(),
        'action_type' => 13,
        'last_value' => NULL,
        'new_value' => $new_data,
        'additional_info' => NULL
    ]);

    $last_project_query = $db->query("SELECT SHA2(`id_project`, 256) as 'project_id', `project_link`, `project_image`, `project_text` from `our_projects` where `id_project` = (SELECT max(`id_project`) from `our_projects` where 1)");

    $new_project_data = [
        'csrf_token' => $_SESSION['csrf_token'],
        'project_id' => $last_project_query[0]['project_id'],
        'project_link' => $last_project_query[0]['project_link'],
        'project_image' => $last_project_query[0]['project_image'],
        'project_text' => $last_project_query[0]['project_text']
    ];



    echo array_encode_json($new_project_data);

}

?>