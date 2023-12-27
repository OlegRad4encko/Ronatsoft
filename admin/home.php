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

    $count_new_applications = get_new_applications_count();
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
            <div class="inline">
                <button id="menu-toggle" class="menu-toggle"><i class="fa-solid fa-bars"></i></button>

                <ul class="nav">
                    <?php if (get_user_role() == "admin") { ?>
                    <li>
                        <a href="?page=users" id="users" <?php echo ($active_page == 'users')? 'class="active-page"' : '' ?>>Users</a>
                    </li>
                    <?php } ?>

                    <li>
                        <a href="?page=edit_landing" id="edit_landing" <?php echo ($active_page == 'edit_landing')? 'class="active-page"' : '' ?>>Edit Landing</a>
                    </li>
                    <li>
                        <a href="?page=applications" id="applications" <?php echo ($active_page == 'applications')? 'class="active-page"' : '' ?>>Applications <?php echo ($count_new_applications > 0)? '<i class="fa-solid fa-envelope"></i>'.$count_new_applications : ''?></a>
                    </li>

                    <?php if (get_user_role() == "admin") { ?>
                    <li><a href="?page=history" id="history" <?php echo ($active_page == 'history')? 'class="active-page"' : '' ?>>History</a></li>
                    <?php } ?>

                    <li><a href="#" id="logout">Logout</a></li>
                </ul>
            </div>
            

        </div>

        <div class="content outline" id="content">
                   
            <?php 
                
                switch($active_page) {
                    case 'users':
                        
                        echo get_users_table();
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
                        $entries_on_page = 10;
                        $new_applications = false;
                        $page_num = 1;

                        if(isset($_GET['entries_on_page'])) 
                        {
                            $entries_on_page = $_GET['entries_on_page'];
                        }
                        if(isset($_GET['new_applications']))
                        {
                            $new_applications = $_GET['new_applications'];
                        }


                        ?> 
                            <div class="applications">
                                <form class="filter">
                                    <input type="hidden" name="page" value="applications">
                                    <div>
                                        <div>
                                            <label for="entries_on_page">Entries on page: </label>
                                            <select name="entries_on_page" id="entries_on_page">
                                                <option value="10" <?php echo ($entries_on_page == 10) ? 'selected' : '' ?>>10</option>
                                                <option value="25" <?php echo ($entries_on_page == 25) ? 'selected' : '' ?>>25</option>
                                                <option value="50" <?php echo ($entries_on_page == 50) ? 'selected' : '' ?>>50</option>
                                            </select>
                                        </div>
                                        

                                        <div>
                                            <label for="new">Only new application</label>
                                            <input type="checkbox" id="new" name="new_applications" value="true" <?php echo ($new_applications) ? 'checked' : '' ?>>
                                        </div>
                                        
                                    </div>

                                    <button type="submit">Apply</button>
                                </form>

                                
                            <?php

                            if(isset($_GET['page_num'])) {
                                $page_num = $_GET['page_num'];
                            }

                            
                            echo get_application($entries_on_page, $new_applications, $page_num, $entries_on_page);
                            
                            ?>
                        
                            </div>
                        <?php


                        
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