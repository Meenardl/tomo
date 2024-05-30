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

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

if (isset($_GET['day'])) {
    $_SESSION['day'] = (int)$_GET['day'];
}

if (!isset($_SESSION['month']) || !isset($_SESSION['day'])) {
    header("Location: month.php");
    exit();
}

$conn = connectToDatabase();
$user_id = $_SESSION['user_id'];
$month = $_SESSION['month'];
$day = $_SESSION['day'];

$existing_journal_sql = "SELECT * FROM journal WHERE user_id = '$user_id' AND month = '$month' AND day = '$day'";
$existing_journal_result = $conn->query($existing_journal_sql);
$existing_journal = $existing_journal_result->fetch_assoc();

function processForm() {
    global $conn, $user_id, $month, $day, $existing_journal;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $answer_one = $conn->real_escape_string($_POST['textarea1']);
        $answer_two = $conn->real_escape_string($_POST['textarea2']);
        $answer_three = $conn->real_escape_string($_POST['textarea3']);
        $answer_four = $conn->real_escape_string($_POST['textarea4']);
        $answer_five = $conn->real_escape_string($_POST['textarea5']);
        $emoji = isset($_POST['mood']) ? $conn->real_escape_string($_POST['mood']) : '';

        if ($existing_journal) {
            // Update data
            $update_journal_sql = "UPDATE journal SET answer_one = '$answer_one', answer_two = '$answer_two', 
                                   answer_three = '$answer_three', answer_four = '$answer_four', answer_five = '$answer_five'
                                   WHERE user_id = '$user_id' AND month = '$month' AND day = '$day'";
            if ($conn->query($update_journal_sql) === TRUE) {
                //echo "<p>Diary berhasil diperbarui.</p>";
                header("Location: harian31.php"); // Ubah sesuai bulan
            } else {
                echo "Error: " . $update_journal_sql . "<br>" . $conn->error;
            }

            if ($emoji) {
                $update_mood_sql = "UPDATE mood_tracker SET mood = '$emoji' WHERE user_id = '$user_id' AND month = '$month'";
                if ($conn->query($update_mood_sql) !== TRUE) {
                    echo "Error: " . $update_mood_sql . "<br>" . $conn->error;
                }
            }
        } else {
            // Insert data baru
            $insert_journal_sql = "INSERT INTO journal (user_id, month, day, answer_one, answer_two, answer_three, answer_four, answer_five) 
                                   VALUES ('$user_id', '$month', '$day', '$answer_one', '$answer_two', '$answer_three', '$answer_four', '$answer_five')";
            if ($conn->query($insert_journal_sql) === TRUE) {
                //echo "<p>Diary berhasil disimpan.</p>";
                header("Location: harian31.php"); // Ubah sesuai bulan
            } else {
                echo "Error: " . $insert_journal_sql . "<br>" . $conn->error;
            }

            if ($emoji) {
                $insert_mood_sql = "INSERT INTO mood_tracker (user_id, month, mood) VALUES ('$user_id', '$month', '$emoji')";
                if ($conn->query($insert_mood_sql) !== TRUE) {
                    echo "Error: " . $insert_mood_sql . "<br>" . $conn->error;
                }
            }
        }

        $existing_journal_sql = "SELECT * FROM journal WHERE user_id = '$user_id' AND month = '$month' AND day = '$day'";
        $existing_journal_result = $conn->query($existing_journal_sql);
        $existing_journal = $existing_journal_result->fetch_assoc();
    }
}

processForm();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diary</title>
    <link rel="stylesheet" href="jurnal.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="jur-create.jpeg">
            <p>Take a deep breath... and tell me about your day</p>
        </div>
    </header>
    <form id="myForm" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <!-- Isi PHP buat jurnal -->
        <div class="text-field">
            <p>"What have you been up to today? All good? Tell me all about it!"</p>
            <div class="textarea-container">
                <textarea name="textarea1" id="textarea1" maxwords="200" spellcheck="false" placeholder="Type here..." required><?php echo htmlspecialchars(isset($existing_journal['answer_one']) ? $existing_journal['answer_one'] : ''); ?></textarea>
                <div class="placeholder-bottom">0/200</div>
            </div>
        </div>
        <div class="text-field">
            <p>"Did any of your worries from yesterday actually come true?"</p>
            <div class="textarea-container">
                <textarea name="textarea2" id="textarea2" maxwords="200" spellcheck="false" placeholder="Type here..." required><?php echo htmlspecialchars(isset($existing_journal['answer_two']) ? $existing_journal['answer_two'] : ''); ?></textarea>
                <div class="placeholder-bottom">0/200</div>
            </div>
        </div>
        <div class="text-field">
            <p>"Is there anything on your mind for tomorrow that's making you a bit anxious?"</p>
            <div class="textarea-container">
                <textarea name="textarea3" id="textarea3" maxwords="200" spellcheck="false" placeholder="Type here..." required><?php echo htmlspecialchars(isset($existing_journal['answer_three']) ? $existing_journal['answer_three'] : ''); ?></textarea>
                <div class="placeholder-bottom">0/200</div>
            </div>
        </div>
        <div class="text-field">
            <p>"Give yourself a pat on the back for even the smallest achievements - you totally deserve it!"</p>
            <div class="textarea-container">
                <textarea name="textarea4" id="textarea4" maxwords="200" spellcheck="false" placeholder="Type here..." required><?php echo htmlspecialchars(isset($existing_journal['answer_four']) ? $existing_journal['answer_four'] : ''); ?></textarea>
                <div class="placeholder-bottom">0/200</div>
            </div>
        </div>
        <div class="text-field">
            <p>"Got any plans for tomorrow? From your morning routine to the tasks you want to tackle, jot them down!"</p>
            <div class="textarea-container">
                <textarea name="textarea5" id="textarea5" maxwords="200" spellcheck="false" placeholder="Type here..." required><?php echo htmlspecialchars(isset($existing_journal['answer_five']) ? $existing_journal['answer_five'] : ''); ?></textarea>
                <div class="placeholder-bottom">0/200</div>
            </div>
        </div>
        <div class="emot">
            <p>"How are you feeling today? Pick a mood that matches how you're doing."</p>
        </div>
        <div class="wrap"> <!--buat agar input value ke database-->
            <img src="happy.jpeg" data-value="happy" <?php echo isset($existing_journal['mood']) && $existing_journal['mood'] === 'happy' ? 'class="selected"' : ''; ?>>
            <img src="angry.jpeg" data-value="angry" <?php echo isset($existing_journal['mood']) && $existing_journal['mood'] === 'angry' ? 'class="selected"' : ''; ?>>
            <img src="tired.jpeg" data-value="tired" <?php echo isset($existing_journal['mood']) && $existing_journal['mood'] === 'tired' ? 'class="selected"' : ''; ?>>
            <img src="anxious.jpeg" data-value="anxious" <?php echo isset($existing_journal['mood']) && $existing_journal['mood'] === 'anxious' ? 'class="selected"' : ''; ?>>
            <img src="sad.jpeg" data-value="sad" <?php echo isset($existing_journal['mood']) && $existing_journal['mood'] === 'sad' ? 'class="selected"' : ''; ?>>
        </div>
        <input type="hidden" name="mood" id="moodInput" value="<?php echo isset($existing_journal['mood']) ? $existing_journal['mood'] : ''; ?>">
        <button class="submit-btn" type="submit">Submit</button>
    </form>
    
    <footer></footer>

    <script>
        // Nilai emot
        document.querySelectorAll('.wrap img').forEach(img => {
            img.addEventListener('click', function() {
                // Ambil nilai dari atribut data-value
                const moodValue = this.getAttribute('data-value');
                
                // Masukkan nilai ke dalam input tersembunyi di dalam form
                document.getElementById('moodInput').value = moodValue;
                
                // Tampilkan perubahan visual untuk indikasi
                document.querySelectorAll('.wrap img').forEach(img => img.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        //hitung kata
        const textareas = document.querySelectorAll("textarea");
        textareas.forEach(textarea => {
            textarea.style.cssText = `height: ${textarea.scrollHeight}px; overflow-y:hidden`;
            textarea.addEventListener("input", function(){
                this.style.height = "20px";
                this.style.height = `${this.scrollHeight}px`;
                const maxWords = parseInt(this.getAttribute("maxwords")); // Mengambil jumlah maksimum kata
                const currentWords = this.value.split(/\s+/).filter(word => word !== '').length; // Memisahkan kata-kata dengan spasi dan menghitung jumlahnya
                if (currentWords > maxWords) {                        // Membatasi teks hanya hingga jumlah kata maksimum
                  this.value = this.value.split(/\s+/).slice(0, maxWords).join(' ');
                }
                this.nextElementSibling.textContent = `${currentWords}/${maxWords}`;
            });
        });

        //popup
        function submitForm() {
            const allFilled = Array.from(textareas).every(textarea => textarea.value.trim() !== '');
            if (allFilled) {
                // Formulir telah diisi, lanjutkan dengan mengirim ke halaman harian
                // Tampilkan popup di halaman harian
                showPopup();
            } else {
                // Ada textarea yang belum diisi, munculkan pesan kesalahan
                alert('Please fill in all textareas!');
                event.preventDefault(); // Menghentikan pengiriman formulir
            }
        }
    </script>
</body>
</html>
