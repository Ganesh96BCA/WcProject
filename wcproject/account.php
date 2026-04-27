<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>My Account</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">

<?php include "navbar.php"; ?>

<div class="container mt-4">
<h4><i class="bi bi-person"></i> My Account</h4>

<div class="card p-3 text-dark">
<p><strong>User ID:</strong> <?= $_SESSION['user_id']; ?></p>
<p><strong>Email:</strong> <?= $_SESSION['email'] ?? 'Not Available'; ?></p>
</div>
</div>

</body>
</html>
