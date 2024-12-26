<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Sign</b>In</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <!-- Form login -->
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="submit">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <?php
      // Proses login
      if (isset($_POST['submit'])) {
          try {
              // Sertakan file koneksi ke database
              include 'admin/koneksi.php';

              // Ambil data dari form
              $user_email = trim($_POST['email']);
              $user_pass = md5($_POST['password']); // Mengenkripsi password dengan md5

              // Prepare statement untuk mencegah SQL injection
              $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email AND password = :password");
              
              // Bind parameter
              $stmt->bindParam(':email', $user_email);
              $stmt->bindParam(':password', $user_pass);
              
              // Execute query
              $stmt->execute();
              
              // Ambil hasil
              $data_user = $stmt->fetch(PDO::FETCH_ASSOC);
              
              // Cek hasil
              if ($data_user) {
                  // Jika login berhasil, mulai sesi dan simpan data pengguna
                  session_start();
                  $_SESSION['user'] = $data_user['email'];
                  $_SESSION['user_id'] = $data_user['id'];
                  $_SESSION['level'] = $data_user['level'];

                  // Redirect ke halaman admin
                  header('Location: admin/index.php');
                  exit(); // Pastikan tidak ada output setelah redirect
              } else {
                  // Jika login gagal, tampilkan pesan error
                  echo "<div class='alert alert-danger'>Email atau Password tidak valid</div>";
              }
          } catch(PDOException $e) {
              // Tangani error database
              echo "<div class='alert alert-danger'>Error: Terjadi kesalahan sistem. Silakan coba lagi nanti.</div>";
              // Log error untuk admin (jangan tampilkan ke user)
              error_log("Login error: " . $e->getMessage());
          }
      }
      ?>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
