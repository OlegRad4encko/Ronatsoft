<?php 

require_once("check_session_part.php");
require_once('findXSS.php');


if (!isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] != @$_POST['csrf_token']) 
{
    echo build_error_block('Token error');
    exit;
}

if (!isset($_POST['label']) and !isset($_POST['icon']) and !isset($_POST['link'])) {
    echo build_error_block('Form submission error');
    exit;
}

if (empty(trim($_POST['label'])) or empty(trim($_POST['icon'])) or empty(trim($_POST['link']))) 
{
    echo build_error_block('Please fill in all required fields.');
    exit;
}


$add_social = $db->query("INSERT INTO `social_links` (`link_label`, `link_icon_class`, `link_url`)
    VALUES (:label, :icon, :link)",[
        'label' => findXSS($_POST['label']),
        'icon' => findXSS($_POST['icon']),
        'link' => findXSS($_POST['link'])
    ]);

$last_link_id = $db->query("SELECT SHA2(`id_link`, 256) as 'id_link' 
from `social_links` where 
`id_link` = (select max(`id_link`) as 'id_link' from `social_links` where 1)");

$finish_data = [
    'hached_id' => $last_link_id[0]['id_link'],
    'label' => findXSS($_POST['label']),
    'icon' => findXSS($_POST['icon']),
    'link' => findXSS($_POST['link']),
    'csrf_token' => $_POST['csrf_token']
];

$history_data = [
    'label' => findXSS($_POST['label']),
    'icon' => findXSS($_POST['icon']),
    'link' => findXSS($_POST['link'])
];

add_history([
    'id_user' => get_unhashed_user_id(),
    'action_type' => 7,
    'last_value' => NULL,
    'new_value' => array_encode_json($history_data),
    'additional_info' => NULL
]);

echo array_encode_json($finish_data);


?>