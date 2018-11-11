<?php
	$newURL = str_replace('index.php','home.html',$_SERVER['PHP_SELF']);
	header('Location: '.$newURL);
	die();
?>