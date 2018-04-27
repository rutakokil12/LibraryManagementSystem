
<html>
<head>
    <title>DBMS</title>
</head>
<body>
<h2>Document return</h2>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<p>Please find below the details of Borrowed Documents by you</p>
    <?php
    include 'connect_db.php';
    $conn = OpenCon();
    session_start();
    $readerId = $_SESSION['cardnumber'];
    $borNumbers = $conn->query("SELECT BorNumber ,Copy_id ,Document_id,Lib_id, Reader_id, BDTime, RDTime FROM database_borrows WHERE Reader_id = $readerId ");
    if ($borNumbers->num_rows > 0) {
        echo "<table><tr><th>Select </th><th>Borrow Number </th></th><th>Copy Id </th><th>Document ID </th><th> Branch id </th><th> Borrow DTime  </th><th>  Return DTime  </th></tr>";
        // output data of each row

        while($row = $borNumbers->fetch_assoc()) {
            echo "<tr><td><input type=\"checkbox\" name='checkbox[]' value='" . $row['BorNumber'] . "'  />"."</td><td>". $row["BorNumber"]. "</td><td>". $row["Copy_id"]. " </td><td>". $row["Document_id"]. "</td><td> " . $row["Lib_id"] . "</td><td>" . $row["BDTime"] .  " </td><td>" . $row["RDTime"] .  "</td></tr>";
        }
        echo "</table>";

    } else {
        echo "0 results";
    }
    if(isset($_REQUEST['submit'])) {
        returnDoc($conn);
    }
    function returnDoc($conn){
    $chvalues = array();
    if(isset($_POST['checkbox'])) {
        foreach ($_POST['checkbox'] as $ch => $value) {$chvalues[] = $value;
           $checkRdtime = $conn->query("select RDTime FROM database_borrows WHERE BorNumber = $value ");
            if ($checkRdtime->num_rows > 0) {
                while($row = $checkRdtime->fetch_assoc()) {
                   if(is_null($row["RDTime"])){
                       date_default_timezone_set("UTC");
                       $date = date('Y-m-d H:i:s.u');
                       $sql = "UPDATE database_borrows SET RDTime = '$date' WHERE BorNumber = $value";
                       if ($conn->query($sql) === TRUE) {
                           echo "New record updated successfully";
                           header("Location: Doc_return.php");
                       } else {
                           echo "Error: " . $sql . "<br>" . $conn->error;
                       }

                   }else{
                       echo "There are no any documents to return";
                       echo "</br>You have already returned document on " . $row["RDTime"];
                   }
                }
                echo "</table>";

            } else {
                echo "0 results";
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
