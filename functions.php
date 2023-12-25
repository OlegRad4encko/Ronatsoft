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
            '<script src="assets/js/client_application.js"></script>',
            '<script src="assets/js/toggle-menu.js"></script>',

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


?>