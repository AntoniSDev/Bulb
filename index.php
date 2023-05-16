<?php

require_once("connect.php");
$sql = "SELECT * FROM bulb";
$query = $db->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);


if ($_POST) {
    if (isset($_POST["date"]) && (isset($_POST["floor"])) && (isset($_POST["position"])) && (isset($_POST["price"]))) {
        require_once("connect.php");
        $date = strip_tags($_POST["date"]);
        $floor = strip_tags($_POST["floor"]);
        $position = strip_tags($_POST["position"]);
        $price = strip_tags($_POST["price"]);

        $sql = "INSERT INTO bulb (date, floor, position, price) VALUES (:date, :floor, :position, :price)";
        $query = $db->prepare($sql);
        $query->bindvalue(":date", $date, PDO::PARAM_STR);
        $query->bindvalue(":floor", $floor, PDO::PARAM_INT);
        $query->bindvalue(":position", $position, PDO::PARAM_STR);
        $query->bindvalue(":price", $price, PDO::PARAM_STR);

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
    <link rel="stylesheet" href="style.css">
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
        <h2>Add a bulb ?</h2>
        <form method="post">
            <div class="row">
                <div class="mb-3">
                    <label for="date" class="form-label">Date :</label>
                    <div class="input-group">
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="floor" class="form-label">Floor :</label>
                    <select class="form-select" id="floor" name="floor" required>
                        <option value="">Select floor</option>
                        <option value="1">1st Floor</option>
                        <option value="2">2nd Floor</option>
                        <option value="3">3rd Floor</option>
                        <option value="4">4th Floor</option>
                        <option value="5">5th Floor</option>
                        <option value="6">6th Floor</option>
                        <option value="7">7th Floor</option>
                        <option value="8">8th Floor</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label">Select a position :</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="position" id="north" value="north" required>
                        <label class="form-check-label" for="north">North</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="position" id="east" value="east">
                        <label class="form-check-label" for="east">East</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="position" id="south" value="south">
                        <label class="form-check-label" for="south">South</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="position" id="west" value="west">
                        <label class="form-check-label" for="west">West</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="text" class="form-control" id="price" name="price" required placeholder="Enter price">
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary m-5">Add a bulb</button>
            </div>

        </form>
    </div>







    <!-- HISTORY -->

    <div class="container col-xl-6 col-sm-10">
        <h2>History</h2>
        <div class="row mt-4 mb-4">
            <div class="col">id</div>
            <div class="col">date</div>
            <div class="col">floor</div>
            <div class="col">position</div>
            <div class="col">price</div>
            <div class="col">edit</div>
        </div>

        <?php
        foreach ($result as $row) {
            echo "<div class='row mb-2'>";
            echo "<div class='col'>" . $row['id'] . "</div>";
            echo "<div class='col'>" . $row['date'] . "</div>";
            echo "<div class='col'>" . $row['floor'] . "F</div>";
            echo "<div class='col'>" . $row['position'] . "</div>";
            echo "<div class='col'>$" . $row['price'] . "</div>";
            echo "<div class='col d-flex'>";
            echo "<button class='btn btn-primary btn-sm me-2'><i class='bi bi-pencil'></i></button>";
            echo "<button class='btn btn-danger btn-sm'><i class='bi bi-trash'></i></button>";
            echo "</div>";
            echo "</div>";
        }
        ?>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>