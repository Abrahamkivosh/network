<?php

include_once("library/sessions.php");
dalo_session_start();

if (array_key_exists('daloradius_logged_in', $_SESSION)
    && $_SESSION['daloradius_logged_in'] !== false) {
    header('Location: admin.php');
    exit;
}

include("lang/main.php");



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/adminLogin.css">
    <title>Login - <?php echo $configValues['SYSTEM_NAME'] ?>- ISP ?></title>
    <?php 
    $message = isset($_GET['message']) ?  $_GET['message'] : null  ;
    ?>
</head>
<body>
    <div class="container">
        <form class="login-form" action="dologin.php" id="login_form" method="post" >
            <h2>ADMIN LOGIN</h2>
            <?php  if ( !is_null($message)){   ?>
            <div class="alert" id="loginAlert">
                <div class="message">
                    <?php echo $message; ?>
                </div>
                <button type="button" class="close-btn"  >×</button>
            </div>
            <?php } ?>
            
            <label for="username">Username:</label>
            <input type="text"  id="username" name="username" autocomplete="username" autofocus  placeholder="User Name" type="text" tabindex="1" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" autocomplete="current-password"   placeholder="Password" type="password" tabindex="2" required>
            
            <button id="submitButton" type="submit"><?= t('text','LoginPlease') ?></button>
        </form>
    </div>
    <script src="./js/adminLogin.js"></script>
</body>
</html>
