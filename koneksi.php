<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "tomo";

$koneksi = new mysqli($host, $username, $password, $dbname);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
