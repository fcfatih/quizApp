<?php
//string disindaki herseyi sayi, sembol vb. siler..

function test_input($data){
    $data = trim(stripcslashes(htmlspecialchars($data)));
}


function strTemizle($value){
    return trim(filter_input($value, FILTER_SANITIZE_STRING));
}
?>




