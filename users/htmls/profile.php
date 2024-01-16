<?php 
session_start();
include('connect.php');


if (!isset($_SESSION["user_id"])) {
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
} 

$user_id = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT username, email, phone FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);

$stmt->execute();

$stmt->bind_result($username, $email, $phone);
$stmt->fetch();
$stmt->close();


?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Profile</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Free Website Template" name="keywords">
        <meta content="Free Website Template" name="description">
        <link href="../img/favicon.ico" rel="icon">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:300;400;600;700;800&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../css/profile.css">

    </head>
    <body>
        <nav>
            <ul class="nav-items">
                <li ><a href="quiz.php">Quiz</a></li>
                <li><a href="appointment.php">Make an appointment</a></li>
                <li><a href="appointment_history.php">Appointment History</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nava>
        
        <div class="wrapper">
            <div class="sidebar">
                <div class="sidebar-text d-flex flex-column h-100 justify-content-center text-center">
                <img class="mx-auto d-block w-75 bg-danger img-fluid rounded-circle mb-4 p-3" src="../img/userIcon.jfif" alt="Image">
  <h1 class="font-weight-bold bg-red"><?php echo $username; ?></h1>
                    <p class="mb-4">
                    </p>
                    <div class="d-flex justify-content-center mb-5" style="margin-left:19px;">
                    <a class="btn btn-outline-danger mr-2 bg-red" href="mailto:<?php echo $email; ?>"><i><?php echo $email; ?></i></a>
                    <a class="btn btn-outline-danger mr-2 bg-red" href="#"><i><?php echo $phone; ?></i></a>
          <br>
                    </div>
                </div>
                <div class="sidebar-icon d-flex flex-column h-100 justify-content-center text-right">
                    <i class="fas fa-2x fa-angle-double-right text-primary"></i>
                </div>
            </div>
            <div class="content">
                <div class="container p-0">
                    <nav class="navbar navbar-expand-lg bg-secondary navbar-dark">
                        <a href="" class="navbar-brand d-block d-lg-none">Navigation</a>
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </nav>
                </div>
                <div class="container p-0">
                    <div id="blog-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner arousel-item">
                            <div class="carousel-item active">
                                <img class="w-100" src="../img/donor1.png" alt="Image">
                                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                    <h2 class="mb-3 text-white font-weight-bold">Blood donation saves lives</h2>
                                    <div class="d-flex text-white">
                                        <small class="mr-2 text-muted"><i class="fa fa-calendar-alt"></i> since Aug 2023</small>
                                        <small class="mr-2 text-muted"><i class="fa fa-folder"></i> 3500 Donations</small>
                                    </div>
                                    <a href="blood_don.php" class="btn btn-lg btn-outline-light mt-4">Read More</a>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="w-100" src="../img/donor2.png" alt="Image">
                                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                    <h2 class="text-white font-weight-bold">Blood donation saves lives</h2>
                                    <div class="d-flex">
                                        <small class="mr-2 text-muted"><i class="fa fa-calendar-alt"></i> since Aug 2023</small>
                                        <small class="mr-2 text-muted"><i class="fa fa-folder"></i> 3500 Donations</small>
                                    </div>
                                    <a href="blood_don.php" class="btn btn-lg btn-outline-light mt-4">Read More</a>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="w-100" src="../img/donor3.png" alt="Image">
                                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                    <h2 class="text-white font-weight-bold">Blood donation saves lives</h2>
                                    <div class="d-flex">
                                        <small class="mr-2 text-muted"><i class="fa fa-calendar-alt"></i> since Aug 2023</small>
                                        <small class="mr-2 text-muted"><i class="fa fa-folder"></i> 3500 Donations</small>
                                    </div>
                                    <a href="blood_don.php" class="btn btn-lg btn-outline-light mt-4">Read More</a>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#blog-carousel" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#blog-carousel" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
                </div>
                <div class="container bg-white pt-5">
                    <div class="row blog-item px-3 pb-5">
                        <div class="col-md-5">
                            <img class="img-fluid mb-4 mb-md-0" src="../img/donor1.png" alt="Image">
                        </div>
                        <div class="col-md-7">
                            <h3 class="mt-md-4 px-md-3 mb-2 py-2 bg-white font-weight-bold">Make a new appointment</h3>
                            <div class="d-flex mb-3">
                                <small class="mr-2 text-muted"><i class="fa fa-calendar-alt"></i> since Aug 2023</small>
                                <small class="mr-2 text-muted"><i class="fa fa-folder"></i> 3500 Donations</small>  
                            </div>
                            <p>
                                YOUR DROPLET OF BLOOD MAY CREATE AN OCEAN OF HAPPINESS
                            </p>
                            <a class="btn btn-link p-0" href="appointment.php">Make an appointment <i class="fa fa-angle-right"></i></a>
                            <br>
                            <a class="btn btn-link p-0" href="quiz_page.php">Check if you still eligble <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                    <div class="row blog-item px-3 pb-5">
                        <div class="col-md-5">
                            <img class="img-fluid mb-4 mb-md-0" src="../img/donor1.png" alt="Image">
                        </div>
                        <div class="col-md-7">
                            <h3 class="mt-md-4 px-md-3 mb-2 py-2 bg-white font-weight-bold">See appointments history</h3>
                            <div class="d-flex mb-3">
                            </div>
                            <p>
                                YOUR DROPLET OF BLOOD MAY CREATE AN OCEAN OF HAPPINESS
                            </p>
                            <a class="btn btn-link p-0" href="appointment_history.php">See appointment history <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                    <div class="container bg-white pt-5">
                        <div class="row blog-item px-3 pb-5">
                            <div class="col-md-5">
                                <img class="img-fluid mb-4 mb-md-0" src="../img/donor1.png" alt="Image">
                            </div>
                            <div class="col-md-7">
                                <h3 class="mt-md-4 px-md-3 mb-2 py-2 bg-white font-weight-bold">HERO-STORYIES</h3>
                                <div class="d-flex mb-3">
                                    <small class="mr-2 text-muted"><i class="fa fa-calendar-alt"></i> since Aug 2023</small>
                                    <small class="mr-2 text-muted"><i class="fa fa-folder"></i> 3500 Donations</small>
                                </div>
                                <p>
                                    check out the hero stories
                                </p>
                                <a class="btn btn-link p-0" href="stores.php">Read More <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
            </div>
        </div>
        <footer class="py-3" style="background: #333;">
        <div class="container text-center">
            <div class="row align-items-center">
                <div class="col-lg-12 mb-2">
                    <div class="mb-3 text-white">

                    <?php
                    
$stmt = $conn->prepare("SELECT twitter, instagram, email FROM contact_links WHERE id = 1");
$stmt->execute();
$stmt->bind_result($twitter, $instagram, $email);
$stmt->fetch();

$stmt->close();
$conn->close();
                    ?>
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
        <a href="#" class="back-to-top"><i class="fa fa-angle-double-up"></i></a>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="mail/jqBootstrapValidation.min.js"></script>
        <script src="mail/contact.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
