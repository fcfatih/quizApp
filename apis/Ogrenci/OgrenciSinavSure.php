<?php
class OgrenciSinavSure{
    public $ID;
    public $OGRENCIID;
    public $SINAVID;
    public $SINAVABASLAMA;
    public $SINAVIBITIRME;
    
    function recordExist($db){
        $sorgu = "SELECT * FROM OGRENCISINAVSURE WHERE SINAVID = :sinavID AND OGRENCIID = :ogrID";
        $stmt = $db->prepare($sorgu);
        $stmt->bindParam(":sinavID", $this->SINAVID);
        $stmt->bindParam(":ogrID", $this->OGRENCIID);
        try{
            $stmt->execute();
            $c = $stmt->rowCount();
            if($c > 0){
                return true;
            }
            else{
                return false;
            }
        }
        catch(Exception $e){
            print_r($e);
        }
    }
    
    function readOne($db){
        $sorgu = "SELECT * FROM OGRENCISINAVSURE WHERE SINAVID = :sinavID AND OGRENCIID = :ogrID";
        $stmt = $db->prepare($sorgu);
        $stmt->bindParam(":sinavID", $this->SINAVID);
        $stmt->bindParam(":ogrID", $this->OGRENCIID);
        try{
            $stmt->execute();
            $num = $stmt->rowCount();
            if($num > 0 ){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                extract($row);
                $this->ID = $ID;
                $this->SINAVABASLAMA = $SINAVABASLAMA;
                $this->SINAVIBITIRME = $SINAVIBITIRME;
                return true;
            }else{
                return false;
            }
        } catch (Exception $e){
            
        }
    }
    
    function create($db){
        //id bilgisi otomatik arttirma olmaliydi..
        $sorgu = "INSERT INTO OGRENCISINAVSURE SET ID = 0, OGRENCIID = :ogrID, SINAVID = :sinavID, SINAVABASLAMA = :simdi";
        $stmt = $db->prepare($sorgu);
        $stmt->bindParam(":ogrID", $this->OGRENCIID);
        $stmt->bindParam(":sinavID", $this->SINAVID);
        $this->SINAVABASLAMA = new DateTime();
        $s =  $this->SINAVABASLAMA->format("Y-m-d H:i:s");
        $stmt->bindParam(":simdi", $s);
        try{
            $stmt->execute();
        }catch(Exception $e){}
    }
    
    function update($db){
        $sorgu = "UPDATE OGRENCISINAVSURE SET SINAVIBITIRME = :bitis WHERE OGRENCIID = :ogrID AND SINAVID = :sinavID";
        $stmt = $db->prepare($sorgu);
        $stmt->bindParam(":ogrID", $this->OGRENCIID);
        $stmt->bindParam(":sinavID", $this->SINAVID);
        $s = $this->SINAVIBITIRME->format("Y-m-d H:i:s");
        $stmt->bindParam(":bitis", $s);
        try{
            $stmt->execute();
        }catch(Exception $e){}
    }
}
?>