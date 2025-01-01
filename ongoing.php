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
            <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">

            <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-thin.css">

            <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-solid.css">

            <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-regular.css">

            <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-light.css">
        </head>

        <body>
            <!--  Body Wrapper -->
            <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
                <?php

                require "side.php";

                ?>
                <div class="body-wrapper">

                    <?php
                    require "nav.php";
                    ?>

                    <div class="container-fluid">
                        <div class="row">
                            <h4 class="h2 text-black">Ongoing Projects</h4>
                            <div class="col-lg-8">
                                <section>
                                    <div>
                                        <span class="h3 text-black">Call Boxes</span>
                                    </div>
                                    <div class="row">

                                    
                                        <div class="col-12 d-flex">
                                            <?php
                                            $x = Databases::search("SELECT * FROM `calls` WHERE `prioraty_id`='1'");
                                            $xnum = $x->num_rows;

                                            for ($i = 0; $i < $xnum; $i++) {
                                                $xdata = $x->fetch_assoc();
                                            ?>
                                                <div class="col-12 col-md-6 col-lg-4 shadow-sm rounded-5 p-5 text-center mx-3 mt-3">
                                                    <img src="assets-admin/box.png" class="img-fluid" alt="">
                                                    <span class="mt-5 text-black h4"><?php echo $xdata["name"]; ?></span>
                                                    <br />
                                                    <span class="mt-5 text-black h5">Date: <?php echo $xdata["date_time"]; ?></span><br />
                                                    <?php
                                                    $xm = Databases::search("SELECT * FROM `ongoing_projects` WHERE `call_id`='" . $xdata['call_code'] . "' ");
                                                    $xnum = $xm->num_rows;
                                                    if( $xnum == 1){
                                                        $deadline = $xm->fetch_assoc();
                                                        ?>
                                                         <span class="mt-5 text-danger h6">Deadline: <?php echo $deadline["deadline"] ;  ?></span><br />
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <span class="mt-5 text-danger h6">Deadline: </span><br />
                                                        <?php
                                                    }
                                                     ?>
                                                    <span class="mt-5 text-danger h6">add new or update Deadline below</span><br />
                                                    <input type="date" id="Deadline" class="form-control" placeholder="add new Deadline"/>
                                                    <?php
                                                    $sy = Databases::search("SELECT * FROM `system_type` WHERE `type_id`='" . $xdata["system_id"] . "'");
                                                    $syy = $sy->fetch_assoc();
                                                    ?>
                                                    <span class="mt-5 text-black h5">System Type: <?php echo $syy["type_name"]; ?></span><br />
                                                    <button class="btn btn-danger mt-3"><i class="fa fa-download" onclick="generatePDF('<?php echo $xdata['call_code']; ?>')"></i> Download</button>
                                                    <button class="btn btn-danger mt-3" onclick="AddDeadline('<?php echo $xdata['call_code']; ?>')"><i class="fa"></i>ADD Deadline</button>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>


                                    </div>
                                </section>
                            </div>
                        </div>

                    </div>



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
        <script src="sahan.js"></script>
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