<?php
class attendance_model extends CI_Model
{
    // function get_settings_table($table,$offset,$row,$tab,$tab_filter,$view_type){
    //     if($tab == 'All'){
    //         $query =  $this->db
    //         ->where('is_deleted', 0)
    //         ->order_by('id', 'DESC');
    //         if ($table == 'tbl_std_holidays') {
    //             $query->select('*, DATE_FORMAT(col_holi_date, "%d/%m/%Y") as col_holi_date', false);
    //         }
    //         // $query = $query->get($table, $row, $offset);
    //         $query = $query->get($table);
    //         return $query->result();
    //     }
    //     else{
    //         $query =  $this->db
    //         ->select('*, DATE_FORMAT(col_holi_date, "%d/%m/%Y") as col_holi_date', false)
    //         ->where('is_deleted', 0)
    //         ->where($tab_filter, $tab)
    //         ->order_by('id', 'DESC')
    //         // ->get($table,$row,$offset);
    //         ->get($table);
    //         return $query->result();
    //     }
    // }
    function get_settings_table($table, $filter, $selectColumns)
    {
        $query = $this->db
            ->where('is_deleted', 0)
            ->order_by('id', 'DESC');
        foreach ($selectColumns as $column) {
            // if ($column['useRaw']) {
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

    function get_holidays($year){
        $sql = "SELECT id, DATE_FORMAT(col_holi_date, '%d/%m/%Y') as col_holi_date, col_holi_type, name, status FROM tbl_std_holidays WHERE year=?";
        $query = $this->db->query($sql, array($year));
        $query->next_result();
        return $query->result();
    }

    function get_settings_table2($table, $filter, $selectColumns, $sortColumn, $sortOrder)
    {
        $query = $this->db
            ->where('is_deleted', 0);
        $query->order_by('MONTH(' . $sortColumn . ')', 'ASC');
        $query->order_by('DAY(' . $sortColumn . ')', 'ASC');

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

    // function get_settings_table2($table, $filter, $selectColumns,$sortColumn,$sortOrder) {
    //     $query = $this->db
    //     ->where('is_deleted', 0)
    //     ->order_by($sortColumn, $sortOrder);
    //     foreach ($selectColumns as $column) {
    //         // if ($column['useRaw']) {
    //         if (array_key_exists('useRaw', $column)) {
    //             $query->select($column['selectStatement'], false);
    //         } else {
    //             $query->select($column['selectStatement']);
    //         }
    //     }
    //     foreach ($filter as $conditions) {
    //         foreach ($conditions as $key => $value) {
    //             $query->where($key, $value);
    //         }
    //     }
    //     $query = $query->get($table);
    //     return $query->result();
    // }

    function get_settings_table_pagination($table, $offset, $row, $tab, $tab_filter, $view_type, $selectColumns)
    {
        if ($tab == 'All') {
            $query = $this->db
                ->where('is_deleted', 0)
                ->order_by('id', 'DESC');
            foreach ($selectColumns as $column) {
                if (!$column['useRaw']) {
                    $query->select($column['selectStatement'], false);
                } else {
                    $query->select($column['selectStatement']);
                }
            }
            // $query = $query->get($table, $row, $offset);
            $query = $query->get($table);
            return $query->result();
        } else {
            $query = $this->db
                ->where('is_deleted', 0)
                ->where($tab_filter, $tab)
                ->order_by('id', 'DESC');
            foreach ($selectColumns as $column) {
                if (!$column['useRaw']) {
                    $query->select($column['selectStatement'], false);
                } else {
                    $query->select($column['selectStatement']);
                }
            }
            // $query = $query->get($table, $row, $offset);
            $query = $query->get($table);
            return $query->result();
        }
    }

    function get_settings_table_count($table, $filter, $selectColumns)
    {
        $query = $this->db
            ->where('is_deleted', 0);
        foreach ($selectColumns as $column) {
            if (!$column['useRaw']) {
                $query->select($column['selectStatement'], false);
            } else {
                $query->select($column['selectStatement']);
            }
        }
        foreach ($filter as $key => $value) {
            $query->where($key, $value);
        }
        $query->count_all_results($table);
        return $query;
        // if($tab == 'All'){
        // }
        // else{
        //     $query = $this->db
        //     ->where('is_deleted', 0)
        //     ->where($tab_filter, $tab)
        //     ->count_all_results($table);
        //     return $query;
        // }
    }

    function get_settings_table_search($tab, $tab_filter, $table, $search, $row, $offset, $view_type)
    {
        $sql = "SELECT * FROM $table
        WHERE $tab_filter=? AND (";
        $fields = $this->db->list_fields($table);
        foreach ($fields as $field) {
            $sql .= "$table.$field LIKE '%$search%'";
            if ($field !== end($fields)) {
                $sql .= " OR ";
            }
        }
        $sql .= ") ORDER BY id DESC LIMIT $offset,$row";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }

    function get_display_count($table, $column, $value, $view_type)
    {
        if ($value == 'All') {
            $query =  $this->db
                ->where('is_deleted', 0)
                ->count_all_results($table);
            return $query;
        } else {
            $query =  $this->db
                ->where('is_deleted', 0)
                ->where($column, $value)
                ->count_all_results($table);
            return $query;
        }
    }
    function get_system_setup_by_setting2($setting, $value)
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
    function get_system_setup_by_setting($setting)
    {
        $is_exist = $this->db->select('*')->where('setting', $setting)->get('tbl_system_setup')->row_array();
        if ($is_exist) {
            return $is_exist;
        } else {
            $this->db->insert('tbl_system_setup', array('setting' => $setting, 'value' => 0));
            $insert_id = $this->db->insert_id();
            return array('id' => $insert_id, 'setting' => $setting, 'value' => 0);
        }
        // $query = "SELECT * FROM tbl_system_setup WHERE setting=?";
        // return $this->db->query($query, array($setting))->row_array();
    }
    function UPDATE_HOME_SETTINGS($settings)
    {
        try {
            foreach ($settings as $key => $value) {
                // $updateData = array('value' => $value);
                // if ($key === 'payroll_rankandfile' || $key === 'payroll_managers') {
                //     $value = implode(",", $value);
                // }
                $this->db->set('value', $value);
                $this->db->where('setting', $key);
                $this->db->update('tbl_system_setup');
                // $query = $this->db->last_query();
                // return $query;
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // function UPDATE_OFFSET_RESET($data){
    //     foreach($data as $key => $value){
    //         $this->db->where('setting', $key);
    //         $query = $this->db->get('tbl_offset_balance_reset');
    //         if($query->num_rows() > 0) {
    //             // Update the record if it exists
    //             $this->db->set('reset_date', $value);
    //             $this->db->where('setting', $key);
    //             $this->db->update('tbl_offset_balance_reset');
    //         } else {
    //             // Insert the new record if it doesn't exist
    //             $this->db->insert('tbl_offset_balance_reset', [
    //                 'setting' => $key,
    //                 'reset_date' => $value
    //             ]);
    //         }
    //     }
    // }

    // funCtion GET_OFFSET_RESET($setting, $reset_date){
    //     $sql = "SELECT * FROM tbl_offset_balance_reset WHERE setting=?";
    //     $result = $this->db->query($sql, array($setting))->row_array();
    //     if(!$result){
    //         $sql_insert = "INSERT INTO tbl_offset_balance_reset (setting, reset_date) VALUES (?,?)";
    //         $this->db->query($sql, array($setting));
    //         $query_select_new = "SELECT * FROM tbl_offset_balance_reset WHERE setting=?";
    //         $result = $this->db->query($query_select_new, array($setting))->row_array();
    //     }
    //      return $result ? $result['reset_date'] : null;
    // }

    function GET_ABSENT_LWOP_AWOL($setting)
    {
        $sql = "SELECT value FROM tbl_system_setup WHERE setting=?";
        $query = $this->db->query($sql, array($setting));
        $result = $query->row();
        if ($result->value) {
            return $result->value;
        } else {
            return null;
        }
    }



    function GET_ATTENDANCES($employee, $period)
    {
        $procedure = "CALL GetAttendance(" . $employee . ", " . $period . ");";

        $query = $this->db->query($procedure);
        $result = $query->result();
        // Free the stored procedure result set
        $query->next_result();
        $query->free_result();
        return $result;
    }

    function UPDATE_ABSENT_SETTINGS($settings, $value)
    {
        $sql = "SELECT * FROM tbl_system_setup WHERE setting=?";
        $query = $this->db->query($sql, array($settings));
        $result = $query->num_rows();

        if ($result > 0) {
            $sql_update = "UPDATE tbl_system_setup SET value=? WHERE setting=?";
            $query_update = $this->db->query($sql_update, array($value, $settings));
            if ($query_update) {
                return true;
            } else {
                return false;
            }
        } else {
            $sql_insert = "INSERT INTO tbl_system_setup (setting, value) VALUES(?,?)";
            $query_insert = $this->db->query($sql_insert, array($settings, $value));
            if ($query_insert) {
                return true;
            } else {
                return false;
            }
        }
    }


    // function update_setting_tables($table, $data, $edit_user) {
    //     $date = date('Y-m-d H:i:s');
    //     $id = !empty($data['id']) ? $data['id'] : 0;
    //     $columns = array();
    //     $values = array();
    //     $params = array();
    //     foreach ($data as $key => $value) {
    //         if ($key !== 'id') {
    //             $columns[] = $key . '= ?';
    //             $values[] = $value;
    //             $params[] = '?';
    //         }
    //     }
    //     $columns = implode(', ', $columns);
    //     $params = implode(', ', $params);
    //     if ($id == 0) {
    //         $sql = "INSERT INTO $table (create_date, edit_date, edit_user, $columns) VALUES (?, ?, ?, $params)";
    //         $query = $this->db->query($sql, array_merge([$date, $date, $edit_user], $values));
    //         if ($query) {
    //             return "inserted";
    //         } else {
    //             return "failedUpdate";
    //         }
    //     } else {
    //         $sql = "UPDATE $table SET edit_date=?, edit_user=?, $columns WHERE id=?";
    //         $values[] = $id;
    //         $query = $this->db->query($sql, array_merge([$date, $edit_user], $values));
    //         if ($query) {
    //             return "updated";
    //         } else {
    //             return "failedInsert";
    //         }
    //     }
    // }
    function update_setting_tables($table, $data, $edit_user)
    {
        $date = date('Y-m-d H:i:s');
        $id = !empty($data['id']) ? $data['id'] : 0;
        $columns = array();
        $values = array();
        $params = array();
        if ($id == 0) {
            foreach ($data as $key => $value) {
                if ($key !== 'id') {
                    $columns[] = $key;
                    $values[] = $value;
                    $params[] = '?';
                }
            }
            $columns = implode(', ', $columns);
            $params = implode(', ', $params);
            $arrayValues = array_merge([$date, $date, $edit_user], $values);
            // return array('columns'=>$columns,'arrayValues'=>$arrayValues);
            $sql = "INSERT INTO $table (create_date, edit_date, edit_user, $columns) VALUES (?, ?, ?, $params)";
            $query = $this->db->query($sql, $arrayValues);
            if ($query) {
                return "inserted";
            } else {
                return "failedInsert";
            }
        } else {
            foreach ($data as $key => $value) {
                if ($key !== 'id') {
                    $columns[] = $key . '= ?';
                    $values[] = $value;
                    $params[] = '?';
                }
            }
            $columns = implode(', ', $columns);
            $params = implode(', ', $params);
            $sql = "UPDATE $table SET edit_date=?, edit_user=?, $columns WHERE id=?";
            $values[] = $id;
            $query = $this->db->query($sql, array_merge([$date, $edit_user], $values));
            if ($query) {
                return "updated";
            } else {
                return "failedUpdate";
            }
        }
    }
    function update_setting_holidays($table, $data, $edit_user)
    {
        $date = date('Y-m-d H:i:s');
        $id = !empty($data['id']) ? $data['id'] : 0;

        // Check if the date is already in the table (for duplicates)
        $check_duplicate_sql = "SELECT id FROM $table WHERE col_holi_date = ? AND id != ?";
        $duplicate_check_query = $this->db->query($check_duplicate_sql, array($data['col_holi_date'], $id));

        if ($duplicate_check_query->num_rows() > 0) {
            return "duplicateDate"; // Return an error if the date is duplicate
        }

        $columns = array();
        $values = array();
        $params = array();

        if ($id == 0) {
            foreach ($data as $key => $value) {
                if ($key !== 'id') {
                    $columns[] = $key;
                    $values[] = $value;
                    $params[] = '?';
                }
            }
            $columns = implode(', ', $columns);
            $params = implode(', ', $params);
            $arrayValues = array_merge([$date, $date, $edit_user], $values);
            $sql = "INSERT INTO $table (create_date, edit_date, edit_user, $columns) VALUES (?, ?, ?, $params)";
            $query = $this->db->query($sql, $arrayValues);

            if ($query) {
                return "inserted";
            } else {
                return "failedInsert";
            }
        } else {
            foreach ($data as $key => $value) {
                if ($key !== 'id') {
                    $columns[] = $key . '= ?';
                    $values[] = $value;
                    $params[] = '?';
                }
            }
            $columns = implode(', ', $columns);
            $params = implode(', ', $params);
            $sql = "UPDATE $table SET edit_date=?, edit_user=?, $columns WHERE id=?";
            $values[] = $id;
            $query = $this->db->query($sql, array_merge([$date, $edit_user], $values));
            if ($query) {
                return "updated";
            } else {
                return "failedUpdate";
            }
        }
    }
    function FILTER_ATTENDANCE_RECORDS($dept, $sect, $group, $division, $branch, $team)
    {

        $where_query        = "WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0";
        $query_dept         = empty($this->input->get('dept')) || $this->input->get('dept') == 'all' || $this->input->get('dept') == 'undefined' ? $where_query : $where_query .= ' AND col_empl_dept=?';
        $query_comp         = empty($this->input->get('company')) || $this->input->get('company') == 'all' || $this->input->get('company') == 'undefined' ? $where_query : $where_query .= ' AND col_empl_company=?';
        $query_section      = empty($this->input->get('section')) || $this->input->get('section') == 'all' || $this->input->get('section') == 'undefined' ? $where_query : $where_query .= ' AND col_empl_sect=?';
        $query_group        = empty($this->input->get('group')) || $this->input->get('group') == 'all' || $this->input->get('group') == 'undefined' ? $where_query : $where_query .= ' AND col_empl_group=?';
        $query_division     = empty($this->input->get('division')) || $this->input->get('division') == 'all' || $this->input->get('division') == 'undefined' ? $where_query : $where_query .= ' AND col_empl_divi=?';
        $query_branch       = empty($this->input->get('branch')) || $this->input->get('branch') == 'all' || $this->input->get('branch') == 'undefined' ? $where_query : $where_query .= ' AND col_empl_branch=?';
        $query_team         = empty($this->input->get('team')) || $this->input->get('team') == 'all' || $this->input->get('team') == 'undefined' ? $where_query : $where_query .= ' AND col_empl_team=?';
        $sql = "SELECT id,col_suffix,col_empl_posi,col_empl_group,col_empl_cmid,col_last_name,col_frst_name,col_midl_name FROM tbl_employee_infos $where_query ORDER BY col_empl_cmid ASC ";
        $arr_val = array();
        if (!empty($dept) && $dept != 'all') {
            $arr_val[] = $dept;
        }
        if (!empty($comp) && $comp != 'all') {
            $arr_val[] = $comp;
        }
        if (!empty($sect) && $sect != 'all') {
            $arr_val[] = $sect;
        }
        if (!empty($group) && $group != 'all') {
            $arr_val[] = $group;
        }
        if (!empty($division) && $division != 'all') {
            $arr_val[] = $division;
        }
        if (!empty($branch) && $branch != 'all') {
            $arr_val[] = $branch;
        }
        if (!empty($team) && $team != 'all') {
            $arr_val[] = $team;
        }
        // return array(
        //     'sql'=> $sql,
        //     'arr'=> $arr_val,
        //     'where_query'=> $where_query
        // );
        $query = $this->db->query($sql, $arr_val);
        $query->next_result();
        return $query->result();
    }

    function EMPLOYEE_LIST_ATTENDANCE()
    {
        $sql = "SELECT id,CONCAT(col_empl_cmid,'-',col_last_name,',',col_frst_name,' ',col_midl_name) as 'name' FROM tbl_employee_infos 
        WHERE disabled=0 /*(termination_date IS NULL || termination_date = '0000-00-00' )*/
        ORDER BY col_empl_cmid ASC ";

        $query = $this->db->query($sql);
        return $query->result();
    }

    function EMPLOYEE_LIST_ATTENDANCE_SUMMARY()
    {
        $sql = "SELECT tb1.id, tb1.col_empl_cmid as cmid, CONCAT(tb1.col_last_name,', ',tb1.col_frst_name,' ',LEFT(tb1.col_midl_name, 1),'.') as 'name', tb2.days FROM tbl_employee_infos AS tb1
        LEFT JOIN tbl_employee_work_days AS tb2 ON tb1.id=tb2.empl_id
        WHERE (tb1.termination_date IS NULL || tb1.termination_date = '0000-00-00' ) AND tb1.disabled=0 AND tb1.salary_rate != 0 AND tb1.salary_type != '' AND tb1.salary_type IS NOT NULL AND tb2.days IS NOT NULL
        ORDER BY tb1.col_empl_cmid ASC ";

        $query = $this->db->query($sql);
        return $query->result();
    }

    function ADD_DATA($table, $data)
    {
        return $this->db->insert($table, $data);
    }
    function GET_LIST_DATA($table)
    {
        $query = $this->db->get($table);
        return $query->result();
    }
    function UPDATE_ROW_DATA($table, $data, $column, $value)
    {
        $this->db->where($column, $value);
        return $this->db->update($table, $data);
    }
    function GET_EMPLOYEE_INFO($id)
    {
        $this->db->select('tbl_employee_infos.id as id,salary_type,col_last_name as lastname,col_frst_name as firstname,col_midl_name as middlename,
        tbl_std_groups.name as empl_group,
        tbl_std_positions.name as position,
        tbl_projects.project_name as project_name,
        tbl_std_departments.name as department');
        $this->db->from('tbl_employee_infos');
        $this->db->join('tbl_std_groups', 'tbl_employee_infos.col_empl_group=tbl_std_groups.id', 'left');
        $this->db->join('tbl_std_positions', 'tbl_employee_infos.col_empl_posi=tbl_std_positions.id', 'left');
        $this->db->join('tbl_std_departments', 'tbl_employee_infos.col_empl_dept=tbl_std_departments.id', 'left');
        $this->db->join('tbl_projects', 'tbl_employee_infos.col_project=tbl_projects.id', 'left');
        $this->db->where('tbl_employee_infos.id', $id);
        $query = $this->db->get();
        return $query->result();
    }
    function GET_EMPLOYEELIST()
    {
        $sql = "SELECT id,col_suffix,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,
        col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,
        col_empl_team,col_empl_line FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        ORDER BY col_empl_cmid ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEES_LIST()
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

    function GET_FILTERED_EMPLOYEELIST_3($offset, $row, $branch, $dept, $division, $clubhouse, $section, $group, $team, $line)
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
        if ($clubhouse  == "all") {
            $clubhouse   = "col_empl_club";
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
        $sql = "SELECT tbl_employee_infos.id,col_suffix,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi,col_empl_club, col_empl_sect,col_empl_group,col_empl_team,col_empl_line,salary_rate,salary_type, empl_cmid, empl_code FROM tbl_employee_infos 
        LEFT JOIN tbl_zkteco_code ON tbl_employee_infos.col_empl_cmid = tbl_zkteco_code.empl_cmid
        WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND col_empl_branch    = $branch
        AND col_empl_dept      = $dept
        AND col_empl_divi      = $division
        -- AND col_empl_club      = $clubhouse
        AND col_empl_sect      = $section
        AND col_empl_group     = $group
        AND col_empl_team      = $team
        AND col_empl_line      = $line
        AND disabled = '0'
        ORDER BY col_empl_cmid ASC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_SEARCHED_3($search)
    {
        $sql = "SELECT *, empl_cmid, empl_code FROM tbl_employee_infos 
        LEFT JOIN tbl_zkteco_code ON tbl_employee_infos.col_empl_cmid = tbl_zkteco_code.empl_cmid
        WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND tbl_employee_infos.id=?
        ORDER BY tbl_employee_infos.col_empl_cmid ASC";
        $query = $this->db->query($sql, array($search));
        $query->next_result();
        return $query->result();
    }
    function GET_FILTERED_EMPLOYEELIST_DATA($offset, $row, $branch, $dept, $division, $clubhouse, $section, $group, $team, $line)
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
        if ($clubhouse  == "all") {
            $clubhouse   = "col_empl_club";
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
            CONCAT_WS('',COALESCE(col_empl_cmid, ''), 
            CASE WHEN col_last_name IS NOT NULL AND col_last_name != '' THEN CONCAT('-', col_last_name) ELSE '' END,
            CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
            CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
            CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS full_name
        FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0
        AND col_empl_branch = $branch
        AND col_empl_dept   = $dept
        AND col_empl_divi   = $division
        -- AND col_empl_club   = $clubhouse
        AND col_empl_sect   = $section
        AND col_empl_group  = $group
        AND col_empl_team   = $team
        AND col_empl_line   = $line
        AND disabled = '0'
        ORDER BY col_empl_cmid ASC
        -- ORDER BY col_empl_cmid + 0 ASC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_UNDERTIME($date_from, $date_to)
    {
        $this->db->select('tb1.id,tb4.col_empl_cmid, tb1.date, tb1.time_in, tb1.time_out, tb3.time_regular_start, tb3.time_regular_end');
        $this->db->select("HOUR(TIMEDIFF(tb1.time_out,  tb3.time_regular_end))+FLOOR(MINUTE(TIMEDIFF(tb1.time_out, tb3.time_regular_end))/15)*0.25 AS duration", false);
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb4.col_last_name IS NOT NULL AND tb4.col_last_name != '' THEN CONCAT(tb4.col_last_name) ELSE '' END,  
        CASE WHEN tb4.col_suffix IS NOT NULL AND tb4.col_suffix != '' THEN CONCAT(' ', tb4.col_suffix) ELSE '' END,
        CASE WHEN tb4.col_frst_name IS NOT NULL AND tb4.col_frst_name != '' THEN CONCAT(', ', tb4.col_frst_name) ELSE '' END,
        CASE WHEN tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name != '' THEN CONCAT(' ', LEFT(tb4.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');
        $this->db->where("tb1.date between '$date_from' and '$date_to' and tb1.time_out<tb3.time_regular_end");
        // $this->db->where('tb1.time_out < tb3.time_regular_end');
        $this->db->order_by('tb4.col_empl_cmid + 0', 'ASC');
        $query = $this->db->get();
        return $query->result_object();
    }
    function GET_PAYROLL_PERIOD()
    {
        $this->db->select('id,name,date_from,date_to');
        $this->db->where('status', 'Active');
        $query = $this->db->get('tbl_payroll_period');
        return $query->result();
    }
    function GET_SPE_PAYROLL_PERIOD($id)
    {
        $this->db->select('id,name,date_from,date_to');
        $this->db->where('status', 'Active');
        $this->db->where('id', $id);
        $query = $this->db->get('tbl_payroll_period');
        return $query->row();
    }
    function GET_FILTERED_EMPLOYEELIST_2($offset, $row, $branch, $dept, $division, $clubhouse, $section, $group, $team, $line)
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
        if ($clubhouse == "all") {
            $clubhouse   = "col_empl_club";
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
        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi,col_empl_club,col_empl_sect,col_empl_group,col_empl_team,col_empl_line,salary_rate,salary_type FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND col_empl_branch  = $branch
        AND col_empl_dept    = $dept
        AND col_empl_divi    = $division
        AND col_empl_club    = $clubhouse
        AND col_empl_sect    = $section
        AND col_empl_group   = $group
        AND col_empl_team    = $team
        AND col_empl_line    = $line
        AND disabled = '0'
        ORDER BY col_empl_cmid ASC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
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

    function GET_APPROVED_UNPAID_OT($id)
    {
        $sql = "SELECT SUM(hours) as sumhours FROM tbl_overtimes WHERE payroll_paid IS NULL AND empl_id = $id";
        // $sql = "SELECT SUM(hours) as sumhours 
        //     FROM tbl_overtimes 
        //     WHERE payroll_paid IS NULL 
        //       AND empl_id = $id 
        //       AND status NOT IN ('Approved', 'Rejected', 'Cancelled', 'Withdrawed')";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->sumhours ?? 0;
    }

    // function GET_TOTAL_OT()
    // {
    //     $sql = "SELECT SUM(hours) as sumhours FROM tbl_overtimes";
    //     $query = $this->db->query($sql);
    //     $result = $query->row();
    //     return $result->sumhours;
    // }

    function GET_SEARCHED_DATA($search)
    {
        $sql = "SELECT id,col_empl_cmid, CONCAT(col_last_name, ' ', col_frst_name) AS full_name FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
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
            CONCAT_WS('',COALESCE(col_empl_cmid, ''), 
            CASE WHEN col_last_name IS NOT NULL AND col_last_name != '' THEN CONCAT('-', col_last_name) ELSE '' END,
            CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
            CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
            CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS full_name
        FROM tbl_employee_infos WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 AND id=?
        ORDER BY id ASC";
        $query = $this->db->query($sql, $search);
        $query->next_result();
        return $query->result();
    }
    function GET_SEARCHED_ALL_EMPL()
    {
        $sql = "SELECT * FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        ORDER BY col_empl_cmid ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_COUNT_EMPLOYEELIST()
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL || termination_date = '0000-00-00')  AND disabled=0";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }
    function GET_FILTERED_EMPLOYEELIST_COUNT($branch, $dept, $division, $clubhouse, $section, $group, $team, $line)
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
        if ($clubhouse  == "all") {
            $clubhouse   = "col_empl_club";
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
        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi,col_empl_club,col_empl_sect,col_empl_group,col_empl_team,col_empl_line FROM tbl_employee_infos 
        WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
         AND disabled=0
        AND col_empl_branch  = $branch
        AND col_empl_dept    = $dept
        AND col_empl_divi    = $division
        -- AND col_empl_club    = $clubhouse
        AND col_empl_sect    = $section
        AND col_empl_group   = $group
        AND col_empl_team    = $team
        AND col_empl_line    = $line
        ORDER BY col_empl_cmid
        ";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function GET_PERIOD_DATA($sched_id)
    {
        $sql = "SELECT date_from,date_to FROM tbl_payroll_period WHERE id=? AND status=?  ORDER BY id desc";
        $query = $this->db->query($sql, array($sched_id, 'active'));
        $data = $query->row_array();
        return $data;
    }
    function GET_SHIFT_ASSIGN_SPECIFIC($user_id)
    {
        $sql = "SELECT date,shift_id FROM tbl_attendance_shiftassign WHERE empl_id = ?";
        $query = $this->db->query($sql, array($user_id));
        $query->next_result();
        return $query->result();
    }
    function GET_SHIFT_DATA_DATERANGE($begin, $end)
    {
        $sql = "SELECT empl_id,date,shift_id FROM tbl_attendance_shiftassign WHERE date >= '$begin' AND date <= '$end' AND is_deleted=0";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_SHIFT_ALL_DATA()
    {
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE status='Active'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_SYSTEM_SETTING($setting)
    {
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
    }

    function GET_SPECIFIC_LEAVE_NAME($id)
    {
        $sql = "SELECT name FROM tbl_std_leavetypes WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        return $result->name;
    }
    function GET_LEAVE_NAMES()
    {
        $sql = "SELECT id,name FROM tbl_std_leavetypes";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function INSERT_ATTENDANCE_LOCK($data)
    {
        $EMPL_ID = $data["EMPL_ID"];
        $PAYROLL_SCHED = $data["PAYROLL_SCHED"];
        $SUM_PRESENT = $data["SUM_PRESENT"];
        $SUM_ABSENT = $data["SUM_ABSENT"];
        $SUM_TARDINESS = $data["SUM_TARDINESS"];
        $SUM_UNDERTIME = $data["SUM_UNDERTIME"];
        $SUM_PAID_LEAVE = $data["SUM_PAID_LEAVE"];
        $SUM_REG_HOURS = $data["SUM_REG_HOURS"];
        $SUM_REG_OT = $data["SUM_REG_OT"];
        $SUM_REG_ND = $data["SUM_REG_ND"];
        $SUM_REG_NDOT = $data["SUM_REG_NDOT"];
        $SUM_REST_HOURS = $data["SUM_REST_HOURS"];
        $SUM_REST_OT = $data["SUM_REST_OT"];
        $SUM_REST_ND = $data["SUM_REST_ND"];
        $SUM_REST_NDOT = $data["SUM_REST_NDOT"];
        $SUM_LEG_HOURS = $data["SUM_LEG_HOURS"];
        $SUM_LEG_OT = $data["SUM_LEG_OT"];
        $SUM_LEG_ND = $data["SUM_LEG_ND"];
        $SUM_LEG_NDOT = $data["SUM_LEG_NDOT"];
        $SUM_LEGREST_HOURS = $data["SUM_LEGREST_HOURS"];
        $SUM_LEGREST_OT = $data["SUM_LEGREST_OT"];
        $SUM_LEGREST_ND = $data["SUM_LEGREST_ND"];
        $SUM_LEGREST_NDOT = $data["SUM_LEGREST_NDOT"];
        $SUM_SPE_HOURS = $data["SUM_SPE_HOURS"];
        $SUM_SPE_OT = $data["SUM_SPE_OT"];
        $SUM_SPE_ND = $data["SUM_SPE_ND"];
        $SUM_SPE_NDOT = $data["SUM_SPE_NDOT"];
        $SUM_SPEREST_HOURS = $data["SUM_SPEREST_HOURS"];
        $SUM_SPEREST_OT = $data["SUM_SPEREST_OT"];
        $SUM_SPEREST_ND = $data["SUM_SPEREST_ND"];
        $SUM_SPEREST_NDOT = $data["SUM_SPEREST_NDOT"];
        $sql = "INSERT INTO tbl_attendance_records_lock (status,empl_id,period,present,absent,tardiness,undertime,paid_leave,reg_hours,reg_ot,reg_nd,reg_ndot,rest_hours,rest_ot,rest_nd,rest_ndot,leg_hours,leg_ot,leg_nd,leg_ndot,legrest_hours,legrest_ot,legrest_nd,legrest_ndot,spe_hours,spe_ot,spe_nd,spe_ndot,sperest_hours,sperest_ot,sperest_nd,sperest_ndot)
        VALUES ('0',$EMPL_ID,$PAYROLL_SCHED,$SUM_PRESENT,$SUM_ABSENT,$SUM_TARDINESS,$SUM_UNDERTIME,$SUM_PAID_LEAVE,$SUM_REG_HOURS,$SUM_REG_OT,$SUM_REG_ND,$SUM_REG_NDOT,$SUM_REST_HOURS,$SUM_REST_OT,$SUM_REST_ND,$SUM_REST_NDOT,$SUM_LEG_HOURS,$SUM_LEG_OT,$SUM_LEG_ND,$SUM_LEG_NDOT,$SUM_LEGREST_HOURS,$SUM_LEGREST_OT,$SUM_LEGREST_ND,$SUM_LEGREST_NDOT,$SUM_SPE_HOURS,$SUM_SPE_OT,$SUM_SPE_ND,$SUM_SPE_NDOT,$SUM_SPEREST_HOURS,$SUM_SPEREST_OT,$SUM_SPEREST_ND,$SUM_SPEREST_NDOT)";
        $query = $this->db->query($sql);
    }
    function UPDATE_EXEMPT_ATTENDANCE($id)
    {
        // Retrieve relevant attendance data using joins
        $this->db->select('tb3.time_regular_start, tb3.time_regular_end, tb1.time_in, tb1.time_out');
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->where('tb1.id', $id); // Assuming you want data for a specific attendance record
        $query = $this->db->get();
        $attendance = $query->row();
        if ($attendance) {
            // Update the 'time_out' field with 'time_regular_end' data
            $this->db->set('time_out', $attendance->time_regular_end);
            $this->db->where('id', $id);
            $this->db->update('tbl_attendance_records');
            return true; // Successfully updated
        } else {
            return false; // No data found for the specified ID
        }
    }
    function UPDATE_ATTENDANCE_LOCK($data)
    {
        $EMPL_ID = $data["EMPL_ID"];
        $PAYROLL_SCHED = $data["PAYROLL_SCHED"];
        $SUM_PRESENT = $data["SUM_PRESENT"];
        if ($data["SUM_ABSENT"] == "") {
            $SUM_ABSENT = 0;
        } else {
            $SUM_ABSENT = $data["SUM_ABSENT"];
        }
        if ($data["SUM_TARDINESS"] == "") {
            $SUM_TARDINESS = 0;
        } else {
            $SUM_TARDINESS = $data["SUM_TARDINESS"];
        }
        if ($data["SUM_UNDERTIME"] == "") {
            $SUM_UNDERTIME = 0;
        } else {
            $SUM_UNDERTIME = $data["SUM_UNDERTIME"];
        }
        if ($data["SUM_PAID_LEAVE"] == "") {
            $SUM_PAID_LEAVE = 0;
        } else {
            $SUM_PAID_LEAVE = $data["SUM_PAID_LEAVE"];
        }
        if ($data["SUM_REG_HOURS"] == "") {
            $SUM_REG_HOURS = 0;
        } else {
            $SUM_REG_HOURS = $data["SUM_REG_HOURS"];
        }
        if ($data["SUM_REG_OT"] == "") {
            $SUM_REG_OT = 0;
        } else {
            $SUM_REG_OT = $data["SUM_REG_OT"];
        }
        if ($data["SUM_REG_ND"] == "") {
            $SUM_REG_ND = 0;
        } else {
            $SUM_REG_ND = $data["SUM_REG_ND"];
        }
        if ($data["SUM_REG_NDOT"] == "") {
            $SUM_REG_NDOT = 0;
        } else {
            $SUM_REG_NDOT = $data["SUM_REG_NDOT"];
        }
        if ($data["SUM_REST_HOURS"] == "") {
            $SUM_REST_HOURS = 0;
        } else {
            $SUM_REST_HOURS = $data["SUM_REST_HOURS"];
        }
        if ($data["SUM_REST_OT"] == "") {
            $SUM_REST_OT = 0;
        } else {
            $SUM_REST_OT = $data["SUM_REST_OT"];
        }
        if ($data["SUM_REST_ND"] == "") {
            $SUM_REST_ND = 0;
        } else {
            $SUM_REST_ND = $data["SUM_REST_ND"];
        }
        if ($data["SUM_REST_NDOT"] == "") {
            $SUM_REST_NDOT = 0;
        } else {
            $SUM_REST_NDOT = $data["SUM_REST_NDOT"];
        }
        if ($data["SUM_LEG_HOURS"] == "") {
            $SUM_LEG_HOURS = 0;
        } else {
            $SUM_LEG_HOURS = $data["SUM_LEG_HOURS"];
        }
        if ($data["SUM_LEG_OT"] == "") {
            $SUM_LEG_OT = 0;
        } else {
            $SUM_LEG_OT = $data["SUM_LEG_OT"];
        }
        if ($data["SUM_LEG_ND"] == "") {
            $SUM_LEG_ND = 0;
        } else {
            $SUM_LEG_ND = $data["SUM_LEG_ND"];
        }
        if ($data["SUM_LEG_NDOT"] == "") {
            $SUM_LEG_NDOT = 0;
        } else {
            $SUM_LEG_NDOT = $data["SUM_LEG_NDOT"];
        }
        if ($data["SUM_LEGREST_HOURS"] == "") {
            $SUM_LEGREST_HOURS = 0;
        } else {
            $SUM_LEGREST_HOURS = $data["SUM_LEGREST_HOURS"];
        }
        if ($data["SUM_LEGREST_OT"] == "") {
            $SUM_LEGREST_OT = 0;
        } else {
            $SUM_LEGREST_OT = $data["SUM_LEGREST_OT"];
        }
        if ($data["SUM_LEGREST_ND"] == "") {
            $SUM_LEGREST_ND = 0;
        } else {
            $SUM_LEGREST_ND = $data["SUM_LEGREST_ND"];
        }
        if ($data["SUM_LEGREST_NDOT"] == "") {
            $SUM_LEGREST_NDOT = 0;
        } else {
            $SUM_LEGREST_NDOT = $data["SUM_LEGREST_NDOT"];
        }
        if ($data["SUM_SPE_HOURS"] == "") {
            $SUM_SPE_HOURS = 0;
        } else {
            $SUM_SPE_HOURS = $data["SUM_SPE_HOURS"];
        }
        if ($data["SUM_SPE_OT"] == "") {
            $SUM_SPE_OT = 0;
        } else {
            $SUM_SPE_OT = $data["SUM_SPE_OT"];
        }
        if ($data["SUM_SPE_ND"] == "") {
            $SUM_SPE_ND = 0;
        } else {
            $SUM_SPE_ND = $data["SUM_SPE_ND"];
        }
        if ($data["SUM_SPE_NDOT"] == "") {
            $SUM_SPE_NDOT = 0;
        } else {
            $SUM_SPE_NDOT = $data["SUM_SPE_NDOT"];
        }
        if ($data["SUM_SPEREST_HOURS"] == "") {
            $SUM_SPEREST_HOURS = 0;
        } else {
            $SUM_SPEREST_HOURS = $data["SUM_SPEREST_HOURS"];
        }
        if ($data["SUM_SPEREST_OT"] == "") {
            $SUM_SPEREST_OT = 0;
        } else {
            $SUM_SPEREST_OT = $data["SUM_SPEREST_OT"];
        }
        if ($data["SUM_SPEREST_ND"] == "") {
            $SUM_SPEREST_ND = 0;
        } else {
            $SUM_SPEREST_ND = $data["SUM_SPEREST_ND"];
        }
        if ($data["SUM_SPEREST_NDOT"] == "") {
            $SUM_SPEREST_NDOT = 0;
        } else {
            $SUM_SPEREST_NDOT = $data["SUM_SPEREST_NDOT"];
        }
        $sql = "UPDATE tbl_attendance_records_lock SET status = '0',present = $SUM_PRESENT,absent = $SUM_ABSENT,tardiness = $SUM_TARDINESS,undertime = $SUM_UNDERTIME,paid_leave = $SUM_PAID_LEAVE,reg_hours = $SUM_REG_HOURS,reg_ot = $SUM_REG_OT,reg_nd = $SUM_REG_ND,reg_ndot = $SUM_REG_NDOT,rest_hours = $SUM_REST_HOURS,rest_ot = $SUM_REST_OT,rest_nd = $SUM_REST_ND,rest_ndot = $SUM_REST_NDOT,leg_hours = $SUM_LEG_HOURS,leg_ot = $SUM_LEG_OT,leg_nd = $SUM_LEG_ND,leg_ndot = $SUM_LEG_NDOT,legrest_hours = $SUM_LEGREST_HOURS,legrest_ot = $SUM_LEGREST_OT,legrest_nd = $SUM_LEGREST_ND,legrest_ndot = $SUM_LEGREST_NDOT,spe_hours = $SUM_SPE_HOURS,spe_ot = $SUM_SPE_OT,spe_nd = $SUM_SPE_ND,spe_ndot = $SUM_SPE_NDOT,sperest_hours = $SUM_SPEREST_HOURS,sperest_ot = $SUM_SPEREST_OT,sperest_nd = $SUM_SPEREST_ND,sperest_ndot = $SUM_SPEREST_NDOT
        WHERE empl_id = $EMPL_ID AND period = $PAYROLL_SCHED";
        $query = $this->db->query($sql);
    }
    function GET_APPROVED_LEAVES($employee_id, $date_from, $date_to)
    {
        $sql = "SELECT * FROM tbl_leaves_assign WHERE status = 'Approved' AND empl_id = ? AND leave_date >= ? AND leave_date <= ?";
        $query = $this->db->query($sql, array($employee_id, $date_from, $date_to));
        $query->next_result();
        return $query->result();
    }
    function GET_APPROVED_OFFSET($employee_id, $date_from, $date_to)
    {
        $sql = "SELECT * FROM tbl_attendance_offsets WHERE status = 'Approved' AND empl_id = ? AND offset_date >= ? AND offset_date <= ?  AND offset_type = 'Redeem'";
        $query = $this->db->query($sql, array($employee_id, $date_from, $date_to));
        $query->next_result();
        return $query->result();
    }
    function GET_APPROVED_UNDERTIME($employee_id, $date_from, $date_to)
    {
        $sql = "SELECT date_undertime, request_time_in, request_time_out FROM tbl_attendance_undertime WHERE status = 'Approved' AND empl_id = ? AND date_undertime >= ? AND date_undertime <= ?";
        $query = $this->db->query($sql, array($employee_id, $date_from, $date_to));
        $query->next_result();
        return $query->result();
    }



    function GET_APPROVED_OT($employee_id, $date_from, $date_to)
    {
        $sql = "SELECT * FROM tbl_overtimes WHERE status = 'Approved' AND empl_id = ? AND date_ot >= ? AND date_ot <= ?";
        $query = $this->db->query($sql, array($employee_id, $date_from, $date_to));
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_APPROVED_OT($date_from, $date_to)
    {
        $sql = "SELECT empl_id, date_ot, hours FROM tbl_overtimes WHERE status = 'Approved' AND date_ot >= ? AND date_ot <= ?";
        $query = $this->db->query($sql, array($date_from, $date_to));
        $query->next_result();
        return $query->result();
    }
    function GET_SALARY_TYPE($user_id)
    {
        if (empty($user_id)) {
            return '';
        }
        $sql = "SELECT salary_type FROM tbl_employee_infos WHERE id = ?";
        $query = $this->db->query($sql, array($user_id));
        $result = $query->result_array();
        return $result[0]["salary_type"];
    }

    function GET_SALARY_RATE($user_id)
    {
        if (empty($user_id)) {
            return '';
        }
        $sql = "SELECT salary_rate FROM tbl_employee_infos WHERE id = ?";
        $query = $this->db->query($sql, array($user_id));
        $result = $query->result_array();
        return $result[0]["salary_rate"];
    }

    function GET_WORK_DAYS($user_id)
    {
        if (empty($user_id)) {
            return '';
        }
        $sql = "SELECT days FROM tbl_employee_work_days WHERE empl_id = ? ORDER BY id DESC LIMIT 1";
        $query = $this->db->query($sql, array($user_id));
        $result = $query->row_array();
        if ($result) {
            return $result["days"];
        } else {
            return '';
        }
    }


    function GET_MIN_HOURS_PRESENT()
    {
        $sql = "SELECT value AS minhours FROM tbl_system_setup WHERE setting = 'min_hours_present' ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["minhours"];
    }
    function GET_LATEUNDERTIME_DEDUCTIONTYPE()
    {
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = 'timekeeping_lateunder_deduction_perminute'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if ($result[0]["value"] == NULL || $result[0]["value"] == "") {
            return 0;
        } else {
            return 1;
        }
    }
    function GET_GRACEPERIOD()
    {
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = 'timekeeping_graceperiod'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if ($result[0]["value"] == NULL || $result[0]["value"] == "" || $result[0]["value"] == 0) {
            return 0;
        } else {
            return $result[0]["value"];
        }
    }
    function GET_IN_OUT_TYPE()
    {
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = 'in_out_count'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["value"];
    }
    function INSERT_APPROVAL_CSV($arr_data)
    {
        $sql = "INSERT INTO tbl_overtime_approvers (empl_id,approver_1a,approver_1b,approver_2a,approver_2b,approver_3a,approver_3b) 
                VALUES (?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, $arr_data);
    }
    function INSERT_CSV($arr_data)
    {
        $sql = "INSERT INTO tbl_attendance_suminac(user_id,cut_off,reg_hrs,swap,rest_day_ot,legal_w,legal_wo,spe_hol,
        reg_ot,free_lunch,excess_ot_hol,excess_ot_spe,excess_ot_reg,allo_meal_ot,nd,nd_ot,absent,tardiness,
        undertime,allo_rice,allo_ctpa,allo_sea,allo_transpo,allo_swc,loan_rcbc,vac,adj_medical,adj_rice,
        adj_nightdiff,adj_restot,adj_shot,adj_lhot,adj_allo_transpo,adj_regot) 
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, $arr_data);
    }
    function IS_DUPLICATE_CSV($date, $user)
    {
        $sql = "SELECT id FROM tbl_attendance_records WHERE empl_id='$user' AND date='$date'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        $data = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }
    function IS_DUPLICATE_LOCK($user_id, $period)
    {
        $sql = "SELECT id FROM tbl_attendance_records_lock WHERE empl_id=? AND period=?";
        $query = $this->db->query($sql, array($user_id, $period));
        $query->next_result();
        $data = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }
    function IS_PAYSLIP($user_id, $period)
    {
        $sql = "SELECT id FROM tbl_payroll_payslips WHERE empl_id=? AND PAYSLIP_PERIOD=?";
        $query = $this->db->query($sql, array($user_id, $period));
        $query->next_result();
        $data = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }
    function IS_LEAVE($user_id, $date_from, $date_to)
    {
        $sql = "SELECT id FROM tbl_leaves_assign WHERE empl_id=$user_id AND leave_date >= '$date_from' AND  leave_date <= '$date_to' AND (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3' OR status = 'Pending 4' OR status = 'Pending 5')";
        $query = $this->db->query($sql);
        $query->next_result();
        $data = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }
    function IS_TIME($user_id, $date_from, $date_to)
    {
        $sql = "SELECT id FROM tbl_attendance_adjustments WHERE empl_id=$user_id AND date_adjustment >= '$date_from' AND  date_adjustment <= '$date_to' AND (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3' OR status = 'Pending 4' OR status = 'Pending 5')";
        $query = $this->db->query($sql);
        $query->next_result();
        $data = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }
    function IS_OVERTIME($user_id, $date_from, $date_to)
    {
        $sql = "SELECT id FROM tbl_overtimes WHERE empl_id=$user_id AND date_ot >= '$date_from' AND  date_ot <= '$date_to' AND (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3' OR status = 'Pending 4' OR status = 'Pending 5')";
        $query = $this->db->query($sql);
        $query->next_result();
        $data = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }
    function IS_HOLIDAY($user_id, $date_from, $date_to)
    {
        $sql = "SELECT id FROM tbl_holidaywork WHERE empl_id=$user_id AND date >= '$date_from' AND  date <= '$date_to' AND (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3' OR status = 'Pending 4' OR status = 'Pending 5')";
        $query = $this->db->query($sql);
        $query->next_result();
        $data = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }
    function MOD_GET_WRK_SHFT_DATA($work_shift_id)
    {
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE id=? LIMIT 1";
        $query = $this->db->query($sql, array($work_shift_id));
        $query->next_result();
        return $query->row();
    }
    function GET_HOLIDAY()
    {
        $sql = "SELECT col_holi_date,col_holi_type FROM tbl_std_holidays";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_ATTENDANCE_RECORD($user_id)
    {
        $sql = "SELECT date,time_in,time_out
                FROM tbl_attendance_records WHERE empl_id=?";
        $query = $this->db->query($sql, array($user_id));
        $query->next_result();
        return $query->result();
    }

    // function GET_ATTENDANCE_ADJUSTMENTS($employee_id, $date_from, $date_to)
    // {
    //     // SQL query with time formatting
    //     $sql = "SELECT empl_id, 
    //                    DATE_FORMAT(time_in_1, '%H:%i') AS time_in_1, 
    //                    DATE_FORMAT(time_out_1, '%H:%i') AS time_out_1, 
    //                    DATE_FORMAT(time_in_2, '%H:%i') AS time_in_2, 
    //                    DATE_FORMAT(time_out_2, '%H:%i') AS time_out_2, 
    //                    date_adjustment, status 
    //             FROM tbl_attendance_adjustments 
    //             WHERE empl_id = ? 
    //             AND date_adjustment BETWEEN ? AND ? 
    //             AND status = 'Approved'";

    //     // Execute the query with parameter binding
    //     $query = $this->db->query($sql, array($employee_id, $date_from, $date_to));
    //     $query->next_result();

    //     // Return the results as an array
    //     return $query->result_array();
    // }

    function GET_ZKTECO_ATTENDANCE_RECORD($employee_id)
    {
        $sql = "SELECT * FROM tbl_zkteco 
        LEFT JOIN tbl_zkteco_code ON tbl_zkteco.emp_code=tbl_zkteco_code.empl_code WHERE tbl_zkteco_code.empl_id=?";
        $query = $this->db->query($sql, array($employee_id));
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
    function GET_ALL_DEPT()
    {
        $sql = 'SELECT id,name,status FROM tbl_std_departments WHERE status="Active"';
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_SECT()
    {
        $sql = 'SELECT id,name,status FROM tbl_std_sections WHERE status="Active"';
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_GROUP()
    {
        $sql = 'SELECT id,name,status FROM tbl_std_groups WHERE status="Active"';
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_LINE()
    {
        $sql = 'SELECT id,name,status FROM tbl_std_lines WHERE status="Active"';
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIFIC_USER_ID($cmid)
    {
        $sql = "SELECT id FROM tbl_employee_infos WHERE col_empl_cmid=?";
        $query = $this->db->query($sql, array($cmid));
        $query->next_result();
        return $query->row_result();
    }
    function GET_ATTE_SUMINAC_REC($cut_off_period)
    {
        $filter = "";
        if ($cut_off_period) {
            $filter = "WHERE cut_off=$cut_off_period";
        }
        $sql = "SELECT * FROM tbl_attendance_suminac " . $filter;
        $query = $this->db->query($sql, array($cut_off_period));
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEE_NAME()
    {
        $sql = "SELECT *,CONCAT(col_frst_name,' ',col_last_name) AS name FROM tbl_employee_infos";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_PAY_SCHED()
    {
        $sql = "SELECT * FROM tbl_payroll_period";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_GET_SEARCHED_DATA($search)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE col_frst_name LIKE '$search%' OR col_last_name LIKE '$search%' OR col_midl_name LIKE '$search%' OR col_empl_email LIKE '$search%' OR col_mobl_numb LIKE '$search%' AND isSuperAdmin != 1";
        $query = $this->db->query($sql, array());
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
    function MOD_DISP_ALL_EMPLOYEES($dept, $sec, $group, $line, $status)
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
        $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 " . $filter_q . " ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_ALL_EMPLOYEES_2()
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_EMPL_INFO_BIOM()
    {
        $sql = "SELECT id,col_empl_cmid,col_empl_dept,col_empl_sect,col_empl_posi,col_frst_name,col_last_name FROM tbl_employee_infos";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_EMPL_NOT_YET_IN_OFFICE()
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? AND time_in=? AND time_out=? AND id!=?";
        $query = $this->db->query($sql, array(date('Y-m-d'), '00:00:00', '00:00:00', '6'));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_EMPL_ALREADY_IN_OFFICE()
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? AND time_in!=? AND time_out=?";
        $query = $this->db->query($sql, array(date('Y-m-d'), '00:00:00', '00:00:00'));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_EMPL_OUT_OF_OFFICE()
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? AND time_in!=? AND time_out!=?";
        $query = $this->db->query($sql, array(date('Y-m-d'), '00:00:00', '00:00:00'));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_EMPL_ON_REST()
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? AND id=?";
        $query = $this->db->query($sql, array(date('Y-m-d'), '6'));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_ON_LEAVE()
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? ";
        $query = $this->db->query($sql, array(date('Y-m-d')));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_EMPL_NOT_YET_IN_OFFICE_AJAX($attendance_date)
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? AND time_in=? AND time_out=?";
        $query = $this->db->query($sql, array($attendance_date, '00:00:00', '00:00:00', '6'));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_EMPL_ALREADY_IN_OFFICE_AJAX($attendance_date)
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? AND time_in!=? AND time_out=?";
        $query = $this->db->query($sql, array($attendance_date, '00:00:00', '00:00:00'));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_EMPL_OUT_OF_OFFICE_AJAX($attendance_date)
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? AND time_in!=? AND time_out!=?";
        $query = $this->db->query($sql, array($attendance_date, '00:00:00', '00:00:00'));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_EMPL_ON_REST_AJAX($attendance_date)
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date=? ";
        $query = $this->db->query($sql, array($attendance_date, '6'));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_ON_LEAVE_AJAX($attendance_date)
    {
        $sql = "SELECT * FROM tbl_leaves_assign WHERE  status='Approved'";
        $query = $this->db->query($sql, array($attendance_date));
        $query->next_result();
        return $query->result();
    }
    function MOD_INSRT_OVERTIME($overtime_date, $type, $time_out, $num_hours, $reason, $status, $assigned_by, $employee_id)
    {
        $sql = "INSERT INTO tbl_overtimes (date_created,date_ot,type,time_out,hours,reason,status1,status2,assigned_by,empl_id) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array(date('Y-m-d'), $overtime_date, $type, $time_out, $num_hours, $reason, $status, $status, $assigned_by, $employee_id));
        return $this->db->insert_id();
    }
    function MOD_UPDT_OT_STATUS_APPR1($status, $ot_insrt_id)
    {
        $sql = "UPDATE tbl_overtimes SET status1=? WHERE id = ?";
        $query = $this->db->query($sql, array($status, $ot_insrt_id));
    }
    function MOD_UPDT_OT_STATUS_APPR2($status, $ot_insrt_id)
    {
        $sql = "UPDATE tbl_overtimes SET status2=? WHERE id = ?";
        $query = $this->db->query($sql, array($status, $ot_insrt_id));
    }
    function MOD_UPDT_OVERTIME_APPLICATION($actual_ot_duration, $overtime_id)
    {
        $sql = "UPDATE tbl_overtimes SET hours=? WHERE id = ?";
        $query = $this->db->query($sql, array($actual_ot_duration, $overtime_id));
    }
    function MOD_UPDT_ATT_REG_OT($ot_hours, $ot_date, $empl_id)
    {
        $sql = "UPDATE tbl_attendance_records SET appr_reg_ot=? WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql, array($ot_hours, $ot_date, $empl_id));
    }
    function MOD_UPDT_ATT_ND_OT($ot_hours, $ot_date, $empl_id)
    {
        $sql = "UPDATE tbl_attendance_records SET appr_ns_ot=? WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql, array($ot_hours, $ot_date, $empl_id));
    }
    function MOD_UPDT_ATT_REST_OT($ot_hours, $ot_date, $empl_id)
    {
        $sql = "UPDATE tbl_attendance_records SET bp_sp_hol=? WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql, array($ot_hours, $ot_date, $empl_id));
    }
    function MON_DISP_CUTOFF_PERIOD($start_date, $end_date, $employee_id)
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE date >= ? AND date <= ? AND empl_id=?";
        $query = $this->db->query($sql, array($start_date, $end_date, $employee_id));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_ALL_APPR_ROUTE_OT_ADJ()
    {
        $sql = "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 ORDER BY id ASC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_APPR_ROUT_LIST()
    {
        $sql = "SELECT * FROM tbl_overtime_approvers";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_APPR_ROUTE_OT_ADJ($id)
    {
        $sql = "SELECT * FROM tbl_overtime_approvers WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }
    function MOD_INSRT_NOTIF_LOGS($empl_id, $empl_group, $appr_type, $reciever, $date_created, $message, $status, $application_id, $requested_by)
    {
        $sql = "INSERT INTO notif_approvals (empl_id, empl_group, appr_type, reciever, date_created, message, status, application_id, requested_by) VALUES (?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($empl_id, $empl_group, $appr_type, $reciever, $date_created, $message, $status, $application_id, $requested_by));
        return;
    }
    function MOD_INSRT_APPLICATION_NOTIF_LOGS($empl_id, $message, $type, $date_created, $application_id, $notif_status)
    {
        $sql = "INSERT INTO notif_application (empl_id, message, type, date_created, application_id, notif_status) VALUES (?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($empl_id, $message, $type, $date_created, $application_id, $notif_status));
        return;
    }
    function MOD_DISP_PAY_SCHED()
    {
        $sql = "SELECT id,name FROM tbl_payroll_period WHERE status='active' ORDER BY id desc";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_SHIFTTEMPLATE()
    {
        $sql = "SELECT * FROM tbl_attendance_shifttemplates ORDER BY name";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_INSRT_SHIFTTEMPLATE($code, $name, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday)
    {
        $sql = "INSERT INTO tbl_attendance_shifttemplates (code,name,monday,tuesday,wednesday,thursday,friday,saturday,sunday) VALUES (?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($code, $name, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday));
        return;
    }
    function MOD_UPDT_SHIFTTEMPLATE($code, $name, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $id)
    {
        $sql = "UPDATE tbl_attendance_shifttemplates SET code=?,name=?,monday=?,tuesday=?,wednesday=?,thursday=?,friday=?,saturday=?,sunday=? WHERE id=?";
        $query = $this->db->query($sql, array($code, $name, $monday, $tuesday, $wednesday, $thursday, $friday, $saturday, $sunday, $id));
    }
    function MOD_DLT_SHIFTTEMPLATE($ShiftTemplate_id)
    {
        $sql = "DELETE FROM tbl_attendance_shifttemplates WHERE id = ?";
        $query = $this->db->query($sql, array($ShiftTemplate_id));
    }
    function MOD_DISP_WRK_SHFT($tab, $row, $offset)
    {
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE is_deleted=0 AND status=? ORDER BY id ASC LIMIT $row OFFSET $offset";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_WRK_SHFT_COUNT($tab)
    {
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE is_deleted=0 AND status=?";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function GET_WORK_SHIFT_ACTIVE_COUNT($tab)
    {
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE is_deleted=0 AND status=?";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function GET_WORK_SHIFT_INACTIVE_COUNT($tab)
    {
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE is_deleted=0 AND status=?";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_SEARCH_WRK_SHFT($tab, $search)
    {
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE is_deleted='0' AND status=?
        AND (tbl_attendance_shifts.id LIKE '%$search%'
        OR tbl_attendance_shifts.code LIKE '%$search%'
        OR tbl_attendance_shifts.name LIKE '%$search%'
        OR tbl_attendance_shifts.color LIKE '%$search%')
        ORDER BY id ASC";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function UPDATE_WORKSHIFT($id, $status)
    {
        $sql = "UPDATE tbl_attendance_shifts SET status=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $id));
    }
    function ADD_WORK_SHIFT($data)
    {
        return $this->db->insert('tbl_attendance_shifts', $data);
    }
    function UPDATE_SPE_WORKSHIFT($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_attendance_shifts', $data);
    }
    function code_exist_by_code_id($code, $id)
    {
        $this->db->where('code', $code);
        $this->db->where('id !=', $id);
        $this->db->from('tbl_attendance_shifts');
        return $this->db->count_all_results();
    }
    function code_exist_by_code($code)
    {
        $this->db->where('code', $code);
        $this->db->from('tbl_attendance_shifts');
        return $this->db->count_all_results();
    }
    function MOD_INSRT_WRK_SHFT($code, $shift_name, $time_in, $time_out, $time_in_2, $time_out_2, $time_out_w_ot, $has_next_day, $color, $status, $lunch_break_start, $lunch_break_end)
    {
        $datetime = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_attendance_shifts (create_date,edit_date,code,name,time_in,time_out,time_in_2,time_out_2,time_out_ot,next_day,color,status,lunch_break_start,lunch_break_end) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($datetime, $datetime, $code, $shift_name, $time_in, $time_out, $time_in_2, $time_out_2, $time_out_w_ot, $has_next_day, $color, $status, $lunch_break_start, $lunch_break_end));
        return;
    }
    function MOD_UPDT_WRK_SHFT($code, $shift_name, $time_in, $time_out, $time_in_2, $time_out_2, $time_out_w_ot, $has_next_day, $color, $id, $lunch_break_start, $lunch_break_end)
    {
        $datetime = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_shifts SET edit_date=?, code=?,name=?,time_in=?,time_out=?,time_in_2=?,time_out_2=?,time_out_ot=?,next_day=?,color=?,lunch_break_start=?,lunch_break_end=? WHERE id=?";
        return $this->db->query($sql, array($datetime, $code, $shift_name, $time_in, $time_out, $time_in_2, $time_out_2, $time_out_w_ot, $has_next_day, $color, $lunch_break_start, $lunch_break_end, $id));
    }
    function MOD_DLT_WRK_SHFT($work_shift_id)
    {
        $sql = "UPDATE tbl_attendance_shifts SET is_deleted=1 WHERE id = ?";
        $query = $this->db->query($sql, array($work_shift_id));
    }
    function MOD_INSRT_HOLIDAY($HOLIDAY_INPF_NAME, $HOLIDAY_INPF_DATE, $HOLIDAY_INPF_TYPE)
    {
        $sql = "INSERT INTO tbl_std_holidays (name,col_holi_date,col_holi_type) VALUES (?,?,?)";
        $query = $this->db->query($sql, array($HOLIDAY_INPF_NAME, $HOLIDAY_INPF_DATE, $HOLIDAY_INPF_TYPE));
        return;
    }
    function MOD_UPDT_HOLIDAY($UPDT_HOLIDAY_INPF_NAME, $UPDT_HOLIDAY_INPF_DATE, $UPDT_HOLIDAY_INPF_TYPE, $UPDT_HOLIDAY_INPF_ID)
    {
        $sql = "UPDATE tbl_std_holidays SET name=?,col_holi_date=?,col_holi_type=? WHERE id=?";
        $query = $this->db->query($sql, array($UPDT_HOLIDAY_INPF_NAME, $UPDT_HOLIDAY_INPF_DATE, $UPDT_HOLIDAY_INPF_TYPE, $UPDT_HOLIDAY_INPF_ID));
    }
    function MOD_DLT_HOLIDAY($holiday_id)
    {
        $sql = "DELETE FROM tbl_std_holidays WHERE id = ?";
        $query = $this->db->query($sql, array($holiday_id));
    }
    function MOD_DISP_DISTINCT_BRANCH()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_branches";
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
    function GET_ALL_EMP()
    {
        $sql = "SELECT * FROM tbl_employee_infos";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_INSERT_APPROVER_DATA($emp_id, $app1a, $app1b, $app2a, $app2b, $app3a, $app3b)
    {
        $sql = "INSERT INTO tbl_overtime_approvers (empl_id,approver_1a,approver_1b,approver_2a,approver_2b,approver_3a,approver_3b) VALUE (?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($emp_id, $app1a, $app1b, $app2a, $app2b, $app3a, $app3b));
        return;
    }
    function INSERT_ATTENDANCE_REC_CSV($arr_data)
    {
        $sql = "INSERT INTO tbl_attendance_records (date,empl_id,time_in,time_out) VALUE (?,?,?,?)";
        $query = $this->db->query($sql, $arr_data);
        return;
    }
    function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'maiya_reset'";
        return $this->db->query($query)->row_array();
    }
    function UPDATE_ATTENDANCE_REC_CSV($arr_data)
    {
        $sql = "UPDATE tbl_attendance_records SET time_in = ?,time_out = ? WHERE date = ? and empl_id = ?";
        $query = $this->db->query($sql, $arr_data);
        return;
    }
    function GET_OVERTIME_APPROVER($empl_id)
    {
        $sql = "SELECT * FROM tbl_overtime_approvers WHERE empl_id=?";
        $query = $this->db->query($sql, array($empl_id));
        return $query->num_rows();
    }
    function MOD_UPDT_OVERTIME_APPROVER($date, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b, $id)
    {
        $sql = "UPDATE tbl_overtime_approvers SET edit_date=?,approver_1a=?,approver_1b=?,approver_2a=?,approver_2b=?,approver_3a=?,approver_3b=?  WHERE empl_id IN (" . $id . ")";
        $query = $this->db->query($sql, array($date, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b));
    }
    function MOD_INSERT_OVERTIME_APPROVER($date, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b, $empl_id)
    {
        $sql = "INSERT INTO tbl_overtime_approvers (create_date, edit_date,empl_id,approver_1a,approver_1b,approver_2a,approver_2b,approver_3a,approver_3b) VALUES (?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($date, $date, $empl_id, $approver1a, $approver1b, $approver2a, $approver2b, $approver3a, $approver3b));
        return;
    }
    function GET_ZKTECO_RECORDS($offset, $row, $user_id)
    {
        if ($user_id == null) {
            $sql = "SELECT id,emp_code,punch_time,punch_state,terminal_sn FROM tbl_zkteco ORDER BY id DESC LIMIT " . $offset . ", " . $row . " ";
        } else {
            $sql = "SELECT id,emp_code,punch_time,punch_state,terminal_sn FROM tbl_zkteco WHERE emp_code = $user_id ORDER BY id DESC LIMIT " . $offset . ", " . $row . " ";
        }
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_ZKTECO_CODE($id)
    {
        $sql = "SELECT empl_id FROM tbl_zkteco_code WHERE empl_code = $id";
        $query = $this->db->query($sql, array());
        $result = $query->result();
        if ($result) {
            return $result[0]->empl_id;
        } else {
            return "";
        }
    }
    function GET_ZKTECO_EMPL_CODE_BY_EMPL_ID($empl_id)
    {
        $sql = "SELECT empl_code FROM tbl_zkteco_code WHERE empl_id=?";
        $query = $this->db->query($sql, array($empl_id));
        $result = $query->result();
        if ($result) {
            return $result[0]->empl_code;
        } else {
            return "";
        }
    }
    function GET_COUNT_ZKTECO_RECORDS($user_id)
    {
        if ($user_id == null) {
            $sql = "SELECT id FROM tbl_zkteco";
        } else {
            $sql = "SELECT id FROM tbl_zkteco WHERE emp_code = $user_id";
        }
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }
    function GET_ALL_EMPLOYEES()
    {
        $sql = "SELECT * FROM tbl_employee_infos ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_FILTER_ZKTECO_EMPLOYEES()
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE id=1 ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_BIOMETRICS($terminal_sn)
    {
        $sql = "SELECT name FROM tbl_biometrics WHERE terminal_sn=?";
        $query = $this->db->query($sql, array($terminal_sn));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return "";
        }
    }
    function GET_READY_PAYSLIP($period)
    {
        $sql =  "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name,
                col_empl_posi,col_empl_type FROM tbl_employee_infos
                WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
                AND EXISTS(
                SELECT empl_id from tbl_attendance_records_lock
                WHERE tbl_attendance_records_lock.empl_id=tbl_employee_infos.id and tbl_attendance_records_lock.period=$period
                )
                AND 
                NOT EXISTS (
                SELECT empl_id from tbl_payroll_payslips WHERE tbl_payroll_payslips.empl_id=tbl_employee_infos.id and
                tbl_payroll_payslips.PAYSLIP_PERIOD = $period)";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_NOT_READY_PAYSLIP($period)
    {
        $sql =  "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name,
                col_empl_posi,col_empl_type from tbl_employee_infos
                WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
                AND NOT EXISTS(
                SELECT empl_id from tbl_attendance_records_lock
                WHERE tbl_attendance_records_lock.empl_id=tbl_employee_infos.id and tbl_attendance_records_lock.period=$period
                )
                AND 
                NOT EXISTS (
                SELECT empl_id from tbl_payroll_payslips WHERE tbl_payroll_payslips.empl_id=tbl_employee_infos.id and
                tbl_payroll_payslips.PAYSLIP_PERIOD = $period)";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function IS_DUPLICATE_CMID($empl_id)
    {
        $sql = "SELECT * FROM tbl_zkteco_code WHERE empl_cmid=?";
        $query = $this->db->query($sql, array($empl_id));
        return $query->num_rows();
    }
    function IS_DUPLICATE_CODE($code)
    {
        $sql = "SELECT * FROM tbl_zkteco_code WHERE empl_code=?";
        $query = $this->db->query($sql, array($code));
        return $query->num_rows();
    }
    function check_zkteco_code($data)
    {
        $sql = "SELECT id FROM tbl_zkteco_code WHERE empl_cmid!=? AND empl_code=?";
        $query = $this->db->query($sql, array($data[1], $data[5]));
        return $query->num_rows();
    }
    function update_zkteco_code($data, $userId)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_zkteco_code SET edit_date=?, edit_user=?, empl_id=?, empl_code=? WHERE empl_cmid=?";
        $this->db->query($sql, array($edit_date, $userId, $data[0], $data[5], $data[1]));
        $updated_rows = $this->db->affected_rows();
        return $updated_rows;
    }
    function insert_zkteco_code($data, $userId)
    {
        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_zkteco_code (create_date, edit_date, empl_id, empl_cmid, empl_code) VALUES(?,?,?,?,?)";
        $this->db->query($sql, array($create_date, $create_date, $data[0], $data[1], $data[5]));
        $inserted_rows = $this->db->affected_rows();
        return $inserted_rows;
    }
    function UPDATE_EMPL_CODE($id, $empl_id, $code)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_zkteco_code SET edit_date=?, empl_id=?, empl_code=? WHERE empl_cmid=?";
        return $this->db->query($sql, array($edit_date, $id, $code, $empl_id));
    }
    function INSERT_EMPL_CODE($id, $empl_id, $code)
    {
        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_zkteco_code (create_date, edit_date, empl_id, empl_cmid, empl_code) VALUES(?,?,?,?,?)";
        return $this->db->query($sql, array($create_date, $create_date, $id, $empl_id, $code));
    }
    function IS_DUPLICATE($user_id, $date)
    {
        $sql = "SELECT id FROM tbl_attendance_shiftassign WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql, array($user_id, $date));
        $query->next_result();
        $data = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }
    function UPDATE_USER_WORK_SHIFT($user_id, $shift_id, $date)
    {
        $datetime = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_attendance_shiftassign SET edit_date=?, shift_id=? WHERE empl_id=? AND date=?";
        return $this->db->query($sql, array($datetime, $shift_id, $user_id, $date));
    }
    function ADD_USER_WORK_SHIFT($user_id, $shift_id, $date)
    {
        $datetime = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_attendance_shiftassign (create_date,edit_date,empl_id,date,shift_id) VALUES(?,?,?,?,?)";
        return $this->db->query($sql, array($datetime, $datetime, $user_id, $date, $shift_id));
    }
    function is_duplicate_data($user_id, $date)
    {
        $sql = "SELECT id FROM tbl_attendance_shiftassign WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql, array($user_id, $date));
        return $query->num_rows();
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
    function update_shift_data($data_row, $editUser)
    {
        $SHIFT_DATA                 = $this->GET_SHIFT_ALL_DATA();
        $datetime       = date('Y-m-d H:i:s');
        $user_id        = $data_row[0];
        $shift_id       = $this->convert_name2id($SHIFT_DATA, $data_row[1]);
        $date           = $data_row[2];
        $is_duplicate = $this->is_duplicate_data($user_id, $date);
        if ($is_duplicate > 0) {
            $sql = " UPDATE tbl_attendance_shiftassign SET edit_date=?, shift_id=? WHERE empl_id=? AND date=?";
            $this->db->query($sql, array($datetime, $shift_id, $user_id, $date));
        } else {
            $sql = "INSERT INTO tbl_attendance_shiftassign (create_date,edit_date,edit_user,is_deleted,empl_id,date,shift_id) VALUES(?,?,?,?,?,?,?)";
            $this->db->query($sql, array($datetime, $datetime, $editUser, 0, $user_id, $date, $shift_id));
        }
    }
    
    function GET_CUTOFF_LIST()
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE status = 'Active' ORDER BY date_to DESC";
        $query = $this->db->query($sql, array());
        return $query->result_object();
    }
    function GET_CUTOFF($id)
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE id=? AND status = 'Active' ORDER BY date_to DESC";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }
    function GET_ATTENDACE_SUMMARY($period)
    {
        $sql = "SELECT empl_id,present,absent,tardiness,undertime,paid_leave,reg_hours,reg_ot,reg_nd,reg_ndot,rest_hours,rest_ot,rest_nd,rest_ndot,leg_hours,leg_ot,leg_nd,leg_ndot,legrest_hours,legrest_ot,legrest_nd,legrest_ndot,spe_hours,spe_ot,spe_nd,spe_ndot,sperest_hours,sperest_ot,sperest_nd,sperest_ndot,status,adjustments,internet_fee,medical_fee,rice_allowance,rest_day_ot,lhot,regular,st_hours,rcbc_loan,uniform,bonus,il_sl_conversion,swc,electricity_allwance,meal_allowance,meal_electricity_and_internet,ot_meal FROM tbl_attendance_records_calc WHERE period=? ORDER BY id DESC";
        $query = $this->db->query($sql, array($period));
        $query->next_result();
        return $query->result();
    }
    function GET_ATTENDANCE_LOG_IN_OUT($period_start, $period_end)
    {
        $sql = "SELECT date, empl_id, time_in, time_out FROM tbl_attendance_records WHERE date >= ? AND  date <= ?";
        $query = $this->db->query($sql, array($period_start, $period_end));
        $query->next_result();
        return $query->result();
    }
    function GET_ATTENDANCE_EMPLOYEES_SHIFT($period_start, $period_end)
    {
        $sql =  "SELECT tb2.code, tb1.date,tb1.empl_id,  tb2.time_regular_start,  tb2.time_regular_end, tb2.time_regular_reg FROM  tbl_attendance_shiftassign AS tb1 INNER JOIN  tbl_attendance_shifts AS tb2 ON  tb2.id = tb1.shift_id  
        WHERE tb1.date >= '$period_start' AND tb1.date <='$period_end'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEELIST_SUMMARY($offset, $row)
    {
        $sql = "SELECT tbl_employee_infos.id, tbl_employee_infos.col_empl_cmid, 
        CONCAT_WS(
            '', 
            COALESCE(col_last_name, ''), 
            CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END, ', ',
            COALESCE(col_frst_name, ''), 
            CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS fullname, tbl_std_positions.name AS position
        FROM tbl_employee_infos 
        LEFT JOIN tbl_std_positions ON tbl_employee_infos.col_empl_posi=tbl_std_positions.id
        WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 ORDER BY col_empl_cmid ASC      
        -- LIMIT " . $offset . ", " . $row . " 
        ";    //ORDER BY col_empl_cmid + 0 ASC
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEELIST_SUMMARY_EDIT()
    {
        $sql = "SELECT id, col_empl_cmid,
        CONCAT_WS(
            '', 
            COALESCE(col_last_name, ''), 
            CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END, ', ',
            COALESCE(col_frst_name, ''), 
            CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS fullname
        FROM tbl_employee_infos 
        WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        ORDER BY col_empl_cmid ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEELIST_SUMMARY_COUNT()
    {
        $sql = "SELECT id, col_empl_cmid, CONCAT(col_last_name,', ',col_frst_name) as fullname FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function GET_ZKTECO_ATTENDANCE_RECORD_DATA($period_start, $period_end)
    {
        $sql = "SELECT empl_id, punch_time, punch_state  FROM tbl_zkteco
            LEFT JOIN tbl_zkteco_code ON tbl_zkteco.emp_code = tbl_zkteco_code.empl_code
            WHERE DATE(tbl_zkteco.punch_time) BETWEEN ? AND ?";
        $query = $this->db->query($sql, array($period_start, $period_end));
        $query->next_result();
        return $query->result();
    }
    function GET_ZKTECO_ATTENDANCE_EMPLOYEE_NAME($offset, $resultsPerPage, $search)
    {
        if (empty($offset)) {
            $offset = 0;
        } elseif (is_string($offset)) {
            $offset = intval($offset);
        }
        if (empty($resultsPerPage)) {
            $resultsPerPage = 10;
        } elseif (is_string($resultsPerPage)) {
            $resultsPerPage = intval($resultsPerPage);
        }
        $sql = "SELECT 
                    tbl_zkteco_code.empl_code as empl_code,
                    tbl_zkteco.emp_code as zkteco_emp_code,
                    tbl_zkteco.id AS id,
                    tbl_employee_infos.col_empl_cmid AS empl_id,
                    tbl_biometrics.name AS terminal_sn,
                    tbl_zkteco.punch_time, 
                    tbl_zkteco.punch_state, 
                    CONCAT(
                        tbl_employee_infos.col_last_name, 
                        ', ', 
                        tbl_employee_infos.col_frst_name, 
                        ' ', 
                        CONCAT(LEFT(tbl_employee_infos.col_midl_name, 1), '.')
                    ) AS employee_name
                FROM tbl_zkteco
                LEFT JOIN tbl_zkteco_code ON tbl_zkteco.emp_code = tbl_zkteco_code.empl_code
                LEFT JOIN tbl_employee_infos ON tbl_zkteco_code.empl_id = tbl_employee_infos.id
                LEFT JOIN tbl_biometrics ON tbl_zkteco.terminal_sn = tbl_biometrics.terminal_sn";
        $params = array();
        if (!empty($search)) {
            $sql .= " WHERE tbl_employee_infos.col_frst_name LIKE ? OR tbl_employee_infos.col_midl_name LIKE ? OR tbl_employee_infos.col_last_name LIKE ?";
            $searchTerm = "%$search%";
            $params = array($searchTerm, $searchTerm, $searchTerm);
        }
        $sql .= " LIMIT ?, ?";
        $params[] = $offset;
        $params[] = $resultsPerPage;
        $query = $this->db->query($sql, $params);
        $query->next_result();
        return $query->result_array();
    }
    function GET_ZKTECO_ATTENDANCE_EMPLOYEE_NAME_count($search)
    {
        $sql = "SELECT 
                    tbl_zkteco.id AS id,
                    tbl_employee_infos.id AS empl_id,
                    tbl_biometrics.name AS terminal_sn,
                    tbl_zkteco.punch_time, 
                    tbl_zkteco.punch_state, 
                    CONCAT(
                        tbl_employee_infos.col_last_name, 
                        ', ', 
                        tbl_employee_infos.col_frst_name, 
                        ' ', 
                        CONCAT(LEFT(tbl_employee_infos.col_midl_name, 1), '.')
                    ) AS employee_name
                FROM tbl_zkteco
                LEFT JOIN tbl_employee_infos ON tbl_zkteco.emp_code = tbl_employee_infos.id
                LEFT JOIN tbl_biometrics ON tbl_zkteco.terminal_sn = tbl_biometrics.terminal_sn";
        $params = array();
        if (!empty($search)) {
            $sql .= " WHERE tbl_employee_infos.col_frst_name LIKE ? OR tbl_employee_infos.col_midl_name LIKE ? OR tbl_employee_infos.col_last_name LIKE ?";
            $searchTerm = "%$search%";
            $params = array($searchTerm, $searchTerm, $searchTerm);
        }
        $query = $this->db->query($sql, $params);
        return $query->num_rows();
    }
    function GET_BENEFITS_DYNAMIC_TYPE()
    {
        $sql = "SELECT id, name FROM tbl_benefits_dynamic_type WHERE is_deleted=0";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_BENEFITS_FIXED_TYPE()
    {
        $sql = "SELECT id, name FROM tbl_benefits_fixed_type WHERE is_deleted=0";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_BENEFITS_ADJUSTMENT_TYPE()
    {
        $sql = "SELECT id, name FROM tbl_benefits_adjustment_type WHERE is_deleted=0";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_BENEFITS_DYNAMIC_STD()
    {
        $sql = "SELECT id,name,value, type FROM tbl_benefits_dynamic_std WHERE is_deleted=0";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEELIST_ASSIGN()
    {
        $sql = "SELECT tb1.id, tb1.col_empl_cmid, CONCAT(tb1.col_last_name,', ',tb1.col_frst_name) as fullname, tb2.category as category FROM tbl_employee_infos AS tb1 INNER JOIN tbl_benefits_dynamic_assign AS tb2 ON tb2.user = tb1.id WHERE tb2.category > 0 ORDER BY tb1.col_empl_cmid ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_BENEFITS_DYNAMIC_COUNT($period)
    {
        $sql = "SELECT id,user_id,count, type FROM tbl_benefits_dynamic_count WHERE period=? AND is_deleted=0";
        $query = $this->db->query($sql, array($period));
        $query->next_result();
        return $query->result();
    }
    function GET_BENEFITS_FIXED_ASSIGN($period)
    {
        $sql = "SELECT id, user_id, value, type FROM tbl_benefits_fixed_assign WHERE period=? AND is_deleted=0";
        $query = $this->db->query($sql, array($period));
        $query->next_result();
        return $query->result();
    }
    function GET_BENEFITS_ADJUSTMENT_ASSIGN($period)
    {
        $sql = "SELECT id, user_id, value, type FROM tbl_benefits_adjustment_assign WHERE period=? AND is_deleted=0";
        $query = $this->db->query($sql, array($period));
        $query->next_result();
        return $query->result();
    }
    function UPDATE_OVERTIME($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_overtimes', $data);
    }
    function GET_OVERTIME($id)
    {
        $this->db->select('tb1.id,tb1.date_ot,tb1.empl_id,tb1.assigned_by as assigned_by_id,tb1.comment,tb1.reason,tb1.time_out,tb1.status,tb1.hours,tb1.type');
        $this->db->select("CONCAT(tb2.col_empl_cmid,'-',tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(tb2.col_midl_name,1)) as employee ", false);
        $this->db->select("CONCAT(tb3.col_empl_cmid,'-',tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(tb3.col_midl_name,1)) as assigned_by ", false)
            ->from('tbl_overtimes as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left')
            ->join('tbl_employee_infos as tb3', 'tb1.assigned_by=tb3.id', 'left')
            ->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    function GET_OVERTIMES($status, $search, $limit, $offset, $filter_arr)
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
        $this->db->select('tb1.id,tb1.date_ot,tb1.hours,tb1.type,tb1.time_out,tb1.reason,tb1.status,tb1.comment');
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee", false);
        $this->db->from('tbl_overtimes as tb1');
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->join('tbl_employee_infos as tb2', 'tb1.assigned_by=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        if (!empty($search)) {
            $this->db->having("assigned_by = '$search' OR employee LIKE '%$search%' 
          OR hours LIKE '%$search%' OR date_ot LIKE '%$search%'
          OR type LIKE '%$search%'
          OR status LIKE '%$search%'
          ");
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }
    function GET_OVERTIMES_COUNT($status, $search, $filter_arr)
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
        $this->db->select('tb1.id,tb1.date_ot,tb1.hours,tb1.type,tb1.time_out,tb1.reason,tb1.status,tb1.comment');
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee", false);
        $this->db->from('tbl_overtimes as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.assigned_by=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        if (!empty($search)) {
            $this->db->having("assigned_by = '$search' OR employee LIKE '%$search%' 
          OR hours LIKE '%$search%' OR date_ot LIKE '%$search%'
          OR type LIKE '%$search%'
          OR status LIKE '%$search%'
          ");
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    function UPDATE_HOLIDAY_WORK($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_holidaywork', $data);
    }
    function GET_HOLIDAY_WORK($id)
    {
        $this->db->select('tb1.id,tb1.date,tb1.empl_id,tb1.assigned_by as assigned_by_id,tb1.comment,tb1.reason,tb1.status,tb1.hours,tb1.type');
        $this->db->select("CONCAT(tb2.col_empl_cmid,'-',tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(tb2.col_midl_name,1)) as employee ", false);
        $this->db->select("CONCAT(tb3.col_empl_cmid,'-',tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(tb3.col_midl_name,1)) as assigned_by ", false)
            ->from('tbl_holidaywork as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left')
            ->join('tbl_employee_infos as tb3', 'tb1.assigned_by=tb3.id', 'left')
            ->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    function GET_HOLIDAY_WORKS($status, $search, $limit, $offset, $filter_arr)
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
        $this->db->select('tb1.id,tb1.date,tb1.hours,tb1.type,tb1.reason,tb1.status,tb1.comment');
        $this->db->select("
            CONCAT_WS(
                '', 
                COALESCE(tb2.col_last_name, ''), 
                CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END, ', ',
                COALESCE(tb2.col_frst_name, ''), 
                CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
            ) AS assigned_by
            ", false);
        $this->db->select("
            CONCAT_WS(
                '', 
                COALESCE(tb3.col_last_name, ''), 
                CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix != '' THEN CONCAT(' ', tb3.col_suffix) ELSE '' END, ', ',
                COALESCE(tb3.col_frst_name, ''), 
                CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name != '' THEN CONCAT(' ', LEFT(tb3.col_midl_name, 1), '.') ELSE '' END
            ) AS employee
            ", false);
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
            $this->db->having("assigned_by = '$search' OR employee LIKE '%$search%' 
          OR hours LIKE '%$search%' OR date LIKE '%$search%'
          OR type LIKE '%$search%'
          OR status LIKE '%$search%'
          ");
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }
    function GET_HOLIDAY_WORKS_COUNT($search, $status, $filter_arr)
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
        $this->db->select('tb1.id,tb1.date,tb1.hours,tb1.type,tb1.reason,tb1.status,tb1.comment');
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
            $this->db->having("assigned_by = '$search' OR employee LIKE '%$search%' 
          OR hours LIKE '%$search%' OR date LIKE '%$search%'
          OR type LIKE '%$search%'
          OR status LIKE '%$search%'
          ");
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    function UPDATE_TIME_ADJ($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_attendance_adjustments', $data);
    }
    function GET_TIME_ADJ_SPE($id)
    {
        $this->db->select('tb1.id,tb1.date_adjustment,tb1.empl_id,tb1.assigned_by as assigned_by_id,tb1.remarks,tb1.reason,tb1.attachment,
        tb1.time_in_1,tb1.time_out_1,tb1.time_in_2,tb1.time_out_2,tb1.status,tb1.shift_type');
        $this->db->select("CONCAT(tb2.col_empl_cmid,'-',tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(tb2.col_midl_name,1)) as employee ", false);
        $this->db->select("CONCAT(tb3.col_empl_cmid,'-',tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(tb3.col_midl_name,1)) as assigned_by ", false)
            ->from('tbl_attendance_adjustments as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left')
            ->join('tbl_employee_infos as tb3', 'tb1.assigned_by=tb3.id', 'left')
            ->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    function GET_OFFSET_STATUS($id)
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
        $this->db->from('tbl_attendance_offsets as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_approvers_offset as tb3', 'tb1.empl_id            = tb3.empl_id', 'left');
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
    function UPDATE_OFFSET($data, $id)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_attendance_offsets', $data);
    }
    function GET_OFFSET($id)
    {
        $query = $this->db->select('*')
            ->where('id', $id)
            ->limit('1')
            ->get('tbl_attendance_offsets');
        return $query->row();
    }
    function GET_OFFSETS($status, $search, $limit, $offset, $filter_arr)
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
            ->select("CONCAT('OFF', LPAD(tb1.id, 5, '0')) as c_id", false)
            ->select('tb1.offset_date')
            ->select('tb1.time_range')
            ->select('tb1.duration')
            ->select('tb1.status')
            ->select('tb1.remarks,tb1.reason')
            ->select('tb2.id as employee_table_id')
            ->select('tb3.id as assigned_table_id')
            ->from('tbl_attendance_offsets as tb1')
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
        $this->db->limit($limit, $offset);
        $this->db->order_by('tb1.id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    function GET_EMPLOYEES()
    {
        $this->db->select('id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name');
        $this->db->where("disabled = 0 AND (termination_date IS NULL OR termination_date = '0000-00-00') ");
        $this->db->order_by('col_last_name ', 'ASC');
        $query = $this->db->get('tbl_employee_infos');
        return $query->result();
    }
    function GET_OFFSETS_COUNT($search, $status, $filter_arr)
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
            ->select('tb1.offset_date')
            ->select('tb1.duration')
            ->select('tb1.status')
            ->select('tb1.remarks')
            ->from('tbl_attendance_offsets as tb1')
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
        $query = $this->db->get();
        return $query->num_rows();
    }
    function GET_EMPLOYEE_SPECIFIC_ROW($employee_id)
    {
        $sql   = "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->row();
    }
    function GET_SETUP_SETTING($setting)
    {
        $this->db->where('setting', $setting);
        $query = $this->db->get('tbl_system_setup');
        $val = $query->row();
        return $val->value;
    }
    // function GET_USER_APPROVERS($id, $table)
    // {
    //     $this->db->select('tb1.id,approver_1a,approver_2a,approver_3a,tb1.empl_id');
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
    function ADD_OFFSET_REQUEST($data)
    {
        return $this->db->insert('tbl_attendance_offsets', $data);
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
        } else if ($type == 'offsets') {
            $this->db->from('tbl_attendance_offsets as tb1');
        } else if ($type == 'acquire_offsets') {
            $this->db->from('tbl_attendance_offsets_acquire as tb1');
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

    function ADD_NOTIFICATION($data)
    {
        $this->db->insert('tbl_notifications', $data);
        return $this->db->insert_id();
    }
    
    function GET_IS_DUPLICATE_DATE($date)
    {
        $sql = "SELECT * FROM tbl_attendance_offsets WHERE offset_date=?";
        $query = $this->db->query($sql, array($date));
        return $query->num_rows();
    }
    function GET_TIME_ADJ($status, $search, $limit, $offset, $filter_arr)
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
        $this->db->select('tb1.id,tb1.date_adjustment,tb1.shift_type, 
        tb1.time_in_1,tb1.time_out_1,tb1.time_in_2,tb1.time_out_2,tb1.attachment,tb1.status');
        $this->db->select("
            CONCAT_WS(
                '', 
                COALESCE(tb2.col_empl_cmid, ''), 
                CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT('-', tb2.col_last_name) ELSE '' END, ', ',
                CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END, ', ',
                COALESCE(tb2.col_frst_name, ''), 
                CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
            ) AS assigned_by
            ", false);
        $this->db->select("
            CONCAT_WS(
                '', 
                COALESCE(tb3.col_empl_cmid, ''), 
                CASE WHEN tb3.col_last_name IS NOT NULL AND tb3.col_last_name != '' THEN CONCAT('-', tb3.col_last_name) ELSE '' END, ', ',
                CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix != '' THEN CONCAT(' ', tb3.col_suffix) ELSE '' END, ', ',
                COALESCE(tb3.col_frst_name, ''), 
                CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name != '' THEN CONCAT(' ', LEFT(tb3.col_midl_name, 1), '.') ELSE '' END
            ) AS employee
            ", false);
        $this->db->from('tbl_attendance_adjustments as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.assigned_by=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        if (!empty($search)) {
            $this->db->where("tb3.id = '$search'
          ");
        }
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }
    function GET_OFFSET_COUNT($search, $status, $filter_arr)
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
        $this->db->select('tb1.id,tb1.date_offset,tb1.shift_type,
        tb1.time_in_1,tb1.time_out_1,tb1.time_in_2,tb1.time_out_2,tb1.attachment,tb1.status');
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee", false);
        $this->db->from('tbl_attendance_offsets as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.assigned_by=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        if (!empty($search)) {
            $this->db->having("assigned_by = '$search' OR employee LIKE '%$search%' 
          OR date_adjustment LIKE '%$search%'
          OR shift_type LIKE '%$search%'
          OR status LIKE '%$search%'
          OR attachment LIKE '%$search%'
          ");
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    function GET_TIME_ADJ_COUNT($search, $status, $filter_arr)
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
        $this->db->select('tb1.id,tb1.date_adjustment,tb1.shift_type,
        tb1.time_in_1,tb1.time_out_1,tb1.time_in_2,tb1.time_out_2,tb1.attachment,tb1.status');
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee", false);
        $this->db->from('tbl_attendance_adjustments as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.assigned_by=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        if (!empty($search)) {
            $this->db->having("assigned_by = '$search' OR employee LIKE '%$search%' 
          OR date_adjustment LIKE '%$search%'
          OR shift_type LIKE '%$search%'
          OR status LIKE '%$search%'
          OR attachment LIKE '%$search%'
          ");
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    function GET_ALL_BENEFITS_LOAN()
    {
        $sql = "SELECT tbl_benefits_loan.id, loan_name, CONCAT(col_last_name,', ',col_frst_name) as fullname, loan_type, loan_date, loan_amount, loan_terms, empl_id, initial_paid FROM tbl_benefits_loan LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_benefits_loan.empl_id
         WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0";
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
    function GET_EMPLOYEE_ID($cmid)
    {
        $sql = "SELECT id FROM tbl_employee_infos WHERE col_empl_cmid=? AND (termination_date IS NULL || termination_date = '0000-00-00') AND disabled=0";
        $query = $this->db->query($sql, array($cmid));
        $result = $query->row();
        return $result->id;
    }
    function IS_ATTENDANCE_DUPLICATE($empl_id, $date)
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE empl_id=? AND date=? ";
        $query = $this->db->query($sql, array($empl_id, $date));
        return $query->num_rows();
    }
    function UPDATE_ATTENDANCE_RECORD_ADVANCE($data, $empl_id)
    {
        $id = $data['id'] ?? 0;
        $time_in = $data['advance_in'];
        $time_out = $data['advance_out'];
        $date = $data['date'];
        // if () {
        //     $create_date        = date('Y-m-d H:i:s');
        //     $sql = "INSERT INTO tbl_attendance_records_advance (create_date, edit_date, date, empl_id, time_in, time_out) VALUES(?,?,?,?,?,?)";
        //     $this->db->query($sql, array($create_date, $create_date, $date, $empl_id, $time_in, $time_out,));
        // }
        if ($id) {
            $edit_date = date('Y-m-d H:i:s');
            $sql = "UPDATE tbl_attendance_records_advance SET edit_date=?, time_in=?, time_out=? WHERE id=?";
            $this->db->query($sql, array($edit_date, $time_in, $time_out, $id));
        } else if ($date && ($time_in || $time_out)) {
            $create_date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO tbl_attendance_records_advance (create_date, edit_date, date, empl_id, time_in, time_out) VALUES(?,?,?,?,?,?)";
            $this->db->query($sql, array($create_date, $create_date, $date, $empl_id, $time_in, $time_out));
        }
    }
    function ADD_ATTENDANCE_RECORD($data)
    {
        $cmid               = $data[0];
        $empl_id            = $this->GET_EMPLOYEE_ID($cmid);

        $dateParts          = explode('/', $data[1]);
        $day                = $dateParts[0];
        $month              = $dateParts[1];
        $year               = $dateParts[2];
        $date               = date('Y-m-d', strtotime($month . '/' . $day . '/' . $year));
        $result = $this->IS_ATTENDANCE_DUPLICATE($empl_id, $date);
        if ($result <= 0) {
            $time_in            = $data[2];
            $time_out           = $data[3];

            $create_date        = date('Y-m-d H:i:s');
            $sql = "INSERT INTO tbl_attendance_records (create_date, edit_date, date, empl_id, time_in, time_out) VALUES(?,?,?,?,?,?)";
            $this->db->query($sql, array($create_date, $create_date, $date, $empl_id, $time_in, $time_out));
        }
    }
    function UPDATE_CONVERTER($data)
    {
        $cmid               = $data[0];
        $empl_id            = $this->GET_EMPLOYEE_ID($cmid);

        $dateParts          = explode('/', $data[1]);
        $day                = $dateParts[0];
        $month              = $dateParts[1];
        $year               = $dateParts[2];
        $date               = date('Y-m-d', strtotime($month . '/' . $day . '/' . $year));
        $result = $this->IS_ATTENDANCE_DUPLICATE($empl_id, $date);
        if ($result <= 0) {
            $time_in            = $data[2];
            // $time_out           = $data[3];
            // $break_in            = $data[4];
            // $break_out           = $data[5];
            $create_date        = date('Y-m-d H:i:s');
            $sql = "INSERT INTO tbl_timerecord_raw (create_date, edit_date, date, empl_id, time_in) VALUES(?,?,?,?,?)";
            $this->db->query($sql, array($create_date, $create_date, $date, $empl_id, $time_in));
        }
    }
    function save_sorted_data($data)
    {
        $this->db->trans_start();

        foreach ($data as $row) {
            $insert_data = [
                'empl_id' => $row[0],
                'date' => date('Y-m-d', strtotime($row[1])),
                'time' => $row[2]
            ];
            $this->db->insert('tbl_timerecord_raw', $insert_data);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return false;
        } else {
            return true;
        }
    }
    function edit_attendance_record_advance($data)
    {
        $id                     = $data[0];
        // $time_in                = $data[3];
        $time_in = empty($data[3]) ? null : $data[3];
        $time_out = empty($data[4]) ? null : $data[4];
        $break_in = empty($data[5]) ? null : $data[5];
        $break_out = empty($data[6]) ? null : $data[6];
        // $time_out               = $data[4];
        // $break_in                = $data[5];
        // $break_out               = $data[6];
        $current_date           = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_records_advance SET edit_date=?, time_in=?, time_out=?, break_in = ?, break_out = ? WHERE id=?";
        $this->db->query($sql, array($current_date, $time_in, $time_out, $break_in, $break_out, $id));
        return $this->db->affected_rows();
    }
    function edit_attendance_record($data)
    {
        $id                     = $data[0];
        // $time_in                = $data[3];
        $time_in = empty($data[3]) ? null : $data[3];
        $time_out = empty($data[4]) ? null : $data[4];
        $break_in = empty($data[5]) ? null : $data[5];
        $break_out = empty($data[6]) ? null : $data[6];
        // $time_out               = $data[4];
        // $break_in                = $data[5];
        // $break_out               = $data[6];
        $current_date           = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_records SET edit_date=?, time_in=?, time_out=?, break_in = ?, break_out = ? WHERE id=?";
        $this->db->query($sql, array($current_date, $time_in, $time_out, $break_in, $break_out, $id));
        return $this->db->affected_rows();
    }
    function GET_ALL_ATTENDANCE_RECORD_OLD($empl_id, $start_date, $end_date)
    {
        $sql = "SELECT id,empl_id,date,time_in,time_out,break_in,break_out FROM tbl_attendance_records WHERE empl_id=? AND date=? ORDER BY id DESC";
        $query = $this->db->query($sql, array($empl_id, $start_date));
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_ATTENDANCE_RECORD($empl_id, $start_date, $end_date)
    {
        $sql = "SELECT id, empl_id, date, time_in, time_out 
                FROM tbl_attendance_records 
                WHERE empl_id=? AND date BETWEEN ? AND ? 
                ORDER BY id DESC";
        $query = $this->db->query($sql, array($empl_id, $start_date, $end_date));
        $query->next_result();
        return $query->result();
    }
    function GET_FOR_ADD_ATTENDANCE_RECORD_ADVANCE($empl_id, $start_date, $end_date)
    {
        $sql0 = "SELECT * FROM tbl_zkteco_code where empl_id=?";
        $query0 = $this->db->query($sql0, array($empl_id));
        $emp_code = null;
        $result0 = $query0->row();
        // return $result0 ;
        if ($result0 && property_exists($result0, 'empl_code')) {
            $emp_code = $result0->empl_code;
            // return $emp_code; 
        }
        $sql = "SELECT tb6.id,tb0.date, tb1.empl_id,tb2.time_regular_start,tb2.time_regular_end,tb3.time_in as remote_in,tb3.time_out as remote_out,
        SUBSTRING(TIME(tb4.punch_time), 1, 8) as zkteco_in,SUBSTRING(TIME(tb5.punch_time), 1, 8)as zkteco_out,
        tb6.time_in as advance_in,tb6.time_out as advance_out
        FROM tbl_dates as tb0
        LEFT JOIN tbl_attendance_shiftassign as tb1 ON tb0.date = tb1.date AND tb1.empl_id = ?
        LEFT JOIN tbl_attendance_shifts as tb2 ON tb1.shift_id = tb2.id
        LEFT JOIN tbl_attendance_records as tb3 ON tb0.date = tb3.date
        LEFT JOIN tbl_zkteco as tb4 ON tb0.date = DATE(tb4.punch_time) AND tb4.punch_state = 0  AND tb4.emp_code = ?
        LEFT JOIN tbl_zkteco as tb5 ON tb0.date = DATE(tb5.punch_time) AND tb5.punch_state = 1  AND tb5.emp_code = ?
        LEFT JOIN tbl_attendance_records_advance as tb6 ON tb0.date = tb6.date
        WHERE tb0.date BETWEEN ? AND ?
        ORDER BY tb0.date DESC";
        $query = $this->db->query($sql, array($empl_id, $emp_code, $emp_code, $start_date, $end_date));
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_ATTENDANCE_RECORD_ADVANCE($empl_id, $start_date, $end_date)
    {
        $sql = "SELECT id, empl_id, date, time_in, time_out
                FROM tbl_attendance_records_advance 
                WHERE empl_id=? AND date BETWEEN ? AND ? 
                ORDER BY id DESC";
        $query = $this->db->query($sql, array($empl_id, $start_date, $end_date));
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIFIC_LEAVE_ASSIGN($startDate, $endDate)
    {
        $sql = "SELECT type, empl_id, leave_date, duration FROM tbl_leaves_assign WHERE status = 'Approved' AND leave_date BETWEEN ? AND ? ORDER BY id";
        $query = $this->db->query($sql, array($startDate, $endDate));
        $query->next_result();
        return $query->result();
    }
    function GET_COMP_STRUCTURE()
    {
        $sql = "SELECT * FROM tbl_system_setup";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
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
    function GET_CLUBHOUSE()
    {
        $sql = "SELECT id,name FROM tbl_std_clubhouse";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SECTIONS()
    {
        $sql = "SELECT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_RESIGNATION_REASONS()
    {
        $sql = "SELECT id,name FROM tbl_std_resignationtypes ORDER BY name";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_TERMINATION_REASONS()
    {
        $sql = "SELECT id,name FROM tbl_std_terminationtypes ORDER BY name";
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
    function GET_LINES()
    {
        $sql = "SELECT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_COMPANIES()
    {
        $sql = "SELECT id,name FROM tbl_std_companies";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEMENT_TYPES()
    {
        $sql = "SELECT id,name FROM tbl_std_employeetypes";
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
    function GET_EMPLOYEELIST_DAILY_ALL($branch, $dept, $division, $clubhouse, $section, $group, $team, $line, $company, $type)
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
        if ($clubhouse  == "all") {
            $clubhouse   = "col_empl_club";
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
        if ($company   == "all") {
            $company    = "col_empl_company";
        }
        if ($type   == "all") {
            $type    = "col_empl_type";
        }
        $sql = "SELECT id, col_empl_cmid, 
        CONCAT_WS(
            '', 
            COALESCE(col_last_name, ''), 
            CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END, ', ',
            COALESCE(col_frst_name, ''), 
            CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS fullname
         FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND col_empl_branch  = $branch
        AND col_empl_dept    = $dept
        AND col_empl_divi    = $division
        -- AND col_empl_club    = $clubhouse
        AND col_empl_sect    = $section
        AND col_empl_group   = $group
        AND col_empl_team    = $team
        AND col_empl_line    = $line
        AND col_empl_company = $company
        AND col_empl_type = $type
        ORDER BY col_empl_cmid ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEELIST_DAILY($offset, $row, $branch, $dept, $division, $section, $group, $team, $line, $company, $type)
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
        if ($company   == "all") {
            $company    = "col_empl_company";
        }
        if ($type   == "all") {
            $type    = "col_empl_type";
        }
        $sql = "SELECT id, col_empl_cmid, CONCAT(col_last_name,', ',col_frst_name) as fullname FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND col_empl_branch  = $branch
        AND col_empl_dept    = $dept
        AND col_empl_divi    = $division
        AND col_empl_sect    = $section
        AND col_empl_group   = $group
        AND col_empl_team    = $team
        AND col_empl_line    = $line
        AND col_empl_company = $company
        AND col_empl_type = $type
        ORDER BY col_empl_cmid ASC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEELIST_DAILY_COUNT($branch, $dept, $division, $clubhouse, $section, $group, $team, $line, $company, $type)
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
        if ($clubhouse  == "all") {
            $clubhouse   = "col_empl_club";
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
        if ($company   == "all") {
            $company    = "col_empl_company";
        }
        if ($type   == "all") {
            $type    = "col_empl_type";
        }
        $sql = "SELECT id, col_empl_cmid, CONCAT(col_last_name,', ',col_frst_name) as fullname FROM tbl_employee_infos WHERE  termination_date IS NULL AND disabled=0
        AND col_empl_branch  = $branch
        AND col_empl_dept    = $dept
        AND col_empl_divi    = $division
        AND col_empl_club    = $clubhouse
        AND col_empl_sect    = $section
        AND col_empl_group   = $group
        AND col_empl_team    = $team
        AND col_empl_line    = $line
        AND col_empl_company = $company
        AND col_empl_type = $type
        ORDER BY col_empl_cmid ASC ";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function GET_EMPLOYEELIST_COUNT()
    {
        $sql = "SELECT id FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function GET_WITH_SHIFT($date)
    {
        $sql = "SELECT * FROM tbl_attendance_shiftassign WHERE date=?";
        $query = $this->db->query($sql, $date);
        // return $query->num_rows();
        $query->next_result();
        return $query->result();
    }
    function GET_WITH_SHIFT_COUNT($date)
    {
        $sql = "SELECT id FROM tbl_attendance_shiftassign WHERE date='$date'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function GET_ATTENDANCE_REMOTE_TODAY_DATA($date)
    {
        $sql = "SELECT date, empl_id, time_in, time_out, time_in_address, time_out_address, snapshot_in, snapshot_out, break_in, break_out, break_in_address, break_out_address, break_in_snapshot, break_out_snapshot
                FROM tbl_attendance_records WHERE  date=?";
        $query = $this->db->query($sql, $date);
        $query->next_result();
        return $query->result();
    }
    function GET_ATTENDANCE($id)
    {
        $this->db->select("tb1.id,tb1.empl_id,tb1.time_in,tb1.time_out,tb3.time_regular_start,tb3.time_regular_end");
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb4.col_last_name IS NOT NULL AND tb4.col_last_name != '' THEN CONCAT(tb4.col_last_name) ELSE '' END,  
        CASE WHEN tb4.col_suffix IS NOT NULL AND tb4.col_suffix != '' THEN CONCAT(' ', tb4.col_suffix) ELSE '' END,
        CASE WHEN tb4.col_frst_name IS NOT NULL AND tb4.col_frst_name != '' THEN CONCAT(', ', tb4.col_frst_name) ELSE '' END,
        CASE WHEN tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name != '' THEN CONCAT(' ', LEFT(tb4.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    function GET_ZKTECO_ATTENDANCE_RECORD_TODAY_DATA($date)
    {
        $sql = "SELECT empl_id, punch_time, punch_state  FROM tbl_zkteco
            LEFT JOIN tbl_zkteco_code ON tbl_zkteco.emp_code = tbl_zkteco_code.empl_code
            WHERE DATE(tbl_zkteco.punch_time)=?";
        $query = $this->db->query($sql, array($date));
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIFIC_LEAVE_ASSIGN_TODAY($date)
    {
        $sql = "SELECT type, empl_id, leave_date, duration FROM tbl_leaves_assign WHERE status = 'Approved' AND leave_date=? ORDER BY id";
        $query = $this->db->query($sql, array($date));
        $query->next_result();
        return $query->result();
    }
    function GET_ATTENDANCE_EMPLOYEES_SHIFT_TODAY($date)
    {
        $sql =  "SELECT tb2.code, tb1.date,tb1.empl_id,  tb2.time_regular_start,  tb2.time_regular_end, tb2.time_regular_reg FROM  tbl_attendance_shiftassign AS tb1 INNER JOIN  tbl_attendance_shifts AS tb2 ON  tb2.id = tb1.shift_id  
        WHERE tb1.date = ?";
        $query = $this->db->query($sql, array($date));
        $query->next_result();
        return $query->result();
    }
    function insert_benefits_column($benefits_val)
    {
        $current_date = date('Y-m-d H:i:s');
        $att_lock_id = $benefits_val['att_lock_id'];
        $type = $benefits_val['type'];
        $value = $benefits_val['value'];
        $is_duplicate = $this->is_duplicate_attendance_lock_id($att_lock_id, $type);
        if ($is_duplicate > 0) {
            $sql = "UPDATE tbl_attendance_records_lock_benefits SET edit_date=?, value=? WHERE attendance_lock_id=? AND type=?";
            $query = $this->db->query($sql, array($current_date, $value, $att_lock_id, $type));
        } else {
            $sql = "INSERT INTO tbl_attendance_records_lock_benefits (create_date, edit_date, attendance_lock_id, type, value) VALUES (?, ?, ?, ?, ?)";
            $query = $this->db->query($sql, array($current_date, $current_date, $att_lock_id, $type, $value));
        }
    }

    function upload_attendance_summary($data, $cutOffVal)
    {
        $empl_id                = $data[0];
        $cmid                   = $data[2];
        $employee_name          = $data[3];
        $abs                    = $data[4];
        $lwop                   = $data[5];
        // $awol                   = $data[6];
        $tard                   = $data[6];
        $ut                     = $data[7];
        $leave                  = $data[8];
        $offset                 = $data[9];

        $reg_hr                 = $data[10];
        $reg_ot                 = $data[11];
        $reg_nd                 = $data[12];
        $reg_ndot               = $data[13];

        $res_hr                 = $data[14];
        $res_ot                 = $data[15];
        $res_nd                 = $data[16];
        $res_ndot               = $data[17];

        $leg_hr                 = $data[18];
        $leg_ot                 = $data[19];
        $leg_nd                 = $data[20];
        $leg_ndot               = $data[21];

        $sp_hr                  = $data[22];
        $sp_ot                  = $data[23];
        $sp_nd                  = $data[24];
        $sp_ndot                = $data[25];

        $night_meal             = $data[26];
        $spe_meal               = $data[27];
        $present                = $data[28];
        $birthday_leave         = $data[29];

        $is_duplicate = $this->is_duplicate_attendance_records_lock($empl_id, $cutOffVal);

        if ($is_duplicate > 0) {
            $create_date = date('Y-m-d H:i:s');
            $sql = "UPDATE tbl_attendance_records_lock SET edit_date=? ,absent=?, lwop=?, tardiness=?, undertime=?, paid_leave=?, reg_hours=?, `offset`=?, reg_ot=?, reg_nd=?, reg_ndot=?, 
            rest_hours=?, rest_ot=?, rest_nd=?, rest_ndot=?, leg_hours=?, leg_ot=?, leg_nd=?, leg_ndot=?, spe_hours=?, spe_ot=?, spe_nd=?, spe_ndot=?, night_meal = ?, spe_meal = ?, present = ?, birthday_leave = ?
            WHERE empl_id=? AND period=?";
            $query = $this->db->query($sql, array(
                $create_date, $abs, $lwop, $tard, $ut, $leave, $reg_hr, $offset, $reg_ot, $reg_nd, $reg_ndot, $res_hr, $res_ot, $res_nd, $res_ndot, $leg_hr, $leg_ot, $leg_nd, $leg_ndot,
                $sp_hr, $sp_ot, $sp_nd, $sp_ndot,$night_meal,$spe_meal,$present, $birthday_leave, $empl_id, $cutOffVal
            ));
        } else {
            $create_date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO tbl_attendance_records_lock (create_date, edit_date, empl_id, period, absent, lwop, tardiness, undertime, paid_leave, reg_hours,  `offset`, reg_ot, reg_nd, reg_ndot, rest_hours, rest_ot, rest_nd, 
            rest_ndot, leg_hours, leg_ot, leg_nd, leg_ndot,spe_hours, spe_ot, spe_nd, spe_ndot, night_meal, spe_meal, present, birthday_leave) 
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $this->db->query($sql, array(
                $create_date, $create_date, $empl_id, $cutOffVal, $abs, $lwop, $tard, $ut, $leave, $reg_hr, $offset, $reg_ot, $reg_nd, $reg_ndot, $res_hr, $res_ot, $res_nd, $res_ndot, $leg_hr, $leg_ot, $leg_nd, $leg_ndot,
                $sp_hr, $sp_ot, $sp_nd, $sp_ndot, $night_meal, $spe_meal, $present, $birthday_leave
            ));
            // return $this->db->insert_id();
        }
    }

    function upload_data($data, $cutOffVal)
    {
        $empl_id                = $data['id'];
        $present                = $data['DAYS'];
        $AWOL                   = $data['AWOL'];
        $PAID                   = $data['PAID'];
        $TARD                   = $data['TARD'];
        $UT                     = $data['UT'];
        $REG_REG                = $data['REG REG'];
        $REG_OT                 = $data['REG OT'];
        $REG_ND                 = $data['REG ND'];
        $REG_NDOT               = $data['REG NDOT'];
        $RST_REG                = $data['RST REG'];
        $RST_OT                 = $data['RST OT'];
        $RST_ND                 = $data['RST ND'];
        $RST_NDOT               = $data['RST NDOT'];
        $LEG_REG                = $data['LEG REG'];
        $LEG_OT                 = $data['LEG OT'];
        $LEG_ND                 = $data['LEG ND'];
        $LEG_NDOT               = $data['LEG NDOT'];
        $RST_LEG_REG            = $data['RST+LEG REG'];
        $RST_LEG_OT             = $data['RST+LEG OT'];
        $RST_LEG_ND             = $data['RST+LEG ND'];
        $RST_LEG_NDOT           = $data['RST+LEG NDOT'];
        $SPE_REG                = $data['SPE REG'];
        $SPE_OT                 = $data['SPE OT'];
        $SPE_ND                 = $data['SPE ND'];
        $SPE_NDOT               = $data['SPE NDOT'];
        $RST_SPE_REG            = $data['RST+SPE REG'];
        $RST_SPE_OT             = $data['RST+SPE OT'];
        $RST_SPE_ND             = $data['RST+SPE ND'];
        $RST_SPE_NDOT           = $data['RST+SPE NDOT'];
        // $RICE_SUBSIDY           = $data['RICE SUBSIDY'];
        $is_duplicate = $this->is_duplicate_attendance_records_lock($empl_id, $cutOffVal);
        if ($is_duplicate > 0) {
            $create_date = date('Y-m-d H:i:s');
            $sql = "UPDATE tbl_attendance_records_lock SET edit_date=?, present=? ,absent=?, tardiness=?, undertime=?, paid_leave=?, reg_hours=?, reg_ot=?, reg_nd=?, reg_ndot=?, 
            rest_hours=?, rest_ot=?, rest_nd=?, rest_ndot=?, leg_hours=?, leg_ot=?, leg_nd=?, leg_ndot=?, legrest_hours=?, legrest_ot=?, legrest_nd=?, legrest_ndot=?, 
            spe_hours=?, spe_ot=?, spe_nd=?, spe_ndot=?, sperest_hours=?, sperest_ot=?, sperest_nd=?, sperest_ndot=?
            WHERE empl_id=? AND period=?";
            $query = $this->db->query($sql, array(
                $create_date,
                $present,
                $AWOL,
                $TARD,
                $UT,
                $PAID,
                $REG_REG,
                $REG_OT,
                $REG_ND,
                $REG_NDOT,
                $RST_REG,
                $RST_OT,
                $RST_ND,
                $RST_NDOT,
                $LEG_REG,
                $LEG_OT,
                $LEG_ND,
                $LEG_NDOT,
                $RST_LEG_REG,
                $RST_LEG_OT,
                $RST_LEG_ND,
                $RST_LEG_NDOT,
                $SPE_REG,
                $SPE_OT,
                $SPE_ND,
                $SPE_NDOT,
                $RST_SPE_REG,
                $RST_SPE_OT,
                $RST_SPE_ND,
                $RST_SPE_NDOT,
                $empl_id,
                $cutOffVal
            ));
            // Fetch the updated record to get the ID
            $selectSql = "SELECT id FROM tbl_attendance_records_lock WHERE empl_id=? AND period=?";
            $query = $this->db->query($selectSql, array($empl_id, $cutOffVal));
            $result = $query->row();
            if ($result) {
                $updatedId = $result->id;
                return $updatedId;
            } else {
                return null;
            }
        } else {
            $create_date = date('Y-m-d H:i:s');
            $sql = "INSERT INTO tbl_attendance_records_lock (create_date, edit_date, empl_id, period, present, absent, tardiness, undertime, paid_leave, reg_hours, reg_ot, reg_nd, reg_ndot, rest_hours, rest_ot, rest_nd, rest_ndot, leg_hours, leg_ot, leg_nd, leg_ndot, 
            legrest_hours, legrest_ot, legrest_nd, legrest_ndot, spe_hours, spe_ot, spe_nd, spe_ndot, sperest_hours, sperest_ot, sperest_nd, sperest_ndot) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $this->db->query($sql, array(
                $create_date,
                $create_date,
                $empl_id,
                $cutOffVal,
                $present,
                $AWOL,
                $TARD,
                $UT,
                $PAID,
                $REG_REG,
                $REG_OT,
                $REG_ND,
                $REG_NDOT,
                $RST_REG,
                $RST_OT,
                $RST_ND,
                $RST_NDOT,
                $LEG_REG,
                $LEG_OT,
                $LEG_ND,
                $LEG_NDOT,
                $RST_LEG_REG,
                $RST_LEG_OT,
                $RST_LEG_ND,
                $RST_LEG_NDOT,
                $SPE_REG,
                $SPE_OT,
                $SPE_ND,
                $SPE_NDOT,
                $RST_SPE_REG,
                $RST_SPE_OT,
                $RST_SPE_ND,
                $RST_SPE_NDOT
            ));
            return $this->db->insert_id();
        }
    }
    function is_duplicate_attendance_records_lock($empl_id, $cutOffVal)
    {
        $sql = "SELECT * FROM tbl_attendance_records_lock WHERE empl_id=? AND period=? ";
        $query = $this->db->query($sql, array($empl_id, $cutOffVal));
        return $query->num_rows();
    }
    function is_duplicate_attendance_lock_id($id, $type)
    {
        $sql = "SELECT * FROM tbl_attendance_records_lock_benefits WHERE attendance_lock_id=? AND type=?";
        $query = $this->db->query($sql, array($id, $type));
        return $query->num_rows();
    }
    function GET_YEARS()
    {
        $sql = "SELECT name FROM tbl_std_years WHERE status='Active' ORDER BY name DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    // function GET_ALL_HOLIDAYS($year)
    // {
    //     $this->db->select('col_holi_date,name,col_holi_type')
    //         ->where('year', $year)
    //         ->where('status', 'Active')
    //         ->order_by('id', 'ASC');
    //     $query = $this->db->get('tbl_std_holidays');
    //     return $query->result();
    // }

    function GET_ALL_HOLIDAYS($year)
    {
        $this->db->select('col_holi_date, name, col_holi_type')
            ->where('year', $year)
            ->where('status', 'Active')
            ->order_by('MONTH(col_holi_date)', 'ASC')
            ->order_by('DAY(col_holi_date)', 'ASC');
        $query = $this->db->get('tbl_std_holidays');
        return $query->result();
    }


    function GET_YEARS_ID()
    {
        $sql = "SELECT id, name FROM tbl_std_years WHERE status='Active' ORDER BY name DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function GET_SETTING_VALUE($setting)
    {
        $sql = "SELECT value FROM tbl_system_setup WHERE setting=?";
        $query = $this->db->query($sql, array($setting));
        $result = $query->row();
        if ($result) {
            return $result->value;
        } else {
            return null;
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



    function GET_ATTENDACE_SHIFT_ASSIGN($empl_id, $date)
    {
        $sql = "SELECT shift_id FROM tbl_attendance_shiftassign WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql, array($empl_id, $date));
        $result = $query->row();
        if ($result) {
            return $result->shift_id;
        } else {
            return null;
        }
    }

    function GET_ATTENDANCE_SHIFT($id)
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

    function GET_EAGLE_RIDGE_SETTING($setting)
    {
        $sql = "SELECT * FROM tbl_system_setup WHERE setting=? ";
        $query = $this->db->query($sql, array($setting));
        $result = $query->row();
        if ($result) {
            return $result->value;
        } else {
            return null;
        }
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

    function GET_EMPLOYEELIST_DATA()
    {
        $sql = "SELECT id, col_empl_cmid, CONCAT(col_last_name,', ',col_frst_name) as fullname FROM tbl_employee_infos WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 ORDER BY col_empl_cmid ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function ADD_TIME_ADJUSTMENT_REQUEST($data)
    {
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');
        $this->db->insert('tbl_attendance_adjustments', $data);
        return $this->db->insert_id();
    }

    function GET_LEAVE_ENTITLEMENT($empl_id, $current_year){
        // $current_year = '2025';
        $year_id = $this->GET_YEAR_ID($current_year);
        $type = 'Birthday Leave';
        $sql = "SELECT * FROM tbl_leave_entitlements WHERE empl_id=? AND year=? AND type=? ";
        $query = $this->db->query($sql, array($empl_id, $year_id, $type));
        $result = $query->row();
        if($result){
            return $result->value;
        }else{
            return null;
        }
    }

    function GET_YEAR_ID($year_name){
        $sql = "SELECT id FROM tbl_std_years WHERE name = ?";
        $query = $this->db->query($sql, array($year_name));
        $result = $query->row();
        if($result){
            return $result->id;
        }else{
            return null;
        }
    }

    function GET_EMPLOYEE_BDAY($id){
        $sql = "SELECT col_birt_date FROM tbl_employee_infos WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if($result){
            return $result->col_birt_date;
        }else{
            return null;
        }
    }

    function GET_CUTOFF_PERIOD_MONTH($id){
        $sql = "SELECT date_from, date_to  FROM tbl_payroll_period WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if($result){
            return $result->date_from;
        }else{
            return null;
        }
    }

    function CHECK_APPROVED_BDAY_LEAVE($empl_id, $current_year_month, $status, $type) {
        // Split the Y-m into year and month
        list($year, $month) = explode('-', $current_year_month);
    
        $sql = "SELECT 1 FROM tbl_leaves_assign WHERE empl_id = ? 
                  AND YEAR(leave_date) = ? 
                  AND MONTH(leave_date) = ? 
                  AND status = ? 
                  AND type = ?";
    
        $query = $this->db->query($sql, array($empl_id, $year, $month, $status, $type));
    
        return $query->num_rows(); // Returns 0 if not found, 1 or more if found
    }

    function GET_PERIOD_CONNECTED($period)
    {
        if (empty($period) || $period == 'undefined') {
            return [];
        }
        $sql   = "SELECT connected_period FROM tbl_payroll_period WHERE id = $period";
        $query = $this->db->query($sql, array());
        return $query->row();
    }

    function GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $period)
    {
        $sql = "SELECT COUNT_ABSENT FROM tbl_payroll_payslips WHERE empl_id = ? AND PAYSLIP_PERIOD = ?";
        $query = $this->db->query($sql, array($empl_id, $period));
        $result = $query->row();

        return is_object($result) ? $result->COUNT_ABSENT : null;
    }

    function GET_PREV_CUTOFF_PERIOD($date_to, $status){
        $sql = "SELECT id FROM tbl_payroll_period WHERE date_to=? AND status=?";
        $query = $this->db->query($sql, array($date_to, $status));
        $result = $query->row();
        if($result){
            return $result->id;
        }else{
            return null;
        }
    }


    function GET_PREV_SHIFT($empl_id, $date){
        
        $sql = "SELECT tb1.shift_id, tb2.code FROM tbl_attendance_shiftassign AS tb1
        LEFT JOIN tbl_attendance_shifts AS tb2 ON tb1.shift_id=tb2.id
        WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql, array($empl_id, $date));
        $result = $query->row();
        if($result){
            return $result;
        }else{
            return null;
        }
    }

    function GET_WORKINGDAYS($empl_id){
        $sql = "SELECT days FROM tbl_employee_work_days
        WHERE empl_id=?";
        $query = $this->db->query($sql, array($empl_id));
        $result = $query->row();
        if($result){
            return $result;
        }else{
            return null;
        }
    }

    function GET_EMPLOYEE_INFOS($empl_id){
        $sql = "SELECT salary_rate, salary_type FROM tbl_employee_infos
        WHERE id=?";
        $query = $this->db->query($sql, array($empl_id));
        $result = $query->row();
        if($result){
            return $result;
        }else{
            return null;
        }
    }









}
