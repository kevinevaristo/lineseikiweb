<?php
class administrators_model extends CI_Model
{

    function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'maiya_reset'";
        return $this->db->query($query)->row_array();
    }

    function AUTO_INSERT_SETTINGS($settings)
    {
        $sql_select = "SELECT * FROM tbl_system_setup WHERE setting = ?";
        $query_select = $this->db->query($sql_select, array($settings));

        if ($query_select) {
            if ($query_select->num_rows() <= 0) {
                $sql_insert = "INSERT INTO tbl_system_setup (setting, value) VALUES (?, 'd/m/Y')";
                $query_insert = $this->db->query($sql_insert, array($settings));
                if ($query_insert) {
                    return true; // Insertion successful
                } else {
                    return false; // Insertion failed
                }
            } else {
                return false; // Setting already exists
            }
        } else {
            return false; // Error in SELECT query
        }
    }

    function get_table($table, $filter, $selectColumns) {
        $query = $this->db
        ->where('is_deleted', 0)
        ->order_by('id', 'DESC');
        foreach ($selectColumns as $column) {
            if (array_key_exists('useRaw', $column)) {
                $query->select($column['selectStatement'], false);
            } else {
                $query->select($column['selectStatement']);
            }
        }
        foreach ($filter as $conditions) {
            foreach ($conditions as $key => $value) {
                $query->where($key, $value);
            }
        }
        $query = $query->get($table);
        return $query->result();
    }

    function insert_data_table($table,$input_data){
        try {
        $this->db->insert($table, $input_data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        } catch (Exception $e) {
            return false;
        }
    }

    function GET_USERS($limit, $offset, $is_active, $company, $dept, $sec, $group, $line, $branch, $division, $team){
        $filter_q = "";
        if ($company && $company !== 'null') {
            $filter_q .= " AND col_empl_company=" . $company;
        }
        if ($dept && $dept !== 'null') {
            $filter_q .= " AND col_empl_dept=" . $dept;
        }
        if ($sec && $sec !== 'null') {
            $filter_q .= " AND col_empl_sect=" . $sec;
        }
        if ($group && $group !== 'null') {
            $filter_q .= " AND col_empl_group=" . $group;
        }
        if ($line && $line !== 'null') {
            $filter_q .= " AND col_empl_line=" . $line;
        }
        if ($branch && $branch !== 'null') {
            $filter_q .= " AND col_empl_branch=" . $branch;
        }
        if ($division && $division !== 'null') {
            $filter_q .= " AND col_empl_divi=" . $division;
        }
        if ($team && $team !== 'null') {
            $filter_q .= " AND col_empl_team=" . $team;
        }

        $sql     = "SELECT * FROM tbl_employee_infos WHERE disabled=?" . $filter_q . " ORDER BY col_empl_cmid ASC LIMIT $limit OFFSET $offset ";
        $query   = $this->db->query($sql, array($is_active));
        $query->next_result();
        return $query->result();
    }

    function GET_INACTIVE_USER_COUNT()
    {
        $this->db->from('tbl_employee_infos');
        $this->db->where('disabled', 1);
        $count = $this->db->count_all_results();
        return $count;
    }

    function GET_ACTIVE_USER_COUNT()
    {
        $this->db->from('tbl_employee_infos');
        $this->db->where('disabled', 0);
        // $this->db->where('termination_date', NULL);
        $count = $this->db->count_all_results();
        return $count;
    }
    function GET_USER_ACCESS_LOGS($employee,$limit, $offset){
        $this->db->select('tb1.id, tb2.col_empl_cmid, tb1.ip_address,tb1.uri,tb1.description,tb1.create_date,device');
        $this->db->select('CONCAT(tb2.col_last_name,IF(tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> "", CONCAT(" ",tb2.col_suffix, ""), ""), ", ",
        tb2.col_frst_name, " ",IF(tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> "", CONCAT(LEFT(tb2.col_midl_name, 1), "."), "")) as employee', false);
        $this->db->from('tbl_access_logs as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.empl_id=tb2.id','left');
        if(!empty($employee)|| $employee){
            $this->db->where('empl_id',$employee);
        }
        $this->db->order_by('id','desc');
        $this->db->limit($limit, $offset);
        $query=$this->db->get();
        return $query->result();
    }
    function GET_USER_ACCESS_LOGS_COUNT($employee){
        $this->db->select('tb1.id,tb1.ip_address,tb1.uri,tb1.description,tb1.create_date');
        $this->db->select('CONCAT(tb2.col_last_name,IF(tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> "", CONCAT(" ",tb2.col_suffix, ""), ""), ", ",
        tb2.col_frst_name, " ",IF(tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> "", CONCAT(LEFT(tb2.col_midl_name, 1), "."), "")) as employee', false);
        $this->db->from('tbl_access_logs as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.empl_id=tb2.id','left');
        if(!empty($employee)|| $employee){
            $this->db->where('empl_id',$employee);
        }
        $query=$this->db->get();
        return $query->num_rows();
    }
    function GET_SEARCH_USER_COUNT($search, $is_active)
    {
        $sql    = "SELECT COUNT(*) as count FROM tbl_employee_infos
                   Where tbl_employee_infos.disabled=? AND (  col_last_name Like '%$search%'
                   OR col_midl_name LIKE '%$search%'
                   OR col_midl_name LIKE '%$search%'
                   OR col_empl_cmid LIKE '%$search%'
                   OR exists (SELECT name from tbl_std_positions
                   WHERE tbl_std_positions.id=tbl_employee_infos.col_empl_posi AND name like '%$search%')
                   OR exists 
                   (SELECT user_access FROM tbl_system_useraccess 	
                   WHERE tbl_system_useraccess.id=tbl_employee_infos.col_user_access AND user_access like '%$search%'))
                   ";
        $query = $this->db->query($sql, array($is_active));
        $row   = $query->row();
        return $row->count;
    }

    function GET_SEARCHED_USERS($limit, $offset, $search, $is_active)
    {
        $sql   =   "SELECT * FROM tbl_employee_infos
                    Where tbl_employee_infos.disabled=? AND ( col_last_name Like '%$search%'
                    OR col_midl_name LIKE '%$search%'
                    OR col_frst_name LIKE '%$search%'
                    OR col_empl_cmid LIKE '%$search%'
                    OR exists (SELECT name from tbl_std_positions
                    WHERE tbl_std_positions.id=tbl_employee_infos.col_empl_posi AND name like '%$search%')
                    OR exists 
                    (SELECT user_access FROM tbl_system_useraccess 	
                    WHERE tbl_system_useraccess.id=tbl_employee_infos.col_user_access AND user_access like '%$search%'))
                     ORDER BY col_empl_cmid ASC LIMIT $limit OFFSET $offset
                    ";
        $query = $this->db->query($sql, array($is_active));
        $query->next_result();
        return $query->result();
    }

    function GET_SEARCH_IS_ACTIVE_COUNT($search, $is_active)
    {
        $sql   =   "SELECT * FROM tbl_employee_infos
                    Where tbl_employee_infos.disabled=? AND ( col_last_name Like '%$search%'
                    OR col_midl_name LIKE '%$search%'
                    OR col_frst_name LIKE '%$search%'
                    OR col_empl_cmid LIKE '%$search%'
                    OR exists (SELECT name from tbl_std_positions
                    WHERE tbl_std_positions.id=tbl_employee_infos.col_empl_posi AND name like '%$search%')
                    OR exists 
                    (SELECT user_access FROM tbl_system_useraccess 	
                    WHERE tbl_system_useraccess.id=tbl_employee_infos.col_user_access AND user_access like '%$search%'))
                     ORDER BY col_empl_cmid ASC
                    ";
        $query = $this->db->query($sql, array($is_active));
        return $query->num_rows();
    }

    function GET_POSITIONS()
    {
        $sql   = "SELECT id,name FROM tbl_std_positions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_USER_ACCESS()
    {
        $sql   = "SELECT id,user_access FROM tbl_system_useraccess";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_USER_COUNT($is_active)
    {
        $this->db->from('tbl_employee_infos');
        $this->db->where('disabled', $is_active);
        $count = $this->db->count_all_results();
        return $count;
    }

    function GET_ACTIVITY_LOGS()
    {
        $sql   = "SELECT * FROM tbl_activity_logs  ORDER BY create_date DESC";
        $query = $this->db->query($sql, array());
        return $query->result_array();
    }

    function GET_EMPLOYEE_IDS()
    {
        $sql   = "SELECT id,col_empl_cmid FROM tbl_employee_infos";
        $query = $this->db->query($sql, array());
        return $query->result_array();
    }

    function SET_REMOTE_ATTENDANCE_EMPLOYEE($id, $is_active)
    {
        $sql   = "UPDATE tbl_employee_infos SET remote_att=? WHERE id=?";
        $query = $this->db->query($sql, array($is_active, $id));
        return null;
    }

    function SET_USER_ACCESS_EMPLOYEE($id, $is_active)
    {
        $sql   = "UPDATE tbl_employee_infos SET col_user_access=? WHERE id=?";
        $query = $this->db->query($sql, array($is_active, $id));
        return null;
    }

    function CHECK_ACTIVE_LIMIT($active)
    {
        $sqlLimit = "SELECT value FROM tbl_system_setup WHERE setting='max_active_user'";
        $limit    = $this->db->query($sqlLimit);
        if (!$limit) {
            return array('messageError' => 'Getting limit Error');
        }
        $finalLimit = $limit->row()->value;
        $finalActiveTotal = $active;
        if ($finalLimit < $finalActiveTotal) {
            $difference = $finalActiveTotal - $finalLimit;
            $reduce = $difference;
            return array('messageError' => "Change was not saved. Max user limit. Reduce " . $reduce . " Active ");
        }
        return null;
    }

    function SET_ACTIVATION_EMPLOYEE($id, $is_active)
    {
        if (!$is_active) {
            $sqlLimit = "SELECT value FROM tbl_system_setup WHERE setting='max_active_user'";
            $limit = $this->db->query($sqlLimit);
            if (!$limit) {
                return array('messageError' => 'Getting limit Error');
            }
            if (!$limit->row()) {
                return array('messageError' => 'Getting limit Error');
            }
            $sqlActiveTotal = "SELECT COUNT(*) as count FROM tbl_employee_infos WHERE disabled=0";
            $activeTotal = $this->db->query($sqlActiveTotal);
            if ($activeTotal && $activeTotal->num_rows() < 1 && $activeTotal->row()->count < 1) {
                return array('messageError' => 'Maximum Active Count is Zero and below');
            }
            $finalLimit = $limit->row()->value;
            $finalActiveTotal = $activeTotal->row()->count;
            if ($finalLimit <= $finalActiveTotal) {
                return array('messageError' => "Activation failed as limit already reached. Limit: " . $finalLimit . ". Active Users: " . $finalActiveTotal . ".");
            }

            $sql = "UPDATE tbl_employee_infos SET disabled=? WHERE id=?";
            $query = $this->db->query($sql, array($is_active, $id));
            return null;
        } else {
            $sql = "UPDATE tbl_employee_infos SET disabled=? WHERE id=?";
            $query = $this->db->query($sql, array($is_active, $id));
            return null;
        }
    }

    function get_module_access()
    {
        // $sql = "SELECT setting,value FROM tbl_system_setup where id>=7";
        // $res = $this->db->query($sql)->result_array();
        // $new_data = array();
        // foreach ($res as $res_data) {
        //     $new_data[$res_data["setting"]] = $res_data["value"];
        // }
        // return $nw_data;
        $modules_id=array(7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,58,63,66,87,91,152,153,158);
        $this->db->select('id,setting,value');
        $this->db->where_in('id',$modules_id);
        $query=$this->db->get('tbl_system_setup');
        $results= $query->result_array();
        $new_data=array();
        foreach ($results as $res_data) {
            if($res_data["value"]!=0){
                $new_data[$res_data["setting"]] = explode(',',$res_data["value"]);
            }
        }
        return $new_data;
    }

    function get_all_user_access()
    {
        $sql = "SELECT * FROM tbl_system_useraccess";
        return $this->db->query($sql)->result_array();
    }

    function get_home_announcement()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_announcement'";
        return $this->db->query($query)->row_array();
    }

    function get_home_celebration()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_celebration'";
        return $this->db->query($query)->row_array();
    }

    function get_home_date()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_date'";
        return $this->db->query($query)->row_array();
    }

    function get_home_leave()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_leave_info'";
        return $this->db->query($query)->row_array();
    }

    function get_home_whos_out()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_whos_out'";
        return $this->db->query($query)->row_array();
    }

    function get_home_start_guide()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_start_guide'";
        return $this->db->query($query)->row_array();
    }

    function get_home_new_member()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_new_member'";
        return $this->db->query($query)->row_array();
    }

    function GET_HOME_TIMERECORD()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_my_time_record'";
        return $this->db->query($query)->row_array();
    }

    function GET_HOME_ATTENDANCE_SUMMARY()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_attendance_summary'";
        return $this->db->query($query)->row_array();
    }

    function GET_HOME_REQUEST()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_requests'";
        return $this->db->query($query)->row_array();
    }

    function GET_HOME_APPROVAL()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_approval'";
        return $this->db->query($query)->row_array();
    }

    function GET_HOME_UPCOMING_HOLIDAYS()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_upcoming_holidays'";
        return $this->db->query($query)->row_array();
    }

    function get_system_setup_setting($setting)
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = ?";
        return $this->db->query($query, array($setting))->row_array();
    }

    function GET_COMP_STRUCTURE()
    {
        $sql   = "SELECT * FROM tbl_system_setup";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_SYSTEM_IP_ADDRESS()
    {
        $sql    = "SELECT value FROM tbl_system_setup WHERE setting = 'ip_address'";
        $query  = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["value"];
    }

    function add_user_access($user, $data, $modules)
    {
        $date = date('Y-m-d H:i:s');
        if (empty($user)) {
            return;
        }
        $sql = "INSERT INTO tbl_system_useraccess (create_date,edit_date,user_access,user_page,user_modules) VALUES (?,?,?,?,?)";
        $query = $this->db->query($sql, array($date, $date, $user, $data, $modules));
        return $this->db->insert_id();
    }

    function GET_USER_ACCESS_BY_ID($id)
    {
        $sql = "SELECT user_page FROM tbl_system_useraccess WHERE id=?";
        return $this->db->query($sql, array($id))->result_array();
    }

    function update_user_access($id, $data, $modules)
    {
        $sql = "UPDATE tbl_system_useraccess SET user_page=?,user_modules=? WHERE id=?";
        return $this->db->query($sql, array($data, $modules, $id));
    }

    function update_user_access_data($id, $name, $data, $modules)
    {
        $date = date('Y-m-d H:i:s');
        $sql  = "UPDATE tbl_system_useraccess SET edit_date=?, user_access=?, user_page=?,user_modules=? WHERE id=?";
        return $this->db->query($sql, array($date, $name, $data, $modules, $id));
    }

    function get_employee_list(){
        $sql = "SELECT id,
        CONCAT_WS('', 
        CONCAT(col_empl_cmid, '-', col_last_name), 
        CASE WHEN col_suffix IS NOT NULL AND col_suffix <> '' THEN CONCAT(' ',col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name <> '' THEN CONCAT(', ',col_frst_name) ELSE '' END, 
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name <> '' THEN CONCAT(' ',LEFT(col_midl_name,1), '.') ELSE '' END)
        as nameWithCMIDList
        FROM tbl_employee_infos WHERE disabled=0 AND (termination_date is null OR termination_date='0000-00-00')  ORDER BY col_empl_cmid +0 ASC ";

        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function mod_reset_user_password($empl_id, $reset_pass)
    {
        $salt = password_hash(uniqid(), PASSWORD_BCRYPT);
        $password = ucfirst($reset_pass);
        $encrypted_password = password_hash($password . $salt, PASSWORD_BCRYPT);

        $sql = "UPDATE tbl_employee_infos SET col_user_pass=?,col_salt_key=?,password_attempt=0, real_pass=0 WHERE id=?";
        $query = $this->db->query($sql, array($encrypted_password, $salt, $empl_id));
        if ($query) {
            return true;
        }
        return false;
    }
    function UPDATE_HOME_SETTINGS($settings){
        try {
            foreach ($settings as $key => $value) {
                $updateData = array('value' => $value);
                if ($key === 'payroll_rankandfile' || $key === 'payroll_managers') {
                    $value = implode(",", $value);
                }
                $this->db->set('value',$value);
                $this->db->where('setting', $key); 
                $this->db->update('tbl_system_setup');
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    function mod_updt_user_access($user_access, $remote_attendance, $disable, $empl_id)
    {
        $sql   = "UPDATE tbl_employee_infos SET disabled=?, col_user_access=?, remote_att=? WHERE id=?";
        $query = $this->db->query($sql, array($disable, $user_access, $remote_attendance, $empl_id));
        return 'User Access Updated!';
    }

    function MOD_UPDATE_STATUS($stat, $id)
    {
        $sql   = "UPDATE tbl_system_setup SET value=? WHERE id=?";
        $query = $this->db->query($sql, array($stat, $id));
    }

    function MOD_UPDATE_IP_ADDRESS($val, $setting)
    {
        $sql   = "UPDATE tbl_system_setup SET value=? WHERE setting=?";
        $query = $this->db->query($sql, array($val, $setting));
    }

    function mod_insert_ip($create_date, $ip_add, $remarks, $status)
    {
        $sql   = "INSERT INTO tbl_system_whitelist (create_date, edit_date, ip_address, remarks, status) VALUES (?,?,?,?,?)";
        $query = $this->db->query($sql, array($create_date, $create_date, $ip_add, $remarks, $status));
        return;
    }

    function get_ip_address($offset, $row)
    {
        $sql   = "SELECT * FROM tbl_system_whitelist WHERE is_deleted=0 ORDER BY id DESC LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function get_count_ip_address($offset, $row)
    {
        $sql   = "SELECT * FROM tbl_system_whitelist WHERE is_deleted=0 ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function get_search_ip_address($search)
    {
        $sql   = "SELECT * FROM tbl_system_whitelist WHERE is_deleted=0 
        AND (tbl_system_whitelist.ip_address LIKE '%$search%'
        OR tbl_system_whitelist.remarks LIKE '%$search%')
        ORDER BY id ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function mod_delete_ip_address($id)
    {
        $sql   = "UPDATE tbl_system_whitelist SET is_deleted=1 WHERE id=?";
        $query = $this->db->query($sql, array($id));
    }

    function get_system_setup_by_setting2($setting, $value) {
        $query_select = "SELECT * FROM tbl_system_setup WHERE setting=?";
        $result = $this->db->query($query_select, array($setting))->row_array();
        if (!$result) {
            $query_insert = "INSERT INTO tbl_system_setup (setting, value) VALUES (?, ?)";
            $this->db->query($query_insert, array($setting,$value));
            $query_select_new = "SELECT * FROM tbl_system_setup WHERE setting=?";
            $result = $this->db->query($query_select_new, array($setting))->row_array();
        }
        return $result ? $result['value'] : null;
    }

    function get_system_setup_by_setting($setting)
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting=?";
        return $this->db->query($query, array($setting))->row_array();
    }

    function get_company_name()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'CompanyName'";
        return $this->db->query($query)->row_array();
    }
    function GET_SETTING_ID()
    {
        $sql = "SELECT id FROM tbl_system_setup WHERE setting = 'date_format';";
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->id;
    }
    function get_date_format()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'date_format'";
        return $this->db->query($query)->row_array();
    }

    function get_navbar()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'navbarLogo'";
        return $this->db->query($query)->row_array();
    }



    function get_header()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'headerLogo'";
        return $this->db->query($query)->row_array();
    }

    function get_header_content()
    {
        $query = "SELECT value FROM tbl_system_setup WHERE setting = 'headerName'";
        return $this->db->query($query)->row_array();
    }

    function update_general_setting($data)
    {
        foreach ($data as $id => $newdata) {
            $sql   = "UPDATE tbl_system_setup SET value='" . $newdata . "' WHERE id= '" . $id . "'";
            $query = $this->db->query($sql);
        }
    }

    function update_nav_logo($upload_img, $id)
    {
        $sql   = "UPDATE tbl_system_setup SET value=? WHERE id=?";
        $query = $this->db->query($sql, array($upload_img, $id));
    }

    function update_login_logo($upload_img, $id)
    {
        $sql   = "UPDATE tbl_system_setup SET value=? WHERE id=?";
        $query = $this->db->query($sql, array($upload_img, $id));
    }

    function get_old_logo($id)
    {
        $sql   = "SELECT value FROM tbl_system_setup WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $row   = $query->row();
        return $row->value;
    }

    function GET_SYSTEM_SETTING_DATA($setting)
    {
        $sql   = "SELECT id, value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query = $this->db->query($sql);
        return $query->row();
    }

    function GET_SYSTEM_SETTING($setting)
    {
        $sql    = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
    }

    function GET_BRANCHES()
    {
        $sql   = "SELECT id,name FROM tbl_std_branches";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_DEPARTMENTS()
    {
        $sql   = "SELECT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_COMPANY()
    {
        $sql   = "SELECT id,name FROM tbl_std_companies";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_DIVISIONS()
    {
        $sql   = "SELECT id,name FROM tbl_std_divisions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_SECTIONS()
    {
        $sql   = "SELECT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_GROUPS()
    {
        $sql   = "SELECT id,name FROM tbl_std_groups";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_LINES()
    {
        $sql   = "SELECT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_TEAMS()
    {
        $sql   = "SELECT id,name FROM tbl_std_teams";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_POSITION()
    {
        $sql   = "SELECT id,name FROM tbl_std_positions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEE_DATA()
    {
        $sql = "SELECT  id, col_empl_cmid, 
            CONCAT_WS('',COALESCE(col_last_name, ''), 
            CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
            CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
            CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
            ) AS fullname
         , col_empl_posi, col_user_access, remote_att, disabled
        FROM tbl_employee_infos ORDER BY id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function update_data($data)
    {
        $C_POSITIONS                = $this->GET_POSITION();
        $USER_ACCESS                = $this->GET_USER_ACCESS();

        $id                         = $data[0];
        $user_access                = $this->convert_name2id($USER_ACCESS, $data[4]);
        $remote_attendance          = ($data[5] == 'Enabled') ? '1' : '0';
        $disabled                   = ($data[6] == 'Active') ? '0' : '1';

        $sql = " UPDATE tbl_employee_infos SET disabled=?, remote_att=?, col_user_access=? WHERE id=?";
        $this->db->query($sql, array($disabled, $remote_attendance, $user_access, $id));
    }

    function convert_name2id($array, $pos)
    {
        $id = "";
        $posLower = strtolower($pos);
        foreach ($array as $e) {
            $nameLower = strtolower($e->user_access);
            if ($nameLower == $posLower) {
                $id = $e->id;
                return $id;
            }
        }
        return 0;
    }

    function UPDATE_SYSTEM_SETUP($settings){

        try {
            foreach ($settings as $key => $value) {
                $this->db->set('value',$value);
                $this->db->where('setting', $key); 
                $this->db->update('tbl_system_setup');
            }
            return true; 
        } catch (Exception $e) {
            return false;

        }

    }

}
