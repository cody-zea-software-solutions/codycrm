<?php
session_start();
if (isset($_SESSION["a"])) {

  include "db.php";

  $uemail = $_SESSION["a"]["username"];

  $u_detail = Databases::search("SELECT * FROM `admin` WHERE `username`='" . $uemail . "'");

  if ($u_detail->num_rows == 1) {
    session_abort();
    $u_details = $u_detail->fetch_assoc();
?>

    <!doctype html>
    <html lang="en">

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>CODY ZEA || Admin-Panel</title>
      <link rel="shortcut icon" href="assets-admin/images/logos/logo.webp" type="image/x-icon">

      <link rel="stylesheet" href="assets-admin/css/styles.min.css" />
    </head>

    <body>
      <!--  Body Wrapper -->
      <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <?php

        require "side.php";

        ?>
        <!--  Main wrapper -->
        <div class="body-wrapper">

          <?php
          require "nav.php";
          ?>


        </div>
      </div>

    </body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="assets-admin/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets-admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets-admin/js/sidebarmenu.js"></script>
    <script src="assets-admin/js/app.min.js"></script>
    <script src="assets-admin/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="assets-admin/libs/simplebar/dist/simplebar.js"></script>
    <script src="assets-admin/js/dashboard.js"></script>

    </html>
  <?php
  } else {
  ?>

    <script>
      alert("You Are Not an Admin");
      window.location = "authentication-login.php";
    </script>

  <?php
  }
} else {
  ?>

  <script>
    alert("You Are Not an Admin");
    window.location = "authentication-login.php";
  </script>

<?php

}

?>