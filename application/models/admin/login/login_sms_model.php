<?php

class login_sms_model extends CI_Model

{
    function login_sms($username,$password){
		$sql   ="SELECT id FROM tbl_system_user_sms WHERE username = ? AND password = ?";
		$query = $this->db->query($sql,array($username,$password));
		$query->next_result();
		return $query->result();
	}

}