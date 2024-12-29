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

          <?php
          require "nav.php";
          ?>

          <div class="container-fluid">
            <!--  Row 1 -->
            <div class="row">
              <div class="col-lg-8 d-flex align-items-strech">
                <div class="card w-100">
                  <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                      <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Sales Overview</h5>
                      </div>
                    </div>
                    <div id="chart"></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4">
                <div class="row">
                  <div class="col-lg-12">
                    <?php

                    date_default_timezone_set("Pacific/Auckland"); // Set the timezone to New Zealand
                    $today = date("Y-m-d");
                    $thismonth = date("m");
                    $thisyear = date("Y");

                    // Initialize variables
                    $a = "0";
                    $b = "0";
                    $c = "0";
                    $e = "0";
                    $f = "0";

                    // Query for today's invoices
                    $invoice_rs = Databases::search("SELECT * FROM invoice WHERE DATE(invoice_date) = '$today'");
                    if ($invoice_rs->num_rows >= 1) {
                      $sdf = $invoice_rs->fetch_assoc();
                      $a = $sdf["invoice_total"];
                    }

                    // Query for this month's invoices
                    $invoice_rs2 = Databases::search("
                    SELECT * FROM invoice 
                    WHERE DATE_FORMAT(invoice_date, '%Y-%m') = '$thisyear-$thismonth'");
                    if ($invoice_rs2->num_rows >= 1) {
                      $sdf = $invoice_rs2->fetch_assoc();
                      $b = $sdf["invoice_total"];
                    }


                    ?>
                    <!-- Yearly Breakup -->
                    <div class="card overflow-hidden border shadow">
                      <div class="card-body p-4">
                        <h5 class="card-title mb-9 fw-semibold">Daily Breakup</h5>
                        <div class="row align-items-center">
                          <div class="col-8">
                            <h4 class="fw-semibold mb-3">NZD <?php echo number_format($a, 2) ?></h4>
                            <div class="d-flex align-items-center">
                              <div class="me-4">
                                <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                <span class="fs-2"><?php echo $thisyear ?></span>
                              </div>

                            </div>
                          </div>
                          <div class="col-4">
                            <div class="d-flex justify-content-center">
                              <div id="breakup"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <!-- Monthly Earnings -->
                    <div class="card border shadow">
                      <div class="card-body">
                        <div class="row alig n-items-start">
                          <div class="col-8">
                            <h5 class="card-title mb-9 fw-semibold"> Monthly Earnings </h5>
                            <h4 class="fw-semibold mb-3">NZD <?php echo number_format($b, 2) ?></h4>
                            <div class="d-flex align-items-center pb-1">

                            </div>
                          </div>
                          <div class="col-4">
                            <div class="d-flex justify-content-end">
                              <div
                                class="text-white bg-orange rounded-circle p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-currency-dollar fs-6"></i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div id="earning"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4 d-flex align-items-stretch">
                <div class="card w-100">
                  <div class="card-body p-4">
                    <div class="mb-4">
                      <h5 class="card-title fw-semibold">Recent Transactions</h5>
                    </div>
                    <ul class="timeline-widget mb-0 position-relative mb-n5">
                      <?php
                      $invoice_rs3 = Databases::search("SELECT * 
                      FROM `invoice` 
                      ORDER BY `invoice_date` DESC 
                      LIMIT 5;
                      ");
                      $invoice_num3 = $invoice_rs3->num_rows;
                      for ($x = 1; $x <= $invoice_num3; $x++) {
                        $invoice_data3 = $invoice_rs3->fetch_assoc();
                        // Original datetime string
                        $datetimeString = $invoice_data3["invoice_date"];

                        // Convert datetime string to a Unix timestamp
                        $timestamp = strtotime($datetimeString);

                        // Format the time portion using date() function
                        $formattedTime = date("H:i:s", $timestamp);
                        $datetime = $invoice_data3["invoice_date"]; // Example: 2024-12-05 14:30:00
                        $date = (new DateTime($datetime))->format('Y-m-d');

                        ?>
                        <li class="timeline-item d-flex position-relative overflow-hidden">
                          <div class="timeline-time text-dark flex-shrink-0 text-end"><?php echo $date; ?>
                          </div>
                          <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                            <span class="timeline-badge border-2 border border-primary flex-shrink-0 my-8"></span>
                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                          </div>
                          <div class="timeline-desc fs-3 text-dark mt-n1">NZD
                            <?php echo number_format($invoice_data3["invoice_total"], 2) ?> Payment received at
                            <?php echo $formattedTime; ?>

                          </div>
                        </li>
                        <?php
                      }
                      ?>


                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-8 d-flex align-items-stretch">
                <div class="card w-100">
                  <div class="card-body p-4">
                    <h5 class="card-title fw-semibold mb-4">Recent Transactions</h5>
                    <div class="table-responsive">
                      <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                          <tr>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Id</h6>
                            </th>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Invoice</h6>
                            </th>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Name</h6>
                            </th>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Status</h6>
                            </th>
                            <th class="border-bottom-0">
                              <h6 class="fw-semibold mb-0">Budget</h6>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $invoice_rs1 = Databases::search("SELECT * FROM invoice
                          INNER JOIN `order` ON `order`.order_code=invoice.payment_intent ORDER BY `invoice_date` DESC  LIMIT 5");
                          $invoice_num1 = $invoice_rs1->num_rows;
                          for ($x = 1; $x <= $invoice_num1; $x++) {
                            $invoice_data1 = $invoice_rs1->fetch_assoc();
                            ?>
                            <tr>

                              <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-0"><?php echo $x ?></h6>
                              </td>
                              <td class="border-bottom-0">
                                <h6 class="fw-semibold mb-1"><?php echo $invoice_data1['payment_intent'] ?></h6>
                                <span class="fw-normal"><?php echo $invoice_data1["invoice_date"] ?></span>
                              </td>
                              <td class="border-bottom-0">
                                <p class="mb-0 fw-normal"><?php echo $invoice_data1["user_email"] ?></p>
                              </td>
                              <td class="border-bottom-0">
                                <div class="d-flex align-items-center gap-2">
                                  <span class="badge bg-warning rounded-3 fw-semibold">Success</span>
                                </div>
                              </td>
                              <td class="border-bottom-0">
                                <span class="fw-semibold mb-0 text-black">NZD
                                  <?php echo number_format($invoice_data1["invoice_total"], 2) ?></span>
                              </td>
                              <?php
                          }
                          ?>

                          </tr>

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="row">

              <?php
              for ($x = 0; $x < 4; $x++) {
                ?>
                <div class="col-sm-6 col-xl-3">
                  <div class="card overflow-hidden rounded-2">
                    <div class="position-relative p-4 d-flex flex-row align-items-center" style="height:12rem;">
                      <a href="javascript:void(0)"><img src="assets-admin/images/products/ps4.jpg"
                          class="card-img-top rounded-0" alt="..."></a>
                      <a href="javascript:void(0)"
                        class="bg-green rounded-circle p-2 text-white d-inline-flex position-absolute bottom-0 end-0 mb-n3 me-3"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add To Cart"><i
                          class="ti ti-basket fs-4"></i></a>
                    </div>
                    <div class="card-body pt-3 p-4">
                      <h6 class="fw-semibold fs-4">Coir Peat - 5Kg</h6>
                      <div class="d-flex align-items-center justify-content-between">
                        <h6 class="fw-semibold fs-4 mb-0">$15 <span
                            class="ms-2 fw-normal text-muted fs-3"><del>$18</del></span></h6>
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
                          data-bs-target="#exampleModal">UPDATE</button>
                        <button class="btn tex-r p-1 rounded-0-5" data-bs-toggle="modal"
                          data-bs-target="#exampleModal3">DELETE</button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
              }
              ?>

            </div> -->

            <!-- Update product popup -->
            <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <div class="border-x log-link d-flex justify-content-center align-items-center h-100"
                                  onclick="triggerFileInput();"><span class="small">Main
                                    Image</span>
                                  <img src="" class="img-fluid h-100">
                                </div>
                              </div>
                              <div class="col-8 col-md-4  mb-2" style="height: 200px;">
                                <div class="border-x log-link d-flex justify-content-center align-items-center h-100"
                                  onclick="triggerFileInput();"><span class="small">Sub
                                    Image</span>
                                  <img src="" class="img-fluid h-100">
                                </div>
                              </div>
                              <div class="col-8 col-md-4 mb-2" style="height: 200px;">
                                <div class="border-x log-link d-flex justify-content-center align-items-center h-100"
                                  onclick="triggerFileInput();"><span class="small">Sub
                                    Image</span>
                                  <img src="" class="img-fluid h-100">
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
                          <div class="col-12 mt-3 mb-3">
                            <textarea class="form-control rounded-0" placeholder="Description" id="floatingTextarea2"
                              style="height: 100px"></textarea>
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
            </div> -->
            <!-- Update product popupend -->

            <!-- delete product modal -->
            <!-- <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            </div> -->
            <!-- delete product modal end -->

            <div class="py-6 px-6 text-center">
              <p class="mb-0 fs-4">Design and Developed by <a href="codylanka.com"
                  class="pe-1 text-primary text-decoration-underline">CL Solution.com</a> Distributed by <a
                  href="codylanka.com">CL Solution</a></p>
            </div>
          </div>
        </div>
      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

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