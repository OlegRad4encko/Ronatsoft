<?php
    require_once('functions.php');

    if(!isset($_SESSION['name']) || empty($_SESSION['name'])){
        header("Location: index.php?error=783");
        exit (0);
    }

    if(isset($_SESSION['name'])){
        if(checkSession()) {
          header("Location: index.php");
          exit (0);
      }
    } 

    $active_page = 'none';
    if (isset($_GET['page'])) {
        $active_page = $_GET['page'];
    }

?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Admin Panel</title>
        <?php echo get_styles(); ?>
    </head>
    <body>
        <div class="header outline">

            <div class="user-data">
                <h1><?php echo first_letter_to_appercase(get_user_role()); ?> | <?php echo get_user_name(); ?></h1>
            </div>

            <ul>
                <?php if (get_user_role() == "admin") { ?>
                <li><a href="?page=users" id="users" <?php echo ($active_page == 'users')? 'class="active-page"' : '' ?>>Users</a></li>
                <?php } ?>

                <li><a href="?page=edit_landing" id="edit_landing" <?php echo ($active_page == 'edit_landing')? 'class="active-page"' : '' ?>>Edit Landing</a></li>
                <li><a href="?page=applications" id="applications" <?php echo ($active_page == 'applications')? 'class="active-page"' : '' ?>>Applications</a></li>

                <?php if (get_user_role() == "admin") { ?>
                <li><a href="?page=history" id="history" <?php echo ($active_page == 'history')? 'class="active-page"' : '' ?>>History</a></li>
                <?php } ?>

                <li><a href="#" id="logout">Logout</a></li>
            </ul>

        </div>

        <div class="content outline" id="content">
                   
            <?php 
                
                switch($active_page) {
                    case 'users':
                        
                        echo get_all_users();
                        ?>
                        
                        <div class="controls controls-right">
                            <div>
                                <button type="button" name="add_user">Add User</button>
                            </div>
                        </div>
                        
                        <?php

                        break;

                    case 'edit_landing':
                        echo $active_page;
                        break;

                    case 'applications':
                        echo $active_page;
                        break;

                    case 'history':
                        echo $active_page;
                        break;

                    default:
                    ?>
                        <div class="temporary">Select a category to work with</div>
                    <?php
                        break;

                }

            ?>
        </div>

        <?php echo get_scripts() ?>
    </body>
</html>