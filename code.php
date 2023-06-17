<?php
session_start();
require 'dbcon.php';

if(isset($_POST['delete_sanpham']))
{
    $student_id = mysqli_real_escape_string($con, $_POST['delete_sanpham']);
        
    $query = "DELETE FROM sanpham WHERE id='$student_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Sản Phẩm '$student_id' Deleted Successfully";
        header("Location: index.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Sản Phẩm Not Deleted";
        header("Location: index.php");
        exit(0);
    }
}

if(isset($_POST['update_product']))
{
    $student_id = mysqli_real_escape_string($con, $_POST['student_id']);

    $ten_san_pham = mysqli_real_escape_string($con, $_POST['ten_san_pham']);
    $image = mysqli_real_escape_string($con, $_POST['image']);
    $khu_vuc = mysqli_real_escape_string($con, $_POST['khu_vuc']);
    $trang_thai = mysqli_real_escape_string($con, $_POST['trang_thai']);
    $tinh_trang = mysqli_real_escape_string($con, $_POST['tinh_trang']);

    $query = "UPDATE sanpham SET ten_san_pham='$ten_san_pham', image='$image', khu_vuc='$khu_vuc', trang_thai='$trang_thai', tinh_trang='$tinh_trang' WHERE id='$student_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Sản Phẩm Updated Successfully";
        header("Location: index.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Sản Phẩm Not Updated";
        header("Location: index.php");
        exit(0);
    }

}


if(isset($_POST['save_product']))
{
    $ten_san_pham = mysqli_real_escape_string($con, $_POST['ten_san_pham']);
    $image = mysqli_real_escape_string($con, $_POST['image']);
    $khu_vuc = mysqli_real_escape_string($con, $_POST['khu_vuc']);
    $trang_thai = mysqli_real_escape_string($con, $_POST['trang_thai']);
    $tinh_trang = mysqli_real_escape_string($con, $_POST['tinh_trang']);

    $query = "INSERT INTO sanpham (ua_thich,ten_san_pham,image,khu_vuc,trang_thai,tinh_trang) VALUES (0,'$ten_san_pham','$image','$khu_vuc','$trang_thai','$tinh_trang')";

    $query_run = mysqli_query($con, $query);
    if($query_run)
    {
        $_SESSION['message'] = "Sản Phẩm Created Successfully";
        header("Location: sanpham-create.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Sản Phẩm Not Created";
        header("Location: sanpham-create.php");
        exit(0);
    }
}


if(isset($_POST['import_product'])) {

    $excelFile = "";

    // Kiểm tra dữ liệu có bị lỗi không
    if ($_FILES["fileToUpload"]['error'] != 0)
    {
        $_SESSION['message'] = "Dữ liệu upload bị lỗi";
        header("Location: import-sanpham.php");
        exit(0);
    }

    $target_dir = "uploads/";
    $fileName = basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $fileName;
    $allowUpload = true;
    
    // Lấy phần mở rộng của file
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Cỡ lớn nhất được upload (bytes), max 20MB
    $maxfilesize = 20000000;
    
    // Những loại file được phép upload
    $allowtypes = array('xlsx');

    if (strlen($fileType) == 0) {
        $_SESSION['message'] = "File chưa được chọn, vui lòng chọn file .xlsx";
        header("Location: import-sanpham.php");
        exit(0);
    }
    
    // Kiểm tra kiểu file
    if (!in_array( $fileType, $allowtypes ))
    {
        $_SESSION['message'] = "Không thể upload file '" . $target_file . "'. Chỉ được upload các định dạng xlsx";
        header("Location: import-sanpham.php");
        exit(0);
    }
    
    // Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
    if ($_FILES["fileToUpload"]["size"] > $maxfilesize)
    {
        $_SESSION['message'] = "Không được upload lớn hơn $maxfilesize (bytes).";
        header("Location: import-sanpham.php");
        exit(0);
    }
    
    if ($allowUpload) {
        require('ExcelAction.php');    

        if (file_exists($target_file))
        {
            $time = date("Y-m-d_h-m-s", time()) . "_";
            $excelFile = $target_dir . $time . $fileName;
            
            // Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $excelFile)) {
                ExcelAction::readExcelAndInsertDb($excelFile);
                $_SESSION['message'] = "File ". $excelFile ." Đã upload thành công.";
                header("Location: import-sanpham.php");
                exit(0);
            } else {
                echo "Có lỗi xảy ra khi upload file.";
                $_SESSION['message'] = "Có lỗi xảy ra khi upload file.";
                header("Location: import-sanpham.php");
                exit(0);
            }

        } else {
            $excelFile = $target_file;
            // Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $excelFile)) {
                ExcelAction::readExcelAndInsertDb($excelFile);
                $_SESSION['message'] = "File ". basename( $_FILES["fileToUpload"]["name"])." Đã upload thành công.";
                header("Location: import-sanpham.php");
                exit(0);
            } else {
                echo "Có lỗi xảy ra khi upload file.";
                $_SESSION['message'] = "Có lỗi xảy ra khi upload file.";
                header("Location: import-sanpham.php");
                exit(0);
            }
        }
    }
}

# add sản phẩm vào list view
if(isset($_POST['add_product_to_list']))
{
    $product_id = mysqli_real_escape_string($con, $_POST['add_product_to_list']);
    $query = "UPDATE sanpham SET status_add_list = 1 WHERE id = $product_id;";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        echo 'Add Sản Phẩm ' . $product_id . ' to List successfully';
        // $_SESSION['message'] = "Add Sản Phẩm '$product_id' to List successfully";
        // header("Location: products.php");
        exit(0);
    }
    else
    {
        echo 'Có lỗi xảy ra khi add sản phẩm vào list.';
        // $_SESSION['message'] = "Có lỗi xảy ra khi add sản phẩm vào list.";
        // header("Location: products.php");
        exit(0);
    }
}

# remove sản phẩm from list view
if(isset($_POST['remove_product_from_list']))
{
    $product_id = mysqli_real_escape_string($con, $_POST['remove_product_from_list']);
    $query = "UPDATE sanpham SET status_add_list = 0 WHERE id = $product_id;";
    $query_run = mysqli_query($con, $query);
    
    if($query_run)
    {
        $_SESSION['message'] = "Remove Sản Phẩm '$product_id' successfully";
        header("Location: products.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Có lỗi xảy ra khi remove sản phẩm.";
        header("Location: products.php");
        exit(0);
    }
}

# add sản phẩm to báo giá
if(isset($_POST['add_to_product_quotes']))
{
    $querySelect = "SELECT * FROM sanpham WHERE status_add_list = 1;";
    $resultProduct = mysqli_query($con, $querySelect);

    if (mysqli_num_rows($resultProduct) > 0) {

        # add compaign and get compaign id
        $today = date("Y-m-d");
        // $today = date("Y-m-d H:i:s");
        $sqlInsertTableCompaign = "INSERT INTO campaign_baogia (`create_date`) VALUES ('$today');";
        $resultInsertCompaign = mysqli_query($con, $sqlInsertTableCompaign);

        if (!$resultInsertCompaign) {
            $_SESSION['message'] = "Có lỗi xảy ra khi tạo bao gia";
            exit(0);
        }

        # get compaign id
        $sqlCampaign = "SELECT * FROM campaign_baogia WHERE create_date = '$today' ORDER BY campaign_id DESC;";
        $resultCampaign = mysqli_query($con, $sqlCampaign);
        
        $campaignId;
        foreach ($resultCampaign as $campaign) {
            $campaignId = $campaign['campaign_id'];
            break;
        }

        
        $numberProductInList = 0;
        foreach ($resultProduct as $product) {
            $id = $product['id'];

            $tenSP = $product['ten_san_pham'];
            $image = $product['image'];
            $donVi = $product['don_vi'];
            $soLuong = $product['so_luong'];
            $giaBan = $product['gia_ban'];
            $khoHangDen = $product['khu_vuc'];

            if (strlen($image) == 0) {
                $image = '';
            }
            if (strlen($donVi) == 0) {
                $donVi = '';
            }
            if (strlen($soLuong) == 0) {
                $soLuong = 0;
            }
            if (strlen($giaBan) == 0) {
                $giaBan = 0;
            }
            if (strlen($khoHangDen) == 0) {
                $khoHangDen = '';
            }

            # insert from product list add and insert campaign id
            $queryInsert = "INSERT INTO spbaogia (ten_san_pham,image,don_vi,so_luong,gia,kho,status,campaign_id) 
            VALUES ('$tenSP', '$image', '$donVi', $soLuong, '$giaBan', '$khoHangDen', 2, $campaignId);";
            mysqli_query($con, $queryInsert);

            # update remove product list add
            $queryUpdateStatus = "UPDATE sanpham SET status_add_list = 0 WHERE id = $id;";
            mysqli_query($con, $queryUpdateStatus);
            
            $numberProductInList++;
        }

        $_SESSION['message'] = "Add " . $numberProductInList . " products to BaoGia successfully.";
        header("Location: products.php");
        exit(0);

    } else {
        $_SESSION['message'] = "Không có sản phẩm nào từ List.";
        header("Location: products.php");
        exit(0);
    }
}

# add sản phẩm vào báo giá
if(isset($_POST['add_product_quotes']))
{
    $userName = $_SESSION['username'];
    $queryUsers = "SELECT * FROM users WHERE user_name = '$userName';";
    $query_run = mysqli_query($con, $queryUsers);
    $user_id;

    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $user) {
            $user_id = $user['user_id'];
        }
    }

    $product_id = mysqli_real_escape_string($con, $_POST['add_product_quotes']);
    $query = "SELECT * FROM sanpham WHERE id='$product_id' ";
    $query_run = mysqli_query($con, $query);
    $tenSP = "";
    $image = "";
    $gia_ban = 0;

    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $sanpham) {
            $tenSP = $sanpham['ten_san_pham'];
            $image = $sanpham['image'];
            $gia_ban = $sanpham['gia_ban'];
        }
    }
    $queryInsert = "INSERT INTO spbaogia (ten_san_pham,image,gia,user_id,status) VALUES ('$tenSP', '$image', $gia_ban, '$user_id', 2)";
    echo $queryInsert;
    $query_run = mysqli_query($con, $queryInsert);

    if($query_run)
    {
        // echo "Add Sản Phẩm '$tenSP' to Báo Giá successfully";
        $_SESSION['message'] = "Add Sản Phẩm '$tenSP' to Báo Giá successfully";
        header("Location: products.php");
        exit(0);
    }
    else
    {
        // echo "Có lỗi xảy ra khi add sản phẩm vào báo giá.";
        $_SESSION['message'] = "Có lỗi xảy ra khi add sản phẩm vào báo giá.";
        header("Location: products.php");
        exit(0);
    }
}

# submit sản phẩm vào đặt hàng
if(isset($_POST['submit_product_quotes']))
{
    $product_id = mysqli_real_escape_string($con, $_POST['submit_product_quotes']);
    $queryUpdateStatus = "UPDATE spbaogia SET status=1 WHERE id='$product_id';";
    $query_run = mysqli_query($con, $queryUpdateStatus);
}

// update product tai muc san pham
if(isset($_POST['p_donVi'])) {
    $query = "UPDATE sanpham SET don_vi='" . $_POST['p_donVi'] . "' WHERE id=" . $_POST['id'] . ";";
    $query_run = mysqli_query($con, $query);
}

if(isset($_POST['p_soLuong'])) {
    $query = "UPDATE sanpham SET so_luong=" . $_POST['p_soLuong'] . " WHERE id=" . $_POST['id'] . ";";
    $query_run = mysqli_query($con, $query);
}

if(isset($_POST['p_giaBan'])) {
    $query = "UPDATE sanpham SET gia_ban=" . $_POST['p_giaBan'] . " WHERE id=" . $_POST['id'] . ";";
    $query_run = mysqli_query($con, $query);
}

if(isset($_POST['p_kho'])) {
    $query = "UPDATE sanpham SET khu_vuc='" . $_POST['p_kho'] . "' WHERE id=" . $_POST['id'] . ";";
    $query_run = mysqli_query($con, $query);
}

// update product tai muc bao gia
if(isset($_POST['don_vi'])) {
    $query = "UPDATE spbaogia SET don_vi = '" . $_POST['don_vi'] . "' WHERE id = '" . $_POST['id'] . "'";
    $query_run = mysqli_query($con, $query);
}

if(isset($_POST['so_luong'])) {
    $query = "UPDATE spbaogia SET so_luong = '" . $_POST['so_luong'] . "' WHERE id = '" . $_POST['id'] . "'";
    $query_run = mysqli_query($con, $query);
}

if(isset($_POST['gia'])) {
    $query = "UPDATE spbaogia SET gia = '" . $_POST['gia'] . "' WHERE id = '" . $_POST['id'] . "'";
    $query_run = mysqli_query($con, $query);
}

if(isset($_POST['hsd'])) {
    $query = "UPDATE spbaogia SET hsd = '" . $_POST['hsd'] . "' WHERE id = '" . $_POST['id'] . "'";
    $query_run = mysqli_query($con, $query);
}

if(isset($_POST['thue'])) {
    $query = "UPDATE spbaogia SET thue = '" . $_POST['thue'] . "' WHERE id = '" . $_POST['id'] . "'";
    $query_run = mysqli_query($con, $query);
}

if(isset($_POST['kho'])) {
    $query = "UPDATE spbaogia SET kho = '" . $_POST['kho'] . "' WHERE id = '" . $_POST['id'] . "'";
    $query_run = mysqli_query($con, $query);
}

if(isset($_POST['lich_su'])) {
    $query = "UPDATE spbaogia SET lich_su = '" . $_POST['lich_su'] . "' WHERE id = '" . $_POST['id'] . "'";
    $query_run = mysqli_query($con, $query);
}



?>