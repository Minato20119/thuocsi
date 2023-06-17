<div class="overflow-scroll">
    <table class="table table-hover">
        <thead>
            <tr>
                <th style="width: 1%;">ID</th>
                <th style="width: 1%;"><input class="form-check-input" type="checkbox" value="" id="check-sp-chua-bao-gia" checked></th>
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

            $query = "SELECT * FROM spbaogia
            LEFT JOIN link_spbaogia_ncc
            ON (spbaogia.id = link_spbaogia_ncc.product_id) 
            AND (link_spbaogia_ncc.name_ncc = NULL OR link_spbaogia_ncc.name_ncc = '$userName') 
            WHERE spbaogia.STATUS = 2 AND spbaogia.campaign_id = $campaignId ";

            # search san pham chua bao gia
            if (isset($_POST['submit-search'])) {
                $valueSearch = addslashes($_POST['search']);
                $query = $query . " AND ten_san_pham LIKE '%$valueSearch%'";
            }

            $query_run = mysqli_query($con, $query);

            if(mysqli_num_rows($query_run) > 0)
            {   
                foreach($query_run as $sanpham) {
                    $product_id = $sanpham['id'];

                    # check product da bao gia
                    $queryDaBaoGia = "SELECT * FROM link_spbaogia_ncc 
                    WHERE campaign_id = $campaignId AND name_ncc = '$userName' AND status_baogia = 1 AND product_id = $product_id; ";

                    // echo '<br>queryDaBaoGia: ' . $queryDaBaoGia;

                    $queryBaoGia = mysqli_query($con, $queryDaBaoGia);
                    if(mysqli_num_rows($queryBaoGia) > 0) {
                        // echo '<br>product_id: ' . $product_id;
                        continue;
                    }

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

            <tr class="baogia-table">
                <td style="text-align: center;"><?= $sanpham['id']; ?></td>
                <td style="text-align: center;"><input class="check-input" type="checkbox" data-id="<?= $sanpham['id']; ?>"></td>
                <td style="text-align: center;"><img src="<?= $sanpham['image']; ?>" style="height: 50px; width: auto;"></td>
                <td><?= $sanpham['ten_san_pham']; ?></td>
                <td style="text-align: center;" class="update_donvi" data-id="<?= $sanpham['id']; ?>"><?= $sanpham['don_vi']; ?></td>
                <td style="font-weight: bold;font-size: 0.85rem;" contenteditable='true' class="update_so_luong" data-id="<?= $sanpham['id']; ?>">
                
                <?php echo $soLuong; ?>
                </td>
                <td style="color: orange; text-align: right;">
                    <span contenteditable='true' class="update_gia change_input" data-id="<?= $sanpham['id']; ?>">
                        <?php 
                            echo number_format($price, 0, '', ','); 
                        ?>
                    </span>
                    <span>đ</span>
                </td>

                <td style="text-align: center;" contenteditable='true' class="update_hsd" data-id="<?= $sanpham['id']; ?>"><?= $sanpham['hsd']; ?></td>
                <td style="text-align: center;" class="update_kho" data-id="<?= $sanpham['id']; ?>"><?= $sanpham['kho']; ?></td>
                <td style="text-align: center;" class="update_lich_su" data-id="<?= $sanpham['id']; ?>"><i class="bi bi-clock-history"></i></td>
                

                <script>
                // $('.update_so_luong').click(function(){

                //     var contents = $(this).html();
                    
                //     var soLuong = <?php // echo $slCurrent ; ?>;

                //     $(this).blur(function() {
                //         if (contents != $(this).html()) {
                //             var soLuongChanged = $(this).text();
                //             $(this).text(soLuong + ' + ' + soLuongChanged);
                //             contents = $(this).html();
                //         }
                //     });
                // });
                </script>

            </tr>

            <?php
                    }
                } else {
                    echo "<h5> No Record Found </h5>";
                }
            ?>
            <?php // $sessionSoLuong = (isset($_SESSION['id']))?$_SESSION['id']:''; ?>
            <script>
                // var contents = $('.update_so_luong').html();
                // var soLuong = $('.update_so_luong').text();

                // $('.update_so_luong').blur(function() {
                //     if (contents != $(this).html()) {
                //         var soLuongChanged = $('.update_so_luong').text();
                //         $('.update_so_luong').text(soLuong + ' + ' + soLuongChanged);
                //         contents = $(this).html();
                //     }
                // });
                // $('.update_so_luong').click(function(){

                //     var contents = $(this).html();
                //     var id = $(this).data('id');
                //     var soLuong = <?php // echo (isset($_SESSION['so_luong_' . $sanpham['id']])) ? $_SESSION['id'] : '' ; ?>;

                //     $(this).blur(function() {
                //         if (contents != $(this).html()) {
                //             var soLuongChanged = $(this).text();
                //             $(this).text(soLuong + ' + ' + soLuongChanged);
                //             contents = $(this).html();
                //         }
                //     });
                // });
                
            </script>

            <script>
                
                $('.update_hsd').on('input', function(e) {
                    var hsd;
                    var id = $(this).data('id');
                    var data = {
                        id: id,
                        hsd: $(this).text(),
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
 

        </tbody>
    </table>

</div>

<div class="modal-bao-gia">

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success" id="listBaoGia" data-bs-toggle="modal" data-bs-target="#confirmListBaoGia">
        <span>
            <i class="fas fa-cart-plus"></i> TIẾP TỤC: 
            <span id="check-input-selected"></span>
        </span>
    </button>

    <?php include('modal-product-quotes.php'); ?>

</div>

<script type="text/javascript" src="assert/baogia.js"></script>
