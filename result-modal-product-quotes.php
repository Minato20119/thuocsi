<?php

session_start();
require 'dbcon.php';
$listCheckboxSelected = isset($_POST['listBaoGia']) ? $_POST['listBaoGia'] : [];
$userName = $_SESSION['username'];

foreach ($listCheckboxSelected as $checkBoxSelected) {
    $id = $checkBoxSelected;

    $query = "SELECT * FROM spbaogia WHERE id = $id;";
    $query_run = mysqli_query($con, $query);

    $queryLinkNCC = "SELECT * FROM link_spbaogia_ncc WHERE product_id = $id AND name_ncc = '$userName';";
    $resultLinkNCC = mysqli_query($con, $queryLinkNCC);

    $numberRows = mysqli_num_rows($query_run);

    if ($numberRows > 0) {
        foreach ($query_run as $sanpham) {

            $soLuong = $sanpham['so_luong'];
            $price = $sanpham['gia'];

            foreach ($resultLinkNCC as $linkProduct) {
                $soLuong = $linkProduct['bg_so_luong'];
                $price = $linkProduct['bg_price'];
                break;
            }

            if (strlen($soLuong) == 0 || $soLuong == 0) {
                $soLuong = $sanpham['so_luong'];
            }
            
            if (strlen($price) == 0 || $price == 0) {
                $price = $sanpham['gia'];
            }

?>

<tr class="baogia-table" id="resultModalTable" data-id="<?= $sanpham['id']; ?>">
    <td style="text-align: center;"><img src="<?= $sanpham['image']; ?>"></td>
    <td><?= $sanpham['ten_san_pham']; ?></td>
    <td style="font-weight: bold;font-size: 0.85rem;" contenteditable='true' class="update_so_luong" data-id="<?= $sanpham['id']; ?>">
    
    <?= $soLuong; ?></td>
    <td style="color: orange; text-align: right;">
        <span contenteditable='true' class="update_gia change_input" data-id="<?= $sanpham['id']; ?>">
            <?php 
                echo number_format($price, 0, '', ','); 
            ?>
        </span>
        <span>đ</span>
    </td>
    <td style="text-align: center;" class="update_kho" data-id="<?= $sanpham['id']; ?>"><?= $sanpham['kho']; ?></td>
    <td style="text-align: center;">
        <form method="POST" class="d-inline" id="removeIdListView">
            <button type="submit" name="removeIdListView" value="<?= $sanpham['id']; ?>">
                <i class="fa fa-trash"></i>
            </button>
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
<script>
    // nha cung cap update so luong
$('.update_so_luong').on('input', function (e) {
    var so_luong;
    var id = $(this).data('id');
    var data = {
        id: id,
        so_luong: $(this).text(),
    };
    console.log(data);
    $.ajax({
        type: "POST",
        url: 'product-quotes-update-data-ncc.php',
        dataType: "json",
        data: data,
        success: function (data) {
            if (data.status == '200') {
                console.log('updated');
            }
        },
        error: function (data) {
            console.log('error update so luong.');
            console.log(data);
        }
    });
});

// ncc update gia
$('.update_gia').on('input', function (e) {
    var giaBanFE = $(this).text();
    var numb = giaBanFE.match(/\d/g);
    numb = numb.join("");

    var gia;
    var id = $(this).data('id');
    var data = {
        id: id,
        gia: numb,
    };
    console.log(data);
    $.ajax({
        type: "POST",
        url: 'product-quotes-update-data-ncc.php',
        dataType: "json",
        data: data,
        success: function (data) {
            if (data.status == '200') {
                console.log('updated');
            }
        },
        error: function (data) {
            console.log('error update price.');
            console.log(data);
        }
    });
});
</script>
<script>

$('form#removeIdListView').submit(function(e) {

    e.preventDefault();
    console.log('removeIdListView');
    $(this).parents('tr').hide();

});

</script>