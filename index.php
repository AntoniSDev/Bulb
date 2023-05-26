<?php

session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
};

// PAGINATION

// On détermine sur quelle page on se trouve
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $currentPage = (int) strip_tags($_GET['page']);
} else {
    $currentPage = 1;
}
// On se connecte à là base de données
require_once('connect.php');

// On détermine le nombre total d'articles
$sql = 'SELECT COUNT(*) AS nb_articles FROM `bulb`;';

// On prépare la requête
$query = $db->prepare($sql);

// On exécute
$query->execute();

// On récupère le nombre d'articles
$result = $query->fetch();

$nbArticles = (int) $result['nb_articles'];

// On détermine le nombre d'articles par page
$parPage = 5;

// On calcule le nombre de pages total
$pages = ceil($nbArticles / $parPage);

// Calcul du 1er article de la page
$premier = ($currentPage * $parPage) - $parPage;

$sql = 'SELECT * FROM `bulb` ORDER BY `date` DESC LIMIT :premier, :parpage;';

// On prépare la requête
$query = $db->prepare($sql);

$query->bindValue(':premier', $premier, PDO::PARAM_INT);
$query->bindValue(':parpage', $parPage, PDO::PARAM_INT);

// On exécute
$query->execute();

// On récupère les valeurs dans un tableau associatif
$articles = $query->fetchAll(PDO::FETCH_ASSOC);


// END PAGINATION

//require_once("connect.php");
//$sql = "SELECT * FROM bulb";
//$query = $db->prepare($sql);
//$query->execute();
//$result = $query->fetchAll(PDO::FETCH_ASSOC);


if ($_POST) {
    if (
        isset($_POST["date"]) &&
        (isset($_POST["floor"])) &&
        (isset($_POST["position"])) &&
        (isset($_POST["price"]))
    ) {
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
        require_once('close.php');
        header('Location: index.php');
    }
}



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

<body>
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



    <!-- ADD -->
    <div class="container col-xl-6 col-sm-10 bg-secondary text-white mt-4 p-4 rounded-3">
        <h2>Add a bulb ?</h2>
        <form method="post">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="date" class="form-label">Date :</label>
                    <div class="input-group-prepend">
                        <input type="date" class="form-control form-control-lg" id="date" name="date" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="floor" class="form-label">Floor :</label>
                    <select class="form-select form-select-lg" id="floor" name="floor" required>
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

            <div class="row mb-3 text-center">
                <div class="col-12">
                    <label class="form-label">Position :</label>
                    <div class="form-check form-check-inline form-check-lg">
                        <input class="form-check-input" type="radio" name="position" id="north" value="north" required>
                        <label class="form-check-label" for="north">North</label>
                    </div>
                    <div class="form-check form-check-inline form-check-lg">
                        <input class="form-check-input" type="radio" name="position" id="east" value="east">
                        <label class="form-check-label" for="east">East</label>
                    </div>
                    <div class="form-check form-check-inline form-check-lg">
                        <input class="form-check-input" type="radio" name="position" id="south" value="south">
                        <label class="form-check-label" for="south">South</label>
                    </div>
                    <div class="form-check form-check-inline form-check-lg">
                        <input class="form-check-input" type="radio" name="position" id="west" value="west">
                        <label class="form-check-label" for="west">West</label>
                    </div>
                </div>
            </div>

            <div class="mb-3 text-center">
                <label for="price" class="form-label">Price:</label>
                <div class="input-group justify-content-center">
                    <span class="input-group-text">$</span>
                    <input type="text" class="form-control" id="price" name="price" required placeholder="Enter price" style="max-width: 200px;">
                </div>
            </div>

            <div class="container d-flex justify-content-center">
                <a href="add.php"><button class="btn btn-primary btn-lg">Add a bulb</button></a>
            </div>

        </form>
    </div>


    <!-- PAGINATION -->

    <div class="container d-flex justify-content-center mt-5">
        <nav>
            <ul class="pagination">
                <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                    <a href="./?page=<?= $currentPage - 1 ?>" class="page-link" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                </li>
                <?php for ($page = 1; $page <= $pages; $page++) : ?>
                    <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                    <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                        <a href="./?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                    </li>
                <?php endfor ?>
                <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                    <a href="./?page=<?= $currentPage + 1 ?>" class="page-link" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- END PAGINATION -->


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

        <?php foreach ($articles as $row) : ?>
            <div class="row mb-2">
                <div class="col"><?= $row['id'] ?></div>
                <div class="col"><?= $row['date'] ?></div>
                <div class="col"><?= $row['floor'] ?>F</div>
                <div class="col"><?= $row['position'] ?></div>
                <div class="col">$<?= $row['price'] ?></div>
                <div class="col">
                    <div class="d-flex">
                        <a href="edit.php?id=<?= $row["id"] ?>" class="btn btn-primary btn-sm me-2"><i class="bi bi-pencil"></i></a>
                        <a href="delete.php?id=<?= $row["id"] ?>" data-toggle="modal" data-target="#confirmationModal" class="delete-link" data-bulb-id="<?= $row["id"] ?>">
                            <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- END HISTORY -->








    <!-- DELETE MODAL -->

    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete the bulb id n°<span id="deleteBulbId"></span>? <!-- Demande de confirmation pour supprimer l'ampoule avec l'ID correspondant -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> <!-- Bouton d'annulation -->
                    <a id="deleteLink" href="#" class="btn btn-danger">Delete</a> <!-- Bouton de suppression avec un lien vers la suppression -->
                </div>
            </div>
        </div>
    </div>
    <!-- END DELETE MODAL -->






    <!-- DELETE TOAST -->
    <?php if (isset($_SESSION['bulb_delete']) && $_SESSION['bulb_delete'] === true) : ?>

        <div class="toast position-fixed top-0 end-0 align-items-center text-white bg-success border-0 fs-4" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Bulb id n°<?= $_SESSION['bulb_delete_id'] ?> has been deleted successfully.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <?php unset($_SESSION['bulb_delete'], $_SESSION['bulb_delete_id']); ?>
    <?php endif; ?>
    <!-- END DELETE TOAST -->




    <!-- Inclure Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Inclure Bootstrap 5.3.0 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <script src="script.js"></script>
</body>

</html>