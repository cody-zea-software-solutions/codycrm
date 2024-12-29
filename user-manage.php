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

            <div class="row">
              <div class="col-12 text-center mb-3">
                <div class="mb-1"><span class="h4 mb-9 fw-semibold">Manage Users&nbsp;&nbsp;<i class="fa fa-user"
                      aria-hidden="true"></i></span>
                </div>
                <div><span class="mb-9 text-dark-emphasis">You can manage users here</span>
                </div>
              </div>
            </div>

            <div class="row px-3">
              <div class="col-12 py-4 mb-3 border shadow">

                <div class="row p-2 d-flex flex-row justify-content-end">
                  <div class="col-12 col-lg-6">

                    <form action="">
                      <div class="input-group rounded border rounded-5">
                        <input type="search" class="form-control border-0 border-end" placeholder="Search by email"
                          aria-label="Search" id="ukey" aria-describedby="search-addon" />
                        <span class="input-group-text bg-orange btn border-0" onclick="SearchUser();" id="search-addon">
                          <i class="fas fa-search text-white"></i>
                        </span>
                      </div>
                    </form>
                  </div>
                </div>

                <div class="row" id="userarea">
                  <section>
                    <div class="gradient-custom-1 h-100">
                      <div class="mask d-flex align-items-center h-100">
                        <div class="container">
                          <div class="row justify-content-center">
                            <div class="col-12">
                              <div class="table-responsive bg-white">
                                <table class="table mb-0">
                                  <thead>
                                    <tr>
                                      <th scope="col"></th>
                                      <th scope="col">FULL NAME</th>
                                      <th scope="col">EMAIL</th>
                                      <th scope="col">ADDRESS</th>
                                      <th scope="col">STATUS</th>
                                    </tr>
                                  </thead>
                                  <tbody>



                                    <?php
                                    $user_rs = Databases::search("SELECT * FROM `user` LEFT JOIN `address` ON `user`.`email` = `address`.`user_email` 
                                    LEFT JOIN `city` ON `city`.`city_id`=`address`.`city_id`");
                                    $user_num = $user_rs->num_rows;

                                    for ($i = 0; $i < $user_num; $i++) {
                                      $user_data = $user_rs->fetch_assoc();
                                      $umail = $user_data["email"];
                                      ?>
                                      <tr id="userarea">
                                        <td>
                                          <?php echo $i + 1 ?>
                                        </td>
                                        <td>
                                          <?php echo $user_data["first_name"] . " " . $user_data["last_name"] ?>
                                        </td>
                                        <th scope="row">
                                          <?php echo $user_data["email"] ?>
                                        </th>
                                        <td>
                                          <?php echo $user_data["first_line"] . " , " . $user_data["second_line"] . " , " . $user_data["city_name"] ?>
                                        </td>
                                        <td>
                                          <?php
                                          if ($user_data["status"] == 1) {
                                            ?>
                                            <a class="btn ub-btn p-1"
                                              onclick="userblockandunblcok('<?php echo $user_data['email']; ?>', '<?php echo $user_data['status']; ?>');"
                                              class="btn ub-btn p-1">BLOCK</a>
                                            <?php
                                          } else {
                                            ?>
                                            <a class="btn ub-btn p-1"
                                              onclick="userblockandunblcok('<?php echo $user_data['email']; ?>', '<?php echo $user_data['status']; ?>');">UNBLOCK</a>
                                            <?php
                                          }
                                          ?>
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