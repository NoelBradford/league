<?php
class User {
	private $db;
	
	// Create a new user object
	public function __construct($db, $id = null) {
		
		// session_start();
		$this->db = $db;
		$this->id = $id;
		return $this;
	}
	
	// Get username
	public function GetUsers($startIndex = 0, $stopIndex = null) {
		$query = 'SELECT * FROM users WHERE id >= ' . $startIndex . ' ';
		
		if ($stopIndex)
			$query .= 'AND id <= ' . $stopIndex;
		
		$result = $this->db->query ( $query );
		
		while ( $obj = $result->fetch_object () ) {
			$a [] = $obj;
		}
		
		return $a;
	}
	public function GetPlayerInfo() {
		$query = 'SELECT * FROM users WHERE id = ' . $this->id . ' ';
		
		$result = $this->db->query ( $query );
		$obj = $result->fetch_object ();
		return $obj;
	}
	public function GetPlayersCount() {
		$query = 'SELECT count(id) as count FROM users ' . 'WHERE User = ' . $this->id . ' ';
		
		$result = $this->db->query ( $query );
		$obj = $result->fetch_object ();
		return $obj->count;
	}
	public function GivePlayerPremium($id, $duration) {
		$duration = time () + $duration;
		$query = 'update users set premium=' . $duration . ' WHERE id = ' . $id;
		
		$this->db->query ( $query );
	}
	public function GivePlayerPoints($id, $points) {
		$query = 'update users set points=points+' . $points . ' WHERE id = ' . $id;
		
		$this->db->query ( $query );
	}
	public function GetUserInfo() {
		$query = 'SELECT * FROM users ' . 'WHERE id = ' . $this->id . ' ';
		
		$result = $this->db->query ( $query )->fetch_object ();
		
		return $result;
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
		$query = 'insert into users (' . implode ( ',', $keys ) . ') values(' . implode ( ',', $values ) . ')';
		// die($query);
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
		$query = 'update users set ' . $info . ' where id=' . $data ['id'];
		// die($query);
		$this->db->query ( $query );
	}
	public function Delete($id) {
		$query = 'delete FROM users ' . 'WHERE id = ' . $id . ' ';
		
		$result = $this->db->query ( $query );
	}
}

?>