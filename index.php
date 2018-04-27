<?php
include 'connect_db.php';
$conn = OpenCon();

if(isset($_REQUEST['submit1'])) {
    session_start();
    $cardnumber = $_POST['cardnumber'];
    $_SESSION['cardnumber'] = $cardnumber;
    $result = $conn->query("SELECT ReaderID FROM database_reader WHERE ReaderID = $cardnumber");
    if ($result->num_rows == 0) {
        echo "Reader id does not exist in the library records";
    } else {
        header("Location: reader.php");
    }
}

CloseCon($conn);
?>
<html>
<head>
    <title>DBMS</title>
    <style>
        #background{position:absolute; z-index:-1; width:100%; height:100%;}

    </style>
</head>
<body>
<div>
    <img id="background" src="background.png" alt="" title="" />
</div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <p>READER</p>
    Card Number <input type = "number" name="cardnumber" required autocomplete="on">
    <p><input type = "submit" value="submit"  name="submit1"></p>
</form>
<form action="administrative.php" method="post">
    ADMINISTRATIVE
    <p>UserID <input type="text" name="userid"></p>
    PassWord <input type="password" name="pwd">
    <p><input type = "submit" value="submit" name="submit2"></p>
</form>
</body>
</html>