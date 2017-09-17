
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
        $Vid = $_POST["vid"];
        $Vid = (int)$Vid;
    $query = "SELECT * FROM concepts WHERE concept = '$concept' AND vid = $Vid ";

}
$result = mysql_query($query);

if (mysql_num_rows($result) > 0) {
    while ($row = mysql_fetch_assoc($result)) {

    $vid = $row['vid'];
    $vid = (int)$vid;
    $startp = $row['startpoint'];
    $startp = (int)$startp;
    $duration = $row['duration'];
    $duration = (int)$duration;

    }
    
    $query1 = "SELECT youtube_id FROM videotbl WHERE vid = $vid";
    $result1 = mysql_query($query1);
    $id = mysql_fetch_assoc($result1);

    $videoid =  (string)$id['youtube_id'];
    echo $videoid;
    
    }



?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Video Player</title>
        <style type="text/css">
            .wd1 {
                width: 8em;
            }
            .ht1 {
                height: 4em;
            }
        </style>
    </head>
    <body>
      <!-- 1. The <iframe> (and video player) will replace this <div> tag. -->
        <br>
        <br>
        <b>Playlist</b> &nbsp; &nbsp;<br />
        <div id="player"></div>
        <hr />
        <span id='myplaylist'></span>
        <script>
            // 2. This code loads the IFrame Player API code asynchronously.
            var tag = document.createElement('script');

            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            // 3. This function creates an <iframe> (and YouTube player)
            //    after the API code downloads.
            var player;
            function onYouTubeIframeAPIReady() {
                    player = new YT.Player('player', {
                        height: '390', width: '640',
                        videoId: '<?php print $videoid; ?>',
                        
                        playerVars : {'autoplay' : 1},
                        
                        events: {
                            'onReady': onPlayerReady,
                            'onStateChange': onPlayerStateChange,
                        }
                    });
                }
            

            // 4. The API will call this function when the video player is ready.
            function onPlayerReady(event) {
                       player.loadVideoById({videoId:'<?php print $videoid; ?>',
                      startSeconds:<?php print $startp; ?> ,
                      endSeconds:<?php print $duration; ?>,
                      suggestedQuality:'large'});
            }

         // 5. The API calls this function when the player's state changes.
            //    The function indicates that when playing a video (state=1),
            //    the player should play for six seconds and then stop.
            function onPlayerStateChange(event) {
                if (event.data == YT.PlayerState.ENDED)
                {
  
                        
                    }

                    //  player.loadVideoById(video);
                }
            
            function stopVideo() {
                player.stopVideo();
            }
            function pauseVideo() {
                player.pauseVideo();
            }
        </script>
    </body>
</html>