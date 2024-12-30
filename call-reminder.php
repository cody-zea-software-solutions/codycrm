<?php

session_start();
if (isset($_SESSION["a"])) {

    include "db.php";

    $uemail = $_SESSION["a"]["username"];

    $u_detail = Databases::search("SELECT * FROM `admin` WHERE `username`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {
        session_abort();

        $uid = $_SESSION["a"]["admin_id"];

?>
        <!doctype html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>CODY ZEA || Call reminder</title>
            <link rel="shortcut icon" href="assets-admin/images/logos/logo.webp" type="image/x-icon">
            <link rel="stylesheet" href="assets-admin/css/styles.min.css" />
            <script src="https://kit.fontawesome.com/dfdb94433e.js" crossorigin="anonymous"></script>

            <style>
                .toast-container {
                    position: fixed;
                    top: 1rem;
                    right: 1rem;
                    z-index: 1050;
                }
            </style>

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
                    <!--  Header Start -->
                    <?php
                    require "nav.php";
                    ?>
                    <!--  Header End -->
                    <div class="container-fluid">
                        <div class="row d-flex justify-content-center">
                            <div class="col-12 text-center mb-3">
                                <div class="mb-1"><span class="h4 mb-9 fw-semibold">Call Reminder&nbsp;&nbsp;<i class="fa fa-calendar-check-o"
                                            aria-hidden="true"></i></span>
                                </div>
                                <div><span class="mb-9 text-dark-emphasis">You can manage calls here</span>
                                </div>
                            </div>

                            <?php

                            $call_r = Databases::search("SELECT * FROM next_call INNER JOIN calls
                                                    ON calls.call_code = next_call.call_code
                                                    INNER JOIN prioraty ON prioraty.prioraty_id=calls.prioraty_id
                                                    INNER JOIN system_type ON system_type.type_id=calls.system_id
                                                    WHERE `user_id` = '" . $uid . "' AND `st`='1' ORDER BY `next_date` ASC");


                            for ($x = 0; $x < $call_r->num_rows; $x++) {
                                $call_d = $call_r->fetch_array();
                            ?>
                                <div class="col-12 border shadow py-2 px-2 mt-2">

                                    <div class="row px-4">

                                        <div class="col-12 col-md-6 col-lg-4 mt-1">
                                            <div class="form-floating">
                                                <input type="text" class="form-control rounded-0" id="name" placeholder="" value="<?php echo $call_d['name'] ?>" readonly>
                                                <label for="floatingInput">NAME</label>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 mt-1">
                                            <div class="form-floating">
                                                <input type="text" class="form-control rounded-0" id="mobile" placeholder="" value="<?php echo $call_d['mobile'] ?>" readonly>
                                                <label for="floatingInput">MOBILE</label>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 mt-1">
                                            <div class="form-floating">
                                                <input type="text" class="form-control rounded-0" id="date" placeholder="" value="<?php echo $call_d['date_time'] ?>" readonly>
                                                <label for="floatingInput">DATE</label>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 mt-1">
                                            <div class="form-floating">
                                                <select class="form-select rounded-0" id="priority<?php echo $call_d['next_id'] ?>" aria-label="Floating label select example">
                                                    <option value="<?php echo $call_d['prioraty_id'] ?>" Selected><?php echo $call_d['prioraty_name'] ?></option>
                                                    <?php
                                                    $status_rs = Databases::search("SELECT * FROM `prioraty`");
                                                    $status_num = $status_rs->num_rows;
                                                    for ($i = 0; $i < $status_num; $i++) {
                                                        $status_data = $status_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $status_data["prioraty_id"] ?>">
                                                            <?php echo $status_data["prioraty_name"] ?></option>

                                                    <?php
                                                    }
                                                    ?>

                                                </select>
                                                <label for="floatingSelect">Select Priority Level</label>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 mt-1">
                                            <div class="form-floating">
                                                <select class="form-select rounded-0" id="s_type<?php echo $call_d['next_id'] ?>" aria-label="Floating label select example">
                                                    <option value="<?php echo $call_d['type_id'] ?>" Selected><?php echo $call_d['type_name'] ?></option>
                                                    <?php
                                                    $system_type_rs = Databases::search("SELECT * FROM `system_type`");
                                                    $system_type_num = $system_type_rs->num_rows;
                                                    for ($i = 0; $i < $system_type_num; $i++) {
                                                        $system_type_data = $system_type_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $system_type_data["type_id"] ?>">
                                                            <?php echo $system_type_data["type_name"] ?></option>

                                                    <?php
                                                    }
                                                    ?>

                                                </select>
                                                <label for="floatingSelect">Select System Type</label>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-4 mt-1">
                                            <div class="form-floating">
                                                <input type="number" class="form-control rounded-0" id="budget<?php echo $call_d['next_id'] ?>" placeholder="" value="<?php echo $call_d['budget'] ?>">
                                                <label for="floatingInput">BUDGET</label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-1">
                                            <div class="form-floating">
                                                <textarea class="form-control rounded-0" id="description<?php echo $call_d['next_id'] ?>" placeholder="" style="height: 100px;"><?php echo $call_d['description'] ?></textarea>
                                                <label for="description">DESCRIPTION</label>
                                            </div>
                                        </div>

                                        <div class="col-8 col-md-6 col-lg-5 mt-1">
                                            <div class="form-floating">
                                                <input type="text" class="form-control rounded-0 text-dark border-dark" id="next_date<?php echo $call_d['next_id'] ?>" placeholder="" value="<?php echo $call_d['next_date'] ?>" readonly>
                                                <label for="floatingInput" class="text-dark">NEXT DATE</label>
                                            </div>
                                        </div>

                                        <div class="col-4 col-md-3 col-lg-2 mt-1">
                                            <div class="form-floating">
                                                <input type="text" class="form-control rounded-0 text-dark border-dark" id="count<?php echo $call_d['next_id'] ?>" placeholder="" value="<?php echo $call_d['count'] ?>" readonly>
                                                <label for="floatingInput" class="text-dark">COUNT</label>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-3 mt-1 col-lg-5 text-end">
                                            <button class="btn btn-orange rounded-0 py-3 px-5" onclick="modifyCalls('<?php echo $call_d['next_id'] ?>','<?php echo $call_d['call_code'] ?>');" id="modify_button<?php echo $call_d['next_id'] ?>">
                                                UPDATE
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            <?php
                            }
                            ?>

                            <div class="col-12">
                                <!-- Toast container -->
                                <div class="toast-container rounded-0">
                                    <div id="custom-toast" class="toast align-items-center text-white bg-danger border-0 rounded-0 p-1" role="alert" aria-live="assertive" aria-atomic="true">
                                        <div class="d-flex">
                                            <div class="toast-body" id="toast_inner"></div>
                                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
                integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
                integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
                crossorigin="anonymous"></script>

            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
                integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
                integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
                crossorigin="anonymous"></script>
            <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
            <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../assets/js/sidebarmenu.js"></script>
            <script src="../assets/js/app.min.js"></script>
            <script src="../admin-panel/assets-admin/js/script.js"></script>
            <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
            <script src="assets-admin/libs/jquery/dist/jquery.min.js"></script>
            <script src="assets-admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="assets-admin/js/sidebarmenu.js"></script>
            <script src="assets-admin/js/app.min.js"></script>
            <script src="assets-admin/libs/apexcharts/dist/apexcharts.min.js"></script>
            <script src="assets-admin/libs/simplebar/dist/simplebar.js"></script>
            <script src="assets-admin/js/dashboard.js"></script>
            <!-- Include jQuery library -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

            <!-- Include CKEditor library -->
            <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>


        </body>

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