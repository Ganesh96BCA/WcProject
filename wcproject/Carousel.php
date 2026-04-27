<?php
include "conn.php";

/* ============================
   FETCH PRODUCTS FOR CAROUSEL
============================= */
$stmt = $pdo->prepare("
    SELECT title, description, photo
    FROM products
    WHERE photo IS NOT NULL AND photo != ''
    ORDER BY created_at DESC
    LIMIT 5
");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FlixKart - Simple Store</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/carousel.css">
</head>
<body>

<div class="carousel-container mt-3">

<?php if (!empty($products)): ?>

<div id="simpleCarousel"
     class="carousel slide carousel-fade"
     data-bs-ride="carousel"
     data-bs-interval="4000"
     data-bs-pause="hover"
     data-bs-wrap="true">

    <!-- Indicators -->
    <div class="carousel-indicators">
        <?php foreach ($products as $index => $p): ?>
            <button type="button"
                    data-bs-target="#simpleCarousel"
                    data-bs-slide-to="<?= $index; ?>"
                    class="<?= $index === 0 ? 'active' : ''; ?>">
            </button>
        <?php endforeach; ?>
    </div>

    <!-- Slides -->
    <div class="carousel-inner">
        <?php foreach ($products as $index => $p): ?>
        <div class="carousel-item <?= $index === 0 ? 'active' : ''; ?>">
            <img src="images/<?= htmlspecialchars($p['photo']); ?>"
                 alt="<?= htmlspecialchars($p['title']); ?>">

            <div class="carousel-caption">
                <h5><?= htmlspecialchars($p['title']); ?></h5>
                <p><?= htmlspecialchars(substr($p['description'], 0, 80)); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#simpleCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#simpleCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>

</div>

<?php else: ?>
    <div class="alert alert-warning text-center mt-4">
        No products available for carousel
    </div>
<?php endif; ?>

</div>

<footer>© 2025 FlixKart • Simple Design</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
