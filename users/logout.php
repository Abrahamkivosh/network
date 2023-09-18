<?php


include('library/sessions.php');
dalo_session_start();
dalo_session_destroy();
$loginPath = dirname($_SERVER['PHP_SELF']) . '/login.php';
header('Location: ' . $loginPath);

?>
