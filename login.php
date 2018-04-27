<?php
    include "shih_connect_db.php";
    $sql = "SELECT * FROM login WHERE `userid` = '".$_POST['userid']."' and `password` = '".$_POST['pwd']."'";
    $retval = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($retval,MYSQLI_NUM);
    if($row[0] == NULL){
        echo '<script>alert("wrong username or password")</script>';
        echo "<form name='auto' action='index.php'";
        echo "</form>";
        echo "<script>auto.submit(); </script> ";
    }else{
        echo "<form name='auto' action='administrative.php'";
        echo "</form>";
        echo "<script>auto.submit(); </script> ";   
    }
?>