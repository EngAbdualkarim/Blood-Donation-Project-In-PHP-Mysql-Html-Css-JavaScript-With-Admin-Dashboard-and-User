
<?php
session_start();

include('connect.php');

if (!isset($_SESSION["admin_id"])) {
    header("Location:../../users/htmls/login.php");
    exit();
}

if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $deleteQuery = "DELETE FROM user WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location: aboutDonors.php");
        exit();
    } else {
        echo "Error deleting user.";
    }

    $stmt->close();
} else {
    echo "User ID not provided.";
}
?>
s