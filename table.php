<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <style type="text/css">
      
       #pagenation a{
            color: #fff;
       }
       #pagenation{
        text-align: center;
        margin-top: 5%;
       } 
       .button-style{
        border-radius: 20px;
       }
       .link{
        border-radius: 100px !important;
       }

    </style>
</head>
<body>

    <?php 
        require 'dbcon.php';
        
        $limit_per_page = 5;
        $page = isset($_POST['page_no']) ? $_POST['page_no'] : 1;

        $offset = ($page - 1) * $limit_per_page;
        $query = "SELECT * FROM sanpham LIMIT {$offset}, {$limit_per_page}";
        $result = mysqli_query($con, $query);
    ?>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Submit</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <th scope="row"><?php echo $row['id']; ?></th>
                        <td><?php echo $row['ten_san_pham']; ?></td>
                        <td><?php echo $row['image']; ?></td>
                        <td>
                            <div class="abc">
                                <form method="POST" class="d-inline form-submit">
                                    <button type="submit" value="<?= $row['id']; ?>" name="submit_product_quotes" class="btn btn-success btn-sm">Submit</button>
                                </form>
                            </div>
                            <script>
                                $('form').submit(function(e) {
                                    e.preventDefault();
                                    $(this).parent().hide();
                                });
                            </script>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <?php 
            $sql_total = "SELECT * FROM sanpham";
            $record = mysqli_query($con, $sql_total);
            $total_record = mysqli_num_rows($record);
            $total_pages = ceil($total_record / $limit_per_page);
        ?>
        <div class="pagenation" id="pagenation">

            <?php if($page > 1){ ?>

            <a href="" id="<?php echo $page - 1; ?>" class="button-style btn btn-success">Previous</a>                    

            <?php } ?>

            <?php for ($i=1; $i <= $total_pages; $i++) { ?>
                <a id="<?php echo $i ?>" href="" class="link btn btn-primary"><?php echo $i ?></a>
            <?php } ?>

            <?php if($page != $total_pages){ ?>

            <a href="" id="<?php echo $page+1; ?>" class="button-style btn btn-success">Next</a> 

            <?php } ?>
          
        </div> 

</body>
</html>