<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['product_id'];
    deleteProduct($id);
    header("Location: index.php");
    exit();
}
?>
