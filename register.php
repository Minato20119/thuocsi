<?php
include('header.php');
require 'dbcon.php';

$userName = $_SESSION['username'];
$queryUsers = "SELECT * FROM users WHERE user_name = '$userName';";
$query_run = mysqli_query($con, $queryUsers);
$role_id;

if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $user) {
        $role_id = $user['role_id'];
    }
}

if ($role_id != 1) {
    header("Location: index.php");
    exit(0);
}

?>


<title>Register</title>
</head>

<body class="main-bg">
  <!-- Register Form -->
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card shadow">
          <div class="card-title text-center border-bottom">
            <h2 class="p-3">Register
                <a href="index.php" class="btn btn-danger float-end">HOME</a>
            </h2>
          </div>
          <?php include('message.php'); ?>
          <div class="card-body">
            <h3 class="text-center mb-4">Tạo tài khoản cho NCC</h3>
            <form action="register.php" method='POST'>
              <div class="mb-4">
                <label for="username" class="form-label">Username/Tel</label>
                <input type="text" class="form-control" name='username' id="username" required=""/>
              </div>
              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name='password' id="password" required=""/>
              </div>
              <div class="d-grid">
                <button type="submit" name="register" class="btn text-light main-bg">Tạo</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


        <?php
            //Xử lý đăng nhập
            if (isset($_POST['register'])) {
                //Kết nối tới database
                include('dbcon.php');

                //Lấy dữ liệu nhập vào
                $username = addslashes($_POST['username']);
                $password = addslashes($_POST['password']);

                //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
                if (!$username || !$password) {
                    echo "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.";
                    exit;
                }

                $query = "INSERT INTO `users` (`user_name`, `user_password`, `role_id`) VALUES ('$username', '$password', 2)";
                $query_run = mysqli_query($con, $query);
            
                if (!$query_run)
                {
                    $_SESSION['message'] = "Error Register. Tài khoản đã tồn tại. Try again!";
                    header("Location: register.php");
                    exit(0);
                } else {
                    $_SESSION['message'] = "Account <b>" . $username . "</b> đã được đăng ký thành công, đăng nhập ngay <a href='login.php'>Ở đây</a>";
                    header("Location: register.php");
                    exit(0);
                }

                if (!mysqli_close($con)) {
                    echo 'Error close connection.';
                }
            }
        ?>

        <?php include('footer.php'); ?>