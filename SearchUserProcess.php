<?php
require_once "db.php";
session_start();

if (isset($_GET["ukey"])) {


  $key = $_GET["ukey"];


  $user_rs = Databases::search("SELECT * FROM `user` LEFT JOIN `address` ON `user`.`email` = `address`.`user_email` 
                                    LEFT JOIN `city` ON `city`.`city_id`=`address`.`city_id` WHERE `user`.`email` LIKE '%" . $key . "%'");
  $user_num = $user_rs->num_rows;
  ?>

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

  <?php

} else {
  echo "Please Try Again";
}





?>