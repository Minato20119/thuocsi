<?php
require 'dbcon.php';

if(isset($_POST['so_luong'])) {
    $query = "UPDATE order_confirmation SET `so_luong_chot`='" . $_POST['so_luong'] . "' WHERE `id_order_confirm`='" . $_POST['id'] . "'";
    $query_run = mysqli_query($con, $query);
}

if(isset($_POST['gia'])) {
    $query = "UPDATE order_confirmation SET `gia_chot`='" . $_POST['gia'] . "' WHERE `id_order_confirm`='" . $_POST['id'] . "'";
    $query_run = mysqli_query($con, $query);
}

if(isset($_POST['thue'])) {
    $query = "UPDATE order_confirmation SET `thue`='" . $_POST['thue'] . "' WHERE `id_order_confirm`='" . $_POST['id'] . "'";
    $query_run = mysqli_query($con, $query);
}


# add san pham vao order
if(isset($_POST['submit_order']))
{
    $sqlCheckOrderStatus = "SELECT * FROM order_confirmation WHERE status_product = 1 ORDER BY ten_san_pham ASC;";
    $resultOrderConfirm = mysqli_query($con, $sqlCheckOrderStatus);

    if (mysqli_num_rows($resultOrderConfirm) == 0) {
        $_SESSION['message'] = "Không có đơn hàng nào được tạo.";
        header("Location: order-confirmation.php");
        exit(0);
    }

    $user_ncc = "";
    $index = 0;
    $listUserTemp = array();

    foreach ($resultOrderConfirm as $orderConfirm) {
        $listUserTemp[$index++] = $orderConfirm['user_ncc'];
    }
    $listUsers = array_unique($listUserTemp);
    $today = date("Y-m-d H:i:s");

    foreach ($listUsers as $user) {
        $sqlInsertOrder = "INSERT INTO orders (`user_ncc`, `order_date`) VALUES ('$user', '$today');";
        $resultInsertOrder = mysqli_query($con, $sqlInsertOrder);

        if (!$resultInsertOrder) {
            $_SESSION['message'] = "Có lỗi xảy ra khi tạo đơn hàng";
            exit(0);
        }

        $sqlOrder = "SELECT * FROM orders WHERE user_ncc = '$user' AND order_date = '$today';";
        $resultOrder = mysqli_query($con, $sqlOrder);
        
        $order_id;
        foreach ($resultOrder as $order) {
            $order_id = $order['order_id'];
        }

        $sqlOrderConfirm = "SELECT * FROM order_confirmation WHERE status_product = 1 AND user_ncc = '$user';";
        $resultOrderConfirmByUser = mysqli_query($con, $sqlOrderConfirm);

        if (mysqli_num_rows($resultOrderConfirmByUser) > 0) {
            foreach ($resultOrderConfirmByUser as $product) {
                $tenSP = $product['ten_san_pham'];
                $image = $product['image'];
                $donVi = $product['don_vi'];
                $soLuong = $product['so_luong_chot'];
                $gia = $product['gia_chot'];
                $hsd = $product['hsd'];
                $kho = $product['kho'];

                # insert into order detail
                $sqlInsertOrderDetails = "INSERT INTO orders_details (`order_id`, `ten_san_pham`, `image`, `don_vi`, `so_luong_chot`, `gia_chot`, `hsd`, `kho`) 
                VALUES ($order_id, '$tenSP', '$image', '$donVi', $soLuong, $gia, '$hsd','$kho');";   

                $resultInsertOrderDetail = mysqli_query($con, $sqlInsertOrderDetails);

                if (!$resultInsertOrderDetail) {
                    $_SESSION['message'] = "Có lỗi xảy ra khi tạo Order detail.";
                    header("Location: order-confirmation.php");
                    exit(0);
                }
            }
        }
    }

    $sqlUpdateStatusProduct = "UPDATE order_confirmation SET status_product = 3 WHERE status_product = 1;";
    $resultUpdate = mysqli_query($con, $sqlUpdateStatusProduct);

    if ($resultUpdate) {
        $_SESSION['message'] = "Tạo đơn hàng thành công.";
        header("Location: order-confirmation.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Có lỗi xảy ra khi change status product.";
        header("Location: order-confirmation.php");
        exit(0);
    }

}


?>