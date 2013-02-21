<?
session_start(); 

	$page = strtoupper($_GET["page"]);


	include "navfile.php";
	
	if(empty($title))
		$title = "Tag-a-long Expeditions - Utah White Water Rafting Vacations | Colorado River Rafting, Outdoor Adventures, Jetboating, Hiking, Mountain Biking, Jeep Tours, Kayaking, Canoeing and Cross Country Skiing in Moab Utah | 4x4 Canyonlands and Arches National Parks";
	if(empty($keywords))
		$keywords = "utah raft, colorado river white water rafting, raft the colorado river, extreme white water grand canyon rafting, outdoor adventures, cataract canyon, canyonland off road expeditions and tours, westwater canyon raft vacation, white water rafting, whitewater utah vacation, whitewater adventure, camping adventures, utah whitewater, colorado river adventure, moab utah, Utah vacations, moab jeep tours, moab 4x4 tours, jeep trail tours, mountain yurts for rent western usa, hiking tours, jet boat tours, jetboat cruise, green river adventure, canoe labryinth, canoe stillwater, sea kayak, jetboat shuttle, canoe shuttle, san juan, grand staircase escalante, arches national park, canyonlands national park, cross country skiing, la sal mountains, ski huts yurts cabins in la sal mountains, yurt";
	if(empty($desc))
		$desc = "Guided whitewater rafting vacations and outdoor adventures on the Colorado River in Cataract and Westwater Canyons, Green River in Desolation Canyon, and the San Juan River and 4x4 tours in Canyonlands and Arches National Parks and Grand Staircase/Escalante National Monument - Also offering canoe and sea kayak shuttles from the confluence of the Green and Colorado rivers via jetboat.";
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">

<head>

<!-- Bing code for verification -->
<meta name="msvalidate.01" content="079600CDB717038DD6599A99E4FDF4B8" />
<!-- end Bing code -->

<title><?php echo $title; ?></title>

<meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />

<meta name="verify-v1" content="yTN9XWxNx1mifYv97BRg6wMQ+TdLWTeuKYnd/AbBVFk=" />

<meta name="verify-v1" content="57Z48i4L9lVxPlwH4OwgxknHGS8u/WCR4GEOBvEZ4x8=" />

<meta name="msvalidate.01" content="B91A3E26CF6F6E6FA05D8E4FCF2DB3E8" />

<meta http-equiv="Content-Language" content="en-us" />

<meta name="description" content="<?php echo $desc; ?>" />

<meta name="keywords" content="<?php echo $keywords; ?>" />

<meta name="copyright" content="" />

<meta name="robots" content="index,follow" />

<meta name="revisit-after" content="14 days" />

<meta name="distribution" content="global" />

<link rel="StyleSheet" href="style.css" type="text/css" media="all" />

<!-- <link rel="shortcut icon" href="#" />	-->

<!-- Mobile -->
		<script language="javascript">
		var wpmredurl   = 'http://m.tagalong.com';
		var wpmreddays  = 1;
		var wpmredhours = 0;
		</script>
		<script language="javascript" type="text/javascript" src="http://tagalong.com/wpmobred.js"></script>
<!-- End Mobile -->

</head>

<body>

<div id="wrap">

<div id="header">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td width="70%"><div id="logo"><a href="index.php"><img src="images/logo_bg.gif" alt="Tag-A-Long River and Wilderness Expeditions exploring canyonlands and the colorado river" width="275" height="32" /></a><span style="font-size: 1.4em; font-weight:bold; font-style:italic; font-family:Arial, Helvetica, sans-serif; margin:6px 0 0 8px; color:#200;" >Utah River and Wilderness Expeditions since 1964</span></div><!-- /logo -->

</td>
        <td width="30%" align="right">
<!-- Site Search Box -->
<div id="cse" style="width: 100%;">Loading</div>
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript"> 
  google.load('search', '1', {language : 'en', style : google.loader.themes.ESPRESSO});
  google.setOnLoadCallback(function() {
    var customSearchOptions = {};  var customSearchControl = new google.search.CustomSearchControl(
      '017620292569982944346:cupdmkx92zq', customSearchOptions);
    customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
    customSearchControl.draw('cse');
  }, true);
</script>
<!-- End Search -->
</td>
    </tr>
</table>
<style type="text/css">
  .gsc-control-cse {
    font-family: Georgia, serif;
    border-color: #996633;
    background-color: #996633;
		padding:0px !important;
		margin:0px;
  }
  .gsc-control-cse .gsc-table-result {
    font-family: Georgia, serif;
  }
  input.gsc-input {
    border-color: #D3BCA1;
  }
  input.gsc-search-button {
    border-color: #300D00;
    background-color: #461200;
  }
  .gsc-tabHeader.gsc-tabhInactive {
    border-color: #A25B08;
    background-color: #A25B08;
  }
  .gsc-tabHeader.gsc-tabhActive {
    border-color: #461200;
    background-color: #461200;
  }
  .gsc-tabsArea {
    border-color: #461200;
  }
  .gsc-webResult.gsc-result,
  .gsc-results .gsc-imageResult {
    border-color: #FFFFFF;
    background-color: #FFFFFF;
  }
  .gsc-webResult.gsc-result:hover,
  .gsc-imageResult:hover {
    border-color: #FFFFFF;
    background-color: #FFFFFF;
  }
  .gsc-webResult.gsc-result.gsc-promotion:hover {
    border-color: #FFFFFF;
    background-color: #FFFFFF;
  }
  .gs-webResult.gs-result a.gs-title:link,
  .gs-webResult.gs-result a.gs-title:link b,
  .gs-imageResult a.gs-title:link,
  .gs-imageResult a.gs-title:link b {
    color: #950000;
  }
  .gs-webResult.gs-result a.gs-title:visited,
  .gs-webResult.gs-result a.gs-title:visited b,
  .gs-imageResult a.gs-title:visited,
  .gs-imageResult a.gs-title:visited b {
    color: #950000;
  }
  .gs-webResult.gs-result a.gs-title:hover,
  .gs-webResult.gs-result a.gs-title:hover b,
  .gs-imageResult a.gs-title:hover,
  .gs-imageResult a.gs-title:hover b {
    color: #950000;
  }
  .gs-webResult.gs-result a.gs-title:active,
  .gs-webResult.gs-result a.gs-title:active b,
  .gs-imageResult a.gs-title:active,
  .gs-imageResult a.gs-title:active b {
    color: #950000;
  }
  .gsc-cursor-page {
    color: #950000;
  }
  a.gsc-trailing-more-results:link {
    color: #950000;
  }
  .gs-webResult .gs-snippet,
  .gs-imageResult .gs-snippet,
  .gs-fileFormatType {
    color: #333333;
  }
  .gs-webResult div.gs-visibleUrl,
  .gs-imageResult div.gs-visibleUrl {
    color: #A25B08;
  }
  .gs-webResult div.gs-visibleUrl-short {
    color: #A25B08;
  }
  .gs-webResult div.gs-visibleUrl-short {
    display: none;
  }
  .gs-webResult div.gs-visibleUrl-long {
    display: block;
  }
  .gs-promotion div.gs-visibleUrl-short {
    display: none;
  }
  .gs-promotion div.gs-visibleUrl-long {
    display: block;
  }
  .gsc-cursor-box {
    border-color: #FFFFFF;
  }
  .gsc-results .gsc-cursor-box .gsc-cursor-page {
    border-color: #A25B08;
    background-color: #FFFFFF;
    color: #950000;
  }
  .gsc-results .gsc-cursor-box .gsc-cursor-current-page {
    border-color: #461200;
    background-color: #461200;
    color: #950000;
  }
  .gsc-webResult.gsc-result.gsc-promotion {
    border-color: #FEFEDC;
    background-color: #FFFFCC;
  }
  .gsc-completion-title {
    color: #950000;
  }
  .gsc-completion-snippet {
    color: #333333;
  }
  .gs-promotion a.gs-title:link,
  .gs-promotion a.gs-title:link *,
  .gs-promotion .gs-snippet a:link {
    color: #0000CC;
  }
  .gs-promotion a.gs-title:visited,
  .gs-promotion a.gs-title:visited *,
  .gs-promotion .gs-snippet a:visited {
    color: #0000CC;
  }
  .gs-promotion a.gs-title:hover,
  .gs-promotion a.gs-title:hover *,
  .gs-promotion .gs-snippet a:hover {
    color: #0000CC;
  }

  .gs-promotion a.gs-title:active,
  .gs-promotion a.gs-title:active *,
  .gs-promotion .gs-snippet a:active {
    color: #0000CC;
  }
  .gs-promotion .gs-snippet,
  .gs-promotion .gs-title .gs-promotion-title-right,
  .gs-promotion .gs-title .gs-promotion-title-right *  {
    color: #333333;
  }
  .gs-promotion .gs-visibleUrl,
  .gs-promotion .gs-visibleUrl-short {
    color: #A25B08;
  }</style>
  
<!-- End: Have Shane Help!!! -->


<div id="toprighttabs2"><ul><li><a href="index.php?page=contact">Contact Us</a></li><li><a href="index.php?page=sitemap">Site Map</a></li></ul></div>

<div class="clearfloats"><!-- --></div>

</div><!-- /header -->



<div id="wrap2">



<div id="sidebar">

<b class="ulc1"></b><b class="ulc2"></b><b class="ulc3"></b><b class="ulc4"></b><!-- rounded upper left corner on homepage -->



<div id="sidebar1">



<p class="homelink"><a href="index.php">Tag-A-Long Moab Home</a></p>



<div id="tripsbox">

<b class="tb1"></b><b class="tb2"></b><b class="tb3"></b><b class="tb4"></b>

<div id="tripsboxcontent">



<?php include "navbar.php" ?>



</div><!-- /tribsboxcontent -->

<b class="tb4"></b><b class="tb3"></b><b class="tb2"></b><b class="tb1"></b>

</div><!--/tripsbox -->

</div><!-- /sidebar1 -->

</div><!-- /sidebar -->

<div id="main">

<div id="toplinks">

<a href="index.php?page=about"><span style="color:#FFF;">ABOUT Tag-A-Long:</span></a> &nbsp; &nbsp;

<a href="index.php?page=why">WHY CHOOSE US?</a> &nbsp; <span style="color:#774;">|</span> &nbsp; 

<a href="index.php?page=guides">GUIDES</a> &nbsp; <span style="color:#774;">|</span> &nbsp; 

<a href="index.php?page=gear">GEAR</a> &nbsp; <span style="color:#774;">|</span> &nbsp; 

<a href="index.php?page=meals">MEALS</a> &nbsp; <span style="color:#774;">|</span> &nbsp; 

<a href="index.php?page=vessels">VESSELS &amp; VEHICLES</a> &nbsp; <span style="color:#774;">|</span> &nbsp; 

<a href="index.php?page=employment">EMPLOYMENT</a> &nbsp; <span style="color:#774;">|</span> &nbsp;

<!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=tagalong"><img src="http://s7.addthis.com/static/btn/sm-share-en.gif" width="83" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=tagalong"></script>
<!-- AddThis Button END -->

</div><!-- /toplinks -->



<!-- write java that chooses random image to load -->

<?php

$imglist='';

//$img_folder is the variable that holds the path to the banner images.

// see that you dont forget about the "/" at the end

$img_folder = "images/quotes/";

mt_srand((double)microtime()*1000);

//use the directory class

$imgs = dir($img_folder);

//read all files from the directory, checks if are images and ads them to a list (see below how to display flash banners)

while ($file = $imgs->read()) {

if (eregi("gif", $file) || eregi("jpg", $file) || eregi("png", $file))

$imglist .= "$file ";

} closedir($imgs->handle);

//put all images into an array

$imglist = explode(" ", $imglist);

$no = sizeof($imglist)-2;

//generate a random number between 0 and the number of images

$random = mt_rand(0, $no);

$image = $imglist[$random];

//display image

echo '<div><img src="'.$img_folder.$image.'" border=0 alt="quote" ></div>';

?>



<!-- <div><img src="images/quotes/nd2.png" alt="quote" /></div> -->

<div id="content2">

<!-- start content -->



<?php

	include "$include";

?>



</div><!-- /content -->



<!-- stop content -->



</div><!-- /main -->

<div class="clearfloats"><!-- --></div>

</div><!-- /wrap2 -->

</div><!-- /wrap -->

<div style="text-align:center; width:100%;">&copy; 2009 Tag-a-long Expeditions<br />All Rights Reserved</div>


<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7616731-2");
pageTracker._trackPageview();
} catch(err) {}</script>

</body>

</html>

