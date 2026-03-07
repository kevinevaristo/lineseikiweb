<?php
class selfservices_model extends CI_Model
{

    function update_table_data($table, $data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($table, $data);
        return $id;
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

    function send_messages_api($data)
    {
        if ($this->db->insert('tbl_messages', $data)) {
            return true;
        } else {
            return false;
        }
    }

    function get_group_member_name_by_groupId($groupId, $userId)
    {
        $this->db->select("DISTINCT
            CONCAT_WS('',
            CASE WHEN t2.col_last_name IS NOT NULL AND t2.col_last_name != '' THEN CONCAT(t2.col_last_name) ELSE '' END,
            CASE WHEN t2.col_suffix IS NOT NULL AND t2.col_suffix != '' THEN CONCAT(' ', t2.col_suffix) ELSE '' END,
            CASE WHEN t2.col_frst_name IS NOT NULL AND t2.col_frst_name != '' THEN CONCAT(', ', t2.col_frst_name) ELSE '' END,
            CASE WHEN t2.col_midl_name IS NOT NULL AND t2.col_midl_name != '' THEN CONCAT(' ', LEFT(t2.col_midl_name, 1), '.') ELSE '' END
        ) AS name
        ", false);
        $this->db->from('tbl_message_group_members as t1');
        $this->db->join('tbl_employee_infos as t2', 't1.empl_id = t2.id', 'left');
        $this->db->where('t1.group_id', $groupId);
        $this->db->where_not_in('t1.empl_id', $userId);
        // $this->db->where_not_in('t1.status',  array('Requested'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->name;
        } else {
            return null;
        }
    }
    function GET_USER_FENCES($userId)
    {

        $fences_id = $this->db->where('empl_id', $userId)->get('tbl_employee_fences')->row();
        if ($fences_id && $fences_id->fences != '[]') {
            $this->db->select('area')->where_in("id", json_decode($fences_id->fences));
            $fences = $this->db->get('tbl_fence_areas');
            $result = $fences->result();
            $fences_arr = array();
            foreach ($result as $area) {
                $fences_arr[] = $area->area;
            }
            return $fences_arr;
        }
        return array();
    }
    // function get_message_group_by_userId($userId){
    //     $this->db->select("t2.empl_id as id, t3.message, t4.col_imag_path,
    //         CONCAT_WS('',
    //         CASE WHEN t4.col_last_name IS NOT NULL AND t4.col_last_name != '' THEN CONCAT(t4.col_last_name) ELSE '' END,
    //         CASE WHEN t4.col_suffix IS NOT NULL AND t4.col_suffix != '' THEN CONCAT(' ', t4.col_suffix) ELSE '' END,
    //         CASE WHEN t4.col_frst_name IS NOT NULL AND t4.col_frst_name != '' THEN CONCAT(', ', t4.col_frst_name) ELSE '' END,
    //         CASE WHEN t4.col_midl_name IS NOT NULL AND t4.col_midl_name != '' THEN CONCAT(' ', LEFT(t4.col_midl_name, 1), '.') ELSE '' END
    //     ) AS name", false);
    //     $this->db->from('tbl_message_groups as t1');
    //     $this->db->join('tbl_message_group_members as t2', 't1.id = t2.group_id', 'left');
    //     $this->db->join('(
    //         SELECT group_id, MAX(edit_date) AS max_edit_date
    //         FROM tbl_messages
    //         GROUP BY group_id
    //     ) AS latest_messages', 't1.id = latest_messages.group_id', 'left');
    //     $this->db->join('tbl_messages as t3', 't1.id = t3.group_id AND t3.edit_date = latest_messages.max_edit_date', 'left');
    //     $this->db->join('tbl_employee_infos as t4', 't2.empl_id = t4.id', 'left');
    //     $this->db->where('t2.empl_id', $userId);
    //     $this->db->where_not_in('t2.status', array('Requested'));
    //     $this->db->order_by('t3.edit_date', 'DESC');
    //     // $this->db->group_by('t2.empl_id');s
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    function get_message_group_by_userId($userId)
    {

        $this->db->distinct();
        $this->db->select("t1.id");
        $this->db->from('tbl_message_groups as t1');
        $this->db->join('tbl_message_group_members as t2', 't1.id = t2.group_id', 'left');
        $this->db->where('t2.empl_id', $userId);
        $query = $this->db->get();
        $results = $query->result();

        $ids = array();
        foreach ($results as $row) {
            $ids[] = $row->id;
        }
        if (empty($ids)) {
            return [];
        }
        $this->db->select("t2.group_id as groupId, t3.message, t4.col_imag_path,t3.seen_by,
        CONCAT_WS('',
        CASE WHEN t4.col_last_name IS NOT NULL AND t4.col_last_name != '' THEN CONCAT(t4.col_last_name) ELSE '' END,
        CASE WHEN t4.col_suffix IS NOT NULL AND t4.col_suffix != '' THEN CONCAT(' ', t4.col_suffix) ELSE '' END,
        CASE WHEN t4.col_frst_name IS NOT NULL AND t4.col_frst_name != '' THEN CONCAT(', ', t4.col_frst_name) ELSE '' END,
        CASE WHEN t4.col_midl_name IS NOT NULL AND t4.col_midl_name != '' THEN CONCAT(' ', LEFT(t4.col_midl_name, 1), '.') ELSE '' END
            ) AS name
            ", false);
        $this->db->from('tbl_message_group_members as t2');
        $this->db->join('(SELECT group_id, MAX(edit_date) AS latest_edit_date FROM tbl_messages GROUP BY group_id) AS latest_messages', 't2.group_id = latest_messages.group_id', 'left');
        $this->db->join('tbl_messages as t3', 'latest_messages.group_id = t3.group_id AND latest_messages.latest_edit_date = t3.edit_date');
        $this->db->join('tbl_employee_infos as t4', 't2.empl_id = t4.id', 'left');
        $this->db->where_not_in('t2.empl_id', $userId);
        $this->db->where_in('t2.group_id', $ids);
        $this->db->order_by('t3.edit_date', 'DESC');
        $this->db->group_by('t2.group_id');
        $query = $this->db->get();
        return $query->result();
    }

    function get_message_group_id($senderId, $receiverId)
    {
        $this->db->select("t1.id", false);
        $this->db->from('tbl_message_groups as t1');
        $this->db->join('tbl_message_group_members as t2', 't1.id = t2.group_id', 'left');
        $this->db->where('t2.empl_id', $receiverId);
        $query = $this->db->get();
        $results = $query->result();
        $ids = array();
        foreach ($results as $row) {
            $ids[] = $row->id;
        }
        // $this->db->distinct();
        // $id=null;
        if (!empty($ids)) {
            $this->db->select("t1.id", false);
            $this->db->from('tbl_message_groups as t1');
            $this->db->join('tbl_message_group_members as t2', 't1.id = t2.group_id', 'left');
            $this->db->where('t2.empl_id', $senderId);
            $this->db->where_in('t2.group_id', $ids);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $row = $query->row();
                return $row->id;
            }
        }
        // return 'insert';
        // return $query->result();
        // if ($query->num_rows() > 0) {
        //     $row = $query->row();
        //     return $row->id;
        // } else {
        $data1 = array(
            'create_date' => date("Y-m-d H:i:s"),
            'edit_date' => date("Y-m-d H:i:s"),
            'edit_user' => $senderId,
            'is_deleted' => 0,
            'status' => 'Active',
        );
        $this->db->insert('tbl_message_groups', $data1);
        $groupId = $this->db->insert_id();

        $data2 = array(
            'create_date' => date("Y-m-d H:i:s"),
            'edit_date' => date("Y-m-d H:i:s"),
            'edit_user' => $senderId,
            'is_deleted' => 0,
            'group_id' => $groupId,
            'empl_id' => $senderId,
            'status' => 'Requested',
        );
        $this->db->insert('tbl_message_group_members', $data2);

        $data3 = array(
            'create_date' => date("Y-m-d H:i:s"),
            'edit_date' => date("Y-m-d H:i:s"),
            'edit_user' => $senderId,
            'is_deleted' => 0,
            'group_id' => $groupId,
            'empl_id' => $receiverId,
            'status' => 'Accepted',
        );
        $this->db->insert('tbl_message_group_members', $data3);
        // Return the inserted id
        return $groupId;
        // }
    }
    function checkMembership($groupId, $userId)
    {
        $this->db->select("t1.id");
        $this->db->where("t1.group_id", $groupId);
        $this->db->where("t1.empl_id", $userId);
        $this->db->from('tbl_message_group_members as t1');
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if ($num_rows < 1) {
            return false;
        }
        return true;
    }
    function get_unseen_messages($userId)
    {
        $this->db->distinct();
        $this->db->select("t1.group_id");
        $this->db->where("t1.empl_id", $userId);
        $this->db->from('tbl_message_group_members as t1');
        $query = $this->db->get();
        $first_query_result = $query->result();
        $ids = array();
        foreach ($first_query_result as $row) {
            $ids[] = $row->group_id;
        }

        $sql = "SELECT t1.id, t3.seen_by, t2.group_id
        FROM tbl_employee_infos AS t1
        LEFT JOIN tbl_message_group_members AS t2 ON t2.empl_id = t1.id 
        JOIN tbl_messages AS t3 ON t3.group_id = t2.group_id 
        WHERE t2.group_id IN ('" . implode("','", $ids) . "') 
        AND FIND_IN_SET(?, t3.seen_by) = 0
        GROUP BY t2.group_id";

        $query = $this->db->query($sql, array($userId));
        return $query->num_rows();
        // return array($query->result(), $userId);
    }
    function get_messages($groupId, $userId)
    {
        $this->db->select("t1.id");
        $this->db->where("t1.group_id", $groupId);
        $this->db->where("t1.empl_id", $userId);
        $this->db->from('tbl_message_group_members as t1');
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        if ($num_rows < 1) {
            return 'Prohibited';
        }

        $this->db->select("t1.id,t1.sender_id,t1.message,t1.attachment,t2.col_imag_path,t1.create_date,t1.seen_by,
            CONCAT_WS('',
            CASE WHEN t2.col_last_name IS NOT NULL AND t2.col_last_name != '' THEN CONCAT(t2.col_last_name) ELSE '' END,
            CASE WHEN t2.col_suffix IS NOT NULL AND t2.col_suffix != '' THEN CONCAT(' ', t2.col_suffix) ELSE '' END,
            CASE WHEN t2.col_frst_name IS NOT NULL AND t2.col_frst_name != '' THEN CONCAT(', ', t2.col_frst_name) ELSE '' END,
            CASE WHEN t2.col_midl_name IS NOT NULL AND t2.col_midl_name != '' THEN CONCAT(' ', LEFT(t2.col_midl_name, 1), '.') ELSE '' END
        ) AS name
        ", false);
        $this->db->from('tbl_messages as t1');
        $this->db->join('tbl_employee_infos as t2', 't1.sender_id = t2.id', 'left');
        $this->db->where("t1.group_id", $groupId);
        $this->db->order_by('t1.edit_date', 'DESC');
        $query = $this->db->get();
        $results = $query->result();

        foreach ($results as $row) {
            $existingSeenBy = $row->seen_by;
            $existingIds = explode(',', $existingSeenBy);
            $existingIds[] = $userId;
            $uniqueIds = array_unique(array_filter($existingIds));
            $newSeenBy = implode(',', $uniqueIds);
            $this->db->where('id', $row->id);
            $this->db->update('tbl_messages', ['seen_by' => $newSeenBy]);
        }

        return $results;
    }

    function GET_EMPLOYEES_BY_SEARCH($search)
    {
        $this->db->select("DISTINCT t1.id,t1.col_imag_path,t2.name as position,
            CONCAT_WS('',
                CASE WHEN t1.col_last_name IS NOT NULL AND t1.col_last_name != '' THEN CONCAT(t1.col_last_name) ELSE '' END,
                CASE WHEN t1.col_suffix IS NOT NULL AND t1.col_suffix != '' THEN CONCAT(' ', t1.col_suffix) ELSE '' END,
                CASE WHEN t1.col_frst_name IS NOT NULL AND t1.col_frst_name != '' THEN CONCAT(', ', t1.col_frst_name) ELSE '' END,
                CASE WHEN t1.col_midl_name IS NOT NULL AND t1.col_midl_name != '' THEN CONCAT(' ', LEFT(t1.col_midl_name, 1), '.') ELSE '' END
            ) AS name
            ", false);
        $this->db->from('tbl_employee_infos as t1');
        $this->db->join('tbl_std_positions as t2', 't1.col_empl_posi = t2.id', 'left');
        $this->db->where("t1.disabled = 0 AND (t1.termination_date IS NULL OR t1.termination_date = '0000-00-00') ");

        if (!empty($search)) {
            $this->db->where("(t1.col_last_name LIKE '%$search%' OR t1.col_frst_name LIKE '%$search%' OR t1.col_midl_name LIKE '%$search%' OR t2.name LIKE '%$search%')");
        }

        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }




    function GET_USER_ACTIVITIES($user_id, $limit, $offset)
    {
        $this->db->select("tb1.id,tb2.status,tb2.description,tb2.title,tb2.duration,tb2.location,tb2.start_date,tb2.end_date,tb1.response");
        $this->db->from("tbl_participants as tb1");
        $this->db->join("tbl_activities as tb2", "tb1.activity_id=tb2.id", "left");
        $this->db->where("tb1.empl_id", $user_id);
        $this->db->order_by("tb1.id", "desc");
        $query = $this->db->get();
        return $query->result();
    }
    function GET_USER_ACTIVITIES_COUNT($user_id)
    {
        $this->db->where("empl_id", $user_id);
        $query = $this->db->get("tbl_participants");
        return $query->num_rows();
    }
    function GET_EMPLOYEES()
    {
        $this->db->select("id,
        CONCAT_WS('',
            CASE WHEN col_empl_cmid IS NOT NULL AND col_empl_cmid != '' THEN CONCAT(col_empl_cmid) ELSE '' END,
            CASE WHEN col_last_name IS NOT NULL AND col_last_name != '' THEN CONCAT('-', col_last_name) ELSE '' END,
            CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
            CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
            CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS name
        ", false);
        $this->db->where("disabled = 0 AND (termination_date IS NULL OR termination_date = '0000-00-00') ");
        $this->db->order_by('col_empl_cmid + 0 ', 'ASC');
        $query = $this->db->get('tbl_employee_infos');
        return $query->result();
    }

    function get_reimbursement_types()
    {
        $this->db->select("id, name", false);
        $this->db->where("is_deleted = 0 AND status='Active' ");
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('tbl_std_reimbursementtypes');
        return $query->result();
    }

    function get_cashadvance_types()
    {
        $this->db->select("id, name", false);
        $this->db->where("is_deleted = 0 AND status='Active' ");
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('tbl_std_cashadvancetypes');
        return $query->result();
    }

    function add_table_data($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function get_reimbursement($row, $offset, $id, $status)
    {
        $sql = "SELECT t1.id,t1.description,t1.amount,t1.remarks,t1.attachment,t1.status,
        CONCAT_WS('',COALESCE(t2.col_empl_cmid, ''), 
        CASE WHEN t2.col_last_name  IS NOT NULL AND t2.col_last_name != '' THEN CONCAT('-', t2.col_last_name ) ELSE '' END,
        CASE WHEN t2.col_suffix IS NOT NULL AND t2.col_suffix != '' THEN CONCAT(' ', t2.col_suffix) ELSE '' END,
        CASE WHEN t2.col_frst_name IS NOT NULL AND t2.col_frst_name != '' THEN CONCAT(', ', t2.col_frst_name) ELSE '' END,
        CASE WHEN t2.col_midl_name IS NOT NULL AND t2.col_midl_name != '' THEN CONCAT(' ', LEFT(t2.col_midl_name, 1), '.') ELSE '' END
        ) AS employee,
        t3.name as type
        
        FROM tbl_benefits_reimbursement as t1
        LEFT JOIN tbl_employee_infos as t2 ON t2.id = t1.empl_id
        LEFT JOIN tbl_std_reimbursementtypes as t3 ON t3.id = t1.type
        WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 AND t1.is_deleted=0
        AND t2.id = ?";

        if (!empty($status)) {
            $sql .= " AND t1.status = ?";
            $params = array($id, $status);
        } else {
            $params = array($id);
        }

        $sql .= " ORDER BY t1.id DESC LIMIT $row OFFSET $offset";

        $query = $this->db->query($sql, $params);
        $query->next_result();
        return $query->result();
    }

    function get_cashadvance($row, $offset, $id, $status)
    {
        $sql = "SELECT t1.id,t1.description,t1.amount,t1.remarks,t1.attachment,t1.status,
        CONCAT_WS('',COALESCE(t2.col_empl_cmid, ''), 
        CASE WHEN t2.col_last_name  IS NOT NULL AND t2.col_last_name != '' THEN CONCAT('-', t2.col_last_name ) ELSE '' END,
        CASE WHEN t2.col_suffix IS NOT NULL AND t2.col_suffix != '' THEN CONCAT(' ', t2.col_suffix) ELSE '' END,
        CASE WHEN t2.col_frst_name IS NOT NULL AND t2.col_frst_name != '' THEN CONCAT(', ', t2.col_frst_name) ELSE '' END,
        CASE WHEN t2.col_midl_name IS NOT NULL AND t2.col_midl_name != '' THEN CONCAT(' ', LEFT(t2.col_midl_name, 1), '.') ELSE '' END
        ) AS employee,
        t3.name as type
        
        FROM tbl_benefits_cashadvance as t1
        LEFT JOIN tbl_employee_infos as t2 ON t2.id = t1.empl_id
        LEFT JOIN tbl_std_cashadvancetypes as t3 ON t3.id = t1.type
        WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 AND t1.is_deleted=0
        AND t2.id = ?";

        if (!empty($status)) {
            $sql .= " AND t1.status = ?";
            $params = array($id, $status);
        } else {
            $params = array($id);
        }

        $sql .= " ORDER BY t1.id DESC LIMIT $row OFFSET $offset";

        $query = $this->db->query($sql, $params);
        $query->next_result();
        return $query->result();
    }

    // function get_reimbursement_count($row, $offset, $id, $status)
    // {
    //     $sql = "SELECT t1.id,t1.description,t1.amount,t1.remarks,t1.attachment,t1.status,
    //     CONCAT_WS('',COALESCE(t2.col_empl_cmid, ''), 
    //     CASE WHEN t2.col_last_name  IS NOT NULL AND t2.col_last_name != '' THEN CONCAT('-', t2.col_last_name ) ELSE '' END,
    //     CASE WHEN t2.col_suffix IS NOT NULL AND t2.col_suffix != '' THEN CONCAT(' ', t2.col_suffix) ELSE '' END,
    //     CASE WHEN t2.col_frst_name IS NOT NULL AND t2.col_frst_name != '' THEN CONCAT(', ', t2.col_frst_name) ELSE '' END,
    //     CASE WHEN t2.col_midl_name IS NOT NULL AND t2.col_midl_name != '' THEN CONCAT(' ', LEFT(t2.col_midl_name, 1), '.') ELSE '' END
    //     ) AS employee,
    //     t3.name as type

    //     FROM tbl_benefits_reimbursement as t1
    //     LEFT JOIN tbl_employee_infos as t2 ON t2.id = t1.empl_id
    //     LEFT JOIN tbl_std_reimbursementtypes as t3 ON t3.id = t1.type
    //     WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 AND t1.is_deleted=0
    //     AND t2.id = ?";

    //     if (!empty($status)) {
    //         $sql .= " AND t1.status = ?";
    //         $params = array($id, $status);
    //     } else {
    //         $params = array($id);
    //     }

    //     $query = $this->db->query($sql, $params);
    //     $query->next_result();
    //     return $query->result();
    // }

    function get_reimbursement_count($row, $offset, $id, $status)
    {
        $sql = "SELECT COUNT(*) as count
                FROM tbl_benefits_reimbursement as t1
                LEFT JOIN tbl_employee_infos as t2 ON t2.id = t1.empl_id
                LEFT JOIN tbl_std_reimbursementtypes as t3 ON t3.id = t1.type
                WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 AND t1.is_deleted=0
                AND t2.id = ?";

        if (!empty($status)) {
            $sql .= " AND t1.status = ?";
            $params = array($id, $status);
        } else {
            $params = array($id);
        }

        $query = $this->db->query($sql, $params);
        $result = $query->row(); // Assuming this returns a single row with the count
        return $result->count;
    }


    function get_cashadvance_count($row, $offset, $id, $status)
    {
        $sql = "SELECT COUNT(*) as count
                FROM tbl_benefits_cashadvance as t1
                LEFT JOIN tbl_employee_infos as t2 ON t2.id = t1.empl_id
                LEFT JOIN tbl_std_cashadvancetypes as t3 ON t3.id = t1.type
                WHERE (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 AND t1.is_deleted=0
                AND t2.id = ?";

        if (!empty($status)) {
            $sql .= " AND t1.status = ?";
            $params = array($id, $status);
        } else {
            $params = array($id);
        }

        $query = $this->db->query($sql, $params);
        $result = $query->row(); // Assuming this returns a single row with the count
        return $result->count;
    }


    function get_reimbursement_id_approval($id)
    {
        $sql = "SELECT t1.id,t1.description,t1.amount,t1.remarks,t1.attachment,t1.empl_id,t1.create_date,t1.status,t1.approver_date,
        CONCAT_WS('',COALESCE(t2.col_empl_cmid, ''), 
        CASE WHEN t2.col_last_name  IS NOT NULL AND t2.col_last_name != '' THEN CONCAT('-', t2.col_last_name ) ELSE '' END,
        CASE WHEN t2.col_suffix IS NOT NULL AND t2.col_suffix != '' THEN CONCAT(' ', t2.col_suffix) ELSE '' END,
        CASE WHEN t2.col_frst_name IS NOT NULL AND t2.col_frst_name != '' THEN CONCAT(', ', t2.col_frst_name) ELSE '' END,
        CASE WHEN t2.col_midl_name IS NOT NULL AND t2.col_midl_name != '' THEN CONCAT(' ', LEFT(t2.col_midl_name, 1), '.') ELSE '' END
        ) AS employee,t2.col_comp_emai,t2.col_imag_path, t3.name as type,
        CONCAT_WS('',COALESCE(t4.col_empl_cmid, ''), 
        CASE WHEN t4.col_last_name  IS NOT NULL AND t4.col_last_name != '' THEN CONCAT('-', t4.col_last_name ) ELSE '' END,
        CASE WHEN t4.col_suffix IS NOT NULL AND t4.col_suffix != '' THEN CONCAT(' ', t4.col_suffix) ELSE '' END,
        CASE WHEN t4.col_frst_name IS NOT NULL AND t4.col_frst_name != '' THEN CONCAT(', ', t4.col_frst_name) ELSE '' END,
        CASE WHEN t4.col_midl_name IS NOT NULL AND t4.col_midl_name != '' THEN CONCAT(' ', LEFT(t4.col_midl_name, 1), '.') ELSE '' END
        ) AS approver,t4.col_comp_emai as approver_col_comp_emai,t4.col_imag_path as approver_col_imag_path,
        CONCAT_WS('',COALESCE(t5.col_empl_cmid, ''), 
        CASE WHEN t5.col_last_name  IS NOT NULL AND t5.col_last_name != '' THEN CONCAT('-', t5.col_last_name ) ELSE '' END,
        CASE WHEN t5.col_suffix IS NOT NULL AND t5.col_suffix != '' THEN CONCAT(' ', t5.col_suffix) ELSE '' END,
        CASE WHEN t5.col_frst_name IS NOT NULL AND t5.col_frst_name != '' THEN CONCAT(', ', t5.col_frst_name) ELSE '' END,
        CASE WHEN t5.col_midl_name IS NOT NULL AND t5.col_midl_name != '' THEN CONCAT(' ', LEFT(t5.col_midl_name, 1), '.') ELSE '' END
        ) AS requester,t5.col_comp_emai as requester_col_comp_emai,t5.col_imag_path as requester_col_imag_path
        FROM tbl_benefits_reimbursement as t1
        LEFT JOIN tbl_employee_infos as t2 ON t2.id = t1.empl_id
        LEFT JOIN tbl_std_reimbursementtypes as t3 ON t3.id = t1.type
        LEFT JOIN tbl_employee_infos as t4 ON t4.id = t1.approver
        LEFT JOIN tbl_employee_infos as t5 ON t5.id = t1.requested_by
        WHERE t1.id=?";

        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }

    function get_cashadvance_id_approval($id)
    {
        $sql = "SELECT t1.id,t1.description,t1.amount,t1.remarks,t1.attachment,t1.empl_id,t1.create_date,t1.status,t1.approver_date,
        CONCAT_WS('',COALESCE(t2.col_empl_cmid, ''), 
        CASE WHEN t2.col_last_name  IS NOT NULL AND t2.col_last_name != '' THEN CONCAT('-', t2.col_last_name ) ELSE '' END,
        CASE WHEN t2.col_suffix IS NOT NULL AND t2.col_suffix != '' THEN CONCAT(' ', t2.col_suffix) ELSE '' END,
        CASE WHEN t2.col_frst_name IS NOT NULL AND t2.col_frst_name != '' THEN CONCAT(', ', t2.col_frst_name) ELSE '' END,
        CASE WHEN t2.col_midl_name IS NOT NULL AND t2.col_midl_name != '' THEN CONCAT(' ', LEFT(t2.col_midl_name, 1), '.') ELSE '' END
        ) AS employee,t2.col_comp_emai,t2.col_imag_path, t3.name as type,
        CONCAT_WS('',COALESCE(t4.col_empl_cmid, ''), 
        CASE WHEN t4.col_last_name  IS NOT NULL AND t4.col_last_name != '' THEN CONCAT('-', t4.col_last_name ) ELSE '' END,
        CASE WHEN t4.col_suffix IS NOT NULL AND t4.col_suffix != '' THEN CONCAT(' ', t4.col_suffix) ELSE '' END,
        CASE WHEN t4.col_frst_name IS NOT NULL AND t4.col_frst_name != '' THEN CONCAT(', ', t4.col_frst_name) ELSE '' END,
        CASE WHEN t4.col_midl_name IS NOT NULL AND t4.col_midl_name != '' THEN CONCAT(' ', LEFT(t4.col_midl_name, 1), '.') ELSE '' END
        ) AS approver,t4.col_comp_emai as approver_col_comp_emai,t4.col_imag_path as approver_col_imag_path,
        CONCAT_WS('',COALESCE(t5.col_empl_cmid, ''), 
        CASE WHEN t5.col_last_name  IS NOT NULL AND t5.col_last_name != '' THEN CONCAT('-', t5.col_last_name ) ELSE '' END,
        CASE WHEN t5.col_suffix IS NOT NULL AND t5.col_suffix != '' THEN CONCAT(' ', t5.col_suffix) ELSE '' END,
        CASE WHEN t5.col_frst_name IS NOT NULL AND t5.col_frst_name != '' THEN CONCAT(', ', t5.col_frst_name) ELSE '' END,
        CASE WHEN t5.col_midl_name IS NOT NULL AND t5.col_midl_name != '' THEN CONCAT(' ', LEFT(t5.col_midl_name, 1), '.') ELSE '' END
        ) AS requester,t5.col_comp_emai as requester_col_comp_emai,t5.col_imag_path as requester_col_imag_path
        FROM tbl_benefits_cashadvance as t1
        LEFT JOIN tbl_employee_infos as t2 ON t2.id = t1.empl_id
        LEFT JOIN tbl_std_cashadvancetypes as t3 ON t3.id = t1.type
        LEFT JOIN tbl_employee_infos as t4 ON t4.id = t1.approver
        LEFT JOIN tbl_employee_infos as t5 ON t5.id = t1.requested_by
        WHERE t1.id=?";

        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }

    function GET_MY_TEAM($user)
    {
        // $sql = "SELECT 
        // a.id,CONCAT(a.col_last_name,', ',a.col_frst_name,' ',LEFT(a.col_midl_name, 1),'.') AS name,
        // a.col_imag_path AS image,
        // a.col_empl_posi AS position,
        // CONCAT(b.col_last_name,', ',b.col_frst_name,' ',LEFT(b.col_midl_name, 1),'.') AS reporting_to,
        // b.col_imag_path as superior_image,
        // b.col_empl_posi AS superior_position
        // FROM tbl_employee_infos a
        // LEFT JOIN tbl_employee_infos b 
        // ON b.id=a.reporting_to  
        // WHERE a.reporting_to = ? OR a.id = ?";
        $sql = "SELECT 
            a.id,
            CONCAT(
                a.col_last_name,
                IF(LENGTH(a.col_suffix) > 0, CONCAT(' ', a.col_suffix), ''),
                ', ',a.col_frst_name,
                IF(LENGTH(a.col_frst_name) > 0, ' ', ''),
                IF(LENGTH(a.col_midl_name) > 0, LEFT(a.col_midl_name, 1), ''),
                IF(LENGTH(a.col_midl_name) > 0, '.', '')
            ) AS name,
            a.col_imag_path AS image,
            a.col_empl_posi AS position,
            CONCAT(
                b.col_last_name,
                IF(LENGTH(b.col_suffix) > 0, CONCAT(' ', b.col_suffix), ''),
                ', ',
                b.col_frst_name,
                IF(LENGTH(b.col_midl_name) > 0, CONCAT(' ', LEFT(b.col_midl_name, 1), '.'), '')
            ) AS reporting_to,
            b.col_imag_path AS superior_image,
            b.col_empl_posi AS superior_position
        FROM tbl_employee_infos a
        LEFT JOIN tbl_employee_infos b 
        ON b.id = a.reporting_to  
        WHERE a.reporting_to = ? OR a.id = ?";

        $query = $this->db->query($sql, array($user, $user));
        return $query->result_array();
    }
    function SAVE_TOKEN($data)
    {
        $this->db->insert('tbl_session', $data);
        return $this->db->insert_id();
    }
    function GET_LEAVE_APPROVAL_HOURS($id)
    {
        $sql = "SELECT COALESCE(SUM(duration), 0) AS total_hours FROM tbl_leaves_assign WHERE id=? OR parent_id=?";
        $query = $this->db->query($sql, array($id, $id));
        $result = $query->row();
        return $result->total_hours;
    }

    function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'maiya_reset'";
        return $this->db->query($query)->row_array();
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

    function GET_LOANS($loan_id)
    {
        $sql = "SELECT COUNT(*) AS row_count FROM tbl_payroll_payslip_loan WHERE loan_id = ?";
        $query = $this->db->query($sql, array($loan_id));
        $result = $query->result_array();
        return $result[0]["row_count"];
    }
    function GET_SYSTEM_SETUP($setting)
    {
        $this->db->Select('value');
        $this->db->where('setting', $setting);
        $query = $this->db->get('tbl_system_setup');
        $data = $query->row();
        return $data->value;
    }
    function GET_LEAVE_SETTING($setting)
    {
        $this->db->Select('value');
        $this->db->where('setting', $setting);
        $query = $this->db->get('tbl_leaves_settings');
        $data = $query->row();
        return $data->value;
    }
    // function GET_LEAVE_LIST($userId, $status, $limit, $offset)
    // {
    //     $this->db->select('tb1.id,tb3.name as type,leave_date,leave_range,duration,tb1.status,remarks,reason')
    //         ->from('tbl_leaves_assign as tb1')
    //         ->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left')
    //         ->join('tbl_std_leavetypes as tb3', 'tb1.type=tb3.id', 'left')
    //         ->where('tb1.empl_id', $userId)
    //         ->where('(tb1.parent_id = 0 OR tb1.parent_id IS NULL)');
    //     if (!empty($status)) {
    //         $this->db->like('tb1.status', $status);
    //     }
    //     $this->db->limit($limit, $offset);
    //     $this->db->order_by('id', 'desc');
    //     $query = $this->db->get();
    //     return $query->result();
    // }

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


    function GET_OFFSETS_LIST($userId, $status, $limit, $offset)
    {
        $this->db->select('tb1.id,offset_date,  offset_type, time_range,duration,tb1.status,remarks,reason')
            ->from('tbl_attendance_offsets as tb1')
            ->where('tb1.empl_id', $userId);
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function GET_OFFSETS_ACQUIRE_LIST($userId, $status, $limit, $offset)
    {
        $this->db->select('tb1.id,offset_date, offset_type, time_range,duration,tb1.status,remarks,reason')
            ->from('tbl_attendance_offsets_acquire as tb1')
            ->where('tb1.empl_id', $userId);
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    // function GET_LEAVE_LIST_COUNT($userId, $status)
    // {
    //     $this->db->select('tb1.id,tb3.name as type,leave_date,duration,tb1.status,remarks')
    //         ->from('tbl_leaves_assign as tb1')
    //         ->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left')
    //         ->join('tbl_std_leavetypes as tb3', 'tb1.type=tb3.id', 'left')
    //         ->where('tb1.empl_id', $userId)
    //         ->where('(tb1.parent_id = 0 OR tb1.parent_id IS NULL)');
    //     if (!empty($status)) {
    //         $this->db->like('tb1.status', $status);
    //     }
    //     $query = $this->db->get();
    //     return $query->num_rows();
    // }

    function GET_OFFSETS_LIST_COUNT($userId, $status)
    {
        $this->db->select('tb1.id')
            ->from('tbl_attendance_offsets as tb1')
            // ->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left')
            ->where('tb1.empl_id', $userId);
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function GET_OFFSETS_ACQUIRE_LIST_COUNT($userId, $status)
    {
        $this->db->select('tb1.id')
            ->from('tbl_attendance_offsets_acquire as tb1')
            // ->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left')
            ->where('tb1.empl_id', $userId);
        if (!empty($status)) {
            $this->db->like('tb1.status', $status);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function MOD_DISP_HOLIDAY_BASED_DATE($date)
    {
        $query = $this->db
            ->select('col_holi_type')
            ->where('col_holi_date', $date)
            ->get('tbl_std_holidays');

        return $query->result();
    }

    function GET_OFFSET_STATUS($id,)
    {
        $this->db->select('tb1.id,tb1.offset_date, tb1.offset_type, tb1.empl_id,tb1.duration,tb1.status,tb1.create_date,tb1.remarks,tb1.reason,
        tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,tb1.type,
        tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat,
         tb3.approver_1a,tb3.approver_2a,tb3.approver_3a
        ');
        // $this->db->select(' CONCAT(tb2.col_last_name, ", ", tb2.col_frst_name, " ", LEFT(tb2.col_midl_name,1),".") as employee', false);
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

        // $this->db->select('CONCAT(tb8.col_last_name, ", ", tb8.col_frst_name, " ", LEFT(tb8.col_midl_name,1),".") as pending_approver1', false);
        $this->db->select('CONCAT(tb8.col_last_name,IF(tb8.col_suffix IS NOT NULL AND tb8.col_suffix <> "", CONCAT(" ",tb8.col_suffix, ""), ""), ", ",
        tb8.col_frst_name, " ",IF(tb8.col_midl_name IS NOT NULL AND tb8.col_midl_name <> "", CONCAT(LEFT(tb8.col_midl_name, 1), "."), "")) as pending_approver1', false);

        // $this->db->select('CONCAT(tb9.col_last_name, ", ", tb9.col_frst_name, " ", LEFT(tb9.col_midl_name,1),".") as pending_approver2', false);
        $this->db->select('CONCAT(tb9.col_last_name,IF(tb9.col_suffix IS NOT NULL AND tb9.col_suffix <> "", CONCAT(" ",tb9.col_suffix, ""), ""), ", ",
        tb9.col_frst_name, " ",IF(tb9.col_midl_name IS NOT NULL AND tb9.col_midl_name <> "", CONCAT(LEFT(tb9.col_midl_name, 1), "."), "")) as pending_approver2', false);

        // $this->db->select('CONCAT(tb10.col_last_name, ", ", tb10.col_frst_name, " ", LEFT(tb10.col_midl_name,1),".") as pending_approver3,', false);
        $this->db->select('CONCAT(tb10.col_last_name,IF(tb10.col_suffix IS NOT NULL AND tb10.col_suffix <> "", CONCAT(" ",tb10.col_suffix, ""), ""), ", ",
        tb10.col_frst_name, " ",IF(tb10.col_midl_name IS NOT NULL AND tb10.col_midl_name <> "", CONCAT(LEFT(tb10.col_midl_name, 1), "."), "")) as pending_approver3', false);

        $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,tb6.col_imag_path as approver_3_img');
        $this->db->select('tb8.col_imag_path as pending_approver1_img,tb9.col_imag_path as pending_approver2_img,tb10.col_imag_path as pending_approver3_img');

        $this->db->select('tb2.col_empl_emai as employee_email,tb8.col_empl_emai as approver1a_email,tb9.col_empl_emai as approver2a_email,tb10.col_empl_emai as approver3a_email');
        $this->db->select('tb4.col_empl_emai as approver1_email,tb5.col_empl_emai as approver2_email,tb6.col_empl_emai as approver3_email');

        $this->db->from('tbl_attendance_offsets as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_approvers_offset as tb3', 'tb1.empl_id      = tb3.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver1   = tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.approver2   = tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver3   = tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
        $this->db->join('tbl_employee_infos as tb8', 'tb3.approver_1a   = tb8.id', 'left');
        $this->db->join('tbl_employee_infos as tb9', 'tb3.approver_2a  = tb9.id', 'left');
        $this->db->join('tbl_employee_infos as tb10', 'tb3.approver_3a  = tb10.id', 'left');
        $this->db->where('tb1.id', $id);
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row();
    }

    function GET_ACQUIRE_OFFSET_STATUS($id,)
    {
        $this->db->select('tb1.id,tb1.offset_date, tb1.offset_type,tb1.empl_id,tb1.duration,tb1.status,tb1.create_date,tb1.remarks,tb1.reason,
        tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,tb1.type,
        tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat,
         tb3.approver_1a,tb3.approver_2a,tb3.approver_3a
        ');
        // $this->db->select(' CONCAT(tb2.col_last_name, ", ", tb2.col_frst_name, " ", LEFT(tb2.col_midl_name,1),".") as employee', false);
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

        // $this->db->select('CONCAT(tb8.col_last_name, ", ", tb8.col_frst_name, " ", LEFT(tb8.col_midl_name,1),".") as pending_approver1', false);
        $this->db->select('CONCAT(tb8.col_last_name,IF(tb8.col_suffix IS NOT NULL AND tb8.col_suffix <> "", CONCAT(" ",tb8.col_suffix, ""), ""), ", ",
        tb8.col_frst_name, " ",IF(tb8.col_midl_name IS NOT NULL AND tb8.col_midl_name <> "", CONCAT(LEFT(tb8.col_midl_name, 1), "."), "")) as pending_approver1', false);

        // $this->db->select('CONCAT(tb9.col_last_name, ", ", tb9.col_frst_name, " ", LEFT(tb9.col_midl_name,1),".") as pending_approver2', false);
        $this->db->select('CONCAT(tb9.col_last_name,IF(tb9.col_suffix IS NOT NULL AND tb9.col_suffix <> "", CONCAT(" ",tb9.col_suffix, ""), ""), ", ",
        tb9.col_frst_name, " ",IF(tb9.col_midl_name IS NOT NULL AND tb9.col_midl_name <> "", CONCAT(LEFT(tb9.col_midl_name, 1), "."), "")) as pending_approver2', false);

        // $this->db->select('CONCAT(tb10.col_last_name, ", ", tb10.col_frst_name, " ", LEFT(tb10.col_midl_name,1),".") as pending_approver3,', false);
        $this->db->select('CONCAT(tb10.col_last_name,IF(tb10.col_suffix IS NOT NULL AND tb10.col_suffix <> "", CONCAT(" ",tb10.col_suffix, ""), ""), ", ",
        tb10.col_frst_name, " ",IF(tb10.col_midl_name IS NOT NULL AND tb10.col_midl_name <> "", CONCAT(LEFT(tb10.col_midl_name, 1), "."), "")) as pending_approver3', false);

        $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,tb6.col_imag_path as approver_3_img');
        $this->db->select('tb8.col_imag_path as pending_approver1_img,tb9.col_imag_path as pending_approver2_img,tb10.col_imag_path as pending_approver3_img');

        $this->db->select('tb2.col_empl_emai as employee_email,tb8.col_empl_emai as approver1a_email,tb9.col_empl_emai as approver2a_email,tb10.col_empl_emai as approver3a_email');
        $this->db->select('tb4.col_empl_emai as approver1_email,tb5.col_empl_emai as approver2_email,tb6.col_empl_emai as approver3_email');

        $this->db->from('tbl_attendance_offsets_acquire as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_approvers_offset_acquire as tb3', 'tb1.empl_id      = tb3.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver1   = tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.approver2   = tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver3   = tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
        $this->db->join('tbl_employee_infos as tb8', 'tb3.approver_1a   = tb8.id', 'left');
        $this->db->join('tbl_employee_infos as tb9', 'tb3.approver_2a  = tb9.id', 'left');
        $this->db->join('tbl_employee_infos as tb10', 'tb3.approver_3a  = tb10.id', 'left');
        $this->db->where('tb1.id', $id);
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row();
    }

    function GET_SETUP_SETTING($setting)
    {
        $this->db->where('setting', $setting);
        $query = $this->db->get('tbl_system_setup');
        $val = $query->row();
        return $val->value;
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

    function get_leave_entitlement_by_id_typeName_year($empl_id, $typeName, $year)
    {
        $query = "SELECT tb1.value, tb1.empl_id,tb1.type, tb2.name as year FROM tbl_leave_entitlements as tb1
        left join tbl_std_years as tb2 on
        tb1.year = tb2.id
        where empl_id=? AND type =? AND tb2.name =?";
        return $this->db->query($query, array($empl_id, $typeName, $year))->row_array();
    }

    function get_leave_type_name_by_id($id)
    {
        $query = $this->db->get_where('tbl_std_leavetypes', array('id' => $id));
        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->name;
        } else {
            return false;
        }
    }

    function get_offset_approve_count($empl_id)
    {
        $query = "SELECT SUM(duration) AS value FROM tbl_attendance_offsets
        where empl_id = ? AND status = 'Approved'";
        return $this->db->query($query, array($empl_id))->row_array();
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

    function GET_OFFSETS_IS_DUPLICATE_DATE_EMPL_ID($date, $empl_id)
    {
        $sql = "SELECT * FROM tbl_attendance_offsets WHERE offset_date=? AND empl_id=?";
        $query = $this->db->query($sql, array($date, $empl_id));
        return $query->num_rows();
    }

    function GET_OFFSETS_IS_DUPLICATE_DATE_EMPL_ID_ACQUIRE($date, $empl_id)
    {
        $sql = "SELECT * FROM tbl_attendance_offsets_acquire WHERE offset_date=? AND empl_id=?";
        $query = $this->db->query($sql, array($date, $empl_id));
        return $query->num_rows();
    }

    function ADD_OFFSET_REQUEST($data)
    {
        $this->db->insert('tbl_attendance_offsets', $data);
        return $this->db->insert_id();
    }

    function ADD_OFFSET_REQUEST_ACQUIRE($data)
    {
        $this->db->insert('tbl_attendance_offsets_acquire', $data);
        return $this->db->insert_id();
    }

    function GET_DATA_COUNT($id)
    {
        $sql = "SELECT * FROM tbl_leaves_assign WHERE empl_id = $id";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function GET_IN_OUT_TYPE()
    {

        $sql = "SELECT value FROM tbl_system_setup WHERE setting = 'in_out_count'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["value"];
    }

    function GET_EMPOLOYEES()
    {
        $this->db->select('id, col_empl_cmid,col_last_name,col_frst_name,col_midl_name,col_empl_dept')
            ->where('disabled', 0)
            ->where('termination_date', NULL);
        $query = $this->db->get('tbl_employee_infos');
        return $query->result_object();
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
    function GET_USER_DEPARMENT($user_id)
    {
        $sql = "SELECT col_empl_dept FROM tbl_employee_infos WHERE id = $user_id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["col_empl_dept"];
    }
    function GET_EMPLOYEE_IDS()
    {
        $sql = "SELECT id,col_empl_cmid FROM tbl_employee_infos";
        $query = $this->db->query($sql, array());
        return $query->result_array();
    }

    function GET_NOTIFICATIONS($id)
    {
        $sql = "SELECT * FROM tbl_notifications WHERE empl_id=?  order by id desc";
        $query = $this->db->query($sql, array($id));
        return $query->result_array();
    }

    function UPDATE_NOTIFICATION($id)
    {
        $this->db->set('is_read', '1');
        $this->db->where('id', $id);
        return $this->db->update('tbl_notifications');
    }
    function UPDATE_NOTIFICATION_READ_ALL($id)
    {
        $this->db->set('is_read', '1');
        $this->db->where('empl_id', $id);
        return $this->db->update('tbl_notifications');
    }
    function GET_ACTIVITY_LOGS($user_id)
    {
        $sql = "SELECT * FROM tbl_activity_logs WHERE empl_id=? ORDER BY create_date DESC";
        $query = $this->db->query($sql, array($user_id));
        return $query->result_array();
    }

    function GET_USER_PASSWORD_KEYS($user_id)
    {
        $sql = "SELECT col_user_pass,col_salt_key FROM tbl_employee_infos WHERE id=? Limit 1";
        $query = $this->db->query($sql, array($user_id))->row();
        return $query;
    }

    function check_password($password, $id, $salt)
    {
        $decrypted_password = md5($password . '' . $salt);
        $sql = "SELECT id FROM tbl_employee_infos WHERE id=? AND col_user_pass=? Limit 1";
        return $this->db->query($sql, array($id, $decrypted_password))->num_rows();
    }

    function MOD_CHANGE_PASSWORD($new_password, $user_id)
    {
        // $salt = bin2hex(openssl_random_pseudo_bytes(22));
        // $encrypted_password = md5($new_password . '' . $salt);
        $salt                           = password_hash(uniqid(), PASSWORD_BCRYPT);
        $encrypted_password             = password_hash($new_password . $salt, PASSWORD_BCRYPT);
        $sql = "UPDATE tbl_employee_infos SET col_user_pass=?, real_pass=1,col_salt_key=? WHERE id=?";
        $query = $this->db->query($sql, array($encrypted_password, $salt, $user_id));
    }

    function FETCH_HOLIDAYS()
    {
        $sql = "SELECT name as title,DATE_FORMAT(col_holi_date,'%Y-%m-%d') AS start FROM tbl_std_holidays";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    function FETCH_MY_SCHEDULE($empl_id)
    {
        $sql = "SELECT code as title, date as start FROM tbl_attendance_shiftassign INNER JOIN tbl_attendance_shifts ON tbl_attendance_shiftassign.shift_id = tbl_attendance_shifts.id WHERE empl_id =? ";
        $query = $this->db->query($sql, array($empl_id))->result_array();
        return $query;
    }

    function FETCH_EVENTS()
    {
        $sql = "SELECT event_title as title,DATE_FORMAT(event_date_from,'%Y-%m-%dT08:00:00') AS start,DATE_FORMAT(event_date_to,'%Y-%m-%dT08:00:00') AS end FROM tbl_event";
        $query = $this->db->query($sql)->result_array();
        return $query;
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

        $sql = "SELECT tb1.id,reporting_to,col_empl_cmid,
        col_last_name,col_imag_path,col_midl_name,col_frst_name,tb2.name as position
        FROM tbl_employee_infos as tb1 
        LEFT JOIN tbl_std_positions as tb2 on tb1.col_empl_posi=tb2.id
        WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0       
        AND col_empl_branch = $branch
        AND col_empl_dept = $dept
        AND col_empl_divi = $division
        AND col_empl_sect = $section
        AND col_empl_group = $group
        AND col_empl_team = $team
        AND col_empl_line = $line
        ORDER BY col_empl_cmid ASC
        LIMIT " . $offset . ", " . $row . " ";

        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function UPDATE_MY_TEAM($ids, $reporting_to)
    {
        $data = array(
            'reporting_to' => $reporting_to
        );
        $this->db->where_in('id', $ids);
        return $this->db->update('tbl_employee_infos', $data);
    }
    function GET_TASK($id)
    {
        $this->db->select("tb1.id,tb1.create_date,tb1.edit_date,task_title,task_description,task_date_from,task_date_to,tb1.status,attachment,remarks,tb1.edit_user");
        $this->db->select("CONCAT_WS(' ',tb2.col_empl_cmid,'-',tb2.col_last_name,tb2.col_suffix,tb2.col_frst_name,RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as employee", false);
        $this->db->select("CONCAT_WS(' ',tb3.col_empl_cmid,'-',tb3.col_last_name,tb3.col_suffix,tb3.col_frst_name,RPAD(LEFT(tb3.col_midl_name,1),2,'.')) as editor", false);
        $this->db->from('tbl_employee_tasks as tb1');
        $this->db->join('tbl_employee_infos as tb2', "tb1.employee_id=tb2.id", 'left');
        $this->db->join('tbl_employee_infos as tb3', "tb1.edit_user=tb3.id", 'left');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    function UPDATE_TASK($data, $id)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_employee_tasks', $data);
    }
    function GET_SUPPORT($id)
    {
        $this->db->select("tb1.id,tb1.create_date,tb1.edit_date,title,description,feedback,tb1.status,attachment,tb1.edit_user");
        $this->db->select("CONCAT_WS(' ',tb2.col_empl_cmid,'-',tb2.col_last_name,tb2.col_suffix,tb2.col_frst_name,RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as employee", false);
        $this->db->select("CONCAT_WS(' ',tb3.col_empl_cmid,'-',tb3.col_last_name,tb3.col_suffix,tb3.col_frst_name,RPAD(LEFT(tb3.col_midl_name,1),2,'.')) as editor", false);
        $this->db->from('tbl_hr_supports as tb1');
        $this->db->join('tbl_employee_infos as tb2', "tb1.employee_id=tb2.id", 'left');
        $this->db->join('tbl_employee_infos as tb3', "tb1.edit_user=tb3.id", 'left');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    function UPDATE_SUPPORT($data, $id)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_hr_supports', $data);
    }
    function GET_COMPLAINT($id)
    {
        $this->db->select("tb1.id,tb1.create_date,tb1.edit_date,title,description,feedback,tb1.status,attachment,tb1.edit_user");
        $this->db->select("CONCAT_WS(' ',tb2.col_empl_cmid,'-',tb2.col_last_name,tb2.col_suffix,tb2.col_frst_name,RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as employee", false);
        $this->db->select("CONCAT_WS(' ',tb3.col_empl_cmid,'-',tb3.col_last_name,tb3.col_suffix,tb3.col_frst_name,RPAD(LEFT(tb3.col_midl_name,1),2,'.')) as editor", false);
        $this->db->from('tbl_hr_complaints as tb1');
        $this->db->join('tbl_employee_infos as tb2', "tb1.employee_id=tb2.id", 'left');
        $this->db->join('tbl_employee_infos as tb3', "tb1.edit_user=tb3.id", 'left');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    function UPDATE_COMPLAINT($data, $id)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_hr_complaints', $data);
    }
    function GET_WARNING($id)
    {
        $this->db->select("tb1.id,tb1.create_date,tb1.edit_date,title,description,feedback,tb1.status,attachment,tb1.edit_user");
        $this->db->select("CONCAT_WS(' ',tb2.col_empl_cmid,'-',tb2.col_last_name,tb2.col_suffix,tb2.col_frst_name,RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as employee", false);
        $this->db->select("CONCAT_WS(' ',tb3.col_empl_cmid,'-',tb3.col_last_name,tb3.col_suffix,tb3.col_frst_name,RPAD(LEFT(tb3.col_midl_name,1),2,'.')) as editor", false);
        $this->db->from('tbl_hr_warnings as tb1');
        $this->db->join('tbl_employee_infos as tb2', "tb1.employee_id=tb2.id", 'left');
        $this->db->join('tbl_employee_infos as tb3', "tb1.edit_user=tb3.id", 'left');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    function UPDATE_WARNING($data, $id)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_hr_warnings', $data);
    }
    function FETCH_TASKS($id)
    {
        if ($id) {
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
        } else {
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

    function GET_COMPANIES()
    {
        $sql = "SELECT id,name FROM tbl_std_companies";
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


    function GET_OVERTIME_STEP($department)
    {
        $sql = "SELECT value FROM tbl_overtime_step WHERE department = $department";

        $query = $this->db->query($sql, array());
        $result = $query->row();

        if ($result) {
            return $result->value;
        } else {
            return "0.5";
        }
    }

    function GET_DEPARTMENT_MIN_HOUR($id)
    {
        $sql = "SELECT tbl_std_departments.min_hours FROM tbl_employee_infos 
        LEFT JOIN tbl_std_departments ON tbl_employee_infos.col_empl_dept = tbl_std_departments.id WHERE tbl_employee_infos.id = ? ";
        $query = $this->db->query($sql, array($id));
        return $query->row();
    }

    function get_loan_payments_api($loanId)
    {
        $this->db->select('tb1.payslip_id,tb1.deducted, tb3.name as period');
        $this->db->from('tbl_payroll_payslip_loan as tb1');
        $this->db->join('tbl_payroll_payslips as tb2', 'tb1.payslip_id=tb2.id', 'left');
        $this->db->join('tbl_payroll_period as tb3', 'tb2.PAYSLIP_PERIOD=tb3.id', 'left');
        $this->db->where('tb1.loan_id', $loanId);
        $this->db->order_by('tb1.id', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    function GET_EMPL_LOANS($userId, $limit, $offset, $search, $loan_date)
    {
        $this->db->select('tb1.*,,tb3.name as loan_type');
        $this->db->select("CONCAT_WS(' ',tb2.col_last_name,tb2.col_suffix,tb2.col_frst_name,RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as employee", false);
        $this->db->from('tbl_benefits_loan as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left');
        $this->db->join('tbl_std_loantypes as tb3', 'tb1.loan_type=tb3.id');
        $this->db->where('tb1.empl_id', $userId);
        if($loan_date) {
            $this->db->where('DATE(tb1.loan_date)', date('Y-m-d', strtotime($loan_date)));
        }
        if ($search) {
            $this->db->having("employee LIKE '%$search%' OR tb3.name LIKE '%$search%' ");
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    // function GET_EMPL_LOANS_COUNT($userId)
    // {
    //     $this->db->where('empl_id', $userId);
    //     $query = $this->db->get('tbl_benefits_loan');
    //     return $query->num_rows();
    // }

    function GET_EMPL_LOANS_COUNT($userId, $limit, $offset, $search, $loan_date)
    {
        $this->db->select('tb1.*,,tb3.name as loan_type');
        $this->db->select("CONCAT_WS(' ',tb2.col_last_name,tb2.col_suffix,tb2.col_frst_name,RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as employee", false);
        $this->db->from('tbl_benefits_loan as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left');
        $this->db->join('tbl_std_loantypes as tb3', 'tb1.loan_type=tb3.id');
        $this->db->where('tb1.empl_id', $userId);
        if($loan_date) {
            $this->db->where('DATE(tb1.loan_date)', date('Y-m-d', strtotime($loan_date)));
        }
        if ($search) {
            $this->db->having("employee LIKE '%$search%' OR tb3.name LIKE '%$search%' ");
        }

        $query = $this->db->get();
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
    function GET_ROW_DATA($table, $id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    function GET_APPROVER_DATA_2($approver_id)
    {

        if ($approver_id === Null || $approver_id === '0') {
            return (object) ['fullname2' => Null, 'email2' => Null];
        }
        $this->db->select('CONCAT(col_last_name,IF(col_suffix IS NOT NULL AND col_suffix <> "", CONCAT(" ",col_suffix, ""), ""), ", ",
        col_frst_name, " ",IF(col_midl_name IS NOT NULL AND col_midl_name <> "", CONCAT(LEFT(col_midl_name, 1), "."), "")) as fullname2', false);
        $this->db->select('col_empl_emai as email2');
        $this->db->from('tbl_employee_infos');
        $this->db->where('id', $approver_id);
        $query = $this->db->get();
        $result = $query->row();

        return $result;
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

    function GET_APPROVER_DATA($approver_id, $date, $current_status, $next_status, $next_date = '')
    {
        $this->db->select('CONCAT(col_last_name,IF(col_suffix IS NOT NULL AND col_suffix <> "", CONCAT(" ",col_suffix, ""), ""), ", ",
        col_frst_name, " ",IF(col_midl_name IS NOT NULL AND col_midl_name <> "", CONCAT(LEFT(col_midl_name, 1), "."), "")) as fullname', false);
        $this->db->select('col_empl_emai as email,col_imag_path as image');
        $this->db->from('tbl_employee_infos');
        $this->db->where('id', $approver_id);
        $query = $this->db->get();
        $result = $query->row();

        if ($current_status != 'Approved' && $current_status != 'Rejected' && $current_status != 'Withdrawed') {

            if ($date && $date != '0000-00-00 00:00:00') {
                if (($current_status != $next_status)) {
                    $result->status = '<span class="text-success h6">Approved by</span>';
                    $result->date_row = $date;
                }
            }
            if (!$date || $date == '0000-00-00 00:00:00') {
                if ($current_status == $next_status) {
                    $result->status = '<span class="h6">Pending response from</span>';
                    $result->date_row = '';
                }
                if ($current_status != $next_status) {
                    $result->status = '<span class="h6 font-bold">Needs response from</span>';
                    $result->date_row = '';
                }
            }
        }

        if ($current_status == 'Approved') {
            if (!$date || $date == '0000-00-00 00:00:00') {
                // $result = array();
                $result->status = '<span class="text-success h6">Approved</span>';
                $result->date_row = '0000-00-00 00:00:00';
            }
            if ($date && $date != '0000-00-00 00:00:00') {
                $result->status = '<span class="text-success h6">Approved by</span>';
                $result->date_row = $date;
            }
        }
        if ($current_status == 'Rejected') {
            if (!$date || $date == '0000-00-00 00:00:00') {
                $result->status = '<span class="h6">No response needed</span>';
                $result->date_row = '';
            } else if ($date && $date != '0000-00-00 00:00:00' && $next_date == '0000-00-00 00:00:00') {
                $result->status = '<span class="text-danger h6">Rejected by</span>';
                $result->date_row = $date;
            } else {
                $result->status = '<span class="text-success h6">Approved by</span>';
                $result->date_row = $date;
            }
        }
        if ($current_status == 'Withdrawed') {
            if (!$date || $date == '0000-00-00 00:00:00') {
                $result->status = '<span class="h6">No response needed</span>';
                $result->date_row = '';
            } else {
                $result->status = '<span class="text-success h6">Approved by</span>';
                $result->date_row = $date;
            }
        }
        if ($current_status == 'Cancelled') {
            if (!$date || $date == '0000-00-00 00:00:00') {
                $result->status = '<span class="h6">No response needed</span>';
                $result->date_row = '';
            } else if ($date && $date != '0000-00-00 00:00:00' && $next_date == '0000-00-00 00:00:00') {
                $result->status = '<span class="h6">No response needed</span>';
                $result->date_row = $date;
            } else {
                $result->status = '<span class="text-success h6">Approved by</span>';
                $result->date_row = $date;
            }
        }

        return $result;
    }


    function GET_APPROVED_BY($approver_id)
    {
        if ($approver_id === Null || $approver_id === '0') {
            return (object) ['approvedby' => Null];
        }
        $this->db->select('CONCAT(col_last_name,IF(col_suffix IS NOT NULL AND col_suffix <> "", CONCAT(" ",col_suffix, ""), ""), ", ",
        col_frst_name, " ",IF(col_midl_name IS NOT NULL AND col_midl_name <> "", CONCAT(LEFT(col_midl_name, 1), "."), "")) as approvedby', false);
        $this->db->select('col_empl_emai as email,col_imag_path as image');
        $this->db->from('tbl_employee_infos');
        $this->db->where('id', $approver_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    function GET_LEAVE_APPROVAL_TABLE_DATA($id)
    {
        $sql = "SELECT leave_date,date_from,date_to,type,leave_range,duration,current_shift FROM tbl_leaves_assign where id=? OR parent_id=?";
        $query = $this->db->query($sql, array($id, $id));
        $query->next_result();
        return $query->result();
    }

    function GET_LEAVE_APPROVAL_STATUS($id)
    {
        $this->db->select('tb1.id,tb1.empl_id,tb1.leave_date,tb1.duration,tb1.status,tb1.create_date,tb1.remarks,tb1.reason,tb1.attachment,
        tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,tb8.name as type,
        tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat,tb1.approver4 as approver_4_stat,tb1.approver5 as approver_5_stat,
        tb3.approver_1a, tb3.approver_1b, tb3.approver_2a, tb3.approver_2b,tb3.approver_3a,tb3.approver_4a,tb3.approver_5a
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

        // --approver 4 and 5
        $this->db->select('CONCAT(tb12.col_last_name,IF(tb12.col_suffix IS NOT NULL AND tb12.col_suffix <> "", CONCAT(" ",tb12.col_suffix, ""), ""), ", ",
        tb12.col_frst_name, " ",IF(tb12.col_midl_name IS NOT NULL AND tb12.col_midl_name <> "", CONCAT(LEFT(tb12.col_midl_name, 1), "."), "")) as approver4', false);
        $this->db->select('CONCAT(tb14.col_last_name,IF(tb14.col_suffix IS NOT NULL AND tb14.col_suffix <> "", CONCAT(" ",tb14.col_suffix, ""), ""), ", ",
        tb14.col_frst_name, " ",IF(tb14.col_midl_name IS NOT NULL AND tb14.col_midl_name <> "", CONCAT(LEFT(tb14.col_midl_name, 1), "."), "")) as approver5', false);
        // ---
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
        // peding approver 4 and 5
        $this->db->select('CONCAT(tb13.col_last_name,IF(tb13.col_suffix IS NOT NULL AND tb13.col_suffix <> "", CONCAT(" ",tb13.col_suffix, ""), ""), ", ",
        tb13.col_frst_name, " ",IF(tb13.col_midl_name IS NOT NULL AND tb13.col_midl_name <> "", CONCAT(LEFT(tb13.col_midl_name, 1), "."), "")) as pending_approver4', false);

        $this->db->select('CONCAT(tb15.col_last_name,IF(tb15.col_suffix IS NOT NULL AND tb15.col_suffix <> "", CONCAT(" ",tb15.col_suffix, ""), ""), ", ",
        tb15.col_frst_name, " ",IF(tb15.col_midl_name IS NOT NULL AND tb15.col_midl_name <> "", CONCAT(LEFT(tb15.col_midl_name, 1), "."), "")) as pending_approver5', false);
        // ---
        $this->db->select('tb2.col_empl_emai as employee_email,tb9.col_empl_emai as approver1a_email,tb10.col_empl_emai as approver2a_email,
        tb11.col_empl_emai as approver3a_email,tb13.col_empl_emai as approver4a_email,tb15.col_empl_emai as approver5a_email');
        $this->db->select('tb4.col_empl_emai as approver1_email,tb5.col_empl_emai as approver2_email,
        tb6.col_empl_emai as approver3_email,tb12.col_empl_emai as approver4_email,tb14.col_empl_emai as approver5_email');

        $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,
        tb6.col_imag_path as approver_3_img,tb12.col_imag_path as approver_4_img,tb14.col_imag_path as approver_5_img');

        $this->db->select('tb9.col_imag_path as pending_approver1_img,tb10.col_imag_path as pending_approver2_img,
        tb11.col_imag_path as pending_approver3_img,tb13.col_imag_path as pending_approver4_img,tb15.col_imag_path as pending_approver5_img');

        $this->db->from('tbl_leaves_assign as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_approvers_leave as tb3', 'tb1.empl_id            = tb3.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver1     = tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.approver2     = tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver3     = tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
        $this->db->join('tbl_std_leavetypes as tb8', 'tb1.type          = tb8.id', 'left');
        $this->db->join('tbl_employee_infos as tb9', 'tb3.approver_1a   = tb9.id', 'left');
        $this->db->join('tbl_employee_infos as tb9b', 'tb3.approver_1b  = tb9b.id', 'left');
        $this->db->join('tbl_employee_infos as tb10', 'tb3.approver_2a  = tb10.id', 'left');
        $this->db->join('tbl_employee_infos as tb10b', 'tb3.approver_2b = tb10b.id', 'left');
        $this->db->join('tbl_employee_infos as tb11', 'tb3.approver_3a  = tb11.id', 'left');
        $this->db->join('tbl_employee_infos as tb12', 'tb1.approver4    = tb12.id', 'left');
        $this->db->join('tbl_employee_infos as tb13', 'tb3.approver_4a  = tb13.id', 'left');
        $this->db->join('tbl_employee_infos as tb14', 'tb1.approver5    = tb14.id', 'left');
        $this->db->join('tbl_employee_infos as tb15', 'tb3.approver_5a  = tb15.id', 'left');
        $this->db->where('tb1.id', $id);
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row();
    }

    function GET_SHIFT_APPROVAL($id)
    {
        $this->db->select('tb1.id,tb1.empl_id,tb1.date,tb8.name,tb1.status,tb1.create_date,tb1.remarks,tb1.reason,tb1.attachment,
        tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,
        tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat,tb1.approver4 as approver_4_stat,tb1.approver5 as approver_5_stat,
        tb3.approver_1a,tb3.approver_2a,tb3.approver_3a,tb3.approver_4a,tb3.approver_5a
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

        // --approver 4 and 5
        $this->db->select('CONCAT(tb12.col_last_name,IF(tb12.col_suffix IS NOT NULL AND tb12.col_suffix <> "", CONCAT(" ",tb12.col_suffix, ""), ""), ", ",
        tb12.col_frst_name, " ",IF(tb12.col_midl_name IS NOT NULL AND tb12.col_midl_name <> "", CONCAT(LEFT(tb12.col_midl_name, 1), "."), "")) as approver4', false);
        $this->db->select('CONCAT(tb14.col_last_name,IF(tb14.col_suffix IS NOT NULL AND tb14.col_suffix <> "", CONCAT(" ",tb14.col_suffix, ""), ""), ", ",
        tb14.col_frst_name, " ",IF(tb14.col_midl_name IS NOT NULL AND tb14.col_midl_name <> "", CONCAT(LEFT(tb14.col_midl_name, 1), "."), "")) as approver5', false);
        // ---
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
        // peding approver 4 and 5
        $this->db->select('CONCAT(tb13.col_last_name,IF(tb13.col_suffix IS NOT NULL AND tb13.col_suffix <> "", CONCAT(" ",tb13.col_suffix, ""), ""), ", ",
        tb13.col_frst_name, " ",IF(tb13.col_midl_name IS NOT NULL AND tb13.col_midl_name <> "", CONCAT(LEFT(tb13.col_midl_name, 1), "."), "")) as pending_approver4', false);

        $this->db->select('CONCAT(tb15.col_last_name,IF(tb15.col_suffix IS NOT NULL AND tb15.col_suffix <> "", CONCAT(" ",tb15.col_suffix, ""), ""), ", ",
        tb15.col_frst_name, " ",IF(tb15.col_midl_name IS NOT NULL AND tb15.col_midl_name <> "", CONCAT(LEFT(tb15.col_midl_name, 1), "."), "")) as pending_approver5', false);
        // ---
        $this->db->select('tb2.col_empl_emai as employee_email,tb9.col_empl_emai as approver1a_email,tb10.col_empl_emai as approver2a_email,
        tb11.col_empl_emai as approver3a_email,tb13.col_empl_emai as approver4a_email,tb15.col_empl_emai as approver5a_email');
        $this->db->select('tb4.col_empl_emai as approver1_email,tb5.col_empl_emai as approver2_email,
        tb6.col_empl_emai as approver3_email,tb12.col_empl_emai as approver4_email,tb14.col_empl_emai as approver5_email');

        $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,
        tb6.col_imag_path as approver_3_img,tb12.col_imag_path as approver_4_img,tb14.col_imag_path as approver_5_img');
        $this->db->select('tb9.col_imag_path as pending_approver1_img,tb10.col_imag_path as pending_approver2_img,
        tb11.col_imag_path as pending_approver3_img,tb13.col_imag_path as pending_approver4_img,tb15.col_imag_path as pending_approver5_img');
        $this->db->from('tbl_attendance_shiftassign as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_approvers_shift as tb3', 'tb1.empl_id            = tb3.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver1     = tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.approver2     = tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver3     = tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
        $this->db->join('tbl_attendance_shifts as tb8', 'tb1.shift_id   = tb8.id', 'left');
        $this->db->join('tbl_employee_infos as tb9', 'tb3.approver_1a   = tb9.id', 'left');
        $this->db->join('tbl_employee_infos as tb10', 'tb3.approver_2a  = tb10.id', 'left');
        $this->db->join('tbl_employee_infos as tb11', 'tb3.approver_3a  = tb11.id', 'left');
        $this->db->join('tbl_employee_infos as tb12', 'tb1.approver4    = tb12.id', 'left');
        $this->db->join('tbl_employee_infos as tb13', 'tb3.approver_4a  = tb13.id', 'left');
        $this->db->join('tbl_employee_infos as tb14', 'tb1.approver5    = tb14.id', 'left');
        $this->db->join('tbl_employee_infos as tb15', 'tb3.approver_5a  = tb15.id', 'left');
        $this->db->where('tb1.id', $id);
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row();
    }




    // function GET_OFFSET_APPROVAL_STATUS($id)
    // {
    //     $this->db->select('tb1.id,tb1.empl_id,tb1.date,tb8.name,tb1.status,tb1.create_date,tb1.remarks,tb1.reason,tb1.attachment,
    //     tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,
    //     tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat,tb1.approver4 as approver_4_stat,tb1.approver5 as approver_5_stat,
    //     tb3.approver_1a,tb3.approver_2a,tb3.approver_3a,tb3.approver_4a,tb3.approver_5a
    //     ');

    //     // $this->db->select("CONCAT_WS(' ',tb2.col_last_name,tb2.col_suffix, tb2.col_frst_name, LEFT(tb2.col_midl_name,1),'.') as employee", false);
    //     $this->db->select('CONCAT(tb2.col_last_name,IF(tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> "", CONCAT(" ",tb2.col_suffix, ""), ""), ", ",
    //     tb2.col_frst_name, " ",IF(tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> "", CONCAT(LEFT(tb2.col_midl_name, 1), "."), "")) as employee', false);

    //     // $this->db->select('CONCAT(tb4.col_last_name, ", ", tb4.col_frst_name, " ", LEFT(tb4.col_midl_name,1),".") as approver1', false);
    //     $this->db->select('CONCAT(tb4.col_last_name,IF(tb4.col_suffix IS NOT NULL AND tb4.col_suffix <> "", CONCAT(" ",tb4.col_suffix, ""), ""), ", ",
    //     tb4.col_frst_name, " ",IF(tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name <> "", CONCAT(LEFT(tb4.col_midl_name, 1), "."), "")) as approver1', false);

    //     // $this->db->select('CONCAT(tb5.col_last_name, ", ", tb5.col_frst_name, " ", LEFT(tb5.col_midl_name,1),".") as approver2', false);
    //     $this->db->select('CONCAT(tb5.col_last_name,IF(tb5.col_suffix IS NOT NULL AND tb5.col_suffix <> "", CONCAT(" ",tb5.col_suffix, ""), ""), ", ",
    //     tb5.col_frst_name, " ",IF(tb5.col_midl_name IS NOT NULL AND tb5.col_midl_name <> "", CONCAT(LEFT(tb5.col_midl_name, 1), "."), "")) as approver2', false);

    //     // $this->db->select('CONCAT(tb6.col_last_name, ", ", tb6.col_frst_name, " ", LEFT(tb6.col_midl_name,1),".") as approver3,', false);
    //     $this->db->select('CONCAT(tb6.col_last_name,IF(tb6.col_suffix IS NOT NULL AND tb6.col_suffix <> "", CONCAT(" ",tb6.col_suffix, ""), ""), ", ",
    //     tb6.col_frst_name, " ",IF(tb6.col_midl_name IS NOT NULL AND tb6.col_midl_name <> "", CONCAT(LEFT(tb6.col_midl_name, 1), "."), "")) as approver3', false);

    //     // --approver 4 and 5
    //     $this->db->select('CONCAT(tb12.col_last_name,IF(tb12.col_suffix IS NOT NULL AND tb12.col_suffix <> "", CONCAT(" ",tb12.col_suffix, ""), ""), ", ",
    //     tb12.col_frst_name, " ",IF(tb12.col_midl_name IS NOT NULL AND tb12.col_midl_name <> "", CONCAT(LEFT(tb12.col_midl_name, 1), "."), "")) as approver4', false);
    //     $this->db->select('CONCAT(tb14.col_last_name,IF(tb14.col_suffix IS NOT NULL AND tb14.col_suffix <> "", CONCAT(" ",tb14.col_suffix, ""), ""), ", ",
    //     tb14.col_frst_name, " ",IF(tb14.col_midl_name IS NOT NULL AND tb14.col_midl_name <> "", CONCAT(LEFT(tb14.col_midl_name, 1), "."), "")) as approver5', false);
    //     // ---
    //     // $this->db->select('CONCAT(tb7.col_last_name, ", ", tb7.col_frst_name, " ", LEFT(tb7.col_midl_name,1),".") as assigned_by,', false);
    //     $this->db->select('CONCAT(tb7.col_last_name,IF(tb7.col_suffix IS NOT NULL AND tb7.col_suffix <> "", CONCAT(" ",tb7.col_suffix, ""), ""), ", ",
    //     tb7.col_frst_name, " ",IF(tb7.col_midl_name IS NOT NULL AND tb7.col_midl_name <> "", CONCAT(LEFT(tb7.col_midl_name, 1), "."), "")) as assigned_by', false);

    //     // $this->db->select('CONCAT(tb9.col_last_name, ", ", tb9.col_frst_name, " ", LEFT(tb9.col_midl_name,1),".") as pending_approver1', false);
    //     $this->db->select('CONCAT(tb9.col_last_name,IF(tb9.col_suffix IS NOT NULL AND tb9.col_suffix <> "", CONCAT(" ",tb9.col_suffix, ""), ""), ", ",
    //     tb9.col_frst_name, " ",IF(tb9.col_midl_name IS NOT NULL AND tb9.col_midl_name <> "", CONCAT(LEFT(tb9.col_midl_name, 1), "."), "")) as pending_approver1', false);

    //     // $this->db->select('CONCAT(tb10.col_last_name, ", ", tb10.col_frst_name, " ", LEFT(tb10.col_midl_name,1),".") as pending_approver2', false);
    //     $this->db->select('CONCAT(tb10.col_last_name,IF(tb10.col_suffix IS NOT NULL AND tb10.col_suffix <> "", CONCAT(" ",tb10.col_suffix, ""), ""), ", ",
    //     tb10.col_frst_name, " ",IF(tb10.col_midl_name IS NOT NULL AND tb10.col_midl_name <> "", CONCAT(LEFT(tb10.col_midl_name, 1), "."), "")) as pending_approver2', false);

    //     // $this->db->select('CONCAT(tb11.col_last_name, ", ", tb11.col_frst_name, " ", LEFT(tb11.col_midl_name,1),".") as pending_approver3,', false);
    //     $this->db->select('CONCAT(tb11.col_last_name,IF(tb11.col_suffix IS NOT NULL AND tb11.col_suffix <> "", CONCAT(" ",tb11.col_suffix, ""), ""), ", ",
    //     tb11.col_frst_name, " ",IF(tb11.col_midl_name IS NOT NULL AND tb11.col_midl_name <> "", CONCAT(LEFT(tb11.col_midl_name, 1), "."), "")) as pending_approver3', false);
    //     // peding approver 4 and 5
    //     $this->db->select('CONCAT(tb13.col_last_name,IF(tb13.col_suffix IS NOT NULL AND tb13.col_suffix <> "", CONCAT(" ",tb13.col_suffix, ""), ""), ", ",
    //     tb13.col_frst_name, " ",IF(tb13.col_midl_name IS NOT NULL AND tb13.col_midl_name <> "", CONCAT(LEFT(tb13.col_midl_name, 1), "."), "")) as pending_approver4', false);

    //     $this->db->select('CONCAT(tb15.col_last_name,IF(tb15.col_suffix IS NOT NULL AND tb15.col_suffix <> "", CONCAT(" ",tb15.col_suffix, ""), ""), ", ",
    //     tb15.col_frst_name, " ",IF(tb15.col_midl_name IS NOT NULL AND tb15.col_midl_name <> "", CONCAT(LEFT(tb15.col_midl_name, 1), "."), "")) as pending_approver5', false);
    //     // ---
    //     $this->db->select('tb2.col_empl_emai as employee_email,tb9.col_empl_emai as approver1a_email,tb10.col_empl_emai as approver2a_email,
    //     tb11.col_empl_emai as approver3a_email,tb13.col_empl_emai as approver4a_email,tb15.col_empl_emai as approver5a_email');
    //     $this->db->select('tb4.col_empl_emai as approver1_email,tb5.col_empl_emai as approver2_email,
    //     tb6.col_empl_emai as approver3_email,tb12.col_empl_emai as approver4_email,tb14.col_empl_emai as approver5_email');

    //     $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,
    //     tb6.col_imag_path as approver_3_img,tb12.col_imag_path as approver_4_img,tb14.col_imag_path as approver_5_img');
    //     $this->db->select('tb9.col_imag_path as pending_approver1_img,tb10.col_imag_path as pending_approver2_img,
    //     tb11.col_imag_path as pending_approver3_img,tb13.col_imag_path as pending_approver4_img,tb15.col_imag_path as pending_approver5_img');
    //     $this->db->from('tbl_attendance_offsets as tb1');
    //     $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
    //     $this->db->join('tbl_approvers_offset as tb3', 'tb1.empl_id            = tb3.empl_id', 'left');
    //     $this->db->join('tbl_employee_infos as tb4', 'tb1.approver1     = tb4.id', 'left');
    //     $this->db->join('tbl_employee_infos as tb5', 'tb1.approver2     = tb5.id', 'left');
    //     $this->db->join('tbl_employee_infos as tb6', 'tb1.approver3     = tb6.id', 'left');
    //     $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
    //     $this->db->join('tbl_attendance_shifts as tb8', 'tb1.shift_id   = tb8.id', 'left');
    //     $this->db->join('tbl_employee_infos as tb9', 'tb3.approver_1a   = tb9.id', 'left');
    //     $this->db->join('tbl_employee_infos as tb10', 'tb3.approver_2a  = tb10.id', 'left');
    //     $this->db->join('tbl_employee_infos as tb11', 'tb3.approver_3a  = tb11.id', 'left');
    //     $this->db->join('tbl_employee_infos as tb12', 'tb1.approver4    = tb12.id', 'left');
    //     $this->db->join('tbl_employee_infos as tb13', 'tb3.approver_4a  = tb13.id', 'left');
    //     $this->db->join('tbl_employee_infos as tb14', 'tb1.approver5    = tb14.id', 'left');
    //     $this->db->join('tbl_employee_infos as tb15', 'tb3.approver_5a  = tb15.id', 'left');
    //     $this->db->where('tb1.id', $id);
    //     $this->db->limit('1');
    //     $query = $this->db->get();
    //     return $query->row();
    // }


    function GET_OFFSET_APPROVAL_STATUS($id)
    {
        $this->db->select('tb1.id, tb1.empl_id, tb1.offset_date, tb1.offset_type,tb8.name as shift_type,tb1.status,tb1.create_date,tb1.remarks,tb1.reason,tb1.attachment,
        tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,
        tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat,tb1.approver4 as approver_4_stat,tb1.approver5 as approver_5_stat,
        tb3.approver_1a, tb3.approver_1b, tb3.approver_2a, tb3.approver_2b, tb3.approver_3a,tb3.approver_4a,tb3.approver_5a
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

        // --approver 4 and 5
        $this->db->select('CONCAT(tb12.col_last_name,IF(tb12.col_suffix IS NOT NULL AND tb12.col_suffix <> "", CONCAT(" ",tb12.col_suffix, ""), ""), ", ",
        tb12.col_frst_name, " ",IF(tb12.col_midl_name IS NOT NULL AND tb12.col_midl_name <> "", CONCAT(LEFT(tb12.col_midl_name, 1), "."), "")) as approver4', false);
        $this->db->select('CONCAT(tb14.col_last_name,IF(tb14.col_suffix IS NOT NULL AND tb14.col_suffix <> "", CONCAT(" ",tb14.col_suffix, ""), ""), ", ",
        tb14.col_frst_name, " ",IF(tb14.col_midl_name IS NOT NULL AND tb14.col_midl_name <> "", CONCAT(LEFT(tb14.col_midl_name, 1), "."), "")) as approver5', false);
        // ---
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
        // peding approver 4 and 5
        $this->db->select('CONCAT(tb13.col_last_name,IF(tb13.col_suffix IS NOT NULL AND tb13.col_suffix <> "", CONCAT(" ",tb13.col_suffix, ""), ""), ", ",
        tb13.col_frst_name, " ",IF(tb13.col_midl_name IS NOT NULL AND tb13.col_midl_name <> "", CONCAT(LEFT(tb13.col_midl_name, 1), "."), "")) as pending_approver4', false);

        $this->db->select('CONCAT(tb15.col_last_name,IF(tb15.col_suffix IS NOT NULL AND tb15.col_suffix <> "", CONCAT(" ",tb15.col_suffix, ""), ""), ", ",
        tb15.col_frst_name, " ",IF(tb15.col_midl_name IS NOT NULL AND tb15.col_midl_name <> "", CONCAT(LEFT(tb15.col_midl_name, 1), "."), "")) as pending_approver5', false);
        // ---
        $this->db->select('tb2.col_empl_emai as employee_email,tb9.col_empl_emai as approver1a_email,tb10.col_empl_emai as approver2a_email,
        tb11.col_empl_emai as approver3a_email,tb13.col_empl_emai as approver4a_email,tb15.col_empl_emai as approver5a_email');

        $this->db->select('tb4.col_empl_emai as approver1_email,tb5.col_empl_emai as approver2_email,
        tb6.col_empl_emai as approver3_email,tb12.col_empl_emai as approver4_email,tb14.col_empl_emai as approver5_email');

        $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,
        tb6.col_imag_path as approver_3_img,tb12.col_imag_path as approver_4_img,tb14.col_imag_path as approver_5_img');

        $this->db->select('tb9.col_imag_path as pending_approver1_img,tb10.col_imag_path as pending_approver2_img,
        tb11.col_imag_path as pending_approver3_img,tb13.col_imag_path as pending_approver4_img,tb15.col_imag_path as pending_approver5_img');

        $this->db->from('tbl_attendance_offsets as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_approvers_offset as tb3', 'tb1.empl_id            = tb3.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver1     = tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.approver2     = tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver3     = tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
        $this->db->join('tbl_attendance_shifts as tb8', 'tb1.shift_id   = tb8.id', 'left');

        $this->db->join('tbl_employee_infos as tb9', 'tb3.approver_1a   = tb9.id', 'left');
        $this->db->join('tbl_employee_infos as tb9b', 'tb3.approver_1b  = tb9b.id', 'left');
        $this->db->join('tbl_employee_infos as tb10', 'tb3.approver_2a  = tb10.id', 'left');
        $this->db->join('tbl_employee_infos as tb10b', 'tb3.approver_2b = tb10b.id', 'left');
        $this->db->join('tbl_employee_infos as tb11', 'tb3.approver_3a  = tb11.id', 'left');
        $this->db->join('tbl_employee_infos as tb12', 'tb1.approver4    = tb12.id', 'left');
        $this->db->join('tbl_employee_infos as tb13', 'tb3.approver_4a  = tb13.id', 'left');
        $this->db->join('tbl_employee_infos as tb14', 'tb1.approver5    = tb14.id', 'left');
        $this->db->join('tbl_employee_infos as tb15', 'tb3.approver_5a  = tb15.id', 'left');
        $this->db->where('tb1.id', $id);
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row();
    }



    function GET_ACQUIRE_OFFSET_APPROVAL_STATUS($id)
    {
        $this->db->select('tb1.id, tb1.empl_id, tb1.offset_date, tb1.offset_type,tb8.name as shift_type,tb1.status,tb1.create_date,tb1.remarks,tb1.reason,tb1.attachment,
        tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,
        tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat,tb1.approver4 as approver_4_stat,tb1.approver5 as approver_5_stat,
        tb3.approver_1a, tb3.approver_1b, tb3.approver_2a, tb3.approver_2b, tb3.approver_3a,tb3.approver_4a,tb3.approver_5a
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

        // --approver 4 and 5
        $this->db->select('CONCAT(tb12.col_last_name,IF(tb12.col_suffix IS NOT NULL AND tb12.col_suffix <> "", CONCAT(" ",tb12.col_suffix, ""), ""), ", ",
        tb12.col_frst_name, " ",IF(tb12.col_midl_name IS NOT NULL AND tb12.col_midl_name <> "", CONCAT(LEFT(tb12.col_midl_name, 1), "."), "")) as approver4', false);
        $this->db->select('CONCAT(tb14.col_last_name,IF(tb14.col_suffix IS NOT NULL AND tb14.col_suffix <> "", CONCAT(" ",tb14.col_suffix, ""), ""), ", ",
        tb14.col_frst_name, " ",IF(tb14.col_midl_name IS NOT NULL AND tb14.col_midl_name <> "", CONCAT(LEFT(tb14.col_midl_name, 1), "."), "")) as approver5', false);
        // ---
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
        // peding approver 4 and 5
        $this->db->select('CONCAT(tb13.col_last_name,IF(tb13.col_suffix IS NOT NULL AND tb13.col_suffix <> "", CONCAT(" ",tb13.col_suffix, ""), ""), ", ",
        tb13.col_frst_name, " ",IF(tb13.col_midl_name IS NOT NULL AND tb13.col_midl_name <> "", CONCAT(LEFT(tb13.col_midl_name, 1), "."), "")) as pending_approver4', false);

        $this->db->select('CONCAT(tb15.col_last_name,IF(tb15.col_suffix IS NOT NULL AND tb15.col_suffix <> "", CONCAT(" ",tb15.col_suffix, ""), ""), ", ",
        tb15.col_frst_name, " ",IF(tb15.col_midl_name IS NOT NULL AND tb15.col_midl_name <> "", CONCAT(LEFT(tb15.col_midl_name, 1), "."), "")) as pending_approver5', false);
        // ---
        $this->db->select('tb2.col_empl_emai as employee_email,tb9.col_empl_emai as approver1a_email,tb10.col_empl_emai as approver2a_email,
        tb11.col_empl_emai as approver3a_email,tb13.col_empl_emai as approver4a_email,tb15.col_empl_emai as approver5a_email');

        $this->db->select('tb4.col_empl_emai as approver1_email,tb5.col_empl_emai as approver2_email,
        tb6.col_empl_emai as approver3_email,tb12.col_empl_emai as approver4_email,tb14.col_empl_emai as approver5_email');

        $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,
        tb6.col_imag_path as approver_3_img,tb12.col_imag_path as approver_4_img,tb14.col_imag_path as approver_5_img');

        $this->db->select('tb9.col_imag_path as pending_approver1_img,tb10.col_imag_path as pending_approver2_img,
        tb11.col_imag_path as pending_approver3_img,tb13.col_imag_path as pending_approver4_img,tb15.col_imag_path as pending_approver5_img');

        $this->db->from('tbl_attendance_offsets_acquire as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_approvers_offset_acquire as tb3', 'tb1.empl_id            = tb3.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver1     = tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.approver2     = tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver3     = tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
        $this->db->join('tbl_attendance_shifts as tb8', 'tb1.shift_id   = tb8.id', 'left');

        $this->db->join('tbl_employee_infos as tb9', 'tb3.approver_1a   = tb9.id', 'left');
        $this->db->join('tbl_employee_infos as tb9b', 'tb3.approver_1b  = tb9b.id', 'left');
        $this->db->join('tbl_employee_infos as tb10', 'tb3.approver_2a  = tb10.id', 'left');
        $this->db->join('tbl_employee_infos as tb10b', 'tb3.approver_2b = tb10b.id', 'left');
        $this->db->join('tbl_employee_infos as tb11', 'tb3.approver_3a  = tb11.id', 'left');
        $this->db->join('tbl_employee_infos as tb12', 'tb1.approver4    = tb12.id', 'left');
        $this->db->join('tbl_employee_infos as tb13', 'tb3.approver_4a  = tb13.id', 'left');
        $this->db->join('tbl_employee_infos as tb14', 'tb1.approver5    = tb14.id', 'left');
        $this->db->join('tbl_employee_infos as tb15', 'tb3.approver_5a  = tb15.id', 'left');
        $this->db->where('tb1.id', $id);
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row();
    }



    function GET_OVERTIME_STATUS($id)
    {
        $this->db->select('tb1.id,tb1.date_ot,tb1.empl_id,tb1.hours, tb1.ndot, tb1.status,tb1.create_date,tb1.edit_date, tb1.current_shift, tb1.time_range,tb1.comment,tb1.reason,
        tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,tb1.type,
        tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat,
         tb3.approver_1a,tb3.approver_1b,tb3.approver_2a,tb3.approver_2b,tb3.approver_3a,tb3.approver_3b
        ');
        // $this->db->select(' CONCAT(tb2.col_last_name, ", ", tb2.col_frst_name, " ", LEFT(tb2.col_midl_name,1),".") as employee', false);
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

        // $this->db->select('CONCAT(tb8.col_last_name, ", ", tb8.col_frst_name, " ", LEFT(tb8.col_midl_name,1),".") as pending_approver1', false);
        $this->db->select('CONCAT(tb8.col_last_name,IF(tb8.col_suffix IS NOT NULL AND tb8.col_suffix <> "", CONCAT(" ",tb8.col_suffix, ""), ""), ", ",
        tb8.col_frst_name, " ",IF(tb8.col_midl_name IS NOT NULL AND tb8.col_midl_name <> "", CONCAT(LEFT(tb8.col_midl_name, 1), "."), "")) as pending_approver1', false);

        // $this->db->select('CONCAT(tb9.col_last_name, ", ", tb9.col_frst_name, " ", LEFT(tb9.col_midl_name,1),".") as pending_approver2', false);
        $this->db->select('CONCAT(tb9.col_last_name,IF(tb9.col_suffix IS NOT NULL AND tb9.col_suffix <> "", CONCAT(" ",tb9.col_suffix, ""), ""), ", ",
        tb9.col_frst_name, " ",IF(tb9.col_midl_name IS NOT NULL AND tb9.col_midl_name <> "", CONCAT(LEFT(tb9.col_midl_name, 1), "."), "")) as pending_approver2', false);

        // $this->db->select('CONCAT(tb10.col_last_name, ", ", tb10.col_frst_name, " ", LEFT(tb10.col_midl_name,1),".") as pending_approver3,', false);
        $this->db->select('CONCAT(tb10.col_last_name,IF(tb10.col_suffix IS NOT NULL AND tb10.col_suffix <> "", CONCAT(" ",tb10.col_suffix, ""), ""), ", ",
        tb10.col_frst_name, " ",IF(tb10.col_midl_name IS NOT NULL AND tb10.col_midl_name <> "", CONCAT(LEFT(tb10.col_midl_name, 1), "."), "")) as pending_approver3', false);

        $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,tb6.col_imag_path as approver_3_img');
        $this->db->select('tb8.col_imag_path as pending_approver1_img,tb9.col_imag_path as pending_approver2_img,tb10.col_imag_path as pending_approver3_img');

        $this->db->select('tb2.col_empl_emai as employee_email,tb8.col_empl_emai as approver1a_email,tb9.col_empl_emai as approver2a_email,tb10.col_empl_emai as approver3a_email');
        $this->db->select('tb4.col_empl_emai as approver1_email,tb5.col_empl_emai as approver2_email,tb6.col_empl_emai as approver3_email');

        $this->db->from('tbl_overtimes as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_approvers_ot as tb3', 'tb1.empl_id      = tb3.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver1   = tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.approver2   = tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver3   = tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
        $this->db->join('tbl_employee_infos as tb8', 'tb3.approver_1a   = tb8.id', 'left');
        $this->db->join('tbl_employee_infos as tb9b', 'tb3.approver_1b  = tb9b.id', 'left');
        $this->db->join('tbl_employee_infos as tb9', 'tb3.approver_2a  = tb9.id', 'left');
        $this->db->join('tbl_employee_infos as tb10b', 'tb3.approver_2b = tb10b.id', 'left');
        $this->db->join('tbl_employee_infos as tb10', 'tb3.approver_3a  = tb10.id', 'left');
        $this->db->join('tbl_employee_infos as tb11b', 'tb3.approver_3b  = tb11b.id', 'left');
        $this->db->where('tb1.id', $id);
        $this->db->limit('1');
        $query = $this->db->get();
        return $query->row();
    }
    function GET_ADJUSTMENTS_SPECIFIC($adjustments, $id)
    {
        // First query to get the shift_id
        $shift_id_query = $this->db->query("SELECT tbl_attendance_shiftassign.shift_id FROM tbl_attendance_shiftassign WHERE tbl_attendance_shiftassign.`date`='$adjustments' AND tbl_attendance_shiftassign.empl_id = ?", array($id));
        $shift_id_result = $shift_id_query->row(); // Assuming you expect only one row

        if ($shift_id_result) {
            // Use the shift_id in the second query
            $shift_id = $shift_id_result->shift_id;
            $sql = "SELECT * FROM tbl_attendance_shifts WHERE id = ?";
            $adjustments_query = $this->db->query($sql, array($shift_id));
            return $adjustments_query->row(); // Return only the first row
        } else {
            // Handle case where no shift_id is found
            return false;
        }
    }
    function GET_ACTUAL_TIMES($adjustments, $id)
    {

        $sql = "SELECT time_in, time_out FROM tbl_attendance_records WHERE `date` = ? AND empl_id = ?";
        $adjustments_query = $this->db->query($sql, array($adjustments, $id));

        // Check if the result is empty
        if ($adjustments_query->num_rows() > 0) {
            return $adjustments_query->row(); // Return the first row if data is found
        } else {
            // Return default empty values if no data is found
            return (object) [
                'time_in'  => '',
                'time_out' => ''
            ];
        }
    }



    function GET_TIME_ADJUSTMENT($id)
    {
        $this->db->select('tb1.id,tb1.date_adjustment,tb1.empl_id,tb1.status,tb1.create_date,tb1.remarks,tb1.attachment,tb1.reason,
        tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,tb1.shift_type,tb1.time_in_1,tb1.time_out_1,tb1.time_in_2,tb1.time_out_2,
        tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat,
        tb3.approver_1a,tb3.approver_2a,tb3.approver_3a
        ');

        // $this->db->select(' CONCAT(tb2.col_last_name, ", ", tb2.col_frst_name, " ", LEFT(tb2.col_midl_name,1),".") as employee', false);
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

        // $this->db->select('CONCAT(tb8.col_last_name, ", ", tb8.col_frst_name, " ", LEFT(tb8.col_midl_name,1),".") as pending_approver1', false);
        $this->db->select('CONCAT(tb8.col_last_name,IF(tb8.col_suffix IS NOT NULL AND tb8.col_suffix <> "", CONCAT(" ",tb8.col_suffix, ""), ""), ", ",
        tb8.col_frst_name, " ",IF(tb8.col_midl_name IS NOT NULL AND tb8.col_midl_name <> "", CONCAT(LEFT(tb8.col_midl_name, 1), "."), "")) as pending_approver1', false);

        // $this->db->select('CONCAT(tb9.col_last_name, ", ", tb9.col_frst_name, " ", LEFT(tb9.col_midl_name,1),".") as pending_approver2', false);
        $this->db->select('CONCAT(tb9.col_last_name,IF(tb9.col_suffix IS NOT NULL AND tb9.col_suffix <> "", CONCAT(" ",tb9.col_suffix, ""), ""), ", ",
        tb9.col_frst_name, " ",IF(tb9.col_midl_name IS NOT NULL AND tb9.col_midl_name <> "", CONCAT(LEFT(tb9.col_midl_name, 1), "."), "")) as pending_approver2', false);

        $this->db->select('CONCAT(tb10.col_last_name, ", ", tb10.col_frst_name, " ", LEFT(tb10.col_midl_name,1),".") as pending_approver3,', false);
        $this->db->select('CONCAT(tb10.col_last_name,IF(tb10.col_suffix IS NOT NULL AND tb10.col_suffix <> "", CONCAT(" ",tb10.col_suffix, ""), ""), ", ",
        tb10.col_frst_name, " ",IF(tb10.col_midl_name IS NOT NULL AND tb10.col_midl_name <> "", CONCAT(LEFT(tb10.col_midl_name, 1), "."), "")) as pending_approver3', false);

        $this->db->select('tb2.col_empl_emai as employee_email,tb8.col_empl_emai as approver1a_email,tb9.col_empl_emai as approver2a_email,tb10.col_empl_emai as approver3a_email');
        $this->db->select('tb4.col_empl_emai as approver1_email,tb5.col_empl_emai as approver2_email,tb6.col_empl_emai as approver3_email');

        $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,tb6.col_imag_path as approver_3_img');
        $this->db->select('tb8.col_imag_path as pending_approver1_img,tb9.col_imag_path as pending_approver2_img,tb10.col_imag_path as pending_approver3_img');

        $this->db->from('tbl_attendance_adjustments as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_approvers_timeadj as tb3', 'tb1.empl_id            = tb3.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver1   = tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.approver2   = tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver3   = tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
        $this->db->join('tbl_employee_infos as tb8', 'tb3.approver_1a   = tb8.id', 'left');
        $this->db->join('tbl_employee_infos as tb9', 'tb3.approver_2a  = tb9.id', 'left');
        $this->db->join('tbl_employee_infos as tb10', 'tb3.approver_3a  = tb10.id', 'left');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function GET_HOLIDAY_WORK_STATUS($id)
    {
        $this->db->select('tb1.id,tb1.date,tb1.empl_id,tb1.hours,tb1.status,tb1.create_date,tb1.comment,tb1.reason,
        tb1.approver1_date,tb1.approver2_date,tb1.approver3_date,tb1.type,
        tb1.approver1 as approver_1_stat,tb1.approver2 as approver_2_stat,tb1.approver3 as approver_3_stat,
        tb3.approver_1a,tb3.approver_2a,tb3.approver_3a
        ');
        // $this->db->select(' CONCAT(tb2.col_last_name, ", ", tb2.col_frst_name, " ", LEFT(tb2.col_midl_name,1),".") as employee', false);
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

        // $this->db->select('CONCAT(tb8.col_last_name, ", ", tb8.col_frst_name, " ", LEFT(tb8.col_midl_name,1),".") as pending_approver1', false);
        $this->db->select('CONCAT(tb8.col_last_name,IF(tb8.col_suffix IS NOT NULL AND tb8.col_suffix <> "", CONCAT(" ",tb8.col_suffix, ""), ""), ", ",
        tb8.col_frst_name, " ",IF(tb8.col_midl_name IS NOT NULL AND tb8.col_midl_name <> "", CONCAT(LEFT(tb8.col_midl_name, 1), "."), "")) as pending_approver1', false);

        // $this->db->select('CONCAT(tb9.col_last_name, ", ", tb9.col_frst_name, " ", LEFT(tb9.col_midl_name,1),".") as pending_approver2', false);
        $this->db->select('CONCAT(tb9.col_last_name,IF(tb9.col_suffix IS NOT NULL AND tb9.col_suffix <> "", CONCAT(" ",tb9.col_suffix, ""), ""), ", ",
        tb9.col_frst_name, " ",IF(tb9.col_midl_name IS NOT NULL AND tb9.col_midl_name <> "", CONCAT(LEFT(tb9.col_midl_name, 1), "."), "")) as pending_approver2', false);

        // $this->db->select('CONCAT(tb10.col_last_name, ", ", tb10.col_frst_name, " ", LEFT(tb10.col_midl_name,1),".") as pending_approver3,', false);
        $this->db->select('CONCAT(tb10.col_last_name,IF(tb10.col_suffix IS NOT NULL AND tb10.col_suffix <> "", CONCAT(" ",tb10.col_suffix, ""), ""), ", ",
        tb10.col_frst_name, " ",IF(tb10.col_midl_name IS NOT NULL AND tb10.col_midl_name <> "", CONCAT(LEFT(tb10.col_midl_name, 1), "."), "")) as pending_approver3', false);

        $this->db->select('tb2.col_empl_emai as employee_email,tb8.col_empl_emai as approver1a_email,tb9.col_empl_emai as approver2a_email,tb10.col_empl_emai as approver3a_email');
        $this->db->select('tb4.col_empl_emai as approver1_email,tb5.col_empl_emai as approver2_email,tb6.col_empl_emai as approver3_email');

        $this->db->select('tb2.col_imag_path as empl_image,tb4.col_imag_path as approver_1_img,tb5.col_imag_path as approver_2_img,tb6.col_imag_path as approver_3_img');
        $this->db->select('tb8.col_imag_path as pending_approver1_img,tb9.col_imag_path as pending_approver2_img,tb10.col_imag_path as pending_approver3_img');

        $this->db->from('tbl_holidaywork as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id       = tb2.id', 'left');
        $this->db->join('tbl_approvers_ot as tb3', 'tb1.empl_id      = tb3.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver1   = tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.approver2   = tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver3   = tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.assigned_by   = tb7.id', 'left');
        $this->db->join('tbl_employee_infos as tb8', 'tb3.approver_1a   = tb8.id', 'left');
        $this->db->join('tbl_employee_infos as tb9', 'tb3.approver_2a  = tb9.id', 'left');
        $this->db->join('tbl_employee_infos as tb10', 'tb3.approver_3a  = tb10.id', 'left');
        $this->db->where('tb1.id', $id);
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

    function GET_SYSTEM_SETTING($setting)
    {
        $is_exist = $this->db->select("value")->where('setting', $setting)->get("tbl_system_setup")->row();
        if ($is_exist) {
            return $is_exist->value;
        } else {
            $this->db->insert("tbl_system_setup", array('setting' => $setting, 'value' => '0'));
            return 0;
        }
    }

    function ENABLE_SETTINGS($setting)
    {
        $sql = "SELECT 1 AS value FROM tbl_system_setup WHERE setting = '$setting'";
        $query = $this->db->query($sql);
        $result = $query->row();

        if ($result) {
            return 1; // Always return 1
        }

        return null;
    }

    public function acknowledge_payslip($payslip_id, $user_id)
    {
        $this->db->where('id', $payslip_id);
        $this->db->where('empl_id', $user_id);
        return $this->db->update('tbl_payroll_payslips', ['is_acknowledged' => 1]);
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

    function GET_EMPLOYEE_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function ADD_EMPLOYEE_LOGS($edit_id, $empl_id, $category, $from_val, $to_val)
    {
        $log_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_logs (log_date, edit_id,empl_id,category,from_val,to_val) VALUES(?,?,?,?,?,?)";
        $this->db->query($sql, array($log_date, $edit_id, $empl_id, $category, $from_val, $to_val));
    }

    function UPDATE_PERSONAL_DETAIL($first_name, $middlename, $lastname, $marital_status, $mobile_number, $birthdate, $gender, $nationality, $shirt_size, $email, $home_address, $current_address, $user_id)
    {

        $sql = "UPDATE tbl_employee_infos SET col_last_name=?,col_midl_name=?,col_frst_name=?,col_mart_stat=?,col_home_addr=?,col_curr_addr=?,col_birt_date=?,col_empl_gend=?,col_empl_nati=?,col_shir_size=?,col_empl_emai=?,col_mobl_numb=? WHERE id=?";
        $query = $this->db->query($sql, array($lastname, $middlename, $first_name, $marital_status, $home_address, $current_address, $birthdate, $gender, $nationality, $shirt_size, $email, $mobile_number, $user_id));
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

    function GET_COMP_STRUCTURE()
    {
        $sql = "SELECT * FROM tbl_system_setup";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_INSRT_SKILL($employee_id, $skill, $level)
    {
        $sql = "INSERT INTO tbl_std_skillnames(
            col_empl_id,
            col_skill_name,
            col_skill_level) VALUES (?,?,?)";
        $query = $this->db->query($sql, array($employee_id, $skill, $level));
        return $this->db->insert_id();
    }

    function MOD_UPDT_EMPLOYEE_INFO($employee_id, $lastname, $middlename, $firstname, $birthday, $gender, $marital_status, $shirt_size, $nationality, $home_address, $current_address, $employee_key)
    {
        $sql = "UPDATE tbl_employee_infos SET col_empl_cmid=?,col_last_name=?,col_midl_name=?,col_frst_name=?,col_birt_date=?,col_empl_gend=?,col_mart_stat=?,col_shir_size=?,col_empl_nati=?,col_home_addr=?,col_curr_addr=? WHERE id=?";
        $query = $this->db->query($sql, array($employee_id, $lastname, $middlename, $firstname, $birthday, $gender, $marital_status, $shirt_size, $nationality, $home_address, $current_address, $employee_key));
    }

    function MOD_UPDT_EMPLOYEE_CONTACT($work_email, $personal_email, $work_number, $personal_number, $employee_key)
    {
        $sql = "UPDATE tbl_employee_infos SET col_comp_emai=?,col_empl_emai=?,col_comp_numb=?,col_mobl_numb=? WHERE id=?";
        $query = $this->db->query($sql, array($work_email, $personal_email, $work_number, $personal_number, $employee_key));
    }

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

    function MOD_UPDT_EMPL_DETAILS($emp_type, $position, $department, $section, $groups, $line, $hmo, $hmo_number, $user_id)
    {
        $sql = "UPDATE tbl_employee_infos SET col_empl_type=?,col_empl_posi=?,col_empl_dept=?,col_empl_sect=?,col_empl_group=?,col_empl_line=?,col_empl_hmoo=?,col_empl_hmon=? WHERE id=?";
        $query = $this->db->query($sql, array($emp_type, $position, $department, $section, $groups, $line, $hmo, $hmo_number, $user_id));
    }

    function MOD_UPDT_EMPL_SALARY_RATE($salary_rate, $salary_type, $user_id)
    {
        $sql = "UPDATE tbl_employee_infos SET salary_rate=?,salary_type=? WHERE id=?";
        $query = $this->db->query($sql, array($salary_rate, $salary_type, $user_id));
    }

    function MOD_INSRT_DOC($document_file, $document_name, $employee_id)
    {
        $sql = "INSERT INTO tbl_employee_documents(col_doc_file,col_doc_name,col_empl_id) VALUES (?,?,?)";
        $query = $this->db->query($sql, array($document_file, $document_name, $employee_id));
        return $this->db->insert_id();
    }

    function MOD_DLT_DOCU($document_id)
    {
        $sql = "DELETE FROM tbl_employee_documents WHERE id=?";
        $query = $this->db->query($sql, array($document_id));
    }

    function MOD_INSRT_EMERGENCY($INSRT_EMER_EMPID, $INSRT_EMER_NAME, $INSRT_EMER_RELA, $INSRT_EMER_MNUM, $INSRT_EMER_WPHN, $INSRT_EMER_HPHN, $INSRT_EMER_ADDR)
    {
        $sql = "INSERT INTO tbl_employee_emergency (empid, name, relationship, mobile_number, work_phone, home_phone, current_address) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $query = $this->db->query($sql, array($INSRT_EMER_EMPID, $INSRT_EMER_NAME, $INSRT_EMER_RELA, $INSRT_EMER_MNUM, $INSRT_EMER_WPHN, $INSRT_EMER_HPHN, $INSRT_EMER_ADDR));
        return;
    }

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

    function MOD_DLT_DEPENDENTS($DATA_ID)
    {
        $sql = "DELETE FROM tbl_employee_dependents WHERE id=?";
        $query = $this->db->query($sql, array($DATA_ID));
        return;
    }

    function MOD_GET_DEPENDENTS_DATA($DATA_ID)
    {
        $sql = "SELECT * FROM tbl_employee_dependents WHERE id=?";
        $query = $this->db->query($sql, array($DATA_ID));
        $query->next_result();
        return $query->result();
    }

    function MOD_UPDT_DEPENDENTS($dep_name1, $dep_rel1, $dep_gend1, $dep_birth1, $dep_name2, $dep_rel2, $dep_gend2, $dep_birth2, $dep_name3, $dep_rel3, $dep_gend3, $dep_birth3, $dep_name4, $dep_rel4, $dep_gend4, $dep_birth4, $employee_id)
    {
        $sql = "UPDATE tbl_employee_infos SET dep_name1=?, dep_rel1=?, dep_gend1=?, dep_birth1=?, dep_name2=?, dep_rel2=?, dep_gend2=?, dep_birth2=?, dep_name3=?, dep_rel3=?, dep_gend3=?, dep_birth3=?, dep_name4=?, dep_rel4=?, dep_gend4=?, dep_birth4=? WHERE id=?";
        $query = $this->db->query($sql, array($dep_name1,  $dep_rel1,  $dep_gend1,  $dep_birth1,  $dep_name2,  $dep_rel2,  $dep_gend2,  $dep_birth2,  $dep_name3,  $dep_rel3,  $dep_gend3,  $dep_birth3,  $dep_name4,  $dep_rel4,  $dep_gend4,  $dep_birth4, $employee_id));
        return;
    }

    function MOD_INSRT_NOTES($INSRT_NOTE_CRBY, $INSRT_NOTE_CRDT, $INSRT_NOTE_DESC, $INSRT_NOTE_EMID)
    {
        $sql = "INSERT INTO tbl_empl_note (col_notes_created_by, col_notes_date_created, col_notes_desc, col_empl_id) VALUES (?, ?, ?, ?)";
        $query = $this->db->query($sql, array($INSRT_NOTE_CRBY, $INSRT_NOTE_CRDT, $INSRT_NOTE_DESC, $INSRT_NOTE_EMID));
        return;
    }

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

    function MOD_DISP_LEAVE_CREDIT_SETTING()
    {
        $this->db->select('s.id, s.setting, s.value, t.*');
        $this->db->from('tbl_leaves_settings s');
        $this->db->join('tbl_std_leavetypes t', 's.id = t.leave_setting_id', 'left');
        $this->db->where('s.value', 1);
        $result = $this->db->get()->result();
    }

    function MOD_DISP_EMPLOYEE($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function GET_SPECIFIC_EMPLOYEE_REMOTE_ATTENDANCE($employee_id)
    {
        $sql = "SELECT remote_att FROM tbl_employee_infos WHERE id=?";
        $query = $this->db->query($sql, array($employee_id));

        $result = $query->row();
        if ($result) {
            return $result->remote_att;
        } else {
            return null;
        }
    }

    function GET_TODAY_USER_ATTENDANCE($user_id)
    {
        $currDate = date('Y-m-d');
        $this->db->select("tb1.id,tb3.name as shift_name,
        tb3.time_regular_start,
        tb3.time_regular_end,
        tb3.time_in_2 ,
        tb3.time_out_2,
        tb1.snapshot_in,
        tb1.snapshot_out,
        tb1.time_in,tb1.time_in_address,
        tb1.time_out,tb1.time_out_address,
        tb1.break_in,tb1.break_in_address,
        tb1.break_out,tb1.break_out_address");
        $this->db->from("tbl_attendance_records  as tb1");
        $this->db->join("tbl_attendance_shiftassign as tb2", "tb1.date=tb2.date AND tb1.empl_id=tb2.empl_id", "left");
        $this->db->join("tbl_attendance_shifts as tb3", "tb2.shift_id=tb3.id", "left");
        $this->db->where("tb1.date", $currDate);
        $this->db->where("tb1.empl_id", $user_id);
        $query = $this->db->get();
        return $query->row();
    }
    function GET_TODAY_SHIFT($user_id)
    {
        $currDate = date('Y-m-d');
        $this->db->select("tb1.id,tb2.name,tb2.time_regular_start,tb2.time_regular_end");
        $this->db->from("tbl_attendance_shiftassign as tb1");
        $this->db->join("tbl_attendance_shifts as tb2", "tb1.shift_id=tb2.id");
        $this->db->where("tb1.date", $currDate);
        $this->db->where("tb1.empl_id", $user_id);
        $query = $this->db->get();
        return $query->row();
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

    function INSERT_TIME_ADJUSTMENT($timeIn1, $timeOut1, $timeIn2, $timeOut2, $empl_id, $date)
    {
        $sql = "INSERT INTO tbl_attendance_records (date, empl_id, time_in, time_out) VALUES (?,?,?,?)";
        $query = $this->db->query($sql, array($date, $empl_id, $timeIn1, $timeOut1));
    }

    function UPDATE_TIME_ADJUSTMENT($timeIn1, $timeOut1, $timeIn2, $timeOut2, $empl_id, $date)
    {
        $sql = "UPDATE tbl_attendance_records SET time_in=?, time_out=? WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql, array($timeIn1, $timeOut1, $empl_id, $date));
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

    function IS_DUPLICATE_REMOTE($user_id)
    {
        $date = new DateTime("now");
        $period = $date->format('Y-m-d');

        $sql = "SELECT id FROM tbl_attendance_records WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql, array($user_id, $period));
        $query->next_result();
        $data = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }

    function get_system_setup_setting($setting)
    {
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = ?";
        $query = $this->db->query($sql, array($setting));
        $result = $query->row();
        return $result->value;
    }

    function GET_ATTENDANCE_DATA($user_id)
    {
        $date = new DateTime("now");
        $period = $date->format('Y-m-d');

        $sql = "SELECT * FROM tbl_attendance_records WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql, array($user_id, $period));
        return $query->row();
    }

    function GET_EMPL_TIME_IN($empl_id, $current_date)
    {
        $sql = "SELECT * FROM tbl_attendance_records where date=? AND empl_id=?";
        $query = $this->db->query($sql, array($current_date, $empl_id));
        return $query->row();
    }

    function UPDATE_EMPL_TIME_IN_1($empl_id, $current_date, $time, $time_address, $file_name)
    {
        $datetime = date('Y-m-d H:i:s');
        
        $check = $this->db->query("SELECT * FROM tbl_attendance_records WHERE empl_id=? AND date=?", array($empl_id, $current_date))->row();
        
        if($check){
            // Update existing
            $this->db->query("UPDATE tbl_attendance_records 
                            SET time_in=?, time_in_address=?, snapshot_in=?, edit_date=? 
                            WHERE empl_id=? AND date=?", 
                            array($time, $time_address, $file_name, $datetime, $empl_id, $current_date));
        } else {
            // Insert new
            $this->db->query("INSERT INTO tbl_attendance_records 
                            (create_date, edit_date, is_deleted, edit_user, empl_id, date, time_in, time_in_address, snapshot_in)
                            VALUES (?, ?, 0, ?, ?, ?, ?, ?, ?)", 
                            array($datetime, $datetime, $empl_id, $empl_id, $current_date, $time, $time_address, $file_name));
        }
    }


    function UPDATE_EMPL_TIME_OUT_1($empl_id, $current_date, $time, $time_address, $file_name)
    {
        $datetime = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_records SET edit_date=?, time_out=?, time_out_address=?, snapshot_out=? WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql, array($datetime, $time, $time_address, $file_name, $current_date, $empl_id));
    }

    // commented by benar due to bug on 31jan24
    // function UPDATE_EMPL_TIME_IN_2($empl_id, $current_date, $time, $time_address)
    // {
    //     $datetime = date('Y-m-d H:i:s');
    //     $sql = "UPDATE tbl_attendance_records SET edit_date=?, time_in2=?, time_in2_address=? WHERE date=? AND empl_id=?";
    //     $query = $this->db->query($sql, array($datetime, $time, $time_address, $current_date, $empl_id));
    // }
    function UPDATE_EMPL_TIME_IN_2($empl_id, $current_date, $time, $time_address, $file_name)
    {
        $datetime = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_records SET edit_date=?, break_in=?, break_in_address=?, break_in_snapshot=? WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql, array($datetime, $time, $time_address, $file_name, $current_date, $empl_id));
    }
    // commented by benar due to bug on 31jan24
    // function UPDATE_EMPL_TIME_OUT_2($empl_id, $current_date, $time, $time_address)
    // {
    //     $datetime = date('Y-m-d H:i:s');
    //     $sql = "UPDATE tbl_attendance_records SET edit_date=?, time_out2=?, time_out2_address=? WHERE date=? AND empl_id=?";
    //     $query = $this->db->query($sql, array($datetime, $time, $time_address, $current_date, $empl_id));
    // } 
    function UPDATE_EMPL_TIME_OUT_2($empl_id, $current_date, $time, $time_address, $file_name)
    {
        $datetime = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_records SET edit_date=?, break_out=?, break_out_address=?, break_out_snapshot=? WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql, array($datetime, $time, $time_address, $file_name, $current_date, $empl_id));
    }

    function GET_APPROVED_TIME_ADJUSTMENT($id)
    {
        $sql = "SELECT * FROM tbl_attendance_adjustments WHERE status = 'Approved' AND id=?";
        $query = $this->db->query($sql, array($id));
        return $query->row();
    }
    function GET_APPROVED_TIME_ADJUSTMENTS($empl_id, $date_from, $date_to)
    {
        $sql = "SELECT *
                FROM tbl_attendance_adjustments
                WHERE status = 'Approved'
                AND empl_id = ?
                AND date_adjustment >= ?
                AND date_adjustment <= ?";
                
        $query = $this->db->query($sql, array($empl_id, $date_from, $date_to));
        $query->next_result();
        return $query->result();
    }


    function GET_ATTENDANCE_SHIFT($code)
    {
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE code=?";
        $query = $this->db->query($sql, array($code));
        return $query->row();
    }

    function MOD_GET_WRK_SHFT_DATA($work_shift_id)
    {
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE id=?";
        $query = $this->db->query($sql, array($work_shift_id));
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

    function MOD_UPDT_NOTES($UPDT_NOTE_CRBY, $UPDT_NOTE_CRDT, $UPDT_NOTE_DESC, $UPDT_NOTE_EMID, $DATA_ID)
    {
        $sql = "UPDATE tbl_empl_note SET col_notes_created_by=?, col_notes_date_created=?, col_notes_desc=?, col_empl_id=? WHERE id=?";
        $query = $this->db->query($sql, array($UPDT_NOTE_CRBY, $UPDT_NOTE_CRDT, $UPDT_NOTE_DESC, $UPDT_NOTE_EMID, $DATA_ID));
        return;
    }

    function MOD_UPDT_EDUCATION($school, $degree, $from_year, $to_year, $grade, $employee_id, $education_id)
    {
        $sql = "UPDATE tbl_employee_education SET col_educ_school=?,col_educ_degree=?,col_educ_from_yr=?,col_educ_to_yr=?,col_educ_grade=? WHERE col_empl_id=? AND id=?";
        $query = $this->db->query($sql, array($school, $degree, $from_year, $to_year, $grade, $employee_id, $education_id));
    }

    function MOD_DLT_EDUCATION($education_id)
    {
        $sql = "DELETE FROM tbl_employee_education WHERE id = ?";
        $query = $this->db->query($sql, array($education_id));
    }

    function MOD_GET_EDUCATION_DATA($education_id)
    {
        $sql = "SELECT * FROM tbl_employee_education WHERE id=?";
        $query = $this->db->query($sql, array($education_id));
        $query->next_result();
        return $query->result();
    }

    function MOD_UPDT_LICENSE($certificate_name, $issuer, $issued_on, $expires_on, $employee_id, $education_id)
    {
        $sql = "UPDATE tbl_pers_lice SET col_cert_name=?,col_cert_issuer=?,col_cert_issued_on=?,col_cert_expires_on=? WHERE col_empl_id=? AND id=?";
        $query = $this->db->query($sql, array($certificate_name, $issuer, $issued_on, $expires_on, $employee_id, $education_id));
    }

    function MOD_DLT_LICENSE($license_id)
    {
        $sql = "DELETE FROM tbl_pers_lice WHERE id = ?";
        $query = $this->db->query($sql, array($license_id));
    }

    function MOD_GET_LICENSE_DATA($license_id)
    {
        $sql = "SELECT * FROM tbl_pers_lice WHERE id=?";
        $query = $this->db->query($sql, array($license_id));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ASSET_INFO($asset_id)
    {
        $sql = "SELECT * FROM tbl_asset_assign WHERE id=?";
        $query = $this->db->query($sql, array($asset_id));
        $query->next_result();
        return $query->result();
    }

    function MOD_INSRT_ASSET_LOGS($assign_to, $user_id, $issued_on, $asset_id)
    {
        $sql = "INSERT INTO tbl_asset_logs (col_assign_to,col_assign_by,col_issued_on,col_asset_item) VALUES (?,?,?,?)";
        $query = $this->db->query($sql, array($assign_to, $user_id, $issued_on, $asset_id));
        return $this->db->insert_id();
    }

    function MOD_UPDT_ASSET_STATUS_TRANSFER($assign_to, $issued_on, $user_id, $asset_id)
    {
        $sql = "UPDATE tbl_asset_assign SET col_asset_assigned_to=?,col_asset_assigned_by=?,col_asset_issued_on=?,col_asset_status=? WHERE id=?";
        $query = $this->db->query($sql, array($assign_to, $user_id, $issued_on, 'in-use', $asset_id));
    }

    function MOD_UPDT_ASSET_LOGS($issued_on_key, $asset_id, $assign_to)
    {
        $sql = "UPDATE tbl_asset_logs SET col_returned_on=? WHERE col_issued_on=? AND col_asset_item=? AND col_assign_to=?";
        $query = $this->db->query($sql, array(date('Y-m-d'), $issued_on_key, $asset_id, $assign_to));
    }

    function GET_LEAVE_ASSIGN($id)
    {
        $this->db->select('tb1.*');
        $this->db->select('CONCAT(tb2.col_last_name,IF(tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> "", CONCAT(" ",tb2.col_suffix, ""), ""), ", ",
        tb2.col_frst_name, " ",IF(tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> "", CONCAT(LEFT(tb2.col_midl_name, 1), "."), "")) as employee', false);
        $this->db->from('tbl_leaves_assign as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
        // $sql = "SELECT * FROM tbl_leaves_assign WHERE id=? ";
        // $query = $this->db->query($sql, array($id));
        // $query->next_result();
        // return $query->row();
    }


    function GET_LEAVE_APPROVERS($id)
    {
        $this->db->select('tb1.*');
        $this->db->select('CONCAT(tb2.col_last_name,IF(tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> "", CONCAT(" ",tb2.col_suffix, ""), ""), ", ",
        tb2.col_frst_name, " ",IF(tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> "", CONCAT(LEFT(tb2.col_midl_name, 1), "."), "")) as employee', false);
        $this->db->from('tbl_leaves_assign as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
        // $sql = "SELECT * FROM tbl_leaves_assign WHERE id=? ";
        // $query = $this->db->query($sql, array($id));
        // $query->next_result();
        // return $query->row();
    }


    function GET_OVERTIME_APPROVERS($id)
    {
        $this->db->select('tb1.*');
        $this->db->select('CONCAT(tb2.col_last_name,IF(tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> "", CONCAT(" ",tb2.col_suffix, ""), ""), ", ",
        tb2.col_frst_name, " ",IF(tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> "", CONCAT(LEFT(tb2.col_midl_name, 1), "."), "")) as employee', false);
        $this->db->from('tbl_approvers_ot as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function GET_SHIFT_REQUEST($id)
    {
        $this->db->select('tb1.*');
        $this->db->select('CONCAT(tb2.col_last_name,IF(tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> "", CONCAT(" ",tb2.col_suffix, ""), ""), ", ",
        tb2.col_frst_name, " ",IF(tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> "", CONCAT(LEFT(tb2.col_midl_name, 1), "."), "")) as employee', false);
        $this->db->from('tbl_attendance_shiftassign as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
    }
    function GET_OFFSET_ASSIGN($id)
    {
        $sql = "SELECT * FROM tbl_attendance_offsets WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->row();
    }
    function GET_ACQUIRE_OFFSET_ASSIGN($id)
    {
        $sql = "SELECT * FROM tbl_attendance_offsets_acquire WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->row();
    }
    function GET_OVERTIME_ASSIGN($id)
    {
        $this->db->select('tb1.*');
        $this->db->select('CONCAT(tb2.col_last_name,IF(tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> "", CONCAT(" ",tb2.col_suffix, ""), ""), ", ",
        tb2.col_frst_name, " ",IF(tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> "", CONCAT(LEFT(tb2.col_midl_name, 1), "."), "")) as employee', false);
        $this->db->from('tbl_overtimes as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
        // $sql = "SELECT * FROM tbl_overtimes WHERE id=?";
        // $query = $this->db->query($sql, array($id));
        // $query->next_result();
        // return $query->row();
    }

    function GET_HOLIDAYWORK_ASSIGN($id)
    {
        $this->db->select('tb1.*');
        $this->db->select('CONCAT(tb2.col_last_name,IF(tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> "", CONCAT(" ",tb2.col_suffix, ""), ""), ", ",
        tb2.col_frst_name, " ",IF(tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> "", CONCAT(LEFT(tb2.col_midl_name, 1), "."), "")) as employee', false);
        $this->db->from('tbl_holidaywork as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
        // $sql = "SELECT * FROM tbl_holidaywork WHERE id=? ";
        // $query = $this->db->query($sql, array($id));
        // $query->next_result();
        // return $query->row();
    }


    function GET_OVERTIME_APPROVALS($userId, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team)
    {
        $filter_q = "";

        // Apply department filter
        if (!empty($dept) && $dept !== "undefined") {
            $filter_q .= " AND tb2.col_empl_dept=" . $this->db->escape($dept);
        }

        // Apply section filter
        if (!empty($sec) && $sec !== "undefined") {
            $filter_q .= " AND tb2.col_empl_sect=" . $this->db->escape($sec);
        }

        // Apply group filter
        if (!empty($group) && $group !== "undefined") {
            $filter_q .= " AND tb2.col_empl_group=" . $this->db->escape($group);
        }

        // Apply line filter
        if (!empty($line) && $line !== "undefined") {
            $filter_q .= " AND tb2.col_empl_line=" . $this->db->escape($line);
        }

        // Apply branch filter
        if (!empty($branch) && $branch !== "undefined") {
            $filter_q .= " AND tb2.col_empl_branch=" . $this->db->escape($branch);
        }

        // Apply division filter
        if (!empty($division) && $division !== "undefined") {
            $filter_q .= " AND tb2.col_empl_divi=" . $this->db->escape($division);
        }

        // Apply team filter
        if (!empty($team) && $team !== "undefined") {
            $filter_q .= " AND tb2.col_empl_team=" . $this->db->escape($team);
        }

        // Query with filters
        $sql = "SELECT *, tb1.empl_id as empl_id, tb1.id as id FROM tbl_overtimes as tb1
                LEFT JOIN tbl_employee_infos as tb2 ON tb1.empl_id=tb2.id
                WHERE tb1.status LIKE '%Pending%' $filter_q
                AND (
                    ((tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND tb1.status = 'Pending 1') OR
                    ((tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND tb1.status = 'Pending 2') OR
                    ((tb1.approver3 = $userId OR tb1.approver3_b = $userId) AND tb1.status = 'Pending 3') OR
                    ((tb1.approver4 = $userId OR tb1.approver4_b = $userId) AND tb1.status = 'Pending 4') OR
                    ((tb1.approver5 = $userId OR tb1.approver5_b = $userId) AND tb1.status = 'Pending 5')
                )
                ORDER BY tb1.id DESC
                LIMIT $offset, $row";

        $query = $this->db->query($sql);
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

        $sql = "SELECT tb1.* FROM tbl_attendance_changeshift AS tb1
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tb1.empl_id
        WHERE tb1.status LIKE '%Pending%' " . $filter_q . " 

        AND ( (( tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND approver1_date = '0000-00-00 00:00:00') OR 
        ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver1_date!='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00') OR
        ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver1_date='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00')
        )
        
        ORDER BY tb1.id DESC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_CHANGEOFF_APPROVALS($userId, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $clubhouse, $division, $team)
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

        $sql = "SELECT tb1.* FROM tbl_attendance_changeoff AS tb1
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tb1.empl_id
        WHERE tb1.status LIKE '%Pending%' " . $filter_q . " 

        AND ( (( tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND approver1_date = '0000-00-00 00:00:00') OR 
        ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver1_date!='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00') OR
        ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver1_date='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00')
        )
        
        ORDER BY tb1.id DESC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_OVERTIME_APPROVALS($userId, $company, $dept, $sec, $group, $line, $branch, $division, $team)
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
        if ($team && $team !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }

        $sql = "SELECT *, tb1.empl_id as empl_id, tb1.id as id FROM tbl_overtimes AS tb1
        JOIN tbl_approvers_ot ON tbl_approvers_ot.empl_id = tb1.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tb1.empl_id

        WHERE tb1.status LIKE '%Pending%' " . $filter_q . " 
         AND ( ((tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND tb1.status = 'Pending 1') OR
        ((tb1.approver2 = $userId OR tb1.approver2_b = $userId)  AND tb1.status = 'Pending 2') OR
        ((tb1.approver3 = $userId OR tb1.approver3_b = $userId)  AND tb1.status = 'Pending 3') OR
        ((tb1.approver4 = $userId OR tb1.approver4_b = $userId)  AND tb1.status = 'Pending 4') OR
        ((tb1.approver5 = $userId OR tb1.approver5_b = $userId)  AND tb1.status = 'Pending 5')
        )

        ORDER BY tb1.id DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    // function GET_OFFSET_APPROVALS($userId, $offset, $row, $dept, $sec, $group, $line, $branch, $division, $team)
    // {

    //     $filter_q = "";

    //     if ($dept) {
    //         $filter_q .= " AND tbl_employee_infos.col_empl_dept=" . $dept;
    //     }
    //     if ($sec) {
    //         $filter_q .= " AND tbl_employee_infos.col_empl_sect=" . $sec;
    //     }
    //     if ($group) {
    //         $filter_q .= " AND tbl_employee_infos.col_empl_group=" . $group;
    //     }
    //     if ($line) {
    //         $filter_q .= " AND tbl_employee_infos.col_empl_line=" . $line;
    //     }
    //     if ($branch) {
    //         $filter_q .= " AND tbl_employee_infos.col_empl_branch=" . $branch;
    //     }
    //     if ($division) {
    //         $filter_q .= " AND tbl_employee_infos.col_empl_divi=" . $division;
    //     }
    //     if ($team) {
    //         $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
    //     }
    //     $sql = "SELECT tbl_attendance_offsets.* FROM tbl_attendance_offsets
    //     JOIN tbl_approvers_offset ON tbl_attendance_offsets.empl_id=tbl_approvers_offset.empl_id
    //     JOIN tbl_employee_infos ON tbl_attendance_offsets.empl_id=tbl_employee_infos.id
    //     WHERE tbl_attendance_offsets.status LIKE '%Pending%' " . $filter_q . " 
    //     AND ((approver_1a = $userId AND approver1 = 0) OR (approver_2a = $userId AND (approver2 = 0 AND approver1 !=0)) OR (approver_3a = $userId  AND (approver3 = 0 AND approver1 !=0 AND approver2 !=0) ))

    //     ORDER BY tbl_attendance_offsets.create_date DESC
    //     LIMIT " . $offset . ", " . $row . " ";
    //     $query = $this->db->query($sql, array());
    //     $query->next_result();
    //     return $query->result();
    // }

    function GET_OFFSET_APPROVALS($userId, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team)
    {

        $filter_q = "";

        if ($company && $company !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_company=" . $company;
        }
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
        if ($team && $team !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }
        $sql = "SELECT tb1.* FROM tbl_attendance_offsets as tb1
        LEFT JOIN tbl_employee_infos ON tb1.empl_id=tbl_employee_infos.id
        WHERE tb1.status LIKE '%Pending%' " . $filter_q . " 
    
        AND ( (( tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND approver1_date = '0000-00-00 00:00:00') OR 
            ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver1_date!='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00') OR
            ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver1_date='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00')
            )

        ORDER BY tb1.create_date DESC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_OFFSET_APPROVALS_COUNT($userId, $company, $dept, $sec, $group, $line, $branch, $division, $team)
    {

        $filter_q = "";

        if ($company && $company !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_company=" . $company;
        }
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
        if ($team && $team !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }
        $sql = "SELECT tb1.* FROM tbl_attendance_offsets as tb1
        LEFT JOIN tbl_employee_infos ON tb1.empl_id=tbl_employee_infos.id
        WHERE tb1.status LIKE '%Pending%' " . $filter_q . " 
    
        AND ( (( tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND approver1_date = '0000-00-00 00:00:00') OR 
            ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver1_date!='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00') OR
            ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver1_date='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00')
            )

        ORDER BY tb1.create_date DESC ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }


    function GET_ACQUIRE_OFFSET_APPROVALS($userId, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team)
    {
        $filter_q = "";

        if ($company && $company !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_company=" . $company;
        }
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
        if ($team && $team !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }
        $sql = "SELECT tb1.* FROM tbl_attendance_offsets_acquire as tb1
        LEFT JOIN tbl_employee_infos ON tb1.empl_id=tbl_employee_infos.id
        WHERE tb1.status LIKE '%Pending%' " . $filter_q . " 
    
        AND ( (( tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND approver1_date = '0000-00-00 00:00:00') OR 
        ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver2_date='0000-00-00 00:00:00') OR
        ( (tb1.approver3 = $userId OR tb1.approver3_b = $userId) AND approver3_date='0000-00-00 00:00:00')
        )
        
        ORDER BY tb1.create_date DESC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();

        // AND ( (( tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND approver1_date = '0000-00-00 00:00:00') OR 
        // ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver1_date!='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00') OR
        // ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver1_date='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00')
        // )
    }

    function GET_ACQUIRE_OFFSET_APPROVALS_COUNT($userId, $company, $dept, $sec, $group, $line, $branch, $division, $team)
    {
        $filter_q = "";

        if ($company && $company !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_company=" . $company;
        }
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
        if ($team && $team !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }
        $sql = "SELECT tb1.* FROM tbl_attendance_offsets_acquire as tb1
        LEFT JOIN tbl_employee_infos ON tb1.empl_id=tbl_employee_infos.id
        WHERE tb1.status LIKE '%Pending%' " . $filter_q . " 
    
        AND ( (( tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND approver1_date = '0000-00-00 00:00:00') OR 
        ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver2_date='0000-00-00 00:00:00') OR
        ( (tb1.approver3 = $userId OR tb1.approver3_b = $userId) AND approver3_date='0000-00-00 00:00:00')
        )
        
        ORDER BY tb1.create_date DESC ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();

        // AND ( (( tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND approver1_date = '0000-00-00 00:00:00') OR 
        // ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver1_date!='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00') OR
        // ( (tb1.approver2 = $userId OR tb1.approver2_b = $userId) AND approver1_date='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00')
        // )
    }

    function GET_LEAVE_APPROVALS($userId, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team)
    {
        // var_dump($userId);

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
        if ($team && $team !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }
        // AND ((approver_1a = $userId AND approver1 = 0) OR (approver_2a = $userId AND (approver2 = 0 AND approver1 !=0)) OR (approver_3a = $userId  AND (approver3 = 0 AND approver1 !=0 AND approver2 !=0) ))

        $sql = "SELECT tb1.* FROM tbl_leaves_assign as tb1
        LEFT JOIN tbl_employee_infos ON tb1.empl_id=tbl_employee_infos.id
        WHERE  (tb1.parent_id is null or tb1.parent_id = 0) AND tb1.status LIKE '%Pending%' " . $filter_q . "
 
        AND ( ((tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND tb1.status = 'Pending 1') OR
        ((tb1.approver2 = $userId OR tb1.approver2_b = $userId)  AND tb1.status = 'Pending 2') OR
        ((tb1.approver3 = $userId OR tb1.approver3_b = $userId)  AND tb1.status = 'Pending 3') OR
        ((tb1.approver4 = $userId OR tb1.approver4_b = $userId)  AND tb1.status = 'Pending 4') OR
        ((tb1.approver5 = $userId OR tb1.approver5_b = $userId)  AND tb1.status = 'Pending 5')
        )
 
        ORDER BY tb1.create_date DESC
        LIMIT " . $offset . ", " . $row . " ";



        $query = $this->db->query($sql, array($userId));
        $query->next_result();
        return $query->result();
    }


    function GET_LEAVE_APPROVALS_COUNT($userId, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team)
    {
        // var_dump($userId);

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
        if ($team && $team !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }
        // AND ((approver_1a = $userId AND approver1 = 0) OR (approver_2a = $userId AND (approver2 = 0 AND approver1 !=0)) OR (approver_3a = $userId  AND (approver3 = 0 AND approver1 !=0 AND approver2 !=0) ))

        $sql = "SELECT tb1.* FROM tbl_leaves_assign as tb1
        LEFT JOIN tbl_employee_infos ON tb1.empl_id=tbl_employee_infos.id
        WHERE  (tb1.parent_id is null or tb1.parent_id = 0) AND tb1.status LIKE '%Pending%' " . $filter_q . " 

       AND ( ((tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND tb1.status = 'Pending 1') OR
        ((tb1.approver2 = $userId OR tb1.approver2_b = $userId)  AND tb1.status = 'Pending 2') OR
        ((tb1.approver3 = $userId OR tb1.approver3_b = $userId)  AND tb1.status = 'Pending 3') OR
        ((tb1.approver4 = $userId OR tb1.approver4_b = $userId)  AND tb1.status = 'Pending 4') OR
        ((tb1.approver5 = $userId OR tb1.approver5_b = $userId)  AND tb1.status = 'Pending 5')
        )

        ORDER BY tb1.create_date DESC ";

        $query = $this->db->query($sql, array($userId));
        $query->next_result();
        return $query->result();
    }



    function GET_EXEMPTUT_APPROVALS($userId, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team)
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
        if ($team && $team !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }

        $sql = "SELECT *, tbl_attendance_undertimerequest.empl_id as empl_id, tbl_attendance_undertimerequest.id as id FROM tbl_attendance_undertimerequest
        JOIN tbl_approvers_leave ON tbl_approvers_leave.empl_id = tbl_attendance_undertimerequest.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_attendance_undertimerequest.empl_id
        WHERE tbl_attendance_undertimerequest.status LIKE '%Pending%' " . $filter_q . " 
         AND (( approver1 = $userId AND approver1_date='0000-00-00 00:00:00') OR  
        (approver2=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00'  ) OR
        (approver3=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date!='0000-00-00 00:00:00' AND approver3_date='0000-00-00 00:00:00'  ) OR
        (approver4=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date!='0000-00-00 00:00:00' AND approver3_date!='0000-00-00 00:00:00' AND approver4_date='0000-00-00 00:00:00'  ) OR
        (approver5=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date!='0000-00-00 00:00:00' AND approver3_date!='0000-00-00 00:00:00' AND approver4_date!='0000-00-00 00:00:00' AND approver5_date='0000-00-00 00:00:00'   )
        )
        ORDER BY tbl_attendance_undertimerequest.id DESC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_NURSE_APPROVALS($userId, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team)
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
        if ($team && $team !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }
        // AND ((approver_1a = $userId AND approver1 = 0) OR (approver_2a = $userId AND (approver2 = 0 AND approver1 !=0)) OR (approver_3a = $userId  AND (approver3 = 0 AND approver1 !=0 AND approver2 !=0) ))

        $sql = "SELECT * FROM tbl_leaves_assign
        WHERE status = 'Nurse' ORDER BY create_date DESC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_SHIFT_APPROVALS($userId, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team)
    {
        // $filter_q = "";

        // if ($dept && $dept !== "undefined") {
        //     $filter_q .= " AND tbl_employee_infos.col_empl_dept=" . $dept;
        // }
        // if ($sec && $sec !== "undefined") {
        //     $filter_q .= " AND tbl_employee_infos.col_empl_sect=" . $sec;
        // }
        // if ($group && $group !== "undefined") {
        //     $filter_q .= " AND tbl_employee_infos.col_empl_group=" . $group;
        // }
        // if ($line && $line !== "undefined") {
        //     $filter_q .= " AND tbl_employee_infos.col_empl_line=" . $line;
        // }
        // if ($branch && $branch !== "undefined") {
        //     $filter_q .= " AND tbl_employee_infos.col_empl_branch=" . $branch;
        // }
        // if ($division && $division !== "undefined") {
        //     $filter_q .= " AND tbl_employee_infos.col_empl_divi=" . $division;
        // }
        // if ($team && $team !== "undefined") {
        //     $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        // }

        $sql = "SELECT *, tbl_attendance_shiftassign_approval.status as status, tbl_attendance_shiftassign_approval.id as id FROM tbl_attendance_shiftassign_approval
        LEFT JOIN tbl_approvers_shift ON tbl_attendance_shiftassign_approval.empl_id=tbl_approvers_shift.empl_id
        LEFT JOIN tbl_payroll_period ON tbl_attendance_shiftassign_approval.cutoff_period=tbl_payroll_period.id
        WHERE   (tbl_attendance_shiftassign_approval.status LIKE '%Pending%' OR tbl_attendance_shiftassign_approval.status LIKE '%Checked%' OR tbl_attendance_shiftassign_approval.status LIKE '%Approved%' OR tbl_attendance_shiftassign_approval.status LIKE '%Rejected%')

        AND (( checked_by = $userId) OR ( noted_by = $userId))
        
        ORDER BY tbl_attendance_shiftassign_approval.create_date DESC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();

        // AND (( checked_by = $userId) OR ( noted_by = $userId))

        // AND (( checked_by = $userId AND approver_date1='0000-00-00 00:00:00') OR 
        // ( noted_by = $userId AND approver_date1!='0000-00-00 00:00:00' AND approver_date2='0000-00-00 00:00:00') OR
        // ( noted_by = $userId AND approver_date1='0000-00-00 00:00:00' AND approver_date2='0000-00-00 00:00:00')
        // )
    }

    function GET_SHIFT_APPROVALS_COUNT($userId, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team)
    {
        // $filter_q = "";

        // if ($dept && $dept !== "undefined") {
        //     $filter_q .= " AND tbl_employee_infos.col_empl_dept=" . $dept;
        // }
        // if ($sec && $sec !== "undefined") {
        //     $filter_q .= " AND tbl_employee_infos.col_empl_sect=" . $sec;
        // }
        // if ($group && $group !== "undefined") {
        //     $filter_q .= " AND tbl_employee_infos.col_empl_group=" . $group;
        // }
        // if ($line && $line !== "undefined") {
        //     $filter_q .= " AND tbl_employee_infos.col_empl_line=" . $line;
        // }
        // if ($branch && $branch !== "undefined") {
        //     $filter_q .= " AND tbl_employee_infos.col_empl_branch=" . $branch;
        // }
        // if ($division && $division !== "undefined") {
        //     $filter_q .= " AND tbl_employee_infos.col_empl_divi=" . $division;
        // }
        // if ($team && $team !== "undefined") {
        //     $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        // }

        $sql = "SELECT *, tbl_attendance_shiftassign_approval.status as status, tbl_attendance_shiftassign_approval.id as id FROM tbl_attendance_shiftassign_approval
        LEFT JOIN tbl_approvers_shift ON tbl_attendance_shiftassign_approval.empl_id=tbl_approvers_shift.empl_id
        LEFT JOIN tbl_payroll_period ON tbl_attendance_shiftassign_approval.cutoff_period=tbl_payroll_period.id
        WHERE   (tbl_attendance_shiftassign_approval.status LIKE '%Pending%' OR tbl_attendance_shiftassign_approval.status LIKE '%Checked%' OR tbl_attendance_shiftassign_approval.status LIKE '%Approved%' OR tbl_attendance_shiftassign_approval.status LIKE '%Rejected%')
     
        AND (( checked_by = $userId) OR ( noted_by = $userId))
        
        ORDER BY tbl_attendance_shiftassign_approval.create_date DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEELIST_DATA($empl_id)
    {

        $sql = "SELECT DISTINCT tbl_employee_infos.id,col_empl_cmid, 
            CONCAT_WS('',COALESCE(col_empl_cmid, ''), 
            CASE WHEN col_last_name IS NOT NULL AND col_last_name != '' THEN CONCAT('-', col_last_name) ELSE '' END,
            CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
            CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
            CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS full_name
        FROM tbl_employee_infos 
        LEFT JOIN tbl_attendance_shiftassign_approval ON tbl_employee_infos.id = tbl_attendance_shiftassign_approval.empl_id
        LEFT JOIN tbl_approvers_shift ON tbl_attendance_shiftassign_approval.empl_id=tbl_approvers_shift.empl_id
        WHERE (tbl_attendance_shiftassign_approval.status LIKE '%Pending%' OR tbl_attendance_shiftassign_approval.status LIKE '%Checked%' OR tbl_attendance_shiftassign_approval.status LIKE '%Approved%') AND 
        (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 AND (( checked_by = $empl_id) OR ( noted_by = $empl_id))";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_FILTERED_EMPLOYEELIST_DATA($empl_id)
    {

        $sql = "SELECT id,col_empl_cmid, 
            CONCAT_WS('',COALESCE(col_empl_cmid, ''), 
            CASE WHEN col_last_name IS NOT NULL AND col_last_name != '' THEN CONCAT('-', col_last_name) ELSE '' END,
            CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
            CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
            CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS full_name
        FROM tbl_employee_infos WHERE id=? AND (termination_date IS NULL OR termination_date = '0000-00-00') AND disabled=0 ";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }

    function update_shift_approval($data_id, $status, $editUser)
    {
        $datetime                   = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_shiftassign_approval SET edit_date=? ,edit_user=?, status=?, approver1=?, approver_date1=? WHERE id=?";
        $this->db->query($sql, array($datetime, $editUser, $status,  $editUser, $datetime, $data_id));
    }

    function NURSE_APPROVELEAVE($leaveid)
    {
        $sql = "UPDATE tbl_leaves_assign SET status ='Pending 1' WHERE id=$leaveid";
        $this->db->query($sql);
    }


    function NURSE_REJECTLEAVE($leaveid)
    {
        $sql = "UPDATE tbl_leaves_assign SET status = 'Rejected', reason = 'Nurse Reject' WHERE id=$leaveid";
        $this->db->query($sql);
    }

    function GET_EXEMPTUT_DATA($id)
    {
        $sql = "SELECT * FROM tbl_attendance_undertimerequest WHERE id=$id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result[0];
    }
    function GET_CHANGESHIFT_DATA($id)
    {
        $sql = "SELECT * FROM tbl_attendance_changeshift WHERE id=$id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result[0];
    }

    function GET_CHANGEOFF_DATA($id)
    {
        $sql = "SELECT * FROM tbl_attendance_changeoff WHERE id=$id";
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

    function CHANGEOFF_APPROVAL($changeoff_id, $next_status, $approverdate)
    {
        $datetime                   = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_changeoff SET status ='$next_status', $approverdate = '$datetime' WHERE id= '$changeoff_id'";
        $this->db->query($sql);
    }

    function GET_CHANGED_SHIFT($changeshift_id)
    {
        $sql_change = "SELECT * FROM tbl_attendance_changeshift WHERE id=?";
        $query = $this->db->query($sql_change, array($changeshift_id));
        $result = $query->row();
        return $result;
    }

    function GET_CHANGED_OFF($changeoff_id)
    {
        $sql_change = "SELECT * FROM tbl_attendance_changeoff WHERE id=?";
        $query = $this->db->query($sql_change, array($changeoff_id));
        $result = $query->row();
        return $result;
    }

    function EXEMPTUT_APPROVE($exemptut_id, $next_status, $approverdate)
    {
        $datetime                   = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_attendance_undertimerequest SET status ='$next_status', $approverdate = '$datetime' WHERE id= '$exemptut_id'";
        $this->db->query($sql);
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


    function is_duplicate_data($user_id, $date)
    {
        $sql = "SELECT id FROM tbl_attendance_shiftassign WHERE empl_id=? AND date=?";
        $query = $this->db->query($sql, array($user_id, $date));
        return $query->num_rows();
    }

    function transfer_data_to_main_attendance_assign($empl_id, $date_from, $date_to, $editUser)
    {
        $sql = "SELECT empl_id,date,shift_id,lock_shift FROM tbl_attendance_shiftassign_temp WHERE empl_id=? AND date >= ? AND date <= ? AND is_deleted=0";
        $query = $this->db->query($sql, array($empl_id, $date_from, $date_to, $editUser));

        $results = $query->result();

        if ($results) {
            foreach ($results as $result) {
                $datetime           = date('Y-m-d H:i:s');
                $is_duplicate       = $this->is_duplicate_data($result->empl_id, $result->date);
                if ($is_duplicate > 0) {
                    $sql = " UPDATE tbl_attendance_shiftassign SET edit_date=?, shift_id=? WHERE empl_id=? AND date=?";
                    $this->db->query($sql, array($datetime, $result->shift_id, $result->empl_id, $result->date));
                } else {
                    $sql = "INSERT INTO tbl_attendance_shiftassign (create_date,edit_date,edit_user,is_deleted,empl_id,date,shift_id) VALUES(?,?,?,?,?,?,?)";
                    $this->db->query($sql, array($datetime, $datetime, $editUser, 0, $result->empl_id, $result->date, $result->shift_id));
                }
            }
        }
    }



    function GET_NURSE_APPROVALS_COUNT($userId, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team)
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
        if ($team && $team !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }
        // AND ((approver_1a = $userId AND approver1 = 0) OR (approver_2a = $userId AND (approver2 = 0 AND approver1 !=0)) OR (approver_3a = $userId  AND (approver3 = 0 AND approver1 !=0 AND approver2 !=0) ))
        $sql = "SELECT tbl_leaves_assign.* FROM tbl_leaves_assign
        JOIN tbl_approvers_leave ON tbl_leaves_assign.empl_id=tbl_approvers_leave.empl_id
        JOIN tbl_employee_infos ON tbl_leaves_assign.empl_id=tbl_employee_infos.id
        WHERE (tbl_leaves_assign.parent_id is null or tbl_leaves_assign.parent_id = 0) AND tbl_leaves_assign.status LIKE '%Pending%' " . $filter_q . " 
        
        AND (( approver1 = $userId AND approver1_date='0000-00-00 00:00:00') OR  
        (approver2=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00'  ) OR
        (approver3=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date!='0000-00-00 00:00:00' AND approver3_date='0000-00-00 00:00:00'  ) OR
        (approver4=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date!='0000-00-00 00:00:00' AND approver3_date!='0000-00-00 00:00:00' AND approver4_date='0000-00-00 00:00:00'  ) OR
        (approver5=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date!='0000-00-00 00:00:00' AND approver3_date!='0000-00-00 00:00:00' AND approver4_date!='0000-00-00 00:00:00' AND approver5_date='0000-00-00 00:00:00'   )
        )
        ORDER BY tbl_leaves_assign.create_date DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_OFFSET_APPROVALS($userId, $dept, $sec, $group, $line, $branch, $division, $team)
    {
        $filter_q = "";
        if ($dept) {
            $filter_q .= " AND tbl_employee_infos.col_empl_dept=" . $dept;
        }
        if ($sec) {
            $filter_q .= " AND tbl_employee_infos.col_empl_sect=" . $sec;
        }
        if ($group) {
            $filter_q .= " AND tbl_employee_infos.col_empl_group=" . $group;
        }
        if ($line) {
            $filter_q .= " AND tbl_employee_infos.col_empl_line=" . $line;
        }
        if ($branch) {
            $filter_q .= " AND tbl_employee_infos.col_empl_branch=" . $branch;
        }
        if ($division) {
            $filter_q .= " AND tbl_employee_infos.col_empl_divi=" . $division;
        }
        if ($team) {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }
        $sql = "SELECT *, tbl_attendance_offsets.empl_id as empl_id, tbl_attendance_offsets.id as id FROM tbl_attendance_offsets
        JOIN tbl_approvers_offset ON tbl_approvers_offset.empl_id = tbl_attendance_offsets.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_attendance_offsets.empl_id
        WHERE tbl_attendance_offsets.status LIKE '%Pending%' " . $filter_q . " 
        AND ((approver_1a = $userId AND approver1 = 0) OR (approver_2a = $userId AND (approver2 = 0 AND approver1 !=0)) OR (approver_3a = $userId  AND (approver3 = 0 AND approver1 !=0 AND approver2 !=0 ))) 
        ORDER BY tbl_attendance_offsets.create_date DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_COUNT_LEAVE_APPROVALS($userId, $dept, $sec, $group, $line, $branch, $division, $team)
    {
        $filter_q = "";
        if ($dept) {
            $filter_q .= " AND tbl_employee_infos.col_empl_dept=" . $dept;
        }
        if ($sec) {
            $filter_q .= " AND tbl_employee_infos.col_empl_sect=" . $sec;
        }
        if ($group) {
            $filter_q .= " AND tbl_employee_infos.col_empl_group=" . $group;
        }
        if ($line) {
            $filter_q .= " AND tbl_employee_infos.col_empl_line=" . $line;
        }
        if ($branch) {
            $filter_q .= " AND tbl_employee_infos.col_empl_branch=" . $branch;
        }
        if ($division) {
            $filter_q .= " AND tbl_employee_infos.col_empl_divi=" . $division;
        }
        if ($team) {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }
        $sql = "SELECT *, tbl_leaves_assign.empl_id as empl_id, tbl_leaves_assign.id as id FROM tbl_leaves_assign
        JOIN tbl_approvers_leave ON tbl_approvers_leave.empl_id = tbl_leaves_assign.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_leaves_assign.empl_id
        WHERE tbl_leaves_assign.status LIKE '%Pending%' " . $filter_q . " 
        AND (( approver1 = $userId AND approver1_date='0000-00-00 00:00:00') OR  
        (approver2=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00'  ) OR
        (approver3=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date!='0000-00-00 00:00:00' AND approver3_date='0000-00-00 00:00:00'  ) OR
        (approver4=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date!='0000-00-00 00:00:00' AND approver3_date!='0000-00-00 00:00:00' AND approver4_date='0000-00-00 00:00:00'  ) OR
        (approver5=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date!='0000-00-00 00:00:00' AND approver3_date!='0000-00-00 00:00:00' AND approver4_date!='0000-00-00 00:00:00' AND approver5_date='0000-00-00 00:00:00'   )
        )
        ORDER BY tbl_leaves_assign.create_date DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_HOLIDAYWORK_APPROVALS_COUNT($userId, $empl_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team)
    {
        $filter_q = "";
        if ($empl_id && $empl_id !== 'undefined') {
            $filter_q .= "AND tbl_holidaywork.empl_id='$empl_id'";
        }
        if ($dept && $dept !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_dept=" . $dept;
        }
        if ($sec && $sec !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_sect=" . $sec;
        }
        if ($group && $group !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_group=" . $group;
        }
        if ($line && $line !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_line=" . $line;
        }
        if ($branch && $branch !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_branch=" . $branch;
        }
        if ($division && $division !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_divi=" . $division;
        }
        if ($team && $team !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }

        $sql = "SELECT *, tb1.empl_id as empl_id, tb1.id as id FROM tbl_holidaywork AS tb1
        JOIN tbl_approvers_ot ON tbl_approvers_ot.empl_id = tb1.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tb1.empl_id
        WHERE tb1.status LIKE '%Pending%' " . $filter_q . " 

        AND ( ((tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND tb1.status = 'Pending 1') OR
        ((tb1.approver2 = $userId OR tb1.approver2_b = $userId)  AND tb1.status = 'Pending 2') OR
        ((tb1.approver3 = $userId OR tb1.approver3_b = $userId)  AND tb1.status = 'Pending 3') OR
        ((tb1.approver4 = $userId OR tb1.approver4_b = $userId)  AND tb1.status = 'Pending 4') OR
        ((tb1.approver5 = $userId OR tb1.approver5_b = $userId)  AND tb1.status = 'Pending 5')
        )

        ORDER BY tb1.create_date DESC ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_HOLIDAYWORK_APPROVALS($userId, $empl_id, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team)
    {
        $filter_q = "";
        if ($empl_id && $empl_id !== 'undefined') {
            $filter_q .= "AND tbl_holidaywork.empl_id='$empl_id'";
        }
        if ($dept && $dept !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_dept=" . $dept;
        }
        if ($sec && $sec !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_sect=" . $sec;
        }
        if ($group && $group !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_group=" . $group;
        }
        if ($line && $line !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_line=" . $line;
        }
        if ($branch && $branch !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_branch=" . $branch;
        }
        if ($division && $division !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_divi=" . $division;
        }
        if ($team && $team !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }

        $sql = "SELECT *, tb1.empl_id as empl_id, tb1.id as id FROM tbl_holidaywork AS tb1
        JOIN tbl_approvers_ot ON tbl_approvers_ot.empl_id = tb1.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tb1.empl_id
        WHERE tb1.status LIKE '%Pending%' " . $filter_q . " 

         AND ( ((tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND tb1.status = 'Pending 1') OR
        ((tb1.approver2 = $userId OR tb1.approver2_b = $userId)  AND tb1.status = 'Pending 2') OR
        ((tb1.approver3 = $userId OR tb1.approver3_b = $userId)  AND tb1.status = 'Pending 3') OR
        ((tb1.approver4 = $userId OR tb1.approver4_b = $userId)  AND tb1.status = 'Pending 4') OR
        ((tb1.approver5 = $userId OR tb1.approver5_b = $userId)  AND tb1.status = 'Pending 5')
        )

        ORDER BY tb1.create_date DESC 
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_HOLIDAYWORK_APPROVALS($userId, $empl_id, $dept, $sec, $group, $line, $branch, $division, $team)
    {
        $filter_q = "";
        if ($empl_id && $empl_id !== 'undefined') {
            $filter_q .= "AND tbl_holidaywork.empl_id='$empl_id'";
        }
        if ($dept && $dept !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_dept=" . $dept;
        }
        if ($sec && $sec !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_sect=" . $sec;
        }
        if ($group && $group !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_group=" . $group;
        }
        if ($line && $line !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_line=" . $line;
        }
        if ($branch && $branch !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_branch=" . $branch;
        }
        if ($division && $division !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_divi=" . $division;
        }
        if ($team && $team !== 'undefined') {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }

        $sql = "SELECT *, tbl_holidaywork.empl_id as empl_id, tbl_holidaywork.id as id FROM tbl_holidaywork
        JOIN tbl_approvers_ot ON tbl_approvers_ot.empl_id = tbl_holidaywork.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_holidaywork.empl_id
        WHERE tbl_holidaywork.status LIKE '%Pending%' " . $filter_q . " 

        AND (( approver1 = $userId AND approver1_date='0000-00-00 00:00:00') OR  
        (approver2=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00'  ) OR
        (approver3=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date!='0000-00-00 00:00:00' AND approver3_date='0000-00-00 00:00:00'  ) OR
        (approver4=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date!='0000-00-00 00:00:00' AND approver3_date!='0000-00-00 00:00:00' AND approver4_date='0000-00-00 00:00:00'  ) OR
        (approver5=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date!='0000-00-00 00:00:00' AND approver3_date!='0000-00-00 00:00:00' AND approver4_date!='0000-00-00 00:00:00' AND approver5_date='0000-00-00 00:00:00'   )
        ) 
        
        ORDER BY tbl_holidaywork.create_date DESC ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_TIME_ADJ($id)
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
    function UPDATE_TIME_ADJ($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_attendance_adjustments', $data);
    }

    function GET_TIME_ADJUSTMENT_APPROVALS($userId, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team)
    {

        $filter_q = '';
        if ($company && $company !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_company=" . $company;
        }
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
        if ($team && $team !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }

        $sql = "SELECT *, tb1.empl_id as empl_id, tb1.id as id FROM tbl_attendance_adjustments as tb1
        JOIN tbl_approvers_timeadj ON tbl_approvers_timeadj.empl_id = tb1.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tb1.empl_id
        WHERE tb1.status LIKE '%Pending%' " . $filter_q . " 
        
        AND ( ((tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND tb1.status = 'Pending 1') OR
        ((tb1.approver2 = $userId OR tb1.approver2_b = $userId)  AND tb1.status = 'Pending 2') OR
        ((tb1.approver3 = $userId OR tb1.approver3_b = $userId)  AND tb1.status = 'Pending 3') OR
        ((tb1.approver4 = $userId OR tb1.approver4_b = $userId)  AND tb1.status = 'Pending 4') OR
        ((tb1.approver5 = $userId OR tb1.approver5_b = $userId)  AND tb1.status = 'Pending 5')
        )

        ORDER BY tb1.create_date DESC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();

        // AND (( approver1 = $userId AND approver1_date='0000-00-00 00:00:00') OR  
        // (approver2=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date='0000-00-00 00:00:00'  ) OR
        // (approver3=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date!='0000-00-00 00:00:00' AND approver3_date='0000-00-00 00:00:00'  ) OR
        // (approver4=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date!='0000-00-00 00:00:00' AND approver3_date!='0000-00-00 00:00:00' AND approver4_date='0000-00-00 00:00:00'  ) OR
        // (approver5=$userId AND approver1_date!='0000-00-00 00:00:00' AND approver2_date!='0000-00-00 00:00:00' AND approver3_date!='0000-00-00 00:00:00' AND approver4_date!='0000-00-00 00:00:00' AND approver5_date='0000-00-00 00:00:00'   )
        // )
    }


    function GET_COUNT_TIME_ADJUSTMENT_APPROVALS($userId, $company, $dept, $sec, $group, $line, $branch, $division, $team)
    {
        $filter_q = '';
        if ($company && $company !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_company=" . $company;
        }
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
        if ($team && $team !== "undefined") {
            $filter_q .= " AND tbl_employee_infos.col_empl_team=" . $team;
        }

        $sql = "SELECT *, tb1.empl_id as empl_id, tb1.id as id FROM tbl_attendance_adjustments AS tb1
        JOIN tbl_approvers_timeadj ON tbl_approvers_timeadj.empl_id = tb1.empl_id
        JOIN tbl_employee_infos ON tbl_employee_infos.id = tb1.empl_id
        WHERE tb1.status LIKE '%Pending%' " . $filter_q . " 

         AND ( ((tb1.approver1 = $userId OR tb1.approver1_b = $userId) AND tb1.status = 'Pending 1') OR
        ((tb1.approver2 = $userId OR tb1.approver2_b = $userId)  AND tb1.status = 'Pending 2') OR
        ((tb1.approver3 = $userId OR tb1.approver3_b = $userId)  AND tb1.status = 'Pending 3') OR
        ((tb1.approver4 = $userId OR tb1.approver4_b = $userId)  AND tb1.status = 'Pending 4') OR
        ((tb1.approver5 = $userId OR tb1.approver5_b = $userId)  AND tb1.status = 'Pending 5')
        )

        ORDER BY tb1.create_date DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }


    function GET_BACKUP_APPROVALS($userId, $offset, $row, $company, $dept, $sec, $group, $line, $branch, $division, $team, $table, $columns)
    {

        $filter_q = array();
        if ($company) {
            $filter_q['col_empl_company']  = $company;
        }
        if ($dept) {
            $filter_q['col_empl_dept']  = $dept;
        }
        if ($sec) {
            $filter_q['col_empl_sect']  = $sec;
        }
        if ($group) {
            $filter_q['col_empl_group'] = $group;
        }
        if ($line) {
            $filter_q['col_empl_line']  = $line;
        }
        if ($branch) {
            $filter_q['col_empl_branch'] = $branch;
        }
        if ($division) {
            $filter_q['col_empl_divi'] = $division;
        }
        if ($team) {
            $filter_q['col_empl_team'] = $team;
        }
        $this->db->select($columns, false);
        $this->db->from($table . ' as tb1');
        $this->db->join('tbl_approvers_leave as tb2', 'tb1.empl_id=tb2.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id', 'left');
        $this->db->like('tb1.status', 'Pending');
        $this->db->where($filter_q);
        $this->db->where("(((approver_1a = $userId OR approver_1b = $userId ) AND approver1 = 0 ) 
        OR ((approver_2a = $userId OR approver_2b = $userId ) AND approver2 = 0 AND approver1 !=0 ) OR ((approver_3a = $userId OR approver_3b = $userId ) AND approver3 = 0 AND approver2 !=0 AND approver1 !=0 ))");
        $this->db->limit($row, $offset);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }

    function GET_COUNT_BACKUP_APPROVALS($userId, $company, $dept, $sec, $group, $line, $branch, $division, $team, $table)
    {
        $filter_q = array();
        if ($dept) {
            $filter_q['col_empl_dept']  = $dept;
        }
        if ($sec) {
            $filter_q['col_empl_sect']  = $sec;
        }
        if ($group) {
            $filter_q['col_empl_group'] = $group;
        }
        if ($line) {
            $filter_q['col_empl_line']  = $line;
        }
        if ($branch) {
            $filter_q['col_empl_branch'] = $branch;
        }
        if ($division) {
            $filter_q['col_empl_divi'] = $division;
        }
        if ($team) {
            $filter_q['col_empl_team'] = $team;
        }
        $this->db->select('tb1.*');
        $this->db->from($table . ' as tb1');
        $this->db->join('tbl_approvers_leave as tb2', 'tb1.empl_id=tb2.empl_id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.empl_id=tb3.id');
        $this->db->like('tb1.status', 'Pending');
        $this->db->where($filter_q);
        $this->db->where("((approver_1a = $userId OR approver_1b = $userId ) AND approver1 = 0) 
        OR (approver_2a = $userId OR approver_2b = $userId ) OR (approver_3a = $userId OR approver_3b = $userId )");
        $query = $this->db->get();
        return $query->num_rows();
    }

    function GET_TIME_ADJUSTMENT_ASSIGN($id)
    {
        $this->db->select('tb1.*');
        $this->db->select('CONCAT(tb2.col_last_name,IF(tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> "", CONCAT(" ",tb2.col_suffix, ""), ""), ", ",
        tb2.col_frst_name, " ",IF(tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> "", CONCAT(LEFT(tb2.col_midl_name, 1), "."), "")) as employee', false);
        $this->db->from('tbl_attendance_adjustments as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function GET_SPECIFIC_OVERTIME($id)
    {
        $sql = "SELECT * FROM tbl_overtimes WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3') AND id=?";
        $query = $this->db->query($sql, array($id));
        return $query->result_array();;
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

    function GET_SPECIFIC_HOLIDAYWORK($id)
    {
        $sql = "SELECT * FROM tbl_holidaywork WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3') AND id=?";
        $query = $this->db->query($sql, array($id));
        return $query->result_array();;
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

    function UPDATE_HOLIDAY_WORK($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_holidaywork', $data);
    }

    function GET_SPECIFIC_TIME_ADJ($id)
    {
        $sql = "SELECT * FROM tbl_attendance_adjustments WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3') AND id=?";
        $query = $this->db->query($sql, array($id));
        return $query->result_array();;
    }

    function GET_SPECIFIC_LEAVE_REQUEST($id)
    {
        $sql = "SELECT * FROM tbl_leaves_assign WHERE (status = 'Pending 1' OR status = 'Pending 2' OR status = 'Pending 3') AND id=?";
        $query = $this->db->query($sql, array($id));
        return $query->result_array();;
    }

    function GET_ALL_LEAVETYPES()
    {
        $sql = "SELECT * FROM tbl_std_leavetypes WHERE status='Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }


    function GET_LEAVE_TYPES_ACTIVE()
    {
        $this->db->select('t.*, s.value');
        $this->db->from('tbl_std_leavetypes t');
        $this->db->join('tbl_leaves_settings s', 't.leave_setting_id = s.id', 'left');
        // $this->db->where('s.value', 1);
        $this->db->where('(s.value IS NULL OR s.value = 1)');
        $this->db->where('t.status', 'Active');
        $result = $this->db->get()->result();

        return $result;
    }

    function SHOW_HIDE_CREDITS_OTHERS()
    {
        $this->db->select('value');
        $this->db->from('tbl_leaves_settings');
        $this->db->where('setting', 'other_credit');
        $result = $this->db->get()->result();
        if (!empty($result)) {
            return $result[0]->value;
        } else {
            return 0;
        }
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
    function get_leave_setting2($setting)
    {
        $this->db->select('value');
        $this->db->from('tbl_leaves_settings');
        $this->db->where('setting', $setting);
        $result = $this->db->get()->row();
        if ($result) {
            return $result->value;
        } else {
            return 0;
        }
    }
    function SHOW_HIDE_ATTACHMENT($type)
    {
        $this->db->select('s.value');
        $this->db->from('tbl_std_leavetypes t');
        $this->db->join('tbl_leaves_settings s', 't.attachment_id = s.id', 'inner');
        $this->db->where('t.id', $type);
        $result = $this->db->get()->row();
        if ($result) {
            return $result->value;
        } else {
            return 0;
        }
    }

    function SHOW_HIDE_REASON($type)
    {
        $this->db->select('s.value');
        $this->db->from('tbl_std_leavetypes t');
        $this->db->join('tbl_leaves_settings s', 't.reason_id = s.id', 'inner');
        $this->db->where('t.id', $type);
        // $result = $this->db->get()->row()->value;

        $result = $this->db->get()->row();

        if ($result) {
            return $result->value;
        } else {
            return 0;
        }
        // return $result;
    }


    function LWOP_OFFSET_SHOW_HIDE($type)
    {
        $this->db->select('t.name, t.credit_id');
        $this->db->from('tbl_std_leavetypes t');
        $this->db->where('t.credit_id IS NULL', $type);
        $query = $this->db->get();

        // Example to retrieve results
        $result = $query->result();
    }

    function GET_ALL_LEAVETYPES2()
    {
        $sql = "SELECT * FROM tbl_std_leavetypes WHERE status='Active' ORDER BY id DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

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

    function get_leave_approver()
    {
        $sql = "SELECT * FROM tbl_approvers";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function get_overtime_approver()
    {
        $sql = "SELECT * FROM tbl_approvers";
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

    function GET_ALL_EMPLOYEES_SEARCH_LIST_WITH_ID()
    {
        $sql   = "SELECT id,col_last_name,col_midl_name,col_frst_name,col_empl_cmid,col_suffix FROM tbl_employee_infos WHERE disabled=0 ORDER BY col_empl_cmid +0 ASC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function UPDATE_SHIFT_ASSIGN($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_attendance_shiftassign SET status=?, approver1=?, approver1_date=?,remarks=? WHERE id=? or parent_id=?";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id, $id));
    }

    function UPDATE_OFFSET_ASSIGN($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_attendance_offsets SET status=?, approved_by_1=?, approver1_date=?,remarks=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }
    function UPDATE_OFFSET_ASSIGN2($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_attendance_offsets SET status=?, approved_by_2=?, approver2_date=?,remarks=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }
    function UPDATE_OFFSET_ASSIGN3($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_attendance_offsets SET status=?, approved_by_3=?, approver3_date=?,remarks=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }

    // tbl_attendance_offsets_acquire
    function UPDATE_ACQUIRE_OFFSET_ASSIGN($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_attendance_offsets_acquire SET status=?, approved_by_1=?, approver1_date=?,remarks=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }
    function UPDATE_ACQUIRE_OFFSET_ASSIGN2($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_attendance_offsets_acquire SET status=?, approved_by_2=?, approver2_date=?,remarks=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }
    function UPDATE_ACQUIRE_OFFSET_ASSIGN3($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_attendance_offsets_acquire SET status=?, approved_by_3=?, approver3_date=?,remarks=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }

    function UPDATE_LEAVE_ASSIGN($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_leaves_assign SET status=?, approved_by_1=?, approver1_date=?,remarks=? WHERE id=? or parent_id=?";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id, $id));
    }

    function UPDATE_LEAVE_ASSIGN2($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_leaves_assign SET status=?, approved_by_2=?, approver2_date=?,remarks=? WHERE id=? or parent_id=?";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id, $id));
    }

    function UPDATE_LEAVE_ASSIGN3($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_leaves_assign SET status=?, approved_by_3=?, approver3_date=?,remarks=? WHERE id=? or parent_id=?";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id, $id));
    }
    function UPDATE_LEAVE_ASSIGN4($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_leaves_assign SET status=?, approved_by_4=?, approver4_date=?,remarks=? WHERE id=? or parent_id=?";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id, $id));
    }
    function UPDATE_LEAVE_ASSIGN5($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_leaves_assign SET status=?, approved_by_5=?, approver5_date=?,remarks=? WHERE id=? or parent_id=?";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id, $id));
    }

    function GET_SHIFT_ASSIGN($date, $empl_id)
    {
        $sql = "SELECT * FROM tbl_attendance_shiftassign WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql, array($date, $empl_id));
        return $query->row();
    }

    function GET_SHIFT_ASSIGN_ID($date, $empl_id)
    {
        $sql = "SELECT * FROM tbl_attendance_shiftassign WHERE date=? AND empl_id=?";
        $query = $this->db->query($sql, array($date, $empl_id));
        if ($query->row()) {
            return $query->row()->shift_id;
        }
        return false;
    }

    function GET_SHIFT($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_attendance_shifts');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    function GET_ATTENDANCE_EMPL_REC($id)
    {
        $sql = "SELECT id, date, empl_id, time_format(time_in, '%H:%i') as time_in, 
        time_format(time_out, '%H:%i') as time_out FROM tbl_attendance_records 
        WHERE empl_id=? AND
        NOT EXISTS( SELECT * FROM tbl_attendance_adjustments WHERE tbl_attendance_records.date=tbl_attendance_adjustments.date_adjustment  )";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }

    function GET_EMPL_OVERTIME($userId, $status, $limit, $offset)
    {
        $this->db->select('id,date_ot,type,hours,ndot,reason,status,comment');
        $this->db->where('empl_id', $userId);
        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get('tbl_overtimes');
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

    function GET_EMPL_CHANGESHIFT($userId, $status, $limit, $offset)
    {
        $this->db->select('id,date_shift,current_shift,request_shift,reason,status,comment');
        $this->db->where('empl_id', $userId);
        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get('tbl_attendance_changeshift');
        return $query->result();
    }

    function GET_EMPL_CHANGE_OFF($userId, $status, $limit, $offset)
    {
        $this->db->select('id,date_shift,current_shift,request_shift,reason,status,comment, date_shift_to, current_shift_to, request_shift_to');
        $this->db->where('empl_id', $userId);
        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get('tbl_attendance_changeoff');
        return $query->result();
    }

    function GET_EMPL_UNDERTIME($userId, $status, $limit, $offset)
    {
        $this->db->select('id, date_undertime, current_shift, request_time_in, request_time_out,reason,status, comment, create_date');
        $this->db->where('empl_id', $userId);
        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get('tbl_attendance_undertime');
        return $query->result();
    }

    function GET_EMPL_UNDERTIME_COUNT($userId, $status)
    {
        $this->db->select('id,date_undertime,current_shift,request_time_in, request_time_out,reason,status,comment');
        $this->db->where('empl_id', $userId);
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $query = $this->db->get('tbl_attendance_undertime');
        return $query->num_rows();
    }

    function GET_EMPL_EXEMPTUT($userId, $status, $limit, $offset)
    {
        $this->db->select('id,date_undertime,actual_out,shift_out,reason,status,comment');
        $this->db->where('empl_id', $userId);
        $this->db->order_by('id', 'desc');
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get('tbl_attendance_undertimerequest');
        return $query->result();
    }
    function GET_EMPLOYEE_OTHER_DETAILS($employee_id)
    {
        $this->db->select('tb1.id,tb1.name,tb2.value');
        $this->db->from('tbl_std_custominfo as tb1');
        $this->db->join('tbl_employees_custominfo as tb2', "tb1.id=tb2.custom_info_id AND tb2.empl_id=$employee_id", 'left');
        $query = $this->db->get();
        return $query->result();
    }
    function GET_EMPL_OVERTIME_COUNT($userId, $status)
    {
        $this->db->select('id,date_ot,hours,reason,status,comment');
        $this->db->where('empl_id', $userId);
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $query = $this->db->get('tbl_overtimes');
        return $query->num_rows();
    }
    function GET_EMPL_CHANGESHIFT_COUNT($userId, $status)
    {
        $this->db->select('id,date_shift,current_shift,request_shift,reason,status,comment');
        $this->db->where('empl_id', $userId);
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $query = $this->db->get('tbl_attendance_changeshift');
        return $query->num_rows();
    }

    function GET_EMPL_CHANGEOFF_COUNT($userId, $status)
    {
        $this->db->select('id,date_shift,current_shift,request_shift,reason,status,comment');
        $this->db->where('empl_id', $userId);
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $query = $this->db->get('tbl_attendance_changeoff');
        return $query->num_rows();
    }

    function GET_EMPL_EXEMPTUT_COUNT($userId, $status)
    {
        $this->db->select('id,date_undertime,actual_out,shift_out,reason,status,comment');
        $this->db->where('empl_id', $userId);
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $query = $this->db->get('tbl_attendance_undertimerequest');
        return $query->num_rows();
    }
    function GET_EMPL_HOLIDAY_WORK($userId, $status, $limit, $offset)
    {
        $this->db->select('id,date,reason,status,comment,hours,reason,status,comment,type');
        $this->db->where('empl_id', $userId);
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('tbl_holidaywork');
        return $query->result();
    }

    function GET_EMPL_HOLIDAY_WORK_COUNT($userId, $status)
    {
        $this->db->select('id,date,reason,status,comment,hours,reason,status,comment');
        $this->db->where('empl_id', $userId);
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $query = $this->db->get('tbl_holidaywork');
        return $query->num_rows();
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

    function GET_EMPL_TIME_ADJ($userId, $status, $limit, $offset)
    {
        $this->db->select('id,date_adjustment,time_in_1,time_out_1,time_in_2,time_out_2,attachment,reason,status,remarks');
        $this->db->where('empl_id', $userId);
        $this->db->limit($limit, $offset);
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('tbl_attendance_adjustments');
        return $query->result();
    }

    function  GET_EMPL_TIME_ADJ_COUNT($userId, $status)
    {
        $this->db->select('id,date_adjustment,time_in_1,time_out_1,time_in_2,time_out_2,attachment,reason,status,remarks');
        $this->db->where('empl_id', $userId);
        if (!empty($status)) {
            $this->db->like('status', $status);
        }
        $query = $this->db->get('tbl_attendance_adjustments');
        return $query->num_rows();
    }

    function ADD_DATA($table_name, $data)
    {
        return $this->db->insert($table_name, $data);
    }

    function ADD_LEAVE_REQUEST($data)
    {

        $this->db->insert('tbl_leaves_assign', $data);
        return $this->db->insert_id();
    }

    function GET_IS_DUPLICATE_DATE($date)
    {
        $sql = "SELECT * FROM tbl_leaves_assign WHERE leave_date=?";
        $query = $this->db->query($sql, array($date));
        return $query->num_rows();
    }
    function GET_IS_DUPLICATE_DATE_EMPL_ID($date, $empl_id)
    {
        $sql = "SELECT * FROM tbl_leaves_assign WHERE status != 'Withdrawed' AND leave_date=? AND empl_id=?";
        $query = $this->db->query($sql, array($date, $empl_id));
        return $query->num_rows();
    }

    function ADD_OVERTIME_REQUEST($data, $day_typess)
    {
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');
        $data['type']       = $day_typess;
        $this->db->insert('tbl_overtimes', $data);
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

    function ADD_EXEMPTUT_REQUEST($data)
    {
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');

        $this->db->insert('tbl_attendance_undertimerequest', $data);
        return $this->db->insert_id();
    }
    function GET_DAY_TYPE($day_type)
    {
        $sql = "SELECT name AS daytype FROM tbl_std_holidays WHERE col_holi_date LIKE '%$day_type%' ";
        $query = $this->db->query($sql)->row();
        $theday = $query->daytype;

        if ($theday) {
            return $theday;
        } else {
            return null;
        }
    }

    function ADD_SHIFT_REQUEST($data)
    {
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');
        $this->db->insert('tbl_attendance_shiftassign', $data);
        return $this->db->insert_id();
    }

    function ADD_TIME_ADJUSTMENT_REQUEST($data)
    {
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');
        $this->db->insert('tbl_attendance_adjustments', $data);
        return $this->db->insert_id();
    }

    function ADD_HOLIDAY_WORK($data)
    {
        $data['create_date'] = date('Y-m-d H:i:s');
        $data['edit_date'] = date('Y-m-d H:i:s');
        $this->db->insert('tbl_holidaywork', $data);
        return $this->db->insert_id();
    }

    function UPDATE_OVERTIME_ASSIGN($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_overtimes SET status=?, approved_by_1=?, approver1_date=?,comment=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }

    function UPDATE_OVERTIME_ASSIGN2($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_overtimes SET status=?, approved_by_2=?, approver2_date=?,comment=? WHERE id=? AND approved_by_1 <> ? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id, $emp_id));
    }

    function UPDATE_OVERTIME_ASSIGN3($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_overtimes SET status=?, approved_by_3=?, approver3_date=?,comment=? WHERE id=? AND approved_by_2 <> ? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id, $emp_id));
    }
    function UPDATE_OVERTIME_ASSIGN4($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_overtimes SET status=?, approved_by_4=?, approver4_date=?,comment=? WHERE id=? AND approved_by_3 <> ? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id, $emp_id));
    }
    function UPDATE_OVERTIME_ASSIGN5($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_overtimes SET status=?, approved_by_5=?, approver5_date=?,comment=? WHERE id=? AND approved_by_4 <> ? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id, $emp_id));
    }

    function UPDATE_HOLIDAYWORK_ASSIGN($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_holidaywork SET status=?, approved_by_1=?, approver1_date=?,comment=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }

    function UPDATE_HOLIDAYWORK_ASSIGN2($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_holidaywork SET status=?, approved_by_2=?, approver2_date=?,comment=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }

    function UPDATE_HOLIDAYWORK_ASSIGN3($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_holidaywork SET status=?, approved_by_3=?, approver3_date=?,comment=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }
    function UPDATE_HOLIDAYWORK_ASSIGN4($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_holidaywork SET status=?, approved_by_4=?, approver4_date=?,comment=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }
    function UPDATE_HOLIDAYWORK_ASSIGN5($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_holidaywork SET status=?, approved_by_5=?, approver5_date=?,comment=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }



    function UPDATE_TIME_ADJ_ASSIGN($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_attendance_adjustments SET status=?, approved_by_1=?, approver1_date=?,remarks=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }

    function UPDATE_TIME_ADJ_ASSIGN2($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_attendance_adjustments SET status=?, approved_by_2=?, approver2_date=?,remarks=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }

    function UPDATE_TIME_ADJ_ASSIGN3($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_attendance_adjustments SET status=?, approved_by_3=?, approver3_date=?,remarks=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }
    function UPDATE_TIME_ADJ_ASSIGN4($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_attendance_adjustments SET status=?, approved_by_4=?, approver4_date=?,remarks=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
    }
    function UPDATE_TIME_ADJ_ASSIGN5($status, $emp_id, $date_created, $id, $remarks = '')
    {
        $sql = "UPDATE tbl_attendance_adjustments SET status=?, approved_by_5=?, approver5_date=?,remarks=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $emp_id, $date_created, $remarks, $id));
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

    function GET_CUT_OFFS()
    {
        $this->db->select('id, date_from,date_to')
            ->where('status', 'Active')
            ->order_by('date_from', 'DESC');
        $query = $this->db->get('tbl_payroll_period');
        return $query->result();
    }

    function GET_SPECIFIC_SHIFT_RECORD($empl_id, $firstDay, $lastDay)
    {
        $sql = "SELECT * FROM tbl_attendance_shiftassign WHERE empl_id = ? AND date BETWEEN ? AND ? ";
        $query = $this->db->query($sql, array($empl_id, $firstDay, $lastDay));
        $query->next_result();
        return $query->result_array();
    }

    function GET_SPECIFIC_ATTENDANCE_RECORD($empl_id, $firstDay, $lastDay)
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE empl_id = ? AND date BETWEEN ? AND ? ";
        $query = $this->db->query($sql, array($empl_id, $firstDay, $lastDay));
        $query->next_result();
        return $query->result_array();
    }

    // function GET_ATTENDANCE_ADJUSTMENTS($empl_id, $firstDay, $lastDay)
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
    //     $query = $this->db->query($sql, array($empl_id, $firstDay, $lastDay));
    //     $query->next_result();

    //     // Return the results as an array
    //     return $query->result_array();
    // }

    function GET_SPECIFIC_ZKTECO_RECORD($empl_id, $firstDay, $lastDay)
    {
        $sql = "SELECT * FROM tbl_zkteco 
        LEFT JOIN tbl_zkteco_code ON tbl_zkteco.emp_code = tbl_zkteco_code.empl_code
        WHERE empl_id = ? AND (SELECT DATE_FORMAT(punch_time, '%Y-%m-%d')) BETWEEN ? AND ?  ";
        $query = $this->db->query($sql, array($empl_id, $firstDay, $lastDay));
        $query->next_result();
        return $query->result_array();
    }

    function GET_COUNT_ATTENDANCE_RECORD($empl_id)
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE empl_id = ? ";
        $query = $this->db->query($sql, array($empl_id));
        return $query->num_rows();
    }

    function INSERT_EMPLOYEE_IMAGE($user_img, $userID)
    {
        $sql = "UPDATE tbl_employee_infos SET col_imag_path=? WHERE id=?";
        $query = $this->db->query($sql, array($user_img, $userID));
    }

    // function GET_ALL_MY_PAYSPLIP($empl_id, $offset, $row)
    // {
    //     $query = $this->db
    //         ->select('tb2.id AS employee_id, tb2.col_empl_cmid, tb2.col_suffix, tb2.col_last_name, tb2.col_frst_name, tb2.col_midl_name, tb2.col_empl_posi, tb2.col_empl_type, tb1.id as id, tb3.name as cutoff_period, tb3.payslip_sched ')
    //         ->from('tbl_payroll_payslips as tb1')
    //         ->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left')
    //         ->join('tbl_payroll_period as tb3', 'tb1.PAYSLIP_PERIOD = tb3.id', 'left')
    //         ->where('tb1.empl_id', $empl_id)
    //         ->limit($row, $offset)
    //         ->get();
    //     return $query->result();
    // }

    function GET_ALL_MY_PAYSPLIP($empl_id, $offset, $row)
    {
        $sql = "SELECT
                    tb2.id AS employee_id,
                    tb2.col_empl_cmid,
                    tb2.col_suffix,
                    tb2.col_last_name,
                    tb2.col_frst_name,
                    tb2.col_midl_name,
                    tb2.col_empl_posi,
                    tb2.col_empl_type,
                    tb1.id as id,
                    tb1.is_acknowledged, 
                    tb3.name as cutoff_period,
                    tb3.payslip_sched
                FROM tbl_payroll_payslips as tb1
                LEFT JOIN tbl_employee_infos as tb2 ON tb1.empl_id = tb2.id
                LEFT JOIN tbl_payroll_period as tb3 ON tb1.PAYSLIP_PERIOD = tb3.id
                WHERE tb1.empl_id = ? AND tb1.status = 'Published'
                LIMIT $offset, $row";

        $query = $this->db->query($sql, array($empl_id));
        return $query->result();
    }


    function GET_FILTERED_MY_PAYSPLIP($user_id, $dateFilter)
    {
        $sql = "SELECT tbl_employee_infos.id AS employee_id, tbl_employee_infos.col_empl_cmid, tbl_employee_infos.col_suffix,tbl_employee_infos.col_last_name, tbl_employee_infos.col_frst_name, tbl_employee_infos.col_midl_name, tbl_employee_infos.col_empl_posi, tbl_employee_infos.col_empl_type, tbl_payroll_payslips.id as id 
        FROM tbl_payroll_payslips 
        INNER JOIN tbl_employee_infos ON tbl_payroll_payslips.empl_id = tbl_employee_infos.id WHERE empl_id = ? AND tbl_payroll_payslips.PAYSLIP_PERIOD = ?";

        $query = $this->db->query($sql, array($user_id, $dateFilter));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_PAY_SCHED()
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE status='active' ORDER BY id DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_MY_PAYSPLIP($empl_id)
    {
        $sql = "SELECT tbl_employee_infos.col_empl_cmid, tbl_employee_infos.col_last_name, tbl_employee_infos.col_frst_name, tbl_employee_infos.col_midl_name, tbl_employee_infos.col_empl_posi, tbl_employee_infos.col_empl_type, tbl_payroll_payslips.id as id 
        FROM tbl_payroll_payslips 
        INNER JOIN tbl_employee_infos ON tbl_payroll_payslips.empl_id = tbl_employee_infos.id WHERE empl_id = ? AND tbl_payroll_payslips.status = 'Published'";

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


    function GET_PAYSLIP_DATA($id)
    {
        $this->db->select('col_empl_cmid,col_suffix,col_last_name,col_frst_name,col_midl_name,col_empl_posi,col_empl_type,tbl_payroll_payslips.id as id,tbl_employee_infos.salary_type as salary_type,tbl_employee_infos.salary_rate as salary_rate,tbl_payroll_payslips.*,tbl_std_positions.name as position,tbl_std_departments.name as department,tbl_std_sections.name as section,tbl_payroll_period.name as PAYSLIP_PERIOD,tbl_payroll_period.payout as PAYSLIP_PAYOUT');
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

    function DELETE_PAYSLIP_DATA($ids)
    {
        $this->db->where_in('id', $ids);
        return $this->db->delete('tbl_payroll_payslips');
    }

    function MOD_UPDATE_LEAVE_STATUS($id, $status)
    {
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_leaves_assign SET edit_date=?, status=? WHERE id=? or parent_id=?";
        return $this->db->query($sql, array($date, $status, $id, $id));
    }

    function MOD_UPDATE_ACQUIRE_OFFSET_STATUS($id, $status)
    {
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_offsets_acquire SET edit_date=?, status=? WHERE id=?";
        return $this->db->query($sql, array($date, $status, $id));
    }

    function MOD_UPDATE_REDEEM_OFFSET_STATUS($id, $status)
    {
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_offsets SET edit_date=?, status=? WHERE id=?";
        return $this->db->query($sql, array($date, $status, $id));
    }

    function GET_LEAVE_ENTITLEMENT($id, $type)
    {
        $sql = "SELECT value FROM tbl_leave_entitlements WHERE empl_id=? AND type=?";
        $query = $this->db->query($sql, array($id, $type));
        $result = $query->result_array();
        $output = $result;

        return $output;
    }

    function GET_EMPLOYEE_LOGS_SPECIFIC($empl_id)
    {
        $sql = "SELECT * FROM tbl_employee_logs WHERE empl_id=? AND category != 'Salary Rate' AND category != 'Salary Type' ORDER BY log_date DESC LIMIT 100";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }

    function UPDATE_OVERTIME($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('tbl_overtimes', $data);
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

    function GET_EMPLOYEE_BY_ID_REPORTING_TO($employeeId)
    {
        $sql = "SELECT id,col_suffix,col_empl_company,col_empl_branch,col_empl_dept,col_empl_posi,col_empl_cmid,reporting_to,col_comp_emai,col_last_name,col_midl_name,col_frst_name,col_imag_path FROM tbl_employee_infos WHERE id=? ";
        $query = $this->db->query($sql, array($employeeId));
        return $query->row();
    }

    function GET_EMPLOYEE_BY_ID_DIRECTS($employeeId)
    {
        $sql = "SELECT id,col_suffix,col_empl_company,col_empl_branch,col_empl_dept,col_empl_posi,col_empl_cmid,reporting_to,col_comp_emai,col_last_name,col_midl_name,col_frst_name,col_imag_path FROM tbl_employee_infos WHERE reporting_to=? ";
        $query = $this->db->query($sql, array($employeeId));
        return $query->result();
    }

    function GET_POSITION_NAME_BY_ID($postionId)
    {
        $sql = "SELECT name FROM tbl_std_positions WHERE id=?";
        $query = $this->db->query($sql, array($postionId));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }

    function GET_COMPANY_NAME_BY_ID($postionId)
    {
        $sql = "SELECT name FROM tbl_std_companies WHERE id=?";
        $query = $this->db->query($sql, array($postionId));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }

    function GET_BRANCH_NAME_BY_ID($branchId)
    {
        $sql = "SELECT name FROM tbl_std_branches WHERE id=?";
        $query = $this->db->query($sql, array($branchId));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }

    function GET_DEPARTMENT_NAME_BY_ID($departmentId)
    {
        $sql = "SELECT name FROM tbl_std_departments WHERE id=?";
        $query = $this->db->query($sql, array($departmentId));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }

    function ADD_NOTIFICATION($data)
    {
        $this->db->insert('tbl_notifications', $data);
        return $this->db->insert_id();
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

    function DELETE_NOTIFICATION($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_notifications');
    }

    function GET_APPROVED_LEAVES($empl_id, $date_from, $date_to)
    {
        $sql = "SELECT * FROM tbl_leaves_assign WHERE status = 'Approved' AND empl_id = ? AND leave_date >= ? AND leave_date <= ?";
        $query = $this->db->query($sql, array($empl_id, $date_from, $date_to));
        $query->next_result();
        return $query->result();
    }

    function GET_SPECIFIC_LEAVE_NAME($id)
    {
        $sql = "SELECT name FROM tbl_std_leavetypes WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result->name;
        }
        return '';
    }

    function GET_LEAVE_NAMES()
    {
        $sql = "SELECT id,name FROM tbl_std_leavetypes";
        $query = $this->db->query($sql);
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

    function GET_SHIFT_ASSIGN_SPECIFIC($user_id)
    {
        $sql = "SELECT date,shift_id FROM tbl_attendance_shiftassign WHERE empl_id = ?";
        $query = $this->db->query($sql, array($user_id));
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

    function GET_YEARS()
    {
        $sql = "SELECT id,name FROM tbl_std_years";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_FILTERED_EMPLOYEELIST_COUNT($branch, $dept, $division, $section, $group, $team, $line, $company)
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

        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,col_empl_line,salary_rate,salary_type,col_empl_company FROM tbl_employee_infos 
        WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND col_empl_branch = $branch
        AND col_empl_dept = $dept
        AND col_empl_divi = $division
        AND col_empl_sect = $section
        AND col_empl_group = $group
        AND col_empl_team = $team
        AND col_empl_line = $line
        AND col_empl_company = $company
        ORDER BY col_empl_cmid ASC";

        $query = $this->db->query($sql);
        return $query->num_rows();
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

    function MOD_DISP_DISTINCT_BRANCH()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_branches";
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

    function MOD_DISP_DISTINCT_COMPANY()
    {
        $sql = "SELECT DISTINCT id,name FROM tbl_std_companies";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_HOLIDAY()
    {
        $sql = "SELECT col_holi_date,col_holi_type FROM tbl_std_holidays";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_EMPLOYEES()
    {
        $this->db->select('id,reporting_to,col_empl_cmid,
        col_last_name,col_midl_name,col_frst_name')
            ->where('termination_date', NULL)
            ->where('disabled', 0);
        $query = $this->db->get('tbl_employee_infos');
        return $query->result_object();
    }

    function GET_MAINTENANCE()
    {
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = 'maintenance'";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["value"];
    }

    function GET_USER_PASSWORD($id)
    {
        $sql = "SELECT col_last_name, col_birt_date FROM tbl_employee_infos WHERE id=?";
        $query = $this->db->query($sql, array($id));
        return $query->result_object();
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
            /* Hours / 8 = Days */
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
            /* Hours / 8 = Days */
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
            /* Hours / 8 = Days */
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
    // Dynamic function call
    function DELETE_DATA_ROW($table, $id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($table);
    }
    function INSERT_DATA_ROW($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    function GET_ALL_PAYROLL_PAYSLIP_LOAN_DATA($payslip_id)
    {
        if (empty($payslip_id) || $payslip_id == null) {
            return [];
        }
        $sql   = "SELECT * FROM tbl_payroll_payslip_loan WHERE payslip_id=$payslip_id";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }


    function GET_ALL_PAYROLL_TAXABLE_DATA($payroll_id)
    {
        if (empty($payroll_id) || $payroll_id == null) {
            return [];
        }
        $sql   = "SELECT * FROM tbl_payrolls_taxable WHERE payroll_id=$payroll_id";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_PAYROLL_NONTAXABLE_DATA($payroll_id)
    {
        if (empty($payroll_id) || $payroll_id == null) {
            return [];
        }
        $sql   = "SELECT * FROM tbl_payrolls_nontaxable WHERE payroll_id=$payroll_id";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function UPDATE_DATA($table, $id, $data)
    {
        $this->db->where("id", $id);
        return $this->db->update($table, $data);
    }

    public function get_all_assets_info($limit, $offset, $status, $search_query, $row, $id)
    {
        // Selecting specific columns from multiple tables
        $this->db->select('aa.*, ab.col_empl_cmid AS assign_by_cmid, ab.col_frst_name AS assign_by_fname, ab.col_last_name AS assign_by_lname, ei.col_empl_cmid, ei.col_frst_name, ei.col_last_name, lc.name AS location_name, lc.id AS location_id, ac.name AS asset_category_name, ac.id AS asset_category_id');

        // From the main table
        $this->db->from('tbl_asset_assign as aa');

        // Joining other tables
        $this->db->join('tbl_employee_infos as ei', 'aa.col_asset_assigned_to = ei.id', 'left');
        $this->db->join('tbl_employee_infos as ab', 'aa.col_asset_assigned_by = ab.id', 'left');
        $this->db->join('tbl_std_companylocations as lc', 'aa.col_asset_location = lc.id', 'left');
        $this->db->join('tbl_std_assetcategories as ac', 'aa.col_asset_category = ac.id', 'left');

        // Filtering based on status and assigned user ID
        $this->db->where('aa.status', $status);
        $this->db->where('aa.col_asset_assigned_to', $id);

        // Adding search conditions with OR LIKE
        if ($search_query) {

            $this->db->like('ei.col_empl_cmid', $search_query);
            $this->db->or_like('ei.col_frst_name', $search_query);
            $this->db->or_like('ei.col_last_name', $search_query);
            $this->db->or_like('lc.name', $search_query);
            $this->db->or_like('ac.name', $search_query);
            $this->db->or_like('aa.col_asset_name', $search_query);
            $this->db->or_like('aa.col_asset_serial', $search_query);
        }

        // Ordering and limiting results
        $this->db->order_by('aa.id', 'DESC');
        $this->db->limit($row, $offset);

        // Executing the query
        $query = $this->db->get();

        // Returning the result or an empty array if no results
        return $query->result();
    }

    function get_assets_count($status, $id, $search_query)
    {
        $this->db->select('aa.*, ab.col_empl_cmid AS assign_by_cmid, ab.col_frst_name AS assign_by_fname, ab.col_last_name AS assign_by_lname, ei.col_empl_cmid, ei.col_frst_name, ei.col_last_name, lc.name AS location_name, lc.id AS location_id, ac.name AS asset_category_name, ac.id AS asset_category_id');

        // From the main table
        $this->db->from('tbl_asset_assign as aa');

        // Joining other tables
        $this->db->join('tbl_employee_infos as ei', 'aa.col_asset_assigned_to = ei.id', 'left');
        $this->db->join('tbl_employee_infos as ab', 'aa.col_asset_assigned_by = ab.id', 'left');
        $this->db->join('tbl_std_companylocations as lc', 'aa.col_asset_location = lc.id', 'left');
        $this->db->join('tbl_std_assetcategories as ac', 'aa.col_asset_category = ac.id', 'left');

        // Filtering based on status and assigned user ID
        $this->db->where('aa.status', $status);
        $this->db->where('aa.col_asset_assigned_to', $id);

        // Adding search conditions with OR LIKE
        if ($search_query) {

            $this->db->like('ei.col_empl_cmid', $search_query);
            $this->db->or_like('ei.col_frst_name', $search_query);
            $this->db->or_like('ei.col_last_name', $search_query);
            $this->db->or_like('lc.name', $search_query);
            $this->db->or_like('ac.name', $search_query);
            $this->db->or_like('aa.col_asset_name', $search_query);
            $this->db->or_like('aa.col_asset_serial', $search_query);
        }

        if ($search_query) {

            $this->db->like('col_asset_name', $search_query);
        }

        $query = $this->db->get();

        return $query->num_rows();
    }

    function MOD_DISP_ASSETS($limit, $offset, $status)
    {
        $this->db->select('id,col_asset_name,col_asset_description,col_asset_serial,col_asset_category,col_asset_location,col_asset_assigned_to,col_asset_warranty_exp, status')
            ->where('status', $status)
            ->where('is_deleted', '0')
            ->limit($limit, $offset)
            ->order_by('id', 'DESC');
        $query = $this->db->get('tbl_asset_assign');
        return $query->result();
    }

    function MOD_DISP_ASSET($id)
    {
        $this->db->select('aa.*, ei.col_empl_cmid, ei.col_frst_name, ei.col_last_name, lc.name AS location_name, lc.id AS location_id, ac.name AS asset_category_name, ac.id AS asset_category_id');
        $this->db->from('tbl_asset_assign as aa');
        $this->db->join('tbl_employee_infos as ei', 'aa.col_asset_assigned_to = ei.id', 'left');
        $this->db->join('tbl_std_companylocations as lc', 'aa.col_asset_location = lc.id', 'left');
        $this->db->join('tbl_std_assetcategories as ac', 'aa.col_asset_category = ac.id', 'left');
        $this->db->where('aa.col_asset_assigned_to', $id);

        $query = $this->db->get();
        return $query->row();
    }


    function get_value_navbar()
    {
        $sql = "SELECT value FROM tbl_system_setup WHERE id = 3";
        // return $this->db->query($sql)->row();
        $query = $this->db->query($sql, array());
        $result = $query->row();
        return $result ? $result->value : null;
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

    function GET_SPECIFIC_ATTENDANCE($empl_id, $date)
    {
        $sql = "SELECT * FROM tbl_attendance_records WHERE empl_id=? AND date=? ";
        $query = $this->db->query($sql, array($empl_id, $date));
        $result = $query->row();
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    function GET_MY_SHIFT_APPROVALS($userId)
    {
        $sql = "SELECT *, tbl_attendance_shiftassign_approval.status as status FROM tbl_attendance_shiftassign_approval 
        LEFT JOIN tbl_payroll_period ON tbl_attendance_shiftassign_approval.cutoff_period=tbl_payroll_period.id
        WHERE empl_id = $userId ";

        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_PAYROLL_PERIOD($id)
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE id=?  ";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    function GET_SHIFT_DATA_DATERANGE($empl_id, $begin, $end)
    {
        $sql = "SELECT empl_id,date,shift_id FROM tbl_attendance_shiftassign_temp WHERE empl_id=? AND date >= '$begin' AND date <= '$end' AND is_deleted=0";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }


    function GET_SHIFT_DATA_DATERANGE_SELF($empl_id, $begin, $end)
    {
        $sql = "SELECT tbl_attendance_shiftassign_temp.empl_id,date,shift_id FROM tbl_attendance_shiftassign_temp 
            LEFT JOIN tbl_approvers_shift ON tbl_attendance_shiftassign_temp.empl_id = tbl_approvers_shift.empl_id
            WHERE (( checked_by = $empl_id) OR ( noted_by = $empl_id)) AND date >= '$begin' AND date <= '$end' AND tbl_attendance_shiftassign_temp.is_deleted=0";
        $query = $this->db->query($sql, array($empl_id));
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

    function UPDATE_CHANGESHIFT($empl_id, $date_shift, $result_id)
    {
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_attendance_shiftassign SET edit_date=?, shift_id=? WHERE empl_id=? AND date=?";
        $this->db->query($sql, array($date, $result_id, $empl_id, $date_shift));
    }

    function GET_OFFSET_APPROVAL_TABLE_DATA($id)
    {
        $sql = "SELECT offset_date,duration,offset_type FROM tbl_attendance_offsets where id=?";
        $query = $this->db->query($sql, array($id,));
        $query->next_result();
        return $query->result();
    }

    function GET_ACQUIRE_OFFSET_APPROVAL_TABLE_DATA($id)
    {
        $sql = "SELECT offset_date,duration,offset_type FROM tbl_attendance_offsets_acquire where id=?";
        $query = $this->db->query($sql, array($id,));
        $query->next_result();
        return $query->result();
    }

    function GET_OFFSET_APPROVERS($id)
    {
        $this->db->select('tb1.*');
        $this->db->select('CONCAT(tb2.col_last_name,IF(tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> "", CONCAT(" ",tb2.col_suffix, ""), ""), ", ",
        tb2.col_frst_name, " ",IF(tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> "", CONCAT(LEFT(tb2.col_midl_name, 1), "."), "")) as employee', false);
        $this->db->from('tbl_attendance_offsets as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        return $query->row();
        // $sql = "SELECT * FROM tbl_leaves_assign WHERE id=? ";
        // $query = $this->db->query($sql, array($id));
        // $query->next_result();
        // return $query->row();
    }

    function GET_TOTAL_REDEEMED_OFFSET($empl_id, $reset_date, $reset_date_2)
    {
        $sql = "SELECT SUM(duration) AS total_redeemed_offset FROM `tbl_attendance_offsets` WHERE empl_id = ? AND offset_type = 'Redeem' AND (status = 'Approved' OR status LIKE 'Pending%') AND offset_date >= ?";
        $query = $this->db->query($sql, array($empl_id, $reset_date));
        return $query->row();
    }


    function GET_TOTAL_ACQUIRED_OFFSET($empl_id, $reset_date = null, $reset_date_2 = null)
    {
        $sql = "SELECT SUM(duration) AS total_acquired_offset FROM `tbl_attendance_offsets_acquire` WHERE empl_id = ? AND offset_type = 'Acquire' AND status = 'Approved'";

        $params = array($empl_id);
        if ($reset_date && $reset_date_2) {
            $sql .= " AND offset_date > ? AND offset_date < ?";
            $params[] = $reset_date;
            $params[] = $reset_date_2;
        } elseif ($reset_date) {
            $sql .= " AND offset_date > ?";
            $params[] = $reset_date;
        } elseif ($reset_date_2) {
            $sql .= " AND offset_date > ?";
            $params[] = $reset_date_2;
        }

        $query = $this->db->query($sql, $params);
        return $query->row();
    }


    function GET_PAYSLIP_COORDINATES($setting)
    {
        $sql = "SELECT value FROM tbl_payroll_coordinates WHERE setting=?";
        $query = $this->db->query($sql, array($setting));
        $return = $query->row();
        if ($return) {
            return $return->value;
        } else {
            return null;
        }
    }

    function GET_ALL_PAYSLIP_OTHER_DEDUCTIONS($payslip_id)
    {
        if (empty($payslip_id) || $payslip_id == null) {
            return [];
        }
        $sql   = "SELECT payslip_id, deduction_id, code, value FROM tbl_payroll_payslip_otherdeductions WHERE payslip_id=$payslip_id";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }


    function GET_ALL_LOANS($empl_id)
    {
        $sql = "SELECT * FROM tbl_benefits_loan WHERE empl_id=?";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }

    function GET_NAME_PAYROLL_SCHEDULE($id)
    {
        $sql = "SELECT name FROM tbl_payroll_period WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();

        if ($result) {
            return $result->name;
        } else {
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


    // function GET_ALL_LEAVE_APPROVERS($id)
    // {
    //     $this->db->select('tb1.approver_1a, tb1.approver_1b, tb1.approver_2a, tb1.approver_2b, tb1.approver_3a, tb1.approver_3b, tb1.approver_4a, tb1.approver_4b, tb1.approver_5a, tb1.approver_5b,');
    //     $this->db->select("'Leave Approver' as type", false);
    //     $this->db->from('tbl_approvers_leave as tb1');
    //     $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id', 'left');
    //     $this->db->where('tb1.empl_id', $id);
    //     $query = $this->db->get();
    //     return $query->row();
    // }


    function GET_ALL_ACQUIRE_OFFSET_APPROVERS($id)
    {
        $this->db->from('tbl_approvers_offset_acquire as tb1');

        $approvers = ['1a','1b','2a','2b','3a','3b','4a','4b','5a','5b'];

        foreach ($approvers as $i => $ap) {
            $alias = "e" . ($i+1);
            $field = "approver_" . $ap;

            $this->db->select("
                CONCAT(
                    {$alias}.col_last_name,
                    IF({$alias}.col_suffix IS NOT NULL AND {$alias}.col_suffix <> '', CONCAT(' ', {$alias}.col_suffix), ''),
                    ', ',
                    {$alias}.col_frst_name, ' ',
                    IF({$alias}.col_midl_name IS NOT NULL AND {$alias}.col_midl_name <> '', CONCAT(LEFT({$alias}.col_midl_name,1), '.'), '')
                ) AS {$field}", false);

            $this->db->join("tbl_employee_infos as {$alias}", "tb1.{$field} = {$alias}.id", "left");
        }

        $this->db->select("'Acquire Offset Approver' as type", false);
        $this->db->where('tb1.empl_id', $id);
        $query = $this->db->get();
        return $query->row();
    }


    function GET_ALL_OFFSET_APPROVERS($id)
    {
        $this->db->from('tbl_approvers_offset as tb1');

        $approvers = ['1a','1b','2a','2b','3a','3b','4a','4b','5a','5b'];

        foreach ($approvers as $i => $ap) {
            $alias = "e" . ($i+1); 
            $field = "approver_" . $ap;

            $this->db->select("
                CONCAT(
                    {$alias}.col_last_name,
                    IF({$alias}.col_suffix IS NOT NULL AND {$alias}.col_suffix <> '', CONCAT(' ', {$alias}.col_suffix), ''),
                    ', ',
                    {$alias}.col_frst_name, ' ',
                    IF({$alias}.col_midl_name IS NOT NULL AND {$alias}.col_midl_name <> '', CONCAT(LEFT({$alias}.col_midl_name,1), '.'), '')
                ) AS {$field}", false);

            $this->db->join("tbl_employee_infos as {$alias}", "tb1.{$field} = {$alias}.id", "left");
        }

        $this->db->select("'Redeem Offset Approver' as type", false);
        $this->db->where('tb1.empl_id', $id);
        $query = $this->db->get();
        return $query->row();
    }


    function GET_ALL_TIME_ADJ_APPROVERS($id)
    {
        $this->db->from('tbl_approvers_timeadj as tb1');

        $approvers = ['1a','1b','2a','2b','3a','3b','4a','4b','5a','5b'];

        foreach ($approvers as $i => $ap) {
            $alias = "e" . ($i+1);
            $field = "approver_" . $ap;

            $this->db->select("
                CONCAT(
                    {$alias}.col_last_name,
                    IF({$alias}.col_suffix IS NOT NULL AND {$alias}.col_suffix <> '', CONCAT(' ', {$alias}.col_suffix), ''),
                    ', ',
                    {$alias}.col_frst_name, ' ',
                    IF({$alias}.col_midl_name IS NOT NULL AND {$alias}.col_midl_name <> '', CONCAT(LEFT({$alias}.col_midl_name,1), '.'), '')
                ) AS {$field}", false);

            $this->db->join("tbl_employee_infos as {$alias}", "tb1.{$field} = {$alias}.id", "left");
        }

        $this->db->select("'Time Adjustment Approver' as type", false);
        $this->db->where('tb1.empl_id', $id);
        $query = $this->db->get();
        return $query->row();
    }


    function GET_ALL_LEAVE_APPROVERS($id)
    {
        $this->db->from('tbl_approvers_leave as tb1');

        $approvers = [
            '1a','1b','2a','2b','3a','3b','4a','4b','5a','5b'
        ];

        foreach ($approvers as $i => $ap) {
            $alias = "e" . ($i+1); 
            $field = "approver_" . $ap;

            $this->db->select("
                CONCAT(
                    {$alias}.col_last_name,
                    IF({$alias}.col_suffix IS NOT NULL AND {$alias}.col_suffix <> '', CONCAT(' ', {$alias}.col_suffix), ''),
                    ', ',
                    {$alias}.col_frst_name, ' ',
                    IF({$alias}.col_midl_name IS NOT NULL AND {$alias}.col_midl_name <> '', CONCAT(LEFT({$alias}.col_midl_name,1), '.'), '')
                ) AS {$field}", false);

            $this->db->join("tbl_employee_infos as {$alias}", "tb1.{$field} = {$alias}.id", "left");
        }

        $this->db->select("'Leave Approver' as type", false);
        $this->db->where('tb1.empl_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function GET_ALL_OT_APPROVERS($id)
    {
        $this->db->from('tbl_approvers_ot as tb1');

        // Define approver fields
        $approvers = [
            '1a','1b','2a','2b','3a','3b','4a','4b','5a','5b'
        ];

        foreach ($approvers as $i => $ap) {
            $alias = "e" . ($i+1); // e1, e2, ...
            $field = "approver_" . $ap;

            // Build full name (same as leave approver)
            $this->db->select("
                CONCAT(
                    {$alias}.col_last_name,
                    IF({$alias}.col_suffix IS NOT NULL AND {$alias}.col_suffix <> '', CONCAT(' ', {$alias}.col_suffix), ''),
                    ', ',
                    {$alias}.col_frst_name, ' ',
                    IF({$alias}.col_midl_name IS NOT NULL AND {$alias}.col_midl_name <> '', CONCAT(LEFT({$alias}.col_midl_name,1), '.'), '')
                ) AS {$field}", false);

            // Join to employee table
            $this->db->join("tbl_employee_infos as {$alias}", "tb1.{$field} = {$alias}.id", "left");
        }

        // Add type
        $this->db->select("'Overtime/Holiday Work Approver' as type", false);

        // Condition
        $this->db->where('tb1.empl_id', $id);

        $query = $this->db->get();
        return $query->row();
    }
    







} // class selfservices_model extends CI_Model ================================
