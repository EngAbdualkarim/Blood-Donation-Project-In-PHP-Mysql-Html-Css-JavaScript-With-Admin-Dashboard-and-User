<?php
include('connect.php');
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $email = $_GET['email'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];
    $updateQuery = "UPDATE user SET password = ? WHERE email = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ss", $newPassword, $email);
    $updateStmt->execute();
    echo '<script>alert("Password changed successfully!"); location.href="login.php";</script>';
    exit();
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
    <title>Change Password</title>
</head>

<body>
    <br><br><br><br><br><br>
    <main>
        <div class="center-wrapper">
            <div class="page">
                <form action="change_password.php" method="POST">
                    <h1>Change Password</h1>
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    <div class="input-box">
                        <input type="password" placeholder="Enter new password" id="new_password" name="new_password" required>
                    </div>
                    <button class="button" type="submit">Change Password</button>
                </form>
            </div>
        </div>
    </main>

    <br><br><br>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</body>

</html>
