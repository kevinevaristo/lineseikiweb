<?php
class offsets_model extends CI_Model
{
    // function GET_EMPL_INFO()                        
    // {
    //     $sql = "SELECT id,name FROM tbl_employee_infos";
    //     $query = $this->db->query($sql, array());
    //     $query->next_result();
    //     return $query->result();
    // }

    // function GET_SECTIONS()                        
    // {
    //     $sql = "SELECT id,name FROM tbl_std_sections";
    //     $query = $this->db->query($sql, array());
    //     $query->next_result();
    //     return $query->result();
    // }
    function GET_EMPLOYEES()
    {
        $this->db->select('id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name');
        $this->db->where("disabled = 0 AND (termination_date IS NULL OR termination_date = '0000-00-00') ");
        $this->db->order_by('col_empl_cmid + 0 ', 'ASC');
        $query = $this->db->get('tbl_employee_infos');
        return $query->result();
    }
    function get_payroll_period($date){
        $query = "SELECT date_from, date_to FROM maiya_hrms.tbl_payroll_period WHERE ? >= date_from AND ? <= date_to";
        return $this->db->query($query, array($date, $date))->row_array();
    }
    function get_offset_entitlement($empl_id,$typeName,$year){
        $query = "SELECT tb1.value, tb1.empl_id,tb1.type, tb2.name as year FROM maiya_hrms.tbl_offset_entitlements as tb1
        left join maiya_hrms.tbl_std_years as tb2 on
        tb1.year = tb2.id
        where empl_id=? AND type =? AND tb2.name =?";
        return $this->db->query($query, array($empl_id, $typeName, $year))->row_array();
    }
    function get_leaves_total($empl_id,$type,$date_from,$date_to){
        $query = "SELECT SUM(duration) AS total_duration FROM maiya_hrms.tbl_offsets_assign WHERE offset_date >= ? AND offset_date <= ? 
        AND empl_id=? AND type=?
        AND status != 'Rejected' ";
        $query = $this->db->query($query, array($date_from, $date_to,$empl_id,$type));
        $query->next_result();
        $result = $query->result();
        return $result[0]->total_duration;
    }
    function GET_SETUP_SETTING($setting){
        $this->db->where('setting',$setting);
        $query=$this->db->get('tbl_system_setup');
        $val=$query->row();
        return $val->value;
    }
    function GET_SETUP_OFFSET_SETTING($setting){
        $this->db->where('setting',$setting);
        $query=$this->db->get('tbl_system_setup');
        if ($query->num_rows() > 0) {
            $val = $query->row();
            return $val->value;
        } else {
            return null;
        }
    }
    function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'maiya_reset'";
        return $this->db->query($query)->row_array();
    }

    function GET_YEARS()
    {
        $sql   = "SELECT id,name FROM tbl_std_years";
        $query = $this->db->query($sql, array());
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

    function GET_OFFSETS($status, $search, $limit, $offset, $filter_arr)
    {
        $new_filter = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb2.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb2.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb2.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select('tb1.id')
            ->select("
                CONCAT_WS(
                    '', 
                    COALESCE(tb3.col_last_name, ''), 
                    CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix != '' THEN CONCAT(' ', tb3.col_suffix) ELSE '' END, ', ',
                    COALESCE(tb3.col_frst_name, ''), 
                    CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name != '' THEN CONCAT(' ', LEFT(tb3.col_midl_name, 1), '.') ELSE '' END
                ) AS assigned_by
                ", false)
            ->select("
                CONCAT_WS(
                    '', 
                    COALESCE(tb2.col_last_name, ''), 
                    CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END, ', ',
                    COALESCE(tb2.col_frst_name, ''), 
                    CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
                ) AS employee
                ", false)
            ->select("CONCAT('LEAV', LPAD(tb1.id, 5, '0')) as c_id", false)
            ->select('tb4.name as type')
            ->select('tb1.offset_date')
            ->select('tb1.duration')
            ->select('tb1.status')
            ->select('tb1.remarks,tb1.reason')
            ->select('tb2.id as employee_table_id')
            ->select('tb3.id as assigned_table_id')
            ->from('tbl_offsets_assign as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left')
            ->join('tbl_employee_infos as tb3', 'tb1.assigned_by = tb3.id', 'left')
            ->join('tbl_std_offsettypes as tb4', 'tb1.type = tb4.id', 'left');
        if (!empty($new_filter)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        if (!empty($search)) {
            $this->db->where('tb2.id', $search);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('tb1.id','desc');
        $query = $this->db->get();
        return $query->result();
    }

    function GET_OFFSETS_COUNT($search, $status, $filter_arr)
    {
        $new_filter                         = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb2.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb2.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb2.col_empl_team']    = $filter_arr['team'];
        $filtered                           = array_filter($new_filter);
        $this->db->select('tb1.id')
            ->select("CONCAT(tb3.col_last_name, ' ', tb3.col_midl_name, ',', tb3.col_frst_name) AS assigned_by", false)
            ->select("CONCAT(tb2.col_last_name, ' ', tb2.col_midl_name, ',', tb2.col_frst_name) AS employee", false)
            ->select("CONCAT('LEAV', LPAD(tb1.id, 5, '0')) as c_id", false)
            ->select('tb4.name as type')
            ->select('tb1.offset_date')
            ->select('tb1.duration')
            ->select('tb1.status')
            ->select('tb1.remarks')
            ->from('tbl_offsets_assign as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left')
            ->join('tbl_employee_infos as tb3', 'tb1.assigned_by = tb3.id', 'left')
            ->join('tbl_std_offsettypes as tb4', 'tb1.type = tb4.id', 'left');
        if (!empty($new_filter)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        if (!empty($search)) {
            $this->db->where('tb2.id', $search);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function GET_LEAVE($id)
    {
        $query = $this->db->select('*')
            ->where('id', $id)
            ->limit('1')
            ->get('tbl_offsets_assign');
        return $query->row();
    }

    function GET_LEAVE_APPROVAL_STATUS($id)
    {
        $this->db->select('tb1.id,tb1.empl_id,tb1.offset_date,tb1.duration,tb1.status,tb1.reason,tb1.create_date,tb1.remarks,tb1.attachment,
        tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,tb8.name as type,
        tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat,
        tb3.approver_1a,tb3.approver_2a,tb3.approver_3a
        ');
        // $this->db->select('CONCAT(tb2.col_last_name, ", ", tb2.col_frst_name, " ", LEFT(tb2.col_midl_name,1),".") as employee', false);
        $this->db->select("
            CONCAT_WS('',COALESCE(tb2.col_last_name, ''), 
                CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END, ', ',
                COALESCE(tb2.col_frst_name, ''), 
                CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
            ) AS employee", false);

        // $this->db->select('CONCAT(tb4.col_last_name, ", ", tb4.col_frst_name, " ", LEFT(tb4.col_midl_name,1),".") as approver1', false);
        $this->db->select("CONCAT_WS('',COALESCE(tb4.col_last_name, ''), 
            CASE WHEN tb4.col_suffix IS NOT NULL AND tb4.col_suffix != '' THEN CONCAT(' ', tb4.col_suffix) ELSE '' END, ', ',
            COALESCE(tb4.col_frst_name, ''), 
            CASE WHEN tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name != '' THEN CONCAT(' ', LEFT(tb4.col_midl_name, 1), '.') ELSE '' END
            ) AS approver1", false);

        // $this->db->select('CONCAT(tb5.col_last_name, ", ", tb5.col_frst_name, " ", LEFT(tb5.col_midl_name,1),".") as approver2', false);
        $this->db->select("CONCAT_WS('',COALESCE(tb5.col_last_name, ''), 
            CASE WHEN tb5.col_suffix IS NOT NULL AND tb5.col_suffix != '' THEN CONCAT(' ', tb5.col_suffix) ELSE '' END, ', ',
            COALESCE(tb5.col_frst_name, ''), 
            CASE WHEN tb5.col_midl_name IS NOT NULL AND tb5.col_midl_name != '' THEN CONCAT(' ', LEFT(tb5.col_midl_name, 1), '.') ELSE '' END
            ) AS approver2", false);

        // $this->db->select('CONCAT(tb6.col_last_name, ", ", tb6.col_frst_name, " ", LEFT(tb6.col_midl_name,1),".") as approver3,', false);
        $this->db->select("CONCAT_WS('',COALESCE(tb6.col_last_name, ''), 
            CASE WHEN tb6.col_suffix IS NOT NULL AND tb6.col_suffix != '' THEN CONCAT(' ', tb6.col_suffix) ELSE '' END, ', ',
            COALESCE(tb6.col_frst_name, ''), 
            CASE WHEN tb6.col_midl_name IS NOT NULL AND tb6.col_midl_name != '' THEN CONCAT(' ', LEFT(tb6.col_midl_name, 1), '.') ELSE '' END
            ) AS approver3", false);

        // $this->db->select('CONCAT(tb7.col_last_name, ", ", tb7.col_frst_name, " ", LEFT(tb7.col_midl_name,1),".") as assigned_by,', false);
        $this->db->select("CONCAT_WS('',COALESCE(tb7.col_last_name, ''), 
            CASE WHEN tb7.col_suffix IS NOT NULL AND tb7.col_suffix != '' THEN CONCAT(' ', tb7.col_suffix) ELSE '' END, ', ',
            COALESCE(tb7.col_frst_name, ''), 
            CASE WHEN tb7.col_midl_name IS NOT NULL AND tb7.col_midl_name != '' THEN CONCAT(' ', LEFT(tb7.col_midl_name, 1), '.') ELSE '' END
            ) AS assigned_by", false);

        // $this->db->select('CONCAT(tb9.col_last_name, ", ", tb9.col_frst_name, " ", LEFT(tb9.col_midl_name,1),".") as pending_approver1', false);
        $this->db->select("CONCAT_WS('',COALESCE(tb9.col_last_name, ''), 
            CASE WHEN tb9.col_suffix IS NOT NULL AND tb9.col_suffix != '' THEN CONCAT(' ', tb9.col_suffix) ELSE '' END, ', ',
            COALESCE(tb9.col_frst_name, ''), 
            CASE WHEN tb9.col_midl_name IS NOT NULL AND tb9.col_midl_name != '' THEN CONCAT(' ', LEFT(tb9.col_midl_name, 1), '.') ELSE '' END
            ) AS pending_approver1", false);

        // $this->db->select('CONCAT(tb10.col_last_name, ", ",tb10.col_frst_name," ", LEFT(tb10.col_midl_name,1),".")as pending_approver2', false);
        $this->db->select("CONCAT_WS('',COALESCE(tb10.col_last_name, ''), 
            CASE WHEN tb10.col_suffix IS NOT NULL AND tb10.col_suffix != '' THEN CONCAT(' ', tb10.col_suffix) ELSE '' END, ', ',
            COALESCE(tb10.col_frst_name, ''), 
            CASE WHEN tb10.col_midl_name IS NOT NULL AND tb10.col_midl_name != '' THEN CONCAT(' ', LEFT(tb10.col_midl_name, 1), '.') ELSE '' END
            ) AS pending_approver2", false);

        // $this->db->select('CONCAT(tb11.col_last_name, ", ",tb11.col_frst_name," ", LEFT(tb11.col_midl_name,1),".")as pending_approver3,', false);
        $this->db->select("CONCAT_WS('',COALESCE(tb11.col_last_name, ''), 
            CASE WHEN tb11.col_suffix IS NOT NULL AND tb11.col_suffix != '' THEN CONCAT(' ', tb11.col_suffix) ELSE '' END, ', ',
            COALESCE(tb11.col_frst_name, ''), 
            CASE WHEN tb11.col_midl_name IS NOT NULL AND tb11.col_midl_name != '' THEN CONCAT(' ', LEFT(tb11.col_midl_name, 1), '.') ELSE '' END
            ) AS pending_approver3", false);

        $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,tb6.col_imag_path as approver_3_img');
        $this->db->select('tb9.col_imag_path as pending_approver1_img,tb10.col_imag_path as pending_approver2_img,tb11.col_imag_path as pending_approver3_img');
        $this->db->from('tbl_offsets_assign as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_approvers_leave as tb3', 'tb1.empl_id            = tb3.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver1     = tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.approver2     = tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver3     = tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
        $this->db->join('tbl_std_offsettypes as tb8', 'tb1.type          = tb8.id', 'left');
        $this->db->join('tbl_employee_infos as tb9', 'tb3.approver_1a   = tb9.id', 'left');
        $this->db->join('tbl_employee_infos as tb10', 'tb3.approver_2a  = tb10.id', 'left');
        $this->db->join('tbl_employee_infos as tb11', 'tb3.approver_3a  = tb11.id', 'left');
        $this->db->where('tb1.id', $id);
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row();
    }

    function UPDATE_LEAVE($data, $id)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_offsets_assign', $data);
    }

    function MOD_UPDT_LEAVE_DETAILS($date_requested, $date_leave, $type, $leave_reason, $duration, $status, $row_id)
    {
        $sql   = "UPDATE tbl_offsets_assign SET col_date_created=?, col_leave_from=?, col_leave_type=?, col_leave_comments=?, col_leave_duration=?, col_leave_status1=? WHERE id = ?";
        $query = $this->db->query($sql, array($date_requested, $date_leave, $type, $leave_reason, $duration, $status, $row_id));
    }

    // function MOD_DISP_ASSIGNED_LEAVE(){             
    //     $sql = "SELECT * FROM tbl_offsets_assign ORDER BY col_date_created DESC";
    //     $query = $this->db->query($sql,array());
    //     $query->next_result();
    //     return $query->result();
    // }

    // function MOD_INSRT_ASSIGN_LEAVE($leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $new_leave_balance){
    //     $sql = "INSERT INTO tbl_offsets_assign (col_date_created,col_leave_type,col_leave_from,col_leave_duration,col_leave_comments,col_leave_status1,col_assigned_by,col_empl_id,col_leave_balance) VALUES (?,?,?,?,?,?,?,?,?)";
    //     $query = $this->db->query($sql,array(date('Y-m-d'),$leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $new_leave_balance));
    //     return;
    // }

    function MOD_INSRT_ASSIGN_LEAVE_SINGLE($leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $new_leave_balance)
    {
        $sql   = "INSERT INTO tbl_offsets_assign (col_date_created,col_leave_type,col_leave_from,col_leave_duration,col_leave_comments,col_leave_status1,col_leave_status2,col_leave_status3,col_assigned_by,col_empl_id,col_leave_balance) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array(date('Y-m-d'), $leave_type, $date, $duration, $comment, 'Pending Approval', 'Pending Approval', 'Pending Approval', $assigned_by, $employee_id, $new_leave_balance));
        return $this->db->insert_id();
    }

    function MOD_UPDT_LEAVE_STATUS_APPR1($status, $leave_insrt_id)
    {
        $sql   = "UPDATE tbl_offsets_assign SET col_leave_status1=? WHERE id = ?";
        $query = $this->db->query($sql, array($status, $leave_insrt_id));
    }

    function MOD_UPDT_LEAVE_STATUS_APPR2($status, $leave_insrt_id)
    {
        $sql   = "UPDATE tbl_offsets_assign SET col_leave_status2=? WHERE id = ?";
        $query = $this->db->query($sql, array($status, $leave_insrt_id));
    }

    function MOD_UPDT_LEAVE_STATUS_APPR3($status, $leave_insrt_id)
    {
        $sql   = "UPDATE tbl_offsets_assign SET col_leave_status3=? WHERE id = ?";
        $query = $this->db->query($sql, array($status, $leave_insrt_id));
    }

    function MOD_INSRT_ASSIGN_LEAVE_SINGLE_WITH_FILE($leave_type, $date, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $new_leave_balance)
    {
        $sql   = "INSERT INTO tbl_offsets_assign (col_date_created,col_leave_type,col_leave_from,col_leave_duration,col_leave_comments,col_leave_status1,col_leave_status2,col_leave_status3,col_assigned_by,col_empl_id,col_leave_image,col_leave_balance) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array(date('Y-m-d'), $leave_type, $date, $duration, $comment, 'Pending Approval', 'Pending Approval', 'Pending Approval', $assigned_by, $employee_id, $leave_file, $new_leave_balance));
        return $this->db->insert_id();
    }

    function MOD_INSRT_ASSIGN_LEAVE_MULTIPLE($leave_type, $date_from, $date_to, $duration, $comment, $status, $assigned_by, $employee_id, $new_leave_balance)
    {
        $sql   = "INSERT INTO tbl_offsets_assign (col_date_created,col_leave_type,col_leave_from,col_leave_to,col_leave_duration,col_leave_comments,col_leave_status1,col_leave_status2,col_leave_status3,col_assigned_by,col_empl_id,col_leave_balance) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array(date('Y-m-d'), $leave_type, $date_from, $date_to, $duration, $comment, 'Pending Approval', 'Pending Approval', 'Pending Approval', $assigned_by, $employee_id, $new_leave_balance));
        return $this->db->insert_id();
    }

    function MOD_INSRT_ASSIGN_LEAVE_MULTIPLE_WITH_FILE($leave_type, $date_from, $date_to, $duration, $comment, $status, $assigned_by, $employee_id, $leave_file, $new_leave_balance)
    {
        $sql   = "INSERT INTO tbl_offsets_assign (col_date_created,col_leave_type,col_leave_from,col_leave_to,col_leave_duration,col_leave_comments,col_leave_status1,col_leave_status2,col_leave_status3,col_assigned_by,col_empl_id,col_leave_image,col_leave_balance) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array(date('Y-m-d'), $leave_type, $date_from, $date_to, $duration, $comment, 'Pending Approval', 'Pending Approval', 'Pending Approval', $assigned_by, $employee_id, $leave_file, $new_leave_balance));
        return $this->db->insert_id();
    }

    function MOD_UPDT_LEAVE_BALANCE($leave_type, $total_leave_balance, $employee_id)
    {
        $sql   = "UPDATE tbl_employee_infos SET " . $leave_type . "=? WHERE id = ?";
        $query = $this->db->query($sql, array($total_leave_balance, $employee_id));
    }

    function MOD_INSRT_ENTITLEMENT($date, $leave_type, $comment, $assigned_by, $employee_id, $value, $total_leave_balance)
    {
        $sql   = "INSERT INTO tbl_offset_entitlements (col_date_created,col_leave_type,col_leave_comments,col_assigned_by,col_empl_id,col_leave_value,col_leave_balance) VALUES (?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($date, $leave_type, $comment, $assigned_by, $employee_id, $value, $total_leave_balance));
        return;
    }

    function MOD_GET_EMPL_CURRENT_BALANCE($leave_type, $user_id)
    {
        $sql   = "SELECT " . $leave_type . " FROM tbl_employee_infos WHERE id=?";
        $query = $this->db->query($sql, array($user_id));
        $row   = $query->row_array();
        return $row;
    }

    // function MOD_DISP_ENTITLEMENT(){                                        
    //     $sql = "SELECT * FROM tbl_offset_entitlements ORDER BY id desc";
    //     $query = $this->db->query($sql,array());
    //     $query->next_result();
    //     return $query->result();
    // }

    // function MOD_DISP_ENTITLEMENT_LIMIT(){                                  
    //     $sql = "SELECT * FROM tbl_offset_entitlements ORDER BY id DESC LIMIT 10";
    //     $query = $this->db->query($sql,array());
    //     $query->next_result();
    //     return $query->result();
    // }

    function MOD_DISP_SPECIFIC_APPROVAL_ROUTE($empl_id)
    {
        $sql   = "SELECT * FROM tbl_leave_approvers WHERE employee=? ORDER BY id ASC";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }

    // function MOD_DISP_USED_LEAVE($empl_id, $start_date, $end_date){         
    //     $sql = "SELECT * FROM tbl_offsets_assign WHERE col_empl_id=? AND col_date_created>=? AND col_date_created<=? AND col_leave_status1='Approved' AND col_leave_status2='Approved' AND col_leave_status3='Approved'";
    //     $query = $this->db->query($sql,array($empl_id, $start_date, $end_date));
    //     $query->next_result();
    //     return $query->result();
    // }

    function MOD_DISP_EMPL_LEAVE_DATA($empl_id)
    {
        $sql   = "SELECT * FROM tbl_employee_infos WHERE id=?";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }

    // function MOD_GET_APPLICATION_INFO($empl_id, $start_date, $end_date){               
    //     $sql = "SELECT * FROM tbl_offsets_assign WHERE col_leave_from >= ? AND col_leave_from <= ? AND col_empl_id=? ORDER BY col_date_created DESC";
    //     $query = $this->db->query($sql,array($start_date, $end_date, $empl_id));
    //     $query->next_result();
    //     return $query->result();
    // }

    // function MOD_GET_APPLICATION_DATE($start_date, $end_date)
    // {
    //     $sql   = "SELECT * FROM tbl_offsets_assign WHERE col_leave_from >= ? AND col_leave_from <= ? ORDER BY col_date_created DESC";
    //     $query = $this->db->query($sql, array($start_date, $end_date));
    //     $query->next_result();
    //     return $query->result();
    // }

    // function MOD_GET_APPLICATION_EMPL($empl_id){                               
    //     $sql = "SELECT * FROM tbl_offsets_assign WHERE col_empl_id=? ORDER BY col_date_created DESC";
    //     $query = $this->db->query($sql,array($empl_id));
    //     $query->next_result();
    //     return $query->result();
    // }

    function MOD_DISP_ALL_APPR_ROUTE_LEAVE()
    {
        $sql   = "SELECT * FROM tbl_leave_approvers ORDER BY tbl_leave_approvers.id ASC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_UPDT_APPROVAL_ROUTE_LEAVE($date, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b, $empl_id)
    {
        $sql   = "UPDATE tbl_leave_approvers SET edit_date=?, approver_1a=?,approver_1b=?,approver_2a=?,approver_2b=?,approver_3a=?,approver_3b=?  WHERE empl_id IN (" . $empl_id . ")";
        $query = $this->db->query($sql, array($date, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b));
    }

    function MOD_INSERT_LEAVE_APPROVER($date, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b, $empl_id)
    {
        $sql   = "INSERT INTO tbl_leave_approvers (create_date, edit_date, empl_id, approver_1a,approver_1b,approver_2a,approver_2b,approver_3a,approver_3b) VALUES (?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($date, $date, $empl_id, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b));
        return;
    }

    function GET_LEAVE_APPROVER($empl_id)
    {
        $sql   = "SELECT * FROM tbl_leave_approvers WHERE empl_id=?";
        $query = $this->db->query($sql, array($empl_id));
        return $query->num_rows();
    }

    // function MOD_DISP_ALL_APPR_ROUTE(){
    //     $sql = "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name FROM tbl_employee_infos WHERE termination_date = '0000-00-00' ORDER BY id ASC";
    //     $query = $this->db->query($sql,array());
    //     $query->next_result();
    //     return $query->result();
    // }

    function MOD_DISP_APPR_ROUT_LIST()
    {
        $sql   = "SELECT * FROM tbl_leave_approvers";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEELIST()
    {
        $sql   = "SELECT id,col_suffix,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,
        col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,
        col_empl_team,col_empl_line FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0
        ORDER BY col_empl_cmid+0 ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_FILTERED_EMPLOYEELIST($offset, $row, $branch, $dept, $division, $section, $group, $team, $line)
    {
        if ($branch    == "all") {
            $branch     = "col_empl_branch";
        }
        if ($dept      == "all") {
            $dept       = "col_empl_dept";
        }
        if ($division  == "all") {
            $division   = "col_empl_divi";
        }
        if ($section   == "all") {
            $section    = "col_empl_sect";
        }
        if ($group     == "all") {
            $group      = "col_empl_group";
        }
        if ($team      == "all") {
            $team       = "col_empl_team";
        }
        if ($line      == "all") {
            $line       = "col_empl_line";
        }

        $sql = "SELECT id,col_suffix,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,
        col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,
        col_empl_line,col_hire_date FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND col_empl_branch = $branch
        AND col_empl_dept   = $dept
        AND col_empl_divi   = $division
        AND col_empl_sect   = $section
        AND col_empl_group  = $group
        AND col_empl_team   = $team
        AND col_empl_line   = $line
        ORDER BY col_empl_cmid+0 ASC
        LIMIT " . $offset . ", " . $row . " ";

        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_FILTERED_EMPLOYEELIST_TABLE($offset, $row, $branch, $dept, $division, $section, $group, $team, $line)
    {
        if ($branch    == "all") {
            $branch     = "col_empl_branch";
        }
        if ($dept      == "all") {
            $dept       = "col_empl_dept";
        }
        if ($division  == "all") {
            $division   = "col_empl_divi";
        }
        if ($section   == "all") {
            $section    = "col_empl_sect";
        }
        if ($group     == "all") {
            $group      = "col_empl_group";
        }
        if ($team      == "all") {
            $team       = "col_empl_team";
        }
        if ($line      == "all") {
            $line       = "col_empl_line";
        }

        $sql = "SELECT id,col_empl_cmid, 
        
        CONCAT_WS('',
        CASE WHEN col_last_name IS NOT NULL AND col_last_name != '' THEN CONCAT(col_last_name) ELSE '' END,   
        CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS fullname,
        
        col_hire_date FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND col_empl_branch = $branch
        AND col_empl_dept   = $dept
        AND col_empl_divi   = $division
        AND col_empl_sect   = $section
        AND col_empl_group  = $group
        AND col_empl_team   = $team
        AND col_empl_line   = $line
        ORDER BY col_empl_cmid +0 ASC
        LIMIT " . $offset . ", " . $row . " ";

        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_FILTERED_EMPLOYEE($branch, $dept, $division, $section, $group, $team, $line)
    {
        if ($branch    == "all") {
            $branch     = "col_empl_branch";
        }
        if ($dept      == "all") {
            $dept       = "col_empl_dept";
        }
        if ($division  == "all") {
            $division   = "col_empl_divi";
        }
        if ($section   == "all") {
            $section    = "col_empl_sect";
        }
        if ($group     == "all") {
            $group      = "col_empl_group";
        }
        if ($team      == "all") {
            $team       = "col_empl_team";
        }
        if ($line      == "all") {
            $line       = "col_empl_line";
        }

        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,col_empl_line FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND col_empl_branch  = $branch
        AND col_empl_dept    = $dept
        AND col_empl_divi    = $division
        AND col_empl_sect    = $section
        AND col_empl_group   = $group
        AND col_empl_team    = $team
        AND col_empl_line    = $line
        ORDER BY col_empl_cmid ASC";

        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function GET_SEARCHED($search)
    {
        // $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0 
        // AND (tbl_employee_infos.col_empl_cmid LIKE '%$search%' 
        // OR CONCAT(col_last_name, ' ', col_frst_name, ' ', col_midl_name) LIKE '%$search%') 
        // ORDER BY id ASC";
        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 and id=?";
        $query = $this->db->query($sql, array($search));
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_EMPLOYEELIST()
    {
        $sql   = "SELECT * FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }

    function GET_EMPLOYEE_SPECIFIC_ROW($employee_id)
    {
        $sql   = "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->row();
    }
    function GET_IS_DUPLICATE_DATE($date)
    {
        $sql = "SELECT * FROM tbl_offsets_assign WHERE offset_date=?";
        $query = $this->db->query($sql, array($date));
        return $query->num_rows();
    }
    function GET_REQUESTOR($type, $id)
    {
        // $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as requestor", false);
        $this->db->select("CONCAT_WS(
            '', 
            COALESCE(tb2.col_last_name, ''), 
            CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END, ', ',
            COALESCE(tb2.col_frst_name, ''), 
            CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) as requestor", false);
        if ($type == 'offset') {
            $this->db->from('tbl_offsets_assign as tb1');
        } else if ($type == 'leave') {
            $this->db->from('tbl_leaves_assign as tb1');
        } else if ($type == 'overtime') {
            $this->db->from('tbl_overtimes as tb1');
        } else if ($type == 'holiday work') {
            $this->db->from('tbl_holidaywork as tb1');
        } else if ($type == 'time adjustment') {
            $this->db->from('tbl_attendance_adjustments as tb1');
        }
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result->requestor;
    }
    function ADD_NOTIFICATION($data)
    {
        $this->db->insert('tbl_notifications', $data);
        return $this->db->insert_id();
    }
    function ADD_OFFSET_REQUEST($data) 
    {
        return $this->db->insert('tbl_offsets_assign', $data);
    }

    function MOD_DISP_GROUP_APPROVERS($group_name)
    {

        $sql   = "SELECT * FROM tbl_approval_groups WHERE group_name=?";

        $query = $this->db->query($sql, array($group_name));

        $query->next_result();

        return $query->result();
    }

    function IS_DUPLICATE($user_id, $year, $type)
    {
        $sql   = "SELECT id FROM tbl_offset_entitlements WHERE empl_id=? AND year=? AND type=?";
        $query = $this->db->query($sql, array($user_id, $year, $type));
        $query->next_result();
        $data  = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }

    function ADD_USER_ENTITLEMENT($user_id, $entitlement_val, $year, $type)
    {

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_offset_entitlements (create_date,edit_date,empl_id,value,year,type) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql, array($create_date, $create_date, $user_id, $entitlement_val, $year, $type));
    }

    function UPDATE_USER_ENTITLEMENT($user_id, $entitlement_val, $year, $type)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_offset_entitlements SET edit_date=?,value=? WHERE empl_id=? AND year=? AND type=?";
        return $this->db->query($sql, array($edit_date, $entitlement_val, $user_id, $year, $type));
    }

    function MOD_DISP_OFFSETTYPES()
    {
        $sql   = "SELECT * FROM tbl_std_offsettypes ORDER BY id ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    // function MOD_DISP_ALL_EMPLOYEES(){                          
    //     $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
    //     $query = $this->db->query($sql, array());
    //     $query->next_result();
    //     return $query->result();

    // }

    function GET_ENTITLEMENT_DATA($year)
    {
        $sql   = "SELECT year,empl_id,type,SUM(value) as value FROM tbl_offset_entitlements WHERE year = $year GROUP BY type,year,empl_id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_FILTER_EMPLOYEES($dept, $sec, $group, $line, $status)
    {

        if ($dept) {
            $filter_q = " AND col_empl_dept=" . $dept;
        } else if ($sec) {
            $filter_q = " AND col_empl_sect=" . $sec;
        } else if ($group) {
            $filter_q = " AND col_empl_group=" . $group;
        } else if ($line) {
            $filter_q = " AND col_empl_line=" . $line;
        } else if ($status) {
            $filter_q = " AND disabled=" . $status;
        } else {
            $filter_q = "";
        }

        $sql   = "SELECT * FROM tbl_employee_infos WHERE disabled=0 " . $filter_q . " ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_EMPL()
    {
        $sql   = "SELECT * FROM tbl_employee_infos WHERE disabled=0 ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_EMPLOYEE($employee_id)
    {
        $sql   = "SELECT * FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_PAY_SCHED()
    {

        $sql   = "SELECT id,name FROM tbl_payroll_period WHERE status='active' ORDER BY id desc";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();
    }

    // function MOD_DISP_DISTICT_Group(){                      

    //     $sql = "SELECT DISTINCT id,name FROM tbl_std_groups";

    //     $query = $this->db->query($sql,array());

    //     $query->next_result();

    //     return $query->result();

    // }

    // function MOD_CHK_GROUP_APPROVERS_EXIST($group_name){       
    //     $sql = "SELECT * FROM tbl_approval_groups WHERE group_name=?";

    //     $query = $this->db->query($sql,array($group_name));

    //     $query->next_result();

    //     return $query->result();

    // }

    function UPDATE_EMPL_ID($empl_id, $user_id)
    {
        $sql   = "UPDATE tbl_employee_infos SET col_empl_cmid=? WHERE id=?";
        $this->db->query($sql, array($empl_id, $user_id));
    }

    function MOD_DISP_EMPLOYEES_ID($id)
    {
        $sql   = "SELECT * FROM tbl_employee_infos WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }

    function MOD_INSERT_APPROVER_DATA($emp_id, $app1a, $app1b, $app2a, $app2b, $app3a, $app3b)
    {
        $sql   = "INSERT INTO tbl_leave_approvers (empl_id,approver_1a,approver_1b,approver_2a,approver_2b,approver_3a,approver_3b) VALUE (?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($emp_id, $app1a, $app1b, $app2a, $app2b, $app3a, $app3b));
        return;
    }

    function GET_ALL_EMP()
    {
        $sql   = "SELECT * FROM tbl_employee_infos";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    // function APPROVER_IS_DUPLICATE($id){                      
    //     $sql = "SELECT * FROM tbl_leave_approvers WHERE empl_id = ?";
    //     $query = $this->db->query($sql, array($id));
    //     return $query->row_num();
    // }

    function INSERT_APPROVAL_CSV($arr_data)
    {
        $arr_data['create_date'] = date('Y-m-d H:i:s');
        $arr_data['edit_date'] = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_leave_approvers (empl_id,approver_1a,approver_1b,approver_2a,approver_2b,approver_3a,approver_3b,create_date,edit_date) VALUES (?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, $arr_data);
        return;
    }

    function UPDATE_APPROVAL_CSV($arr_data)
    {
        $date  = date('Y-m-d H:i:s');
        $sql   = "UPDATE tbl_leave_approvers SET edit_date=?, approver_1a=?,approver_1b=?,approver_2a=?,approver_2b=?,approver_3a=?,approver_3b=?  WHERE empl_id = ?";
        $query = $this->db->query($sql, array($date, $arr_data['approver_1a'], $arr_data['approver_1b'], $arr_data['approver_2a'], $arr_data['approver_2b'], $arr_data['approver_3a'], $arr_data['approver_3b'], $arr_data['Employee_id']));
    }

    function MOD_GET_SEARCHED($search)
    {
        $sql = "SELECT * FROM tbl_employee_infos 
        WHERE col_frst_name LIKE '$search%' OR 
        col_last_name LIKE '$search%' OR 
        col_midl_name LIKE '$search%' OR
        col_empl_group LIKE '$search%' OR
        col_empl_cmid LIKE '%$search%' ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    // function GET_DEPARTMENTS()                     
    // {
    //     $sql = "SELECT id,name FROM tbl_std_departments";
    //     $query = $this->db->query($sql, array());
    //     $query->next_result();
    //     return $query->result();
    // }

    // function GET_GROUPS()                           
    // {
    //     $sql = "SELECT id,name FROM tbl_std_groups";
    //     $query = $this->db->query($sql, array());
    //     $query->next_result();
    //     return $query->result();
    // }

    // function GET_LINES()                             
    // {
    //     $sql = "SELECT id,name FROM tbl_std_lines";
    //     $query = $this->db->query($sql, array());
    //     $query->next_result();
    //     return $query->result();
    // }

    function GET_SYSTEM_SETTING($setting)
    {
        $sql    = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
    }

    function GET_SYSTEM_SETTING_DATA($setting)
    {
        $sql   = "SELECT id, value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    function GET_SYSTEM_SETTING_DATA_NAME($setting)
    {
        $sql   = "SELECT id, setting, value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query = $this->db->query($sql);
        return $query->row_array();
    }



    function UPDATE_SYSTEM_SETTING($data)
    {
        foreach ($data as $id => $newdata) {
            $sql   = "UPDATE tbl_system_setup SET value='" . $newdata . "' WHERE id= '" . $id . "'";
            $query = $this->db->query($sql);
        }
    }

    function MOD_DISP_DISTINCT_BRANCH()
    {
        $sql   = "SELECT DISTINCT id,name FROM tbl_std_branches";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_DEPARTMENT()
    {
        $sql   = "SELECT DISTINCT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_DIVISION()
    {
        $sql   = "SELECT DISTINCT id,name FROM tbl_std_divisions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_SECTION()
    {
        $sql   = "SELECT DISTINCT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_GROUP()
    {
        $sql   = "SELECT DISTINCT id,name FROM tbl_std_groups";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_TEAM()
    {
        $sql   = "SELECT DISTINCT id,name FROM tbl_std_teams";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_LINE()
    {
        $sql   = "SELECT DISTINCT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_STD_DATA($table)
    {
        $this->db->select('id,name')
            ->from($table)
            ->where(array('status' => 'active'));
        $query = $this->db->get();
        return $query->result();
    }

    function GET_SYSTEM_OFFSET_SETTING()
    {
        $sql    = "SELECT value FROM tbl_system_setup WHERE setting = 'offset_setting'";
        $query  = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["value"];
    }

    function MOD_UPDATE_LEAVE_SETTING($val, $setting)
    {
        $sql   = "UPDATE tbl_system_setup SET value=? WHERE setting=?";
        $query = $this->db->query($sql, array($val, $setting));
    }

    function GET_REPORTING_TO_DIRECTS($employeeId)
    {
        $data['reportingTo'] = null;
        $data['employeeInfo']  = null;
        $data['directsTo']  = null;
        $employeeInfo = $this->GET_EMPLOYEE_BY_ID_REPORTING_TO($employeeId);
        if ($employeeInfo) {
            $data['employeeInfo'] = $employeeInfo;
            $position = $this->GET_POSITION_NAME_BY_ID($employeeInfo->col_empl_posi);
            if (!$position) $position = '';
            $data['employeeInfo']->col_empl_posi = $position;
            $company = $this->GET_COMPANY_NAME_BY_ID($employeeInfo->col_empl_company);
            if (!$company) $company = '';
            $data['employeeInfo']->col_empl_company = $company;
            $branch = $this->GET_BRANCH_NAME_BY_ID($employeeInfo->col_empl_branch);
            if (!$branch) $branch = '';
            $data['employeeInfo']->col_empl_branch = $branch;
            $department = $this->GET_DEPARTMENT_NAME_BY_ID($employeeInfo->col_empl_dept);
            if (!$department) $department = '';
            $data['employeeInfo']->col_empl_dept = $department;
            $reportingTo = $this->GET_EMPLOYEE_BY_ID_REPORTING_TO($employeeInfo->reporting_to);
            if ($reportingTo) {
                $data['reportingTo'] = $reportingTo;
            }
        }
        $directsTo = $this->GET_EMPLOYEE_BY_ID_DIRECTS($employeeId);
        if (!empty($directsTo)) {
            $data['directsTo']  = $directsTo;
        }
        return $data;
    }

    // function GET_EMPLOYEE_BY_ID_REPORTING_TO($employeeId){
    //     $sql = "SELECT id,col_empl_company,col_empl_branch,col_empl_dept,col_empl_posi,col_empl_cmid,reporting_to,col_comp_emai,col_last_name,col_midl_name,col_frst_name,col_imag_path FROM tbl_employee_infos WHERE id=? ";
    //     $query = $this->db->query($sql, array($employeeId));
    //     return $query->row();
    // }

    // function GET_EMPLOYEE_BY_ID_DIRECTS($employeeId){
    //     $sql = "SELECT id,col_empl_company,col_empl_branch,col_empl_dept,col_empl_posi,col_empl_cmid,reporting_to,col_comp_emai,col_last_name,col_midl_name,col_frst_name,col_imag_path FROM tbl_employee_infos WHERE reporting_to=? ";
    //     $query = $this->db->query($sql, array($employeeId));
    //     return $query->result();
    // }

    // function GET_POSITION_NAME_BY_ID($postionId) {
    //     $sql = "SELECT name FROM tbl_std_positions WHERE id=?";
    //     $query = $this->db->query($sql, array($postionId));
    //     $result = $query->row();
    //     if ($result) {
    //         return $result->name;
    //     } else {
    //         return null; 
    //     }
    // }

    // function GET_COMPANY_NAME_BY_ID($postionId) {
    //     $sql = "SELECT name FROM tbl_std_companies WHERE id=?";
    //     $query = $this->db->query($sql, array($postionId));
    //     $result = $query->row();
    //     if ($result) {
    //         return $result->name;
    //     } else {
    //         return null; 
    //     }
    // }

    // function GET_BRANCH_NAME_BY_ID($branchId) {
    //     $sql = "SELECT name FROM tbl_std_branches WHERE id=?";
    //     $query = $this->db->query($sql, array($branchId));
    //     $result = $query->row();
    //     if ($result) {
    //         return $result->name;
    //     } else {
    //         return null; 
    //     }
    // }

    // function GET_DEPARTMENT_NAME_BY_ID($departmentId) {
    //     $sql = "SELECT name FROM tbl_std_departments WHERE id=?";
    //     $query = $this->db->query($sql, array($departmentId));
    //     $result = $query->row();
    //     if ($result) {
    //         return $result->name;
    //     } else {
    //         return null; 
    //     }
    // }

    function GET_PERIOD_DATA($sched_id)
    {
        $sql   = "SELECT date_from,date_to FROM tbl_payroll_period WHERE id=? AND status=?  ORDER BY id desc";
        $query = $this->db->query($sql, array($sched_id, 'active'));
        $data  = $query->row_array();

        return $data;
    }

    function GET_HOLIDAY()
    {
        $sql   = "SELECT col_holi_date,col_holi_type FROM tbl_std_holidays";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_SHIFT_DATA_DATERANGE($begin, $end)
    {
        $sql   = "SELECT empl_id,date,shift_id FROM tbl_attendance_shiftassign WHERE date >= '$begin' AND date <= '$end' AND is_deleted=0";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_SHIFT_ALL_DATA()
    {
        $sql   = "SELECT * FROM tbl_attendance_shifts WHERE status='Active'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_WORK_SHIFT_DATA()
    {
        $sql   = "SELECT * FROM tbl_attendance_shifts where is_deleted=0 AND status='Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MON_DISP_CUTOFF_PERIOD($start_date, $end_date, $employee_id)
    {
        $sql   = "SELECT * FROM tbl_attendance_records WHERE date >= ? AND date <= ? AND empl_id=?";
        $query = $this->db->query($sql, array($start_date, $end_date, $employee_id));
        $query->next_result();
        return $query->result();
    }

    function GET_ACQUIRE_OFFSETS($status, $search, $limit, $offset, $filter_arr, $user_id)
    {
        $new_filter = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb2.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb2.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb2.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb2.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        $this->db->select('tb1.id,offset_date, offset_type,time_range,duration,tb1.status,remarks,reason')
            ->select("
                CONCAT_WS(
                    '', 
                    COALESCE(tb3.col_last_name, ''), 
                    CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix != '' THEN CONCAT(' ', tb3.col_suffix) ELSE '' END, ', ',
                    COALESCE(tb3.col_frst_name, ''), 
                    CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name != '' THEN CONCAT(' ', LEFT(tb3.col_midl_name, 1), '.') ELSE '' END
                ) AS assigned_by
                ", false)
            ->select("
                CONCAT_WS(
                    '', 
                    CONCAT(tb2.col_empl_cmid, '-', tb2.col_last_name), 
                    CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> '' THEN CONCAT(' ',tb2.col_suffix) ELSE '' END,
                    CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name <> '' THEN CONCAT(', ',tb2.col_frst_name) ELSE '' END, 
                    CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb2.col_midl_name, 1)), '.') ELSE '' END
                ) AS employee
                ", false)

            ->from('tbl_attendance_offsets_acquire as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left')
            ->join('tbl_employee_infos as tb3', 'tb1.assigned_by = tb3.id', 'left')
            ->join('tbl_std_leavetypes as tb4', 'tb1.type = tb4.id', 'left')
            ->join('tbl_approvers_shift  as tb5', 'tb1.empl_id = tb5.empl_id', 'left');
        if (!empty($new_filter)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        if (!empty($search)) {
            $this->db->where('tb2.id', $search);
        }
        // $this->db->where('(tb1.parent_id = 0 OR tb1.parent_id IS NULL)');
        $this->db->limit($limit, $offset);
        $this->db->order_by('tb1.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }


    function GET_ACQUIRE_OFFSET_COUNT($search, $status, $filter_arr, $user_id)
    {
        $new_filter = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb2.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb2.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb2.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb2.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        $this->db->select('tb1.id')
            ->select("
                CONCAT_WS(
                    '', 
                    CONCAT(tb2.col_empl_cmid, '-', tb2.col_last_name), 
                    CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> '' THEN CONCAT(' ',tb2.col_suffix) ELSE '' END,
                    CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name <> '' THEN CONCAT(', ',tb2.col_frst_name) ELSE '' END, 
                    CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb2.col_midl_name, 1)), '.') ELSE '' END
                ) AS employee
                ", false)

            ->from('tbl_attendance_offsets_acquire as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left')
            ->join('tbl_employee_infos as tb3', 'tb1.assigned_by = tb3.id', 'left')
            ->join('tbl_approvers_shift  as tb5', 'tb1.empl_id = tb5.empl_id', 'left');
        if (!empty($new_filter)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        if (!empty($search)) {
            $this->db->where('tb2.id', $search);
        }
        // $this->db->where('(tb1.parent_id = 0 OR tb1.parent_id IS NULL)');
        $this->db->order_by('tb1.id', 'desc');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function GET_REDEEM_OFFSETS($status, $search, $limit, $offset, $filter_arr, $user_id)
    {
        $new_filter = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb2.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb2.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb2.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb2.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        $this->db->select('tb1.id,offset_date, offset_type,time_range,duration,tb1.status,remarks,reason')
            ->select("
                CONCAT_WS(
                    '', 
                    COALESCE(tb3.col_last_name, ''), 
                    CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix != '' THEN CONCAT(' ', tb3.col_suffix) ELSE '' END, ', ',
                    COALESCE(tb3.col_frst_name, ''), 
                    CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name != '' THEN CONCAT(' ', LEFT(tb3.col_midl_name, 1), '.') ELSE '' END
                ) AS assigned_by
                ", false)
            ->select("
                CONCAT_WS(
                    '', 
                    CONCAT(tb2.col_empl_cmid, '-', tb2.col_last_name), 
                    CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> '' THEN CONCAT(' ',tb2.col_suffix) ELSE '' END,
                    CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name <> '' THEN CONCAT(', ',tb2.col_frst_name) ELSE '' END, 
                    CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb2.col_midl_name, 1)), '.') ELSE '' END
                ) AS employee
                ", false)

            ->from('tbl_attendance_offsets as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left')
            ->join('tbl_employee_infos as tb3', 'tb1.assigned_by = tb3.id', 'left')
            ->join('tbl_std_leavetypes as tb4', 'tb1.type = tb4.id', 'left')
            ->join('tbl_approvers_shift  as tb5', 'tb1.empl_id = tb5.empl_id', 'left');
        if (!empty($new_filter)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        if (!empty($search)) {
            $this->db->where('tb2.id', $search);
        }
        // $this->db->where('(tb1.parent_id = 0 OR tb1.parent_id IS NULL)');
        $this->db->limit($limit, $offset);
        $this->db->order_by('tb1.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function GET_REDEEM_OFFSET_COUNT($search, $status, $filter_arr, $user_id)
    {
        $new_filter = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb2.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb2.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb2.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb2.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        $this->db->select('tb1.id')
            ->select("
                CONCAT_WS(
                    '', 
                    CONCAT(tb2.col_empl_cmid, '-', tb2.col_last_name), 
                    CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> '' THEN CONCAT(' ',tb2.col_suffix) ELSE '' END,
                    CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name <> '' THEN CONCAT(', ',tb2.col_frst_name) ELSE '' END, 
                    CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb2.col_midl_name, 1)), '.') ELSE '' END
                ) AS employee
                ", false)

            ->from('tbl_attendance_offsets as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left')
            ->join('tbl_employee_infos as tb3', 'tb1.assigned_by = tb3.id', 'left')
            ->join('tbl_approvers_shift  as tb5', 'tb1.empl_id = tb5.empl_id', 'left');
        if (!empty($new_filter)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        if (!empty($search)) {
            $this->db->where('tb2.id', $search);
        }
        // $this->db->where('(tb1.parent_id = 0 OR tb1.parent_id IS NULL)');
        $this->db->order_by('tb1.id', 'desc');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function MOD_DISP_ALL_EMPLOYEES($user_id)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 AND reporting_to=? ORDER BY  col_empl_cmid +0 ASC";
        $query = $this->db->query($sql, array($user_id));
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEES_MEMBERS($user_id)
    {
        $sql = "SELECT tb_empl.id,tb_empl.col_suffix,tb_empl.col_empl_cmid,tb_empl.col_last_name,tb_empl.col_midl_name,tb_empl.col_frst_name,
            CONCAT_WS(
                '', 
                CONCAT(col_empl_cmid, '-', col_last_name), 
                CASE WHEN col_suffix IS NOT NULL AND col_suffix <> '' THEN CONCAT(' ', col_suffix) ELSE '' END,
                CASE WHEN col_frst_name IS NOT NULL AND col_frst_name <> '' THEN CONCAT(', ', col_frst_name) ELSE '' END, 
                CASE WHEN col_midl_name IS NOT NULL AND col_midl_name <> '' THEN CONCAT(' ', UPPER(LEFT(col_midl_name, 1)), '.') ELSE '' END
            ) AS fullname
        FROM 
            tbl_employee_infos as tb_empl

        WHERE 
            disabled = 0 
            AND (termination_date IS NULL OR termination_date = '0000-00-00')
            AND reporting_to = ?
        ORDER BY 
            col_empl_cmid + 0 ASC";

        $query = $this->db->query($sql, array($user_id));
        return $query->result();
    }
    function GET_EMPLOYEES_MEMBER()
    {
        $sql = "SELECT tb_empl.id,tb_empl.col_suffix,tb_empl.col_empl_cmid,tb_empl.col_last_name,tb_empl.col_midl_name,tb_empl.col_frst_name,
            CONCAT_WS(
                '', 
                CONCAT(col_empl_cmid, '-', col_last_name), 
                CASE WHEN col_suffix IS NOT NULL AND col_suffix <> '' THEN CONCAT(' ', col_suffix) ELSE '' END,
                CASE WHEN col_frst_name IS NOT NULL AND col_frst_name <> '' THEN CONCAT(', ', col_frst_name) ELSE '' END, 
                CASE WHEN col_midl_name IS NOT NULL AND col_midl_name <> '' THEN CONCAT(' ', UPPER(LEFT(col_midl_name, 1)), '.') ELSE '' END
            ) AS fullname
        FROM 
            tbl_employee_infos as tb_empl

        WHERE 
            disabled = 0 
            AND (termination_date IS NULL OR termination_date = '0000-00-00')
        ORDER BY 
            col_empl_cmid + 0 ASC";

        $query = $this->db->query($sql, array());
        return $query->result();
    }

    function GET_DATE_SETTING($setting)
    {
        $is_exist = $this->db->select("value")->where('setting', $setting)->get("tbl_system_setup")->row();
        if ($is_exist) {
            return $is_exist->value;
        } else {
            $this->db->insert("tbl_system_setup", array('setting' => $setting, 'value' => '0'));
            return 0;
        }
    }

    function GET_TOTAL_REDEEMED_OFFSET($empl_id){
        $sql = "SELECT SUM(duration) AS total_redeemed_offset FROM `tbl_attendance_offsets` WHERE empl_id = ? AND offset_type = 'Redeem' AND (status = 'Approved' OR status LIKE 'Pending%') ";
        $query = $this->db->query($sql, array($empl_id));
        return $query->row();
    }


    function GET_TOTAL_ACQUIRED_OFFSET($empl_id){
        $sql = "SELECT SUM(duration) AS total_acquired_offset FROM `tbl_attendance_offsets_acquire` WHERE empl_id = ? AND offset_type = 'Acquire' AND status = 'Approved' ";
        $query = $this->db->query($sql, array($empl_id));
        return $query->row();
    }





}
