<?php

require_once("check_session_part.php");
require_once('findXSS.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
    {
        echo build_error_block('Form submission error');
        exit;
    }

    $displayed_about_section_name = '';
    $paragraph1 = '';
    $paragraph2 = '';

    $image_set = 'false';
    $about_us_image_type = '';
    $path_about_us_image = '';
    $about_us_image_link = '';

    $about_us_text_color = '';
    $about_us_background_color = '';


    if(!isset($_POST['displayed_about_section_name']) or !isset($_POST['paragraph1']) or !isset($_POST['paragraph2'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if(empty(trim($_POST['displayed_about_section_name'])) or (empty(trim($_POST['paragraph1'])) or empty(trim($_POST['paragraph2'])))) {
        echo build_error_block('Fill text data in "About Us" sedction');
        exit;
    }

    $displayed_about_section_name = $_POST['displayed_about_section_name'];
    $paragraph1 = $_POST['paragraph1'];
    $paragraph2 = $_POST['paragraph2'];



    if(isset($_POST['image_set'])) {
        $image_set = $_POST['image_set'];

        if(!isset($_POST['about_us_image_type'])) {
            echo build_error_block('Form submission error');
            exit;
        }
        $about_us_image_type = $_POST['about_us_image_type'];

        switch ($about_us_image_type) {
            case '1':
                $logoImage = $_FILES['about_us_image_file'];
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

                $path_about_us_image = $uploadDirectory . 'about-us-image.png';
                rename($targetPath, $path_about_us_image);
                break;

            case '2':
                if(!isset($_POST['about_us_image_link'])) {
                    echo build_error_block('Form submission error');
                    exit;
                }

                $about_us_image_link = $_POST['about_us_image_link'];

                break;
            
            default:
                echo build_error_block('Form submission error');
                exit;
        }
    }

    if(!isset($_POST['about_us_text_color'])) {
        echo build_error_block('Form submission error');
        exit;
    }
    if(!isset($_POST['about_us_background_color'])) {
        echo build_error_block('Form submission error');
        exit;
    }

    if(empty(trim($_POST['about_us_text_color']))){
        echo build_error_block('Fill in the "About Us text color"');
        exit;
    }
    if(empty(trim($_POST['about_us_background_color']))){
        echo build_error_block('Fill in the "About Us background color"');
        exit;
    }

    $about_us_text_color = $_POST['about_us_text_color'];
    $about_us_background_color = $_POST['about_us_background_color'];

    $history_data_old = $db->query("SELECT `section_name`, 
    `section_content` from `page_sections` 
    WHERE `section_name` = 'about_us_section'");

    $about_us_section_data = [
        'displayed_about_section_name' => findXSS($displayed_about_section_name),
        'paragraph1' => findXSS($paragraph1),
        'paragraph2' => findXSS($paragraph2),
        'image_set' => findXSS($image_set),
        'about_us_image_type' => findXSS($about_us_image_type),
        'path_about_us_image' => ($path_about_us_image) ? findXSS($path_about_us_image) : NULL,
        'about_us_image_link' => ($about_us_image_link) ? findXSS($about_us_image_link) : NULL,
        'about_us_text_color' => findXSS($about_us_text_color),
        'about_us_background_color' => findXSS($about_us_background_color),
    ];

    $new_about_us_section_data = array_encode_json($about_us_section_data);

    $check_the_section = $db->query("SELECT count(*) as 'count' FROM `page_sections` WHERE `section_name` = 'about_us_section'");

    if($check_the_section[0]['count'] == 0) {
        $db->query("INSERT INTO `page_sections` (`section_name`, `section_content`) values (:section_name, :section_content)",[
            'section_name' => 'about_us_section',
            'section_content' => $new_about_us_section_data
        ]);
    } else {
        $db->query("UPDATE `page_sections` SET `section_content`= :section_content WHERE `section_name` = 'about_us_section'",[
            'section_content' => $new_about_us_section_data
        ]);
    }

    $history_data_new = $db->query("SELECT `section_name`, 
    `section_content` from `page_sections` 
    WHERE `section_name` = 'about_us_section'");

    $new_data = array_encode_json($history_data_new[0]);
    $old_data = array_encode_json($history_data_old[0]);

    add_history([
        'id_user' => get_unhashed_user_id(),
        'action_type' => 18,
        'last_value' => $old_data,
        'new_value' => $new_data,
        'additional_info' => NULL
    ]);
    

    echo build_success_block('About Us section data is saved');



}

?>