<?php
require_once("../Config/config.php");

//hangi fonksiyonlara ihtiyacim var?
/*
   1- simdiki zaman
 * 2- simdiki zamana belirli bir sureyi (saat-dakika-saniye) ekleme
 * 3- bir sureden simdiyi cikarip kalan sureyi H:i:s seklinde elde etme
 * 
 * 
 * benim is akisimda neler lazim?
 * 1- baslangic (simdi)
 * 2- kalan sure hesabi
 *    bu nasil yapilir?
 *    baslangic + sinav suresi - simdi
 *    ortaya cikan sonuc his seklinde doner. gerisini zaten front halledicek.
 * 
 *  */

function simdi(){
    $dt = new DateTime();
    //echo($dt->format("Y-m-d H:i:s"));
    return $dt;
}

//ibirnci datetime nesnesine ikinci datetime nesnesinin sa-dakika-saniyesini ekler. 
function ekleTime($t1, $t2){
    $saat = $t2->format("H");
    $dakika = $t2->format("i");
    $saniye = $t2->format("s");
    $ekleme = "PT".$saat."H".$dakika."M".$saniye."S";
    $t1->add(new DateInterval($ekleme));
    return $t1;
}

function fark($t1, $t2){
    $interval = $t1->diff($t2);
    return new DateTime($interval->format("P %Y-%m-%d %H:%i:%s"));
}

//verilen sureden simdiki saati cikarip
//DateTime olarak dondurur
function kalanSure($t){
    return fark($t, new DateTime());
}

//verilen sureden simdiki saati cikarip
//kalan sureyi array("hour" => ..) sekline bir dizi olarak dondurur
function kalanSureSDS($t){
    $sonuc = kalanSure($t);
    $saat = $sonuc->format("H");
    $dakika = $sonuc->format("i");
    $saniye = $sonuc->format("s");
    return array("hour" => $saat, "minutes" => $dakika, "seconds" => $saniye);
}

function test(){
    //simdi();
    
    ////echo("<br>");
    //ekleTime(new DateTime(), new DateTime("03:10:40"));
    
    ////$datetime1 = new DateTime('2020-1-1 06:05:10'); 
    //$datetime2 = new DateTime('2020-1-1 06:02:10'); 
    //$sonuc = fark($datetime1, $datetime2);
    //echo($sonuc->format("Y-m-d H:i:s"));
    
    $sonuc = kalanSureSDS(new DateTime("2020-4-24 02:00:00"));
    print_r($sonuc);
}

test();
?>