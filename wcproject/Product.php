<?php
session_start();
include 'conn.php'; // Product.php is in root wcproject

date_default_timezone_set('Europe/London');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Products - FlixKart</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/product.css">
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a href="admin.php" class="btn btn-outline-light me-2">
                <i class="bi bi-arrow-left-circle"></i> Back
            </a>
   
    <div class="d-flex ms-auto">
        <a href="AddProducts.php" class="btn btn-outline-light me-2">
            <i class="bi bi-plus-square text-warning"></i> Add Product
        </a>
        <a href="menu.php" class="btn btn-outline-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
  </div>
</nav>

<!-- CONTENT -->
<div class="container mt-4">

<h3 class="mb-3">
    Product List
</h3>

<?php
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table table-dark table-striped table-hover">
<thead>
<tr>
    <th>ID</th>
    <th>Image</th>
    <th>Product</th>
    <th>Description</th>
    <th>Price ($)</th>
    <th>Stock</th>
    <th>Actions</th>
</tr>
</thead>

<tbody>
<?php if (!empty($products)): ?>
    <?php foreach ($products as $product): ?>
    <tr>
        <td><?= $product['id']; ?></td>
<td>
    <?php
    if (!empty($product['photo'])) {
        // Show product image from images folder
        echo '<img src="images/' . htmlspecialchars($product['photo']) . '" class="product-img">';
    } else {
        // Show default placeholder image
        echo '<img src="images/no-image.png" class="product-img">';
    }
    ?>
</td>




        <td>
            <i class="fa-solid fa-person-dress text-warning me-1"></i>
            <?= htmlspecialchars($product['title']); ?>
        </td>

        <td><?= htmlspecialchars(substr($product['description'], 0, 80)); ?>...</td>

        <td><?= number_format($product['price'], 2); ?></td>

        <td>
            <?php if ($product['available_stock'] > 0): ?>
                <span class="badge bg-success">
                    <?= $product['available_stock']; ?> Available
                </span>
            <?php else: ?>
                <span class="badge bg-danger">Out of Stock</span>
            <?php endif; ?>
        </td>

        <td>
            <a href="EditProduct.php?id=<?= $product['id']; ?>" class="btn btn-sm btn-primary">
                <i class="bi bi-pencil"></i>
            </a>
            <a href="deleteProducts.php?id=<?= $product['id']; ?>"
               class="btn btn-sm btn-danger"
               onclick="return confirm('Delete this product?')">
                <i class="bi bi-trash"></i>
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="7" class="text-center">No products found</td>
    </tr>
<?php endif; ?>
</tbody>
</table>

</div>

</body>
</html>
