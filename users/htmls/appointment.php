<?php
session_start();
include 'connect.php';

if (!isset($_SESSION["user_id"])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = $conn->real_escape_string($_POST['location']);
    $donation_center = $conn->real_escape_string($_POST['donation_center']);
    $appointment_date = $conn->real_escape_string($_POST['appointment_date']);
    $user_id = $_SESSION["user_id"];

    $twoMonthsAgo = date("Y-m-d", strtotime("-2 months"));
    $checkQuery = "SELECT appointment_date FROM appointment WHERE user_id = $user_id ORDER BY appointment_date DESC LIMIT 1";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        $lastAppointmentDate = $result->fetch_assoc()["appointment_date"];
        $dateDifference = date_diff(new DateTime($lastAppointmentDate), new DateTime($appointment_date));

        if ($dateDifference->m < 2) {
            $message = "You cannot make another appointment within the next two months.";
        } else {
            $sql = "INSERT INTO appointment (user_id, location, donation_center, appointment_date) 
                    VALUES ('$user_id', '$location', '$donation_center', '$appointment_date')";

            if ($conn->query($sql) === TRUE) {
                $message = "Appointment successfully made!";
            } else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        $sql = "INSERT INTO appointment (user_id, location, donation_center, appointment_date) 
                VALUES ('$user_id', '$location', '$donation_center', '$appointment_date')";
        if ($conn->query($sql) === TRUE) {
            $message = "Appointment successfully made!";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
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
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Appointment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="../css/appointment.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="quiz.php">Quiz</a></li>
            <li><a href="appointment.php">Make an appointment</a></li>
            <li><a href="appointment_history.php">Appointment History</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>
    
    
    <form action="appointment.php" method="post">
        <div class="LocationPage">
            <h4>Enter Your Exact Location</h4>
            <div class="input-box">
                <input type="text" placeholder="Location" name="location" required>
            </div>
            <div class="container mt-4">
    <button type="button" class="btn btn-dark" onclick="getLocation()">Get Nearest Hospital</button>
    <p id="nearestHospital" class="mt-2"></p>
</div>
            <h4>Choose the Closest Donation Center</h4>
            <div class="input-box">
                <select name="donation_center">
                    <option>Select Donation Center</option>
                    <option>المختبر الاقليمي</option>
                    <option>مستشفى الملك خالد</option>
                    <option>مستشفى الولادة والاطفال بنجران</option>
                    <option>مستشفى نجران العام</option>
                </select>
            </div>
            <h4>Select Appointment Day</h4>
            <div class="input-box">
                <input type="date" name="appointment_date" id="appointment_date" required>
            </div>

            <button class="Login btn" type="submit">Submit</button>
        </div>
    </form>
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


    <script>
    <?php 
        if ($message != "") {
            echo "alert('$message');";
        }
    ?>
</script>

<script>
    const hospitals = [
        {name: "المختبر الاقليمي", latitude:17.531525349109444, longitude:44.204112055758316},
        {name: ">مستشفى الملك خالد", latitude: 17.545481824135923, longitude: 44.23377975770123},
        {name: "مستشفى الولادة والاطفال بنجران", latitude: 17.553722209521982, longitude:44.272480071167664},
        {name: "مستشفى نجران العام", latitude: 17.4933, longitude: 44.1277}
    ];

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showNearestHospital, showError);
        } else { 
            document.getElementById("nearestHospital").innerHTML = "Geolocation is not supported by your browser.";
            }
    }

    function showNearestHospital(position) {
        const userLatitude = position.coords.latitude;
        const userLongitude = position.coords.longitude;

        let nearestHospital = null;
        let shortestDistance = Infinity;

        for (let hospital of hospitals) {
            const distance = haversineDistance(userLatitude, userLongitude, hospital.latitude, hospital.longitude);
            if (distance < shortestDistance) {
                shortestDistance = distance;
                nearestHospital = hospital;
            }
        }

        document.getElementById("nearestHospital").innerHTML = "Nearest Hospital: " + nearestHospital.name;
        }


      
    function haversineDistance(lat1, lon1, lat2, lon2) {
        function toRad(value) {
            return value * Math.PI / 180;
        }

        const R = 6371; 
        const dLat = toRad(lat2-lat1);
        const dLon = toRad(lon2-lon1); 
        const a = 
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) * 
            Math.sin(dLon/2) * Math.sin(dLon/2); 
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
        const d = R * c;
        return d;
    }

    function showError(error) {
    switch (error.code) {
        case error.PERMISSION_DENIED:
            document.getElementById("nearestHospital").innerHTML = "User denied the request for geolocation.";
            break;
        case error.POSITION_UNAVAILABLE:
            document.getElementById("nearestHospital").innerHTML = "Location information is unavailable.";
            break;
        case error.TIMEOUT:
            document.getElementById("nearestHospital").innerHTML = "The request to get user location timed out.";
            break;
        case error.UNKNOWN_ERROR:
            document.getElementById("nearestHospital").innerHTML = "An unknown error occurred.";
            break;
    }
}

    </script>
</body>
</html>
