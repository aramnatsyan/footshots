<html>
<head> 

<?php
include 'config.php';
$timeline_type = $_GET['post_type'];
$timeline_id = $_GET['post_id'];
$actual_link = "http://".$_SERVER['HTTP_HOST'].'/fadmin';

$timelineDetail = mysqli_fetch_assoc(mysqli_query($con,"select post_caption,post_image_url from foot_posts where post_id='$timeline_id'"));
 
 

?>
<title><?php echo $timelineDetail['post_caption'];?> | Footshots</title>
 <meta content="width=device-width, initial-scale=1" name="viewport" />
  <meta content="<?php echo $timelineDetail['post_caption'];?>" name="description" />




  <meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta property="og:image" content="<?php echo $actual_link.'/footshot/'?><?php echo $timelineDetail['post_image_url']; ?>">
<meta property="og:image:type" content="image/png">
<!-- <meta property="og:image:width" content="200">
<meta property="og:image:height" content="200"> -->

</head>
<body>
	<?php 
	  
       $info= $_SERVER['HTTP_USER_AGENT'];

if( stristr($info,'iPad') )   { 
       echo '<script>window.location= "footshots://app/'.$timeline_type.'?post_id='.$timeline_id.'";</script>';
        echo '<script>window.location= "https://itunes.apple.com/au/";</script>';
       } 

       if( stristr($info,'iPhone') )   { 
       echo '<script>window.location= "footshots://app/'.$timeline_type.'?post_id='.$timeline_id.'";</script>';
         echo '<script>window.location= "https://itunes.apple.com/au/";</script>';
       } 

       

       if( stristr($info,'Android') )   { 
        
       echo '<script>window.location= "market://search?q=com.app.footshots&post_type='.$timeline_type.'&post_id='.$timeline_id.'";</script>'; 
       } 
 
         

 
//$this->Admin_model->add_analytics($device,$details->messges_id);
//$this->Admin_model->add_analytics('android',$details->messges_id);
//$this->Admin_model->add_analytics('web',$details->messges_id);


?>

<script type="text/javascript">

var IS_IPAD = navigator.userAgent.match(/iPad/i) != null,
IS_IPHONE = !IS_IPAD && ((navigator.userAgent.match(/iPhone/i) != null) || (navigator.userAgent.match(/iPod/i) != null)),
IS_IOS = IS_IPAD || IS_IPHONE,
IS_ANDROID = !IS_IOS && navigator.userAgent.match(/android/i) != null,
IS_MOBILE = IS_IOS || IS_ANDROID;
 
if(IS_IPAD||IS_IPHONE)
{   
	 window.location = "footshots://app/<?php echo $_GET['post_type']; ?>?post_id=<?php echo $_GET['post_id']; ?>";
  //window.location="cruiseculture://<?php echo $_GET['post_type'] ?>/<?php echo $_GET['timeline_id'] ?>";
  
} 
 
if(IS_MOBILE)
{
 
  window.location="market://search?q=com.app.footshots&post_type=<?php echo $_GET['post_type']; ?>&post_id=$_GET['post_id']";
}
else
{
	 
	 window.location= "footshots://app/<?php echo $_GET['post_type']; ?>?post_id=<?php echo $_GET['post_id']; ?>";
}
 

</script>
</body>
</html>