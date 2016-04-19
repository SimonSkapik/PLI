<?php

if(isset($_POST['result'])){
	$xml_name = $_POST['lang']."_data.xml";
	$xml_file = fopen($xml_name, 'a') or die("can't open file");
	fwrite($xml_file, $_POST['result']);
	fclose($xml_file);
	
	$text_name = $_POST['lang']."_data.txt";
	$text_file = fopen($text_name, 'a') or die("can't open file");
	fwrite($text_file, $_POST['result_text']);
	fclose($text_file);
}


?>


<!doctype html>
<html lang="cz">
<head>
	<meta charset="utf-8">

	<title>Web Crawler</title>
	<meta name="description" content="Web Crawler">
	<meta name="author" content="Simon Skapik, Pavel Dvorsky">

	<link rel="stylesheet" href="css/default.css">
	<script src="js/jquery-2.2.0.min.js"></script>
	<script src="js/jquery.xdomainajax.js"></script>
	<script src="js/script.js"></script>

  <!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body>
<!--<input type="text" id="url" name="url" value="http://zpravy.idnes.cz/domaci.aspx" />-->
<label>Base: </label><input type="text" id="base" name="base" value="http://www.clearadmit.com/category/news/page/" /><br> <!-- http://www.uni-europa.org/news/page/ -->
<label>From: </label><input type="text" id="start" name="start" value="2" /><br>
<label>To: </label><input type="text" id="stop" name="stop" value="20" /><br>
<input type="button" id="load" name="load" onclick="Load_EVERY_FUCKIN_THING($('#base').val(),parseInt($('#start').val()),parseInt($('#stop').val()));" value="Load" />
<form method="post" action="./">
	<textarea name="result" id="result"></textarea>
	<textarea name="result_text" id="result_text"></textarea>
	<input type="text" name="lang" value="english" />
	<input type="submit" name="send" value="Save" />
</form>
<div id="alpha"></div>

</body>
</html>