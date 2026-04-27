<?php
session_start();
include "conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$pdo->beginTransaction();

/* CREATE ORDER */
$stmt = $pdo->prepare("INSERT INTO orders (user_id) VALUES (?)");
$stmt->execute([$user_id]);
$order_id = $pdo->lastInsertId();

/* FETCH CART ITEMS */
$stmt = $pdo->prepare("SELECT product_id, quantity FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* INSERT ORDER ITEMS */
foreach ($items as $item) {
    $stmt = $pdo->prepare("
        INSERT INTO order_items (order_id, product_id, quantity)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$order_id, $item['product_id'], $item['quantity']]);
}

/* CLEAR CART */
$stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);

$pdo->commit();

header("Location: orders.php");
exit;
