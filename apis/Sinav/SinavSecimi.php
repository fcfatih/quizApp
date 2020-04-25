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
    require_once("../Tools/timeTools.php");
    require_once("../Ogrenci/Ogrenci.php");
    require_once("../Ogrenci/OgrenciSinavSure.php");
    require_once("Sinav.php");
    require_once("../Config/DataBase.php");
    require_once("../Config/config.php");
    
    try{
        $database = new Database();
        $db = $database->getConnection();
        
        $ogrenci = $_SESSION["userOgrenci"];
        
        $sinav = new Sinav($data->sinavID);
        $sinav->readOne($db);
        $_SESSION["sinav"] = $sinav;
        
        $ogrenciSinavSure = new OgrenciSinavSure();
        $ogrenciSinavSure->OGRENCIID = $ogrenci->ID;
        $ogrenciSinavSure->SINAVID = $sinav->ID;
        //DELETE FROM OGRENCISINAVSURE WHERE OGRENCIID = 8427
        
        if(!$ogrenciSinavSure->recordExist($db)){
            //ogrenci ilk kez sinava griiyor.
            $ogrenciSinavSure->create($db);
            $bitirmeZamani = ekleTime($ogrenciSinavSure->SINAVABASLAMA, new DateTime($sinav->SINAVSURESI));
            $_SESSION["ogrenciSinavSure"] = $ogrenciSinavSure;
            $_SESSION["ogrenciSinavBitisZamani"] = $bitirmeZamani;
            http_response_code(200);
            echo json_encode(array("message" => "START"), JSON_UNESCAPED_UNICODE);
        }
        else{
            //baglanti kopmus olabilir.
            //bitirme zamani kaydi var mi?
            $ogrenciSinavSure->readOne($db);
            if($ogrenciSinavSure->SINAVIBITIRME === null){
                //bitir dememis
                //suresi bitmemis ise 
                //sinav suresi bitmis mi?
                if(farkBul($_SESSION["ogrenciSinavBitisZamani"], new DateTime()) < 0){
                    //sinavi bitir dememis peki yeterli suresi varsa
                    $ogrenciSinavSure->SINAVIBITIRME = new DateTime();
                    $ogrenciSinavSure->update($db);
                    http_response_code(200);
                    echo json_encode(array("message" => "RUN_OUT_OF_TIME"), JSON_UNESCAPED_UNICODE);
                }
                else{
                    //yeterli süresi yoksa
                    http_response_code(200);
                    echo json_encode(array("message" => "RECONNECT"), JSON_UNESCAPED_UNICODE);
                }                
            }
            else{
                http_response_code(200);
                echo json_encode(array("message" => "FINISED"), JSON_UNESCAPED_UNICODE);
            }
        }
    } catch (Exception $e){
        //echo json_encode(array("err_message" => "Hata"), JSON_UNESCAPED_UNICODE);
        print_r($e);
        exit;
    }
}else{
    echo json_encode(array("err_message" => "Eksik yada yanlış bilgi girişi"), JSON_UNESCAPED_UNICODE);
    exit();
}



//http_response_code(200);
//echo json_encode(array("message" => "DONE"), JSON_UNESCAPED_UNICODE);
//echo json_encode(array("err_message" => "Eksik yada yanlış bilgi girişi"), JSON_UNESCAPED_UNICODE);
//echo json_encode(array("err_message" => "Hata"), JSON_UNESCAPED_UNICODE);
//exit();
?>
