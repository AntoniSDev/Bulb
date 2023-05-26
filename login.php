<?php
//opening php session
session_start();

if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
};

//checking if form is sent
if (!empty($_POST)) {
    //form is sent
    //checking all fields not empty
    if (
        isset($_POST["email"], $_POST["pass"])
        && !empty($_POST["email"]
            && !empty($_POST["pass"]))
    ) {
        //checking email is real email
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            die("This is not a mail");
        }

        //connect db
        require_once "connect.php";

        $sql = "SELECT * FROM users WHERE email = :email";

        $query = $db->prepare($sql);

        $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);

        $query->execute();

        $user = $query->fetch();

        if (!$user) {
            die("User/Password wrong");
        }

        // user exists , checking password

        if (!password_verify($_POST["pass"], $user["pass"])) {
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

<header>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid d-flex justify-content-center">
            <a class="navbar-brand" href="#">Super BULBMAN</a>
        </div>
        <div class="container-fluid">
            <ul class="nav justify-content-center">
                <?php if (!isset($_SESSION["user"])) : ?>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-secondary" href="login.php">login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-secondary" href="register.php">register</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <span class="nav-link" style="color: white;">wHELLcome <?= $_SESSION["user"]["nick"] ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-secondary" href="disconnect.php" style="color: white;">disconnect</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>


<div class="container col-xl-6 col-sm-10 bg-secondary text-white mt-4 p-4 rounded-3 mb-5">

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
