<?php
    # submit sản phẩm để admin duyệt
    session_start();
    require 'dbcon.php';

    if(isset($_POST['spBaoGiaId']))
    {
        $listCheckboxSelected = $_POST['spBaoGiaId'];
        $userName = $_SESSION['username'];
        $campaignId = $_SESSION['campaign'];

        foreach ($listCheckboxSelected as $checkBoxSelected) {
            $product_id = $checkBoxSelected;
            $queryUpdateToLinkTable = "UPDATE link_spbaogia_ncc SET status_baogia = 1 WHERE product_id = $product_id AND campaign_id = $campaignId AND name_ncc = '$userName';";
            $query_run = mysqli_query($con, $queryUpdateToLinkTable);

            $querySelect = "SELECT * FROM spbaogia LEFT JOIN link_spbaogia_ncc
            ON (spbaogia.id = link_spbaogia_ncc.product_id) 
            AND (link_spbaogia_ncc.name_ncc = NULL OR link_spbaogia_ncc.name_ncc = '$userName') 
            WHERE spbaogia.campaign_id = $campaignId AND product_id = $product_id;";
            $resultSpBaoGia = mysqli_query($con, $querySelect);

            # insert vao table order-confirmation
            if (mysqli_num_rows($resultSpBaoGia) > 0) {

                foreach ($resultSpBaoGia as $sanpham) {

                    $tenSP = $sanpham['ten_san_pham'];
                    $image = $sanpham['image'];
                    $don_vi = $sanpham['don_vi'];
                    $hsd = $sanpham['hsd'];
                    $kho = $sanpham['kho'];

                    $so_luong_chot;
                    $gia_chot;

                    $soLuongDefault = $sanpham['so_luong'];
                    $giaDefault = $sanpham['gia'];

                    $soLuongNCC = $sanpham['bg_so_luong'];
                    $giaNCC = $sanpham['bg_price'];

                    $nhaCungCapInDB = $sanpham['name_ncc'];
                    $nhaCungCapSession = $userName;

                    # get so luong
                    if ($nhaCungCapInDB == $nhaCungCapSession && !empty($soLuongNCC)) {
                        $so_luong_chot = $soLuongNCC;
                    } else {
                        $so_luong_chot = $soLuongDefault;
                    }

                    # get price
                    if ($nhaCungCapInDB == $nhaCungCapSession && !empty($giaNCC)) {
                        $gia_chot = $giaNCC;
                    } else {
                        $gia_chot = $giaDefault;
                    }

                    $queryInsertOrderConfirmation = "INSERT INTO `order_confirmation` 
                    (`id_spbaogia`, `user_ncc`, `ten_san_pham`, `image`, `don_vi`, `so_luong_chot`, `gia_chot`, `hsd`, `kho`) 
                    VALUES ('$product_id', '$userName', '$tenSP', '$image', '$don_vi', $so_luong_chot, $gia_chot, '$hsd', '$kho');";
                    mysqli_query($con, $queryInsertOrderConfirmation);
                    echo 'Submit_product_quotes: Add id ' . $product_id . 'success to Confirm Order<br>';
                    break;
                }
            }
        }
        $_SESSION['message'] = "Báo Giá Successfully!";
        header("Location: product-quotes.php");
    }
?>