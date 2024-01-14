<?php

    require_once("database/database.php");
    $db = new Database();

    session_start();


    function get_styles() {
        $styles = [
            '<link rel="stylesheet" href="assets/css/outline-main.css">'
        ];

        $result_styles = '';
        for ($i = 0; $i < count($styles); $i ++) {
            $result_styles = $result_styles.$styles[$i];
        }

        return $result_styles;
    }


    function get_scripts() {
        $scripts = [
            '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>',
            '<script src="https://kit.fontawesome.com/24baab97da.js" crossorigin="anonymous"></script>',
            '<script src="assets/js/client_application.js"></script>'

        ];

        $result_scripts = '';
        for ($i = 0; $i < count($scripts); $i ++) {
            $result_scripts = $result_scripts.$scripts[$i];
        }

        return $result_scripts;
    }


    # check XSS
    function findXSS($param) {
        return htmlspecialchars($param,ENT_QUOTES);
    }

    
    # genera CSRF token 
    function generate_CSRF_form_token() {
        return $_SESSION['csrf_token'] = substr( str_shuffle( 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM' ), 0, 10 );
    }

    function build_form_info_block($text, $type) {
        if ($type == 'error') 
        {
            return '<div class="form-error"><p>'.$text.'</p><i class="cross-popup fa-regular fa-circle-xmark"></i></div>';
        }

        if ($type == 'success') 
        {
            return '<div class="form-success"><p>'.$text.'</p><i class="cross-popup fa-regular fa-circle-xmark"></i></div>';
        }
    }


    # get_header_custom_data
    function get_section_custom_data($section) {
        if(empty($section)) {
            return 0;
        }

        global $db;
        
        $section_data = $db->query("SELECT `section_content` from `page_sections` where `section_name` = :section_name",[
            'section_name' => $section
        ]);
        return json_decode($section_data[0]['section_content'], true);
    } 

    function get_link_data($id) {
        global $db;
        $link_data = $db->query("SELECT `link_icon_class`, `link_url` from `social_links` where SHA2(`id_link`, 256) = :id",[
            'id' => $id
        ]);
        return $link_data[0];
    }

    function get_projects($blocks) {
        global $db;

        $check_count_of_project = $db->query("SELECT COUNT(*) as 'count' from `our_projects` where 1");


        $projects = '';
        $project_block = '';


        if($check_count_of_project[0]['count'] <= $blocks) {
            $projects = $db->query("SELECT * from `our_projects` where 1");
        } else {
            $projects = $db->query("SELECT * from `our_projects` where 1 order by rand() limit ".findXSS($blocks), []);
        }

        for ($prjct=0; $prjct < count($projects); $prjct++) { 
            $project_block .= '<a class="element" href="'.$projects[$prjct]['project_link'].'"  target="_blank">';
            if($projects[$prjct]['project_image'] == '') {
                $project_block .= $projects[$prjct]['project_text'];
            } else {
                $project_block .= '<img src="'.$projects[$prjct]['project_image'].'">';
            }
            $project_block .= '</a>';
        }

        return $project_block;
    }

    function get_feedback($blocks, $text_color, $background) {
        global $db;

        $check_count_of_feedbacks = $db->query("SELECT COUNT(*) as 'count' from `feedbacks` where 1");

        $feedbacks = '';
        $feedback_block = '';

        if($check_count_of_feedbacks[0]['count'] <= $blocks) {
            $feedbacks = $db->query("SELECT * from `feedbacks` where 1");
        } else {
            $feedbacks = $db->query("SELECT * from `feedbacks` where 1 order by rand() limit ".findXSS($blocks), []);
        }

        for ($feed=0; $feed < count($feedbacks); $feed++) { 
            $feedback_block .= '<div class="feedback">';
            $feedback_block .= '<style>.client-info::after {background-color: '.$background.'}</style>';
            $feedback_block .= '<div class="client-info">';
            $feedback_block .= '<div class="client-image" style="color: '.$background.'; background-color: '.$background.'">';
            if($feedbacks[$feed]['image_name']) {
                $feedback_block .= '<img src="site-images/feedback_users_images/'.$feedbacks[$feed]['image_name'].'" alt="">';        
            } else {

                $feedback_block .= '<i class="fa-solid fa-user" style="color: '.$text_color.'"></i>';
            }
            $feedback_block .= '</div>';
            $feedback_block .= '<div class="client-name-position">';
            $feedback_block .= '<span style="color: '.$background.'">'. $feedbacks[$feed]['user_first_name'] .' '. $feedbacks[$feed]['user_second_name'] .'</span>';
            $feedback_block .= '<span style="color: '.$background.'">'. (($feedbacks[$feed]['user_type'] == 'new') ? 'New customer' : 'Regular customer') .'</span>';
            $feedback_block .= '<span style="color: '.$background.'">'.$feedbacks[$feed]['publish_date'].'</span>';
            $feedback_block .= '</div>';
            $feedback_block .= '</div>';
            $feedback_block .= '<div class="client-text" style="color: '.$text_color.'; background-color: '.$background.'">';
            $feedback_block .= $feedbacks[$feed]['users_text'];
            $feedback_block .= '</div>';
            $feedback_block .= '</div>';
        }
        return $feedback_block;
    }

?>