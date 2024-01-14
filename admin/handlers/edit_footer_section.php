<?php

require_once("check_session_part.php");
require_once('findXSS.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
    {
        echo build_error_block('Form submission error');
        exit;
    }

    if (!isset($_POST['displayed_footer_company_name'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if (!isset($_POST['rights_text'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if (!isset($_POST['background_footer_color'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if (!isset($_POST['footer_text_color'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if (empty(trim($_POST['displayed_footer_company_name']))) {
        echo build_error_block('Fill in the company name');
        exit;
    }

    if (empty(trim($_POST['rights_text']))) {
        echo build_error_block('Fill in the Rights text');
        exit;
    }

    if (empty(trim($_POST['background_footer_color']))) {
        echo build_error_block('Select footer background color');
        exit;
    }

    if (empty(trim($_POST['footer_text_color']))) {
        echo build_error_block('Select footer text color');
        exit;
    }

    $footer_data = [
        'company_name' => findXSS($_POST['displayed_footer_company_name']),
        'rights_text' => findXSS($_POST['rights_text']),
        'background_color' => findXSS($_POST['background_footer_color']),
        'text_color' => findXSS($_POST['footer_text_color'])
    ];

    $history_data_old = $db->query("SELECT `section_name`, 
    `section_content` from `page_sections` 
    WHERE `section_name` = 'footer_section'");

    $array_data = array_encode_json($footer_data);

    $check_the_section = $db->query("SELECT count(*) as 'count' FROM `page_sections` WHERE `section_name` = 'footer_section'");
    if($check_the_section[0]['count'] == 0) {
        $db->query("INSERT INTO `page_sections` (`section_name`, `section_content`) values (:section_name, :section_content)",[
            'section_name' => 'footer_section',
            'section_content' => $array_data
        ]);
    } else {
        $db->query("UPDATE `page_sections` SET `section_content`= :section_content WHERE `section_name` = 'footer_section'",[
            'section_content' => $array_data
        ]);
    }


    $history_data_new = $db->query("SELECT `section_name`, 
    `section_content` from `page_sections` 
    WHERE `section_name` = 'footer_section'");

    $new_data = array_encode_json($history_data_new[0]);
    $old_data = array_encode_json($history_data_old[0]);

    add_history([
        'id_user' => get_unhashed_user_id(),
        'action_type' => 21,
        'last_value' => $old_data,
        'new_value' => $new_data,
        'additional_info' => NULL
    ]);


    echo build_success_block('Footer section data is saved');



} else {
    echo build_error_block('Form submission error');
    exit;
}

?>
