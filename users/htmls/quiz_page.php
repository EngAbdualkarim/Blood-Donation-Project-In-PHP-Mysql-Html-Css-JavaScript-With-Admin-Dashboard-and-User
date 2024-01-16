<?php 
session_start();
include 'connect.php';

if (!isset($_SESSION["user_id"])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
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
    <title>Quiz Page</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/quiz_page.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body> 
        
            <div class="cen">
                <div class="quiz-container">
                    <h1>Would you like to take our quick eligibility quiz?</h1>
                    <div class="choices">
                        <input type="radio" id="choice1" name="answer" value="Yes,Please">
                        <label for="choice1">Yes, Please</label><br>
                        <input type="radio" id="choice2" name="answer" value="No,Thanks">
                        <label for="choice2">No, Thanks</label><br>
                    </div>
                    <button type="button" id="nextButton">NEXT</button>
                </div>
            </div>

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
                const nextButton = document.getElementById('nextButton');
                nextButton.addEventListener('click', function() {
                    const selectedChoice = document.querySelector('input[name="answer"]:checked');
                    if (selectedChoice && selectedChoice.value === 'Yes,Please') {
                        window.location.href = 'quiz.php';
                    } else {
                        window.location.href = 'appointment.php';
                    }
                });
            </script>
        </body>

</html>