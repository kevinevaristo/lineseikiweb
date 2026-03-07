<?php
class userguide_model extends CI_Model
{

    function getUserAccessInfo($employee_id)
    {
        $this->db->select('i.col_user_access, ua.*');
        $this->db->from('tbl_employee_infos i');
        $this->db->join('tbl_system_useraccess ua', 'i.col_user_access = ua.id', 'inner');
        $this->db->where('i.id', $employee_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
}
