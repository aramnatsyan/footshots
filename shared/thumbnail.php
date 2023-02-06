<?php

$video = '../postimageupload/542/83_1572945479.mp4';
$thumbnail = '../postimageupload/542/thumbnail.jpg';
$output = '../postimageupload/542/11output.mp4';
$bitrate = "1200k";

// shell command [highly simplified, please don't run it plain on your script!]
//echo shell_exec("ffmpeg -i $video -deinterlace -an -ss 1 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $thumbnail 2>&1");
echo shell_exec("ffmpeg -i $video -b:v $bitrate -bufsize $bitrate $output");

   ?>