<?php
// open errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$log = "visited page: ";
$logQuery = "performed query for active accounting records on page: ";

if (! defined('CHECKLOGIN_INCLUDED')) {
    include_once ("library/checklogin.php");
    define('CHECKLOGIN_INCLUDED', true);
}

if (!defined('CONFIG_INCLUDED')) {
    include_once('library/config_read.php');
    define('CONFIG_INCLUDED', true);
}


if (!defined("LOGGING_INCLUDED")) {
    include_once ("include/config/logging.php");
    define('LOGGING_INCLUDED', true);
}


if  (!defined('MAIN_INCLUDED')) {
    include_once ("lang/main.php");
    define('MAIN_INCLUDED', true);
}

if (!defined('OPENDB_INCLUDED')) {
    include_once '../library/opendb.php';
    define('OPENDB_INCLUDED', true);
}

if (!defined('USER_INCLUDED')) {
    include_once ("../library/user.php");
    define('USER_INCLUDED', true);
}
$login = $_SESSION['login_user'];




// create user instance
$user = new User($dbSocket, $configValues);

$user->setUserInstance($login);