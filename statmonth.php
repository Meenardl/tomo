<?php
session_start();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Username';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="landprof.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-logo">
            <img src="TomoHi.jpeg">
            <div class="navbar-text">
                <span class="title">Hi Friend!</span>
                <span class="subtitle">Let's talk with Tomo</span>
            </div>
        </div>
        
        <div class="all">
            <div class="navbar-toggle" id="mobile-menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <div class="navbar-menu" id="navbar-menu">
                <a href="month.php" class="home">Home</a>
                <a href="statmonth.php" class="stat">Statistic</a>   
            </div>
            <div class="profile-icon-container" id="profile-icon-container">
                <img src="kosong.jpg" alt="Profile" class="profile-img" id="profile-icon"> <!--berubah ngikutin database-->
                <div class="menu" id="menu">
                    <div class="sub-menu">
                        <div class="info">
                            <img src="kosong.jpg" class="prof-menu"> <!--berubah ngikutin database-->
                            <h2><?php echo $username; ?></h2> <!--nanti ubah biar otomatis nama username pas login-->
                        </div>
                        <hr>
        
                        <a href="profile.php" class="sub-menu-link">
                         <i class='bx bxs-user icon'></i>
                         <p>Edit Profil</p>
                         <span></span>
                        </a>
        
                        <a href="signout.php" class="sub-menu-link">
                         <i class='bx bxs-log-out icon'></i>
                         <p>Logout</p>
                         <span></span>
                        </a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </nav>
    
    <div class="kotak"></div>
    <div class="kotak2"></div>
    <p class="tulisan"> WHAT I FEEL IN A MONTH? </p>
    <div class="month">
        <button onclick="window.location.href='harian31.php?month=1'">JAN</button>
        <button onclick="window.location.href='harian28.php?month=2'">FEB</button>
        <button onclick="window.location.href='harian31.php?month=3'">MAR</button>
        <button onclick="window.location.href='harian30.php?month=4'">APR</button>
        <button onclick="window.location.href='harian31.php?month=5'">MAY</button>
        <button onclick="window.location.href='harian30.php?month=6'">JUN</button>
        <button onclick="window.location.href='harian31.php?month=7'">JUL</button>
        <button onclick="window.location.href='harian31.php?month=8'">AUG</button>
        <button onclick="window.location.href='harian30.php?month=9'">SEP</button>
        <button onclick="window.location.href='harian31.php?month=10'">OCT</button>
        <button onclick="window.location.href='harian30.php?month=11'">NOV</button>
        <button onclick="window.location.href='harian31.php?month=12'">DEC</button>
    </div>

    <script>
        const mobileMenu = document.getElementById('mobile-menu');
        const navbarMenu = document.getElementById('navbar-menu');
        const profileIcon = document.getElementById('profile-icon');
        const menu = document.getElementById("menu");

        mobileMenu.addEventListener('click', () => {
            navbarMenu.classList.toggle('active');
            menu.classList.remove('open-class'); // Tutup menu profil saat toggle menu diklik
        });

        profileIcon.addEventListener('click', () => {
            menu.classList.toggle('open-class'); // Toggle menu profil saat ikon profil diklik
            navbarMenu.classList.remove('active'); // Tutup toggle menu saat ikon profil diklik
        });

        // Tutup menu profil saat pengguna mengklik di luar area menu
        window.onclick = function(event) {
            if (!event.target.matches('#profile-icon')) {
                if (menu.classList.contains('open-class')) {
                    menu.classList.remove('open-class');
                }
            }
        };
    </script>
    <footer></footer>
</body>
</html>
