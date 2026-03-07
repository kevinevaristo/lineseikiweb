<?php
class administrators_model extends CI_Model
{
    function GET_USERS()
    {                                   
        $sql   = "SELECT * FROM tbl_employee_infos";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
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

    function GET_ACTIVITY_LOGS()
    {
        $sql   ="SELECT * FROM tbl_activity_logs  ORDER BY create_date DESC";
        $query = $this->db->query($sql, array());
        return $query->result_array();
    }

    function GET_EMPLOYEE_IDS()
    {
        $sql   ="SELECT id,col_empl_cmid FROM tbl_employee_infos";
        $query = $this->db->query($sql, array());
        return $query->result_array();
    }

    function SET_ACTIVATION_EMPLOYEE($id,$is_active){
        $sql   = "UPDATE tbl_employee_infos SET disabled=? WHERE id=?";
        $query = $this->db->query($sql, array($is_active, $id));
    }

    function GET_MODULE_ACCESS()
    {
        $sql   = "SELECT setting,value FROM tbl_system_setup where id>=7 AND id<=22";
        $res   = $this->db->query($sql)->result_array();
        $new_data=array();
        foreach($res as $res_data){
            $new_data[$res_data["setting"]]=$res_data["value"];
        }
        return $new_data;
    }

    function GET_ALL_USER_ACCESS()
    {
        $sql   = "SELECT * FROM tbl_system_useraccess";
        return $this->db->query($sql)->result_array();
    }

    function GET_HOME_ANNOUNCEMENT()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_announcement'";
        return $this->db->query($query)->row_array();
    }

    function GET_HOME_CELEBRATION()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_celebration'";
        return $this->db->query($query)->row_array();
    }

    function GET_HOME_DATE()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_date'";
        return $this->db->query($query)->row_array();
    }

    function GET_HOME_LEAVE()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_leave_info'";
        return $this->db->query($query)->row_array();
    }

    function GET_HOME_WHOS_OUT()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_whos_out'";
        return $this->db->query($query)->row_array();
    }

    function GET_HOME_START_GUIDE()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_start_guide'";
        return $this->db->query($query)->row_array();
    }

    function GET_HOME_NEW_MEMBER()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'home_new_member'";
        return $this->db->query($query)->row_array();
    }

    function GET_COMP_STRUCTURE()
    {
        $sql   = "SELECT * FROM tbl_system_setup";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function ADD_USER_ACCESS($user,$data,$modules)
    {
        if(empty($user)){
            return;
        }
        $sql   = "INSERT INTO tbl_system_useraccess (user_access,user_page,user_modules) VALUES (?,?,?)";
        $query = $this->db->query($sql, array($user,$data,$modules));
        return $this->db->insert_id();
    }

    function GET_USER_ACCESS_BY_ID($id)
    {
        $sql   = "SELECT user_page FROM tbl_system_useraccess WHERE id=?";
        return $this->db->query($sql,array($id))->result_array();
    }

    function UPDATE_USER_ACCESS($id,$data,$modules)
    {                
        $sql   = "UPDATE tbl_system_useraccess SET user_page=?,user_modules=? WHERE id=?";
        return $this->db->query($sql,array($data,$modules,$id));
    }

    function UPDATE_USER_ACCESS_DATA($id,$data,$modules)
    {
        $sql   = "UPDATE tbl_system_useraccess SET user_page=?,user_modules=? WHERE id=?";
        return $this->db->query($sql,array($data,$modules,$id));
    }

    function MOD_RESET_USER_PASSWORD($empl_id, $reset_pass)
    {
        $salt     = bin2hex(openssl_random_pseudo_bytes(22));
        $password = ucfirst($reset_pass);
        $encrypted_password = md5($password.''.$salt);

        $sql   = "UPDATE tbl_employee_infos SET col_user_pass=?,col_salt_key=?,password_attempt=0, real_pass=0 WHERE id=?";
        $query = $this->db->query($sql, array($encrypted_password,$salt,$empl_id));
        return 'Employee Password has been Reset!';
    }

    function MOD_UPDT_USER_ACCESS($user_access, $remote_attendance, $empl_id)
    {
        $sql   = "UPDATE tbl_employee_infos SET col_user_access=?, remote_att=? WHERE id=?";
        $query = $this->db->query($sql, array($user_access, $remote_attendance, $empl_id));
        return 'User Access Updated!';
    }

    function MOD_UPDATE_STATUS($stat, $id)
    {                         
        $sql   = "UPDATE tbl_system_setup SET value=? WHERE id=?";
        $query = $this->db->query($sql, array($stat, $id));
    }

    function MOD_INSERT_IP($ip_add,$remarks, $status)
    {              
        $sql   = "INSERT INTO tbl_system_whitelist (ip_address, remarks, status) VALUES (?,?,?)";
        $query = $this->db->query($sql, array($ip_add,$remarks, $status));
        return;
    }

    function GET_IP_ADDRESS()
    {                                      
        $sql   = "SELECT * FROM tbl_system_whitelist WHERE is_deleted=0";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_DELETE_IP_ADDRESS($id)
    {
        $sql = "UPDATE tbl_system_whitelist SET is_deleted=1 WHERE id=?";
        $query = $this->db->query($sql, array($id));
    }
    
}