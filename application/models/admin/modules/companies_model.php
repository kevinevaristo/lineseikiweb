<?php
class companies_model extends CI_Model
{
    function GET_ORGANIZATION_CHART()
    {
        // $sql = "SELECT 
        // a.id,CONCAT(a.col_last_name,', ',a.col_frst_name,' ',LEFT(a.col_midl_name, 1),'.') AS name,
        // a.col_imag_path AS image,
        // a.col_empl_posi AS position,a.extra_posi as extra_position,
        // CONCAT(b.col_last_name,', ',b.col_frst_name,' ',LEFT(b.col_midl_name, 1),'.') AS reporting_to,
        // b.col_imag_path as superior_image,
        // b.col_empl_posi AS superior_position,
        // b.extra_posi as superior_extra_position
        // FROM tbl_employee_infos a
        // LEFT JOIN tbl_employee_infos b 
        // ON b.id=a.reporting_to  
        // WHERE a.reporting_to AND a.termination_date='0000-00-00' AND a.disabled=0";
        $sql = "SELECT 
                    a.id,
                    CONCAT_WS(
                        '',
                        COALESCE(a.col_last_name, ''),
                        CASE WHEN a.col_suffix IS NOT NULL AND a.col_suffix != '' THEN CONCAT(' ',a.col_suffix) ELSE '' END, ', ',
                        COALESCE(a.col_frst_name, ''),
                        CASE WHEN a.col_midl_name IS NOT NULL AND a.col_midl_name != '' THEN CONCAT(' ', LEFT(a.col_midl_name, 1), '.') ELSE '' END
                    ) AS name,
                    a.col_imag_path AS image,
                    a.col_empl_posi AS position,
                    a.extra_posi as extra_position,
                    CONCAT_WS(
                        '', 
                        COALESCE(b.col_last_name, ''), 
                        CASE WHEN b.col_suffix IS NOT NULL AND b.col_suffix != '' THEN CONCAT(' ',b.col_suffix) ELSE '' END, ', ',
                        COALESCE(b.col_frst_name, ''),
                        CASE WHEN b.col_midl_name IS NOT NULL AND b.col_midl_name != '' THEN CONCAT(' ', LEFT(b.col_midl_name, 1), '.') ELSE '' END
                    ) AS reporting_to,
                    b.col_imag_path as superior_image,
                    b.col_empl_posi AS superior_position,
                    b.extra_posi as superior_extra_position
                FROM 
                    tbl_employee_infos a
                LEFT JOIN 
                    tbl_employee_infos b ON b.id = a.reporting_to  
                WHERE 
                    a.reporting_to 
                    AND a.termination_date IS NULL OR a.termination_date = '0000-00-00'
                    AND a.disabled = 0";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function GET_SYSTEM_SETTING($setting)
    {
        $is_exist=$this->db->select("value")->where('setting',$setting)->get("tbl_system_setup")->row();
        if($is_exist){
            return $is_exist->value;
        }else{
            $this->db->insert("tbl_system_setup",array('setting'=>$setting,'value'=>'0'));
            return 0;
        }
    }


    function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'maiya_reset'";
        return $this->db->query($query)->row_array();
    }
    function GET_KNOWLEDGE_BASES($limit, $offset, $status){
        $this->db->select('tb1.id,tb1.title,tb1.description,tb1.feedback,tb1.status,tb1.attachment');
        $this->db->select('CONCAT(tb2.col_last_name,IF(tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> "", CONCAT(" ",tb2.col_suffix, ""), ""), ", ",
        tb2.col_frst_name, " ",IF(tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> "", CONCAT(LEFT(tb2.col_midl_name, 1), "."), "")) as employee', false);
        $this->db->from('tbl_hr_knowledgebases as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.employee_id=tb2.id','left');
        $this->db->where('tb1.status',$status);
        $this->db->limit($limit,$offset);
        $this->db->order_by('tb1.id','desc');
        $query=$this->db->get();
        return $query->result();
    }
    function GET_KNOWLEDGE_BASES_COUNT($status){
        $this->db->where('status',$status);
        $query=$this->db->get('tbl_hr_knowledgebases');
        return $query->num_rows();
    }
    function GET_KNOWLEDGE_BASE($id){
        $this->db->select('tb1.id,tb1.employee_id,tb1.title,tb1.description,tb1.feedback,tb1.status,tb1.attachment');
        $this->db->select('CONCAT(tb2.col_empl_cmid,"-",tb2.col_last_name,IF(tb2.col_suffix IS NOT NULL AND tb2.col_suffix <> "", CONCAT(" ",tb2.col_suffix, ""), ""), ", ",
        tb2.col_frst_name, " ",IF(tb2.col_midl_name IS NOT NULL AND tb2.col_midl_name <> "", CONCAT(LEFT(tb2.col_midl_name, 1), "."), "")) as employee', false);
        $this->db->from('tbl_hr_knowledgebases as tb1');
        $this->db->join('tbl_employee_infos as tb2','tb1.employee_id=tb2.id','left');
        $this->db->where('tb1.id',$id);
        $query=$this->db->get();
        return $query->row();
    }
    function GET_POSITION()
    {
        $sql = "SELECT id,name FROM tbl_std_positions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_ANNOUNCEMENTS()
    {
        $this->db->select('tb1.id,title,col_imag_path,tb1.create_date,col_frst_name,col_suffix,col_midl_name,col_last_name,description,attachment,status', FALSE)
            ->from('tbl_hr_announcements as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.edit_user=tb2.id', 'left')
            ->where('status', 'Active')
            ->order_by('id', 'desc');

        $query = $this->db->get();
        return $query->result();
    }

    function GET_ALL_JOB_POST()
    {
        $this->db->select('tb1.id,title,col_imag_path,tb1.create_date,col_frst_name,col_suffix,col_midl_name,col_last_name,description,responsibilities,qualifications,attachment,status', FALSE)
            ->from('tbl_recruitment_jobposting as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.edit_user=tb2.id', 'left')
            ->where('status', 'Active')
            ->order_by('id', 'desc');

        $query = $this->db->get();
        return $query->result();
    }

    function BULK_ACTIVATE($table, $status, $ids)
    {
        $this->db->set('status', $status);
        $this->db->where_in('id', $ids);
        $this->db->update($table);
    }

    function MOD_DISP_ANNOUNCEMENTS()
    {
        $sql = "SELECT * FROM tbl_hr_announcements ORDER BY id DESC LIMIT 20";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ANC_DATA_COUNT()
    {
        $sql = "SELECT COUNT(id) as anc_count FROM tbl_hr_announcements";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_REQUEST()
    {
        $sql = "SELECT * FROM tbl_hr_aboutcompany where status='Active' ORDER BY id DESC LIMIT 10";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_DATA_COUNT()
    {
        $sql = "SELECT COUNT(id) as count FROM tbl_hr_complaints";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function EDIT_ABOUT_ALL($about, $mission, $vision)
    {
        $sql = "UPDATE tbl_hr_aboutcompany set about_cmp=?, mission=?, vision=? where id=1";
        $query = $this->db->query($sql, array($about, $mission, $vision));
    }

    function GET_ALL_EMPLOYEES()
    {
        $this->db->select('id,reporting_to,col_empl_cmid,
        col_last_name,col_midl_name,col_frst_name');
        $this->db->select('CONCAT(col_empl_cmid,"-",col_last_name,IF(col_suffix IS NOT NULL AND col_suffix <> "", CONCAT(" ",col_suffix, ""), ""), ", ",
        col_frst_name, " ",IF(col_midl_name IS NOT NULL AND col_midl_name <> "", CONCAT(LEFT(col_midl_name, 1), "."), "")) as fullname', false)
            ->where("termination_date IS NULL OR termination_date='0000-00-00'")
            ->where('disabled', 0);
         $this->db->order_by('col_empl_cmid + 0 ', 'ASC');
        $query = $this->db->get('tbl_employee_infos');
        return $query->result_object();
    }

    function GET_FILTERED_EMPLOYEELIST($offset, $row, $branch, $dept, $division, $section, $group, $team, $line)
    {

        if ($branch    == "all") {
            $branch     = "col_empl_branch";
        }
        if ($dept      == "all") {
            $dept       = "col_empl_dept";
        }
        if ($division  == "all") {
            $division   = "col_empl_divi";
        }
        if ($section   == "all") {
            $section    = "col_empl_sect";
        }
        if ($group     == "all") {
            $group      = "col_empl_group";
        }
        if ($team      == "all") {
            $team       = "col_empl_team";
        }
        if ($line      == "all") {
            $line       = "col_empl_line";
        }

        $sql = "SELECT id,reporting_to,col_empl_cmid,
        col_last_name,col_imag_path,col_midl_name,col_frst_name
        FROM tbl_employee_infos 
        WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND col_empl_branch = $branch
        AND col_empl_dept = $dept
        AND col_empl_divi = $division
        AND col_empl_sect = $section
        AND col_empl_group = $group
        AND col_empl_team = $team
        AND col_empl_line = $line
        ORDER BY col_empl_cmid ASC
        LIMIT " . $offset . ", " . $row . " ";

        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function UPDATE_ORGANIZATION($ids, $reporting_to)
    {
        $data = array(
            'reporting_to' => $reporting_to
        );
        $this->db->where_in('id', $ids);

        return $this->db->update('tbl_employee_infos', $data);
    }

    function GET_ABOUT_THE_COMPANY()
    {
        $tableName = 'tbl_hr_aboutcompany';
        $columnName = 'html_content';
        $idToRetrieve = 1;
        $query = $this->db->select($columnName)->from($tableName)->where('id', $idToRetrieve)->get();
        if ($query->num_rows() > 0) {
            $result = $query->row();
            $htmlContent = $result->$columnName;
            $data = array('htmlContent' => $htmlContent);
            return $data;
        } else {
            return null;
        }
    }

    // function GET_ALL_HOLIDAYS($year)
    // {
    //     $this->db->select('col_holi_date,name,col_holi_type')
    //         ->where('year', $year)
    //         ->where('status', 'Active')
    //         ->order_by('col_holi_date', 'asc');
    //     $query = $this->db->get('tbl_std_holidays');
    //     return $query->result();
    // }

    function GET_ALL_HOLIDAYS($year)
    {
        $this->db->select('col_holi_date, name, col_holi_type')
            ->where('year', $year)
            ->where('status', 'Active')
            ->order_by('MONTH(col_holi_date)', 'ASC')
            ->order_by('DAY(col_holi_date)', 'ASC');
        $query = $this->db->get('tbl_std_holidays');
        return $query->result();
    }

    function GET_ALL_POLICIES()
    {
        $this->db->select('id,title,description,attachment')
            ->where('status', 'Active');
        $query = $this->db->get('tbl_hr_policies');
        return $query->result();
    }

    function GET_YEARS(){
        $sql = "SELECT name FROM tbl_std_years WHERE status='Active' ORDER BY name DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }
    function ADD_DATA($table,$data){
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id; 
    }
    function UPDATE_DATA($table,$data,$id){
        $this->db->where('id',$id);
        return $this->db->update($table,$data);
    }
}
