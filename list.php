<html>
    
    <style>
        table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
 </style>
 <script src="http://code.jquery.com/jquery-3.2.1.js"></script>
 <script>
     var currentLesson = {lid:null,title:null};
     function AddLesson()
     {
         if($("#txtLesson").val()) {
         currentLesson.title =  $("#txtLesson").val();
         $.post('addlesson.php', JSON.stringify({title: currentLesson.title}))
         .done(function(data){  
             currentLesson.lid = Number(data);
             $("#lblCurrentLesson").text(currentLesson.title);
             $("#txtLesson").val("");
          })
         .fail(function(xhr, status, error) {
             alert("An error has occured while adding a lesson")
          });
      }
     }
     $(function(ready){
     $('#sltLessons').on('change', function() {
       currentLesson.lid =  $('#sltLessons :selected').val();
       currentLesson.title =  $('#sltLessons :selected').text();
       console.log( currentLesson.title);
       $("#lblCurrentLesson").text(currentLesson.title);
     })
    });
     
     function AddtoCurrentLesson(videoId){
         var lessonvideo = {vid: Number(videoId),lid:Number(currentLesson.lid),start:Number($("#txtStart"+videoId).val()),duration:Number($("#txtDuration"+videoId).val())};
         console.log(lessonvideo);
         if(lessonvideo.vid && lessonvideo.lid && lessonvideo.start && lessonvideo.duration)
         {
              $.post('addvideotolesson.php',JSON.stringify(lessonvideo) )
         .done(function(data){  
            $("#td"+videoId).html("Added to lesson already");
          })
         .fail(function(xhr, status, error) {
             alert("An error has occured while adding a video to lesson")
          });
         }
     }
 </script>
 <body>
     <div><input type="text" id="txtLesson"  placeholder="Enter a lesson name"><button onclick="AddLesson()">Add Lesson</button> </div>
 <br/>
 <strong>(or)</strong>
 <br/>
 <div>
 <p>Choose from existing lesson</p>
 <p>
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
    
$query1 = "Select lid,title from lessons";

$result2= mysql_query($query1);

if (mysql_num_rows($result2) > 0) {
    echo "<select id='sltLessons'>";
    while ($row = mysql_fetch_assoc($result2)) {
    echo "<option value='".$row["lid"]."'>".$row["title"]."</option>";
    }
    echo "</select>";
}
?>
     </p>
</div>
 <br/>
 <div><strong>Current Lesson : </strong><label id="lblCurrentLesson"></label></div>
 <br/>
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
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    $query = "SELECT videotbl.vid,title,GROUP_CONCAT(concept) concepts 
FROM videotbl 
LEFT OUTER JOIN concepts on videotbl.vid = concepts.vid
GROUP BY title
Order by videotbl.vid";
}

$result1 = mysql_query($query);

if (mysql_num_rows($result1) > 0) {
    echo "<table style='width:50%'>";
    echo "<tr>";
    echo "<th>Title</th>";
    echo "<th>Concepts</th>";
    echo "<th>Add to current lesson</th>";
    echo "</tr>";
    while ($row = mysql_fetch_assoc($result1)) {
    echo "<tr>";
    echo "<td>".$row["title"]."</td>";
    echo "<td>".$row["concepts"]."</td>";
    echo "<td id='td".$row["vid"]."'>"
    . "<p>start : <input id='txtStart".$row["vid"]."' type='text'></p>"
    . "<p>duration : <input id='txtDuration".$row["vid"]."' type='text'></p>"
    . "<button onclick=\"AddtoCurrentLesson('".$row["vid"]."')\">Add!</button></td>";
    echo "</tr>";
    }
    echo "</table>";
    
}
?>
        </body>
</html>
