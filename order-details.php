<?php
    require 'dbcon.php';
    
    if (isset($_POST['order_id']))
    {
        $order_id = mysqli_real_escape_string($con, $_POST['order_id']);
    }
?>
    

    <?php include('header.php'); ?>

    <title>Order details - <?php echo $order_id; ?></title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="col py-3">
        <h3>Order details - <?php echo $order_id; ?></h3>
        <br>

        <?php include('message.php'); ?>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a href="order.php" class="btn btn-danger float-end">BACK</a>
                    </div>
                    <div class="card-body">
                        <!-- Tabs content -->
                        <div class="overflow-scroll">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Hình ảnh</th>
                                            <th>Đơn vị</th>
                                            <th>SL chốt</th>
                                            <th>Giá chốt</th>
                                            <th>HSD</th>
                                            <th>Kho</th>
                                            <th>Lịch sử</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        if(isset($_POST['order_id']))
                                        {
                                            $userName = $_SESSION['username'];
                                            $order_id = mysqli_real_escape_string($con, $_POST['order_id']);

                                            // Check user admin
                                            $sqlUser = "SELECT role_id FROM users WHERE user_name = '$username';";
                                            $resultUser = mysqli_query($con, $sqlUser) or die(mysqli_error($con));

                                            $row = mysqli_fetch_array($resultUser);
                                            $sqlSelectOrder = "SELECT * FROM orders WHERE user_ncc = '$userName' AND order_id = $order_id;";

                                            if ($row['role_id'] == 1) {
                                                $sqlSelectOrder = "SELECT * FROM orders WHERE order_id = $order_id;";
                                            }

                                            $resultOrder = mysqli_query($con, $sqlSelectOrder);

                                            if (mysqli_num_rows($resultOrder) == 0) {
                                                echo "<h5> Not found order detail. </h5>";
                                                exit(0);
                                            }

                                            $queryOrderDetail = "SELECT * FROM orders_details WHERE order_id = $order_id;";
                                            $resultOrderDetail = mysqli_query($con, $queryOrderDetail);

                                            if(mysqli_num_rows($resultOrderDetail) > 0)
                                            {   
                                                $stt = 1;
                                                foreach($resultOrderDetail as $sanpham)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?= $stt++; ?></td>
                                                        <td><?= $sanpham['ten_san_pham']; ?></td>
                                                        <td><img src="<?= $sanpham['image']; ?>" style="height: 50px; width: auto;"></td>
                                                        <td><?= $sanpham['don_vi']; ?></td>
                                                        <td><?= $sanpham['so_luong_chot']; ?></td>
                                                        <td style="color: orange; text-align: right;"><?= number_format($sanpham['gia_chot'], 0, '', ',') . 'đ'; ?></td>
                                                        <td><?= $sanpham['hsd']; ?></td>
                                                        <td><?= $sanpham['kho']; ?></td>
                                                        <td><?= $sanpham['lich_su']; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            else
                                            {
                                                echo "<h5> No Record Found </h5>";
                                            }
                                        }
                                    ?>
                                    </tbody>
                                </table>
                        <!-- Tabs content -->

                    </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
    </div>
    </div>

    <?php include('footer.php'); ?>
