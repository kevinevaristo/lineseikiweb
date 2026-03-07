<?php

class recruitments_model extends CI_Model

{

    // =========================================================== APPLY  =============================================================

    function MOD_INSRT_APPLY_REQUEST_SINGLE($employee_id, $title, $description, $feedback, $status, $responsibilities, $qualifications, $job_type, $location, $job_family, $industry, $experience)                  //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "INSERT INTO tbl_recruitment_jobposting (employee_id, title, description, feedback, status, responsibilities, qualifications, job_type, location, job_family, industry, experience_level) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

        $query = $this->db->query($sql, array($employee_id, $title, $description, $feedback, $status, $responsibilities, $qualifications, $job_type, $location, $job_family, $industry, $experience));

        return $this->db->insert_id();
    }

    function MOD_UPDATE($id, $title, $description, $feedback, $status, $responsibilities, $qualifications, $job_type, $location, $job_family, $industry, $experience)                          //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "UPDATE tbl_recruitment_jobposting SET title = ?, description = ?, feedback = ?,  status = ?, responsibilities = ?, qualifications = ?, job_type = ?, location = ?, job_family = ?, industry = ?, experience_level = ? WHERE id = ?";

        $query = $this->db->query($sql, array($title, $description, $feedback, $status, $responsibilities, $qualifications, $job_type, $location, $job_family, $industry, $experience, $id));
        return $query;
    }

    // =========================================================== MY DETAILS =============================================================

    // Display DETAILS

    function MOD_DISP_MY_REQUEST($user_id)

    {

        $sql = "SELECT * FROM tbl_recruitment_jobposting WHERE employee_id=? ORDER BY id DESC LIMIT 10";

        $query = $this->db->query($sql, array($user_id));

        $query->next_result();

        return $query->result();
    }

    // Display specific Request

    function MOD_DISP_SPECIFIC_REQUEST($id)                     //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "SELECT * FROM tbl_recruitment_jobposting WHERE id=? ";

        $query = $this->db->query($sql, array($id));

        $query->next_result();

        return $query->result();
    }

    /// ===========================

    function MOD_DISP_ML_DATA_COUNT($user_id)

    {

        $sql = "SELECT COUNT(id) as ml_count FROM tbl_recruitment_jobposting WHERE employee_id=?";

        $query = $this->db->query($sql, array($user_id));

        $query->next_result();

        return $query->result();
    }

    function MOD_DISP_ML_DATA_LIMIT($user_id, $num_start, $numlimit)                        //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "SELECT * FROM tbl_recruitment_jobposting WHERE employee_id=? ORDER BY id DESC LIMIT ?,? ";

        $query = $this->db->query($sql, array($user_id, $num_start, $numlimit));

        $query->next_result();

        return $query->result();
    }

    function MOD_DISP_ALL_REQUEST()                         //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "SELECT * FROM tbl_recruitment_jobposting ORDER BY id DESC LIMIT 10";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();
    }

    // Display all leave

    function MOD_DISP_ALL_DATA($num_start, $numlimit)                           //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "SELECT * FROM tbl_recruitment_jobposting ORDER BY id DESC LIMIT ?,? ";

        $query = $this->db->query($sql, array($num_start, $numlimit));

        $query->next_result();

        return $query->result();
    }

    function MOD_DISP_ALL_DATA_COUNT()

    {

        $sql = "SELECT COUNT(id) as count FROM tbl_recruitment_jobposting";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();
    }

    function MOD_DELETE($complaint_id)                          //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "DELETE FROM tbl_recruitment_jobposting WHERE id = ?";

        $query = $this->db->query($sql, array($complaint_id));
    }

    function MOD_DISP_ALL($num_start, $numlimit)                //JERENZ: NOT FOUND IN THE CONTROLLER

    {

        $sql = "SELECT * FROM tbl_recruitment_jobposting ORDER BY id DESC LIMIT ?,? ";

        $query = $this->db->query($sql, array($num_start, $numlimit));

        $query->next_result();

        return $query->result();
    }

    function MOD_DISP_SINGLE_ROW($id)                           //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT id, title, description, status, qualifications, responsibilities, job_type, location, job_family, industry, experience_level FROM tbl_recruitment_jobposting WHERE id=? ";
        // $this->db->select('id, title, description, feedback, status');
        // $query = $this->db->get('tbl_job_post', ['id' => $id]);
        $query = $this->db->query($sql, array($id));

        return $query->row_array();
    }

    // Applicant Tracking

    function MOD_INSRT_APPLY_SINGLE($employee_id, $title, $description, $status)                                //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "INSERT INTO tbl_recruitment_entries (employee_id, title, description, feedback, status) VALUES (?,?,?,?,?)";
        $query = $this->db->query($sql, array($employee_id, $title, $description, $feedback, $status));
        return $this->db->insert_id();
    }

    // =========================================================== MY DETAILS =============================================================
    // Display DETAILS
    function MOD_DISP_APPLICANT($user_id)                                   //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT * FROM tbl_recruitment_entries WHERE employee_id=? ORDER BY id DESC LIMIT 10";
        $query = $this->db->query($sql, array($user_id));
        $query->next_result();
        return $query->result();
    }
    // Display specific Request
    function MOD_DISP_SPECIFIC_APPLICANT($id)                               //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT * FROM tbl_recruitment_entries WHERE id=? ";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }
    /// ===========================
    function MOD_DISP_ML_DATA_COUNT_APPLICANT($user_id)                     //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT COUNT(id) as ml_count FROM tbl_recruitment_entries WHERE employee_id=?";
        $query = $this->db->query($sql, array($user_id));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_ML_DATA_LIMIT_APPLICANT($user_id, $num_start, $numlimit)                          //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT * FROM tbl_recruitment_entries WHERE employee_id=? ORDER BY id DESC LIMIT ?,? ";
        $query = $this->db->query($sql, array($user_id, $num_start, $numlimit));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_ALL_REQUEST_APPLICANT()
    {
        $sql = "SELECT * FROM tbl_recruitment_entries ORDER BY id DESC LIMIT 10";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    // Display all leave
    function MOD_DISP_ALL_DATA_APPLICANT($num_start, $numlimit)                         //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT * FROM tbl_recruitment_entries ORDER BY id DESC LIMIT ?,? ";
        $query = $this->db->query($sql, array($num_start, $numlimit));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_ALL_JOB_COUNT()                                                   //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT COUNT(id) as count FROM tbl_job_apply";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DELETE_ENTRY($complaint_id)                                            //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "DELETE FROM tbl_recruitment_entries WHERE id = ?";
        $query = $this->db->query($sql, array($complaint_id));
    }
    function MOD_DISP_ALL_ENTRY($num_start, $numlimit)                                  //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT * FROM tbl_recruitment_entries ORDER BY id DESC LIMIT ?,? ";
        $query = $this->db->query($sql, array($num_start, $numlimit));
        $query->next_result();
        return $query->result();
    }

    public function download($id)                                                       //JERENZ: NOT FOUND IN THE CONTROLLER
    {
        $sql = "SELECT * FROM tbl_job_apply WHERE id=?";

        $query = $this->db->query($sql, array($id));

        $query->next_result();

        return $query->row_array();
    }

    // Former P220
    function MOD_DISP_LEAVETYPES()
    {

        $sql = "SELECT * FROM tbl_leav_type ORDER BY name";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();
    }

    function MOD_DISP_NOTIF_APPLICATION($empl_id)
    {

        $sql = "SELECT * FROM notif_application WHERE empl_id=? ORDER BY id DESC";

        $query = $this->db->query($sql, array($empl_id));

        $query->next_result();

        return $query->result();
    }

    function MOD_UPDT_APPLICATION_NOTIF_STATUS($notif_status, $empl_id, $notif_id)
    {

        $sql = "UPDATE notif_application SET notif_status=? WHERE empl_id=? AND id=?";

        $query = $this->db->query($sql, array($notif_status, $empl_id, $notif_id));
    }

    function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'maiya_reset'";
        return $this->db->query($query)->row_array();
    }

    // function GET_JOB_POSTING($limit, $offset, $status)
    // {
    //     $this->db->select('id,title,description,responsibilities,qualifications,requirements,employment_type,salary_range,attachment,status')
    //         ->where('status', $status)
    //         ->limit($limit, $offset)
    //         ->order_by('id', 'DESC');
    //     $query = $this->db->get('tbl_recruitment_jobposting');
    //     return $query->result();
    // }

    function GET_JOB_POSTING($limit, $offset, $status)
    {
        $this->db->select('*')
            ->where('status', $status)
            ->limit($limit, $offset)
            ->order_by('id', 'DESC');
        $query = $this->db->get('tbl_recruitment_jobposting');

        // Fetch results and format salary range
        $result = $query->result();
        foreach ($result as $job) {
            // Format salary range
            $job->salary_range = $job->min_salary . ' - ' . $job->max_salary;
        }

        return $result;
    }

    function ADD_DATA($table_name, $data)
    {
        $this->db->insert($table_name, $data);
        return $this->db->insert_id();
    }

    function UPDATE_DATA($table_name, $data, $where)
    {
        $this->db->where($where);
        return $this->db->update($table_name, $data);
    }

    function GET_JOB_POSTING_COUNT($status)
    {
        $this->db->select('id,title,description,responsibilities,qualifications,requirements,employment_type,salary_range,attachment,status')
            ->where('status', $status);
        $query = $this->db->get('tbl_recruitment_jobposting');
        return $query->num_rows();
    }

    function GET_JOB_POST($id)
    {
        $this->db->select('tb1.*,tb2.col_suffix,tb2.col_frst_name,tb2.col_last_name,tb2.col_midl_name,tb2.col_empl_cmid');
        $this->db->from('tbl_recruitment_jobposting as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.edit_user=tb2.id', 'left');
        $this->db->where('tb1.id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    function UPDATE_JOB_POSTING($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_recruitment_jobposting', $data);
    }

    function GET_APPLICANT_TRACKING($limit, $offset, $status, $applicant_status = null, $job_title = null)
    {
        $this->db->select('*');

        if ($job_title) {
            $this->db->where('job_title', $job_title);
        }

        if ($applicant_status) {
            $this->db->where('status', $applicant_status);
        }

        $this->db->limit($limit, $offset)
            ->order_by('id', 'DESC');

        $query = $this->db->get('tbl_recruitment_entries');
        $results = $query->result();

        foreach ($results as &$applicant) {
            $applicant_name = $applicant->first_name . " " . $applicant->last_name;
        
            if (!empty($applicant->middle_name)) {
                $applicant_name = $applicant->first_name . " " . $applicant->middle_name . " " . $applicant->last_name;
            }
        
            if (!empty($applicant->suffix)) {
                $applicant_name .= " " . $applicant->suffix;
            }
        
            $applicant->applicant_name = $applicant_name;
        }
        
        // foreach ($results as &$applicant) {
        //     $applicant_name = $applicant->last_name;

        //     if (!empty($applicant->suffix)) {
        //         $applicant_name .= " " . $applicant->suffix;
        //     }

        //     $applicant_name .= ", " . $applicant->first_name;

        //     if (!empty($applicant->middle_name)) {
        //         $applicant_name .= " " . strtoupper(substr($applicant->middle_name, 0, 1)) . ".";
        //     }

        //     $applicant->applicant_name = $applicant_name;
        // }

        return $results;
    }

    function GET_APPLICANT_TRACKING_COUNT($status, $job_title = null, $applicant_status = null)
    {
        $this->db->select('*');

        if ($job_title) {
            $this->db->where('job_title', $job_title);
        }

        if ($applicant_status) {
            $this->db->where('status', $applicant_status);
        }

        $query = $this->db->get('tbl_recruitment_entries');
        return $query->num_rows();
    }

    function GET_APPLICANT($id)
    {
        $this->db->select('tb1.*,tb2.col_suffix,tb2.col_frst_name,tb2.col_last_name,tb2.col_midl_name,tb2.col_empl_cmid');
        $this->db->from('tbl_recruitment_entries as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.edit_user=tb2.id', 'left');
        $this->db->where('tb1.id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    function UPDATE_APPLICANT($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_recruitment_entries', $data);
    }

    public function insert_applicant($data)
    {
        $this->db->insert('tbl_recruitment_entries', $data);
    }

    function GET_ALL_APPLICANTS()
    {
        $sql = "SELECT id, first_name, last_name, phone, email, province, city, baranggay, street, zip_code, status FROM tbl_recruitment_entries";

        $query = $this->db->query($sql);

        if (!$query) {
            log_message('error', 'Database query failed: ' . $this->db->last_query());
            return [];
        }

        return $query->result();
    }

    public function save_applicant($applicant_data)
    {
        // Check if the applicant ID exists in the data
        if (isset($applicant_data['id']) && !empty($applicant_data['id'])) {
            // Check if applicant exists in the database
            $this->db->where('id', $applicant_data['id']);
            $exists = $this->db->get('tbl_recruitment_entries')->row();

            if ($exists) {
                $update_data = [];
                foreach ($applicant_data as $key => $value) {
                    if (!empty($value)) {
                        $update_data[$key] = $value;
                    }
                }

                if (!empty($update_data)) {
                    $this->db->where('id', $applicant_data['id']);
                    $updated = $this->db->update('tbl_recruitment_entries', $update_data);

                    if ($updated) {
                        return true;
                    } else {
                        log_message('error', 'Update failed for ID: ' . $applicant_data['id']);
                        return false;
                    }
                } else {
                    return true;
                }
            }
        }
    }

    function GET_EXAMINATION_LIST($status, $limit, $offset, $applicant_status, $applicant_id = null)
    {
        $this->db->select('tb1.id, applied_date, type, reason, tb1.status, tb1.applicant_status');

        $this->db->select("
            CONCAT(
                tb2.last_name,
                IF(tb2.suffix IS NOT NULL AND tb2.suffix != '', CONCAT(' ', tb2.suffix), ''),
                ', ',
                tb2.first_name,
                IF(tb2.middle_name IS NOT NULL AND tb2.middle_name != '', CONCAT(' ', UPPER(LEFT(tb2.middle_name, 1)), '.'), '')
            ) as applicant", false);

        $this->db->from('tbl_exam_list as tb1');
        $this->db->join('tbl_recruitment_entries as tb2', 'tb1.applicant_id = tb2.id', 'left');

        // Filter by status
        if (!empty($status)) {
            $this->db->where('tb1.status', $status);
        }

        // Filter by applicant_status 
        if (!empty($applicant_status)) {
            $this->db->where('tb1.applicant_status', $applicant_status);
        }

        // Filter by applicant_id 
        if (!empty($applicant_id)) {
            $this->db->where('tb1.applicant_id', $applicant_id);
        }

        $this->db->limit($limit, $offset);
        $this->db->order_by('tb1.id', 'desc');

        $query = $this->db->get();
        return $query->result();
    }


    function GET_EXAMINATION_LIST_COUNT($status, $applicant_status, $applicant_id = null)
    {
        $this->db->select('id,applied_date,applicant_id,type,reason,applicant_status,status');

        if (!empty($status)) {
            $this->db->where('status', $status);
        }

        if (!empty($applicant_status)) {
            $this->db->where('applicant_status', $applicant_status);
        }

        if (!empty($applicant_id)) {
            $this->db->where('applicant_id', $applicant_id);
        }

        $query = $this->db->get('tbl_exam_list');
        return $query->num_rows();
    }


    function GET_APPLICANT_LIST()
    {
        $this->db->select('id,last_name,first_name,middle_name,suffix');
        // $this->db->where("status = 'Active'");
        $query = $this->db->get('tbl_recruitment_entries');
        return $query->result();
    }

    function GET_ALL_APPLICANT_LIST()
    {
        $this->db->select('id,last_name,first_name,middle_name,suffix');
        $query = $this->db->get('tbl_recruitment_entries');
        return $query->result();
    }

    function GET_JOB_TITLE_LIST()
    {
        $this->db->select('id,title');
        $query = $this->db->get('tbl_recruitment_jobposting');
        return $query->result();
    }

    function INSERT_APPLICANTS($table_name, $data)
    {
        return $this->db->insert($table_name, $data);
    }

    function GET_EXAM_APPLICANT($id)
    {
        $this->db->select('tb1.*,tb2.col_suffix,tb2.col_frst_name,tb2.col_last_name,tb2.col_midl_name,tb2.col_empl_cmid,tb3.last_name,tb3.first_name,tb3.middle_name,tb3.suffix');
        $this->db->from('tbl_exam_list as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.edit_user=tb2.id', 'left');
        $this->db->join('tbl_recruitment_entries as tb3', 'tb1.applicant_id = tb3.id', 'left');
        $this->db->where('tb1.id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    function UPDATE_EXAM_APPLICANT($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tbl_exam_list', $data);
    }

    function BULK_ACTIVATE($table, $status, $ids)
    {
        $this->db->set('status', $status);
        $this->db->where_in('id', $ids);
        // $this->db->update($table);
        if ($this->db->update($table)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function GET_ALL_JOB_POST()
    {
        $this->db->select('tb1.id, title, col_imag_path, tb1.create_date, col_frst_name, col_suffix, col_midl_name, col_last_name, description, requirements, responsibilities, qualifications, employment_type, min_salary, max_salary, attachment, status', FALSE)
            ->from('tbl_recruitment_jobposting as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.edit_user = tb2.id', 'left')
            ->where('status', 'Active')
            ->order_by('id', 'desc');

        $query = $this->db->get();

        $result = $query->result();
        foreach ($result as $job) {
            $job->salary_range = $job->min_salary . ' - ' . $job->max_salary;
        }

        return $result;
    }

    public function GET_JOB_BY_ID($job_id)
    {
        $this->db->select('tb1.id, title, col_imag_path, tb1.create_date, col_frst_name, col_suffix, col_midl_name, col_last_name, description, requirements, responsibilities, qualifications, employment_type, min_salary, max_salary, link, attachment, status', FALSE)
            ->from('tbl_recruitment_jobposting as tb1')
            ->join('tbl_employee_infos as tb2', 'tb1.edit_user = tb2.id', 'left')
            ->where('tb1.id', $job_id)
            ->where('status', 'Active');
    
        $query = $this->db->get();
        $result = $query->result();
    
        foreach ($result as $job) {
            $job->salary_range = $job->min_salary . ' - ' . $job->max_salary;
        }
    
        return $result;
    }
    
    function GET_SYSTEM_SETTING($setting)
    {
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
    }

    function get_navbar()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'navbarLogo'";
        return $this->db->query($query)->row_array();
    }

    function get_login_logo()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'loginLogo'";
        return $this->db->query($query)->row_array();
    }

    function get_company_name()
    {
        $query = "SELECT value FROM tbl_system_setup WHERE setting = 'CompanyName'";
        return $this->db->query($query)->row()->value;
    }
}
