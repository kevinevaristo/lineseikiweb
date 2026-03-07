<?php
class main_table_02_model extends CI_Model
{
    function get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type)                     //JERENZ: NO GET DATA LIST FOUND IN THE MAIN TABLE 02 CONTROLLER
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
                ->where($tab_filter, $tab)
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
                ->where($tab_filter, $tab)
                ->order_by('id', 'DESC')
                ->get($table,$row,$offset);
                return $query->result();
            }            
        }
    }
    function get_data_list2($table,$offset,$row,$tab,$tab_filter,$view_type, $sortColumn, $sortType)                     //JERENZ: NO GET DATA LIST FOUND IN THE MAIN TABLE 02 CONTROLLER
    {
        if($view_type[0]=="all"){
            if($tab == 'All'){
                $query =  $this->db
                ->where('is_deleted', 0)
                ->order_by($sortColumn, $sortType)
                ->get($table,$row,$offset);
                return $query->result();
            }
            else{
                $query =  $this->db
                ->where('is_deleted', 0)
                ->where($tab_filter, $tab)
                ->order_by($sortColumn, $sortType)
                ->get($table,$row,$offset);
                return $query->result();
            }
        }
        else{
            if($tab == 'All'){
                $query =  $this->db
                ->where('is_deleted', 0)
                ->where($view_type[1], $view_type[2])
                ->order_by($sortColumn, $sortType)
                ->get($table,$row,$offset);
                return $query->result();
            }
            else{
                $query =  $this->db
                ->where('is_deleted', 0)
                ->where($view_type[1], $view_type[2])
                ->where($tab_filter, $tab)
                ->order_by($sortColumn, $sortType)
                ->get($table,$row,$offset);
                return $query->result();
            }            
        }
    }
    function get_data_count($table,$tab,$tab_filter,$view_type)                     //JERENZ: NO GET DATA COUNT FOUND IN THE MAIN TABLE 02 CONTROLLER
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
                ->where($tab_filter, $tab)
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
                ->where($tab_filter, $tab)
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
    function get_display_count($table,$column,$value,$view_type)                    //JERENZ: NO GET DISPLAY COUNT FOUND IN THE MAIN TABLE 02 CONTROLLER
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
    function get_employee_list(){
        $this->db->select('id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name');
        $this->db->where("disabled = 0 AND termination_date IS NULL ");
        $query=$this->db->get('tbl_employee_infos');
        return $query->result();
    }
    function GET_EMPL_NAME()                //JERENZ: DISABLED IN THE MAIN TABLE 02 CONTROLLER
    {
        $query =  $this->db
        ->select("id,col_suffix,col_midl_name, col_empl_cmid, col_frst_name, col_last_name")
        ->where('is_deleted', 0)
        ->where('disabled', 0)
        ->get('tbl_employee_infos');
        return $query->result();
    }

    function GET_STD_ID_NAME($table)        //JERENZ: NO GET STD ID NAME FOUND IN THE MAIN TABLE 02 CONTROLLER
    {
        if($table != ""){
            $query =  $this->db
            ->select("id, name")
            ->where('is_deleted', 0)
            ->get($table);
            return $query->result();
        }

    }


    // function get_allowance_name()
    // {
    //     $query =  $this->db
    //     ->select("id, name")
    //     ->where('is_deleted', 0)
    //     ->get('tbl_std_allowances');
    //     return $query->result();
    // }

    function get_deduction_name()                       //JERENZ: NO GET DEDUCTION NAME FOUND IN THE MAIN TABLE 02 CONTROLLER
    {
        $query =  $this->db
        ->select("id, name")
        ->where('is_deleted', 0)
        ->get('tbl_std_deductions');
        return $query->result();
    }
    function get_skill_name()                          //JERENZ: NO GET SKILL NAME FOUND IN THE MAIN TABLE 02 CONTROLLER
    {
        $query =  $this->db
        ->select("id, name")
        ->where('is_deleted', 0)
        ->get('tbl_empl_skill');
        return $query->result();
    }
    function get_skill_level()                          //JERENZ: NO GET SKILL LEVEL FOUND IN THE MAIN TABLE 02 CONTROLLER
    {
        $query =  $this->db
        ->select("id, name")
        ->where('is_deleted', 0)
        ->get('tbl_std_skilllevels');
        return $query->result();
    }
    function EDIT_TABLE_ROW($table,$id,$set_array){
        $this->db
        ->set($set_array)
        ->where('id', $id)
        ->update($table);
        return $this->db->affected_rows() > 0;
    }
    function ADD_TABLE_ROW($table, $set_array){
        $this->db
        ->insert($table, $set_array);
        return $this->db->affected_rows() > 0;
    }
    function DELETE_TABLE_ROW($id,$table,$edit_user,$edit_date){
        $this->db
        ->set('is_deleted',1)
        ->set('edit_user',$edit_user)
        ->set('edit_date',$edit_date)
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
        return $this->db->affected_rows() > 0;
    }





    function get_specific_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type)                 //JERENZ: NO GET SPECIFIC DATA FOUND IN THE MAIN TABLE 02 CONTROLLER
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
    function get_specific_data2($tab,$tab_filter,$table,$search,$row,$offset,$view_type, $sortColumn, $sortType)                 //JERENZ: NO GET SPECIFIC DATA FOUND IN THE MAIN TABLE 02 CONTROLLER
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
            $sql .= ") ORDER BY ".$sortColumn." DESC LIMIT $offset,$row"; 
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
            $sql .= ") ORDER BY ".$sortColumn." DESC LIMIT $offset,$row";
            $query = $this->db->query($sql,array($tab));
            $query->next_result();
            return $query->result();
        }
    }

    function get_specific_with_empl_data_2($tab,$tab_filter,$table,$search,$row,$offset,$view_type)                 //JERENZ: NO GET SPECIFIC WITH EMPL DATA 2 FOUND IN THE MAIN TABLE 02 CONTROLLER
    {
        if($view_type[0]=="all"){

            $sql = "SELECT * FROM tbl_employee_infos
            INNER JOIN $table ON $table.employee_id = tbl_employee_infos.id
            WHERE $tab_filter=? AND (";
            $fields = $this->db->list_fields($table);
            foreach ($fields as $field)
            {
                if ($field != 'create_date' || $field != 'edit_date' || $field != 'is_deleted' || $field != 'attachment'){
                    $sql .= "$table.$field LIKE '%$search%' OR ";
                }
            }
            $sql .= "col_last_name LIKE '%$search%'
                    OR col_midl_name LIKE '%$search%'
                    OR col_frst_name LIKE '%$search%')
                    ORDER BY $table.id DESC LIMIT $offset,$row";
                    
            if(is_numeric($search)){
                $sql = "SELECT * FROM tbl_employee_infos 
                INNER JOIN $table ON $table.employee_id = tbl_employee_infos.id
                WHERE $tab_filter=? AND tbl_employee_infos.id=$search ORDER BY $table.id DESC LIMIT $offset,$row";
            }
            $query = $this->db->query($sql,array($tab));
            $query->next_result();
            return $query->result();
        }
        else{

            $sql = "SELECT * FROM tbl_employee_infos
            INNER JOIN $table ON $table.employee_id = tbl_employee_infos.id
            WHERE $tab_filter=? AND (";
            $fields = $this->db->list_fields($table);
            foreach ($fields as $field)
            {
                $sql .= "$table.$field LIKE '%$search%' AND $table.$view_type[1] = $view_type[2] OR ";
            }
            $sql .= "col_last_name LIKE '%$search%'
                    OR col_midl_name LIKE '%$search%'
                    OR col_frst_name LIKE '%$search%')
                    AND $table.$view_type[1] = $view_type[2]
                    ORDER BY $table.id DESC LIMIT $offset,$row";
            if(is_numeric($search)){
                $sql = "SELECT * FROM tbl_employee_infos 
                INNER JOIN $table ON $table.employee_id = tbl_employee_infos.id
                WHERE  $tab_filter=? AND tbl_employee_infos.id=$search ORDER BY $table.id DESC LIMIT $offset,$row";
            }
            $query = $this->db->query($sql,array($tab));
            $query->next_result();
            return $query->result();
        }
    }


    function get_specific_with_empl_data($tab,$tab_filter,$table,$search,$row,$offset,$view_type)               //JERENZ: NO GET SPECIFIC WITH EMPL DATA FOUND IN THE MAIN TABLE 02 CONTROLLER
    {

        if($view_type[0]=="all"){

            $sql = "SELECT * FROM tbl_employee_infos
            INNER JOIN $table ON $table.empl_id = tbl_employee_infos.id
            WHERE $tab_filter=? AND (";
            $fields = $this->db->list_fields($table);
            foreach ($fields as $field)
            {
                $sql .= "$table.$field LIKE '%$search%' OR ";
            }
            $sql .= "col_last_name LIKE '%$search%'
                    OR col_midl_name LIKE '%$search%'
                    OR col_frst_name LIKE '%$search%')
                    ORDER BY $table.id DESC LIMIT $offset,$row";
            $query = $this->db->query($sql,array($tab));
            $query->next_result();
            return $query->result();
        }
        else{

            $sql = "SELECT * FROM tbl_employee_infos
            INNER JOIN $table ON $table.empl_id = tbl_employee_infos.id
            WHERE $tab_filter=? AND (";
            $fields = $this->db->list_fields($table);
            foreach ($fields as $field)
            {
                $sql .= "$table.$field LIKE '%$search%' AND $view_type[1] = $view_type[2] OR ";
            }
            $sql .= "col_last_name LIKE '%$search%'
                    OR col_midl_name LIKE '%$search%'
                    OR col_frst_name LIKE '%$search%')
                    AND $view_type[1] = $view_type[2]
                    ORDER BY $table.id DESC LIMIT $offset,$row";
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
        $sql = "INSERT INTO $table_name (name, status, edit_user) VALUES (?,?,?)";
        $this->db->query("SET NAMES 'utf8'");
        $this->db->query("SET CHARACTER SET 'utf8'");
        $query = $this->db->query($sql,array($name,$status,$edit_user));
        return $this->db->insert_id();
    }
}