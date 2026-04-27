<?php
session_start();
include 'conn.php';

if (!empty($_POST['email']) && !empty($_POST['password'])) {

    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // If using md5 (legacy)
        if (md5($pass) === $row['pwd']) {
            // Set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if ($row['role'] == 0) {
                header("Location: Admin.php");
                exit;
            } elseif ($row['role'] == 1) {
                header("Location: UserPage.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "Wrong login or password";
            header("Location: connection.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Wrong login or password";
        header("Location: connection.php");
        exit;
    }

} else {
    header("Location: connection.php");
    exit;
}
?>