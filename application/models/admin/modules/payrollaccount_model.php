<?php
class payrollaccount_model extends CI_Model{
    function CHECKACCOUNT($username,$password){
        $sql="SELECT id FROM tbl_special_account WHERE username=? AND password=?";
        $query=$this->db->query($sql,array($username,$password));
        $query->next_result();
        return $query->row();
    }
}