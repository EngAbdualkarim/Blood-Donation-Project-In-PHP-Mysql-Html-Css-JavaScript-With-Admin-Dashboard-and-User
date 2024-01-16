<?php
session_start();

include('connect.php');

if (!isset($_SESSION["admin_id"])) {
    header("Location:../../users/htmls/login.php");
    exit();
}

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $user_query = "SELECT username, blood_type,email,phone FROM user WHERE id = ?";
    $user_statement = $conn->prepare($user_query);
    $user_statement->bind_param("i", $user_id);
    $user_statement->execute();
    $user_result = $user_statement->get_result();

    if ($user_result) {
        $user_data = $user_result->fetch_assoc();
        $username = $user_data['username'];
        $blood_type = $user_data['blood_type'];
    }

    $donation_query = "SELECT donation_center, appointment_date FROM appointment WHERE user_id = ?";
    $donation_statement = $conn->prepare($donation_query);
    $donation_statement->bind_param("i", $user_id);
    $donation_statement->execute();
    $donation_result = $donation_statement->get_result();

    if ($donation_result) {
        $donation_data = $donation_result->fetch_assoc();
        $donation_center = $donation_data['donation_center'];
        $appointment_date = $donation_data['appointment_date'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/donor.css">
    <title>Donor info</title>
</head>
<body>
    <ul class="nav-items">
        <li class="nav-items"><a href="admin.php" class="nav-link">Go Back</a> </li>
    </ul>
    <div id="login-container">
        <h1><?php echo $username; ?></h1>
        <div class="description">
            <?php
            echo "{$username}, a male donor with blood type {$blood_type}, made a donation at {$donation_center} on {$appointment_date}.";
            ?>
        </div>
        <div class="social">
            <a href="mailto:<?php echo $user_data['email']; ?>">Email </a><br>
            <a><?php echo $user_data['phone']; ?></a>
        </div>
        <footer>
            <div class="likes">
                <p><i class='fa fa-heart'></i></p>
            </div>
            <div class="projects">     
            </div>
        </footer>
    </div>
</body>
</html>
