<?php 

include('header.php'); 

// setup your table

if($_GET['action']=='remove'){
	$league = new League($db,$_GET['list']);
	$res=$league->LeaveFromLeague($_GET['uid']);
	if($res){echo "<h1>success</h1>";}else{echo "<h1>".$league->error."</h1>";}
}


if($_GET['delete']){

		$league = new League($db);
		$league->Delete($_GET['delete']);


}


if($_POST){
		$league = new League($db);
		if($_POST['id']!=''){

		$league->Update($_POST);	

			}else{

		$league->CreateNew($_POST);	

			}


}





$params = array('sql_query'=> 'SELECT * FROM league','search'=> $search,'multiple_search'=> $multiple_search,'items_per_page'=> $items_per_page,'sort'=> $sort,'page'=> $page,'total_items'=> $total_items,
'header'=> 'id,begin_time,end_time,description,is_for_premium,is_free,is_level_limited,avatar,is_match_limited,group_max,max_in_group,is_last,prizes','width'=> '25,40,,50',
'table_key'=>'id'
);


$arr_extra_cols[0] = array(14,'Actions','45','<a href="?edit=#COL1#"><img src="images/icon-edit.gif" /></a><a href="?delete=#COL1#"><img src="images/icon-delete.gif" /></a><br/><a href="?list=#COL1#">Users</a>');

$params['extra_cols'] = $arr_extra_cols;




$ct->table($params);

// pass a pager to the class
$ct->pager = getCreativePagerLite('ct',$page,$ct->total_items,$ct->items_per_page);

$out_table=$ct->display();




if($_GET['edit']){

				$league = new League($db,$_GET['edit']);
				$obj=$league->GetLeagueInfo();

//				print_r($obj); die('ok');
	}

echo $out_table; 
?>
<form action="" method="post">
<table id="ct" class="ct"><thead><tr id="ct_sort"><th onclick="ctSort('ct','1')" class="sort" width="25">id</th><th onclick="ctSort('ct','2')" class="sort" width="40">begin_time</th><th onclick="ctSort('ct','3')" class="sort">end_time</th><th onclick="ctSort('ct','4')" class="sort" width="50">description</th><th onclick="ctSort('ct','5')" class="sort">is_for_premium</th><th onclick="ctSort('ct','6')" class="sort">is_free</th><th onclick="ctSort('ct','7')" class="sort">is_level_limited</th><th onclick="ctSort('ct','8')" class="sort">avatar</th><th onclick="ctSort('ct','9')" class="sort">is_match_limited</th><th onclick="ctSort('ct','10')" class="sort">group_max</th><th onclick="ctSort('ct','11')" class="sort">max_in_group</th><th onclick="ctSort('ct','12')" class="sort">is_last</th><th onclick="ctSort('ct','13')" class="sort">prizes</th></tr>
<tr id="ct_multiple_search" class="ct_multiple_search" style="display: none;"><th>
</th><th>
</th><th>
</th><th>
</th><th>
</th><th>
</th><th></th><th>
</th><th>
</th><th>
</th><th>
</th><th>
</th><th></th></tr></thead><tbody><tr class="odd">
<td width="25"><input type="hidden" name="id" value="<?=$obj->id;?>"></td>
<td width="40"><input type="date" name="begin_time" value="<?=$obj->begin_time;?>"></td>
<td><input type="date" name="end_time" value="<?=$obj->end_time;?>"></td>
<td width="50"><input type="text" name="description"  value="<?=$obj->description;?>"></td>
<td><input type="text" name="is_for_premium"  value="<?=$obj->is_for_premium;?>"></td>
<td><input type="text" name="is_free"  value="<?=$obj->is_free;?>"></td>
<td><input type="text" name="is_level_limited"  value="<?=$obj->is_level_limited;?>"></td>
<td><input type="text" name="avatar" value="<?=$obj->avatar;?>"></td>
<td><input type="text" name="is_match_limited"  value="<?=$obj->is_match_limited;?>"></td>
<td><input type="text" name="group_max"  value="<?=$obj->group_max;?>"></td>
<td><input type="text" name="max_in_group" value="<?=$obj->max_in_group;?>"></td>
<td><input type="text" name="is_last" value="<?=$obj->is_last;?>"></td>
<td><input type="text" name="prizes"  value="<?=$obj->prizes;?>"></td></tr></tbody></table>
<br/><input type="submit">
</form>

<?
	if($_GET['list']){
?>
  <h1>User List</h1>
<?

					$league = new League($db,$_GET['list']);
					$list=$league->GetPlayersInfo();
					if($list){
					foreach($list as $key=>$val){
					?>
					<div class="row">Group ID:<?=$val->group_id;?> ID:<a href="users.php?id=<?=$val->user_id;?>"><?=$val->user_id;?></a> Points:<?=$val->points;?><a href="?action=remove&uid=<?=$val->user_id;?>&list=<?=$_GET['list'];?>">Remove from league</a></div>
					<?
					}         }
	}

include('footer.php'); 

?>

