<?php
require_once("conn.php");

if (isset($_GET['id'])) {
    $id =$_GET['id']; // safer cast for numeric IDs
    $req = "DELETE FROM users WHERE id = ?";
    $ps = $pdo->prepare($req);
    $ps->execute([$id]);
}

// ✅ Redirect back to Admin Page
header("Location: Admin.php");
exit;
?>
