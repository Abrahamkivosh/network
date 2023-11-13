<!DOCTYPE html>
<html lang="en">
  <head>
  <title>
   My Profile
  </title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="./css/style.css" />
   
<?php
include_once "./authCheck.php";

$userInfo =(object) $user->getUserInfo() ;


isset($_POST['firstname']) ? $firstname = $_POST['firstname'] : $firstname = "";
isset($_POST['lastname']) ? $lastname = $_POST['lastname'] : $lastname = "";

isset($_POST['email']) ? $email = $_POST['email'] : $email = "";
isset($_POST['workphone']) ? $workphone = $_POST['workphone'] : $workphone = "";
isset($_POST['mobilephone']) ? $mobilephone = $_POST['mobilephone'] : $mobilephone = "";
isset($_POST['company']) ? $company = $_POST['company'] : $company = "";
isset($_POST['city']) ? $city = $_POST['city'] : $city = "";
isset($_POST['state']) ? $state = $_POST['state'] : $state = "";

isset($_POST['currentpassword']) ? $currentpassword = $_POST['currentpassword'] : $currentpassword = "";
isset($_POST['newpassword']) ? $newpassword = $_POST['newpassword'] : $newpassword = "";
isset($_POST['confirmpassword']) ? $confirmpassword = $_POST['confirmpassword'] : $confirmpassword = "";

// isset($_POST['submit']) ? $submit = $_POST['submit'] : $submit = "";




if (isset( $_POST['firstname']))
{
    include "./actions/updateProfile.php";
   
    include_once "../library/opendb.php";

    $response = updateProfileAndPassword($dbSocket, $user, $firstname, $lastname, $email, $workphone, $mobilephone, $company, $city, $state, $currentpassword, $newpassword, $confirmpassword);

    $response = json_decode($response);

    if ($response->status == true) {
        $_SESSION['message_success'] =  $response->message;
    }else {
        $_SESSION['errors'] =  $response->data ;
    }
   
}


?>

  </head>
  <body>
    <!-- top navigation bar -->
    <?php
      include_once "./includes/top_navbar.php";

    ?>
  
    <!-- top navigation bar -->
    <!-- offcanvas -->
    <?php
      include_once "./includes/offcanvasAside.php";
      ?>
    <!-- offcanvas -->
    <main class="mt-5 pt-3">

    <?php
      include "./pages/profileIndex.php";
      ?>
    
    </main>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script> -->
    <script src="./js/jquery-3.5.1.js"></script>
    <!-- <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script> -->
    <!-- <script src="./js/script.js"></script> -->
    <script src="./js/profile.js"></script>
  </body>
</html>
