<div class="overflow-scroll">
    <table class="table table-hover">
        <thead>
            <tr>
                <th style="width: 1%;">ID</th>
                <th style="width: 1%;">Hình ảnh</th>
                <th style="text-align: left">Tên sản phẩm</th>
                <th style="width: 5%;">Đơn vị tính</th>
                <th style="width: 12%; text-align: center;">SL tối đa đáp ứng<br>/<br>SL yêu cầu</th>
                <th style="width: 15%;">Giá đáp ứng<br>/<br>Giá đề nghị<br>
                    <p style="font-size: xx-small;">(Giá đã bao gồm VAT)</p>
                </th>
                <th style="width: 10%;">HSD</th>
                <th style="width: 8%;">Kho hàng đến</th>
                <th style="width: 1%;"><i class="fa-solid fa-circle-info"></i></th>
            </tr>
        </thead>
        <tbody>

            <?php
                $userName = $_SESSION['username'];
                $campaignId = $_SESSION['campaign'];
    
                $queryDaBaoGia = "SELECT * FROM spbaogia
                LEFT JOIN link_spbaogia_ncc
                ON (spbaogia.id = link_spbaogia_ncc.product_id) 
                AND (link_spbaogia_ncc.name_ncc = '$userName') 
                WHERE spbaogia.campaign_id = $campaignId AND status_baogia = 1";
                
                # search san pham da bao gia
                if (isset($_POST['submit-search'])) {
                    $valueSearch = addslashes($_POST['search']);
                    $queryDaBaoGia = $queryDaBaoGia . " AND ten_san_pham LIKE '%$valueSearch%'";
                }

                $query_run = mysqli_query($con, $queryDaBaoGia);

                if(mysqli_num_rows($query_run) > 0)
                {   
                    $stt = 1;
                    foreach($query_run as $sanpham) {
                        $soLuong;
                        $price;

                        $soLuongDefault = $sanpham['so_luong'];
                        $giaDefault = $sanpham['gia'];

                        $soLuongNCC = $sanpham['bg_so_luong'];
                        $giaNCC = $sanpham['bg_price'];

                        $nhaCungCapInDB = $sanpham['name_ncc'];
                        $nhaCungCapSession = $userName;

                        # get so luong
                        if ($nhaCungCapInDB == $nhaCungCapSession && !empty($soLuongNCC)) {
                            $soLuong = $soLuongNCC;
                        } else {
                            $soLuong = $soLuongDefault;
                        }

                        # get price
                        if ($nhaCungCapInDB == $nhaCungCapSession && !empty($giaNCC)) {
                            $price = $giaNCC;
                        } else {
                            $price = $giaDefault;
                        }
            ?>		

            <tr>
                <td style="text-align: center;"><?= $sanpham['id']; ?></td>
                <td style="text-align: center;"><img src="<?= $sanpham['image']; ?>" style="height: 50px; width: auto;"></td>
                <td><?= $sanpham['ten_san_pham']; ?></td>
                <td style="text-align: center;" class="update_donvi" data-id="<?= $sanpham['id']; ?>"><?= $sanpham['don_vi']; ?></td>

                <td style="font-weight: bold;" class="update_so_luong" data-id="<?= $sanpham['id']; ?>">
                    <?php echo $soLuong; ?>
                </td>
                <td style="color: orange; text-align: right;">
                    <span class="update_gia" data-id="<?= $sanpham['id']; ?>">
                        <?php 
                            echo number_format($price, 0, '', ','); 
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