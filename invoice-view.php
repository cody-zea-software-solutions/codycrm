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
            <title>BOOZEBITES New Zealand || Admin-Panel</title>
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
                        <div class="card">
                            <div class="card-body">
                                <div class="row d-flex flex-row justify-content-center">

                                    <div class="col-12 col-md-6 order-2 order-md-1 mt-3 mt-md-0 text-center">
                                        <img src="assets-admin\images\backgrounds\Invoice-bro.svg"
                                            class="img-fluid" width="400px">
                                    </div>

                                    <div
                                        class="col-12 col-md-6 text-center d-flex flex-row align-items-center justify-content-center order-1 order-lg-2">
                                        <div class="row d-flex flex-row justify-content-center">
                                            <div class="col-8 shadow p-3 border position-relative">
                                                <div
                                                    class="position-absolute top-0 start-0 notification bg-dark rounded-circle m-3">
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 text-end pe-4 pt-1">
                                                        <img src="assets-admin\images\backgrounds\Invoice-bro.svg" class="img-fluid" width="90px"
                                                            alt="" srcset="">
                                                    </div>
                                                    <div class="col-12 mt-3 ps-4 text-start">
                                                        <div class="mb-2"><span class="h4 mb-9 fw-semibold">Invoices
                                                            </span></div>
                                                        <div><span class="mb-9 text-dark-emphasis">Manage your Invoices
                                                                here</span></div>
                                                    </div>
                                                    <div class="col-12 mt-3">
                                                        <button class="btn fw-bold col-8 btn-orange" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal"><i class="fa-solid fa-receipt"></i>
                                                            Show Invoices</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!---Invoice Management Modal-->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="modal-title fs-4 fw-bold" id="exampleModalLabel"><i
                                                        class="fa-solid fa-receipt"></i>&nbsp;
                                                    Invoice Management BoozeBites</div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row p-2 d-flex flex-row justify-content-end">
                                                    <div class="col-12 col-lg-6">

                                                        <form action="">
                                                            <div class="input-group rounded border rounded-5">
                                                                <input type="search" class="form-control border-0 border-end"
                                                                    placeholder="Search by Invoice Id" aria-label="Search"
                                                                    aria-describedby="search-addon" id="keyword" />
                                                                <span class="input-group-text bg-orange btn border-0 text-white"
                                                                    id="search-addon" onclick="SearchInvoice();">
                                                                    <i class="fas fa-search text-white"></i>
                                                                </span>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>

                                                <section>
                                                    <div class="gradient-custom-1 h-100">
                                                        <div class="mask d-flex align-items-center h-100">
                                                            <div class="container" id="UserResult">
                                                                <div class="row justify-content-center">
                                                                    <div class="col-12">
                                                                        <div class="table-responsive bg-white">
                                                                            <table class="table mb-0">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th scope="col"></th>
                                                                                        <th scope="col">Invoice ID</th>
                                                                                        <th scope="col">Customer Name</th>
                                                                                        <th scope="col">Total Price</th>
                                                                                        <th scope="col">Date</th>
                                                                                        <th scope="col">View</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>

                                                                                    <?php
                                                                                    $invoice_rs = Databases::search("SELECT * FROM invoice
                                                                                    INNER JOIN `order` ON `order`.id=invoice.order_id
                                                                                    INNER JOIN `user` ON `user`.`email`=`order`.user_email ORDER BY `invoice`.`invoice_date` DESC");
                                                                                    $invoice_num = $invoice_rs->num_rows;
                                                                                    for ($x = 1; $x <= $invoice_num; $x++) {
                                                                                        $invoice_data = $invoice_rs->fetch_assoc();
                                                                                        ?>
                                                                                        <tr id="UserResult">
                                                                                            <td>
                                                                                                <?php echo $x ?>
                                                                                            </td>
                                                                                            <th scope="row">
                                                                                                <?php echo $invoice_data['payment_intent'] ?>
                                                                                            </th>
                                                                                            <td>
                                                                                                <?php echo $invoice_data["first_name"] . " " . $invoice_data["last_name"] ?></br>
                                                                                                <?php echo $invoice_data["email"]; ?>
                                                                                            </td>
                                                                                            <td>NZD
                                                                                                <?php echo $invoice_data["invoice_total"]; ?>
                                                                                            </td>
                                                                                            <td>
                                                                                                <?php echo $invoice_data["invoice_date"] ?>
                                                                                            </td>
                                                                                            <td><a class="btn x py-1 px-3 rounded-1" href="invoice.php?in_id=<?php echo $invoice_data['payment_intent']?>" target="_blank"><i
                                                                                                        class="fa fa-download"
                                                                                                        aria-hidden="true"></i></a>
                                                                                            </td>
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
                                                        </div>
                                                    </div>
                                                </section>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!---Invoice Management Modal-->
                                <!--Innvoice PDF GET MODAL-->
                          
                                <!-- Modal -->
                                <div class="modal fade" id="invoicePDF" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                            
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Innvoice PDF GET MODAL-->

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
            <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
            <script src="../admin-panel/assets-admin/libs/jquery/dist/jquery.min.js"></script>
            <script src="../admin-panel/assets-admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="../admin-panel/assets-admin/js/sidebarmenu.js"></script>
            <script src="../admin-panel/assets-admin/js/app.min.js"></script>
            <script src="../admin-panel/assets-admin/libs/apexcharts/dist/apexcharts.min.js"></script>
            <script src="../admin-panel/assets-admin/libs/simplebar/dist/simplebar.js"></script>
            <script src="../admin-panel/assets-admin/js/dashboard.js"></script>
            <script src="../denu.js"></script>
            <script src="../script.js"></script>
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