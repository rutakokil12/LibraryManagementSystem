<?php
function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "ThinkBeautiful@12";
    $db = "pt";


    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);


    return $conn;
}

function CloseCon($conn)
{
    $conn -> close();
}


?>

