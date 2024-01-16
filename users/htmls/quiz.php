<?php 
session_start();
include('connect.php');

if (!isset($_SESSION["user_id"])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
} 
if (isset($_POST['userScore'])) {
    $userScore = $_POST['userScore'];
    $userID = $_SESSION['user_id'];
    
    $checkQuery = "SELECT * FROM quiz WHERE user_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $updateQuery = "UPDATE quiz SET score = ? WHERE user_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("ii", $userScore, $userID);
        if ($stmt->execute()) {
            echo "Success";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        $insertQuery = "INSERT INTO quiz (score, user_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ii", $userScore, $userID);
        if ($stmt->execute()) {
            echo "Success";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
    $conn->close();
    exit(); 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Free Quiz App</title>
    <link rel="stylesheet" href="../css/quiz.css">
    <link rel="icon" href="../img/aorta logo.png">

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

    <div class="start_btn"><button>Start Blood Eligibility Quiz</button></div>
    
    <div class="info_box">
        <div class="info-title"><span>Blood Eligibility Quiz</span></div>
        <div class="info-list">
            <div class="info">-Let’s find out if you're eligble to donate Depending on your answers to the following questions..</div>
            <div class="info">-You have to get a full scour in the quiz to be able to donate blood.</div>
            <div class="info">Note*Once you select your answer, it can't be undone.</div>
        </div>
        <div class="buttons">
            <button class="quit">Exit Quiz</button>
            <button class="restart">Continue</button>
        </div>
    </div>

    
    <div class="quiz_box">
        <header>
            <div class="title">Eligibility Quiz</div>
            <div class="timer">
                <div class="time_left_txt">Time Left</div>
                <div class="timer_sec">30</div>
            </div>
            <div class="time_line"></div>
        </header>
        <section>
            <div class="que_text">
              
            </div>
            <div class="option_list">
               
            </div>
        </section>
        <footer>
            <div class="total_que">
               
            </div>
            <button class="next_btn">Next Question</button>
        </footer>
    </div>
    <div class="result_box">
        <div class="icon">
            <i class="fas fa-award"></i>
        </div>
        <div class="complete_text">You've Completed The Quiz!</div>
        <div class="score_text">
            
        </div>

        <form action="quiz.php" method="POST">
        <div class="buttons">
            <button class="restart">Replay Quiz</button>
            <button class="quit">Next</button>
        </div>
        </form>
    </div>
    <script src="../js/questions.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>