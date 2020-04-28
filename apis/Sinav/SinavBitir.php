<?php

require_once("Sinav.php");
require_once("../Ogrenci/OgrenciSinavSure.php");
require_once("../Ogrenci/Ogrenci.php");
require_once("../Config/DataBase.php");
require_once("../Config/config.php");

$database = new Database();
$db = $database->getConnection();

$ogrenciSinavSure = $_SESSION["ogrenciSinavSure"];
$ogrenciSinavSure->SINAVIBITIRME = new DateTime();
$ogrenciSinavSure->update($db);
$_SESSION["sinav"] = null;

http_response_code(200);
echo json_encode(array("message" => "FINISHED"), JSON_UNESCAPED_UNICODE);
exit();


?>
