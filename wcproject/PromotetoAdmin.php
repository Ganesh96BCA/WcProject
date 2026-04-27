<?php
require_once("conn.php");

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $pdo->prepare("UPDATE users SET role = 0 WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: listusers.php"); // or wherever your user list is
exit;
