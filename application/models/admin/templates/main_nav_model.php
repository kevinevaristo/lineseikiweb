<?php
class main_nav_model extends CI_Model{
    function get_user_access_page($id){
        $query = $this->db
         ->select('user_page')
         ->where('id', $id)
         ->get('tbl_system_useraccess');
        return $query->row_array(); 
    }
    function get_user_access_modules($empl_id) {
        $this->db->select('tbl_system_useraccess.user_modules');
        $this->db->from('tbl_employee_infos');
        $this->db->join('tbl_system_useraccess', 'tbl_employee_infos.col_user_access = tbl_system_useraccess.id', 'inner');
        $this->db->where('tbl_employee_infos.id', $empl_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->user_modules;
        } else {
            return null;
        }
    }
    function get_user_access_pages($empl_id) {
        $this->db->select('tbl_system_useraccess.user_page');
        $this->db->from('tbl_employee_infos');
        $this->db->join('tbl_system_useraccess', 'tbl_employee_infos.col_user_access = tbl_system_useraccess.id', 'inner');
        $this->db->where('tbl_employee_infos.id', $empl_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->user_page;
        } else {
            return null;
        }
    }
    function get_user_access_id($id){
        $query = $this->db
        ->select('col_user_access')
        ->where('id', $id)
        ->get('tbl_employee_infos');
       return $query->row_array(); 
    }
}