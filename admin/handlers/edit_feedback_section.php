<?php

require_once("check_session_part.php");
require_once('findXSS.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
    {
        echo build_error_block('Form submission error');
        exit;
    }

    if(!isset($_POST['displayed_feedback_section_name'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if(!isset($_POST['count_feedback_blocks'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if(!isset($_POST['background_color'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if(!isset($_POST['feedback_background_color'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if(empty(trim($_POST['displayed_feedback_section_name']))) {
        echo build_error_block('Fill in the section name');
        exit;
    }

    $displayed_feedback_section_name = $_POST['displayed_feedback_section_name'];
    $count_feedback_blocks = $_POST['count_feedback_blocks'];
    $background_color = $_POST['background_color'];
    $feedback_background_color = $_POST['feedback_background_color'];

    $feedback_section_data = [
        'displayed_feedback_section_name' => $displayed_feedback_section_name,
        'count_feedback_blocks' => $count_feedback_blocks,
        'background_color' => $background_color,
        'feedback_background_color' => $feedback_background_color
    ];


    $history_data_old = $db->query("SELECT `section_name`, 
    `section_content` from `page_sections` 
    WHERE `section_name` = 'feedback_section'");


    $new_feedback_section_data = array_encode_json($feedback_section_data);

    $check_the_section = $db->query("SELECT count(*) as 'count' FROM `page_sections` WHERE `section_name` = 'feedback_section'");

    if($check_the_section[0]['count'] == 0) {
        $db->query("INSERT INTO `page_sections` (`section_name`, `section_content`) values (:section_name, :section_content)",[
            'section_name' => 'feedback_section',
            'section_content' => $new_feedback_section_data
        ]);
    } else {
        $db->query("UPDATE `page_sections` SET `section_content`= :section_content WHERE `section_name` = 'feedback_section'",[
            'section_content' => $new_feedback_section_data
        ]);
    }
    

    $history_data_new = $db->query("SELECT `section_name`, 
    `section_content` from `page_sections` 
    WHERE `section_name` = 'feedback_section'");

    $new_data = array_encode_json($history_data_new[0]);
    $old_data = array_encode_json($history_data_old[0]);

    add_history([
        'id_user' => get_unhashed_user_id(),
        'action_type' => 20,
        'last_value' => $old_data,
        'new_value' => $new_data,
        'additional_info' => NULL
    ]);


    echo build_success_block('Feedback section data is saved');


} else {
    echo build_error_block('Form submission error');
    exit;
}

?>