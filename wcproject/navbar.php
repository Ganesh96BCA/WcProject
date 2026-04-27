<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "conn.php";

/* CART COUNT FROM DATABASE */
$cartCount = 0;
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("
        SELECT SUM(quantity) AS total 
        FROM cart 
        WHERE user_id = ?
    ");
    $stmt->execute([$_SESSION['user_id']]);
    $cartCount = $stmt->fetchColumn();
    if (!$cartCount) $cartCount = 0;
}
?>

<nav class="navbar navbar-dark bg-dark">
<div class="container-fluid">
    <a class="navbar-brand fw-bold" href="userpage.php">FlixKart</a>

    <div class="d-flex align-items-center ms-auto">

        <!-- CART ICON WITH COUNT -->
        <a href="cart.php" class="btn btn-outline-warning me-3 position-relative">
            <i class="bi bi-cart"></i>

            <?php if ($cartCount > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= $cartCount; ?>
            </span>
            <?php endif; ?>
        </a>

        <!-- ACCOUNT -->
        <a href="orders.php" class="btn btn-outline-light me-2">
            <i class="bi bi-person-circle"></i> Account
        </a>

        <!-- LOGOUT -->
        <a href="index.php" class="btn btn-outline-danger">
            Logout
        </a>

    </div>
</div>
</nav>
