<?php
session_start();

include('connect.php');

if (!isset($_SESSION["admin_id"])) {
    header("Location:../../users/htmls/login.php");
    exit();
}

$currentDate = date("Y-m-d");

$query = "SELECT u.username, u.phone, u.email,  a.location, a.donation_center, u.blood_type, u.gender, q.score
          FROM user u
          LEFT JOIN appointment a ON u.id = a.user_id
          LEFT JOIN quiz q ON u.id = q.user_id
          WHERE DATE(u.date_created) = ?";

$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("s", $currentDate);
    $stmt->execute();
    $stmt->bind_result($username, $phone, $email, $location, $donation_center, $blood_type, $gender, $test_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/donation.css">
    <title>New Users Today</title>
</head>
<body>
    <nav>
        <ul class="nav-items">
            <li class="nav-items"><a href="admin.php" class="nav-link">Go Back</a></li>
        </ul>
    </nav>
    <div class="container">
        <div class="table">
            <div class="table-header">
                <div class="header__item"><a id="name" class="filter__link" href="#">Name</a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">Phone Number</a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">Email</a></div>
                <div class="header__item"><a id="wins" class="filter__link filter__link--number" href="#">Address</a></div>
                <div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">Donation Hospital</a></div>
                <div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">Blood type</a></div>
                <div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">Gender</a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">Test result</a></div>
            </div>
            <div class="table-content">  
                <?php
                while ($stmt->fetch()) {
                    ?>
                    <div class="table-row">        
                        <div class="table-data"><?php echo htmlspecialchars($username); ?></div>
                        <div class="table-data"><?php echo htmlspecialchars($phone); ?></div>
                        <div class="table-data"><?php echo htmlspecialchars($email); ?></div>
                        <div class="table-data"><?php echo htmlspecialchars($location); ?></div>
                        <div class="table-data"><?php echo htmlspecialchars($donation_center); ?></div>
                        <div class="table-data"><?php echo htmlspecialchars($blood_type); ?></div>
                        <div class="table-data"><?php echo htmlspecialchars($gender); ?></div>
                        <div class="table-data">
                        <?php 
                        if ($test_result == 8) {
                            echo 'Eligible';
                        } else {
                            echo 'Ineligible';
                        }
                        ?>
                    </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    $stmt->close();
} else {
    echo "Error preparing statement.";
}

$conn->close();
?>
