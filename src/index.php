<?php
	$newURL = str_replace('index.php','homeWithoutTables.php',$_SERVER['PHP_SELF']);
	header('Location: '.$newURL);
	die();
?>