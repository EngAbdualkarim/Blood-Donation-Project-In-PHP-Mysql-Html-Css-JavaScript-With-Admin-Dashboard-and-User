<?php
session_start();

include('connect.php');

if (!isset($_SESSION["admin_id"])) {
    header("Location:../../users/htmls/login.php");
    exit();
}

$query = "
    SELECT 
    u.id,
        u.username,
        u.phone,
        u.email,
        a.location,
        a.donation_center,
        u.blood_type,
        u.gender,
        a.appointment_date,
        COALESCE(q.score, 0) as score
    FROM user u
    JOIN appointment a ON u.id = a.user_id
    LEFT JOIN quiz q ON u.id = q.user_id
    WHERE a.appointment_date = (SELECT MAX(appointment_date) FROM appointment WHERE user_id = u.id)
";

$stmt = $conn->prepare($query);
$stmt->execute();
$stmt->bind_result($id,$username, $phone, $email, $location, $donation_center, $blood_type, $gender, $appointment_date, $score);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/donation.css">
    <title>About Donors</title>
</head>
<body>
    <nav>
        <ul class="nav-items">
            <li class="nav-items"><a href="admin.php" class="nav-link">Go Back</a> </li>
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
                <div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">Latest donation date</a></div>
                <div class="header__item"><a id="total" class="filter__link filter__link--number" href="#">Test result</a></div>
            </div>
        
            <?php
            while ($stmt->fetch()) {
                ?>
                <div class="table-row">
                    <div class="table-data"><?php echo $username; ?></div>
                    <div class="table-data"><?php echo $phone; ?></div>
                    <div class="table-data"><?php echo $email; ?></div>
                    <div class="table-data"><?php echo $location; ?></div>
                    <div class="table-data"><?php echo $donation_center; ?></div>
                    <div class="table-data"><?php echo $blood_type; ?></div>
                    <div class="table-data"><?php echo $gender; ?></div>
                    <div class="table-data"><?php echo $appointment_date; ?></div>
                    <div class="table-data">
                        <?php 
                        if ($score == 8) {
                            echo 'Eligible';
                        } else {
                            echo 'Ineligible';
                        }
                        ?>
                    </div>
                    <div class="table-data">
                        <a href="delete_donor.php?user_id=<?php echo $id; ?>" class="btn btngrey ">Delete</a>
                </div>
                </div>
                <?php
            }
            $stmt->close();
            ?>
        </div>
    </div>
</body>
</html>
