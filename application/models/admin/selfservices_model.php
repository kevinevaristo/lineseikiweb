<?php
class selfservices_model extends CI_Model
{
    function GET_MY_TEAM($user)
    {
        $sql = "SELECT 
        a.id,CONCAT(a.col_last_name,', ',a.col_frst_name,' ',LEFT(a.col_midl_name, 1),'.') AS name,
        a.col_imag_path AS image,
        a.col_empl_posi AS position,
        CONCAT(b.col_last_name,', ',b.col_frst_name,' ',LEFT(b.col_midl_name, 1),'.') AS reporting_to,
        b.col_imag_path as superior_image,
        b.col_empl_posi AS superior_position
        FROM tbl_employee_infos a
        LEFT JOIN tbl_employee_infos b 
        ON b.id=a.reporting_to  
        WHERE a.reporting_to = ? OR a.id = ?";

        $query = $this->db->query($sql, array($user,$user));
        return $query->result_array();
    }


    function GET_LEAVE_LIST($id,$row,$offset)                     //JERENZ: NO GET DATA LIST FOUND IN THE MAIN TABLE 02 CONTROLLER
    {
        $sql="SELECT * FROM tbl_leaves_assign WHERE empl_id = $id ORDER BY id DESC LIMIT $row OFFSET $offset";
        $query = $this->db->query($sql);
        $result = $query->result();
        
        return $result;

     
    }
   
    function GET_DATA_COUNT($id){
        $sql = "SELECT * FROM tbl_leaves_assign WHERE empl_id = $id";
        $query = $this->db->query($sql);
        // $query->next_result();
        return $query->num_rows();
    }
    function GET_IN_OUT_TYPE(){
 
        $sql = "SELECT value FROM tbl_system_setup WHERE id = 56";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["value"];    
    }
    function GET_EMPOLOYEES(){
        $this->db->select('id, col_empl_cmid,col_last_name,col_frst_name,col_midl_name')
        ->where('disabled',0)
        ->where('termination_date','0000-00-00');
        $query = $this->db->get('tbl_employee_infos');
        return $query->result_object();
    }
    function GET_EMPLOYEE_IDS(){
        $sql="SELECT id,col_empl_cmid FROM tbl_employee_infos";
        $query = $this->db->query($sql, array());
        return $query->result_array();
    }
    function GET_NOTIFICATIONS(){
        $sql="SELECT * FROM tbl_notifications";
        $query = $this->db->query($sql, array());
        return $query->result_array();
    }
    function GET_ACTIVITY_LOGS($user_id){
        $sql="SELECT * FROM tbl_activity_logs WHERE empl_id=? ORDER BY create_date DESC";
        $query = $this->db->query($sql, array($user_id));
        return $query->result_array();
    }
    function GET_USER_PASSWORD_KEYS($user_id){
        $sql = "SELECT col_user_pass,col_salt_key FROM tbl_employee_infos WHERE id=? Limit 1";
        $query = $this->db->query($sql,array($user_id))->row();
        return $query;
    }
    function check_password($password,$id,$salt){                               //JERENZ: NO CHECK PASSWORD FOUND IN THE SELF SERVICES CONTROLLER
        $decrypted_password = md5($password.''.$salt);
        $sql = "SELECT id FROM tbl_employee_infos WHERE id=? AND col_user_pass=? Limit 1";
        return $this->db->query($sql,array($id,$decrypted_password))->num_rows();
    }
    function MOD_CHANGE_PASSWORD($new_password, $user_id){
		$salt=bin2hex(openssl_random_pseudo_bytes(22));
        $encrypted_password = md5($new_password.''.$salt);
		$sql = "UPDATE tbl_employee_infos SET col_user_pass=?, real_pass=1,col_salt_key=? WHERE id=?";
		$query = $this->db->query($sql,array($encrypted_password, $salt,$user_id));
	}
    function FETCH_HOLIDAYS(){
        $sql = "SELECT name as title,DATE_FORMAT(col_holi_date,'%Y-%m-%d') AS start FROM tbl_std_holidays";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    function FETCH_MY_SCHEDULE($empl_id){
        $sql = "SELECT code as title, date as start FROM tbl_attendance_shiftassign INNER JOIN tbl_attendance_shifts ON tbl_attendance_shiftassign.shift_id = tbl_attendance_shifts.id WHERE empl_id =? ";
        $query = $this->db->query($sql, array($empl_id))->result_array();
        return $query;
    }

    function FETCH_EVENTS(){                    //JERENZ: NO FETCH EVENTS FOUND IN THE SELF SERVICES CONTROLLER
        $sql = "SELECT event_title as title,DATE_FORMAT(event_date_from,'%Y-%m-%dT08:00:00') AS start,DATE_FORMAT(event_date_to,'%Y-%m-%dT08:00:00') AS end FROM tbl_event";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    function GET_FILTERED_EMPLOYEELIST($offset,$row,$branch,$dept,$division,$section,$group,$team,$line){

        if($branch    == "all"){$branch     = "col_empl_branch";}
        if($dept      == "all"){$dept       = "col_empl_dept";}
        if($division  == "all"){$division   = "col_empl_divi";}
        if($section   == "all"){$section    = "col_empl_sect";}
        if($group     == "all"){$group      = "col_empl_group";}
        if($team      == "all"){$team       = "col_empl_team";}
        if($line      == "all"){$line       = "col_empl_line";}

        $sql = "SELECT tb1.id,reporting_to,col_empl_cmid,
        col_last_name,col_imag_path,col_midl_name,col_frst_name,tb2.name as position
        FROM tbl_employee_infos as tb1 
        LEFT JOIN tbl_std_positions as tb2 on tb1.col_empl_posi=tb2.id
        WHERE termination_date = '0000-00-00' AND disabled = 0
        AND col_empl_branch = $branch
        AND col_empl_dept = $dept
        AND col_empl_divi = $division
        AND col_empl_sect = $section
        AND col_empl_group = $group
        AND col_empl_team = $team
        AND col_empl_line = $line
        ORDER BY col_empl_cmid ASC
        LIMIT ".$offset.", ".$row." ";

        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function UPDATE_MY_TEAM($ids,$reporting_to){
        $data = array(
               'reporting_to' => $reporting_to
            );
        $this->db->where_in('id', $ids);
        return $this->db->update('tbl_employee_infos', $data);
    }
    function FETCH_TASKS($id){
        if($id){
            $sql = "SELECT task_title as title,CASE 
            WHEN DATE_FORMAT(task_date_to,'%H:%i:%S')='00:00:00' AND DATE_FORMAT(task_date_from,'%H:%i:%S')='00:00:00'
            THEN DATE_FORMAT(task_date_from,'%Y-%m-%d')
            ELSE  DATE_FORMAT(task_date_from,'%Y-%m-%dT%H:%i:%S')
            END AS start,
            CASE 
            WHEN DATE_FORMAT(task_date_to,'%H:%i:%S')='00:00:00' AND DATE_FORMAT(task_date_from,'%H:%i:%S')='00:00:00'
            THEN DATE_ADD(DATE_FORMAT(task_date_to,'%Y-%m-%d'),INTERVAL 1 DAY)
            ELSE  DATE_FORMAT(task_date_to,'%Y-%m-%dT%H:%i:%S')
            END AS end
            FROM tbl_employee_tasks WHERE employee_id=?";
        }
        else{
            $sql = "SELECT task_title as title,CASE 
            WHEN DATE_FORMAT(task_date_to,'%H:%i:%S')='00:00:00' AND DATE_FORMAT(task_date_from,'%H:%i:%S')='00:00:00'
            THEN DATE_FORMAT(task_date_from,'%Y-%m-%d')
            ELSE  DATE_FORMAT(task_date_from,'%Y-%m-%dT%H:%i:%S')
            END AS start,
            CASE 
            WHEN DATE_FORMAT(task_date_to,'%H:%i:%S')='00:00:00' AND DATE_FORMAT(task_date_from,'%H:%i:%S')='00:00:00'
            THEN DATE_ADD(DATE_FORMAT(task_date_to,'%Y-%m-%d'),INTERVAL 1 DAY)
            ELSE  DATE_FORMAT(task_date_to,'%Y-%m-%dT%H:%i:%S')
            END AS end
            FROM tbl_employee_tasks";
        }
        

        $query = $this->db->query($sql, array($id))->result_array();

        return $query;
    }

    function GET_TYPE()
    {
        $sql = "SELECT id,name FROM tbl_std_employeetypes";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_BRANCHES()
    {
        $sql = "SELECT id,name FROM tbl_std_branches";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_POSITION()
    {
        $sql = "SELECT id,name FROM tbl_std_positions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_DEPARTMENTS()
    {
        $sql = "SELECT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_DIVISIONS()
    {
        $sql = "SELECT id,name FROM tbl_std_divisions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_EMPL_NAMES($tableName){
        $query=$this->db->select('empl_id,col_frst_name,col_midl_name,col_last_name')
        ->from($tableName)
        ->join('tbl_employee_infos', 'tbl_employee_infos.id = '.$tableName.'.empl_id')
        ->like('status','Pending')
        ->group_by("empl_id")
        ->get()->result();
        return $query;
    }
    function GET_LEAVE_APPROVAL_STATUS($id){
        $this->db->select('tb1.id,tb1.leave_date,tb1.duration,tb1.status,tb1.create_date,tb1.remarks,tb1.attachment,
        tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,tb8.name as type,
        tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat
        ');
        $this->db->select(' CONCAT(tb2.col_last_name, ", ", tb2.col_frst_name, " ", LEFT(tb2.col_midl_name,1),".") as employee',false);
        $this->db->select('CONCAT(tb4.col_last_name, ", ", tb4.col_frst_name, " ", LEFT(tb4.col_midl_name,1),".") as approver1',false);
        $this->db->select('CONCAT(tb5.col_last_name, ", ", tb5.col_frst_name, " ", LEFT(tb5.col_midl_name,1),".") as approver2',false);
        $this->db->select('CONCAT(tb6.col_last_name, ", ", tb6.col_frst_name, " ", LEFT(tb6.col_midl_name,1),".") as approver3,',false);
        $this->db->select('CONCAT(tb7.col_last_name, ", ", tb7.col_frst_name, " ", LEFT(tb7.col_midl_name,1),".") as assigned_by,',false);
        $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,tb6.col_imag_path as approver_3_img');
        $this->db->from('tbl_leaves_assign as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_leave_approvers as tb3', 'tb1.empl_id      = tb3.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb3.approver_1a   = tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb3.approver_2a   = tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb3.approver_3a   = tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
        $this->db->join('tbl_std_leavetypes as tb8', 'tb1.type          = tb8.id', 'left');
        $this->db->where('tb1.id',$id);
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row();
    }
    function GET_OVERTIME_STATUS($id){
        $this->db->select('tb1.id,tb1.date_ot,tb1.hours,tb1.status,tb1.create_date,tb1.comment,
        tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,tb1.type,
        tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat
        ');
        $this->db->select(' CONCAT(tb2.col_last_name, ", ", tb2.col_frst_name, " ", LEFT(tb2.col_midl_name,1),".") as employee',false);
        $this->db->select('CONCAT(tb4.col_last_name, ", ", tb4.col_frst_name, " ", LEFT(tb4.col_midl_name,1),".") as approver1',false);
        $this->db->select('CONCAT(tb5.col_last_name, ", ", tb5.col_frst_name, " ", LEFT(tb5.col_midl_name,1),".") as approver2',false);
        $this->db->select('CONCAT(tb6.col_last_name, ", ", tb6.col_frst_name, " ", LEFT(tb6.col_midl_name,1),".") as approver3,',false);
        $this->db->select('CONCAT(tb7.col_last_name, ", ", tb7.col_frst_name, " ", LEFT(tb7.col_midl_name,1),".") as assigned_by,',false);
        $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,tb6.col_imag_path as approver_3_img');
        $this->db->from('tbl_overtimes as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_overtime_approvers as tb3', 'tb1.empl_id      = tb3.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb3.approver_1a   = tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb3.approver_2a   = tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb3.approver_3a   = tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
        $this->db->where('tb1.id',$id);
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row();
    }
    function GET_TIME_ADJUSTMENT($id){
        $this->db->select('tb1.id,tb1.date_adjustment,tb1.status,tb1.create_date,tb1.remarks,tb1.attachment,
        tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,tb1.shift_type,tb1.time_in_1,tb1.time_out_1,tb1.time_in_2,tb1.time_out_2,
        tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat
        ');
        $this->db->select(' CONCAT(tb2.col_last_name, ", ", tb2.col_frst_name, " ", LEFT(tb2.col_midl_name,1),".") as employee',false);
        $this->db->select('CONCAT(tb4.col_last_name, ", ", tb4.col_frst_name, " ", LEFT(tb4.col_midl_name,1),".") as approver1',false);
        $this->db->select('CONCAT(tb5.col_last_name, ", ", tb5.col_frst_name, " ", LEFT(tb5.col_midl_name,1),".") as approver2',false);
        $this->db->select('CONCAT(tb6.col_last_name, ", ", tb6.col_frst_name, " ", LEFT(tb6.col_midl_name,1),".") as approver3,',false);
        $this->db->select('CONCAT(tb7.col_last_name, ", ", tb7.col_frst_name, " ", LEFT(tb7.col_midl_name,1),".") as assigned_by,',false);
        $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,tb6.col_imag_path as approver_3_img');
        $this->db->from('tbl_attendance_adjustments as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_overtime_approvers as tb3', 'tb1.empl_id      = tb3.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb3.approver_1a   = tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb3.approver_2a   = tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb3.approver_3a   = tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
        $this->db->where('tb1.id',$id);
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row();
    }
    function GET_HOLIDAY_WORK_STATUS($id){
        $this->db->select('tb1.id,tb1.date,tb1.hours,tb1.status,tb1.create_date,tb1.comment,
        tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,tb1.type,
        tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat
        ');
        $this->db->select(' CONCAT(tb2.col_last_name, ", ", tb2.col_frst_name, " ", LEFT(tb2.col_midl_name,1),".") as employee',false);
        $this->db->select('CONCAT(tb4.col_last_name, ", ", tb4.col_frst_name, " ", LEFT(tb4.col_midl_name,1),".") as approver1',false);
        $this->db->select('CONCAT(tb5.col_last_name, ", ", tb5.col_frst_name, " ", LEFT(tb5.col_midl_name,1),".") as approver2',false);
        $this->db->select('CONCAT(tb6.col_last_name, ", ", tb6.col_frst_name, " ", LEFT(tb6.col_midl_name,1),".") as approver3,',false);
        $this->db->select('CONCAT(tb7.col_last_name, ", ", tb7.col_frst_name, " ", LEFT(tb7.col_midl_name,1),".") as assigned_by,',false);
        $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,tb6.col_imag_path as approver_3_img');
        $this->db->from('tbl_holidaywork as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_overtime_approvers as tb3', 'tb1.empl_id      = tb3.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb3.approver_1a   = tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb3.approver_2a   = tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb3.approver_3a   = tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
        $this->db->where('tb1.id',$id);
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row();
    }
    function GET_SECTIONS()
    {
        $sql = "SELECT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_GROUPS()
    {
        $sql = "SELECT id,name FROM tbl_std_groups";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    
    function GET_SYSTEM_SETTING($setting){
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
        
    }
    function GET_LINES()
    {
        $sql = "SELECT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_TEAMS()
    {
        $sql = "SELECT id,name FROM tbl_std_teams";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_GENDERS()
    {
        $sql = "SELECT id,name FROM tbl_std_genders";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_HMO()
    {
        $sql = "SELECT id,name FROM tbl_std_hmos";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SHIRT_SIZE()
    {
        $sql = "SELECT id,name FROM tbl_std_shirtsizes";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_MARITAL()
    {
        $sql = "SELECT id,name FROM tbl_std_maritalstatuses";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_NATIONALITY()
    {
        $sql = "SELECT id,name FROM tbl_std_nationalities";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_EDUCATION_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_education WHERE col_empl_id = $employee_id AND is_deleted = '0'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_SKILL_MATRIX_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_skillassign WHERE username = $employee_id AND is_deleted='0'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_SKILL_NAME()
    {
        $sql = "SELECT id,name FROM tbl_std_skillnames";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SKILL_LEVEL()
    {
        $sql = "SELECT id,name FROM tbl_std_skilllevels";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    // Display Employees
    function GET_EMPLOYEE_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEE_SPECIFIC_ROW($employee_id)
    {
        $sql = "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->row();
    }

    function GET_DEPENDENTS_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_dependents WHERE col_depe_empid=? AND is_deleted='0' ORDER BY col_depe_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function GET_EMERGENCY_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_emergency WHERE empid=? AND is_deleted='0' ORDER BY name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }
    function GET_DOCUMENTS_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_documents WHERE col_empl_id=? AND is_deleted='0'";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function GET_COMP_STRUCTURE(){
        $sql = "SELECT * FROM tbl_system_setup";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }


    // EMPLOYEE SKILLS 
    function MOD_INSRT_SKILL($employee_id, $skill, $level)
    {
        $sql = "INSERT INTO tbl_std_skillnames(
            col_empl_id,
            col_skill_name,
            col_skill_level) VALUES (?,?,?)";
        $query = $this->db->query($sql, array($employee_id, $skill, $level));
        return $this->db->insert_id();
    }

    // EMPLOYEE INFO
    function MOD_UPDT_EMPLOYEE_INFO($employee_id, $lastname, $middlename, $firstname, $birthday, $gender, $marital_status, $shirt_size, $nationality, $home_address, $current_address, $employee_key)
    {
        $sql = "UPDATE tbl_employee_infos SET col_empl_cmid=?,col_last_name=?,col_midl_name=?,col_frst_name=?,col_birt_date=?,col_empl_gend=?,col_mart_stat=?,col_shir_size=?,col_empl_nati=?,col_home_addr=?,col_curr_addr=? WHERE id=?";
        $query = $this->db->query($sql, array($employee_id, $lastname, $middlename, $firstname, $birthday, $gender, $marital_status, $shirt_size, $nationality, $home_address, $current_address, $employee_key));
    }

    // EMPLOYEE CONTACT
    function MOD_UPDT_EMPLOYEE_CONTACT($work_email, $personal_email, $work_number, $personal_number, $employee_key)
    {
        $sql = "UPDATE tbl_employee_infos SET col_comp_emai=?,col_empl_emai=?,col_comp_numb=?,col_mobl_numb=? WHERE id=?";
        $query = $this->db->query($sql, array($work_email, $personal_email, $work_number, $personal_number, $employee_key));
    }

    // EMPLOYEE SKILL
    function MOD_UPDT_SKILL($skill_name1, $skill_lvl1, $skill_name2, $skill_lvl2, $employee_id)
    {
        $sql = "UPDATE tbl_employee_infos SET skill_name1=?,skill_lvl1=?,skill_name2=?,skill_lvl2=? WHERE id=?";
        $query = $this->db->query($sql, array($skill_name1, $skill_lvl1, $skill_name2, $skill_lvl2, $employee_id));
    }

    function MOD_DLT_SKILL($skill_id)
    {
        $sql = "DELETE FROM tbl_std_skillnames WHERE id = ?";
        $query = $this->db->query($sql, array($skill_id));
    }

    function MOD_GET_SKILL_DATA($skill_id)
    {
        $sql = "SELECT * FROM tbl_std_skillnames WHERE id=?";
        $query = $this->db->query($sql, array($skill_id));
        $query->next_result();
        return $query->result();
    }
    

    function MOD_UPDT_EMPLOYEE_ID($sss, $hdmf, $philhealth, $tin, $drivers_license, $national_id, $passport, $employee_id)
    {
        $sql = "UPDATE tbl_employee_infos SET col_empl_sssc=?,col_empl_hdmf=?,col_empl_phil=?,col_empl_btin=?,col_empl_driv=?,col_empl_naid=?,col_empl_pass=? WHERE id=?";
        $query = $this->db->query($sql, array($sss, $hdmf, $philhealth, $tin, $drivers_license, $national_id, $passport, $employee_id));
    }

    function MOD_UPDT_JOB($hired_on, $end_on, $regularization_date, $employee_id)
    {
        $sql = "UPDATE tbl_employee_infos SET col_hire_date=?,col_endd_date=?,date_regular=? WHERE id=?";
        $query = $this->db->query($sql, array($hired_on, $end_on, $regularization_date, $employee_id));
    }

    // EMPLOYEE JOB
    function MOD_UPDT_EMPL_DETAILS($emp_type, $position, $department, $section, $groups, $line, $hmo, $hmo_number, $user_id)
    {
        $sql = "UPDATE tbl_employee_infos SET col_empl_type=?,col_empl_posi=?,col_empl_dept=?,col_empl_sect=?,col_empl_group=?,col_empl_line=?,col_empl_hmoo=?,col_empl_hmon=? WHERE id=?";
        $query = $this->db->query($sql, array($emp_type, $position, $department, $section, $groups, $line, $hmo, $hmo_number, $user_id));
    }

    // EMPLOYEE JOB - MONTHLY SALARY
    function MOD_UPDT_EMPL_SALARY_RATE($salary_rate, $salary_type, $user_id)
    {
        $sql = "UPDATE tbl_employee_infos SET salary_rate=?,salary_type=? WHERE id=?";
        $query = $this->db->query($sql, array($salary_rate, $salary_type, $user_id));
    }

    // EMPLOYEE DOCUMENT
    function MOD_INSRT_DOC($document_file, $document_name, $employee_id)
    {
        $sql = "INSERT INTO tbl_employee_documents(col_doc_file,col_doc_name,col_empl_id) VALUES (?,?,?)";
        $query = $this->db->query($sql, array($document_file, $document_name, $employee_id));
        return $this->db->insert_id();
    }

    // Delete Document
    function MOD_DLT_DOCU($document_id)
    {
        $sql = "DELETE FROM tbl_employee_documents WHERE id=?";
        $query = $this->db->query($sql, array($document_id));
    }

    // Add Emergency
    function MOD_INSRT_EMERGENCY($INSRT_EMER_EMPID, $INSRT_EMER_NAME, $INSRT_EMER_RELA, $INSRT_EMER_MNUM, $INSRT_EMER_WPHN, $INSRT_EMER_HPHN, $INSRT_EMER_ADDR)
    {
        $sql = "INSERT INTO tbl_employee_emergency (empid, name, relationship, mobile_number, work_phone, home_phone, current_address) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $query = $this->db->query($sql, array($INSRT_EMER_EMPID, $INSRT_EMER_NAME, $INSRT_EMER_RELA, $INSRT_EMER_MNUM, $INSRT_EMER_WPHN, $INSRT_EMER_HPHN, $INSRT_EMER_ADDR));
        return;
    }

    // Delete Emergency
    function MOD_DLT_EMERGENCY($DATA_ID)
    {
        $sql = "DELETE FROM tbl_employee_emergency WHERE id=?";
        $query = $this->db->query($sql, array($DATA_ID));
        return;
    }

    function MOD_GET_EMERGENCY_DATA($DATA_ID)
    {
        $sql = "SELECT * FROM tbl_employee_emergency WHERE id=?";
        $query = $this->db->query($sql, array($DATA_ID));
        $query->next_result();
        return $query->result();
    }

    function MOD_INSRT_DEPENDENTS($INSRT_DEPT_EMPID, $INSRT_DEPT_NAME, $INSRT_DEPT_BDAY, $INSRT_DEPT_GNDR, $INSRT_DEPT_RELA)
    {
        $sql = "INSERT INTO tbl_employee_dependents (col_depe_empid, col_depe_name, col_depe_bday, col_depe_gndr, col_depe_rela) VALUES (?, ?, ?, ?, ?)";
        $query = $this->db->query($sql, array($INSRT_DEPT_EMPID, $INSRT_DEPT_NAME, $INSRT_DEPT_BDAY, $INSRT_DEPT_GNDR, $INSRT_DEPT_RELA));
        return;
    }

    // Delete Dependents
    function MOD_DLT_DEPENDENTS($DATA_ID)
    {
        $sql = "DELETE FROM tbl_employee_dependents WHERE id=?";
        $query = $this->db->query($sql, array($DATA_ID));
        return;
    }
    // Display DEPENDENTS in Modal
    function MOD_GET_DEPENDENTS_DATA($DATA_ID)
    {
        $sql = "SELECT * FROM tbl_employee_dependents WHERE id=?";
        $query = $this->db->query($sql, array($DATA_ID));
        $query->next_result();
        return $query->result();
    }

    //Update Dependents
    function MOD_UPDT_DEPENDENTS($dep_name1, $dep_rel1, $dep_gend1, $dep_birth1, $dep_name2, $dep_rel2, $dep_gend2, $dep_birth2, $dep_name3, $dep_rel3, $dep_gend3, $dep_birth3, $dep_name4, $dep_rel4, $dep_gend4, $dep_birth4, $employee_id)
    {
        $sql = "UPDATE tbl_employee_infos SET dep_name1=?, dep_rel1=?, dep_gend1=?, dep_birth1=?, dep_name2=?, dep_rel2=?, dep_gend2=?, dep_birth2=?, dep_name3=?, dep_rel3=?, dep_gend3=?, dep_birth3=?, dep_name4=?, dep_rel4=?, dep_gend4=?, dep_birth4=? WHERE id=?";
        $query = $this->db->query($sql, array($dep_name1,  $dep_rel1,  $dep_gend1,  $dep_birth1,  $dep_name2,  $dep_rel2,  $dep_gend2,  $dep_birth2,  $dep_name3,  $dep_rel3,  $dep_gend3,  $dep_birth3,  $dep_name4,  $dep_rel4,  $dep_gend4,  $dep_birth4, $employee_id));
        return;
    }

    // Add Notes
    function MOD_INSRT_NOTES($INSRT_NOTE_CRBY, $INSRT_NOTE_CRDT, $INSRT_NOTE_DESC, $INSRT_NOTE_EMID)
    {
        $sql = "INSERT INTO tbl_empl_note (col_notes_created_by, col_notes_date_created, col_notes_desc, col_empl_id) VALUES (?, ?, ?, ?)";
        $query = $this->db->query($sql, array($INSRT_NOTE_CRBY, $INSRT_NOTE_CRDT, $INSRT_NOTE_DESC, $INSRT_NOTE_EMID));
        return;
    }

    // Delete Notes
    function MOD_DLT_NOTES($DATA_ID)
    {
        $sql = "DELETE FROM tbl_empl_note WHERE id=?";
        $query = $this->db->query($sql, array($DATA_ID));
        return;
    }

    function MOD_GET_NOTES_DATA($DATA_ID)
    {
        $sql = "SELECT * FROM tbl_empl_note WHERE id=?";
        $query = $this->db->query($sql, array($DATA_ID));
        $query->next_result();
        return $query->result();
    }

    function GET_SHIFT_LIST()
    {
        $sql = "SELECT * FROM tbl_attendance_shifts";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_EMPLOYEE($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    

    function MOD_DISP_EMPLOYEE_REMOTE_ATTENDANCE($userId)
    {
        $date = new DateTime("now");
        $currDate = $date->format('Y-m-d');
        $query = $this->db->select('*')->from('tbl_attendance_shiftassign')
            ->where('empl_id', $userId)
            ->where('DATE(date)', $currDate)
            ->get();
        return $query->result();
    }

    function INSERT_TIME_ADJUSTMENT($timeIn1, $timeOut1, $timeIn2, $timeOut2, $empl_id, $date){
        $sql = "INSERT INTO tbl_attendance_records (date, empl_id, time_in1, time_out1, time_in2, time_out2) VALUES (?,?,?,?,?,?)";
        $query = $this->db->query($sql,array($date, $empl_id, $timeIn1, $timeOut1, $timeIn2, $timeOut2));
    }

    function UPDATE_TIME_ADJUSTMENT($timeIn1, $timeOut1, $timeIn2, $timeOut2, $empl_id, $date){
        $sql = "UPDATE tbl_attendance_records SET time_in1=?, time_out1=?, time_in2=?, time_out2=? WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql, array($timeIn1, $timeOut1, $timeIn2, $timeOut2, $empl_id, $date));
    }

    function INSERT_ATTENDANCE_SHIFT_ASSIGN($shift_id, $empl_id, $date){
        $sql = "INSERT INTO tbl_attendance_shiftassign (empl_id, date, shift_id) VALUES (?,?,?)";
        $query = $this->db->query($sql,array($empl_id, $date, $shift_id));
    }

    function UPDATE_ATTENDANCE_SHIFT_ASSIGN($shift_id, $empl_id, $date){
        $sql = "UPDATE tbl_attendance_shiftassign SET shift_id=? WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql, array($shift_id, $empl_id, $date));
    }

    function IS_DUPLICATE_TIME_ADDJ($empl_id, $date){
        $sql = "SELECT id FROM tbl_attendance_records WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql,array($empl_id,$date));
        return $query->num_rows();
    }

    function IS_DUPLICATE_ATTENDANCE_SHIFTASSIGN($empl_id, $date){
        $sql = "SELECT id FROM tbl_attendance_shiftassign WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql,array($empl_id,$date));
        return $query->num_rows();
    }


    function IS_DUPLICATE_REMOTE($user_id){
        $date = new DateTime("now");
        $period = $date->format('Y-m-d');

        $sql = "SELECT id FROM tbl_attendance_records WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql,array($user_id,$period));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function GET_ATTENDANCE_DATA($user_id){
        $date = new DateTime("now");
        $period = $date->format('Y-m-d');

        $sql = "SELECT * FROM tbl_attendance_records WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql,array($user_id,$period));
        return $query->row();
    }


    function GET_EMPL_TIME_IN($empl_id, $current_date){                     //JERENZ: NO GET EMPL TIME IN FOUND IN THE SELF SERVICES
        $sql = "SELECT * FROM tbl_attendance_records where date=? AND empl_id=?";
        $query = $this->db->query($sql, array($current_date, $empl_id));
        return $query->row();
    }

    function UPDATE_EMPL_TIME_IN_1($empl_id, $current_date, $time, $time_address){
        $datetime = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_attendance_records (create_date,edit_date,edit_user, empl_id, date, time_in, time_in_address) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $query = $this->db->query($sql, array($datetime, $datetime,$empl_id,$empl_id, $current_date, $time, $time_address));
    }

    function UPDATE_EMPL_TIME_OUT_1($empl_id, $current_date, $time, $time_address){
        $datetime = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_records SET edit_date=?, time_out=?, time_out_address=? WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql, array($datetime, $time, $time_address, $current_date, $empl_id));
    }

    function UPDATE_EMPL_TIME_IN_2($empl_id, $current_date, $time, $time_address){
        $datetime = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_records SET edit_date=?, time_in2=?, time_in2_address=? WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql, array($datetime, $time, $time_address, $current_date, $empl_id));
    }

    function UPDATE_EMPL_TIME_OUT_2($empl_id, $current_date, $time, $time_address){
        $datetime = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_records SET edit_date=?, time_out2=?, time_out2_address=? WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql, array($datetime, $time, $time_address, $current_date, $empl_id));
    }

    function GET_APPROVED_TIME_ADJUSTMENT($id){
        $sql = "SELECT * FROM tbl_attendance_adjustments WHERE status = 'Approved' AND id=?";
        $query = $this->db->query($sql,array($id));
        // $query->next_result();
        return $query->row();
    }

    function GET_ATTENDANCE_SHIFT($code){
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE code=?";
        $query = $this->db->query($sql,array($code));
        return $query->row();
    }

    // Display WRK_SHFT in Modal
    function MOD_GET_WRK_SHFT_DATA($work_shift_id){                          //JERENZ: DISABLED IN THE SELF SERVICES CONTROLLER
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE id=?";
        $query = $this->db->query($sql,array($work_shift_id));
        $query->next_result();
        return $query->result();
    }

    //Update Notes
    function MOD_UPDT_NOTES($UPDT_NOTE_CRBY, $UPDT_NOTE_CRDT, $UPDT_NOTE_DESC, $UPDT_NOTE_EMID, $DATA_ID)
    {
        $sql = "UPDATE tbl_empl_note SET col_notes_created_by=?, col_notes_date_created=?, col_notes_desc=?, col_empl_id=? WHERE id=?";
        $query = $this->db->query($sql, array($UPDT_NOTE_CRBY, $UPDT_NOTE_CRDT, $UPDT_NOTE_DESC, $UPDT_NOTE_EMID, $DATA_ID));
        return;
    }

    // Update EDUCATION
    function MOD_UPDT_EDUCATION($school,$degree,$from_year,$to_year,$grade,$employee_id,$education_id){
        $sql = "UPDATE tbl_employee_education SET col_educ_school=?,col_educ_degree=?,col_educ_from_yr=?,col_educ_to_yr=?,col_educ_grade=? WHERE col_empl_id=? AND id=?";
        $query = $this->db->query($sql,array($school,$degree,$from_year,$to_year,$grade,$employee_id,$education_id));
    }

    // Delete EDUCATION
    function MOD_DLT_EDUCATION($education_id){
        $sql = "DELETE FROM tbl_employee_education WHERE id = ?";
        $query = $this->db->query($sql,array($education_id));
    }

    // Display EDUCATION in Modal
    function MOD_GET_EDUCATION_DATA($education_id){
        $sql = "SELECT * FROM tbl_employee_education WHERE id=?";
        $query = $this->db->query($sql,array($education_id));
        $query->next_result();
        return $query->result();
    }

    // Update LICENSE
    function MOD_UPDT_LICENSE($certificate_name,$issuer,$issued_on,$expires_on,$employee_id,$education_id){
        $sql = "UPDATE tbl_pers_lice SET col_cert_name=?,col_cert_issuer=?,col_cert_issued_on=?,col_cert_expires_on=? WHERE col_empl_id=? AND id=?";
        $query = $this->db->query($sql,array($certificate_name,$issuer,$issued_on,$expires_on,$employee_id,$education_id));
    }

    // Delete LICENSE
    function MOD_DLT_LICENSE($license_id){
        $sql = "DELETE FROM tbl_pers_lice WHERE id = ?";
        $query = $this->db->query($sql,array($license_id));
    }

    // Display LICENSE in Modal
    function MOD_GET_LICENSE_DATA($license_id){
        $sql = "SELECT * FROM tbl_pers_lice WHERE id=?";
        $query = $this->db->query($sql,array($license_id));
        $query->next_result();
        return $query->result();
    }

    // Display Asset Info
    function MOD_DISP_ASSET_INFO($asset_id){
        $sql = "SELECT * FROM tbl_asset_assign WHERE id=?";
        $query = $this->db->query($sql,array($asset_id));
        $query->next_result();
        return $query->result();
    }

    // Insert Asset data to transaction logs 
    function MOD_INSRT_ASSET_LOGS($assign_to,$user_id,$issued_on,$asset_id){
        $sql = "INSERT INTO tbl_asset_logs (col_assign_to,col_assign_by,col_issued_on,col_asset_item) VALUES (?,?,?,?)";
        $query = $this->db->query($sql,array($assign_to,$user_id,$issued_on,$asset_id));
        return $this->db->insert_id();
    }

    // Update Asset status
    function MOD_UPDT_ASSET_STATUS_TRANSFER($assign_to,$issued_on,$user_id,$asset_id){
        $sql = "UPDATE tbl_asset_assign SET col_asset_assigned_to=?,col_asset_assigned_by=?,col_asset_issued_on=?,col_asset_status=? WHERE id=?";
        $query = $this->db->query($sql,array($assign_to,$user_id,$issued_on,'in-use',$asset_id));
    }

    function MOD_UPDT_ASSET_LOGS($issued_on_key,$asset_id,$assign_to){
        $sql = "UPDATE tbl_asset_logs SET col_returned_on=? WHERE col_issued_on=? AND col_asset_item=? AND col_assign_to=?";
        $query = $this->db->query($sql,array(date('Y-m-d'),$issued_on_key,$asset_id,$assign_to));
    }

    function GET_LEAVE_ASSIGN(){
        $sql = "SELECT * FROM tbl_leaves_assign WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3')";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_OVERTIME_ASSIGN(){
        $sql = "SELECT * FROM tbl_overtimes WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3')";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_HOLIDAYWORK_ASSIGN(){
        $sql = "SELECT * FROM tbl_holidaywork WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3') ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_OVERTIME_APPROVALS($userId,$offset,$row,$company,$dept, $sec, $group, $line,$branch,$division,$team){
        $filter_q = "";
        if($dept){
            $filter_q .= " AND tbl_employee_infos.col_empl_dept=".$dept;
        }
        if($sec){
            $filter_q .= " AND tbl_employee_infos.col_empl_sect=".$sec;
        }
        if($group){
            $filter_q .= " AND tbl_employee_infos.col_empl_group=".$group;
        }
        if($line){
            $filter_q .= " AND tbl_employee_infos.col_empl_line=".$line;
        }
        if($branch){
            $filter_q .= " AND tbl_employee_infos.col_empl_branch=".$branch;
        }
        if($division){
            $filter_q .= " AND tbl_employee_infos.col_empl_divi=".$division;
        }
        if($team){
            $filter_q .= " AND tbl_employee_infos.col_empl_team=".$team;
        }
        $sql = "SELECT *, tbl_overtimes.empl_id as empl_id, tbl_overtimes.id as id FROM tbl_overtimes
        JOIN tbl_overtime_approvers ON tbl_overtime_approvers.empl_id = tbl_overtimes.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_overtimes.empl_id
        WHERE tbl_overtimes.status LIKE '%Pending%' ".$filter_q." AND (approver_1a = $userId OR approver_1b = $userId OR approver_2a = $userId OR approver_2b = $userId OR approver_3a = $userId  OR approver_3b = $userId) 
        ORDER BY tbl_overtimes.create_date DESC
        LIMIT ".$offset.", ".$row." ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
      }

      function GET_COUNT_OVERTIME_APPROVALS($userId,$company,$dept, $sec, $group, $line,$branch,$division,$team){
        $filter_q = "";
        if($dept){
            $filter_q .= " AND tbl_employee_infos.col_empl_dept=".$dept;
        }
        if($sec){
            $filter_q .= " AND tbl_employee_infos.col_empl_sect=".$sec;
        }
        if($group){
            $filter_q .= " AND tbl_employee_infos.col_empl_group=".$group;
        }
        if($line){
            $filter_q .= " AND tbl_employee_infos.col_empl_line=".$line;
        }
        if($branch){
            $filter_q .= " AND tbl_employee_infos.col_empl_branch=".$branch;
        }
        if($division){
            $filter_q .= " AND tbl_employee_infos.col_empl_divi=".$division;
        }
        if($team){
            $filter_q .= " AND tbl_employee_infos.col_empl_team=".$team;
        }
        $sql = "SELECT *, tbl_overtimes.empl_id as empl_id, tbl_overtimes.id as id FROM tbl_overtimes
        JOIN tbl_overtime_approvers ON tbl_overtime_approvers.empl_id = tbl_overtimes.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_overtimes.empl_id
        WHERE tbl_overtimes.status LIKE '%Pending%' ".$filter_q." AND (approver_1a = $userId OR approver_1b = $userId OR approver_2a = $userId OR approver_2b = $userId OR approver_3a = $userId  OR approver_3b = $userId) 
        ORDER BY tbl_overtimes.create_date DESC";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
      }

    function GET_LEAVE_APPROVALS($userId,$offset,$row,$dept, $sec, $group, $line,$branch,$division,$team){

        $filter_q = "";
        if($dept){
            $filter_q .= " AND tbl_employee_infos.col_empl_dept=".$dept;
        }
        if($sec){
            $filter_q .= " AND tbl_employee_infos.col_empl_sect=".$sec;
        }
        if($group){
            $filter_q .= " AND tbl_employee_infos.col_empl_group=".$group;
        }
        if($line){
            $filter_q .= " AND tbl_employee_infos.col_empl_line=".$line;
        }
        if($branch){
            $filter_q .= " AND tbl_employee_infos.col_empl_branch=".$branch;
        }
        if($division){
            $filter_q .= " AND tbl_employee_infos.col_empl_divi=".$division;
        }
        if($team){
            $filter_q .= " AND tbl_employee_infos.col_empl_team=".$team;
        }
        $sql = "SELECT *, tbl_leaves_assign.empl_id as empl_id, tbl_leaves_assign.id as id FROM tbl_leaves_assign
        JOIN tbl_leave_approvers ON tbl_leave_approvers.empl_id = tbl_leaves_assign.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_leaves_assign.empl_id
        WHERE tbl_leaves_assign.status LIKE '%Pending%' ".$filter_q." AND (approver_1a = $userId OR approver_1b = $userId OR approver_2a = $userId OR approver_2b = $userId OR approver_3a = $userId  OR approver_3b = $userId) 
        ORDER BY tbl_leaves_assign.create_date DESC
        LIMIT ".$offset.", ".$row." ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_LEAVE_APPROVALS($userId,$dept, $sec, $group, $line,$branch,$division,$team){
        $filter_q = "";
        if($dept){
            $filter_q .= " AND tbl_employee_infos.col_empl_dept=".$dept;
        }
        if($sec){
            $filter_q .= " AND tbl_employee_infos.col_empl_sect=".$sec;
        }
        if($group){
            $filter_q .= " AND tbl_employee_infos.col_empl_group=".$group;
        }
        if($line){
            $filter_q .= " AND tbl_employee_infos.col_empl_line=".$line;
        }
        if($branch){
            $filter_q .= " AND tbl_employee_infos.col_empl_branch=".$branch;
        }
        if($division){
            $filter_q .= " AND tbl_employee_infos.col_empl_divi=".$division;
        }
        if($team){
            $filter_q .= " AND tbl_employee_infos.col_empl_team=".$team;
        }
        $sql = "SELECT *, tbl_leaves_assign.empl_id as empl_id, tbl_leaves_assign.id as id FROM tbl_leaves_assign
        JOIN tbl_leave_approvers ON tbl_leave_approvers.empl_id = tbl_leaves_assign.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_leaves_assign.empl_id
        WHERE tbl_leaves_assign.status LIKE '%Pending%' ".$filter_q." AND (approver_1a = $userId OR approver_1b = $userId OR approver_2a = $userId OR approver_2b = $userId OR approver_3a = $userId  OR approver_3b = $userId) 
        ORDER BY tbl_leaves_assign.create_date DESC";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_HOLIDAYWORK_APPROVALS($userId,$offset,$row,$dept, $sec, $group, $line,$branch,$division,$team){
        $filter_q = "";
        if($dept){
            $filter_q .= " AND tbl_employee_infos.col_empl_dept=".$dept;
        }
        if($sec){
            $filter_q .= " AND tbl_employee_infos.col_empl_sect=".$sec;
        }
        if($group){
            $filter_q .= " AND tbl_employee_infos.col_empl_group=".$group;
        }
        if($line){
            $filter_q .= " AND tbl_employee_infos.col_empl_line=".$line;
        }
        if($branch){
            $filter_q .= " AND tbl_employee_infos.col_empl_branch=".$branch;
        }
        if($division){
            $filter_q .= " AND tbl_employee_infos.col_empl_divi=".$division;
        }
        if($team){
            $filter_q .= " AND tbl_employee_infos.col_empl_team=".$team;
        }
        $sql = "SELECT *, tbl_holidaywork.empl_id as empl_id, tbl_holidaywork.id as id FROM tbl_holidaywork
        JOIN tbl_overtime_approvers ON tbl_overtime_approvers.empl_id = tbl_holidaywork.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_holidaywork.empl_id
        WHERE tbl_holidaywork.status LIKE '%Pending%' ".$filter_q." AND (approver_1a = $userId OR approver_1b = $userId OR approver_2a = $userId OR approver_2b = $userId OR approver_3a = $userId  OR approver_3b = $userId) 
        ORDER BY tbl_holidaywork.create_date DESC 
        LIMIT ".$offset.", ".$row." ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_HOLIDAYWORK_APPROVALS($userId,$dept, $sec, $group, $line,$branch,$division,$team){
        $filter_q = "";
        if($dept){
            $filter_q .= " AND tbl_employee_infos.col_empl_dept=".$dept;
        }
        if($sec){
            $filter_q .= " AND tbl_employee_infos.col_empl_sect=".$sec;
        }
        if($group){
            $filter_q .= " AND tbl_employee_infos.col_empl_group=".$group;
        }
        if($line){
            $filter_q .= " AND tbl_employee_infos.col_empl_line=".$line;
        }
        if($branch){
            $filter_q .= " AND tbl_employee_infos.col_empl_branch=".$branch;
        }
        if($division){
            $filter_q .= " AND tbl_employee_infos.col_empl_divi=".$division;
        }
        if($team){
            $filter_q .= " AND tbl_employee_infos.col_empl_team=".$team;
        }
        $sql = "SELECT *, tbl_holidaywork.empl_id as empl_id, tbl_holidaywork.id as id FROM tbl_holidaywork
        JOIN tbl_overtime_approvers ON tbl_overtime_approvers.empl_id = tbl_holidaywork.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_holidaywork.empl_id
        WHERE tbl_holidaywork.status LIKE '%Pending%' ".$filter_q." AND (approver_1a = $userId OR approver_1b = $userId OR approver_2a = $userId OR approver_2b = $userId OR approver_3a = $userId  OR approver_3b = $userId) 
        ORDER BY tbl_holidaywork.create_date DESC ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }
    function GET_TIME_ADJ($id){
        $this->db->select('tb1.id,tb1.date_adjustment,tb1.empl_id,tb1.assigned_by as assigned_by_id,tb1.remarks,tb1.reason,tb1.attachment,
        tb1.time_in_1,tb1.time_out_1,tb1.time_in_2,tb1.time_out_2,tb1.status,tb1.shift_type');
        $this->db->select("CONCAT(tb2.col_empl_cmid,'-',tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(tb2.col_midl_name,1)) as employee ",false);
        $this->db->select("CONCAT(tb3.col_empl_cmid,'-',tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(tb3.col_midl_name,1)) as assigned_by ",false)
        ->from('tbl_attendance_adjustments as tb1')
        ->join('tbl_employee_infos as tb2','tb1.empl_id=tb2.id','left')
        ->join('tbl_employee_infos as tb3','tb1.assigned_by=tb3.id','left')
        ->where('tb1.id',$id);
        $query=$this->db->get();
        return $query->row();
    }
    function UPDATE_TIME_ADJ($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('tbl_attendance_adjustments',$data);
    }

    // ATTENDANCE TIME ADJUSTMENT APPROVALS
    function GET_TIME_ADJUSTMENT_APPROVALS($userId,$offset,$row,$company,$dept, $sec, $group, $line,$branch,$division,$team){

        $filter_q = "";
        if($company){
            $filter_q .= " AND tbl_employee_infos.col_empl_company=".$company;
        }
        if($dept){
            $filter_q .= " AND tbl_employee_infos.col_empl_dept=".$dept;
        }
        if($sec){
            $filter_q .= " AND tbl_employee_infos.col_empl_sect=".$sec;
        }
        if($group){
            $filter_q .= " AND tbl_employee_infos.col_empl_group=".$group;
        }
        if($line){
            $filter_q .= " AND tbl_employee_infos.col_empl_line=".$line;
        }
        if($branch){
            $filter_q .= " AND tbl_employee_infos.col_empl_branch=".$branch;
        }
        if($division){
            $filter_q .= " AND tbl_employee_infos.col_empl_divi=".$division;
        }
        if($team){
            $filter_q .= " AND tbl_employee_infos.col_empl_team=".$team;
        }
        
        $sql = "SELECT *, tbl_attendance_adjustments.empl_id as empl_id, tbl_attendance_adjustments.id as id FROM tbl_attendance_adjustments
        JOIN tbl_overtime_approvers ON tbl_overtime_approvers.empl_id = tbl_attendance_adjustments.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_attendance_adjustments.empl_id
        WHERE tbl_attendance_adjustments.status LIKE '%Pending%' " .$filter_q. " AND (approver_1a = $userId OR approver_1b = $userId OR approver_2a = $userId OR approver_2b = $userId OR approver_3a = $userId  OR approver_3b = $userId) 
        ORDER BY tbl_attendance_adjustments.create_date DESC
        LIMIT ".$offset.", ".$row." ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_TIME_ADJUSTMENT_APPROVALS($userId,$company,$dept, $sec, $group, $line,$branch,$division,$team){
        $filter_q = "";
        
        if($company){
            $filter_q .= " AND tbl_employee_infos.col_empl_company=".$company;
        }
        if($dept){
            $filter_q .= " AND tbl_employee_infos.col_empl_dept=".$dept;
        }
        if($sec){
            $filter_q .= " AND tbl_employee_infos.col_empl_sect=".$sec;
        }
        if($group){
            $filter_q .= " AND tbl_employee_infos.col_empl_group=".$group;
        }
        if($line){
            $filter_q .= " AND tbl_employee_infos.col_empl_line=".$line;
        }
        if($branch){
            $filter_q .= " AND tbl_employee_infos.col_empl_branch=".$branch;
        }
        if($division){
            $filter_q .= " AND tbl_employee_infos.col_empl_divi=".$division;
        }
        if($team){
            $filter_q .= " AND tbl_employee_infos.col_empl_team=".$team;
        }
        
        $sql = "SELECT *, tbl_attendance_adjustments.empl_id as empl_id, tbl_attendance_adjustments.id as id FROM tbl_attendance_adjustments
        JOIN tbl_overtime_approvers ON tbl_overtime_approvers.empl_id = tbl_attendance_adjustments.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_attendance_adjustments.empl_id
        WHERE tbl_attendance_adjustments.status LIKE '%Pending%' " .$filter_q. " AND (approver_1a = $userId OR approver_1b = $userId OR approver_2a = $userId OR approver_2b = $userId OR approver_3a = $userId  OR approver_3b = $userId) 
        ORDER BY tbl_attendance_adjustments.create_date DESC";
       
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_TIME_ADJUSTMENT_ASSIGN(){
        $sql = "SELECT * FROM tbl_attendance_adjustments WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3')";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_SPECIFIC_OVERTIME($id){
        $sql = "SELECT * FROM tbl_overtimes WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3') AND id=?";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();;
    }
    function GET_OVERTIME($id){
        $this->db->select('tb1.id,tb1.date_ot,tb1.empl_id,tb1.assigned_by as assigned_by_id,tb1.comment,tb1.reason,tb1.time_out,tb1.status,tb1.hours,tb1.type');
        $this->db->select("CONCAT(tb2.col_empl_cmid,'-',tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(tb2.col_midl_name,1)) as employee ",false);
        $this->db->select("CONCAT(tb3.col_empl_cmid,'-',tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(tb3.col_midl_name,1)) as assigned_by ",false)
        ->from('tbl_overtimes as tb1')
        ->join('tbl_employee_infos as tb2','tb1.empl_id=tb2.id','left')
        ->join('tbl_employee_infos as tb3','tb1.assigned_by=tb3.id','left')
        ->where('tb1.id',$id);
        $query=$this->db->get();
        return $query->row();
    }

    function GET_SPECIFIC_HOLIDAYWORK($id){
        $sql = "SELECT * FROM tbl_holidaywork WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3') AND id=?";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();;
    }
    function GET_HOLIDAY_WORK($id){
        $this->db->select('tb1.id,tb1.date,tb1.empl_id,tb1.assigned_by as assigned_by_id,tb1.comment,tb1.reason,tb1.status,tb1.hours,tb1.type');
        $this->db->select("CONCAT(tb2.col_empl_cmid,'-',tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(tb2.col_midl_name,1)) as employee ",false);
        $this->db->select("CONCAT(tb3.col_empl_cmid,'-',tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(tb3.col_midl_name,1)) as assigned_by ",false)
        ->from('tbl_holidaywork as tb1')
        ->join('tbl_employee_infos as tb2','tb1.empl_id=tb2.id','left')
        ->join('tbl_employee_infos as tb3','tb1.assigned_by=tb3.id','left')
        ->where('tb1.id',$id);
        $query=$this->db->get();
        return $query->row();
    }
    function UPDATE_HOLIDAY_WORK($id,$data){
        $this->db->where('id',$id);
        return $this->db->update('tbl_holidaywork',$data);
    }
    function GET_SPECIFIC_TIME_ADJ($id){
        $sql = "SELECT * FROM tbl_attendance_adjustments WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3') AND id=?";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();;
    }
    
    function GET_SPECIFIC_LEAVE_REQUEST($id){
        $sql = "SELECT * FROM tbl_leaves_assign WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3') AND id=?";
        $query = $this->db->query($sql,array($id));
        return $query->result_array();;
    }

    
    function GET_ALL_LEAVETYPESS(){
        $sql = "SELECT * FROM tbl_std_leavetypes WHERE status='Active' GROUP BY id DESC";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function get_leave_approver(){                              //JERENZ: NO GET LEAVE APPROVER FOUND IN THE  SELF SERVICES CONTROLLER
        $sql = "SELECT * FROM tbl_leave_approvers";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function get_overtime_approver(){                           //JERENZ: NO GET OVERTIME APPROVER FOUND IN THE  SELF SERVICES CONTROLLER
        $sql = "SELECT * FROM tbl_overtime_approvers";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_EMPLOYEE(){
        $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 and termination_date='0000-00-00'";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function UPDATE_LEAVE_ASSIGN($status,$emp_id,$date_created,$id){
        $sql = "UPDATE tbl_leaves_assign SET status=?, approver1=?, approver1_date=? WHERE id=? ";
        $query = $this->db->query($sql, array($status,$emp_id,$date_created,$id));
    }

    function UPDATE_LEAVE_ASSIGN2($status,$emp_id,$date_created,$id){
        $sql = "UPDATE tbl_leaves_assign SET status=?, approver2=?, approver2_date=? WHERE id=? ";
        $query = $this->db->query($sql, array($status,$emp_id,$date_created,$id));
    }

    function UPDATE_LEAVE_ASSIGN3($status,$emp_id,$date_created,$id){
        $sql = "UPDATE tbl_leaves_assign SET status=?, approver3=?, approver3_date=? WHERE id=? ";
        $query = $this->db->query($sql, array($status,$emp_id,$date_created,$id));
    }


    function GET_SHIFT_ASSIGN($date, $empl_id){                             //JERENZ: NO GET SHIFT ASSIGN FOUND IN THE SELF SERVICES CONTROLLER
        $sql = "SELECT * FROM tbl_attendance_shiftassign WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql , array($date, $empl_id));
        return $query->row();
    }
    function GET_SHIFT_ASSIGN_ID($date, $empl_id){
        $sql = "SELECT * FROM tbl_attendance_shiftassign WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql , array($date, $empl_id));
        if( $query->row()){
             return $query->row()->shift_id;
        }
        return false;
    }
    function GET_SHIFT($id){
        $this->db->select('*');
        $this->db->from('tbl_attendance_shifts');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    // function GET_ATTENDANCE_EMPL_REC($id){
    //      $sql = "SELECT id, date, empl_id, time_format(time_in1, '%H:%i') as time_in1, 
    //      time_format(time_out1, '%H:%i') as time_out1, time_format(time_in2, '%H:%i') as time_in2,
    //      time_format(time_out2, '%H:%i') as time_out2 FROM tbl_attendance_records 
    //      WHERE empl_id=? AND
    //      NOT EXISTS( SELECT * FROM tbl_attendance_adjustments WHERE tbl_attendance_records.date=tbl_attendance_adjustments.date_adjustment  )";
    //     $query = $this->db->query($sql,array($id));
    //     $query->next_result();
    //     return $query->result();
    // }
    function GET_ATTENDANCE_EMPL_REC($id){
        $sql = "SELECT id, date, empl_id, time_format(time_in, '%H:%i') as time_in, 
        time_format(time_out, '%H:%i') as time_out FROM tbl_attendance_records 
        WHERE empl_id=? AND
        NOT EXISTS( SELECT * FROM tbl_attendance_adjustments WHERE tbl_attendance_records.date=tbl_attendance_adjustments.date_adjustment  )";
       $query = $this->db->query($sql,array($id));
       $query->next_result();
       return $query->result();
   }


    function GET_EMPL_OVERTIME($userId,$status,$limit,$offset){
        $this->db->select('id,date_ot,hours,reason,status,comment');
        $this->db->where('empl_id',$userId);
        if(!empty($status)){
            $this->db->like('status',$status);
        }
        $this->db->limit($limit,$offset);
        $query=$this->db->get('tbl_overtimes');
        return $query->result();
        
    }
    function GET_EMPL_OVERTIME_COUNT($userId,$status){
        $this->db->select('id,date_ot,hours,reason,status,comment');
        $this->db->where('empl_id',$userId);
        if(!empty($status)){
            $this->db->like('status',$status);
        }
        $query=$this->db->get('tbl_overtimes');
        return $query->num_rows();
    }
    function GET_EMPL_HOLIDAY_WORK($userId,$status,$limit,$offset){
        $this->db->select('id,date,reason,status,comment,hours,reason,status,comment,type');
        $this->db->where('empl_id',$userId);
        if(!empty($status)){
            $this->db->like('status',$status);
        }
        $this->db->limit($limit,$offset);
        $this->db->order_by('id','desc');
        $query=$this->db->get('tbl_holidaywork');
        return $query->result();
    }
    function GET_EMPL_HOLIDAY_WORK_COUNT($userId,$status){
        $this->db->select('id,date,reason,status,comment,hours,reason,status,comment');
        $this->db->where('empl_id',$userId);
        if(!empty($status)){
            $this->db->like('status',$status);
        }
        $query=$this->db->get('tbl_holidaywork');
        return $query->num_rows();
    }
    // time adjustments
    function GET_EMPL_TIME_ADJ($userId,$status,$limit,$offset){
        $this->db->select('id,date_adjustment,time_in_1,time_out_1,time_in_2,time_out_2,attachment,reason,status,remarks');
        $this->db->where('empl_id',$userId);
        $this->db->limit($limit,$offset);
        if(!empty($status)){
            $this->db->like('status',$status);
        }
         $query=$this->db->get('tbl_attendance_adjustments');
        return $query->result();
    }
    function  GET_EMPL_TIME_ADJ_COUNT($userId,$status){
        $this->db->select('id,date_adjustment,time_in_1,time_out_1,time_in_2,time_out_2,attachment,reason,status,remarks');
        $this->db->where('empl_id',$userId);
        if(!empty($status)){
            $this->db->like('status',$status);
        }
         $query=$this->db->get('tbl_attendance_adjustments');
        return $query->num_rows();
    }
    function ADD_DATA($table_name,$data){
        return $this->db->insert($table_name, $data);
    }
    function ADD_LEAVE_REQUEST($data){
        return $this->db->insert('tbl_leaves_assign', $data);
    }
    function GET_IS_DUPLICATE_DATE($date){
        $sql = "SELECT * FROM tbl_leaves_assign WHERE leave_date=?";
        $query = $this->db->query($sql,array($date));
        return $query->num_rows(); 
    }
     function ADD_OVERTIME_REQUEST($data){
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('tbl_overtimes', $data);
    }
    function ADD_TIME_ADJUSTMENT_REQUEST($data){
          return $this->db->insert('tbl_attendance_adjustments', $data);
    } 
    function ADD_HOLIDAY_WORK($data){
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');
        return $this->db->insert('tbl_holidaywork', $data);
    }
    
    function UPDATE_OVERTIME_ASSIGN($status,$emp_id,$date_created,$id){
        $sql = "UPDATE tbl_overtimes SET status=?, approver1=?, approver1_date=? WHERE id=? ";
        $query = $this->db->query($sql, array($status,$emp_id,$date_created,$id));
    }

    function UPDATE_OVERTIME_ASSIGN2($status,$emp_id,$date_created,$id){
        $sql = "UPDATE tbl_overtimes SET status=?, approver2=?, approver2_date=? WHERE id=? ";
        $query = $this->db->query($sql, array($status,$emp_id,$date_created,$id));
    }

    function UPDATE_OVERTIME_ASSIGN3($status,$emp_id,$date_created,$id){
        $sql = "UPDATE tbl_overtimes SET status=?, approver3=?, approver3_date=? WHERE id=? ";
        $query = $this->db->query($sql, array($status,$emp_id,$date_created,$id));
    }


    function UPDATE_HOLIDAYWORK_ASSIGN($status,$emp_id,$date_created,$id){
        $sql = "UPDATE tbl_holidaywork SET status=?, approver1=?, approver1_date=? WHERE id=? ";
        $query = $this->db->query($sql, array($status,$emp_id,$date_created,$id));
    }

    function UPDATE_HOLIDAYWORK_ASSIGN2($status,$emp_id,$date_created,$id){
        $sql = "UPDATE tbl_holidaywork SET status=?, approver2=?, approver2_date=? WHERE id=? ";
        $query = $this->db->query($sql, array($status,$emp_id,$date_created,$id));
    }

    function UPDATE_HOLIDAYWORK_ASSIGN3($status,$emp_id,$date_created,$id){
        $sql = "UPDATE tbl_holidaywork SET status=?, approver3=?, approver3_date=? WHERE id=? ";
        $query = $this->db->query($sql, array($status,$emp_id,$date_created,$id));
    }


    function UPDATE_TIME_ADJ_ASSIGN($status,$emp_id,$date_created,$id){
        $sql = "UPDATE tbl_attendance_adjustments SET status=?, approver1=?, approver1_date=? WHERE id=? ";
        $query = $this->db->query($sql, array($status,$emp_id,$date_created,$id));
    }

    function UPDATE_TIME_ADJ_ASSIGN2($status,$emp_id,$date_created,$id){
        $sql = "UPDATE tbl_attendance_adjustments SET status=?, approver2=?, approver2_date=? WHERE id=? ";
        $query = $this->db->query($sql, array($status,$emp_id,$date_created,$id));
    }

    function UPDATE_TIME_ADJ_ASSIGN3($status,$emp_id,$date_created,$id){
        $sql = "UPDATE tbl_attendance_adjustments SET status=?, approver3=?, approver3_date=? WHERE id=? ";
        $query = $this->db->query($sql, array($status,$emp_id,$date_created,$id));
    }

    function GET_SALARY_TYPE($user_id){
        if(empty($user_id)){
            return '';
        }
        $sql = "SELECT salary_type FROM tbl_employee_infos WHERE id = ?";
        $query = $this->db->query($sql, array($user_id));
        $result = $query->result_array();
        return $result[0]["salary_type"];    
    }
    function GET_CUT_OFFS(){
        $this->db->select('id, date_from,date_to')
        ->where('status','Active')
        ->order_by('date_from', 'DESC');
        $query = $this->db->get('tbl_payroll_period');
        return $query->result();
    }
    function GET_SPECIFIC_ATTENDANCE_RECORD($empl_id,$firstDay,$lastDay){
        $sql = "SELECT * FROM tbl_attendance_records WHERE empl_id = ? AND date BETWEEN ? AND ? ";
        $query = $this->db->query($sql , array($empl_id,$firstDay,$lastDay));
        $query->next_result();
        return $query->result_array();
    }

    function GET_SPECIFIC_ZKTECO_RECORD($empl_id,$firstDay,$lastDay){
        $sql = "SELECT * FROM tbl_zkteco 
        LEFT JOIN tbl_zkteco_code ON tbl_zkteco.emp_code = tbl_zkteco_code.empl_code
        WHERE empl_id = ? AND (SELECT DATE_FORMAT(punch_time, '%Y-%m-%d')) BETWEEN ? AND ?  ";
        $query = $this->db->query($sql , array($empl_id,$firstDay,$lastDay));
        $query->next_result();
        return $query->result_array();
    }

    function GET_COUNT_ATTENDANCE_RECORD($empl_id){
        $sql = "SELECT * FROM tbl_attendance_records WHERE empl_id = ? ";
        $query = $this->db->query($sql , array($empl_id));
        return $query->num_rows();
    }

    function INSERT_EMPLOYEE_IMAGE($user_img, $userID)
    {
        $sql = "UPDATE tbl_employee_infos SET col_imag_path=? WHERE id=?";
        $query = $this->db->query($sql, array($user_img, $userID));
    }
    
    function GET_ALL_MY_PAYSPLIP($empl_id,$offset,$row){
        $sql = "SELECT tbl_employee_infos.col_empl_cmid, tbl_employee_infos.col_last_name, tbl_employee_infos.col_frst_name, tbl_employee_infos.col_midl_name, tbl_employee_infos.col_empl_posi, tbl_employee_infos.col_empl_type, tbl_payroll_payslips.id as id 
        FROM tbl_payroll_payslips 
        INNER JOIN tbl_employee_infos ON tbl_payroll_payslips.empl_id = tbl_employee_infos.id WHERE empl_id = ?
        LIMIT ".$offset.", ".$row." ";

        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }

    function GET_FILTERED_MY_PAYSPLIP($user_id,$dateFilter){
        $sql = "SELECT tbl_employee_infos.col_empl_cmid, tbl_employee_infos.col_last_name, tbl_employee_infos.col_frst_name, tbl_employee_infos.col_midl_name, tbl_employee_infos.col_empl_posi, tbl_employee_infos.col_empl_type, tbl_payroll_payslips.id as id 
        FROM tbl_payroll_payslips 
        INNER JOIN tbl_employee_infos ON tbl_payroll_payslips.empl_id = tbl_employee_infos.id WHERE empl_id = ? AND tbl_payroll_payslips.PAYSLIP_PERIOD = ?";

        $query = $this->db->query($sql, array($user_id,$dateFilter));
        $query->next_result();
        return $query->result();
    }


    // Display PAY_SCHED
    function MOD_DISP_PAY_SCHED()
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE status='active' ORDER BY id DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_MY_PAYSPLIP($empl_id){
        $sql = "SELECT tbl_employee_infos.col_empl_cmid, tbl_employee_infos.col_last_name, tbl_employee_infos.col_frst_name, tbl_employee_infos.col_midl_name, tbl_employee_infos.col_empl_posi, tbl_employee_infos.col_empl_type, tbl_payroll_payslips.id as id 
        FROM tbl_payroll_payslips 
        INNER JOIN tbl_employee_infos ON tbl_payroll_payslips.empl_id = tbl_employee_infos.id WHERE empl_id = ?";

        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }

    function GET_SPECIFIC_POSITION()
    {
        $sql = "SELECT * FROM tbl_std_positions ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_SPECIFIC_EMPLOYEE_TYPE()
    {
        $sql = "SELECT * FROM tbl_std_employeetypes";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_PAYSLIP_DATA($id){
        $this->db->select('col_empl_cmid,col_last_name,col_frst_name,col_midl_name,col_empl_posi,col_empl_type,tbl_payroll_payslips.id as id,tbl_employee_infos.salary_type as salary_type,tbl_employee_infos.salary_rate as salary_rate,tbl_payroll_payslips.*,tbl_std_positions.name as position,tbl_std_departments.name as department,tbl_std_sections.name as section,tbl_payroll_period.name as PAYSLIP_PERIOD');
        $this->db->from('tbl_payroll_payslips');
        $this->db->join('tbl_employee_infos', 'tbl_payroll_payslips.empl_id = tbl_employee_infos.id', 'left');
        $this->db->join('tbl_std_positions', 'tbl_std_positions.id = tbl_employee_infos.col_empl_posi', 'left');
        $this->db->join('tbl_std_departments', 'tbl_std_departments.id = tbl_employee_infos.col_empl_dept', 'left');
        $this->db->join('tbl_std_sections', 'tbl_std_sections.id = tbl_employee_infos.col_empl_sect', 'left');
         $this->db->join('tbl_payroll_period', 'tbl_payroll_period.id = tbl_payroll_payslips.PAYSLIP_PERIOD', 'left');
        $this->db->where('tbl_payroll_payslips.id', $id);
        $query = $this->db->get();
        return $query->result_object();
    }
    

    function DELETE_PAYSLIP_DATA($ids){
        $this->db->where_in('id', $ids);
        return $this->db->delete('tbl_payroll_payslips');
    }


    function MOD_UPDATE_LEAVE_STATUS($id, $status){
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_leaves_assign SET edit_date=?, status=? WHERE id=?";
        $query = $this->db->query($sql ,array($date, $status, $id));
    }

    function GET_LEAVE_ENTITLEMENT($id, $type){
        $sql = "SELECT value FROM tbl_leave_entitlements WHERE empl_id=? AND type=?";
        $query = $this->db->query($sql, array($id,$type));
        return $query->row_array();
    }

    function GET_EMPLOYEE_LOGS_SPECIFIC($empl_id)
    {
        $sql = "SELECT * FROM tbl_employee_logs WHERE empl_id=? AND category != 'Salary Rate' AND category != 'Salary Type' ORDER BY log_date DESC LIMIT 100";
        // $sql = "SELECT el.*, ei.col_frst_name, ei.col_last_name
        // FROM tbl_employee_logs el
        // JOIN tbl_employee_infos ei ON el.edit_id = ei.id
        // WHERE el.empl_id = ?
        // ORDER BY el.log_date DESC LIMIT 100";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }
    function UPDATE_OVERTIME($id,$data){
        $this->db->where('id', $id);
        $this->db->update('tbl_overtimes', $data);
    }
}