<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Fetch submissions
try {
    $stmt = $pdo->prepare("SELECT title, description, created_at FROM submissions WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    $submissions = $stmt->fetchAll();
} catch (PDOException $e) {
    $submissions = [];
    $error_msg = "Could not load submissions.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InfoCollect - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                InfoCollect
            </div>
            <div class="navbar-nav">
                <span class="nav-link">Welcome, <?php echo htmlspecialchars($user_name); ?></span>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container dashboard-container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="dashboard-grid">
            <!-- Left Column: Form -->
            <div class="dashboard-form">
                <div class="card">
                    <h3 class="card-title">Submit New Data</h3>
                    <form action="submit.php" method="POST">
                        <div class="form-group">
                            <label class="form-label" for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control" required placeholder="Enter data title">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" required placeholder="Provide details..."></textarea>
                        </div>
                        <button type="submit" class="btn">Submit Data</button>
                    </form>
                </div>
            </div>

            <!-- Right Column: Submissions List -->
            <div class="dashboard-data">
                <div class="card">
                    <h3 class="card-title">Your Recent Submissions</h3>
                    <?php if (isset($error_msg)): ?>
                        <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                    <?php endif; ?>

                    <?php if (empty($submissions)): ?>
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                            <p>No data submitted yet.</p>
                        </div>
                    <?php else: ?>
                        <div class="submissions-list">
                            <?php foreach ($submissions as $sub): ?>
                                <div class="submission-item">
                                    <h4><?php echo htmlspecialchars($sub['title']); ?></h4>
                                    <div class="submission-meta">
                                        Submitted on: <?php echo date('M d, Y g:i A', strtotime($sub['created_at'])); ?>
                                    </div>
                                    <p class="submission-desc"><?php echo nl2br(htmlspecialchars($sub['description'])); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>
