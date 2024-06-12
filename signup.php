<?php

function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tomo";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    return $conn;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $conn = connectToDatabase();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $conf_password = $_POST['conf-password'];
    $email = $_POST['email'];

    if ($password !== $conf_password) {
      $error_message = "Password dan konfirmasi password tidak cocok.";
    } else {
      $emailCheckQuery = "SELECT * FROM user WHERE email = '$email'";
      $result = $conn->query($emailCheckQuery);
      
      if ($result->num_rows > 0) {
        $error_message = "Email sudah terdaftar, silahkan gunakan email lain.";
      } else {
          $sql = "INSERT INTO user (username, password, email) VALUES ('$username', '$password', '$email')";
          if ($conn->query($sql) === TRUE) {
              header("Location: signin.php"); // Arahkan ke halaman login setelah berhasil registrasi
              exit();
          } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
          }
      }
    }
    $conn->close();
} else {
    //echo "Invalid request method or signup not set.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign up</title>
  <link rel="stylesheet" href="reglog.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="container">
    <div class="form-box">
      <div class="top">
        <img src="Tomo.jpeg" alt="">
      </div>
      <h1>Sign Up</h1>
      <p>Welcome! Register a Journalmind account to start creating</p>
      <?php
      if (!empty($error_message)) {
          echo "<p style='color:red;'>$error_message</p>";
      }
      ?>
      <form action="signup.php" method="post"> <!-- Ubah action ke signup.php -->
        <div class="input-field2">
          <i class='bx bx-user'></i>
          <input type="text" placeholder="Username" id="username" name="username" required>
        </div>
        <div class="input-field2">
          <i class='bx bxs-envelope'></i>
          <input type="email" placeholder="Email" id="email" name="email" required>
        </div>
        <div class="input-field2">
          <i class='bx bx-lock-alt'></i>
          <input type="password" placeholder="Password" id="password" name="password" required>
          <span class="eye" onclick="myFunction('password', 'show-password', 'hide-password')">
            <i id="show-password" class='bx bxs-show' style="display:none;"></i> <!-- Sembunyikan secara default -->
            <i id="hide-password" class='bx bxs-low-vision'></i>
          </span>
        </div>
        <div class="input-field2">
          <i class='bx bx-lock-alt'></i>
          <input type="password" placeholder="Confirm Password" id="conf-password" name="conf-password" required>
          <span class="eye" onclick="myFunction('conf-password', 'show-conf-password', 'hide-conf-password')">
            <i id="show-conf-password" class='bx bxs-show' style="display:none;"></i> <!-- Sembunyikan secara default -->
            <i id="hide-conf-password" class='bx bxs-low-vision'></i>
          </span>
        </div>
        <div class="sign-in">
          <p>Already have an account?<a href="signin.php"> Sign in instead</a></p>
        </div>
        <button class="submit-btn" type="submit" name="signup">Sign up</button>
      </form>
    </div>
  </div>
  <script>
    function myFunction(passwordFieldId, showId, hideId){
      var x = document.getElementById(passwordFieldId);
      var y = document.getElementById(showId);
      var z = document.getElementById(hideId);

      if(x.type == 'password'){
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
