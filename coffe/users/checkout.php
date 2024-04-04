<?php
session_start();

// Ambil data keranjang belanja dan total pembayaran dari sesi
$cartItems = isset($_SESSION['cartItems']) ? $_SESSION['cartItems'] : [];
$totalAmount = isset($_SESSION['totalAmount']) ? $_SESSION['totalAmount'] : 0;

// Validasi apakah keranjang belanja kosong
if (empty($cartItems)) {
    // Jika keranjang belanja kosong, arahkan pengguna kembali ke halaman utama atau halaman keranjang belanja
    header('Location: index.php'); // Ganti "index.php" dengan halaman yang sesuai
    exit(); // Hentikan eksekusi skrip
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../assets/css/chechout.css">
</head>
<body>
    <h2>Checkout</h2>
    
    <div class="checkout-items">
        <!-- Loop through each item in the cart -->
        <?php foreach ($cartItems as $item): ?>
            <div class="checkout-item">
                <div class="item-details">
                    <h3><?php echo isset($item['name']) ? $item['name'] : ''; ?></h3>
                    <div class="item-info">
                        <p>Price: <?php echo isset($item['price']) ? $item['price'] : ''; ?></p>
                        <p>Quantity: <?php echo isset($item['quantity']) ? $item['quantity'] : ''; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div class="checkout-total">
        <h3>Total Amount: <?php echo $totalAmount; ?></h3>
    </div>
    
    <form action="payment.php" method="POST">
        <label for="payment-method">Select Payment Method:</label>
        <select name="payment-method" id="payment-method">
            <option value="dana">Dana</option>
        </select>
        <button type="submit">Proceed to Payment</button>
        <a href="index.php" class="btn">Back</a>
    </form>
</body>
</html>