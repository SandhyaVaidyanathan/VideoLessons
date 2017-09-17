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

$value = $data->title;

$checkQuery = "Select * from lessons where title = '".$value."'";
$result1 = mysqli_query($con,$checkQuery);

$query = "INSERT INTO lessons(title) VALUES('$value')";       
$result = mysqli_query($con,$query);

if ($result) {
    $last_id = mysqli_insert_id($con);
    echo $last_id;
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($con);
}
mysqli_close($con);
?>
