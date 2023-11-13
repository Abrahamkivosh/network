<!DOCTYPE html>
<html lang="en">
  <head>
  <title> 
    View Invoice
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
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/dashboard.css" />


    <?php

include_once "./authCheck.php";

// get invoice id from url
$id = $_GET['id'] ;

// decrypt id
$id = decryptId($id) ;


$invoice = (object)$user->getUserInvoiceById($id) ;

$invoiceItems = (object)$user->getUserInvoiceItems($id) ;



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
      include_once "./pages/invoiceShow.php";
      ?>
    
    </main>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="./js/jquery-3.5.1.js"></script>
    <script src="./js/jquery.dataTables.min.js"></script>
    <script src="./js/dataTables.bootstrap5.min.js"></script>
    <script src="./js/script.js"></script>
  </body>
</html>
