<?php
class League {
	private $db;
	private $username;
	private $id;
	private $max_in_group;
	private $email;
	private $is_logged = false;
	private $msg = array ();
	public $error;
	
	// Create a new user object
	public function __construct($db, $id = null) {
		$this->db = $db;
		$this->id = $id;
		return $this;
	}
	
	// Get username
	public function GetLeagues($startIndex = 0, $stopIndex = null) {
		$query = 'SELECT * FROM league ' . 'WHERE id >= ' . $startIndex . ' ';
		
		if ($stopIndex)
			$query .= 'AND id <= ' . $stopIndex;
		
		$result = $this->db->query ( $query );
		while ( $obj = $result->fetch_object () ) {
			$a [] = $obj;
		}
		
		return $a;
	}
	public function LeaveFromLeague($playerId) {
		$query = 'SELECT * FROM league ' . 'WHERE id = ' . $this->id . ' ';
		
		$obj = $this->db->query ( $query )->fetch_object ();
		
		if ((time () > $obj->end_time) || (time () < $obj->begin_time)) {
			
			$query = 'delete from league_group_users ' . 'WHERE user_id = ' . $playerId . ' and group_id IN (select id from league_groups where league_id=' . $this->id . ')';
			
			$this->db->query ( $query );
			return true;
		} else {
			$this->error = 'sorry, league runned';
			return false;
		}
	}
	public function GetPlayersInfo($startIndex = 0, $stopIndex = null) {
		$query = 'SELECT * FROM league_groups ' . 'WHERE league_id = ' . $this->id;
		
		$result = $this->db->query ( $query );
		
		while ( $obj = $result->fetch_object () ) {
			$a [] = $obj->id;
		}
		
		$ids = join ( "','", $a );
		
		$query = 'SELECT * FROM league_group_users where group_id in (\'' . $ids . '\')';
		
		$result = $this->db->query ( $query );
		
		while ( $obj = $result->fetch_object () ) {
			$users [] = $obj;
		}
		
		return $users;
	}
	public function JoinToLeague($playerId) {
		$user = new User ( $db, $playerId );
		$obj = $user->GetPlayerInfo ();
		
		if ($obj->block == 1) {
			$this->error = 'user blocked';
			return false;
		}
		$group_id = $this->GetCurrentGroup ();
		
		$query = 'insert into league_group_users (group_id, user_id) values(' . $group_id . ',' . $playerId . ')';
		$this->db->query ( $query ); // echo $group_id;
		
		return true;
	}
	public function GetCurrentGroup() {
		$query = 'SELECT * FROM league_groups ' . 'WHERE league_id = ' . $this->id . ' ';
		
		$obj = $this->db->query ( $query )->fetch_object ();
		
		if ($obj) {
			$group = $obj->id;
			// check count in group
			$query = 'SELECT * as count FROM league_group_users' . 'WHERE group_id = ' . $group . ' ';
			$res = $this->db->query ( $query );
			if ($res->num_rows > $this->max_in_group) {
				
				$group = $this->CreateNewGroup ();
			}
		} else {
			
			$group = $this->CreateNewGroup ();
		}
		
		return $group;
	}
	public function CreateNewGroup() {
		$query = 'insert into league_groups (league_id) values(' . $this->id . ')';
		$this->db->query ( $query );
		return $this->db->insert_id;
	}
	public function GetPlayersCount() {
		$query = 'SELECT count(id) as count FROM users ' . 'WHERE league = ' . $this->id . ' ';
		
		$result = $this->db->query ( $query );
		$obj = $result->fetch_object ();
		return $obj->count;
	}
	public function GetLeagueInfo() {
		$query = 'SELECT * FROM league ' . 'WHERE id = ' . $this->id . ' ';
		
		$result = $this->db->query ( $query );
		return $result->fetch_object ();
		
		while ( $obj = $result->fetch_object () ) {
			echo "<pre>";
			print_r ( $obj );
			echo "</pre>";
		}
	}
	public function CreateNew($data) {
		foreach ( $data as $key => $val ) {
			$keys [] = $key;
			
			if (is_string ( $val ))
				$val = '\'' . $val . '\'';
			
			$values [] = $val;
		}
		$query = 'insert into league (' . implode ( ',', $keys ) . ') values(' . implode ( ',', $values ) . ')';
		
		$this->db->query ( $query );
	}
	public function Update($data) {
		$info = '';
		foreach ( $data as $key => $val ) {
			
			if (is_string ( $val ))
				$val = '\'' . $val . '\'';
			
			if ($info != "")
				$info .= ',';
			$info .= $key . "=" . $val;
		}
		$query = 'update league set ' . $info . ' where id=' . $data ['id'];
		
		$this->db->query ( $query );
	}
	public function Delete($id) {
		$query = 'delete FROM league ' . 'WHERE id = ' . $id . ' ';
		
		$result = $this->db->query ( $query );
	}
}

?>