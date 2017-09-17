<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "videodb";

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $data = json_decode(file_get_contents("php://input"));
}

$con = mysqli_connect($dbhost, $dbuser, $dbpassword,$dbname);

if (!$con) {
    die('Could not connect: ' . mysql_error());
}


$lid = (int)$data->lid;
$vid = (int)$data->vid;
$start = (int)$data->start;
$duration = (int)$data->duration;

$query = "INSERT INTO lessonvid(vid,lid,startpoint,duration) VALUES($vid,$lid,$start,$duration)";       
$result = mysqli_query($con,$query);
if ($result) {
    $last_id = mysqli_insert_id($con);
    echo $last_id;
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($con);
}
mysqli_close($con);
?>