<?php 

$league->GetLeagues(); 

if(isset($_GET['q'])){
	if($_GET['q']=='GetLeagueInfo'){
		$league = new League($db,$_GET['id']);
		$league->GetLeagueInfo();
	}

	if($_GET['q']=='GetPlayersCount'){
		$league = new League($db,$_GET['id']);
		echo "<br/><h1>".$league->GetPlayersCount()."</h1>";
	}


}

?>