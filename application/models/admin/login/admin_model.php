<?php

class admin_model extends CI_Model

{
	function GET_ALL_USERS(){
		$sql="SELECT i.id, i.col_last_name, i.col_frst_name, i.col_midl_name, i.col_empl_posi, i.disabled, u.user_access
		FROM tbl_employee_infos AS i
		JOIN tbl_system_useraccess AS u ON i.col_user_access = u.id;";
		$query = $this->db->query($sql,array());
		$query->next_result();
		return $query->result();
	}

	function GET_EMPL_USERACCESS()
	{
		$sql="SELECT ";
		$query = $this->db->query($sql,array());
		$query->next_result();
		return $query->result();
	}

	function GET_ALL_POSITIONS(){
		$sql="SELECT id,name FROM tbl_std_positions";
		$query = $this->db->query($sql,array());
		$query->next_result();
		return $query->result();
	}

	function LOGIN_ADMIN($username,$password){
		$sql="SELECT id FROM tbl_system_user_admin WHERE username = ? AND password = ?";
		$query = $this->db->query($sql,array($username,$password));
		$query->next_result();
		return $query->result();
	}
	
	function GET_USER_DISABLED($user_id){
		$sql="SELECT id,disabled,termination_type FROM tbl_employee_infos WHERE id=?";
		$query = $this->db->query($sql,array($user_id));
		$result = $query->result_array();
		return $result[0];
	}

	// Removed tbl_system_setup functions:
	// - GET_NAME()
	// - get_logo()

}

?>