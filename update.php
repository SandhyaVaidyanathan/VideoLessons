
<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "videodb";

$con = mysql_connect($dbhost, $dbuser, $dbpassword);

if (!$con) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db($dbname, $con);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $concept = $_POST["concept"];
    $startp = $_POST["start"];
    $startp = (int)$startp;
    $duration = $_POST["duration"];
    $duration = (int)$duration;
    
    
    $query = "UPDATE concepts SET startpoint = $startp, duration = $duration WHERE concept = '$concept' ";
    $result1 = mysql_query($query);
}

mysql_close($con);

echo "<p>Your concept has been successfully added</p>";
echo "<p><a href='updateconcepts.html'>Click here to update more concepts</a></p>";
echo "<a href='index.php'>Go back to home page</a></p>";

?>

