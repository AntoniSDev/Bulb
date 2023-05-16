<?php 



try{
    $server_name = "localhost";
    $db_name = "bulbman";
    $user_name = "root";
    $password = "";

    $db = new PDO("mysql:host=$server_name;dbname=$db_name;charset=utf8mb4", "$user_name", "$password");
 
}catch(PDOException $e){
    echo "Echec de connexion:" . " " . $e->getMessage();
};
