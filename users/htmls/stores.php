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
        <meta name="keywords" content="blood,donor,donation,blood bank,"> 
        <link rel="stylesheet" href="../css/home.css"> 
        <link rel="icon" href="../img/aorta logo.png">
        <a href="https://storyset.com/people"></a>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <title>Aorta Stores</title>    
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
<section class="stories">
<h1>Hero Stories</h1>
<p>Be one of them</p>

<div class="row" style="margin: 20px;">
    <div class="stories-col">
    <img src="../img/donor1.png">
    <h1>Abdullah Al-Harbi</h1>
    <br><br>
    <p>His story began when he lost a dear person in 2005 due to a lack of blood.
    
    He needed to think about this situation, and he kept looking into donating blood and why Saudi Arabia needs more than any other country to donate blood, and he found that the cause is traffic accidents.
   
    He did not stop thinking about it only, but formed a campaign  Inside Aramco, and then he expanded his campaign outside the walls of his company in 2012, so his idea was to “shop and donate” the first center in a shopping mall to donate blood,
    benefiting more than one hundred thousand people from this work.

    </p>
</div>
<div class="stories-col">
    <img src="../img/donor2.png">
    <h1>Maadi Al-Omari</h1>
    <br><br>
    <p>  A medical student at Umm Al-Qura University, after her friend had a terrible accident that necessitated the transfusion of large quantities of blood, as doctors faced difficulty in providing for her needs due to the scarcity of her blood type, she created the “Saveno” platform, an innovative blood donation initiative that benefited more than 500 patients and 30 blood banks  Until today and now she is organizing the "Sisters of the Southern Border" campaign to donate to the soldiers of the Saudi army.

    </p>
</div>
<div class="stories-col">
    <img src="../img/donor3.png">
    <h1>Rudolf Isaac</h1>
    <br><br>
    <p> The famous boxer who discovered his rare blood group
         (U-) discovered his blood type by chance, as he passed by a
          blood donation center once when he was 28 years old. The Life saving blood.
          Rudolph said, "One day someone in your family may need blood, and you may be the savior,
           You never know what the future holds.
           <br> That's how I look at it."
    </p>
</div>
</div>
</section>

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