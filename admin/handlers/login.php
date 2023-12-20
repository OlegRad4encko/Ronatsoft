<?php
    require_once("../../database/database.php");
    require_once("findXSS.php");

    $db = new Database();
    session_start();

    if(isset( $_SESSION['csrf_token'] ) and $_SESSION['csrf_token'] == @$_POST['csrf_token']){
        if(isset($_POST['login']) and isset($_POST['password'])) {
            $sql = $db->query("select id_user from `administration` where user_login = :user_login and password_hashed = :password_hashed",[
                ':user_login' => findXSS($_POST['login']),
                ':password_hashed' => hash("sha256",hash("sha256",$_POST['password']))
              ]);
        }
        if(count($sql) == 0) {
            // echo 'Не правильное имя или пароль!';
            echo hash("sha256",hash("sha256", 'admin'));
        }
        if(count($sql) > 1) {
            echo 'Неизвесная ошибка!';
        }
        if(count($sql) == 1) {
            $_SESSION['name'] = time();
            $sessionTime = $_SESSION['name'];
            $userhash = hash("sha256",hash("sha256",$_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']));
            $sqlhash = $db->query("insert into `sessions`(`id_user`,`session`,`user_hash`,`create_time`)
                values(:id_user,:session,:user_hash,NOW())",[
                    ':id_user' => $sql[0]['id_user'],
                    ':session' => $sessionTime,
                    ':user_hash' => $userhash
                ]);

            echo "<script>document.location.href=\"home.php\"</script>";
        }
    }
?>