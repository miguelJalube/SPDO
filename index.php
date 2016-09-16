<?php

//  Autoload
function __autoload($class_name){
    if(file_exists($class_name . '.class.php')){
        require_once $class_name . '.class.php';
    }
}

$req = 'INSERT INTO map (height, width, obstacles, ships) VALUES (:height, :width, :obstacles, :ships)';
$bind = array(
    'height'=>'23',
    'width'=>'23',
    'obstacles'=>'23',
    'ships'=>'23'
);

$query = \model\SPDO::getInstance();
$array = $query->query($req, $bind);

echo "<pre>";
print_r($array);

?>