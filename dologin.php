<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("lang/main.php");
include('library/sessions.php');

// set's the session max lifetime to 3600 seconds
ini_set('session.gc_maxlifetime', 3600);

dalo_session_start();
dalo_session_regenerate_id();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include('library/opendb.php');

    // Function to sanitize input data
    function sanitize_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $errorMessage = '';

    // validate location
    $location_name = (!empty($_POST['location'])) ? $_POST['location'] : "default";

    $_SESSION['location_name'] = (array_key_exists('CONFIG_LOCATIONS', $configValues)
        && is_array($configValues['CONFIG_LOCATIONS'])
        && count($configValues['CONFIG_LOCATIONS']) > 0
        && in_array($location_name, $configValues['CONFIG_LOCATIONS'])) ?
        $location_name : "default";

    $operator_user = isset($_POST["username"]) ? sanitize_input($_POST["username"]) : null;
    $operator_pass = isset($_POST["password"]) ? sanitize_input($_POST["password"]) : null;

    echo $operator_user;
    echo $operator_pass;
    $sqlFormat = "select * from %s where username='%s' and password='%s'";
    $sql = sprintf(
        $sqlFormat,
        $configValues['CONFIG_DB_TBL_DALOOPERATORS'],
        $operator_user,
        $operator_pass
    );
    $res = $dbSocket->query($sql);
    $numRows = $res->numRows();

    if ($numRows != 1) {
        $_SESSION['daloradius_logged_in'] = false;
        $_SESSION['operator_login_error'] = true;
        $response = array("status" => false, "message" => t('messages', 'loginerror'), "data" => array());
    } else {
        $row = $res->fetchRow(DB_FETCHMODE_ASSOC);
        $operator_id = $row['id'];
        $_SESSION['daloradius_logged_in'] = true;

        $_SESSION['operator_user'] = $operator_user;
        $_SESSION['operator_id'] = $operator_id;

        // lets update the lastlogin time for this operator
        $now = date("Y-m-d H:i:s");
        $sqlFormat = "update %s set lastlogin='%s' where username='%s'";
        $sql = sprintf(
            $sqlFormat,
            $configValues['CONFIG_DB_TBL_DALOOPERATORS'],
            $now,
            $operator_user
        );
        $res = $dbSocket->query($sql);
        $response = array("status" => "success", "message" => "Login successful!", "data" => array(['redirect' => ""]));

        // header('Location: admin.php');
    }

    // ~ close connection to db before redirecting
    include('library/closedb.php');
} else {
    $response = array("status" => false, "message" => "Supported Method is POST!", "data" => array());
    // header('Location: login.php');
}


// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
if ($response['status']) {
    if (array_key_exists('login_error', $_SESSION)) {
        unset($_SESSION['login_error']);
    }
    $_SESSION['logged_in'] = true;
    $_SESSION['message_danger'] = "";    
    header('Location: admin.php' );
} else {
    $_SESSION['logged_in'] = false;
    $_SESSION['login_error'] = true;
    $_SESSION['message_danger'] = $response['message'];
    header('Location: login.php');
    
}
