<?php
class employees_model extends CI_Model
{

    function get_settings_table($table, $filter, $selectColumns)
    {
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
    function get_settings_table_by_order($table, $filter, $selectColumns, $order)
    {
        $query = $this->db
            ->where('is_deleted', 0)
            ->order_by($order['name'], $order['value']);
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
    function GET_EMPLOYEE_FENCES($offset, $row, $branch, $dept, $division, $clubhouse, $section, $group, $team, $line, $search)
    {
        $this->db->select("tb1.id,
        CONCAT_WS('', 
        CONCAT(tb1.col_empl_cmid, '-', tb1.col_last_name), 
        CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix <> '' THEN CONCAT(' ',tb1.col_suffix) ELSE '' END,
        CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name <> '' THEN CONCAT(', ',tb1.col_frst_name) ELSE '' END, 
        CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name <> '' THEN CONCAT(' ',LEFT(tb1.col_midl_name,1), '.') ELSE '' END)
        as employee,tb2.fences", FALSE);
        $this->db->from('tbl_employee_infos as tb1');
        $this->db->join('tbl_employee_fences as tb2', 'tb1.id=tb2.empl_id', 'left');
        if ($branch != "all") {
            $this->db->where("tb1.col_empl_branch", $branch);
        }
        if ($dept != "all") {
            $this->db->where("tb1.col_empl_dept", $dept);
        }
        if ($division != "all") {
            $this->db->where("tb1.col_empl_divi", $division);
        }
        if ($clubhouse != "all") {
            $this->db->where("tb1.col_empl_club", $clubhouse);
        }
        if ($clubhouse != "all") {
            $this->db->where("tb1.col_empl_club", $clubhouse);
        }
        if ($section != "all") {
            $this->db->where('tb1.col_empl_sect', $section);
        }
        if ($group != "all") {
            $this->db->where('tb1.col_empl_group', $group);
        }
        if ($team != "all") {
            $this->db->where('tb1.col_empl_team', $team);
        }
        if ($line != "all") {
            $this->db->where('tb1.col_empl_line', $line);
        }
        if ($search != "all") {
            $this->db->where('tb1.id', $search);
        }
        $this->db->limit($row, $offset);
        $this->db->order_by("tb1.col_empl_cmid + 0 ASC");
        $query = $this->db->get();
        return $query->result();
    }
    function get_custom_groups_assignment($offset, $row, $branch, $dept, $division, $clubhouse, $section, $group, $team, $line, $company, $id)
    {
        $conditions = array();
        $params = array();
        if ($branch != "all") {
            $conditions[] = "tb1.col_empl_branch = ?";
            $params[] = $branch;
        }
        if ($dept != "all") {
            $conditions[] = "tb1.col_empl_dept = ?";
            $params[] = $dept;
        }
        if ($division != "all") {
            $conditions[] = "tb1.col_empl_divi = ?";
            $params[] = $division;
        }
        if ($clubhouse != "all") {
            $conditions[] = "tb1.col_empl_club = ?";
            $params[] = $clubhouse;
        }
        if ($section != "all") {
            $conditions[] = "tb1.col_empl_sect = ?";
            $params[] = $section;
        }
        if ($group != "all") {
            $conditions[] = "tb1.col_empl_group = ?";
            $params[] = $group;
        }
        if ($team != "all") {
            $conditions[] = "tb1.col_empl_team = ?";
            $params[] = $team;
        }
        if ($line != "all") {
            $conditions[] = "tb1.col_empl_line = ?";
            $params[] = $line;
        }
        if ($company != "all") {
            $conditions[] = "tb1.col_empl_company = ?";
            $params[] = $company;
        }
        if ($id != "all") {
            $conditions[] = "tb1.id = ?";
            $params[] = $id;
        }

        $whereClause = implode(" AND ", $conditions);

        $sql = "SELECT tb1.id,
        CONCAT_WS('', 
        CONCAT(tb1.col_empl_cmid, '-', tb1.col_last_name), 
        CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix <> '' THEN CONCAT(' ',tb1.col_suffix) ELSE '' END,
        CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name <> '' THEN CONCAT(', ',tb1.col_frst_name) ELSE '' END, 
        CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name <> '' THEN CONCAT(' ',LEFT(tb1.col_midl_name,1), '.') ELSE '' END)
        as employee,
        GROUP_CONCAT(t3.name) AS groups
        FROM  tbl_employee_infos AS tb1
        LEFT JOIN tbl_custom_group_assignments AS t2 ON tb1.id = t2.empl_id AND t2.is_checked=1
        LEFT JOIN tbl_std_custom_groups AS t3 ON t2.custom_group_id = t3.id
        WHERE (tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00') AND tb1.disabled = 0 
        " . ($whereClause ? "AND $whereClause" : "") . "
        GROUP BY tb1.col_empl_cmid
        ORDER BY tb1.col_empl_cmid + 0 ASC
        LIMIT ?, ?";

        $params[] = intval($offset);
        $params[] = intval($row);

        $query = $this->db->query($sql, $params);
        // $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function update_custom_groups($empl_id, $group, $value, $userId)
    {
        $this->db->select('id');
        $this->db->where('name', $group);
        $query = $this->db->get('tbl_std_custom_groups');
        if ($query->num_rows() < 1) {
            return false;
        }
        $row = $query->row();
        $groupid = $row->id;
        $currentDateTime = date('Y-m-d H:i:s');
        $data = array('is_checked' => $value);
        $this->db->where('empl_id', $empl_id);
        $this->db->where('custom_group_id', $groupid);
        $this->db->update('tbl_custom_group_assignments', array('is_checked' => $value, 'edit_date' => $currentDateTime, 'edit_user' => $userId));
        if ($this->db->affected_rows() == 0) {
            $data = array('empl_id' => $empl_id, 'custom_group_id' => $groupid, 'is_checked' => $value, 'edit_date' => $currentDateTime, 'edit_user' => $userId);
            $this->db->insert('tbl_custom_group_assignments', $data);
        }
    }
    function get_custom_groups_assignment_count($offset, $row, $branch, $dept, $division, $clubhouse, $section, $group, $team, $line, $company, $id)
    {
        $conditions = array();
        $params = array();
        if ($branch != "all") {
            $conditions[] = "tb1.col_empl_branch = ?";
            $params[] = $branch;
        }
        if ($dept != "all") {
            $conditions[] = "tb1.col_empl_dept = ?";
            $params[] = $dept;
        }
        if ($division != "all") {
            $conditions[] = "tb1.col_empl_divi = ?";
            $params[] = $division;
        }
        if ($clubhouse != "all") {
            $conditions[] = "tb1.col_empl_club = ?";
            $params[] = $clubhouse;
        }
        if ($section != "all") {
            $conditions[] = "tb1.col_empl_sect = ?";
            $params[] = $section;
        }
        if ($group != "all") {
            $conditions[] = "tb1.col_empl_group = ?";
            $params[] = $group;
        }
        if ($team != "all") {
            $conditions[] = "tb1.col_empl_team = ?";
            $params[] = $team;
        }
        if ($line != "all") {
            $conditions[] = "tb1.col_empl_line = ?";
            $params[] = $line;
        }
        if ($company != "all") {
            $conditions[] = "tb1.col_empl_company = ?";
            $params[] = $company;
        }
        if ($id != "all") {
            $conditions[] = "tb1.id = ?";
            $params[] = $id;
        }

        $whereClause = implode(" AND ", $conditions);

        $sql = "SELECT tb1.id,
        CONCAT_WS('', 
        CONCAT(tb1.col_empl_cmid, '-', tb1.col_last_name), 
        CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix <> '' THEN CONCAT(' ',tb1.col_suffix) ELSE '' END,
        CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name <> '' THEN CONCAT(', ',tb1.col_frst_name) ELSE '' END, 
        CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name <> '' THEN CONCAT(' ',LEFT(tb1.col_midl_name,1), '.') ELSE '' END)
        as employee,
        GROUP_CONCAT(t3.name) AS groups
        FROM  tbl_employee_infos AS tb1
        LEFT JOIN tbl_custom_group_assignments AS t2 ON tb1.id = t2.empl_id AND t2.is_checked=1
        LEFT JOIN tbl_std_custom_groups AS t3 ON t2.custom_group_id = t3.id
        WHERE (tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00') AND tb1.disabled = 0
        " . ($whereClause ? "AND $whereClause" : "") . "
        GROUP BY tb1.col_empl_cmid";

        $query = $this->db->query($sql, $params);
        $query->next_result();
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function GET_EMPLOYEE_TYPES()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            // ->order_by('id', 'DESC')
            ->get('tbl_std_employeetypes');
        return $query->result();
    }

    function update_system_setup($settings)
    {
        try {
            foreach ($settings as $key => $value) {
                $this->db->set('value', $value);
                $this->db->where('setting', $key);
                $this->db->update('tbl_system_setup');
            }
            return true;
        } catch (Exception $e) {
            return false;
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

    function GET_REQUIREMENTS()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_requirements');
        return $query->result();
    }

    function update_employees_type($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_employeetypes (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_employeetypes SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }
    function update_requirements($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_requirements (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_requirements SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_POSITIONS_TYPES()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_positions');
        return $query->result();
    }
    function update_positions($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_positions (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_positions SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }
    function GET_COMPANIES2()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_companies');
        return $query->result();
    }
    function update_companies($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_companies (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_companies SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }
    function update_custom_informations($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_custominfo (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_custominfo SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }
    function GET_BRANCHES_TYPES()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_branches');
        return $query->result();
    }
    function update_branches($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_branches (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_branches SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_DEPARTMENTS2()
    {
        $query =  $this->db
            ->select('id, name, status, min_hours')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_departments');
        return $query->result();
    }

    function update_departments($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $min_hours      = $data['min_hours'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_departments (create_date, edit_date, edit_user, min_hours, name, status) VALUES (?,?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status, $min_hours));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_departments SET edit_date=?, edit_user=?, name=?, status=?, min_hours=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $min_hours, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_DIVISIONS2()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_divisions');
        return $query->result();
    }
    function update_divisions($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_divisions (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_divisions SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_CLUBHOUSE2()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_clubhouse');
        return $query->result();
    }

    function update_clubhouse($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_clubhouse (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_clubhouse SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_SECTIONS2()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_sections');
        return $query->result();
    }
    function update_sections($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_sections (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_sections SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_GROUPS2()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_groups');
        return $query->result();
    }
    function update_groups($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_groups (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_groups SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_TEAMS2()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_teams');
        return $query->result();
    }
    function update_teams($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_teams (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_teams SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_LINES2()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_lines');
        return $query->result();
    }
    function update_lines($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_lines (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_lines SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_MARITAL_STATUSES()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_maritalstatuses');
        return $query->result();
    }
    function update_marital_statuses($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_maritalstatuses (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_maritalstatuses SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_GENDERS2()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_genders');
        return $query->result();
    }
    function update_genders($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_genders (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_genders SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_NATIONALITIES()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_nationalities');
        return $query->result();
    }
    function update_nationalities($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_nationalities (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_nationalities SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_RELIGIONS()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_religions');
        return $query->result();
    }
    function update_religions($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_religions (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_religions SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_BLOOD_TYPES()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_bloodtypes');
        return $query->result();
    }
    function update_blood_types($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_bloodtypes (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_bloodtypes SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_HMOS()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_hmos');
        return $query->result();
    }
    function update_hmos($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_hmos (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_hmos SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_SHIRT_SIZES()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_shirtsizes');
        return $query->result();
    }
    function update_shirt_sizes($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_shirtsizes (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_shirtsizes SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_BANKS()
    {
        $query =  $this->db
            ->select('id, name, status')
            ->where('is_deleted', 0)
            // ->where('id >=', 5)
            ->order_by('id', 'DESC')
            ->get('tbl_std_banks');
        return $query->result();
    }
    function update_banks($data, $edit_user)
    {
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if ($id == 0) {
            $sql = "INSERT INTO tbl_std_banks (create_date, edit_date, edit_user, name, status) VALUES (?,?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $edit_user, $name, $status));
            if ($query) {
                return "inserted";
            } else {
                return "failedUpdate";
            }
        } else {
            $sql = "UPDATE tbl_std_banks SET edit_date=?, edit_user=?, name=?, status=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $id));
            if ($query) {
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_EMPLOYEE_SPECIFIC($employee_id)
    {
        $sql   = "SELECT * FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEE_SPECIFIC_NAME($employee_id)
    {
        $sql   = "SELECT CONCAT_WS('',COALESCE(col_empl_cmid, ''), 
        CASE WHEN col_last_name IS NOT NULL AND col_last_name != '' THEN CONCAT('-', col_last_name) ELSE '' END,
        CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS employee FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'maiya_reset'";
        return $this->db->query($query)->row_array();
    }

    function GET_DEPENDENTS_SPECIFIC($employee_id)
    {
        $sql   = "SELECT * FROM tbl_employee_dependents WHERE col_depe_empid=? AND is_deleted='0' ORDER BY col_depe_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function GET_DEPENDENTS()
    {
        $sql   = "SELECT * FROM tbl_employee_dependents";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_EMERGENCY()
    {
        $sql   = "SELECT * FROM tbl_employee_emergency ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_DOCUMENTS()
    {
        $sql   = "SELECT * FROM tbl_employee_documents";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

 

    function getRequirementsCountNotDone($empl_id)
    {
        $sql = "SELECT COUNT(tb1.id) AS count
        FROM tbl_std_requirements AS tb1
        WHERE
            tb1.status = 'Active'";
        $query = $this->db->query($sql);
        $result = $query->row();
        $requirementsTotal = $result->count;

        $sql = "SELECT COUNT(tb1.id) AS count
        FROM tbl_std_requirements AS tb1
        LEFT JOIN tbl_employee_requirements AS tb2 ON tb2.req_id = tb1.id AND tb2.empl_id = ?
        LEFT JOIN tbl_employee_infos AS tb3 ON tb3.id = tb2.empl_id
        WHERE
            tb1.status = 'Active'
            AND tb2.status = 'Done'";
        $query = $this->db->query($sql, array($empl_id, $empl_id));
        $result = $query->row();
        return $requirementsTotal - $result->count;
    }



    function GET_EMERGENCY_SPECIFIC($employee_id)
    {
        $sql   = "SELECT * FROM tbl_employee_emergency WHERE empid=? and is_deleted=0 ORDER BY name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function GET_EMERGENCY_SPECIFIC_BY_ID($id)
    {
        $sql   = "SELECT * FROM tbl_employee_emergency WHERE id=? ORDER BY name";
        $query = $this->db->query($sql, array($id));
        return $query->row_array();
    }

    function ADD_EMERGENCY_CONTACT($empl_id, $relation, $contact_name, $mobile_num, $work_phone_number, $home_phone_number, $current_address)
    {
        $sql   = "INSERT INTO tbl_employee_emergency(empid,name,relationship,mobile_number,work_phone,home_phone,current_address) VALUE(?,?,?,?,?,?,?)";
        return  $this->db->query($sql, array($empl_id, $contact_name, $relation, $mobile_num, $work_phone_number, $home_phone_number, $current_address));
    }

    function UPDATE_EMERGENCY_CONTACT($id, $empl_id, $relation, $contact_name, $mobile_num, $work_phone_number, $home_phone_number, $current_address)
    {
        $sql   = "UPDATE tbl_employee_emergency 
                SET empid=?,name=?,relationship=?,mobile_number=?,work_phone=?,home_phone=?,current_address=? WHERE id=?";
        return  $this->db->query($sql, array($empl_id, $contact_name, $relation, $mobile_num, $work_phone_number, $home_phone_number, $current_address, $id));
    }

    function DELETE_EMERGENCY_CONTACT($id)
    {
        $sql   = "UPDATE tbl_employee_emergency 
                SET is_deleted=1 WHERE id=?";
        return  $this->db->query($sql, array($id));
    }

    function GET_DOCUMENTS_SPECIFIC($employee_id)
    {
        $sql   = "SELECT * FROM tbl_employee_documents WHERE col_empl_id=? AND is_deleted=0";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function ADD_EMPL_DOCUMENT($file, $file_name, $empl_id)
    {
        $sql   = "INSERT INTO tbl_employee_documents(edit_user,col_doc_file,col_doc_name,col_empl_id) VALUE(?,?,?,?)";
        return $this->db->query($sql, array($empl_id, $file, $file_name, $empl_id));
    }
    // function ADD_EMPL_REQUIREMENTS_ATTACHMENT($attachment,$empl_id,$std_id,$requirement_id)
    // {
    //     $current_date = date('Y-m-d H:i:s');
    //     $sql   = "INSERT INTO tbl_employee_requirements(create_date,edit_date,edit_user,empl_id,is_deleted,req_id,attachment) VALUE(?,?,?,?,?,?,?)";
    //     return $this->db->query($sql, array($current_date,$current_date,$empl_id,$empl_id,0,std_id,$attachment));
    // }
    //  ADD_EMPL_REQUIREMENTS_STATUS($status,$id,$std_id,$requirement_id,$empl_id);
    function ADD_EMPL_REQUIREMENTS_STATUS($status, $id, $std_id, $empl_id)
    {
        $current_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_requirements (create_date, edit_date, edit_user, empl_id, is_deleted, req_id, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $result = $this->db->query($sql, array($current_date, $current_date, $id, $empl_id, 0, $std_id, $status));

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    function ADD_EMPL_REQUIREMENTS_ATTACHMENT($attachment, $id, $std_id, $requirement_id, $empl_id)
    {
        $current_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_requirements (create_date, edit_date, edit_user, empl_id, is_deleted, req_id, attachment) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $result = $this->db->query($sql, array($current_date, $current_date, $id, $empl_id, 0, $std_id, $attachment));

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    // function UPDATE_EMPL_REQUIREMENTS_ATTACHMENT($attachment,$requirement_id){
    //     $current_date = date('Y-m-d H:i:s');
    //     $sql   = "UPDATE tbl_employee_requirements SET create_date=?,edit_date=?,edit_user=?, attachment=? WHERE id=?";
    //     return $this->db->query($sql, array($current_date,$current_date,$attachment,$requirement_id));
    // }
    function UPDATE_EMPL_REQUIREMENTS_STATUS($status, $requirement_id, $id)
    {
        $current_date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_employee_requirements SET create_date=?, edit_date=?, edit_user=?, status=? WHERE id=?";
        $this->db->query($sql, array($current_date, $current_date, $id, $status, $requirement_id));
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function UPDATE_EMPL_REQUIREMENTS_ATTACHMENT($attachment, $requirement_id, $id)
    {
        $current_date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_employee_requirements SET create_date=?, edit_date=?, edit_user=?, attachment=? WHERE id=?";
        $this->db->query($sql, array($current_date, $current_date, $id, $attachment, $requirement_id));
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function DELETE_EMPL_DOCUMENT($id)
    {
        $sql   = "UPDATE tbl_employee_documents SET is_deleted=1 WHERE id=?";
        return $this->db->query($sql, array($id));
    }

    function GET_TYPE()
    {
        $sql   = "SELECT id,name FROM tbl_std_employeetypes WHERE status = 'Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_BRANCHES()
    {
        $sql   = "SELECT id,name FROM tbl_std_branches";
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

    function GET_DEPARTMENTS()
    {
        $sql   = "SELECT id,name FROM tbl_std_departments";
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

    function GET_CLUBHOUSE()
    {
        $sql = "SELECT id, 
                    COALESCE(name, 'No data yet') AS name, 
                    'inactive' AS status 
                FROM tbl_std_clubhouse";
        $query = $this->db->query($sql, array());
        $query->next_result();
        $results = $query->result();

        if (empty($results)) {
            return [(object) [
                'id' => null,
                'name' => 'No data yet',
                'status' => 'inactive'
            ]];
        }
        foreach ($results as $result) {
            $result->status = 'inactive';
        }
        return $results;
    }

    function GET_SECTIONS()
    {
        $sql   = "SELECT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_RESIGNATION_REASONS()
    {
        $sql   = "SELECT id,name FROM tbl_std_resignationtypes ORDER BY name";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_TERMINATION_REASONS()
    {
        $sql   = "SELECT id,name FROM tbl_std_terminationtypes ORDER BY name";
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

    function GET_EMPLOYEMENT_TYPES()
    {
        $sql   = "SELECT id,name FROM tbl_std_employeetypes";
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

    function GET_GENDERS()
    {
        $sql   = "SELECT id,name FROM tbl_std_genders";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_HMO()
    {
        $sql   = "SELECT id,name FROM tbl_std_hmos";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_CLUBHOUSES()
    {
        $sql = "SELECT id, 
                    COALESCE(name, 'No data yet') AS name, 
                    'inactive' AS status 
                FROM tbl_std_clubhouse";
        $query = $this->db->query($sql, array());
        $query->next_result();
        $results = $query->result();

        if (empty($results)) {
            return [(object) [
                'id' => null,
                'name' => 'No data yet',
                'status' => 'inactive'
            ]];
        }
        foreach ($results as $result) {
            $result->status = 'inactive';
        }
        return $results;
    }

    function GET_SHIRT_SIZE()
    {
        $sql   = "SELECT id,name FROM tbl_std_shirtsizes";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_MARITAL()
    {
        $sql   = "SELECT id,name FROM tbl_std_maritalstatuses";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_NATIONALITY()
    {
        $sql   = "SELECT id,name FROM tbl_std_nationalities";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_COMPANIES_ACTIVE()
    {
        $sql   = "SELECT id,name FROM tbl_std_companies WHERE status = 'Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_COMPANIES()
    {
        $sql   = "SELECT id,name FROM tbl_std_companies";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_BRANCHES_ACTIVE()
    {
        $sql   = "SELECT id,name FROM tbl_std_branches WHERE status = 'Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_DEPARTMENTS_ACTIVE()
    {
        $sql   = "SELECT id,name FROM tbl_std_departments WHERE status = 'Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_CLUBHOUSE_ACTIVE()
    {
        $sql   = "SELECT id,name FROM tbl_std_clubhouse WHERE status = 'Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_DIVISION_ACTIVE()
    {
        $sql   = "SELECT id,name FROM tbl_std_divisions WHERE status = 'Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_POSITION_ACTIVE()
    {
        $sql   = "SELECT id,name FROM tbl_std_positions WHERE status = 'Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_TEAMS_ACTIVE()
    {
        $sql   = "SELECT id,name FROM tbl_std_teams WHERE status = 'Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_EDUCATION_SPECIFIC($employee_id)
    {
        $sql   = "SELECT * FROM tbl_employee_education WHERE col_empl_id = ? AND is_deleted=0";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function DELETE_EDUCATION($id)
    {
        $sql   = "UPDATE tbl_employee_education SET is_deleted=1 WHERE id=?";
        return $this->db->query($sql, array($id));
    }

    function GET_EDUCATION_SPECIFIC2($id)
    {
        $sql   = "SELECT * FROM tbl_employee_education WHERE id=?";
        $query = $this->db->query($sql, array($id));
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

    function GET_EMPLOYEE_LOGS_SPECIFIC($empl_id)
    {
        $sql   = "SELECT * FROM tbl_employee_logs WHERE empl_id=? AND category != 'Salary Rate' AND category != 'Salary Type' ORDER BY log_date DESC LIMIT 1000";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEE_SALARY_LOGS_SPECIFIC($empl_id)
    {
        $sql   = "SELECT * FROM tbl_employee_logs WHERE empl_id=? AND category = 'Salary Rate' OR category = 'Salary Type' ORDER BY log_date DESC LIMIT 1000";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }

    function DELETE_WORK_HISTORY($id)
    {
        $id                 = $id;
        $delete             = '1';
        $datetime           = date('Y-m-d H:i:s');

        $sql   = " UPDATE tbl_employee_workhistory SET edit_date=?, is_deleted=? WHERE id=?";
        $this->db->query($sql, array($datetime, $delete, $id));
    }

    function DELETE_SKILL_BY_ID($id)
    {
        $id                 = $id;
        $delete             = '1';
        $datetime           = date('Y-m-d H:i:s');

        $sql   = " UPDATE tbl_employee_skillassign SET edit_date=?, is_deleted=? WHERE id=?";
        $this->db->query($sql, array($datetime, $delete, $id));
    }

    function DELETE_EMERGENCY_CONTACTS_BY_ID($id)
    {
        $id                 = $id;
        $delete             = '1';
        $datetime           = date('Y-m-d H:i:s');

        $sql   = " UPDATE tbl_employee_emergency SET edit_date=?, is_deleted=? WHERE id=?";
        $this->db->query($sql, array($datetime, $delete, $id));
    }

    function DELETE_DEPENDENTS_BY_ID($id)
    {
        $id                 = $id;
        $delete             = '1';
        $datetime           = date('Y-m-d H:i:s');

        $sql  = " UPDATE tbl_employee_dependents SET edit_date=?, is_deleted=? WHERE id=?";
        $this->db->query($sql, array($datetime, $delete, $id));
    }

    function DELETE_DOCUMENTS_BY_ID($id)
    {
        $id                 = $id;
        $delete             = '1';
        $datetime           = date('Y-m-d H:i:s');

        $sql = " UPDATE tbl_employee_documents SET edit_date=?, is_deleted=? WHERE id=?";
        $this->db->query($sql, array($datetime, $delete, $id));
    }

    function DELETE_EDUCATION_BY_ID($id)
    {
        $id                 = $id;
        $delete             = '1';
        $datetime           = date('Y-m-d H:i:s');

        $sql = " UPDATE tbl_employee_education SET edit_date=?, is_deleted=? WHERE id=?";
        $this->db->query($sql, array($datetime, $delete, $id));
    }

    function GET_WORK_HISTORY($userId)
    {
        $sql = "SELECT id,col_empl_id,company_name,company_address,date_start,date_end,position 
        FROM tbl_employee_workhistory WHERE is_deleted=0 && col_empl_id=? ";
        $query = $this->db->query($sql, array($userId));
        // $query->next_result();
        return $query->result();
    }

    function GET_WORK_HISTORY_ALL()
    {
        $sql = "SELECT id,col_empl_id,company_name,company_address,date_start,date_end,position 
        FROM tbl_employee_workhistory WHERE is_deleted=0";
        $query = $this->db->query($sql, array());
        $raw = $query->result();
        foreach ($raw as &$row) {
            $col_empl_id = $row->col_empl_id;
            $col_empl_cmid = $this->getCMID($col_empl_id);
            $row->col_empl_cmid = $col_empl_cmid;
            unset($row->col_empl_id);
        }
        return $raw;
    }

    function GET_EDUCATION_ALL_NOT_DELETED()
    {
        $sql = "SELECT id,col_empl_id,col_educ_degree,col_educ_school,col_educ_from_yr,col_educ_to_yr,col_educ_grade,address,completion,col_educ_level
        FROM tbl_employee_education WHERE is_deleted=0";
        $query = $this->db->query($sql, array());
        $raw = $query->result();
        foreach ($raw as &$row) {
            $col_empl_id = $row->col_empl_id;
            $col_empl_cmid = $this->getCMID($col_empl_id);
            $row->col_empl_cmid = $col_empl_cmid;
            unset($row->col_empl_id);
        }
        return $raw;
    }

    function GET_DEPENDENTS_ALL_NOT_DELETED()
    {
        $sql = "SELECT id,col_depe_empid,col_depe_name,col_depe_bday,col_depe_gndr,col_depe_rela
        FROM tbl_employee_dependents WHERE is_deleted=0";
        $query = $this->db->query($sql, array());
        $raw = $query->result();
        foreach ($raw as &$row) {
            $row->col_empl_cmid = $this->getCMID($row->col_depe_empid);
            unset($row->col_depe_empid);
        }
        return $raw;
    }

    function GET_EMERGENCY_CONTACTS_ALL_NOT_DELETED()
    {
        $sql = "SELECT id,empid,name,relationship,mobile_number,work_phone,home_phone,current_address
        FROM tbl_employee_emergency WHERE is_deleted=0";
        $query = $this->db->query($sql, array());
        $raw = $query->result();
        foreach ($raw as &$row) {
            $row->col_empl_cmid = $this->getCMID($row->empid);
            unset($row->empid);
        }
        return $raw;
    }

    function GET_DOCUMENTS_ALL_NOT_DELETED()
    {
        $sql = "SELECT id,col_empl_id,col_doc_file,col_doc_name
        FROM tbl_employee_documents WHERE is_deleted=0";
        $query = $this->db->query($sql, array());
        $raw = $query->result();
        foreach ($raw as &$row) {
            $col_empl_id = $row->col_empl_id;
            $col_empl_cmid = $this->getCMID($col_empl_id);
            $row->col_empl_cmid = $col_empl_cmid;
            unset($row->col_empl_id);
        }
        return $raw;
    }

    function GET_SKILLS_ALL_NOT_DELETED()
    {
        $sql = "SELECT id,username,name,value,status
        FROM tbl_employee_skillassign WHERE is_deleted=0";
        $query = $this->db->query($sql, array());
        $raw = $query->result();
        foreach ($raw as &$row) {
            $row->col_empl_cmid = $this->getCMID($row->username);
            $row->name = $this->getSkillName($row->name);
            $row->value = $this->getSkillLevel($row->value);
            unset($row->username);
        }
        return $raw;
    }

    function getCMID($col_empl_id)
    {
        $sql    = "SELECT col_empl_cmid FROM tbl_employee_infos WHERE id=?";
        $query  = $this->db->query($sql, array($col_empl_id));
        $result = $query->row();
        if ($result) {
            return $result->col_empl_cmid;
        } else {
            return null;
        }
    }

    function getSkillName($skillId)
    {
        $sql    = "SELECT name FROM tbl_std_skillnames WHERE id=?";
        $query  = $this->db->query($sql, array($skillId));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }

    function getSkillNameId($skillName)
    {
        $sql    = "SELECT id  FROM tbl_std_skillnames WHERE name=?";
        $query  = $this->db->query($sql, array($skillName));
        $result = $query->row();
        if ($result) {
            return $result->id;
        } else {
            return null;
        }
    }

    function getSkillLevel($skillLevelId)
    {
        $sql    = "SELECT name FROM tbl_std_skilllevels WHERE id=?";
        $query  = $this->db->query($sql, array($skillLevelId));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }

    function getSkillLevelId($skillLevelName)
    {
        $sql    = "SELECT id FROM tbl_std_skilllevels WHERE name=?";
        $query  = $this->db->query($sql, array($skillLevelName));
        $result = $query->row();
        if ($result) {
            return $result->id;
        } else {
            return null;
        }
    }

    function getEmployeeTableId($col_empl_cmid)
    {
        // Modified SQL query to ensure that disabled records are not returned
        $sql = "SELECT id 
                FROM tbl_employee_infos 
                WHERE col_empl_cmid = ? 
                  AND (termination_date IS NULL OR termination_date = '0000-00-00') 
                  AND disabled = 0";
        $query = $this->db->query($sql, array($col_empl_cmid));
        $result = $query->row();

        if ($result) {
            return $result->id;
        } else {
            return null;
        }
    }

    function GET_ALL_EMPLOYEE(){
        $sql   = "SELECT col_empl_cmid,col_last_name,col_midl_name,col_frst_name,col_suffix,col_home_addr,col_curr_addr,col_province,col_city,col_barangay,col_birt_date,col_empl_gend,
        col_empl_nati,col_shir_size,col_empl_emai,col_mobl_numb,col_hire_date,date_regular,resignation_date,col_endd_date,col_empl_type,col_empl_posi,col_empl_dept,col_empl_sect,col_empl_group,
        col_empl_line,bank_name,account_number,col_empl_sssc,col_empl_hdmf,col_empl_phil,col_empl_btin,col_empl_driv,col_empl_naid,col_empl_pass FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 ORDER BY col_empl_cmid + 0 ASC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    FUNCTION GET_EMPL_GENDER_NAME($id){
        
        $sql = "SELECT * FROM `tbl_std_genders` WHERE id=? ";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }

    FUNCTION GET_EMPL_NAT_NAME($id){
        
        $sql = "SELECT * FROM `tbl_std_nationalities` WHERE id=? ";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }
    
    FUNCTION GET_EMPL_SHIRTSIZE_NAME($id){
        
        $sql = "SELECT * FROM `tbl_std_shirtsizes` WHERE id=? ";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }

    FUNCTION GET_EMPL_EMPL_TYPE_NAME($id){
        
        $sql = "SELECT * FROM `tbl_std_employeetypes` WHERE id=? ";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }
    
    FUNCTION GET_EMPL_POSITION_NAME($id){
        
        $sql = "SELECT * FROM `tbl_std_positions` WHERE id=? ";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }
    
    FUNCTION GET_EMPL_DEPARTMENT_NAME($id){
        
        $sql = "SELECT * FROM `tbl_std_departments` WHERE id=? ";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }

    FUNCTION GET_EMPL_SECTION_NAME($id){
        
        $sql = "SELECT * FROM `tbl_std_sections` WHERE id=? ";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }

    FUNCTION GET_EMPL_GROUP_NAME($id){
        
        $sql = "SELECT * FROM `tbl_std_groups` WHERE id=? ";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }
    
    FUNCTION GET_EMPL_LINE_NAME($id){
        
        $sql = "SELECT * FROM `tbl_std_lines` WHERE id=? ";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }
    

    function GET_TABLEPLUS()
    {
        $sql   = "SELECT * 
        FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 ORDER BY col_empl_cmid + 0 ASC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    
    function GET_TABLEPLUS_ID($id)
    {
        $sql   = "SELECT * 
        FROM tbl_employee_infos WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }

    function employee_search()
    {
        $sql = "SELECT id,col_empl_pass, CONCAT_WS('',
        CASE WHEN col_empl_cmid IS NOT NULL AND col_empl_cmid != '' THEN CONCAT(col_empl_cmid, '-') ELSE '' END,
        CASE WHEN col_last_name IS NOT NULL AND col_last_name != '' THEN CONCAT(col_last_name) ELSE '' END,
        CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS employee_name FROM tbl_employee_infos";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function is_duplicate_data($data_row)
    {
        $sql   = "SELECT col_empl_cmid FROM tbl_employee_infos WHERE col_empl_cmid = ?";
        $query = $this->db->query($sql, $data_row['col_empl_cmid']);
        return $query->num_rows();
    }

    function insert_data($data, $editUser)
    {

        $C_BRANCH                       = $this->GET_BRANCHES();
        $C_SECTIONS                     = $this->GET_SECTIONS();
        $C_DEPARTMENTS                  = $this->GET_DEPARTMENTS();
        $C_POSITIONS                    = $this->GET_POSITION();
        $C_TYPE                         = $this->GET_TYPE();
        $C_SHIRT_SIZE                   = $this->GET_SHIRT_SIZE();
        $C_GENDERS                      = $this->GET_GENDERS();
        $C_MARITAL                      = $this->GET_MARITAL();
        $C_NATIONALITY                  = $this->GET_NATIONALITY();
        $C_GROUPS                       = $this->GET_GROUPS();
        $C_LINES                        = $this->GET_LINES();
        $C_DIVISIONS                    = $this->GET_DIVISIONS();
        $C_CLUBHOUSE                   = $this->GET_CLUBHOUSE();
        $C_HMOS                         = $this->GET_HMO();
        $C_USER_ACCESS                  = $this->GET_USER_ACCESS();
        $C_COMPANIES                    = $this->GET_COMPANIES();
        $C_BRANCHES                     = $this->GET_BRANCHES();
        $C_TEAMS                        = $this->GET_TEAMS();

        $user_access                    =  1; // Default
        $data['col_last_name']          = ucwords($data['col_last_name']);
        $data['col_midl_name']          = ucwords($data['col_midl_name']);
        $data['col_frst_name']          = ucwords($data['col_frst_name']);
        $data['bank_name']              = ucwords($data['bank_name']);
        $data['account_number']         = ucwords($data['account_number']);
        $data['col_mart_stat']          =  $this->convert_name2id($C_MARITAL, $data['col_mart_stat']);
        $data['col_birt_date']          =  convertDateToMySQLFormat($data['col_birt_date']);
        $data['col_empl_gend']          =  $this->convert_name2id($C_GENDERS, $data['col_empl_gend']);
        $data['col_empl_nati']          =  $this->convert_name2id($C_NATIONALITY, $data['col_empl_nati']);
        $data['col_shir_size']          =  $this->convert_name2id($C_SHIRT_SIZE, $data['col_shir_size']);
        $data['col_hire_date']          = convertDateToMySQLFormat($data['col_hire_date']);

        $data['date_regular']           = convertDateToMySQLFormat($data['date_regular']);
        $data['resignation_date']       = convertDateToMySQLFormat($data['resignation_date']);
        $data['col_endd_date']          = convertDateToMySQLFormat($data['col_endd_date']);
        $data['col_empl_type']          =  $this->convert_name2id($C_TYPE, $data['col_empl_type']);
        $data['col_empl_posi']          =  $this->convert_name2id($C_POSITIONS, $data['col_empl_posi']);
        $data['col_empl_company']       =  $this->convert_name2id($C_COMPANIES, $data['col_empl_company']);
        $data['col_empl_branch']        =  $this->convert_name2id($C_BRANCHES, $data['col_empl_branch']);
        $data['col_empl_dept']          =  $this->convert_name2id($C_DEPARTMENTS, $data['col_empl_dept']);
        $data['col_empl_divi']          =  $this->convert_name2id($C_DIVISIONS, $data['col_empl_divi']);
        $data['col_empl_club']          =  $this->convert_name2id($C_CLUBHOUSE, $data['col_empl_club']);
        $data['col_empl_sect']          =  $this->convert_name2id($C_SECTIONS, $data['col_empl_sect']);
        $data['col_empl_group']         =  $this->convert_name2id($C_GROUPS, $data['col_empl_group']);
        $data['col_empl_team']          =  $this->convert_name2id($C_TEAMS, $data['col_empl_team']);
        $data['col_empl_line']          =  $this->convert_name2id($C_LINES, $data['col_empl_line']);
        $data['col_empl_hmoo']          =  $this->convert_name2id($C_HMOS, $data['col_empl_hmoo']);
        $data['disabled']                        = ($data['disabled'] !== 'Inactive') ? 0 : 1;

        $data['salary_rate'] = empty($data['salary_rate']) ? 0 : (float)$data['salary_rate'];

        $last_name                      = $data['col_last_name'];
        $birth_year                     = date('Y', strtotime($data['col_birt_date']));
        $pass                           = $last_name . '.' . $birth_year;

        $salt                           = password_hash(uniqid(), PASSWORD_BCRYPT);
        $password                       = ucfirst($pass);
        $encrypted_password             = password_hash($password . $salt, PASSWORD_BCRYPT);

        // $salt = password_hash(uniqid(), PASSWORD_BCRYPT);
        // $password = ucfirst($reset_pass);
        // $encrypted_password = password_hash($password . $salt, PASSWORD_BCRYPT);

        // $salt                           = bin2hex(openssl_random_pseudo_bytes(22));
        // $password                       = ucfirst($pass);
        // $encrypted_password             = md5($password . '' . $salt);

        // $data['pass'] = $pass;
        // return $data;
        $current_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_infos (create_date, edit_date,        edit_user,
                                                col_user_name,         col_empl_cmid,    
                                                col_user_pass, col_salt_key, col_user_access, col_last_name, 
                                                col_midl_name,         col_frst_name,          col_suffix,          
                                                col_mart_stat,        col_home_addr,         col_curr_addr, 
                                                col_province,col_city,col_barangay,            col_birt_date,
                                                col_empl_gend,          col_empl_nati,          col_shir_size, 
                                                col_empl_emai,         col_mobl_numb,        col_hire_date,             
                                                date_regular,          resignation_date,          col_endd_date,          
                                                col_empl_type,         col_empl_posi,          col_empl_company,           
                                                col_empl_branch,         col_empl_dept,          col_empl_divi,
                                                col_empl_club,         col_empl_sect,          col_empl_group,           
                                                col_empl_team,         
                                                col_empl_line,          col_imag_path,          col_empl_sssc,         
                                                col_empl_hdmf,           col_empl_phil,           col_empl_btin,          
                                                col_empl_driv,         col_empl_naid,           col_empl_pass,         
                                                col_empl_hmoo,           col_empl_hmon,          salary_rate,         
                                                salary_type, bank_name, account_number, disabled) 
                VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $this->db->query($sql, array(
            $current_date,
            $current_date,
            $editUser,
            $data['col_empl_cmid'],
            $data['col_empl_cmid'],
            $encrypted_password,
            $salt,
            $user_access,
            $data['col_last_name'],
            $data['col_midl_name'],
            $data['col_frst_name'],
            $data['col_suffix'],
            $data['col_mart_stat'],
            $data['col_home_addr'],
            $data['col_curr_addr'],
            $data['col_province'],
            $data['col_city'],
            $data['col_barangay'],
            $data['col_birt_date'],
            $data['col_empl_gend'],
            $data['col_empl_nati'],
            $data['col_shir_size'],
            $data['col_empl_emai'],
            $data['col_mobl_numb'],
            $data['col_hire_date'],
            $data['date_regular'],
            $data['resignation_date'],
            $data['col_endd_date'],
            $data['col_empl_type'],
            $data['col_empl_posi'],
            $data['col_empl_company'],
            $data['col_empl_branch'],
            $data['col_empl_dept'],
            $data['col_empl_divi'],
            $data['col_empl_club'],
            $data['col_empl_sect'],
            $data['col_empl_group'],
            $data['col_empl_team'],
            $data['col_empl_line'],
            $data['col_imag_path'],
            $data['col_empl_sssc'],
            $data['col_empl_hdmf'],
            $data['col_empl_phil'],
            $data['col_empl_btin'],
            $data['col_empl_driv'],
            $data['col_empl_naid'],
            $data['col_empl_pass'],
            $data['col_empl_hmoo'],
            $data['col_empl_hmon'],
            $data['salary_rate'],
            $data['salary_type'],
            $data['bank_name'],
            $data['account_number'],
            $data['disabled']
        ));
    }

    function convert_name2id($array, $pos)
    {
        $id = "";
        $posLower = strtolower($pos);
        foreach ($array as $e) {
            $nameLower = strtolower($e->name);
            if ($nameLower == $posLower) {
                $id = $e->id;
                return $id;
            }
        }
        return 0;
    }

    function update_data($data, $edit_id_logs)
    {
        $C_SECTIONS                     = $this->GET_SECTIONS();
        $C_DEPARTMENTS                  = $this->GET_DEPARTMENTS();
        $C_CLUBHOUSE                    = $this->GET_CLUBHOUSE();
        $C_POSITIONS                    = $this->GET_POSITION();
        $C_TYPE                         = $this->GET_TYPE();
        $C_SHIRT_SIZE                   = $this->GET_SHIRT_SIZE();
        $C_GENDERS                      = $this->GET_GENDERS();
        $C_MARITAL                      = $this->GET_MARITAL();
        $C_NATIONALITY                  = $this->GET_NATIONALITY();
        $C_GROUPS                       = $this->GET_GROUPS();
        $C_LINES                        = $this->GET_LINES();
        $C_DIVISIONS                    = $this->GET_DIVISIONS();
        $C_HMOS                         = $this->GET_HMO();
        $C_COMPANIES                    = $this->GET_COMPANIES();
        $C_BRANCHES                     = $this->GET_BRANCHES();
        $C_TEAMS                        = $this->GET_TEAMS();

        // $data_4                         =  $this->convert_name2id($C_MARITAL, $data[4]);
        $data['col_mart_stat_name']     = $data['col_mart_stat'];
        $data['col_mart_stat']          =  $this->convert_name2id($C_MARITAL, $data['col_mart_stat']);

        $birth_date = null;
        // if ($data[7] && $data[7] !== '0000-00-00') {
        if ($data['col_birt_date'] && $data['col_birt_date'] !== '0000-00-00') {
            // $birth_date_array           = explode("/", $data[7]);
            $birth_date_array           = explode("/", $data['col_birt_date']);
            $birth_date_day             = $birth_date_array[0];
            $birth_date_month           = $birth_date_array[1];
            $birth_date_year            = $birth_date_array[2];
            $birth_date                 = date("Y-m-d", strtotime($birth_date_day . '-' . $birth_date_month . '-' . $birth_date_year));
            $data['col_birt_date']      = $birth_date;
        }

        // $data_8                         =  $this->convert_name2id($C_GENDERS, $data[8]);
        $data['col_empl_gend_name']     =  $data['col_empl_gend'];
        $data['col_empl_gend']          =  $this->convert_name2id($C_GENDERS, $data['col_empl_gend']);
        // $data_9                         =  $this->convert_name2id($C_NATIONALITY, $data[9]);
        $data['col_empl_nati_name']     =  $data['col_empl_nati'];
        $data['col_empl_nati']          =  $this->convert_name2id($C_NATIONALITY, $data['col_empl_nati']);
        // $data_10                        =  $this->convert_name2id($C_SHIRT_SIZE, $data[10]);
        $data['col_shir_size_name']     =  $data['col_shir_size'];
        $data['col_shir_size']          =  $this->convert_name2id($C_SHIRT_SIZE, $data['col_shir_size']);

        $hire_date = null;
        // if ($data[13] && $data[13] !== '0000-00-00') {
        if ($data['col_hire_date'] && $data['col_hire_date'] !== '0000-00-00') {
            // $hire_date_array            = explode("/", $data[13]);
            $hire_date_array            = explode("/", $data['col_hire_date']);
            $hire_date_day              = $hire_date_array[0];
            $hire_date_month            = $hire_date_array[1];
            $hire_date_year             = $hire_date_array[2];
            $hire_date                  = date("Y-m-d", strtotime($hire_date_day . '-' . $hire_date_month . '-' . $hire_date_year));
            $data['col_hire_date']      = $hire_date;
        }

        $regular_date = null;
        // if ($data[14] && $data[14] !== '0000-00-00') {
        if ($data['date_regular'] && $data['date_regular'] !== '0000-00-00') {
            $regular_date_array         = explode("/", $data['date_regular']);
            $regular_date_day           = $regular_date_array[0];
            $regular_date_month         = $regular_date_array[1];
            $regular_date_year          = $regular_date_array[2];
            $regular_date               = date("Y-m-d", strtotime($regular_date_day . '-' . $regular_date_month . '-' . $regular_date_year));
            $data['date_regular']       = $regular_date;
        }

        $resign_date = null;
        // if ($data[15] && $data[15] !== '0000-00-00') {
        if ($data['resignation_date'] && $data['resignation_date'] !== '0000-00-00') {
            $resign_date_array          = explode("/", $data['resignation_date']);
            $resign_date_day            = $resign_date_array[0];
            $resign_date_month          = $resign_date_array[1];
            $resign_date_year           = $resign_date_array[2];
            $resign_date                = date("Y-m-d", strtotime($resign_date_day . '-' . $resign_date_month . '-' . $resign_date_year));
            $data['resignation_date']   = $resign_date;
        }

        $endd_date = null;
        // if ($data[16] && $data[16] !== '0000-00-00') {
        if ($data['col_endd_date'] && $data['col_endd_date'] !== '0000-00-00') {
            $endd_date_array            = explode("/", $data['col_endd_date']);
            $endd_date_day              = $endd_date_array[0];
            $endd_date_month            = $endd_date_array[1];
            $endd_date_year             = $endd_date_array[2];
            $endd_date                  = date("Y-m-d", strtotime($endd_date_day . '-' . $endd_date_month . '-' . $endd_date_year));
            $data['col_endd_date']      = $endd_date;
        }

        // $data_17                        =  $this->convert_name2id($C_TYPE, $data[17]);
        $data['col_empl_type_name']     = $data['col_empl_type'];
        $data['col_empl_type']          =  $this->convert_name2id($C_TYPE, $data['col_empl_type']);
        // $data_18                     =  $this->convert_name2id($C_POSITIONS, $data[18]);
        $data['col_empl_posi_name']     = $data['col_empl_posi'];
        $data['col_empl_posi']          =  $this->convert_name2id($C_POSITIONS, $data['col_empl_posi']);
        // $data_19                        =  $this->convert_name2id($C_COMPANIES, $data[19]);
        $data['col_empl_company_name']  = $data['col_empl_company'];
        $data['col_empl_company']       =  $this->convert_name2id($C_COMPANIES, $data['col_empl_company']);
        // $data_20                        =  $this->convert_name2id($C_BRANCHES, $data[20]);
        $data['col_empl_branch_name']   = $data['col_empl_branch'];
        $data['col_empl_branch']        =  $this->convert_name2id($C_BRANCHES, $data['col_empl_branch']);
        // $data_21                        =  $this->convert_name2id($C_DEPARTMENTS, $data[21]);
        $data['col_empl_dept_name']     = $data['col_empl_dept'];
        $data['col_empl_dept']          =  $this->convert_name2id($C_DEPARTMENTS, $data['col_empl_dept']);
        // $data_22                        =  $this->convert_name2id($C_DIVISIONS, $data[22]);
        $data['col_empl_divi_name']     = $data['col_empl_divi'];
        $data['col_empl_divi']          =  $this->convert_name2id($C_DIVISIONS, $data['col_empl_divi']);
        // $data_22                        =  $this->convert_name2id($C_DIVISIONS, $data[22]);
        $data['col_empl_club_name']     = $data['col_empl_club'];
        $data['col_empl_club']          =  $this->convert_name2id($C_CLUBHOUSE, $data['col_empl_club']);
        // $data_23                        =  $this->convert_name2id($C_SECTIONS, $data[23]);
        $data['col_empl_sect_name']     = $data['col_empl_sect'];
        $data['col_empl_sect']          =  $this->convert_name2id($C_SECTIONS, $data['col_empl_sect']);
        // $data_24                        =  $this->convert_name2id($C_GROUPS, $data[24]);
        $data['col_empl_group_name']    = $data['col_empl_group'];
        $data['col_empl_group']         =  $this->convert_name2id($C_GROUPS, $data['col_empl_group']);
        // $data_25                        =  $this->convert_name2id($C_TEAMS, $data[25]);
        $data['col_empl_team_name']     = $data['col_empl_team'];
        $data['col_empl_team']          =  $this->convert_name2id($C_TEAMS, $data['col_empl_team']);
        // $data_26                        =  $this->convert_name2id($C_LINES, $data[26]);
        $data['col_empl_line_name']     = $data['col_empl_line'];
        $data['col_empl_line']          =  $this->convert_name2id($C_LINES, $data['col_empl_line']);
        // $data_35                        =  $this->convert_name2id($C_HMOS, $data[35]);
        $data['col_empl_hmoo_name']     = $data['col_empl_hmoo'];
        $data['col_empl_hmoo']          =  $this->convert_name2id($C_HMOS, $data['col_empl_hmoo']);


        $isConverted = array(
            "col_empl_hmoo",
            "col_empl_line",
            "col_empl_team",
            "col_empl_group",
            "col_empl_sect",
            "col_empl_divi",
            "col_empl_club",
            "col_empl_dept",
            "col_empl_branch",
            "col_empl_company",
            "col_empl_posi",
            "col_empl_type",
            "col_shir_size",
            "col_empl_nati",
            "col_empl_gend",
            "col_mart_stat"
        );

        $sqlold = "SELECT * FROM tbl_employee_infos WHERE col_empl_cmid=?";
        // $queryold = $this->db->query($sqlold, array($data[0]));
        $queryold = $this->db->query($sqlold, array($data['col_empl_cmid']));
        $queryold->next_result();
        $old = $queryold->result();
        $current_date = date('Y-m-d H:i:s');
        $setColumns = "edit_date=?";
        $queryData = array($current_date);
        $logs = [];
        foreach ($old[0] as $key => $value) {
            foreach ($data as $key2 => $value2) {
                if ($key == $key2 && $value != $value2) {
                    $setColumns .= ", $key=?";
                    array_push($queryData, $data[$key]);
                    array_push($logs, [
                        $this->columnCategory($key),
                        $value,
                        in_array($key, $isConverted) ? $data[$key . '_name'] : $value2,
                    ]);
                }
            }
        }
        // foreach ($old[0] as $key => $value) {
        //     if ($key == "col_last_name" && !empty($data[1]) && $value != $data[1]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[1]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[1],
        //         ]);
        //     } else if ($key == "col_midl_name" && !empty($data[2]) && $value != $data[2]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[2]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[2],
        //         ]);
        //     } else if ($key == "col_frst_name" && !empty($data[3]) && $value != $data[3]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[3]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[3],
        //         ]);
        //     } else if ($key == "col_mart_stat" && !empty($data[4]) && $value != $data_4) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data_4);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[4],
        //         ]);
        //     } else if ($key == "col_home_addr" && !empty($data[5]) && $value != $data[5]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[5]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[5],
        //         ]);
        //     } else if ($key == "col_curr_addr" && !empty($data[6]) && $value != $data[6]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[6]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[6],
        //         ]);
        //     } else if ($key == "col_birt_date" && !empty($data[7]) && $value != $birth_date) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $birth_date);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $birth_date,
        //         ]);
        //     } else if ($key == "col_empl_gend" && !empty($data[8]) && $value != $data_8) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data_8);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[8],
        //         ]);
        //     } else if ($key == "col_empl_nati" && !empty($data[9]) && $value != $data_9) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data_9);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[9],
        //         ]);
        //     } else if ($key == "col_shir_size" && !empty($data[10]) && $value != $data_10) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data_10);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[10],
        //         ]);
        //     } else if ($key == "col_empl_emai" && !empty($data[11]) && $value != $data[11]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[11]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[11],
        //         ]);
        //     } else if ($key == "col_mobl_numb" && !empty($data[12]) && $value != $data[12]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[12]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[12],
        //         ]);
        //     } else if ($key == "col_hire_date" && !empty($data[13]) && $value != $hire_date) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $hire_date);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $hire_date,
        //         ]);
        //     } else if ($key == "date_regular" && !empty($data[14]) && $value != $regular_date) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $regular_date);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $regular_date,
        //         ]);
        //     } else if ($key == "resignation_date" && !empty($data[15]) && $value != $resign_date) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $resign_date);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $resign_date,
        //         ]);
        //     } else if ($key == "col_endd_date" && !empty($data[16]) && $value != $endd_date) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $endd_date);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $endd_date,
        //         ]);
        //     } else if ($key == "col_empl_type" && !empty($data[17]) && $value != $data_17) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data_17);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[17],
        //         ]);
        //     } else if ($key == "col_empl_posi" && !empty($data[18]) && $value != $data_18) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data_18);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[18],
        //         ]);
        //     } else if ($key == "col_empl_company" && !empty($data[19]) && $value != $data_19) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data_19);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[19],
        //         ]);
        //     } else if ($key == "col_empl_branch" && !empty($data[20]) && $value != $data_20) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data_20);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[20],
        //         ]);
        //     } else if ($key == "col_empl_dept" && !empty($data[21]) && $value != $data_21) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data_21);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[21],
        //         ]);
        //     } else if ($key == "col_empl_divi" && !empty($data[22]) && $value != $data_22) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data_22);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[22],
        //         ]);
        //     } else if ($key == "col_empl_sect" && !empty($data[23]) && $value != $data_23) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data_23);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[23],
        //         ]);
        //     } else if ($key == "col_empl_group" && !empty($data[24]) && $value != $data_24) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data_24);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[24],
        //         ]);
        //     } else if ($key == "col_empl_team" && !empty($data[25]) && $value != $data_25) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data_25);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[25],
        //         ]);
        //     } else if ($key == "col_empl_line" && !empty($data[26]) && $value != $data_26) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data_26);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[26],
        //         ]);
        //     } else if ($key == "col_imag_path" && !empty($data[27]) && $value != $data[27]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[27]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[27],
        //         ]);
        //     } else if ($key == "col_empl_sssc" && !empty($data[28]) && $value != $data[28]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[28]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[28],
        //         ]);
        //     } else if ($key == "col_empl_hdmf" && !empty($data[29]) && $value != $data[29]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[29]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[29],
        //         ]);
        //     } else if ($key == "col_empl_phil" && !empty($data[30]) && $value != $data[30]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[30]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[30],
        //         ]);
        //     } else if ($key == "col_empl_btin" && !empty($data[31]) && $value != $data[31]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[31]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[31],
        //         ]);
        //     } else if ($key == "col_empl_driv" && !empty($data[32]) && $value != $data[32]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[32]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[32],
        //         ]);
        //     } else if ($key == "col_empl_naid" && !empty($data[33]) && $value != $data[33]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[33]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[33],
        //         ]);
        //     } else if ($key == "col_empl_pass" && !empty($data[34]) && $value != $data[34]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[34]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[34],
        //         ]);
        //     } else if ($key == "col_empl_hmoo" && !empty($data[35]) && $value != $data_35) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data_35);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[35],
        //         ]);
        //     } else if ($key == "col_empl_hmon" && !empty($data[36]) && $value != $data[36]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[36]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[36],
        //         ]);
        //     } else if ($key == "salary_rate" && !empty($data[37]) && $value != $data[37]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[37]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[37],
        //         ]);
        //     } else if ($key == "salary_type" && !empty($data[38]) && $value != $data[38]) {
        //         $setColumns .= ", $key=?";
        //         array_push($queryData, $data[38]);
        //         array_push($logs, [
        //             $this->columnCategory($key),
        //             $value,
        //             $data[38],
        //         ]);
        //     }
        // }

        if (!empty($logs)) {
            try {
                // array_push($queryData, $data[0]);
                array_push($queryData, $data['col_empl_cmid']);
                $sql = "UPDATE tbl_employee_infos SET $setColumns WHERE col_empl_cmid=?";
                $this->db->query($sql, $queryData);
                $edit_id = $edit_id_logs;
                $empl_id = $old[0]->id;
                foreach ($logs as $new_row) {
                    $category = $new_row[0];
                    $from_val = $new_row[1];
                    $to_val = $new_row[2];
                    $this->ADD_EMPLOYEE_LOGS($edit_id, $empl_id, $category, $from_val, $to_val);
                }
            } catch (Exception $e) {
                return array('query error' => 'Error updating data: ' . $e->getMessage());
            }
        }
    }

    function UPDATE_WORK_HISTORY_ALL($data, $editUser)
    {
        if ($data[0]) {
            $current_date = date('Y-m-d H:i:s');
            $setColumns = "edit_date=?";
            $queryData = array($current_date);
            $response = null;
            if ($data[1]) {
                $data_1 = $this->getEmployeeTableId($data[1]);
                if (!$data_1) {
                    return $response = array('error_message' => "Employee Id $data[1] Not Found will not be updated");
                }
                $setColumns .= ", col_empl_id=?";
                array_push($queryData, $data_1);
            } else {
                return $response = array('error_message' => 'Some Blank Employee Id Found will not be updated');
            }
            if ($data[2]) {
                $setColumns .= ", company_name=?";
                array_push($queryData, $data[2]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[3]) {
                $setColumns .= ", company_address=?";
                array_push($queryData, $data[3]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[4]) {
                $setColumns .= ", date_start=?";
                array_push($queryData, $data[4]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[5]) {
                $setColumns .= ", date_end=?";
                array_push($queryData, $data[5]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[6]) {
                $setColumns .= ", position=?";
                array_push($queryData, $data[6]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($editUser) {
                $setColumns .= ", edit_user=?";
                array_push($queryData, $editUser);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            try {
                array_push($queryData, $data[0]);
                $sql = "UPDATE tbl_employee_workhistory SET $setColumns WHERE id=?";
                $this->db->query($sql, $queryData);
                return $response;
            } catch (Exception $e) {
                return array('error_message' => 'Error updating data: ' . $e->getMessage());
            }
        } else {
            $current_date = date('Y-m-d H:i:s');
            $data_1 = null;
            if ($data[1]) {
                $data_1 = $this->getEmployeeTableId($data[1]);
                if (!$data_1) {
                    return $response = array('error_message' => "Employee Id $data[1] Not Found will not be updated");
                }
            } else {
                return $response = array('error_message' => 'Some Blank Employee Id Found will not be updated');
            }
            try {
                $sql = "INSERT INTO tbl_employee_workhistory (create_date,edit_date,company_name,company_address,date_start,date_end,position,col_empl_id,edit_user) VALUES(?,?,?,?,?,?,?,?,?)";
                $this->db->query($sql, array($current_date, $current_date, $data[2], $data[3], $data[4], $data[5], $data[6], $data_1, $editUser));
                return null;
            } catch (Exception $e) {
                return array('error_message' => 'Error updating data: ' . $e->getMessage());
            }
        }
    }

    function UPDATE_SKILL_ALL($data, $editUser)
    {
        if ($data[0]) {
            $current_date = date('Y-m-d H:i:s');
            $setColumns = "edit_date=?";
            $queryData = array($current_date);
            $response = null;
            if ($data[1]) {
                $data_1 = $this->getEmployeeTableId($data[1]);
                if (!$data_1) {
                    return $response = array('error_message' => "Employee Id $data[1] Not Found will not be updated");
                }
                $setColumns .= ", username=?";
                array_push($queryData, $data_1);
            } else {
                return $response = array('error_message' => 'Some Blank Employee Id Found and will not be updated');
            }
            if ($data[2]) {
                $data_2 = $this->getSkillNameId($data[2]);
                if (!$data_2) {
                    return $response = array('error_message' => "Skill Name $data[2] Invalid will not be updated");
                }
                $setColumns .= ", name=?";
                array_push($queryData, $data_2);
            } else {
                return $response = array('error_message' => 'Some Blank Skill Name found and will not be updated');
            }
            if ($data[3]) {
                $data_3 = $this->getSkillLevelId($data[3]);
                if (!$data_3) {
                    return $response = array('error_message' => "Skill Level $data[3] Invalid will not be updated");
                }
                $setColumns .= ", value=?";
                array_push($queryData, $data_3);
            } else {
                return $response = array('error_message' => 'Some Blank Skill Level Found and will not be updated');
            }
            if ($data[4]) {
                $setColumns .= ", status=?";
                array_push($queryData, $data[4]);
            } else {
                $response = array('error_message' => 'Some blank Status found and will not be updated');
            }
            if ($editUser) {
                $setColumns .= ", edit_user=?";
                array_push($queryData, $editUser);
            } else {
                return $response = array('error_message' => 'Some blank field will not be updated.');
            }
            try {
                array_push($queryData, $data[0]);
                $sql = "UPDATE tbl_employee_skillassign SET $setColumns WHERE id=?";
                $this->db->query($sql, $queryData);
                return $response;
            } catch (Exception $e) {
                return array('error_message' => 'Error updating data: ' . $e->getMessage());
            }
        } else {
            $current_date = date('Y-m-d H:i:s');
            $data_1 = null;
            if ($data[1]) {
                $data_1 = $this->getEmployeeTableId($data[1]);
                if (!$data_1) {
                    return $response = array('error_message' => "Employee Id $data[1] Not Found and will not be added");
                }
            } else {
                return $response = array('error_message' => 'Some Blank Employee Id Found will not be added');
            }
            if ($data[2]) {
                $data_2 = $this->getSkillNameId($data[2]);
                if (!$data_2) {
                    return $response = array('error_message' => "Skill Name $data[2] Invalid will not be added");
                }
            } else {
                return $response = array('error_message' => 'Some Blank Skill Name found and will not be added');
            }
            if ($data[3]) {
                $data_3 = $this->getSkillLevelId($data[3]);
                if (!$data_3) {
                    return $response = array('error_message' => "Skill Level $data[3] Invalid will not be added");
                }
            } else {
                return $response = array('error_message' => 'Some Blank Skill Level Found and will not be added');
            }
            try {
                $sql = "INSERT INTO tbl_employee_skillassign (create_date,edit_date,username,name,value,status,edit_user) VALUES(?,?,?,?,?,?,?)";
                $this->db->query($sql, array($current_date, $current_date, $data_1, $data_2, $data_3, $data[4], $editUser));
                return null;
            } catch (Exception $e) {
                return array('error_message' => 'Error updating data: ' . $e->getMessage());
            }
        }
    }

    function UPDATE_EDUCATION_ALL($data, $editUser)
    {
        if ($data[0]) {
            $current_date = date('Y-m-d H:i:s');
            $setColumns = "edit_date=?";
            $queryData = array($current_date);
            $response = null;
            if ($data[1]) {
                $data_1 = $this->getEmployeeTableId($data[1]);
                if (!$data_1) {
                    return $response = array('error_message' => "Employee Id $data[1] Not Found will not be updated");
                }
                $setColumns .= ", col_empl_id=?";
                array_push($queryData, $data_1);
            } else {
                return $response = array('error_message' => 'Some Blank Employee Id Found will not be updated');
            }
            if ($data[2]) {
                $setColumns .= ", col_educ_degree=?";
                array_push($queryData, $data[2]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[3]) {
                $setColumns .= ", col_educ_school=?";
                array_push($queryData, $data[3]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[4]) {
                $setColumns .= ", col_educ_from_yr=?";
                array_push($queryData, $data[4]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[5]) {
                $setColumns .= ", col_educ_to_yr=?";
                array_push($queryData, $data[5]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[6]) {
                $setColumns .= ", col_educ_grade=?";
                array_push($queryData, $data[6]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[7]) {
                $setColumns .= ", address=?";
                array_push($queryData, $data[7]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[8]) {
                $setColumns .= ", completion=?";
                array_push($queryData, $data[8]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[9]) {
                $setColumns .= ", col_educ_level=?";
                array_push($queryData, $data[9]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($editUser) {
                $setColumns .= ", edit_user=?";
                array_push($queryData, $editUser);
            } else {
                return $response = array('error_message' => 'Some blank field will not be updated.');
            }
            try {
                array_push($queryData, $data[0]);
                $sql = "UPDATE tbl_employee_education SET $setColumns WHERE id=?";
                $this->db->query($sql, $queryData);
                return $response;
            } catch (Exception $e) {
                return array('error_message' => 'Error updating data: ' . $e->getMessage());
            }
        } else {
            $current_date = date('Y-m-d H:i:s');
            $data_1 = null;
            if ($data[1]) {
                $data_1 = $this->getEmployeeTableId($data[1]);
                if (!$data_1) {
                    return $response = array('error_message' => "Employee Id $data[1] Not Found will not be updated");
                }
            } else {
                return $response = array('error_message' => 'Some Blank Employee Id Found will not be updated');
            }
            try {
                $sql = "INSERT INTO tbl_employee_education (create_date,edit_date,col_empl_id,col_educ_degree,col_educ_school,col_educ_from_yr,col_educ_to_yr,col_educ_grade,address,completion,col_educ_level,edit_user) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
                $this->db->query($sql, array($current_date, $current_date, $data_1, $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $editUser));
                return null;
            } catch (Exception $e) {
                return array('error_message' => 'Error updating data: ' . $e->getMessage());
            }
        }
    }

    function UPDATE_EMERGENCY_CONTACTS_ALL($data, $editUser)
    {
        if ($data[0]) {
            $current_date = date('Y-m-d H:i:s');
            $setColumns = "edit_date=?";
            $queryData = array($current_date);
            $response = null;
            if ($data[1]) {
                $data_1 = $this->getEmployeeTableId($data[1]);
                if (!$data_1) {
                    return $response = array('error_message' => "Employee Id $data[1] Not Found will not be updated");
                }
                $setColumns .= ", empid=?";
                array_push($queryData, $data_1);
            } else {
                return $response = array('error_message' => 'Some Blank Employee Id Found will not be updated');
            }
            if ($data[2]) {
                $setColumns .= ", name=?";
                array_push($queryData, $data[2]);
            } else {
                $response = array('error_message' => 'Some blank Name field will not be updated');
            }
            if ($data[3]) {
                $setColumns .= ", relationship=?";
                array_push($queryData, $data[3]);
            } else {
                $response = array('error_message' => 'Some blank Relationship field will not be updated');
            }
            if ($data[4]) {
                $setColumns .= ", mobile_number=?";
                array_push($queryData, $data[4]);
            } else {
                $response = array('error_message' => 'Some blank Mobile Number field will not be updated');
            }
            if ($data[5]) {
                $setColumns .= ", work_phone=?";
                array_push($queryData, $data[5]);
            } else {
                $response = array('error_message' => 'Some blank Work Phone field will not be updated');
            }
            if ($data[6]) {
                $setColumns .= ", home_phone=?";
                array_push($queryData, $data[6]);
            } else {
                $response = array('error_message' => 'Some blank Home Phone field will not be updated');
            }
            if ($data[7]) {
                $setColumns .= ", current_address=?";
                array_push($queryData, $data[7]);
            } else {
                $response = array('error_message' => 'Some blank Current Address field will not be updated');
            }

            if ($editUser) {
                $setColumns .= ", edit_user=?";
                array_push($queryData, $editUser);
            } else {
                return $response = array('error_message' => 'Some blank field will not be updated.');
            }
            try {
                array_push($queryData, $data[0]);
                $sql = "UPDATE tbl_employee_emergency SET $setColumns WHERE id=?";
                $this->db->query($sql, $queryData);
                return $response;
            } catch (Exception $e) {
                return array('error_message' => 'Error updating data: ' . $e->getMessage());
            }
        } else {
            $current_date = date('Y-m-d H:i:s');
            $data_1 = null;
            if ($data[1]) {
                $data_1 = $this->getEmployeeTableId($data[1]);
                if (!$data_1) {
                    return $response = array('error_message' => "Employee Id $data[1] Not Found will not be updated");
                }
            } else {
                return $response = array('error_message' => 'Some Blank Employee Id Found will not be updated');
            }
            try {
                $sql = "INSERT INTO tbl_employee_emergency (create_date,edit_date,empid,name,relationship,mobile_number,work_phone,home_phone,current_address,edit_user) VALUES(?,?,?,?,?,?,?,?,?,?)";
                $this->db->query($sql, array($current_date, $current_date, $data_1, $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $editUser));
                return null;
            } catch (Exception $e) {
                return array('error_message' => 'Error updating data: ' . $e->getMessage());
            }
        }
    }

    function UPDATE_DEPENDENTS_ALL($data, $editUser)
    {
        if ($data[0]) {
            $current_date = date('Y-m-d H:i:s');
            $setColumns = "edit_date=?";
            $queryData = array($current_date);
            $response = null;
            if ($data[1]) {
                $data_1 = $this->getEmployeeTableId($data[1]);
                if (!$data_1) {
                    return $response = array('error_message' => "Employee Id $data[1] Not Found will not be updated");
                }
                $setColumns .= ", col_depe_empid=?";
                array_push($queryData, $data_1);
            } else {
                return $response = array('error_message' => 'Some Blank Employee Id Found will not be updated');
            }
            if ($data[2]) {
                $setColumns .= ", col_depe_name=?";
                array_push($queryData, $data[2]);
            } else {
                $response = array('error_message' => 'Some blank Name field will not be updated');
            }
            if ($data[3]) {
                $setColumns .= ", col_depe_bday=?";
                array_push($queryData, $data[3]);
            } else {
                $response = array('error_message' => 'Some blank Birth Date field will not be updated');
            }
            if ($data[4]) {
                $setColumns .= ", col_depe_gndr=?";
                array_push($queryData, $data[4]);
            } else {
                $response = array('error_message' => 'Some blank Gender field will not be updated');
            }
            if ($data[5]) {
                $setColumns .= ", col_depe_rela=?";
                array_push($queryData, $data[5]);
            } else {
                $response = array('error_message' => 'Some blank Relationship field will not be updated');
            }

            if ($editUser) {
                $setColumns .= ", edit_user=?";
                array_push($queryData, $editUser);
            } else {
                return $response = array('error_message' => 'Some blank field will not be updated.');
            }
            try {
                array_push($queryData, $data[0]);
                $sql = "UPDATE tbl_employee_dependents SET $setColumns WHERE id=?";
                $this->db->query($sql, $queryData);
                return $response;
            } catch (Exception $e) {
                return array('error_message' => 'Error updating data: ' . $e->getMessage());
            }
        } else {
            $current_date = date('Y-m-d H:i:s');
            $data_1 = null;
            if ($data[1]) {
                $data_1 = $this->getEmployeeTableId($data[1]);
                if (!$data_1) {
                    return $response = array('error_message' => "Employee Id $data[1] Not Found will not be updated");
                }
            } else {
                return $response = array('error_message' => 'Some Blank Employee Id Found will not be updated');
            }
            try {
                $sql = "INSERT INTO tbl_employee_dependents (create_date,edit_date,col_depe_empid,col_depe_name,col_depe_bday,col_depe_gndr,col_depe_rela,edit_user) VALUES(?,?,?,?,?,?,?,?)";
                $this->db->query($sql, array($current_date, $current_date, $data_1, $data[2], $data[3], $data[4], $data[5], $editUser));
                return null;
            } catch (Exception $e) {
                return array('error_message' => 'Error updating data: ' . $e->getMessage());
            }
        }
    }

    function UPDATE_DOCUMENTS_ALL($data, $editUser)
    {
        if ($data[0]) {
            $current_date = date('Y-m-d H:i:s');
            $setColumns = "edit_date=?";
            $queryData = array($current_date);
            $response = null;
            if ($data[1]) {
                $data_1 = $this->getEmployeeTableId($data[1]);
                if (!$data_1) {
                    return $response = array('error_message' => "Employee Id $data[1] Not Found will not be updated");
                }
                $setColumns .= ", col_empl_id=?";
                array_push($queryData, $data_1);
            } else {
                return $response = array('error_message' => 'Some Blank Employee Id Found will not be updated');
            }
            if ($data[2]) {
                $setColumns .= ", col_doc_file=?";
                array_push($queryData, $data[2]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[3]) {
                $setColumns .= ", col_doc_name=?";
                array_push($queryData, $data[3]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }

            if ($editUser) {
                $setColumns .= ", edit_user=?";
                array_push($queryData, $editUser);
            } else {
                return $response = array('error_message' => 'Some blank field will not be updated.');
            }
            try {
                array_push($queryData, $data[0]);
                $sql = "UPDATE tbl_employee_documents SET $setColumns WHERE id=?";
                $this->db->query($sql, $queryData);
                return $response;
            } catch (Exception $e) {
                return array('error_message' => 'Error updating data: ' . $e->getMessage());
            }
        } else {
            $current_date = date('Y-m-d H:i:s');
            $data_1 = null;
            if ($data[1]) {
                $data_1 = $this->getEmployeeTableId($data[1]);
                if (!$data_1) {
                    return $response = array('error_message' => "Employee Id $data[1] Not Found will not be updated");
                }
            } else {
                return $response = array('error_message' => 'Some Blank Employee Id Found will not be updated');
            }
            try {
                $sql = "INSERT INTO tbl_employee_documents (create_date,edit_date,col_empl_id,col_doc_file,col_doc_name,edit_user) VALUES(?,?,?,?,?,?)";
                $this->db->query($sql, array($current_date, $current_date, $data_1, $data[2], $data[3], $editUser));
                return null;
            } catch (Exception $e) {
                return array('error_message' => 'Error updating data: ' . $e->getMessage());
            }
        }
    }

    function UPDATE_WORK_HISTORY($data, $editUser, $userId)
    {
        if ($data[0]) {
            $current_date = date('Y-m-d H:i:s');
            $setColumns = "edit_date=?";
            $queryData = array($current_date);
            $response = null;
            if ($data[1]) {
                $setColumns .= ", company_name=?";
                array_push($queryData, $data[1]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[2]) {
                $setColumns .= ", company_address=?";
                array_push($queryData, $data[2]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[3]) {
                $setColumns .= ", date_start=?";
                array_push($queryData, $data[3]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[4]) {
                $setColumns .= ", date_end=?";
                array_push($queryData, $data[4]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($data[5]) {
                $setColumns .= ", position=?";
                array_push($queryData, $data[5]);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            if ($editUser) {
                $setColumns .= ", edit_user=?";
                array_push($queryData, $editUser);
            } else {
                $response = array('error_message' => 'Some blank field will not be updated');
            }
            try {
                array_push($queryData, $data[0]);
                $sql = "UPDATE tbl_employee_workhistory SET $setColumns WHERE id=?";
                $this->db->query($sql, $queryData);
                return $response;
            } catch (Exception $e) {
                return array('error_message' => 'Error updating data: ' . $e->getMessage());
            }
        } else {
            if (!$userId) return array('error_message' => 'Invalid User Id');
            if (!$editUser) return array('error_message' => 'Invalid User Edit Id');
            $current_date = date('Y-m-d H:i:s');
            try {
                $sql = "INSERT INTO tbl_employee_workhistory (create_date,edit_date,company_name,company_address,date_start,date_end,position,col_empl_id,edit_user) VALUES(?,?,?,?,?,?,?,?,?)";
                $this->db->query($sql, array($current_date, $current_date, $data[1], $data[2], $data[3], $data[4], $data[5], $userId, $editUser));
                return null;
            } catch (Exception $e) {
                return array('error_message' => 'Error updating data: ' . $e->getMessage());
            }
        }
    }

    function GET_WORK_HISTORY_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_workhistory WHERE is_deleted=0 AND col_empl_id=?";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function GET_SKILL_MATRIX_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_skillassign WHERE username = $employee_id AND status = 'Active' AND is_deleted=0 ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function DELETE_EMPL_SKILL($id)
    {
        $sql = "UPDATE tbl_employee_skillassign SET is_deleted=1 WHERE id=?";
        return $this->db->query($sql, array($id));
    }

    function GET_SKILL_MATRIX_SPECIFIC2($id)
    {
        $sql = "SELECT * FROM tbl_employee_skillassign WHERE id=? AND status = 'Active'";
        $query = $this->db->query($sql, array($id));
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

    function GET_SKILL_NAME_ACTIVE()
    {
        $sql = "SELECT id,name FROM tbl_std_skillnames WHERE status='Active'";
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

    function GET_SKILL_LEVEL_ACTIVE()
    {
        $sql = "SELECT id,name FROM tbl_std_skilllevels WHERE status='Active'";
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

    function MOD_DISP_DISTINCT_LINE()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql, array());
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

    function UPDATE_PERSONAL_DET($first_name, $middlename, $lastname, $marital_status, $mobile_number, $birthdate, $gender, $nationality, $shirt_size, $email, $home_address, $current_address, $user_id)
    {

        $sql = "UPDATE tbl_employee_infos SET col_last_name=?,col_midl_name=?,col_frst_name=?,col_mart_stat=?,col_home_addr=?,col_curr_addr=?,col_birt_date=?,col_empl_gend=?,col_empl_nati=?,col_shir_size=?,col_empl_emai=?,col_mobl_numb=? WHERE id=?";
        $query = $this->db->query($sql, array($lastname, $middlename, $first_name, $marital_status, $home_address, $current_address, $birthdate, $gender, $nationality, $shirt_size, $email, $mobile_number, $user_id));
    }

    function UPDATE_EMPLOYMENT_DET($hired_date, $reg_date, $resign_Date, $end_date, $emp_type, $position, $branch, $dept, $division, $clubhouse, $sec, $group, $line, $team, $com_num, $com_email, $hmo_prov, $hmo_num, $termination_reason, $resignation_reason, $termination_date, $user_id)
    {
        // var_dump($position);
        $sql = "UPDATE tbl_employee_infos SET date_regular=?,col_hire_date=?,col_endd_date=?,resignation_date=?,col_empl_type=?,col_empl_posi=?,col_empl_branch=?,col_empl_dept=?,col_empl_divi=?,col_empl_club=?,col_empl_sect=?,col_empl_group=?,col_empl_line=?,col_empl_team=?,col_comp_emai=?,col_comp_numb=?,col_empl_hmoo=?,col_empl_hmon=?,termination_reason=?,resignation_reason=?,termination_date=?  WHERE id=?";
        $query = $this->db->query($sql, array($reg_date, $hired_date, $end_date, $resign_Date, $emp_type, $position, $branch, $dept, $division, $clubhouse, $sec, $group, $line, $team, $com_email, $com_num, $hmo_prov, $hmo_num, $termination_reason, $resignation_reason, $termination_date, $user_id));
    }

    function ADD_EMPLOYEE_LOGS($edit_id, $empl_id, $category, $from_val, $to_val)
    {
        $log_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_logs (log_date, edit_id,empl_id,category,from_val,to_val) VALUES(?,?,?,?,?,?)";
        $this->db->query($sql, array($log_date, $edit_id, $empl_id, $category, $from_val, $to_val));
    }

    function UPDATE_ID_DET($sss, $hdmf, $philhealth, $tin, $driver_lic, $nat_id, $passport, $user_id)
    {
        $sql = "UPDATE tbl_employee_infos SET col_empl_sssc=?,col_empl_hdmf=?,col_empl_phil=?,col_empl_btin=?,col_empl_driv=?,col_empl_naid=?,col_empl_pass=? WHERE id=?";
        $query = $this->db->query($sql, array($sss, $hdmf, $philhealth, $tin, $driver_lic, $nat_id, $passport, $user_id));
    }

    function UPDATE_COMP_DET($salary_type, $salary_rate, $bank, $branch, $acc_type, $payment_type, $acc_num, $user_id)
    {
        $sql = "UPDATE tbl_employee_infos SET salary_rate=?,salary_type=?,bank_name=?,branch_name=?,account_number=?,account_type=?,payment_type=? WHERE id=?";
        $query = $this->db->query($sql, array($salary_rate, $salary_type, $bank, $branch, $acc_num, $acc_type, $payment_type, $user_id));
    }

    function UPDATE_EDUC_DET($degree, $school, $address, $from_yr, $to_yr, $completion, $educ_id, $user_id, $grade, $level)
    {
        $sql = "UPDATE tbl_employee_education SET col_educ_degree=?, col_educ_school=?, col_educ_from_yr=?, col_educ_to_yr=?,address=?,completion=?,col_educ_grade=?,col_educ_level=? WHERE id=?";
        return $this->db->query($sql, array($degree, $school, $from_yr, $to_yr, $address, $completion, $grade, $level, $educ_id));
    }

    function ADD_NEW_EDUC($degree, $school, $address, $from_yr, $to_yr, $completion, $user_id, $grade, $level)
    {
        $sql = "INSERT INTO tbl_employee_education(col_empl_id, col_educ_degree, col_educ_school, col_educ_from_yr, col_educ_to_yr, col_educ_grade, address, completion, col_educ_level)
            VALUE(?,?,?,?,?,?,?,?,?)
        ";
        return $this->db->query($sql, array($user_id, $degree, $school, $from_yr, $to_yr, $grade, $address, $completion, $level));
    }

    function UPDATE_SKILL_DET($title, $level, $skill_id)
    {
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_employee_skillassign SET edit_date=?, name=?, value=?  WHERE id=?";
        return $this->db->query($sql, array($date, $title, $level, $skill_id));
    }

    function ADD_NEW_SKILL($user_id, $level, $skill)
    {
        $date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_skillassign(create_date,edit_date,username,name,value,status) VALUE(?,?,?,?,?,?)";
        return  $this->db->query($sql, array($date, $date, $user_id, $skill, $level, 'Active'));
    }

    function ADD_NEW_DEPENDENT($user_id, $full_name, $b_day, $gender, $relationship)
    {
        $sql = "INSERT INTO tbl_employee_dependents(col_depe_empid, col_depe_name, col_depe_bday, col_depe_gndr, col_depe_rela) VALUE(?,?,?,?,?)";
        return  $this->db->query($sql, array($user_id, $full_name, $b_day, $gender, $relationship));
    }

    function GET_SPECIFIC_DEPENDENT($id)
    {
        $sql = "SELECT * FROM tbl_employee_dependents WHERE id=? LIMIT 1";
        return $this->db->query($sql, array($id))->row_array();
    }

    function UPDATE_SPECIFIC_DEPENDENT($id, $full_name, $b_day, $gender, $relationship)
    {
        $sql = "UPDATE tbl_employee_dependents SET col_depe_name=?, col_depe_bday=?, col_depe_gndr=?, col_depe_rela=? WHERE id=?";
        return  $this->db->query($sql, array($full_name, $b_day, $gender, $relationship, $id));
    }

    function DELETE_DEPENDENT($id)
    {
        $sql = "UPDATE tbl_employee_dependents SET is_deleted=? WHERE id=?";
        return $this->db->query($sql, array(1, $id));
    }

    function UPDTRECORD($filedata)
    {
        if (count($filedata) > 0) {
            $newdate = str_replace('/', '-', $filedata[7]);
            $birthday = date("Y-m-d", strtotime($newdate));
            $newdate_2 = str_replace('/', '-', $filedata[15]);
            $hired_on = date("Y-m-d", strtotime($newdate_2));
            if ((substr(strval($filedata[13]), 0, 1) == '9') || (substr(strval($filedata[13]), 0, 1) == 9)) {
                $mobile_number = '0' . strval($filedata[13]);
            } else {
                $mobile_number = ($filedata[13]);
            }
            if ((substr(strval($filedata[14]), 0, 1) == '9') || (substr(strval($filedata[14]), 0, 1) == 9)) {
                $work_phone_number = '0' . strval($filedata[14]);
            } else {
                $work_phone_number = ($filedata[14]);
            }
            $employee_cmid = strval($filedata[0]);
            $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE_BASED_CMID($filedata[0]);
            $username = str_pad($employee_cmid, 5, "0", STR_PAD_LEFT);
            $sql = "UPDATE tbl_employee_infos SET col_user_name=? ,col_last_name = ?,col_midl_name = ?,col_frst_name = ?,col_mart_stat = ?,col_home_addr = ?,col_curr_addr = ?,col_birt_date = ?,col_empl_gend = ?,col_empl_nati = ?,col_shir_size = ?,col_empl_emai = ?,col_comp_emai = ?,col_mobl_numb = ?,col_comp_numb = ?,col_hire_date = ?,col_empl_type = ?,col_empl_posi = ?,col_empl_group = ?,col_empl_line = ?,col_empl_dept = ?,col_empl_sect = ?,col_imag_path = ?,col_empl_sssc = ?,col_empl_hdmf = ?,col_empl_phil = ?,col_empl_btin = ?,col_empl_driv = ?,col_empl_naid = ?,col_empl_pass = ?,col_empl_hmoo = ?,col_empl_hmon = ?,salary_rate = ?,salary_type = ?,pioneer_allowance = ?,load_allowance = ?,skill_allowance = ?,group_leader_allowance = ?,transpo_allowance = ?,sch1_name=?,sch1_deg=?,sch1_from=?,sch1_to=?,sch1_gwa=?,sch2_name=?,sch2_deg=?,sch2_from=?,sch2_to=?,sch2_gwa=?,sch3_name=?,sch3_deg=?,sch3_from=?,sch3_to=?,sch3_gwa=?,skill_name1=?,skill_lvl1=?,skill_name2=?,skill_lvl2=?,emer_cont_name=?,emer_cont_rel=?,emer_cont_num=?,emer_cont_workphone=?,emer_cont_homephone=?,emer_cont_add=?,dep_name1=?,dep_birth1=?,dep_gend1=?,dep_rel1=?,dep_name2=?,dep_birth2=?,dep_gend2=?,dep_rel2=?,dep_name3=?,dep_birth3=?,dep_gend3=?,dep_rel3=?,dep_name4=?,dep_birth4=?,dep_gend4=?,dep_rel4=? WHERE col_empl_cmid=?";
            $this->db->query($sql, array($username, $filedata[1], $filedata[2], $filedata[3], $filedata[4], $filedata[5], $filedata[6], $birthday, $filedata[8], $filedata[9], $filedata[10], $filedata[11], $filedata[12], $mobile_number, $work_phone_number, $hired_on, $filedata[16], $filedata[17], $filedata[18], $filedata[19], $filedata[20], $filedata[21], $filedata[22], $filedata[23], $filedata[24], $filedata[25], $filedata[26], $filedata[27], $filedata[28], $filedata[29], $filedata[30], $filedata[31], $filedata[32], $filedata[33], $filedata[34], $filedata[35], $filedata[36], $filedata[37], $filedata[38], $filedata[39], $filedata[40], $filedata[41], $filedata[42], $filedata[43], $filedata[44], $filedata[45], $filedata[46], $filedata[47], $filedata[48], $filedata[49], $filedata[50], $filedata[51], $filedata[52], $filedata[53], $filedata[54], $filedata[55], $filedata[56], $filedata[57], $filedata[58], $filedata[59], $filedata[60], $filedata[61], $filedata[62], $filedata[63], $filedata[64], $filedata[65], $filedata[66], $filedata[67], $filedata[68], $filedata[69], $filedata[70], $filedata[71], $filedata[72], $filedata[73], $filedata[74], $filedata[75], $filedata[76], $filedata[77], $filedata[78], $filedata[79], $employee_cmid));
        }
    }

    function CHECKDUPLICATEEMPLID($employee_id)
    {
        $sql = "SELECT col_empl_cmid FROM tbl_employee_infos WHERE col_empl_cmid = ?";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_EMPLOYEES_LIMIT2($offset, $row, $dept, $sec, $group, $line, $branch, $division, $team, $status, $disabled, $company)
    {
        $filter_q = "";
        if ($dept) {
            $filter_q .= " AND col_empl_dept=" . $dept;
        }
        if ($sec) {
            $filter_q .= " AND col_empl_sect=" . $sec;
        }
        if ($group) {
            $filter_q .= " AND col_empl_group=" . $group;
        }
        if ($line) {
            $filter_q .= " AND col_empl_line=" . $line;
        }
        if ($branch) {
            $filter_q .= " AND col_empl_branch=" . $branch;
        }
        if ($division) {
            $filter_q .= " AND col_empl_divi=" . $division;
        }
        if ($team) {
            $filter_q .= " AND col_empl_team=" . $team;
        }
        if ($company) {
            $filter_q .= " AND col_empl_company=" . $company;
        }
        if ($disabled) {
            $filter_q .= " AND disabled=" . $disabled;
        } else {
            $filter_q .= " AND disabled=0";
        }

        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') " . $filter_q . " ORDER BY col_empl_cmid + 0 ASC  LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_EMPLOYEES_LIMIT_DIRECTORIES($offset, $row, $dept, $sec, $group, $line, $branch, $division, $clubhouse, $team, $status, $company, $employment_type)
    {
        $filter_q = "";
        if ($dept) {
            $filter_q .= " AND col_empl_dept=" . $dept;
        }
        if ($sec) {
            $filter_q .= " AND col_empl_sect=" . $sec;
        }
        if ($group) {
            $filter_q .= " AND col_empl_group=" . $group;
        }
        if ($line) {
            $filter_q .= " AND col_empl_line=" . $line;
        }
        if ($branch) {
            $filter_q .= " AND col_empl_branch=" . $branch;
        }
        if ($division) {
            $filter_q .= " AND col_empl_divi=" . $division;
        }
        if ($clubhouse) {
            $filter_q .= " AND col_empl_club=" . $clubhouse;
        }
        if ($team) {
            $filter_q .= " AND col_empl_team=" . $team;
        }
        if ($company) {
            $filter_q .= " AND col_empl_company=" . $company;
        }
        if ($employment_type) {
            $filter_q .= " AND col_empl_type=" . $employment_type;
        }

        $filter_q .= " AND disabled=0";

        $sql = "SELECT * FROM tbl_employee_infos 
            WHERE (termination_date IS NULL OR termination_date = '0000-00-00') " . $filter_q . " 
            ORDER BY col_empl_cmid + 0 ASC
            LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_EMPLOYEES_LIMIT($offset, $row, $dept, $sec, $group, $line, $branch, $division, $team, $status, $company)
    {
        $filter_q = "";
        if ($dept) {
            $filter_q .= " AND col_empl_dept=" . $dept;
        }
        if ($sec) {
            $filter_q .= " AND col_empl_sect=" . $sec;
        }
        if ($group) {
            $filter_q .= " AND col_empl_group=" . $group;
        }
        if ($line) {
            $filter_q .= " AND col_empl_line=" . $line;
        }
        if ($branch) {
            $filter_q .= " AND col_empl_branch=" . $branch;
        }
        if ($division) {
            $filter_q .= " AND col_empl_divi=" . $division;
        }
        if ($team) {
            $filter_q .= " AND col_empl_team=" . $team;
        }
        if ($company) {
            $filter_q .= " AND col_empl_company=" . $company;
        }

        $filter_q .= " AND disabled=0";

        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') " . $filter_q . " ORDER BY LENGTH(col_empl_cmid), col_empl_cmid  LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_SEARCH_EMPLOYEES_DIRECTORY($search)
    {
        $sql = "SELECT tbl_employee_infos.* FROM tbl_employee_infos
        WHERE id=?
        ";
        $query = $this->db->query($sql, array($search));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_SEARCH_EMPLOYEES($search, $status)
    {
        $sql = "SELECT tbl_employee_infos.* FROM tbl_employee_infos
        LEFT JOIN tbl_std_departments ON tbl_std_departments.id = tbl_employee_infos.col_empl_dept
        LEFT JOIN tbl_std_employeetypes ON tbl_std_employeetypes.id = tbl_employee_infos.col_empl_type
        LEFT JOIN tbl_std_positions ON tbl_std_positions.id = tbl_employee_infos.col_empl_posi
        LEFT JOIN tbl_std_sections ON tbl_std_sections.id = tbl_employee_infos.col_empl_sect
        LEFT JOIN tbl_std_groups ON tbl_std_groups.id = tbl_employee_infos.col_empl_group
        LEFT JOIN tbl_std_lines ON tbl_std_lines.id = tbl_employee_infos.col_empl_line
        WHERE tbl_employee_infos.disabled=0 AND  (termination_date IS NULL OR termination_date = '0000-00-00') AND ( tbl_employee_infos.id  LIKE '%$search%'
        OR tbl_employee_infos.col_last_name LIKE '%$search%'
        OR tbl_employee_infos.col_frst_name LIKE '%$search%'
        OR tbl_employee_infos.col_midl_name LIKE '%$search%'
        OR tbl_std_departments.name LIKE '%$search%'
        OR tbl_std_employeetypes.name LIKE '%$search%'
        OR tbl_std_positions.name LIKE '%$search%'
        OR tbl_std_sections.name LIKE '%$search%'
        OR tbl_std_groups.name LIKE '%$search%'
        OR tbl_std_lines.name LIKE '%$search%' )
        ORDER BY tbl_employee_infos.id DESC";

        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_SEARCHED_DATA($search)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE col_frst_name LIKE '$search%' OR col_last_name LIKE '$search%' OR col_midl_name LIKE '$search%' OR col_empl_emai LIKE '$search%' OR col_mobl_numb LIKE '$search%' AND isSuperAdmin != 1 AND termination_type=0 ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
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

            $sqlActiveTotal = "SELECT COUNT(*) as count FROM tbl_employee_infos WHERE disabled=0 AND (termination_date IS NULL OR termination_date = '0000-00-00')";
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

    function CHECK_ACTIVE_LIMIT($type, $active, $add)
    {
        if ($type != 'all' && $type != 'add') {
            return array('messageError', 'Prohibited');
        }
        $finalActiveTotal = null;
        $sqlLimit = "SELECT value FROM tbl_system_setup WHERE setting='max_active_user'";
        $limit = $this->db->query($sqlLimit);
        if (!$limit) {
            return array('messageError' => 'Getting limit Error');
        }
        $finalLimit = $limit->row()->value;

        if ($type === 'all') {
            $finalActiveTotal = $active;
            if ($finalLimit < $finalActiveTotal) {
                $difference = $finalActiveTotal - $finalLimit;
                $reduce = $difference;
                return array('messageError' => "Change was not saved. Max user limit. Make " . $reduce . " Inactive ");
            }
        }
        if ($type === 'add') {
            $sqlActiveTotal = "SELECT COUNT(*) as count FROM tbl_employee_infos WHERE disabled=0 AND (termination_date IS NULL OR termination_date = '0000-00-00')";
            $activeTotal = $this->db->query($sqlActiveTotal);
            if ($activeTotal && $activeTotal->num_rows() < 1 && $activeTotal->row()->count < 1) {
                return array('messageError' => 'Maximum Active Count is Zero and below');
            }
            $finalActiveTotal = $add + $activeTotal->row()->count;
            if ($finalLimit < $finalActiveTotal) {
                $difference = $finalActiveTotal - $finalLimit;
                $reduce = $difference;
                return array('messageError' => "Add was not saved. Max user limit. Make " . $reduce . " Inactive ");
            }
        }
        return null;
    }

    function MOD_INSRT_EMPLOYEE($empl_cmid, $last_name, $middle_name, $first_name, $email, $birthday, $gender, $mobile_num, $hired_on, $empl_type, $position, $department, $section, $group, $line, $home_address, $current_address, $marital_status, $nationality, $shirt_size, $salary_rate, $salary_type)
    {
        $salt = bin2hex(openssl_random_pseudo_bytes(22));
        $password = ucfirst($last_name . '.' . date_format(date_create($birthday), "Y"));
        $encrypted_password = md5($password . '' . $salt);
        $empl_username = str_pad($empl_cmid, 5, "0", STR_PAD_LEFT);
        $sql = "INSERT INTO tbl_employee_infos(col_empl_cmid,col_user_date,col_user_name,col_user_pass,col_salt_key,col_last_name,col_midl_name,col_frst_name,col_empl_emai,col_birt_date,col_empl_gend,col_mobl_numb,col_hire_date,col_empl_type,col_empl_posi,col_empl_dept,col_empl_sect,col_empl_group,col_empl_line,col_home_addr,col_curr_addr,col_mart_stat,col_empl_nati,col_shir_size,salary_rate,salary_type,col_user_access) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($empl_cmid, date('Y-m-d H:i:s'), $empl_username, $encrypted_password, $salt, $last_name, $middle_name, $first_name, $email, $birthday, $gender, $mobile_num, $hired_on, $empl_type, $position, $department, $section, $group, $line, $home_address, $current_address, $marital_status, $nationality, $shirt_size, $salary_rate, $salary_type, $empl_type));
        return $this->db->insert_id();
    }

    function test($first_name, $birthdate)
    {
        $salt = bin2hex(openssl_random_pseudo_bytes(22));
        $clean_password = ucfirst($last_name . '@' . date_format(date_create($birthdate), "mdY"));
        $encrypted_password = md5($clean_password . '' . $salt);
        echo $salt;
        echo "<br>";
        echo "Encrpted password " . $encrypted_password;
        $decrypted_password = md5($clean_password . '' . $salt);
        echo "<br>";
        echo "Decripted Password " . $decrypted_password;
    }

    function INSERT_EMPLOYEE_IMAGE($user_img, $userID)
    {
        $sql = "UPDATE tbl_employee_infos SET col_imag_path=? WHERE id=?";
        $query = $this->db->query($sql, array($user_img, $userID));
    }

    function MOD_GET_FILTER_DATA($department, $line, $group, $section, $status)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE " . $department . " AND " . $line . " AND " . $group . " AND " . $section . " AND " . $status . " AND isSuperAdmin != 1";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_FILTER_DATA_DEPARTMENT($department, $line, $group, $section, $status)
    {
        $sql = "SELECT DISTINCT col_empl_dept FROM tbl_employee_infos WHERE " . $department . " AND " . $line . " AND " . $group . " AND " . $section . " AND " . $status . " AND isSuperAdmin != 1";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_FILTER_DATA_SECTION($department, $line, $group, $section, $status)
    {
        $sql = "SELECT DISTINCT col_empl_sect FROM tbl_employee_infos WHERE " . $department . " AND " . $line . " AND " . $group . " AND " . $section . " AND " . $status . " AND isSuperAdmin != 1";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_FILTER_DATA_GROUP($department, $line, $group, $section, $status)
    {
        $sql = "SELECT DISTINCT col_empl_group FROM tbl_employee_infos WHERE " . $department . " AND " . $line . " AND " . $group . " AND " . $section . " AND " . $status . " AND isSuperAdmin != 1";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_FILTER_DATA_LINE($department, $line, $group, $section, $status)
    {
        $sql = "SELECT DISTINCT col_empl_line FROM tbl_employee_infos WHERE " . $department . " AND " . $line . " AND " . $group . " AND " . $section . " AND " . $status . " AND isSuperAdmin != 1";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_EMPLOYEES()
    {
        $sql = "SELECT col_empl_cmid,col_last_name,col_suffix,col_frst_name,col_midl_name FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 ORDER BY col_empl_cmid + 0 ASC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function FILTER_EMPLOYEE_COUNT2($dept, $sec, $group, $line, $branch, $division, $team, $status, $disabled, $company)
    {

        $filter_q = '';
        if ($dept) {
            $filter_q .= " AND col_empl_dept=" . $dept;
        }
        if ($sec) {
            $filter_q .= " AND col_empl_sect=" . $sec;
        }
        if ($group) {
            $filter_q .= " AND col_empl_group=" . $group;
        }
        if ($line) {
            $filter_q .= " AND col_empl_line=" . $line;
        }
        if ($branch) {
            $filter_q .= " AND col_empl_branch=" . $branch;
        }
        if ($division) {
            $filter_q .= " AND col_empl_divi=" . $division;
        }
        if ($team) {
            $filter_q .= " AND col_empl_team=" . $team;
        }
        if ($company) {
            $filter_q .= " AND col_empl_company=" . $company;
        }
        if ($disabled) {
            $filter_q .= " AND disabled=" . $disabled;
        } else {
            $filter_q .= " AND disabled= 0";
        }
        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') " . $filter_q . " ORDER BY col_empl_cmid + 0 ASC ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function FILTER_EMPLOYEE_COUNT_DIRECTORIES($dept, $sec, $group, $line, $branch, $division, $clubhouse, $team, $status, $company, $employment_type)
    {

        $filter_q = '';
        if ($dept) {
            $filter_q .= " AND col_empl_dept=" . $dept;
        }
        if ($sec) {
            $filter_q .= " AND col_empl_sect=" . $sec;
        }
        if ($group) {
            $filter_q .= " AND col_empl_group=" . $group;
        }
        if ($line) {
            $filter_q .= " AND col_empl_line=" . $line;
        }
        if ($branch) {
            $filter_q .= " AND col_empl_branch=" . $branch;
        }
        if ($division) {
            $filter_q .= " AND col_empl_divi=" . $division;
        }
        if ($clubhouse) {
            $filter_q .= " AND col_empl_club=" . $clubhouse;
        }
        if ($team) {
            $filter_q .= " AND col_empl_team=" . $team;
        }
        if ($company) {
            $filter_q .= " AND col_empl_company=" . $company;
        }
        if ($employment_type) {
            $filter_q .= " AND col_empl_type=" . $employment_type;
        }

        $filter_q .= " AND disabled= 0";

        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') " . $filter_q . " ORDER BY col_empl_cmid + 0 ASC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function FILTER_EMPLOYEE_COUNT($dept, $sec, $group, $line, $branch, $division, $team, $status, $company)
    {

        $filter_q = '';
        if ($dept) {
            $filter_q .= " AND col_empl_dept=" . $dept;
        }
        if ($sec) {
            $filter_q .= " AND col_empl_sect=" . $sec;
        }
        if ($group) {
            $filter_q .= " AND col_empl_group=" . $group;
        }
        if ($line) {
            $filter_q .= " AND col_empl_line=" . $line;
        }
        if ($branch) {
            $filter_q .= " AND col_empl_branch=" . $branch;
        }
        if ($division) {
            $filter_q .= " AND col_empl_divi=" . $division;
        }
        if ($team) {
            $filter_q .= " AND col_empl_team=" . $team;
        }
        if ($company) {
            $filter_q .= " AND col_empl_company=" . $company;
        }

        $filter_q .= " AND disabled= 0";

        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') " . $filter_q . " ORDER BY col_empl_cmid + 0 ASC ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_ACTIVE_COUNT()
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled = 0";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }

    function MOD_DISP_SPEC_ACTIVE_COUNT($col_empl_type)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled = 0 AND col_empl_type = $col_empl_type";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }

    function MOD_DISP_ALL_EMPLOYEES_PAGINATION($num_start, $num_limit)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 AND isSuperAdmin != 1 ORDER BY LENGTH(col_empl_cmid), col_empl_cmid LIMIT ?,?";
        $query = $this->db->query($sql, array($num_start, $num_limit));
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

    function GET_EMPL_CMID($empl_cmid)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE col_empl_cmid=? ";
        $query = $this->db->query($sql, array($empl_cmid));
        return $query->num_rows();
    }

    function GET_SYSTEM_SETTING($setting)
    {
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = ? ";
        $query = $this->db->query($sql, array($setting));
        $result = $query->row();
        if ($result) {
            return $result->value;
        }
        return '';
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

    function GET_ALLOWANCE_TYPES()
    {
        $sql = "SELECT * FROM tbl_std_allowances WHERE status = 'Active' ORDER BY id ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_TAXABLE_ALLOWANCE_TYPES()
    {
        $sql = "SELECT * FROM tbl_std_allowances_tax WHERE status = 'Active' ORDER BY id ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_NON_TAXABLE_ALLOWANCE_TYPES()
    {
        $sql = "SELECT * FROM tbl_std_allowances_nontax WHERE status = 'Active' ORDER BY id ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_TAXABLE_DEDUCTION_TYPES()
    {
        $sql = "SELECT * FROM tbl_std_deductions_tax WHERE status = 'Active' ORDER BY id ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_NON_TAXABLE_DEDUCTION_TYPES()
    {
        $sql = "SELECT * FROM tbl_std_deductions_nontax WHERE status = 'Active' ORDER BY id ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_CUTOFF_PERIOD_DATE($cutoff)
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE id=?";
        $query = $this->db->query($sql, array($cutoff));
        return $query->row_array();
    }

    function GET_APPROVED_OT($cutoff, $id)
    {

        $cutoff_dates = $this->GET_CUTOFF_PERIOD_DATE($cutoff);
        $date_from = $cutoff_dates['date_from'];
        $date_to = $cutoff_dates['date_to'];

        $sql = "SELECT empl_id, SUM(hours) AS total_hours FROM tbl_overtimes WHERE empl_id = ? AND date_ot BETWEEN ? AND ? AND status = 'Approved'";
        $query = $this->db->query($sql, array($id, $date_from, $date_to));
        return $query->result_array();
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

        $sql = "SELECT id,reporting_to,col_empl_cmid,
        col_last_name,col_imag_path,col_midl_name,col_frst_name,extra_posi
        FROM tbl_employee_infos 
        WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled = 0
        AND col_empl_branch = $branch
        AND col_empl_dept   = $dept
        AND col_empl_divi   = $division
        AND col_empl_sect   = $section
        AND col_empl_group  = $group
        AND col_empl_team   = $team
        AND col_empl_line   = $line
        ORDER BY col_empl_cmid + 0 ASC
        LIMIT " . $offset . ", " . $row . " ";

        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_FILTERED_EMPLOYEELIST_TABLE($offset, $row, $branch, $dept, $division, $clubhouse, $section, $group, $team, $line, $company)
    {

        $conditions = [];
        $parameters = [];

        if ($branch !== "all" && isset($branch) && $branch !== "undefined") {
            $conditions[] = "col_empl_branch = ?";
            $parameters[] = $branch;
        }

        if ($dept !== "all" && isset($dept) && $dept !== "undefined") {
            $conditions[] = "col_empl_dept = ?";
            $parameters[] = $dept;
        }

        if ($division !== "all" && isset($division) && $division !== "undefined") {
            $conditions[] = "col_empl_divi = ?";
            $parameters[] = $division;
        }

        if ($clubhouse !== "all" && isset($clubhouse) && $clubhouse !== "undefined") {
            $conditions[] = "col_empl_club = ?";
            $parameters[] = $clubhouse;
        }

        if ($section !== "all" && isset($section) && $section !== "undefined") {
            $conditions[] = "col_empl_sect = ?";
            $parameters[] = $section;
        }

        if ($group !== "all" && isset($group) && $group !== "undefined") {
            $conditions[] = "col_empl_group = ?";
            $parameters[] = $group;
        }

        if ($team !== "all" && isset($team) && $team !== "undefined") {
            $conditions[] = "col_empl_team = ?";
            $parameters[] = $team;
        }

        if ($line !== "all" && isset($line) && $line !== "undefined") {
            $conditions[] = "col_empl_line = ?";
            $parameters[] = $line;
        }

        if ($company !== "all" && isset($company)  && $company !== "undefined") {
            $conditions[] = "col_empl_company = ?";
            $parameters[] = $company;
        }

        $whereClause = (!empty($conditions)) ? "AND " . implode(" AND ", $conditions) : "";

        $sql = "SELECT id,col_empl_cmid, 
        CONCAT_WS('', col_last_name, 
        CASE WHEN col_suffix IS NOT NULL AND col_suffix <> '' THEN CONCAT(' ',col_suffix) ELSE '' END, 
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name <> '' THEN CONCAT(', ',col_frst_name, ' ') ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name <> '' THEN CONCAT(' ', col_midl_name) ELSE '' END) 
        as fullname, salary_rate, salary_type, salary_no_work_with_pay AS nwwp FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled = 0
        $whereClause
        ORDER BY col_empl_cmid + 0 ASC
        LIMIT " . $offset . ", " . $row . " ";

        $query = $this->db->query($sql, $parameters);
        $query->next_result();
        return $query->result();
    }
    function GET_FILTERED_SETUP_ORGANIZATION_TABLE($offset, $row, $branch, $dept, $division, $clubhouse, $section, $group, $team, $line, $company, $id)
    {

        $conditions = array();
        $params = array();
        if ($branch != "all") {
            $conditions[] = "tb1.col_empl_branch = ?";
            $params[] = $branch;
        }
        if ($dept != "all") {
            $conditions[] = "tb1.col_empl_dept = ?";
            $params[] = $dept;
        }
        if ($division != "all") {
            $conditions[] = "tb1.col_empl_divi = ?";
            $params[] = $division;
        }
        if ($clubhouse != "all") {
            $conditions[] = "tb1.col_empl_club = ?";
            $params[] = $clubhouse;
        }
        if ($section != "all") {
            $conditions[] = "tb1.col_empl_sect = ?";
            $params[] = $section;
        }
        if ($group != "all") {
            $conditions[] = "tb1.col_empl_group = ?";
            $params[] = $group;
        }
        if ($team != "all") {
            $conditions[] = "tb1.col_empl_team = ?";
            $params[] = $team;
        }
        if ($line != "all") {
            $conditions[] = "tb1.col_empl_line = ?";
            $params[] = $line;
        }
        if ($company != "all") {
            $conditions[] = "tb1.col_empl_company = ?";
            $params[] = $company;
        }
        if ($id != "all") {
            $conditions[] = "tb1.id = ?";
            $params[] = $id;
        }

        $whereClause = implode(" AND ", $conditions);

        $sql = "SELECT tb1.id, tb1.col_empl_cmid, tb1.extra_posi, tb2.reporting_to,
        CONCAT_WS('', 
        CONCAT(tb1.col_empl_cmid, '-', tb1.col_last_name), 
        CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix <> '' THEN CONCAT(' ',tb1.col_suffix) ELSE '' END,
        CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name <> '' THEN CONCAT(', ',tb1.col_frst_name) ELSE '' END, 
        CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name <> '' THEN CONCAT(' ',LEFT(tb1.col_midl_name,1), '.') ELSE '' END)
        as fullname,
        CASE 
            WHEN (tb2.termination_date IS NULL OR tb2.termination_date = '0000-00-00') THEN 
            
            CONCAT_WS('', 
            CONCAT(tb2.col_empl_cmid, '-', tb2.col_last_name), 
            CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> '' THEN CONCAT(' ',tb2.col_suffix) ELSE '' END, 
            
            CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name <> '' THEN CONCAT(', ',tb2.col_frst_name) ELSE '' END, 
            CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> '' THEN CONCAT(' ',LEFT(tb2.col_midl_name,1), '.') ELSE '' END)

            ELSE NULL
        END as reportingto
                
        FROM tbl_employee_infos AS tb1
        LEFT JOIN tbl_employee_infos AS tb2 ON tb1.reporting_to = tb2.id
        WHERE (tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00') AND tb1.disabled = 0
        " . ($whereClause ? "AND $whereClause" : "") . "
        ORDER BY tb1.col_empl_cmid + 0 ASC
        LIMIT ?, ?";

        $params[] = intval($offset);
        $params[] = intval($row);
        // $params[] = $offset;
        // $params[] = $row;

        $query = $this->db->query($sql, $params);
        $query->next_result();
        return $query->result();
    }
    function GET_FILTERED_SETUP_ORGANIZATION_TABLE_COUNT($branch, $dept, $division, $clubhouse, $section, $group, $team, $line, $company, $id)
    {

        $conditions = array();
        $params = array();
        if ($branch != "all") {
            $conditions[] = "tb1.col_empl_branch = ?";
            $params[] = $branch;
        }
        if ($dept != "all") {
            $conditions[] = "tb1.col_empl_dept = ?";
            $params[] = $dept;
        }
        if ($division != "all") {
            $conditions[] = "tb1.col_empl_divi = ?";
            $params[] = $division;
        }
        if ($clubhouse != "all") {
            $conditions[] = "tb1.col_empl_club = ?";
            $params[] = $clubhouse;
        }
        if ($section != "all") {
            $conditions[] = "tb1.col_empl_sect = ?";
            $params[] = $section;
        }
        if ($group != "all") {
            $conditions[] = "tb1.col_empl_group = ?";
            $params[] = $group;
        }
        if ($team != "all") {
            $conditions[] = "tb1.col_empl_team = ?";
            $params[] = $team;
        }
        if ($line != "all") {
            $conditions[] = "tb1.col_empl_line = ?";
            $params[] = $line;
        }
        if ($company != "all") {
            $conditions[] = "tb1.col_empl_company = ?";
            $params[] = $company;
        }
        if ($id != "all") {
            $conditions[] = "tb1.id = ?";
            $params[] = $id;
        }

        $whereClause = implode(" AND ", $conditions);

        $sql = "SELECT tb1.id, tb1.col_empl_cmid, tb1.extra_posi, tb2.reporting_to,
        CONCAT(tb1.col_empl_cmid,'-',tb1.col_last_name,', ',tb1.col_frst_name,' ', tb1.col_midl_name) as fullname,
        CASE 
            WHEN (tb2.termination_date IS NULL OR tb2.termination_date = '0000-00-00') THEN CONCAT(tb2.col_empl_cmid,'-',tb2.col_last_name, ', ', tb2.col_frst_name,' ', tb2.col_midl_name)
            ELSE NULL
        END as reportingto
                
        FROM tbl_employee_infos AS tb1
        LEFT JOIN tbl_employee_infos AS tb2 ON tb1.reporting_to = tb2.id
        WHERE (tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00') AND tb1.disabled = 0
        " . ($whereClause ? "AND $whereClause" : "") . "
        ORDER BY tb1.col_empl_cmid ASC
        ";

        // $params[] = intval($offset);
        // $params[] = intval($row);
        // $params[] = $offset;
        // $params[] = $row;

        // $query = $this->db->query($sql);
        // return $query->num_rows();

        $query = $this->db->query($sql, $params);
        return $query->num_rows();
        // $query->next_result();
        // return $query->result();
    }
    function GET_FILTERED_SETUP_ORGANIZATION_TABLE_test($offset, $row, $branch, $dept, $division, $section, $group, $team, $line, $company)
    {
        $conditions = array();
        $params = array();
        $sql = "SELECT tb1.id, tb1.col_empl_cmid, tb1.extra_posi, tb2.reporting_to,
    CONCAT(tb1.col_empl_cmid,'-',tb1.col_last_name,', ',tb1.col_frst_name,' ', tb1.col_midl_name) as fullname,
    CASE 
        WHEN (tb2.termination_date IS NULL OR tb2.termination_date = '0000-00-00') THEN CONCAT(tb2.col_empl_cmid,'-',tb2.col_last_name, ', ', tb2.col_frst_name,' ', tb2.col_midl_name)
        ELSE NULL
    END as reportingto
                
    FROM tbl_employee_infos AS tb1
    LEFT JOIN tbl_employee_infos AS tb2 ON tb1.reporting_to = tb2.id
    WHERE (tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00') AND tb1.disabled = 0 ";

        if ($branch != "all") {
            $conditions[] = "tb1.col_empl_branch = ?";
            $params[] = $branch;
        }

        if (!empty($conditions)) {
            $sql .= "AND " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY tb1.col_empl_cmid ASC LIMIT ?, ?";

        $params[] = $offset;
        $params[] = $row;

        $query = $this->db->query($sql, $params);

        if ($query === false) {
            return false;
        }
        $query->next_result();
        return $query->result();
    }


    function GET_FILTERED_EMPLOYEELIST_COUNT($branch, $dept, $division, $clubhouse, $section, $group, $team, $line, $company)
    {
        $conditions = [];
        $parameters = [];

        if ($branch !== "all" && isset($branch) && $branch !== "undefined") {
            $conditions[] = "col_empl_branch = ?";
            $parameters[] = $branch;
        }

        if ($dept !== "all" && isset($dept) && $dept !== "undefined") {
            $conditions[] = "col_empl_dept = ?";
            $parameters[] = $dept;
        }

        if ($division !== "all" && isset($division) && $division !== "undefined") {
            $conditions[] = "col_empl_divi = ?";
            $parameters[] = $division;
        }

        if ($clubhouse !== "all" && isset($clubhouse) && $clubhouse !== "undefined") {
            $conditions[] = "col_empl_club = ?";
            $parameters[] = $clubhouse;
        }

        if ($section !== "all" && isset($section) && $section !== "undefined") {
            $conditions[] = "col_empl_sect = ?";
            $parameters[] = $section;
        }

        if ($group !== "all" && isset($group) && $group !== "undefined") {
            $conditions[] = "col_empl_group = ?";
            $parameters[] = $group;
        }

        if ($team !== "all" && isset($team) && $team !== "undefined") {
            $conditions[] = "col_empl_team = ?";
            $parameters[] = $team;
        }

        if ($line !== "all" && isset($line) && $line !== "undefined") {
            $conditions[] = "col_empl_line = ?";
            $parameters[] = $line;
        }

        if ($company !== "all" && isset($company)  && $company !== "undefined") {
            $conditions[] = "col_empl_company = ?";
            $parameters[] = $company;
        }

        $whereClause = (!empty($conditions)) ? "AND " . implode(" AND ", $conditions) : "";

        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,col_empl_line,salary_rate,salary_type,col_empl_company FROM tbl_employee_infos 
        WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled = 0
        $whereClause
        ORDER BY col_empl_cmid + 0 ASC";

        $query = $this->db->query($sql, $parameters);
        return $query->num_rows();
    }


    function GET_SEARCHED($search)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 
        AND (tbl_employee_infos.col_empl_cmid LIKE '%$search%' 
        OR CONCAT(col_last_name, ' ', col_frst_name, ' ', col_midl_name) LIKE '%$search%'
        OR CONCAT(col_last_name, ', ', col_frst_name, ' ', col_midl_name) LIKE '%$search%')  
        ORDER BY id ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_SEARCHED_SALARY_DETAILS($search)
    {

        $sql = "SELECT id,col_empl_cmid, 
        CONCAT_WS(' ', col_last_name, 
        CASE WHEN col_suffix IS NOT NULL AND col_suffix <> '' THEN CONCAT(col_suffix, ', ') ELSE '' END, 
        col_last_name, 
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name <> '' THEN CONCAT(' ', col_midl_name) ELSE '' END)
        as fullname, salary_rate, salary_type 
        FROM tbl_employee_infos 
        WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled = 0 AND id=? ORDER BY id ASC
        ";
        $query = $this->db->query($sql, array($search));
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_EMPLOYEELIST()
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00')";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }

    function GET_YEARS()
    {
        $sql = "SELECT id,name FROM tbl_std_years";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALLOWANCE_DATA($year)
    {
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_allowanceassign WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALLOWANCE_TAX_DATA($year)
    {
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_allowanceassigntax WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_EMPLOYEES()
    {
        $this->db->select('id,reporting_to,col_empl_cmid,
        col_last_name,col_midl_name,col_frst_name')
            ->where("(termination_date IS NULL OR termination_date = '0000-00-00')")
            ->where('disabled', 0);
        $query = $this->db->get('tbl_employee_infos');
        return $query->result_object();
    }

    function GET_ALLOWANCE_NON_TAX_DATA($year)
    {
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_allowanceassignnontax WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    // function GET_DEDUCTION_TAX_DATA($year)
    // {
    //     $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_deductionassigntax WHERE year = $year GROUP BY name,year,username";
    //     $query = $this->db->query($sql, array());
    //     $query->next_result();
    //     return $query->result();
    // }

    function GET_DEDUCTION_NON_TAX_DATA($year)
    {
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_deductionassignnontax WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_CUTOFF_PERIOD()
    {
        $sql = "SELECT * FROM tbl_payroll_period ORDER BY id DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function IS_DUPLICATE($user_id, $year, $type)
    {
        $sql = "SELECT id FROM tbl_employee_allowanceassign WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql, array($user_id, $year, $type));
        $query->next_result();
        $data = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }

    function IS_DUPLICATE_ALLOWANCE_TAX($user_id, $year, $type)
    {
        $sql = "SELECT id FROM tbl_employee_allowanceassigntax WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql, array($user_id, $year, $type));
        $query->next_result();
        $data = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }

    function IS_DUPLICATE_ALLOWANCE_NONTAX($user_id, $year, $type)
    {
        $sql = "SELECT id FROM tbl_employee_allowanceassignnontax WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql, array($user_id, $year, $type));
        $query->next_result();
        $data = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }

    // function IS_DUPLICATE_DEDUCTION_TAX($user_id, $year, $type)
    // {
    //     $sql = "SELECT id FROM tbl_employee_deductionassigntax WHERE username=? AND year=? AND name=?";
    //     $query = $this->db->query($sql, array($user_id, $year, $type));
    //     $query->next_result();
    //     $data = $query->result();
    //     if (empty($data)) {
    //         return 0;
    //     }
    //     return 1;
    // }

    function IS_DUPLICATE_DEDUCTION_NONTAX($user_id, $year, $type)
    {
        $sql = "SELECT id FROM tbl_employee_deductionassignnontax WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql, array($user_id, $year, $type));
        $query->next_result();
        $data = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }

    function UPDATE_ORGANIZATION($ids, $reporting_to)
    {
        $data = array(
            'reporting_to' => $reporting_to
        );
        $this->db->where_in('id', $ids);

        return $this->db->update('tbl_employee_infos', $data);
    }

    function ADD_USER_ALLOWANCE($user_id, $allowance_val, $year, $type)
    {

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_allowanceassign (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql, array($create_date, $create_date, $user_id, $type, $allowance_val, $year));
    }

    function UPDATE_USER_ALLOWANCE($user_id, $allowance_val, $year, $type)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_allowanceassign SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql, array($edit_date, $allowance_val, $user_id, $year, $type));
    }

    // function update_approver_count($data)
    // {
    //     $edit_date = date('Y-m-d H:i:s');
    //     $sql = " UPDATE tbl_system_setup SET edit_date=?, value=? WHERE setting= 'num_approvers'";
    //     return $this->db->query($sql, array($edit_date, $data));
    // }
    function update_setting_general($value, $key)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_system_setup SET edit_date=?, value=? WHERE setting= ?";
        return $this->db->query($sql, array($edit_date, $value,  $key));
    }
    function update_setting_general2($value, $key, $edit_user)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_system_setup SET edit_date=?, value=?, edit_user=? WHERE setting= ?";
        return $this->db->query($sql, array($edit_date, $value, $edit_user, $key));
    }

    function update_max_wire($empl_id, $checkbox)
    {
        $datetime = date('Y-m-d H:i:s');

        $sql = "SELECT * FROM tbl_employee_maxwire WHERE empl_id = ?";
        $query = $this->db->query($sql, array($empl_id));
        $result = $query->num_rows();

        if ($result <= 0) {
            // Insert
            $sql_insert = "INSERT INTO tbl_employee_maxwire (create_date, edit_date, empl_id, value) VALUES (?,?,?,?)";
            $sql_query = $this->db->query($sql_insert, array($datetime, $datetime, $empl_id, $checkbox));
        } else {
            // Update
            $sql_update = " UPDATE tbl_employee_maxwire SET edit_date=?, value=? WHERE empl_id=?";
            return $this->db->query($sql_update, array($datetime, $checkbox, $empl_id));
        }
    }


    function ADD_USER_ALLOWANCE_TAX($user_id, $allowance_val, $year, $type)
    {

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_allowanceassigntax (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql, array($create_date, $create_date, $user_id, $type, $allowance_val, $year));
    }

    function UPDATE_USER_ALLOWANCE_TAX($user_id, $allowance_val, $year, $type)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_allowanceassigntax SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql, array($edit_date, $allowance_val, $user_id, $year, $type));
    }

    function ADD_USER_ALLOWANCE_NONTAX($user_id, $allowance_val, $year, $type)
    {

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_allowanceassignnontax (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql, array($create_date, $create_date, $user_id, $type, $allowance_val, $year));
    }

    function UPDATE_USER_ALLOWANCE_NONTAX($user_id, $allowance_val, $year, $type)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_allowanceassignnontax SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql, array($edit_date, $allowance_val, $user_id, $year, $type));
    }

    // function ADD_USER_DEDUCTION_TAX($user_id, $allowance_val, $year, $type)
    // {

    //     $create_date = date('Y-m-d H:i:s');
    //     $sql = "INSERT INTO tbl_employee_deductionassigntax (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
    //     return $this->db->query($sql, array($create_date, $create_date, $user_id, $type, $allowance_val, $year));
    // }

    // function UPDATE_USER_DEDUCTION_TAX($user_id, $allowance_val, $year, $type)
    // {
    //     $edit_date = date('Y-m-d H:i:s');
    //     $sql = " UPDATE tbl_employee_deductionassigntax SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
    //     return $this->db->query($sql, array($edit_date, $allowance_val, $user_id, $year, $type));
    // }

    function ADD_USER_DEDUCTION_NONTAX($user_id, $val, $year, $type)
    {

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_deductionassignnontax (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql, array($create_date, $create_date, $user_id, $type, $val, $year));
    }

    function UPDATE_USER_DEDUCTION_NONTAX($user_id, $val, $year, $type)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_deductionassignnontax SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql, array($edit_date, $val, $user_id, $year, $type));
    }

    function UPDATE_SALARY_DETAILS($user_id, $value)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_infos SET edit_date=?, salary_rate=? WHERE id=?";
        return $this->db->query($sql, array($edit_date, $value, $user_id));
    }

    function UPDATE_SETUP_ORGANIZATION($data, $editUser)
    {
        $id = $data[0];
        $extra_posi = $data[2];
        $col_empl_cmid = $data[3];
        $reportingId = $this->getEmployeeTableId($col_empl_cmid);
        $edit_date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_employee_infos SET edit_date=?, edit_user=?, reporting_to=?, extra_posi=? WHERE id=?";
        $this->db->query($sql, array($edit_date, $editUser, $reportingId, $extra_posi, $id));
    }

    function ASSIGN_TO_COUNT()
    {
        $sql = "SELECT COUNT(*) as count FROM `tbl_employee_infos` WHERE (reporting_to = 0 OR reporting_to IS NULL);";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->count;
    }

    function UPDATE_SALARY_TYPE_DETAILS($user_id, $value)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_infos SET edit_date=?, salary_type=? WHERE id=?";
        return $this->db->query($sql, array($edit_date, $value, $user_id));
    }

    function UPDATE_SALARY_BULK($id, $salary_amount, $salary_type)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_infos SET edit_date=?, salary_rate=?, salary_type=? WHERE id=? ";
        return $this->db->query($sql, array($edit_date, $salary_amount, $salary_type, $id));
    }

    function UPDATE_EMPLOYEE_DISABLED($empl_id, $value)
    {
        $sql = "UPDATE tbl_employee_infos SET disabled=? WHERE id=?";
        $query = $this->db->query($sql, array($value, $empl_id));
    }

    function columnCategory($column)
    {
        switch ($column) {
            case "account_number":
                return "Bank Account Number";
            case "payment_type":
                return "Bank Payment Type";
            case "account_type":
                return "Bank Account Type";
            case "branch_name":
                return "Bank Branch";
            case "bank_name":
                return "Bank Name";
            case "col_empl_pass":
                return "Passport";
            case "col_empl_naid":
                return "National ID";
            case "col_empl_driv":
                return "Driver's License";
            case "col_empl_btin":
                return "TIN";
            case "col_empl_phil":
                return "Philhealth";
            case "col_empl_hdmf":
                return "Pagibig";
            case "col_empl_sssc":
                return "SSS";
            case "col_empl_hmon":
                return "HMO Number";
            case "col_empl_hmoo":
                return "HMO Provider";
            case "col_comp_emai":
                return "Company Email";
            case "col_comp_numb":
                return "Company Number";
            case "col_empl_team":
                return "Team";
            case "col_empl_line":
                return "Line";
            case "col_empl_group":
                return "Groups";
            case "col_empl_sect":
                return "Sections";
            case "col_empl_divi":
                return "Division";
            case "col_empl_club":
                return "Clubhouse";
            case "col_empl_dept":
                return "Department";
            case "col_empl_branch":
                return "Branch";
            case "col_empl_posi":
                return "Position";
            case "col_empl_type":
                return "Employment Type";
            case "col_endd_date":
                return "Last Day of Work";
            case "resignation_date":
                return "Resignation";
            case "date_regular":
                return "Regularization";
            case "col_hire_date":
                return "Hired Date";
            case "col_curr_addr":
                return "Current Address";
            case "col_home_addr":
                return "Home Address";
            case "col_empl_emai":
                return "Email";
            case "col_shir_size":
                return "Shirt size";
            case "col_empl_nati":
                return "Nationality";
            case "col_empl_gend":
                return "Gender";
            case "col_birt_date":
                return "Birthdate";
            case "col_mobl_numb":
                return "Mobile Number";
            case "col_mart_stat":
                return "Marital Status";
            case "col_last_name":
                return "Last Name";
            case "col_midl_name":
                return "Middle Name";
            case "col_frst_name":
                return "First Name";
            case "salary_rate":
                return "Salary Rate";
            case "salary_type":
                return "Salary Type";
            case "salary_no_work_with_pay":
                return "Salary no work with pay";
            case "col_imag_path":
                return "Image Path";
            case "col_empl_company":
                return "Company";
            case "termination_date":
                return "Termination Date";
            case "termination_reason":
                return "Termination Reason";
            case "resignation_date":
                return "Resignation Date";
            case "resignation_reason":
                return "Resignation Reason";
            default:
                return "Not Found";
        }
    }

    function UPDATE_SALARY_DETAIL($data, $edit_id_logs)
    {
        $id = $data['id'];
        $salary_rate = $data['salary_rate'];
        $salary_type = $data['salary_type'];
        $nwwp = $data['nwwp'];

        $sqlold = "SELECT * FROM tbl_employee_infos WHERE id=?";
        $queryold = $this->db->query($sqlold, array($id));
        $queryold->next_result();
        $old = $queryold->result();
        $current_date = date('Y-m-d H:i:s');
        $setColumns = "edit_date=?";
        $queryData = array($current_date);
        $logs = [];
        foreach ($old[0] as $key => $value) {
            if ($key == "salary_rate" && !empty($salary_rate) && $value != $salary_rate) {
                $setColumns .= ", $key=?";
                array_push($queryData, $salary_rate);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $salary_rate,
                ]);
            } else if ($key == "salary_type" && !empty($salary_type) && $value != $salary_type) {
                $setColumns .= ", $key=?";
                array_push($queryData, $salary_type);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $salary_type,
                ]);
            } else if ($key == "salary_no_work_with_pay" && !empty($nwwp) && $value != $nwwp) {
                $setColumns .= ", $key=?";
                array_push($queryData, $nwwp);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $nwwp,
                ]);
            }
        }

        if (!empty($logs)) {
            try {
                array_push($queryData, $id);
                $sql = "UPDATE tbl_employee_infos SET $setColumns WHERE id=?";
                $this->db->query($sql, $queryData);
                $edit_id = $edit_id_logs;
                $empl_id = $old[0]->id;
                foreach ($logs as $new_row) {
                    $category = $new_row[0];
                    $from_val = $new_row[1];
                    $to_val = $new_row[2];
                    $this->ADD_EMPLOYEE_LOGS($edit_id, $empl_id, $category, $from_val, $to_val);
                }
            } catch (Exception $e) {
                return array('query error' => 'Error updating data: ' . $e->getMessage());
            }
        }

        // $sql = "UPDATE tbl_employee_infos SET salary_rate=?,salary_type=? WHERE id=?";
        // $this->db->query($sql, array($salary_rate, $salary_type, $id));
    }

    

    function GET_EMPL_APPROVALS_LEAVE($search, $limit, $offset, $filter_arr)
    {
        $new_filter = array_filter([
            'tb1.col_empl_company' => $filter_arr['company'],
            'tb1.col_empl_branch'  => $filter_arr['branch'],
            'tb1.col_empl_dept'    => $filter_arr['dept'],
            'tb1.col_empl_divi'    => $filter_arr['div'],
            'tb1.col_empl_club'    => $filter_arr['clubhouse'],
            'tb1.col_empl_sect'    => $filter_arr['section'],
            'tb1.col_empl_group'   => $filter_arr['group'],
            'tb1.col_empl_line'    => $filter_arr['line'],
            'tb1.col_empl_team'    => $filter_arr['team'],
            'tb1.id'               => $filter_arr['id']
        ]);
    
        $this->db->select("tb1.id, tb1.col_empl_cmid, tb2.auto_approve, tb1.col_last_name, tb1.col_midl_name, tb1.col_frst_name");
    
        $concat_fields = [
            'tb1'  => 'employee_name',
            'tb1a' => 'approver_1a_name', 'tb1b' => 'approver_1b_name',
            'tb2a' => 'approver_2a_name', 'tb2b' => 'approver_2b_name',
            'tb3a' => 'approver_3a_name', 'tb3b' => 'approver_3b_name',
            'tb4a' => 'approver_4a_name', 'tb4b' => 'approver_4b_name',
            'tb5a' => 'approver_5a_name', 'tb5b' => 'approver_5b_name'
        ];
    
        foreach ($concat_fields as $alias => $field_name) {
            $this->db->select("CONCAT_WS('',
                CASE WHEN {$alias}.col_empl_cmid IS NOT NULL AND {$alias}.col_empl_cmid != '' THEN CONCAT({$alias}.col_empl_cmid, '-') ELSE '' END,
                CASE WHEN {$alias}.col_last_name IS NOT NULL AND {$alias}.col_last_name != '' THEN {$alias}.col_last_name ELSE '' END,
                CASE WHEN {$alias}.col_suffix IS NOT NULL AND {$alias}.col_suffix != '' THEN CONCAT(' ', {$alias}.col_suffix) ELSE '' END,
                CASE WHEN {$alias}.col_frst_name IS NOT NULL AND {$alias}.col_frst_name != '' THEN CONCAT(', ', {$alias}.col_frst_name) ELSE '' END,
                CASE WHEN {$alias}.col_midl_name IS NOT NULL AND {$alias}.col_midl_name != '' THEN CONCAT(' ', LEFT({$alias}.col_midl_name, 1), '.') ELSE '' END
            ) AS {$field_name}", false);
        }
    
        $this->db->from('tbl_employee_infos as tb1')
            ->join('tbl_approvers_leave as tb2', 'tb1.id = tb2.empl_id', 'left')
            ->join('tbl_employee_infos as tb1a', 'tb2.approver_1a = tb1a.id', 'left')
            ->join('tbl_employee_infos as tb1b', 'tb2.approver_1b = tb1b.id', 'left')
            ->join('tbl_employee_infos as tb2a', 'tb2.approver_2a = tb2a.id', 'left')
            ->join('tbl_employee_infos as tb2b', 'tb2.approver_2b = tb2b.id', 'left')
            ->join('tbl_employee_infos as tb3a', 'tb2.approver_3a = tb3a.id', 'left')
            ->join('tbl_employee_infos as tb3b', 'tb2.approver_3b = tb3b.id', 'left')
            ->join('tbl_employee_infos as tb4a', 'tb2.approver_4a = tb4a.id', 'left')
            ->join('tbl_employee_infos as tb4b', 'tb2.approver_4b = tb4b.id', 'left')
            ->join('tbl_employee_infos as tb5a', 'tb2.approver_5a = tb5a.id', 'left')
            ->join('tbl_employee_infos as tb5b', 'tb2.approver_5b = tb5b.id', 'left')
            ->where("tb1.disabled = '0' AND (tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00')");
    
        if (!empty($new_filter)) {
            $this->db->where($new_filter);
        }
    
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
    
        $this->db->order_by('tb1.col_empl_cmid + 0', 'ASC')
            ->order_by('CAST(tb1.col_empl_cmid AS SIGNED)', 'ASC');
    
        return $this->db->get()->result();
    }
    
    function GET_EMPL_APPROVALS_OT($search, $limit, $offset, $filter_arr)
    {
        $new_filter = array_filter([
            'tb1.col_empl_company' => $filter_arr['company'],
            'tb1.col_empl_branch'  => $filter_arr['branch'],
            'tb1.col_empl_dept'    => $filter_arr['dept'],
            'tb1.col_empl_divi'    => $filter_arr['div'],
            'tb1.col_empl_club'    => $filter_arr['clubhouse'],
            'tb1.col_empl_sect'    => $filter_arr['section'],
            'tb1.col_empl_group'   => $filter_arr['group'],
            'tb1.col_empl_line'    => $filter_arr['line'],
            'tb1.col_empl_team'    => $filter_arr['team'],
            'tb1.id'               => $filter_arr['id']
        ]);
    
        $this->db->select("tb1.id, tb1.col_empl_cmid, tb2.auto_approve, tb1.col_last_name, tb1.col_midl_name, tb1.col_frst_name");
    
        $concat_fields = [
            'tb1'  => 'employee_name',
            'tb1a' => 'approver_1a_name', 'tb1b' => 'approver_1b_name',
            'tb2a' => 'approver_2a_name', 'tb2b' => 'approver_2b_name',
            'tb3a' => 'approver_3a_name', 'tb3b' => 'approver_3b_name',
            'tb4a' => 'approver_4a_name', 'tb4b' => 'approver_4b_name',
            'tb5a' => 'approver_5a_name', 'tb5b' => 'approver_5b_name'
        ];
    
        foreach ($concat_fields as $alias => $field_name) {
            $this->db->select("CONCAT_WS('',
                CASE WHEN {$alias}.col_empl_cmid IS NOT NULL AND {$alias}.col_empl_cmid != '' THEN CONCAT({$alias}.col_empl_cmid, '-') ELSE '' END,
                CASE WHEN {$alias}.col_last_name IS NOT NULL AND {$alias}.col_last_name != '' THEN {$alias}.col_last_name ELSE '' END,
                CASE WHEN {$alias}.col_suffix IS NOT NULL AND {$alias}.col_suffix != '' THEN CONCAT(' ', {$alias}.col_suffix) ELSE '' END,
                CASE WHEN {$alias}.col_frst_name IS NOT NULL AND {$alias}.col_frst_name != '' THEN CONCAT(', ', {$alias}.col_frst_name) ELSE '' END,
                CASE WHEN {$alias}.col_midl_name IS NOT NULL AND {$alias}.col_midl_name != '' THEN CONCAT(' ', LEFT({$alias}.col_midl_name, 1), '.') ELSE '' END
            ) AS {$field_name}", false);
        }
    
        $this->db->from('tbl_employee_infos as tb1')
            ->join('tbl_approvers_ot as tb2', 'tb1.id = tb2.empl_id', 'left')
            ->join('tbl_employee_infos as tb1a', 'tb2.approver_1a = tb1a.id', 'left')
            ->join('tbl_employee_infos as tb1b', 'tb2.approver_1b = tb1b.id', 'left')
            ->join('tbl_employee_infos as tb2a', 'tb2.approver_2a = tb2a.id', 'left')
            ->join('tbl_employee_infos as tb2b', 'tb2.approver_2b = tb2b.id', 'left')
            ->join('tbl_employee_infos as tb3a', 'tb2.approver_3a = tb3a.id', 'left')
            ->join('tbl_employee_infos as tb3b', 'tb2.approver_3b = tb3b.id', 'left')
            ->join('tbl_employee_infos as tb4a', 'tb2.approver_4a = tb4a.id', 'left')
            ->join('tbl_employee_infos as tb4b', 'tb2.approver_4b = tb4b.id', 'left')
            ->join('tbl_employee_infos as tb5a', 'tb2.approver_5a = tb5a.id', 'left')
            ->join('tbl_employee_infos as tb5b', 'tb2.approver_5b = tb5b.id', 'left')
            ->where("tb1.disabled = '0' AND (tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00')");
    
        if (!empty($new_filter)) {
            $this->db->where($new_filter);
        }
    
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
    
        $this->db->order_by('tb1.col_empl_cmid + 0', 'ASC')
            ->order_by('CAST(tb1.col_empl_cmid AS SIGNED)', 'ASC');
    
        return $this->db->get()->result();
    }

    function GET_EMPL_APPROVALS_TIMEADJ($search, $limit, $offset, $filter_arr)
    {
        $new_filter = array_filter([
            'tb1.col_empl_company' => $filter_arr['company'],
            'tb1.col_empl_branch'  => $filter_arr['branch'],
            'tb1.col_empl_dept'    => $filter_arr['dept'],
            'tb1.col_empl_divi'    => $filter_arr['div'],
            'tb1.col_empl_club'    => $filter_arr['clubhouse'],
            'tb1.col_empl_sect'    => $filter_arr['section'],
            'tb1.col_empl_group'   => $filter_arr['group'],
            'tb1.col_empl_line'    => $filter_arr['line'],
            'tb1.col_empl_team'    => $filter_arr['team'],
            'tb1.id'               => $filter_arr['id']
        ]);
    
        $this->db->select("tb1.id, tb1.col_empl_cmid, tb2.auto_approve, tb1.col_last_name, tb1.col_midl_name, tb1.col_frst_name");
    
        $concat_fields = [
            'tb1'  => 'employee_name',
            'tb1a' => 'approver_1a_name', 'tb1b' => 'approver_1b_name',
            'tb2a' => 'approver_2a_name', 'tb2b' => 'approver_2b_name',
            'tb3a' => 'approver_3a_name', 'tb3b' => 'approver_3b_name',
            'tb4a' => 'approver_4a_name', 'tb4b' => 'approver_4b_name',
            'tb5a' => 'approver_5a_name', 'tb5b' => 'approver_5b_name'
        ];
    
        foreach ($concat_fields as $alias => $field_name) {
            $this->db->select("CONCAT_WS('',
                CASE WHEN {$alias}.col_empl_cmid IS NOT NULL AND {$alias}.col_empl_cmid != '' THEN CONCAT({$alias}.col_empl_cmid, '-') ELSE '' END,
                CASE WHEN {$alias}.col_last_name IS NOT NULL AND {$alias}.col_last_name != '' THEN {$alias}.col_last_name ELSE '' END,
                CASE WHEN {$alias}.col_suffix IS NOT NULL AND {$alias}.col_suffix != '' THEN CONCAT(' ', {$alias}.col_suffix) ELSE '' END,
                CASE WHEN {$alias}.col_frst_name IS NOT NULL AND {$alias}.col_frst_name != '' THEN CONCAT(', ', {$alias}.col_frst_name) ELSE '' END,
                CASE WHEN {$alias}.col_midl_name IS NOT NULL AND {$alias}.col_midl_name != '' THEN CONCAT(' ', LEFT({$alias}.col_midl_name, 1), '.') ELSE '' END
            ) AS {$field_name}", false);
        }
    
        $this->db->from('tbl_employee_infos as tb1')
            ->join('tbl_approvers_timeadj as tb2', 'tb1.id = tb2.empl_id', 'left')
            ->join('tbl_employee_infos as tb1a', 'tb2.approver_1a = tb1a.id', 'left')
            ->join('tbl_employee_infos as tb1b', 'tb2.approver_1b = tb1b.id', 'left')
            ->join('tbl_employee_infos as tb2a', 'tb2.approver_2a = tb2a.id', 'left')
            ->join('tbl_employee_infos as tb2b', 'tb2.approver_2b = tb2b.id', 'left')
            ->join('tbl_employee_infos as tb3a', 'tb2.approver_3a = tb3a.id', 'left')
            ->join('tbl_employee_infos as tb3b', 'tb2.approver_3b = tb3b.id', 'left')
            ->join('tbl_employee_infos as tb4a', 'tb2.approver_4a = tb4a.id', 'left')
            ->join('tbl_employee_infos as tb4b', 'tb2.approver_4b = tb4b.id', 'left')
            ->join('tbl_employee_infos as tb5a', 'tb2.approver_5a = tb5a.id', 'left')
            ->join('tbl_employee_infos as tb5b', 'tb2.approver_5b = tb5b.id', 'left')
            ->where("tb1.disabled = '0' AND (tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00')");
    
        if (!empty($new_filter)) {
            $this->db->where($new_filter);
        }
    
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
    
        $this->db->order_by('tb1.col_empl_cmid + 0', 'ASC')
            ->order_by('CAST(tb1.col_empl_cmid AS SIGNED)', 'ASC');
    
        return $this->db->get()->result();
    }
    
    function GET_EMPL_APPROVALS_OFFSET($search, $limit, $offset, $filter_arr)
    {
        $new_filter = array_filter([
            'tb1.col_empl_company' => $filter_arr['company'],
            'tb1.col_empl_branch'  => $filter_arr['branch'],
            'tb1.col_empl_dept'    => $filter_arr['dept'],
            'tb1.col_empl_divi'    => $filter_arr['div'],
            'tb1.col_empl_club'    => $filter_arr['clubhouse'],
            'tb1.col_empl_sect'    => $filter_arr['section'],
            'tb1.col_empl_group'   => $filter_arr['group'],
            'tb1.col_empl_line'    => $filter_arr['line'],
            'tb1.col_empl_team'    => $filter_arr['team'],
            'tb1.id'               => $filter_arr['id']
        ]);
    
        $this->db->select("tb1.id, tb1.col_empl_cmid, tb2.auto_approve, tb1.col_last_name, tb1.col_midl_name, tb1.col_frst_name");
    
        $concat_fields = [
            'tb1'  => 'employee_name',
            'tb1a' => 'approver_1a_name', 'tb1b' => 'approver_1b_name',
            'tb2a' => 'approver_2a_name', 'tb2b' => 'approver_2b_name',
            'tb3a' => 'approver_3a_name', 'tb3b' => 'approver_3b_name',
            'tb4a' => 'approver_4a_name', 'tb4b' => 'approver_4b_name',
            'tb5a' => 'approver_5a_name', 'tb5b' => 'approver_5b_name'
        ];
    
        foreach ($concat_fields as $alias => $field_name) {
            $this->db->select("CONCAT_WS('',
                CASE WHEN {$alias}.col_empl_cmid IS NOT NULL AND {$alias}.col_empl_cmid != '' THEN CONCAT({$alias}.col_empl_cmid, '-') ELSE '' END,
                CASE WHEN {$alias}.col_last_name IS NOT NULL AND {$alias}.col_last_name != '' THEN {$alias}.col_last_name ELSE '' END,
                CASE WHEN {$alias}.col_suffix IS NOT NULL AND {$alias}.col_suffix != '' THEN CONCAT(' ', {$alias}.col_suffix) ELSE '' END,
                CASE WHEN {$alias}.col_frst_name IS NOT NULL AND {$alias}.col_frst_name != '' THEN CONCAT(', ', {$alias}.col_frst_name) ELSE '' END,
                CASE WHEN {$alias}.col_midl_name IS NOT NULL AND {$alias}.col_midl_name != '' THEN CONCAT(' ', LEFT({$alias}.col_midl_name, 1), '.') ELSE '' END
            ) AS {$field_name}", false);
        }
    
        $this->db->from('tbl_employee_infos as tb1')
            ->join('tbl_approvers_offset as tb2', 'tb1.id = tb2.empl_id', 'left')
            ->join('tbl_employee_infos as tb1a', 'tb2.approver_1a = tb1a.id', 'left')
            ->join('tbl_employee_infos as tb1b', 'tb2.approver_1b = tb1b.id', 'left')
            ->join('tbl_employee_infos as tb2a', 'tb2.approver_2a = tb2a.id', 'left')
            ->join('tbl_employee_infos as tb2b', 'tb2.approver_2b = tb2b.id', 'left')
            ->join('tbl_employee_infos as tb3a', 'tb2.approver_3a = tb3a.id', 'left')
            ->join('tbl_employee_infos as tb3b', 'tb2.approver_3b = tb3b.id', 'left')
            ->join('tbl_employee_infos as tb4a', 'tb2.approver_4a = tb4a.id', 'left')
            ->join('tbl_employee_infos as tb4b', 'tb2.approver_4b = tb4b.id', 'left')
            ->join('tbl_employee_infos as tb5a', 'tb2.approver_5a = tb5a.id', 'left')
            ->join('tbl_employee_infos as tb5b', 'tb2.approver_5b = tb5b.id', 'left')
            ->where("tb1.disabled = '0' AND (tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00')");
    
        if (!empty($new_filter)) {
            $this->db->where($new_filter);
        }
    
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
    
        $this->db->order_by('tb1.col_empl_cmid + 0', 'ASC')
            ->order_by('CAST(tb1.col_empl_cmid AS SIGNED)', 'ASC');
    
        return $this->db->get()->result();
    }

    function GET_EMPL_APPROVALS_ACQUIRE_OFFSET($search, $limit, $offset, $filter_arr)
    {
        $new_filter = array_filter([
            'tb1.col_empl_company' => $filter_arr['company'],
            'tb1.col_empl_branch'  => $filter_arr['branch'],
            'tb1.col_empl_dept'    => $filter_arr['dept'],
            'tb1.col_empl_divi'    => $filter_arr['div'],
            'tb1.col_empl_club'    => $filter_arr['clubhouse'],
            'tb1.col_empl_sect'    => $filter_arr['section'],
            'tb1.col_empl_group'   => $filter_arr['group'],
            'tb1.col_empl_line'    => $filter_arr['line'],
            'tb1.col_empl_team'    => $filter_arr['team'],
            'tb1.id'               => $filter_arr['id']
        ]);
    
        $this->db->select("tb1.id, tb1.col_empl_cmid, tb2.auto_approve, tb1.col_last_name, tb1.col_midl_name, tb1.col_frst_name");
    
        $concat_fields = [
            'tb1'  => 'employee_name',
            'tb1a' => 'approver_1a_name', 'tb1b' => 'approver_1b_name',
            'tb2a' => 'approver_2a_name', 'tb2b' => 'approver_2b_name',
            'tb3a' => 'approver_3a_name', 'tb3b' => 'approver_3b_name',
            'tb4a' => 'approver_4a_name', 'tb4b' => 'approver_4b_name',
            'tb5a' => 'approver_5a_name', 'tb5b' => 'approver_5b_name'
        ];
    
        foreach ($concat_fields as $alias => $field_name) {
            $this->db->select("CONCAT_WS('',
                CASE WHEN {$alias}.col_empl_cmid IS NOT NULL AND {$alias}.col_empl_cmid != '' THEN CONCAT({$alias}.col_empl_cmid, '-') ELSE '' END,
                CASE WHEN {$alias}.col_last_name IS NOT NULL AND {$alias}.col_last_name != '' THEN {$alias}.col_last_name ELSE '' END,
                CASE WHEN {$alias}.col_suffix IS NOT NULL AND {$alias}.col_suffix != '' THEN CONCAT(' ', {$alias}.col_suffix) ELSE '' END,
                CASE WHEN {$alias}.col_frst_name IS NOT NULL AND {$alias}.col_frst_name != '' THEN CONCAT(', ', {$alias}.col_frst_name) ELSE '' END,
                CASE WHEN {$alias}.col_midl_name IS NOT NULL AND {$alias}.col_midl_name != '' THEN CONCAT(' ', LEFT({$alias}.col_midl_name, 1), '.') ELSE '' END
            ) AS {$field_name}", false);
        }
    
        $this->db->from('tbl_employee_infos as tb1')
            ->join('tbl_approvers_offset_acquire as tb2', 'tb1.id = tb2.empl_id', 'left')
            ->join('tbl_employee_infos as tb1a', 'tb2.approver_1a = tb1a.id', 'left')
            ->join('tbl_employee_infos as tb1b', 'tb2.approver_1b = tb1b.id', 'left')
            ->join('tbl_employee_infos as tb2a', 'tb2.approver_2a = tb2a.id', 'left')
            ->join('tbl_employee_infos as tb2b', 'tb2.approver_2b = tb2b.id', 'left')
            ->join('tbl_employee_infos as tb3a', 'tb2.approver_3a = tb3a.id', 'left')
            ->join('tbl_employee_infos as tb3b', 'tb2.approver_3b = tb3b.id', 'left')
            ->join('tbl_employee_infos as tb4a', 'tb2.approver_4a = tb4a.id', 'left')
            ->join('tbl_employee_infos as tb4b', 'tb2.approver_4b = tb4b.id', 'left')
            ->join('tbl_employee_infos as tb5a', 'tb2.approver_5a = tb5a.id', 'left')
            ->join('tbl_employee_infos as tb5b', 'tb2.approver_5b = tb5b.id', 'left')
            ->where("tb1.disabled = '0' AND (tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00')");
    
        if (!empty($new_filter)) {
            $this->db->where($new_filter);
        }
    
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
    
        $this->db->order_by('tb1.col_empl_cmid + 0', 'ASC')
            ->order_by('CAST(tb1.col_empl_cmid AS SIGNED)', 'ASC');
    
        return $this->db->get()->result();
    }

   

    function GET_EMPL_APPROVALS_COUNT_LEAVES($search, $filter_arr)
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

    function GET_EMPL_APPROVALS_COUNT_OT($search, $filter_arr)
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
            ->join('tbl_approvers_ot as tb2', 'tb1.id = tb2.empl_id', 'left')
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

    function GET_EMPL_APPROVALS_COUNT_TIMEADJ($search, $filter_arr)
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
            ->join('tbl_approvers_timeadj as tb2', 'tb1.id = tb2.empl_id', 'left')
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

    function GET_EMPL_APPROVALS_COUNT_OFFSET($search, $filter_arr)
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
            ->join('tbl_approvers_offset as tb2', 'tb1.id = tb2.empl_id', 'left')
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

    function GET_ALL_EMPLOYEES_MAX_WIRE()
    {
        $sql = "SELECT tbl_emp.id, tbl_emp.col_empl_cmid, CONCAT(col_last_name, ', ', col_frst_name, 
        CASE WHEN col_midl_name <> '' THEN CONCAT(' ', UCASE(LEFT(col_midl_name, 1)), '.') ELSE '' END) AS fullname, tbl_max.value AS max_value FROM tbl_employee_infos AS tbl_emp
        LEFT JOIN tbl_employee_maxwire AS tbl_max ON tbl_max.empl_id = tbl_emp.id;";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function ASSIGN_APPROVERS_LEAVES($ids, $data)
    {
        foreach ($ids as $id) {
            $data['empl_id'] = $id;
            $this->db->where('empl_id', $id);
            $query = $this->db->get('tbl_approvers_leaves');

            if ($query->num_rows() > 0) {
                $this->db->where('empl_id', $id);
                $this->db->update('tbl_approvers_leaves', $data);
            } else {
                $this->db->insert('tbl_approvers_leaves', $data);
            }
        }
    }

    function ASSIGN_APPROVERS_OT($ids, $data)
    {
        foreach ($ids as $id) {
            $data['empl_id'] = $id;
            $this->db->where('empl_id', $id);
            $query = $this->db->get('tbl_approvers_ot');

            if ($query->num_rows() > 0) {
                $this->db->where('empl_id', $id);
                $this->db->update('tbl_approvers_ot', $data);
            } else {
                $this->db->insert('tbl_approvers_ot', $data);
            }
        }
    }

    function is_duplicate_leave($id){
        $sql   = "SELECT empl_id FROM tbl_approvers_leave WHERE empl_id = ?";
        $query = $this->db->query($sql, $id);
        return $query->num_rows();
    }
    
    function update_approval_leaves($data, $userId)
    {

        $empl_id = $data[0];
        $result = $this->is_duplicate_leave($empl_id);
    
        $temp_data = array(
            'empl_id' => $data[0],
            'auto_approve' => $data[2],
            'edit_date' => date('Y-m-d H:i:s'),
            'edit_user' => $userId
        );
    
        // Initialize all approver fields to 0
        for ($i = 1; $i <= 5; $i++) {
            $temp_data["approver_{$i}a"] = 0;
            $temp_data["approver_{$i}b"] = 0;
        }
    
        // Dynamically assign approver IDs if provided in $data
        for ($i = 3; $i <= 12; $i++) {
            if (isset($data[$i]) && !empty($data[$i])) {
                $approver_id = $this->getEmployeeTableId($data[$i]) ?: 0;
                $suffix = ($i % 2 == 1) ? 'a' : 'b';
                $index = ceil(($i - 2) / 2);
                $temp_data["approver_{$index}{$suffix}"] = $approver_id;
            }
        }
    
        if ($result > 0) {
            // Update if duplicate exists
            $this->db->where('empl_id', $empl_id);
            $this->db->update('tbl_approvers_leave', $temp_data);
        } else {
            // Insert if no duplicate
            $temp_data['create_date'] = date('Y-m-d H:i:s');
            $this->db->insert('tbl_approvers_leave', $temp_data);
        }


        // $employeeStatus = [];

        // for ($i = 3; $i <= 12; $i++) {
        //     if (!empty($data[$i])) {
        //         $col_empl_cmid = $data[$i];
        //         if (!isset($employeeStatus[$col_empl_cmid])) {
        //             $employeeStatus[$col_empl_cmid] = $this->getEmployeeTableId($col_empl_cmid);
        //         }
        //     }
        // }

        // $uniqueEmployeeIds = [];
        // foreach ($employeeStatus as $col_empl_cmid => $employeeId) {
        //     if ($employeeId !== null) {
        //         if (in_array($employeeId, $uniqueEmployeeIds)) {
        //             continue;
        //         }
        //         $uniqueEmployeeIds[] = $employeeId;
        //     } else {
        //         continue;
        //     }
        // }

        // foreach ($uniqueEmployeeIds as $index => $employeeId) {
        //     $temp_data["approver_" . (intdiv($index, 2) + 1) . chr(97 + ($index % 2))] = $employeeId;
        // }

        // $temp_data['edit_date'] = date('Y-m-d H:i:s');
        // $temp_data['edit_user'] = $userId;

        // $this->db->where('empl_id', $data[0]);
        // $this->db->update('tbl_approvers_leave', $temp_data);
        // $res = $this->db->affected_rows();
        // return $res;
    }

    function insert_approval_leaves($data, $userId)
    {
        $temp_data = array();

        $temp_data['empl_id'] = $data[0];
        $temp_data['approver_1a'] = 0;
        $temp_data['approver_1b'] = 0;
        $temp_data['approver_2a'] = 0;
        $temp_data['approver_2b'] = 0;
        $temp_data['approver_3a'] = 0;
        $temp_data['approver_3b'] = 0;
        $temp_data['approver_4a'] = 0;
        $temp_data['approver_4b'] = 0;
        $temp_data['approver_5a'] = 0;
        $temp_data['approver_5b'] = 0;
        $temp_data['auto_approve'] = $data[2];

        $employeeStatus = [];

        for ($i = 3; $i <= 12; $i++) {
            if (!empty($data[$i])) {
                $col_empl_cmid = $data[$i];
                if (!isset($employeeStatus[$col_empl_cmid])) {
                    $employeeStatus[$col_empl_cmid] = $this->getEmployeeTableId($col_empl_cmid);
                }
            }
        }
        foreach ($employeeStatus as $col_empl_cmid => $employeeId) {
            if ($employeeId !== null) {
                if (isset($data[3]) && $data[3] === $col_empl_cmid) $temp_data['approver_1a'] = $employeeId;
                if (isset($data[4]) && $data[4] === $col_empl_cmid) $temp_data['approver_1b'] = $employeeId;
                if (isset($data[5]) && $data[5] === $col_empl_cmid) $temp_data['approver_2a'] = $employeeId;
                if (isset($data[6]) && $data[6] === $col_empl_cmid) $temp_data['approver_2b'] = $employeeId;
                if (isset($data[7]) && $data[7] === $col_empl_cmid) $temp_data['approver_3a'] = $employeeId;
                if (isset($data[8]) && $data[8] === $col_empl_cmid) $temp_data['approver_3b'] = $employeeId;
                if (isset($data[9]) && $data[9] === $col_empl_cmid) $temp_data['approver_4a'] = $employeeId;
                if (isset($data[10]) && $data[10] === $col_empl_cmid) $temp_data['approver_4b'] = $employeeId;
                if (isset($data[11]) && $data[11] === $col_empl_cmid) $temp_data['approver_5a'] = $employeeId;
                if (isset($data[12]) && $data[12] === $col_empl_cmid) $temp_data['approver_5b'] = $employeeId;
            }
        }

        $temp_data['edit_date'] = date('Y-m-d H:i:s');
        $temp_data['create_date'] = date('Y-m-d H:i:s');
        $temp_data['edit_user'] = $userId;

        $this->db->insert('tbl_approvers_leave', $temp_data);
        $inserted_rows = $this->db->affected_rows();

        return $inserted_rows;
    }

    function is_duplicate_overtime($id)
    {
        $sql   = "SELECT empl_id FROM tbl_approvers_ot WHERE empl_id = ?";
        $query = $this->db->query($sql, $id);
        return $query->num_rows();
    }

    function update_approval_ot($data, $userId)
    {

        $empl_id = $data[0];
        $result = $this->is_duplicate_overtime($empl_id);
    
        $temp_data = array(
            'empl_id' => $data[0],
            'auto_approve' => $data[2],
            'edit_date' => date('Y-m-d H:i:s'),
            'edit_user' => $userId
        );
    
        // Initialize all approver fields to 0
        for ($i = 1; $i <= 5; $i++) {
            $temp_data["approver_{$i}a"] = 0;
            $temp_data["approver_{$i}b"] = 0;
        }
    
        // Dynamically assign approver IDs if provided in $data
        for ($i = 3; $i <= 12; $i++) {
            if (isset($data[$i]) && !empty($data[$i])) {
                $approver_id = $this->getEmployeeTableId($data[$i]) ?: 0;
                $suffix = ($i % 2 == 1) ? 'a' : 'b';
                $index = ceil(($i - 2) / 2);
                $temp_data["approver_{$index}{$suffix}"] = $approver_id;
            }
        }
    
        if ($result > 0) {
            // Update if duplicate exists
            $this->db->where('empl_id', $empl_id);
            $this->db->update('tbl_approvers_ot', $temp_data);
        } else {
            // Insert if no duplicate
            $temp_data['create_date'] = date('Y-m-d H:i:s');
            $this->db->insert('tbl_approvers_ot', $temp_data);
        }


        // $employeeStatus = [];

        // for ($i = 3; $i <= 12; $i++) {
        //     if (!empty($data[$i])) {
        //         $col_empl_cmid = $data[$i];
        //         if (!isset($employeeStatus[$col_empl_cmid])) {
        //             $employeeStatus[$col_empl_cmid] = $this->getEmployeeTableId($col_empl_cmid);
        //         }
        //     }
        // }

        // $uniqueEmployeeIds = [];
        // foreach ($employeeStatus as $col_empl_cmid => $employeeId) {
        //     if ($employeeId !== null) {
        //         if (in_array($employeeId, $uniqueEmployeeIds)) {
        //             continue;
        //         }
        //         $uniqueEmployeeIds[] = $employeeId;
        //     } else {
        //         continue;
        //     }
        // }

        // foreach ($uniqueEmployeeIds as $index => $employeeId) {
        //     $temp_data["approver_" . (intdiv($index, 2) + 1) . chr(97 + ($index % 2))] = $employeeId;
        // }

        // $temp_data['edit_date'] = date('Y-m-d H:i:s');
        // $temp_data['edit_user'] = $userId;

        // $this->db->where('empl_id', $data[0]);
        // $this->db->update('tbl_approvers_ot', $temp_data);
        // $res = $this->db->affected_rows();
        // return $res;
    }

    function insert_approval_ot($data, $userId)
    {
        $temp_data = array();

        $temp_data['empl_id'] = $data[0];
        $temp_data['approver_1a'] = 0;
        $temp_data['approver_1b'] = 0;
        $temp_data['approver_2a'] = 0;
        $temp_data['approver_2b'] = 0;
        $temp_data['approver_3a'] = 0;
        $temp_data['approver_3b'] = 0;
        $temp_data['approver_4a'] = 0;
        $temp_data['approver_4b'] = 0;
        $temp_data['approver_5a'] = 0;
        $temp_data['approver_5b'] = 0;
        $temp_data['auto_approve'] = $data[2];

        $employeeStatus = [];

        for ($i = 3; $i <= 12; $i++) {
            if (!empty($data[$i])) {
                $col_empl_cmid = $data[$i];
                if (!isset($employeeStatus[$col_empl_cmid])) {
                    $employeeStatus[$col_empl_cmid] = $this->getEmployeeTableId($col_empl_cmid);
                }
            }
        }
        foreach ($employeeStatus as $col_empl_cmid => $employeeId) {
            if ($employeeId !== null) {
                if (isset($data[3]) && $data[3] === $col_empl_cmid) $temp_data['approver_1a'] = $employeeId;
                if (isset($data[4]) && $data[4] === $col_empl_cmid) $temp_data['approver_1b'] = $employeeId;
                if (isset($data[5]) && $data[5] === $col_empl_cmid) $temp_data['approver_2a'] = $employeeId;
                if (isset($data[6]) && $data[6] === $col_empl_cmid) $temp_data['approver_2b'] = $employeeId;
                if (isset($data[7]) && $data[7] === $col_empl_cmid) $temp_data['approver_3a'] = $employeeId;
                if (isset($data[8]) && $data[8] === $col_empl_cmid) $temp_data['approver_3b'] = $employeeId;
                if (isset($data[9]) && $data[9] === $col_empl_cmid) $temp_data['approver_4a'] = $employeeId;
                if (isset($data[10]) && $data[10] === $col_empl_cmid) $temp_data['approver_4b'] = $employeeId;
                if (isset($data[11]) && $data[11] === $col_empl_cmid) $temp_data['approver_5a'] = $employeeId;
                if (isset($data[12]) && $data[12] === $col_empl_cmid) $temp_data['approver_5b'] = $employeeId;
            }
        }

        $temp_data['edit_date'] = date('Y-m-d H:i:s');
        $temp_data['create_date'] = date('Y-m-d H:i:s');
        $temp_data['edit_user'] = $userId;

        $this->db->insert('tbl_approvers_ot', $temp_data);
        $inserted_rows = $this->db->affected_rows();

        return $inserted_rows;
    }

    function is_duplicate_timeaj($id)
    {
        $sql   = "SELECT empl_id FROM tbl_approvers_timeadj WHERE empl_id = ?";
        $query = $this->db->query($sql, $id);
        return $query->num_rows();
    }

    
    function update_approval_timeadj($data, $userId)
    {

        $empl_id = $data[0];
        $result = $this->is_duplicate_timeaj($empl_id);
    
        $temp_data = array(
            'empl_id' => $data[0],
            'auto_approve' => $data[2],
            'edit_date' => date('Y-m-d H:i:s'),
            'edit_user' => $userId
        );
    
        // Initialize all approver fields to 0
        for ($i = 1; $i <= 5; $i++) {
            $temp_data["approver_{$i}a"] = 0;
            $temp_data["approver_{$i}b"] = 0;
        }
    
        // Dynamically assign approver IDs if provided in $data
        for ($i = 3; $i <= 12; $i++) {
            if (isset($data[$i]) && !empty($data[$i])) {
                $approver_id = $this->getEmployeeTableId($data[$i]) ?: 0;
                $suffix = ($i % 2 == 1) ? 'a' : 'b';
                $index = ceil(($i - 2) / 2);
                $temp_data["approver_{$index}{$suffix}"] = $approver_id;
            }
        }
    
        if ($result > 0) {
            // Update if duplicate exists
            $this->db->where('empl_id', $empl_id);
            $this->db->update('tbl_approvers_timeadj', $temp_data);
        } else {
            // Insert if no duplicate
            $temp_data['create_date'] = date('Y-m-d H:i:s');
            $this->db->insert('tbl_approvers_timeadj', $temp_data);
        }


        // $employeeStatus = [];

        // for ($i = 3; $i <= 12; $i++) {
        //     if (!empty($data[$i])) {
        //         $col_empl_cmid = $data[$i];
        //         if (!isset($employeeStatus[$col_empl_cmid])) {
        //             $employeeStatus[$col_empl_cmid] = $this->getEmployeeTableId($col_empl_cmid);
        //         }
        //     }
        // }

        // $uniqueEmployeeIds = [];
        // foreach ($employeeStatus as $col_empl_cmid => $employeeId) {
        //     if ($employeeId !== null) {
        //         if (in_array($employeeId, $uniqueEmployeeIds)) {
        //             continue;
        //         }
        //         $uniqueEmployeeIds[] = $employeeId;
        //     } else {
        //         continue;
        //     }
        // }

        // foreach ($uniqueEmployeeIds as $index => $employeeId) {
        //     $temp_data["approver_" . (intdiv($index, 2) + 1) . chr(97 + ($index % 2))] = $employeeId;
        // }

        // $temp_data['edit_date'] = date('Y-m-d H:i:s');
        // $temp_data['edit_user'] = $userId;

        // $this->db->where('empl_id', $data[0]);
        // $this->db->update('tbl_approvers_timeadj', $temp_data);
        // $res = $this->db->affected_rows();
        // return $res;
    }

    function insert_approval_timeadj($data, $userId)
    {
        $temp_data = array();

        $temp_data['empl_id'] = $data[0];
        $temp_data['approver_1a'] = 0;
        $temp_data['approver_1b'] = 0;
        $temp_data['approver_2a'] = 0;
        $temp_data['approver_2b'] = 0;
        $temp_data['approver_3a'] = 0;
        $temp_data['approver_3b'] = 0;
        $temp_data['approver_4a'] = 0;
        $temp_data['approver_4b'] = 0;
        $temp_data['approver_5a'] = 0;
        $temp_data['approver_5b'] = 0;
        $temp_data['auto_approve'] = $data[2];

        $employeeStatus = [];

        for ($i = 3; $i <= 12; $i++) {
            if (!empty($data[$i])) {
                $col_empl_cmid = $data[$i];
                if (!isset($employeeStatus[$col_empl_cmid])) {
                    $employeeStatus[$col_empl_cmid] = $this->getEmployeeTableId($col_empl_cmid);
                }
            }
        }
        foreach ($employeeStatus as $col_empl_cmid => $employeeId) {
            if ($employeeId !== null) {
                if (isset($data[3]) && $data[3] === $col_empl_cmid) $temp_data['approver_1a'] = $employeeId;
                if (isset($data[4]) && $data[4] === $col_empl_cmid) $temp_data['approver_1b'] = $employeeId;
                if (isset($data[5]) && $data[5] === $col_empl_cmid) $temp_data['approver_2a'] = $employeeId;
                if (isset($data[6]) && $data[6] === $col_empl_cmid) $temp_data['approver_2b'] = $employeeId;
                if (isset($data[7]) && $data[7] === $col_empl_cmid) $temp_data['approver_3a'] = $employeeId;
                if (isset($data[8]) && $data[8] === $col_empl_cmid) $temp_data['approver_3b'] = $employeeId;
                if (isset($data[9]) && $data[9] === $col_empl_cmid) $temp_data['approver_4a'] = $employeeId;
                if (isset($data[10]) && $data[10] === $col_empl_cmid) $temp_data['approver_4b'] = $employeeId;
                if (isset($data[11]) && $data[11] === $col_empl_cmid) $temp_data['approver_5a'] = $employeeId;
                if (isset($data[12]) && $data[12] === $col_empl_cmid) $temp_data['approver_5b'] = $employeeId;
            }
        }

        $temp_data['edit_date'] = date('Y-m-d H:i:s');
        $temp_data['create_date'] = date('Y-m-d H:i:s');
        $temp_data['edit_user'] = $userId;

        $this->db->insert('tbl_approvers_timeadj', $temp_data);
        $inserted_rows = $this->db->affected_rows();

        return $inserted_rows;
    }

    function is_duplicate_acquire_offset($id)
    {
        $sql   = "SELECT empl_id FROM tbl_approvers_offset_acquire WHERE empl_id = ?";
        $query = $this->db->query($sql, $id);
        return $query->num_rows();
    }

    function update_approval_acquire_offset($data, $userId)
    {

        $empl_id = $data[0];
        $result = $this->is_duplicate_acquire_offset($empl_id);
    
        $temp_data = array(
            'empl_id' => $data[0],
            'auto_approve' => $data[2],
            'edit_date' => date('Y-m-d H:i:s'),
            'edit_user' => $userId
        );
    
        // Initialize all approver fields to 0
        for ($i = 1; $i <= 5; $i++) {
            $temp_data["approver_{$i}a"] = 0;
            $temp_data["approver_{$i}b"] = 0;
        }
    
        // Dynamically assign approver IDs if provided in $data
        for ($i = 3; $i <= 12; $i++) {
            if (isset($data[$i]) && !empty($data[$i])) {
                $approver_id = $this->getEmployeeTableId($data[$i]) ?: 0;
                $suffix = ($i % 2 == 1) ? 'a' : 'b';
                $index = ceil(($i - 2) / 2);
                $temp_data["approver_{$index}{$suffix}"] = $approver_id;
            }
        }
    
        if ($result > 0) {
            // Update if duplicate exists
            $this->db->where('empl_id', $empl_id);
            $this->db->update('tbl_approvers_offset_acquire', $temp_data);
        } else {
            // Insert if no duplicate
            $temp_data['create_date'] = date('Y-m-d H:i:s');
            $this->db->insert('tbl_approvers_offset_acquire', $temp_data);
        }
    }

    function is_duplicate_offset($id)
    {
        $sql   = "SELECT empl_id FROM tbl_approvers_offset WHERE empl_id = ?";
        $query = $this->db->query($sql, $id);
        return $query->num_rows();
    }
    
    function update_approval_offset($data, $userId)
    {

        $empl_id = $data[0];
        $result = $this->is_duplicate_offset($empl_id);
    
        $temp_data = array(
            'empl_id' => $data[0],
            'auto_approve' => $data[2],
            'edit_date' => date('Y-m-d H:i:s'),
            'edit_user' => $userId
        );
    
        // Initialize all approver fields to 0
        for ($i = 1; $i <= 5; $i++) {
            $temp_data["approver_{$i}a"] = 0;
            $temp_data["approver_{$i}b"] = 0;
        }
    
        // Dynamically assign approver IDs if provided in $data
        for ($i = 3; $i <= 12; $i++) {
            if (isset($data[$i]) && !empty($data[$i])) {
                $approver_id = $this->getEmployeeTableId($data[$i]) ?: 0;
                $suffix = ($i % 2 == 1) ? 'a' : 'b';
                $index = ceil(($i - 2) / 2);
                $temp_data["approver_{$index}{$suffix}"] = $approver_id;
            }
        }
    
        if ($result > 0) {
            // Update if duplicate exists
            $this->db->where('empl_id', $empl_id);
            $this->db->update('tbl_approvers_offset', $temp_data);
        } else {
            // Insert if no duplicate
            $temp_data['create_date'] = date('Y-m-d H:i:s');
            $this->db->insert('tbl_approvers_offset', $temp_data);
        }
    }

        // $employeeStatus = [];

        // for ($i = 3; $i <= 12; $i++) {
        //     if (!empty($data[$i])) {
        //         $col_empl_cmid = $data[$i];
        //         if (!isset($employeeStatus[$col_empl_cmid])) {
        //             $employeeStatus[$col_empl_cmid] = $this->getEmployeeTableId($col_empl_cmid);
        //         }
        //     }
        // }

        // $uniqueEmployeeIds = [];
        // foreach ($employeeStatus as $col_empl_cmid => $employeeId) {
        //     if ($employeeId !== null) {
        //         if (in_array($employeeId, $uniqueEmployeeIds)) {
        //             continue;
        //         }
        //         $uniqueEmployeeIds[] = $employeeId;
        //     } else {
        //         continue;
        //     }
        // }

        // foreach ($uniqueEmployeeIds as $index => $employeeId) {
        //     $temp_data["approver_" . (intdiv($index, 2) + 1) . chr(97 + ($index % 2))] = $employeeId;
        // }

        // $temp_data['edit_date'] = date('Y-m-d H:i:s');
        // $temp_data['edit_user'] = $userId;

        // $this->db->where('empl_id', $data[0]);
        // $this->db->update('tbl_approvers_offset', $temp_data);
        // $res = $this->db->affected_rows();
        // return $res;
    // }

    function insert_approval_offset($data, $userId)
    {
        $temp_data = array();

        $temp_data['empl_id'] = $data[0];
        $temp_data['approver_1a'] = 0;
        $temp_data['approver_1b'] = 0;
        $temp_data['approver_2a'] = 0;
        $temp_data['approver_2b'] = 0;
        $temp_data['approver_3a'] = 0;
        $temp_data['approver_3b'] = 0;
        $temp_data['approver_4a'] = 0;
        $temp_data['approver_4b'] = 0;
        $temp_data['approver_5a'] = 0;
        $temp_data['approver_5b'] = 0;
        $temp_data['auto_approve'] = $data[2];

        $employeeStatus = [];

        for ($i = 3; $i <= 12; $i++) {
            if (!empty($data[$i])) {
                $col_empl_cmid = $data[$i];
                if (!isset($employeeStatus[$col_empl_cmid])) {
                    $employeeStatus[$col_empl_cmid] = $this->getEmployeeTableId($col_empl_cmid);
                }
            }
        }
        foreach ($employeeStatus as $col_empl_cmid => $employeeId) {
            if ($employeeId !== null) {
                if (isset($data[3]) && $data[3] === $col_empl_cmid) $temp_data['approver_1a'] = $employeeId;
                if (isset($data[4]) && $data[4] === $col_empl_cmid) $temp_data['approver_1b'] = $employeeId;
                if (isset($data[5]) && $data[5] === $col_empl_cmid) $temp_data['approver_2a'] = $employeeId;
                if (isset($data[6]) && $data[6] === $col_empl_cmid) $temp_data['approver_2b'] = $employeeId;
                if (isset($data[7]) && $data[7] === $col_empl_cmid) $temp_data['approver_3a'] = $employeeId;
                if (isset($data[8]) && $data[8] === $col_empl_cmid) $temp_data['approver_3b'] = $employeeId;
                if (isset($data[9]) && $data[9] === $col_empl_cmid) $temp_data['approver_4a'] = $employeeId;
                if (isset($data[10]) && $data[10] === $col_empl_cmid) $temp_data['approver_4b'] = $employeeId;
                if (isset($data[11]) && $data[11] === $col_empl_cmid) $temp_data['approver_5a'] = $employeeId;
                if (isset($data[12]) && $data[12] === $col_empl_cmid) $temp_data['approver_5b'] = $employeeId;
            }
        }

        $temp_data['edit_date'] = date('Y-m-d H:i:s');
        $temp_data['create_date'] = date('Y-m-d H:i:s');
        $temp_data['edit_user'] = $userId;

        $this->db->insert('tbl_approvers_offset', $temp_data);
        $inserted_rows = $this->db->affected_rows();

        return $inserted_rows;
    }
    function GET_ALL_EMPLOYEES_SEARCH_DIRECTORIES()
    {
        // ORDER BY LENGTH(col_empl_cmid), col_empl_cmid
        // ORDER BY  col_empl_cmid
        $sql   = "SELECT id,col_last_name,col_midl_name,col_frst_name,col_empl_cmid,col_suffix FROM tbl_employee_infos WHERE disabled=0 ORDER BY col_empl_cmid + 0 ASC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ONBOARDING_LIST($userId, $status, $limit, $offset)
    {
        $this->db->select('tb1.id,date,task_name,tb1.status');
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as employee", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as person_in_charge", false);
        $this->db->from('tbl_employee_onboarding as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.employee_id=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.person_in_charge=tb3.id', 'left')
            // ->from('tbl_employee_onboarding as tb1')
            ->where('tb1.employee_id', $userId);
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function GET_ONBOARDING_LIST_COUNT($userId, $status)
    {
        $this->db->select('tb1.id')
            ->from('tbl_employee_onboarding as tb1')
            ->where('tb1.employee_id', $userId);
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }


    function GET_SPECIFIC_ONBOARDING_DATA($id)
    {
        $sql = "select * from tbl_employee_onboarding WHERE id = ?";
        $this->db->select('tb1.id,date,task_name,tb1.status');
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as employee", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as person_in_charge", false);
        $this->db->from('tbl_employee_onboarding as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.employee_id=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.person_in_charge=tb3.id', 'left')
            // ->from('tbl_employee_onboarding as tb1')
            ->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function ADD_DATA($table_name, $data)
    {
        return $this->db->insert($table_name, $data);
    }

    function UPDATE_ONBOARDING_DATA($id, $table, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($table, $data);
    }



    // Search drop down list used in controller salary_details, approval_routes and payroll_assignment
    function GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID()
    {
        $sql   = "SELECT id,col_last_name,col_midl_name,col_frst_name,col_empl_cmid,col_suffix FROM tbl_employee_infos WHERE disabled=0 ORDER BY col_empl_cmid + 0 ASC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_EMPLOYEES_SEARCH_SETUP_ORGANIZATION()
    {
        $sql   = "SELECT id,col_last_name,col_midl_name,col_frst_name,col_empl_cmid,col_suffix FROM tbl_employee_infos 
        WHERE 
        (termination_date IS NULL OR termination_date = '0000-00-00') AND
        disabled=0 ORDER BY col_empl_cmid + 0 ASC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_EMPLOYEES_SEARCH_INACTIVE()
    {
        $sql   = "SELECT id,col_last_name,col_midl_name,col_frst_name,col_empl_cmid FROM tbl_employee_infos WHERE disabled=1";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }


    function GET_FILTERED_EMPLOYEELIST_WORK_DAYS($offset, $row, $branch, $dept, $division, $clubhouse, $section, $group, $team, $line, $year, $searchId)
    {
        $conditions = [];
        $parameters = [];
        $conditions2 = [];
        $parameters2 = [];

        if ($branch !== "all" && isset($branch) && $branch !== "undefined") {
            $conditions[] = "col_empl_branch = ?";
            $parameters[] = $branch;
        }

        if ($dept !== "all" && isset($dept) && $dept !== "undefined") {
            $conditions[] = "col_empl_dept = ?";
            $parameters[] = $dept;
        }

        if ($division !== "all" && isset($division) && $division !== "undefined") {
            $conditions[] = "col_empl_divi = ?";
            $parameters[] = $division;
        }

        if ($clubhouse !== "all" && isset($clubhouse) && $clubhouse !== "undefined") {
            $conditions[] = "col_empl_club = ?";
            $parameters[] = $clubhouse;
        }

        if ($section !== "all" && isset($section) && $section !== "undefined") {
            $conditions[] = "col_empl_sect = ?";
            $parameters[] = $section;
        }

        if ($group !== "all" && isset($group) && $group !== "undefined") {
            $conditions[] = "col_empl_group = ?";
            $parameters[] = $group;
        }

        if ($team !== "all" && isset($team) && $team !== "undefined") {
            $conditions[] = "col_empl_team = ?";
            $parameters[] = $team;
        }

        if ($line !== "all" && isset($line) && $line !== "undefined") {
            $conditions[] = "col_empl_line = ?";
            $parameters[] = $line;
        }
        if ($year !== "all" && isset($year) && $year !== "undefined") {
            // $conditions2[] = "y.id = ?";
            $conditions2[] = "w.year = ?";
            // $conditions[] = "(y.id = ? OR w.empl_id IS NULL)";
            $parameters2[] = $year;
        }
        if ($searchId !== "all" && isset($searchId) && $searchId !== "undefined") {
            $conditions[] = "i.id = ?";
            $parameters[] = $searchId;
        }

        $whereClause = (!empty($conditions)) ? "AND " . implode(" AND ", $conditions) : "";
        $whereClause2 = (!empty($conditions2)) ? "AND " . implode(" AND ", $conditions2) : "";

        $sql = "SELECT DISTINCT i.id,
        CONCAT_WS('',COALESCE(col_empl_cmid, ''), 
        CASE WHEN col_last_name IS NOT NULL AND col_last_name != '' THEN CONCAT('-', col_last_name) ELSE '' END,
        CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS fullname,
        w.days,
        y.name
        FROM tbl_employee_infos as i
        LEFT JOIN tbl_employee_work_days as w ON i.id = w.empl_id $whereClause2
        LEFT JOIN tbl_std_years as y ON w.year = y.id 
        WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0
        $whereClause
        
        ORDER BY col_empl_cmid + 0 ASC
        LIMIT " . $offset . ", " . $row . " ";


        // $query = $this->db->query($sql, $parameters2, $parameters);
        $query = $this->db->query($sql, array_merge($parameters2, $parameters));
        $query->next_result();

        return $query->result();
    }
    function GET_FILTERED_EMPLOYEELIST_WORK_DAYS_COUNT($offset, $row, $branch, $dept, $division, $clubhouse, $section, $group, $team, $line, $year, $searchId)
    {
        $conditions = [];
        $parameters = [];
        $conditions2 = [];
        $parameters2 = [];

        if ($branch !== "all" && isset($branch) && $branch !== "undefined") {
            $conditions[] = "col_empl_branch = ?";
            $parameters[] = $branch;
        }

        if ($dept !== "all" && isset($dept) && $dept !== "undefined") {
            $conditions[] = "col_empl_dept = ?";
            $parameters[] = $dept;
        }

        if ($division !== "all" && isset($division) && $division !== "undefined") {
            $conditions[] = "col_empl_divi = ?";
            $parameters[] = $division;
        }

        if ($clubhouse !== "all" && isset($clubhouse) && $clubhouse !== "undefined") {
            $conditions[] = "col_empl_club = ?";
            $parameters[] = $clubhouse;
        }

        if ($section !== "all" && isset($section) && $section !== "undefined") {
            $conditions[] = "col_empl_sect = ?";
            $parameters[] = $section;
        }

        if ($group !== "all" && isset($group) && $group !== "undefined") {
            $conditions[] = "col_empl_group = ?";
            $parameters[] = $group;
        }

        if ($team !== "all" && isset($team) && $team !== "undefined") {
            $conditions[] = "col_empl_team = ?";
            $parameters[] = $team;
        }

        if ($line !== "all" && isset($line) && $line !== "undefined") {
            $conditions[] = "col_empl_line = ?";
            $parameters[] = $line;
        }
        if ($year !== "all" && isset($year) && $year !== "undefined") {
            // $conditions2[] = "y.id = ?";
            $conditions2[] = "w.year = ?";
            // $conditions[] = "(y.id = ? OR w.empl_id IS NULL)";
            $parameters2[] = $year;
        }
        if ($searchId !== "all" && isset($searchId) && $searchId !== "undefined") {
            $conditions[] = "i.id = ?";
            $parameters[] = $searchId;
        }

        $whereClause = (!empty($conditions)) ? "AND " . implode(" AND ", $conditions) : "";
        $whereClause2 = (!empty($conditions2)) ? "AND " . implode(" AND ", $conditions2) : "";

        $sql = "SELECT DISTINCT i.id,
        CONCAT_WS('',COALESCE(col_empl_cmid, ''), 
        CASE WHEN col_last_name IS NOT NULL AND col_last_name != '' THEN CONCAT('-', col_last_name) ELSE '' END,
        CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS fullname,
        w.days,
        y.name
        FROM tbl_employee_infos as i
        LEFT JOIN tbl_employee_work_days as w ON i.id = w.empl_id $whereClause2
        LEFT JOIN tbl_std_years as y ON w.year = y.id 
        WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0
        $whereClause
        
        ORDER BY col_empl_cmid + 0 ASC ";

        $query = $this->db->query($sql, array_merge($parameters2, $parameters));
        return $query->num_rows();
    }

    function update_setting_tables_where($table, $data, $edit_user)
    {
        $date = date('Y-m-d H:i:s');
        $id = $data['id'];
        $year = $data['year'];
        $days = $data['days'];
        // $columns = array();
        // $values = array();
        // $params = array();

        // foreach ($data as $key => $value) {
        //     if ($key !== 'id' || $key !== 'year') {
        //         $columns[] = $key . '= ?';
        //         $values[] = $value;
        //         $params[] = '?';
        //     }
        // }
        // $columns = implode(', ', $columns);
        // $params = implode(', ', $params);
        $sql = "UPDATE $table SET edit_date=?, edit_user=?, days=? WHERE empl_id=? AND year=?";
        // $values[] = $id;
        // $values[] = $year;
        // $query = $this->db->query($sql, array_merge([$date, $edit_user], $values));
        $query = $this->db->query($sql, array_merge([$date, $edit_user, $days, $id, $year]));
        if ($query !== false && $this->db->affected_rows() > 0) {
            // The update was successful
            return "updated";
        } else {
            // $arrayValues = array_merge([$date, $date, $edit_user], $values);
            // $sql = "INSERT INTO $table (create_date, edit_date, edit_user, $columns) VALUES (?, ?, ?, $params)";
            $sql = "INSERT INTO $table (create_date, edit_date, edit_user, empl_id, days, year) VALUES (?, ?, ?, ?, ?, ?)";
            // $query = $this->db->query($sql, $arrayValues);
            $query = $this->db->query($sql, array_merge([$date, $date, $edit_user, $id, $days, $year]));
            if ($query !== false && $this->db->affected_rows() > 0) {
                return "inserted";
            } else {
                return "failedInsert";
            }
        }
    }

    function GET_FILTERED_EMPLOYEELIST_PAYROLL_ASSIGNMENT($offset, $row, $branch, $dept, $division, $clubhouse, $section, $group, $team, $line, $search)
    {
        $conditions = [];
        $parameters = [];

        if ($branch !== "all" && isset($branch) && $branch !== "undefined") {
            $conditions[] = "t1.col_empl_branch = ?";
            $parameters[] = $branch;
        }

        if ($dept !== "all" && isset($dept) && $dept !== "undefined") {
            $conditions[] = "t1.col_empl_dept = ?";
            $parameters[] = $dept;
        }

        if ($division !== "all" && isset($division) && $division !== "undefined") {
            $conditions[] = "t1.col_empl_divi = ?";
            $parameters[] = $division;
        }

        if ($clubhouse !== "all" && isset($clubhouse) && $clubhouse !== "undefined") {
            $conditions[] = "t1.col_empl_club = ?";
            $parameters[] = $clubhouse;
        }

        if ($section !== "all" && isset($section) && $section !== "undefined") {
            $conditions[] = "t1.col_empl_sect = ?";
            $parameters[] = $section;
        }

        if ($group !== "all" && isset($group) && $group !== "undefined") {
            $conditions[] = "t1.col_empl_group = ?";
            $parameters[] = $group;
        }

        if ($team !== "all" && isset($team) && $team !== "undefined") {
            $conditions[] = "t1.col_empl_team = ?";
            $parameters[] = $team;
        }

        if ($line !== "all" && isset($line) && $line !== "undefined") {
            $conditions[] = "t1.col_empl_line = ?";
            $parameters[] = $line;
        }
        if ($search !== "all" && isset($search) && $search !== "undefined") {
            $conditions[] = "t1.id = ?";
            $parameters[] = $search;
        }

        $whereClause = (!empty($conditions)) ? "AND " . implode(" AND ", $conditions) : "";

        $sql = "SELECT CONCAT_WS('',COALESCE(t1.col_empl_cmid, ''), 
            CASE WHEN t1.col_last_name IS NOT NULL AND t1.col_last_name != '' THEN CONCAT('-', t1.col_last_name) ELSE '' END,
            CASE WHEN t1.col_suffix IS NOT NULL AND t1.col_suffix != '' THEN CONCAT(' ', t1.col_suffix) ELSE '' END,
            CASE WHEN t1.col_frst_name IS NOT NULL AND t1.col_frst_name != '' THEN CONCAT(', ', t1.col_frst_name) ELSE '' END,
            CASE WHEN t1.col_midl_name IS NOT NULL AND t1.col_midl_name != '' THEN CONCAT(' ', LEFT(t1.col_midl_name, 1), '.') ELSE '' END
            ) AS employee, MAX(t2.assignment) AS assignment, t1.id as id
            FROM tbl_employee_infos as t1
            LEFT JOIN tbl_payroll_assignment as t2 on t1.id = t2.empl_id
            WHERE (t1.termination_date IS NULL OR t1.termination_date = '0000-00-00') AND t1.disabled=0
            
            $whereClause
            GROUP BY t1.id
            ORDER BY t1.col_empl_cmid + 0 ASC
            LIMIT " . $offset . ", " . $row . " ";

        $query = $this->db->query($sql, $parameters);
        $query->next_result();

        return $query->result();
    }
    function GET_FILTERED_EMPLOYEELIST_PAYROLL_ASSIGNMENT_COUNT($offset, $row, $branch, $dept, $division, $clubhouse, $section, $group, $team, $line, $search)
    {
        $conditions = [];
        $parameters = [];

        if ($branch !== "all" && isset($branch) && $branch !== "undefined") {
            $conditions[] = "t1.col_empl_branch = ?";
            $parameters[] = $branch;
        }

        if ($dept !== "all" && isset($dept) && $dept !== "undefined") {
            $conditions[] = "t1.col_empl_dept = ?";
            $parameters[] = $dept;
        }

        if ($division !== "all" && isset($division) && $division !== "undefined") {
            $conditions[] = "t1.col_empl_divi = ?";
            $parameters[] = $division;
        }

        if ($clubhouse !== "all" && isset($clubhouse) && $clubhouse !== "undefined") {
            $conditions[] = "t1.col_empl_club = ?";
            $parameters[] = $clubhouse;
        }

        if ($section !== "all" && isset($section) && $section !== "undefined") {
            $conditions[] = "t1.col_empl_sect = ?";
            $parameters[] = $section;
        }

        if ($group !== "all" && isset($group) && $group !== "undefined") {
            $conditions[] = "t1.col_empl_group = ?";
            $parameters[] = $group;
        }

        if ($team !== "all" && isset($team) && $team !== "undefined") {
            $conditions[] = "t1.col_empl_team = ?";
            $parameters[] = $team;
        }

        if ($line !== "all" && isset($line) && $line !== "undefined") {
            $conditions[] = "t1.col_empl_line = ?";
            $parameters[] = $line;
        }
        if ($search !== "all" && isset($search) && $search !== "undefined") {
            $conditions[] = "t1.id = ?";
            $parameters[] = $search;
        }

        $whereClause = (!empty($conditions)) ? "AND " . implode(" AND ", $conditions) : "";

        $sql = "SELECT CONCAT_WS('',COALESCE(t1.col_empl_cmid, ''), 
            CASE WHEN t1.col_last_name IS NOT NULL AND t1.col_last_name != '' THEN CONCAT('-', t1.col_last_name) ELSE '' END,
            CASE WHEN t1.col_suffix IS NOT NULL AND t1.col_suffix != '' THEN CONCAT(' ', t1.col_suffix) ELSE '' END,
            CASE WHEN t1.col_frst_name IS NOT NULL AND t1.col_frst_name != '' THEN CONCAT(', ', t1.col_frst_name) ELSE '' END,
            CASE WHEN t1.col_midl_name IS NOT NULL AND t1.col_midl_name != '' THEN CONCAT(' ', LEFT(t1.col_midl_name, 1), '.') ELSE '' END
            ) AS employee, MAX(t2.assignment) AS assignment
            FROM tbl_employee_infos as t1
            LEFT JOIN tbl_payroll_assignment as t2 on t1.id = t2.empl_id
            WHERE (t1.termination_date IS NULL OR t1.termination_date = '0000-00-00') AND t1.disabled=0
            
            $whereClause
            GROUP BY t1.id
            ORDER BY t1.col_empl_cmid + 0 ASC";

        $query = $this->db->query($sql, $parameters);
        // $query->next_result();

        return $query->num_rows();
    }
    function GET_FILTERED_EMPLOYEELIST_PAYROLL_ASSIGNMENT_OLD($offset, $row, $branch, $dept, $division, $section, $group, $team, $line)
    {
        $conditions = [];
        $parameters = [];

        if ($branch !== "all" && isset($branch) && $branch !== "undefined") {
            $conditions[] = "col_empl_branch = ?";
            $parameters[] = $branch;
        }

        if ($dept !== "all" && isset($dept) && $dept !== "undefined") {
            $conditions[] = "col_empl_dept = ?";
            $parameters[] = $dept;
        }

        if ($division !== "all" && isset($division) && $division !== "undefined") {
            $conditions[] = "col_empl_divi = ?";
            $parameters[] = $division;
        }

        if ($section !== "all" && isset($section) && $section !== "undefined") {
            $conditions[] = "col_empl_sect = ?";
            $parameters[] = $section;
        }

        if ($group !== "all" && isset($group) && $group !== "undefined") {
            $conditions[] = "col_empl_group = ?";
            $parameters[] = $group;
        }

        if ($team !== "all" && isset($team) && $team !== "undefined") {
            $conditions[] = "col_empl_team = ?";
            $parameters[] = $team;
        }

        if ($line !== "all" && isset($line) && $line !== "undefined") {
            $conditions[] = "col_empl_line = ?";
            $parameters[] = $line;
        }

        $whereClause = (!empty($conditions)) ? "AND " . implode(" AND ", $conditions) : "";

        $sql = "SELECT id, col_suffix, col_empl_posi, col_empl_cmid, col_last_name, col_imag_path, col_midl_name, col_frst_name, col_empl_branch, col_empl_dept, col_empl_divi, col_empl_sect, col_empl_group, col_empl_team, col_empl_line, salary_rate, salary_type FROM tbl_employee_infos 
                WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0
                $whereClause
                ORDER BY col_empl_cmid + 0 ASC
                LIMIT " . $offset . ", " . $row . " ";

        $query = $this->db->query($sql, $parameters);
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

        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,col_empl_line,salary_rate,salary_type FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0
        AND col_empl_branch = $branch
        AND col_empl_dept   = $dept
        AND col_empl_divi   = $division
        AND col_empl_sect   = $section
        AND col_empl_group  = $group
        AND col_empl_team   = $team
        AND col_empl_line   = $line
        ORDER BY col_empl_cmid + 0 ASC";

        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function GET_STD_SETTINGS($table)
    {
        $query = $this->db->get($table);
        return $query->result();
    }
    function GET_EMPL_OTHER_INFO($employee_id)
    {
        $this->db->select('tb1.id,tb1.name,tb2.value');
        $this->db->from('tbl_std_custominfo as tb1');
        $this->db->join('tbl_employees_custominfo as tb2', "tb1.id=tb2.custom_info_id AND tb2.empl_id=$employee_id", 'left');
        $query = $this->db->get();
        return $query->result();
    }
    function GET_EMPL_OTHER_DATA_INFO($employee_id)
    {
        $this->db->select('tb1.id,tb1.empl_id,tb1.custom_info_id,tb2.name as field,tb1.value');
        $this->db->from('tbl_employees_custominfo as tb1');
        $this->db->join('tbl_std_custominfo as tb2', 'tb1.custom_info_id=tb2.id');
        $this->db->where('tb1.empl_id', $employee_id);
        $query = $this->db->get();
        return $query->result();
    }
    function GET_EMPL_OTHER_INFO_FIELD($empl_id, $field_id)
    {
        $this->db->select('tb1.id,tb1.name as field,tb2.value,tb2.custom_info_id');
        $this->db->from('tbl_std_custominfo as tb1');
        $this->db->join('tbl_employees_custominfo as tb2', ' tb1.id = tb2.custom_info_id AND tb2.empl_id =' . $empl_id, 'left');
        $this->db->where_in('tb1.id', $field_id);
        $query = $this->db->get();
        return $query->result();
    }
    function GET_COUNT_FILTERED_EMPLOYEE_PAYROLL_ASSIGNMENT($branch, $dept, $division, $section, $group, $team, $line)
    {

        $conditions = [];
        $parameters = [];

        if ($branch !== "all" && isset($branch) && $branch !== "undefined") {
            $conditions[] = "col_empl_branch = ?";
            $parameters[] = $branch;
        }

        if ($dept !== "all" && isset($dept) && $dept !== "undefined") {
            $conditions[] = "col_empl_dept = ?";
            $parameters[] = $dept;
        }

        if ($division !== "all" && isset($division) && $division !== "undefined") {
            $conditions[] = "col_empl_divi = ?";
            $parameters[] = $division;
        }

        if ($section !== "all" && isset($section) && $section !== "undefined") {
            $conditions[] = "col_empl_sect = ?";
            $parameters[] = $section;
        }

        if ($group !== "all" && isset($group) && $group !== "undefined") {
            $conditions[] = "col_empl_group = ?";
            $parameters[] = $group;
        }

        if ($team !== "all" && isset($team) && $team !== "undefined") {
            $conditions[] = "col_empl_team = ?";
            $parameters[] = $team;
        }

        if ($line !== "all" && isset($line) && $line !== "undefined") {
            $conditions[] = "col_empl_line = ?";
            $parameters[] = $line;
        }

        $whereClause = (!empty($conditions)) ? "AND " . implode(" AND ", $conditions) : "";

        $sql = "SELECT id, col_suffix, col_empl_posi, col_empl_cmid, col_last_name, col_imag_path, col_midl_name, col_frst_name, col_empl_branch, col_empl_dept, col_empl_divi, col_empl_sect, col_empl_group, col_empl_team, col_empl_line, salary_rate, salary_type FROM tbl_employee_infos 
                WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0
                $whereClause
                ORDER BY col_empl_cmid + 0 ASC";

        $query = $this->db->query($sql, $parameters);
        return $query->num_rows();
    }



    function GET_SEARCHED_PAYROLL_ASSIGNMENT($search)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 
        AND id=?
        -- AND (tbl_employee_infos.col_empl_cmid LIKE '%$search%' 
        -- OR CONCAT(col_last_name, ' ', col_frst_name, ' ', col_midl_name) LIKE '%$search%'
        -- OR CONCAT(col_last_name, ', ', col_frst_name, ' ', col_midl_name) LIKE '%$search%') 
        -- ORDER BY id ASC
        ";
        $query = $this->db->query($sql, array($search));
        $query->next_result();
        return $query->result();
    }
    function GET_YEARS_PAYROLL_ASSIGNMENT()
    {
        $sql = "SELECT id,name FROM tbl_std_years";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_YEARS_DESC()
    {
        $sql = "SELECT id,name FROM tbl_std_years ORDER BY name DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_PAYROLL_ASSIGNMENT()
    {
        $sql = "SELECT * FROM tbl_payroll_assignment ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_DEPARTMENT_2()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_DIVISION_2()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_divisions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_CLUBHOUSE_2()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_clubhouse";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_SECTION_2()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_BRANCH_2()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_branches";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_GROUP_2()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_groups";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_TEAM_2()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_teams";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_LINE_2()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function update_assignment_data($data_row)
    {
        $id         =  $data_row['id'];
        $assignment      =  $data_row['assignment'];
        $date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_payroll_assignment SET edit_date=?, assignment=? WHERE empl_id=?";
        $this->db->query($sql, array($date, $assignment, $id));
        if ($this->db->affected_rows() == 0) {
            $sql = "INSERT INTO tbl_payroll_assignment (create_date,edit_date,empl_id,assignment) VALUES (?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $id, $assignment));
        }
    }

    function GET_PAYROLL_ASSIGNMENT_COUNT()
    {
        $sql = "SELECT t1.id FROM tbl_employee_infos as t1
        LEFT JOIN tbl_payroll_assignment as t2 on t1.id = t2.empl_id
        WHERE (t1.termination_date IS NULL OR t1.termination_date = '0000-00-00') AND t1.disabled=0
        AND t2.assignment IS NULL
        GROUP BY t1.id";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function GET_SPECIFIC_PAYROLL_ASSIGNMENT($empl_id)
    {
        $sql = "SELECT * FROM tbl_payroll_assignment WHERE empl_id = ?";
        $query = $this->db->query($sql, array($empl_id));
        return $query->num_rows();
    }

    // function GET_EMPLOYEE_REQUIREMENTS_BY_ID($employeeTableId){
    //     $sql = "SELECT DISTINCT
    //     tb1.id AS tbl_std_requirements_id,
    //     tb1.name AS name,
    //     NULL AS tbl_employee_requirements_id,
    //     NULL AS attachment,
    //     NULL AS status,
    //     NULL AS req_id,
    //     NULL AS tbl_employee_infos_id,
    //     NULL AS col_empl_cmid
    //   FROM tbl_std_requirements AS tb1
    //   WHERE NOT EXISTS (
    //     SELECT 1
    //     FROM tbl_employee_requirements AS tb2
    //     LEFT JOIN tbl_employee_infos AS tb3 ON tb3.id = tb2.empl_id
    //     WHERE tb2.req_id = tb1.id AND tb3.id = ? AND tb1.status = 'Active'
    //   )
    //   UNION
    //   SELECT DISTINCT
    //     tb1.id AS tbl_std_requirements_id,
    //     tb1.name AS name,
    //     tb2.id AS tbl_employee_requirements_id,
    //     tb2.attachment AS attachment,
    //     tb2.status AS status,
    //     tb2.req_id AS req_id,
    //     tb3.id AS tbl_employee_infos_id,
    //     tb3.id AS col_empl_cmid
    //   FROM tbl_std_requirements AS tb1
    //   LEFT JOIN tbl_employee_requirements AS tb2 ON tb2.req_id = tb1.id
    //   LEFT JOIN tbl_employee_infos AS tb3 ON tb3.id = tb2.empl_id
    //   WHERE tb3.id = ? AND tb1.status = 'Active'
    //   GROUP BY tbl_std_requirements_id 
    //   ORDER BY name"; 
    //     $query = $this->db->query($sql, array($employeeTableId, $employeeTableId));
    //     $query->next_result();
    //     return $query->result(); 
    // }
    function GET_EMPLOYEE_REQUIREMENTS_BY_ID($employeeTableId)
    {
        $sql = "
            WITH all_requirements AS (
                SELECT DISTINCT
                    tb1.id AS tbl_std_requirements_id,
                    tb1.name AS name,
                    tb2.id AS tbl_employee_requirements_id,
                    tb2.attachment AS attachment,
                    tb2.status AS status,
                    tb2.req_id AS req_id,
                    tb3.id AS tbl_employee_infos_id,
                    tb3.id AS col_empl_cmid
                FROM tbl_std_requirements AS tb1
                LEFT JOIN tbl_employee_requirements AS tb2 ON tb2.req_id = tb1.id
                LEFT JOIN tbl_employee_infos AS tb3 ON tb3.id = tb2.empl_id
                WHERE tb3.id = ? AND tb1.status = 'Active'
                
                UNION
                
                SELECT DISTINCT
                    tb1.id AS tbl_std_requirements_id,
                    tb1.name AS name,
                    NULL AS tbl_employee_requirements_id,
                    NULL AS attachment,
                    NULL AS status,
                    NULL AS req_id,
                    NULL AS tbl_employee_infos_id,
                    NULL AS col_empl_cmid
                FROM tbl_std_requirements AS tb1
                LEFT JOIN tbl_employee_requirements AS tb2 ON tb2.req_id = tb1.id
                LEFT JOIN tbl_employee_infos AS tb3 ON tb3.id = tb2.empl_id
                WHERE tb1.id NOT IN (
                    SELECT DISTINCT tb1.id
                    FROM tbl_std_requirements AS tb1
                    LEFT JOIN tbl_employee_requirements AS tb2 ON tb2.req_id = tb1.id
                    LEFT JOIN tbl_employee_infos AS tb3 ON tb3.id = tb2.empl_id
                    WHERE tb3.id = ? AND tb2.is_deleted = 0
                ) AND tb1.status = 'Active'
            ),
            ranked_requirements AS (
                SELECT
                    *,
                    ROW_NUMBER() OVER (PARTITION BY name ORDER BY tbl_std_requirements_id) AS rn
                FROM all_requirements
            )
            SELECT *
            FROM ranked_requirements
            WHERE rn = 1
            ORDER BY name;
        ";

        $query = $this->db->query($sql, array($employeeTableId, $employeeTableId));
        return $query->result();
    }


    function DELETE_EMPLOYEE_REQUIREMENTS($emp_id, $req_id)
    {
        $sql = "UPDATE tbl_employee_requirements SET is_deleted = 1 WHERE empl_id = ? AND id = ?";
        $result = $this->db->query($sql, array($emp_id, $req_id));

        if (!$result) {
            // Log the query and error message for debugging
            log_message('error', 'Query failed: ' . $this->db->last_query());
            log_message('error', 'Error: ' . $this->db->error()['message']);
            return false;
        }

        return $this->db->affected_rows() > 0;
    }




    // function GET_EMPLOYEE_REQUIREMENTS_BY_ID($employeeTableId){
    //     $sql = "SELECT
    //         tb1.id AS tbl_std_requirements_id,
    //         tb1.name AS name,
    //         tb2.id AS tbl_employee_requirements_id,
    //         tb2.attachment AS attachment,
    //         tb2.status AS status,
    //         tb2.req_id AS req_id,
    //         tb3.id AS tbl_employee_infos_id,
    //         tb3.id AS col_empl_cmid
    //     FROM tbl_std_requirements AS tb1
    //     LEFT OUTER JOIN tbl_employee_requirements AS tb2 ON tb2.req_id = tb1.id
    //     LEFT JOIN tbl_employee_infos AS tb3 ON tb3.id = tb2.empl_id AND tb3.id = ?
    //     WHERE tb1.status = 'Active'
    //     -- GROUP BY tbl_std_requirements_id 
    //     ORDER BY name"; 
    //     $query = $this->db->query($sql, array($employeeTableId, $employeeTableId));
    //     $query->next_result();
    //     return $query->result(); 
    // }

    function GET_APPROVER_COUNT()
    {
        $sql = "SELECT COUNT(*) as count FROM `tbl_employee_infos` 
        LEFT JOIN tbl_approvers_leave ON  tbl_approvers_leave.empl_id = tbl_employee_infos.id
        WHERE (approver_1a IS NULL OR approver_1a = 0) AND 
        (approver_1b IS NULL OR approver_1b = 0) AND 
        (approver_2a IS NULL OR approver_2a = 0) AND 
        (approver_2b IS NULL OR approver_2b = 0) AND 
        (approver_3a IS NULL OR approver_3a = 0) AND 
        (approver_3b IS NULL OR approver_3b = 0)";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->count;
    }
    function UPDATE_EMPLOYEE_FENCE($data)
    {
        $has_data = $this->db->where('empl_id', $data['empl_id'])->get('tbl_employee_fences')->row();
        if ($has_data) {
            $this->db->where('empl_id', $data['empl_id'])->delete('tbl_employee_fences');
            $sql = $this->db->insert('tbl_employee_fences', $data);
            return $sql;
        } else {
            if (isset($data['fences']) && $data['fences'] && !empty(json_decode($data['fences']))) {
                $sql = $this->db->insert('tbl_employee_fences', $data);
                return $sql;
            }
        }
        return 1;
    }
    function GET_LIST_DATA($table)
    {
        $query = $this->db->get($table);
        return $query->result();
    }

    function GET_EMPLOYEE_LIST()
    {
        $this->db->select('id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name');
        $this->db->where("disabled = 0 AND (termination_date IS NULL OR termination_date = '0000-00-00') ");
        $this->db->order_by('col_empl_cmid + 0 ', 'ASC');
        $query = $this->db->get('tbl_employee_infos');
        return $query->result();
    }

    function GET_SALARY_TYPE_AND_RATE_COUNT()
    {
        $sql = "SELECT COUNT(*) as count FROM `tbl_employee_infos` WHERE (salary_rate = 0 OR salary_rate IS NULL) AND (salary_type = 0 OR salary_type IS NULL)";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->count;
    }
    function ADD_EMPL_CUSTOMIZE_FIELD($data)
    {
        return $this->db->insert_batch('tbl_employees_custominfo', $data);
    }
    function DELETE_EMPL_CUSTOMIZE_FIELD($empl_id)
    {
        $this->db->where('empl_id', $empl_id);
        return $this->db->delete('tbl_employees_custominfo');
    }


    function GET_DISABLED_EMPLOYEES($empl_id)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE col_empl_cmid=? AND disabled=1";
        $query = $this->db->query($sql, array($empl_id));
        return $query->row();
    }
} // edn of class employees_model extends CI_Model


function convertDateToMySQLFormat($inputDate)
{
    $dateComponents = explode('/', $inputDate);

    if (count($dateComponents) === 3) {
        $formattedDate = $dateComponents[2] . '-' . $dateComponents[1] . '-' . $dateComponents[0];
    } else {
        $formattedDate = null;
    }

    return $formattedDate;
}
