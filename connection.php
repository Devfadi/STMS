<?php

$host="localhost";
$user="root";
$pass="";
$db="imad";

$link = new mysqli($host,$user,$pass,$db);
if (mysqli_connect_errno()){
    echo mysqli_connect_error();
    exit();
}
else{
    //echo "Successful database connection !!!";
}
mysqli_set_charset($link,'utf8');
mysqli_select_db($link,$db)or die("cannot select DB");


?>
