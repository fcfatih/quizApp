<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once("../Config/config.php");
require_once("../Config/DataBase.php");

$database = new Database();
$db = $database->getConnection();

$sorgu = "SELECT * FROM ILCELER";
$stmt = $db->prepare($sorgu);
try{
    $stmt->execute();
    $ilceler_dizisi = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $ilceitem = array(
            "ilceID" => $id,
            "ilceAdi" => $ilceadi
        );
        array_push($ilceler_dizisi, $ilceitem);
    }
    http_response_code(200);
    echo(json_encode($ilceler_dizisi, JSON_UNESCAPED_UNICODE));
}catch(Exception $e){
    print_r($e);
    exit();
}


?>
