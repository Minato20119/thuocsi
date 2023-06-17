<?php include('header.php'); ?>

    <title>Product Create</title>
</head>
<body>
  
    <div class="container mt-5">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Add 
                            <a href="products.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label>Tên sản phẩm</label>
                                <input type="text" name="ten_san_pham" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Hình ảnh</label>
                                <input type="text" name="image" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Khu vực</label>
                                <input type="text" name="khu_vuc" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Trạng thái</label>
                                <input type="text" name="trang_thai" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Tình trạng</label>
                                <input type="text" name="tinh_trang" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="save_product" class="btn btn-primary">Save Product</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
