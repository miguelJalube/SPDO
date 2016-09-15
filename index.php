<?php

//  Autoload
function __autoload($class_name){
    if(file_exists($class_name . '.class.php')){
        require_once $class_name . '.class.php';
    }
}

$query = \model\SPDO::getInstance();
$array = $query->query('SELECT * FROM equiw_content');

echo "<pre>";
print_r($array);

?>