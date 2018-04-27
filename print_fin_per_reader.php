<?php
	include "noujan_connect_db.php";
	date_default_timezone_set("UTC");
    $date = date('Y-m-d H:i:s.u');
    //echo $date;
    $rDocID = $_POST['DocID'];
    $ReaderID = $_POST['Reader'];
    //echo "docID: $rDocID     ResderID: $ReaderID";

	$sql = "SELECT database_borrows.BDTime
			FROM database_borrows 
			WHERE (database_borrows.RDTime IS null) AND Reader_id = '".$ReaderID."' AND Document_id = '".$rDocID."'";
	$retval=mysqli_query($conn,$sql);
	while($row=mysqli_fetch_array($retval, MYSQLI_NUM))
	{
		
		$time = strtotime($row[0]);
		$BDTime = date('Y-m-d H:i:s.u',$time);
		$y = new DateTime($date);
		$x = new DateTime($BDTime);
		$nbDays = $y->diff($x);
		$interval = $nbDays->days;
		if ($interval>20) {
			$fine = $interval * 20;	
			echo "ReaderID: $ReaderID need to pay : $fine Dollars    for DocID: $rDocID<br/>";
		}
		else if ($interval<20)
		{
			echo "You Don't need to pay anything! :)<br/>";
		}
	}

?>

<html>
    <a href="index.php">HOME</a>
</html>