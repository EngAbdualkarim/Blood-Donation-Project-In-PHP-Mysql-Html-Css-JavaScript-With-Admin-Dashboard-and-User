<?php
include 'connect.php';

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
    <link rel="stylesheet" href="../css/home.css">
    <link rel="icon" href="../img/aorta logo.png">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Aorta</title>   
</head>
<body>
  <main> 
  <nav>
    <ul class="nav-items">
      <li class="nav-items"><a href="index.php" class="nav-link">Home</a> </li>
      <li class="nav-items"><a href="blood_don.php" class="nav-link">BLOOD-DONATION</a> </li>  
      <li class="nav-items"><a href="stores.php" class="nav-link">HERO-STORYIES</a> </li> 
      <li class="nav-items"><a href="signup.php" class="nav-link">Sign Up</a></li> 
      <li class="nav-items"><a href="login.php" class="nav-link">LOGIN</a></li>
  </ul>
    </nav>
   
   </div>
  </div>
    <video autoplay loop muted plays-inline>
      <source src="../img/bloodvie.mp4" type="video/mp4">
    </video>
<section class="qout">
<div class="Qu"> 
<p>YOUR DROPLET OF BLOOD<br> MAY CREATE AN OCEAN OF HAPPINESS</p> 
</div></section>
<img class="bddimg5" src="../img/posiple.png" alt="img">

<section class="blood-donation">

  <div> <h1> BlOOD DONATION </h1>
    <br> <br>
    <p><b> 
      It is a simple medical procedure that saves lives; <br>
      A person donates blood voluntarily, in which blood is <br>
      taken from a healthy person, examined,and then saved <br>
       so that it can be used to treat another person in <br>
       emergencies that require a blood transfusion, <br>
       or for people who need long-term treatment<br>
      </b> </p>
      <br> <br>
  </div>
  </section>
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