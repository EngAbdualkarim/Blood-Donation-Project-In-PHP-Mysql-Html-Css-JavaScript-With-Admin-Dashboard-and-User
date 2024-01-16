<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $userQuery = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $verifyCode = rand(10000, 99999);

        $updateQuery = "UPDATE user SET verify_code = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ss", $verifyCode, $email);
        $updateStmt->execute();

        $to = $email;
        $subject = "Password Reset Verification Code";
        $message = "Your verification code is: $verifyCode";
        $headers = "From: abdu324432@gmail.com";

        mail($to, $subject, $message, $headers);

        echo '<script>alert("Verify Code Sent Successfully!"); location.href="verify_code.php?email=' . $email . '";</script>';
        exit();
    } else {
        echo '<script>alert("Email not found. Please enter a valid email address.";</script>';
    }

    $stmt->close();
    $updateStmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <title>Forget Password</title>
</head>
<body>
<br><br><br><br><br><br>
<main>
    <div class="center-wrapper">
        <div class="page">
            <form action="forget_password.php" method="POST">
                <h1>Forget Password</h1>
                <div class="input-box">
                    <input type="text" placeholder="Enter your email" id="email" name="email" required>
                </div>
                <button class="button" type="submit">Send Verify Code</button>
                <div class="register-link">
                    <p>Do you want to return? <a href="../htmls/Login.php">Back to login</a></p>
                </div>
            </form>
        </div>
        </main>
<br>
<br><br>
       
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>
</html>

