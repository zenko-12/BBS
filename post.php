<?php // post.php

session_start();
require_once('init.php');

if (false === isset($_SESSION['user'])) {
	header("Location: login.php");
	exit;
}


echo 'ttttttt';

?>