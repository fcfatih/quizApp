<?php

require_once("Sinav.php");
require_once("../Config/DataBase.php");
require_once("../Config/config.php");

$database = new Database();
$db = $database->getConnection();
$sinav = $_SESSION["sinav"];


function sinaviOlustur($db, $sinav){
    http_response_code(200);
    $result = array();
    $sorgu = "SELECT * FROM DERSLER WHERE DERSLER.SINAVID = ".$sinav->ID;
    //$sorgu = "SELECT * FROM DERSLER WHERE DERSLER.SINAVID = 1";
    $stmt =  $db->prepare($sorgu);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $dersitem = array(
            "dersAdi" => $DERSADI,
            "dersID"  => $ID,
            "soruSayisi" => $SORUMIKTARI,
            "sonAktifSoruIndex" => 0,
            "sorular" => array()
        );
        array_push($result, $dersitem);
    }

    foreach($result as $key => $value){
        //$result[$key]["dersAdi"] = "fc";
        $sorgu = "SELECT ID, SORUIMGURL FROM SORULARIMG WHERE SINAVID = ".$sinav->ID." AND DERSID = ".$result[$key]["dersID"];
        $stmt =  $db->prepare($sorgu);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $soruitem = array(
                "soruID" => $ID,
                "soruIMG" => $SORUIMGURL,
                "kullaniciCevabi" => ""
            );
            array_push($result[$key]["sorular"], $soruitem);
        }
    }
    //iyi de bu varsa zaten bunu dondur..
    if(!isset($_SESSION["aktifSinav"])){
        $_SESSION["aktifSinav"] = $result;
    }
    echo(json_encode($result, JSON_UNESCAPED_UNICODE));
}

sinaviOlustur($db, $sinav);

?>
