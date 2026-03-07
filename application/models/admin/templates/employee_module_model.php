<?php
class employee_module_model extends CI_Model
{
    function get_data_list($table,$offset,$row,$tab,$tab_filter,$view_type,$dept,$sec,$group,$line,$branch,$division,$team,$status)
    {
        if($dept){
            $filter_q = " AND col_empl_dept=".$dept;
        }else if($sec){
            $filter_q = " AND col_empl_sect=".$sec;
        }else if($group){
            $filter_q = " AND col_empl_group=".$group;
        }
        else if($line){
            $filter_q = " AND col_empl_line=".$line;
        }
        else if($branch){
            $filter_q = " AND col_empl_branch=".$branch;
        }
        else if($division){
            $filter_q = " AND col_empl_divi=".$division;
        }
        else if($team){
            $filter_q = " AND col_empl_team=".$team;
        }
        else if($status){
            $filter_q = " AND disabled=".$status;
        }else{
            $filter_q = "";
        }
        
        if($view_type[0]=="all"){
            if($tab == 'All'){
                $query =  $this->db
                ->where('is_deleted', 0)
                ->order_by('id', 'DESC')
                ->get($table,$row,$offset);
                return $query->result();
            }
            else{
                // $query =  $this->db
                // ->where('is_deleted', 0)
                // ->where($tab_filter, $tab)
                // ->order_by('id', 'DESC')
                // ->get($table,$row,$offset);
                // return $query->result();
                
                $sql = "SELECT * FROM ".$table." 
                LEFT JOIN tbl_employee_infos ON ".$table.".username=tbl_employee_infos.id
                WHERE ".$table.".is_deleted = 0 AND ".$tab_filter." = '".$tab."' " .$filter_q. " ORDER BY ".$table.".id DESC LIMIT ".$row;
                $query = $this->db->query($sql);
                $query->next_result();
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
    function get_data_count($table,$tab,$tab_filter,$view_type)
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
    function get_data_row($table,$modal_id)
    {
        $query =  $this->db
        ->where('is_deleted', 0)
        ->where('id', $modal_id)
        ->get($table);
        return $query->result();
    }
    function get_display_count($table,$column,$value,$view_type)
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
        ->select("id, col_empl_cmid, col_frst_name, col_last_name")
        ->where('is_deleted', 0)
        ->get('tbl_employee_infos');
        return $query->result();
    }

    function GET_STD_ID_NAME($table)
    {
        if($table != ""){
            $query =  $this->db
            ->select("id, name")
            ->where('is_deleted', 0)
            ->get($table);
            return $query->result();
        }

    }


    function get_allowance_name()
    {
        $query =  $this->db
        ->select("id, name")
        ->where('is_deleted', 0)
        ->get('tbl_std_allowances');
        return $query->result();
    }
    function get_deduction_name()
    {
        $query =  $this->db
        ->select("id, name")
        ->where('is_deleted', 0)
        ->get('tbl_std_deductions');
        return $query->result();
    }
    function get_skill_name()
    {
        $query =  $this->db
        ->select("id, name")
        ->where('is_deleted', 0)
        ->get('tbl_empl_skill');
        return $query->result();
    }
    function get_skill_level()
    {
        $query =  $this->db
        ->select("id, name")
        ->where('is_deleted', 0)
        ->get('tbl_std_skilllevels');
        return $query->result();
    }
    function edit_table_row($table,$id,$set_array){
        $this->db
        ->set($set_array)
        ->where('id', $id)
        ->update($table);
    }
    function add_table_row($table, $set_array){
        $this->db
        ->insert($table, $set_array);
    }
    function delete_table_row($id,$table,$edit_user,$edit_date){
        $this->db
        ->set('is_deleted',1)
        ->set('edit_user',$edit_user)
        ->set('edit_date',$edit_date)
        ->where('id', $id)
        ->update($table);
    }
    function edit_bulk_status($table,$status,$ids,$edit_user)
    {
        $this->db
        ->set('status',$status)
        ->set('edit_user',$edit_user)
        ->where_in('id', $ids)
        ->update($table);
    }
    function get_specific_data($table,$search,$row,$offset,$view_type)
    {
        if($view_type[0]=="all"){
            $sql ="SELECT * FROM $table
            WHERE `id` LIKE '%$search%'
            OR `name` LIKE '%$search%'
            OR `status` LIKE '%$search%'
            ORDER BY id DESC
            LIMIT $offset,$row";
            $query = $this->db->query($sql);
            $query->next_result();
            return $query->result();
        }
        else{
            $sql ="SELECT * FROM $table
            WHERE (`id` LIKE '%$search%'
            OR `name` LIKE '%$search%'
            OR `status` LIKE '%$search%')
            AND $view_type[1] = $view_type[2];
            ORDER BY id DESC
            LIMIT $offset,$row";
            $query = $this->db->query($sql);
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