<?php
if ($_SERVER['argc'] > 1) :
    $path = $_SERVER['argv'][1];
    $db_name = $_SERVER['argv'][2];
    $db_user = $_SERVER['argv'][3];
    $db_pass = $_SERVER['argv'][4];
    try {
        $dbh = new PDO("mysql:host=localhost", $db_user, $db_pass);

        $dbh->exec("CREATE DATABASE `$db_name`;
                GRANT ALL PRIVILEGES ON `$db_name`.* TO '$db_user'@'localhost';
                FLUSH PRIVILEGES;") 
        or die(print_r($dbh->errorInfo(), true));

    } catch (PDOException $e) {
        die("DB ERROR: ". $e->getMessage());
    }
    $_POST['dbname'] = $db_name;
    $_POST['uname'] = $db_user;
    $_POST['pwd'] = $db_pass;
    $_POST['dbhost'] = 'localhost';
    $_POST['prefix'] = 'wp';
    $_GET['step'] = 2;
    $site_title = 'SiteTitle';
    $user_name = 'admin';
    $admin_pass = 'B00st3r!';
    $email = 'jcox@boostability.com';
    include $path . '/wp-admin/setup-config.php';
    exec("curl --data weblog_title=$site_title&user_name=$user_name&admin_password=$admin_pass&admin_password2=$admin_pass&admin_email=$email&blog_public=0 http://localhost/$path/wp-admin/install.php?step=2");
else :
    echo 'Arguments are: path, db_name, db_user, and db_pass';
endif;
?>
