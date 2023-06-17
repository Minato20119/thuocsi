<?php

//Nhúng file PHPExcel
require_once 'PHPExcel-1.8/Classes/PHPExcel.php';



class ExcelAction {

    public static function readExcelAndInsertDb ($excelPath) {
        //Tiến hành xác thực file
        $objFile = PHPExcel_IOFactory::identify($excelPath);
        $objData = PHPExcel_IOFactory::createReader($objFile);

        //Chỉ đọc dữ liệu
        $objData->setReadDataOnly(true);

        // Load dữ liệu sang dạng đối tượng
        $objPHPExcel = $objData->load($excelPath);

        //Lấy ra số trang sử dụng phương thức getSheetCount();
        // Lấy Ra tên trang sử dụng getSheetNames();

        //Chọn sheet cần truy xuất
        $sheet = $objPHPExcel->setActiveSheetIndex(0);

        //Lấy ra số dòng cuối cùng
        $Totalrow = $sheet->getHighestRow();
        //Lấy ra tên cột cuối cùng
        $LastColumn = $sheet->getHighestColumn();

        //Chuyển đổi tên cột đó về vị trí thứ, VD: C là 3, D là 4
        $TotalCol = PHPExcel_Cell::columnIndexFromString($LastColumn);

        //Tạo mảng chứa dữ liệu
        $data = [];

        //Tiến hành lặp qua từng ô dữ liệu
        //----Lặp dòng, Vì dòng đầu là tiêu đề cột nên chúng ta sẽ lặp giá trị từ dòng 2
        for ($row = 3; $row <= $Totalrow; $row++) {
            //----Lặp cột
            $ma_san_pham = "";
            $ten_san_pham = "";
            $mo_ta = "";
            $image = "";
            $gia_ban;
            for ($col = 0; $col < $TotalCol; $col++) {

                // Tiến hành lấy giá trị của từng ô đổ vào mảng
                $value = $sheet->getCellByColumnAndRow($col, $row)->getValue();

                if ($col == 1) {
                    $ma_san_pham = $value;
                }
                if ($col == 2) {
                    $ten_san_pham = $value;
                }
                if ($col == 3) {
                    $mo_ta = $value;
                }
                if ($col == 5) {
                    $image = $value;
                }
                if ($col == 12) {
                    $gia_ban = $value;
                }
            }
            $queryInsertData = "INSERT INTO `sanpham` (`ma_san_pham`, `ten_san_pham`, `image`, `gia_ban`, `mo_ta`) VALUES ('$ma_san_pham', '$ten_san_pham', '$image', $gia_ban, '$mo_ta');";

            include 'dbcon.php';

            $query_run = mysqli_query($con, $queryInsertData);
            
            if(!$query_run)
            {
                $_SESSION['message'] = "Sản Phẩm Import To Database Failed";
                header("Location: import-sanpham.php");
                exit(0);
            }

            // Remove after final
            // if ($row == 100) {
            //     break;
            // }
        }
    }
}


?>