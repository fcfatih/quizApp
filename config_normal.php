<?php
session_start();

define("ENVIRONMENT", "DEVELOPMENT");

if(ENVIRONMENT === "DEVELOPMENT"){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

date_default_timezone_set('Europe/Istanbul');
setlocale(LC_TIME, 'tr_TR');
?>