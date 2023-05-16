<?php
require_once("connect.php");
$sql = "SELECT * FROM bulb";
$query = $db->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);


if ($_POST) {
    if (isset($_POST["first_name"]) && (isset($_POST["last_name"])) && (isset($_POST["email"])) && (isset($_POST["gender"]))) {
      require_once("connect.php");
      $first_name = strip_tags($_POST["first_name"]);
      $last_name = strip_tags($_POST["last_name"]);
      $email = strip_tags($_POST["email"]);
      $gender = strip_tags($_POST["gender"]);
   
      $sql = "INSERT INTO users (first_name, last_name, email, gender) VALUES (:first_name, :last_name, :email, :gender)";
      $query = $db->prepare($sql);
      $query->bindvalue(":first_name", $first_name, PDO::PARAM_STR);
      $query->bindvalue(":last_name", $last_name, PDO::PARAM_STR);
      $query->bindvalue(":email", $email, PDO::PARAM_STR);
      $query->bindvalue(":gender", $gender, PDO::PARAM_STR);
  
      $query->execute();
      require_once("close.php");
      header("Location: index.php");
    }
  }


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="d-flex justify-content-center">
            </div>
            <h1>BULBMAN</h1>
            <button class="">Logout</button>
        </nav>
    </header>

    <div class="container d-flex justify-content-center">
        <a href="add.php"><button>Add a bulb</button></a>
    </div>

    <!-- ADD -->

    <div class="container col-xl-6 col-sm-10">
        <h2>Add a bulb</h2>

    </div>

    




    <!-- HISTORY -->
    
    <div class="container col-xl-6 col-sm-10">
        <h2>History</h2>
        <div class="row">
            <div class="col">id</div>
            <div class="col">date</div>
            <div class="col">floor</div>
            <div class="col">position</div>
            <div class="col">price</div>
            <div class="col">edit</div>
        </div>

        <?php
        foreach ($result as $row) {
            echo "<div class='row'>";
            echo "<div class='col'>" . $row['id'] . "</div>";
            echo "<div class='col'>" . $row['date'] . "</div>";
            echo "<div class='col'>" . $row['floor'] . "F</div>";
            echo "<div class='col'>" . $row['position'] . "</div>";
            echo "<div class='col'>$" . $row['price'] . "</div>";
            echo "<div class='col d-flex'>";
            echo "<button class='btn btn-primary me-2'><i class='bi bi-pencil'></i></button>";
            echo "<button class='btn btn-danger'><i class='bi bi-trash'></i></button>";
            echo "</div>";
            echo "</div>";
        }
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>