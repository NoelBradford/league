<?php 

$ladder->GetLadders(); 

if(isset($_GET['q'])){
	if($_GET['q']=='GetLadderInfo'){
		$league = new Ladder($db,$_GET['id']);
		$league->GetLadderInfo();
	}

	if($_GET['q']=='GetPlayersCount'){
		$league = new Ladder($db,$_GET['id']);
		echo "<br/><h1>".$league->GetPlayersCount()."</h1>";
	}


}

?>