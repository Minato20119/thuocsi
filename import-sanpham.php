<?php
?>


    <?php include('header.php'); ?>

    <title>Product Create</title>
</head>
<body>
  
    <div class="container mt-5">

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Import Product 
                            <a href="products.php" class="btn btn-danger float-end">HOME</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Choose File</label>
                                <input type="file" name="fileToUpload" id="fileToUpload">
                            
                                <button type="submit" name="import_product" class="btn btn-success float-end">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
