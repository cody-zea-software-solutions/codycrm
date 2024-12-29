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
            <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
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
                    <div class="container-fluid mt-6">

                        <div class="row">

                            <div class="col-12 text-center mb-3">
                                <div class="mb-1"><span class="h4 mb-9 fw-semibold">Manage Variations&nbsp;&nbsp;<i
                                            class="fa fa-database" aria-hidden="true"></i></span>
                                </div>
                                <div><span class="mb-9 text-dark-emphasis">You can add or change product variations</span>
                                </div>
                            </div>

                            <div class="col-12 border shadow">

                                <div class="row m-3">
                                    <div class="col-12 text-center mt-3">
                                        <span class="fw-500 fw-bold">Add new variations</span>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <div class="form-floating">
                                            <select class="form-select rounded-0" id="addvname"
                                                aria-label="Floating label select example">
                                                <option selected value="0">Select Product</option>
                                                <?php

                                                $category_rs = Databases::search("SELECT * FROM `product`
                                                INNER JOIN cook_type ON cook_type.cook_type_id=product.cook_type_id
                                                INNER JOIN meat_type ON meat_type.meat_type_id=product.meat_type_id WHERE `on_delete`='0' ");
                                                $category_num = $category_rs->num_rows;

                                                for ($i = 0; $i < $category_num; $i++) {
                                                    $category_data = $category_rs->fetch_assoc();
                                                    ?>
                                                    <option value="<?php echo $category_data["product_id"] ?>">
                                                        <?php echo $category_data["product_name"], ' ', $category_data["cook_type_name"], ' ', $category_data["meat_type_name"] ?>
                                                    </option>
                                                    <?php
                                                }

                                                ?>
                                            </select>
                                            <label for="floatingSelect">Select your product here</label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-6 mt-3">
                                        <div class="form-floating">
                                            <select class="form-select rounded-0" id="addvbox"
                                                aria-label="Floating label select example">
                                                <option selected value="0">Select Variation</option>
                                                <?php

                                                $categor_rs = Databases::search("SELECT * FROM `box_type` ");
                                                $categor_num = $categor_rs->num_rows;

                                                for ($i = 0; $i < $categor_num; $i++) {
                                                    $categor_data = $categor_rs->fetch_assoc();
                                                    ?>
                                                    <option value="<?php echo $categor_data["box_type_id"]; ?>">
                                                        <?php echo $categor_data["box_type_name"] ?>
                                                    </option>
                                                    <?php
                                                }

                                                ?>
                                            </select>
                                            <label for="floatingSelect">Select your variation here</label>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-6 mt-3" id="inputset">
                                        <div class="input-group">
                                            <span class="input-group-text">NZD</span>
                                            <div class="form-floating is-invalid">
                                                <input type="number" class="form-control" id="addvprice"
                                                    placeholder="Enter Amount" required>
                                                <label for="price">Price</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-4 col-md-2 mt-3 d-flex flex-column justify-content-center">
                                        <button class="btn x rounded-0 mb-2" onclick="AddVar();">Add</button>
                                    </div>

                                </div>


                            </div>
                        </div>

                        <div class="row d-flex justify-content-center mt-5" id="ProductResult">
                            <?php
                            $product_rs = Databases::search("SELECT * FROM price_table 
                    INNER JOIN box_type ON box_type.box_type_id=price_table.box_type_box_type_id
                    INNER JOIN product ON product.product_id=price_table.product_product_id
                    INNER JOIN cook_type ON cook_type.cook_type_id=product.cook_type_id
                    INNER JOIN meat_type ON meat_type.meat_type_id=product.meat_type_id WHERE `on_delete` = '0'");
                            $product_num = $product_rs->num_rows;



                            for ($x = 0; $x < $product_num; $x++) {

                                $product_data = $product_rs->fetch_assoc();

                                $img_q = Databases::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_data["product_id"] . "'");
                                if ($img_q->num_rows >= 1) {
                                    $img_d = $img_q->fetch_assoc();
                                    $img = $img_d["product_img_path"];
                                } else {
                                    $img = null;
                                }

                                // $price = { () $product_data["price"] + 5% }
                    
                                ?>
                                <div class="col-sm-6 col-xl-3">
                                    <div class="card overflow-hidden rounded-2">
                                        <div class="position-relative p-4 d-flex flex-row align-items-center" style="height:12rem;">
                                            <a href="javascript:void(0)"><img src="<?php echo $img ?>"
                                                    class="card-img-top rounded-0" alt="..."></a>
                                            <a href="javascript:void(0)"
                                                class="bg-orange rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3"
                                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i
                                                    class="ti ti-basket fs-4"></i></a>
                                        </div>
                                        <div class="card-body pt-3 p-4">
                                            <h6 class="fs-4">
                                                <?php echo $product_data['product_name'], "</br>", $product_data['cook_type_name'], " ", $product_data['meat_type_name'], " ", $product_data['box_type_name'] ?>
                                            </h6>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h6 class="fw-semibold fs-4 mb-0">
                                                    <?php echo number_format($product_data['price'], 2) ?>
                                                </h6>
                                            </div>
                                            <div class="d-flex justify-content-end mt-2">
                                                <button class="btn tex-g p-1 mx-1 rounded-0-5" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal<?php echo $product_data["product_product_id"], $product_data["box_type_box_type_id"] ?>">UPDATE</button>
                                                <?php
                                                $productid = $product_data['product_product_id'] . $product_data['box_type_box_type_id'];
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Update product popup -->
                                <div class="modal fade"
                                    id="exampleModal<?php echo $product_data["product_product_id"], $product_data["box_type_box_type_id"] ?>"
                                    tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="modal-title fs-4 fw-bold" id="exampleModalLabel"><i class="fa fa-list"
                                                        aria-hidden="true"></i>&nbsp;
                                                    Product Management</div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row d-flex justify-content-center my-2">
                                                    <div class="col-12 col-lg-9 border shadow">
                                                        <div class="row m-3">

                                                            <div class="col-3 mt-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control rounded-0" readonly
                                                                        value="<?php echo $product_data['product_id'] ?>">
                                                                    <label for="floatingInput">ProductID</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-9 mt-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control rounded-0" readonly
                                                                        value="<?php echo $product_data["product_name"] ?>"
                                                                        placeholder="title of the product">
                                                                    <label for="floatingInput">Product Title</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control rounded-0" readonly
                                                                        value="<?php echo $product_data["cook_type_name"] ?>"
                                                                        placeholder="title of the product">
                                                                    <label for="floatingInput">Product Cook Type</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control rounded-0" readonly
                                                                        value="<?php echo $product_data["meat_type_name"] ?>"
                                                                        placeholder="title of the product">
                                                                    <label for="floatingInput">Product Meat Type</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-4">
                                                                <div class="form-floating">
                                                                    <select class="form-select rounded-0"
                                                                        id="<?php echo $productid; ?>pb"
                                                                        aria-label="Floating label select example">
                                                                        <option selected
                                                                            value="<?php echo $product_data["box_type_id"] ?>">
                                                                            <?php echo $product_data["box_type_name"] ?>
                                                                        </option>
                                                                        <?php
                                                                        $catego_rs = Databases::search("SELECT * FROM `box_type`");
                                                                        $catego_num = $catego_rs->num_rows;
                                                                        for ($i = 0; $i < $catego_num; $i++) {
                                                                            $catego_data = $catego_rs->fetch_assoc();
                                                                            ?>
                                                                            <option value="<?php echo $catego_data["box_type_id"] ?>">
                                                                                <?php echo $catego_data["box_type_name"] ?>
                                                                            </option>

                                                                            <?php
                                                                        }
                                                                        ?>

                                                                    </select>
                                                                    <label for="floatingSelect">Select your product box type
                                                                        here</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control rounded-0"
                                                                        id="<?php echo $productid; ?>pp"
                                                                        value="<?php echo $product_data["price"] ?>"
                                                                        placeholder="title of the product">
                                                                    <label for="floatingInput">Price in NZD</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 text-end mt-3">
                                                                <button class="btn rounded-1 fw-bold x col-md-2"
                                                                    onclick="update_product(<?php echo $product_data['product_product_id'], ',', $product_data['box_type_box_type_id'] ?>)"><i
                                                                        class="fa fa-floppy-o" aria-hidden="true"></i>
                                                                    SAVE</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Update product popupend -->

                                <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.tiny.cloud/1/v6ya2mxbd70fn22v774qp5fw78t114ccnejem2vy8oriyj04/tinymce/5/tinymce.min.js"
                referrerpolicy="origin"></script>

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
            <!-- Include jQuery library -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


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