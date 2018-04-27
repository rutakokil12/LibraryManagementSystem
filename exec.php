<?php
include "shih_connect_db.php";
#add copy
if(isset($_POST['sub'])){
    $sql = "select MAX(id) from `database_copy`";
    $retval = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($retval,MYSQLI_NUM);
    $id = $row[0] + 1;
    $sql = "INSERT INTO `database_copy`(`id`, `Position`, `CopyNo`, `Branch_id`, `Document_id`) VALUES ('".$id."','".$_POST['DOCID']."','".$_POST['TITLE']."','".$_POST['PDATE']."','".$_POST['PUBLISHERID']."')";
    $retval = mysqli_query($conn,$sql);
    echo "<form name='auto' action='administrative.php'>";
    echo "</form>";
    echo "<script>auto.submit(); </script> ";
}
#search copy
if(isset($_POST['sub2'])){
    $sql = "SELECT DISTINCT * 
                FROM database_copy
                WHERE (id IN (SELECT database_borrows.Copy_id
                              FROM database_borrows
                              WHERE database_borrows.RDTime IS null))
                              OR (id IN (SELECT database_reserves.Copy_id
                                        FROM database_reserves
                                        WHERE database_reserves.DTime IS NOT null))";
    $retval = mysqli_query($conn,$sql);
    $j =0;
    while($row = mysqli_fetch_array($retval,MYSQLI_NUM)) {
        if($row[4] == $_POST['DOCID']){
            $lib[$j] = $row[3];
            $copy[$j] = $row[2];
            echo $row[4]."'s copies are unavailable in library_no ".$row[3]."<br>";
            $j++;
        }
    }
    $sqlava = "SELECT *
                  FROM database_copy
                  WHERE id NOT IN (SELECT DISTINCT id 
                                  FROM database_copy
                                  WHERE (id IN (SELECT database_borrows.Copy_id
                                                FROM database_borrows
                                                WHERE database_borrows.RDTime IS null))
                                                OR (id IN (SELECT database_reserves.Copy_id
                                                          FROM database_reserves
                                                          WHERE database_reserves.DTime IS NOT null)))";
    $retvalava = mysqli_query($conn,$sqlava);

    while ( $row = mysqli_fetch_array($retvalava,MYSQLI_NUM)) {
        if ($_POST['DOCID'] == $row[4]) {
            echo "DocID:$row[4] is available in Lib_id: $row[3]<br/>";
        }
    }

}
#add reader
if(isset($_POST['sub3'])){
    $sql = "INSERT INTO `database_reader`(`ReaderID`, `RType`, `RName`, `Address`) VALUES ('".$_POST['readerid']."','".$_POST['rtype']."','".$_POST['rname']."','".$_POST['address']."')";
    $retval = mysqli_query($conn,$sql);
    echo "<form name='auto' action='administrative.php'";
    echo "</form>";
    echo "<script>auto.submit(); </script> ";
}
#search branch
if(isset($_POST['sub4'])){
    $sql = "SELECT * FROM `database_branch` WHERE `LibID` = '".$_POST['libid']."'";
    $retval = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($retval,MYSQLI_NUM)) {
        echo  $row[1]." ".$row[2]."<br>";
    }
}
#top 10 borrowers
if(isset($_POST['sub5'])){
    $sql = "SELECT count(*),Reader_id,`Lib_id` FROM `database_borrows`,`database_branch` where `Lib_id` = `database_branch`.`LibID` GROUP BY `Reader_id`,`Lib_id` order by Lib_id";
    $retval = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($retval,MYSQLI_NUM)) {
        echo  $row[1]." borrows ".$row[0]." books from ".$row[2]."<br>";
    }
}
#top 10 books
if(isset($_POST['sub6'])){
    $sql = "SELECT `title`,count(*),`database_borrows`.`Lib_id` FROM `database_document`,`database_borrows` WHERE `database_borrows`.`Document_id` = `DocID` GROUP by `title`,`database_borrows`.`Lib_id` order by `database_borrows`.`Lib_id`";
    $retval = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($retval,MYSQLI_NUM)) {
        echo  $row[1]." books ".$row[0]." are popular in libid =  ".$row[2]."<br>";
    }
}
#top 10 popular books
if(isset($_POST['sub7'])){
    $sql = "SELECT `Title`,`DocID`, YEAR(BDTime), count(*) FROM `database_document`,`database_borrows` where `DocID` = `database_borrows`.`Document_id` GROUP by `DocID`, YEAR(BDTime) UNION ALL SELECT `Title`,`DocID`, YEAR(DTime),count(*) FROM `database_document`,`database_reserves` where `DocID` = `database_reserves`.`Document_id` GROUP by `DocID`, YEAR(DTime) ORDER BY `count(*)` DESC";
    $retval = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($retval,MYSQLI_NUM)) {
        echo  $row[2]." has ".$row[3]." ".$row[0]."<br>";
    }
}
#average fine
if(isset($_POST['sub8'])){
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

}
?>
<html>
<body>
<a href="administrative.php">HOME</a>
</body>
</html>