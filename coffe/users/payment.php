<?php
session_start();

// Check if the payment method is selected
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment-method'])) {
    $paymentMethod = $_POST['payment-method'];
    
    // Handle the payment method
    if ($paymentMethod === 'dana') {
        // Process payment through Dana
        // Add any additional logic here
        
        // Clear the cart and totalAmount session variables
        unset($_SESSION['cartItems']);
        unset($_SESSION['totalAmount']);

        // Redirect to thank you page
        header('Location: thank_you.php');
        exit();

    } else {
        // Redirect back to checkout page if payment method is not recognized
        header('Location: checkout.php');
        exit();
    }
} else {
    // Redirect back to checkout page if payment method is not selected
    header('Location: checkout.php');
    exit();
}
?>

