<?php
$invalid = 0;
$login = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT * FROM form WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $num = mysqli_num_rows($result);

        if ($num > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, trim($row['password']))) { 
                $login = 1;
                session_start();
                $_SESSION['username'] = $username;
                header('location:home.php');
            } else {
                $invalid = 1;
            }
        } else {
            $invalid = 1;
        }
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
</head>
<body>
<?php
if ($invalid) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>&#9888;</strong> invalid username or password.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}

if ($login) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong></strong> login successfully.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>
    <div class="container my-5">
        <h2 class="text-center">log in</h2>
        <form action="login.php" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Enter your username" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter your password" autocomplete="off">
            </div>
            <button type="submit" class="btn btn-primary">login</button>
            <a href="signup.php" class="btn btn-secondary">signup</a>
        </form>
    </div>
</body>
</html>
