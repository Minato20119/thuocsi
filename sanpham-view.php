<?php
require 'dbcon.php';
?>


    <?php include('header.php'); ?>

    <title>Sản Phẩm View</title>
</head>
<body>

    <div class="container mt-5">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Sản phẩm View
                            <a href="products.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if(isset($_GET['id']))
                        {
                            $student_id = mysqli_real_escape_string($con, $_GET['id']);
                            $query = "SELECT * FROM sanpham WHERE id='$student_id' ";
                            $query_run = mysqli_query($con, $query);

                            if(mysqli_num_rows($query_run) > 0)
                            {
                                $sanpham = mysqli_fetch_array($query_run);
                                ?>
                                    <div class="mb-3">
                                        <label>#</label>
                                        <p class="form-control">
                                            <?=$sanpham['id'];?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Ưa thích</label>
                                        <p class="form-control">
                                            <?=$sanpham['ua_thich'];?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Tên sản phẩm</label>
                                        <p class="form-control">
                                            <?=$sanpham['ten_san_pham'];?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Hình ảnh</label>
                                        <p class="form-control">
                                            <?=$sanpham['image'];?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Khu vực</label>
                                        <p class="form-control">
                                            <?=$sanpham['khu_vuc'];?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Trạng thái</label>
                                        <p class="form-control">
                                            <?=$sanpham['trang_thai'];?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Tình trạng</label>
                                        <p class="form-control">
                                            <?=$sanpham['tinh_trang'];?>
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label>Lịch sử</label>
                                        <p class="form-control">
                                            <?=$sanpham['lich_su'];?>
                                        </p>
                                    </div>

                                <?php
                            }
                            else
                            {
                                echo "<h4>No Such Id Found</h4>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>