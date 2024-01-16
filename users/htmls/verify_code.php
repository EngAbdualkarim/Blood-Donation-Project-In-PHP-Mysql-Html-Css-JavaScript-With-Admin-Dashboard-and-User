<?php
include('connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $email = $_GET['email'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $verifyCode = $_POST['verify_code'];

    $userQuery = "SELECT * FROM user WHERE email = ? AND verify_code = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("ss", $email, $verifyCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<script>alert("Verify Code is the same"); location.href="change_password.php?email=' . $email . '";</script>';
        exit();
    } else {
        echo "Invalid verification code. Please try again.";
    }

    $stmt->close();
}
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
    <title>Verify Password</title>
</head>
<body>
    <br><br><br><br><br><br>
    <main>
        <div class="center-wrapper">
            <div class="page">
                <form action="verify_code.php" method="POST">
                    <h1>Verify Code</h1>
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    <div class="input-box">
                        <input type="text" placeholder="Enter verification code" id="verify_code" name="verify_code" required>
                    </div>
                    <button class="button" type="submit">Verify Code</button>
                </form>
            </div>
        </div>
    </main>

    <br><br><br>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>
