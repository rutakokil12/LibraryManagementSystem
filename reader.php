<?php
include "shih_connect_db.php";
session_start();
$readerId = $_SESSION['cardnumber'];
$sql = "select * from database_reader where ReaderID = $readerId";
$retval = mysqli_query($conn,$sql);
$Reader = $readerId;
while($row = mysqli_fetch_array($retval, MYSQLI_NUM)) {
    $rID = $row[0];
    $rName = $row[2];
    echo "HI $rName $rID <br>";
}
?>
<html>
<head>
    <title>Reader</title>
</head>
<body>
<form action="search.php" method="post">
    <h1>SERACH A DOCUMENT BY ID, TITLE OR PUBLISHER NAME</h1>
    <p>Document ID: <input type="text" name="ID"></p>
    <p>Document Title: <input type="text" name="Title"></p>
    <p>Publisher Name: <input type="text" name="pub"></p>
    <input type="submit" value="submit">
</form>
<ul style="list-style-type:disc">
<li><a href ="Doc_Checkout.php">Document checkout</a></li>
<li><a href ="Doc_return.php">Document return</a></li>
<li><a href ="Doc_reserve.php">Document reserve</a></li>
</ul>
<form action="print_fin_per_reader.php" method="post">
    Compute fine for a document ID: <input type="text" name="DocID"> borrowed by <?php echo "$rName $rID ";?> due TODAY.
    <?php echo "<input type='text' name='Reader' value=".$Reader.">";?>
    <p></p>
    <input type="submit" value="Compute">
    <p></p>
</form>
<ul style="list-style-type:disc">
<li><a href ="Doc_resStatus.php">Print the list of documents reserved by a reader and their status.</a></li>
<li><a href = "Doc_display.php">Print the document id and document titles of documents published by a publisher.</a></li>
<li>Quit</li>
</ul>
</body>
</html>