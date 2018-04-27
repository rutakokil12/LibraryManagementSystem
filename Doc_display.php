<?php
    include "shih_connect_db.php";
echo "Please find below the document id , document titles of documnents published by publisher ";
    $sql = "SELECT `DocID`, `Title`, `Publisher_id` FROM `database_document` ";
    $revtal = mysqli_query($conn,$sql);
    echo "<table><tr><th>Document ID </th><th>Title </th><th>Publisher_ID</th><th>";
    //echo "Document_ID Title Publisher_ID"."<br>";
    while($row = mysqli_fetch_array($revtal,MYSQLI_NUM)){
        //echo $row[0]." ".$row[1]." ".$row[2]."<br>";
        echo "<tr><td>" . $row[0] . "</td><td>". $row[1]. "</td><td>" .$row[2]. "</td><td>";
    }
echo "</table>";
?>
<html>
<a href="index.php">HOME</a>
</html>
