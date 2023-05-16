<?php
require_once("connect.php");

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
        <button>Add a bulb</button>
    </div>
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