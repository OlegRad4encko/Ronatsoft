<?php

require_once("check_session_part.php");
require_once('findXSS.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
    {
        echo build_error_block('Form submission error');
        exit;
    }

    if (!isset($_POST['project_id'])) {
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

    $update_project = $db->query("UPDATE `our_projects` SET `project_link` = :project_link ,`project_text` = :project_text, `project_image` = :project_image_link WHERE SHA2(`id_project`, 256) = :project_id", [
        'project_link' => findXSS($_POST['project_link']),
        'project_image_link' => findXSS($_POST['project_image_link']),
        'project_text' => findXSS($_POST['project_text']),
        'project_id' => findXSS($_POST['project_id'])
    ]);

    echo build_success_block('Project data is saved');

}

?>