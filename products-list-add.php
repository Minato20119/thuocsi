    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th style="text-align: left;">Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th style="width: 5%;">Đơn vị tính</th>
                <th style="width: 13%; text-align: center;">Số Lượng Yêu Cầu</th>
                <th style="width: 14%;">Giá đáp ứng<br>/<br>Giá đề nghị<br>
                    <p style="font-size: xx-small;">(Giá đã bao gồm VAT)</p>
                </th>
                <th style="width: 8%;">Kho hàng đến</th>
                <th style="width: 0.5%;"><i class="fa-solid fa-circle-info"></i></th>
                <th style="width: 9%;">Remove</th>
            </tr>
        </thead>
        <tbody>
            <?php

                if (!isset($_POST['submit-search'])) {
                    require 'dbcon.php';
                    $limit_per_page = 20;
                    $page = isset($_POST['page_no']) ? $_POST['page_no'] : 1;
                    $offset = ($page - 1) * $limit_per_page;

                    $query = "SELECT * FROM sanpham WHERE status_add_list = 1 LIMIT {$offset}, {$limit_per_page}";
                    $query_run = mysqli_query($con, $query);

                    if (mysqli_num_rows($query_run) > 0) {
                        $stt = 1;
                        foreach ($query_run as $sanpham) {
                            ?>
                            <tr>
                                <td style="text-align: center;"><?= $stt++; ?></td>
                                <td><?= $sanpham['ten_san_pham']; ?></td>
                                <td style="text-align: center;"><img src="<?= $sanpham['image']; ?>" style="height: 50px; width: auto;"></td>
                                <td contenteditable='true' class="p_don_vi" data-id="<?= $sanpham['id']; ?>" style="text-align: center;"><?= $sanpham['don_vi']; ?></td>
                                <td contenteditable='true' class="p_so_luong" data-id="<?= $sanpham['id']; ?>" style="font-weight: bold;"><?= $sanpham['so_luong']; ?></td>
                                <td style="color: orange; text-align: right;">
                                    <span contenteditable='true' class="p_gia_ban" data-id="<?= $sanpham['id']; ?>">
                                        <?php 
                                            echo number_format($sanpham['gia_ban'], 0, '', ','); 
                                        ?>
                                    </span>
                                    <span>đ</span>
                                </td>
                                <td contenteditable='true' class="p_khu_vuc" data-id="<?= $sanpham['id']; ?>" style="text-align: center;"><?= $sanpham['khu_vuc']; ?></td>
                                <td><i class="bi bi-clock-history"></i></td>
                                <td style="text-align: center;">
                                    <form method="POST" class="d-inline add-product-to-list">
                                        <button type="submit" name="remove_product_from_list" value="<?= $sanpham['id']; ?>" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<h5> No Record Found </h5>";
                    }
                }
            ?>

        </tbody>
    </table>

<script>
    $('.p_don_vi').on('input', function(e) {
        var p_donVi;
        var id = $(this).data('id');
        var data = {
            id: id,
            p_donVi: $(this).text(),
        };
        console.log(data);
        $.ajax({
            type: "POST",
            url: 'code.php',
            dataType: "json",
            data: data,
            success: function(data) {
                if (data.status == '200') {
                    console.log('updated');
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
    $('.p_so_luong').on('input', function(e) {
        var p_soLuong;
        var id = $(this).data('id');
        var data = {
            id: id,
            p_soLuong: $(this).text(),
        };
        console.log(data);
        $.ajax({
            type: "POST",
            url: 'code.php',
            dataType: "json",
            data: data,
            success: function(data) {
                if (data.status == '200') {
                    console.log('updated');
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    $('.p_gia_ban').on('input', function(e) {
        var giaBanFE = $(this).text();
        var numb = giaBanFE.match(/\d/g);
        numb = numb.join("");

        var p_giaBan;
        var id = $(this).data('id');
        var data = {
            id: id,
            p_giaBan: numb,
        };
        console.log(data);
        $.ajax({
            type: "POST",
            url: 'code.php',
            dataType: "json",
            data: data,
            success: function(data) {
                if (data.status == '200') {
                    console.log('updated');
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    $('.p_khu_vuc').on('input', function(e) {
        var p_kho;
        var id = $(this).data('id');
        var data = {
            id: id,
            p_kho: $(this).text(),
        };
        console.log(data);
        $.ajax({
            type: "POST",
            url: 'code.php',
            dataType: "json",
            data: data,
            success: function(data) {
                if (data.status == '200') {
                    console.log('updated');
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
</script>


    <?php 
        $sql_total = "SELECT * FROM sanpham WHERE status_add_list = 1";
        if (isset($_POST['submit-search'])) {
            $sql_total = "SELECT * FROM sanpham WHERE status_add_list = 1 AND ten_san_pham LIKE '%$valueSearch%'";
        }
        $record = mysqli_query($con, $sql_total);
        $total_record = mysqli_num_rows($record);
        $total_pages = ceil($total_record / $limit_per_page);
    ?>

<div>
    <nav aria-label="Page navigation">

        <ul class="pagination justify-content-end">

            <?php 
            if($page == 1){ 
            ?>
                <li class="page-item disabled">
                    <a class="page-link" id="1">Previous</a>
                </li>
            <?php 
            } else {
            ?>
                <li class="page-item">
                    <a class="page-link" id="<?php echo $page - 1; ?>">Previous</a>
                </li>
            <?php
            } 

            for ($i = 1; $i <= $total_pages; $i++) { 
                if ($page == $i) {
                    echo 
                    '<li class="page-item active" aria-current="page">
                        <a class="page-link" href="" id="'. $i . '">'. $i . '</a>
                    </li>';

                    if ($i + 8 < $total_pages) {
                        for ($j = 0; $j < 7; $j++) { 
                            echo '<li class="page-item"><a class="page-link" href="" id="' . ($i + $j + 1) . '">' . ($i + $j + 1) . '</a></li>';
                        }
                        echo '<li class="page-item"><a class="page-link" href="">...</a></li>';
                    } else {
                        for ($j = 1; $j <= $total_pages - $page; $j++) { 
                            echo '<li class="page-item"><a class="page-link" href="" id="' . ($page + $j) . '">' . ($page + $j) . '</a></li>';
                        }
                        break;
                    }
                }
            }

            ?>
            
            <?php if($page != $total_pages){ ?>
                <li class="page-item">
                    <a class="page-link" href="" id="<?php echo $page + 1; ?>">Next</a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>

