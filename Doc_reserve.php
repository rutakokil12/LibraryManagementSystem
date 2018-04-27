
<html>
<head>
    <title>DBMS</title>
</head>
<body >
<h2>Document reserve</h2>
<p><form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

        <?php
        include 'connect_db.php';
        $conn = OpenCon();
        $copyAvailable = $conn->query("SELECT database_copy.id, database_copy.CopyNo, database_copy.Branch_id,database_copy.Document_id, COUNT(*) as numOfCopies FROM database_copy WHERE id not in(SELECT database_borrows.Copy_id FROM database_borrows,database_copy where database_borrows.Copy_id = database_Copy.id AND database_borrows.RDTime is  NULL
UNION ALL 
SELECT database_reserves.Copy_id FROM database_copy,database_reserves where database_copy.id = database_reserves.Copy_id) GROUP BY database_copy.Branch_id , database_copy.Document_id ORDER BY database_copy.id");
        echo "Available Documents and number of copies for each document in different branches are - ";
        if ($copyAvailable->num_rows > 0) {
            echo "<table><tr><th>Select </th><th>Copy Id</th><th>Copy No </th><th>Branch Id</th><th>Document ID</th><th>Number Of Copies </th><th>";
            // output data of each row

            while($row = $copyAvailable->fetch_assoc()) {
                echo "<tr><td><input type=\"checkbox\" name='checkbox[]' value='" . $row['id'] . "'  />"."</td><td>". $row["id"]. "</td><td>". $row["CopyNo"]. " </td><td>". $row["Branch_id"]. "</td><td>". $row["Document_id"]. "</td><td>". $row["numOfCopies"]. "</td><td> " ;
            }
            echo "</table>";

        } else {
            echo "0 results";
        }
        if(isset($_REQUEST['submit'])) {
            getCheckedDoc($conn);
        }




        function getCheckedDoc($conn) {
            session_start();
            $readerId = $_SESSION['cardnumber'];
            $chvalues = array();
            if(isset($_POST['checkbox']))
            {
                foreach($_POST['checkbox'] as $ch => $value)
                {
                    $chvalues[] = $value;
                    $idData = $conn->query("SELECT Document_id , Branch_id, CopyNo FROM database_copy WHERE id = $value ");
                    if ($idData->num_rows > 0) {
                        while($row = $idData->fetch_assoc()) {
                            $Doc_id = $row["Document_id"];
                            $Lib_id =$row["Branch_id"];
                            $Copy_No = $row["CopyNo"];
                        }
                    }
                    else {
                        echo "0 results";
                    }
                    $resNumber = $conn->query("SELECT MAX(ResNumber)  FROM database_reserves");
                    if ($resNumber->num_rows > 0) {
                        while($row = $resNumber->fetch_assoc()) {
                            $RNo = $row['MAX(ResNumber)'];
                            $RNo = $RNo + 1;
                        }
                    }
                    else {
                        echo "0 results";
                    }
                    date_default_timezone_set("UTC");
                    $reserveDate = date('Y-m-d H:i:s.u');
                    $RDTime =null;

                        $sql = "INSERT INTO database_reserves (ResNumber, DTime, Copy_id, Reader_id,Document_id,CopyNo,Lib_id)VALUES ('$RNo','$reserveDate' ,'$value','$readerId','$Doc_id','$Copy_No','$Lib_id')";

                        if ($conn->query($sql)) {
                            echo "<script>alert('Please record your Reserve number  and pick up your document before 6 pm within 24 hours ')</script>";
                            echo"Please record your Reserve number " .$RNo. " and pick up your document before 6 pm within 24 hours " ;
                            header("Location: Doc_reserve.php");
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }

                }

            }

        }


        CloseCon($conn);

        ?>
<p><input type = "submit" value="submit"  name="submit"></p>

</form>

<a href="index.php">HOME</a>
</body>
</html>
