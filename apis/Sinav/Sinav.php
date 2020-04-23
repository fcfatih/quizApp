<?php
class Sinav{
    public $ID;
    public $SINAVADI;
    public $ACIKLAMA;
    public $BASLANGICTARIHI;
    public $BITISTARIHI;
    public $SINIFSEVIYESI;
    public $DURUM;
    public $SINAVSURESI;
    
    public function __construct(
        $ID = null, 
        $SINAVADI = null, 
        $ACIKLAMA = null, 
        $BASLANGICTARIHI = null, 
        $BITISTARIHI = null, 
        $SINIFSEVIYESI = null,
        $DURUM = null,
        $SINAVSURESI = null){
        
        $this->ID = $ID;
        $this->SINAVADI = $SINAVADI;
        $this->ACIKLAMA = $ACIKLAMA;
        $this->BASLANGICTARIHI = $BASLANGICTARIHI;
        $this->BITISTARIHI = $BITISTARIHI;
        $this->SINIFSEVIYESI = $SINIFSEVIYESI;
        $this->DURUM = $DURUM;
        $this->SINAVSURESI = $SINAVSURESI;
    }
    
    public function toARRAY(){
        return array(
            "ID" => $this->ID, 
            "SINAVADI" => $this->SINAVADI, 
            "ACIKLAMA" => $this->ACIKLAMA, 
            "BASLANGICTARIHI" => $this->BASLANGICTARIHI, 
            "BITISTARIHI" => $this->BITISTARIHI, 
            "SINIFSEVIYESI" => $this->SINIFSEVIYESI,
            "DURUM" => $this->DURUM, 
            "SINAVSURESI" => $this->SINAVSURESI
        );
    }
}
/*
  sinav durumlari
 * 0 - hazirlaniyor
 * 1 - yayina baslamadi (sinav henuz baslamadi)
 * 2 - yayina basladi   (saatinde otomatik baslasin)
 * 3 - bitti (sinav 2 gundu bitti)
 * 4 - sonuclar aciklandi
 *  */

?>
