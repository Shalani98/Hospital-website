<?php
$host="localhost";
$user="root";
$pwd="";
$db="care_compass_hospitals";
$conp=mysqli_connect($host,$user,$pwd,$db);
if(mysqli_connect_error()){
    die('Database connection fail' .mysqli_connect_error());
}
?>