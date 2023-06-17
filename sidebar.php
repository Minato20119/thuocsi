
<?php 
    $username = $_SESSION['username'];
    $query = "SELECT role_id FROM users WHERE user_name = '$username';";

    $result = mysqli_query($con, $query) or die(mysqli_error($con));
    $row = mysqli_fetch_array($result);
?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-success bg-gradient">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="index.php" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <img src="image/logo-removebg.png" style="height: 80px;">
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <?php 
                        if ($row['role_id'] == 1) {
                            echo 
                            '<li class="nav-item">
                                <a href="order-confirmation.php" class="nav-link align-middle px-0 text-white">
                                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Duyệt SP Báo Giá</span>
                                </a>
                            </li>';
                        }
                    ?>
                    <li>
                        <a href="product-quotes.php" class="nav-link align-middle px-0 text-white">
                            <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Báo Giá SP mới</span> </a>
                    </li>
                    <li>
                        <a href="order.php" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Đơn Hàng</span></a>
                    </li>
                    <?php 
                        if ($row['role_id'] == 1) {
                            echo 
                            '<li>
                                <a href="products.php" class="nav-link px-0 align-middle text-white">
                                    <i class="fs-4 bi-grid text-white"></i> <span class="ms-1 d-none d-sm-inline">Sản phẩm</span> 
                                </a>
                            </li>';
                        }
                    ?>
                    <li>
                        <a href="quote-history.php" class="nav-link px-0 align-middle text-white">
                            <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Lịch Sử Báo Giá</span> </a>
                    </li>
                    
                </ul>
                <hr>
                <div class="dropdown pb-4">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="image\logo.jpg" alt="hugenerd" width="30" height="30" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1"><?php echo $_SESSION['username']; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <?php

                            if ($row['role_id'] == 1) {
                                echo '<li><a class="dropdown-item" href="register.php">Tạo Account NCC</a></li>';
                            } else {
                                echo '<li><a class="dropdown-item" href="#">Thông Tin NCC</a></li>';
                            }
                        ?>
                        <li><a class="dropdown-item" href="#">Thông tin tài khoản</a></li>
                        <li><a class="dropdown-item" href="#">Đổi mật khẩu</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        