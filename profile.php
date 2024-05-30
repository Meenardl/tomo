<?php
session_start();

// Function to connect to the database
function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tomo";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Redirect to signin.php if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

$conn = connectToDatabase();
$user_id = $_SESSION['user_id'];

// Update user profile if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "UPDATE user SET username='$username', email='$email', password='$password' WHERE user_id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        //echo "<p>Profile updated successfully.</p>";
        header("Location: signin.php");
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

// Retrieve user data
$sql = "SELECT username, email FROM user WHERE user_id = '$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="edit.css">
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
                <img src="kosong.jpg" alt="Profile" class="profile-img" id="profile-icon"> <!--kalo foto udh disimpan akan berubah ngikutin sesuai database-->
                <div class="menu" id="menu">
                    <div class="sub-menu">
                        <div class="info">
                            <img src="kosong.jpg" class="prof-menu"> <!--ubah agar ngikutin sesuai foto yg udah disimpan di database-->
                            <h2><?php echo $user['username']; ?></h2> <!--nanti ubah biar otomatis ngikutin database nama username pas login-->
                        </div>
                        <hr>
        
                        <a href="profile.php" class="sub-menu-link">
                         <i class='bx bxs-user icon'></i>
                         <p>Edit Profil</p>
                         <span></span>
                        </a>
        
                        <a href="signout.php" class="sub-menu-link"> <!--buat pengaturan logut-->
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
        <div class="form-box">
            <form action="profile.php" method="post"> <!--masukin php edit profil-->
                <h1>Edit Profile</h1>
                <img src="kosong.jpg" id="profil"> <!--foto default-->
                <label for="input-file">Change</label>
                <input class="change" type="file" accept="image/jpeg, image/png, image/jpg" id="input-file"> <!--isi foto profil-->
                <div class="input-field">
                    <i class='bx bx-user'></i>
                    <input type="text" placeholder="Username" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                </div>
                <div class="input-box">
                <div class="input-field">
                <i class='bx bxs-envelope'></i>
                <input type="email" placeholder="Email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
                </div>
                <div class="input-field">
                <i class='bx bx-lock-alt'></i>
                <input type="password" placeholder="Password" id="password" name="password" required>
                <span class="eye" onclick="myFunction()">
                    <i id="show" class='bx bxs-show'></i>
                    <i id="hide" class='bx bxs-low-vision'></i>
                </div>
                <button class="submit-btn" type="submit">Submit</button>
            </form>
        </div>
    </div>
    <div class="popup" id="popup">
        <div class="popup-box">
            <div class="Rectangle26"></div>
            <div class="Success">SUCCESS!</div>
            <div class="YouReChangeHasBeenSaved">your change has been saved</div>
            <div class="Ellipse24"></div>                
            <div class="Ellipse25"></div>
            <div class="Ellipse32"></div>
            <div class="Ellipse26"></div>
            <div class="Ellipse33"></div>
            <div class="Ellipse27"></div>
            <div class="Ellipse28"></div>
            <div class="Ellipse34"></div>
            <div class="Ellipse30"></div>
            <div class="Ellipse35"></div>
            <div class="Ellipse31"></div>
            <div class="Ellipse29"></div>
            <img src="ceklis.jpeg" class="ceklis">
        </div>
    </div>

    <script>
        function myFunction(){
            var x = document.getElementById("password");
            var y = document.getElementById("show");
            var z = document.getElementById("hide");
        
            if(x.type == 'password'){
                x.type = "text"
                y.style.display = "block";
                z.style.display = "none";
            }
            else{
                x.type = "password"
                y.style.display = "none";
                z.style.display = "block";
            }
        }
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
        
        let profil = document.getElementById("profil");
        let input = document.getElementById("input-file");

        input.onchange= function(){
            profil.src=URL.createObjectURL(input.files[0]);
        }
        function showPopup() {
        // Mendapatkan nilai dari input
        var username = document.getElementById('username').value.trim();
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value.trim();

        // Memeriksa apakah semua input telah diisi
        if (username === '' || email === '' || password === '') {
            // Jika ada input yang kosong, tampilkan pesan peringatan
            alert('Please fill in all fields before submitting.');
        } else {
            // Jika semua input telah diisi, tampilkan popup
            var popup = document.getElementById("popup");
            popup.style.display = "flex"; // Show the popup

            // Setelah 3 detik, sembunyikan popup
            setTimeout(function() {
                popup.style.display = "none";
                window.location.href = 'signin.php';
            }, 3000);
        }
    }
    </script>
    <footer></footer>
</body>
</html>