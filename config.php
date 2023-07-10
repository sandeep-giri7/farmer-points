<?php
$servername= 'localhost';
$username= 'root';
$password= '';
$dbname= 'farmerspoint';

$conn= mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die("Connection failed: ".mysqli_connect_error());
    // echo "Connection failed";
}
else{
    echo "Connection successful<br>";
}
?>