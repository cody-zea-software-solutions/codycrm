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

            <style>
                .table-row-with-border {
                    border-bottom: 1px solid #dee2e6;
                    height: 100px !important;
                }
            </style>

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

                    <div class="row">
                    <div class="col-12 text-center mb-3">
                    <div class="mb-1"><span class="h4 mb-9 fw-semibold">Manage Orders&nbsp;&nbsp;<i class="fa fa-archive"
                      aria-hidden="true"></i></span>
                    </div>
                            <div><span class="mb-9 text-dark-emphasis">You can manage your orders here</span>
                        </div>
                    </div>
                    </div>

                        <div class="row">
                            <section>
                                <div class="gradient-custom-1 h-100">
                                    <div class="mask d-flex align-items-center h-100">
                                        <div class="container">

                                            <div class="row">
                                                <?php
                                                $order_cou = Databases::search("SELECT `email`,`order`.`id`,order.order_status_id,order_date,order_status_name,CONCAT(first_name,' ',last_name) AS user_name,mobile,
                                                CONCAT(first_line,',',second_line,',',city_name) AS `address` FROM `order`
                                                INNER JOIN order_status ON `order`.order_status_id=order_status.order_status_id
                                                INNER JOIN user ON user.email = `order`.user_email
                                                INNER JOIN address ON address.user_email=user.email
                                                INNER JOIN city ON city.city_id=address.city_id
                                                ORDER BY order_date DESC");
                                                for ($cvb = 0; $cvb < $order_cou->num_rows; $cvb++) {
                                                    $order_cou_fetch = $order_cou->fetch_assoc();
                                                    $ocf = $order_cou_fetch['id'];
                                                    ?>
                                                    <div class="col-12 border border-dark-subtle shadow mt-3 ">
                                                        <div class="row mt-2">
                                                            <div class="d-flex">
                                                                <div class="p-2 w-100 ">
                                                                    <div class=""><b>Name : </b>
                                                                        <?php echo $order_cou_fetch['user_name'] ?>
                                                                    </div>
                                                                    <div class=""><b>Mobile : </b>
                                                                        <?php echo $order_cou_fetch['mobile'] ?>
                                                                    </div>
                                                                    <div class=""><b>Email : </b>
                                                                        <?php echo $order_cou_fetch['email'] ?>
                                                                    </div>
                                                                    <div class=""><b>Address : </b>
                                                                        <?php echo $order_cou_fetch['address'] ?>
                                                                    </div>
                                                                    <div class=""><b>Date Time : </b>
                                                                        <?php echo $order_cou_fetch['order_date'] ?>
                                                                    </div>
                                                                </div>
                                                                <div class="p-2"><a class="btn btn-warning" data-bs-toggle="modal"
                                                                        data-bs-target="#exampleModal<?php echo $cvb ?>3"><?php echo $order_cou_fetch['order_status_name'] ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row justify-content-center">
                                                            <div class="col-12 px-3 pt-4 pb-5 rounded-2">
                                                                <div class="table-responsive bg-white">
                                                                    <table class="table mb-0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col"></th>
                                                                                <th></th>
                                                                                <th scope="col">ITEM</th>
                                                                                <th scope="col">DETAILS</th>
                                                                                <th scope="col">UNIT PRICE</th>
                                                                                <th scope="col">QTY</th>
                                                                                <th scope="col">TOTAL PRICE</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $order_rs = Databases::search("SELECT 
                                                                            price_table.product_product_id AS product_id,
                                                                            price_table.box_type_box_type_id AS box_id,
                                                                            qty,
                                                                            CONCAT(product.product_name, ' ', meat_type.meat_type_name, ' ', cook_type.cook_type_name) AS p_name,
                                                                            `order`.user_email,
                                                                            product.description,
                                                                            price_table.price,
                                                                            `order`.order_status_id,
                                                                            (SELECT product_img.product_img_path 
                                                                             FROM product_img 
                                                                             WHERE product_img.product_id = product.product_id 
                                                                             LIMIT 1) AS product_img_path,
                                                                            preference.preference_name
                                                                        FROM order_item
                                                                        INNER JOIN product ON product.product_id = order_item.price_table_product_product_id
                                                                        INNER JOIN `order` ON `order`.id = order_item.order_id
                                                                        INNER JOIN price_table ON price_table.box_type_box_type_id = order_item.price_table_box_type_box_type_id 
                                                                            AND price_table.product_product_id = product.product_id
                                                                        INNER JOIN meat_type ON meat_type.meat_type_id = product.meat_type_id
                                                                        INNER JOIN cook_type ON cook_type.cook_type_id = product.cook_type_id
                                                                        INNER JOIN preference ON preference.preference_id = order_item.preference_preference_id
                                                                        WHERE `order`.id = $ocf");
                                                                            $order_num = $order_rs->num_rows;

                                                                            for ($x = 0; $x < $order_num; $x++) {

                                                                                $order_data = $order_rs->fetch_assoc();
                                                                                $pid = $order_data["product_id"];
                                                                                $p_tot=$order_data["price"]*$order_data["qty"];
                                                                                ?>
                                                                                <tr class="table-row-with-border">
                                                                                    <td>
                                                                                        <?php echo $x + 1 ?>
                                                                                    </td>
                                                                                    <th><img src="<?php echo $order_data["product_img_path"] ?>"
                                                                                            class="img-fluid rounded-3"
                                                                                            alt="Shopping item" style="width: 65px;">
                                                                                    </th>


                                                                                    <th scope="row">
                                                                                        <?php echo $order_data['p_name'],' ',$order_data['preference_name']; ?>
                                                                                    </th>
                                                                                    <td>
                                                                                        <?php echo $order_data["description"] ?>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td>NZD 
                                                                                        <?php echo number_format($order_data["price"], 2) ?>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td><?php echo $order_data["qty"] ?></td>
                                                                                    <td>NZD
                                                                                        <?php echo number_format($p_tot, 2) ?>
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
                                                        <div class="row">
                                                            <!-- status update modal -->
                                                            <div class="modal fade" id="exampleModal<?php echo $cvb ?>3"
                                                                tabindex="-1" aria-labelledby="exampleModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <div class="modal-title fs-4 fw-bold"
                                                                                id="exampleModalLabel">
                                                                            </div>
                                                                            <button type="button" class="btn-close"
                                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="col-12 mb-3">
                                                                            
                                                                                <div class="form-floating mb-1">
                                                                                
                                                                                    <select class="form-select rounded-0"
                                                                                        aria-label="Floating label select example"
                                                                                        id="statusChangeProduct<?php echo $cvb ?>3">
                                                                                        <?php

                                                                                        $status_rs = Databases::search("SELECT * FROM `order_status`");
                                                                                        $status_num = $status_rs->num_rows;

                                                                                        $c = 0;
                                                                                        while ($c < $status_num) {

                                                                                            $c++;

                                                                                            $status_data = $status_rs->fetch_assoc();
                                                                                            ?>
                                                                                            <option
                                                                                                value="<?php echo $status_data["order_status_id"]; ?>" 
                                                                                                <?php if ($order_cou_fetch['order_status_id'] == $status_data["order_status_id"])
                                                                                                    echo 'selected'; ?>>
                                                                                                <?php echo $status_data["order_status_name"]; ?>
                                                                                            </option>

                                                                                            <?php

                                                                                        }

                                                                                        ?>

                                                                                    </select>
                                                                                    <label for="statusChange">Change This
                                                                                        order status here.</label>
                                                                                </div>
                                                                                <label class="small">Order of <b>
                                                                                        <?php echo $order_data['user_email'] ?>
                                                                                    </b>.</label><br>
                                                                                <label class="small">Warning : Please be
                                                                                    carefull when you selecting <b>
                                                                                        CANCELED
                                                                                    </b>.</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn x"
                                                                                onclick="OrderStatusSave(<?php echo $ocf ?>,<?php echo $cvb ?>);">Save</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- status update modal end -->
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </section>


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