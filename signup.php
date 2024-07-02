<?php
$success = 0;
$userExists = 0;
$emailExists = 0;
$phoneExists = 0;
$missingFields = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';

    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($phone) || empty($password)) {
        $missingFields = 1;
    } else {
        $stmt = $con->prepare("SELECT * FROM form WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) > 0) {
            $userExists = 1;
        }

        $stmt = $con->prepare("SELECT * FROM form WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) > 0) {
            $emailExists = 1;
        }

        $stmt = $con->prepare("SELECT * FROM form WHERE phone = ?");
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        if (mysqli_num_rows($result) > 0) {
            $phoneExists = 1;
        }

        if (!$userExists && !$emailExists && !$phoneExists) {
            $hashpassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $con->prepare("INSERT INTO form (username, email, phone, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $username, $email, $phone, $hashpassword);
            $result = $stmt->execute();
            if ($result) {
                $success = 1;
                header('location:login.php');
            } else {
                die(mysqli_error($con));
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" >
</head>
<body>

<?php
if ($missingFields) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>&#9888;</strong> All fields are required.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}

if ($userExists) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>&#9888;</strong> Username already exists.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}

if ($emailExists) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>&#9888;</strong> Email already exists.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}

if ($phoneExists) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>&#9888;</strong> Phone number already exists.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}

if ($success) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong></strong> Sign up successful.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
?>

<div class="container my-5">
    <h2 class="text-center">Sign up</h2>
    <form action='signup.php' method='post'>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" placeholder="Enter your username" autocomplete="off">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Enter your email" autocomplete="off">
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" placeholder="Enter your phone" autocomplete="off">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Enter your password" autocomplete="off">
        </div>
        <button type="submit" class="btn btn-primary">Sign up</button>
    </form>
</div>

</body>
</html>
