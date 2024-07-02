<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require 'connect.php';

$username = $_SESSION['username'];
$query = "SELECT * FROM form WHERE username = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1>User Profile</h1>
            </div>
            <div class="card-body">
                <?php if ($user): ?>
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
            
                <?php else: ?>
                    <p class="text-danger">User details not found.</p>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-primary mt-3">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
