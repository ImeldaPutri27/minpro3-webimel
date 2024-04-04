<?php
   // Sertakan file koneksi ke database
   include 'db.php';

   // Mulai sesi
   session_start();

   // Dapatkan detail pesanan dari permintaan POST
   $orderDetails = json_decode(file_get_contents('php://input'), true);

   // Dapatkan username dari sesi
   $user = $_SESSION['username'];

   // Dapatkan ID pengguna berdasarkan nama pengguna
   $sql1 = "SELECT * FROM users WHERE username = '$user'";
   $result = $con->query($sql1);
   while($row = $result->fetch_assoc()) {
       $id = $row['id'];
   }

   // Insert detail pesanan ke dalam database
   $date = date('Y-m-d');
   foreach ($orderDetails as $order) {
       $title = $order['title'];
       $price = $order['price'];
       $quantity = $order['quantity'];
       $subtotalAmount = $order['subtotal_amount'];
       $invoiceNumber = $order['invoice_number'];
       $sql = "INSERT INTO orders (price, title, quantity, subtotal_amount, date, invoice_number, user_id) VALUES ('$price', '$title', '$quantity', '$subtotalAmount', '$date', '$invoiceNumber', '$id')";
       if ($con->query($sql) !== TRUE) {
           echo "Error: " . $sql . "<br>" . $con->error;
       }
   }

    // Hitung total pembayaran
    $totalAmount = 0;
    foreach ($orderDetails as $order) {
        $totalAmount += $order['subtotal_amount'];
    }

    // Simpan data keranjang belanja dan total pembayaran di dalam $_SESSION
    $_SESSION['cartItems'] = $orderDetails;
    $_SESSION['totalAmount'] = $totalAmount;

    // Redirect ke halaman checkout setelah semua item order ditambahkan
    header('Location: checkout.php');
    exit();

    // Close database connection
    $con->close();
?>
