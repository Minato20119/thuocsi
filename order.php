<?php
    require 'dbcon.php';
?>
    

    <?php include('header.php'); ?>

    <title>Đơn hàng</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="col py-3">
        <h3>Đơn hàng</h3>

        <?php include('message.php'); ?>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                    <div class="overflow-scroll">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order ID</th>
                                    <th>NCC</th>
                                    <th>Thời gian Order</th>
                                    <th>Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $userName = $_SESSION['username'];

                                    // Check user admin
                                    $sqlUser = "SELECT role_id FROM users WHERE user_name = '$username';";
                                    $resultUser = mysqli_query($con, $sqlUser) or die(mysqli_error($con));

                                    $row = mysqli_fetch_array($resultUser);
                                    $sqlSelectOrder = "SELECT * FROM orders WHERE user_ncc = '$userName' ORDER BY order_id DESC;";

                                    if ($row['role_id'] == 1) {
                                        $sqlSelectOrder = "SELECT * FROM orders ORDER BY order_id DESC;";
                                    }

                                    $resultOrder = mysqli_query($con, $sqlSelectOrder);

                                    if(mysqli_num_rows($resultOrder) > 0)
                                    {   
                                        $stt = 1;
                                        foreach($resultOrder as $order)
                                        {
                                            ?>

                                            <tr>
                                                <td><?= $stt++; ?></td>
                                                <td><?= $order['order_id']; ?></td>
                                                <td><?= $order['user_ncc']; ?></td>
                                                <td><?= $order['order_date']; ?></td>
                                                <td>
                                                    <form action="order-details.php" method="POST" class="d-inline">
                                                        <button type="submit" name="order_id" value="<?= $order['order_id']; ?>" class="btn btn-success btn-sm">View Order - <?= $order['order_id']; ?></button>
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
                            </tbody>
                        </table>

                    </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>
    </div>

    <?php include('footer.php'); ?>
