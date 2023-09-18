<?php
/**
 * This file contains all the system links navigation
 * 
 */

 $links = [
   "index" => [
     "title" => "Dashboard",
     "icon" => "bi bi-speedometer2",
     "link" => "index.php"
   ],
   "invoices" => [
     "title" => "Invoices",
     "icon" => "bi bi-file-earmark-text",
     "link" => "invoices.php"
   ],
   "payments" => [
     "title" => "Payments",
     "icon" => "bi bi-credit-card-2-front",
     "link" => "payments.php"
   ],
   "profile" => [
     "title" => "Profile",
     "icon" => "bi bi-person-circle",
     "link" => "profile.php"
   ],
  //  "settings" => [
  //    "title" => "Settings",
  //    "icon" => "bi bi-gear",
  //    "link" => "settings.php"
  //  ],
   "logout" => [
     "title" => "Logout",
     "icon" => "bi bi-box-arrow-right",
     "link" => "logout.php"
   ]
 ];

//  Define the current page
 $currentPage = basename($_SERVER['PHP_SELF'], ".php");

//  Loop through the links array
foreach ($links as $link => $value) {
  // Check if the current page is the same as the link
  if ($currentPage == $link) {
    // If it is, add the active class to the link
    $links[$link]["class"] = "active";
  } else {
    // If it is not, add the empty string to the link
    $links[$link]["class"] = "";
  }
}

?>