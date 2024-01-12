<?php

require_once("check_session_part.php");
require_once('findXSS.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
    {
        echo build_error_block('1Form submission error');
        exit;
    }

    if (!isset($_POST['project_id'])) {
        echo build_error_block('2Form submission error');
        exit;
    }

    $delete_project = $db->query("DELETE FROM `our_projects` where SHA2(`id_project`, 256) = :project_id", [
        'project_id' => findXSS($_POST['project_id'])
    ]);

    echo build_success_block("Projecs successfuly deleted.");
} else {
    echo build_error_block('1Form submission error');
    exit;
}

?>