<?
    $con=mysqli_connect("localhost","theremyt_usr","regnantREG","theremyt_db");
    echo mysqli_fetch_row(mysqli_query($con,"select * from test"))[0];

    echo "<br><h1>I hope this is the last test commmit!</h1>";
?>
