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
                            <h4 class="h2 text-black">Prioraty Level: High</h4>
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
                                                    <span class="mt-5 text-black h4"><?php echo $xdata["name"]; ?></span><br />
                                                    <span class="mt-5 text-black h5">Date: <?php echo $xdata["date_time"]; ?></span><br />
                                                    <span class="mt-5 text-danger h6">Deadline: 12/30/2024</span><br />
                                                    <?php
                                                    $sy = Databases::search("SELECT * FROM `system_type` WHERE `type_id`='" . $xdata["system_id"] . "'");
                                                    $syy = $sy->fetch_assoc();
                                                    ?>
                                                    <span class="mt-5 text-black h5">System Type: <?php echo $syy["type_name"]; ?></span><br />
                                                    <button onclick="show('<?php echo $xdata['call_code']; ?>')" class="btn btn-success mt-3">
                                                        <i class="fa-regular fa-eye"></i> Show
                                                    </button>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>

                                    </div>
                                </section>


                                <!-- user details modal -->
                                <?php
                                $ccode = '';
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    if (isset($_POST['callid']) && !empty($_POST['callid'])) {
                                        $ccode = $_POST['callid'];
                                    } else {
                                        $error_message = "Please enter a Call ID.";
                                    }
                                }
                                ?>

                                <!-- user details modal -->
                                <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="modal-title fs-4 fw-bold" id="exampleModalLabel">
                                                    <i class="fa-regular fa-phone"></i>&nbsp; Call Details
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <!-- Form for call ID -->
                                            <form method="POST" action="">
                                                <input type="text" id="callid" name="callid" placeholder="Enter Call ID" value="<?php echo htmlspecialchars($ccode); ?>">
                                                <button type="submit" style="display: none;">Submit</button>
                                            </form>

                                            <div class="modal-body pt-4">
                                                <div class="card mb-0">
                                                    <div class="row pt-3 px-2">
                                                        <div class="col-4 col-md-2 d-flex justify-content-center align-items-center">
                                                            <img src="./assets-admin/box.png" class="img-fluid" width="90px" alt="">
                                                        </div>
                                                        <div class="col-8 col-md-10">
                                                            <div class="row">
                                                                <div class="col-12 col-md-6 mb-3">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control rounded-0" id="floatingInput" readonly>
                                                                        <label for="floatingInput">Project Name</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6 mb-3">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control rounded-0" id="floatingInputDate" readonly>
                                                                        <label for="floatingInputDate">Date</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control rounded-0" id="floatingInputDistrict" readonly>
                                                                        <label for="floatingInputDistrict">District</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6 mb-3">
                                                                    <div class="form-floating">
                                                                        <input type="text" class="form-control rounded-0" id="floatingInputSystem" readonly>
                                                                        <label for="floatingInputSystem">System Type</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 mb-3">
                                                                    <div class="form-floating">
                                                                        <textarea class="form-control rounded-0" id="floatingInputDescription"></textarea>
                                                                        <label for="floatingInputDescription">Description</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 mb-3">
                                                                    <div class="form-floating">
                                                                        <textarea class="form-control rounded-0" id="floatingInputNote"></textarea>
                                                                        <label for="floatingInputNote">Add a Call Note</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <div class="col-12 mt-3 text-end">
                                                    <button class="btn fw-bold x" data-bs-dismiss="modal">Close</button>
                                                    <button class="btn btn-success" type="submit" data-bs-dismiss="modal" onclick="Update();">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- user details modal end-->






                                <!-- user details modal end-->


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