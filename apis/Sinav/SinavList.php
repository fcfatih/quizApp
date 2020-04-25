<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


require_once("../Ogrenci/Ogrenci.php");
require_once("Sinav.php");
require_once("../Config/DataBase.php");
require_once("../Config/config.php");

if(isset($_SESSION["userOgrenci"])){
    $database = new Database();
    $db = $database->getConnection();
    $ogr = $_SESSION["userOgrenci"];
    
    //$durum = 2; //yayinda olan sınavlar 2
    //$sorgu = "SELECT * FROM SINAVLAR WHERE DURUM = :durum AND SINIFSEVIYESI = :seviye";
    $sorgu = "SELECT * FROM SINAVLAR WHERE DURUM IN (2,4) AND SINIFSEVIYESI = :seviye";
    $stmt = $db->prepare($sorgu);
    //$stmt->bindParam(":durum", $durum); 
    $stmt->bindParam(":seviye", $ogr->SINIFSEVIYESI);
    
    try{
        $stmt->execute();
        $num = $stmt->rowCount();
        if($num > 0){
            $sinavlar_dizisi = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $item = new Sinav($ID, $SINAVADI, $ACIKLAMA, $BASLANGICTARIHI, $BITISTARIHI, $SINIFSEVIYESI, $DURUM, $SINAVSURESI);
                array_push($sinavlar_dizisi, $item->toARRAY());
            }
            http_response_code(200);
            echo(json_encode($sinavlar_dizisi, JSON_UNESCAPED_UNICODE));
        }
    } catch (Exception $e){
        print_r($e);
    }
}
else{
    echo json_encode(array("err_message" => "Erişim yetkiniz yok"), JSON_UNESCAPED_UNICODE);
    exit();
}











?>