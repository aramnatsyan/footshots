<html>
<head> 
 <?php

 $type = $_GET['type'];
$email = $_GET['email'];
$password = $_GET['password'];
$thumbnail = $_GET['thumbnail'];
$actual_link = "http://".$_SERVER['HTTP_HOST'];

?>
<title>chumsy</title>
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta property="og:image:type" content="image/png">
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="chumsy" />
<meta property="og:description" content="Post Share" />
<meta property="og:url" content="<?php echo $thumbnail; ?>" />
<meta property="og:site_name" content="chumsy" />
<meta property="article:tag" content="Posts" />
<meta property="article:tag" content="Post Share" />
<meta property="article:section" content="Sharing posts" />
<meta property="article:published_time" content="<?php echo date('Y-m-d H:i:s')?>" />
<meta property="article:modified_time" content="<?php echo date('Y-m-d H:i:s')?>" />
<meta property="og:updated_time" content="<?php echo date('Y-m-d H:i:s')?>" />
<meta property="og:image" content="<?php echo $thumbnail; ?>" />
<meta property="og:image:secure_url" content="<?php echo $thumbnail; ?>" />
<meta property="og:image:width" content="504" />
<meta property="og:image:height" content="504" />
<meta name="twitter:card" content="chumsy" />
<meta name="twitter:description" content="Post Share" />
<meta name="twitter:title"content="chumsy" />
<meta name="twitter:image"content="<?php echo $thumbnail; ?>" />

<!-- <meta property="og:image:width" content="200">
<meta property="og:image:height" content="200"> -->
</head>
<body>
	<?php 
	  
      $info= $_SERVER['HTTP_USER_AGENT']; 

if( stristr($info,'iPad') )   { 
       echo '<script>window.location= "chumsy://app/'.$type.'?email='.$email.'&password='.$password.'";</script>';
        echo '<script>window.location= "itms-apps://itunes.apple.com/";</script>';
		// $url = 'chumsy://app/'.$type.'?email='.$email;
		// $url1 = "itms-apps://itunes.apple.com/";
		// header("Location: $url");  
		// header("Location: $url1");  
       }

       if( stristr($info,'iPhone') )   
        { 
       echo '<script>window.location= "chumsy://app/'.$type.'?email='.$email.'&password='.$password.'";</script>';
         echo '<script>window.location= "itms-apps://itunes.apple.com/";</script>';
         
		// $url = 'chumsy://app/'.$type.'?email='.$email;
		// $url1 = "itms-apps://itunes.apple.com/";
		// header("Location: $url");  
		// header("Location: $url1"); 
       } 

       

       if( stristr($info,'Android') )   { 
        
       echo '<script>window.location= "market://search?q=com.app.chumsy&type='.$type.'&email='.$email.'&password='.$password.'";</script>'; 
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
	 window.location = "chumsy://app/<?php echo $_GET['type']; ?>?email=<?php echo $_GET['email']; ?>&password=<?php echo $_GET['password']; ?>";

  
} 
 
if(IS_MOBILE)
{
 
  window.location="market://search?q=com.app.chumsy&type=<?php echo $_GET['type']; ?>&email=$_GET['email']&password=<?php echo $_GET['password']; ?>";
}
else
{
	  window.location = "chumsy://app/<?php echo $_GET['type']; ?>?email=<?php echo $_GET['email']; ?>&password=<?php echo $_GET['password']; ?>";
}
 

</script>
</body>
</html>