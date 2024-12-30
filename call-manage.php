<?php

session_start();
if (isset($_SESSION["a"])) {

  include "db.php";

  $uemail = $_SESSION["a"]["username"];

  $u_detail = Databases::search("SELECT * FROM `admin` WHERE `username`='" . $uemail . "'");

  if ($u_detail->num_rows == 1) {
    session_abort();

?>
    <!doctype html>
    <html lang="en">

    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>CODY ZEA || Call management</title>
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
                <div class="mb-1"><span class="h4 mb-9 fw-semibold">Call Management&nbsp;&nbsp;<i class="fa fa-archive"
                      aria-hidden="true"></i></span>
                </div>
                <div><span class="mb-9 text-dark-emphasis">You can manage clients here</span>
                </div>
              </div>

              <div class="col-12 border shadow py-4 px-4">

                <div class="row px-4">

                  <div class="col-12 col-md-6 mt-4 pe-3">
                    <div class="form-floating">
                      <input type="text" class="form-control border-dark rounded-0" id="name" placeholder="">
                      <label for="floatingInput" class="text-dark">NAME</label>
                    </div>
                  </div>

                  <div class="col-12 col-md-6 mt-4 ps-3">
                    <div class="form-floating">
                      <input type="text" class="form-control border-dark rounded-0" id="mobile" placeholder="">
                      <label for="floatingInput" class="text-dark">MOBILE</label>
                    </div>
                  </div>

                  <div class="col-12 col-md-6 mt-4 pe-3">
                    <div class="form-floating">
                      <select class="form-select rounded-0 text-dark border-dark" id="priority" aria-label="Floating label select example">
                        <option value="0" Selected>Not Selected</option>
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
                      <label for="floatingSelect" class="text-dark">Select Priority Level</label>
                    </div>
                  </div>

                  <div class="col-12 col-md-6 mt-4 ps-3">
                    <div class="form-floating">
                      <select class="form-select rounded-0 text-dark border-dark" id="s_type" aria-label="Floating label select example">
                        <option value="0" Selected>Not Selected</option>
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
                      <label for="floatingSelect" class="text-dark">Select System Type</label>
                    </div>
                  </div>

                  <div class="col-12 col-md-6 mt-4 pe-3">
                    <div class="form-floating">
                      <select class="form-select rounded-0 text-dark border-dark" id="district" aria-label="Floating label select example">
                        <option value="0" Selected>Not Selected</option>
                        <?php
                        $district_type_rs = Databases::search("SELECT * FROM `district`");
                        $district_type_num = $district_type_rs->num_rows;
                        for ($i = 0; $i < $district_type_num; $i++) {
                          $district_type_data = $district_type_rs->fetch_assoc();
                        ?>
                          <option value="<?php echo $district_type_data["district_id"] ?>">
                            <?php echo $district_type_data["district_name"] ?></option>

                        <?php
                        }
                        ?>

                      </select>
                      <label for="floatingSelect" class="text-dark">Select District</label>
                    </div>
                  </div>

                  <div class="col-12 col-md-6 mt-4 ps-3">
                    <div class="form-floating">
                      <input type="number" class="form-control border-dark rounded-0" id="budget" placeholder="">
                      <label for="floatingInput" class="text-dark">BUDGET</label>
                    </div>
                  </div>

                  <div class="col-12 mt-4">
                    <div class="form-floating">
                      <textarea class="form-control border-dark rounded-0" id="description" placeholder="" style="height: 100px;"></textarea>
                      <label for="description" class="text-dark">DESCRIPTION</label>
                    </div>
                  </div>

                  <div class="col-12 my-4 text-end">
                    <button class="btn btn-orange rounded-0 py-3 px-5" onclick="addCalls();" id="add_button">
                      ADD
                    </button>
                  </div>

                  <!-- Toast container -->
                  <div class="toast-container rounded-0">
                    <div id="custom-toast" class="toast align-items-center text-white bg-danger border-0 rounded-0 p-1" role="alert" aria-live="assertive" aria-atomic="true">
                      <div class="d-flex">
                        <div class="toast-body" id="toast_inner"></div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                      </div>
                    </div>
                  </div>

                  <div class="col-12 mb-5">
                    <div class="row justify-content-center align-items-center">
                      <div class="col-12 col-md-6">
                      <img src="assets-admin\call.svg" class="img-fluid">
                      </div>
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