<?php
class Ladder {
	private $db;
	private $username;
	private $id;
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
	public function LeaveFromLadder($playerId) {
		$query = 'SELECT * FROM ladder ' . 'WHERE id = ' . $this->id . ' ';
		
		$obj = $this->db->query ( $query )->fetch_object ();
		
		// print_r($obj);
		if ((time () > $obj->end_time) || (time () < $obj->begin_time)) {
			
			$query = 'delete from ladder_users ' . 'WHERE user_id = ' . $playerId . ' and ladder_id=' . $this->id;
			// echo $query;
			$this->db->query ( $query );
			return true;
		} else {
			$this->error = 'sorry, ladder runned';
			return false;
		}
	}
	public function IsTemplate() {
		$query = 'SELECT * FROM ladder ' . 'WHERE id = ' . $this->id . ' ';
		
		$obj = $this->db->query ( $query )->fetch_object ();
		
		if ($obj->template > 0)
			return true;
		return false;
	}
	public function Repeat() {
		$query = "insert into ladder( `begin_time`, `end_time`, `description`, `is_for_premium`, `is_free`, `is_level_limited`, `avatar`, `is_match_limited`, `group_max`, `max_in_group`, `is_last`, `prizes`,`template` ) select `end_time`, `end_time`+`template`, `description`, `is_for_premium`, `is_free`, `is_level_limited`, `avatar`, `is_match_limited`, `group_max`, `max_in_group`, `is_last`, `prizes`,`template` from ladder where id=" . $this->id;
		
		$this->db->query ( $query );
		
		$query = 'update ladder set template = null' . ' WHERE id = ' . $this->id . ' ';
		
		$this->db->query ( $query );
	}
	public function Close() {
		$query = 'update ladder set status=3 ' . 'WHERE id = ' . $this->id . ' ';
		
		$this->db->query ( $query );
	}
	public function GetPrizesInfo() {
		$query = 'SELECT * FROM ladder ' . 'WHERE id = ' . $this->id . ' ';
		
		$obj = $this->db->query ( $query )->fetch_object ();
		
		return json_decode ( $obj->prizes );
	}
	public function JoinToLadder($playerId) {
		$user = new User ( $db, $playerId );
		$obj = $user->GetPlayerInfo ();
		
		if ($obj->block == 1) {
			$this->error = 'user blocked';
			return false;
		}
		
		$query = "insert ignore into ladder_users (ladder_id,user_id) values(" . $this->id . "," . $playerId . ")";
		
		$this->db->query ( $query );
		return true;
	}
	public function IsAllowJoin($playerId) {
		$user = new User ( $db, $playerId );
		$obj = $user->GetPlayerInfo ();
		
		if ($obj->block == 1) {
			$this->error = 'user blocked';
			return false;
		}
		
		return true;
	}
	public function IsPlayerInLadder($playerId) {
		$query = 'SELECT * FROM ladder_users ' . 'WHERE ladder_id = ' . $this->id . ' and user_id >' . $playerId;
		$result = $this->db->query ( $query );
		$count = mysql_num_rows ( $result );
		if ($count > 0)
			return true;
		
		return false;
	}
	public function GetPlayersInfo($startIndex = 0, $stopIndex = null) {
		$query = 'SELECT * FROM ladder_users ' . 'WHERE ladder_id = ' . $this->id . ' and user_id >' . $startIndex;
		
		if ($stopIndex)
			$query .= 'AND user_id <= ' . $stopIndex;
		$query .= ' order by points';
		// echo $query;
		$result = $this->db->query ( $query );
		
		while ( $obj = $result->fetch_object () ) {
			$a [] = $obj;
		}
		
		return $a;
	}
	// Get username
	public function GetLadders($startIndex = 0, $stopIndex = null) {
		$query = 'SELECT * FROM ladder ' . 'WHERE id >= ' . $startIndex . ' ';
		
		if ($stopIndex)
			$query .= 'AND id <= ' . $stopIndex;
		
		$result = $this->db->query ( $query );
		
		while ( $obj = $result->fetch_object () ) {
			$a [] = $obj;
		}
		
		return $a;
	}
	public function GetPlayersCount() {
		$query = 'SELECT count(id) as count FROM users ' . 'WHERE ladder = ' . $this->id . ' ';
		
		$result = $this->db->query ( $query );
		$obj = $result->fetch_object ();
		return $obj->count;
	}
	public function Delete($id) {
		$query = 'delete FROM ladder ' . 'WHERE id = ' . $id . ' ';
		
		$result = $this->db->query ( $query );
	}
	public function GetLadderInfo() {
		$query = 'SELECT * FROM ladder ' . 'WHERE id = ' . $this->id . ' ';
		
		$result = $this->db->query ( $query );
		return $result->fetch_object ();
	}
	public function CreateNew($data) {
		foreach ( $data as $key => $val ) {
			if ($key == 'id')
				continue;
			$keys [] = $key;
			
			if (is_string ( $val ))
				$val = '\'' . $val . '\'';
			
			$values [] = $val;
		}
		$query = 'insert into ladder (' . implode ( ',', $keys ) . ') values(' . implode ( ',', $values ) . ')';
		
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
		$query = 'update ladder set ' . $info . ' where id=' . $data ['id'];
		
		$this->db->query ( $query );
	}
	public function CreateNewTemplate($data) {
		foreach ( $data as $key => $val ) {
			if ($key == 'id')
				continue;
			$keys [] = $key;
			
			if (is_string ( $val ))
				$val = '\'' . $val . '\'';
			
			$values [] = $val;
		}
		$query = 'insert into ladder_template (' . implode ( ',', $keys ) . ') values(' . implode ( ',', $values ) . ')';
		echo $query;
		$this->db->query ( $query );
	}
	public function UpdateTemplate($data) {
		$info = '';
		foreach ( $data as $key => $val ) {
			
			if (is_string ( $val ))
				$val = '\'' . $val . '\'';
			
			if ($info != "")
				$info .= ',';
			$info .= $key . "=" . $val;
		}
		$query = 'update ladder_template set ' . $info . ' where id=' . $data ['id'];
		
		$this->db->query ( $query );
	}

	public function ApplyPlayerGame($playerId, $points) {
	}
}

?>