<?php 

require_once("check_session_part.php");
require_once('findXSS.php');

if (isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] == @$_POST['csrf_token']) 
{
    if (isset($_POST['id_user'])) 
    {

        $checking_for_availability = $db->query("SELECT count(*) as `count` FROM `administration`
        WHERE SHA2(`id_user`, 256) = :id_user", [
            ':id_user' => findXSS($_POST['id_user'])
        ]);

        if ($checking_for_availability[0]['count'] == 1) 
        {
            if(current_user() != $_POST['id_user']) 
            {
                $user_id_name = $db->query("SELECT `id_name` FROM `administration`
                WHERE SHA2(`id_user`, 256) = :id_user", [
                    'id_user' => findXSS($_POST['id_user'])
                ]);

                $delete_user_name = $db->query("DELETE FROM `administrator_names` 
                WHERE `id_name` = :id_name", [
                    'id_name' => findXSS($user_id_name[0]['id_name'])
                ]);

                $delete_user = $db->query("DELETE FROM `administration` 
                WHERE SHA2(`id_user`, 256) = :id_user", [
                    'id_user' => findXSS($_POST['id_user'])
                ]);

                echo "success";

                exit;
            } else 
            {
                echo '<div class="popup-error"><div class="inline"><h2>Error</h2><i class="cross-popup fa-regular fa-circle-xmark"></i></div><p>You can`t delete yourself!</p></div>';
                exit; 
            }
        } else 
        {
            echo '<div class="popup-error"><div class="inline"><h2>Error</h2><i class="cross-popup fa-regular fa-circle-xmark"></i></div><p>Update page and try delete user again.</p></div>';
            exit;
        }

    } else 
    {
        echo '<div class="popup-error"><div class="inline"><h2>Error</h2><i class="cross-popup fa-regular fa-circle-xmark"></i></div><p>Form submission error</p></div>';
        exit;
    }
} else 
{
    echo '<div class="popup-error"><div class="inline"><h2>Error</h2><i class="cross-popup fa-regular fa-circle-xmark"></i></div><p>Form submission error</p></div>';
    exit;
}
?>