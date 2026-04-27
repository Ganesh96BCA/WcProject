<?php
require_once("conn.php");

if (isset($_GET['id'])) {
    $id =$_GET['id']; // safer cast for numeric IDs
    $req = "DELETE FROM products WHERE id = ?";
    $ps = $pdo->prepare($req);
    $ps->execute([$id]);
}

// ✅ Redirect back to product list
header("Location: Admin.php");
exit;
?>
