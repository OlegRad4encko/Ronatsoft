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
        echo build_error_block('2Form submission error');
        exit;
    }

    $history_data_old = $db->query("SELECT `project_link`, 
    `project_image`, `project_text` from `our_projects` 
    WHERE SHA2(`id_project`, 256) = :project_id", [
        'project_id' => findXSS($_POST['project_id'])
    ]);

    $delete_project = $db->query("DELETE FROM `our_projects` where SHA2(`id_project`, 256) = :project_id", [
        'project_id' => findXSS($_POST['project_id'])
    ]);

    $old_data = array_encode_json($history_data_old[0]);
    add_history([
        'id_user' => get_unhashed_user_id(),
        'action_type' => 15,
        'last_value' => $old_data,
        'new_value' => NULL,
        'additional_info' => NULL
    ]);

    echo build_success_block("Projecs successfuly deleted.");
} else {
    echo build_error_block('Form submission error');
    exit;
}

?>