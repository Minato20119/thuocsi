<?php
require 'dbcon.php';
?>


    <?php include('header.php'); ?>

    <title>Student Edit</title>
</head>
<body>
  
    <div class="container mt-5">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Sản phẩm Edit 
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
                                <form action="code.php" method="POST">
                                    <input type="hidden" name="student_id" value="<?= $sanpham['id']; ?>">

                                    <div class="mb-3">
                                        <label>Tên sản phẩm</label>
                                        <input type="text" name="ten_san_pham" value="<?=$sanpham['ten_san_pham'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Hình ảnh</label>
                                        <input type="text" name="image" value="<?=$sanpham['image'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Khu vực</label>
                                        <input type="text" name="khu_vuc" value="<?=$sanpham['khu_vuc'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Trạng thái</label>
                                        <input type="text" name="trang_thai" value="<?=$sanpham['trang_thai'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label>Tình trạng</label>
                                        <input type="text" name="tinh_trang" value="<?=$sanpham['tinh_trang'];?>" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" name="update_product" class="btn btn-primary">
                                            Update sanpham
                                        </button>
                                    </div>

                                </form>
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