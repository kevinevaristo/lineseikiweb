<?php 

class project_management_model extends CI_Model
{
    function MOD_INSRT_APPLY_REQUEST_SINGLE($project_name, $progress, $status, $code, $type, $budget, $description, $max_member, $start_date, $end_date)

    {

        $sql = "INSERT INTO tbl_projects (project_name, project_progress, status, code, start_date, end_date, type, budget, description, max_members) VALUES (?,?,?,?,?,?,?,?,?,?)";

        $query = $this->db->query($sql, array($project_name, $progress, $status, $code, $start_date, $end_date, $type, $budget, $description, $max_member));

        return $this->db->insert_id();

    }

    // Update

    function MOD_UPDATE($progress, $status, $budget, $description)

    {

        $sql = "UPDATE tbl_projects SET project_progress = ?, status = ?, budget = ?, description = ? WHERE id = ?";

        $query = $this->db->query($sql, array($progress, $status, $budget, $description));

    }


    // Display all data

    function MOD_DISP_ALL_REQUEST()

    {

        $sql = "SELECT * 
                FROM tbl_projects
                LEFT JOIN tbl_project_assign ON tbl_projects.id = tbl_project_assign.project_id
                ORDER BY tbl_projects.id DESC LIMIT 10";

        $query = $this->db->query($sql, array());

        $query->next_result();

        return $query->result();

    }

    // Display employee
    function MOD_DISP_ALL_EMPLOYEES()
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
        // $sql = "SELECT * FROM tbl_empl_info WHERE disabled=0 AND isSuperAdmin != 1 ORDER BY col_empl_cmid DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }


     function MOD_INSRT_APPLY_REQUEST($employees, $project_id, $role, $join_date, $start_date, $end_date)
        {
            $employee_id = implode(', ' , $employees);

        
                $sql = "INSERT INTO tbl_project_assign (employee_id, project_id, role, join_date, start_date, end_date) VALUES (?,?,?,?,?,?)";
        // var_dump($employees);
        // echo $employee_id;

                $query = $this->db->query($sql, array($employee_id, $project_id, $role, $join_date, $start_date, $end_date));
        
             
                return $this->db->insert_id();

           
           
        }

        function MOD_DISP_ALL_PROJECT_ASSIGN()

        {
    
            $sql = "SELECT *  FROM tbl_project_assign ORDER BY id DESC LIMIT 10;";
    
            $query = $this->db->query($sql, array());
    
            $query->next_result();
    
            return $query->result();
        }


        // Task Management

        function MOD_INSRT_APPLY_REQUEST_SINGLE_TASK($employee_id, $title, $description, $date_from, $date_to, $status, $remarks )

    {

        $sql = "INSERT INTO tbl_employee_tasks (employee_id, task_title, task_description, task_date_from, task_date_to, status, remarks) VALUES (?,?,?,?,?,?,?)";

        $query = $this->db->query($sql, array($employee_id, $title, $description, $date_from, $date_to, $status, $remarks));

        return $this->db->insert_id();

    }

    function MOD_UPDATE_TASK($task_id, $title, $description, $date_from, $date_to, $status, $remarks){

        $sql = "UPDATE tbl_employee_tasks SET task_title = ?, task_description = ?, task_date_from = ?, task_date_to = ?, status = ?, remarks = ? WHERE id = ?";

        $query = $this->db->query($sql, array($title, $description, $date_from, $date_to, $status, $remarks, $task_id));

    }

    // =========================================================== MY DETAILS =============================================================

    // Display DETAILS

    function MOD_DISP_MY_REQUEST($user_id)

    {

        $sql = "SELECT * FROM tbl_employee_tasks WHERE employee_id=? ORDER BY id DESC LIMIT 10";

        $query = $this->db->query($sql, array($user_id));

        $query->next_result();

        return $query->result();

    }

    // Display specific Request

    function MOD_DISP_SPECIFIC_REQUEST($id)

    {

        $sql = "SELECT id,status,

        DATE_FORMAT(task_date_from,'%Y-%m-%d') AS task_date_from,

        DATE_FORMAT(task_date_to,'%Y-%m-%d') AS task_date_to,

        task_title,

        task_description,

        remarks,

        attachment,

        DATE_FORMAT(task_date_from,'%I:%i') AS start_time,

        DATE_FORMAT(task_date_from,'%p') AS start_indicator,

        DATE_FORMAT(task_date_to,'%I:%i') AS end_time,

        DATE_FORMAT(task_date_to,'%p') AS end_indicator

        FROM tbl_employee_tasks WHERE id=? ";

        $query = $this->db->query($sql, array($id));

        $query->next_result();

        return $query->result();

    }

    /// ===========================

    function MOD_DISP_ML_DATA_COUNT($user_id)

    {

        $sql = "SELECT COUNT(id) as ml_count FROM tbl_employee_tasks WHERE employee_id=?";

        $query = $this->db->query($sql, array($user_id));

        $query->next_result();

        return $query->result();

    }

    function MOD_DISP_ML_DATA_LIMIT($user_id, $num_start, $numlimit)

    {

        $sql = "SELECT * FROM tbl_employee_tasks WHERE employee_id=? ORDER BY id DESC LIMIT ?,? ";

        $query = $this->db->query($sql, array($user_id, $num_start, $numlimit));

        $query->next_result();

        return $query->result();

    }

    function MOD_DISP_ML_ALL_TASK_INFO(){

        $sql="SELECT task_title AS Title,task_description AS Description,task_date_from AS start,task_date_to AS end,status,attachment,remarks FROM tbl_employee_tasks";

        return $this->db->query($sql,array())->result_array();

    }

    function MOD_DISP_ML_ALL_TASK(){

        $sql = "SELECT * FROM tbl_employee_tasks ORDER BY id DESC";

        $query = $this->db->query($sql);

        $query->next_result();

        return $query->result();

    }
}











?>