<?php
    class header_model extends CI_Model
    {
        function get_user_notifications($user_id){
            $this->db->select('*')
            ->where('empl_id',$user_id)
            ->where('is_read','0');
            $query=$this->db->get('tbl_notifications');
            return $query->num_rows();
        }
        function get_unseen_messages($userId){
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
        }
        // Removed tbl_system_setup functions:
        // - GET_MAYA_THEME()
        // - GET_END_TRIAL()
        // - CHECK_ADMIN()
        // Removed tbl_system_setup functions:
        // - get_header_content()
        // - get_logo()
        // - get_navbar()
        // - get_header()
        // Removed tbl_system_setup functions:
        // - get_status()
        // - get_company_status()
        // - get_employee_status()
        // - get_hr_status()
        // - get_attendance_status()
        // - get_leave_status()
        // - get_offset_status()
        // - get_payroll_status()
        // - get_rec_status()
        // - get_learn_status()
        // - get_teams_status()
        // - get_records_status()
        // - get_benefits_status()
        // - get_performance_status()
        // - get_rewards_status()
        // - get_exit_status()
        // - get_asset_status()
        // - get_proj_status()
        // - get_admin_status()
        // - get_messaging_status()
        // - get_overtime_status()

        function get_sadmin_status($id){
            $sql = "SELECT * FROM tbl_employee_infos WHERE id = ?";
            $query = $this->db->query($sql,array($id));
            $query->next_result();
            return $query->result();
        }
        //==================================================== USER ACCESS ===========================================================
        function get_user_access_id($id){
            $sql="SELECT col_user_access FROM tbl_employee_infos WHERE id=? LIMIT 1";
            return $this->db->query($sql,array($id))->row_array();
        }
        function get_user_access_modules($id){
            $sql = "SELECT user_modules FROM tbl_system_useraccess WHERE id=?";
            return $this->db->query($sql,array($id))->row_array();
        }
    }
