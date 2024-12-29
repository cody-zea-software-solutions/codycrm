<?php

session_start();
if (isset($_SESSION["a"])) {

    include "db.php";

    $uemail = $_SESSION["a"]["email"];

    $u_detail = Databases::search("SELECT * FROM `admin` WHERE `email`='" . $uemail . "'");

    if ($u_detail->num_rows == 1) {
        session_abort();

        $in_id = $_GET['in_id'];

        $in_data = Databases::search("SELECT * FROM invoice
        INNER JOIN `order` ON `order`.id=invoice.order_id
        INNER JOIN `user` ON `user`.`email`=`order`.user_email
        INNER JOIN address ON address.user_email=`user`.email
        INNER JOIN city ON city.city_id=address.city_id WHERE `payment_intent`='$in_id'");
        $in_det = $in_data->fetch_assoc();

        $price = 0;

        ?>

        <!doctype html>
        <html lang="en">

        <head>
        </head>

        <title>BOOZEBITES New Zealand || Admin-Panel</title>
        <link rel="shortcut icon" href="../assets/images/logos/favicon.png" type="image/x-icon">

        <body>


            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title> Order confirmation </title>
            <meta name="robots" content="noindex,nofollow" />
            <meta name="viewport" content="width=device-width; initial-scale=1.0;" />
            <style type="text/css">
                @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);

                body {
                    margin: 0;
                    padding: 0;
                    background: #e1e1e1;
                }

                div,
                p,
                a,
                li,
                td {
                    -webkit-text-size-adjust: none;
                }

                .ReadMsgBody {
                    width: 100%;
                    background-color: #ffffff;
                }

                .ExternalClass {
                    width: 100%;
                    background-color: #ffffff;
                }

                body {
                    width: 100%;
                    height: 100%;
                    background-color: #e1e1e1;
                    margin: 0;
                    padding: 0;
                    -webkit-font-smoothing: antialiased;
                }

                html {
                    width: 100%;
                }

                p {
                    padding: 0 !important;
                    margin-top: 0 !important;
                    margin-right: 0 !important;
                    margin-bottom: 0 !important;
                    margin-left: 0 !important;
                }

                .visibleMobile {
                    display: none;
                }

                .hiddenMobile {
                    display: block;
                }

                @media only screen and (max-width: 600px) {
                    body {
                        width: auto !important;
                    }

                    table[class=fullTable] {
                        width: 96% !important;
                        clear: both;
                    }

                    table[class=fullPadding] {
                        width: 85% !important;
                        clear: both;
                    }

                    table[class=col] {
                        width: 45% !important;
                    }

                    .erase {
                        display: none;
                    }
                }

                @media only screen and (max-width: 420px) {
                    table[class=fullTable] {
                        width: 100% !important;
                        clear: both;
                    }

                    table[class=fullPadding] {
                        width: 85% !important;
                        clear: both;
                    }

                    table[class=col] {
                        width: 100% !important;
                        clear: both;
                    }

                    table[class=col] td {
                        text-align: left !important;
                    }

                    .erase {
                        display: none;
                        font-size: 0;
                        max-height: 0;
                        line-height: 0;
                        padding: 0;
                    }

                    .visibleMobile {
                        display: block !important;
                    }

                    .hiddenMobile {
                        display: none !important;
                    }
                }
            </style>


            <!-- Header -->
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
                <tr>
                    <td height="20"></td>
                </tr>
                <tr>
                    <td>
                        <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                            bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
                            <tr class="hiddenMobile">
                                <td height="40"></td>
                            </tr>
                            <tr class="visibleMobile">
                                <td height="30"></td>
                            </tr>

                            <tr>
                                <td>
                                    <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                                        class="fullPadding">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <table width="220" border="0" cellpadding="0" cellspacing="0" align="left"
                                                        class="col">
                                                        <tbody>
                                                            <tr>
                                                                <td align="left"> <img src="../assets/images/logos/favicon.png"
                                                                        width="32" height="32" alt="logo" border="0" /></td>
                                                            </tr>
                                                            <tr class="hiddenMobile">
                                                                <td height="40"></td>
                                                            </tr>
                                                            <tr class="visibleMobile">
                                                                <td height="20"></td>
                                                            </tr>
                                                            <tr>
                                                                <td
                                                                    style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                                    Hello,
                                                                    <?php echo $in_det['first_name'], ' ', $in_det['last_name'] ?>
                                                                    <br>
                                                                    <?php echo $in_det['email'] ?>
                                                                    <br> Thank you for shopping from our store and for your
                                                                    order.
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <table width="220" border="0" cellpadding="0" cellspacing="0" align="right"
                                                        class="col">
                                                        <tbody>
                                                            <tr class="visibleMobile">
                                                                <td height="20"></td>
                                                            </tr>
                                                            <tr>
                                                                <td height="5"></td>
                                                            </tr>
                                                            <tr>
                                                                <td
                                                                    style="font-size: 21px; color: #ff0000; letter-spacing: -1px; font-family: 'Open Sans', sans-serif; line-height: 1; vertical-align: top; text-align: right;">
                                                                    Invoice
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                            <tr class="hiddenMobile">
                                                                <td height="50"></td>
                                                            </tr>
                                                            <tr class="visibleMobile">
                                                                <td height="20"></td>
                                                            </tr>
                                                            <tr>
                                                                <td
                                                                    style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
                                                                    <small>ORDER</small>
                                                                    <?php echo $in_det['payment_intent'] ?><br />
                                                                    <small><?php echo $in_det['invoice_date'] ?></small>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!-- /Header -->
            <!-- Order Details -->
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
                <tbody>
                    <tr>
                        <td>
                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                                bgcolor="#ffffff">
                                <tbody>
                                    <tr>
                                    <tr class="hiddenMobile">
                                        <td height="60"></td>
                                    </tr>
                                    <tr class="visibleMobile">
                                        <td height="40"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                                                class="fullPadding">
                                                <tbody>
                                                    <tr>
                                                        <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;"
                                                            width="52%" align="left">
                                                            Item
                                                        </th>
                                                        <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                            align="left">
                                                            UNIT PRICE </th>
                                                        <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                            align="center">
                                                            Quantity
                                                        </th>
                                                        <th style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                                            align="right">
                                                            Subtotal
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td height="1" style="background: #bebebe;" colspan="4"></td>
                                                    </tr>
                                                    <tr>
                                                        <td height="10" colspan="4"></td>
                                                    </tr>

                                                    <?php

                                                    $item_r = Databases::search("SELECT product_name,qty,price,meat_type_name,cook_type_name,box_type_name,preference_name FROM order_item
                                                    INNER JOIN `order` ON `order`.id=order_item.order_id
                                                    INNER JOIN price_table ON price_table.product_product_id=order_item.price_table_product_product_id
                                                    AND price_table.box_type_box_type_id=order_item.price_table_box_type_box_type_id
                                                    INNER JOIN product ON product.product_id=price_table.product_product_id
                                                    INNER JOIN box_type ON box_type.box_type_id=price_table.box_type_box_type_id
                                                    INNER JOIN cook_type ON cook_type.cook_type_id=product.cook_type_id
                                                    INNER JOIN meat_type ON meat_type.meat_type_id=product.meat_type_id
                                                    INNER JOIN preference ON preference.preference_id=order_item.preference_preference_id
                                                    WHERE `order`.`order_code`='$in_id' ");

                                                    for ($x = 0; $x < $item_r->num_rows; $x++) {
                                                        $item = $item_r->fetch_assoc();
                                                        $sp = $item['price']*$item['qty'];
                                                        ?>

                                                        <tr>


                                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #ff0000;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                                                class="article">
                                                                <?php echo $item['product_name'] ?>
                                                                <small
                                                                    style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;"><br><?php echo $item['cook_type_name'], ' ', $item['meat_type_name'], ' ', $item['box_type_name'], ' ', $item['preference_name'] ?></small>
                                                            </td>
                                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                                                align="center">NZD <?php echo number_format($item['price'], 2) ?></td>
                                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                                                align="center"><?php echo $item['qty'] ?></td>
                                                            <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;"
                                                                align="right">NZD <?php echo number_format($sp,2) ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4"></td>
                                                        </tr>

                                                        <?php

                                                        $price = $price + $sp;
                                                    }

                                                    ?>

                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- /Order Details -->
            <!-- Total -->
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
                <tbody>
                    <tr>
                        <td>
                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                                bgcolor="#ffffff">
                                <tbody>
                                    <tr>
                                        <td>

                                            <!-- Table Total -->
                                            <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                                                class="fullPadding">
                                                <tbody>
                                                    <tr>
                                                        <td
                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                            SUBTOTAL in NZD 
                                                        </td>
                                                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;"
                                                            width="80">
                                                             <?php echo number_format($price, 2) ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                            SHIPPING
                                                        </td>
                                                        <td style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;"
                                                            width="80"> +6.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                            DISCOUNT
                                                        </td>
                                                        <td
                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                                             -<?php echo number_format($in_det['discount'], 2) ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td
                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                                            <strong>GRAND TOTAL</strong>
                                                        </td>
                                                        <td
                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                                            <strong>
                                                                <?php echo number_format($price + 6 - $in_det['discount'], 2); ?>
                                                            </strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!-- /Table Total -->

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- /Total -->
            <!-- Information -->
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
                <tbody>
                    <tr>
                        <td>
                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                                bgcolor="#ffffff">
                                <tbody>
                                    <tr>
                                    <tr class="hiddenMobile">
                                        <td height="60"></td>
                                    </tr>
                                    <tr class="visibleMobile">
                                        <td height="40"></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                                                class="fullPadding">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <table width="220" border="0" cellpadding="0" cellspacing="0"
                                                                align="left" class="col">

                                                                <tbody>
                                                                    <tr>
                                                                        <td
                                                                            style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                                                            <strong>SHIPPING INFORMATION</strong>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="100%" height="10"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                                                            <?php echo $in_det['first_name'], '  ', $in_det['last_name'] ?><br>
                                                                            <?php echo $in_det['first_line'], ' , ', $in_det['second_line']; ?>,
                                                                            <br>
                                                                            <?php echo $in_det['city_name']; ?><br> T:
                                                                            <?php echo $in_det['mobile']; ?>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>


                                                            <table width="220" border="0" cellpadding="0" cellspacing="0"
                                                                align="right" class="col">
                                                                <tbody>
                                                                    <tr class="visibleMobile">
                                                                        <td height="20"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="font-size: 11px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                                                            <strong> <a href="#"
                                                                                    class="">BOOZEBITES CO NZ</a> </strong>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="100%" height="10"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td
                                                                            style="font-size: 12px; font-family: 'Open Sans', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                                                            BoozeBites<br> Another Place<br> T: 202-555-0171
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td width="100%" height="10"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                    <tr class="hiddenMobile">
                                        <td height="60"></td>
                                    </tr>
                                    <tr class="visibleMobile">
                                        <td height="30"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- /Information -->
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">

                <tr>
                    <td>
                        <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                            bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                            <tr>
                                <td>
                                    <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                                        class="fullPadding">
                                        <tbody>
                                            <tr>
                                                <td
                                                    style="font-size: 12px; color: #5b5b5b; font-family: 'Open Sans', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                    Have a nice day.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr class="spacer">
                                <td height="50"></td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="20"></td>
                </tr>
            </table>

        </body>

        </html>

        <?php
    }
}

?>