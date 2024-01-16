<?php
session_start();
session_destroy();
header("Location:../../users/htmls/login.php");
exit();
?>