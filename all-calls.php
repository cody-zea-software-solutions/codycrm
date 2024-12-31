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
            <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
                data-sidebar-position="fixed" data-header-position="fixed">
                <?php

                require "side.php";

                ?>
                <div class="body-wrapper">

                    <?php
                    require "nav.php";
                    ?>

                    <div class="container-fluid">

                        <div class="row px-3">

                            <div class="col-6 col-md-4 mt-4 pe-3">
                                <div class="form-floating">
                                    <select class="form-select rounded-0 text-dark border-dark" id="type" onchange="searchCall();" aria-label="Floating label select example">
                                        <option value="1" >Name</option>
                                        <option value="2" >Code</option>

                                    </select>
                                    <label for="floatingSelect" class="text-dark">Select Type</label>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 mt-4 ps-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control border-dark rounded-0" id="keyword" placeholder="" onkeyup="searchCall();">
                                    <label for="floatingInput" class="text-dark">Keyword</label>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="text-dark">
                                        <th scope="col"></th>
                                        <th scope="col">CODE</th>
                                        <th scope="col">NAME</th>
                                        <th scope="col">DISTRICT</th>
                                        <th scope="col">MOBILE</th>
                                        <th scope="col">DATE</th>
                                        <th scope="col">BUDGET</th>
                                        <th scope="col">PRIORITY</th>
                                        <th scope="col">TYPE</th>
                                        <th scope="col">DESCRIPTION</th>
                                        <th scope="col">BY</th>
                                    </tr>
                                </thead>
                                <tbody id="UserResult">
                                    <?php
                                    $data_r = Databases::search("SELECT * FROM calls
                                            INNER JOIN district ON district.district_id = calls.district_id
                                            INNER JOIN prioraty ON prioraty.prioraty_id=calls.prioraty_id
                                            INNER JOIN system_type ON system_type.type_id=calls.system_id
                                            INNER JOIN admin ON admin.admin_id=calls.user_id ORDER BY `date_time` DESC ");
                                    for ($i = 1; $i <= $data_r->num_rows; $i++) {
                                        $row_d = $data_r->fetch_assoc();
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $i ?></th>
                                            <td><?php echo $row_d['call_code'] ?></td>
                                            <td><?php echo $row_d['name'] ?></td>
                                            <td><?php echo $row_d['district_name'] ?></td>
                                            <td><?php echo $row_d['mobile'] ?></td>
                                            <td><?php echo $row_d['date_time'] ?></td>
                                            <td><?php echo $row_d['budget'] ?></td>
                                            <td><?php echo $row_d['prioraty_name'] ?></td>
                                            <td><?php echo $row_d['type_name'] ?></td>
                                            <td><?php echo $row_d['description'] ?></td>
                                            <td><?php echo $row_d['username'] ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
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