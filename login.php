<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = 'Please fill in all fields.';
        header("Location: index.php?action=login");
        exit();
    }

    try {
        $stmt = $pdo->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = 'Invalid email or password.';
            header("Location: index.php?action=login");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Something went wrong. Please try again.';
        header("Location: index.php?action=login");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
