<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $purchasedate = $_POST['created_at']; // Updated this line to match the input name

    // Include purchasedate in the addProduct function
    addProduct($name, $category, $price, $quantity, $purchasedate);
    header("Location: index.php");
    exit();
}
?>
