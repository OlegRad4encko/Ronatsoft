<?php

require_once("check_session_part.php");
require_once('findXSS.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
    {
        echo build_error_block('Form submission error');
        exit;
    }

    if(!isset($_POST['displayed_projects_section_name'])) {
        echo build_error_block('Form submission error');
        exit;
    }
    
    if(empty(trim($_POST['displayed_projects_section_name']))) {
        echo build_error_block('Fill in the displayed section name');
        exit;
    }
    
    if(!isset($_POST['count_projects_blocks'])) {
        echo build_error_block('Form submission error');
        exit;
    }
    
    if(!isset($_POST['from_color_gradient'])) {
        echo build_error_block('Form submission error');
        exit;
    }
    
    if(!isset($_POST['to_color_gradient'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    $displayed_projects_section_name = $_POST['displayed_projects_section_name'];
    $count_projects_blocks = $_POST['count_projects_blocks'];
    $from_color_gradient = $_POST['from_color_gradient'];
    $to_color_gradient = $_POST['to_color_gradient'];


    $our_projects_data = [
        'displayed_projects_section_name' => findXSS($displayed_projects_section_name),
        'count_projects_blocks' => findXSS($count_projects_blocks),
        'from_color_gradient' => findXSS($from_color_gradient),
        'to_color_gradient' => findXSS($to_color_gradient)
    ];


    $history_data_old = $db->query("SELECT `section_name`, 
    `section_content` from `page_sections` 
    WHERE `section_name` = 'our_projects_section'");


    $json_our_project_data = array_encode_json($our_projects_data);

    $check_the_section = $db->query("SELECT count(*) as 'count' FROM `page_sections` WHERE `section_name` = 'our_projects_section'");

    if($check_the_section[0]['count'] == 0) {
        $db->query("INSERT INTO `page_sections` (`section_name`, `section_content`) values (:section_name, :section_content)",[
            'section_name' => 'our_projects_section',
            'section_content' => $json_our_project_data
        ]);
    } else {
        $db->query("UPDATE `page_sections` SET `section_content`= :section_content WHERE `section_name` = 'our_projects_section'",[
            'section_content' => $json_our_project_data
        ]);
    }
    

    $history_data_new = $db->query("SELECT `section_name`, 
    `section_content` from `page_sections` 
    WHERE `section_name` = 'our_projects_section'");

    $new_data = array_encode_json($history_data_new[0]);
    $old_data = array_encode_json($history_data_old[0]);

    add_history([
        'id_user' => get_unhashed_user_id(),
        'action_type' => 19,
        'last_value' => $old_data,
        'new_value' => $new_data,
        'additional_info' => NULL
    ]);


    echo build_success_block('Our Projects section data is saved');

} else {
    echo build_error_block('Form submission error');
    exit;
}





?>