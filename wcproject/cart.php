<?php
session_start();
include "conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* ==================================
   PLACE ORDER + REDUCE STOCK
================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {

    // Fetch cart items with stock
    $stmt = $pdo->prepare("
        SELECT c.product_id, c.quantity, p.available_stock
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$user_id]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$cartItems) {
        die("Cart is empty");
    }

    $pdo->beginTransaction();

    try {

        // Create order
        $stmt = $pdo->prepare("INSERT INTO orders (user_id) VALUES (?)");
        $stmt->execute([$user_id]);
        $order_id = $pdo->lastInsertId();

        foreach ($cartItems as $item) {

            // Stock validation
            if ($item['quantity'] > $item['available_stock']) {
                throw new Exception("Not enough stock for product ID " . $item['product_id']);
            }

            // Insert order items
            $stmt = $pdo->prepare("
                INSERT INTO order_items (order_id, product_id, quantity)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([
                $order_id,
                $item['product_id'],
                $item['quantity']
            ]);

            // Reduce stock
            $stmt = $pdo->prepare("
                UPDATE products
                SET available_stock = available_stock - ?
                WHERE id = ?
            ");
            $stmt->execute([
                $item['quantity'],
                $item['product_id']
            ]);
        }

        // Clear cart
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->execute([$user_id]);

        $pdo->commit();

        $success = "Order placed successfully!";

    } catch (Exception $e) {
        $pdo->rollBack();
        $error = $e->getMessage();
    }
}

/* ==================================
   REMOVE ITEM FROM CART
================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_cart_id'])) {
    $cart_id = $_POST['remove_cart_id'];

    $delete = $pdo->prepare("
        DELETE FROM cart 
        WHERE cart_id = ? AND user_id = ?
    ");
    $delete->execute([$cart_id, $user_id]);

    header("Location: cart.php");
    exit;
}

/* ==================================
   FETCH CART ITEMS
================================== */
$stmt = $pdo->prepare("
    SELECT c.cart_id, p.title, p.price, c.quantity
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
");
$stmt->execute([$user_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Your Cart</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body { background: #575157; color: white; }
.remove-btn {
    background: none;
    border: none;
    color: #ff6b6b;
}
.remove-btn:hover { color: red; }
</style>
</head>

<body>

<?php include "navbar.php"; ?>

<div class="container mt-4">

<h4><i class="bi bi-cart"></i> Your Cart</h4>

<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= $success; ?></div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?= $error; ?></div>
<?php endif; ?>

<?php if ($cartItems): ?>

<table class="table table-dark table-striped align-middle">
<thead>
<tr>
    <th>Product</th>
    <th>Qty</th>
    <th>Price</th>
    <th>Total</th>
    <th class="text-center">Remove</th>
</tr>
</thead>
<tbody>

<?php
$grand = 0;
foreach ($cartItems as $item):
    $total = $item['price'] * $item['quantity'];
    $grand += $total;
?>
<tr>
    <td><?= htmlspecialchars($item['title']); ?></td>
    <td><?= $item['quantity']; ?></td>
    <td>€<?= number_format($item['price'], 2); ?></td>
    <td>€<?= number_format($total, 2); ?></td>

    <td class="text-center">
        <form method="POST">
            <input type="hidden" name="remove_cart_id" value="<?= $item['cart_id']; ?>">
            <button type="submit" class="remove-btn">
                <i class="bi bi-trash fs-5"></i>
            </button>
        </form>
    </td>
</tr>
<?php endforeach; ?>

<tr class="fw-bold">
    <td colspan="3" class="text-end">Grand Total</td>
    <td>€<?= number_format($grand, 2); ?></td>
    <td></td>
</tr>

</tbody>
</table>

<!-- PLACE ORDER BUTTON -->
<form method="POST">
    <button type="submit" name="place_order" class="btn btn-success">
        <i class="bi bi-bag-check"></i> Place Order
    </button>
</form>

<?php else: ?>
<div class="alert alert-info">Your cart is empty.</div>
<?php endif; ?>

</div>

</body>
</html>
