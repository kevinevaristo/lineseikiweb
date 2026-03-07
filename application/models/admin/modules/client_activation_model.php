<?php

class client_activation_model extends CI_Model{

    function INSERT_NEW_ACCOUNT($empl_no,$username,$password,$lastname,$midlname,$firstname){

        $salt = bin2hex(openssl_random_pseudo_bytes(22));
        $encrypted_password = md5($password.''.$salt);
        $user_access = 2;

        $sql = "INSERT INTO tbl_employee_infos (col_empl_cmid, col_user_name, col_user_pass, col_salt_key, col_user_access, col_last_name, col_midl_name, col_frst_name) VALUES (?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($empl_no, $username, $encrypted_password, $salt, $user_access, $lastname, $midlname, $firstname ));
    }

    function IS_DUPLICATE($username){
        $sql = "SELECT * FROM tbl_employee_infos WHERE col_user_name=? ";
        $query = $this->db->query($sql, array($username));
        return $query->num_rows();
    }

    function GET_COMPANY_NAME(){
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'CompanyName'";
        return $this->db->query($query)->row_array();
    }

    function GET_NAVBAR(){
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'navbarLogo'";
        return $this->db->query($query)->row_array();
    }

    function UPDATE_COMPANY_NAME($data){
        foreach ($data as $id => $newdata) {
            $sql = "UPDATE tbl_system_setup SET value='".$newdata."' WHERE id= '".$id."'";
            $query = $this->db->query($sql);
        }
    }

    function UPDATE_LOGIN_LOGO($upload_img, $id){
        $sql = "UPDATE tbl_system_setup SET value=? WHERE id=?";
        $query = $this->db->query($sql,array($upload_img, $id));
    }

    function GET_OLD_LOGO($id){
        $sql = "SELECT value FROM tbl_system_setup WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $row = $query->row();
        return $row->value;
    }

    function UPDATE_ORG($data){
        foreach ($data as $id => $newdata) {
            $sql = "UPDATE tbl_system_setup SET value='".$newdata."' WHERE id= '".$id."'";
            $query = $this->db->query($sql);
        }
    }

    function UPDATE_CONTRIBUTIONS_SETTING($data){

        $date = date("Y-m-d H:i:s");
        foreach ($data as $id => $newdata) {
            $sql = "UPDATE tbl_system_setup SET create_date='".$date."', edit_date='".$date."', value='".$newdata."' WHERE id= '".$id."'";
            $query = $this->db->query($sql);
        }
    }

    function INSERT_DATE_COVERAGE($name,$data_from,$date_to,$pay_period,$year){
        $status = "Active";
        $now = date("Y/m/d H:i:s");
        $sql = "INSERT INTO tbl_payroll_period (create_date, edit_date, name, date_from, date_to, payout, status, year) VALUES (?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($now, $now, $name, $data_from, $date_to, $pay_period, $status, $year));
    }


    function INSERT_IP_ADDRESS($create_date, $ip_address){
        $status = "Active";
        $sql = "INSERT INTO tbl_system_whitelist (create_date, edit_date, ip_address, status) VALUES (?,?,?,?,?)";
        $query = $this->db->query($sql, array($create_date,$create_date, $ip_address, $status));
        return;
    }

    function UPDATE_SITE_RESTICTION_SETTING($data){

        $date = date("Y-m-d H:i:s");
        foreach ($data as $setting => $newdata) {
            $sql = "UPDATE tbl_system_setup SET create_date='".$date."', edit_date='".$date."', value='".$newdata."' WHERE setting= '".$setting."'";
            $query = $this->db->query($sql);
        }

        if ($query) {
            return "1";
        } else {
            return "0";
        }
    }

    function UPDATE_ACTIVATION_SETTING(){
        $sql = "UPDATE tbl_system_setup SET value=1 WHERE setting='activation'";
        $query = $this->db->query($sql);
    }


}