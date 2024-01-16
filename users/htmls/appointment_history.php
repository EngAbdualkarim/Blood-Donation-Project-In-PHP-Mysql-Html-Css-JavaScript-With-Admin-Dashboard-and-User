<?php 
session_start();


include 'connect.php';

if (!isset($_SESSION["user_id"])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}

$appointments = [];

$stmt = $conn->prepare("SELECT location, donation_center, appointment_date FROM appointment WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION["user_id"]); 

$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

$stmt->close();

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
    <link rel="stylesheet" href="../css/appointment_history.css">
    <link rel="icon" href="../img/aorta logo.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Aorta</title>
</head>
<body>
<main> 
<nav>
        <ul>
            <li><a href="quiz.php">Quiz</a></li>
            <li><a href="appointment.php">Make an appointment</a></li>
            <li><a href="appointment_history.php">Appointment History</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>
    
    <br><br>
    <div class="container mt-5">

<?php if (count($appointments) > 0): ?>

    <table class="table table-hover table-responsive-sm">
        <thead class="thead-dark">
            <tr>
                <th>Location</th>
                <th>Donation Center</th>
                <th>Appointment Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr class="table-light">
                    <td><?= $appointment['location'] ?></td>
                    <td><?= $appointment['donation_center'] ?></td>
                    <td><?= $appointment['appointment_date'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>

    <div class="alert alert-warning mt-4 text-center" role="alert">
        <h4 class="alert-heading">Sorry!</h4>
        <p>You don't have any previous donations.</p>
    </div>
    <div class="text-center">
        <img class="ch img-fluid" src="../img/bddimg5.png"  alt="logo" style="max-width: 200px; opacity: 1;">
    </div>

<?php endif; ?>

</div>

</main>
<br><br><br><br><br><br><br><br><br><br><br><br><br>
<footer class="py-3" style="background: #333;">
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col-lg-12 mb-2">
                    <div class="mb-3 text-white">
                        <h4>Connect with Us</h4>
                        <a href="<?= $instagram ?>" class="text-danger mr-3 hover-icon"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="<?= $twitter ?>" class="text-danger mr-3 hover-icon"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="mailto:<?= $email ?>" class="text-danger hover-icon"><i class="far fa-envelope fa-2x"></i></a>
                    </div>
                    <p class="mt-3 text-white">&copy; 2023 Aorta. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
