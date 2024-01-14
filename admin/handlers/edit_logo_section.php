<?php

require_once("check_session_part.php");
require_once('findXSS.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
    {
        echo build_error_block('Form submission error');
        exit;
    }


    $wellcome_text = '';
    $company_name = '';
    $slogan_text = '';

    $logo_section_background = '';

    $path_to_logo_section_background = '';
    $background_color = '';





    if(!isset($_POST['wellcome_text']) or !isset($_POST['company_name']) or !isset($_POST['slogan_text'])) {
        echo build_error_block('Form submission error');
        exit;
    }
    if(empty(trim($_POST['wellcome_text'])) or empty(trim($_POST['company_name'])) or empty(trim($_POST['slogan_text']))) {
        echo build_error_block('Fill all required fields');
        exit;
    }
    $wellcome_text = $_POST['wellcome_text'];
    $company_name = $_POST['company_name'];
    $slogan_text = $_POST['slogan_text'];


    if(!isset($_POST['logo_section_background'])) {
        echo build_error_block('Form submission error');
        exit;
    }
    if($_POST['logo_section_background'] != '1' and $_POST['logo_section_background'] != '2') {
        echo build_error_block('Select logo image type');
        exit;
    }
    $logo_section_background = $_POST['logo_section_background'];
    
    switch ($logo_section_background) {
        case '1':
            $logoImage = $_FILES['background-image'];
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

            $path_to_logo_section_background = $uploadDirectory . 'logo-background-image.png';
            rename($targetPath, $path_to_logo_section_background);

            break;
        case '2':
            if(!isset($_POST['background-color'])) {
                echo build_error_block('Form submission error');
                exit;
            }
            if(empty(trim($_POST['background-color']))) {
                echo build_error_block('Fill in the background color of the logo section');
                exit;
            }
            $background_color = $_POST['background-color'];

            break;
        
        default:
            echo build_error_block('Unknown error');
            exit;
    }


    $logo_section = [
        'wellcome_text' => findXSS($wellcome_text),
        'company_name' => findXSS($company_name),
        'slogan_text' => findXSS($slogan_text),
        'logo_section_background' => $logo_section_background,
        'path_to_logo_section_background' => ($path_to_logo_section_background) ? findXSS($path_to_logo_section_background) : NULL,
        'background_color' => ($background_color) ? findXSS($background_color) : NULL,
    ];

    $history_data_old = $db->query("SELECT `section_name`, 
    `section_content` from `page_sections` 
    WHERE `section_name` = 'logo_section'");

    $new_logo_section = array_encode_json($logo_section);

    $check_the_section = $db->query("SELECT count(*) as 'count' FROM `page_sections` WHERE `section_name` = 'logo_section'");

    if($check_the_section[0]['count'] == 0) {
        $db->query("INSERT INTO `page_sections` (`section_name`, `section_content`) values (:section_name, :section_content)",[
            'section_name' => 'logo_section',
            'section_content' => $new_logo_section
        ]);
    } else {
        $db->query("UPDATE `page_sections` SET `section_content`= :section_content WHERE `section_name` = 'logo_section'",[
            'section_content' => $new_logo_section
        ]);
    }

    $history_data_new = $db->query("SELECT `section_name`, 
    `section_content` from `page_sections` 
    WHERE `section_name` = 'logo_section'");

    $new_data = array_encode_json($history_data_new[0]);
    $old_data = array_encode_json($history_data_old[0]);

    add_history([
        'id_user' => get_unhashed_user_id(),
        'action_type' => 17,
        'last_value' => $old_data,
        'new_value' => $new_data,
        'additional_info' => NULL
    ]);
    

    echo build_success_block('Logo section data is saved');
}

?>