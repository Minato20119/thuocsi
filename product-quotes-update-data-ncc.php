<?php
    session_start();
    require 'dbcon.php';

    if(isset($_POST['so_luong'])) {
        $userName = $_SESSION['username'];
        $product_id = trim($_POST['id']);
        $soLuong = trim($_POST['so_luong']);
        echo '<br>soLuong: ' . $soLuong;

        # check campaign id from spbaogia chua bao gia
        $sqlGetCampaignID = "SELECT id, ten_san_pham, so_luong, gia, kho, STATUS, campaign_id FROM spbaogia WHERE STATUS = 2 AND id = $product_id;";
        $result_sp_baogia = mysqli_query($con, $sqlGetCampaignID); 

        $campaignId;
        if (mysqli_num_rows($result_sp_baogia) > 0) {
            foreach ($result_sp_baogia as $sanpham) {
                $campaignId = $sanpham['campaign_id'];
                break;
            }
        }

        # check campaign exist on link spbaogia
        $sqlCheckExist = "SELECT * FROM link_spbaogia_ncc WHERE product_id = $product_id AND name_ncc = '$userName' AND campaign_id = $campaignId;";
        $query_run = mysqli_query($con, $sqlCheckExist);

        if(mysqli_num_rows($query_run) <= 0) {
            $sqlInsertData = "INSERT INTO link_spbaogia_ncc (`product_id`, `bg_so_luong`, `name_ncc`, `campaign_id`) 
            VALUES ($product_id, $soLuong, '$userName', $campaignId);";
            echo '<br>Before: sqlInsertData: ' . $sqlInsertData;
            mysqli_query($con, $sqlInsertData);
        } else { 
            $sqlUpdateData = "UPDATE link_spbaogia_ncc 
            SET bg_so_luong = '" . $_POST['so_luong'] . "' WHERE product_id = '$product_id' and name_ncc = '$userName' and campaign_id = $campaignId;";
            echo '<br>Before: sqlUpdateData: ' . $sqlUpdateData;
            mysqli_query($con, $sqlUpdateData);
        }
    }

    if(isset($_POST['gia'])) {
        $userName = $_SESSION['username'];
        $product_id = trim($_POST['id']);
        $price = trim($_POST['gia']);

        echo '<br>price: ' . $price;

        # check campaign id from spbaogia chua bao gia
        $sqlGetCampaignID = "SELECT id, ten_san_pham, so_luong, gia, kho, STATUS, campaign_id FROM spbaogia WHERE STATUS = 2 AND id = $product_id;";
        $result_sp_baogia = mysqli_query($con, $sqlGetCampaignID); 

        $campaignId;
        if (mysqli_num_rows($result_sp_baogia) > 0) {
            foreach ($result_sp_baogia as $sanpham) {
                $campaignId = $sanpham['campaign_id'];
                break;
            }
        }

        $sqlCheckExist = "SELECT * FROM link_spbaogia_ncc WHERE product_id = $product_id AND name_ncc = '$userName' AND campaign_id = $campaignId;";
        $query_run = mysqli_query($con, $sqlCheckExist);

        if(mysqli_num_rows($query_run) <= 0) {
            $sqlInsertData = "INSERT INTO link_spbaogia_ncc (`product_id`, `bg_price`, `name_ncc`, `campaign_id`) 
            VALUES ($product_id, $price, '$userName', $campaignId);";
            echo '<br>Before: sqlInsertData: ' . $sqlInsertData;
            mysqli_query($con, $sqlInsertData);
        } else {
            $sqlUpdateData = "UPDATE link_spbaogia_ncc 
            SET bg_price = '" . $_POST['gia'] . "' WHERE product_id = '$product_id' and name_ncc = '$userName' and campaign_id = $campaignId;";
            echo '<br>Before: sqlUpdateData: ' . $sqlUpdateData;
            mysqli_query($con, $sqlUpdateData);
        }
    }
?>