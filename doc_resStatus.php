
<html>
<head>
    <title>DBMS</title>
</head>
<body>
<h2>Documents reserved</h2>
<p><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

        <?php
        include 'connect_db.php';
        $conn = OpenCon();
        session_start();
        $readerId = $_SESSION['cardnumber'];
        $resCopies = $conn->query("SELECT Reader_id ,ResNumber,Copy_id, CopyNo,Lib_id,Document_id,DTime FROM database_reserves WHERE Reader_id = $readerId");
        echo "The list of documents reserved by a reader ". $readerId . " and their status. ";
        if ($resCopies->num_rows > 0) {

            echo "<table><tr><th>Reader ID </th><th>Reserve Number </th><th>Copy ID </th><th>Copy No </th><th>Branch ID</th><th>Document ID </th><th> DTime </th><th> reservation status</th><th></th>";
            // output data of each row

            while($row = $resCopies->fetch_assoc()) {
                date_default_timezone_set("America/New_York");
            $pick_update = date('Y-m-d H:i:s.u');
            $resDTime = $row["DTime"];
                $pick_update = strtotime($pick_update);
                $resDTime = strtotime($resDTime);
                $diff  	= $pick_update - $resDTime;
                $hrDiff = floor($diff/(60*60*24));

                if (date('H', $pick_update ) < 18 && $hrDiff < 1 ) {
                    $resStatus = "Yet to be picked up";
                }else {
                    $resStatus = "Already Picked up";
                }

                echo "<tr><td>" . $row["Reader_id"]."</td><td>". $row["ResNumber"]. "</td><td>". $row["Copy_id"]. " </td><td>". $row["CopyNo"]. "</td><td>". $row["Lib_id"]. "</td><td>". $row["Document_id"]. "</td><td>" . $row["DTime"]."</td><td>" .$resStatus. "</td><td>" ;
            }
            echo "</table>";

        } else {
            echo "</br>No Reserved Copies";
        }


        CloseCon($conn);

        ?>


</form>
<a href="index.php">HOME</a>

</body>
</html>
