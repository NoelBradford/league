<?php

require_once('config/db.php');
require_once('classes/class.league.php');
require_once('classes/class.ladder.php');
require_once('classes/class.user.php');

$db = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if ($db->connect_errno) {
	echo 'Database connection problem: ' . $db->connect_errno;
	exit();
}

$league = new League($db);
$ladder = new Ladder($db);
$user = new User($db);
?>

<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="utf-8" />
<link rel="stylesheet" href="css/normalize.css" />
<link rel="stylesheet" href="css/style.css" />
</head>
<body>

<?php


	include('menu.php');

?>

<div id="wrapper" class="clearfix">