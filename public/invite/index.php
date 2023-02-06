<html>
<head> 
 <?php

 $type = $_GET['type'];
$action_id = $_GET['action_id'];
 $actual_link = "http://".$_SERVER['HTTP_HOST'];

?>
<title>chumsy</title>
 <meta content="width=device-width, initial-scale=1" name="viewport" />





  <meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta property="og:image:type" content="image/png">
<!-- <meta property="og:image:width" content="200">
<meta property="og:image:height" content="200"> -->

</head>
<body>
	<?php 
	  
      $info= $_SERVER['HTTP_USER_AGENT']; 

if( stristr($info,'iPad') )   { 

       //echo '<script>window.location= "chumsy://app/'.$type.'?action_id='.$action_id.'";</script>';
         echo '<script>window.location= "itms-apps://itunes.apple.com/";</script>';
		// $url = 'chumsy://app/'.$type.'?action_id='.$action_id;
		// $url1 = "itms-apps://itunes.apple.com/";
		// header("Location: $url");  
		// header("Location: $url1");  
       }

       if( stristr($info,'iPhone') )   
        { 
       // echo '<script>window.location= "chumsy://app/'.$type.'?action_id='.$action_id.'";</script>';
         echo '<script>window.location= "itms-apps://itunes.apple.com/";</script>';
         
        
       } 

       

       if( stristr($info,'Android') )   { 
        
       echo '<script>window.location= "market://search?q=com.app.chumsy&type='.$type.'&action_id='.$action_id.'";</script>'; 
       } 


  

?>

<script type="text/javascript">

var IS_IPAD = navigator.userAgent.match(/iPad/i) != null,
IS_IPHONE = !IS_IPAD && ((navigator.userAgent.match(/iPhone/i) != null) || (navigator.userAgent.match(/iPod/i) != null)),
IS_IOS = IS_IPAD || IS_IPHONE,
IS_ANDROID = !IS_IOS && navigator.userAgent.match(/android/i) != null,
IS_MOBILE = IS_IOS || IS_ANDROID;
 
if(IS_IPAD||IS_IPHONE)
{   
	 window.location = "chumsy://app/<?php echo $_GET['type']; ?>?action_id=<?php echo $_GET['action_id']; ?>";

  
} 
 
if(IS_MOBILE)
{
 
  window.location="market://search?q=com.app.chumsy&type=<?php echo $_GET['type']; ?>&action_id=$_GET['action_id']";
}
else
{
	  window.location = "chumsy://app/<?php echo $_GET['type']; ?>?action_id=<?php echo $_GET['action_id']; ?>";
}
 

</script>
</body>
</html>