<?php
class Home_model extends CI_Model
{
  function MOD_DISP_HOME($user_id)
  {
    $query =  $this->db
      ->select('col_last_name, col_suffix, col_user_name, col_midl_name, col_frst_name, col_imag_path, col_empl_posi, col_user_access, col_empl_group')
      ->where('id', $user_id)
      ->where('disabled', 0)
      ->get('tbl_employee_infos');
    return $query->result();
  }
  function MOD_DISP_ANNOUNCEMENTS($data)
  {
    $query = $this->db
      ->select('id,edit_user, create_date, title, description, attachment')
      ->where('status', 'Active')
      ->order_by('id', 'DESC')
      ->limit($data)
      ->get('tbl_hr_announcements');
    return $query->result();
  }

  function MOD_DISP_JOB_POST($data)
  {
    $query = $this->db
      ->select('id,edit_user, create_date, title, description, responsibilities, qualifications, attachment')
      ->where('status', 'Active')
      ->order_by('id', 'DESC')
      ->limit($data)
      ->get('tbl_recruitment_jobposting');
    return $query->result();
  }

  function MOD_DISP_ALL_EMPLOYEES_BY_DATE()
  {
    $sql = "SELECT col_frst_name, col_last_name,col_midl_name, col_imag_path,CONCAT(MONTHNAME(col_birt_date), ' ', DAY(col_birt_date)) AS Birthday, IF(MONTH(NOW()) = MONTH(col_birt_date) AND DAY(NOW()) = DAY(col_birt_date) , 1, 0) AS Today FROM tbl_employee_infos WHERE disabled=0 AND DATE_FORMAT(col_birt_date, '%m-%d') BETWEEN DATE_FORMAT(NOW(), '%m-%d') AND DATE_FORMAT(DATE_ADD(NOW(), INTERVAL 7 DAY), '%m-%d') ORDER BY MONTH(`col_birt_date`) DESC,DAY(`col_birt_date`) DESC";
    $query = $this->db->query($sql, array());
    $query->next_result();
    return $query->result();
  }

  function MOD_DISP_ON_LEAVE()
  {
    $query = $this->db
      ->select('*')
      ->where('status', 'Approved')
      ->get('tbl_leaves_assign');
    return $query->result();
  }

  function GET_LEAVES($empl_id)
  {
    $query = $this->db
      ->select('tbl_leaves_assign.id as id,duration,tbl_std_leavetypes.name as type,tbl_leaves_assign.status as status,leave_date as date')
      ->from('tbl_leaves_assign')
      ->join('tbl_std_leavetypes', 'tbl_std_leavetypes.id=tbl_leaves_assign.type')
      ->where('empl_id', $empl_id)
      ->like('tbl_leaves_assign.status', 'Pending')
      ->get();
    return $query->result();
  }

  function GET_HOLIDAYWORK($empl_id)
  {
    $query = $this->db
      ->select('id,type,status,date,hours as duration')
      ->from('tbl_holidaywork')
      ->where('empl_id', $empl_id)
      ->like('status', 'Pending')
      ->get();
    return $query->result();
  }

  function GET_OVERTIME($empl_id)
  {
    $query = $this->db
      ->select('id,type,status as status,date_ot as date,hours as duration')
      ->from('tbl_overtimes')
      ->where('empl_id', $empl_id)
      ->like('status', 'Pending')
      ->get();
    return $query->result();
  }

  function GET_TIME_ADJUSTMENTS($empl_id)
  {
    $query = $this->db
      ->select('id,date_adjustment as date,shift_type as type,status')
      ->from('tbl_attendance_adjustments')
      ->where('empl_id', $empl_id)
      ->like('status', 'Pending')
      ->get();
    return $query->result();
  }

  function GET_HOLIDAYS()
  {
    $currentDate = date("Y-m-d");
    $twoMonthsLater = date("Y-m-d", strtotime("+2 months", strtotime($currentDate)));
    $query = $this->db
      ->select('name, col_holi_date, ')
      ->where('col_holi_date >=', $currentDate)
      ->where('col_holi_date <', $twoMonthsLater)
      ->get("tbl_std_holidays");
    return $query->result();
  }

  function DISP_NEW_EMP_MONTH()
  {
    $query = $this->db
      ->select('col_imag_path, col_last_name, col_frst_name, col_midl_name')
      ->where('MONTH(col_hire_date)', date("m"))
      ->where('YEAR(col_hire_date)', date("Y"))
      ->get("tbl_employee_infos");
    return $query->result();
  }

  public function LEAVE_APPROVED_COUNT($userId)
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

  public function LEAVE_REJECTED_COUNT($userId)
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

  public function LEAVE_PENDING_COUNT($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->where_in('status', array("Pending 1", "Pending 2", "Pending 3", "Pending 4", "Pending 5"))
        ->count_all_results("tbl_leaves_assign");
      return $query;
    }
  }

  public function LEAVE_ALL_COUNT($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->like('status', '%Pending%')
        ->count_all_results("tbl_leaves_assign");
      return $query;
    }
  }

  public function HOLIDAYWORK_APPROVED_COUNT($userId)
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

  public function HOLIDAYWORK_REJECTED_COUNT($userId)
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

  public function HOLIDAYWORK_ALL_COUNT($userId)
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

  public function OVERTIME_APPROVED_COUNT($userId)
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

  public function OFFSET_APPROVED_COUNT($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->where("status", "Approved")
        ->count_all_results("tbl_attendance_offsets");
      return $query;
    }
  }

  public function OVERTIME_PENDING_COUNT($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->where_in('status', array("Pending 1", "Pending 2", "Pending 3", "Pending 4", "Pending 5"))
        ->count_all_results("tbl_overtimes");
      return $query;
    }
  }

  function TEAMMEMBERS_LIST($user_id)
  {
    $this->db->select('id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name,col_imag_path');
    $this->db->select("
              CONCAT_WS(
                  '',
                  CONCAT(col_empl_cmid, '-',col_last_name),
                  CASE WHEN col_suffix IS NOT NULL AND col_suffix <> '' THEN CONCAT(' ',col_suffix) ELSE '' END,
                  CASE WHEN col_frst_name IS NOT NULL AND col_frst_name <> '' THEN CONCAT(', ',col_frst_name) ELSE '' END,
                  CASE WHEN col_midl_name IS NOT NULL AND col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(col_midl_name, 1)), '.') ELSE '' END
              ) AS fullname
              ", false);
    $this->db->where("disabled = 0 AND (termination_date IS NULL OR termination_date = '0000-00-00') ");
    $this->db->where('reporting_to', $user_id);
    $this->db->order_by('col_empl_cmid + 0 ', 'ASC');

    $query = $this->db->get('tbl_employee_infos');
    return $query->result();
  }
  public function OVERTIME_ALL_COUNT($userId)
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

  function CHECK_LEAVE($userId)
  {
    $today = date("Y-m-d");

    $sql = "SELECT * FROM tbl_leaves_assign WHERE leave_date = '$today' AND status = 'Approved' AND empl_id = $userId";
    $query = $this->db->query($sql);
    return $query->num_rows();
  }



  public function TIME_APPROVED_COUNT($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->where("status", "Approved")
        ->count_all_results("tbl_attendance_adjustments");
      return $query;
    }
  }

  public function TIME_REJECTED_COUNT($userId)
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

  public function TIME_ALL_COUNT($userId)
  {
    if ($userId) {
      $query = $this->db
        ->select('empl_id')
        ->where('empl_id', $userId)
        ->like('status', '%Pending%')
        ->count_all_results("tbl_attendance_adjustments");
      return $query;
    }
  }

  function LEAVEAPPROVAL_COUNT($userId)
  {
    $sql = "SELECT tb1.* FROM tbl_leaves_assign as tb1
    LEFT JOIN tbl_employee_infos ON tb1.empl_id=tbl_employee_infos.id
    WHERE  (tb1.parent_id is null or tb1.parent_id = 0) AND tb1.status LIKE '%Pending%'

    AND ( ((tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND tb1.status = 'Pending 1') OR
      ((tb1.approver2 = $userId OR tb1.approver2_b = $userId)  AND tb1.status = 'Pending 2') OR
      ((tb1.approver3 = $userId OR tb1.approver3_b = $userId)  AND tb1.status = 'Pending 3') OR
      ((tb1.approver4 = $userId OR tb1.approver4_b = $userId)  AND tb1.status = 'Pending 4') OR
      ((tb1.approver5 = $userId OR tb1.approver5_b = $userId)  AND tb1.status = 'Pending 5')
    )

    ORDER BY tb1.create_date DESC ";

    $query = $this->db->query($sql, array($userId));
    return $query->num_rows();
  }

  function OVERTIMEAPPROVAL_COUNT($userId)
  {
    $sql = "SELECT *, tb1.empl_id as empl_id, tb1.id as id FROM tbl_overtimes AS tb1
    JOIN tbl_approvers_ot ON tbl_approvers_ot.empl_id = tb1.empl_id
    JOIN tbl_employee_infos ON tbl_employee_infos.id = tb1.empl_id

    WHERE tb1.status LIKE '%Pending%'
    AND ( ((tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND tb1.status = 'Pending 1') OR
    ((tb1.approver2 = $userId OR tb1.approver2_b = $userId)  AND tb1.status = 'Pending 2') OR
    ((tb1.approver3 = $userId OR tb1.approver3_b = $userId)  AND tb1.status = 'Pending 3') OR
    ((tb1.approver4 = $userId OR tb1.approver4_b = $userId)  AND tb1.status = 'Pending 4') OR
    ((tb1.approver5 = $userId OR tb1.approver5_b = $userId)  AND tb1.status = 'Pending 5')
    )

    ORDER BY tb1.id DESC";
    $query = $this->db->query($sql, array());
    return $query->num_rows();

  }

  function ADJUSTMENTAPPROVAL_COUNT($userId)
  {
    $sql = "SELECT *, tb1.empl_id as empl_id, tb1.id as id FROM tbl_attendance_adjustments AS tb1
    JOIN tbl_approvers_timeadj ON tbl_approvers_timeadj.empl_id = tb1.empl_id
    JOIN tbl_employee_infos ON tbl_employee_infos.id = tb1.empl_id
    WHERE tb1.status LIKE '%Pending%' 

     AND ( ((tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND tb1.status = 'Pending 1') OR
    ((tb1.approver2 = $userId OR tb1.approver2_b = $userId)  AND tb1.status = 'Pending 2') OR
    ((tb1.approver3 = $userId OR tb1.approver3_b = $userId)  AND tb1.status = 'Pending 3') OR
    ((tb1.approver4 = $userId OR tb1.approver4_b = $userId)  AND tb1.status = 'Pending 4') OR
    ((tb1.approver5 = $userId OR tb1.approver5_b = $userId)  AND tb1.status = 'Pending 5')
    )

    ORDER BY tb1.create_date DESC";
    $query = $this->db->query($sql, array());
    return $query->num_rows();
  }

  function HOLIDAYAPPROVAL_COUNT($userId)
  {
    $sql = "SELECT *, tb1.empl_id as empl_id, tb1.id as id FROM tbl_holidaywork AS tb1
    JOIN tbl_approvers_ot ON tbl_approvers_ot.empl_id = tb1.empl_id
    JOIN tbl_employee_infos ON tbl_employee_infos.id = tb1.empl_id
    WHERE tb1.status LIKE '%Pending%' 

    AND ( ((tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND tb1.status = 'Pending 1') OR
    ((tb1.approver2 = $userId OR tb1.approver2_b = $userId)  AND tb1.status = 'Pending 2') OR
    ((tb1.approver3 = $userId OR tb1.approver3_b = $userId)  AND tb1.status = 'Pending 3') OR
    ((tb1.approver4 = $userId OR tb1.approver4_b = $userId)  AND tb1.status = 'Pending 4') OR
    ((tb1.approver5 = $userId OR tb1.approver5_b = $userId)  AND tb1.status = 'Pending 5')
    )

    ORDER BY tb1.create_date DESC ";
    $query = $this->db->query($sql, array());
    return $query->num_rows();
  }

  function ACQUIRE_OFFSET_COUNT($userId){
    $sql = "SELECT tb1.* FROM tbl_attendance_offsets_acquire as tb1
    LEFT JOIN tbl_employee_infos ON tb1.empl_id=tbl_employee_infos.id
    WHERE tb1.status LIKE '%Pending%'
  
    AND ( (( tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND approver1_date = '0000-00-00 00:00:00') OR 
    ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver2_date='0000-00-00 00:00:00') OR
    ( (tb1.approver3 = $userId OR tb1.approver3_b = $userId) AND approver3_date='0000-00-00 00:00:00')
    )
    
    ORDER BY tb1.create_date DESC ";
    $query = $this->db->query($sql, array());
    return $query->num_rows();
  }

  function REDEEM_OFFSET_COUNT($userId){
    $sql = "SELECT tb1.* FROM tbl_attendance_offsets as tb1
    LEFT JOIN tbl_employee_infos ON tb1.empl_id=tbl_employee_infos.id
    WHERE tb1.status LIKE '%Pending%'

    AND ( (( tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND approver1_date = '0000-00-00 00:00:00') OR 
        ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver1_date!='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00') OR
        ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver1_date='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00')
        )

    ORDER BY tb1.create_date DESC ";
    $query = $this->db->query($sql, array());
    return $query->num_rows();
  }




  function REMAINING_SIL_HOURS($empl_id)
  {
    $year = date("Y");

    $sql = "SELECT tb1.value as sum FROM tbl_leave_entitlements AS tb1 INNER JOIN tbl_std_years AS tb2 ON tb1.year = tb2.id WHERE tb1.type = 'Service Incentive Leave (SIL)' AND tb1.empl_id = ? AND tb2.name = $year";
    $query = $this->db->query($sql, array($empl_id));
    $result = $query->result_array();


    if (!isset($result[0]["sum"])) {
      $output = 0;
    } else {
      // Hours => Days
      $output = $result[0]["sum"] / 8;
    }
    return $output;
  }

  function REMAINING_VACATION_HOURS($empl_id)
  {
    $year = date("Y");

    $sql = "SELECT tb1.value as sum FROM tbl_leave_entitlements AS tb1 INNER JOIN tbl_std_years AS tb2 ON tb1.year = tb2.id WHERE tb1.type = 'Vacation Leave' AND tb1.empl_id = ? AND tb2.name = $year";
    $query = $this->db->query($sql, array($empl_id));
    $result = $query->result_array();


    if (!isset($result[0]["sum"])) {
      $output = 0;
    } else {
      // Hours => Days
      $output = $result[0]["sum"] / 8;
    }
    return $output;
  }

  function USED_SIL_HOURS($empl_id)
  {
    $year = date("Y");

    $sql = "SELECT SUM(tb1.duration) as sum FROM tbl_leaves_assign AS tb1 INNER JOIN tbl_std_leavetypes AS tb2 ON tb1.type = tb2.id WHERE tb2.name = 'Service Incentive Leave (SIL)' AND tb1.status = 'Approved' AND tb1.empl_id = ? AND tb1.leave_date >= '$year-01-01' AND tb1.leave_date <= '$year-12-31';";;

    $query = $this->db->query($sql, array($empl_id));
    $result = $query->result_array();
    if (!isset($result[0]["sum"])) {
      $output = 0;
    } else {
      $output = $result[0]["sum"];
    }
    return $output;
  }

  function USED_VACATION_HOURS($empl_id)
  {

    $year = date("Y");

    $sql = "SELECT SUM(tb1.duration) as sum FROM tbl_leaves_assign AS tb1 INNER JOIN tbl_std_leavetypes AS tb2 ON tb1.type = tb2.id WHERE tb2.name = 'Vacation Leave' AND tb1.status = 'Approved' AND tb1.empl_id = ? AND tb1.leave_date >= '$year-01-01' AND tb1.leave_date <= '$year-12-31';";

    $query = $this->db->query($sql, array($empl_id));
    $result = $query->result_array();
    if (!isset($result[0]["sum"])) {
      $output = 0;
    } else {
      $output = $result[0]["sum"];
    }
    return $output;
  }

  function REMAINING_SICK_HOURS($empl_id)
  {
    $year = date("Y");

    $sql = "SELECT tb1.value as sum FROM tbl_leave_entitlements AS tb1 INNER JOIN tbl_std_years AS tb2 ON tb1.year = tb2.id WHERE tb1.type = 'Sick Leave' AND tb1.empl_id = ? AND tb2.name = $year";
    $query = $this->db->query($sql, array($empl_id));
    $result = $query->result_array();
    if (!isset($result[0]["sum"])) {
      $output = 0;
    } else {
      // Hours => Days
      $output = $result[0]["sum"] / 8;
    }
    return $output;
  }

  function USED_SICK_HOURS($empl_id)
  {
    $year = date("Y");

    $sql = "SELECT SUM(tb1.duration) as sum FROM tbl_leaves_assign AS tb1 INNER JOIN tbl_std_leavetypes AS tb2 ON tb1.type = tb2.id WHERE tb2.name = 'Sick Leave' AND tb1.status = 'Approved' AND tb1.empl_id = ? AND tb1.leave_date >= '$year-01-01' AND tb1.leave_date <= '$year-12-31';";

    $query = $this->db->query($sql, array($empl_id));
    $result = $query->result_array();
    if (!isset($result[0]["sum"])) {
      $output = 0;
    } else {
      $output = $result[0]["sum"];
    }
    return $output;
  }

  function GET_LEAVE_ASSIGN($id)
  {
    $sql = "SELECT * FROM tbl_leaves_assign WHERE id=?";
    $query = $this->db->query($sql, array($id));
    $query->next_result();
    return $query->row();
  }

  function UPDATE_LEAVE_ASSIGN($status, $emp_id, $date_created, $id)
  {
    $sql = "UPDATE tbl_leaves_assign SET status=?, approver1=?, approver1_date=? WHERE id=? ";
    $query = $this->db->query($sql, array($status, $emp_id, $date_created, $id));
  }

  function UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id)
  {
    $sql = "UPDATE tbl_leaves_assign SET status=?, approver2=?, approver2_date=? WHERE id=? ";
    $query = $this->db->query($sql, array($status, $emp_id, $date_created, $id));
  }

  function UPDATE_LEAVE_ASSIGN3($status, $emp_id, $date_created, $id)
  {
    $sql = "UPDATE tbl_leaves_assign SET status=?, approver3=?, approver3_date=? WHERE id=? ";
    $query = $this->db->query($sql, array($status, $emp_id, $date_created, $id));
  }


  function GET_HOLIDAYWORK_ASSIGN($id)
  {
    $sql = "SELECT * FROM tbl_holidaywork WHERE id=? ";
    $query = $this->db->query($sql, array($id));
    $query->next_result();
    return $query->row();
  }

  function UPDATE_HOLIDAYWORK_ASSIGN($status, $emp_id, $date_created, $id)
  {
    $sql = "UPDATE tbl_holidaywork SET status=?, approver1=?, approver1_date=? WHERE id=? ";
    $query = $this->db->query($sql, array($status, $emp_id, $date_created, $id));
  }

  function UPDATE_HOLIDAYWORK_ASSIGN2($status, $emp_id, $date_created, $id)
  {
    $sql = "UPDATE tbl_holidaywork SET status=?, approver2=?, approver2_date=? WHERE id=? ";
    $query = $this->db->query($sql, array($status, $emp_id, $date_created, $id));
  }

  function UPDATE_HOLIDAYWORK_ASSIGN3($status, $emp_id, $date_created, $id)
  {
    $sql = "UPDATE tbl_holidaywork SET status=?, approver3=?, approver3_date=? WHERE id=? ";
    $query = $this->db->query($sql, array($status, $emp_id, $date_created, $id));
  }



  function GET_OVERTIME_ASSIGN($id)
  {
    $sql = "SELECT * FROM tbl_overtimes WHERE id=?";
    $query = $this->db->query($sql, array($id));
    $query->next_result();
    return $query->row();
  }

  function UPDATE_OVERTIME_ASSIGN($status, $emp_id, $date_created, $id)
  {
    $sql = "UPDATE tbl_overtimes SET status=?, approver1=?, approver1_date=? WHERE id=? ";
    $query = $this->db->query($sql, array($status, $emp_id, $date_created, $id));
  }

  function UPDATE_OVERTIME_ASSIGN2($status, $emp_id, $date_created, $id)
  {
    $sql = "UPDATE tbl_overtimes SET status=?, approver2=?, approver2_date=? WHERE id=? ";
    $query = $this->db->query($sql, array($status, $emp_id, $date_created, $id));
  }

  function UPDATE_OVERTIME_ASSIGN3($status, $emp_id, $date_created, $id)
  {
    $sql = "UPDATE tbl_overtimes SET status=?, approver3=?, approver3_date=? WHERE id=? ";
    $query = $this->db->query($sql, array($status, $emp_id, $date_created, $id));
  }


  function GET_TIME_ADJUSTMENT_ASSIGN($id)
  {
    $sql = "SELECT * FROM tbl_attendance_adjustments WHERE id=?";
    $query = $this->db->query($sql, array($id));
    $query->next_result();
    return $query->row();
  }

  function UPDATE_TIME_ADJ_ASSIGN($status, $emp_id, $date_created, $id)
  {
    $sql = "UPDATE tbl_attendance_adjustments SET status=?, approver1=?, approver1_date=? WHERE id=? ";
    $query = $this->db->query($sql, array($status, $emp_id, $date_created, $id));
  }

  function UPDATE_TIME_ADJ_ASSIGN2($status, $emp_id, $date_created, $id)
  {
    $sql = "UPDATE tbl_attendance_adjustments SET status=?, approver2=?, approver2_date=? WHERE id=? ";
    $query = $this->db->query($sql, array($status, $emp_id, $date_created, $id));
  }

  function UPDATE_TIME_ADJ_ASSIGN3($status, $emp_id, $date_created, $id)
  {
    $sql = "UPDATE tbl_attendance_adjustments SET status=?, approver3=?, approver3_date=? WHERE id=? ";
    $query = $this->db->query($sql, array($status, $emp_id, $date_created, $id));
  }

  function GET_APPROVED_TIME_ADJUSTMENT($id)
  {
    $sql = "SELECT * FROM tbl_attendance_adjustments WHERE status = 'Approved' AND id=?";
    $query = $this->db->query($sql, array($id));
    return $query->row();
  }

  function GET_ATTENDANCE_SHIFT($code)
  {
    $sql = "SELECT * FROM tbl_attendance_shifts WHERE code=?";
    $query = $this->db->query($sql, array($code));
    return $query->row();
  }

  function IS_DUPLICATE_TIME_ADDJ($empl_id, $date)
  {
    $sql = "SELECT id FROM tbl_attendance_records WHERE empl_id=? AND date=?";
    $query = $this->db->query($sql, array($empl_id, $date));
    return $query->num_rows();
  }

  function IS_DUPLICATE_ATTENDANCE_SHIFTASSIGN($empl_id, $date)
  {
    $sql = "SELECT id FROM tbl_attendance_shiftassign WHERE empl_id=? AND date=?";
    $query = $this->db->query($sql, array($empl_id, $date));
    return $query->num_rows();
  }

  function INSERT_TIME_ADJUSTMENT($timeIn1, $timeOut1, $timeIn2, $timeOut2, $empl_id, $date)
  {
    $sql = "INSERT INTO tbl_attendance_records (date, empl_id, time_in1, time_out1, time_in2, time_out2) VALUES (?,?,?,?,?,?)";
    $query = $this->db->query($sql, array($date, $empl_id, $timeIn1, $timeOut1, $timeIn2, $timeOut2));
  }

  function UPDATE_TIME_ADJUSTMENT($timeIn1, $timeOut1, $timeIn2, $timeOut2, $empl_id, $date)
  {
    $sql = "UPDATE tbl_attendance_records SET time_in1=?, time_out1=?, time_in2=?, time_out2=? WHERE empl_id=? AND date=?";
    $query = $this->db->query($sql, array($timeIn1, $timeOut1, $timeIn2, $timeOut2, $empl_id, $date));
  }

  function INSERT_ATTENDANCE_SHIFT_ASSIGN($shift_id, $empl_id, $date)
  {
    $sql = "INSERT INTO tbl_attendance_shiftassign (empl_id, date, shift_id) VALUES (?,?,?)";
    $query = $this->db->query($sql, array($empl_id, $date, $shift_id));
  }

  function UPDATE_ATTENDANCE_SHIFT_ASSIGN($shift_id, $empl_id, $date)
  {
    $sql = "UPDATE tbl_attendance_shiftassign SET shift_id=? WHERE empl_id=? AND date=?";
    $query = $this->db->query($sql, array($shift_id, $empl_id, $date));
  }

  function update_overtimeStatus($id, $newStatus)
  {
    $query = $this->db
      ->set('status', $newStatus)
      ->where('id', $id)
      ->update('tbl_overtimes');
    return $query;
  }

  function update_timeAdjustmentStatus($id, $newStatus)
  {
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

  function employeInfo($id)
  {
    $query = $this->db
      ->select('id,col_suffix, col_frst_name, col_last_name, col_midl_name, col_imag_path')
      ->where('id', $id)
      ->get('tbl_employee_infos');
    return $query->result();
  }

  function leave_type($id)
  {
    $query = $this->db
      ->select('name')
      ->where('id', $id)
      ->get('tbl_std_leavetypes');
    $result = $query->result_array();
    return $result[0]["name"];
  }

  function GET_POSITION()
  {
    $sql = "SELECT id,name FROM tbl_std_positions";
    $query = $this->db->query($sql, array());
    $query->next_result();
    return $query->result();
  }

  function GET_FILE_PATH($id)
  {
    $sql = "SELECT attachment FROM tbl_hr_announcements WHERE id=?";
    $query = $this->db->query($sql, array($id));
    $result = $query->result_array();
    return $result[0]["attachment"];
  }

  function GET_WELCOME_MESSAGE()
  {
    $tableName = 'tbl_hr_welcomemessage';
    $columnName = 'html_content';
    $idToRetrieve = 1;
    $query = $this->db->select($columnName)->from($tableName)->where('id', $idToRetrieve)->get();
    if ($query->num_rows() > 0) {
      $result = $query->row();
      $htmlContent = $result->$columnName;
      $data = array('htmlContent' => $htmlContent);
      return $data;
    } else {
      return array('htmlContent' => 'No Message');;
    }
  }

  function GET_ATTENDANCE_RECORD_TODAY_BY_ID_DATE($empl_id, $date)
  {
    $sql = "SELECT * FROM tbl_attendance_records WHERE empl_id = ? AND date=? ";
    $query = $this->db->query($sql, array($empl_id, $date));
    $query->next_result();
    return $query->row_array();
  }

  function GET_ATTENDANCE_RECORD_DATE_BY_ID_ZKTECO($empl_id, $date, $punchState)
  {
    $sql = "SELECT 
                    tbl_zkteco.punch_time
                FROM tbl_zkteco
                LEFT JOIN tbl_zkteco_code ON tbl_zkteco.emp_code = tbl_zkteco_code.empl_code
                LEFT JOIN tbl_employee_infos ON tbl_zkteco_code.empl_id = tbl_employee_infos.id
                WHERE tbl_employee_infos.id = ? AND DATE(tbl_zkteco.punch_time)=? AND tbl_zkteco.punch_state=?
                ORDER BY tbl_zkteco.punch_time ASC
                ";
    $query = $this->db->query($sql, array($empl_id, $date, $punchState));
    $query->next_result();
    return $query->row_array();
  }

  function GET_ATTENDANCE_SHIFT_ASSIGN_ID_TODAY_BY_EMP_ID($empl_id)
  {
    $dateStart = date("Y-m-d");
    $dateEnd = date("Y-m-d", strtotime("-1 day"));
    $sql = "SELECT shift_id, date FROM tbl_attendance_shiftassign WHERE empl_id = ? AND (date = ? OR date = ? OR (date BETWEEN ? AND ?))";
    $query = $this->db->query($sql, array($empl_id, $dateStart, $dateEnd, $dateStart, $dateEnd))->result_array();
    return $query;
  }

  function GET_ATTENDANCE_SHIFT_BY_ID($id)
  {
    $sql = "SELECT code, time_regular_start, time_regular_end FROM tbl_attendance_shifts WHERE id=?";
    $query = $this->db->query($sql, array($id))->result_array();
    return $query;
  }

  function GET_SPECIFIC_ATTENDANCE_LOG_IN_OUT($user_id, $startDate, $endDate)
  {
    $sql = "SELECT date, time_in, time_out FROM tbl_attendance_records WHERE empl_id=? AND date BETWEEN ? AND ?";
    $query = $this->db->query($sql, array($user_id, $startDate, $endDate));
    $query->next_result();
    return $query->result();
  }

  function GET_SPECIFIC_LEAVE_ASSIGN($user_id, $startDate, $endDate)
  {
    $sql = "SELECT type, leave_date, duration FROM tbl_leaves_assign WHERE status = 'Approved' AND empl_id=? AND leave_date BETWEEN ? AND ? ORDER BY id";
    $query = $this->db->query($sql, array($user_id, $startDate, $endDate));
    $query->next_result();
    return $query->result();
  }

  function GET_SPECIFIC_LEAVE_NAME($id)
  {
    $sql = "SELECT name FROM tbl_std_leavetypes WHERE id=?";
    $query = $this->db->query($sql, array($id));
    $result = $query->row();
    return $result->name;
  }

  function GET_SPECIFIC_ATTENDANCE_EMPLOYEES_SHIFT($user_id, $period_start, $period_end)
  {
    $sql =  "SELECT tb2.code,  tb1.date, tb1.empl_id,  tb2.time_regular_start,  tb2.time_regular_end, tb2.time_regular_reg FROM  tbl_attendance_shiftassign AS tb1 INNER JOIN  tbl_attendance_shifts AS tb2 ON  tb2.id = tb1.shift_id  
        WHERE tb1.empl_id=? AND  tb1.date >= '$period_start' AND tb1.date <='$period_end'";
    $query = $this->db->query($sql, array($user_id));
    $query->next_result();
    return $query->result();
  }

  function GET_USER_APPROVERS($id, $table)
  {
    $this->db->select('tb1.id,approver_1a,approver_2a,approver_3a,tb1.empl_id');
    $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as approver_1", false);
    $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',RPAD(LEFT(tb3.col_midl_name,1),2,'.')) as approver_2", false);
    $this->db->select("CONCAT(tb4.col_last_name,',',tb4.col_frst_name,' ',RPAD(LEFT(tb4.col_midl_name,1),2,'.')) as approver_3", false);
    $this->db->select("CONCAT(tb5.col_last_name,',',tb5.col_frst_name,' ',RPAD(LEFT(tb5.col_midl_name,1),2,'.')) as employee", false);
    $this->db->from($table . ' as tb1');
    $this->db->join('tbl_employee_infos as tb2', 'tb1.approver_1a=tb2.id', 'left');
    $this->db->join('tbl_employee_infos as tb3', 'tb1.approver_2a=tb3.id', 'left');
    $this->db->join('tbl_employee_infos as tb4', 'tb1.approver_3a=tb4.id', 'left');
    $this->db->join('tbl_employee_infos as tb5', 'tb1.empl_id=tb5.id', 'left');
    $this->db->where('tb1.empl_id', $id);
    $query = $this->db->get();
    return $query->row();
  }
  function NOTIFICATION_COUNT($user_id)
  {
    $this->db->select('*')
      ->where('empl_id', $user_id)
      ->where('is_read', '0');
    $query = $this->db->get('tbl_notifications');
    return $query->num_rows();
  }
  function ADD_NOTIFICATION($data)
  {
    $this->db->insert('tbl_notifications', $data);
    return $this->db->insert_id();
  }

  function GET_PAYROLL_PERIOD()
  {
    $sql = "SELECT name, date_from, date_to FROM tbl_payroll_period WHERE status='Active' ";
    $query = $this->db->query($sql, array());
    return $query->result();
  }

  function GET_LATEST_PAYROLL_PERIOD_2($date_yesterday)
  {
    $sql = "SELECT name, date_from, date_to FROM tbl_payroll_period WHERE status='Active' AND  date_from <= '$date_yesterday' AND date_to >= '$date_yesterday' LIMIT 1";
    $query = $this->db->query($sql, array());
    return $query->row();
  }

  function GET_LATEST_PAYROLL_PERIOD()
  {
    $sql = "SELECT name, date_from, date_to FROM tbl_payroll_period WHERE status='Active' ORDER BY id DESC LIMIT 1";
    $query = $this->db->query($sql, array());
    return $query->row();
  }

  function GET_SECOND_TO_LAST_PAYROLL_PERIOD()
  {
    $sql = "SELECT name, date_from, date_to FROM tbl_payroll_period WHERE status='Active' ORDER BY id DESC LIMIT 1 OFFSET 1";
    $query = $this->db->query($sql, array());
    return $query->row();
  }

  function GET_ZKTECO_ATTENDANCE($empl_id, $period_start, $period_end)
  {
    $sql = "SELECT empl_id, punch_time, punch_state  FROM tbl_zkteco
        LEFT JOIN tbl_zkteco_code ON tbl_zkteco.emp_code = tbl_zkteco_code.empl_code
        WHERE tbl_zkteco_code.empl_id=? AND DATE(tbl_zkteco.punch_time) BETWEEN ? AND ?";
    $query = $this->db->query($sql, array($empl_id, $period_start, $period_end));
    $query->next_result();
    return $query->result();
  }

  function GET_EMPOYEE($id)
  {
    $this->db->select('id,col_last_name,col_frst_name,col_midl_name');
    $this->db->where('id', $id);
    $query = $this->db->get('tbl_employee_infos');
    return $query->row();
  }

  function GET_LEAVE_ENTITLEMENT_DATA($empl_id, $year){

    $sql = "SELECT tb1.id, tb1.name, tb2.value 
      FROM tbl_std_leavetypes AS tb1
      LEFT JOIN tbl_leaves_settings s ON tb1.leave_setting_id = s.id
      LEFT JOIN tbl_leave_entitlements AS tb2 ON tb1.name = tb2.type AND tb2.empl_id=? AND tb2.year=?
      WHERE (s.value IS NULL OR s.value = 1) 
      AND tb1.status = 'Active'
      AND tb1.id != 1
      ORDER BY tb1.id";
    $query = $this->db->query($sql, array($empl_id, $year));
    $query->next_result();
    return $query->result();
  }

  function get_leaves_total($empl_id, $type, $date_from, $date_to)
  {
      $query = "SELECT SUM(duration) AS total_duration 
      FROM tbl_leaves_assign 
      WHERE leave_date >= ? AND leave_date <= ? 
      AND empl_id = ? AND type = ? 
      AND status NOT IN ('Withdraw', 'Withdrawed', 'Rejected', 'Withdrawn')";

      $query = $this->db->query($query, array($date_from, $date_to, $empl_id, $type));
      $query->next_result();
      $result = $query->result();
      return $result[0]->total_duration;
  }
  
  function get_years() {
    $sql = "SELECT id FROM tbl_std_years ORDER BY id DESC LIMIT 1";
    $query = $this->db->query($sql);
    $result = $query->row();
    return $result ? $result->id : null;
  }





  
}
