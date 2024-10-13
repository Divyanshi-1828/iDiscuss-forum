<?php
// script to connect to the database

//connecting to the database
$servername="localhost";
$username="root";
$password="";
$database="idiscuss";
// create a connection object
$conn=mysqli_connect($servername,$username,$password,$database);

// die if connection was not succesfull
if(!$conn){
    die("Sorry we failed to connect: ".mysqli_connect_error());
}
// else{
//     echo "Connection was successfull<br>";
// }


?>