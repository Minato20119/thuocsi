<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" type="image/x-icon" href="image/logo.jpg">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="assert/style.css">
  <!-- <link rel="stylesheet" href="assert/style1.css"> -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

  <?php
  session_start();

  if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
  }
  ?>

  <title>Login</title>
</head>

<body class="main-bg">
  <!-- Login Form -->
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card shadow">
          <div class="card-title text-center border-bottom">
            <h2 class="p-3">Login
              <a href="index.php" class="btn btn-danger float-end">HOME</a>
            </h2>
          </div>
          <?php include('message.php'); ?>
          <div class="card-body">
            <form action="login.php" method='POST'>
              <div class="mb-4">
                <label for="username" class="form-label">Username/Email</label>
                <input type="text" class="form-control" name='username' id="username" />
              </div>
              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name='password' id="password" />
              </div>
              <div class="mb-4">
                <input type="checkbox" class="form-check-input" id="remember" />
                <label for="remember" class="form-label">Remember Me</label>
              </div>
              <div class="d-grid">
                <button type="submit" name="dangnhap" class="btn text-light main-bg">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


  <?php
  //Khai báo utf-8 để hiển thị được tiếng việt
  //header('Content-Type: text/html; charset=UTF-8');
  //Xử lý đăng nhập
  if (isset($_POST['dangnhap'])) {
    //Kết nối tới database
    include('dbcon.php');

    //Lấy dữ liệu nhập vào
    $username = addslashes($_POST['username']);
    $password = addslashes($_POST['password']);

    //Kiểm tra đã nhập đủ tên đăng nhập với mật khẩu chưa
    if (!$username || !$password) {
      echo "Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu. <a href='login.php'>Thử lại</a>";
      exit;
    }

    // mã hóa pasword
    // $password = md5($password);
  
    //Kiểm tra tên đăng nhập có tồn tại không
    $query = "SELECT user_name, user_password FROM users WHERE user_name='$username'";

    $result = mysqli_query($con, $query) or die(mysqli_error($con));

    if (!$result) {
      echo "Tên đăng nhập hoặc mật khẩu không đúng!";
    } else {
      echo "Đăng nhập thành công!";
    }

    //Lấy mật khẩu trong database ra
    $row = mysqli_fetch_array($result);

    //So sánh 2 mật khẩu có trùng khớp hay không
    if ($password != $row['user_password']) {
      $_SESSION['message'] = "Mật khẩu không đúng. Vui lòng nhập lại. <a href='login.php'>Thử lại</a>";
      header("Location: login.php");
      exit(0);
    } else {
      $_SESSION['username'] = $username;
      $_SESSION['message'] = "Xin chào <b>" . $username . "</b>. Bạn đã đăng nhập thành công. <a href='logout.php'>Thoát</a>";
      header("Location: products.php");
    }
    if (!mysqli_close($con)) {
      echo 'error close connection.';
    }
  }
  ?>



  <?php include('footer.php'); ?>