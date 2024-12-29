<?php
require_once "db.php";
session_start();

if (isset($_GET["key"])) {


    $key = $_GET["key"];

        ?>

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="table-responsive bg-white">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Invoice ID</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Date</th>
                                <th scope="col">View</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $invoice_rs = Databases::search("SELECT * FROM invoice
                                                                                    INNER JOIN `order` ON `order`.id=invoice.order_id
                                                                                    INNER JOIN `user` ON `user`.`email`=`order`.user_email WHERE `invoice_id` LIKE '%" . $key . "%'");
                            $invoice_num = $invoice_rs->num_rows;
                            for ($x = 1; $x <= $invoice_num; $x++) {
                                $invoice_data = $invoice_rs->fetch_assoc();
                                ?>
                                <tr id="UserResult">
                                    <td>
                                        <?php echo $x ?>
                                    </td>
                                    <th scope="row">
                                        <?php echo $invoice_data['payment_intent'] ?>
                                    </th>
                                    <td>
                                        <?php echo $invoice_data["first_name"] . " " . $invoice_data["last_name"] ?></br>
                                        <?php echo $invoice_data["email"]; ?>
                                    </td>
                                    <td>NZD
                                        <?php echo $invoice_data["invoice_total"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $invoice_data["invoice_date"] ?>
                                    </td>
                                    <td><a class="btn x py-1 px-3 rounded-1"
                                            href="invoice.php?in_id=<?php echo $invoice_data['invoice_id'] ?>" target="_blank"><i
                                                class="fa fa-download" aria-hidden="true"></i></a>
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

        
        <?php



} else {
    echo "PLease Try Again";
}


?>