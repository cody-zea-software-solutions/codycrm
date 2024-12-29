<?php
require_once "db.php";
session_start();

if (isset($_GET["pkey"])) {


    $key = $_GET["pkey"];


    $product_rs = Databases::search("SELECT * FROM price_table 
    INNER JOIN box_type ON box_type.box_type_id=price_table.box_type_box_type_id
    INNER JOIN product ON product.product_id=price_table.product_product_id WHERE `product_name` LIKE '%" . $key . "%' AND `on_delete` = 0");
    $product_num = $product_rs->num_rows;





    if ($product_num != 0) {
        for ($i = 0; $i < $product_num; $i++) {
            $product_data = $product_rs->fetch_assoc();


            $product_img_rs = Databases::search("SELECT * FROM `product_img`  WHERE `product_id` = '" . $product_data["product_id"] . "'");
            $product_img_data = $product_img_rs->fetch_assoc();
            ?>


            <div class="col-sm-6 col-xl-3">
                <div class="card overflow-hidden rounded-2">
                    <div class="position-relative p-4 d-flex flex-row align-items-center" style="height:12rem;">
                        <a href="javascript:void(0)"><img src="<?php echo $product_img_data["path_code"] ?>"
                                class="card-img-top rounded-0" alt="..."></a>
                        <a href="javascript:void(0)"
                            class="bg-orange rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i
                                class="ti ti-basket fs-4"></i></a>
                    </div>
                    <div class="card-body pt-3 p-4">
                        <h6 class="fw-semibold fs-4">
                            <?php echo $product_data['title'] ?>
                        </h6>
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="fw-semibold fs-4 mb-0">
                                <?php echo number_format($product_data['price']) ?>.00<span
                                    class="ms-2 fw-normal text-muted fs-3"><del>
                                        <?php echo $product_data["price"] ?>
                                    </del></span>
                            </h6>
                            <ul class="list-unstyled d-flex align-items-center mb-0">
                                <li><a class="me-1" href="javascript:void(0)"><i class="fa fa-star text-warning"></i></a></li>
                                <li><a class="me-1" href="javascript:void(0)"><i class="fa fa-star text-warning"></i></a></li>
                                <li><a class="me-1" href="javascript:void(0)"><i class="fa fa-star text-warning"></i></a></li>
                                <li><a class="me-1" href="javascript:void(0)"><i class="fa fa-star text-warning"></i></a></li>
                                <li><a class="me-1" href="javascript:void(0)"><i class="fa fa-star-o text-warning"></i></a></li>
                            </ul>
                        </div>
                        <div class="d-flex justify-content-end mt-2">
                            <button class="btn tex-g p-1 mx-1 rounded-0-5" data-bs-toggle="modal"
                                data-bs-target="#exampleModal<?php echo $product_data["product_id"] ?>">UPDATE</button>
                            <?php
                            $productid = $product_data["product_id"];
                            ?>
                            <button onclick="Deleteproduct(<?php echo $productid; ?>);" class="btn tex-r p-1 rounded-0-5"
                                data-bs-toggle="modalh" data-bs-target="#exampleModalx">DELETE</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update product popup -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title fs-4 fw-bold" id="exampleModalLabel"><i class="fa fa-list"
                                    aria-hidden="true"></i>&nbsp;
                                Product Management</div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row d-flex justify-content-center my-2">
                                <div class="col-12 col-lg-9 border shadow">
                                    <div class="row m-3">
                                        <div class="col-12 mt-3">
                                            <input type="file" class="form-control d-none" id="newsFileInput">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-8 col-md-4 mb-2" style="height: 200px;">
                                                    <input type="file" class="d-none" id="img_update_1">
                                                    <div class="border-x log-link d-flex justify-content-center align-items-center h-100"
                                                        onclick="tUpdateImage(1);"><span class="small" id="update_span_1">Main
                                                            Image</span>
                                                        <img src="" class="img-fluid h-100" id="update_div_1">
                                                    </div>
                                                </div>
                                                <div class="col-8 col-md-4  mb-2" style="height: 200px;">
                                                    <input type="file" class="d-none" id="img_update_2">
                                                    <div class="border-x log-link d-flex justify-content-center align-items-center h-100"
                                                        onclick="tUpdateImage(2);"><span class="small" id="update_span_2">Sub
                                                            Image</span>
                                                        <img src="" class="img-fluid h-100" id="update_div_2">
                                                    </div>
                                                </div>
                                                <div class="col-8 col-md-4 mb-2" style="height: 200px;">
                                                    <input type="file" class="d-none" id="img_update_3">
                                                    <div class="border-x log-link d-flex justify-content-center align-items-center h-100"
                                                        onclick="tUpdateImage(3);"><span class="small" id="update_span_3">Sub
                                                            Image</span>
                                                        <img src="" class="img-fluid h-100" id="update_div_3">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3 mt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control rounded-0" id="floatingInput"
                                                    placeholder="title of the product" value="Cey12" readonly>
                                                <label for="floatingInput">SKU Code</label>
                                            </div>
                                        </div>
                                        <div class="col-9 mt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control rounded-0" id="floatingInput"
                                                    placeholder="title of the product">
                                                <label for="floatingInput">Product Title</label>
                                            </div>
                                        </div>
                                        <div class="col-6 mt-3">
                                            <div class="form-floating">
                                                <select class="form-select rounded-0" id="floatingSelect"
                                                    aria-label="Floating label select example">
                                                    <option selected>Select product category</option>
                                                    <option value="1">cat1</option>
                                                    <option value="2">cat2</option>
                                                    <option value="3">cat3</option>
                                                </select>
                                                <label for="floatingSelect">Select your product category
                                                    here</label>
                                            </div>
                                        </div>
                                        <div class="col-6 mt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control rounded-0" id="floatingInput"
                                                    placeholder="title of the product">
                                                <label for="floatingInput">Price in NZD</label>
                                            </div>
                                        </div>

                                        <div class="col-6 mt-3">
                                            <div class="form-floating">
                                                <input type="text" class="form-control rounded-0" id="floatingInput"
                                                    placeholder="title of the product">
                                                <label for="floatingInput">Quantity</label>
                                            </div>
                                        </div>

                                        <div class="col-6 mt-3">
                                            <div class="form-floating">
                                                <select class="form-select rounded-0" id="floatingSelect"
                                                    aria-label="Floating label select example">
                                                    <option value="0" selected>Select stock status</option>
                                                    <option value="1">In Stock</option>
                                                    <option value="2">Out of stock</option>
                                                </select>
                                                <label for="floatingSelect">Stock Status</label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-floating">
                                                <textarea class="form-control rounded-0" placeholder="Short Description"
                                                    id="floatingTextarea" style="height: 100px"></textarea>
                                                <label for="floatingTextarea">Short Description</label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3 mb-3">
                                            <textarea class="form-control rounded-0" placeholder="Product Description"
                                                id="floatingTextarea2" style="height: 100px"></textarea>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button class="btn rounded-1 fw-bold x col-md-2"><i class="fa fa-floppy-o"
                                                    aria-hidden="true"></i>
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

            <!-- delete product modal -->
            <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title fs-4 fw-bold" id="exampleModalLabel">Warning&nbsp;&nbsp;<i
                                    class="fa fa-exclamation" aria-hidden="true"></i>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <span>Do you really want to delete <b>Coir peat-5Kg</b> ?</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn x rounded-0-5" data-bs-dismiss="modal">No</button>
                            <button type="button" class="btn ub-btn">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- delete product modal end -->

            <?php
        }
        ?>


        <?php
    } else {
        echo "Product Not Found";
    }
} else {
    echo "Please Try Again";
}






?>