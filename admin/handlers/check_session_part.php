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





function add_history($history_array_data) {
    global $db;

    $action_type = [
        'log in',
        'edit_user','add_user','delete_user',
        'view_application', 'solved_application', 'delete_application'
    ];

    $add_history = $db->query("INSERT INTO `history`(
        `id_user`, 
        `action_type`, 
        `last_value`, 
        `new_value`, 
        `additional_info`, 
        `timestamp`) 
        VALUES (
        :id_user,
        :action_type,
        :last_value,
        :new_value,
        :additional_info,
        now())",[
            'id_user' => $history_array_data['id_user'],
            'action_type' => $action_type[$history_array_data['action_type']],
            'last_value' => $history_array_data['last_value'],
            'new_value' => $history_array_data['new_value'],
            'additional_info' => $history_array_data['additional_info']
        ]);
}





function build_error_block($text) {
    return '<div class="popup-error"><div class="inline"><h2>Error</h2><i class="cross-popup fa-regular fa-circle-xmark"></i></div><p>'.$text.'</p></div>';
}

function build_success_block($text) {
    return '<div class="popup-success"><div class="inline"><h2>Success</h2><i class="cross-popup fa-regular fa-circle-xmark"></i></div><p>'.$text.'</p></div>';
}

function check_application_id($application_id) {
    global $db;

    $check_appl_id_query = $db->query("SELECT count(*) as 'count' from `applications` where SHA2(`id_application`, 256) = :application_id",
    [
        'application_id' => $application_id
    ]);

    return ($check_appl_id_query[0]['count'] > 0) ? true : false;
}


function get_unhashed_user_id() {
    global $db;

    $sesname = $_SESSION['name'];

    $sql = $db->query("SELECT `id_user` from sessions where `session` like :sesname",[
        ':sesname' => $sesname,
    ]);

    return $sql[0]['id_user'];
}


function array_encode_json($array) {
    return json_encode($array);
}







?>