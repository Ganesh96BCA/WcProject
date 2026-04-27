<?php
session_start();
include "conn.php";

/* ==============================
   UPDATE ORDER STATUS
================================ */
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status   = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE orders SET status=? WHERE order_id=?");
    $stmt->execute([$status, $order_id]);

    header("Location: AdminOrders.php");
    exit;
}

/* ==============================
   FETCH ALL ORDERS
================================ */
$stmt = $pdo->prepare("
    SELECT order_id, user_id, status, order_date
    FROM orders
    ORDER BY order_date DESC
");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Orders</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background-color: #575157;
    color: #fff;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <h4 class="mb-0"><i class="bi bi-bag-check"></i> Orders Management</h4>
        <a href="admin.php" class="btn btn-outline-light btn-sm">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</nav>

<div class="container mt-4">

    <table class="table table-dark table-striped table-hover">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Status</th>
                <th>Change Status</th>
                <th>Order Date</th>
            </tr>
        </thead>

        <tbody>
        <?php if ($orders): foreach ($orders as $order): ?>
            <tr>
                <td><?= $order['order_id']; ?></td>
                <td><?= $order['user_id']; ?></td>

                <td>
                    <span class="badge
                        <?= $order['status']=='Pending' ? 'bg-warning' :
                           ($order['status']=='Shipped' ? 'bg-info' :
                           ($order['status']=='Delivered' ? 'bg-success' : 'bg-danger')); ?>">
                        <?= $order['status']; ?>
                    </span>
                </td>

                <td>
                    <form method="POST" class="d-flex">
                        <input type="hidden" name="order_id" value="<?= $order['order_id']; ?>">

                        <select name="status" class="form-select form-select-sm me-2">
                            <option value="Pending"   <?= $order['status']=='Pending'?'selected':''; ?>>Pending</option>
                            <option value="Shipped"   <?= $order['status']=='Shipped'?'selected':''; ?>>Shipped</option>
                            <option value="Delivered" <?= $order['status']=='Delivered'?'selected':''; ?>>Delivered</option>
                            <option value="Canceled"  <?= $order['status']=='Canceled'?'selected':''; ?>>Canceled</option>
                        </select>

                        <button type="submit" name="update_status" class="btn btn-sm btn-primary">
                            Update
                        </button>
                    </form>
                </td>

                <td><?= $order['order_date']; ?></td>
            </tr>
        <?php endforeach; else: ?>
            <tr>
                <td colspan="5" class="text-center">No orders found</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</div>

</body>
</html>
