<?php

class login_payroll_model extends CI_Model

{
	function login_payroll($username, $password)
	{
		$sql   = "SELECT id FROM tbl_system_user_payroll WHERE username = ? AND password = ?";
		$query = $this->db->query($sql, array($username, $password));
		$query->next_result();
		return $query->result();
	} 
}
