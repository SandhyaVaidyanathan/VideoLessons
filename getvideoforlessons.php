<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "videodb";

$con = mysqli_connect($dbhost, $dbuser, $dbpassword,$dbname);

if (!$con) {
    die('Could not connect: ' . mysql_error());
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    $query = "SELECT videotbl.vid,videotbl.title,videotbl.description,videotbl.youtube_id,lessonvid.startpoint,lessonvid.duration
FROM videotbl 
inner join lessonvid on videotbl.vid = lessonvid.vid and lessonvid.lid = ". $_GET['lid'].
" Order by videotbl.vid";
}

//echo $query;

$result1 = mysqli_query($con, $query);

$rows = array();
while ($row = mysqli_fetch_assoc($result1)) {
  $rows[] = $row;
}

echo json_encode($rows);

mysqli_close($con);
?>