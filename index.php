<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
$action = $_GET['action'] ?? 'login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoCollect - <?php echo $action === 'register' ? 'Register' : 'Login'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div id="loaderOverlay" class="loader-overlay">
        <div class="loader"></div>
        <p>Loading...</p>
    </div>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h2>InfoCollect</h2>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if ($action === 'register'): ?>
                <form action="register.php" method="POST">
                    <div class="form-group">
                        <label class="form-label" for="name">Full Name</label>
                        <input type="text" id="name" name="name" class="form-control" required placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required placeholder="john@example.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required minlength="6" placeholder="••••••••">
                    </div>
                    <button type="submit" class="btn">Create Account</button>
                    <p class="form-text">Already have an account? <a href="index.php?action=login">Login here</a></p>
                </form>
            <?php else: ?>
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required placeholder="john@example.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required placeholder="••••••••">
                    </div>
                    <button type="submit" class="btn">Login</button>
                    <p class="form-text">Don't have an account? <a href="index.php?action=register">Register here</a></p>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
