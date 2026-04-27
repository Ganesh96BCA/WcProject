<?php
$title = "Users List";
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Users - FlixKart</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/listusers.css">
</head>
<body>
<div class="container mt-4">
<nav>
    <a href="admin.php" class="btn btn-outline-light me-2">
        <i class="bi bi-arrow-left-circle"></i> Back
    </a>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Users List</h1>
        <div>
            <a href="menu.php" class="btn btn-outline-light custom-logout">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</nav>

<table class="table table-striped table-dark">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Role</th>
            <th>Photo</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php
    require_once("conn.php");

    $stmt = $pdo->prepare("SELECT * FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        foreach ($users as $row) {
            // Skip admins (role = 0)
            if ($row['role'] == 0) continue;
            ?>
            <tr>
                <th scope="row"><?= $row['id'] ?></th>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= $row['role'] == 1 ? 'User' : 'Admin' ?></td>
                <td>
                    <?php if (!empty($row['photo'])): ?>
                        <img src="images/<?= htmlspecialchars($row['photo']) ?>" width="100" height="100">
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
                <td>
                    <a href="deleteUsers.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger me-1"
                       onclick="return confirm('Delete this User?')">Delete</a>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning me-1">Edit</a>
                    <a href="promotetoAdmin.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info"
                       onclick="return confirm('Promote this user to Admin?')">Promote to Admin</a>
                </td>
            </tr>
            <?php
        }
    } else {
        echo "<tr><td colspan='6'>No users found</td></tr>";
    }
    ?>
    </tbody>
</table>
</div>
</body>
</html>
<?php include 'footer.php'; ?>