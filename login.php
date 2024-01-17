<?php
include_once("library/sessions.php");
dalo_session_start();

if (array_key_exists('daloradius_logged_in', $_SESSION)
    && $_SESSION['daloradius_logged_in'] !== false) {
    header('Location: admin.php');
    exit;
}
include("lang/main.php");

$message = isset($_GET['message']) ?  $_GET['message'] : null  ;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./users/css/bootstrap.min.css">
    <link rel="stylesheet" href="./users/css/style.css" />
    <title>Login - <?php echo $configValues['SYSTEM_NAME'] ?>- ISP</title>
    <style>
        /* 
        increase select option size
         */
        select {
          height: 50px;
          width: 100%;
          padding: 10px;
          font-size: 18px;
          border-radius: 5px;
          border: 1px solid #ccc;
        }
        select option {
          font-size: 18px;
        }
        </style>
  </head>
  <body class="vh-100" style="background-color: #508bfc;">

  <section  >
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <h3 class="mb-4"> <a href="./" class="title_login">Admin Login</a> </h3>
            <form action="dologin.php" method="post">
              <?php
               include_once "./users/includes/messages.php";
              ?>

            <div class="form-outline mb-4">
              <input type="text" name="username" id="username" 
                placeholder="Enter your username" autocomplete="username" autofocus  
            placeholder="User Name" tabindex="1" required  class="form-control form-control-lg" />
              <label class="form-label visually-hidden" for="username">Username</label>
            </div>

            <div class="form-outline mb-4">
              <input type="password" id="password" name="password" autocomplete="current-password" 
              placeholder="Enter your password"
              class="form-control form-control-lg" />
              <label class="form-label visually-hidden" for="password">Password</label>
            </div>
          

            <div class=" mb-4 d-grid gap-2 col-12 mx-auto">
                <button class="btn btn-primary btn-lg " type="submit">Login</button>
            </div>
            </form>


          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- boostrap 4 cdn -->

    
    <script src="./users/js/jquery-3.5.1.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="./users/js/bootstrap.bundle.min.js" ></script>

  </body>
</html>
