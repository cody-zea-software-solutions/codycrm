<?php

session_start();
if (isset($_SESSION["a"])) {

    include "db.php";

    $uemail = $_SESSION["a"]["email"];

    $u_detail = Databases::search("SELECT * FROM `admin` WHERE `email`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {
        session_abort();

        ?>
        <!doctype html>
        <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>CEYNAP New Zealand || Admin-Panel</title>
            <link rel="shortcut icon" href="../assets/images/logos/favicon.png" type="image/x-icon">
            <link rel="stylesheet" href="../admin-panel/assets-admin/css/styles.min.css" />

            <!---Icons-->
            <script src="https://kit.fontawesome.com/dfdb94433e.js" crossorigin="anonymous"></script>

            <!---Icons-->
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
                                <div class="mb-1"><span class="h4 mb-9 fw-semibold">Manage Discounts&nbsp;&nbsp;<i
                                            class="fa fa-money" aria-hidden="true"></i></span>
                                </div>
                                <div><span class="mb-9 text-dark-emphasis">You can manage product dicounts here</span>
                                </div>
                            </div>

                            <div class="col-12 col-lg-9 border shadow">

                                <div class="row m-3">
                                    <div class="col-12 text-center mt-3">
                                        <span class="fw-500 fw-bold">Discount per amount</span>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <div class="form-floating">
                                            <input type="text" class="form-control rounded-0" id="dname"
                                                placeholder="title of the product">
                                            <label for="title">Discount Name</label>
                                        </div>
                                    </div>

                                    <div class="col-6 mt-3">
                                        <div class="form-floating">
                                            <input type="number" class="form-control rounded-0" id="damount"
                                                placeholder="title of the product">
                                            <label for="title">Discount Amount</label>
                                        </div>
                                    </div>

                                    <div class="col-6 mt-3" id="inputset">
                                        <div class="input-group">
                                            <div class="form-floating is-invalid">
                                                <input type="number" class="form-control" id="dper" placeholder="Enter Amount"
                                                    required>
                                                <label for="price">Discount Percentage</label>
                                            </div>
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>

                                    <div class="col-4 col-md-2 mt-3 d-flex flex-column justify-content-center">
                                        <button class="btn x rounded-0 mb-2" onclick="AddDis();">Add</button>
                                    </div>

                                </div>


                            </div>

                            <div class="col-12 col-lg-9 border shadow mt-5">

                                <div class="row m-3">
                                    <div class="col-12 text-center mt-3">
                                        <span class="fw-500 fw-bold">Delete Discount</span>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <div class="form-floating">
                                            <select class="form-select rounded-0" id="ddelete"
                                                aria-label="Floating label select example">
                                                <option selected value="0">Select Discount</option>
                                                <?php

                                                $category_rs = Databases::search("SELECT * FROM `discount`");
                                                $category_num = $category_rs->num_rows;

                                                for ($i = 0; $i < $category_num; $i++) {
                                                    $category_data = $category_rs->fetch_assoc();
                                                    ?>
                                                    <option value="<?php echo $category_data["discount_id"] ?>">
                                                        <?php echo $category_data["discount_name"]," || ",$category_data["percentage"]," % off on spend ",$category_data["amount"]," NZD" ?>
                                                    </option>
                                                    <?php
                                                }

                                                ?>
                                            </select>
                                            <label for="floatingSelect">Select your Discount here</label>
                                        </div>
                                    </div>

                                    <div class="col-4 col-md-2 mt-3 d-flex flex-column justify-content-center">
                                        <button class="btn btn-danger rounded-0 mb-2" onclick="DelDis();">Delete</button>
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
            <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
            <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../assets/js/sidebarmenu.js"></script>
            <script src="../assets/js/app.min.js"></script>
            <script src="../admin-panel/assets-admin/js/script.js"></script>
            <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
            <script src="../admin-panel/assets-admin/libs/jquery/dist/jquery.min.js"></script>
            <script src="../admin-panel/assets-admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../admin-panel/assets-admin/js/sidebarmenu.js"></script>
            <script src="../admin-panel/assets-admin/js/app.min.js"></script>
            <script src="../admin-panel/assets-admin/libs/apexcharts/dist/apexcharts.min.js"></script>
            <script src="../admin-panel/assets-admin/libs/simplebar/dist/simplebar.js"></script>
            <script src="../admin-panel/assets-admin/js/dashboard.js"></script>

            <script src="../script.js"></script>
            <script src="../denu.js"></script>
            <script src="../M.js"></script>
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