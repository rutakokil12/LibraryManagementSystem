<?php 
    $conn = mysqli_connect('localhost','root','ThinkBeautiful@12','pt');
    if(! $conn ) {
      die('Could not connect: ' . mysql_error());
    }
?>