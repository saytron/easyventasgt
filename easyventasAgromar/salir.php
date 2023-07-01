<?php
error_reporting(E_ALL ^ E_NOTICE);
	@session_start();
	session_destroy();
	header("location: login.php");

?>