<?php
    require 'dbcon.php';
?>
    

    <?php include('header.php'); 
    
        $userName = $_SESSION['username'];
        $queryUsers = "SELECT * FROM users WHERE user_name = '$userName';";
        $query_run = mysqli_query($con, $queryUsers);
        $role_id;

        if (mysqli_num_rows($query_run) > 0) {
            foreach ($query_run as $user) {
                $role_id = $user['role_id'];
            }
        }

        if ($role_id != 1) {
            header("Location: index.php");
            exit(0);
        }

        $queryChuaDuyet = "SELECT * FROM order_confirmation WHERE status_product = 0 ORDER BY ten_san_pham ASC;";
        $record = mysqli_query($con, $queryChuaDuyet);
        $totalChuaDuyet = mysqli_num_rows($record);

        $queryDaDuyet = "SELECT * FROM order_confirmation WHERE status_product = 1 ORDER BY ten_san_pham ASC;";
        $record = mysqli_query($con, $queryDaDuyet);
        $totalDaDuyet = mysqli_num_rows($record);
    ?>



    <title>Duyệt sản phẩm báo giá</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="col py-3">
        <div class="row">
            <div class="col-6">
                <h3>Duyệt Sản Phẩm Báo Giá</h3>
            </div>
            <div class="col">
                

            </div>
            <div class="col-3">
            </div>
        </div>


        <?php include('message.php'); ?>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <form action="code_confirm_order.php" method="POST">
                            <button type="submit" name="submit_order" class="btn btn-success btn-sm float-end">Tạo Đơn Hàng</button>
                        </form>
                        <!-- Tabs navs -->
                        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="false" tabindex="-1">Chưa duyệt (<?php echo $totalChuaDuyet; ?>)</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false" tabindex="-1">Đã duyệt (<?php echo $totalDaDuyet; ?>)</button>
                            </li>
                        </ul>
                        <!-- Tabs navs -->
                    </div>
                    <div class="card-body">
                        <!-- Tabs content -->
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                            <div class="overflow-scroll">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>NCC</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Hình ảnh</th>
                                            <th>Đơn vị</th>
                                            <th>SL chốt</th>
                                            <th>Giá chốt</th>
                                            <th style="width: 100px;">HSD</th>
                                            <th>Kho</th>
                                            <th><i class="fa-solid fa-circle-info"></i></th>
                                            <th>Duyệt</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $userName = $_SESSION['username'];
                                            $queryUsers = "SELECT * FROM users WHERE user_name = '$userName';";
                                            $query_run = mysqli_query($con, $queryUsers);
                                            $role_id;
                                        
                                            if (mysqli_num_rows($query_run) > 0) {
                                                foreach ($query_run as $user) {
                                                    $role_id = $user['role_id'];
                                                }
                                            }

                                            if ($role_id != 1) {
                                                echo "Permission Denied";
                                                exit(0);
                                            }

                                            $query = "SELECT * FROM order_confirmation WHERE status_product = 0 ORDER BY ten_san_pham ASC;";
                                            $query_run = mysqli_query($con, $query);

                                            if(mysqli_num_rows($query_run) > 0)
                                            {   
                                                $stt = 1;
                                                foreach($query_run as $sanpham)
                                                {
                                                    $product_id = $sanpham['id_order_confirm'];
                                                    ?>
                                                    <tr>
                                                        <td><?= $stt++; ?></td>
                                                        <td><?= $product_id; ?></td>
                                                        <td><?= $sanpham['user_ncc']; ?></td>
                                                        <td><?= $sanpham['ten_san_pham']; ?></td>
                                                        <td><img src="<?= $sanpham['image']; ?>" style="height: 50px; width: auto;"></td>
                                                        
                                                        <td class="update_donvi" data-id="<?= $product_id; ?>"><?= $sanpham['don_vi']; ?></td>
                                                        <td contenteditable='true' class="update_so_luong" data-id="<?= $product_id; ?>"><?= $sanpham['so_luong_chot']; ?></td>
                                                        <td style="color: orange; text-align: right;">
                                                            <span contenteditable='true' class="update_gia" data-id="<?= $product_id; ?>">
                                                                <?php 
                                                                    echo number_format($sanpham['gia_chot'], 0, '', ','); 
                                                                ?>
                                                            </span>
                                                            <span>đ</span>
                                                        </td>
                                                        <td class="update_hsd" data-id="<?= $product_id; ?>"><?= $sanpham['hsd']; ?></td>
                                                        <td class="update_kho" data-id="<?= $product_id; ?>"><?= $sanpham['kho']; ?></td>
                                                        <td class="update_lich_su" data-id="<?= $product_id; ?>"><i class="bi bi-clock-history"></i></td>
                                                        
                                                        <td>
                                                            <form action="order-confirmation.php" method="POST" class="d-inline">
                                                                <button type="submit" data-id="<?= $product_id; ?>" value="<?= $product_id; ?>" name="submit_order_confirmation" class="btn btn-success btn-sm">Submit</button>
                                                            </form>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <form method="POST" class="d-inline" id="removeIdListView">
                                                                <button type="submit" name="removeIdListView" value="<?= $product_id; ?>">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            else
                                            {
                                                echo "<h5> No Record Found </h5>";
                                            }
                                        ?>
                                        <?php 
                                            if(isset($_POST['submit_order_confirmation']))
                                            {
                                                // change status product = 1
                                                $product_id = mysqli_real_escape_string($con, $_POST['submit_order_confirmation']);
                                                $queryUpdateStatus = "UPDATE order_confirmation SET status_product=1 WHERE id_order_confirm='$product_id';";
                                                $query_run = mysqli_query($con, $queryUpdateStatus);

                                                // change status_bg = 3
                                                $queryOrderConfirmation = "SELECT * FROM order_confirmation WHERE id_order_confirm='$product_id';";
                                                $query_run = mysqli_query($con, $queryOrderConfirmation);
                                                $id_spbaogia;

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    foreach ($query_run as $sanpham) {
                                                        $id_spbaogia = $sanpham['id_spbaogia'];
                                                    }
                                                }
                                                $queryUpdateStatusBaoGia = "UPDATE spbaogia SET STATUS = 3 WHERE id = '$id_spbaogia';";
                                                $query_run = mysqli_query($con, $queryUpdateStatusBaoGia);
                                                
                                                echo "id: " . $product_id . " da chuyen vao don hang.";
                                            }
                                        ?>
                                                        
                                        <script>
                                            $('.update_so_luong').on('input', function(e){
                                                var so_luong;
                                                var id = $(this).data('id');
                                                var data = {
                                                    id: id,
                                                    so_luong: $(this).text(),
                                                };
                                                    console.log(data);
                                                    $.ajax({
                                                        type: "POST",
                                                        url: 'code_confirm_order.php',
                                                        dataType: "json",
                                                        data: data,
                                                        success: function (data) {
                                                            if (data.status == '200') {
                                                                console.log('updated'); 
                                                            }                      
                                                        },
                                                        error: function(data) {
                                                            console.log(data);
                                                        }
                                                    });
                                            });

                                            
                                            $('.update_gia').on('input', function(e){
                                                var giaBanFE = $(this).text();
                                                var numb = giaBanFE.match(/\d/g);
                                                numb = numb.join("");

                                                var gia;
                                                var id = $(this).data('id');
                                                var data = {
                                                    id: id,
                                                    gia: numb,
                                                };
                                                    console.log(data);
                                                    $.ajax({
                                                        type: "POST",
                                                        url: 'code_confirm_order.php',
                                                        dataType: "json",
                                                        data: data,
                                                        success: function (data) {
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
                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                            </div>
                            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            <div class="overflow-scroll">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ID</th>
                                            <th>NCC</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Hình ảnh</th>
                                            <th>Đơn vị</th>
                                            <th>SL chốt</th>
                                            <th>Giá chốt</th>
                                            <th style="width: 100px;">HSD</th>
                                            <th>Kho</th>
                                            <th><i class="fa-solid fa-circle-info"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $userName = $_SESSION['username'];
                                            $queryUsers = "SELECT * FROM users WHERE user_name = '$userName';";
                                            $query_run = mysqli_query($con, $queryUsers);
                                            $role_id;
                                        
                                            if (mysqli_num_rows($query_run) > 0) {
                                                foreach ($query_run as $user) {
                                                    $role_id = $user['role_id'];
                                                }
                                            }
                                            if ($role_id != 1) {
                                                echo "Permission Denied";
                                                exit(0);
                                            }

                                            $query = "SELECT * FROM order_confirmation WHERE status_product = 1 ORDER BY ten_san_pham ASC;";
                                            $query_run = mysqli_query($con, $query);

                                            if(mysqli_num_rows($query_run) > 0)
                                            {   
                                                $stt = 1;
                                                foreach($query_run as $sanpham)
                                                {
                                                    $product_id = $sanpham['id_order_confirm'];
                                                    ?>
                                                    <tr>
                                                        <td><?= $stt++; ?></td>
                                                        <td><?= $product_id; ?></td>
                                                        <td><?= $sanpham['user_ncc']; ?></td>
                                                        <td><?= $sanpham['ten_san_pham']; ?></td>
                                                        <td><img src="<?= $sanpham['image']; ?>" style="height: 50px; width: auto;"></td>
                                                        
                                                        <td class="update_donvi" data-id="<?= $product_id; ?>"><?= $sanpham['don_vi']; ?></td>
                                                        <td class="update_so_luong" data-id="<?= $product_id; ?>"><?= $sanpham['so_luong_chot']; ?></td>
                                                        <td style="color: orange; text-align: right;">
                                                            <span contenteditable='true' class="update_gia" data-id="<?= $product_id; ?>">
                                                                <?php 
                                                                    echo number_format($sanpham['gia_chot'], 0, '', ','); 
                                                                ?>
                                                            </span>
                                                            <span>đ</span>
                                                        </td>
                                                        <td class="update_hsd" data-id="<?= $product_id; ?>"><?= $sanpham['hsd']; ?></td>
                                                        <td class="update_kho" data-id="<?= $product_id; ?>"><?= $sanpham['kho']; ?></td>
                                                        <td class="update_lich_su" data-id="<?= $product_id; ?>"><i class="bi bi-clock-history"></i></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            else
                                            {
                                                echo "<h5> No Record Found </h5>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        <!-- Tabs content -->

                        

                    </div>
                </div>
            </div>
        </div>



    </div>
    </div>
    </div>

    <?php include('footer.php'); ?>
