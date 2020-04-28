<?php
require_once("Sinav.php");
require_once("../Ogrenci/Ogrenci.php");
require_once("../Config/DataBase.php");
require_once("../Config/config.php");

$database = new Database();
$db = $database->getConnection();
$sinav = $_SESSION["sinav"];
$ogrenci = $_SESSION["userOgrenci"];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"));
    if(empty($data->dersID)){
        echo json_encode(array("err_message" => "Eksik yada yanlış bilgi girişi"), JSON_UNESCAPED_UNICODE);
        exit();
    }
    if(empty($data->soruID)){
        echo json_encode(array("err_message" => "Eksik yada yanlış bilgi girişi"), JSON_UNESCAPED_UNICODE);
        exit();
    }
    if(empty($data->kullaniciCevabi)){
        echo json_encode(array("err_message" => "Eksik yada yanlış bilgi girişi"), JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    
    
    
    
}
else{
    echo json_encode(array("err_message" => "Eksik yada yanlış bilgi girişi"), JSON_UNESCAPED_UNICODE);
    exit();
}
?>