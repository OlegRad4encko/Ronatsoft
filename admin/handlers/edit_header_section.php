<?php

require_once("check_session_part.php");
require_once('findXSS.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
    {
        echo build_error_block('Form submission error');
        exit;
    }


    $logo_type = '';
    
    $logo_text = '';
    $logo_color = '';

    $logo_first_part_text = '';
    $logo_first_part_color = '';
    $logo_second_part_text = '';
    $logo_second_part_color = '';

    $logo_image = '';
    $full_path_to_header_logo = '';
    $logo_image_link = '';

    $count_soc_links = '';
    $soc_link1 = '';
    $soc_link2 = '';
    $soc_link3 = '';

    $header_text_color = '';
    $header_background_color = '';

    
    if (!isset($_POST['logo_type'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    $logo_type = $_POST['logo_type'];
    switch ($logo_type) {
        case '1':
            if(!isset($_POST['logo_text']) or !isset($_POST['logo_color'])) {
                echo build_error_block('Form submission error');
                exit;
            }
            if(empty(trim($_POST['logo_text'])) or empty(trim($_POST['logo_color']))) {
                echo build_error_block('Fill in all fields');
                exit;
            }
            $logo_text = $_POST['logo_text'];
            $logo_color = $_POST['logo_color'];


            break;

        case '2':
            if(!isset($_POST['logo_first_part_text']) or !isset($_POST['logo_first_part_color'])
            or !isset($_POST['logo_second_part_text']) or !isset($_POST['logo_second_part_color'])){
                echo build_error_block('Form submission error');
                exit;
            }
            if(empty(trim($_POST['logo_first_part_text'])) or empty(trim($_POST['logo_first_part_color'])) or
            empty(trim($_POST['logo_second_part_text'])) or empty(trim($_POST['logo_second_part_color']))) {
                echo build_error_block('Fill in all fields');
                exit;
            }
            $logo_first_part_text = $_POST['logo_first_part_text'];
            $logo_first_part_color = $_POST['logo_first_part_color'];
            $logo_second_part_text = $_POST['logo_second_part_text'];
            $logo_second_part_color = $_POST['logo_second_part_color'];


            break;

        case '3':
            if(!isset($_POST['logo_image'])) {
                echo build_error_block('Form submission error');
                exit;
            }

            $logo_image = $_POST['logo_image'];

            switch ($logo_image) {
                case '1':
                    $logoImage = $_FILES['logo_image_file'];
                    $uploadDirectory = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'site-images'.DIRECTORY_SEPARATOR;
                    $targetPath = $uploadDirectory . $logoImage['name'];

                    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
                    $fileExtension = strtolower(pathinfo($logoImage['name'], PATHINFO_EXTENSION));
                    if(!empty($logoImage['name'])) {
                        if (!in_array($fileExtension, $allowedExtensions)) {
                            echo build_error_block('File format error');
                            exit;
                        }
                    }
                    
                    if(!empty($logoImage['name'])) {
                        if (!move_uploaded_file($logoImage['tmp_name'], $uploadDirectory . $logoImage['name'])) {
                            echo build_error_block('Error uploading file');
                            exit;
                        } 
                    }

                    $full_path_to_header_logo = $uploadDirectory . 'header-logo.png';
                    rename($targetPath, $full_path_to_header_logo);

                    break;
                case '2':
                    if(!isset($_POST['logo_image_link'])) {
                        echo build_error_block('Form submission error');
                        exit;
                    }
                    if(empty(trim($_POST['logo_image_link']))) {
                        echo build_error_block('Fill in all fields');
                        exit;
                    }
                    $logo_image_link = $_POST['logo_image_link'];
                    break;
                
                default:
                    echo build_error_block('Form submission error');
                    exit;
            }


            break;

        default:
            echo build_error_block('Form submission error');
            exit;
    }




    // count_soc_links
    if (!isset($_POST['count_soc_links'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    $count_soc_links = $_POST['count_soc_links'];
    switch ($count_soc_links) {
        case '1':
            if(!isset($_POST['soc1'])) {
                echo build_error_block('Form submission error');
                exit;
            }
            $soc_link1 = $_POST['soc1'];
            break;
        case '2':
            if(!isset($_POST['soc1']) or !isset($_POST['soc2'])) {
                echo build_error_block('Form submission error');
                exit;
            }
            $soc_link1 = $_POST['soc1'];
            $soc_link2 = $_POST['soc2'];
            break;
        case '3':
            if(!isset($_POST['soc1']) or !isset($_POST['soc2']) or !isset($_POST['soc3'])) {
                echo build_error_block('Form submission error');
                exit;
            }
            $soc_link1 = $_POST['soc1'];
            $soc_link2 = $_POST['soc2'];
            $soc_link3 = $_POST['soc3'];
            break;
        
        default:
            echo build_error_block('Form submission error');
            exit;
    }

    if(!isset($_POST['header_text_color'])) {
        echo build_error_block('Form submission error');
        exit;
    }
    $header_text_color = $_POST['header_text_color'];

    if(!isset($_POST['header_background_color'])) {
        echo build_error_block('Form submission error');
        exit;
    }
    $header_background_color = $_POST['header_background_color'];



    $history_data_old = $db->query("SELECT `section_name`, 
    `section_content` from `page_sections` 
    WHERE `section_name` = 'header_section'");



    $new_header = [
        'logo_type' => $logo_type,
        'logo_text' => ($logo_text) ? findXSS($logo_text) : NULL,
        'logo_color' => ($logo_color) ? findXSS($logo_color) : NULL,
        'logo_first_part_text' => ($logo_first_part_text) ? findXSS($logo_first_part_text) : NULL,
        'logo_first_part_color' => ($logo_first_part_color) ? findXSS($logo_first_part_color) : NULL,
        'logo_second_part_text' => ($logo_second_part_text) ? findXSS($logo_second_part_text) : NULL,
        'logo_second_part_color' => ($logo_second_part_color) ? findXSS($logo_second_part_color) : NULL,
        'logo_image' => ($logo_image) ? findXSS($logo_image) : NULL,
        'full_path_to_header_logo' => ($full_path_to_header_logo) ? findXSS($full_path_to_header_logo) : NULL,
        'logo_image_link' => ($logo_image_link) ? findXSS($logo_image_link) : NULL,
        'count_soc_links' => $count_soc_links,
        'soc_link1' => ($soc_link1) ? findXSS($soc_link1) : 0,
        'soc_link2' => ($soc_link2) ? findXSS($soc_link2) : 0,
        'soc_link3' => ($soc_link3) ? findXSS($soc_link3) : 0,
        'header_text_color' => ($header_text_color) ? findXSS($header_text_color) : NULL,
        'header_background_color' => ($header_background_color) ? findXSS($header_background_color) : NULL
    ];

    $new_header_data = array_encode_json($new_header);



    $check_the_section = $db->query("SELECT count(*) as 'count' FROM `page_sections` WHERE `section_name` = 'header_section'");

    if($check_the_section[0]['count'] == 0) {
        $db->query("INSERT INTO `page_sections` (`section_name`, `section_content`) values (:section_name, :section_content)",[
            'section_name' => 'header_section',
            'section_content' => $new_header_data
        ]);
    } else {
        $db->query("UPDATE `page_sections` SET `section_content`= :section_content WHERE `section_name` = 'header_section'",[
            'section_content' => $new_header_data
        ]);
    }

    $history_data_new = $db->query("SELECT `section_name`, 
    `section_content` from `page_sections` 
    WHERE `section_name` = 'header_section'");

    $new_data = array_encode_json($history_data_new[0]);
    $old_data = array_encode_json($history_data_old[0]);

    add_history([
        'id_user' => get_unhashed_user_id(),
        'action_type' => 16,
        'last_value' => $old_data,
        'new_value' => $new_data,
        'additional_info' => NULL
    ]);
    

    echo build_success_block('Header data is saved');




}

?>