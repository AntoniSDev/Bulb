<?php

if ($_POST) {
    if (
        isset($_POST['id']) &&
        isset($_POST['date']) &&
        isset($_POST['floor']) &&
        isset($_POST['position']) &&
        isset($_POST['price'])
    ) {
        require_once('connect.php');
        $id = strip_tags($_POST['id']);
        $date = strip_tags($_POST['date']);
        $floor = strip_tags($_POST['floor']);
        $position = strip_tags($_POST['position']);
        $price = strip_tags($_POST['price']);

        // update table name set
        $sql = "UPDATE bulb SET date=:date, floor=:floor, position=:position, price=:price WHERE id=:id";
        $query = $db->prepare($sql);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->bindValue(':date', $date);
        $query->bindValue(':floor', $floor, PDO::PARAM_INT);
        $query->bindValue(':position', $position);
        $query->bindValue(':price', $price, PDO::PARAM_INT);
        $query->execute();
        require_once('close.php');
        header('Location: index.php');
    }
}

if (isset($_GET['id']) && !empty($_GET['id'])) {

    require_once("connect.php");

    //remove special characters
    $id = strip_tags($_GET['id']);

    //select all from stagiare where is the url 
    $sql = "SELECT * FROM bulb WHERE id = :id";
    $query = $db->prepare($sql);

    //check if 'int' in id
    $query->bindValue(":id", $id, PDO::PARAM_INT);

    $query->execute();
    $result = $query->fetch();
    require_once('close.php');
} else {

    header('Location: index.php');
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Bulb</title>

    <!-- Inclure CSS perso -->
    <link rel="stylesheet" href="style.css">

    <!-- Inclure Boostrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- Inclure Boostrap ICO?S -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>

    <div class="container col-xl-6 col-sm-10">
        <h2>Edit bulb id: <?= $result["id"] ?> ?</h2>
        <form method="post">
            <div class="row">
                <div class="mb-3">
                    <label for="date" class="form-label">Date :</label>
                    <div class="input-group">
                        <input type="date" class="form-control" id="date" name="date" value="<?= $result["date"] ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="floor" class="form-label">Floor :</label>
                    <select class="form-select" id="floor" name="floor" required>
                        <option value="1st floor" <?php if ($result['floor'] == '1') echo 'selected'; ?>>1st Floor</option>

                        <!--  Cette ligne de code crée une option dans un formulaire déroulant (select) avec la valeur "1st floor".   Si la valeur de la clé 'floor' dans le tableau $result est égale à '1', l'attribut 'selected' est ajouté à l'option, ce qui la pré-sélectionne dans le formulaire déroulant.
L'étiquette affichée pour cette option est "1st Floor".-->

                        <option value="2st Floor" <?php if ($result['floor'] == '2') echo 'selected'; ?>>2st Floor</option>
                        <option value="3st floor" <?php if ($result['floor'] == '3') echo 'selected'; ?>>3st Floor</option>
                        <option value="4st floor" <?php if ($result['floor'] == '4') echo 'selected'; ?>>4st Floor</option>
                        <option value="5st floor" <?php if ($result['floor'] == '5') echo 'selected'; ?>>5st Floor</option>
                        <option value="6st floor" <?php if ($result['floor'] == '6') echo 'selected'; ?>>6st Floor</option>
                        <option value="7st floor" <?php if ($result['floor'] == '7') echo 'selected'; ?>>7st Floor</option>
                        <option value="8st floor" <?php if ($result['floor'] == '8') echo 'selected'; ?>>8st Floor</option>

                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label">Select a position :</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="position" id="north" value="north" <?php if ($result["position"] == "north") echo 'checked'; ?> required>

                        <!-- L'élément <input> ci-dessus est un bouton radio avec l'ID "north" et la valeur "north".
Si la valeur de la clé 'position' dans le tableau $result est égale à "north",
l'attribut 'checked' est ajouté, ce qui pré-sélectionne le bouton radio.
L'attribut 'required' spécifie que la sélection d'une position est obligatoire.
-->
                        <label class="form-check-label" for="north">North</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="position" id="east" value="east" <?php if ($result["position"] == "east") echo 'checked'; ?>>
                        <label class="form-check-label" for="east">East</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="position" id="south" value="south" <?php if ($result["position"] == "south") echo 'checked'; ?>>
                        <label class="form-check-label" for="south">South</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="position" id="west" value="west" <?php if ($result["position"] == "west") echo 'checked'; ?>>
                        <label class="form-check-label" for="west">West</label>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="text" class="form-control" id="price" name="price" value="<?= $result["price"] ?>" required>
                </div>
            </div>

            <div class="text-center">
                <input type="hidden" name="id" value="<?= $result["id"] ?>">
                <input type="submit" value="Edit"></input>
            </div>

        </form>
    </div>

    <!-- DELETE TOAST CONFIRM -->
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Bulb n° <?= $result["id"] ?> deleted successfully.
        </div>
    </div>
    <!-- END DELETE TOAST CONFIRM -->



    <!-- Inclure Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Inclure Bootstrap 5.3.0 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <script src="script.js"></script>
</body>

</html>