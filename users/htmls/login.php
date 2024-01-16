<?php
session_start();
include('connect.php');

if (isset($_SESSION["user_id"])) {
    echo "<script>window.location.href = 'quiz_page.php';</script>";
    exit();
}
if (isset($_SESSION["admin_id"])) {
    echo "<script>window.location.href = '../../admin/adminfiles/admin.php';</script>";
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        echo "<script>alert('Please enter both email and password.'); window.location.href = 'login.php';</script>";
        exit();
    } else {
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        $userQuery = "SELECT id, email, password FROM user WHERE email = ? AND password = ? LIMIT 1";
        $stmt = $conn->prepare($userQuery);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $userResult = $stmt->get_result();
        $stmt->close();

        $adminQuery = "SELECT id, name, email, password FROM admin WHERE email = ? AND password = ? LIMIT 1";
        $stmt = $conn->prepare($adminQuery);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $adminResult = $stmt->get_result();
        $stmt->close();

        if ($userResult->num_rows == 1) {
            $row = $userResult->fetch_assoc();
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["email"] = $row["email"];
            echo "<script>window.location.href = 'quiz_page.php';</script>";
            exit();
        } elseif ($adminResult->num_rows == 1) {
            $row = $adminResult->fetch_assoc();
            $_SESSION["admin_id"] = $row["id"];
            $_SESSION["admin_name"] = $row["name"];
            echo "<script>window.location.href = '../../admin/adminfiles/admin.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error in email or password.'); window.location.href = '../htmls/login.php';</script>";
            exit();
        }
    }
}

$stmt = $conn->prepare("SELECT twitter, instagram, email FROM contact_links WHERE id = 1");
$stmt->execute();
$stmt->bind_result($twitter, $instagram, $email);
$stmt->fetch();

$stmt->close();
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>

    <title>Login</title>
    
</head>

<body>
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="blood_don.php">BLOOD-DONATION</a></li>
        <li><a href="stores.php">HERO-STORYIES</a></li>
        <li><a href="signup.php">SIGNUP</a></li>
        <li><a href="login.php">LOGIN</a></li>
    </ul>
</nav>
<br><br><br><br><br><br>
<main>
    <div class="center-wrapper">
        <div class="page">
            <form action="login.php" method="POST">
                <h1>Sign in</h1>
                <div class="input-box">
                    <input type="text" placeholder="Enter your email" id="email" name="email" required>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="Enter your password" id="password" name="password" required>
                </div>
                <button class="button" type="submit">Login</button>
                <div class="register-link">
                    <p>Do not have an account? <a href="../htmls/signup.php">SignUp</a></p>
                </div>
                <div class="register-link">
                    <p> <a href="../htmls/forget_password.php">Forget Password</a></p>
                </div>
            </form>
        </div>
        </main>
<br>
<br><br>
        <footer class="py-3" style="background: #333;width: 100%;">
    <div class="container text-center">
        <div class="row align-items-center">
            <div class="col-lg-12 mb-2">
                <div class="mb-3 text-white">
                <h4>Connect with Us</h4>
                        <a href="<?= $instagram ?>" class="text-danger mr-3 hover-icon"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="<?= $twitter ?>" class="text-danger mr-3 hover-icon"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="mailto:<?= $email ?>" class="text-danger hover-icon"><i class="far fa-envelope fa-2x"></i></a>
                     <p class="mt-3 text-white">&copy; 2023 Aorta. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>

