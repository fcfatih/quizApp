<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once("../Config/DataBase.php");
require_once("../Config/config.php");


$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));
if(empty($data->ilceID) || empty($data->tur)){
    http_response_code(503);
    echo json_encode(array("err_message" => "Eksik yada yanlış bilgi girişi"), JSON_UNESCAPED_UNICODE);
    exit();
}

$sorgu = "SELECT * FROM KURUMLAR WHERE ilceid = :ilceID AND KURUMLAR.tur = :tur";
$stmt = $db->prepare($sorgu);
//validation-sanitation!!!
$stmt->bindParam(":ilceID", $data->ilceID);
$stmt->bindParam(":tur", $data->tur);
try{
    $stmt->execute();
    $kurumlar_dizisi = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $kurumitem = array(
            "kurumKodu" => $kurumkodu,
            "kurumAdi" => $kurumadi
        );
        array_push($kurumlar_dizisi, $kurumitem);
    }
    http_response_code(200);
    echo(json_encode($kurumlar_dizisi, JSON_UNESCAPED_UNICODE));
}catch(Exception $e){
    print_r($e);
    exit();
}


?>
