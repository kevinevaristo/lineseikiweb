<?php
class overtimes_model extends CI_Model{
    function GET_EMPLOYEELIST(){

        $sql = "SELECT id,col_suffix,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,
        col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,
        col_empl_team,col_empl_line FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        ORDER BY col_empl_cmid +0 ASC";

        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function getApprovalAutoApproveEnabled($empl_id){
        $this->db->select('COUNT(*) as count');
        $this->db->where('empl_id', $empl_id);
        $this->db->where('auto_approve', 'Enabled');
        $query = $this->db->get('tbl_approvers_ot');
        $result = $query->row();
        if ($result) {
            return $result->count;
        } else {
            return 0;
        }
    }
    function get_system_setup_by_setting($setting){
        $result = $this->db->select('value')->where('setting', $setting)->get('tbl_system_setup')->row_array();
        if($result){
            return $result['value'];
        } else {
            // If setting doesn't exist, insert with default value
            $this->db->insert('tbl_system_setup', array('setting' => $setting, 'value' => 0));
            return 0;
        }
    }

    function update_system_setup($settings){
        try {
            foreach ($settings as $key => $value) {
                $this->db->set('value',$value);
                $this->db->where('setting', $key); 
                $this->db->update('tbl_system_setup');
            }
            return true; 
        } catch (Exception $e) {
            return false;
        }
    }
    
    
    function update_settings($input_data){
        try {
            foreach ($input_data as $key => $value) {
                // $updateData = array('value' => $value);
                // if ($key === 'payroll_rankandfile' || $key === 'payroll_managers') {
                //     $value = implode(",", $value);
                // }
                $this->db->set('value',$value);
                $this->db->where('setting', $key); 
                $this->db->update('tbl_system_setup');
            }
            return true;
            // return $input_data;
        } catch (Exception $e) {
            return false;
        }
    }

    // function GET_TEAMS($user_id){
    //     $this->db->select('id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name,col_empl_dept');
    //     $this->db->where("disabled = 0 AND termination_date IS NULL");
    //     $query=$this->db->get('tbl_employee_infos');
    //     return $query->result();
    // }

    function GET_TEAMS($user_id){
        $sql = "SELECT id, col_suffix, col_empl_cmid, col_last_name, col_midl_name, col_frst_name, col_empl_dept 
        FROM tbl_employee_infos
        WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        ORDER BY col_empl_cmid + 0 ASC";
         $query = $this->db->query($sql);
        return $query->result();
    }


    function GET_USER_DEPARMENT($user_id){
        $sql = "SELECT col_empl_dept FROM tbl_employee_infos WHERE id = $user_id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result[0]["col_empl_dept"];
    }

       function GET_OVERTIME_STEP($department){
        $sql = "SELECT value FROM tbl_overtime_step WHERE department = $department";

        $query = $this->db->query($sql, array());
        $result = $query->row();

        if ($result) {
            return $result->value;
        } else {
            return "0.5";
        }
    }

    function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'maiya_reset'";
        return $this->db->query($query)->row_array();
    }
    function GET_SYSTEM_SETUP($setting){
        $this->db->Select('value');
        $this->db->where('setting',$setting);
        $query=$this->db->get('tbl_system_setup');
        $data=$query->row();
        return $data->value;
    }
    function GET_EMPLOYEES($user_id){
        $this->db->select('id,col_empl_cmid,col_last_name,col_midl_name,col_frst_name');
        $this->db->where("disabled = 0 AND (termination_date IS NULL OR termination_date = '0000-00-00') ");
        $this->db->where('reporting_to',$user_id);
        $query=$this->db->get('tbl_employee_infos');
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
    function GET_USER_APPROVERS($id)
    {
        $this->db->select('tb1.id,approver_1a,approver_2a,approver_3a,tb1.approver_4a,tb1.approver_5a,tb1.id,approver_1b,approver_2b,approver_3b,tb1.approver_4b,tb1.approver_5b,tb1.empl_id');
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as approver_1", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',RPAD(LEFT(tb3.col_midl_name,1),2,'.')) as approver_2", false);
        $this->db->select("CONCAT(tb4.col_last_name,',',tb4.col_frst_name,' ',RPAD(LEFT(tb4.col_midl_name,1),2,'.')) as approver_3", false);
        $this->db->select("CONCAT(tb5.col_last_name,',',tb5.col_frst_name,' ',RPAD(LEFT(tb5.col_midl_name,1),2,'.')) as employee", false);
        $this->db->from('tbl_approvers_ot as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.approver_1a=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.approver_2a=tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver_3a=tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.empl_id=tb5.id', 'left');
        $this->db->where('tb1.empl_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function GET_USER_APPROVERS_2($id, $table)
    {
        $this->db->select('tb1.id,approver_1a,approver_2a,approver_3a,tb1.approver_4a,tb1.approver_5a,tb1.id,approver_1b,approver_2b,approver_3b,tb1.approver_4b,tb1.approver_5b,tb1.empl_id');
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as approver_1", false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',RPAD(LEFT(tb3.col_midl_name,1),2,'.')) as approver_2", false);
        $this->db->select("CONCAT(tb4.col_last_name,',',tb4.col_frst_name,' ',RPAD(LEFT(tb4.col_midl_name,1),2,'.')) as approver_3", false);
        $this->db->select("CONCAT(tb6.col_last_name,',',tb6.col_frst_name,' ',RPAD(LEFT(tb6.col_midl_name,1),2,'.')) as approver_4", false);
        $this->db->select("CONCAT(tb7.col_last_name,',',tb7.col_frst_name,' ',RPAD(LEFT(tb7.col_midl_name,1),2,'.')) as approver_5", false);
        $this->db->select("CONCAT(tb5.col_last_name,',',tb5.col_frst_name,' ',RPAD(LEFT(tb5.col_midl_name,1),2,'.')) as employee", false);
        $this->db->from($table . ' as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.approver_1a=tb2.id', 'left');
        $this->db->join('tbl_employee_infos as tb3', 'tb1.approver_2a=tb3.id', 'left');
        $this->db->join('tbl_employee_infos as tb4', 'tb1.approver_3a=tb4.id', 'left');
        $this->db->join('tbl_employee_infos as tb5', 'tb1.empl_id=tb5.id', 'left');
        $this->db->join('tbl_employee_infos as tb6', 'tb1.approver_4a=tb6.id', 'left');
        $this->db->join('tbl_employee_infos as tb7', 'tb1.approver_5a=tb7.id', 'left');
        $this->db->where('tb1.empl_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function GET_PENDING_OVERTIME_COUNT()
    {
        $sql = "SELECT COUNT(*) AS count FROM tbl_overtimes WHERE status LIKE 'Pending%';" ;
        $query = $this->db->query($sql);
        $result  = $query->row();
        return $result->count;
    }

    function GET_PENDING_HOLIDAY_WORK_COUNT()
    {
        $sql = "SELECT COUNT(*) as count FROM tbl_holidaywork WHERE status LIKE 'pending%'" ;
        $query = $this->db->query($sql);
        $result  = $query->row();
        return $result->count;
    }

    function CANCEL_OT($id,$user_id){
        $ot=$this->db->select('status')->where('id',$id)->get('tbl_overtimes')->row();
        if($ot->status=='Rejected' || $ot->status=='Cancelled'){
            return 0;
        }
        $this->db->set('status','Cancelled');
        if($ot->status=='Pending 1'){
            $this->db->set('approver1',$user_id);
            $this->db->set('approver1_date',date('Y-m-d H:i:s'));
        }
        if($ot->status=='Pending 2'){
            $this->db->set('approver2',$user_id);
            $this->db->set('approver2_date',date('Y-m-d H:i:s'));
        }
        if($ot->status=='Pending 3'){
            $this->db->set('approver3',$user_id);
            $this->db->set('approver3_date',date('Y-m-d H:i:s'));
        }
        $this->db->where('id',$id);
        return $this->db->update('tbl_overtimes');
    }

    function CANCEL_APPROVED_OT($id,$user_id){
        $date           = date('Y-m-d H:i:s');

        $ot=$this->db->select('status')->where('id',$id)->get('tbl_overtimes')->row();
        if($ot->status=='Rejected' || $ot->status=='Cancelled' || $ot->status=='Withdrawn'){
            return 0;
        }
        $this->db->set('status','Withdrawn');
        $this->db->set('edit_date', $date);
        
        if($ot->status=='Pending 1'){
            $this->db->set('approver1',$user_id);
            $this->db->set('approver1_date',date('Y-m-d H:i:s'));
        }
        if($ot->status=='Pending 2'){
            $this->db->set('approver2',$user_id);
            $this->db->set('approver2_date',date('Y-m-d H:i:s'));
        }
        if($ot->status=='Pending 3'){
            $this->db->set('approver3',$user_id);
            $this->db->set('approver3_date',date('Y-m-d H:i:s'));
        }
        $this->db->where('id',$id);
        return $this->db->update('tbl_overtimes');
    }


    function CANCEL_APPROVED_HOLIDAYWORK($id,$user_id){
        $date           = date('Y-m-d H:i:s');

        $ot=$this->db->select('status')->where('id',$id)->get('tbl_holidaywork')->row();
        if($ot->status=='Rejected' || $ot->status=='Cancelled' || $ot->status=='Withdrawn'){
            return 0;
        }
        $this->db->set('status','Withdrawn');
        $this->db->set('edit_date', $date);
        
        if($ot->status=='Pending 1'){
            $this->db->set('approver1',$user_id);
            $this->db->set('approver1_date',date('Y-m-d H:i:s'));
        }
        if($ot->status=='Pending 2'){
            $this->db->set('approver2',$user_id);
            $this->db->set('approver2_date',date('Y-m-d H:i:s'));
        }
        if($ot->status=='Pending 3'){
            $this->db->set('approver3',$user_id);
            $this->db->set('approver3_date',date('Y-m-d H:i:s'));
        }
        $this->db->where('id',$id);
        return $this->db->update('tbl_holidaywork');
    }

    function GET_EMPLOYEE_TABLE_ID($col_empl_cmid){
        $sql   = "SELECT id FROM tbl_employee_infos WHERE col_empl_cmid=? ";
        $query = $this->db->query($sql, array($col_empl_cmid));
        $query->next_result();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->id;
        } else {
            return null;
        }
    }

    function GET_OVERTIME_IS_DUPLICATE_DATE_BY_ID($date,$empl_id,$id)
    {
        $sql = "SELECT * FROM tbl_overtimes WHERE date_ot=? AND empl_id=? AND id!=? ";
        $query = $this->db->query($sql, array($date,$empl_id,$id));
        return $query->num_rows();
    }

    function GET_OVERTIME_IS_DUPLICATE_DATE($date,$empl_id)
    {
        $sql = "SELECT * FROM tbl_overtimes WHERE date_ot=? AND empl_id=?";
        $query = $this->db->query($sql, array($date,$empl_id));
        return $query->num_rows();
    }
    
    function GET_HOLIDAY_WORK_IS_DUPLICATE_DATE_EMPL_ID($date,$empl_id)
    {
        $sql = "SELECT * FROM tbl_holidaywork WHERE date=? AND empl_id=? AND status !='Withdrawn' ";
        $query = $this->db->query($sql, array($date,$empl_id));
        return $query->num_rows();
    }

    function ADD_OVERTIME_REQUEST($data)
    {
        return $this->db->insert('tbl_overtimes', $data);
    }
    function ADD_HOLIDAY_WORK_REQUEST($data)
    {
        // return $this->db->insert('tbl_holidaywork', $data);
        $this->db->insert('tbl_holidaywork', $data);
        return $this->db->insert_id(); // Returns the inserted ID
    }

    function UPDATE_OVERTIME($data, $id)
    {
        unset($data['c_id']);
        $this->db->where('id', $id);
        return $this->db->update('tbl_overtimes', $data);
    }

    function GET_OVERTIMES_DIRECT($status,$search,$limit,$offset,$filter_arr){
        
        $new_filter=array();
        $new_filter['tb3.col_empl_company'] =$filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  =$filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    =$filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    =$filter_arr['div'];
        $new_filter['tb3.col_empl_sect']    =$filter_arr['section'];
        $new_filter['tb3.col_empl_group']   =$filter_arr['group'];
        $new_filter['tb3.col_empl_line']    =$filter_arr['line'];
        $new_filter['tb3.col_empl_team']    =$filter_arr['team'];
        $filtered=array_filter($new_filter);
        // var_dump($filtered);    
        $this->db->select('tb1.id,tb1.date_ot,tb1.hours,tb1.comment');
        // $this->db->select('tb2.id as assigned_by_tb_id');
        // $this->db->select('tb3.id as employee_tb_id');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        // $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by",false);
        // $this->db->select("CONCAT_WS('',COALESCE(tb2.col_last_name, ''), 
        // CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END, ', ',
        // COALESCE(tb2.col_frst_name, ''), 
        // CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        // ) AS assigned_by", false);

        // $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee",false);
        
        // $this->db->select("CONCAT_WS('',COALESCE(tb3.col_last_name, ''), 
        // CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix != '' THEN CONCAT(' ', tb3.col_suffix) ELSE '' END, ', ',
        // COALESCE(tb3.col_frst_name, ''), 
        // CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name != '' THEN CONCAT(' ', LEFT(tb3.col_midl_name, 1), '.') ELSE '' END
        // ) AS employee", false);

        $this->db->select("
        CONCAT_WS(
            '', 
            CONCAT(tb3.col_empl_cmid, '-', tb3.col_last_name), 
            CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix <> '' THEN CONCAT(' ',tb3.col_suffix) ELSE '' END,
            CASE WHEN tb3.col_frst_name IS NOT NULL AND tb3.col_frst_name <> '' THEN CONCAT(', ',tb3.col_frst_name) ELSE '' END, 
            CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb3.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)
        ->select("CONCAT('OVT', LPAD(tb1.id, 5, '0')) as c_id", false)
        ->select("DATE_FORMAT(tb1.date_ot, '%d/%m/%Y') as date_ot", false)
        ;

        $this->db->from('tbl_overtimes as tb1');
        if(!empty($filtered)){
            $this->db->where($filtered);
        }
        // $this->db->join('tbl_employee_infos as tb2','tb1.assigned_by=tb2.id','left');
        $this->db->join('tbl_employee_infos as tb3','tb1.empl_id=tb3.id','left');
        // $this->db->where('tb3.reporting_to',$user_id)
        // if(!empty($status)){
        //     $this->db->like('status',$status);
        // }
        if(!empty($search)){
            $this->db->where('tb3.id',$search);
        }
        $this->db->limit($limit,$offset);
        $this->db->order_by('id','desc');
        $query=$this->db->get();
        // echo '<pre>';
        // var_dump($query);
        return $query->result();
    }
    function GET_OVERTIMES2($status,$search,$limit,$offset,$filter_arr,$user_id){
        
        $new_filter=array();
        $new_filter['tb3.col_empl_company'] =$filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  =$filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    =$filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    =$filter_arr['div'];
        $new_filter['tb3.col_empl_sect']    =$filter_arr['section'];
        $new_filter['tb3.col_empl_group']   =$filter_arr['group'];
        $new_filter['tb3.col_empl_line']    =$filter_arr['line'];
        $new_filter['tb3.col_empl_team']    =$filter_arr['team'];
        $filtered=array_filter($new_filter);
        // var_dump($filtered);    
        // $this->db->select('tb1.id, CONCAT("OVT", LPAD(tb1.id, 5, "0")) as c_id,tb1.date_ot,tb1.hours,tb1.type,tb1.time_out,tb1.reason,tb1.status,tb1.comment');
        $this->db->select('tb1.id, CONCAT("OVT", LPAD(tb1.id, 5, "0")) as c_id, DATE_FORMAT(tb1.date_ot, "%d/%m/%Y") as date_ot, tb1.hours, tb1.type, tb1.time_out, tb1.reason, tb1.status, tb1.comment', false);
        $this->db->select('tb2.id as assigned_by_tb_id');
        $this->db->select('tb3.id as employee_tb_id');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        // $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by",false);
        $this->db->select("CONCAT_WS('',COALESCE(tb2.col_empl_cmid, ''), 
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT('-', tb2.col_last_name) ELSE '' END,
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END, ', ',
        COALESCE(tb2.col_frst_name, ''), 
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS assigned_by", false);

        // $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee",false);
        $this->db->select("CONCAT_WS('',COALESCE(tb3.col_empl_cmid, ''), 
        CASE WHEN tb3.col_last_name IS NOT NULL AND tb3.col_last_name != '' THEN CONCAT('-', tb3.col_last_name) ELSE '' END, 
        CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix != '' THEN CONCAT(' ', tb3.col_suffix) ELSE '' END, ', ',
        COALESCE(tb3.col_frst_name, ''), 
        CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name != '' THEN CONCAT(' ', LEFT(tb3.col_midl_name, 1), '.') ELSE '' END
        ) AS employee", false);

        $this->db->from('tbl_overtimes as tb1');
        if(!empty($filtered)){
            $this->db->where($filtered);
        }
        $this->db->join('tbl_employee_infos as tb2','tb1.assigned_by=tb2.id','left');
        $this->db->join('tbl_employee_infos as tb3','tb1.empl_id=tb3.id','left');
        // $this->db->where('tb3.reporting_to',$user_id);
        if(!empty($status)){
            $this->db->like('status',$status);
        }
        if(!empty($search)){
            $this->db->where('tb3.id',$search);
        }
        $this->db->limit($limit,$offset);
        $this->db->order_by('id','desc');
        $query=$this->db->get();
        // echo '<pre>';
        // var_dump($query);
        return $query->result();
    }
    function GET_CUTOFF(){
        $this->db->select("id,name,date_from,date_to");
        $this->db->where("status","Active");
        $query=$this->db->get("tbl_payroll_period");
        return $query->result();
    }
    function GET_ATT_RECORDS($limit,$offset,$date_from='',$date_to=''){ 
        $this->db->select('tb1.id,tb1.date as date,tb2.shift_id,tb1.time_in,tb1.time_out, 
        tb4.name as shift,tb1.empl_id,tb4.time_regular_start,tb4.time_regular_end');
        $this->db->select("CONCAT_WS('', CONCAT(tb3.col_empl_cmid, '-', tb3.col_last_name), 
                CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix <> '' THEN CONCAT(' ',tb3.col_suffix) ELSE '' END,
                CASE WHEN tb3.col_frst_name IS NOT NULL AND tb3.col_frst_name <> '' THEN CONCAT(', ',tb3.col_frst_name) ELSE '' END, 
                CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb3.col_midl_name, 1)), '.') ELSE '' END
                ) AS employee",FALSE);
        $this->db->select("TIMESTAMPDIFF(HOUR,CONCAT_ws(' ',tb1.date,tb1.time_in), CONCAT_ws(' ',tb1.date,tb1.time_out)) AS work_hours",FALSE);
        $this->db->select("TIMESTAMPDIFF(HOUR,tb4.time_regular_start,tb4.time_regular_end) as regular_work_hours",FALSE);
        $this->db->from("tbl_attendance_records as tb1");
        $this->db->join("tbl_attendance_shiftassign as tb2","tb1.date=tb2.date AND tb1.empl_id = tb2.empl_id","left");
        $this->db->join("tbl_employee_infos as tb3","tb1.empl_id=tb3.id","left");
        $this->db->join("tbl_attendance_shifts as tb4","tb2.shift_id=tb4.id","left");
        $this->db->having("work_hours > regular_work_hours  AND NOT EXISTS (SELECT date_ot FROM tbl_overtimes as tb5 WHERE tb1.date=tb5.date_ot AND tb1.empl_id=tb5.empl_id)");
        
        if(!empty($date_from) && !empty($date_to)){
            $this->db->where("tb1.date BETWEEN '$date_from' AND '$date_to' ");   
        }
        $this->db->order_by('tb1.date','ASC');
        $this->db->limit($limit,$offset);
        $query=$this->db->get();
        return $query->result();
    }
    function GET_ATT_RECORDS_COUNT($date_from='',$date_to=''){
        $this->db->select("TIMESTAMPDIFF(HOUR,CONCAT_ws(' ',tb1.date,tb1.time_in), CONCAT_ws(' ',tb1.date,tb1.time_out)) AS work_hours",FALSE);
        $this->db->from("tbl_attendance_records as tb1");
        $this->db->join("tbl_attendance_shiftassign as tb2","tb1.date=tb2.date AND tb1.empl_id = tb2.empl_id","left");
        $this->db->join("tbl_employee_infos as tb3","tb1.empl_id=tb3.id","left");
        $this->db->join("tbl_attendance_shifts as tb4","tb2.shift_id=tb4.id","left");
        $this->db->having("work_hours > 8");
        
        if(!empty($date_from) && !empty($date_to)){
            $this->db->where("tb1.date BETWEEN '$date_from' AND '$date_to' ");   
        }
        $this->db->order_by('tb1.date','ASC');
        $query=$this->db->get();
        return $query->num_rows();
    }
    function GET_ROW_ATTENDANCE($id){
        $this->db->select("tb1.date as date_ot,tb1.empl_id");
        $this->db->select("(TIMESTAMPDIFF(HOUR,CONCAT_WS(' ',tb1.date,tb1.time_in), CONCAT_ws(' ',tb1.date,tb1.time_out)) - 
                            TIMESTAMPDIFF(HOUR,tb3.time_regular_start,tb3.time_regular_end) ) as hours",FALSE);
        $this->db->from('tbl_attendance_records as tb1');
        $this->db->join("tbl_attendance_shiftassign as tb2","tb1.date=tb2.date AND tb1.empl_id=tb2.empl_id","left");
        $this->db->join("tbl_attendance_shifts as tb3","tb2.shift_id=tb3.id");
        $this->db->where("tb1.id",$id);
        $query=$this->db->get();
        return $query->row();
    }

    function GET_OVERTIME_LIST_COUNT($search,$reporting_to_empl, $company, $branch, $dept, $div, $clubhouse, $section, $group, $line, $team, $status) {

        $employee   = !empty($search) ? $search : 'NULL';
        $reporting_to_empl      = !empty($reporting_to_empl) ? $reporting_to_empl : 'NULL';
        $company    = !empty($company) ? "'$company'" : 'NULL';
        $branch     = !empty($branch) ? "'$branch'" : 'NULL';
        $dept       = !empty($dept) ? "'$dept'" : 'NULL';
        $div        = !empty($div) ? "'$div'" : 'NULL';
        $clubhouse  = !empty($clubhouse) ? "'$clubhouse'" : 'NULL';
        $section    = !empty($section) ? "'$section'" : 'NULL';
        $group      = !empty($group) ? "'$group'" : 'NULL';
        $line       = !empty($line) ? "'$line'" : 'NULL';
        $team       = !empty($team) ? "'$team'" : 'NULL';
        $status     = !empty($status) ? "'$status'" : 'NULL';
    
        $procedure = "CALL GetOvertimeListCount($employee, $reporting_to_empl, $company, $branch, $dept, $div, $clubhouse, $section, $group, $line, $team, $status);";
        $query = $this->db->query($procedure);

        if ($query) {
            $result = $query->row();  
            $query->next_result();
            $query->free_result();
            return $result->total_count;
        }
        return 0;
    }
    

    function GET_OVERTIME_LIST($search, $reporting_to_empl, $offset, $limit, $company, $branch, $dept, $div, $clubhouse, $section, $group, $line, $team, $status){

        $search     = !empty($search) ? $search : 'NULL';
        $reporting_to_empl      = !empty($reporting_to_empl) ? $reporting_to_empl : 'NULL';
        $company    = !empty($company) ? "'$company'" : 'NULL';
        $branch     = !empty($branch) ? "'$branch'" : 'NULL';
        $dept       = !empty($dept) ? "'$dept'" : 'NULL';
        $div        = !empty($div) ? "'$div'" : 'NULL';
        $clubhouse  = !empty($clubhouse) ? "'$clubhouse'" : 'NULL';
        $section    = !empty($section) ? "'$section'" : 'NULL';
        $group      = !empty($group) ? "'$group'" : 'NULL';
        $line       = !empty($line) ? "'$line'" : 'NULL';
        $team       = !empty($team) ? "'$team'" : 'NULL';
        $status     = !empty($status) ? "'$status'" : 'NULL';
 
        $procedure = "CALL GetOvertimeList(" . $search . ", " . $reporting_to_empl . ", " . $offset . ", " . $limit . ", " . 
                     $company . ", " . $branch . ", " . $dept . ", " . $div . ", " . $clubhouse . ", " . 
                     $section . ", " . $group . ", " . $line . ", " . $team . ", " . $status . ");";
                 
        $query = $this->db->query($procedure);
        $result = $query->result();
        $query->next_result();
        $query->free_result();
        return $result;
    }


    

    function GET_OVERTIMES($status,$search,$limit,$offset,$filter_arr,$user_id){
        
        $new_filter=array();
        $new_filter['tb3.col_empl_company'] =$filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  =$filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    =$filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    =$filter_arr['div'];
        $new_filter['tb3.col_empl_club']    =$filter_arr['clubhouse'];
        $new_filter['tb3.col_empl_sect']    =$filter_arr['section'];
        $new_filter['tb3.col_empl_group']   =$filter_arr['group'];
        $new_filter['tb3.col_empl_line']    =$filter_arr['line'];
        $new_filter['tb3.col_empl_team']    =$filter_arr['team'];
        $filtered=array_filter($new_filter);
        // var_dump($filtered);    
        $this->db->select('tb1.id,tb1.date_ot,tb1.hours, tb1.ndot, tb1.type,tb1.time_out,tb1.reason,tb1.status,tb1.comment');
        $this->db->select('tb2.id as assigned_by_tb_id');
        $this->db->select('tb3.id as employee_tb_id');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        // $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by",false);
        $this->db->select("CONCAT_WS('',COALESCE(tb2.col_empl_cmid, ''), 
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT('-', tb2.col_last_name) ELSE '' END,
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END, ', ',
        COALESCE(tb2.col_frst_name, ''), 
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS assigned_by", false);

        // $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee",false);
        $this->db->select("CONCAT_WS('',COALESCE(tb3.col_empl_cmid, ''), 
        CASE WHEN tb3.col_last_name IS NOT NULL AND tb3.col_last_name != '' THEN CONCAT('-', tb3.col_last_name) ELSE '' END, 
        CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix != '' THEN CONCAT(' ', tb3.col_suffix) ELSE '' END, ', ',
        COALESCE(tb3.col_frst_name, ''), 
        CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name != '' THEN CONCAT(' ', LEFT(tb3.col_midl_name, 1), '.') ELSE '' END
        ) AS employee", false);

        $this->db->from('tbl_overtimes as tb1');
        if(!empty($filtered)){
            $this->db->where($filtered);
        }
        $this->db->join('tbl_employee_infos as tb2','tb1.assigned_by=tb2.id','left');
        $this->db->join('tbl_employee_infos as tb3','tb1.empl_id=tb3.id','left');
        // $this->db->where('tb3.reporting_to',$user_id);
        if(!empty($status)){
            $this->db->like('status',$status);
        }
        if(!empty($search)){
            $this->db->where('tb3.id',$search);
        }
        $this->db->limit($limit,$offset);
        $this->db->order_by('id','desc');
        $query=$this->db->get();
        // echo '<pre>';
        // var_dump($query);
        return $query->result();
    }

    function GET_OVERTIMES_COUNT_DIRECT($status,$search,$filter_arr){
        $new_filter=array();
        $new_filter['tb3.col_empl_company'] =$filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  =$filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    =$filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    =$filter_arr['div'];
        $new_filter['tb3.col_empl_sect']    =$filter_arr['section'];
        $new_filter['tb3.col_empl_group']   =$filter_arr['group'];
        $new_filter['tb3.col_empl_line']    =$filter_arr['line'];
        $new_filter['tb3.col_empl_team']    =$filter_arr['team'];
        $filtered=array_filter($new_filter);
        $this->db->select('tb1.id,tb1.date_ot,tb1.hours,tb1.type,tb1.time_out,tb1.reason,tb1.status,tb1.comment');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by",false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee",false);
        $this->db->from('tbl_overtimes as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.assigned_by=tb2.id','left');
        $this->db->join('tbl_employee_infos as tb3','tb1.empl_id=tb3.id','left');
        // $this->db->where('tb3.reporting_to',$user_id);
        if(!empty($filtered)){
            $this->db->where($filtered);
        }
        // if(!empty($status)){
        //     $this->db->like('status',$status);
        // }
        if(!empty($search)){
            $this->db->where('tb3.id',$search);
        }
        $query=$this->db->get();
        return $query->num_rows();
    }
    
    function GET_OVERTIMES_COUNT($status,$search,$filter_arr,$user_id){
        $new_filter=array();
        $new_filter['tb3.col_empl_company'] =$filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  =$filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    =$filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    =$filter_arr['div'];
        $new_filter['tb3.col_empl_club']    =$filter_arr['clubhouse'];
        $new_filter['tb3.col_empl_sect']    =$filter_arr['section'];
        $new_filter['tb3.col_empl_group']   =$filter_arr['group'];
        $new_filter['tb3.col_empl_line']    =$filter_arr['line'];
        $new_filter['tb3.col_empl_team']    =$filter_arr['team'];
        $filtered=array_filter($new_filter);
        $this->db->select('tb1.id,tb1.date_ot,tb1.hours,tb1.type,tb1.time_out,tb1.reason,tb1.status,tb1.comment');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by",false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee",false);
        $this->db->from('tbl_overtimes as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.assigned_by=tb2.id','left');
        $this->db->join('tbl_employee_infos as tb3','tb1.empl_id=tb3.id','left');
        // $this->db->where('tb3.reporting_to',$user_id);
        if(!empty($filtered)){
            $this->db->where($filtered);
        }
        if(!empty($status)){
            $this->db->like('status',$status);
        }
        if(!empty($search)){
            $this->db->where('tb3.id',$search);
        }
        $query=$this->db->get();
        return $query->num_rows();
    }
    function GET_HOLIDAY_WORKS_DIRECT($status,$search,$limit,$offset,$filter_arr){
        $new_filter=array();
        $new_filter['tb3.col_empl_company'] =$filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  =$filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    =$filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    =$filter_arr['div'];
        $new_filter['tb3.col_empl_sect']    =$filter_arr['section'];
        $new_filter['tb3.col_empl_group']   =$filter_arr['group'];
        $new_filter['tb3.col_empl_line']    =$filter_arr['line'];
        $new_filter['tb3.col_empl_team']    =$filter_arr['team'];
        $filtered=array_filter($new_filter);
        $this->db->select('tb1.id,tb1.date,tb1.hours, tb1.reason');
        // $this->db->select('tb2.id as assigned_by_tb_id');
        // $this->db->select('tb3.id as employee_tb_id');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        // $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by",false);
        // $this->db->select("CONCAT_WS('',COALESCE(tb2.col_last_name, ''), 
        // CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        // CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        // CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        // ) AS assigned_by", false);

        // $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee",false);
        // $this->db->select("CONCAT_WS('',COALESCE(tb3.col_last_name, ''), 
        // CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix != '' THEN CONCAT(' ', tb3.col_suffix) ELSE '' END,
        // CASE WHEN tb3.col_frst_name IS NOT NULL AND tb3.col_frst_name != '' THEN CONCAT(', ', tb3.col_frst_name) ELSE '' END,
        // CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name != '' THEN CONCAT(' ', LEFT(tb3.col_midl_name, 1), '.') ELSE '' END
        // ) AS employee", false);

        $this->db->select("
        CONCAT_WS(
            '', 
            CONCAT(tb3.col_empl_cmid, '-', tb3.col_last_name), 
            CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix <> '' THEN CONCAT(' ',tb3.col_suffix) ELSE '' END,
            CASE WHEN tb3.col_frst_name IS NOT NULL AND tb3.col_frst_name <> '' THEN CONCAT(', ',tb3.col_frst_name) ELSE '' END, 
            CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name <> '' THEN CONCAT(' ',UPPER(LEFT(tb3.col_midl_name, 1)), '.') ELSE '' END
        ) AS employee
        ", false)
        ->select("CONCAT('HDW', LPAD(tb1.id, 5, '0')) as c_id", false)
        ->select("DATE_FORMAT(tb1.date, '%d/%m/%Y') as date", false);

        $this->db->from('tbl_holidaywork as tb1');
        // $this->db->join('tbl_employee_infos as tb2','tb1.assigned_by=tb2.id','left');
        $this->db->join('tbl_employee_infos as tb3','tb1.empl_id=tb3.id','left');
        if(!empty($filtered)){
            $this->db->where($filtered);
        }
        if(!empty($status)){
            $this->db->like('status',$status);
        }
        if(!empty($search)){
            $this->db->where('tb3.id',$search);
        }
        $this->db->order_by('id','desc');
        $this->db->limit($limit,$offset);
        $query=$this->db->get();
        // echo '<pre>';
        // var_dump($query);
        return $query->result();
    }
    function GET_HOLIDAY_WORKS_IS_DUPLICATE_DATE_BY_ID($date,$empl_id,$id)
    {
        $sql = "SELECT * FROM tbl_holidaywork WHERE date=? AND empl_id=? AND id!=? ";
        $query = $this->db->query($sql, array($date,$empl_id,$id));
        return $query->num_rows();
    }
    function UPDATE_HOLIDAY_WORKS($data, $id)
    {
        unset($data['c_id']);
        $this->db->where('id', $id);
        return $this->db->update('tbl_holidaywork', $data);
    }
    function GET_HOLIDAY_WORKS($status,$search,$limit,$offset,$filter_arr){
        $new_filter=array();
        $new_filter['tb3.col_empl_company'] =$filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  =$filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    =$filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    =$filter_arr['div'];
        $new_filter['tb3.col_empl_club']    =$filter_arr['clubhouse'];
        $new_filter['tb3.col_empl_sect']    =$filter_arr['section'];
        $new_filter['tb3.col_empl_group']   =$filter_arr['group'];
        $new_filter['tb3.col_empl_line']    =$filter_arr['line'];
        $new_filter['tb3.col_empl_team']    =$filter_arr['team'];
        $filtered=array_filter($new_filter);
        $this->db->select('tb1.id,tb1.date,tb1.hours,tb1.type,tb1.reason,tb1.status,tb1.comment');
        $this->db->select('tb2.id as assigned_by_tb_id');
        $this->db->select('tb3.id as employee_tb_id');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        // $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by",false);
        $this->db->select("CONCAT_WS('',COALESCE(tb2.col_empl_cmid, ''), 
        CASE WHEN tb2.col_last_name IS NOT NULL AND tb2.col_last_name != '' THEN CONCAT('-', tb2.col_last_name) ELSE '' END,
        CASE WHEN tb2.col_suffix IS NOT NULL AND tb2.col_suffix != '' THEN CONCAT(' ', tb2.col_suffix) ELSE '' END,
        CASE WHEN tb2.col_frst_name IS NOT NULL AND tb2.col_frst_name != '' THEN CONCAT(', ', tb2.col_frst_name) ELSE '' END,
        CASE WHEN tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name != '' THEN CONCAT(' ', LEFT(tb2.col_midl_name, 1), '.') ELSE '' END
        ) AS assigned_by", false);

        // $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee",false);
        $this->db->select("CONCAT_WS('',COALESCE(tb3.col_empl_cmid, ''), 
        CASE WHEN tb3.col_last_name IS NOT NULL AND tb3.col_last_name != '' THEN CONCAT('-', tb3.col_last_name) ELSE '' END,
        CASE WHEN tb3.col_suffix IS NOT NULL AND tb3.col_suffix != '' THEN CONCAT(' ', tb3.col_suffix) ELSE '' END,
        CASE WHEN tb3.col_frst_name IS NOT NULL AND tb3.col_frst_name != '' THEN CONCAT(', ', tb3.col_frst_name) ELSE '' END,
        CASE WHEN tb3.col_midl_name IS NOT NULL AND tb3.col_midl_name != '' THEN CONCAT(' ', LEFT(tb3.col_midl_name, 1), '.') ELSE '' END
        ) AS employee", false);

        $this->db->from('tbl_holidaywork as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.assigned_by=tb2.id','left');
        $this->db->join('tbl_employee_infos as tb3','tb1.empl_id=tb3.id','left');
        if(!empty($filtered)){
            $this->db->where($filtered);
        }
        if(!empty($status)){
            $this->db->like('status',$status);
        }
        if(!empty($search)){
            $this->db->where('tb3.id',$search);
        }
        $this->db->order_by('id','desc');
        $this->db->limit($limit,$offset);
        $query=$this->db->get();
        // echo '<pre>';
        // var_dump($query);
        return $query->result();
    }
    
    function GET_SHIFT_TYPE($id,$date){
        $this->db->select('tb1.id,tb2.name,tb2.time_regular_start,tb2.time_regular_end');
        $this->db->from('tbl_attendance_shiftassign as tb1');
        $this->db->join('tbl_attendance_shifts as tb2','tb1.shift_id=tb2.id','left');
        $this->db->where('tb1.empl_id',$id);
        $this->db->where('tb1.date',$date);    
        $query=$this->db->get();
        return $query->row();
    }
    function GET_SHIFT_OUT($id,$date){
        $this->db->select('id,time_out');
        $this->db->from('tbl_attendance_records');
        $this->db->where('empl_id',$id);
        $this->db->where('date',$date);    
        $query=$this->db->get();
        return $query->row();
    }
    function GET_DEPARTMENT_MIN_HOUR($id){
        $sql = "SELECT tbl_std_departments.min_hours FROM tbl_employee_infos 
        LEFT JOIN tbl_std_departments ON tbl_employee_infos.col_empl_dept = tbl_std_departments.id WHERE tbl_employee_infos.id = ? ";
        $query = $this->db->query($sql, array($id));
        return $query->row();
    }

    function GET_HOLIDAY_WORKS_COUNT($search,$status,$filter_arr){
        $new_filter = array();
        $new_filter['tb3.col_empl_company'] = isset($filter_arr['company']) ? $filter_arr['company'] : null;
        $new_filter['tb3.col_empl_branch']  = isset($filter_arr['branch']) ? $filter_arr['branch'] : null;
        $new_filter['tb3.col_empl_dept']    = isset($filter_arr['dept']) ? $filter_arr['dept'] : null;
        $new_filter['tb3.col_empl_divi']    = isset($filter_arr['div']) ? $filter_arr['div'] : null;
        $new_filter['tb3.col_empl_club']    = isset($filter_arr['clubhouse']) ? $filter_arr['clubhouse'] : null;
        $new_filter['tb3.col_empl_sect']    = isset($filter_arr['section']) ? $filter_arr['section'] : null;
        $new_filter['tb3.col_empl_group']   = isset($filter_arr['group']) ? $filter_arr['group'] : null;
        $new_filter['tb3.col_empl_line']    = isset($filter_arr['line']) ? $filter_arr['line'] : null;
        $new_filter['tb3.col_empl_team']    = isset($filter_arr['team']) ? $filter_arr['team'] : null;
    
        $filtered = array_filter($new_filter);
        
        $this->db->select('tb1.id,tb1.date,tb1.hours,tb1.type,tb1.reason,tb1.status,tb1.comment');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by",false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee",false);
        $this->db->from('tbl_holidaywork as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.assigned_by=tb2.id','left');
        $this->db->join('tbl_employee_infos as tb3','tb1.empl_id=tb3.id','left');
        if(!empty($filtered)){
            $this->db->where($filtered);
        }
        if(!empty($status)){
            $this->db->like('status',$status);
        }
        if(!empty($search)){
            $this->db->where('tb3.id',$search);
        }
        $this->db->order_by('id','desc');
        $query=$this->db->get();
        return $query->num_rows();
    }
    function GET_TIME_ADJ($status,$search,$limit,$offset,$filter_arr){
        $new_filter=array();
        $new_filter['tb3.col_empl_company'] =$filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  =$filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    =$filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    =$filter_arr['div'];
        $new_filter['tb3.col_empl_sect']    =$filter_arr['section'];
        $new_filter['tb3.col_empl_group']   =$filter_arr['group'];
        $new_filter['tb3.col_empl_line']    =$filter_arr['line'];
        $new_filter['tb3.col_empl_team']    =$filter_arr['team'];
        $filtered=array_filter($new_filter);
        
        $this->db->select('tb1.id,tb1.date_adjustment,tb1.shift_type,
        tb1.time_in_1,tb1.time_out_1,tb1.time_in_2,tb1.time_out_2,tb1.attachment,tb1.status');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by",false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee",false);
        $this->db->from('tbl_attendance_adjustments as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.assigned_by=tb2.id','left');
        $this->db->join('tbl_employee_infos as tb3','tb1.empl_id=tb3.id','left');
        if(!empty($filtered)){
            $this->db->where($filtered);
        }
        if(!empty($status)){
            $this->db->like('status',$status);
        }
        if(!empty($search)){
          $this->db->having("assigned_by = '$search' OR employee LIKE '%$search%' 
          OR date_adjustment LIKE '%$search%'
          OR shift_type LIKE '%$search%'
          OR status LIKE '%$search%'
          OR attachment LIKE '%$search%'
          ");
            
        }
        $this->db->limit($limit,$offset);
        $this->db->order_by('id','desc');
        $query=$this->db->get();
        // echo '<pre>';
        // var_dump($query);
        return $query->result();
    }
     function GET_TIME_ADJ_COUNT($search,$status,$filter_arr){
        $new_filter=array();
        $new_filter['tb3.col_empl_company'] =$filter_arr['company'];
        $new_filter['tb3.col_empl_branch']  =$filter_arr['branch'];
        $new_filter['tb3.col_empl_dept']    =$filter_arr['dept'];
        $new_filter['tb3.col_empl_divi']    =$filter_arr['div'];
        $new_filter['tb3.col_empl_sect']    =$filter_arr['section'];
        $new_filter['tb3.col_empl_group']   =$filter_arr['group'];
        $new_filter['tb3.col_empl_line']    =$filter_arr['line'];
        $new_filter['tb3.col_empl_team']    =$filter_arr['team'];
        $filtered=array_filter($new_filter);
        
        $this->db->select('tb1.id,tb1.date_adjustment,tb1.shift_type,
        tb1.time_in_1,tb1.time_out_1,tb1.time_in_2,tb1.time_out_2,tb1.attachment,tb1.status');
        // $this->db->select(" CONCAT('OVT',LPAD(id, 5, '0')) as c_id",false);
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',LEFT(UPPER(tb2.col_midl_name),1),'.') as assigned_by",false);
        $this->db->select("CONCAT(tb3.col_last_name,',',tb3.col_frst_name,' ',LEFT(UPPER(tb3.col_midl_name),1),'.') as employee",false);
        $this->db->from('tbl_attendance_adjustments as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.assigned_by=tb2.id','left');
        $this->db->join('tbl_employee_infos as tb3','tb1.empl_id=tb3.id','left');
        if(!empty($filtered)){
            $this->db->where($filtered);
        }
        if(!empty($status)){
            $this->db->like('status',$status);
        }
        if(!empty($search)){
          $this->db->having("assigned_by = '$search' OR employee LIKE '%$search%' 
          OR date_adjustment LIKE '%$search%'
          OR shift_type LIKE '%$search%'
          OR status LIKE '%$search%'
          OR attachment LIKE '%$search%'
          ");
            
        }
        $query=$this->db->get();
        // echo '<pre>';
        // var_dump($query);
        return $query->num_rows();
    }
    function GET_SHIFT_ALL_DATA(){
        $sql = "SELECT * FROM tbl_attendance_shifts WHERE status='Active'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_STD_DATA($table){
        $this->db->select('id,name')
        ->from($table)
        ->where(array('status'=>'active'));
        $query=$this->db->get();
        return $query->result();
    }

    function MOD_DISP_HOLIDAY_BASED_DATE($date)
  {
    $query = $this->db
      ->select('col_holi_type')
      ->where('col_holi_date', $date)
      ->get('tbl_std_holidays');

    return $query->result();
  }

    // function ADD_DATA($table,$data){
    //     return $this->db->insert($table, $data);
    // }

    function ADD_DATA($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

        // modal reporting, directs start
        function GET_REPORTING_TO_DIRECTS($employeeId){
            $data['reportingTo'] = null;
            $data['employeeInfo']  = null;
            $data['directsTo']  = null;
            $employeeInfo =$this->GET_EMPLOYEE_BY_ID_REPORTING_TO($employeeId);
            if ($employeeInfo) {
                $data['employeeInfo'] = $employeeInfo;
                $position = $this->GET_POSITION_NAME_BY_ID($employeeInfo->col_empl_posi);
                if(!$position )$position='';
                $data['employeeInfo']->col_empl_posi = $position;
                $company = $this->GET_COMPANY_NAME_BY_ID($employeeInfo->col_empl_company);
                if(!$company )$company='';
                $data['employeeInfo']->col_empl_company = $company;
                $branch = $this->GET_BRANCH_NAME_BY_ID($employeeInfo->col_empl_branch);
                if(!$branch )$branch='';
                $data['employeeInfo']->col_empl_branch = $branch;
                $department = $this->GET_DEPARTMENT_NAME_BY_ID($employeeInfo->col_empl_dept);
                if(!$department)$department='';
                $data['employeeInfo']->col_empl_dept = $department;
                $reportingTo =$this->GET_EMPLOYEE_BY_ID_REPORTING_TO($employeeInfo->reporting_to);
                if($reportingTo){
                    $data['reportingTo'] =$reportingTo;
                }
            }
            $directsTo =$this->GET_EMPLOYEE_BY_ID_DIRECTS($employeeId);
            if (!empty($directsTo)) {
                $data['directsTo']  = $directsTo;
            }
            return $data;
        }
        function GET_EMPLOYEE_BY_ID_REPORTING_TO($employeeId){
            $sql = "SELECT id,col_empl_company,col_empl_branch,col_empl_dept,col_empl_posi,col_empl_cmid,reporting_to,col_comp_emai,col_last_name,col_midl_name,col_frst_name,col_imag_path FROM tbl_employee_infos WHERE id=? ";
            $query = $this->db->query($sql, array($employeeId));
            return $query->row();
        }
        function GET_EMPLOYEE_BY_ID_DIRECTS($employeeId){
            $sql = "SELECT id,col_empl_company,col_empl_branch,col_empl_dept,col_empl_posi,col_empl_cmid,reporting_to,col_comp_emai,col_last_name,col_midl_name,col_frst_name,col_imag_path FROM tbl_employee_infos WHERE reporting_to=? ";
            $query = $this->db->query($sql, array($employeeId));
            return $query->result();
            // col_empl_posi
        }
        function GET_POSITION_NAME_BY_ID($postionId) {
            $sql = "SELECT name FROM tbl_std_positions WHERE id=?";
            $query = $this->db->query($sql, array($postionId));
            $result = $query->row();
            if ($result) {
                return $result->name;
            } else {
                return null; 
            }
        }
        function GET_COMPANY_NAME_BY_ID($postionId) {
            $sql = "SELECT name FROM tbl_std_companies WHERE id=?";
            $query = $this->db->query($sql, array($postionId));
            $result = $query->row();
            if ($result) {
                return $result->name;
            } else {
                return null; 
            }
        }
        function GET_BRANCH_NAME_BY_ID($branchId) {
            $sql = "SELECT name FROM tbl_std_branches WHERE id=?";
            $query = $this->db->query($sql, array($branchId));
            $result = $query->row();
            if ($result) {
                return $result->name;
            } else {
                return null; 
            }
        }
        function GET_DEPARTMENT_NAME_BY_ID($departmentId) {
            $sql = "SELECT name FROM tbl_std_departments WHERE id=?";
            $query = $this->db->query($sql, array($departmentId));
            $result = $query->row();
            if ($result) {
                return $result->name;
            } else {
                return null; 
            }
        }
    function GET_REQUESTOR($type, $id)
    {
        $this->db->select("CONCAT(tb2.col_last_name,',',tb2.col_frst_name,' ',RPAD(LEFT(tb2.col_midl_name,1),2,'.')) as requestor", false);
        if ($type == 'leave') {
            $this->db->from('tbl_leaves_assign as tb1');
        } else if ($type == 'overtime') {
            $this->db->from('tbl_overtimes as tb1');
        } else if ($type == 'holiday work') {
            $this->db->from('tbl_holidaywork as tb1');
        } else if ($type == 'time adjustment') {
            $this->db->from('tbl_attendance_adjustments as tb1');
        }
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id');
        $this->db->where('tb1.id', $id);
        $query = $this->db->get();
        $result = $query->row();
        return $result->requestor;
    }
    function ADD_NOTIFICATION($data)
    {
        $this->db->insert('tbl_notifications', $data);
        return $this->db->insert_id();
    }
    function GET_DATA_ROW($table,$column,$value){
        $this->db->where($column,$value);
        $query=$this->db->get($table);
        return $query->row();
    }
    // modal reporting, directs end
    function GET_SYSTEM_SETTING($setting){
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
        
    }

    function get_system_setup_by_setting2($setting, $value) {
        $query_select = "SELECT * FROM tbl_system_setup WHERE setting=?";
        $result = $this->db->query($query_select, array($setting))->row_array();
        if (!$result) {
            $query_insert = "INSERT INTO tbl_system_setup (setting, value) VALUES (?, ?)";
            $this->db->query($query_insert, array($setting,$value));
            $query_select_new = "SELECT * FROM tbl_system_setup WHERE setting=?";
            $result = $this->db->query($query_select_new, array($setting))->row_array();
        }
        return $result ? $result['value'] : null;
    }
   
    function GET_DEPARTMENTS2(){
        $query =  $this->db
        ->select('id, name, status, min_hours')
        ->where('is_deleted', 0)
        // ->where('id >=', 5)
        ->order_by('id', 'DESC')
        ->get('tbl_std_departments');
        return $query->result();
    }

    function update_step_count($ids, $min_hours)
    {
        $step = ($min_hours == '1') ? 1 : 0.5;
        
        $data = array(
            'min_hours' => $min_hours,
            'step' => $step
        );
    
        $this->db->where_in('id', $ids);
        $this->db->update('tbl_std_departments', $data);
        
        return $step;
    }

    function update_departments($data,$edit_user){
        $date           = date('Y-m-d H:i:s');
        $name           = $data['name'];
        $status         = $data['status'];
        $min_hours      = $data['min_hours'];
        $id             = !empty($data['id']) ? $data['id'] : 0;
        if($id == 0){
            $sql = "INSERT INTO tbl_std_departments (create_date, edit_date, edit_user, min_hours, name, status) VALUES (?,?,?,?,?,?)";
            $query = $this->db->query($sql,array($date,$date,$edit_user,$name,$status,$min_hours));
            if($query){
                return "inserted";
            } else {
                return "failedUpdate";
            }
        }else{
            $sql = "UPDATE tbl_std_departments SET edit_date=?, edit_user=?, name=?, status=?, min_hours=?  WHERE id=?";
            $query = $this->db->query($sql, array($date, $edit_user, $name, $status, $min_hours, $id));
            if($query){
                return "updated";
            } else {
                return "failedInsert";
            }
        }
    }
}