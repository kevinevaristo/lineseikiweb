<?php
class admin_model extends CI_Model
{
    function new_user($reated_at,$name_first,$name_middle,$name_last,$name_suffix,$birthdate,$gender,$mobile,$email,$password)
    {
        $sql = "INSERT INTO tbl_users (created_at,name_first,name_middle,name_last,name_suffix,birthdate,gender,mobile,email,password) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql,array($reated_at,$name_first,$name_middle,$name_last,$name_suffix,$birthdate,$gender,$mobile,$email,$password));
    }
}
?>