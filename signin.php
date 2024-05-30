<?php
session_start();

function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tomo";

    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Mengecek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    return $conn;
}

$error_message = ''; // Variabel untuk menyimpan pesan error

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signin'])) {
    $conn = connectToDatabase();
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Menggunakan prepared statement untuk keamanan
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id']; // Simpan user ID dalam sesi
        $_SESSION['username'] = $user['username']; // Menyimpan username dalam sesi
        $_SESSION['email'] = $email; // Menyimpan email di sesi
        header("Location: month.php"); // Arahkan ke halaman dashboard setelah berhasil login
        exit();
    } else {
        $error_message = "Email atau password salah.";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign in</title>
  <link rel="stylesheet" href="reglog.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="container">
    <div class="form-box">
      <div class="top">
        <img src="Tomo.jpeg" alt="">
      </div>
      <h1>Sign in</h1>
      <p>Welcome back. Sign into your Journalmind account to start creating</p>
      <?php
      if (!empty($error_message)) {
          echo "<p style='color:red;'>$error_message</p>";
      }
      ?>
      <form action="signin.php" method="post"> <!-- Ubah action ke login.php -->
        <div class="input-box">
          <div class="input-field">
          <i class='bx bxs-envelope'></i>
          <input type="email" placeholder="Email" id="email" name="email" required>
        </div>
        <div class="input-field">
          <i class='bx bx-lock-alt'></i>
          <input type="password" placeholder="Password" id="password" name="password" required>
          <span class="eye" onclick="togglePassword()">
            <i id="show" class='bx bxs-show'></i>
            <i id="hide" class='bx bxs-low-vision'></i>
          </span>
        </div>
        <p><a href="forgotpass.html">Forgot your password?</a></p>
        <div class="sign-up">
          <p>Don't have an account yet?<a href="signup.php"> Create one now</a></p>
        </div>
        <button class="submit-btn" type="submit" name="signin">Sign in</button>
      </form>
    </div>
  </div>
  <script>
    function togglePassword(){
      var x = document.getElementById('password');
      var y = document.getElementById('show');
      var z = document.getElementById('hide');

      if(x.type === 'password'){
        x.type = "text";
        y.style.display = "block";
        z.style.display = "none";
      }
      else{
        x.type = "password";
        y.style.display = "none";
        z.style.display = "block";
      }
    }
  </script>
</body>
</html>
