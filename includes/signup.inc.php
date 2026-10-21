<?php

if(isset($_POST["submit"])){

     
    $name = $_POST["name"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdRepeat"];

     
    include "../classes/dbh.classes.php";
    include "../classes/signup.classes.php";
    include "../classes/signup-contr.classes.php";
    $signup = new SignupContr($name, $lname, $email, $pwd, $pwdRepeat);

     
    $signup->signupUser();

     
    header("location: ../home.php?error=none");
}
