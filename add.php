
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
    
    $concept = $_POST["concepts"];
    
$myArray = explode(',', $concept);

$query = "INSERT INTO videotbl(title, youtube_id ,description) VALUES ('".$_POST["title"]."','".$_POST["url"]."','".$_POST["desc"]."')";
$result = mysql_query($query);

//echo "query1st";
//echo $result;
$query2 = "SELECT MAX(vid) FROM videotbl";
$result2 = mysql_query($query2);
$val = mysql_fetch_assoc($result2,0);

$v = (int)$val;
$v = $val[0];
    

for ($i = 0; $i < count($myArray); $i++) {
    $query3 = "INSERT INTO concepts(vid,concept) VALUES ($v,'$myArray[$i]')";
    $result3 = mysql_query($query3);
}

echo "<p>Your video has been successfully added</p>";
echo "<p><a href='addvideo.html'>Click here to add another video</a></p>";
echo "<a href='index.php'>Go back to home page</a></p>";
}
?>