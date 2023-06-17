<div class="card mt-5">
    <form class="d-flex" method="POST" >
        <input class="form-control me-1" type="search" name="search" id="name" placeholder="Nhập tên sản phẩm" aria-label="Search">

        <button class="btn btn-primary" type="submit" name="submit-search">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </form>
    <div id="tenSanPham"></div>
</div>


<script>
    $(document).ready(function () {
        $('#name').keyup(function () {
            var query = $(this).val();
            if (query != '') {
                $.ajax({
                    url: "searchPro.php",
                    method: "POST",
                    data: { query: query },
                    success: function (data) {
                        $('#tenSanPham').fadeIn();
                        $('#tenSanPham').html(data);
                    }
                });
            }
        });
        $(document).on('click', 'li', function () {
            $('#name').val($(this).text());
            $('#tenSanPham').fadeOut();
        });
    });  
</script>