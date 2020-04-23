<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $data = json_decode(file_get_contents("php://input"));
    if(empty($data->kurumKodu) || empty($data->ogrenciNo || empty($data->password))){
        http_response_code(503);
        echo json_encode(array("err_message" => "Eksik yada yanlış bilgi girişi"), JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    require_once("../Tools/validation.php");
    require_once("Ogrenci.php");
    require_once("../Config/DataBase.php");
    require_once("../Config/config.php");
    
    
    $database = new Database();
    $db = $database->getConnection();

    $ogrenci = new Ogrenci();
    
    //sanitize and validate !!!
    $ogrenci->KURUMKODU = $data->kurumKodu;
    $ogrenci->OGRENCINO = $data->ogrenciNo;
    $ogrenci->PASSWORD  = $data->password;
    
    $sorgu = "SELECT ID, SINIFSEVIYESI FROM OGRENCILER WHERE KURUMKODU = :kurumKodu AND OGRENCINO = :ogrenciNo AND PASSWORD = :password ";
    $stmt = $db->prepare($sorgu);
    $stmt->bindParam(":kurumKodu", $ogrenci->KURUMKODU);
    $stmt->bindParam(":ogrenciNo", $ogrenci->OGRENCINO);
    $stmt->bindParam(":password", $ogrenci->PASSWORD);
    
    try{
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($row) === 1){
            extract($row[0]);
            $ogrenci->ID = $ID;
            $ogrenci->SINIFSEVIYESI = $SINIFSEVIYESI;
            $_SESSION["userOgrenci"] = $ogrenci;
            http_response_code(200);
            echo json_encode(array("message" => "Logged"), JSON_UNESCAPED_UNICODE);
        }
        else{
            //oyle bir ogrenci yok ya da hatali bilgi girisi
            http_response_code(503);
            echo json_encode(array("err_message" => "Eksik yada yanlış bilgi girişi"), JSON_UNESCAPED_UNICODE);
        }
    }catch(Exception $e){
        print_r($e);
        exit();
    }

}
else{
    echo json_encode(array("err_message" => "Erişim yetkiniz yok"), JSON_UNESCAPED_UNICODE);
}



