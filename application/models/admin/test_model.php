<?php
class test_model extends CI_Model
{
  function GET_PAGE_INFO()
  {
    $sql = "SELECT * FROM tbl_pageinfos";
    $query = $this->db->query($sql);
    $query->next_result();
    return $query->result();
  }

  function UPDATE_PAGE_STATUS($status,$id){
    $sql = "UPDATE tbl_pageinfos SET status=$status WHERE id=$id ";
    $query = $this->db->query($sql);
  }

  function UPDATE_PAGE_STATUS_CLEAR(){
    $sql = "UPDATE tbl_pageinfos SET status=0";
    $query = $this->db->query($sql);
  }

  function UPDATE_PAGE_STATUS_5_ON(){
    $sql = "UPDATE tbl_settings SET value=1 WHERE id = 3;";
    $query = $this->db->query($sql);
  }

  function GET_START_TIME()
  {
    $sql = "SELECT value FROM tbl_settings WHERE id = 1;";
    $query = $this->db->query($sql);
    $result = $query->result_array();
		return $result[0]["value"];
  }

  function GET_ALLOCATED_TIME()
  {
    $sql = "SELECT value FROM tbl_settings WHERE id = 2;";
    $query = $this->db->query($sql);
    $result = $query->result_array();
		return $result[0]["value"];
  }

  function GET_BP_RESULTS()
  {
    $sql = "SELECT bp_systolic,bp_diastolic,bp_pulse FROM tbl_test WHERE id = (SELECT MAX(id) FROM tbl_test);";
    $query = $this->db->query($sql);
    $result = $query->result_array();
		return $result[0];
  }

  function GET_TEMP_RESULTS()
  {
    $sql = "SELECT temp_temperature FROM tbl_test WHERE id = (SELECT MAX(id) FROM tbl_test);";
    $query = $this->db->query($sql);
    $result = $query->result_array();
		return $result[0]["temp_temperature"];
  }


  function GET_OXY_RESULTS()
  {
    $sql = "SELECT oxy_bloodoxygen,oxy_pulse FROM tbl_test WHERE id = (SELECT MAX(id) FROM tbl_test);";
    $query = $this->db->query($sql);
    $result = $query->result_array();
		return $result[0];
  }

  function INSERT_WAIST_HIP($waist_val, $hip_val, $waist_hip_ratio){
    $sql = "INSERT INTO tbl_test (man_waist, man_hip, cal_waisthipratio) VALUES (?,?,?)";
    $query = $this->db->query($sql, array($waist_val, $hip_val, $waist_hip_ratio));
    return $this->db->insert_id();
  }

  function GET_WAIST_HIP_RATIO($id){
    $sql = "SELECT cal_waisthipratio FROM tbl_test WHERE id = ?";
    $query = $this->db->query($sql,array($id));
    $result = $query->result_array();
		return $result[0]["cal_waisthipratio"];
  }




















  function MOD_DISP_ANNOUNCEMENTS($data)
  {
    $query = $this->db
      // ->select('col_empl_id, col_date_created, name, description, col_imag_path')
      ->select('id,edit_user, create_date, title, description, attachment')
      ->where('status','Active')
      ->order_by('id', 'DESC')
      ->limit($data)
      ->get('tbl_hr_announcements');
    return $query->result();
  }
  function MOD_DISP_ALL_EMPLOYEES_BY_DATE()
  {
    $sql = "SELECT col_frst_name, col_last_name, col_imag_path, CONCAT(MONTHNAME(STR_TO_DATE(MONTH(`col_birt_date`), '%m')),' ',DAY(`col_birt_date`)) AS Birthday, IF(MONTH(NOW()) = MONTH(col_birt_date) AND DAY(NOW()) = DAY(col_birt_date) , 1, 0) AS Today FROM tbl_employee_infos WHERE disabled=0 AND DATE_FORMAT(col_birt_date, '%m-%d') BETWEEN DATE_FORMAT(NOW(), '%m-%d') AND DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 7 DAY), '%m-%d') ORDER BY MONTH(`col_birt_date`) DESC,DAY(`col_birt_date`) DESC";
    $query = $this->db->query($sql, array());
    $query->next_result();
    return $query->result();
  }
  function MOD_DISP_ON_LEAVE()
  {
    // $query = $this->db
      // ->select('col_empl_id')
      // ->where('col_leave_from', date('Y-m-d'))
      // ->where('col_leave_status1', 'Approved')
      // ->where('col_leave_status2', 'Approved')
      // ->where('col_leave_status3', 'Approved')
      // ->get('tbl_leaves_assign');
    // return $query->result();
  }
  function GET_LEAVES($empl_id){
    $query = $this->db
      ->select('tbl_leaves_assign.id as id,duration,tbl_std_leavetypes.name as type,tbl_leaves_assign.status as status,leave_date as date')
      ->from('tbl_leaves_assign')
      ->join('tbl_std_leavetypes','tbl_std_leavetypes.id=tbl_leaves_assign.type')
      ->where('empl_id',$empl_id)
      ->like('tbl_leaves_assign.status','Pending')
      ->get();
    return $query->result();
  }

  function GET_HOLIDAYWORK($empl_id){
    $query = $this->db
      ->select('id,type,status,date,hours as duration')
      ->from('tbl_holidaywork')
      ->where('empl_id',$empl_id)
      ->like('status','Pending')
      ->get();
    return $query->result();
  }

  function GET_OVERTIME($empl_id){
    $query = $this->db
      ->select('id,type,status as status,date_ot as date,hours as duration')
      ->from('tbl_overtimes')
      ->where('empl_id',$empl_id)
      ->like('status','Pending')
      ->get();
    return $query->result();
  }
  function GET_TIME_ADJUSTMENTS($empl_id){
       $query = $this->db
      ->select('id,date_adjustment as date,shift_type as type,status')
      ->from('tbl_attendance_adjustments')
      ->where('empl_id',$empl_id)
      ->like('status','Pending')
      ->get();
    return $query->result();
      
  }
  function disp_new_emp_month()
  {
    $query = $this->db
      ->select('col_imag_path, col_last_name, col_frst_name')
      ->where('MONTH(col_hire_date)', date("m"))
      ->where('YEAR(col_hire_date)', date("Y"))
      ->get("tbl_employee_infos");
    return $query->result();
  }
  public function leave_approved_count($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->where('MONTH(create_date)', date("m"))
        ->where('YEAR(create_date)', date("Y"))
        ->where("status", "Approved")
        ->count_all_results("tbl_leaves_assign");
      return $query;
    }
  }
  public function leave_rejected_count($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->where('status', "Rejected")
        ->count_all_results("tbl_leaves_assign");
      return $query;
    }
  }
  public function leave_all_count($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->like('status','%Pending%')
        ->count_all_results("tbl_leaves_assign");
      return $query;
    }
  }

  public function holidaywork_approved_count($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->where("status", "Approved")
        ->count_all_results("tbl_holidaywork");
      return $query;
    }
  }
  public function holidaywork_rejected_count($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->where("status", "Rejected")
        ->count_all_results("tbl_holidaywork");
      return $query;
    }
  }
  
  public function holidaywork_all_count($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->like('status', "%Pending%")
        ->count_all_results("tbl_holidaywork");
      return $query;
    }
  }



  public function overtime_approved_count($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->where("status", "Approved")
        ->count_all_results("tbl_overtimes");
      return $query;
    }
  }
  public function overtime_rejected_count($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->where("status", "Rejected")
        ->count_all_results("tbl_overtimes");
      return $query;
    }
  }
  
  public function overtime_all_count($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->like('status', "%Pending%")
        ->count_all_results("tbl_overtimes");
      return $query;
    }
  }

  public function time_approved_count($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->where("status", "Approved")
        // ->where("status2", "Approved")
        ->count_all_results("tbl_attendance_adjustments");
      return $query;
    }
  }
  public function time_rejected_count($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->where('(status = "Rejected")')
        ->count_all_results("tbl_attendance_adjustments");
      return $query;
    }
  }
  public function time_all_count($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->like('status','%Pending%')
        ->count_all_results("tbl_attendance_adjustments");
      return $query;
    }
  }
  // public function get_leave_for_approvals($userId){
  //      $query = $this->db
  //       ->select('tbl_leaves_assign.id as id,tbl_leaves_assign.status as status,
  //                   col_frst_name,col_last_name,leave_date,duration,tbl_std_leavetypes.name as type')
  //       ->from('tbl_leaves_assign')
  //       ->join('tbl_employee_infos', 'tbl_employee_infos.id = tbl_leaves_assign.empl_id')
  //       ->join('tbl_std_leavetypes', 'tbl_std_leavetypes.id = tbl_leaves_assign.type')
  //       ->where("tbl_leaves_assign.status LIKE '%Pending%'")
  //       ->where("(approver1 = $userId OR approver2 = $userId OR approver3 = $userId)")
  //       ->order_by('tbl_leaves_assign.create_date', 'DESC')
  //       ->limit(5)
  //       ->get()->result();
  //        return $query;
  // }

  // LEAVE APPROVALS
  function get_leave_for_approvals($userId){
    $sql = "SELECT *, tbl_leaves_assign.empl_id as empl_id, tbl_leaves_assign.id as id FROM tbl_leaves_assign
    JOIN tbl_leave_approvers ON tbl_leave_approvers.empl_id = tbl_leaves_assign.empl_id
    JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_leaves_assign.empl_id
    WHERE tbl_leaves_assign.status LIKE '%Pending%'
    AND (approver_1a = $userId OR approver_1b = $userId OR approver_2a = $userId OR approver_2b = $userId OR approver_3a = $userId  OR approver_3b = $userId) 
    ORDER BY tbl_leaves_assign.create_date DESC LIMIT 3";
    $query = $this->db->query($sql,array());
    $query->next_result();
    return $query->result();
  }

  function get_leave_assign(){
    $sql = "SELECT * FROM tbl_leaves_assign WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3')";
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

  // HOLIDAY WORK APPROVALS
  function get_holidaywork_approvals($userId){
    $sql = "SELECT *, tbl_holidaywork.empl_id as empl_id, tbl_holidaywork.id as id FROM tbl_holidaywork
    JOIN tbl_overtime_approvers ON tbl_overtime_approvers.empl_id = tbl_holidaywork.empl_id
    JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_holidaywork.empl_id
    WHERE tbl_holidaywork.status LIKE '%Pending%'
    AND (approver_1a = $userId OR approver_1b = $userId OR approver_2a = $userId OR approver_2b = $userId OR approver_3a = $userId  OR approver_3b = $userId) 
    ORDER BY tbl_holidaywork.create_date DESC
    LIMIT 3" ;
    $query = $this->db->query($sql,array());
    $query->next_result();
    return $query->result();
  }

  function get_holidaywork_assign(){
    $sql = "SELECT * FROM tbl_holidaywork WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3') ";
    $query = $this->db->query($sql,array());
    $query->next_result();
    return $query->result();
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

  // OVERTIME APPROVALS
  function get_overtime_approvals($userId){
    $sql = "SELECT *, tbl_overtimes.empl_id as empl_id, tbl_overtimes.id as id FROM tbl_overtimes
    JOIN tbl_overtime_approvers ON tbl_overtime_approvers.empl_id = tbl_overtimes.empl_id
    JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_overtimes.empl_id
    WHERE tbl_overtimes.status LIKE '%Pending%'
    AND (approver_1a = $userId OR approver_1b = $userId OR approver_2a = $userId OR approver_2b = $userId OR approver_3a = $userId  OR approver_3b = $userId) 
    ORDER BY tbl_overtimes.create_date DESC LIMIT 3";
    $query = $this->db->query($sql,array());
    $query->next_result();
    return $query->result();
  }

  function get_overtime_assign(){
    $sql = "SELECT * FROM tbl_overtimes WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3')";
    $query = $this->db->query($sql,array());
    $query->next_result();
    return $query->result();
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


  // ATTENDANCE TIME ADJUSTMENT APPROVALS
  function get_time_adjustment_approvals($userId){
    $sql = "SELECT *, tbl_attendance_adjustments.empl_id as empl_id, tbl_attendance_adjustments.id as id FROM tbl_attendance_adjustments
    JOIN tbl_overtime_approvers ON tbl_overtime_approvers.empl_id = tbl_attendance_adjustments.empl_id
    JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_attendance_adjustments.empl_id
    WHERE tbl_attendance_adjustments.status LIKE '%Pending%'
    AND (approver_1a = $userId OR approver_1b = $userId OR approver_2a = $userId OR approver_2b = $userId OR approver_3a = $userId  OR approver_3b = $userId) 
    ORDER BY tbl_attendance_adjustments.create_date DESC LIMIT 3";
    $query = $this->db->query($sql,array());
    $query->next_result();
    return $query->result();
  }

  function get_time_adjustment_assign(){
    $sql = "SELECT * FROM tbl_attendance_adjustments WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3')";
    $query = $this->db->query($sql,array());
    $query->next_result();
    return $query->result();
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

  function is_duplicate_time_addj($empl_id, $date){
    $sql = "SELECT id FROM tbl_attendance_records WHERE empl_id=? AND date=?";
    $query = $this->db->query($sql,array($empl_id,$date));
    return $query->num_rows();
  }

  function is_duplicate_attendance_shiftassign($empl_id, $date){
    $sql = "SELECT id FROM tbl_attendance_shiftassign WHERE empl_id=? AND date=?";
    $query = $this->db->query($sql,array($empl_id,$date));
    return $query->num_rows();
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

  
  // function update_leaveStatus($id,$newStatus){
  //      $query = $this->db
  //      ->set('status', $newStatus)
  //      ->where('id', $id)
  //      ->update('tbl_leaves_assign');
  //      return $query;
  // }
  // function get_overtime_for_approvals( $userId){
  //     $query = $this->db
  //       ->select('tbl_overtimes.id as id,status,
  //                   col_frst_name,col_last_name,type,date_ot as date,hours')
  //       ->from('tbl_overtimes')
  //       ->join('tbl_employee_infos', 'tbl_employee_infos.id = tbl_overtimes.empl_id')
  //       ->where("tbl_overtimes.status LIKE '%Pending%'")
  //       ->where("(approver1 = $userId OR approver2 = $userId OR approver3 = $userId)")
  //       ->order_by('tbl_overtimes.create_date', 'DESC')
  //       ->limit(5)
  //        ->get()->result();
  //        return $query;
  // }

   function update_overtimeStatus($id,$newStatus){
       $query = $this->db
       ->set('status', $newStatus)
       ->where('id', $id)
       ->update('tbl_overtimes');
       return $query;
  }


  // function get_time_adjustment_for_approvals($userId){
  //      $query = $this->db
  //       ->select('tbl_attendance_adjustments.id as id,status,
  //                   col_frst_name,col_last_name,shift_type as type,date_adjustment as date')
  //       ->from('tbl_attendance_adjustments')
  //       ->join('tbl_employee_infos', 'tbl_employee_infos.id = tbl_attendance_adjustments.empl_id')
  //       ->where("tbl_attendance_adjustments.status LIKE '%Pending%'")
  //       ->where("(approver1 = $userId OR approver2 = $userId OR approver3 = $userId)")
  //       ->order_by('tbl_attendance_adjustments.create_date', 'DESC')
  //       ->limit(5)
  //        ->get()->result();
  //        return $query;
  // }


  function update_timeAdjustmentStatus($id,$newStatus){
       $query = $this->db
       ->set('status', $newStatus)
       ->where('id', $id)
       ->update('tbl_attendance_adjustments');
       return $query;
  }
  function MOD_DISP_HOLIDAY_BASED_DATE($date)
  {
    $query = $this->db
      ->select('name')
      ->where('col_holi_date', $date)
      ->get('tbl_std_holidays');
     
    return $query->result();
  }
  function get_desktop_logo()
  {
    $query = $this->db
      ->select('*')
      ->where('setting', 'desktopBanner')
      ->get('tbl_system_setup');
    return $query->row_array();
  }
  function get_mobile_logo()
  {
    $query = "SELECT * FROM tbl_system_setup WHERE setting = 'mobileBanner' ";
    return $this->db->query($query)->row_array();
  }
  function get_home_announcement()
  {
    $query = $this->db
      ->select('value')
      ->where('setting', 'home_announcement')
      ->get('tbl_system_setup');
    return $query->row_array();
  }
  function get_home_celebration()
  {
    $query = $this->db
      ->select('value')
      ->where('setting', 'home_celebration')
      ->get('tbl_system_setup');
    return $query->row_array();
  }
  function get_home_date()
  {
    $query = $this->db
      ->select('value')
      ->where('setting', 'home_date')
      ->get('tbl_system_setup');
    return $query->row_array();
  }
  function get_home_leave()
  {
    $query = $this->db
      ->select('value')
      ->where('setting', 'home_leave_info')
      ->get('tbl_system_setup');
    return $query->row_array();
  }
  function get_home_whos_out()
  {
    $query = $this->db
      ->select('value')
      ->where('setting', 'home_whos_out')
      ->get('tbl_system_setup');
    return $query->row_array();
  }
  function get_home_start_guide()
  {
    $query = $this->db
      ->select('value')
      ->where('setting', 'home_start_guide')
      ->get('tbl_system_setup');
    return $query->row_array();
  }
  function get_home_new_member()
  {
    $query = $this->db
      ->select('value')
      ->where('setting', 'home_new_member')
      ->get('tbl_system_setup');
    return $query->row_array();
  }
  function employeInfo($id)
  {
    $query = $this->db
      ->select('col_frst_name, col_last_name, col_imag_path')
      ->where('id', $id)
      ->get('tbl_employee_infos');
    return $query->result();
  }

  function GET_POSITION()
  {
      $sql = "SELECT id,name FROM tbl_std_positions";
      $query = $this->db->query($sql, array());
      $query->next_result();
      return $query->result();
  }

  function get_file_path($id){
    $sql = "SELECT attachment FROM tbl_hr_announcements WHERE id=?";
    $query = $this->db->query($sql,array($id));
    $result = $query->result_array();
		return $result[0]["attachment"];
  }

  
}
