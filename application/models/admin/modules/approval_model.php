<?php
class approval_model extends CI_Model{
    function GET_TOKEN($token){
        $this->db->select('id,code,status');
        $this->db->where('code',$token);
        $this->db->where('expiration >= '."'".date('Y-m-d H:i:s')."'" );
        $query=$this->db->get('tbl_session');
        return $query->row();
    }
    function APPROVE_REQUEST($table,$id,$approver_col,$approver_id,$approver_date_col,$status){
        $this->db->set('status',$status);
        $this->db->set($approver_col,$approver_id);
        $this->db->set($approver_date_col,date('Y-m-d H:i:s'));
        $this->db->where('id',$id);
        return $this->db->update($table);
    }

    function UPDATE_TOKEN_STATUS($id,$status){
        $this->db->set('status',$status);
        $this->db->where('id',$id);
        return $this->db->update('tbl_session');
    }
    function GET_REQUEST_ASSIGN($table,$id)
    {
        $this->db->select('tb1.*');
        $this->db->select('CONCAT(tb2.col_last_name,IF(tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> "", CONCAT(" ",tb2.col_suffix, ""), ""), ", ",
        tb2.col_frst_name, " ",IF(tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> "", CONCAT(LEFT(tb2.col_midl_name, 1), "."), "")) as employee', false);
        $this->db->from( $table.' as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.empl_id=tb2.id','left');
        $this->db->where('tb1.id',$id);
        $query=$this->db->get();
        return $query->row();
    }
    
    function GET_EMPLOYEE_SPECIFIC_ROW($employee_id)
    {
        $sql = "SELECT id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->row();
    }
    
    function CHECK_STATUS($table,$col_date,$id){
        $this->db->select('*');
        $this->db->where('id',$id);
        $this->db->where($col_date,'0000-00-00 00:00:00');
        $query  = $this->db->get($table);
        $result = $query->row();
        if($result){
            return 1;
        } 
        return 0;
    }
    function ADD_NOTIFICATION($data)
    {
        $this->db->insert('tbl_notifications', $data);
        return $this->db->insert_id();
    }
    function SAVE_TOKEN($data){
        $this->db->insert('tbl_session', $data);
        return $this->db->insert_id();
    }
}