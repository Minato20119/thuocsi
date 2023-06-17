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

    $sql_total = "SELECT * FROM sanpham";
    if (isset($_POST['submit-search'])) {
        $valueSearch = addslashes($_POST['search']);
        $sql_total = "SELECT * FROM sanpham WHERE ten_san_pham LIKE '%$valueSearch%'";
    }
    $record = mysqli_query($con, $sql_total);
    $total_record = mysqli_num_rows($record);

    $queryAddList = "SELECT * FROM sanpham WHERE status_add_list = 1";
    $record = mysqli_query($con, $queryAddList);
    $totalRecordAddList = mysqli_num_rows($record);

?>



<title>Product</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="col py-3">
        <div class="row">
            <div class="col-6">
                <h3>Trang sản phẩm</h3>
            </div>
            <div class="col">
                <form class="d-flex" method="POST" >
                    <input class="form-control me-1" type="search" name="search" id="name search_name" placeholder="Nhập tên sản phẩm" aria-label="Search">

                    <button class="btn btn-primary" type="submit" name="submit-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
                <div id="tenSanPham">

                </div>

            </div>
            <div class="col-3">
                <?php 
                    if ($role_id == 1) {
                        ?>
                        <a href="sanpham-create.php" class="btn btn-primary">Add Sản Phẩm</a>
                        <a href="import-sanpham.php" class="btn btn-success">Import Product</a>
                        <?php
                    } 
                ?>
            </div>
        </div>

        <?php include('message.php'); ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="display:none;">
            <div class="show-message">Add product to List successfully!</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card mt-7">
                            <!-- Tabs navs -->
                            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="false" tabindex="-1">Tất Cả (<?php echo $total_record; ?>)</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link listAddButton" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false" tabindex="-1">List Add (<?php echo $totalRecordAddList; ?>)</button>
                                </li>
                            </ul>
                            
                            <!-- Tabs navs -->
                        </div>

                    </div>
                    <div class="card-body">
                        <!-- Tabs content -->
                        <div class="tab-content" id="myTabContent">
                            <!-- Sản phẩm chưa báo giá -->
                            <div class="tab-pane fade active show" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

                            
                            <!-- display result -->
                            <?php 
                                if (isset($_POST['submit-search'])) {
                                    ?>

                                    <div class="overflow-scroll">
                                        <?php
                                        require 'dbcon.php';
                                        $limit_per_page = 25;
                                        $page = isset($_POST['page_no']) ? $_POST['page_no'] : 1;
                                        $offset = ($page - 1) * $limit_per_page;

                                        $valueSearch = addslashes($_POST['search']);
                                        $query = "SELECT * FROM sanpham WHERE ten_san_pham LIKE '%$valueSearch%' LIMIT {$offset}, {$limit_per_page}";

                                        $query_run = mysqli_query($con, $query);
                                        ?>


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
                                                    <th style="width: 11%;">Báo giá SP</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                                

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
                                                                    <button type="submit" name="add_product_to_list" value="<?= $sanpham['id']; ?>" class="btn btn-success btn-sm">Add To List</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    echo "<h5> No Record Found </h5>";
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                        


                                        <?php 
                                            $sql_total = "SELECT * FROM sanpham WHERE ten_san_pham LIKE '%$valueSearch%'";
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
                                    </div>

                                <?php
                                } else {
                                ?>
                                    <div class="overflow-scroll" id="productsAll">
                                    <!-- pagination -->

                                    </div>
                                <?php
                                }
                            ?>
                            


                            </div>

                            <!-- Sản phẩm list add -->
                            <div class="tab-pane fade listAdd" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                            <?php 
                                if (isset($_POST['submit-search'])) {
                                    ?>

                                    <div class="overflow-scroll">
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
                                                    <th style="width: 11%;">Báo giá SP</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                                require 'dbcon.php';
                                                $limit_per_page = 25;
                                                $page = isset($_POST['page_no']) ? $_POST['page_no'] : 1;
                                                $offset = ($page - 1) * $limit_per_page;
                                                
                                                $valueSearch = addslashes($_POST['search']);
                                                $query = "SELECT * FROM sanpham WHERE status_add_list = 1 AND ten_san_pham LIKE '%$valueSearch%' LIMIT {$offset}, {$limit_per_page}";

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
                                                                <form action="code.php" method="POST" class="d-inline">
                                                                    <button type="submit" name="remove_product_from_list" value="<?= $sanpham['id']; ?>" class="btn btn-danger btn-sm">Remove</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    echo "<h5> No Record Found </h5>";
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>

                                <?php
                                } else {
                                ?>
                                    <div class="overflow-scroll" id="productsListAdd">
                                    <!-- pagination -->

                                    </div>
                                <?php
                                }
                            ?>
                                <div class=row>
                                    <div class="col-9">
                                    </div>
                                    <div class="col-3">
                                        <form action="code.php" method="POST" class="d-inline">
                                            <button type="submit" name="add_to_product_quotes" class="btn btn-warning float-end">Add Vào Báo Giá</button>
                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

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

        <script>
            $(document).ready(function(){
                function lodetable(page){
                    $.ajax({
                        url : 'products-all.php',
                        type : 'POST',
                        data : {
                            page_no:page,
                        },
                        success : function(data) {
                        $('#productsAll').html(data);
                        }
                    });
                }
                lodetable();

                $(document).on("click",".pagination a",function(e) {
                    e.preventDefault();
                    var page_id = $(this).attr("id");
                    lodetable(page_id);
                });
            });
            $(document).ready(function(){
                function lodetable(page){
                    $.ajax({
                        url : 'products-list-add.php',
                        type : 'POST',
                        data : {
                            page_no:page,
                        },
                        success : function(data) {
                        $('#productsListAdd').html(data);
                        }
                    });
                }
                lodetable();

                $(document).on("click",".pagination a",function(e) {
                    e.preventDefault();
                    var page_id = $(this).attr("id");
                    lodetable(page_id);
                });
            });
        </script>

    <script>
        $('form.add-product-to-list').submit(function(e) {
            e.preventDefault();
            $(this).parent().hide();
            var query = $(this).children().val();

            console.log('products form.add-product-to-list');
            $.ajax({
                url: "code.php",
                method: "POST",
                data: { add_product_to_list: query },
                success: function (data) {
                    console.log('add success');
                }
            });
        });
    </script>

    </div>
    </div>
    </div>
    <?php include('footer.php'); ?>


