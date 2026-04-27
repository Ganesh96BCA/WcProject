<?php
session_start();
include 'conn.php';

// Get product ID
if (!isset($_GET['id'])) {
    header("Location: Product.php");
    exit;
}
$id = (int) $_GET['id'];

// Fetch product
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Product not found!";
    exit;
}

// Handle update
if (isset($_POST['update_product'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Keep old photo unless new one uploaded
    $photo = $product['photo'];
    if (!empty($_FILES['photo']['name'])) {
        $photo = basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], "images/" . $photo);
    }

    $stmt = $pdo->prepare("UPDATE products 
                           SET title=?, description=?, photo=?, price=?, available_stock=? 
                           WHERE id=?");
    $stmt->execute([$title, $description, $photo, $price, $stock, $id]);

    header("Location: Product.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Product</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<div class="container mt-4">
<nav> 
     <<a href="admin.php" class="btn btn-outline-light me-2">
                <i class="bi bi-arrow-left-circle"></i> Back
            </a>  
<h3>Edit Product</h3>
</nav>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($product['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($product['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Stock</label>
            <input type="number" name="stock" class="form-control" value="<?= $product['available_stock']; ?>">
        </div>
        <div class="mb-3">
            <label>Current Image</label><br>
            <?php if ($product['photo']): ?>
                <img src="images/<?= htmlspecialchars($product['photo']); ?>" width="80">
            <?php else: ?>
                <img src="images/no-image.png" width="80">
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label>Change Image</label>
            <input type="file" name="photo" class="form-control">
        </div>
        <button type="submit" name="update_product" class="btn btn-primary">Update</button>
    </form>
</div>

</body>
</html>