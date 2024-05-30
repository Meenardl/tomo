<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

if (!isset($_SESSION['month'])) {
    header("Location: month.php");
    exit();
}

$month = $_SESSION['month'];
$user_id = $_SESSION['user_id'];

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

$conn = connectToDatabase();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Username';

$sql = "SELECT mood, COUNT(*) as count FROM mood_tracker WHERE user_id = '$user_id' AND month = '$month' GROUP BY mood";
$result = $conn->query($sql);

$moods = [];
$counts = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $moods[$row['mood']] = $row['count']; // Menggunakan mood sebagai kunci dalam array
        $counts[] = $row['count'];
    }
}

// Inisialisasi array untuk menyimpan persentase setiap mood dengan nilai awal 0
$percentages = [
    'happy' => 0,
    'angry' => 0,
    'tired' => 0,
    'anxious' => 0,
    'sad' => 0
];

// Menghitung persentase setiap mood
foreach ($moods as $mood => $count) {
    if ($count > 0) {
        $percentage = ($count / 30) * 100;
        $percentages[$mood] = $percentage;
    } else {
        $percentages[$mood] = 0; // Jika jumlah mood adalah 0, tetapkan persentase ke 0
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistic</title>
    <link rel="stylesheet" href="statistic.css">
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
                <a href="statistic.php" class="stat">Statistic</a>   
            </div>
            <div class="profile-icon-container" id="profile-icon-container">
                <img src="kosong.jpg" alt="Profile" class="profile-img" id="profile-icon">
                <div class="menu" id="menu">
                    <div class="sub-menu">
                        <div class="info">
                            <img src="profil.jpeg" class="prof-menu">
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
    
    <div class="container">

        <div class="allbar">
            <ul class="y-label">
                <li><div>30</div></li>
                <li><div>25</div></li>
                <li><div>20</div></li>
                <li><div>15</div></li>
                <li><div>10</div></li>
                <li><div>5</div></li>
                
            </ul>
            <div class="line-y">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
            <div class="line-x">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
            <div class="barsangry">
                <div class="bar1" style="height: <?php echo min($percentages['happy'], 31); ?>%;"></div>
                <div class="bar2" style="height: <?php echo min($percentages['angry'], 31); ?>%;"></div>
                <div class="bar3" style="height: <?php echo min($percentages['tired'], 31); ?>%;"></div>
                <div class="bar4" style="height: <?php echo min($percentages['anxious'], 31); ?>%;"></div>
                <div class="bar5" style="height: <?php echo min($percentages['sad'], 31); ?>%;"></div>

            </div>
            <div class="emotions">
                <div class="emotion1"><img src="happy.jpeg" alt="Happy Emoji"></div>
                <div class="emotion2"><img src="angry.jpeg" alt="Angry Emoji"></div>
                <div class="emotion2"><img src="tired.jpeg" alt="Tired Emoji"></div>
                <div class="emotion1"><img src="anxious.jpeg" alt="Anxious Emoji"></div>
                <div class="emotion2"><img src="sad.jpeg" alt="Sad Emoji"></div>
            </div>
            <div class="quote">
                <p><?php 
                    $quote_happy = "Wow, seeing you so happy is contagious! Keep that awesome energy going, never stop chasing your dreams. Let's soak up every moment of this happiness and let your joy light up the world around you!";
                    $quote_angry = "Anger is a part of life, but don't let it overpower you. Let me help bring light into the darkness you're feeling. Together, we can get through this.";
                    $quote_tired = "Even though today feels heavy, remember that every step you take brings you closer to your goals. Take time to rest and recharge, because tomorrow is a new opportunity to step even further.";
                    $quote_anxious = "You don't have to feel alone in your fears. I'm here for you, together we can face that anxiety. Believe me, every step you take towards your comfort is a significant progress.";
                    $quote_sad = "When the clouds of sadness gather, remember, you're never alone in the storm. I'm right here, ready to be your umbrella, to dance in the rain with you, and to chase away those gloomy skies. Together, we'll find the rainbow waiting just around the corner.";

                    if ($percentages['happy'] >= $percentages['angry'] && $percentages['happy'] >= $percentages['tired'] && $percentages['happy'] >= $percentages['anxious'] && $percentages['happy'] >= $percentages['sad']) {
                        echo '<div class="quotehappy"><p>"' . $quote_happy . '"</p></div>';
                    } elseif ($percentages['angry'] >= $percentages['tired'] && $percentages['angry'] >= $percentages['anxious'] && $percentages['angry'] >= $percentages['sad']) {
                        echo '<div class="quoteangry"><p>"' . $quote_angry . '"</p></div>';
                    } elseif ($percentages['tired'] >= $percentages['anxious'] && $percentages['tired'] >= $percentages['sad']) {
                        echo '<div class="quotetired"><p>"' . $quote_tired . '"</p></div>';
                    } elseif ($percentages['anxious'] >= $percentages['sad']) {
                        echo '<div class="quoteanxious"><p>"' . $quote_anxious . '"</p></div>';
                    } else {
                        echo '<div class="quotesad"><p>"' . $quote_sad . '"</p></div>';
                    }
                ?></p>
            </div>         
        </div>
        <footer></footer>
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

</body>
</html>