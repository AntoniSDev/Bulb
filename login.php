<?php
  //opening php session
  session_start();
 
if(isset($_SESSION["user"])){
    header("Location: index.php");  
    exit; 
};

//checking if form is sent
if(!empty($_POST)){
    //form is sent
    //checking all fields not empty
    if(isset($_POST["email"], $_POST["pass"])
    && !empty($_POST["email"]
    && !empty($_POST["pass"]))
    ){
      //checking email is real email
      if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        die("This is not a mail");
      }

      //connect db
      require_once "connect.php";

      $sql = "SELECT * FROM users WHERE email = :email";

      $query = $db->prepare($sql);

      $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);

      $query->execute();

      $user = $query->fetch();

      if(!$user){
        die("User/Password wrong");
      }

      // user exists , checking password

      if(!password_verify($_POST["pass"], $user["pass"])){
        die("User/Password wrong");
      }

      //user and password ok
      //connecting user 



      //inject user info in $_SESSION
      $_SESSION["user"] = [
        "id" => $user["id"],
        "nick" => $user["username"],
        "email" => $user["email"]
      ];

      //redirect on userpage
      header("Location: index.php");




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

     
            <?php if(!isset($_SESSION["user"])): ?>
              <li><a href="login.php">login</a></li>     
             <li><a href="register.php">register</a></li>  
              <?php else: ?>
            <li>Bonjour <?= $_SESSION["user"]["nick"]?></li>
               <li><a href="disconnect.php">disconnect</a></li>  
           <?php endif; ?>


    <h1>Login</h1>
    <form action="" method="post">  
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>
        <div>
            <label for="pass">password</label>
            <input type="password" name="pass" id="pass">
        </div>
        <button type="submit">Login now</button>
    </form>    
</div>


<?php

