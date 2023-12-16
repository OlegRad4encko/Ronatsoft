<?php

    require_once('../database/database.php');
    $db = new Database();

    session_start();
    $userhash = hash("sha256",hash("sha256",$_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']));
    
    # get styles
    function get_styles() {
        $styles = [
            '<link rel="stylesheet" href="../assets/css/admin_styles.css">',
            ''
        ];

        $result_string = '';
        for ($i = 0; $i < count($styles); $i ++) {
            $result_string = $result_string.$styles[$i];
        }

        return $result_string;
    }


    # get scripts 
    function get_scripts() {
        $scripts = [
            '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>',
            '<script src="https://kit.fontawesome.com/24baab97da.js" crossorigin="anonymous"></script>'
        ];

        $result_string = '';
        for ($i = 0; $i < count($scripts); $i ++) {
            $result_string = $result_string.$scripts[$i];
        }

        return $result_string;
    }


    function generate_CSRF_form_token() {
        return $_SESSION['csrf_token'] = substr( str_shuffle( 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM' ), 0, 10 );
    }

    function findXSS($param) {
        return htmlspecialchars($param,ENT_QUOTES);
    }
    
    function checkSession($sesname) {
        global $db;
        global $userhash;
      
        $us_id = $db->query("SELECT `id_user` FROM `sessions` where `session` like :sesname and user_hash like :userhash",
        [
          ':sesname' => $sesname,
          ':userhash' => $userhash
        ]);
      
        if(count($us_id) == 0) {
          return true;
        }
      
        $sql = $db->query("SELECT max(sessions.session)`ses` FROM `sessions` WHERE sessions.id_user = :id_user",[
          ':id_user' => $us_id[0]['id_user']
        ]);
        return !($sql[0]['ses'] == $sesname);
      }


?>