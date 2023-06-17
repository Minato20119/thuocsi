<div class="overflow-scroll">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th style="width: 1%;">Hình ảnh</th>
                <th style="text-align: left;">Tên sản phẩm</th>
                <th style="width: 70px;">Đơn vị tính</th>
                <th style="width: 80px;">SL tối đa đáp ứng<br>/<br>SL yêu cầu</th>
                <th style="">Giá đáp ứng<br>/<br>Giá đề nghị<br>
                    <p style="font-size: xx-small;">(Giá đã bao gồm VAT)</p>
                </th>
                <th style="width: 100px;">HSD</th>
                <th style="width: 100px;">Kho hàng đến</th>
                <th><i class="fa-solid fa-circle-info"></i></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $query = "SELECT * FROM spbaogia WHERE STATUS != 3;";

                if (isset($_POST['submit-search'])) {
                    $valueSearch = addslashes($_POST['search']);
                    $query = "SELECT * FROM spbaogia WHERE STATUS != 3 AND ten_san_pham LIKE '%$valueSearch%'";
                }

                $query_run = mysqli_query($con, $query);

                if(mysqli_num_rows($query_run) > 0) 
                {   
                    $stt = 1;
                    foreach($query_run as $sanpham)
                    {
                        ?>                                            
            <tr>
                <td style="text-align: center;"><?= $stt++; ?></td>
                <td style="text-align: center;"><?= $sanpham['id']; ?></td>
                <td style="text-align: center;"><img src="<?= $sanpham['image']; ?>" style="height: 50px; width: auto;"></td>
                <td><?= $sanpham['ten_san_pham']; ?></td>
                <td style="text-align: center;" class="update_donvi" data-id="<?= $sanpham['id']; ?>"><?= $sanpham['don_vi']; ?></td>

                <td style="font-weight: bold;" class="update_so_luong" data-id="<?= $sanpham['id']; ?>">
                    <?= $sanpham['so_luong']; ?>
                    <!-- <p class="change_input"></p> -->
                </td>
                <td style="color: orange; text-align: right;">
                    <span class="update_gia change_input" data-id="<?= $sanpham['id']; ?>">
                        <?php 
                                                                    echo number_format($sanpham['gia'], 0, '', ','); 
                                                                ?>
                    </span>
                    <span>đ</span>
                </td>

                <td style="text-align: center;" class="update_hsd" data-id="<?= $sanpham['id']; ?>"><?= $sanpham['hsd']; ?></td>
                <td style="text-align: center;" class="update_kho" data-id="<?= $sanpham['id']; ?>"><?= $sanpham['kho']; ?></td>
                <td style="text-align: center;" class="update_lich_su" data-id="<?= $sanpham['id']; ?>"><i class="bi bi-clock-history"></i></td>
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