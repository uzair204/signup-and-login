<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center">Home</h2>
        <h1 class="text center">Welcome to the home page, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <a class="btn btn-primary" href="logout.php">Logout</a>
        <a class="btn btn-primary" href="profile.php">profile</a>
    </div>
</body>
</html>

