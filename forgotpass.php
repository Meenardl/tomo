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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_email'])) {
    $conn = connectToDatabase();
    $email = $conn->real_escape_string($_POST['email']);

    $sql = "SELECT user_id FROM user WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $_SESSION['reset_email'] = $email;
        header("Location: resetpass.html");
        exit();
    } else {
        echo "<p>Email tidak terdaftar.</p>";
    }

    $conn->close();
}
?>
