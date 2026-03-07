<?php
class teams_model extends CI_Model
{
    function GET_LEAVE_SETTING($setting)
    {
        $this->db->select('value');
        $this->db->where('setting', $setting);
        $query = $this->db->get('tbl_leaves_settings');
        $data = $query->row();
        return $data->value;
    }
    function getApprovalAutoApproveEnabled($empl_id)
    {
        $this->db->select('COUNT(*) as count');
        $this->db->where('empl_id', $empl_id);
        $this->db->where('auto_approve', 'Enabled');
        $query = $this->db->get('tbl_approvers_leave');
        $result = $query->row();
        if ($result) {
            return $result->count;
        } else {
            return 0;
        }
    }
    function get_system_setup_by_setting($setting, $value)
    {
        $query_select = "SELECT * FROM tbl_system_setup WHERE setting=?";
        $result = $this->db->query($query_select, array($setting))->row_array();
        if (!$result) {
            $query_insert = "INSERT INTO tbl_system_setup (setting, value) VALUES (?, ?)";
            $this->db->query($query_insert, array($setting, $value));
            $query_select_new = "SELECT * FROM tbl_system_setup WHERE setting=?";
            $result = $this->db->query($query_select_new, array($setting))->row_array();
        }
        return $result ? $result['value'] : null;
    }

     function get_system_setup_by_setting2($setting){
        $result = $this->db->select('value')->where('setting', $setting)->get('tbl_system_setup')->row_array();
        if($result){
            return $result['value'];
        } else {
            // If setting doesn't exist, insert with default value
            $this->db->insert('tbl_system_setup', array('setting' => $setting, 'value' => 0));
            return 0;
        }
    }
    function GET_LEAVE_APPROVAL_HOURS($id)
    {
        $sql = "SELECT COALESCE(SUM(duration), 0) AS total_hours FROM tbl_leaves_assign WHERE id=? OR parent_id=?";
        $query = $this->db->query($sql, array($id, $id));
        $result = $query->row();
        return $result->total_hours;
    }
    function MOD_UPDATE_LEAVE_STATUS($id, $status)
    {
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_leaves_assign SET edit_date=?, status=? WHERE id=? or parent_id=?";
        return $this->db->query($sql, array($date, $status, $id, $id));
    }
    function GET_LEAVE_APPROVAL_TABLE_DATA($id)
    {
        $sql = "SELECT leave_date,leave_range,duration FROM tbl_leaves_assign where id=? OR parent_id=?";
        $query = $this->db->query($sql, array($id, $id));
        $query->next_result();
        return $query->result();
    }
    function GET_LEAVE_APPROVAL_STATUS($id)
    {
        $this->db->select('tb1.id,tb1.empl_id,tb1.leave_date,tb1.duration,tb1.status,tb1.create_date,tb1.remarks,tb1.reason,tb1.attachment,
        tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,tb8.name as type,
        tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat,
        tb3.approver_1a,tb3.approver_2a,tb3.approver_3a
        ');
        // $this->db->select("CONCAT_WS(' ',tb2.col_last_name,tb2.col_suffix, tb2.col_frst_name, LEFT(tb2.col_midl_name,1),'.') as employee", false);
        $this->db->select('CONCAT(tb2.col_last_name,IF(tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> "", CONCAT(" ",tb2.col_suffix, ""), ""), ", ",
        tb2.col_frst_name, " ",IF(tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> "", CONCAT(LEFT(tb2.col_midl_name, 1), "."), "")) as employee', false);
        // $this->db->select('CONCAT(tb4.col_last_name, ", ", tb4.col_frst_name, " ", LEFT(tb4.col_midl_name,1),".") as approver1', false);
        $this->db->select('CONCAT(tb4.col_last_name,IF(tb4.col_suffix IS NOT NULL AND tb4.col_suffix <> "", CONCAT(" ",tb4.col_suffix, ""), ""), ", ",
        tb4.col_frst_name, " ",IF(tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name <> "", CONCAT(LEFT(tb4.col_midl_name, 1), "."), "")) as approver1', false);
        // $this->db->select('CONCAT(tb5.col_last_name, ", ", tb5.col_frst_name, " ", LEFT(tb5.col_midl_name,1),".") as approver2', false);
        $this->db->select('CONCAT(tb5.col_last_name,IF(tb5.col_suffix IS NOT NULL AND tb5.col_suffix <> "", CONCAT(" ",tb5.col_suffix, ""), ""), ", ",
        tb5.col_frst_name, " ",IF(tb5.col_midl_name IS NOT NULL AND tb5.col_midl_name <> "", CONCAT(LEFT(tb5.col_midl_name, 1), "."), "")) as approver2', false);
        // $this->db->select('CONCAT(tb6.col_last_name, ", ", tb6.col_frst_name, " ", LEFT(tb6.col_midl_name,1),".") as approver3,', false);
        $this->db->select('CONCAT(tb6.col_last_name,IF(tb6.col_suffix IS NOT NULL AND tb6.col_suffix <> "", CONCAT(" ",tb6.col_suffix, ""), ""), ", ",
        tb6.col_frst_name, " ",IF(tb6.col_midl_name IS NOT NULL AND tb6.col_midl_name <> "", CONCAT(LEFT(tb6.col_midl_name, 1), "."), "")) as approver3', false);
        // $this->db->select('CONCAT(tb7.col_last_name, ", ", tb7.col_frst_name, " ", LEFT(tb7.col_midl_name,1),".") as assigned_by,', false);
        $this->db->select('CONCAT(tb7.col_last_name,IF(tb7.col_suffix IS NOT NULL AND tb7.col_suffix <> "", CONCAT(" ",tb7.col_suffix, ""), ""), ", ",
        tb7.col_frst_name, " ",IF(tb7.col_midl_name IS NOT NULL AND tb7.col_midl_name <> "", CONCAT(LEFT(tb7.col_midl_name, 1), "."), "")) as assigned_by', false);
        // $this->db->select('CONCAT(tb9.col_last_name, ", ", tb9.col_frst_name, " ", LEFT(tb9.col_midl_name,1),".") as pending_approver1', false);
        $this->db->select('CONCAT(tb9.col_last_name,IF(tb9.col_suffix IS NOT NULL AND tb9.col_suffix <> "", CONCAT(" ",tb9.col_suffix, ""), ""), ", ",
        tb9.col_frst_name, " ",IF(tb9.col_midl_name IS NOT NULL AND tb9.col_midl_name <> "", CONCAT(LEFT(tb9.col_midl_name, 1), "."), "")) as pending_approver1', false);
        // $this->db->select('CONCAT(tb10.col_last_name, ", ", tb10.col_frst_name, " ", LEFT(tb10.col_midl_name,1),".") as pending_approver2', false);
        $this->db->select('CONCAT(tb10.col_last_name,IF(tb10.col_suffix IS NOT NULL AND tb10.col_suffix <> "", CONCAT(" ",tb10.col_suffix, ""), ""), ", ",
        tb10.col_frst_name, " ",IF(tb10.col_midl_name IS NOT NULL AND tb10.col_midl_name <> "", CONCAT(LEFT(tb10.col_midl_name, 1), "."), "")) as pending_approver2', false);
        // $this->db->select('CONCAT(tb11.col_last_name, ", ", tb11.col_frst_name, " ", LEFT(tb11.col_midl_name,1),".") as pending_approver3,', false);
        $this->db->select('CONCAT(tb11.col_last_name,IF(tb11.col_suffix IS NOT NULL AND tb11.col_suffix <> "", CONCAT(" ",tb11.col_suffix, ""), ""), ", ",
        tb11.col_frst_name, " ",IF(tb11.col_midl_name IS NOT NULL AND tb11.col_midl_name <> "", CONCAT(LEFT(tb11.col_midl_name, 1), "."), "")) as pending_approver3', false);
        $this->db->select('tb2.col_empl_emai as employee_email,tb9.col_empl_emai as approver1a_email,tb10.col_empl_emai as approver2a_email,tb11.col_empl_emai as approver3a_email');
        $this->db->select('tb4.col_empl_emai as approver1_email,tb5.col_empl_emai as approver2_email,tb6.col_empl_emai as approver3_email');
        $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,tb6.col_imag_path as approver_3_img');
        $this->db->select('tb9.col_imag_path as pending_approver1_img,tb10.col_imag_path as pending_approver2_img,tb11.col_imag_path as pending_approver3_img');
        $this->db->from('tbl_leaves_assign as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_approvers_leave as tb3', 'tb1.empl_id            = tb3.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver1     = tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.approver2     = tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver3     = tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
        $this->db->join('tbl_std_leavetypes as tb8', 'tb1.type          = tb8.id', 'left');
        $this->db->join('tbl_employee_infos as tb9', 'tb3.approver_1a   = tb9.id', 'left');
        $this->db->join('tbl_employee_infos as tb10', 'tb3.approver_2a  = tb10.id', 'left');
        $this->db->join('tbl_employee_infos as tb11', 'tb3.approver_3a  = tb11.id', 'left');
        $this->db->where('tb1.id', $id);
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row();
    }
    function GET_EMPLOYEES_ALL($user_id)
    {
        $sql = "SELECT col_empl_sect FROM tbl_employee_infos WHERE id=?";
        $query = $this->db->query($sql, array($user_id));
        $result = $query->row();
        if ($result) {
            $res = $result->col_empl_sect;
        } else {
            $res = null;
        }

        if ($res) {
            $this->db->select('id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name');
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
            // requested by client to see all employees by sir kevin 25jan24
            $this->db->where('reporting_to', $user_id);
            $this->db->where('col_empl_sect', $res);
            $this->db->order_by('col_empl_cmid + 0 ', 'ASC');
            $query = $this->db->get('tbl_employee_infos');
            return $query->result();
        }
    }
    // function GET_EMPLOYEES_MEMBERS($user_id)
    // {
    //     $this->db->select('id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name');
    //     $this->db->select("
    //             CONCAT_WS(
    //                 '', 
    //                 CONCAT(col_empl_cmid, '-',col_last_name), 
    //                 CASE WHEN col_suffix IS NOT NULL AND col_suffix <> '' THEN CONCAT(' ',col_suffix) ELSE '' END,
    //                 CASE WHEN col_frst_name IS NOT NULL AND col_frst_name <> '' THEN CONCAT(', ',col_frst_name) ELSE '' END, 
    //                 CASE WHEN col_midl_name IS NOT NULL AND col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(col_midl_name, 1)), '.') ELSE '' END
    //             ) AS fullname
    //             ", false);
    //     $this->db->where("disabled = 0 AND (termination_date IS NULL OR termination_date = '0000-00-00') ");
    //     // requested by client to see all employees by sir kevin 25jan24
    //     $this->db->where('reporting_to', $user_id);
    //     $this->db->order_by('col_empl_cmid + 0 ', 'ASC');
    //     $query = $this->db->get('tbl_employee_infos');
    //     return $query->result();
    // }


    //MARK BINAGO ko to preparedby -> reporting to
    function EMPLOYEE_LIST_ATTENDANCE($user_id = null)
    {
        $sql = "SELECT 
                    id,
                    CONCAT(col_empl_cmid, '-', col_last_name, ', ', col_frst_name, ' ', col_midl_name) AS name 
                FROM 
                    tbl_employee_infos 
                WHERE 
                    disabled = 0 
                    /*AND (termination_date IS NULL OR termination_date = '0000-00-00')*/";

        // kapag may laman ang user_id, idagdag ang filter
        if (!empty($user_id)) {
            $sql .= " AND reporting_to = ?";
            $query = $this->db->query($sql, array($user_id));
        } else {
            $query = $this->db->query($sql);
        }

        $sql .= " ORDER BY col_empl_cmid ASC";

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

    function GET_EMPLOYEES($user_id)
    {

        $this->db->select('tb_empl.id,tb_empl.col_suffix,tb_empl.col_empl_cmid,tb_empl.col_last_name,tb_empl.col_midl_name,tb_empl.col_frst_name');
        $this->db->select("
                CONCAT_WS(
                    '', 
                    CONCAT(col_empl_cmid, '-',col_last_name), 
                    CASE WHEN col_suffix IS NOT NULL AND col_suffix <> '' THEN CONCAT(' ',col_suffix) ELSE '' END,
                    CASE WHEN col_frst_name IS NOT NULL AND col_frst_name <> '' THEN CONCAT(', ',col_frst_name) ELSE '' END, 
                    CASE WHEN col_midl_name IS NOT NULL AND col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(col_midl_name, 1)), '.') ELSE '' END
                ) AS fullname
                ", false)
            ->join('tbl_approvers_shift as tb2_shift', 'tb_empl.id = tb2_shift.empl_id', 'left');
        $this->db->where("disabled = 0 AND (termination_date IS NULL OR termination_date = '0000-00-00') ");
        // requested by client to see all employees by sir kevin 25jan24
        $this->db->where('prepared_by', $user_id);
        // $this->db->where('col_empl_sect',$res);
        $this->db->order_by('col_empl_cmid + 0 ', 'ASC');
        $query = $this->db->get('tbl_employee_infos AS tb_empl');
        return $query->result();
    }

    function GET_ALL_EMPLOYEES()
    {
        $this->db->select('id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name');
        $this->db->where("disabled = 0 AND (termination_date IS NULL OR termination_date = '0000-00-00') ");
        $this->db->order_by('col_last_name', 'ASC');
        $query = $this->db->get('tbl_employee_infos');
        return $query->result();
    }


    function GET_EMPLOYEES_OVERTIME()
    {
        $this->db->select('id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name');
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
        $this->db->order_by('col_empl_cmid + 0 ', 'ASC');
        $query = $this->db->get('tbl_employee_infos');
        return $query->result();
    }
    function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'maiya_reset'";
        return $this->db->query($query)->row_array();
    }
    function GET_LEAVES_COUNT($search, $status, $filter_arr, $user_id)
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
            ->select("CONCAT('LEAV', LPAD(tb1.id, 5, '0')) as c_id", false)
            ->select('tb1.leave_date')
            ->select("DATE_FORMAT(tb1.leave_date, '%d/%m/%Y') as leave_date", false)
            ->select('tb1.duration')
            ->select('tb1.remarks')
            ->from('tbl_leaves_assign as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left')
            ->join('tbl_employee_infos as tb3', 'tb1.assigned_by = tb3.id', 'left');
        if (!empty($new_filter)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        if (!empty($search)) {
            $this->db->where('tb2.id', $search);
        }
        $this->db->where('tb2.reporting_to', $user_id);
        $this->db->where('(tb1.parent_id = 0 OR tb1.parent_id IS NULL)');
        $this->db->order_by('tb1.id', 'desc');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function GET_LEAVE_COUNT($search, $status, $filter_arr)
    {
        $new_filter                         = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_club']    = $filter_arr['clubhouse'];
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
            ->select('tb1.leave_date')
            ->select('tb1.duration')
            ->select('tb1.status')
            ->select('tb1.remarks')
            ->from('tbl_leaves_assign as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left')
            ->join('tbl_employee_infos as tb3', 'tb1.assigned_by = tb3.id', 'left')
            ->join('tbl_std_leavetypes as tb4', 'tb1.type = tb4.id', 'left');
        if (!empty($new_filter)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        if (!empty($search)) {
            $this->db->where('tb2.id', $search);
        }
        $this->db->where('(tb1.parent_id = 0 OR tb1.parent_id IS NULL)');
        $query = $this->db->get();
        return $query->num_rows();
    }

    function GET_STD_DATA($table)
    {
        $this->db->select('id,name')
            ->from($table)
            ->where(array('status' => 'active'));
        $query = $this->db->get();
        return $query->result();
    }
    function GET_SYSTEM_SETTING($setting)
    {
        $sql    = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
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
    function GET_IS_DUPLICATE_DATE($empl_id, $date)
    {
        $this->db->select('*');
        $this->db->where('empl_id', $empl_id);
        $this->db->where('leave_date', $date);
        $this->db->where('status !=', 'Withdrawed');
        $query = $this->db->get('tbl_leaves_assign');
        return $query->num_rows();
    }
    function SHOW_HIDE_ATTACHMENT($type)
    {
        $this->db->select('s.value');
        $this->db->from('tbl_std_leavetypes t');
        $this->db->join('tbl_leaves_settings s', 't.attachment_id = s.id', 'inner');
        $this->db->where('t.id', $type);
        $result = $this->db->get()->row()->value;
        return $result;
    }
    function SHOW_HIDE_REASON($type)
    {
        $this->db->select('s.value');
        $this->db->from('tbl_std_leavetypes t');
        $this->db->join('tbl_leaves_settings s', 't.reason_id = s.id', 'inner');
        $this->db->where('t.id', $type);
        $result = $this->db->get()->row()->value;
        return $result;
    }
    function get_leaves_total($empl_id, $type, $date_from, $date_to)
    {
        $query = "SELECT SUM(duration) AS total_duration FROM tbl_leaves_assign WHERE leave_date >= ? AND leave_date <= ? 
        AND empl_id=? AND type=?
        AND status != 'Rejected' ";
        $query = $this->db->query($query, array($date_from, $date_to, $empl_id, $type));
        $query->next_result();
        $result = $query->result();
        return $result[0]->total_duration;
    }

    function GET_EMPL_UNDERTIME($userId, $status, $limit, $offset)
    {

        $this->db->select('tb_change.create_date,tb_change.id,date_undertime,current_shift,request_time_in, request_time_out, reason,status,comment')
            ->select("
        CONCAT_WS(
            '', 
            CONCAT(tb_empl.col_empl_cmid, '-', tb_empl.col_last_name), 
            CASE WHEN tb_empl.col_suffix IS NOT NULL AND tb_empl.col_suffix <> '' THEN CONCAT(' ',tb_empl.col_suffix) ELSE '' END,
            CASE WHEN tb_empl.col_frst_name IS NOT NULL AND tb_empl.col_frst_name <> '' THEN CONCAT(', ',tb_empl.col_frst_name) ELSE '' END, 
            CASE WHEN tb_empl.col_midl_name IS NOT NULL AND tb_empl.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb_empl.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)

            ->join('tbl_employee_infos as tb_empl', 'tb_change.empl_id = tb_empl.id', 'left')
            ->join('tbl_approvers_shift as tb2_shift', 'tb_change.empl_id = tb2_shift.empl_id', 'left');
        $this->db->where('prepared_by', $userId);

        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get('tbl_attendance_undertime as tb_change');
        return $query->result();
    }


    function GET_EMPL_UNDERTIME_COUNT($userId, $status)
    {

        $this->db->select('tb_change.id,current_shift,reason,status,comment')
            ->select("
        CONCAT_WS(
            '', 
            CONCAT(tb_empl.col_empl_cmid, '-', tb_empl.col_last_name), 
            CASE WHEN tb_empl.col_suffix IS NOT NULL AND tb_empl.col_suffix <> '' THEN CONCAT(' ',tb_empl.col_suffix) ELSE '' END,
            CASE WHEN tb_empl.col_frst_name IS NOT NULL AND tb_empl.col_frst_name <> '' THEN CONCAT(', ',tb_empl.col_frst_name) ELSE '' END, 
            CASE WHEN tb_empl.col_midl_name IS NOT NULL AND tb_empl.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb_empl.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)

            ->join('tbl_employee_infos as tb_empl', 'tb_change.empl_id = tb_empl.id', 'left')
            ->join('tbl_approvers_shift as tb2_shift', 'tb_change.empl_id = tb2_shift.empl_id', 'left');
        $this->db->where('prepared_by', $userId);

        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }

        $query = $this->db->get('tbl_attendance_undertime as tb_change');
        return $query->num_rows();
    }

    function GET_EMPL_CHANGEOFF($userId, $status, $limit, $offset)
    {

        $this->db->select('tb_change.create_date,tb_change.id,date_shift,current_shift,request_shift, date_shift_to, current_shift_to, request_shift_to, reason,status,comment')
            ->select("
        CONCAT_WS(
            '', 
            CONCAT(tb_empl.col_empl_cmid, '-', tb_empl.col_last_name), 
            CASE WHEN tb_empl.col_suffix IS NOT NULL AND tb_empl.col_suffix <> '' THEN CONCAT(' ',tb_empl.col_suffix) ELSE '' END,
            CASE WHEN tb_empl.col_frst_name IS NOT NULL AND tb_empl.col_frst_name <> '' THEN CONCAT(', ',tb_empl.col_frst_name) ELSE '' END, 
            CASE WHEN tb_empl.col_midl_name IS NOT NULL AND tb_empl.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb_empl.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)

            ->join('tbl_employee_infos as tb_empl', 'tb_change.empl_id = tb_empl.id', 'left')
            ->join('tbl_approvers_shift as tb2_shift', 'tb_change.empl_id = tb2_shift.empl_id', 'left');
        $this->db->where('prepared_by', $userId);

        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get('tbl_attendance_changeoff as tb_change');
        return $query->result();
    }


    function GET_EMPL_CHANGESHIFT($userId, $status, $limit, $offset)
    {

        $this->db->select('tb_change.create_date,tb_change.id,date_shift,current_shift,request_shift, date_shift_to, current_shift_to, request_shift_to, reason,status,comment')
            ->select("
        CONCAT_WS(
            '', 
            CONCAT(tb_empl.col_empl_cmid, '-', tb_empl.col_last_name), 
            CASE WHEN tb_empl.col_suffix IS NOT NULL AND tb_empl.col_suffix <> '' THEN CONCAT(' ',tb_empl.col_suffix) ELSE '' END,
            CASE WHEN tb_empl.col_frst_name IS NOT NULL AND tb_empl.col_frst_name <> '' THEN CONCAT(', ',tb_empl.col_frst_name) ELSE '' END, 
            CASE WHEN tb_empl.col_midl_name IS NOT NULL AND tb_empl.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb_empl.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)

            ->join('tbl_employee_infos as tb_empl', 'tb_change.empl_id = tb_empl.id', 'left')
            ->join('tbl_approvers_shift as tb2_shift', 'tb_change.empl_id = tb2_shift.empl_id', 'left');
        $this->db->where('prepared_by', $userId);

        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get('tbl_attendance_changeshift as tb_change');
        return $query->result();
    }

    function GET_EMPL_CHANGESHIFT_COUNT($userId, $status)
    {

        $this->db->select('tb_change.id,date_shift,current_shift,request_shift,reason,status,comment')
            ->select("
        CONCAT_WS(
            '', 
            CONCAT(tb_empl.col_empl_cmid, '-', tb_empl.col_last_name), 
            CASE WHEN tb_empl.col_suffix IS NOT NULL AND tb_empl.col_suffix <> '' THEN CONCAT(' ',tb_empl.col_suffix) ELSE '' END,
            CASE WHEN tb_empl.col_frst_name IS NOT NULL AND tb_empl.col_frst_name <> '' THEN CONCAT(', ',tb_empl.col_frst_name) ELSE '' END, 
            CASE WHEN tb_empl.col_midl_name IS NOT NULL AND tb_empl.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb_empl.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)

            ->join('tbl_employee_infos as tb_empl', 'tb_change.empl_id = tb_empl.id', 'left')
            ->join('tbl_approvers_shift as tb2_shift', 'tb_change.empl_id = tb2_shift.empl_id', 'left');
        $this->db->where('prepared_by', $userId);

        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }

        $query = $this->db->get('tbl_attendance_changeshift as tb_change');
        return $query->num_rows();
    }

    // function GET_EMPL_CHANGESHIFT_COUNT($userId, $status)
    // {
    //     $this->db->select('id,date_shift,current_shift,request_shift,reason,status,comment');
    //     $this->db->where('empl_id', $userId);
    //     if (!empty($status)) {
    //         $this->db->like('status', $status);
    //     }
    //     $query = $this->db->get('tbl_attendance_changeshift');
    //     return $query->num_rows();
    // }

    function GET_SPECIFIC_ATTENDANCE_SHIFT($id)
    {
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }
    function GET_EMPL_NAMES($tableName)
    {
        $query = $this->db->select('col_suffix,empl_id,col_frst_name,col_midl_name,col_last_name')
            ->from($tableName)
            ->join('tbl_employee_infos', 'tbl_employee_infos.id = ' . $tableName . '.empl_id')
            ->like('status', 'Pending')
            ->group_by("empl_id")
            ->get()->result();
        return $query;
    }
    function GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID()
    {
        $sql   = "SELECT id,col_last_name,col_midl_name,col_frst_name,col_empl_cmid,col_suffix FROM tbl_employee_infos WHERE disabled=0 ORDER BY col_empl_cmid +0 ASC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_COMPANY()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_companies";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_CHANGESHIFT_DATA($id)
    {
        $sql = "SELECT * FROM tbl_attendance_changeshift WHERE id=$id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result[0];
    }

    function GET_UNDERTIME_DATA($id)
    {
        $sql = "SELECT * FROM tbl_attendance_undertime WHERE id=$id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result[0];
    }

    function GET_APPROVERCOUNT($id)
    {
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = 'num_approvers'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["value"];
    }
    function CHANGESHIFT_APPROVELEAVE($changeshift_id, $next_status, $approverdate)
    {
        $datetime                   = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_changeshift SET status ='$next_status', $approverdate = '$datetime' WHERE id= '$changeshift_id'";
        $this->db->query($sql);
    }

    function UNDERTIME_APPROVAL($changeshift_id, $next_status, $approverdate)
    {
        $datetime                   = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_undertime SET status ='$next_status', $approverdate = '$datetime' WHERE id= '$changeshift_id'";
        $this->db->query($sql);
    }



    function GET_CHANGED_SHIFT($changeshift_id)
    {
        $sql_change = "SELECT * FROM tbl_attendance_changeshift WHERE id=?";
        $query = $this->db->query($sql_change, array($changeshift_id));
        $result = $query->row();
        return $result;
    }
    function UPDATE_CHANGESHIFT($empl_id, $date_shift, $result_id)
    {

        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_shiftassign SET edit_date=?, shift_id=? WHERE empl_id=? AND date=?";
        $this->db->query($sql, array($date, $result_id, $empl_id, $date_shift));
    }

    function GET_SYSTEM_SETTINGS($setting)
    {
        $is_exist = $this->db->select("value")->where('setting', $setting)->get("tbl_system_setup")->row();
        if ($is_exist) {
            return $is_exist->value;
        } else {
            $this->db->insert("tbl_system_setup", array('setting' => $setting, 'value' => '0'));
            return 0;
        }
    }
    function GET_USER_DEPARMENT($user_id)
    {
        $sql = "SELECT col_empl_dept FROM tbl_employee_infos WHERE id = $user_id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["col_empl_dept"];
    }
    function GET_ALL_SHIFTS()
    {
        $this->db->select('name,id,time_regular_start,time_regular_end');
        $this->db->from('tbl_attendance_shifts');
        $this->db->where('is_deleted', '0');
        $this->db->where('status', 'Active');
        $query = $this->db->get();
        return $query->result();
    }
    function GET_EMPOLOYEES()
    {
        $this->db->select('id, col_empl_cmid,col_last_name,col_frst_name,col_midl_name,col_empl_dept')
            ->where('disabled', 0)
            ->where('termination_date', NULL);
        $query = $this->db->get('tbl_employee_infos');
        return $query->result_object();
    }
    function MOD_DISP_HOLIDAY_BASED_DATE($date)
    {
        $query = $this->db
            ->select('col_holi_type')
            ->where('col_holi_date', $date)
            ->get('tbl_std_holidays');

        return $query->result();
    }
    function GET_USERS_APPROVERS($id, $table)
    {
        $this->db->select('tb1.id,approver_1a,approver_2a,approver_3a,tb1.approver_4a,tb1.approver_5a,tb1.id,approver_1b,approver_2b,approver_3b,tb1.approver_4b,tb1.approver_5b,tb1.empl_id');
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as approver_1", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',RPAD(LEFT(tb3.col_midl_name,1),2,'.')) as approver_2", false);
        $this->db->select("CONCAT(tb4.col_last_name,',',tb4.col_frst_name,' ',RPAD(LEFT(tb4.col_midl_name,1),2,'.')) as approver_3", false);
        $this->db->select("CONCAT(tb6.col_last_name,',',tb6.col_frst_name,' ',RPAD(LEFT(tb6.col_midl_name,1),2,'.')) as approver_4", false);
        $this->db->select("CONCAT(tb7.col_last_name,',',tb7.col_frst_name,' ',RPAD(LEFT(tb7.col_midl_name,1),2,'.')) as approver_5", false);
        $this->db->select("CONCAT(tb5.col_last_name,',',tb5.col_frst_name,' ',RPAD(LEFT(tb5.col_midl_name,1),2,'.')) as employee", false);
        $this->db->from($table . ' as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.approver_1a=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.approver_2a=tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver_3a=tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.empl_id=tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver_4a=tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.approver_5a=tb7.id', 'left');
        $this->db->where('tb1.empl_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    // function GET_USERS_APPROVERS($id, $table)
    // {
    //     $this->db->select('tb1.id,checked_by,noted_by,tb1.empl_id');
    //     $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as approver_1", false);
    //     $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',RPAD(LEFT(tb3.col_midl_name,1),2,'.')) as approver_2", false);
    //     // $this->db->select("CONCAT(tb4.col_last_name,',',tb4.col_frst_name,' ',RPAD(LEFT(tb4.col_midl_name,1),2,'.')) as approver_3", false);
    //     // $this->db->select("CONCAT(tb6.col_last_name,',',tb6.col_frst_name,' ',RPAD(LEFT(tb6.col_midl_name,1),2,'.')) as approver_4", false);
    //     // $this->db->select("CONCAT(tb7.col_last_name,',',tb7.col_frst_name,' ',RPAD(LEFT(tb7.col_midl_name,1),2,'.')) as approver_5", false);
    //     $this->db->select("CONCAT(tb5.col_last_name,',',tb5.col_frst_name,' ',RPAD(LEFT(tb5.col_midl_name,1),2,'.')) as employee", false);
    //     $this->db->from($table . ' as tb1');
    //     $this->db->join('tbl_employee_infos as tb2', 'tb1.checked_by=tb2.id', 'left');
    //     $this->db->join('tbl_employee_infos as tb3', 'tb1.noted_by=tb3.id', 'left');
    //     // $this->db->join('tbl_employee_infos as tb4', 'tb1.approver_3a=tb4.id', 'left');
    //     $this->db->join('tbl_employee_infos as tb5', 'tb1.empl_id=tb5.id', 'left');
    //     // $this->db->join('tbl_employee_infos as tb6', 'tb1.approver_4a=tb6.id', 'left');
    //     // $this->db->join('tbl_employee_infos as tb7', 'tb1.approver_5a=tb7.id', 'left');
    //     $this->db->where('tb1.empl_id', $id);
    //     $query = $this->db->get();
    //     return $query->row();
    // }

    function getApprovalsAutoApproveEnabled($empl_id)
    {
        $this->db->select('COUNT(*) as count');
        $this->db->where('empl_id', $empl_id);
        $this->db->where('auto_approve', 'Enabled');
        $query = $this->db->get('tbl_approvers_leave');
        $result = $query->row();
        if ($result) {
            return $result->count;
        } else {
            return 0;
        }
    }
    function GET_REQUESTORS($type, $id)
    {
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as requestor", false);
        if ($type == 'leave') {
            $this->db->from('tbl_leaves_assign as tb1');
        } else if ($type == 'overtime') {
            $this->db->from('tbl_overtimes as tb1');
        } else if ($type == 'holiday work') {
            $this->db->from('tbl_holidaywork as tb1');
        } else if ($type == 'time adjustment') {
            $this->db->from('tbl_attendance_adjustments as tb1');
        } else if ($type == 'offsets') {
            $this->db->from('tbl_attendance_offsets as tb1');
        } else if ($type == 'shift') {
            $this->db->from('tbl_attendance_shiftassign as tb1');
        } else if ($type == 'shiftrequest') {
            $this->db->from('tbl_attendance_changeshift as tb1');
        }
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result->requestor;
    }
    function ADD_NOTIFICATIONS($data)
    {
        $this->db->insert('tbl_notifications', $data);
        return $this->db->insert_id();
    }
    function ADD_CHANGESHIFT_REQUEST($data)
    {
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $this->db->insert('tbl_attendance_changeshift', $data);
        return $this->db->insert_id();
    }

    function ADD_CHANGEOFF_REQUEST($data)
    {
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $this->db->insert('tbl_attendance_changeoff', $data);
        return $this->db->insert_id();
    }

    function ADD_UNDERTIME_REQUEST($data)
    {
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $this->db->insert('tbl_attendance_undertime', $data);
        return $this->db->insert_id();
    }


    function CHANGESHIFT_WITHDRAW($id)
    {
        $sql = "UPDATE tbl_attendance_changeshift SET status ='Withdrawn' WHERE id=$id";
        $this->db->query($sql);
    }

    function CHANGEOFF_WITHDRAW($id)
    {
        $sql = "UPDATE tbl_attendance_changeoff SET status ='Withdrawn' WHERE id=$id";
        $this->db->query($sql);
    }

    function UNDERTIME_WITHDRAW($id)
    {
        $sql = "UPDATE tbl_attendance_undertime SET status ='Withdrawn' WHERE id=$id";
        $this->db->query($sql);
    }


    function GET_SETUP_SETTING($setting)
    {
        $this->db->where('setting', $setting);
        $query = $this->db->get('tbl_system_setup');
        $val = $query->row();
        return $val->value;
    }
    function get_leave_entitlement_by_id_typeName_year($empl_id, $typeName, $year)
    {
        $query = "SELECT tb1.value, tb1.empl_id,tb1.type, tb2.name as year FROM tbl_leave_entitlements as tb1
        left join tbl_std_years as tb2 on
        tb1.year = tb2.id
        where empl_id=? AND type =? AND tb2.name =?";
        return $this->db->query($query, array($empl_id, $typeName, $year))->row_array();
    }
    function get_offset_approve_count($empl_id)
    {
        $query = "SELECT SUM(duration) AS value FROM tbl_attendance_offsets
        where empl_id = ? AND status = 'Approved'";
        return $this->db->query($query, array($empl_id))->row_array();
    }
    function SHOW_HIDE_CREDITS($type)
    {
        $this->db->select('s.value');
        $this->db->from('tbl_std_leavetypes t');
        $this->db->join('tbl_leaves_settings s', 't.credit_id = s.id', 'inner');
        $this->db->where('t.id', $type);
        $result = $this->db->get()->result();
        // Check if there are rows
        if (!empty($result)) {
            return $result[0]->value;
        } else {
            // If no rows, return a default value (e.g., 0)
            return 0;
        }
    }
    function GET_SETUP_LEAVE_SETTING($setting)
    {
        $this->db->where('setting', $setting);
        $query = $this->db->get('tbl_system_setup');
        if ($query->num_rows() > 0) {
            $val = $query->row();
            return $val->value;
        } else {
            return null;
        }
    }
    function GET_EMPLOYEE_SPECIFIC_ROW($employee_id)
    {
        $sql   = "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->row();
    }
    // function GET_USER_APPROVERS($id, $table)
    // {
    //     $this->db->select('tb1.id,approver_1a,approver_2a,approver_3a,approver_4a,approver_5a,tb1.empl_id');
    //     $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as approver_1", false);
    //     $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',RPAD(LEFT(tb3.col_midl_name,1),2,'.')) as approver_2", false);
    //     $this->db->select("CONCAT(tb4.col_last_name,',',tb4.col_frst_name,' ',RPAD(LEFT(tb4.col_midl_name,1),2,'.')) as approver_3", false);
    //     $this->db->select("CONCAT(tb5.col_last_name,',',tb5.col_frst_name,' ',RPAD(LEFT(tb5.col_midl_name,1),2,'.')) as employee", false);
    //     $this->db->from($table . ' as tb1');
    //     $this->db->join('tbl_employee_infos as tb2', 'tb1.approver_1a=tb2.id', 'left');
    //     $this->db->join('tbl_employee_infos as tb3', 'tb1.approver_2a=tb3.id', 'left');
    //     $this->db->join('tbl_employee_infos as tb4', 'tb1.approver_3a=tb4.id', 'left');
    //     $this->db->join('tbl_employee_infos as tb5', 'tb1.empl_id=tb5.id', 'left');
    //     $this->db->where('tb1.empl_id', $id);
    //     $query = $this->db->get();
    //     return $query->row();
    // }

    function GET_USER_APPROVERS($id, $table)
    {
        $this->db->select('tb1.id,approver_1a,approver_2a,approver_3a,tb1.approver_4a,tb1.approver_5a,tb1.id,approver_1b,approver_2b,approver_3b,tb1.approver_4b,tb1.approver_5b,tb1.empl_id');
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as approver_1", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',RPAD(LEFT(tb3.col_midl_name,1),2,'.')) as approver_2", false);
        $this->db->select("CONCAT(tb4.col_last_name,',',tb4.col_frst_name,' ',RPAD(LEFT(tb4.col_midl_name,1),2,'.')) as approver_3", false);
        $this->db->select("CONCAT(tb6.col_last_name,',',tb6.col_frst_name,' ',RPAD(LEFT(tb6.col_midl_name,1),2,'.')) as approver_4", false);
        $this->db->select("CONCAT(tb7.col_last_name,',',tb7.col_frst_name,' ',RPAD(LEFT(tb7.col_midl_name,1),2,'.')) as approver_5", false);
        $this->db->select("CONCAT(tb5.col_last_name,',',tb5.col_frst_name,' ',RPAD(LEFT(tb5.col_midl_name,1),2,'.')) as employee", false);
        $this->db->from($table . ' as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.approver_1a=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.approver_2a=tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver_3a=tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.empl_id=tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver_4a=tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.approver_5a=tb7.id', 'left');
        $this->db->where('tb1.empl_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function GET_LEAVE_LIST_COUNT($search, $reporting_to_empl, $company, $branch, $dept, $div, $clubhouse, $section, $group, $line, $team, $status, $leave_date, $date_from, $date_to)
    {

        $employee                   = !empty($search) ? $search : 'NULL';
        $reporting_to_empl          = !empty($reporting_to_empl) ? $reporting_to_empl : 'NULL';
        $company                    = !empty($company) ? "'$company'" : 'NULL';
        $branch                     = !empty($branch) ? "'$branch'" : 'NULL';
        $dept                       = !empty($dept) ? "'$dept'" : 'NULL';
        $div                        = !empty($div) ? "'$div'" : 'NULL';
        $clubhouse                  = !empty($clubhouse) ? "'$clubhouse'" : 'NULL';
        $section                    = !empty($section) ? "'$section'" : 'NULL';
        $group                      = !empty($group) ? "'$group'" : 'NULL';
        $line                       = !empty($line) ? "'$line'" : 'NULL';
        $team                       = !empty($team) ? "'$team'" : 'NULL';
        $status                     = !empty($status) ? "'$status'" : 'NULL';
        $leave_date                 = !empty($leave_date) ? "'$leave_date'" : 'NULL';
        $date_from                  = !empty($date_from) ? "'$date_from'" : 'NULL';
        $date_to                    = !empty($date_to) ? "'$date_to'" : 'NULL';

        $procedure = "CALL GetLeaveListCount($employee, $reporting_to_empl, $company, $branch, $dept, $div, $clubhouse, $section, $group, $line, $team, $status,$leave_date,$date_from,$date_to);";
        $query = $this->db->query($procedure);

        if ($query) {
            $result = $query->row();
            $query->next_result();
            $query->free_result();
            return $result->total_count;
        }
        return 0;
    }

    function GET_LEAVE_LIST($search, $reporting_to_empl, $offset, $limit, $company, $branch, $dept, $div, $clubhouse, $section, $group, $line, $team, $status, $leave_date, $date_from, $date_to)
    {
        // Convert empty values to 'NULL'
        $search                 = !empty($search) ? "'$search'" : 'NULL';
        $reporting_to_empl      = !empty($reporting_to_empl) ? $reporting_to_empl : 'NULL';
        $company                = !empty($company) ? "'$company'" : 'NULL';
        $branch                 = !empty($branch) ? "'$branch'" : 'NULL';
        $dept                   = !empty($dept) ? "'$dept'" : 'NULL';
        $div                    = !empty($div) ? "'$div'" : 'NULL';
        $clubhouse              = !empty($clubhouse) ? "'$clubhouse'" : 'NULL';
        $section                = !empty($section) ? "'$section'" : 'NULL';
        $group                  = !empty($group) ? "'$group'" : 'NULL';
        $line                   = !empty($line) ? "'$line'" : 'NULL';
        $team                   = !empty($team) ? "'$team'" : 'NULL';
        $status                 = !empty($status) ? "'$status'" : 'NULL';
        $leave_date             = !empty($leave_date) ? "'$leave_date'" : 'NULL';
        $date_from              = !empty($date_from) ? "'$date_from'" : 'NULL';
        $date_to                = !empty($date_to) ? "'$date_to'" : 'NULL';

        // Build procedure call string
        $procedure = "CALL GetLeaveList(" . $search . ", " . $reporting_to_empl . ", " . $offset . ", " . $limit . ", " .
            $company . ", " . $branch . ", " . $dept . ", " . $div . ", " . $clubhouse . ", " .
            $section . ", " . $group . ", " . $line . ", " . $team . ", " . $status . ", " . $leave_date . ", " . $date_from . ", " . $date_to . ");";

        $query = $this->db->query($procedure);
        $result = $query->result();
        $query->next_result();
        $query->free_result();
        return $result;
    }

    function GET_LEAVES2($status, $search, $limit, $offset, $filter_arr, $user_id)
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
        $this->db->select('tb1.id,tb3.id as assigned_table_id,tb2.id as employee_table_id,tb4.name as type,tb1.status,tb1.reason, tb1.leave_range')
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
            ->select("CONCAT('LEAV', LPAD(tb1.id, 5, '0')) as c_id", false)
            ->select('tb1.leave_date')
            // ->select("DATE_FORMAT(tb1.leave_date, '%d/%m/%Y') as leave_date", false)
            ->select('tb1.duration')
            ->select('tb1.remarks')
            ->from('tbl_leaves_assign as tb1')
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
        $this->db->where('tb2.reporting_to', $user_id);
        // $this->db->where('tb5.prepared_by', $user_id);
        $this->db->where('(tb1.parent_id = 0 OR tb1.parent_id IS NULL)');
        $this->db->limit($limit, $offset);
        $this->db->order_by('tb1.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function GET_LEAVE2($status, $search, $limit, $offset, $filter_arr)
    {
        $user_id                                    = $this->session->userdata('SESS_USER_ID');
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
                    CONCAT(tb2.col_empl_cmid, '-', tb2.col_last_name), 
                    CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> '' THEN CONCAT(' ',tb2.col_suffix) ELSE '' END,
                    CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name <> '' THEN CONCAT(', ',tb2.col_frst_name) ELSE '' END, 
                    CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb2.col_midl_name, 1)), '.') ELSE '' END
                ) AS employee
                ", false)
            ->select("CONCAT('LEAV', LPAD(tb1.id, 5, '0')) as c_id", false)
            // ->select('tb4.name as type')
            ->select('tb1.leave_date, tb1.leave_range')
            ->select("DATE_FORMAT(tb1.leave_date, '%d/%m/%Y') as leave_date", false)
            ->select('tb1.duration')
            // ->select('tb1.status')
            ->select('tb1.remarks, tb4.name as type')
            // ->select('tb2.id as employee_table_id')
            // ->select('tb3.id as assigned_table_id')
            ->from('tbl_leaves_assign as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left')
            ->join('tbl_employee_infos as tb3', 'tb1.assigned_by = tb3.id', 'left')
            ->join('tbl_std_leavetypes as tb4', 'tb1.type = tb4.id', 'left');
        // ->join('tbl_std_leavetypes as tb4', 'tb1.type = tb4.id', 'left');
        if (!empty($new_filter)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        if (!empty($search)) {
            $this->db->where('tb2.id', $search);
        }
        $this->db->where('(tb1.parent_id = 0 OR tb1.parent_id IS NULL)');
        $this->db->where('tb2.reporting_to', $user_id);
        $this->db->limit($limit, $offset);
        $this->db->order_by('tb1.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function MOD_DISP_ALL_EMPLOYEES_NAME()
    {
        $sql = "SELECT id,col_empl_cmid,col_last_name,col_suffix,col_frst_name,col_midl_name FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 ORDER BY  col_empl_cmid +0 ASC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_EMPL_MEMBERS_MULTIREQUEST($empl_id)
    {
        $sql = "SELECT id,col_empl_cmid,col_last_name,col_suffix,col_frst_name,col_midl_name FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND reporting_to = '$empl_id' AND disabled=0 ORDER BY  col_empl_cmid +0 ASC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function leaveTypesNames()
    {
        $sql = "SELECT id,name FROM tbl_std_leavetypes WHERE is_deleted=0 AND status='Active' ORDER BY name";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function SHIFT_NAMES()
    {
        $sql = "SELECT name,id,time_regular_start,time_regular_end FROM tbl_attendance_shifts WHERE is_deleted=0 AND status='Active' ORDER BY name";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_OFFSETS($status, $search, $limit, $offset, $filter_arr, $user_id)
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
        $this->db->where('tb2.reporting_to', $user_id);
        // $this->db->where('tb5.prepared_by', $user_id);
        // $this->db->where('(tb1.parent_id = 0 OR tb1.parent_id IS NULL)');
        $this->db->limit($limit, $offset);
        $this->db->order_by('tb1.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function GET_OFFSET_COUNT($search, $status, $filter_arr, $user_id)
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
        $this->db->where('tb2.reporting_to', $user_id);
        // $this->db->where('tb5.prepared_by', $user_id);
        // $this->db->where('(tb1.parent_id = 0 OR tb1.parent_id IS NULL)');
        $this->db->order_by('tb1.id', 'desc');
        $query = $this->db->get();
        return $query->num_rows();
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
        $this->db->where('tb2.reporting_to', $user_id);
        // $this->db->where('tb5.prepared_by', $user_id);
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
        $this->db->where('tb2.reporting_to', $user_id);
        // $this->db->where('tb5.prepared_by', $user_id);
        // $this->db->where('(tb1.parent_id = 0 OR tb1.parent_id IS NULL)');
        $this->db->order_by('tb1.id', 'desc');
        $query = $this->db->get();
        return $query->num_rows();
    }


    function GET_LEAVE_TYPES()
    {
        $this->db->select('*');
        $query = $this->db->get('tbl_std_leavetypes');
        return $query->result();
    }
    function MOD_DISP_ALL_EMPLOYEES($user_id)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 AND reporting_to=? ORDER BY  col_empl_cmid +0 ASC";
        $query = $this->db->query($sql, array($user_id));
        $query->next_result();
        return $query->result();
    }
    function GET_OVERTIMES_ALL($status, $search, $limit, $offset, $filter_arr, $user_id)
    {
        $new_filter = array();
        $new_filter['tb3.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb3.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb3.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb3.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb3.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        $this->db->select('tb1.id,tb1.date_ot,tb1.hours,tb1.reason,tb1.comment,tb1.status,tb3.id as employee_tb_id,tb4.id as assigned_by_tb_id,tb1.type');
        $this->db->select("
        CONCAT_WS(
            '', 
            CONCAT(tb3.col_empl_cmid, '-', tb3.col_last_name), 
            CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix <> '' THEN CONCAT(' ',tb3.col_suffix) ELSE '' END,
            CASE WHEN tb3.col_frst_name IS NOT NULL AND tb3.col_frst_name <> '' THEN CONCAT(', ',tb3.col_frst_name) ELSE '' END, 
            CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb3.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)
            ->select("CONCAT('OVT', LPAD(tb1.id, 5, '0')) as c_id", false)
            ->select("DATE_FORMAT(tb1.date_ot, '%d/%m/%Y') as date_ot", false);
        $this->db->select("
        CONCAT_WS(
            '', 
            CONCAT(tb4.col_empl_cmid, '-', tb4.col_last_name), 
            CASE WHEN tb4.col_suffix IS NOT NULL AND tb4.col_suffix <> '' THEN CONCAT(' ',tb4.col_suffix) ELSE '' END,
            CASE WHEN tb4.col_frst_name IS NOT NULL AND tb4.col_frst_name <> '' THEN CONCAT(', ',tb4.col_frst_name) ELSE '' END, 
            CASE WHEN tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb4.col_midl_name, 1)), '.') ELSE '' END
        ) AS assigned_by
        ", false);
        $this->db->from('tbl_overtimes as tb1');
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.assigned_by=tb4.id', 'left');
        if (!empty($search)) {
            $this->db->where('tb3.id', $search);
        }
        //request by client to see employees by sir kevin 25jan24
        $this->db->where('tb3.reporting_to', $user_id);
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    function GET_OVERTIMES_DIRECT($status, $search, $limit, $offset, $filter_arr, $user_id)
    {
        $new_filter = array();
        $new_filter['tb3.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb3.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb3.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb3.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb3.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb3.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        $this->db->select('tb1.id,tb1.date_ot,tb1.hours, tb1.ndot, tb1.reason,tb1.comment,tb1.status,tb3.id as employee_tb_id,tb4.id as assigned_by_tb_id,tb1.type');
        $this->db->select("
        CONCAT_WS(
            '', 
            CONCAT(tb3.col_empl_cmid, '-', tb3.col_last_name), 
            CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix <> '' THEN CONCAT(' ',tb3.col_suffix) ELSE '' END,
            CASE WHEN tb3.col_frst_name IS NOT NULL AND tb3.col_frst_name <> '' THEN CONCAT(', ',tb3.col_frst_name) ELSE '' END, 
            CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb3.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)
            ->select("CONCAT('OVT', LPAD(tb1.id, 5, '0')) as c_id", false)
            ->select("DATE_FORMAT(tb1.date_ot, '%d/%m/%Y') as date_ot", false);
        $this->db->select("
        CONCAT_WS(
            '', 
            CONCAT(tb4.col_empl_cmid, '-', tb4.col_last_name), 
            CASE WHEN tb4.col_suffix IS NOT NULL AND tb4.col_suffix <> '' THEN CONCAT(' ',tb4.col_suffix) ELSE '' END,
            CASE WHEN tb4.col_frst_name IS NOT NULL AND tb4.col_frst_name <> '' THEN CONCAT(', ',tb4.col_frst_name) ELSE '' END, 
            CASE WHEN tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb4.col_midl_name, 1)), '.') ELSE '' END
        ) AS assigned_by
        ", false);
        $this->db->from('tbl_overtimes as tb1');
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.assigned_by=tb4.id', 'left');
        $this->db->join('tbl_approvers_shift  as tb5', 'tb1.empl_id = tb5.empl_id', 'left');
        if (!empty($search)) {
            $this->db->where('tb3.id', $search);
        }
        //request by client to see employees by sir kevin 25jan24
        $this->db->where('tb3.reporting_to', $user_id);
        // $this->db->where('tb5.prepared_by', $user_id);
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function GET_OVERTIME_LIST_COUNT($search, $reporting_to_empl, $company, $branch, $dept, $div, $clubhouse, $section, $group, $line, $team, $status)
    {

        $employee   = !empty($search) ? $search : 'NULL';
        $reporting_to_empl      = !empty($reporting_to_empl) ? $reporting_to_empl : 'NULL';
        $company    = !empty($company) ? "'$company'" : 'NULL';
        $branch     = !empty($branch) ? "'$branch'" : 'NULL';
        $dept       = !empty($dept) ? "'$dept'" : 'NULL';
        $div        = !empty($div) ? "'$div'" : 'NULL';
        $clubhouse  = !empty($clubhouse) ? "'$clubhouse'" : 'NULL';
        $section    = !empty($section) ? "'$section'" : 'NULL';
        $group      = !empty($group) ? "'$group'" : 'NULL';
        $line       = !empty($line) ? "'$line'" : 'NULL';
        $team       = !empty($team) ? "'$team'" : 'NULL';
        $status     = !empty($status) ? "'$status'" : 'NULL';

        $procedure = "CALL GetOvertimeListCount($employee, $reporting_to_empl, $company, $branch, $dept, $div, $clubhouse, $section, $group, $line, $team, $status);";
        $query = $this->db->query($procedure);

        if ($query) {
            $result = $query->row();
            $query->next_result();
            $query->free_result();
            return $result->total_count;
        }
        return 0;
    }


    function GET_OVERTIME_LIST($search, $reporting_to_empl, $offset, $limit, $company, $branch, $dept, $div, $clubhouse, $section, $group, $line, $team, $status)
    {

        $search     = !empty($search) ? $search : 'NULL';
        $reporting_to_empl      = !empty($reporting_to_empl) ? $reporting_to_empl : 'NULL';
        $company    = !empty($company) ? "'$company'" : 'NULL';
        $branch     = !empty($branch) ? "'$branch'" : 'NULL';
        $dept       = !empty($dept) ? "'$dept'" : 'NULL';
        $div        = !empty($div) ? "'$div'" : 'NULL';
        $clubhouse  = !empty($clubhouse) ? "'$clubhouse'" : 'NULL';
        $section    = !empty($section) ? "'$section'" : 'NULL';
        $group      = !empty($group) ? "'$group'" : 'NULL';
        $line       = !empty($line) ? "'$line'" : 'NULL';
        $team       = !empty($team) ? "'$team'" : 'NULL';
        $status     = !empty($status) ? "'$status'" : 'NULL';

        $procedure = "CALL GetOvertimeList(" . $search . ", " . $reporting_to_empl . ", " . $offset . ", " . $limit . ", " .
            $company . ", " . $branch . ", " . $dept . ", " . $div . ", " . $clubhouse . ", " .
            $section . ", " . $group . ", " . $line . ", " . $team . ", " . $status . ");";

        $query = $this->db->query($procedure);
        $result = $query->result();
        $query->next_result();
        $query->free_result();
        return $result;
    }

    function GET_OVERTIME_DIRECT($status, $search, $limit, $offset, $filter_arr)
    {
        $user_id                                    = $this->session->userdata('SESS_USER_ID');
        $new_filter = array();
        $new_filter['tb3.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb3.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb3.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb3.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb3.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        // var_dump($filtered);    
        $this->db->select('tb1.id,tb1.date_ot,tb1.hours,tb1.comment');
        // $this->db->select('tb2.id as assigned_by_tb_id');
        // $this->db->select('tb3.id as employee_tb_id');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        // $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by",false);
        // $this->db->select("CONCAT_WS('',COALESCE(tb2.col_last_name, ''), 
        // CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END, ', ',
        // COALESCE(tb2.col_frst_name, ''), 
        // CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        // ) AS assigned_by", false);

        // $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee",false);

        // $this->db->select("CONCAT_WS('',COALESCE(tb3.col_last_name, ''), 
        // CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix != '' THEN CONCAT(' ', tb3.col_suffix) ELSE '' END, ', ',
        // COALESCE(tb3.col_frst_name, ''), 
        // CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name != '' THEN CONCAT(' ', LEFT(tb3.col_midl_name, 1), '.') ELSE '' END
        // ) AS employee", false);

        $this->db->select("
        CONCAT_WS(
            '', 
            CONCAT(tb3.col_empl_cmid, '-', tb3.col_last_name), 
            CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix <> '' THEN CONCAT(' ',tb3.col_suffix) ELSE '' END,
            CASE WHEN tb3.col_frst_name IS NOT NULL AND tb3.col_frst_name <> '' THEN CONCAT(', ',tb3.col_frst_name) ELSE '' END, 
            CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb3.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)
            ->select("CONCAT('OVT', LPAD(tb1.id, 5, '0')) as c_id", false)
            ->select("DATE_FORMAT(tb1.date_ot, '%d/%m/%Y') as date_ot", false)
        ;

        $this->db->from('tbl_overtimes as tb1');
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        // $this->db->join('tbl_employee_infos as tb2','tb1.assigned_by=tb2.id','left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        $this->db->where('tb3.reporting_to', $user_id);
        // if(!empty($status)){
        //     $this->db->like('status',$status);
        // }
        if (!empty($search)) {
            $this->db->where('tb3.id', $search);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        // echo '<pre>';
        // var_dump($query);
        return $query->result();
    }
    function GET_OVERTIMES_COUNT_DIRECT($status, $search, $filter_arr, $user_id)
    {
        $new_filter = array();
        $new_filter['tb3.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb3.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb3.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb3.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb3.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb3.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        $this->db->select('tb1.id,tb1.date_ot,tb1.hours,tb1.type,tb1.time_out,tb1.reason,tb1.status,tb1.comment');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee", false);
        $this->db->from('tbl_overtimes as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.assigned_by=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        // $this->db->where('tb3.reporting_to',$user_id);
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        if (!empty($search)) {
            $this->db->where('tb3.id', $search);
        }
        $this->db->where('tb3.reporting_to', $user_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function GET_OVERTIME_COUNT_DIRECT($status, $search, $filter_arr)
    {
        $user_id                                    = $this->session->userdata('SESS_USER_ID');
        $new_filter = array();
        $new_filter['tb3.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb3.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb3.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb3.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb3.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        $this->db->select('tb1.id,tb1.date_ot,tb1.hours,tb1.type,tb1.time_out,tb1.reason,tb1.status,tb1.comment');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee", false);
        $this->db->from('tbl_overtimes as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.assigned_by=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        $this->db->where('tb3.reporting_to', $user_id);
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        // if(!empty($status)){
        //     $this->db->like('status',$status);
        // }
        if (!empty($search)) {
            $this->db->where('tb3.id', $search);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    function GET_OVERTIME_IS_DUPLICATE_DATE($date, $empl_id)
    {
        $sql = "SELECT * FROM tbl_overtimes WHERE date_ot=? AND empl_id=?";
        $query = $this->db->query($sql, array($date, $empl_id));
        return $query->num_rows();
    }
    function GET_TIME_ADJUSTMENT_IS_DUPLICATE_DATE($date, $empl_id)
    {
        $sql = "SELECT * FROM tbl_attendance_adjustments WHERE date_adjustment=? AND empl_id=?";
        $query = $this->db->query($sql, array($date, $empl_id));
        return $query->num_rows();
    }
    function GET_EMPLOYEE_ALL()
    {
        $this->db->select('id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name');
        $this->db->where("disabled = 0 AND (termination_date IS NULL OR termination_date = '0000-00-00') ");
        $this->db->order_by('col_empl_cmid + 0 ', 'ASC');
        $query = $this->db->get('tbl_employee_infos');
        return $query->result();
    }
    function ADD_OVERTIME_REQUEST($data)
    {
        return $this->db->insert('tbl_overtimes', $data);
    }
    function ADD_TIME_ADJUSTMENT_REQUEST($data)
    {
        return $this->db->insert('tbl_attendance_adjustments', $data);
    }

    function GET_TIME_ADJ_LIST_COUNT($search, $reporting_to_empl, $company, $branch, $dept, $div, $clubhouse, $section, $group, $line, $team, $status)
    {

        $employee   = !empty($search) ? $search : 'NULL';
        $reporting_to_empl   = !empty($reporting_to_empl) ? $reporting_to_empl : 'NULL';
        $company    = !empty($company) ? "'$company'" : 'NULL';
        $branch     = !empty($branch) ? "'$branch'" : 'NULL';
        $dept       = !empty($dept) ? "'$dept'" : 'NULL';
        $div        = !empty($div) ? "'$div'" : 'NULL';
        $clubhouse  = !empty($clubhouse) ? "'$clubhouse'" : 'NULL';
        $section    = !empty($section) ? "'$section'" : 'NULL';
        $group      = !empty($group) ? "'$group'" : 'NULL';
        $line       = !empty($line) ? "'$line'" : 'NULL';
        $team       = !empty($team) ? "'$team'" : 'NULL';
        $status     = !empty($status) ? "'$status'" : 'NULL';

        $procedure = "CALL GetTimeAdjustmentListCount($employee, $reporting_to_empl, $company, $branch, $dept, $div, $clubhouse, $section, $group, $line, $team, $status);";
        $query = $this->db->query($procedure);

        if ($query) {
            $result = $query->row();
            $query->next_result();
            $query->free_result();
            return $result->total_count;
        }
        return 0;
    }

    function GET_TIME_ADJ_LIST($search, $reporting_to_empl, $offset, $limit, $company, $branch, $dept, $div, $clubhouse, $section, $group, $line, $team, $status)
    {

        $search                 = !empty($search) ? $search : 'NULL';
        $reporting_to_empl      = !empty($reporting_to_empl) ? $reporting_to_empl : 'NULL';
        $company                = !empty($company) ? "'$company'" : 'NULL';
        $branch                 = !empty($branch) ? "'$branch'" : 'NULL';
        $dept                   = !empty($dept) ? "'$dept'" : 'NULL';
        $div                    = !empty($div) ? "'$div'" : 'NULL';
        $clubhouse              = !empty($clubhouse) ? "'$clubhouse'" : 'NULL';
        $section                = !empty($section) ? "'$section'" : 'NULL';
        $group                  = !empty($group) ? "'$group'" : 'NULL';
        $line                   = !empty($line) ? "'$line'" : 'NULL';
        $team                   = !empty($team) ? "'$team'" : 'NULL';
        $status                 = !empty($status) ? "'$status'" : 'NULL';

        $procedure = "CALL GetTimeAdjustmentList(" . $search . ", " . $reporting_to_empl . ", " . $offset . ", " . $limit . ", " .
            $company . ", " . $branch . ", " . $dept . ", " . $div . ", " . $clubhouse . ", " .
            $section . ", " . $group . ", " . $line . ", " . $team . ", " . $status . ");";

        $query = $this->db->query($procedure);
        $result = $query->result();
        $query->next_result();
        $query->free_result();
        return $result;
    }

    function GET_TIME_ADJ_DIRECT($status, $search, $limit, $offset, $filter_arr, $user_id)
    {
        $new_filter = array();
        $new_filter['tb3.col_empl_company'] = isset($filter_arr['company']) ? $filter_arr['company'] : null;
        $new_filter['tb3.col_empl_branch']  = isset($filter_arr['branch']) ? $filter_arr['branch'] : null;
        $new_filter['tb3.col_empl_dept']    = isset($filter_arr['dept']) ? $filter_arr['dept'] : null;
        $new_filter['tb3.col_empl_divi']    = isset($filter_arr['div']) ? $filter_arr['div'] : null;
        $new_filter['tb3.col_empl_club']    = isset($filter_arr['clubhouse']) ? $filter_arr['clubhouse'] : null;
        $new_filter['tb3.col_empl_sect']    = isset($filter_arr['section']) ? $filter_arr['section'] : null;
        $new_filter['tb3.col_empl_group']   = isset($filter_arr['group']) ? $filter_arr['group'] : null;
        $new_filter['tb3.col_empl_line']    = isset($filter_arr['line']) ? $filter_arr['line'] : null;
        $new_filter['tb3.col_empl_team']    = isset($filter_arr['team']) ? $filter_arr['team'] : null;

        $filtered = array_filter($new_filter);
        $this->db->select('tb1.id,tb1.time_in_1,tb1.time_out_1,tb1.remarks,tb1.status,tb4.id as assigned_by_tb_id, tb3.id as employee_tb_id');
        $this->db->select("
        CONCAT_WS(
            '', 
            CONCAT(tb3.col_empl_cmid, '-', tb3.col_last_name), 
            CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix <> '' THEN CONCAT(' ',tb3.col_suffix) ELSE '' END,
            CASE WHEN tb3.col_frst_name IS NOT NULL AND tb3.col_frst_name <> '' THEN CONCAT(', ',tb3.col_frst_name) ELSE '' END, 
            CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb3.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)
            ->select("CONCAT('ADJ', LPAD(tb1.id, 5, '0')) as c_id", false)
            ->select("DATE_FORMAT(tb1.date_adjustment, '%d/%m/%Y') as date_adjustment", false);
        $this->db->select("
        CONCAT_WS(
            '', 
            CONCAT(tb4.col_empl_cmid, '-', tb4.col_last_name), 
            CASE WHEN tb4.col_suffix IS NOT NULL AND tb4.col_suffix <> '' THEN CONCAT(' ',tb4.col_suffix) ELSE '' END,
            CASE WHEN tb4.col_frst_name IS NOT NULL AND tb4.col_frst_name <> '' THEN CONCAT(', ',tb4.col_frst_name) ELSE '' END, 
            CASE WHEN tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb4.col_midl_name, 1)), '.') ELSE '' END
        ) AS assigned_by
        ", false);
        $this->db->from('tbl_attendance_adjustments as tb1');
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.assigned_by=tb4.id', 'left');
        if (!empty($search)) {
            $this->db->where('tb3.id', $search);
        }
        $this->db->where('tb3.reporting_to', $user_id);
        $this->db->limit($limit, $offset);
        $this->db->order_by('tb1.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    function GET_TIME_ADJ_COUNT_DIRECT($status, $search, $filter_arr, $user_id)
    {
        $new_filter = array();
        $new_filter['tb3.col_empl_company'] = isset($filter_arr['company']) ? $filter_arr['company'] : null;
        $new_filter['tb3.col_empl_branch']  = isset($filter_arr['branch']) ? $filter_arr['branch'] : null;
        $new_filter['tb3.col_empl_dept']    = isset($filter_arr['dept']) ? $filter_arr['dept'] : null;
        $new_filter['tb3.col_empl_divi']    = isset($filter_arr['div']) ? $filter_arr['div'] : null;
        $new_filter['tb3.col_empl_club']    = isset($filter_arr['clubhouse']) ? $filter_arr['clubhouse'] : null;
        $new_filter['tb3.col_empl_sect']    = isset($filter_arr['section']) ? $filter_arr['section'] : null;
        $new_filter['tb3.col_empl_group']   = isset($filter_arr['group']) ? $filter_arr['group'] : null;
        $new_filter['tb3.col_empl_line']    = isset($filter_arr['line']) ? $filter_arr['line'] : null;
        $new_filter['tb3.col_empl_team']    = isset($filter_arr['team']) ? $filter_arr['team'] : null;

        $filtered = array_filter($new_filter);
        $this->db->select('tb1.id,tb1.date_adjustment,tb1.time_in_1,tb1.time_out_1,tb1.remarks');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee", false);
        $this->db->from('tbl_attendance_adjustments as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.assigned_by=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        // $this->db->where('tb3.reporting_to',$user_id);
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        if (!empty($search)) {
            $this->db->where('tb3.id', $search);
        }
        $this->db->where('tb3.reporting_to', $user_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function GET_TIME_ADJUSTMENT_DIRECT($status, $search, $limit, $offset, $filter_arr)
    {

        $new_filter = array();
        $new_filter['tb3.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb3.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb3.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb3.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb3.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        // var_dump($filtered);    
        $this->db->select('tb1.id,tb1.time_in_1,tb1.time_out_1,tb1.remarks,tb1.status,tb3.id as assigned_by_tb_id, tb3.id as employee_tb_id');
        // $this->db->select('tb2.id as assigned_by_tb_id');
        // $this->db->select('tb3.id as employee_tb_id');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        // $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by",false);
        // $this->db->select("CONCAT_WS('',COALESCE(tb2.col_last_name, ''), 
        // CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END, ', ',
        // COALESCE(tb2.col_frst_name, ''), 
        // CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        // ) AS assigned_by", false);

        // $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee",false);

        // $this->db->select("CONCAT_WS('',COALESCE(tb3.col_last_name, ''), 
        // CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix != '' THEN CONCAT(' ', tb3.col_suffix) ELSE '' END, ', ',
        // COALESCE(tb3.col_frst_name, ''), 
        // CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name != '' THEN CONCAT(' ', LEFT(tb3.col_midl_name, 1), '.') ELSE '' END
        // ) AS employee", false);

        $this->db->select("
        CONCAT_WS(
            '', 
            CONCAT(tb3.col_empl_cmid, '-', tb3.col_last_name), 
            CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix <> '' THEN CONCAT(' ',tb3.col_suffix) ELSE '' END,
            CASE WHEN tb3.col_frst_name IS NOT NULL AND tb3.col_frst_name <> '' THEN CONCAT(', ',tb3.col_frst_name) ELSE '' END, 
            CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb3.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)
            ->select("CONCAT('ADJ', LPAD(tb1.id, 5, '0')) as c_id", false)
            ->select("DATE_FORMAT(tb1.date_adjustment, '%d/%m/%Y') as date_adjustment", false);;

        $this->db->from('tbl_attendance_adjustments as tb1');
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        // $this->db->join('tbl_employee_infos as tb2','tb1.assigned_by=tb2.id','left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        // $this->db->where('tb3.reporting_to',$user_id)
        // if(!empty($status)){
        //     $this->db->like('status',$status);
        // }
        if (!empty($search)) {
            $this->db->where('tb3.id', $search);
        }
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        // echo '<pre>';
        // var_dump($query);
        return $query->result();
    }

    function GET_TIME_ADJUSTMENT_COUNT_DIRECT($status, $search, $filter_arr)
    {
        $new_filter = array();
        $new_filter['tb3.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb3.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb3.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb3.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb3.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        $this->db->select('tb1.id,tb1.time_in_1,tb1.time_out_1,tb1.remarks,tb1.status,tb3.id as assigned_by_tb_id, tb3.id as employee_tb_id');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee", false);
        $this->db->from('tbl_attendance_adjustments as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.assigned_by=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        // $this->db->where('tb3.reporting_to',$user_id);
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        // if(!empty($status)){
        //     $this->db->like('status',$status);
        // }
        if (!empty($search)) {
            $this->db->where('tb3.id', $search);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function GET_CHANGE_SHIFT_DIRECT($status, $search, $limit, $offset, $filter_arr)
    {
        $new_filter = array();
        $new_filter['tb3.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb3.col_empl_branch'] = $filter_arr['branch'];
        $new_filter['tb3.col_empl_dept'] = $filter_arr['dept'];
        $new_filter['tb3.col_empl_divi'] = $filter_arr['div'];
        $new_filter['tb3.col_empl_sect'] = $filter_arr['section'];
        $new_filter['tb3.col_empl_group'] = $filter_arr['group'];
        $new_filter['tb3.col_empl_line'] = $filter_arr['line'];
        $new_filter['tb3.col_empl_team'] = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select('tb1.create_date, tb1.id, date_shift, tb1.current_shift, request_shift.name as request_shift_name, date_shift_to, current_shift_to, request_shift_to, reason, tb1.status, comment');

        $this->db->select("
            CONCAT_WS(
                '', 
                CONCAT(tb3.col_empl_cmid, '-', tb3.col_last_name), 
                CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix <> '' THEN CONCAT(' ', tb3.col_suffix) ELSE '' END,
                CASE WHEN tb3.col_frst_name IS NOT NULL AND tb3.col_frst_name <> '' THEN CONCAT(', ', tb3.col_frst_name) ELSE '' END, 
                CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name <> '' THEN CONCAT(' ', UPPER(LEFT(tb3.col_midl_name, 1)), '.') ELSE '' END
            ) AS employee
        ", false);

        $this->db->select("CONCAT('CHS', LPAD(tb1.id, 5, '0')) as c_id", false);
        $this->db->select("DATE_FORMAT(tb1.date_shift, '%d/%m/%Y') as date_shift", false);

        $this->db->from('tbl_attendance_changeshift as tb1');

        if (!empty($filtered)) {
            $this->db->where($filtered);
        }

        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id = tb3.id', 'left');
        $this->db->join('tbl_attendance_shifts as request_shift', 'tb1.request_shift = request_shift.id', 'left');

        if (!empty($search)) {
            $this->db->where('tb3.id', $search);
        }

        if (!empty($status)) {
            $this->db->like('tb1.status', $status); // Ensure this matches tb1.status
        }

        $this->db->limit($limit, $offset);
        $this->db->order_by('tb1.id', 'desc');

        $query = $this->db->get();
        return $query->result();
    }


    function GET_CHANGE_SHIFT_COUNT_DIRECT($status, $search, $filter_arr)
    {
        $new_filter = array();
        $new_filter['tb3.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb3.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb3.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb3.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb3.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        $this->db->select('tb1.create_date,tb1.id,date_shift,current_shift,request_shift, date_shift_to, current_shift_to, request_shift_to, reason,status,comment');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        // $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by",false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee", false);
        $this->db->from('tbl_attendance_changeshift as tb1');
        // $this->db->join('tbl_employee_infos as tb2','tb1.assigned_by=tb2.id','left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        // $this->db->where('tb3.reporting_to',$user_id);
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        // if(!empty($status)){
        //     $this->db->like('status',$status);
        // }
        if (!empty($search)) {
            $this->db->where('tb3.id', $search);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function GET_ATTENDANCE_EMPL_REC($user_id)
    {
        $sql = "SELECT id, date, empl_id, time_format(time_in, '%H:%i') as time_in, 
        time_format(time_out, '%H:%i') as time_out FROM tbl_attendance_records 
        WHERE empl_id=? AND
        NOT EXISTS( SELECT * FROM tbl_attendance_adjustments WHERE tbl_attendance_records.date=tbl_attendance_adjustments.date_adjustment
        AND tbl_attendance_adjustments.empl_id=?   )";
        $query = $this->db->query($sql, array($user_id, $user_id));
        $query->next_result();
        return $query->result();
    }
    function GET_REQUESTOR($type, $id)
    {
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as requestor", false);
        if ($type == 'leave') {
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
    function GET_HOLIDAY_WORKS_DIRECT($status, $search, $limit, $offset, $filter_arr, $user_id)
    {
        $new_filter = array();
        $new_filter['tb3.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb3.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb3.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb3.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb3.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb3.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        $this->db->select('tb1.id,tb1.date,tb1.hours,tb1.comment,tb1.type,tb1.reason,tb1.status,tb4.id as assigned_by_tb_id, tb3.id as employee_tb_id');
        $this->db->select("
        CONCAT_WS(
            '', 
            CONCAT(tb3.col_empl_cmid, '-', tb3.col_last_name), 
            CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix <> '' THEN CONCAT(' ',tb3.col_suffix) ELSE '' END,
            CASE WHEN tb3.col_frst_name IS NOT NULL AND tb3.col_frst_name <> '' THEN CONCAT(', ',tb3.col_frst_name) ELSE '' END, 
            CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb3.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)
            ->select("CONCAT('HDW', LPAD(tb1.id, 5, '0')) as c_id", false)
            ->select("DATE_FORMAT(tb1.date, '%d/%m/%Y') as date", false);
        $this->db->select("
        CONCAT_WS(
            '', 
            CONCAT(tb4.col_empl_cmid, '-', tb4.col_last_name), 
            CASE WHEN tb4.col_suffix IS NOT NULL AND tb4.col_suffix <> '' THEN CONCAT(' ',tb4.col_suffix) ELSE '' END,
            CASE WHEN tb4.col_frst_name IS NOT NULL AND tb4.col_frst_name <> '' THEN CONCAT(', ',tb4.col_frst_name) ELSE '' END, 
            CASE WHEN tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb4.col_midl_name, 1)), '.') ELSE '' END
        ) AS assigned_by
        ", false);
        $this->db->from('tbl_holidaywork as tb1');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.assigned_by=tb4.id', 'left');
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        if (!empty($search)) {
            $this->db->where('tb3.id', $search);
        }
        $this->db->where('tb3.reporting_to', $user_id);
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }
    function GET_HOLIDAY_WORKS_COUNT($search, $status, $filter_arr, $user_id)
    {
        $new_filter = array();
        $new_filter['tb3.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb3.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb3.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb3.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb3.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb3.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);
        $this->db->select('tb1.id,tb1.date,tb1.hours,tb1.type,tb1.reason,tb1.status,tb1.comment');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee", false);
        $this->db->from('tbl_holidaywork as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.assigned_by=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        if (!empty($search)) {
            $this->db->where('tb3.id', $search);
        }
        $this->db->where('tb3.reporting_to', $user_id);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->num_rows();
    }
    function GET_EMPLOYEE_TABLE_ID($col_empl_cmid)
    {
        $sql   = "SELECT id FROM tbl_employee_infos WHERE col_empl_cmid=? ";
        $query = $this->db->query($sql, array($col_empl_cmid));
        $query->next_result();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->id;
        } else {
            return null;
        }
    }
    function GET_LEAVE_IS_DUPLICATE_DATE_BY_ID($date, $empl_id, $id)
    {
        $sql = "SELECT * FROM tbl_leaves_assign WHERE leave_date=? AND empl_id=? AND id!=? ";
        $query = $this->db->query($sql, array($date, $empl_id, $id));
        return $query->num_rows();
    }
    function GET_OVERTIME_IS_DUPLICATE_DATE_BY_ID($date, $empl_id, $id)
    {
        $sql = "SELECT * FROM tbl_overtimes WHERE date_ot=? AND empl_id=? AND id!=? ";
        $query = $this->db->query($sql, array($date, $empl_id, $id));
        return $query->num_rows();
    }
    function GET_LEAVE_IS_DUPLICATE_DATE($date, $empl_id)
    {
        $sql = "SELECT * FROM tbl_leaves_assign WHERE leave_date=? AND empl_id=?";
        $query = $this->db->query($sql, array($date, $empl_id));
        return $query->num_rows();
    }
    function GET_SHIFT_IS_DUPLICATE_DATE($date, $empl_id)
    {
        $sql = "SELECT * FROM tbl_attendance_changeshift WHERE date_shift=? AND empl_id=?";
        $query = $this->db->query($sql, array($date, $empl_id));
        return $query->num_rows();
    }
    function UPDATE_LEAVE($data, $id)
    {
        unset($data['c_id']);
        $this->db->where('id', $id);
        return $this->db->update('tbl_leaves_assign', $data);
    }
    function UPDATE_OVERTIME($data, $id)
    {
        unset($data['c_id']);
        $this->db->where('id', $id);
        return $this->db->update('tbl_overtimes', $data);
    }
    function GET_HOLIDAY_WORKS_IS_DUPLICATE_DATE_BY_ID($date, $empl_id, $id)
    {
        $sql = "SELECT * FROM tbl_holidaywork WHERE date=? AND empl_id=? AND id!=? ";
        $query = $this->db->query($sql, array($date, $empl_id, $id));
        return $query->num_rows();
    }
    function UPDATE_HOLIDAY_WORKS($data, $id)
    {
        unset($data['c_id']);
        $this->db->where('id', $id);
        return $this->db->update('tbl_holidaywork', $data);
    }
    function UPDATE_CHANGE_SHIFT($data)
    {
        if (!empty($data) && isset($data[0]['id'])) {
            $this->db->update_batch('tbl_attendance_changeshift', $data, 'id');

            // Log the last executed query for debugging
            log_message('debug', 'Last Query: ' . $this->db->last_query());

            // Check for database errors
            if ($this->db->_error_message()) {
                $error_message = $this->db->_error_message();
                log_message('error', 'Database Error: ' . $error_message);
                return $error_message;
            }

            // Get the number of affected rows
            $affected_rows = $this->db->affected_rows();
            return $affected_rows;
        }

        return 0;
    }

    function get_shift_id_by_name($shift_name)
    {
        // Fetch shift ID from the database
        $this->db->select('id');
        $this->db->from('tbl_attendance_shifts');
        $this->db->where('name', $shift_name);
        $query = $this->db->get();

        $result = $query->row();
        return $result ? $result->id : null;
    }

    function ADD_NOTIFICATION($data)
    {
        $this->db->insert('tbl_notifications', $data);
        return $this->db->insert_id();
    }
    function ADD_TIME_ADJ($data)
    {
        $query = $this->db->insert_batch('tbl_attendance_adjustments', $data);

        if ($this->db->_error_message()) {
            $error_message = $this->db->_error_message();
            return $error_message;
        }

        // Get the number of affected rows
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }
    function ADD_DATA($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    function ADD_LEAVE_REQUEST_old($data)
    {
        return $this->db->insert('tbl_leaves_assign', $data);
    }
    function ADD_LEAVE_REQUEST($data)
    {
        $this->db->insert('tbl_leaves_assign', $data);
        return $this->db->insert_id();
    }

    function ADD_SHIFT_CHANGE($data)
    {
        $this->db->insert('tbl_attendance_changeshift', $data);
        return $this->db->insert_id();
    }

    function GET_DAY_TYPE($day_type)
    {
        $sql = "SELECT name AS daytype FROM tbl_std_holidays WHERE col_holi_date LIKE '%$day_type%' ";
        $result = $this->db->query($sql)->row();
        $theday = $result ? $result->daytype : 0;
        return $theday;
    }
    function GET_FILTERED_EMPLOYEELIST_2($offset, $row, $branch, $dept, $division, $section, $group, $team, $line, $id)
    {
        $sql = "SELECT t1.id,t1.col_empl_cmid,t1.col_last_name,t1.col_midl_name,t1.col_frst_name 
        FROM tbl_employee_infos AS t1
        LEFT JOIN tbl_employee_infos AS t2 ON t2.reporting_to = t1.id
        WHERE t1.termination_date IS NULL OR t1.termination_date = '0000-00-00' AND t1.disabled=0  
        AND t2.reporting_to =?
        ORDER BY col_empl_cmid ASC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }
    // function GET_FILTERED_EMPLOYEELIST_DATA($offset, $row, $branch, $dept, $division, $section, $group, $team, $line, $id)
    // {
    //     $sql = "SELECT DISTINCT t1.id,t1.col_empl_cmid, 
    //     CONCAT_WS(
    //         '', 
    //         COALESCE(t1.col_empl_cmid, ''), 
    //         CASE WHEN t1.col_last_name IS NOT NULL AND t1.col_last_name != '' THEN CONCAT('-', t1.col_last_name) ELSE '' END,
    //         CASE WHEN t1.col_suffix IS NOT NULL AND t1.col_suffix != '' THEN CONCAT(' ', t1.col_suffix) ELSE '' END,
    //         CASE WHEN t1.col_frst_name IS NOT NULL AND t1.col_frst_name != '' THEN CONCAT(', ', t1.col_frst_name) ELSE '' END,
    //         CASE WHEN t1.col_midl_name IS NOT NULL AND t1.col_midl_name != '' THEN CONCAT(' ', LEFT(t1.col_midl_name, 1), '.') ELSE '' END
    //     ) AS full_name
    //     FROM tbl_employee_infos AS t1
    //     LEFT JOIN tbl_employee_infos AS t2 ON t2.reporting_to = t1.id
    //     WHERE (t1.termination_date IS NULL OR t1.termination_date = '0000-00-00') AND t1.disabled=0 
    //     AND t1.reporting_to = ?
    //     ORDER BY t1.col_last_name ASC
    //     LIMIT " . $offset . ", " . $row . " ";
    //     $query = $this->db->query($sql, array($id));
    //     $query->next_result();
    //     return $query->result();
    // }

    function GET_FILTERED_EMPLOYEELIST_DATA($offset, $row, $branch, $dept, $division, $section, $group, $team, $line, $id)
    {
        $sql = "SELECT  tb_as.id, tb_as.empl_id, tb_emp.col_empl_cmid, tb_as.prepared_by, tb_as.checked_by, tb_as.noted_by,
        CONCAT_WS(
            '', 
            COALESCE(tb_emp.col_empl_cmid, ''), 
            CASE WHEN tb_emp.col_last_name IS NOT NULL AND tb_emp.col_last_name != '' THEN CONCAT('-', tb_emp.col_last_name) ELSE '' END,
            CASE WHEN tb_emp.col_suffix IS NOT NULL AND tb_emp.col_suffix != '' THEN CONCAT(' ', tb_emp.col_suffix) ELSE '' END,
            CASE WHEN tb_emp.col_frst_name IS NOT NULL AND tb_emp.col_frst_name != '' THEN CONCAT(', ', tb_emp.col_frst_name) ELSE '' END,
            CASE WHEN tb_emp.col_midl_name IS NOT NULL AND tb_emp.col_midl_name != '' THEN CONCAT(' ', LEFT(tb_emp.col_midl_name, 1), '.') ELSE '' END
        ) AS full_name

        FROM tbl_approvers_shift AS tb_as 
        LEFT JOIN tbl_employee_infos AS tb_emp ON tb_as.empl_id = tb_emp.id
        WHERE (tb_emp.termination_date IS NULL OR tb_emp.termination_date = '0000-00-00') AND tb_emp.disabled=0 
        AND prepared_by = ?

        ORDER BY tb_as.id ASC
        /*LIMIT " . $offset . ", " . $row . "*/ ";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }




    function GET_FILTERED_EMPLOYEELIST_DATA_COUNT($offset, $row, $branch, $dept, $division, $section, $group, $team, $line, $id)
    {
        $sql = "SELECT DISTINCT t1.id,t1.col_empl_cmid, 
        CONCAT_WS(
            '', 
            COALESCE(t1.col_last_name, ''), 
            CASE WHEN t1.col_suffix IS NOT NULL AND t1.col_suffix != '' THEN CONCAT(' ', t1.col_suffix) ELSE '' END, ', ',
            COALESCE(t1.col_frst_name, ''), 
            CASE WHEN t1.col_midl_name IS NOT NULL AND t1.col_midl_name != '' THEN CONCAT(' ', LEFT(t1.col_midl_name, 1), '.') ELSE '' END
        ) AS full_name
        FROM tbl_employee_infos AS t1
        LEFT JOIN tbl_employee_infos AS t2 ON t2.reporting_to = t1.id
        WHERE (t1.termination_date IS NULL OR t1.termination_date = 0000-00-00) AND t1.disabled=0 
        AND t1.reporting_to = ?
        ORDER BY t1.col_empl_cmid + 0 ASC";
        $query = $this->db->query($sql, array($id));
        return $query->num_rows();
    }
    function GET_FILTERED_EMPLOYEELIST_COUNT($branch, $dept, $division, $section, $group, $team, $line)
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
        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,col_empl_line FROM tbl_employee_infos 
        WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND col_empl_branch  = $branch
        AND col_empl_dept    = $dept
        AND col_empl_divi    = $division
        AND col_empl_sect    = $section
        AND col_empl_group   = $group
        AND col_empl_team    = $team
        AND col_empl_line    = $line
        ORDER BY col_empl_cmid
        ";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function GET_SEARCHED($search)
    {
        $sql = "SELECT * FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND (tbl_employee_infos.col_empl_cmid LIKE '%$search%' 
        OR CONCAT(col_last_name, ' ', col_frst_name, ' ', col_midl_name) LIKE '%$search%') 
        ORDER BY id ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_SEARCHED_EMPL($search)
    {
        $sql = "SELECT *, 
        CONCAT_WS(
            '', 
            COALESCE(col_last_name, ''), 
            CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END, ', ',
            COALESCE(col_frst_name, ''), 
            CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS full_name
        FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date IS NULL) AND disabled=0 AND id=?
        ORDER BY id ASC";
        $query = $this->db->query($sql, $search);
        $query->next_result();
        return $query->result();
    }
    function GET_SEARCHED_ALL_EMPL($id)
    {
        $sql = "SELECT DISTINCT t1.id,t1.col_empl_cmid,t1.col_last_name,t1.col_midl_name,t1.col_frst_name 
        FROM tbl_employee_infos AS t1
        LEFT JOIN tbl_employee_infos AS t2 ON t2.reporting_to = t1.id
        WHERE (t1.termination_date IS NULL OR t1.termination_date = 0000-00-00) AND t1.disabled=0
        AND t1.reporting_to = ?
        ORDER BY t1.col_empl_cmid +0 ASC";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_PAY_SCHED()
    {
        $sql = "SELECT id,name FROM tbl_payroll_period WHERE status='active' ORDER BY id desc";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_WORK_SHIFT_DATA()
    {
        $sql = "SELECT * FROM tbl_attendance_shifts where is_deleted=0 AND status='Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_PERIOD_DATA($sched_id)
    {
        $sql = "SELECT date_from,date_to FROM tbl_payroll_period WHERE id=? AND status=?  ORDER BY id desc";
        $query = $this->db->query($sql, array($sched_id, 'active'));
        $data = $query->row_array();
        return $data;
    }
    function GET_PERIOD_LIST()
    {
        $sql = "SELECT id,date_from,date_to,name FROM tbl_payroll_period WHERE status=? ORDER BY id desc";
        $query = $this->db->query($sql, array('active'));
        return $query->result();
    }
    function GET_HOLIDAY()
    {
        $sql = "SELECT col_holi_date,col_holi_type FROM tbl_std_holidays";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SHIFT_DATA_DATERANGE($begin, $end)
    {
        $sql = "SELECT empl_id,date,shift_id,lock_shift FROM tbl_attendance_shiftassign_temp WHERE date >= '$begin' AND date <= '$end' AND is_deleted=0";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_SHIFT_APPROVAL($assigned_by_id, $period)
    {
        $sql = "SELECT assigned_by, empl_id, cutoff_period, status FROM tbl_attendance_shiftassign_approval WHERE assigned_by=? AND cutoff_period=? AND is_deleted=0";
        $query = $this->db->query($sql, array($assigned_by_id, $period));
        $query->next_result();
        return $query->result();
    }

    // function GET_SHIFT_DATA_DATERANGE($begin, $end)
    // {
    //     $sql = "SELECT empl_id,date,shift_id FROM tbl_attendance_shiftassign WHERE date >= '$begin' AND date <= '$end' AND is_deleted=0";
    //     $query = $this->db->query($sql);
    //     $query->next_result();
    //     return $query->result();
    // }

    function GET_SHIFT_ALL_DATA()
    {
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE status='Active'";
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
    function GET_SHIFTAPPROVAL_LIST()
    {
        $sql = "SELECT * FROM tbl_attendance_shiftassign_approval";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MON_DISP_CUTOFF_PERIOD($start_date, $end_date, $employee_id)
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date >= ? AND date <= ? AND empl_id=?";
        $query = $this->db->query($sql, array($start_date, $end_date, $employee_id));
        $query->next_result();
        return $query->result();
    }
    function convert_name2id($array, $pos)
    {
        $id = "";
        $posLower = strtolower($pos);
        foreach ($array as $e) {
            $nameLower = strtolower($e->code);
            if ($nameLower == $posLower) {
                $id = $e->id;
                return $id;
            }
        }
        return 0;
    }

    // function GET_SHIFT_APPROVALS($userId)
    // {


    //     $sql = "SELECT *, tbl_attendance_shiftassign_approval.status as status FROM tbl_attendance_shiftassign_approval 
    //     LEFT JOIN tbl_payroll_period ON tbl_attendance_shiftassign_approval.cutoff_period=tbl_payroll_period.id
    //     WHERE assigned_by = $userId AND tbl_attendance_shiftassign_approval.status = 'Pending' ";

    //     $query = $this->db->query($sql, array());
    //     $query->next_result();
    //     return $query->result();
    // }

    function GET_SHIFT_APPROVALS($userId)
    {


        $sql = "SELECT *, tbl_attendance_shiftassign_approval.status as status FROM tbl_attendance_shiftassign_approval 
        LEFT JOIN tbl_payroll_period ON tbl_attendance_shiftassign_approval.cutoff_period=tbl_payroll_period.id
        WHERE assigned_by = $userId ";

        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_EMPLOYEE()
    {
        $sql = "SELECT * FROM tbl_employee_infos";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function IS_DUPLICATE($user_id, $date)
    {
        $sql = "SELECT id FROM tbl_attendance_shiftassign_temp WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql, array($user_id, $date));
        $query->next_result();
        $data = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }
    function ADD_USER_WORK_SHIFT($user_id, $shift_id, $date)
    {
        $datetime = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_attendance_shiftassign_temp (create_date,edit_date,empl_id,date,shift_id) VALUES(?,?,?,?,?)";
        return $this->db->query($sql, array($datetime, $datetime, $user_id, $date, $shift_id));
    }
    function UPDATE_USER_WORK_SHIFT($user_id, $shift_id, $date)
    {
        $datetime = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_attendance_shiftassign_temp SET edit_date=?, shift_id=? WHERE empl_id=? AND date=?";
        return $this->db->query($sql, array($datetime, $shift_id, $user_id, $date));
    }
    function is_duplicate_data($user_id, $date)
    {
        $sql = "SELECT id FROM tbl_attendance_shiftassign_temp WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql, array($user_id, $date));
        return $query->num_rows();
    }
    function update_shift_data($data_row, $editUser)
    {
        $SHIFT_DATA         = $this->GET_SHIFT_ALL_DATA();
        $datetime           = date('Y-m-d H:i:s');
        $user_id            = $data_row[0];
        $shift_id           = $this->convert_name2id($SHIFT_DATA, $data_row[1]);
        $date               = $data_row[2];
        $is_duplicate       = $this->is_duplicate_data($user_id, $date);

        if ($is_duplicate > 0) {
            $sql = " UPDATE tbl_attendance_shiftassign_temp SET edit_date=?, shift_id=? WHERE empl_id=? AND date=?";
            $this->db->query($sql, array($datetime, $shift_id, $user_id, $date));
        } else {
            $sql = "INSERT INTO tbl_attendance_shiftassign_temp (create_date,edit_date,edit_user,is_deleted,empl_id,date,shift_id,lock_shift) VALUES(?,?,?,?,?,?,?,?)";
            $this->db->query($sql, array($datetime, $datetime, $editUser, 0, $user_id, $date, $shift_id, 1));
        }
    }

    function is_duplicate_shift_approval($empl_id, $cutoff_period)
    {
        $sql = "SELECT id FROM tbl_attendance_shiftassign_approval WHERE empl_id=? AND cutoff_period=? AND status='Pending' ";
        $query = $this->db->query($sql, array($empl_id, $cutoff_period));
        return $query->num_rows();
    }

    function update_shift_approval($data_row, $editUser)
    {

        $empl_id                    = $data_row[0];
        $cutoff_period              = $data_row[1];
        $datetime                   = date('Y-m-d H:i:s');
        $is_duplicate               = $this->is_duplicate_shift_approval($empl_id, $cutoff_period);
        $status                     = 'Pending';

        if ($is_duplicate > 0) {
        } else {
            $sql = "INSERT INTO tbl_attendance_shiftassign_approval (create_date, edit_date ,edit_user, is_deleted, assigned_by, empl_id, cutoff_period, status) VALUES(?,?,?,?,?,?,?,?)";
            $this->db->query($sql, array($datetime, $datetime, $editUser, 0, $editUser, $empl_id, $cutoff_period, $status));
        }
    }

    function is_duplicate_shiftassignment($user_id, $date)
    {
        $sql = "SELECT id FROM tbl_attendance_shiftassign WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql, array($user_id, $date));
        return $query->num_rows();
    }

    // function update_shift_assignment_data($data_row, $editUser){
    //     $SHIFT_DATA         = $this->GET_SHIFT_ALL_DATA();
    //     $datetime           = date('Y-m-d H:i:s');
    //     $user_id            = $data_row[0];
    //     $shift_id           = $this->convert_name2id($SHIFT_DATA, $data_row[1]);
    //     $date               = $data_row[2];
    //     $is_duplicate       = $this->is_duplicate_shiftassignment($user_id, $date);

    //     if ($is_duplicate > 0) {
    //         $sql = " UPDATE tbl_attendance_shiftassign SET edit_date=?, shift_id=? WHERE empl_id=? AND date=?";
    //         $this->db->query($sql, array($datetime, $shift_id, $user_id, $date));
    //     } else {
    //         $sql = "INSERT INTO tbl_attendance_shiftassign (create_date,edit_date,edit_user,is_deleted,empl_id,date,shift_id) VALUES(?,?,?,?,?,?,?)";
    //         $this->db->query($sql, array($datetime, $datetime, $editUser, 0, $user_id, $date, $shift_id));
    //     }
    // }

    function GET_MY_TEAM($id)
    {
        $sql = "SELECT 
        a.id,
        CONCAT_WS(
            '',
            COALESCE(a.col_last_name, ''),
            CASE WHEN a.col_suffix IS NOT NULL AND a.col_suffix != '' THEN CONCAT(' ',a.col_suffix) ELSE '' END, ', ',
            COALESCE(a.col_frst_name, ''),
            CASE WHEN a.col_midl_name IS NOT NULL AND a.col_midl_name != '' THEN CONCAT(' ', LEFT(a.col_midl_name, 1), '.') ELSE '' END
        ) AS name,
        a.col_imag_path AS image,
        a.col_empl_posi AS position,
        a.extra_posi as extra_position,
        CONCAT_WS(
            '', 
            COALESCE(b.col_last_name, ''), 
            CASE WHEN b.col_suffix IS NOT NULL AND b.col_suffix != '' THEN CONCAT(' ',b.col_suffix) ELSE '' END, ', ',
            COALESCE(b.col_frst_name, ''),
            CASE WHEN b.col_midl_name IS NOT NULL AND b.col_midl_name != '' THEN CONCAT(' ', LEFT(b.col_midl_name, 1), '.') ELSE '' END
        ) AS reporting_to,
        b.col_imag_path as superior_image,
        b.col_empl_posi AS superior_position,
        b.extra_posi as superior_extra_position,
        c.time_in AS time_in,
        c.time_out AS time_out,
        c.date AS date,
        c.empl_id
        FROM 
            tbl_employee_infos a
        LEFT OUTER JOIN 
            tbl_employee_infos b ON b.id = a.reporting_to  
            LEFT OUTER JOIN 
        tbl_attendance_records AS c ON a.id = c.empl_id
        WHERE 
        a.reporting_to = ?
        AND a.termination_date IS NULL OR a.termination_date = '0000-00-00'
        AND a.disabled = 0 ORDER BY c.date DESC";
        $query = $this->db->query($sql, array($id));
        $result = $query->result();
        return $result;
    }


    function MOD_DISP_DISTINCT_BRANCH()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_branches";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_DEPARTMENT()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_DIVISION()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_divisions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_CLUBHOUSE()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_clubhouse";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_SECTION()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_GROUP()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_groups";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_TEAM()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_teams";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_LINE()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_SYSTEM_SETTING_2($setting)
    {
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = ? ";
        $query = $this->db->query($sql, array($setting));
        $result = $query->row();
        if ($result) {
            return $result->value;
        }
        return '';
    }


    function GET_EMPL_APPROVALS_COUNT($search, $filter_arr)
    {
        $new_filter = array();
        $new_filter['tb1.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb1.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb1.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb1.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb1.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb1.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb1.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb1.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb1.col_empl_team']    = $filter_arr['team'];
        $new_filter['tb1.id']               = $filter_arr['id'];
        $filtered = array_filter($new_filter);

        $this->db->select("tb1.id,tb1.col_empl_cmid,tb1.col_last_name,tb1.col_midl_name,tb1.col_frst_name,tb2.approver_1a,tb2.approver_2a,tb2.approver_3a");
        $this->db->select("CONCAT(tb3.col_empl_cmid,'-',tb3.col_last_name,',',tb3.col_frst_name,' ',RPAD(LEFT(tb3.col_midl_name,1),2,'.')) as a1_approver", false);
        $this->db->select("CONCAT(tb4.col_empl_cmid,'-',tb4.col_last_name,',',tb4.col_frst_name,' ',RPAD(LEFT(tb4.col_midl_name,1),2,'.')) as a2_approver", false);
        $this->db->select("CONCAT(tb5.col_empl_cmid,'-',tb5.col_last_name,',',tb5.col_frst_name,' ',RPAD(LEFT(tb5.col_midl_name,1),2,'.')) as a3_approver", false);
        $this->db->select("CONCAT(tb6.col_empl_cmid,'-',tb6.col_last_name,',',tb6.col_frst_name,' ',RPAD(LEFT(tb6.col_midl_name,1),2,'.')) as b1_approver", false)
            ->from('tbl_employee_infos as tb1')
            ->join('tbl_approvers_leave as tb2', 'tb1.id = tb2.empl_id', 'left')
            ->join('tbl_employee_infos as tb3', 'tb2.approver_1a=tb3.id', 'left')
            ->join('tbl_employee_infos as tb4', 'tb2.approver_2a=tb4.id', 'left')
            ->join('tbl_employee_infos as tb5', 'tb2.approver_3a=tb5.id', 'left')
            ->join('tbl_employee_infos as tb6', 'tb2.approver_1b=tb6.id', 'left')
            ->where("tb1.disabled = '0' AND (tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00')");
        if (!empty($new_filter)) {
            $this->db->where($filtered);
        }
        $this->db->order_by('tb1.col_empl_cmid', 'ASC');
        if (!empty($search)) {
            $this->db->having("tb1.col_empl_cmid LIKE '%$search%'
            OR tb1.col_last_name LIKE '%$search%'
            OR tb1.col_midl_name LIKE '%$search%'
            OR tb1.col_frst_name LIKE '%$search%'
            ");
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function MOD_DISP_ALL_EMPLOYEES_LIST($search, $limit, $offset, $filter_arr)
    {
        $new_filter = array();
        $new_filter['col_empl_company'] = $filter_arr['company'];
        $new_filter['col_empl_branch']  = $filter_arr['branch'];
        $new_filter['col_empl_dept']    = $filter_arr['dept'];
        $new_filter['col_empl_divi']    = $filter_arr['div'];
        $new_filter['col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['col_empl_sect']    = $filter_arr['section'];
        $new_filter['col_empl_group']   = $filter_arr['group'];
        $new_filter['col_empl_line']    = $filter_arr['line'];
        $new_filter['col_empl_team']    = $filter_arr['team'];
        $new_filter['id']               = $filter_arr['id'];
        $filtered = array_filter($new_filter);

        // Filtering out empty values
        $filtered = array_filter($new_filter);

        // Constructing the WHERE clause based on the filtered array
        $where_clause = '';
        foreach ($filtered as $column => $value) {
            $where_clause .= "$column = '$value' AND ";
        }
        $where_clause = rtrim($where_clause, ' AND ');

        // Constructing the SQL query with the WHERE clause
        $sql = "SELECT id, col_empl_cmid, col_last_name, col_suffix, col_frst_name, col_midl_name, CONCAT(col_last_name, ', ', col_frst_name) as fullname 
        FROM tbl_employee_infos
        WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled = 0";
        if (!empty($where_clause)) {
            $sql .= " AND $where_clause";
        }
        $sql .= " ORDER BY col_last_name ASC";

        // Executing the SQL query
        $query = $this->db->query($sql);
        $query->next_result();

        // Returning the result
        return $query->result();
    }

    function GET_EMPL_APPROVALS_NEW($search, $limit, $offset, $filter_arr)
    {
        $new_filter = array();
        $new_filter['tb1.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb1.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb1.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb1.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb1.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb1.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb1.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb1.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb1.col_empl_team']    = $filter_arr['team'];
        $new_filter['tb1.id']               = $filter_arr['id'];
        $filtered = array_filter($new_filter);

        $this->db->select("tb1.id,tb1.col_empl_cmid,tb1.col_last_name,tb1.col_midl_name,tb1.col_frst_name");

        $this->db->select("CONCAT_WS('',
        CASE WHEN tb1.col_empl_cmid IS NOT NULL AND tb1.col_empl_cmid != '' THEN CONCAT(tb1.col_empl_cmid, '-') ELSE '' END,
        CASE WHEN tb1.col_last_name IS NOT NULL AND tb1.col_last_name != '' THEN CONCAT(tb1.col_last_name) ELSE '' END,
        CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
        CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
        CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
        ) AS employee_name", false);

        $this->db->select("CONCAT_WS('',
        CASE WHEN tb_pre.col_empl_cmid IS NOT NULL AND tb_pre.col_empl_cmid != '' THEN CONCAT(tb_pre.col_empl_cmid, '-') ELSE '' END,
        CASE WHEN tb_pre.col_last_name IS NOT NULL AND tb_pre.col_last_name != '' THEN CONCAT(tb_pre.col_last_name) ELSE '' END, 
        CASE WHEN tb_pre.col_suffix IS NOT NULL AND tb_pre.col_suffix != '' THEN CONCAT(' ', tb_pre.col_suffix) ELSE '' END,
        CASE WHEN tb_pre.col_frst_name IS NOT NULL AND tb_pre.col_frst_name != '' THEN CONCAT(', ', tb_pre.col_frst_name) ELSE '' END,
        CASE WHEN tb_pre.col_midl_name IS NOT NULL AND tb_pre.col_midl_name != '' THEN CONCAT(' ', LEFT(tb_pre.col_midl_name, 1), '.') ELSE '' END
        ) AS prepared_by", false);

        $this->db->select("CONCAT_WS('',
        CASE WHEN tb_check.col_empl_cmid IS NOT NULL AND tb_check.col_empl_cmid != '' THEN CONCAT(tb_check.col_empl_cmid, '-') ELSE '' END,
        CASE WHEN tb_check.col_last_name IS NOT NULL AND tb_check.col_last_name != '' THEN CONCAT(tb_check.col_last_name) ELSE '' END, 
        CASE WHEN tb_check.col_suffix IS NOT NULL AND tb_check.col_suffix != '' THEN CONCAT(' ', tb_check.col_suffix) ELSE '' END,
        CASE WHEN tb_check.col_frst_name IS NOT NULL AND tb_check.col_frst_name != '' THEN CONCAT(', ', tb_check.col_frst_name) ELSE '' END,
        CASE WHEN tb_check.col_midl_name IS NOT NULL AND tb_check.col_midl_name != '' THEN CONCAT(' ', LEFT(tb_check.col_midl_name, 1), '.') ELSE '' END
        ) AS checked_by", false);

        $this->db->select("CONCAT_WS('',
        CASE WHEN tb_note.col_empl_cmid IS NOT NULL AND tb_note.col_empl_cmid != '' THEN CONCAT(tb_note.col_empl_cmid, '-') ELSE '' END,
        CASE WHEN tb_note.col_last_name IS NOT NULL AND tb_note.col_last_name != '' THEN CONCAT(tb_note.col_last_name) ELSE '' END, 
        CASE WHEN tb_note.col_suffix IS NOT NULL AND tb_note.col_suffix != '' THEN CONCAT(' ', tb_note.col_suffix) ELSE '' END,
        CASE WHEN tb_note.col_frst_name IS NOT NULL AND tb_note.col_frst_name != '' THEN CONCAT(', ', tb_note.col_frst_name) ELSE '' END,
        CASE WHEN tb_note.col_midl_name IS NOT NULL AND tb_note.col_midl_name != '' THEN CONCAT(' ', LEFT(tb_note.col_midl_name, 1), '.') ELSE '' END
        ) AS noted_by", false)

            ->from('tbl_employee_infos as tb1')
            ->join('tbl_approvers_shift as tb2', 'tb1.id = tb2.empl_id', 'left')
            ->join('tbl_employee_infos as tb_pre', 'tb2.prepared_by = tb_pre.id', 'left')
            ->join('tbl_employee_infos as tb_check', 'tb2.checked_by = tb_check.id', 'left')
            ->join('tbl_employee_infos as tb_note', 'tb2.noted_by = tb_note.id', 'left')

            ->where("tb1.disabled = '0' AND (tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00')");

        if (!empty($new_filter)) {
            $this->db->where($filtered);
        }
        // if (!empty($status)) {
        //     $this->db->like('tb1.status', $status);
        // }
        $this->db->order_by('tb1.col_last_name', 'ASC');
        $this->db->order_by('CAST(tb1.col_empl_cmid AS SIGNED)', 'ASC');
        // if (!empty($search)) {
        //     $this->db->having("tb1.col_empl_cmid LIKE '%$search%'
        //     OR tb1.col_last_name LIKE '%$search%'
        //     OR tb1.col_midl_name LIKE '%$search%'
        //     OR tb1.col_frst_name LIKE '%$search%'
        //     ");
        // }
        // $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }

    function getEmployeeId($col_empl_cmid)
    {
        $sql    = "SELECT id FROM tbl_employee_infos WHERE col_empl_cmid=?";
        $query  = $this->db->query($sql, array($col_empl_cmid));
        $result = $query->row();
        if ($result) {
            return $result->id;
        } else {
            return null;
        }
    }

    function GET_ALL_LEAVETYPES()
    {
        $sql = "SELECT * FROM tbl_std_leavetypes WHERE status='Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_CHANGESHIFT_APPROVALS($userId, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team)
    {
        $filter_q = "";
        if ($dept && $dept !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_dept=" . $dept;
        }
        if ($sec && $sec !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_sect=" . $sec;
        }
        if ($group && $group !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_group=" . $group;
        }
        if ($line && $line !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_line=" . $line;
        }
        if ($branch && $branch !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_branch=" . $branch;
        }
        if ($division && $division !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_divi=" . $division;
        }
        if ($clubhouse && $clubhouse !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_club=" . $clubhouse;
        }
        if ($team && $team !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }

        $sql = "SELECT *, tbl_attendance_changeshift.empl_id as empl_id, tbl_attendance_changeshift.id as id FROM tbl_attendance_changeshift
        JOIN tbl_approvers_shift ON tbl_approvers_shift.empl_id = tbl_attendance_changeshift.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_attendance_changeshift.empl_id
        WHERE tbl_attendance_changeshift.status LIKE '%Pending%' " . $filter_q . " 

        AND (( (approver1 = $userId OR approver1_b = $userId) AND approver1_date='0000-00-00 00:00:00') OR 
        ( (approver2 = $userId OR approver2_b = $userId) AND approver1_date!='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00') OR
        ( (approver2 = $userId OR approver2_b = $userId) AND approver1_date='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00')
        )
        
        ORDER BY tbl_attendance_changeshift.id DESC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_UNDERTIME_APPROVALS($userId, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team)
    {
        $filter_q = "";
        if ($dept && $dept !== "undefined") {
            $filter_q .= " AND tb_empl.col_empl_dept=" . $dept;
        }
        if ($sec && $sec !== "undefined") {
            $filter_q .= " AND tb_empl.col_empl_sect=" . $sec;
        }
        if ($group && $group !== "undefined") {
            $filter_q .= " AND tb_empl.col_empl_group=" . $group;
        }
        if ($line && $line !== "undefined") {
            $filter_q .= " AND tb_empl.col_empl_line=" . $line;
        }
        if ($branch && $branch !== "undefined") {
            $filter_q .= " AND tb_empl.col_empl_branch=" . $branch;
        }
        if ($division && $division !== "undefined") {
            $filter_q .= " AND tb_empl.col_empl_divi=" . $division;
        }
        if ($clubhouse && $clubhouse !== "undefined") {
            $filter_q .= " AND tb_empl.col_empl_club=" . $clubhouse;
        }
        if ($team && $team !== "undefined") {
            $filter_q .= " AND tb_empl.col_empl_team=" . $team;
        }

        $sql = "SELECT *, tbl_au.create_date, tbl_au.empl_id as empl_id, tbl_au.id as id, 
         CONCAT_WS(
            '', 
            CONCAT(tb_empl.col_empl_cmid, '-', tb_empl.col_last_name), 
            CASE WHEN tb_empl.col_suffix IS NOT NULL AND tb_empl.col_suffix <> '' THEN CONCAT(' ',tb_empl.col_suffix) ELSE '' END,
            CASE WHEN tb_empl.col_frst_name IS NOT NULL AND tb_empl.col_frst_name <> '' THEN CONCAT(', ',tb_empl.col_frst_name) ELSE '' END, 
            CASE WHEN tb_empl.col_midl_name IS NOT NULL AND tb_empl.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb_empl.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        FROM tbl_attendance_undertime AS tbl_au
 
        JOIN tbl_employee_infos AS tb_empl ON tb_empl.id = tbl_au.empl_id
        WHERE tbl_au.status LIKE '%Pending%' " . $filter_q . " 

        AND (( (approver1 = $userId OR approver1_b = $userId) AND approver1_date='0000-00-00 00:00:00') OR 
        ( (approver2 = $userId OR approver2_b = $userId) AND approver1_date!='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00') OR
        ( (approver2 = $userId OR approver2_b = $userId) AND approver1_date='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00')
        )
        
        ORDER BY tbl_au.id DESC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function UPDATE_SHIFT_APPROVER($data, $edit_user)
    {

        $datetime           = date('Y-m-d H:i:s');
        $cmid               = $data[1];
        $empl_id            = $this->getEmployeeId($cmid);
        $prepared_by        = $this->getEmployeeId($data[3]);
        $checked_by         = $this->getEmployeeId($data[4]);
        $noted_by           = $this->getEmployeeId($data[5]);

        $sql = "SELECT * FROM tbl_approvers_shift WHERE empl_id=?";
        $query = $this->db->query($sql, array($empl_id));
        $result = $query->num_rows();

        if ($result > 0) {
            $sql_update = "UPDATE tbl_approvers_shift SET edit_date=?, prepared_by=?, checked_by=?, noted_by=? WHERE empl_id=?";
            $query_udpate = $this->db->query($sql_update, array($datetime, $prepared_by, $checked_by, $noted_by, $empl_id));
        } else {
            $sql_insert = "INSERT INTO tbl_approvers_shift (create_date, edit_date, empl_id, prepared_by, checked_by, noted_by) VALUES (?,?,?,?,?,?)";
            $query_insert = $this->db->query($sql_insert, array($datetime, $datetime, $empl_id, $prepared_by, $checked_by, $noted_by));
        }
    }

    function get_leaves_settings_by_setting($setting, $value)
    {
        $query_select = "SELECT * FROM  tbl_leaves_settings WHERE setting=?";
        $result = $this->db->query($query_select, array($setting))->row_array();
        if (!$result) {
            $query_insert = "INSERT INTO tbl_leaves_settings (setting, value) VALUES (?, ?)";
            $this->db->query($query_insert, array($setting, $value));
            $query_select_new = "SELECT * FROM tbl_leaves_settings WHERE setting=?";
            $result = $this->db->query($query_select_new, array($setting))->row_array();
        }
        return $result ? $result['value'] : null;
    }



    function GET_SHIFT_TYPE($id, $date)
    {
        $this->db->select('tb1.id,tb2.name,tb2.time_regular_start,tb2.time_regular_end');
        $this->db->from('tbl_attendance_shiftassign as tb1');
        $this->db->join('tbl_attendance_shifts as tb2', 'tb1.shift_id=tb2.id', 'left');
        $this->db->where('tb1.empl_id', $id);
        $this->db->where('tb1.date', $date);
        $query = $this->db->get();
        return $query->row();
    }

    function GET_TOTAL_REDEEMED_OFFSET($empl_id)
    {
        $sql = "SELECT SUM(duration) AS total_redeemed_offset FROM `tbl_attendance_offsets` WHERE empl_id = ? AND offset_type = 'Redeem' AND (status = 'Approved' OR status LIKE 'Pending%') ";
        $query = $this->db->query($sql, array($empl_id));
        return $query->row();
    }


    function GET_TOTAL_ACQUIRED_OFFSET($empl_id)
    {
        $sql = "SELECT SUM(duration) AS total_acquired_offset FROM `tbl_attendance_offsets_acquire` WHERE empl_id = ? AND offset_type = 'Acquire' AND status = 'Approved' ";
        $query = $this->db->query($sql, array($empl_id));
        return $query->row();
    }
} // ============== END OF class teams_model extends CI_Model
