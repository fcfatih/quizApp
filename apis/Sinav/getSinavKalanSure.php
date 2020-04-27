<?php
require_once("../Tools/timeTools.php");
require_once("../Config/config.php");

$bitis = $_SESSION["ogrenciSinavBitisZamani"];
sinavKalanSureSDS($bitis);
?>