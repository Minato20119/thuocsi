<?php
    require 'dbcon.php';
?>
<div class="overflow-scroll">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Ưa thích</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Khu vực</th>
                <th>Trạng trái</th>
                <th>Tình trạng</th>
                <th>Lịch sử</th>
                <th>Báo giá SP</th>
            </tr>
        </thead>
        <tbody>
            <?php

            if (isset($_POST['submit-search'])) {
                $valueSearch = addslashes($_POST['search']);
                $query = "SELECT * FROM sanpham WHERE ten_san_pham LIKE '%" . $valueSearch . "%'";
                $query_run = mysqli_query($con, $query);

                if (mysqli_num_rows($query_run) > 0) {
                    $stt = 1;
                    foreach ($query_run as $sanpham) {
                        ?>
                        <tr>
                            <td>
                                <?= $stt++; ?>
                            </td>
                            <td>
                                <?= $sanpham['ua_thich']; ?>
                            </td>
                            <td>
                                <?= $sanpham['ten_san_pham']; ?>
                            </td>
                            <td><img src="<?= $sanpham['image']; ?>" style="height: 50px; width: auto;"></td>
                            <td>
                                <?= $sanpham['khu_vuc']; ?>
                            </td>
                            <td>
                                <?= $sanpham['trang_thai']; ?>
                            </td>
                            <td>
                                <?= $sanpham['tinh_trang']; ?>
                            </td>
                            <td>
                                <?= $sanpham['lich_su']; ?>
                            </td>
                            <td>
                                <form action="code.php" method="POST" class="d-inline">
                                    <button type="submit" name="add_product_quotes" value="<?= $sanpham['id']; ?>" class="btn btn-success btn-sm">Add</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<h5> No Record Found </h5>";
                }
            }
            if (!isset($_POST['submit-search'])) {
                $query = "SELECT * FROM sanpham limit 1000;";
                $query_run = mysqli_query($con, $query);

                if (mysqli_num_rows($query_run) > 0) {
                    $stt = 1;
                    foreach ($query_run as $sanpham) {
                        ?>
                        <tr>
                            <td>
                                <?= $stt++; ?>
                            </td>
                            <td>
                                <?= $sanpham['ua_thich']; ?>
                            </td>
                            <td>
                                <?= $sanpham['ten_san_pham']; ?>
                            </td>
                            <td><img src="<?= $sanpham['image']; ?>" style="height: 50px; width: auto;"></td>
                            <td>
                                <?= $sanpham['khu_vuc']; ?>
                            </td>
                            <td>
                                <?= $sanpham['trang_thai']; ?>
                            </td>
                            <td>
                                <?= $sanpham['tinh_trang']; ?>
                            </td>
                            <td>
                                <?= $sanpham['lich_su']; ?>
                            </td>
                            <td>
                                <form action="products.php" method="POST" class="d-inline">
                                    <button type="submit" name="add_product_quotes" value="<?= $sanpham['id']; ?>" class="btn btn-success btn-sm">Add</button>
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
            <?php
                # add sản phẩm vào báo giá
                if(isset($_POST['add_product_quotes']))
                {
                    $userName = $_SESSION['username'];
                    $queryUsers = "SELECT * FROM users WHERE user_name = '$userName';";
                    $query_run = mysqli_query($con, $queryUsers);
                    $user_id;

                    if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $user) {
                            $user_id = $user['user_id'];
                        }
                    }

                    $product_id = mysqli_real_escape_string($con, $_POST['add_product_quotes']);
                    $query = "SELECT * FROM sanpham WHERE id='$product_id' ";
                    $query_run = mysqli_query($con, $query);
                    $tenSP = "";
                    $image = "";

                    if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $sanpham) {
                            $tenSP = $sanpham['ten_san_pham'];
                            $image = $sanpham['image'];
                        }
                    }
                    $queryInsert = "INSERT INTO spbaogia (ua_thich,ten_san_pham,image,user_id,status) VALUES (0,'$tenSP','$image','$user_id',2)";
                    $query_run = mysqli_query($con, $queryInsert);

                    if($query_run)
                    {
                        echo "Add Sản Phẩm '$tenSP' to Báo Giá successfully";
                    }
                    else
                    {
                        echo "Có lỗi xảy ra khi add sản phẩm vào báo giá.";
                    }
                }
            ?>

        </tbody>
    </table>

</div>
<div>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-end">
            <li class="page-item disabled">
                <a class="page-link">Previous</a>
            </li>
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">3</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
</div>

