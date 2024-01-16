<?php
session_start();

include('connect.php');

if (!isset($_SESSION["admin_id"])) {
    header("Location:../../users/htmls/login.php");
    exit();
}

$query = "SELECT a.id, u.username, a.location, a.donation_center, a.appointment_date, u.blood_type
          FROM appointment a
          INNER JOIN user u ON a.user_id = u.id";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->execute();
    $stmt->bind_result($appointment_id, $username, $location, $donation_center, $appointment_date, $blood_type);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/donation.css">
    <title>Donations</title>
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
                <div class="header__item"><a id="wins" class="filter__link filter__link--number" href="#">Address</a></div>
                <div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">Donation Hospital</a></div>
                <div class="header__item"><a id="draws" class="filter__link filter__link--number" href="#">Donation Date</a></div>
                <div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">Blood type</a></div>
                <div class="header__item"><a id="losses" class="filter__link filter__link--number" href="#">Action</a></div>
           
            </div>
            <div class="table-content">  
                <?php
                while ($stmt->fetch()) {
                    ?>
                    <div class="table-row">        
                        <div class="table-data"><?php echo htmlspecialchars($username); ?></div>
                        <div class="table-data"><?php echo htmlspecialchars($location); ?></div>
                        <div class="table-data"><?php echo htmlspecialchars($donation_center); ?></div>
                        <div class="table-data">
                            <form id="changeDateForm<?php echo $appointment_id; ?>" action="change_date.php" method="post">
                                <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">
                                <input type="date" name="new_appointment_date" value="<?php echo htmlspecialchars($appointment_date); ?>">
                            </form>
                        </div>
                        <div class="table-data"><?php echo htmlspecialchars($blood_type); ?></div>
                        <div class="table-data">
                            <button class="btn btngrey" onclick="changeDate(<?php echo $appointment_id; ?>)">Change Date</button>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <script>
        function changeDate(appointmentId) {
            var formId = "changeDateForm" + appointmentId;
            document.getElementById(formId).submit();
        }
    </script>
</body>
</html>

<?php
    $stmt->close();
} else {
    echo "Error preparing statement.";
}

$conn->close();
?>
