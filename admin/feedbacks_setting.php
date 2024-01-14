<?php
    require_once('functions.php');

    if(!isset($_SESSION['name']) || empty($_SESSION['name'])){
        header("Location: index.php");
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
    $CSFR_token = $_SESSION['csrf_token'];

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
                        <a href="home.php?page=users" id="users" <?php echo ($active_page == 'users')? 'class="active-page"' : '' ?>>Users</a>
                    </li>
                    <?php } ?>

                    <li>
                        <a href="home.php?page=edit_landing" id="edit_landing" <?php echo ($active_page == 'edit_landing')? 'class="active-page"' : '' ?>>Edit Landing</a>
                    </li>
                    <li>
                        <a href="home.php?page=applications" id="applications" <?php echo ($active_page == 'applications')? 'class="active-page"' : '' ?>>Applications <?php echo ($count_new_applications > 0)? '<i class="fa-solid fa-envelope"></i>'.$count_new_applications : ''?></a>
                    </li>

                    <?php if (get_user_role() == "admin") { ?>
                    <li><a href="home.php?page=history" id="history" <?php echo ($active_page == 'history')? 'class="active-page"' : '' ?>>History</a></li>
                    <?php } ?>

                    <li><a href="home.php?page=logout" id="logout">Logout</a></li>
                </ul>
            </div>
            

        </div>

        <div class="content outline" id="content">
            <?php echo get_feedback_table(); ?>
            <div class="controls controls-right">
                <div>
                    <button type="button" name="add_feedback">Add Feedback</button>
                </div>
            </div>
        </div>

<?php echo get_feedback_scripts(); ?>
</body>
</html>