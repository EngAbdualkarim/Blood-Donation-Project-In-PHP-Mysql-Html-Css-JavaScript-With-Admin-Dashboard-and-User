<?php
session_start();

include('connect.php');

if (!isset($_SESSION["admin_id"])) {
    header("Location:../../users/htmls/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["appointment_id"]) && isset($_POST["new_appointment_date"])) {
        $appointment_id = $_POST["appointment_id"];
        $new_appointment_date = $_POST["new_appointment_date"];

        $updateQuery = "UPDATE appointment SET appointment_date = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);

        if ($stmt) {
            $stmt->bind_param("si", $new_appointment_date, $appointment_id);
            $stmt->execute();
            $stmt->close();
            header("Location: donations.php");
            exit();
        } else {
            echo "Error preparing statement.";
        }
    }
}

$conn->close();
?>
