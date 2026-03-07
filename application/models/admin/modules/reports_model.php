<?php
class reports_model extends CI_Model{
    function GET_CUT_OFF_LIST(){
        $this->db->select('id, name,date_from,date_to');
        $this->db->where('status','Active');
        $this->db->order_by('date_to','DESC');
        $query = $this->db->get('tbl_payroll_period');
        return $query->result_object();
    }
    function isUserPageFound($page, $userId){
        $query = $this->db->query
        ("SELECT COUNT(*) AS count 
        FROM tbl_system_useraccess AS ua 
        JOIN tbl_employee_infos ON tbl_employee_infos.col_user_access = ua.id 
        WHERE FIND_IN_SET(?, ua.user_page) 
        AND tbl_employee_infos.id = ?", array($page, $userId));
        $result = $query->row();
        return $result->count;
    }
    
    function getCustomGroupActive(){
        $this->db->select('id, name');
        $this->db->where('status','Active');
        $query = $this->db->get('tbl_std_custom_groups');
        return $query->result();
    }
    function GET_CUT_OFF($id){
        $this->db->select('id, name,date_from,date_to');
        $this->db->where('status','Active');
        $this->db->where('id',$id);
        $query = $this->db->get('tbl_payroll_period');
        return $query->row();
    }

    function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'maiya_reset'";
        return $this->db->query($query)->row_array();
    }
    function GET_EMPLOYEE_LISTS($limit,$offset){
        $this->db->select("id,col_empl_cmid",false);
        $this->db->select("CONCAT_WS('',
                IF(col_suffix='' OR col_suffix IS NULL,CONCAT(col_last_name,',',col_frst_name),CONCAT(col_last_name,' ',col_suffix,',',col_frst_name)),
                IF(CONCAT(LEFT(col_midl_name,1),'.')='.','',CONCAT(' ',LEFT(col_midl_name,1),'.'))
        ) AS fullname",false);
        $this->db->where('disabled',0);
        $this->db->where('termination_date IS NULL');
        $this->db->limit($limit,$offset);
        $this->db->order_by('col_empl_cmid + 0','ASC');
        $query=$this->db->get('tbl_employee_infos');
        return $query->result();
        
    }
    function GET_EMPLOYEE_LISTS_COUNT(){
        $this->db->select("id,col_empl_cmid",false);
        $this->db->select("CONCAT_WS('',
                IF(col_suffix='' OR col_suffix IS NULL,CONCAT(col_last_name,',',col_frst_name),CONCAT(col_last_name,' ',col_suffix,',',col_frst_name)),
                IF(CONCAT(LEFT(col_midl_name,1),'.')='.','',CONCAT(' ',LEFT(col_midl_name,1),'.'))
        ) AS fullname",false);
        $this->db->where('disabled',0);
        $this->db->where('termination_date IS NULL');
        $this->db->order_by('col_empl_cmid + 0','ASC');
        $query=$this->db->get('tbl_employee_infos');
        return $query->num_rows();
    }
    function GET_EMPLOYEE($ids){ 
        $this->db->select("id,col_curr_addr,salary_rate,col_home_addr,col_mobl_numb,col_empl_cmid,col_empl_emai,col_empl_btin,col_birt_date",false);
        $this->db->select("DATE_FORMAT(col_birt_date,'%m%d%Y') as birth_date",false);
        // $this->db->select("CONCAT_WS('',
        //         IF(col_suffix='' OR col_suffix IS NULL,CONCAT(col_last_name,',',col_frst_name),CONCAT(col_last_name,' ',col_suffix,',',col_frst_name)),
        //         IF(CONCAT(LEFT(col_midl_name,1),'.')='.','',CONCAT(' ',col_midl_name,'.'))
        // ) AS fullname",false);
        $this->db->select("CONCAT_WS(' ',col_last_name,col_suffix,col_frst_name,col_midl_name) as fullname",false);
        $this->db->where_in('id',$ids);
        $this->db->where('disabled',0);
        $this->db->where('termination_date IS NULL');
        
        $this->db->order_by('col_empl_cmid + 0','asc');
        $query=$this->db->get('tbl_employee_infos');
        return $query->result();
    }
    function GET_ALL_EMPLOYEE(){
        $this->db->select("tb1.id,col_last_name,col_frst_name,left(col_midl_name,1) as col_midl_name,col_curr_addr,col_empl_sssc,col_empl_sssc,resignation_date,tb2.name as position,
        CAST(salary_rate as DECIMAL(65,2)) as salary_rate,col_home_addr,col_mobl_numb,col_empl_cmid,col_empl_emai,col_empl_btin,DATE_FORMAT(col_hire_date, '%m%d%Y') as date_hire,
        DATE_FORMAT(col_hire_date, '%m/%d/%Y') as hire_date,DATE_FORMAT(col_birt_date, '%m%d%Y') as birth_date,DATE_FORMAT(resignation_date, '%m%d%Y') as sep_date",false);
        $this->db->select("CONCAT_WS('',
                IF(col_suffix='' OR col_suffix IS NULL,CONCAT(col_last_name,',',col_frst_name),CONCAT(col_last_name,' ',col_suffix,',',col_frst_name)),
                IF(CONCAT(LEFT(col_midl_name,1),'.')='.','',CONCAT(' ',LEFT(col_midl_name,1),'.'))
        ) AS formated_fullname",false);
        $this->db->select("CONCAT_WS(' ',col_last_name,col_frst_name,col_midl_name,col_suffix) as fullname",false);
        $this->db->from('tbl_employee_infos as tb1');
        $this->db->join('tbl_std_positions as tb2','tb1.col_empl_posi=tb2.id','left');
        $this->db->where('disabled',0);
        $this->db->where('termination_date IS NULL');
        
        $this->db->order_by('col_empl_cmid + 0','asc');
        $query=$this->db->get();
        return $query->result();
    }

    function GET_LEAVES_SEARCH($date_from,$date_to, $empl_id, $filter_arr){

        $new_filter = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb2.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb2.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb2.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb2.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select('tb1.id,tb2.col_empl_cmid,tb1.leave_date, tb3.name as type, tb1.duration, tb1.status');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_leaves_assign as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->join('tbl_std_leavetypes as tb3', 'tb1.type = tb3.id', 'left');

        $this->db->where("tb1.leave_date between '$date_from' AND '$date_to' ");
        // $this->db->where('tb1.status', 'Approved');
        if (!empty($empl_id)) {
            $this->db->where('tb1.empl_id', $empl_id);
        }
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result_object();
    }

    function GET_LEAVES($date_from,$date_to){
        $this->db->select('tb1.id,tb2.col_empl_cmid,tb1.leave_date, tb3.name as type, tb1.duration, tb1.status');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_leaves_assign as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->join('tbl_std_leavetypes as tb3', 'tb1.type = tb3.id', 'left');

        $this->db->where("tb1.leave_date between '$date_from' AND '$date_to' ");
        // $this->db->where('tb1.status', 'Approved');
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result_object();
    }
    
    function GET_LEAVES_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id, tb2.col_frst_name, tb2.col_midl_name, tb2.col_last_name, tb1.leave_date, tb3.name as type, tb1.duration');
        $this->db->from('tbl_leaves_assign as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->join('tbl_std_leavetypes as tb3', 'tb1.type = tb3.id', 'left');
        if(empty($date_data)){
            $this->db->where('tb1.leave_date >=', $date_from);
            $this->db->where('tb1.leave_date <=', $date_to);
        }else{
            $this->db->like('tb1.leave_date', $date_data);
        }
        $this->db->where('tb1.status', 'Approved');
        return $this->db->count_all_results();
        
    }

    // function GET_PAYSLIP_LOANS_SEARCH($period_id, $empl_id){
    //     $sql="SELECT tb1.col_empl_cmid,tb1.col_suffix, tb1.col_last_name,tb1.col_frst_name,tb1.col_midl_name,tb2.LOAN_TOTAL,DEDUCTIONS,
    //         CONCAT_WS('',
    //         CASE WHEN tb1.col_last_name IS NOT NULL AND tb1.col_last_name != '' THEN CONCAT(tb1.col_last_name) ELSE '' END,  
    //         CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
    //         CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
    //         CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
    //         ) AS fullname
    //             FROM tbl_employee_infos as tb1
    //             LEFT JOIN tbl_payroll_payslips as tb2 ON tb1.id=tb2.empl_id
    //             WHERE tb2.status='Published' AND tb2.PAYSLIP_PERIOD=? AND tb2.empl_id=? 
    //             ORDER BY tb1.col_empl_cmid + 0 ASC
    //         ";
    //     $query=$this->db->query($sql,array($period_id, $empl_id));
    //     return $query->result();
    // }

    function GET_PAYSLIP_LOANS($period_id){
        $sql="SELECT tb1.col_empl_cmid,tb1.col_suffix, tb1.col_last_name,tb1.col_frst_name,tb1.col_midl_name,tb2.LOAN_TOTAL,DEDUCTIONS,
            CONCAT_WS('',
            CASE WHEN tb1.col_last_name IS NOT NULL AND tb1.col_last_name != '' THEN CONCAT(tb1.col_last_name) ELSE '' END,  
            CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
            CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
            CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
            ) AS fullname
                FROM tbl_employee_infos as tb1
                LEFT JOIN tbl_payroll_payslips as tb2 ON tb1.id=tb2.empl_id AND tb2.status='Published' AND tb2.PAYSLIP_PERIOD=?
                WHERE tb1.disabled = 0 AND (tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00') 
                ORDER BY tb1.col_empl_cmid + 0 ASC
            ";
        $query=$this->db->query($sql,array($period_id));
        return $query->result();
    }

    // function GET_PAYSLIP_LOANS_SEARCH($period_id, $empl_id) {
    //     $this->db->select(' tb1.col_empl_cmid, tb1.col_suffix, tb1.col_last_name, tb1.col_frst_name, tb1.col_midl_name, tb2.LOAN_TOTAL, tb2.DEDUCTIONS
    //     ');
    //     $this->db->select("CONCAT_WS('',
    //         CASE WHEN tb1.col_last_name IS NOT NULL AND tb1.col_last_name != '' 
    //             THEN tb1.col_last_name ELSE '' END,  
    //         CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' 
    //             THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
    //         CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' 
    //             THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
    //         CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' 
    //             THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
    //     ) AS fullname", false);

    //     $this->db->from('tbl_employee_infos as tb1');
    //     $this->db->join(
    //         'tbl_payroll_payslips as tb2',
    //         "tb1.id = tb2.empl_id 
    //         AND tb2.status = 'Published' 
    //         AND tb2.PAYSLIP_PERIOD = " . $this->db->escape($period_id),
    //         'left',
    //         false
    //     );

    //     $this->db->where('tb1.disabled', 0);
    //     $this->db->group_start();
    //         $this->db->where('tb1.termination_date IS NULL', null, false);
    //         $this->db->or_where('tb1.termination_date', '0000-00-00');
    //     $this->db->group_end();
    

    //     if (!empty($empl_id)) {
    //         $this->db->where('tb2.empl_id', $empl_id);
    //     }
    //     $this->db->order_by('tb1.col_empl_cmid + 0', 'ASC');

    //     $query = $this->db->get();
    //     return $query->result();
    // }

    function GET_PAYSLIP_LOANS_SEARCH($date_from, $date_to, $period_id, $empl_id, $filter_arr) {

    $new_filter = array();
    $new_filter['tb1.col_empl_company'] = $filter_arr['company'];
    $new_filter['tb1.col_empl_branch']  = $filter_arr['branch'];
    $new_filter['tb1.col_empl_dept']    = $filter_arr['dept'];
    $new_filter['tb1.col_empl_divi']    = $filter_arr['div'];
    $new_filter['tb1.col_empl_club']    = $filter_arr['clubhouse'];
    $new_filter['tb1.col_empl_sect']    = $filter_arr['section'];
    $new_filter['tb1.col_empl_group']   = $filter_arr['group'];
    $new_filter['tb1.col_empl_line']    = $filter_arr['line'];
    $new_filter['tb1.col_empl_team']    = $filter_arr['team'];
    $filtered = array_filter($new_filter);
    
    $this->db->select('tb1.col_empl_cmid, tb1.col_suffix, tb1.col_last_name, tb1.col_frst_name, tb1.col_midl_name, tb2.LOAN_TOTAL, tb2.DEDUCTIONS');
    
    $this->db->select("CONCAT_WS('',
        CASE WHEN tb1.col_last_name IS NOT NULL AND tb1.col_last_name != '' THEN tb1.col_last_name ELSE '' END,
        CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
        CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
        CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
    ) AS fullname", false);

    $this->db->from('tbl_employee_infos as tb1');
    
    // Simplified JOIN - move conditions to WHERE clause for better readability
    $this->db->join('tbl_payroll_payslips as tb2', 'tb1.id = tb2.empl_id', 'left');
    $this->db->join('tbl_payroll_period as tb3', 'tb2.PAYSLIP_PERIOD = tb3.id', 'left' );

    // Move JOIN conditions to WHERE clause
    $this->db->where('tb2.status', 'Published');
    
    // Employee status conditions
    $this->db->where('tb1.disabled', 0);
    
    // Termination date conditions using older syntax
    $this->db->where("(tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00')", null, false);

    if(!empty($date_from) && !empty($date_to)){
    $this->db->where('tb3.date_to >= ', $date_from);
    $this->db->where('tb3.date_from <= ', $date_to);
    }
    if(!empty($period_id)){
        $this->db->where('tb2.PAYSLIP_PERIOD', $period_id);
    }


    // Optional employee filter
    if (!empty($empl_id)) {
        $this->db->where('tb2.empl_id', $empl_id);
    }

    if (!empty($filtered)) {
        $this->db->where($filtered);
    }
    
    $this->db->order_by('tb1.col_empl_cmid + 0', 'ASC');

    $query = $this->db->get();
    return $query->result();
}

    
    // function GET_PAYSLIP_REPORT($period_id, $empl_id){
    //     $sql="SELECT tb1.col_empl_cmid,tb1.col_suffix, tb1.col_last_name,tb1.col_frst_name,tb1.col_midl_name,tb2.SSS_EE_CURRENT,tb2.PAGIBIG_EE_CURRENT,tb2.PHILHEALTH_EE_CURRENT, tb2.ID_SSS, tb2.SSS_ER_CURRENT, tb2.SSS_EC_ER_CURRENT, 
    //     tb2.ID_PAGIBIG, tb2.PAGIBIG_EE_CURRENT, tb2.PAGIBIG_ER_CURRENT, tb2.ID_PHILHEALTH, tb2.PHILHEALTH_EE_CURRENT, tb2.PHILHEALTH_ER_CURRENT,
    //         CONCAT_WS('',
    //         CASE WHEN tb1.col_last_name IS NOT NULL AND tb1.col_last_name != '' THEN CONCAT(tb1.col_last_name) ELSE '' END,  
    //         CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
    //         CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
    //         CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
    //         ) AS fullname
    //             FROM tbl_employee_infos as tb1
    //             LEFT JOIN tbl_payroll_payslips as tb2 ON tb1.id=tb2.empl_id 
    //             WHERE tb2.status='Published' AND tb2.PAYSLIP_PERIOD=? AND tb2.empl_id=? 
    //             ORDER BY tb1.col_empl_cmid + 0 ASC
    //         ";
    //     $query=$this->db->query($sql,array($period_id, $empl_id));
    //     return $query->result();
    // }

    function GET_PAYSLIP_BENIFITS($period_id){
        $sql="SELECT tb1.col_empl_cmid,tb1.col_suffix, tb1.col_last_name,tb1.col_frst_name,tb1.col_midl_name,tb2.SSS_EE_CURRENT,tb2.PAGIBIG_EE_CURRENT,tb2.PHILHEALTH_EE_CURRENT, tb2.ID_SSS, tb2.SSS_ER_CURRENT, tb2.SSS_EC_ER_CURRENT, 
        tb2.ID_PAGIBIG, tb2.PAGIBIG_EE_CURRENT, tb2.PAGIBIG_ER_CURRENT, tb2.ID_PHILHEALTH, tb2.PHILHEALTH_EE_CURRENT, tb2.PHILHEALTH_ER_CURRENT,
            CONCAT_WS('',
            CASE WHEN tb1.col_last_name IS NOT NULL AND tb1.col_last_name != '' THEN CONCAT(tb1.col_last_name) ELSE '' END,  
            CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
            CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
            CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
            ) AS fullname
                FROM tbl_employee_infos as tb1
                LEFT JOIN tbl_payroll_payslips as tb2 ON tb1.id=tb2.empl_id AND tb2.status='Published' AND tb2.PAYSLIP_PERIOD=?
                WHERE tb1.disabled = 0 AND (tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00') 
                ORDER BY tb1.col_empl_cmid + 0 ASC
            ";
        $query=$this->db->query($sql,array($period_id));
        return $query->result();
    }

    function GET_PAYSLIP_REPORT($date_from, $date_to, $period_id, $empl_id, $filter_arr) {

    $new_filter = array();
    $new_filter['tb1.col_empl_company'] = $filter_arr['company'];
    $new_filter['tb1.col_empl_branch']  = $filter_arr['branch'];
    $new_filter['tb1.col_empl_dept']    = $filter_arr['dept'];
    $new_filter['tb1.col_empl_divi']    = $filter_arr['div'];
    $new_filter['tb1.col_empl_club']    = $filter_arr['clubhouse'];
    $new_filter['tb1.col_empl_sect']    = $filter_arr['section'];
    $new_filter['tb1.col_empl_group']   = $filter_arr['group'];
    $new_filter['tb1.col_empl_line']    = $filter_arr['line'];
    $new_filter['tb1.col_empl_team']    = $filter_arr['team'];
    $filtered = array_filter($new_filter);

    $this->db->select('tb3.name, tb1.col_empl_cmid, tb1.col_suffix, tb1.col_last_name, tb1.col_frst_name, tb1.col_midl_name, tb2.SSS_EE_CURRENT, tb2.PAGIBIG_EE_CURRENT, tb2.PHILHEALTH_EE_CURRENT, tb2.ID_SSS, tb2.SSS_ER_CURRENT, tb2.SSS_EC_ER_CURRENT, tb2.ID_PAGIBIG, tb2.PAGIBIG_EE_CURRENT, tb2.PAGIBIG_ER_CURRENT, tb2.ID_PHILHEALTH, tb2.PHILHEALTH_EE_CURRENT, tb2.PHILHEALTH_ER_CURRENT
    ');
    $this->db->select("CONCAT_WS('',
        CASE WHEN tb1.col_last_name IS NOT NULL AND tb1.col_last_name != '' 
            THEN tb1.col_last_name ELSE '' END,  
        CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' 
            THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
        CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' 
            THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
        CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' 
            THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
    ) AS fullname", false);

    $this->db->from('tbl_employee_infos as tb1');
    $this->db->join('tbl_payroll_payslips as tb2', 'tb1.id = tb2.empl_id', 'left');
    $this->db->join('tbl_payroll_period as tb3', 'tb2.PAYSLIP_PERIOD = tb3.id', 'left' );
    $this->db->where('tb2.status', 'Published');
    
    // Employee status conditions
    $this->db->where('tb1.disabled', 0);
    
    // Termination date conditions using older syntax
    $this->db->where("(tb1.termination_date IS NULL OR tb1.termination_date = '0000-00-00')", null, false);

    
    if(!empty($date_from) && !empty($date_to)){
        $this->db->where('tb3.date_to >= ', $date_from);
        $this->db->where('tb3.date_from <= ', $date_to);
    }
    if(!empty($period_id)){
        $this->db->where('tb2.PAYSLIP_PERIOD', $period_id);
    }

    if (!empty($empl_id)) {
        $this->db->where('tb2.empl_id', $empl_id);
    }

    if (!empty($filtered)) {
        $this->db->where($filtered);
    }
    $this->db->order_by('tb1.col_empl_cmid + 0', 'ASC', false);

    $query = $this->db->get();
    return $query->result();
}


    

    function GET_EMPLOYEES_ALL()
    {
        $this->db->select('id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name');
        $this->db->where("disabled = 0 AND (termination_date IS NULL OR termination_date = '0000-00-00') ");
        $this->db->order_by('col_empl_cmid + 0 ', 'ASC');
        $query = $this->db->get('tbl_employee_infos');
        return $query->result();
    }

    function GET_PAYSLIP_REMITTANCES($period_id){
        $sql="SELECT tb1.col_empl_cmid,tb1.col_suffix, tb1.col_last_name,tb1.col_frst_name,tb1.col_midl_name,tb2.NET_INCOME,
            CONCAT_WS('',
            CASE WHEN tb1.col_last_name IS NOT NULL AND tb1.col_last_name != '' THEN CONCAT(tb1.col_last_name) ELSE '' END,  
            CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
            CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
            CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
            ) AS fullname
                FROM tbl_employee_infos as tb1
                LEFT JOIN tbl_payroll_payslips as tb2 ON tb1.id=tb2.empl_id AND tb2.status='Published' AND tb2.PAYSLIP_PERIOD=?
                ORDER BY tb1.col_empl_cmid + 0 ASC
            ";
        $query=$this->db->query($sql,array($period_id));
        return $query->result();
    }


    function GET_TARDINESS_SEARCH($date_from,$date_to, $empl_id, $filter_arr){

        $new_filter = array();
        $new_filter['tb4.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb4.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb4.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb4.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb4.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb4.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb4.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb4.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb4.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select("tb1.id,tb4.col_empl_cmid,tb1.date, tb1.time_in, tb1.time_out, tb3.time_regular_start,
        tb3.time_regular_end,HOUR(TIMEDIFF(tb1.time_in, tb3.time_regular_start))+FLOOR(MINUTE(TIMEDIFF(tb1.time_in, tb3.time_regular_start))/15)*0.25 AS late_duration",false);
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb4.col_last_name IS NOT NULL AND tb4.col_last_name != '' THEN CONCAT(tb4.col_last_name) ELSE '' END,  
        CASE WHEN tb4.col_suffix IS NOT NULL AND tb4.col_suffix != '' THEN CONCAT(' ', tb4.col_suffix) ELSE '' END,
        CASE WHEN tb4.col_frst_name IS NOT NULL AND tb4.col_frst_name != '' THEN CONCAT(', ', tb4.col_frst_name) ELSE '' END,
        CASE WHEN tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name != '' THEN CONCAT(' ', LEFT(tb4.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');
        $this->db->where("tb1.date between '$date_from' and '$date_to' and tb1.time_in>tb3.time_regular_start");
        if (!empty($empl_id)) {
            $this->db->where('tb1.empl_id', $empl_id);
        }
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->order_by('tb4.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();

    }

    function GET_TARDINESS($date_from,$date_to){
        $this->db->select("tb1.id,tb4.col_empl_cmid,tb1.date, tb1.time_in, tb1.time_out, tb3.time_regular_start,
        tb3.time_regular_end,HOUR(TIMEDIFF(tb1.time_in, tb3.time_regular_start))+FLOOR(MINUTE(TIMEDIFF(tb1.time_in, tb3.time_regular_start))/15)*0.25 AS late_duration",false);
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb4.col_last_name IS NOT NULL AND tb4.col_last_name != '' THEN CONCAT(tb4.col_last_name) ELSE '' END,  
        CASE WHEN tb4.col_suffix IS NOT NULL AND tb4.col_suffix != '' THEN CONCAT(' ', tb4.col_suffix) ELSE '' END,
        CASE WHEN tb4.col_frst_name IS NOT NULL AND tb4.col_frst_name != '' THEN CONCAT(', ', tb4.col_frst_name) ELSE '' END,
        CASE WHEN tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name != '' THEN CONCAT(' ', LEFT(tb4.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');
        $this->db->where("tb1.date between '$date_from' and '$date_to' and tb1.time_in>tb3.time_regular_start");
        $this->db->order_by('tb4.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();

    }
    function GET_TARDINESS_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id, tb1.date, tb1.time_in, tb1.time_out, tb3.time_regular_start, tb3.time_regular_end, tb4.col_last_name, tb4.col_frst_name, tb4.col_midl_name');
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');
        if(empty($date_data)){
            $this->db->where("tb1.date between '$date_from' and '$date_to' and tb1.time_in>tb3.time_regular_start");
        }else{
            $this->db->where("tb1.date",$date_data);
            // $this->db->where("tb1.time_in",">","tb3.time_regular_start");
        }
        return $this->db->count_all_results();

    }

    function GET_UNDERTIME_SEARCH($date_from,$date_to, $empl_id, $filter_arr){

        $new_filter = array();
        $new_filter['tb4.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb4.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb4.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb4.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb4.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb4.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb4.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb4.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb4.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select('tb1.id,tb4.col_empl_cmid, tb1.date, tb1.time_in, tb1.time_out, tb3.time_regular_start, tb3.time_regular_end');
        $this->db->select("HOUR(TIMEDIFF(tb1.time_out,  tb3.time_regular_end))+FLOOR(MINUTE(TIMEDIFF(tb1.time_out, tb3.time_regular_end))/15)*0.25 AS duration",false);
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb4.col_last_name IS NOT NULL AND tb4.col_last_name != '' THEN CONCAT(tb4.col_last_name) ELSE '' END,  
        CASE WHEN tb4.col_suffix IS NOT NULL AND tb4.col_suffix != '' THEN CONCAT(' ', tb4.col_suffix) ELSE '' END,
        CASE WHEN tb4.col_frst_name IS NOT NULL AND tb4.col_frst_name != '' THEN CONCAT(', ', tb4.col_frst_name) ELSE '' END,
        CASE WHEN tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name != '' THEN CONCAT(' ', LEFT(tb4.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');
        $this->db->where("tb1.date between '$date_from' and '$date_to' and tb1.time_out<tb3.time_regular_end");
        if (!empty($empl_id)) {
            $this->db->where('tb1.empl_id', $empl_id);
        }
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->order_by('tb4.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result_object();
    }

    function GET_UNDERTIME($date_from,$date_to){
        $this->db->select('tb1.id,tb4.col_empl_cmid, tb1.date, tb1.time_in, tb1.time_out, tb3.time_regular_start, tb3.time_regular_end');
        $this->db->select("HOUR(TIMEDIFF(tb1.time_out,  tb3.time_regular_end))+FLOOR(MINUTE(TIMEDIFF(tb1.time_out, tb3.time_regular_end))/15)*0.25 AS duration",false);
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb4.col_last_name IS NOT NULL AND tb4.col_last_name != '' THEN CONCAT(tb4.col_last_name) ELSE '' END,  
        CASE WHEN tb4.col_suffix IS NOT NULL AND tb4.col_suffix != '' THEN CONCAT(' ', tb4.col_suffix) ELSE '' END,
        CASE WHEN tb4.col_frst_name IS NOT NULL AND tb4.col_frst_name != '' THEN CONCAT(', ', tb4.col_frst_name) ELSE '' END,
        CASE WHEN tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name != '' THEN CONCAT(' ', LEFT(tb4.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');
        $this->db->where("tb1.date between '$date_from' and '$date_to' and tb1.time_out<tb3.time_regular_end");
        $this->db->order_by('tb4.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result_object();
    }
    function GET_UNDERTIME_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id, tb1.date, tb1.time_in, tb1.time_out, tb3.time_regular_start, tb3.time_regular_end, tb4.col_last_name, tb4.col_frst_name, tb4.col_midl_name');
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');
        if(empty($date_data)){
            $this->db->where("tb1.date between '$date_from' and '$date_to' and tb1.time_out<tb3.time_regular_end");
        }else{
           $this->db->where("tb1.date = '$date_data' and tb1.time_out<tb3.time_regular_end");
        }
        return $this->db->count_all_results();
    }
    function GET_NEW_EMPLOYEES($date_from,$date_to, $empl_id, $filter_arr){

        $new_filter = array();
        $new_filter['col_empl_company'] = $filter_arr['company'];
        $new_filter['col_empl_branch']  = $filter_arr['branch'];
        $new_filter['col_empl_dept']    = $filter_arr['dept'];
        $new_filter['col_empl_divi']    = $filter_arr['div'];
        $new_filter['col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['col_empl_sect']    = $filter_arr['section'];
        $new_filter['col_empl_group']   = $filter_arr['group'];
        $new_filter['col_empl_line']    = $filter_arr['line'];
        $new_filter['col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select('id,col_hire_date,col_empl_cmid');
        $this->db->select("CONCAT_WS('',
        CASE WHEN col_last_name IS NOT NULL AND col_last_name != '' THEN CONCAT(col_last_name) ELSE '' END,  
        CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_employee_infos');
        $this->db->where("col_hire_date between '$date_from'  and '$date_to' and termination_date IS NULL");
        if (!empty($empl_id)) {
            $this->db->where('tbl_employee_infos.id', $empl_id);
        }
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->order_by('col_empl_cmid + 0','ASC');
        
        $query = $this->db->get();
        return $query->result_object();

    }
    function GET_NEW_EMPLOYEES_COUNT($date_from,$date_to,$date_data){
        $this->db->select('id,col_frst_name,col_midl_name,col_last_name,col_hire_date,col_empl_cmid');
        $this->db->from('tbl_employee_infos');
        if(empty($date_data)){
            $this->db->where("col_hire_date between '$date_from'  and '$date_to' and termination_date IS NULL");
        }else{
            $this->db->where("col_hire_date = '$date_data' and termination_date IS NULL");
        }
        return $this->db->count_all_results();

    }
    function GET_PROBI_EMPLOYEES($date_from,$date_to, $empl_id, $filter_arr){
        $new_filter = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb2.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb2.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb2.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb2.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select('tb1.id,tb2.col_empl_cmid, tb1.log_date, tb1.from_val, tb1.to_val');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_employee_logs as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->where("tb1.category", "Employment Type"); // Use double quotes here
        $this->db->where("tb1.to_val", "Probationary");
        $this->db->where("DATE(tb1.log_date) BETWEEN '$date_from' AND '$date_to'", NULL, FALSE);
        if (!empty($empl_id)) {
            $this->db->where('tb1.empl_id', $empl_id);
        }
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GET_PROBI_EMPLOYEES_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id, col_frst_name, col_midl_name, col_last_name, tb1.log_date, col_empl_cmid, tb1.from_val, tb1.to_val');
        $this->db->from('tbl_employee_logs as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->where("tb1.category", "Employment Type"); // Use double quotes here
        $this->db->where("tb1.to_val", "Probationary");
        if(empty($date_data)){
            $this->db->where("DATE(tb1.log_date) BETWEEN '$date_from' AND '$date_to'", NULL, FALSE);
        }else{
            $this->db->where("DATE(tb1.log_date)",$date_data);
        }
        $query = $this->db->get();
        return $query->num_rows();

    }
    function GET_CONTRACTUAL_EMPLOYEES($date_from,$date_to, $empl_id, $filter_arr){

        $new_filter = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb2.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb2.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb2.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb2.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select('tb1.id,tb2.col_empl_cmid, tb1.log_date, col_empl_cmid, tb1.from_val, tb1.to_val');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_employee_logs as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->where("tb1.category", "Employment Type"); // Use double quotes here
        $this->db->where("tb1.to_val", "Project Based");
        $this->db->where("DATE(tb1.log_date) BETWEEN '$date_from' AND '$date_to'");
        if (!empty($empl_id)) {
            $this->db->where('tb1.empl_id', $empl_id);
        }
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();
        
    }
    function GET_CONTRACTUAL_EMPLOYEES_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id, col_frst_name, col_midl_name, col_last_name, tb1.log_date, col_empl_cmid, tb1.from_val, tb1.to_val');
        $this->db->from('tbl_employee_logs as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->where("tb1.category", "Employment Type"); // Use double quotes here
        $this->db->where("tb1.to_val", "Project Based");
        if(empty($date_data)){
            $this->db->where("DATE(tb1.log_date) BETWEEN '$date_from' AND '$date_to'", NULL, FALSE);
        }else{
            $this->db->where("DATE(tb1.log_date)",$date_data);
        }
        $query = $this->db->get();
        return $query->num_rows();

    }
    
    function GET_TERMINATED_EMPLOYEES($date_from,$date_to, $empl_id, $filter_arr){

        $new_filter = array();
        $new_filter['col_empl_company'] = $filter_arr['company'];
        $new_filter['col_empl_branch']  = $filter_arr['branch'];
        $new_filter['col_empl_dept']    = $filter_arr['dept'];
        $new_filter['col_empl_divi']    = $filter_arr['div'];
        $new_filter['col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['col_empl_sect']    = $filter_arr['section'];
        $new_filter['col_empl_group']   = $filter_arr['group'];
        $new_filter['col_empl_line']    = $filter_arr['line'];
        $new_filter['col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select('id,col_suffix,col_frst_name,col_midl_name,col_last_name,termination_date,col_empl_cmid,resignation_date');
        $this->db->select("CONCAT_WS('',
        CASE WHEN col_last_name IS NOT NULL AND col_last_name != '' THEN CONCAT(col_last_name) ELSE '' END,  
        CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_employee_infos');
        $this->db->where("termination_date between '$date_from' and '$date_to'");
        if (!empty($empl_id)) {
            $this->db->where('tbl_employee_infos.id', $empl_id);
        }
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }

        $this->db->order_by('col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result_object();
    }

    function GET_RESIGNED_EMPLOYEES($date_from,$date_to, $empl_id, $filter_arr){

        $new_filter = array();
        $new_filter['col_empl_company'] = $filter_arr['company'];
        $new_filter['col_empl_branch']  = $filter_arr['branch'];
        $new_filter['col_empl_dept']    = $filter_arr['dept'];
        $new_filter['col_empl_divi']    = $filter_arr['div'];
        $new_filter['col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['col_empl_sect']    = $filter_arr['section'];
        $new_filter['col_empl_group']   = $filter_arr['group'];
        $new_filter['col_empl_line']    = $filter_arr['line'];
        $new_filter['col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select('id,col_suffix,col_frst_name,col_midl_name,col_last_name,termination_date,col_empl_cmid,resignation_date');
        $this->db->select("CONCAT_WS('',
        CASE WHEN col_last_name IS NOT NULL AND col_last_name != '' THEN CONCAT(col_last_name) ELSE '' END,  
        CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_employee_infos');
        $this->db->where("resignation_date between '$date_from' and '$date_to'");
        if (!empty($empl_id)) {
            $this->db->where('tbl_employee_infos.id', $empl_id);
        }
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }

        $this->db->order_by('col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result_object();
    }
    function GET_RESIGNED_EMPLOYEES_COUNT($date_from,$date_to,$date_data){
        $this->db->select('id,col_frst_name,col_midl_name,col_last_name,termination_date,col_empl_cmid');
        $this->db->from('tbl_employee_infos');
        if(empty($date_data)){
            $this->db->where("termination_date between '$date_from' and '$date_to'");
        }else{
            $this->db->where("termination_date",$date_data);
        }
        return $this->db->count_all_results();
    }


    function GET_ACTIVE_EMPLOYEES($date_from,$date_to, $empl_id, $filter_arr){

        $new_filter = array();
        $new_filter['tb1.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb1.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb1.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb1.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb1.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb1.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb1.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb1.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb1.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select('tb1.id,col_hire_date,
        tb2.name as empl_position,
        col_empl_cmid');
        $this->db->select("CONCAT_WS('->',tb3.name,tb4.name,tb5.name,tb6.name,tb7.name,tb9.name,tb8.name  ) AS designation", false);
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb1.col_last_name IS NOT NULL AND tb1.col_last_name != '' THEN CONCAT(tb1.col_last_name) ELSE '' END,  
        CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
        CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
        CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_employee_infos as tb1');
        $this->db->join('tbl_std_positions as tb2','tb1.col_empl_posi=tb2.id','left');
        $this->db->join('tbl_std_branches as tb3', 'tb1.col_empl_branch=tb3.id','left');
        $this->db->join('tbl_std_departments as tb4','tb1.col_empl_dept=tb4.id','left');
        $this->db->join('tbl_std_divisions as tb5','tb1.col_empl_divi=tb5.id','left');
        $this->db->join('tbl_std_sections as tb6','tb1.col_empl_sect=tb6.id','left');
        $this->db->join('tbl_std_groups as tb7','tb1.col_empl_group=tb7.id','left');
        $this->db->join('tbl_std_lines as tb8','tb1.col_empl_line=tb8.id','left');
        $this->db->join('tbl_std_teams as tb9','tb1.col_empl_team=tb9.id','left');
        $this->db->where("col_hire_date <= '$date_to'  AND tb1.disabled=0 AND tb1.termination_date IS NULL");
        if (!empty($empl_id)) {
            $this->db->where('tb1.id', $empl_id);
        }
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->order_by('tb1.col_empl_cmid + 0','ASC');
        // $this->db->limit($limit,$offset);
        $query = $this->db->get();
        return $query->result_object();
    }
     function GET_ACTIVE_EMPLOYEES_COUNT($date_from,$date_to){
        $this->db->select('tb1.id,col_frst_name,col_midl_name,col_last_name,col_hire_date,
        tb2.name as empl_position,
        tb3.name as empl_branch,
        tb4.name as empl_department,
        tb5.name as empl_division,
        tb6.name as empl_section,
        tb7.name as empl_group,
        tb8.name as empl_line,
        tb9.name as empl_team,
        col_empl_cmid');
        $this->db->from('tbl_employee_infos as tb1');
        $this->db->join('tbl_std_positions as tb2','tb1.col_empl_posi=tb2.id','left');
        $this->db->join('tbl_std_branches as tb3', 'tb1.col_empl_branch=tb3.id','left');
        $this->db->join('tbl_std_departments as tb4','tb1.col_empl_dept=tb4.id','left');
        $this->db->join('tbl_std_divisions as tb5','tb1.col_empl_divi=tb5.id','left');
        $this->db->join('tbl_std_sections as tb6','tb1.col_empl_sect=tb6.id','left');
        $this->db->join('tbl_std_groups as tb7','tb1.col_empl_group=tb7.id','left');
        $this->db->join('tbl_std_lines as tb8','tb1.col_empl_line=tb8.id','left');
        $this->db->join('tbl_std_teams as tb9','tb1.col_empl_team=tb9.id','left');
        $this->db->where("tb1.disabled = 0 AND tb1.termination_date IS NULL");
        $this->db->where("col_hire_date between '$date_from' AND '$date_to' ");
        // if(empty($date_data)){
        //     $this->db->where("col_hire_date  <= '$date_to' AND tb1.disabled=0 AND termination_date='0000-00-00'");
        // }else{
        //     $this->db->where("col_hire_date  <= '$date_data' AND tb1.disabled=0 AND termination_date='0000-00-00'");
        // }
        return $this->db->count_all_results();
    }
    // function GET_OVERTIME($date_from,$date_to){
    //     $this->db->select('tb1.id, tb1.type, tb2.col_empl_cmid,date_ot,time_out,hours');
    //     $this->db->select("CONCAT_WS('',
    //     CASE WHEN tb2.col_empl_cmid IS NOT NULL AND tb2.col_empl_cmid != '' THEN CONCAT(tb2.col_empl_cmid, '-') ELSE '' END,
    //     CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
    //     CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
    //     CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
    //     CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
    //     ) AS fullname", false);
    //     $this->db->from('tbl_overtimes as tb1');
    //     $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
    //     $this->db->where("date_ot between '$date_from' and '$date_to' AND status='Approved'");
    //     $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
    //     $query = $this->db->get();
    //     return $query->result_object();
    // }

    // function GET_OVERTIME_SEARCH($date_from, $date_to, $empl_id) {
    //     $sql = "SELECT tb1.id, tb1.type, tb2.col_empl_cmid, tb2.col_last_name, tb2.col_suffix, tb2.col_frst_name, tb2.col_midl_name, 
    //             CONCAT_WS('', 
    //                 CASE WHEN tb2.col_empl_cmid IS NOT NULL AND tb2.col_empl_cmid != '' THEN CONCAT(tb2.col_empl_cmid, '-') ELSE '' END, 
    //                 CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
    //                 CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END, 
    //                 CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END, 
    //                 CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END 
    //             ) AS fullname,
    //             tb1.date_ot, tb1.time_out, tb1.hours, tb3.shift_id, tb4.code, tb4.time_regular_end
    //             FROM tbl_overtimes AS tb1
    //             LEFT JOIN tbl_employee_infos AS tb2 ON tb1.empl_id = tb2.id
    //             LEFT JOIN tbl_attendance_shiftassign AS tb3 ON tb1.empl_id = tb3.empl_id AND tb1.date_ot = tb3.date -- connect to tbl_overtimes empl_id and date_ot
    //             LEFT JOIN tbl_attendance_shifts AS tb4 ON tb3.shift_id = tb4.id -- connect to tbl_attendance_shiftassign shift_id  
    //             WHERE tb1.date_ot BETWEEN ? AND ? AND tb1.status = 'Approved' AND tb1.empl_id=?
    //             ORDER BY tb2.col_empl_cmid + 0 ASC";
    
    //     $query = $this->db->query($sql, array($date_from, $date_to, $empl_id));
    //     return $query->result_object();
    // }

    function GET_OVERTIME_SEARCH($date_from, $date_to, $empl_id, $filter_arr) {

        $new_filter = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb2.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb2.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb2.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb2.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select('tb1.id, tb1.type, tb2.col_empl_cmid, tb1.date_ot, tb1.time_out, tb1.hours, tb3.shift_id, tb4.code, tb4.time_regular_end, tb1.status');
        $this->db->select("CONCAT_WS('',
            CASE WHEN tb2.col_empl_cmid IS NOT NULL AND tb2.col_empl_cmid != '' THEN CONCAT(tb2.col_empl_cmid, '-') ELSE '' END,
            CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,
            CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
            CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
            CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
    
        $this->db->from('tbl_overtimes AS tb1');
        $this->db->join('tbl_employee_infos AS tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->join('tbl_attendance_shiftassign AS tb3', 'tb1.empl_id = tb3.empl_id AND tb1.date_ot = tb3.date', 'left');
        $this->db->join('tbl_attendance_shifts AS tb4', 'tb3.shift_id = tb4.id', 'left');
    
        $this->db->where("tb1.date_ot BETWEEN '$date_from' AND '$date_to'");
        // $this->db->where('tb1.status', 'Approved');
        if (!empty($empl_id)) {
            $this->db->where('tb1.empl_id', $empl_id);
        }

        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->order_by('tb2.col_empl_cmid + 0', 'ASC');
    
        $query = $this->db->get();
        return $query->result_object();
    }
    

    // function GET_OVERTIME($date_from, $date_to) {
    //     $sql = "SELECT tb1.id, tb1.type, tb2.col_empl_cmid, tb2.col_last_name, tb2.col_suffix, tb2.col_frst_name, tb2.col_midl_name, 
    //             CONCAT_WS('', 
    //                 CASE WHEN tb2.col_empl_cmid IS NOT NULL AND tb2.col_empl_cmid != '' THEN CONCAT(tb2.col_empl_cmid, '-') ELSE '' END, 
    //                 CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
    //                 CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END, 
    //                 CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END, 
    //                 CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END 
    //             ) AS fullname,
    //             tb1.date_ot, tb1.time_out, tb1.hours, tb3.shift_id, tb4.code, tb4.time_regular_end
    //             FROM tbl_overtimes AS tb1
    //             LEFT JOIN tbl_employee_infos AS tb2 ON tb1.empl_id = tb2.id
    //             LEFT JOIN tbl_attendance_shiftassign AS tb3 ON tb1.empl_id = tb3.empl_id AND tb1.date_ot = tb3.date -- connect to tbl_overtimes empl_id and date_ot
    //             LEFT JOIN tbl_attendance_shifts AS tb4 ON tb3.shift_id = tb4.id -- connect to tbl_attendance_shiftassign shift_id  
    //             WHERE tb1.date_ot BETWEEN ? AND ? AND tb1.status = 'Approved'
    //             ORDER BY tb2.col_empl_cmid + 0 ASC";
    
    //     $query = $this->db->query($sql, array($date_from, $date_to));
    //     return $query->result_object();
    // }

    function GET_OVERTIME($date_from, $date_to) {
        $this->db->select('tb1.id, tb1.type, tb2.col_empl_cmid, tb1.date_ot, tb1.time_out, tb1.hours, tb3.shift_id, tb4.code, tb4.time_regular_end, tb1.status');
        $this->db->select("CONCAT_WS('',
            CASE WHEN tb2.col_empl_cmid IS NOT NULL AND tb2.col_empl_cmid != '' THEN CONCAT(tb2.col_empl_cmid, '-') ELSE '' END,
            CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,
            CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
            CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
            CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
    
        $this->db->from('tbl_overtimes AS tb1');
        $this->db->join('tbl_employee_infos AS tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->join('tbl_attendance_shiftassign AS tb3', 'tb1.empl_id = tb3.empl_id AND tb1.date_ot = tb3.date', 'left');
        $this->db->join('tbl_attendance_shifts AS tb4', 'tb3.shift_id = tb4.id', 'left');
    
        $this->db->where("tb1.date_ot BETWEEN '$date_from' AND '$date_to'");
        $this->db->order_by('tb2.col_empl_cmid + 0', 'ASC');
    
        $query = $this->db->get();
        return $query->result_object();
    }
    
    
    function GET_OVERTIME_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id,col_frst_name,col_midl_name,col_last_name,date_ot,time_out,hours');
        $this->db->from('tbl_overtimes as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        if(empty($date_data)){
            $this->db->where("date_ot between '$date_from' and '$date_to' AND status='Approved'");
        }else{
            $this->db->where("date_ot = '$date_data'  AND status='Approved'");
        }
        return $this->db->count_all_results();
    }

    function GET_TIME_ADJS_SEARCH($date_from,$date_to, $empl_id, $filter_arr){

        $new_filter = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb2.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb2.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb2.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb2.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select('tb1.id,tb2.col_empl_cmid,date_adjustment,time_out_1,time_out_2,time_in_1,time_in_2, tb1.status');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_attendance_adjustments as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->where("date_adjustment between '$date_from' and '$date_to'");
        if (!empty($empl_id)) {
            $this->db->where('tb1.empl_id', $empl_id);
        }
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GET_TIME_ADJS($date_from,$date_to){
        $this->db->select('tb1.id,tb2.col_empl_cmid,date_adjustment,time_out_1,time_out_2,time_in_1,time_in_2, tb1.status');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_attendance_adjustments as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'inner');
        $this->db->where("date_adjustment between '$date_from' and '$date_to'");
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function GET_TIME_ADJS_COUNT($date_from,$date_to){
        $this->db->select('tb1.id,col_frst_name,col_midl_name,col_last_name,date_adjustment,time_out_1,time_out_2,time_in_1,time_in_2');
        
        $this->db->from('tbl_attendance_adjustments as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        if(empty($date_data)){
            $this->db->where("date_adjustment between '$date_from' and '$date_to' AND status='Approved'");
        }else{
            $this->db->where("date_adjustment = '$date_data' AND status='Approved'");
        }
        return $this->db->count_all_results();
    }

    function GET_HOLI_WORKS_SEARCH($date_from,$date_to, $empl_id, $filter_arr){

        $new_filter = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb2.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb2.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb2.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb2.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select('tb1.id,tb2.col_empl_cmid,date,hours, tb1.status');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_holidaywork as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->where("tb1.date between '$date_from' and '$date_to' ");
        if (!empty($empl_id)) {
            $this->db->where('tb1.empl_id', $empl_id);
        }
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GET_HOLI_WORKS($date_from,$date_to){
        $this->db->select('tb1.id,tb2.col_empl_cmid,date,hours, tb1.status');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_holidaywork as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        $this->db->where("tb1.date between '$date_from' and '$date_to' ");
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function GET_HOLI_WORKS_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id,col_frst_name,col_midl_name,col_last_name,date,hours');
        $this->db->from('tbl_holidaywork as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id = tb2.id', 'left');
        if(empty($date_data)){
            $this->db->where("tb1.date between '$date_from' and '$date_to' AND tb1.status='Approved'");
        }else{
            $this->db->where("tb1.date = '$date_data' AND tb1.status='Approved'");
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    function GET_AWOL_EMP($date_from,$date_to,$selectedCustomGroups, $empl_id, $filter_arr){

        $new_filter = array();
        $new_filter['tb5.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb5.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb5.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb5.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb5.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb5.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb5.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb5.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb5.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $sql="SELECT tb1.id, tb1.date,tb5.col_empl_cmid, tb7.id as cg_id,
        CONCAT_WS('',
        CASE WHEN tb5.col_last_name IS NOT NULL AND tb5.col_last_name != '' THEN CONCAT(tb5.col_last_name) ELSE '' END,  
        CASE WHEN tb5.col_suffix IS NOT NULL AND tb5.col_suffix != '' THEN CONCAT(' ', tb5.col_suffix) ELSE '' END,
        CASE WHEN tb5.col_frst_name IS NOT NULL AND tb5.col_frst_name != '' THEN CONCAT(', ', tb5.col_frst_name) ELSE '' END,
        CASE WHEN tb5.col_midl_name IS NOT NULL AND tb5.col_midl_name != '' THEN CONCAT(' ', LEFT(tb5.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname
        FROM tbl_attendance_shiftassign as tb1  
                left join tbl_attendance_shifts as tb4 on tb1.shift_id=tb4.id
                left join tbl_employee_infos as tb5 on tb1.empl_id=tb5.id
                left join tbl_custom_group_assignments as tb6 on tb6.empl_id=tb5.id and tb6.is_checked='1'
                left join tbl_std_custom_groups as tb7 on tb7.id=tb6.custom_group_id
                where (tb1.date between ? and ? ) and not exists (SELECT date FROM tbl_attendance_records as tb2 
                WHERE tb1.date=tb2.date and tb1.empl_id=tb2.empl_id and (tb2.time_in='00:00:00'||tb2.time_out='00:00:00'))
                and not exists (SELECT leave_date from tbl_leaves_assign as tb3 where tb1.date=tb3.leave_date and tb3.status='Approved')
                and  tb4.name!='REST' and tb5.disabled=0 and tb5.termination_date IS NULL";

                // if(isset($selectedCustomGroups) && !empty($selectedCustomGroups)) {
                //     $sql .= " AND tb7.id IN ($selectedCustomGroups)";
                // }

                if($empl_id){
                    $sql .= " AND tb1.empl_id = $empl_id";
                }

                if (!empty($filtered)) {
                    foreach ($filtered as $col => $val) {
                        $sql .= " AND $col = " . $this->db->escape($val);
                    }
                }

                // $sql .= " GROUP BY tb1.date,fullname, tb7.id";
                $sql .= " GROUP BY fullname, tb1.date";
                $sql .= " ORDER BY tb5.col_empl_cmid + 0 ASC";
         $query = $this->db->query($sql, array($date_from,$date_to));
        return $query->result_object();
    }

    function GET_AWOL_EMP_COUNT($date_from,$date_to,$date_data){
        if(!empty($date_data)){
            $sql="SELECT tb1.date,tb5.col_empl_cmid,tb5.col_last_name,tb5.col_frst_name,tb5.col_midl_name FROM tbl_attendance_shiftassign as tb1  
                left join tbl_attendance_shifts as tb4 on tb1.shift_id=tb4.id
                left join tbl_employee_infos as tb5 on tb1.empl_id=tb5.id
                where (tb1.date = ? ) and not exists (SELECT date FROM tbl_attendance_records as tb2 
                WHERE tb1.date=tb2.date and tb1.empl_id=tb2.empl_id and (tb2.time_in='00:00:00'||tb2.time_out='00:00:00'))
                and not exists (SELECT leave_date from tbl_leaves_assign as tb3 where tb1.date=tb3.leave_date and tb3.status='Approved')
                and  tb4.name!='REST' ";
             $query = $this->db->query($sql, array($date_data));
        }else{
            $sql="SELECT tb1.date,tb5.col_empl_cmid,tb5.col_last_name,tb5.col_frst_name,tb5.col_midl_name FROM tbl_attendance_shiftassign as tb1  
                left join tbl_attendance_shifts as tb4 on tb1.shift_id=tb4.id
                left join tbl_employee_infos as tb5 on tb1.empl_id=tb5.id
                where (tb1.date between ? and ? ) and not exists (SELECT date FROM tbl_attendance_records as tb2 
                WHERE tb1.date=tb2.date and tb1.empl_id=tb2.empl_id and (tb2.time_in='00:00:00'||tb2.time_out='00:00:00'))
                and not exists (SELECT leave_date from tbl_leaves_assign as tb3 where tb1.date=tb3.leave_date and tb3.status='Approved')
                and  tb4.name!='REST' ";
         $query = $this->db->query($sql, array($date_from,$date_to));
        }
            return $query->num_rows();
    }
    
    function GET_SLIDERS($date_from,$date_to, $empl_id, $filter_arr){

        $new_filter = array();
        $new_filter['tb4.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb4.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb4.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb4.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb4.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb4.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb4.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb4.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb4.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select('tb1.id, tb1.date, tb4.col_empl_cmid,tb1.time_in, tb1.time_out, tb3.time_regular_start,
        tb3.time_regular_end');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb4.col_last_name IS NOT NULL AND tb4.col_last_name != '' THEN CONCAT(tb4.col_last_name) ELSE '' END,  
        CASE WHEN tb4.col_suffix IS NOT NULL AND tb4.col_suffix != '' THEN CONCAT(' ', tb4.col_suffix) ELSE '' END,
        CASE WHEN tb4.col_frst_name IS NOT NULL AND tb4.col_frst_name != '' THEN CONCAT(', ', tb4.col_frst_name) ELSE '' END,
        CASE WHEN tb4.col_midl_name IS NOT NULL AND tb4.col_midl_name != '' THEN CONCAT(' ', LEFT(tb4.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');

        $this->db->where("tb1.date between '$date_from' AND '$date_to' ");

        if (!empty($empl_id)) {
            $this->db->where('tb1.empl_id', $empl_id);
        }
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->order_by('tb4.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result_object();
    }

    function GET_SLIDERS_COUNT($date_from,$date_to,$date_data){
        $this->db->select('tb1.id, tb1.date, tb1.time_in, tb1.time_out, tb3.time_regular_start,
        tb3.time_regular_end, tb4.col_last_name, tb4.col_frst_name, tb4.col_midl_name');
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join('tbl_attendance_shiftassign as tb2', 'tb1.date = tb2.date and  tb1.empl_id = tb2.empl_id', 'left');
        $this->db->join('tbl_attendance_shifts as tb3', 'tb2.shift_id = tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.empl_id = tb4.id', 'left');
        if(empty($date_data)){
            $this->db->where("tb1.date between '$date_from' and '$date_to' AND (tb1.time_in BETWEEN DATE_SUB(tb3.time_regular_start, INTERVAL 4 MINUTE) AND tb3.time_regular_start)");
        }else{
            $this->db->where("tb1.date = '$date_data' AND (tb1.time_in BETWEEN DATE_SUB(tb3.time_regular_start, INTERVAL 4 MINUTE) AND tb3.time_regular_start)");
        }
        return $this->db->count_all_results();
    }

    function GET_PROMOTED_EMPLOYEES($date_from,$date_to, $empl_id, $filter_arr){

        $new_filter = array();
        $new_filter['tb2.col_empl_company'] = $filter_arr['company'];
        $new_filter['tb2.col_empl_branch']  = $filter_arr['branch'];
        $new_filter['tb2.col_empl_dept']    = $filter_arr['dept'];
        $new_filter['tb2.col_empl_divi']    = $filter_arr['div'];
        $new_filter['tb2.col_empl_club']    = $filter_arr['clubhouse'];
        $new_filter['tb2.col_empl_sect']    = $filter_arr['section'];
        $new_filter['tb2.col_empl_group']   = $filter_arr['group'];
        $new_filter['tb2.col_empl_line']    = $filter_arr['line'];
        $new_filter['tb2.col_empl_team']    = $filter_arr['team'];
        $filtered = array_filter($new_filter);

        $this->db->select('tb1.id, tb2.col_empl_cmid,tb1.log_date,tb1.from_val,tb1.to_val');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        
        $this->db->from('tbl_employee_logs as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.empl_id=tb2.id','left');
        $this->db->where('category', 'Position');
        $this->db->where("log_date between '$date_from' AND '$date_to' ");
        if (!empty($empl_id)) {
            $this->db->where('tb1.empl_id', $empl_id);
        }
        if (!empty($filtered)) {
            $this->db->where($filtered);
        }
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function GET_PROMOTED_EMP($date_from,$date_to, $empl_id){
        $this->db->select('tb1.id, tb2.col_empl_cmid,tb1.log_date,tb1.from_val,tb1.to_val');
        $this->db->select("CONCAT_WS('',
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT(tb2.col_last_name) ELSE '' END,  
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname", false);
        
        $this->db->from('tbl_employee_logs as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.empl_id=tb2.id','left');
        $this->db->where('category', 'Position');
        $this->db->where("log_date between '$date_from' AND '$date_to' ");
        if (!empty($empl_id)) {
            $this->db->where('tb1.empl_id', $empl_id);
        }
        $this->db->order_by('tb2.col_empl_cmid + 0','ASC');
        $query = $this->db->get();
        return $query->result();
    }
    function GET_PROMOTED_EMP_COUNT($date_from,$date_to){
        $this->db->select('tb1.id,tb1.log_date,tb1.from_val,tb1.to_val,tb2.col_last_name,tb2.col_frst_name,tb2.col_midl_name');
        $this->db->from('tbl_employee_logs as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.empl_id=tb2.id','left');
        $this->db->where('category', 'Position');
        $this->db->where("log_date between '$date_from' AND '$date_to' ");
        // if(empty($date_data)){
        //     $this->db->where('log_date >=', $date_from);
        //     $this->db->where('log_date <=', $date_to);
        // }
        // else{
        //      $this->db->like('log_date', $date_data);
        // }
        $query = $this->db->get();
        return $query->num_rows();
    }
    function SYSTEM_SETTINGS($setting){
        $this->db->select('value');
        $this->db->where('setting',$setting);
        $query=$this->db->get('tbl_system_setup');
        $result=$query->row();
        return $result->value;
    }
    function UPDATE_FORM_SETTING($data){
        
        return $this->db->update_batch('tbl_system_setup', $data, 'setting');
    }

    function GET_STD_DATA($table)
    {
        $this->db->select('id,name')
            ->from($table)
            ->where(array('status' => 'active'));
        $query = $this->db->get();
        return $query->result();
    }

    function GET_SYSTEM_SETTING($setting)
    {
        $sql    = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
    }







    
}
