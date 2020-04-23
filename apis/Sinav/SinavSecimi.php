<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"));
    if(empty($data->sinavID)){
        echo json_encode(array("err_message" => "Eksik yada yanlış bilgi girişi"), JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    require_once("../Tools/validation.php");
    require_once("../Ogrenci/Ogrenci.php");
    require_once("../Config/DataBase.php");
    require_once("../Config/config.php");
    
    try{
        $sinavID = $data->sinavID;
        $_SESSION["sinavID"] = $sinavID;
        http_response_code(200);
        echo json_encode(array("message" => "DONE"), JSON_UNESCAPED_UNICODE);
    } catch (Exception $e){
        echo json_encode(array("err_message" => "Hata"), JSON_UNESCAPED_UNICODE);
        print_r($e);
        exit;
    }
}
?>
