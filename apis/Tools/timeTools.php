<?php
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

//ibirnci datetime nesnesine ikinci datetime nesnesinin saat-dakika-saniyesini ekler. 
function ekleTime($t1, $t2){
    $t3 = clone $t1;
    $saat = $t2->format("H");
    $dakika = $t2->format("i");
    $saniye = $t2->format("s");
    $ekleme = "PT".$saat."H".$dakika."M".$saniye."S";
    $t3->add(new DateInterval($ekleme));
    return $t3;
}

//datetime obj olarak verilen iki tarih arasindaki zaman farkini saniye cinsinden verir.
function farkBul($birinci,$ikinci){
    $fark=strtotime($birinci->format("H:i:s")) - strtotime($ikinci->format("H:i:s"));
    return $fark;
}

function farkBulSDS($birinci,$ikinci){
    $fark=strtotime($birinci->format("H:i:s")) - strtotime($ikinci->format("H:i:s"));
    $seconds = $fark ;
    $minutes = round($fark / 60 );
    $hours = round($fark / 3600 );
    if($fark < 0){
        
    }
    return array("signal" => "");
}

function test(){
    
}

?>