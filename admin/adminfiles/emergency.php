<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject = $_POST["Subject"];
    $message = $_POST["Message"];

    $stmt = $conn->prepare("INSERT INTO emergency_messages (subject, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $subject, $message);

    if ($stmt->execute()) {
        $result = $conn->query("SELECT email FROM user");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $to = $row["email"];
                $headers = "From: abdu324432@gmail.com";
                mail($to, $subject, $message, $headers);
            }
        } else {
            echo "No users found.";
        }

        echo '<script>alert("Message submitted successfully."); window.location.href = "admin.php";</script>';
    } else {
        echo "Error submitting message: " . $stmt->error;
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
    <link rel="stylesheet" href="../css/emergency.css">
    <link rel="stylesheet" href="https://icons.getbootstrap.com/">
    <title>Emergency</title>
</head>
<body>
    <nav>
        <ul class="nav-items">
        <li class="nav-items"><a href="admin.php" class="nav-link">Go Back</a> </li>
        
        </ul>
        </nav>
    <div class="hero">
        <form action="emergency.php" method="POST">
           <div class="message-icon" >
            <i class="bi bi-telegram"></i>
            <span>Emergency</span> 
           </div>

                <div id="input-field">
                    <i class="bi bi-person"></i>
                    <input type="text"placeholder="Subject"name="Subject" >
                    </div>

           <div id="input-field">
            <i class="bi bi-chat-right-dots"></i>
            <textarea name="Message" placeholder="Massage" rows="10"></textarea>
           </div>
           <input type="submit" value="Submit" class="send-btn">
           </div>
        </form>
    </div>
</body>