<?php
    require 'dbcon.php';
?>
    

    <?php include('header.php'); ?>

    <title>Báo giá sản phẩm</title>
</head>
<body>
    <?php include('sidebar.php'); ?>
    <div class="col py-3">
        <div class="row">
            <div class="col-6">
                <h3>Báo giá sản phẩm</h3>
            </div>
            <div class="col">

            </div>
            <div class="col-3">
            </div>
        </div>

        <?php
            $userName = $_SESSION['username'];
            
            # get campaign id
            $sqlCampaign = "SELECT * FROM campaign_baogia ORDER BY campaign_id DESC;";
            $resultCampaign = mysqli_query($con, $sqlCampaign);
            
            $campaignId;
            foreach ($resultCampaign as $campaign) {
                $campaignId = $campaign['campaign_id'];
                break;
            }
            $_SESSION['campaign'] = $campaignId;

            # Total product chua bao gia cua nha cung cap
            $queryChuaBaoGia = "SELECT * FROM spbaogia
            LEFT JOIN link_spbaogia_ncc
            ON (spbaogia.id = link_spbaogia_ncc.product_id) 
            AND (link_spbaogia_ncc.name_ncc = NULL OR link_spbaogia_ncc.name_ncc = '$userName') 
            WHERE spbaogia.STATUS = 2 AND spbaogia.campaign_id = $campaignId;";

            $record = mysqli_query($con, $queryChuaBaoGia);
            $totalChuaBaoGia = mysqli_num_rows($record);    

            # Total product da bao gia cua nha cung cap
            $queryDaBaoGia = "SELECT * FROM spbaogia
            LEFT JOIN link_spbaogia_ncc
            ON (spbaogia.id = link_spbaogia_ncc.product_id) 
            AND (link_spbaogia_ncc.name_ncc = '$userName') 
            WHERE spbaogia.campaign_id = $campaignId AND status_baogia = 1;";
            $record = mysqli_query($con, $queryDaBaoGia);
            $totalDaBaoGia = mysqli_num_rows($record);

            # All product cua nha cung cap
            $totalBaoGia = $totalChuaBaoGia + $totalDaBaoGia;
        ?>

        <?php include('message.php'); ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert" style="display:none;">
            <div class="show-message">Báo Giá Successfully!</div>
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
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="false" tabindex="-1">Chưa báo giá (<?php echo $totalChuaBaoGia; ?>)</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false" tabindex="-1">Đã báo giá (<?php echo $totalDaBaoGia; ?>)</button>
                                </li>
                                <!-- <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="true">Tất cả (<?php // echo $totalBaoGia; ?>)</button>
                                </li> -->
                                <div class="col-3">
                                </div>
                                <div class="col-4">
                                    <form class="d-flex" method="POST" >
                                        <input class="form-control me-1" type="search" name="search" id="name" placeholder="Nhập tên sản phẩm" aria-label="Search">

                                        <button class="btn btn-primary" type="submit" name="submit-search">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </button>
                                    </form>
                                    <div id="tenSanPham">

                                    </div>
                                </div>
                            </ul>
                            
                            <!-- Tabs navs -->
                        </div>
 
                    </div>
                    <div class="card-body">
                        <!-- Tabs content -->
                        <div class="tab-content" id="myTabContent">
                            
                            <!-- Sản phẩm chưa báo giá -->
                            <div class="tab-pane fade active show" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">

                                <?php include('product-quotes-chua-bao-gia.php'); ?>

                            </div>

                            <!-- Sản phẩm đã báo giá -->
                            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">

                                <?php include('product-quotes-da-bao-gia.php'); ?>
                            
                            </div>

                            <!-- Tất cả sản phẩm -->
                            <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                            
                                <?php include('product-quotes-bao-gia.php'); ?>

                            </div>
                        </div>
                        <!-- Tabs content -->

                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>
    </div>

    <?php include('footer.php'); ?>
