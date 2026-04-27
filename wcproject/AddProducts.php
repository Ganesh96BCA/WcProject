<?php
session_start();
include 'conn.php';

$message = "";

if (isset($_POST['add_product'])) {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Image upload
    $photo = null;
    if (!empty($_FILES['photo']['name'])) {
        $photo = basename($_FILES['photo']['name']); // keep original name
        move_uploaded_file($_FILES['photo']['tmp_name'], "images/" . $photo); // save into images folder
    }

    if ($title && $price) {
        $stmt = $pdo->prepare("
            INSERT INTO products (title, description, photo, price, available_stock)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->execute([$title, $description, $photo, $price, $stock]);

        // ✅ Redirect to Product.php after success
        header("Location: Product.php");
        exit;
    } else {
        $message = "<div class='alert alert-danger'>Title and Price are required.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Product - FlixKart</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
body { background-color: #575157; color: #fff; }
.card { background-color: #6c7c8aff; }
label { font-weight: 500; }
</style>
</head>

<body>
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold">FlixKart Admin</a>
    <a href="Product.php" class="btn btn-outline-light">
        <i class="bi bi-arrow-left"></i> Back
    </a>
  </div>
</nav>

<div class="container mt-4">
<div class="row justify-content-center">
<div class="col-md-6">

<div class="card p-4 shadow-lg">
    <h3 class="mb-3">Add Product</h3>

    <?= $message; ?>

    <form method="POST" enctype="multipart/form-data">

        <div class="mb-3">
            <label>Product Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label>Price (€)</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Available Stock</label>
            <input type="number" name="stock" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label>Product Image</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <button type="submit" name="add_product" class="btn btn-success w-100">
            <i class="bi bi-plus-circle"></i> Add Product
        </button>

    </form>
</div>

</div>
</div>
</div>

</body>
</html>