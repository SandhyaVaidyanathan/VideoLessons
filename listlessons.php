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
     var currentPlayingLesson = {};
      var playlist = [];
        var player;
      
     function GetVideosForLesson(lid,title)
     {
         if(lid && title) {
             currentPlayingLesson.lid=lid
             currentPlayingLesson.title = title;
         $.get('getvideoforlessons.php?lid=' + lid)
         .done(function(data){  
             if(data.length > 0)
            {
                currentPlayingLesson.videos = JSON.parse(data);
                playlist =  currentPlayingLesson.videos;
               $("#spnLessonName").html(currentPlayingLesson.title);
               lstVideos
               var lsthtml = playlist.map(function(value){return "<li>" +value.title + "-" + value.youtube_id  + "</li>"}).join();
                $("#lstVideos").html(lsthtml);
               onYouTubeIframeAPIReady();
            }
            
          })
         .fail(function(xhr, status, error) {
             alert("An error has occured while playing a lesson")
          });
      }
     }
     
    
            // 2. This code loads the IFrame Player API code asynchronously.
            var tag = document.createElement('script');

            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  
            function onYouTubeIframeAPIReady() {
                if (playlist.length > 0) {
                    console.log(playlist);
                    player = new YT.Player('player', {
                        height: '390', width: '640',
                       // videoId: playlist[0].youtube_id,
                        events: {
                            'onReady': onPlayerReady,
                            'onStateChange': onPlayerStateChange,
                            'onError': onPlayerError
                        }
                    });
                   
                    //playlist = playlist.slice(1, (playlist.length));
                }
            }

            // 4. The API will call this function when the video player is ready.
            function onPlayerReady(event) {
                 var nextVideo = playlist[0];
                    player.loadVideoById({videoId: nextVideo.youtube_id,startSeconds: nextVideo.startpoint,endSeconds:nextVideo.duration});
                 event.target.playVideo();
            }

            function onPlayerError(event) {
                if (playlist.length == 0)
                    return;
                var nextVideo = playlist[0];
                if (nextVideo != '') {
                    player.loadVideoById({videoId: nextVideo.youtube_id,startSeconds: nextVideo.startpoint,endSeconds:nextVideo.duration});
                    playlist = playlist.slice(1, (playlist.length));
                }
            }

            // 5. The API calls this function when the player's state changes.
            //    The function indicates that when playing a video (state=1),
            //    the player should play for six seconds and then stop.
            function onPlayerStateChange(event) {
                if (event.data == YT.PlayerState.ENDED)
                {
                    if (playlist.length == 0)
                        return;
                    var nextVideo = playlist[0];
                    if (nextVideo != '') {
                        player.loadVideoById({videoId: nextVideo.youtube_id,startSeconds: nextVideo.startpoint,endSeconds:nextVideo.duration});
                        playlist = playlist.slice(1, (playlist.length));
                    }
                }
            }
            function stopVideo() {
                player.stopVideo();
            }
            function pauseVideo() {
                player.pauseVideo();
            }
            // Plays the currently cued/loaded video
            function playVideo() {
                player.playVideo();
            }

 </script>
 <body>
 
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
    
    $query = "Select * from lessons";
}

$result1 = mysql_query($query);

if (mysql_num_rows($result1) > 0) {
    echo "<table style='width:30%'>";
    echo "<tr>";
    echo "<th>Lesson Title</th>";
    echo "<th>Click to Play</th>";
    while ($row = mysql_fetch_assoc($result1)) {
    echo "<tr>";
    echo "<td>".$row["title"]."</td>";
    echo "<td><button onclick=\"GetVideosForLesson('".$row["lid"]."','".$row["title"]."')\">Play!</button></td>";
    echo "</tr>";
    }
    echo "</table>";
    
}
?>
     <br/>
     <p><b >Playlist</b>&nbsp;&nbsp;<span id="spnLessonName"></span></p>
        <div id="player"></div>
        <hr />
        <span id='myplaylist'></span>
         <ul id="lstVideos">
            
        </ul>
        </body>
</html>
