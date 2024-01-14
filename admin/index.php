<?php 

    require_once('functions.php');
    require_once("../database/database.php");

    if(isset($_SESSION['name'])){
        if(!checkSession()) {
          header("Location: home.php");
          exit (0);
        }
      }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Log in</title>
        <link rel="stylesheet" href="css/admin_login.css">
        <link rel="stylesheet" href="css/popaps.css">
    </head>
    <body>
        <?php // echo hash("sha256",hash("sha256", 'admin1')) ?>
        <form class="login" id="login" method="POST" action="">
            <input name="csrf_token" type="hidden" value="<?php echo generate_CSRF_form_token() ?>">
            <input name="login" type="text" placeholder="Login">
            <input name="password" type="password" placeholder="Password">
            <input type="submit" value="Log In">
        </form>

        <?php echo get_scripts() ?>
        <script src="js/login.js"></script>
    </body>
</html>