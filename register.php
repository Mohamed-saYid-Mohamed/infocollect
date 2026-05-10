<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['error'] = 'Please fill in all fields.';
        header("Location: index.php?action=register");
        exit();
    }

    if (strlen($password) < 6) {
        $_SESSION['error'] = 'Password must be at least 6 characters.';
        header("Location: index.php?action=register");
        exit();
    }

    try {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $_SESSION['error'] = 'Email is already registered.';
            header("Location: index.php?action=register");
            exit();
        }

        // Insert new user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashed_password]);

        $_SESSION['success'] = 'Registration successful! Please login.';
        header("Location: index.php?action=login");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Something went wrong. Please try again.';
        header("Location: index.php?action=register");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
