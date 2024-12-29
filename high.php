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
                    <div class="container-fluid">

                    <div class="row">
                    <div class="col-12 text-center mb-3">
                                <div class="mb-1"><span class="h4 mb-9 fw-semibold">Manage Products&nbsp;&nbsp;<i
                                            class="fa fa-list" aria-hidden="true"></i></span>
                                </div>
                                <div><span class="mb-9 text-dark-emphasis">You can change or remove products here</span>
                                </div>
                            </div>
                    </div>
                        
                        <div class="row d-flex justify-content-center mt-5" id="ProductResult">
                            <?php
                            $product_rs = Databases::search("SELECT * FROM product
                    INNER JOIN cook_type ON cook_type.cook_type_id=product.cook_type_id
                    INNER JOIN meat_type ON meat_type.meat_type_id=product.meat_type_id ORDER BY `product_id` DESC");
                            $product_num = $product_rs->num_rows;



                            for ($x = 0; $x < $product_num; $x++) {

                                $product_data = $product_rs->fetch_assoc();

                                $img_m = Databases::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_data["product_id"] . "' ORDER BY `product_img_id` ASC");
                                $img_q = Databases::search("SELECT * FROM `product_img` WHERE `product_id`='" . $product_data["product_id"] . "' ORDER BY `product_img_id` ASC");
                                if ($img_m->num_rows >= 1) {
                                    $img_d = $img_m->fetch_assoc();
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
                                                <?php echo $product_data['product_name'], "</br>", $product_data['cook_type_name'], " ", $product_data['meat_type_name'] ?>
                                            </h6>
                                            <div class="d-flex justify-content-end mt-2">
                                                <button class="btn tex-g p-1 mx-1 rounded-0-5" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal<?php echo $product_data["product_id"] ?>">UPDATE
                                                </button><?php
                                                    if($product_data["on_delete"]==0){
                                                        ?>
                                                        <button class='btn text-danger p-1 mx-1 rounded-0-5' onclick="disablePr(<?php echo $product_data['product_id'],',',$product_data['on_delete'] ?>)">DISABLE</button>
                                                        <?php
                                                    }else{
                                                        ?>
                                                        <button class='btn text- p-1 mx-1 rounded-0-5'  onclick="disablePr(<?php echo $product_data['product_id'],',',$product_data['on_delete'] ?>)">ENABLE</button>
                                                        <?php
                                                    }
                                                    ?>
                                                <?php
                                                $productid = $product_data['product_id'];
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Update product popup -->
                                <div class="modal fade" id="exampleModal<?php echo $productid ?>" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                                                            <div class="col-12 my-3">
                                                                <div class="row d-flex justify-content-center">

                                                                <?php
                                                                
                                                                for($cvn=1;$cvn<=$img_q->num_rows;$cvn++){

                                                                    $img_data = $img_q->fetch_assoc();
                                                                    $img = $img_data["product_img_path"];
                                                                    ?>

                                                                    <div class="col-8 col-md-4 mb-2" style="height: 200px;">
                                                                        <input type="file" class="d-none" id="img_input_<?php echo $cvn; echo $productid; ?>">
                                                                        <div class="border-x log-link d-flex justify-content-center align-items-center h-100 outer-div"
                                                                            onclick="cProductImage(<?php echo $cvn; ?>,<?php echo $productid; ?>);">
                                                                            <img src="<?php echo $img ?>" class="img-fluid" id="img_div_<?php echo $cvn; echo $productid; ?>">
                                                                        </div>
                                                                    </div>

                                                                    <?php
                                                                }
                                                                
                                                                ?>

                                                                </div>
                                                            </div>
                                                            <div class="col-3 mt-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control rounded-0"
                                                                        id="<?php echo $productid; ?>sku"
                                                                        placeholder="title of the product"
                                                                        value="<?php echo $product_data['product_id'] ?>">
                                                                    <label for="floatingInput">ProductID</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-9 mt-3">
                                                                <div class="form-floating">
                                                                    <input type="text" class="form-control rounded-0"
                                                                        id="<?php echo $productid; ?>pt"
                                                                        value="<?php echo $product_data["product_name"] ?>"
                                                                        placeholder="title of the product">
                                                                    <label for="floatingInput">Product Title</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <select class="form-select rounded-0"
                                                                        id="<?php echo $productid; ?>pc"
                                                                        aria-label="Floating label select example">
                                                                        <option selected
                                                                            value="<?php echo $product_data["cook_type_id"] ?>">
                                                                            <?php echo $product_data["cook_type_name"] ?>
                                                                        </option>
                                                                        <?php
                                                                        $category_rs = Databases::search("SELECT * FROM `cook_type`");
                                                                        $category_num = $category_rs->num_rows;
                                                                        for ($i = 0; $i < $category_num; $i++) {
                                                                            $category_data = $category_rs->fetch_assoc();
                                                                            ?>
                                                                            <option value="<?php echo $category_data["cook_type_id"] ?>">
                                                                                <?php echo $category_data["cook_type_name"] ?></option>

                                                                            <?php
                                                                        }
                                                                        ?>

                                                                    </select>
                                                                    <label for="floatingSelect">Select your product cook type
                                                                        here</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6 mt-3">
                                                                <div class="form-floating">
                                                                    <select class="form-select rounded-0"
                                                                        id="<?php echo $productid; ?>pm"
                                                                        aria-label="Floating label select example">
                                                                        <option selected
                                                                            value="<?php echo $product_data["meat_type_id"] ?>">
                                                                            <?php echo $product_data["meat_type_name"] ?>
                                                                        </option>
                                                                        <?php
                                                                        $categor_rs = Databases::search("SELECT * FROM `meat_type`");
                                                                        $categor_num = $categor_rs->num_rows;
                                                                        for ($i = 0; $i < $categor_num; $i++) {
                                                                            $categor_data = $categor_rs->fetch_assoc();
                                                                            ?>
                                                                            <option value="<?php echo $categor_data["meat_type_id"] ?>">
                                                                                <?php echo $categor_data["meat_type_name"] ?></option>

                                                                            <?php
                                                                        }
                                                                        ?>

                                                                    </select>
                                                                    <label for="floatingSelect">Select your product meat type
                                                                        here</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 mt-3 mb-3">
                                                                <textarea class="form-control rounded-0"
                                                                    placeholder="Product Description"
                                                                    id="<?php echo $productid; ?>pld"
                                                                    style="height: 100px"><?php echo $product_data["description"] ?></textarea>
                                                            </div>
                                                            <div class="col-12 text-end">
                                                                <button class="btn rounded-1 fw-bold x col-md-2"
                                                                    onclick="update_product_real(<?php  echo $productid; ?>)"><i
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