<?php
$host="mysql:host=localhost;dbname=home_power;";
$username="root";
$password="";


try
{
    $db=new PDO($host,$username,$password);
}
catch(PDOException $e){
    $error_message="database error:";
    $error_message= $e->getMessage();
    echo $error_message;
}

?>