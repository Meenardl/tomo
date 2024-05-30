<?php
session_start();

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

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgotpass.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_password'])) {
    $conn = connectToDatabase();
    $email = $_SESSION['reset_email'];
    $password = $_POST['password']; // Password dalam bentuk teks biasa

    $sql = "UPDATE user SET password='$password' WHERE email='$email'";
    if ($conn->query($sql) === TRUE) {
        //echo "<p>Password berhasil direset.</p>";
        unset($_SESSION['reset_email']);
        header("Location: signin.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
