<?php 

require_once("../../database/database.php");
$db = new Database();
$userhash = hash("sha256",hash("sha256",$_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']."^&&*gdj3458f';fjs"));
session_start();

function generate_form_token() {
    return $_SESSION['csrf_token'] = substr( str_shuffle( 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM' ), 0, 10 );
}

function checkSession() {
    global $db;
    global $userhash;

    $sesname = $_SESSION['name'];

    $sql = $db->query("SELECT max(create_time) as `create_time` from sessions where `session` like :sesname and user_hash like :userhash",[
      ':sesname' => $sesname,
      ':userhash' => $userhash
    ]);
    return !($sql[0]['create_time'] == null);
}

function current_user() {
    global $db;

    $sesname = $_SESSION['name'];

    $sql = $db->query("SELECT SHA2(`id_user`, 256) as 'user_id' from sessions where `session` like :sesname",[
        ':sesname' => $sesname,
    ]);

    return $sql[0]['user_id'];
}

function add_history($param) {
    exit;
}

function build_error_block($text) {
    return '<div class="popup-error"><div class="inline"><h2>Error</h2><i class="cross-popup fa-regular fa-circle-xmark"></i></div><p>'.$text.'</p></div>';
}



?>