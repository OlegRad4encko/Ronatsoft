<?php

    require_once("database/database.php");
    $db = new Database();


    function get_styles() {
        $styles = [
            '<link rel="stylesheet" href="assets/css/outline-main.css">'
        ];

        return $styles;
    }


    function get_scripts() {
        $scripts = [
            '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>'
        ]

        return $scripts;
    }

?>