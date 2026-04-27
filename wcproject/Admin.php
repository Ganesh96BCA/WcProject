<?php
session_start();

// Include your existing PDO connection
include "conn.php";

// Handle user actions: Promote or Delete
if (isset($_GET['action']) && isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);

    if ($_GET['action'] === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id=?");
        $stmt->execute([$user_id]);
    } elseif ($_GET['action'] === 'promote') {
        $stmt = $pdo->prepare("UPDATE users SET role='admin' WHERE id=?");
        $stmt->execute([$user_id]);
    }

    header("Location: admin.php?page=listusers");
    exit;
}

// Fetch statistics
$total_users = $pdo->query("SELECT COUNT(*) AS total FROM users WHERE ROLE=1")->fetch(PDO::FETCH_ASSOC)['total'];
$total_products = $pdo->query("SELECT COUNT(*) AS total FROM products")->fetch(PDO::FETCH_ASSOC)['total'];
$total_orders = $pdo->query("SELECT COUNT(*) AS total FROM orders")->fetch(PDO::FETCH_ASSOC)['total'];

// Determine page
$page = isset($_GET['page']) ? $_GET['page'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel - FlixKart</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/Admin.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <h2><i class="bi bi-speedometer2"></i> Admin Dashboard</h2>
    <div class="d-flex ms-auto">
        <a href="Product.php" class="btn btn-outline-light me-2"> <i class="fa-solid fa-person-dress" style="color:#ff69b4;"></i> Manage Products</a>
        <a href="listusers.php" class="btn btn-outline-light me-2"> <i class="bi bi-people-fill" style="color:#ff69b4;"></i>Manage Users</a>
      <a href="menu.php" class="btn btn-outline-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-4">

<?php
if ($page === 'listusers') {
    // Show user list
    $stmt = $pdo->query("SELECT id, username, email, role FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <h3 class="mb-3"><i class="bi bi-people-fill"></i> Registered Users</h3>
    <table class="table table-dark table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ($users) {
            foreach ($users as $row) {
                echo "<tr>
                        <td>".$row['id']."</td>
                        <td>".$row['username']."</td>
                        <td>".$row['email']."</td>
                        <td>".$row['role']."</td>
                        <td>
                            <a href='admin.php?page=listusers&action=promote&user_id=".$row['id']."' class='btn btn-sm btn-success me-1'>Promote</a>
                            <a href='admin.php?page=listusers&action=delete&user_id=".$row['id']."' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure?')\">Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No users found</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <?php
} else {
    // Dashboard overview
    ?>
    <div class="row g-4">
    <div class="col-md-4">
        <div class="card text-center text-dark shadow-lg border-0 rounded-4 stat-card bg-gradient bg-warning-subtle">
            <div class="p-3">
                <div class="rounded-circle bg-warning d-inline-block p-3 mb-2">
                    <i class="bi bi-box-seam fs-2 text-dark"></i>
                </div>
                <h3 class="fw-bold"><?= $total_products; ?></h3>
                <p class="mb-0">Total Products</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
    <a href="adminorders.php" style="text-decoration:none;">
        <div class="card text-center text-dark shadow-lg border-0 rounded-4 stat-card bg-gradient bg-success-subtle">
            <div class="p-3">
                <div class="rounded-circle bg-success d-inline-block p-3 mb-2">
                    <i class="bi bi-bag-check fs-2 text-white"></i>
                </div>
                <h3 class="fw-bold"><?= $total_orders; ?></h3>
                <p class="mb-0">Total Orders</p>
            </div>
        </div>
    </a>
</div>


    <div class="col-md-4">
        <div class="card text-center text-dark shadow-lg border-0 rounded-4 stat-card bg-gradient bg-info-subtle">
            <div class="p-3">
                <div class="rounded-circle bg-info d-inline-block p-3 mb-2">
                    <i class="bi bi-people-fill fs-2 text-white"></i>
                </div>
                <h3 class="fw-bold"><?= $total_users; ?></h3>
                <p class="mb-0">Registered Users</p>
            </div>
        </div>
    </div>
</div>
    <?php
}
?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
