<?php
session_start();
include "conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = (int)$_GET['product_id'];

/* CHECK IF PRODUCT ALREADY IN CART */
$stmt = $pdo->prepare("
    SELECT cart_id, quantity 
    FROM cart 
    WHERE user_id = ? AND product_id = ?
");
$stmt->execute([$user_id, $product_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if ($item) {
    // Increase quantity
    $stmt = $pdo->prepare("
        UPDATE cart 
        SET quantity = quantity + 1 
        WHERE cart_id = ?
    ");
    $stmt->execute([$item['cart_id']]);
} else {
    // Insert new item
    $stmt = $pdo->prepare("
        INSERT INTO cart (user_id, product_id, quantity)
        VALUES (?, ?, 1)
    ");
    $stmt->execute([$user_id, $product_id]);
}

header("Location: userpage.php");
exit;
