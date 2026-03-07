<?php
class login_model extends CI_Model
{
	function VALIDATE_USER($empl_id)
	{
		$sql   = "SELECT col_empl_cmid FROM tbl_employee_infos WHERE col_empl_cmid = ?";
		$query = $this->db->query($sql, array($empl_id));
		$query->next_result();
		return $query->result();
	}

	

	function GET_USER_EMAIL($username)
	{
		$this->db->select('id,col_empl_emai');
		$this->db->from('tbl_employee_infos');
		$this->db->where('col_user_name', $username);
		$query = $this->db->get();
		return $query->row();
	}

	

	function GET_USER_ACCESS_ID($id)
	{
		$sql   = "SELECT col_user_access FROM tbl_employee_infos WHERE id=?";
		$res   = $this->db->query($sql, array($id))->row_array();
		return $res["col_user_access"];
	}

	function GET_USER_ACCESS($id)
	{
		$sql   = "SELECT user_page FROM tbl_system_useraccess WHERE id=?";
		$res   = $this->db->query($sql, array($id))->row_array();
		return $res["user_page"];
	}

	function GET_USER_ID($empl_id)
	{
		$this->db->select('id,col_user_pass,col_salt_key,password_attempt');
		$arr_where_clause = array('col_empl_cmid' => $empl_id);
		$this->db->where($arr_where_clause);
		$query = $this->db->get('tbl_employee_infos');
		$ret   = $query->row();
		return $ret;
	}

	function LOGIN_USER($empl_id, $password, $salt_key)
	{

		$decrypted_password = md5($password . '' . $salt_key);
		$sql   = "SELECT id FROM tbl_employee_infos WHERE col_empl_cmid=? AND col_user_pass=?";
		$query = $this->db->query($sql, array($empl_id, $decrypted_password));
		$query->next_result();
		return $query->row()->id;
	}

	function CHECK_IF_EMAIL_EXIST($user_email)
	{
		$sql   = "SELECT * FROM tbl_employee_infos WHERE col_empl_emai=?";
		$query = $this->db->query($sql, array($user_email));
		$query->next_result();
		return $query->result();
	}

	function GET_USER_STATUS($user_id)
	{
		$this->db->select('real_pass');
		$arr_where_clause = array('id' => $user_id);
		$this->db->where($arr_where_clause);
		$query = $this->db->get('tbl_employee_infos');
		$ret   = $query->row();
		return (count($query->result()) > 0) ? $ret->real_pass : '';
	}

	function MOD_CHANGE_PASSWORD($new_password, $user_id)
	{
		$salt  = password_hash(uniqid(), PASSWORD_BCRYPT);
		$password = $new_password;
		$encrypted_password = password_hash($password . $salt, PASSWORD_BCRYPT);
		$sql   = "UPDATE tbl_employee_infos SET col_user_pass=?, real_pass=1,col_salt_key=? WHERE id=?";
		$query = $this->db->query($sql, array($encrypted_password, $salt, $user_id));
		return $query;
	}

	function MOD_UPDT_REAL_PASS($empl_id)
	{
		$sql   = "UPDATE tbl_employee_infos SET real_pass=0 WHERE id=?";
		$query = $this->db->query($sql, array($empl_id));
	}

	

	function GET_DISABLED($empl_id)
	{
		$sql    = "SELECT disabled FROM tbl_employee_infos where col_empl_cmid=?";
		$query  = $this->db->query($sql, array($empl_id));
		$result = $query->result_array();
		return $result[0]["disabled"];
	}

	function UPDATE_ATTEMPT($id, $isFail)
	{
		$sql    = "UPDATE tbl_employee_infos SET password_attempt=password_attempt+1 WHERE id=?";
		if (!$isFail) {
	       $sql = "UPDATE tbl_employee_infos SET password_attempt=0 WHERE id=?";
		}
		$query  = $this->db->query($sql, array($id));
	}

	function GET_IP_ADDRESS($ip_add)
	{
		$sql    = "SELECT ip_address FROM tbl_system_whitelist WHERE ip_address=? AND status='Active' AND is_deleted=0";
		$query  = $this->db->query($sql, array($ip_add));
		$query->next_result();
		return $query->num_rows();
	}

	

	function GET_USER_INFO($user_ID)
	{
		$sql   = "SELECT * FROM tbl_employee_infos WHERE id = ?";
		$query = $this->db->query($sql, array($user_ID));
		$query->next_result();
		return $query->result();
	}

	function MOD_DISP_PAY_SCHED()
	{
		$sql   = "SELECT * FROM tbl_payroll_period WHERE status='active' ORDER BY id desc";
		$query = $this->db->query($sql, array());
		$query->next_result();
		return $query->result();
	}

	function RECORD_SUCCESSFUL_LOGIN($empl_id)
	{
		$current_date = date('Y-m-d H:i:s');
		$sql   = "UPDATE tbl_employee_infos SET last_logged_in=? WHERE id=?";
		$query = $this->db->query($sql, array($current_date, $empl_id));
	}

	function ADD_SESS_PASS($data)
	{
		$this->db->insert('tbl_session', $data);
	}

	function GET_SESS_PASS($user_id, $sess, $current_date)
	{
		$this->db->select('id,code');
		$this->db->where('empl_id', $user_id);
		$this->db->where('code', $sess);
		$this->db->where('status', 'Active');
		$this->db->where("expiration >= '$current_date'");
		$query = $this->db->get('tbl_session');
		return $query->row();
	}

	function DELETE_SESS_PASS($user_id)
	{
		$this->db->where('empl_id', $user_id);
		$this->db->delete('tbl_session');
	}

	
 
}
