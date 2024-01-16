<?php
session_start();

include('connect.php');

if (isset($_SESSION["user_id"])) {
    echo "<script>window.location.href = 'quiz_page.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $blood_type = $_POST['blood_type'];
    $birth_date = $_POST['birth_date'];
    $id_number = $_POST['id_number'];
    $weight = $_POST['weight'];
    $gender = $_POST['gender'];
    $id_certification = $_POST['id_certification'];

$email_check = $conn->prepare("SELECT id FROM user WHERE email = ?");
$email_check->bind_param("s", $email);
$email_check->execute();
$email_check_result = $email_check->get_result();
if ($email_check_result->num_rows > 0) {
    echo "<script>alert('This email is already registered!'); window.location.href = 'signup.php';</script>";
    exit();
}
$email_check->close();


$phone_check = $conn->prepare("SELECT id FROM user WHERE phone = ?");
$phone_check->bind_param("s", $phone);
$phone_check->execute();
$phone_check_result = $phone_check->get_result();
if ($phone_check_result->num_rows > 0) {
    echo "<script>alert('This phone number is already registered!'); window.location.href = 'signup.php';</script>";
    exit();
}
$phone_check->close();
    if ($password !== $confirm_password) {
        echo "<script>alert('Password and Confirm Password do not match');window.location.href = 'signup.php';</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO user (first_name, username, email, phone, password, blood_type, birth_date, id_number, weight, gender, id_certification)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssssssiss", $first_name, $username, $email, $phone, $password, $blood_type, $birth_date, $id_number, $weight, $gender, $id_certification);

        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;
            $_SESSION['user_id'] = $user_id;
            echo "<script>alert('Registration successful!'); window.location.href = 'quiz_page.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');window.location.href = 'signup.php';</script>";
        }

        $stmt->close();
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/signup.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Sigup</title>
</head>
<body class="gbody">

<nav>
    <ul class="nav-list">
        <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="blood_don.php" class="nav-link">BLOOD-DONATION</a></li>
        <li class="nav-item"><a href="stores.php" class="nav-link">HERO-STORYIES</a></li>
        <li class="nav-item"><a href="signup.php" class="nav-link">Sign Up</a></li>
        <li class="nav-item"><a href="login.php" class="nav-link">LOGIN</a></li>
    </ul>
</nav>

<br><br><br>
<main>
    <section2g>
        <div class="SignUp">
            <form action="signup.php" method="post">
                <h1>SignUp</h1>
                <div class="user-details">
                    <div class="input-box">
                        <span class="deatils">First Name</span>
                        <input type="text" name="first_name" placeholder="Enter your name" required>
                    </div>
                    <div class="input-box">
                        <span class="deatills">UserName</span>
                        <input type="text" name="username" placeholder="Enter your Username" required>
                    </div>
                    <div class="input-box">
                        <span class="deatills">E-mail</span>
                        <input type="email" name="email" placeholder="Enter your Email" required>
                    </div>
                    <div class="input-box">
                        <span class="deatills">Phone Number</span>
                        <input type="text" name="phone" placeholder="Enter your number" required>
                    </div>
                    <div class="input-box">
                        <span class="deatills">Password</span>
                        <input type="password" name="password" placeholder="Enter your Password" required>
                    </div>
                    <div class="input-box">
                        <span class="deatills">Confirm Password</span>
                        <input type="password" name="confirm_password" placeholder="Confirm your Password" required>
                    </div>
                    <div class="input-box">
                        <span class="deatills">Blood Type</span>
                        <input type="text" name="blood_type" placeholder="Enter your blood type" required>
                    </div>
                    <div class="input-box">
                        <span class="deatills">Your Birth Date</span>
                        <input type="date" name="birth_date" required>
                    </div>
                    <div class="input-box">
                        <span class="The country">Enter ID Number</span>
                        <input type="text" name="id_number" placeholder="Enter your ID" required>
                    </div>
                    <div class="input-box">
                        <span class="deatills">Weight</span>
                        <label for="Weight">(Min 50) </label>
                        <input type="number" name="weight" min="50" placeholder="Enter your Weight" required>
                    </div>
                </div>
                <div class="gender-details">
                    <input type="radio" name="gender" value="male" id="dot-1" required>
                    <input type="radio" name="gender" value="female" id="dot-2" required>
                    <span class="gender-title">Gender</span>
                    <div class="category">
                        <label for="dot-1">
                            <span class="dot one"></span>
                            <span class="gender">Male</span>
                        </label>
                        <label for="dot-2">
                            <span class="dot two"></span>
                            <span class="gender">Female</span>              
                        </label>
                    </div>
                </div>
                <p>I <strong>certify the National ID</strong> belongs to me</p>
                <input type="checkbox" name="id_certification" value="agree" id="vehicle1" required>
                <label for="vehicle1"> I agree</label><br>  
                <input class="button" type="submit" value="Submit!">
            </form>
        </div>
    </section2g>


</main>
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
</body>
</html>
