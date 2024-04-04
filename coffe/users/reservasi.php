<?php
// Konfigurasi koneksi database
$servername = "localhost"; // Ganti dengan nama host MySQL Anda
$username = "root"; // Ganti dengan nama pengguna MySQL Anda
$password = ""; // Ganti dengan kata sandi MySQL Anda
$dbname = "kapetann"; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menyimpan data reservasi jika formulir disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $message = $_POST["message"];
    $create_datetime = date("Y-m-d H:i:s");

    // Menyiapkan pernyataan SQL INSERT dengan placeholder
    $stmt = $conn->prepare("INSERT INTO reservasi (name, email, phone, date, time, message, create_datetime) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Binding parameter ke pernyataan SQL
    $stmt->bind_param("sssssss", $name, $email, $phone, $date, $time, $message, $create_datetime);

    // Jalankan pernyataan SQL
    if ($stmt->execute()) {
        echo "<p>Thank you, $name! Your reservation for $date at $time has been confirmed.</p>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Tutup pernyataan
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservation Form</title>
    <link rel="stylesheet" href="../assets/css/reservasi.css"/>
</head>
<body>
    <h2>Reservasi</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" required><br>
        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" required><br>
        <label for="time">Time:</label><br>
        <input type="time" id="time" name="time" required><br>
        <label for="message">Message (optional):</label><br>
        <textarea id="message" name="message" rows="4" cols="50"></textarea><br>
        <input type="submit" value="Submit Reservation">
        <a href="index.php" class="btn">Back</a>
    </form>
</body>
</html>