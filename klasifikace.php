<!doctype html>
<html lang="cz">
<head>
	<meta charset="utf-8">

	<title>Lang Classifier</title>
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
<label for="classify_text">INSERT YOUR TEXT OF "UNKNOWN" LANGUAGE HERE:</label><br  />
<textarea name="classify_text" rows="15" cols="100" id="classify_text"></textarea><br  />
<input type="button" onclick="classify();" name="send" value="Classify" />

</body>
</html>