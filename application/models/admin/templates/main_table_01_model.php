<?php
class main_table_01_model extends CI_Model
{
    function get_data_list($table,$offset,$row,$tab,$view_type)                    //JERENZ: NO GET DATA LIST FOUND IN THE MAIN TABLE 01 CONTROLLER
    {
        if($view_type[0]=="all"){
            if($tab == 'All'){
                $query =  $this->db
                ->where('is_deleted', 0)
                ->order_by('id', 'DESC')
                ->get($table,$row,$offset);
                return $query->result();
            }
            else{
                $query =  $this->db
                ->where('is_deleted', 0)
                ->where('status', $tab)
                ->order_by('id', 'DESC')
                ->get($table,$row,$offset);
                return $query->result();
            }
        }
        else{
            if($tab == 'All'){
                $query =  $this->db
                ->where('is_deleted', 0)
                ->where($view_type[1], $view_type[2])
                ->order_by('id', 'DESC')
                ->get($table,$row,$offset);
                return $query->result();
            }
            else{
                $query =  $this->db
                ->where('is_deleted', 0)
                ->where($view_type[1], $view_type[2])
                ->where('status', $tab)
                ->order_by('id', 'DESC')
                ->get($table,$row,$offset);
                return $query->result();
            }            
        }
    }
    function get_data_count($table,$tab,$view_type)                                //JERENZ: NO GET DATA COUNT FOUND IN THE MAIN TABLE 01 CONTROLLER
    {
        if($view_type[0]=="all"){
            if($tab == 'All'){
                $query = $this->db
                ->where('is_deleted', 0)
                ->count_all_results($table);
                return $query;
            }
            else{
                $query = $this->db
                ->where('is_deleted', 0)
                ->where('status', $tab)
                ->count_all_results($table);
                return $query;
            }
        }
        else{
            if($tab == 'All'){
                $query = $this->db
                ->where('is_deleted', 0)
                ->where($view_type[1], $view_type[2])
                ->count_all_results($table);
                return $query;
            }
            else{
                $query = $this->db
                ->where('is_deleted', 0)
                ->where($view_type[1], $view_type[2])
                ->where('status', $tab)
                ->count_all_results($table);
                return $query;
            }
        }
    }
    function GET_DATA_ROW($table,$modal_id)
    {
        $query =  $this->db
        ->where('is_deleted', 0)
        ->where('id', $modal_id)
        ->get($table);
        return $query->result();
    }
    function get_display_count($table,$column,$value,$view_type)                    //JERENZ: NO DISPLAY COUNT FOUND IN THE MAIN TABLE 01 CONTROLLER
    {
        if($view_type[0]=="all"){
            if($value == 'All'){
                $query =  $this->db
                ->where('is_deleted', 0)
                ->count_all_results($table);
                return $query;
            }
            else{
                $query =  $this->db
                ->where('is_deleted', 0)
                ->where($column, $value)
                ->count_all_results($table);
                return $query;            
            }
        }
        else{
            if($value == 'All'){
                $query =  $this->db
                ->where('is_deleted', 0)
                ->where($view_type[1], $view_type[2])
                ->count_all_results($table);
                return $query;
            }
            else{
                $query =  $this->db
                ->where('is_deleted', 0)
                ->where($view_type[1], $view_type[2])
                ->where($column, $value)
                ->count_all_results($table);
                return $query;            
            }
        }
    }
    function GET_EMPL_NAME()
    {
        $query =  $this->db
        ->select("id, col_frst_name, col_last_name,col_midl_name,col_suffix")
        ->where('is_deleted', 0)
        ->get('tbl_employee_infos');
        return $query->result();
    }
    function EDIT_TABLE_ROW($table,$id,$set_array){
        $this->db
        ->set($set_array)
        ->where('id', $id)
        ->update($table);
    }
    function ADD_TABLE_ROW($table, $set_array){
        $this->db
        ->insert($table, $set_array);
    }
    function DELETE_TABLE_ROW($id,$table,$edit_user){
        $this->db
        ->set('is_deleted',1)
        ->set('edit_user',$edit_user)
        ->where('id', $id)
        ->update($table);
    }
    function EDIT_BULK_STATUS($table,$status,$ids,$edit_user)
    {
        $this->db
        ->set('status',$status)
        ->set('edit_user',$edit_user)
        ->where_in('id', $ids)
        ->update($table);
    }

    // function get_specific_data($table,$search,$row,$offset,$view_type)
    // {
    //     if($view_type[0]=="all"){
    //         $sql ="SELECT * FROM $table
    //         WHERE `id` LIKE '%$search%'
    //         OR `name` LIKE '%$search%'
    //         OR `status` LIKE '%$search%'
    //         ORDER BY id DESC
    //         LIMIT $offset,$row";
    //         $query = $this->db->query($sql);
    //         $query->next_result();
    //         return $query->result();
    //     }
    //     else{
    //         $sql ="SELECT * FROM $table
    //         WHERE (`id` LIKE '%$search%'
    //         OR `name` LIKE '%$search%'
    //         OR `status` LIKE '%$search%')
    //         AND $view_type[1] = $view_type[2];
    //         ORDER BY id DESC
    //         LIMIT $offset,$row";
    //         $query = $this->db->query($sql);
    //         $query->next_result();
    //         return $query->result();
    //     }
    // }

    function get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type)                         //JERENZ: NO GET SPECIFIC DATA FOUND IN THE MAIN TABLE 01 CONTROLLER
    {
        if($view_type[0]=="all"){
            $sql ="SELECT * FROM $table
            WHERE $tab_filter=? AND (";
            $fields = $this->db->list_fields($table);
            foreach ($fields as $field)
            {
                $sql .= "$table.$field LIKE '%$search%'";
                if ($field !== end($fields)) {
                    $sql .= " OR ";
                }
            } 
            $sql .= ") ORDER BY id DESC LIMIT $offset,$row";
            $query = $this->db->query($sql,array($tab));
            $query->next_result();
            return $query->result();
        }
        else{
            $sql ="SELECT * FROM $table
            WHERE $tab_filter=? AND (";
            $fields = $this->db->list_fields($table);
            foreach ($fields as $field)
            {
                $sql .= "$table.$field LIKE '%$search%'";
                if ($field !== end($fields)) {
                    $sql .= "AND $view_type[1] = $view_type[2] OR ";
                }
            } 
            $sql .= ") ORDER BY id DESC LIMIT $offset,$row";
            $query = $this->db->query($sql,array($tab));
            $query->next_result();
            return $query->result();
        }
    }


    function MOD_CHECK_IF_DUPLICATE($queryArr,$table)
    {
        $query = $this->db->select('id')->from($table)->where($queryArr)->get();
        return $query->num_rows();
    }
    function MOD_INSERT_POSITIONS($name,$edit_user,$table_name, $status)
    {
        $date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO $table_name (create_date, edit_date, name, status, edit_user) VALUES (?,?,?,?,?)";
        $this->db->query("SET NAMES 'utf8'");
        $this->db->query("SET CHARACTER SET 'utf8'");
        $query = $this->db->query($sql,array($date,$date,$name,$status,$edit_user));
        return $this->db->insert_id();
    }

    function CHECK_DUPLICATE($table, $name){
        $sql = "SELECT id FROM $table WHERE name=?";
        $query = $this->db->query($sql,$name);
        return $query->num_rows();
    }

    function get_standard_data($table_name){

        if($table_name == "tbl_std_allowances_tax" || $table_name ==  "tbl_std_allowances_nontax" || $table_name == "tbl_std_deductions_nontax" || $table_name ==  "tbl_std_deductions_tax"){
            $sql = "SELECT id,name,status,type FROM $table_name WHERE is_deleted = 0";
        }
        elseif ($table_name == "tbl_biometrics"){
            $sql = "SELECT id,terminal_sn,name,status FROM $table_name  WHERE is_deleted = 0";
        }
        elseif ($table_name == "tbl_std_holidays"){
            $sql = "SELECT id,col_holi_date,name,col_holi_type,year,status FROM $table_name  WHERE is_deleted = 0";
        }
        else{
            $sql = "SELECT id,name,status FROM $table_name WHERE is_deleted = 0";
        }
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function update_data($tableName, $data){
        $date           = date('Y-m-d H:i:s');
        
        if($tableName == "tbl_std_allowances_tax" || $tableName ==  "tbl_std_allowances_nontax" || $tableName == "tbl_std_deductions_nontax" || $tableName ==  "tbl_std_deductions_tax"){
            $name           = $data[1];
            $status         = $data[2];
            $type         = $data[3];

            if($data[0] == null){
                $sql = "INSERT INTO $tableName (create_date, edit_date, name, type, status) VALUES (?,?,?,?,?)";
                $this->db->query($sql,array($date,$date,$name,$type,$status));
            }else{
                $sql = "UPDATE $tableName SET edit_date=?, name=?, type=?, status=?  WHERE id=?";
                $query = $this->db->query($sql, array($date, $name, $type, $status, $data[0]));
            }

        }
        elseif ($tableName == "tbl_biometrics"){
            $terminal_sn           = $data[1];
            $name                  = $data[2];
            $status                = $data[3];

            if($data[0] == null){
                $sql = "INSERT INTO $tableName (create_date, edit_date, terminal_sn, name, status) VALUES (?,?,?,?,?)";
                $this->db->query($sql,array($date, $date, $terminal_sn, $name, $status));
            }else{
                $sql = "UPDATE $tableName SET edit_date=?, terminal_sn=?, name=?, status=?  WHERE id=?";
                $query = $this->db->query($sql, array($date, $terminal_sn, $name, $status, $data[0]));
            }
        }
        elseif ($tableName == "tbl_std_holidays"){
            $holiday_date           = $data[1];
            $name                   = $data[2];
            $type                   = $data[3];
            $year                   = $data[4];
            $status                 = $data[5];

            if($data[0] == null){
                $sql = "INSERT INTO $tableName (create_date, edit_date, col_holi_date, name, col_holi_type, year, status) VALUES (?,?,?,?,?,?,?)";
                $this->db->query($sql,array($date, $date, $holiday_date, $name, $type, $year, $status));
            }else{
                $sql = "UPDATE $tableName SET edit_date=?, col_holi_date=?, name=?, col_holi_type=?, year=?, status=?  WHERE id=?";
                $query = $this->db->query($sql, array($date, $holiday_date, $name, $type, $year, $status, $data[0]));
            }
        }
        else{
            $name           = $data[1];
            $status         = $data[2];
            if($data[0] == null){
                $sql = "INSERT INTO $tableName (create_date, edit_date, name, status) VALUES (?,?,?,?)";
                $this->db->query($sql,array($date,$date,$name,$status));
            }else{
                $sql = "UPDATE $tableName SET edit_date=?, name=?, status=?  WHERE id=?";
                $query = $this->db->query($sql, array($date, $name, $status, $data[0]));
            }
        }
    }

}