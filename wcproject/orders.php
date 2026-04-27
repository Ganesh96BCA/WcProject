<?php
session_start();
include "conn.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("
    SELECT 
        o.order_id,
        o.order_date,
        o.status,
        SUM(oi.quantity) AS total_qty
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    WHERE o.user_id = ?
    GROUP BY o.order_id, o.order_date, o.status
    ORDER BY o.order_date DESC
");
$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>My Orders</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">

<?php include "navbar.php"; ?>

<div class="container mt-4">
<h4><i class="bi bi-bag"></i> My Orders</h4>

<?php if ($orders): ?>
<table class="table table-dark table-striped">
<thead>
<tr>
    <th>Order ID</th>
    <th>Total Qty</th>
    <th>Status</th>
    <th>Date</th>
</tr>
</thead>
<tbody>

<?php foreach ($orders as $o): ?>
<tr>
    <td><?= $o['order_id']; ?></td>
    <td><?= $o['total_qty']; ?></td>
    <td><?= $o['status']; ?></td>
    <td><?= $o['order_date']; ?></td>
</tr>
<?php endforeach; ?>

</tbody>
</table>
<?php else: ?>
<div class="alert alert-info">No orders found.</div>
<?php endif; ?>

</div>

</body>
</html>
