<html>
    <head>
        <title>Administrative</title>
    </head>
    <body>
        <h1>ADD COPY</h1>
        <form action="exec.php" method = "post">
        <p>Position: <input type="text" name="DOCID"></p>
        <p>CopyNO: <input type="text" name="TITLE"></p>
        <p>Branch_id: <input type="text" name="PDATE"></p>
        <p>Document_id: <input type="text" name="PUBLISHERID"></p>
        <p><input type = "submit" name="sub" value="submit"></p>
        </form>
        <h1>SEARCH COPY</h1>
        <form action="exec.php" method = "post">
        <p>DOCID: <input type="text" name="DOCID"></p>
        <p><input type = "submit" name="sub2" value="submit"></p>
        </form>
        <h1>ADD READER</h1>
        <form action="exec.php" method = "post">
        <p>ReaderID: <input type="text" name="readerid"></p>
        <p>Rtype: <input type="text" name="rtype"></p>
        <p>Rname: <input type="text" name="rname"></p>
        <p>Address: <input type="text" name="address"></p>
        <p><input type = "submit" name="sub3" value="submit"></p>
        </form>
        <h1>SEARCH BRANCH</h1>
        <form action="exec.php" method = "post">
        <p>LibID: <input type="text" name="libid"></p>
        <p><input type = "submit" name="sub4" value="submit"></p>
        </form>
        <h1>Top 10 borrowers</h1>
        <form action="exec.php" method = "post">
        <p><input type = "submit" name="sub5" value="TOP 10 BORROWERS"></p>
        </form>
        <h1>Top 10 books</h1>
        <form action="exec.php" method = "post">
        <p><input type = "submit" name="sub6" value="TOP 10 BOOKS"></p>
        </form>
        <h1>Top 10 popular books</h1>
        <form action="exec.php" method = "post">
        <p><input type = "submit" name="sub7" value="POPULAR BOOKS"></p>
        </form>
        <h1>PRINT AVERAGE FINE</h1>
        <form action="exec.php" method = "post">
        <p><input type = "submit" name="sub8" value="AVG FINE"></p>
        </form>
    </body>
</html>