<?php 

require_once("check_session_part.php");
require_once('findXSS.php');

if (!isset( $_SESSION['csrf_token'] ) or $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
{
    echo build_error_block('Token error');
    exit;
}

if (!isset($_POST['id_link'])) {
    echo build_error_block('Submission error');
    exit;
}

$check_id = $db->query("SELECT count(*) as 'count' from `social_links` where SHA2(`id_link`, 256) = :id_link",[
    'id_link' => findXSS($_POST['id_link'])
]);

if($check_id[0]['count'] == 0) {
    echo build_error_block('Submission error');
    exit;
}

$get_old_value = $db->query("SELECT `link_label` as 'label', `link_icon_class` as 'icon', `link_url` as 'link' from `social_links` where SHA2(`id_link`, 256) = :id_link", [
    'id_link' => findXSS($_POST['id_link'])
 ]);

$delete_link = $db->query("DELETE FROM `social_links` where SHA2(`id_link`, 256) = :id_link", [
    'id_link' => findXSS($_POST['id_link'])
]);

add_history([
    'id_user' => get_unhashed_user_id(),
    'action_type' => 9,
    'last_value' => array_encode_json($get_old_value[0]),
    'new_value' => NULL,
    'additional_info' => NULL
]);

echo 'success';

?>