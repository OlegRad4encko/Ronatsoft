<?php

require_once('../handlers/check_session_part.php');
require_once('../handlers/findXSS.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(!isset($_POST['history_additional_info'])) {
        echo build_error_block('Unknown error');
        exit;
    }

    $history_data = $db->query("SELECT `action_type`, `last_value`, `new_value` from `history` WHERE SHA2(`id_action`, 256) = :id_action",[
        'id_action' => findXSS($_POST['history_additional_info'])
    ]);

    $additional_information = [
        'log in' => "logged in.",
        'edit_user' => "Edit user data: ",
        'add_user' => "Add new user: ",
        'delete_user' => "Delete user",
        'view_application' => "View application: ", 
        'solved_application' => "Make application solved: ", 
        'delete_application' => "Delete application: ",
        'add_social_link' => "Added social link: ", 
        'edit_social_link' => "Edit social link: ", 
        'delete_social_link' => "Delete social link: ",
        'add_feedback' => "Added new feedback: ", 
        'edit_feedback' => "Edit feedback: ", 
        'delete_feedback' => "Delete feedback: ",
        'add_project' => "Added new project: ", 
        'edit_project' => "Edit project: ", 
        'delete_project' => "Delete project: ",
        'edit_header_section' => "Edit the header section: ", 
        'edit_logo_section' => "Edit the logo section: ", 
        'edit_about_us_section' => "Edit the about us section: ",
        'edit_our_project_section' => "Edit the our project section: ",
        'edit_feedback_section' => "Edit the customers feedback section: ",
        'edit_footer_section' => "Edit the footer section: "
    ];

    ?>

<div class="add-edit-form">
        <div class="modal-content modal-history" id="edit_user">
            <div class="modal-header">
                <h1><?php echo $additional_information[$history_data[0]['action_type']] ?></h1>
                <i class="cross-form fa-regular fa-circle-xmark"></i>
            </div>
            <table>
                <?php    
                    $last_value = '';
                    $new_value = ''; 
                ?>
                <?php if($history_data[0]['last_value'] != '') {
                    $last_value = json_decode($history_data[0]['last_value'], true);
                }?>
                <?php if($history_data[0]['new_value'] != '') {
                    $new_value = json_decode($history_data[0]['new_value'], true);
                }?>

                <?php  
                    if($history_data[0]['last_value'] != '') {
                ?>
                    <tr>
                        <td><b>Old data:</b></td>
                    </tr>
                    <tr>
                        <td>
                            <?php 
                                foreach ($last_value as $key => $value) {
                                    echo "<i>$key</i> => $value\n <br>";
                                }
                            ?>
                        </td>
                    </tr>

                <?php } ?>

                <?php  
                    if($history_data[0]['new_value'] != '') {
                ?>
                    <tr>
                        <td><b>New data:</b></td>
                    </tr>
                    <tr>
                        <td>
                            <?php 
                                foreach ($new_value as $key => $value) {
                                    echo "<i>$key</i> => $value\n <br>";
                                }
                            ?>
                        </td>
                    </tr>

                <?php } ?>

            </table>
        </div>
    </div>

    <?php
    
} else {
    echo build_error_block('Unknown error');
    exit;
}

?>