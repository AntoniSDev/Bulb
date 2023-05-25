<?php 

if (isset($_GET['id']) && !empty($_GET['id'])){

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
    // if not result
    if (!$result) {
        header('Location: index.php');
    }
    // delete from tablename where id is same as url
    $sql = "DELETE FROM bulb WHERE id = :id";

    $query = $db->prepare($sql);
    // attach :id too id url
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    require_once('close.php');

    // faire un session start - nommer 
    //
    header('Location: index.php');
    

    }else{

        header('Location: index.php');
}

?>