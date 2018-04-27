<?php
    include "shih_connect_db.php";
    $sql = "SELECT * FROM `database_document` WHERE `DocID` = '".$_POST['ID']."' or `Title` = '".$_POST['Title']."' or `Publisher_id` in (SELECT `PublisherID` from `database_publisher` where `PubName` = '".$_POST['pub']."')";
    $retval = mysqli_query($conn,$sql);
   while($row = mysqli_fetch_array($retval,MYSQLI_NUM)) {
      echo  $row[0]." ".$row[1]." ".$row[2]." ".$row[3]."<br>";
   }
?>
<html>
    <a href="index.php">HOME</a>
</html>