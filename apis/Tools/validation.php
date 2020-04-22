<?php
//string disindaki herseyi sayi, sembol vb. siler..
function strTemizle($value){
    return trim(filter_input($value, FILTER_SANITIZE_STRING));
}





