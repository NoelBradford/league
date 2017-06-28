<?php 

include('header.php'); 


if($_GET['delete']){

		$user = new User($db);
		$user->Delete($_GET['delete']);


}
if($_GET['go_out_from_ladder']){

//echo "out";
$ladder = new Ladder($db,$_GET['lid']);
$res=$ladder->LeaveFromLadder($_GET['go_out_from_ladder']);

if($res){echo "<h1>success</h1>";}else{echo "<h1>".$ladder->error."</h1>";}
}

if($_GET['put_to_ladder']){
//print_r($_GET);
$ladder = new Ladder($db,$_GET['lid']);
$res=$ladder->JoinToLadder($_GET['put_to_ladder']);
if($res){echo "<h1>success</h1>";}else{echo "<h1>".$ladder->error."</h1>";}
}


if($_GET['put_to_league']){
//print_r($_GET);
$league = new League($db,$_GET['lid']);
$res=$league->JoinToLeague($_GET['put_to_league']);
if($res){echo "<h1>success</h1>";}else{echo "<h1>".$league->error."</h1>";}
}


if($_POST){

		$user = new User($db);

		if($_POST['id']!=''){

		$user->Update($_POST);	

			}else{

		$user->CreateNew($_POST);	

			}

}


// setup your table
$q='SELECT * FROM users';
if($_GET['id'])$q='SELECT * FROM users where id='.$_GET['id'];
$params = array('sql_query'=> $q,'search'=> $search,'multiple_search'=> $multiple_search,'items_per_page'=> $items_per_page,'sort'=> $sort,'page'=> $page,'total_items'=> $total_items,
'header'=> 'Login,Password,league,id,ladder,email,block,premium,points,level,matches,reserve_in_ladder','width'=> '25,40,,50',
'table_key'=>'id'

);



$ladder = new Ladder($db);
$list=$ladder->GetLadders();
$ladder_list='<select id="ladder_#COL4#">';
foreach($list as $key=>$val){
	if($val->end_time>time())$ladder_list.='<option value="'.$val->id.'">'.$val->id.'</option>';
}
$ladder_list.='</select>';

$league = new League($db);
$list=$league->GetLeagues();
$league_list='<select id="league_#COL4#">';
foreach($list as $key=>$val){
	if($val->end_time>time())$league_list.='<option value="'.$val->id.'">'.$val->id.'</option>';
}
$ladder_list.='</select>';

                                                                                                                                                                                                                                                             
$arr_extra_cols[0] = array(13,'Actions','45','<a href="?edit=#COL4#"><img src="images/icon-edit.gif" /></a><a href="?delete=#COL4#"><img src="images/icon-delete.gif" /></a><br/><a href="#" onClick="javascript:window.location=\'?put_to_ladder=#COL4#&lid=\'+$(\'#ladder_#COL4#\').val()">Put to ladder</a>'.$ladder_list.'<br/><br/><a href="#" onClick="javascript:window.location=\'?put_to_league=#COL4#&lid=\'+$(\'#league_#COL4#\').val()">Put to league</a>'.$league_list.'<br/>');

$params['extra_cols'] = $arr_extra_cols;

$ct->table($params);

// pass a pager to the class
$ct->pager = getCreativePagerLite('ct',$page,$ct->total_items,$ct->items_per_page);

$out_table=$ct->display();



echo $out_table; 

	if($_GET['edit']){
				$user = new User($db,$_GET['edit']);
				$obj=$user->GetPlayerInfo();
				//print_r($obj);
	}

?>
<form action="" method="post">

<table class="ct" id="ct"><thead>
<tr id="ct_sort"><th width="25" class="sort" onclick="ctSort('ct','1')">Login</th><th width="40" class="sort" onclick="ctSort('ct','2')">Password</th><th class="sort" onclick="ctSort('ct','3')">league</th><th width="50" class="sort" onclick="ctSort('ct','4')">id</th><th class="sort" onclick="ctSort('ct','5')">ladder</th><th class="sort" onclick="ctSort('ct','6')">email</th><th class="sort" onclick="ctSort('ct','7')">block</th><th class="sort" onclick="ctSort('ct','8')">premium</th><th class="sort" onclick="ctSort('ct','9')">points</th><th class="sort" onclick="ctSort('ct','10')">level</th><th class="sort" onclick="ctSort('ct','11')">matches</th><th class="sort" onclick="ctSort('ct','12')">reserve_in_ladder</th></tr>
</thead><tbody>
<tr class="odd">
<td width="25"><input type="text" name="login" value="<?=$obj->login?>"></td>
<td width="40"><input type="text" name="password" value="<?=$obj->password?>"></td>
<td><input type="text" name="league" value="<?=$obj->league?>"></td>
<td width="50"><input type="hidden" name="id" value="<?=$obj->id?>"></td>
<td><input type="text" name="ladder" value="<?=$obj->ladder?>"></td>
<td><input type="text" name="email" value="<?=$obj->email?>"></td>
<td><input type="text" name="block" value="<?=$obj->block?>"></td>
<td><input type="text" name="premium" value="<?=$obj->premium?>"></td>
<td><input type="text" name="points" value="<?=$obj->points?>"></td>
<td><input type="text" name="level" value="<?=$obj->level?>"></td>
<td><input type="text" name="matches" value="<?=$obj->matches?>"></td>
<td><input type="text" name="reserve_in_ladder" value="<?=$obj->reserve_in_ladder?>"></td>
</tr>
</tbody></table>
<br/><input type="submit">

</form>

<?
include('footer.php'); 

?>