<?php
    include "noujan_connect_db.php";
    $sql = "SELECT DISTINCT DATEDIFF(`RDTime`, `BDTime`), RName, Reader_id
FROM database_borrows, database_reader
WHERE `RDTime` is not null and Reader_id = ReaderID and DATEDIFF(`RDTime`, `BDTime`)>20";
    $count = 0;
    $sum = 0;
    $retval = mysqli_query($conn,$sql);
   while($row = mysqli_fetch_array($retval,MYSQLI_NUM)) {
       /*if($row[0]>20){
            echo  20*($row[0]-20)." cents ".$row[1]."<br>";   
       }*/
       $name = $row[2];
       if($row[0]>20){
           $count++;
           $sum +=(($row[0]-20)*20);
       }
   }
    echo $name." average fine paid per reader ".$sum/$count." cents <br>";
?>
<html>
    <a href="administrative.php">HOME</a>
</html>

