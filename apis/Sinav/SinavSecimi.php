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
        //ogrencisinavsure tablosunda kaydi var mi?
        $sorgu = "SELECT * FROM OGRENCISINAVSURE WHERE SINAVID = :sinavID AND OGRENCIID = :ogrenciID";
        
        $sinav = new Sinav($data->sinavID);
        $_SESSION["sinav"] = $sinav;
        $ogr = $_SESSION["userOgrenci"];
        
        $stmt = $db->prepare($sorgu);
        $stmt->bindParam(":sinavID", $sinav->ID);
        $stmt->bindParam(":ogrenciID", $ogr->ID);
        $stmt->execute();
        $num = $stmt->rowCount();
        if($num > 0){
            //ogrenci sinavi baslatmis, suresi dolmadiysa veya bitir demediyse giris yapabilir.
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            if(is_null($BITISTARIHI) || empty($BITISTARIHI)){
                //kalan sure yeterli ise devam edebilir
                //degilse bitis kaydi yapilir. sinavi tamamladiniz.
                
                
                http_response_code(200);
                echo json_encode(array("message" => "DONE"), JSON_UNESCAPED_UNICODE);
                exit();
            }else{
                http_response_code(200);
                echo json_encode(array("message" => "Sınavı tamamladınız."), JSON_UNESCAPED_UNICODE);
                exit();
            }
        }
        else{
            //ogrenci ilk kez sinava giriyor
            $baslangic = DateTime();
            $sinav->BASLANGICTARIHI = $baslangic;

            $sorgu ="INSERT INTO OGRENCISINAVSURE SET OGRENCIID = :ogrenciID, SINAVID = :sinavID SINAVABASLAMA = :baslangic";
            $stmt = $db->prepare($sorgu);
            $stmt->bindParam(":sinavID", $sinav->ID);
            $stmt->bindParam(":ogrenciID", $ogr->ID);
            $stmt->bindParam(":baslangic", $sinav->BASLANGICTARIHI);
            $stmt->execute();
            http_response_code(200);
            echo json_encode(array("message" => "DONE"), JSON_UNESCAPED_UNICODE);
            exit();
        }
    } catch (Exception $e){
        echo json_encode(array("err_message" => "Hata"), JSON_UNESCAPED_UNICODE);
        print_r($e);
        exit;
    }
}else{
    echo json_encode(array("err_message" => "Eksik yada yanlış bilgi girişi"), JSON_UNESCAPED_UNICODE);
    exit();
}
?>
