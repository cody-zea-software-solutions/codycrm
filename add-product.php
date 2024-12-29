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
                <div class="mb-1"><span class="h4 mb-9 fw-semibold">Add new Product&nbsp;&nbsp;<i class="fa fa-plus-circle"
                      aria-hidden="true"></i></span>
                </div>
                <div><span class="mb-9 text-dark-emphasis">You can add new product here</span>
                </div>
              </div>
              <div class="col-12 col-lg-9 border shadow">
                <div class="row m-3">
                  <div class="col-12 my-3">
                    <div class="row d-flex justify-content-center">
                      <div class="col-8 col-md-4 mb-2" style="height: 200px;">
                        <input type="file" class="d-none" id="img_input_1">
                        <div class="border-x log-link d-flex justify-content-center align-items-center h-100 outer-div"
                          onclick="tProductImage(1);"><span class="small" id="img_span_1">First Image</span>
                          <img src="" class="img-fluid" id="img_div_1">
                        </div>
                      </div>
                      <div class="col-8 col-md-4 mb-2" style="height: 200px;">
                        <input type="file" class="d-none" id="img_input_2">
                        <div class="border-x log-link d-flex justify-content-center align-items-center h-100 outer-div"
                          onclick="tProductImage(2);"><span class="small" id="img_span_2">Second Image</span>
                          <img src="" class="img-fluid" id="img_div_2">
                        </div>
                      </div>
                      <div class="col-8 col-md-4 mb-2" style="height: 200px;">
                        <input type="file" class="d-none" id="img_input_3">
                        <div class="border-x log-link d-flex justify-content-center align-items-center h-100 outer-div"
                          onclick="tProductImage(3);"><span class="small" id="img_span_3">Third Image</span>
                          <img src="" class="img-fluid" id="img_div_3">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 mt-3">
                    <div class="form-floating">
                      <input type="text" class="form-control rounded-0" id="title" placeholder="title of the product">
                      <label for="title">Product Title</label>
                    </div>
                  </div>
                  <div class="col-6 mt-3">
                    <div class="form-floating">
                      <select class="form-select rounded-0" id="category" aria-label="Floating label select example">
                        <option selected value="0">Select cook type</option>
                        <?php

                        $category_rs = Databases::search("SELECT * FROM `cook_type` ORDER BY `cook_type_name` ASC");
                        $category_num = $category_rs->num_rows;

                        for ($i = 0; $i < $category_num; $i++) {
                          $category_data = $category_rs->fetch_assoc();
                          ?>
                          <option value="<?php echo $category_data["cook_type_id"] ?>">
                            <?php echo $category_data["cook_type_name"] ?>
                          </option>
                          <?php
                        }

                        ?>


                      </select>
                      <label for="floatingSelect">Select your cook type here</label>
                    </div>

                    <button class="btn x rounded-0 mt-2 d-grid col-12" data-bs-toggle="modal"
                      data-bs-target="#exampleModal">Add New Cook Type</button>

                    <!--Add New Category Modal-->

                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                      aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa fa-plus-circle"
                                aria-hidden="true"></i> Add New Cook Type</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="col-12">
                              <div class="form-floating">
                                <input type="text" class="form-control rounded-0" id="cname"
                                  placeholder="title of the product">
                                <label for="cname">CookType Name</label>
                              </div>
                            </div>


                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn x" onclick="AddCategory();"><i class="fa fa-plus-circle"
                                aria-hidden="true"></i> Add</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--Add New Category Modal-->
                  </div>

                  <div class="col-6 mt-3">
                    <div class="form-floating">
                      <select class="form-select rounded-0" aria-label="Floating label select example" id="weight">
                        <option value="0" selected>Select meat type</option>
                        <?php

                        $weight_rs = Databases::search("SELECT * FROM `meat_type` ORDER BY `meat_type_name` ASC");
                        $weight_num = $weight_rs->num_rows;

                        for ($i = 0; $i < $weight_num; $i++) {

                          $weight_data = $weight_rs->fetch_assoc();
                          ?>
                          <option value="<?php echo $weight_data["meat_type_id"] ?>">
                            <?php echo $weight_data["meat_type_name"] ?>
                          </option>
                          <?php
                        }

                        ?>
                      </select>
                      <label for="floatingSelect">Select meat type</label>
                    </div>

                    <button class="btn x rounded-0 mt-2 d-grid col-12" data-bs-toggle="modal"
                      data-bs-target="#weightModal">Add New Meat Type</button>

                    <!--Add Weight Modal-->

                    <div class="modal fade" id="weightModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                      aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa fa-plus-circle"
                                aria-hidden="true"></i> Add New Meat Type</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="col-12">
                              <div class="form-floating">
                                <input type="text" class="form-control rounded-0" id="wname"
                                  placeholder="title of the product">
                                <label for="wname">Meat Name</label>
                              </div>
                            </div>


                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn x" onclick="AddMeat();"><i class="fa fa-plus-circle"
                                aria-hidden="true"></i> Add</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!--Add Weight Modal-->
                  </div>

                  <div class="col-12 mt-3">
                    <div class="form-floating">
                      <textarea class="form-control rounded-0" placeholder="Short Description" id="sd"
                        style="height: 100px"></textarea>
                      <label for="sd">Description</label>
                    </div>
                  </div>


                  <div class="col-12 text-end mt-4">
                    <button class="btn rounded-1 fw-bold x col-md-2" onclick="addProduct();"><i class="fa fa-plus-circle"
                        aria-hidden="true"></i>
                      ADD</button>
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