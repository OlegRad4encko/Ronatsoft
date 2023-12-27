<?php

    require_once('../database/database.php');
    $db = new Database();

    session_start();
    $userhash = hash("sha256",hash("sha256",$_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']));
    




    function take_first_char_from_str($str) {
        return mb_substr($str, 0, 1, 'UTF-8');
    }




    function to_apper_case($str) {
        return mb_strtoupper($str, 'UTF-8');
    }




    function first_letter_to_appercase($str) {
        return ucfirst($str);
    }




    # get styles
    function get_styles() {
        $styles = [
            '<link rel="stylesheet" href="css/admin_styles.css">',
            '<link rel="stylesheet" href="css/add-edit-forms.css">',
            '<link rel="stylesheet" href="css/popaps.css">',
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
            '<script src="https://kit.fontawesome.com/24baab97da.js" crossorigin="anonymous"></script>',
            '<script src="js/edit_delete_user.js" crossorigin="anonymous"></script>',
            '<script src="js/add_user.js" crossorigin="anonymous"></script>',
            ''
        ];

        $result_string = '';
        for ($i = 0; $i < count($scripts); $i ++) {
            $result_string = $result_string.$scripts[$i];
        }

        return $result_string;
    }




    # genera CSRF token 
    function generate_CSRF_form_token() {
        return $_SESSION['csrf_token'] = substr( str_shuffle( 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM' ), 0, 10 );
    }



    
    # check XSS
    function findXSS($param) {
        return htmlspecialchars($param,ENT_QUOTES);
    }
    



    # check active session
    function checkSession() {
        global $db;
        global $userhash;

        $sesname = $_SESSION['name'];
      
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

    



    # get the user role
    function get_user_role() {
        global $db;
        global $userhash;

        $session_name = $_SESSION['name'];

        $result = $db->query("SELECT user_role FROM `administration` WHERE id_user = (select `id_user` FROM `sessions` where `session` like :session_name and user_hash like :userhash)",
        [
          ':session_name' => $session_name,
          ':userhash' => $userhash
        ]);

        $user_role = $result[0]['user_role'];

        return $user_role;
    }




    # get user name 
    function get_user_name() {
        global $db;
        global $userhash;

        $session_name = $_SESSION['name'];
        
        $result = $db->query("SELECT `first_name`, 
            `second_name`, 
            `patronymic` 
            FROM `administrator_names` 
            WHERE `id_name` = (select `id_name` 
                FROM `administration` 
                WHERE `id_user` = (select `id_user` 
                    FROM `sessions` 
                    where `session` 
                    like :session_name and `user_hash` like :userhash))",
        [
          ':session_name' => $session_name,
          ':userhash' => $userhash
        ]);



        $adm_name = $result[0]['first_name'];
        $adm_surname = $result[0]['second_name'];
        $adm_patronymic = $result[0]['patronymic'];

        if (!empty($adm_surname) && !empty($adm_patronymic)) {
            $rez_adm_surname = to_apper_case(take_first_char_from_str($adm_surname));
            $rez_adm_patronymic = to_apper_case(take_first_char_from_str($adm_patronymic));

            return $adm_name.' '.$rez_adm_surname.'. '.$rez_adm_patronymic.'.';
        }

        return $adm_name;
    }




    function get_users_table() {
        global $db;
        global $userhash;

        $sesname = $_SESSION['name'];
      
        $get_current_user_id = $db->query("SELECT `id_user` FROM `sessions` where `session` like :sesname and user_hash like :userhash",
        [
          ':sesname' => $sesname,
          ':userhash' => $userhash
        ]);

        $get_all_users_query = $db->query("
            SELECT 
                SHA2(`id_user`, 256) as 'user_id',
                `administrator_names`.`first_name`, 
                `administrator_names`.`second_name`, 
                `administrator_names`.`patronymic`, 
                `administration`.`user_role`,
                `administration`.`user_login`
            FROM `administrator_names` INNER JOIN `administration` ON
                `administrator_names`.`id_name` = `administration`.`id_name`
        ", []);

        $user_id_hashed = hash("sha256", $get_current_user_id[0]['id_user']);

        if (count($get_all_users_query) == 0) {
            return '<div class="error-onpage">Somesing went wrong</div>';
        }
        
        $users_table = '<table class="data-table">';
        $users_table .= '<tr>';
        $users_table .= '<th>First Name</th>';
        $users_table .= '<th class="hide">Second Name</th>';
        $users_table .= '<th class="hide">Patronymic</th>';
        $users_table .= '<th>User Role</th>';
        $users_table .= '<th>Login</th>';
        $users_table .= '<th>Edit User</th>';
        $users_table .= '</tr>';
        
        
        for ($iterator = 0; $iterator < count($get_all_users_query); $iterator ++) {
            $users_table .= '<tr>';

            if ($get_all_users_query[$iterator]['user_id'] == $user_id_hashed) {
                $users_table .= '<td>'.$get_all_users_query[$iterator]['first_name'].'<span> (YOU)</span></td>';
            } else {
                $users_table .= '<td>'.$get_all_users_query[$iterator]['first_name'].'</td>';
            }
                

            $users_table .= '<td class="hide">'.$get_all_users_query[$iterator]['second_name'].'</td>';
            $users_table .= '<td class="hide">'.$get_all_users_query[$iterator]['patronymic'].'</td>';
            $users_table .= '<td>'.$get_all_users_query[$iterator]['user_role'].'</td>';
            $users_table .= '<td>'.$get_all_users_query[$iterator]['user_login'].'</td>';
            $users_table .= '<td><button name="edit_user" value="'.$get_all_users_query[$iterator]['user_id'].'"><i class="fa-solid fa-user-pen"></i></td>';
            $users_table .= '</tr>';
        }
        $users_table .= '</table>';

        return $users_table; 
    }




    function get_application($entries_on_page, $only_new, $page, $limit) 
    {
        
        global $db;

        $count_of_applications = get_applications_count();

        $application_table = '';
        $applications;

        $offset = (intval($page) - 1) * $limit;


        if($only_new) 
        {
            $applications = $db->query("SELECT SHA2(`id_application`, 256) as 'id_application', 
            `application_state`, `app_user_mail`, `app_user_first_name`, `id_user` FROM `applications` where `application_state` = 'new' LIMIT ".intval($limit)." OFFSET ".intval($offset));
        } else 
        {
            $applications = $db->query("SELECT SHA2(`id_application`, 256) as 'id_application', 
            `application_state`, `app_user_mail`, `app_user_first_name`, `id_user` FROM `applications` where 1=1 LIMIT ".intval($limit)." OFFSET ".intval($offset));
        }    
        

        if (count($applications) == 0) {
            return "<div>Empty applications list</div>";
        }

        
        $application_table .= '<table class="data-table">';


        $application_table .= '<tr>';
        $application_table .= '<th>User Email</th>';
        $application_table .= '<th class="hide">User Name</th>';
        $application_table .= '<th class="hide">State</th>';
        $application_table .= '<th>View Application</th>';
        $application_table .= '</tr>';


        for ($iterator = 0; $iterator < count($applications); $iterator ++) {
            $user_role = '';
            $user_full_name = '';
            $user_short_name = '';

            if ($applications[$iterator]['application_state'] != 'new') 
            {
                $users_data = $db->query("SELECT 
                concat(`administrator_names`.`second_name`, ' ', 
                `administrator_names`.`first_name`, ' ', 
                `administrator_names`.`patronymic`) as 'user_full_name', 
                concat(`administrator_names`.`second_name`, ' ', 
                SUBSTRING(`administrator_names`.`first_name`, 1, 1), '. ', 
                SUBSTRING(`administrator_names`.`patronymic`, 1, 1), '.') as 'user_short_name', 
                `administration`.`user_role` 
                FROM `administration` join `administrator_names` on administration.id_name = administrator_names.id_name 
                where administration.id_user = :id_user", 
                [
                    'id_user' => $applications[$iterator]['id_user']
                ]);

                $user_role = $users_data[0]['user_role'];
                $user_full_name = $users_data[0]['user_full_name'];
                $user_short_name = $users_data[0]['user_short_name'];
            } else 
            {
                $user_role = '';
                $user_full_name = '';
                $user_short_name = '';
            }
            


            $application_table .= '<tr>';
            $application_table .= '<td>'.$applications[$iterator]['app_user_mail'].'</td>';
            $application_table .= '<td class="hide">'.$applications[$iterator]['app_user_first_name'].'</td>';

            if ($applications[$iterator]['application_state'] == 'new') {
                $application_table .= '<td class="hide">'.$applications[$iterator]['application_state'].'</td>';
            } else {
                $application_table .= '<td class="hide">'.$applications[$iterator]['application_state'].' <span>by <a class="tooltip">'.$user_short_name.'</a></span></td>';
            }
            

            $application_table .= '<td><button name="application_id" value="'.$applications[$iterator]['id_application'].'"><i class="fa-solid fa-book-open"></i></td>';
            $application_table .= '</tr>';
        }
        

        $application_table .= '</table>';


        if($only_new) {
            $application_table .= get_appl_pagination(get_new_applications_count(), $page, $limit, $only_new);
        } else {
            $application_table .= get_appl_pagination(get_applications_count(), $page, $limit, $only_new);
        }
        


        return $application_table;


    }


    function get_new_applications_count() 
    {
        global $db;
        $appl_count = $db->query("SELECT count(*) as 'count' from `applications` where `application_state` = 'new'");
        return $appl_count[0]['count'];
    }

    function get_applications_count() 
    {
        global $db;
        $appl_count = $db->query("SELECT count(*) as 'count' from `applications` where 1=1");
        return $appl_count[0]['count'];
    }

    function get_appl_pagination($items_count, $page, $items_per_page, $only_new) {
        $pagination_block = '<div class="pagination">';
        for ($i = 0; $i<($items_count / $items_per_page); $i ++) {
            $page_number = $i+1;
            $pagination_block .= '<a href="?page=applications&entries_on_page='.$items_per_page.'&new_applications='.$only_new.'&page_num='.$page_number.'">'.$page_number.'</a>';
        }
        $pagination_block .= '</div>';

        return $pagination_block;
    }

    

?>