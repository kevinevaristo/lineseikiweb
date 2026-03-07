<?php
class api_model extends CI_Model
{
	function VALIDATE_USER($empl_id)
	{
		$sql   = "SELECT col_empl_cmid FROM tbl_employee_infos WHERE col_empl_cmid = ?";
		$query = $this->db->query($sql, array($empl_id));
		$query->next_result();
		return $query->result();
	}
	function GET_PENDING_MESSAGES()
	{
		$sql   = "SELECT 
		tbl_employee_infos.col_frst_name, 
		tbl_employee_infos.col_empl_emai,
		tbl_notifications.description,
		tbl_notifications.location
		FROM tbl_notifications
		JOIN tbl_employee_infos ON tbl_notifications.empl_id = tbl_employee_infos.id
		WHERE tbl_notifications.is_email = 0;";
		$query = $this->db->query($sql);
		$query->next_result();
		return $query->result();
	}
	function UPDATE_SENT_MESSAGES()
	{
		$sql   = "UPDATE tbl_notifications SET is_email = 1 WHERE is_email = 0;";
		$query = $this->db->query($sql);
	
	}	





}
