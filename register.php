<?php
session_start();


if(isset($_SESSION["user"])){
    header("Location: index.php");  
    exit; 
};

//checking if form is sent
if (!empty($_POST)) {
    //form is sent
    //checking all fields not empty
    if (
        isset($_POST["nickname"], $_POST["email"], $_POST["pass"])
        && !empty($_POST["nickname"])
        && !empty($_POST["email"])
        && !empty($_POST["pass"])

    ) {
        //form complete
        //recover data and protect
        $nickname = strip_tags($_POST["nickname"]);

        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            die("adress mail wrong");
        }

        // hashing password
        $pass = password_hash($_POST["pass"], PASSWORD_ARGON2ID);

        // add here any other security , same password, user already exists etc...

        //register in db
        require_once "connect.php";

        $sql = "INSERT INTO users (username, email, pass) VALUES  (:nickname, :email, '$pass')";

        //prepare request
        $query = $db->prepare($sql);

        $query->bindValue(":nickname", $nickname, PDO::PARAM_STR);
        $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);

        $query->execute();

        //rocover user id
        $id = $db->lastInsertId();

        //connect user

        //user and password ok
        //connecting user 
      


        //inject user info in $_SESSION
        $_SESSION["user"] = [
            "id" => $id,
            "nick" => $nickname,
            "email" => $_POST["email"]
        ];

        //redirect on userpage
        header("Location: index.php");
    } else {
        die("Form not complete");
    }
}


//page content
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Super BULBMAN</title>

    <!-- Inclure CSS perso -->
    <link rel="stylesheet" href="style.css">

    <!-- Inclure Boostrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- Inclure Boostrap ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1/font/bootstrap-icons.css" rel="stylesheet">

    

</head>


<div class="container col-xl-6 col-sm-10">
    <h1>Register</h1>
    <form action="" method="post">  
        <div>
            <label for="nick">nickname</label>
            <input type="text" name="nickname" id="nick">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="pass">password</label>
            <input type="password" name="pass" id="pass">
        </div>
        <button type="submit">Register now</button>
    </form>    
</div>





<?php

