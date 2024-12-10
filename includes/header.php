<?php
require 'config/config.php';

if(isset($_SESSION['username'])){
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con,"SELECT * FROM users WHERE username='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
}else{
    header("Location:register.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Javascript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
<div class="top_bar">
    <div class="logo">
        <a href="index.php">Swirlfeed!</a>
        <div class="icons">
        <nav>
            <a href="#"><?php echo $user['first_name'];?></a>
            <a href="#"><i class="fa fa-camera-retro fa-lg"></i></a>
            <a href="#"><i class="fa fa-envelope fa-lg"></i></a>
            <a href="#"><i class="fa fa-bell-o fa-lg"></i></a>
            <a href="#"><i class="fa fa-users fa-lg"></i></a>
            <a href="#"><i class="fa fa-cog fa-lg"></i></a>
        </nav>
        </div>
    </div>
</div>