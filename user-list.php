<?php 



if(isset($_GET['q'])){

	if($_GET['q']=='GivePlayerPremium'){
		$user = new User($db,$_GET['id']);
		$user->GivePlayerPremium($_GET['id'],$_GET['duration']);
	}

	if($_GET['q']=='GivePlayerPoints'){
		$user = new User($db,$_GET['id']);
		echo "<br/><h1>".$user->GivePlayerPoints($_GET['id'],$_GET['points'])."</h1>";
	}


}

$user->GetUsers(); 
?>