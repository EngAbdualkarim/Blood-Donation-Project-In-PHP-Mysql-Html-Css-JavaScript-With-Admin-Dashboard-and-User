<?php 
session_start();

include('connect.php');

if (!isset($_SESSION["admin_id"])) {
    header("Location:../../users/htmls/login.php");
    exit();
}

function getUserCount() {
    global $conn;
    $sql = "SELECT COUNT(*) as user_count FROM user";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['user_count'];
}

function getAppointmentCount() {
    global $conn;
    $sql = "SELECT COUNT(*) as appointment_count FROM appointment";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['appointment_count'];
}

function getUsersWithAppointmentsCount() {
    global $conn;
    $sql = "SELECT COUNT(DISTINCT u.id) as users_with_appointments_count
            FROM user u
            JOIN appointment a ON u.id = a.user_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['users_with_appointments_count'];
}

function getRecentDonations() {
    global $conn;
    $currentDate = date('Y-m-d');

    $sql = "SELECT u.id,u.first_name, a.location, u.blood_type, a.appointment_date
            FROM user u
            JOIN appointment a ON u.id = a.user_id
            WHERE DATE(a.appointment_date) = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $currentDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $donations = $result->fetch_all(MYSQLI_ASSOC);

    return $donations;
}


function getNewUsers() {
    global $conn;
    $currentDate = date('Y-m-d');

    $sql = "SELECT id, first_name, date_created
            FROM user
            WHERE DATE(date_created) = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $currentDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $newUsers = $result->fetch_all(MYSQLI_ASSOC);

    return $newUsers;
}





$userCount = getUserCount();
$appointmentCount = getAppointmentCount();
$usersWithAppointmentsCount = getUsersWithAppointmentsCount();

$recentDonations = getRecentDonations();
$newUsers = getNewUsers();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <title>Admin Panel</title>
</head>
<body>
    <div class="side-menu">
        <div class="Dashboard">
            <h1>Dashboard</h1>
        </div>
        <ul> 
            <a href="aboutDonors.php" ><li>About Donors </li></a>
            <a href="donations.php" ><li>Donations </li></a>
            <a href="emergency.php" ><li>Emergency Cases </li></a>
            <a href="contact_links.php" ><li>Manage Contact Us </li></a>
        </ul>
    </div>
    <div class="container">
        <div class="header">
            <div class="nav">
                <div class="search">
                </div>
                <div class="user">
                    <a href="logout.php" class="btn">Log Out</a>
                  

                    <div class="img-case" src="../image/logo.jpg">
                        <img src="../image/logo.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <h1><?php echo $usersWithAppointmentsCount; ?></h1>
                        <h3>Donors</h3>
                    </div>
                    <div class="icon-case">
                        <img src="" alt="">
                    </div>
                </div>
                
                <div class="card">
                    <div class="box">
                        <h1><?php echo $userCount; ?></h1>
                        <h3>Users</h3>
                    </div>
                    <div class="icon-case">
                        <img src="" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1><?php echo $appointmentCount; ?></h1>
                        <h3>Donations</h3>
                    </div>
                    <div class="icon-case">
                        <img src="" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>4</h1>
                        <h3>Hospitals</h3>
                    </div>
                    <div class="icon-case">
                        <img src="" alt="">
                    </div>
                </div>
            </div>
            <div class="content-2">
                <div class="recent-Donations">
                    <div class="title">
                        <h2>Recent Donations</h2>
                        <a href="donations.php" class="btn">View All</a>
                    </div>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Blood type</th>
                            <th>Option</th>
                        </tr>
                        <?php foreach ($recentDonations as $donation) : ?>
                        <tr>
                <td><?php echo $donation['first_name']; ?></td>
                <td><?php echo $donation['location']; ?></td>
                <td><?php echo $donation['blood_type']; ?></td>
                <td><a href="donor.php?user_id=<?php echo $donation['id']; ?>" class="btn">View</a></td>
                        </tr>
        <?php endforeach; ?>
                    </table>
                </div>
                <div class="new-User">
                    <div class="title">
                        <h2>New User</h2>
                        <a href="new_users.php" class="btn">View All</a>
                    </div>
                    <table>
                        <tr>
                            <th>Profile</th>
                            <th>Name</th>
                        </tr>
                        <?php foreach ($newUsers as $user) : ?>
            <tr>
                <td><img src="../image/uu.png" alt=""></td>
                <td><?php echo $user['first_name']; ?></td>
                <td><img src="info.png" alt=""></td>
            </tr>
        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>