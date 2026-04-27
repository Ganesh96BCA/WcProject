<?php
session_start();
include "conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Products</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { background:#575157; color:white; }
.card { background:#6c7c8a; }
.product-img { width:70px; height:70px; object-fit:cover; }
</style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="container mt-4">
<h4><i class="bi bi-box-seam"></i> Products</h4>

<div class="row">
<?php foreach ($products as $p): ?>
<div class="col-md-4 mb-3">
    <div class="card p-3">
        <img src="images/<?= $p['photo'] ?: 'no-image.png'; ?>" class="product-img mb-2">
        <h5><?= htmlspecialchars($p['title']); ?></h5>
        <p>€<?= number_format($p['price'],2); ?></p>

        <a href="add_to_cart.php?product_id=<?= $p['id']; ?>" class="btn btn-warning btn-sm">
            <i class="bi bi-cart-plus"></i> Add to Cart
        </a>
    </div>
</div>
<?php endforeach; ?>
</div>
</div>

</body>
</html>
