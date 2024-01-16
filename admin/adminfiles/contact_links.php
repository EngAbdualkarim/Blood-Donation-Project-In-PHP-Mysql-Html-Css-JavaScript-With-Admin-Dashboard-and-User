<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming your form fields are named twitter, instagram, and email
    $twitter = $_POST["twitter"];
    $instagram = $_POST["instagram"];
    $email = $_POST["email"];

    // Using prepared statements to prevent SQL injection
    $checkQuery = "SELECT * FROM contact_links";
    $stmt = $conn->prepare($checkQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $updateQuery = "UPDATE contact_links SET twitter=?, instagram=?, email=? WHERE id=1";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sss", $twitter, $instagram, $email);
        $stmt->execute();
        echo "<script>alert('Data updated successfully!');window.location.href = 'admin.php';</script>";
    } else {
        $insertQuery = "INSERT INTO contact_links (twitter, instagram, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sss", $twitter, $instagram, $email);
        $stmt->execute();
        echo "<script>alert('Data added successfully!');window.location.href = 'admin.php';</script>";
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>



<!doctype html>
<html lang="en">
<head>
<title>Contact Us Form</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,700" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../css/contact_links.css">
</head>
<script nonce="7d5e803b-908c-4d0f-9e9b-12f18e364edf">(function(w,d){!function(bb,bc,bd,be){bb[bd]=bb[bd]||{};bb[bd].executed=[];bb.zaraz={deferred:[],listeners:[]};bb.zaraz.q=[];bb.zaraz._f=function(bf){return async function(){var bg=Array.prototype.slice.call(arguments);bb.zaraz.q.push({m:bf,a:bg})}};for(const bh of["track","set","debug"])bb.zaraz[bh]=bb.zaraz._f(bh);bb.zaraz.init=()=>{var bi=bc.getElementsByTagName(be)[0],bj=bc.createElement(be),bk=bc.getElementsByTagName("title")[0];bk&&(bb[bd].t=bc.getElementsByTagName("title")[0].text);bb[bd].x=Math.random();bb[bd].w=bb.screen.width;bb[bd].h=bb.screen.height;bb[bd].j=bb.innerHeight;bb[bd].e=bb.innerWidth;bb[bd].l=bb.location.href;bb[bd].r=bc.referrer;bb[bd].k=bb.screen.colorDepth;bb[bd].n=bc.characterSet;bb[bd].o=(new Date).getTimezoneOffset();if(bb.dataLayer)for(const bo of Object.entries(Object.entries(dataLayer).reduce(((bp,bq)=>({...bp[1],...bq[1]})),{})))zaraz.set(bo[0],bo[1],{scope:"page"});bb[bd].q=[];for(;bb.zaraz.q.length;){const br=bb.zaraz.q.shift();bb[bd].q.push(br)}bj.defer=!0;for(const bs of[localStorage,sessionStorage])Object.keys(bs||{}).filter((bu=>bu.startsWith("_zaraz_"))).forEach((bt=>{try{bb[bd]["z_"+bt.slice(7)]=JSON.parse(bs.getItem(bt))}catch{bb[bd]["z_"+bt.slice(7)]=bs.getItem(bt)}}));bj.referrerPolicy="origin";bj.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(bb[bd])));bi.parentNode.insertBefore(bj,bi)};["complete","interactive"].includes(bc.readyState)?zaraz.init():bb.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document);</script></head>
<body>
    <nav>
        <ul class="nav-items">
        <li class="nav-items"><a href="admin.php" class="nav-link">Go Back</a> </li>
        </ul>
        </nav>
<section class="ftco-section">
<div class="container">
<div class="row justify-content-center">
<div class="col-md-6 text-center mb-5">

</div>
</div>
<div class="row justify-content-center">
<div class="col-md-10">
<div class="wrapper">
<div class="row no-gutters">
<div class="col-md-6">
<div class="contact-wrap w-100 p-lg-5 p-4">
<h3 class="mb-4">Manage the contact info</h3>
<div id="form-message-warning" class="mb-4"></div>
<div id="form-message-success" class="mb-4">
The contact info has been ubdated!
</div>

<form method="POST" id="contactForm" name="contactForm" class="contactForm">
<div class="row">

<div class="col-md-12">
<div class="form-group">
<input type="text" class="form-control" name="twitter" id="name" placeholder="Twitter" required>
</div>
</div>
<div class="col-md-12">
<div class="form-group">
<input type="text" class="form-control" name="instagram" id="name" placeholder="Instagram" required>
</div>
</div>
<div class="col-md-12">
<div class="form-group">
<input type="text" class="form-control" name="email" id="email" placeholder="email" required>
</div>
</div>


<div class="col-md-12">
<div class="form-group">
<input type="submit" value="Update" class="btn btn-primary">
<div class="submitting"></div>
</div>
</div>
</div>
</form>
</div>
</div>
<!-- <div class="col-md-6 d-flex align-items-stretch"> -->
<!-- <div class="info-wrap w-100 p-lg-5 p-4 img">
<h3>Current Contact us info</h3>
<p class="mb-4">Here you will find the Current Contact us info </p>
<div class="dbox w-100 d-flex align-items-start">
<div class="icon d-flex align-items-center justify-content-center">
<span class="fa fa-map-marker"></span>
</div>
<div class="text pl-3">
    <p><span>X:</span> <a href="https://twitter.com/Orta2023">@Orta2023</a></p>
</div>
</div>
<div class="dbox w-100 d-flex align-items-center">
<div class="icon d-flex align-items-center justify-content-center">
<span class="fa fa-phone"></span>
</div>
<div class="text pl-3">
<p><span>Instagram:</span> <a href="https://instagram.com/aorta2023_?igshid=OGQ5ZDc2ODk2ZA%3D%3D&utm_source=qr">@aorta2023_</a></p>
</div>
</div>
<div class="dbox w-100 d-flex align-items-center">
<div class="icon d-flex align-items-center justify-content-center">
<span class="fa fa-paper-plane"></span>
</div>
<div class="text pl-3">
<p><span>Email:</span> <a href="mailto:aor.ta.2023a@gmail.com"><span class="__cf_email__" >aor.ta.2023a@gmail.com</span></a></p>
</div>
</div> -->
<!-- <div class="dbox w-100 d-flex align-items-center"> -->

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/main.js"></script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"81dcc04d1902b537","version":"2023.10.0","token":"cd0b4b3a733644fc843ef0b185f98241"}' crossorigin="anonymous"></script>
</body>
</html>
