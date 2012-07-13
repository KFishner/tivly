<?php
/* 
	Spark Ð Simple and Effective 
	Rev. 6
*/


// Replace the email address with the one that should receive the contact form inquiries.
define('TO_EMAIL', 'kevin@tivly.com');

// === You don't need to change anything else. ===



$aErrors = array();
$aResults = array();

/* Functions */

function stripslashes_if_required($sContent) {

    if(get_magic_quotes_gpc()) {
        return stripslashes($sContent);
    } else {
        return $sContent;
    }
}

function get_current_url_path() {

	$sPageUrl = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	$count = strlen(basename($sPageUrl));
	$sPagePath = substr($sPageUrl,0, -$count);
	return $sPagePath;
}

function output($aErrors = array(), $aResults = array()){ // Output JSON

	$bFormSent = empty($aErrors) ? true : false;
	$aCombinedData = array(
		'bFormSent' => $bFormSent,
		'aErrors' => $aErrors,
		'aResults' => $aResults
		);
		
	header('Content-type: application/json');
    echo json_encode($aCombinedData);
	exit;
}

// Check supported version of PHP
if (version_compare(PHP_VERSION, '5.2.0', '<')) { // PHP 5.2 is required for the safety filters used in this script

	$aErrors[] = 'Unsupported PHP version. <br /><em>Minimum requirement is 5.2.<br />Your version is '. PHP_VERSION .'.</em>';
	output($aErrors);
}


if (!empty($_POST)) { // Form posted?

	// Get a safe-sanitized version of the posted data
	$sFromEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	$sFromName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
	
	$sMessage  = 'User Signup:

';
foreach($_POST as $val){
$sMessage .= $val .'
';
}
	
	$sMessage .= "\r\n--\r\nEmail sent from ". get_current_url_path();
		
	$sHeaders  = "From: '$sFromName' <$sFromEmail>"."\r\n";
	$sHeaders .= "Reply-To: '$sFromName' <$sFromEmail>";
	
	if (filter_var($sFromEmail, FILTER_VALIDATE_EMAIL)) { // Valid email format?
	
		$bMailSent = mail(TO_EMAIL, "New inquiry from $sFromName", $sMessage, $sHeaders);
		if ($bMailSent) {
			$aResults[] = "Message sent, thank you!"; 
		} else {
			$aErrors[] = "Message not sent, please try again later.";
		}

	} else {
		$aErrors[] = 'Invalid email address.';
	}
} else { // Nothing posted
	$aErrors[] = 'Empty data submited.';
}

  
//output($aErrors, $aResults);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tivly - Loyalty in One Swipe</title>
    <link href="favicon.ico" rel="shortcut icon">

    
    <!-- Include CSS -->
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/jquery.fancybox.css" rel="stylesheet" type="text/css" media="screen" />

    <!-- Include Scripts -->	
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
    <script type="text/javascript" src="js/superfish.js"></script>
    <script type="text/javascript" src="js/jquery.color.js"></script>
    <script type="text/javascript" src="js/slides.min.js"></script>
    <script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>	
    <script type="text/javascript" src="js/custom.js"></script>
    
    <!-- Google Analytics -->	
    <script type="text/javascript">
    
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-32882337-1']);
      _gaq.push(['_trackPageview']);
    
      (function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
    <!-- Google Analytics -->

<!-- start Mixpanel -->
<script type="text/javascript">(function(c,a){var b,d,h,e;b=c.createElement("script");b.type="text/javascript";b.async=!0;b.src=("https:"===c.location.protocol?"https:":"http:")+'//api.mixpanel.com/site_media/js/api/mixpanel.2.js';d=c.getElementsByTagName("script")[0];d.parentNode.insertBefore(b,d);a._i=[];a.init=function(b,c,f){function d(a,b){var c=b.split(".");2==c.length&&(a=a[c[0]],b=c[1]);a[b]=function(){a.push([b].concat(Array.prototype.slice.call(arguments,0)))}}var g=a;"undefined"!==typeof f?g=
a[f]=[]:f="mixpanel";g.people=g.people||[];h="disable track track_pageview track_links track_forms register register_once unregister identify name_tag set_config people.set people.increment".split(" ");for(e=0;e<h.length;e++)d(g,h[e]);a._i.push([b,c,f])};a.__SV=1.1;window.mixpanel=a})(document,window.mixpanel||[]);
mixpanel.init("7ae3c4e4fd6abd8b7a861ee096120052");</script>
<!-- end Mixpanel -->
</head>

<body>
<script type="text/javascript">
    mixpanel.track("Landing Page Loaded")
</script>
<!-- START HEADER -->
<div id="header">

	<div class="container">
    
    
    	<!-- start primary nav -->
        <div class="header-right">
        
            <div id="primary-nav" class="header-right">
            
                <ul class="sf-menu">
                    <li class="current"><a href="index.html">Home</a></li>
		    <li><a href="#_" class="sublink" data-to=".pagination" style="color:#0099cc">Signup</a></li> 
                    <li>
                        <a href="#_">FAQ</a>
                        <ul>
                            <li><a href="faq.html">FAQ</a></li>
                            <li><a href="aboutus.html">About Us</a></li>
                        </ul>
                    </li>
                    <li><a href="contact.html">Contact</a></li>
		    <li><a href="merchants.html" style="color:#ff9966">|  Become a tivly Merchant</a></li>

                </ul>
                
            </div>
        
        </div><!-- end nav -->
        
        <!-- LOGO -->        
    	<a href="index.html" id="logo"><img src="images/logo.png" border="0" alt="WhiteBox Premium App Site Template" /></a>
        
        <br class="clear" />
        
    </div>
    
</div><!-- END HEADER -->


<!-- START MAIN CONTAINER -->
<div class="slider-wrapper">
    

    <!-- start slider -->  
    <div id="feature-slider">                
    
        <!-- start slides_container-->
        <div class="slides_container">
      
            
            <!-- start slide -->
            <div class="slide">
            
            	
                <div class="cloud-container">
                    <div class="cloud-icons"></div>
                    <img src="images/app-cloud.png" alt="app cloud" class="app-cloud" />
				</div>
                
                <br class="clear" />
                
			</div><!-- end slide -->
            
            
        
            <!-- start slide -->
            <div class="slide">
                        
                <div class="grid onehalf">
                
                  <h2 class="text-replace">Track your loyalty progress towards<span style="color:#ff9966"> the best rewards</span></h2>
                    
                    <p class="justify">All rewards are <strong>fully customizable</strong> from your favorite restaurants. <strong>Every time you swipe your card,</strong> watch your loyalty points grow and get closer to <strong>a free lunch, romantic dinner for 2, or a special tasting menu.</strong> Check out <strong style="color:#ff9966">screenshots</strong> to see how simple tivly is. Free lunch has never been easier.</p>
                    
                    <p><strong>Go ahead! Click one of the thumbnails to the right, <em>you won't be disappointed!</em></strong></p>
                                                                                
                </div>
                
                <div class="grid onehalf last">
                                
                	<ul class="screenshots">
                    	<li><a href="images/screens/scmyvenue.png" class="fancybox" rel="screens"><img src="images/screens/scmyvenuess.png" alt="screen1" /><span></span></a></li>
                    	<li><a href="images/screens/scredwood.png" class="fancybox" rel="screens"><img src="images/screens/scredwoodss.png" alt="screen2" /><span></span></a></li>
                    	<li><a href="images/screens/scmycre.png" class="fancybox" rel="screens"><img src="images/screens/scmycreds.png" alt="screen3" /><span></span></a></li>
                    	<li><a href="images/screens/screwards.png" class="fancybox" rel="screens"><img src="images/screens/screwardss.png" alt="screen4" /><span></span></a></li>
                    </ul><br class="clear"/>
                        
                </div>
                
            </div><!-- end slide -->
	    
            
            <!-- start slide -->
            <div class="slide">
                
		<h4 style="color:#ff9966">Share your favorite places</h4>
                <p class="grid onethird"><img src="images/screens/scshare.png" alt="screen1" /></p>
                <h4 style="color:#ff9966">Take your friends' recommendations</h4>
		<p class="grid onethird"><img src="images/screens/scfbpost.png" alt="screen1" /></p>
                <h4 style="color:#ff9966">Get rewarded and explore as VIPs</h4>
		<p class="grid onethird last"><img src="images/screens/scsharereward.png" style="width:295px" alt="screen1" /></p>


            
		<h2>Go social for even more rewards. Be a <strong style="color:#ff9966">loyal advocate</strong> for your favorite restaurants.</h2>
            </div><!-- end slide -->
            
                   
        </div><!-- end slide_container -->
        
        <a href="#_" class="prev" title="Previous Slide">Previous</a><a href="#_" class="next" title="Next Slide">Next</a>
                                         
    </div><!-- end slider -->    
    
        
    <br class="clear" />
    
</div><!-- END MAIN CONTAINER -->


<!-- start subscribe area -->
<div id="subscribe-area">

	<a id="sub-close" href="#_"><img src="images/close.png" alt="close" /></a>
    
    
	<!-- start container -->
	<div class="container">
        
        <h2>We're days away from launch!<br /><span>Sign up for updates</span></h2>
        
        <form id="subform" action="/" method="post">
        	
            <div class="form-input">
            	<label>Your Name:</label>
                <input name="sname" type="text" id="sname"/>
            </div>
            
          <div class="form-input">
            	<label>Email Address:</label>
              <input name="semail" type="text" id="semail"/>
            </div>
            
            <div class="form-input last">
                <input type="image" src="images/submit.png" name="submit" id="sub-submit" />
            </div>
            
        </form>
    
    </div><!-- end container -->
    
</div><!-- end subscribe area -->


<!-- start bottom content -->
<div id="bottom-content">


    <!-- start container -->
    <div class="container">
    
    	<h2 class="slide-break">Why Choose <span class="wb-logo">tivly</span> For Your Loyalty<br /><span class="wb-small">(other than saving money)</span></h2>
    
        <ul id="features">
        
            <li class="icon heart"><strong>Loyalty done simply</strong> - Sign up, connect your card, swipe and save. Your wallet will thank you for shedding loyalty cards and picking up cash.</li>
            
	    <li class="right icon tag"><strong>Rewards automatically on your credit card</strong> - Keep swiping your card at your favorite restaurants and tivly automatically loads rewards onto your card - just swipe to redeem.</li>
	    
	    <li class="icon refresh"><strong>Follow all your programs</strong> - Manage your loyalty at every restaurant. Know when you're close to a reward or when you need to frequent more often!</li>

	    <li class="right icon eat"><strong>Share your favorite restaurants</strong> - Send recommendations and discounts to friends through facebook, twitter, linkedIn, and email. When they take your recommendations, you get rewarded.</li>            
            
        </ul>
        
        <br class="clear" />
        
        
        <!-- start app store button area -->
        <div id="app-store">
		
        	<a href="#_" class="sublink" data-to=".pagination"><img src="images/signup-circle.png" alt="App Store" /></a> 
        
        </div><!-- end app store area -->
        
    </div><!-- end container -->

</div><!-- end bottom content -->


<!-- START FOOTER -->
<div id="footer">

	<div class="container">
    
    

    
    	<div id="footer-right">
        
            <a href="#" target="_blank" class="social facebook">Fan Us</a> <a href="https://twitter.com/tivlytweets" target="_blank" class="social twitter">Follow Us</a>
            
        </div>
    
		<a id="top" href="#">Top</a> | <a href="aboutus.html">About Us</a> | <a href="jobs.html">Jobs</a> | <a href="contact.html">Contact</a><br />
        &copy 2012 tivly Corporation<br />
        
        <br class="clear" />
    
  </div>
    
</div><!-- END FOOTER -->

</body>
</html>
