<?php
session_start();
include 'koneksi.php';

header("Location: landing.html");

$koneksi->close();
?>