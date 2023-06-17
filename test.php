<?php
    require_once 'Paginator.php';
    require 'dbcon.php';

    $limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 25;
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
    $query      = "SELECT * FROM sanpham";
    $Paginator  = new Paginator( $con, $query );
    $results    = $Paginator->getData( $page, $limit );
?>

<!DOCTYPE html>
    <head>
        <title>PHP Pagination</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
                <div class="col-md-10 col-md-offset-1">
                    <h1>PHP Pagination</h1>
                    <table class="table table-striped table-condensed table-bordered table-rounded">
                            <thead>
                                <tr>
                                    <th>City</th>
                                    <th width="20%">Country</th>
                                    <th width="20%">Continent</th>
                                    <th width="25%">Region</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for( $i = 0; $i < count( $results->data ); $i++ ) : ?>
                                        <tr>
                                                <td><?php echo $results->data[$i]['ten_san_pham']; ?></td>
                                                <td><?php echo $results->data[$i]['don_vi']; ?></td>
                                                <td><?php echo $results->data[$i]['so_luong']; ?></td>
                                                <td><?php echo $results->data[$i]['gia_ban']; ?></td>
                                        </tr>
                                <?php endfor; ?>
                            </tbody>
                    </table>
                    <?php echo $Paginator->createLinks( $links, 'pagination pagination-sm' ); ?> 
                </div>
        </div>
        </body>
</html>