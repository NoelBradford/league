<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

require_once('../config/db.php');
require_once('../classes/class.league.php');
require_once('../classes/class.ladder.php');
require_once('../classes/class.user.php');
$db = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if ($db->connect_errno) {
	echo 'Database connection problem: ' . $db->connect_errno;
	exit();
}


include_once('config.php');
include_once('functions.php');
include_once('creativeTable.php');
$ct=new CreativeTable();
?>

<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="utf-8" />
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<link rel="stylesheet" href="../css/normalize.css" />
<link rel="stylesheet" href="../css/style.css" />
<link rel="stylesheet" type="text/css" href="css/creative/style.css">
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/creative_table_ajax-1.3.min.js"></script>

</head>
<body>

<?php


	include('menu.php');

?>

<div id="wrapper" class="clearfix">