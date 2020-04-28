<?php
require_once("Sinav.php");
require_once("../Ogrenci/Ogrenci.php");
require_once("../Config/DataBase.php");
require_once("../Config/config.php");



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
    
    //veritabaninda kaydet
    //session da kaydet
    $database = new Database();
    $db = $database->getConnection();
    $sinav = $_SESSION["sinav"];
    $ogrenci = $_SESSION["userOgrenci"];
    
    //sanitize validate
    $dersID =               $data->dersID;
    $soruID =               $data->soruID;
    $kullaniciCevabi =      $data->kullaniciCevabi;
    
    //cevap varsa guncelle. yoksa yeni kayit olustur
    $sorgu = "SELECT * FROM OGRENCISINAVSORUCEVAPLARI ".
        "WHERE OGRENCIID = :userID AND SORUID = :soruID ";
    $stmt = $db->prepare($sorgu);
    $stmt->bindParam(":userID", $ogrenci->ID);
    $stmt->bindParam(":soruID", $soruID);
    try{
        $stmt->execute();
    }catch(Exception $e){
        //print_r($e);
    }
    $num = $stmt->rowCount();
    if($num > 0){
        //guncelle
        $sorgu = "UPDATE OGRENCISINAVSORUCEVAPLARI SET " . 
        "SINAVID = :sinavID, ".
        "DERSID = :dersID, ".
        "OGRENCICEVABI = :kullaniciCevabi WHERE OGRENCIID = :userID AND SORUID = :soruID ";
        $stmt = $db->prepare($sorgu);
        $stmt->bindParam(":userID", $ogrenci->ID);
        $stmt->bindParam(":sinavID", $sinav->ID);
        $stmt->bindParam(":dersID", $dersID);
        $stmt->bindParam(":soruID", $soruID);
        $stmt->bindParam(":kullaniciCevabi", $kullaniciCevabi);
        try{
            $stmt->execute();
        }catch(Exception $e){
            //print_r($e);
        }
    }    
    else{
        //ekle
        $sorgu = "INSERT INTO OGRENCISINAVSORUCEVAPLARI SET " . 
        "OGRENCIID = :userID, ".
        "SINAVID = :sinavID, ".
        "DERSID = :dersID, ".
        "SORUID = :soruID, ".
        "OGRENCICEVABI = :kullaniciCevabi";

        $stmt = $db->prepare($sorgu);

        $stmt->bindParam(":userID", $ogrenci->ID);
        $stmt->bindParam(":sinavID", $sinav->ID);
        $stmt->bindParam(":dersID", $dersID);
        $stmt->bindParam(":soruID", $soruID);
        $stmt->bindParam(":kullaniciCevabi", $kullaniciCevabi);

        try{
            $stmt->execute();
        }catch(Exception $e){
            //print_r($e);
        }
    }
    
    //session da da bilgi isleniyor
    $a = $_SESSION["aktifSinav"];
    for($i = 0; $i < count($a); $i++){
        if($a[$i]["dersID"] == $dersID){
            for($j = 0; $j < count($a[$i]["sorular"]); $j++){
                if($a[$i]["sorular"][$j]["soruID"] == $soruID){
                    $a[$i]["sorular"][$j]["kc"] = $kullaniciCevabi;
                }
            }
        }
    }
        
        
        
    
    http_response_code(200);
    echo json_encode(array("message" => "DONE"), JSON_UNESCAPED_UNICODE);
    exit();
}
else{
    echo json_encode(array("err_message" => "Eksik yada yanlış bilgi girişi"), JSON_UNESCAPED_UNICODE);
    exit();
}
?>