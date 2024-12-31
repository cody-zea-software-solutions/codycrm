<?php
session_start();
if (isset($_SESSION["a"])) {

    include "db.php";
    $uemail = $_SESSION["a"]["username"];
    $u_detail = Databases::search("SELECT * FROM `admin` WHERE `username`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {

        // Directly capture the form data
        $keyword = $_POST['keyword'];
        $type = $_POST['type'];

        $q = "SELECT * FROM calls
                INNER JOIN district ON district.district_id = calls.district_id
                INNER JOIN prioraty ON prioraty.prioraty_id=calls.prioraty_id
                INNER JOIN system_type ON system_type.type_id=calls.system_id
                INNER JOIN admin ON admin.admin_id=calls.user_id ";
        if ($type == 1) {
            $q .= "WHERE name LIKE '%$keyword%'  ";
        } else {
            $q .= "WHERE call_code LIKE '%$keyword%'  ";
        }

        $q .= "ORDER BY `date_time` DESC; ";

        $data_r = Databases::search($q);
        if ($data_r->num_rows > 0) {

            for ($x = 1; $x <= $data_r->num_rows; $x++) {
                $row_d = $data_r->fetch_assoc();
?>
                <tr>
                    <th scope="row"><?php echo $x; ?></th>
                    <td><?php echo $row_d['call_code'] ?></td>
                    <td><?php echo $row_d['name'] ?></td>
                    <td><?php echo $row_d['district_name'] ?></td>
                    <td><?php echo $row_d['mobile'] ?></td>
                    <td><?php echo $row_d['date_time'] ?></td>
                    <td><?php echo $row_d['budget'] ?></td>
                    <td><?php echo $row_d['prioraty_name'] ?></td>
                    <td><?php echo $row_d['type_name'] ?></td>
                    <td><?php echo $row_d['description'] ?></td>
                    <td><?php echo $row_d['username'] ?></td>
                </tr>
<?php
            }
        } else {
            echo "No results were found.";
        }
    }
}
?>