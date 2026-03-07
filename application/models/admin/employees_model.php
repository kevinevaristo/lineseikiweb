<?php
class employees_model extends CI_Model
{
    // Display Employees
    function GET_EMPLOYEE_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function GET_DEPENDENTS_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_dependents WHERE col_depe_empid=? AND is_deleted='0' ORDER BY col_depe_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function GET_DEPENDENTS()
    {
        $sql = "SELECT * FROM tbl_employee_dependents";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_EMERGENCY()
    {
        $sql = "SELECT * FROM tbl_employee_emergency ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_DOCUMENTS()
    {
        $sql = "SELECT * FROM tbl_employee_documents";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_EMERGENCY_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_emergency WHERE empid=? and is_deleted=0 ORDER BY name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }
        function GET_EMERGENCY_SPECIFIC_BY_ID($id)
        {
            $sql = "SELECT * FROM tbl_employee_emergency WHERE id=? ORDER BY name";
            $query = $this->db->query($sql, array($id));
            return $query->row_array();
        }

        function ADD_EMERGENCY_CONTACT($empl_id,$relation,$contact_name,$mobile_num,$work_phone_number,$home_phone_number,$current_address){
            $sql="INSERT INTO tbl_employee_emergency(empid,name,relationship,mobile_number,work_phone,home_phone,current_address) VALUE(?,?,?,?,?,?,?)";
            return  $this->db->query($sql, array($empl_id,$contact_name,$relation,$mobile_num,$work_phone_number,$home_phone_number,$current_address));
        }
        function UPDATE_EMERGENCY_CONTACT($id,$empl_id,$relation,$contact_name,$mobile_num,$work_phone_number,$home_phone_number,$current_address){
            $sql="UPDATE tbl_employee_emergency 
                SET empid=?,name=?,relationship=?,mobile_number=?,work_phone=?,home_phone=?,current_address=? WHERE id=?";
            return  $this->db->query($sql, array($empl_id,$contact_name,$relation,$mobile_num,$work_phone_number,$home_phone_number,$current_address,$id));
        }
        function DELETE_EMERGENCY_CONTACT($id){
            $sql="UPDATE tbl_employee_emergency 
                SET is_deleted=1 WHERE id=?";
            return  $this->db->query($sql, array($id));
        }

    function GET_DOCUMENTS_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_documents WHERE col_empl_id=? AND is_deleted=0";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }
    function ADD_EMPL_DOCUMENT($file,$file_name,$empl_id){
        $sql="INSERT INTO tbl_employee_documents(edit_user,col_doc_file,col_doc_name,col_empl_id) VALUE(?,?,?,?)";
        return $this->db->query($sql, array($empl_id,$file,$file_name,$empl_id));
    }
    function DELETE_EMPL_DOCUMENT($id){
        $sql="UPDATE tbl_employee_documents SET is_deleted=1 WHERE id=?";
        return $this->db->query($sql, array($id));
    }
    function GET_TYPE()
    {
        $sql = "SELECT id,name FROM tbl_std_employeetypes";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_BRANCHES()
    {
        $sql = "SELECT id,name FROM tbl_std_branches";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_POSITION()
    {
        $sql = "SELECT id,name FROM tbl_std_positions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_DEPARTMENTS()
    {
        $sql = "SELECT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_DIVISIONS()
    {
        $sql = "SELECT id,name FROM tbl_std_divisions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SECTIONS()
    {
        $sql = "SELECT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_GROUPS()
    {
        $sql = "SELECT id,name FROM tbl_std_groups";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_LINES()
    {
        $sql = "SELECT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_TEAMS()
    {
        $sql = "SELECT id,name FROM tbl_std_teams";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_GENDERS()
    {
        $sql = "SELECT id,name FROM tbl_std_genders";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_HMO()
    {
        $sql = "SELECT id,name FROM tbl_std_hmos";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SHIRT_SIZE()
    {
        $sql = "SELECT id,name FROM tbl_std_shirtsizes";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_MARITAL()
    {
        $sql = "SELECT id,name FROM tbl_std_maritalstatuses";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_NATIONALITY()
    {
        $sql = "SELECT id,name FROM tbl_std_nationalities";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_COMPANIES_ACTIVE()
    {
        $sql = "SELECT id,name FROM tbl_std_companies WHERE status = 'Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_COMPANIES()
    {
        $sql = "SELECT id,name FROM tbl_std_companies";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_BRANCHES_ACTIVE()
    {
        $sql = "SELECT id,name FROM tbl_std_branches WHERE status = 'Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_DEPARTMENTS_ACTIVE()
    {
        $sql = "SELECT id,name FROM tbl_std_departments WHERE status = 'Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_TEAMS_ACTIVE()
    {
        $sql = "SELECT id,name FROM tbl_std_teams WHERE status = 'Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_EDUCATION_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_education WHERE col_empl_id = ? AND is_deleted=0";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }
        function DELETE_EDUCATION($id){
            $sql="UPDATE tbl_employee_education SET is_deleted=1 WHERE id=?";
            return $this->db->query($sql, array($id));
        }

    function GET_EDUCATION_SPECIFIC2($id)
    {
        $sql = "SELECT * FROM tbl_employee_education WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }

    function GET_USER_ACCESS()
    {
        $sql = "SELECT id,user_access FROM tbl_system_useraccess";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEE_LOGS_SPECIFIC($empl_id)
    {
        $sql = "SELECT * FROM tbl_employee_logs WHERE empl_id=? AND category != 'Salary Rate' AND category != 'Salary Type' ORDER BY log_date DESC LIMIT 1000";
        // $sql = "SELECT el.*, ei.col_frst_name, ei.col_last_name
        // FROM tbl_employee_logs el
        // JOIN tbl_employee_infos ei ON el.edit_id = ei.id
        // WHERE el.empl_id = ?
        // ORDER BY el.log_date DESC LIMIT 100";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEE_SALARY_LOGS_SPECIFIC($empl_id)
    {
        $sql = "SELECT * FROM tbl_employee_logs WHERE empl_id=? AND category = 'Salary Rate' OR category = 'Salary Type' ORDER BY log_date DESC LIMIT 1000";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }


    function GET_TABLEPLUS()
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0 ORDER BY id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function is_duplicate_data($data_row){
        $sql = "SELECT col_empl_cmid FROM tbl_employee_infos WHERE col_empl_cmid = ?";
        $query = $this->db->query($sql, $data_row[0]);
        return $query->num_rows();
    }


    function insert_data($data){

        $C_BRANCH                   = $this->GET_BRANCHES();
        $C_SECTIONS                 = $this->GET_SECTIONS();
        $C_DEPARTMENTS              = $this->GET_DEPARTMENTS();
        $C_POSITIONS                = $this->GET_POSITION();
        $C_TYPE                     = $this->GET_TYPE();
        $C_SHIRT_SIZE               = $this->GET_SHIRT_SIZE();
        $C_GENDERS                  = $this->GET_GENDERS();
        $C_MARITAL                  = $this->GET_MARITAL();
        $C_NATIONALITY              = $this->GET_NATIONALITY();
        $C_GROUPS                   = $this->GET_GROUPS();
        $C_LINES                    = $this->GET_LINES();
        $C_DIVISIONS                = $this->GET_DIVISIONS();
        $C_HMOS                     = $this->GET_HMO();
        $C_USER_ACCESS              = $this->GET_USER_ACCESS();
        $C_COMPANIES                = $this->GET_COMPANIES();
        $C_BRANCHES                 = $this->GET_BRANCHES();
        $C_TEAMS                    = $this->GET_TEAMS();

        $user_access                    =  1; // Default
        $data_4                         =  $this->convert_name2id($C_MARITAL, $data[4]);
        $data_7                     =  date("Y-m-d", strtotime( ($data[7]) ? $data[7] : "0000-00-00"));
        $data_8                         =  $this->convert_name2id($C_GENDERS, $data[8]);
        $data_9                        =  $this->convert_name2id($C_NATIONALITY, $data[9]);
        $data_10                        =  $this->convert_name2id($C_SHIRT_SIZE, $data[10]);
        // $hire_date                      = date("Y-m-d", strtotime( ($data[13]) ? $data[13] : "0000-00-00")); 
        $data_13                      = (!empty($data[13]) && strtotime($data[13])) ? date("Y-m-d", strtotime($data[13])) : "0000-00-00";
        $data_14                        = (!empty($data[14]) && strtotime($data[14])) ? date("Y-m-d", strtotime($data[14])) : "0000-00-00";
        // $data_15                        = date("Y-m-d", strtotime( ($data[15]) ? $data[15] : "0000-00-00")); 
        $data_15                        = (!empty($data[15]) && strtotime($data[15])) ? date("Y-m-d", strtotime($data[15])) : "0000-00-00";
        // $data_16                        = date("Y-m-d", strtotime( ($data[16]) ? $data[16] : "0000-00-00"));
        $data_16                        = (!empty($data[16]) && strtotime($data[16])) ? date("Y-m-d", strtotime($data[16])) : "0000-00-00";
        $data_17                        =  $this->convert_name2id($C_TYPE, $data[14]);
        $data_18                        =  $this->convert_name2id($C_POSITIONS, $data[18]);
        $data_19                        =  $this->convert_name2id($C_COMPANIES, $data[19]);
        $data_20                        =  $this->convert_name2id($C_BRANCHES, $data[20]);
        $data_21                        =  $this->convert_name2id($C_DEPARTMENTS, $data[21]);
        $data_22                        =  $this->convert_name2id($C_DIVISIONS, $data[22]);
        $data_23                        =  $this->convert_name2id($C_SECTIONS, $data[23]);
        $data_24                        =  $this->convert_name2id($C_GROUPS, $data[24]);
        $data_25                        =  $this->convert_name2id($C_TEAMS, $data[25]);
        $data_26                        =  $this->convert_name2id($C_LINES, $data[26]);
        $data_35                        =  $this->convert_name2id($C_HMOS, $data[35]);
        $data_39                        = ($data[39] ==='Active') ? 0 : 1;

        $current_date = date('Y-m-d H:i:s');

        $sql = "INSERT INTO tbl_employee_infos (create_date, edit_date, col_empl_cmid, col_user_access, col_last_name, col_midl_name, col_frst_name, col_mart_stat, col_home_addr, col_curr_addr, col_birt_date, col_empl_gend, col_empl_nati, col_shir_size, col_empl_emai, col_mobl_numb, col_hire_date, date_regular, resignation_date, col_endd_date, col_empl_type, col_empl_posi, col_empl_company, col_empl_branch, col_empl_dept, col_empl_divi, col_empl_sect, col_empl_group, col_empl_team, col_empl_line, col_imag_path, col_empl_sssc, col_empl_hdmf, col_empl_phil, col_empl_btin, col_empl_driv, col_empl_naid, col_empl_pass, col_empl_hmoo, col_empl_hmon, salary_rate, salary_type, disabled) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $this->db->query($sql,array($current_date, $current_date, $data[0], $user_access, $data[1], $data[2], $data[3], $data_4, $data[5], $data[6], $data_7, $data_8, $data_9, $data_10, $data[11], $data[12], $data_13, $data_14, $data_15, $data_16, $data_17, $data_18, $data_19, $data_20, $data_21, $data_22, $data_23, $data_24, $data_25, $data_26, $data[27], $data[28], $data[29], $data[30], $data[31], $data[32], $data[33], $data[34], $data_35, $data[36], $data[37], $data[38], $data_39));
    }



    function convert_name2id($array, $pos)
    {
        $id = "";
        $posLower = strtolower($pos);
        foreach ($array as $e) {
            $nameLower = strtolower($e->name);
            if ($nameLower == $posLower) {
                $id = $e->id;
                return $id;
            }
        }
        return 0;
    }

    function update_data($data, $edit_id_logs) {
        // $C_BRANCH                   = $this->GET_BRANCHES();
        $C_SECTIONS                 = $this->GET_SECTIONS();
        $C_DEPARTMENTS              = $this->GET_DEPARTMENTS();
        $C_POSITIONS                = $this->GET_POSITION();
        $C_TYPE                     = $this->GET_TYPE();
        $C_SHIRT_SIZE               = $this->GET_SHIRT_SIZE();
        $C_GENDERS                  = $this->GET_GENDERS();
        $C_MARITAL                  = $this->GET_MARITAL();
        $C_NATIONALITY              = $this->GET_NATIONALITY();
        $C_GROUPS                   = $this->GET_GROUPS();
        $C_LINES                    = $this->GET_LINES();
        $C_DIVISIONS                = $this->GET_DIVISIONS();
        $C_HMOS                     = $this->GET_HMO();
        $C_COMPANIES                = $this->GET_COMPANIES();
        $C_BRANCHES                 = $this->GET_BRANCHES();
        $C_TEAMS                    = $this->GET_TEAMS();

        $data_4                     =  $this->convert_name2id($C_MARITAL, $data[4]);

        $birth_date_array           = explode("/", $data[7]);
        $birth_date_day             = $birth_date_array[0];
        $birth_date_month           = $birth_date_array[1];
        $birth_date_year            = $birth_date_array[2];
        $birth_date                 = date("Y-m-d", strtotime($birth_date_day .'-'.$birth_date_month .'-'. $birth_date_year));
        
        $data_8                         =  $this->convert_name2id($C_GENDERS, $data[8]);
        $data_9                         =  $this->convert_name2id($C_NATIONALITY, $data[9]);
        $data_10                        =  $this->convert_name2id($C_SHIRT_SIZE, $data[10]);
 
        $hire_date_array           = explode("/", $data[13]);
        $hire_date_day             = $hire_date_array[0];
        $hire_date_month           = $hire_date_array[1];
        $hire_date_year            = $hire_date_array[2];
        $hire_date                 = date("Y-m-d", strtotime($hire_date_day .'-'.$hire_date_month .'-'. $hire_date_year));

        $regular_date_array           = explode("/", $data[14]);
        $regular_date_day             = $regular_date_array[0];
        $regular_date_month           = $regular_date_array[1];
        $regular_date_year            = $regular_date_array[2];
        $regular_date                 = date("Y-m-d", strtotime($regular_date_day .'-'.$regular_date_month .'-'. $regular_date_year));

        $resign_date_array           = explode("/", $data[15]);
        $resign_date_day             = $resign_date_array[0];
        $resign_date_month           = $resign_date_array[1];
        $resign_date_year            = $resign_date_array[2];
        $resign_date                 = date("Y-m-d", strtotime($resign_date_day .'-'.$resign_date_month .'-'. $resign_date_year));

        $endd_date_array           = explode("/", $data[16]);
        $endd_date_day             = $endd_date_array[0];
        $endd_date_month           = $endd_date_array[1];
        $endd_date_year            = $endd_date_array[2];
        $endd_date                 = date("Y-m-d", strtotime($endd_date_day .'-'.$endd_date_month .'-'. $endd_date_year));

        $data_17                        =  $this->convert_name2id($C_TYPE, $data[17]);
        $data_18                        =  $this->convert_name2id($C_POSITIONS, $data[18]);
        $data_19                        =  $this->convert_name2id($C_COMPANIES, $data[19]);
        $data_20                        =  $this->convert_name2id($C_BRANCHES, $data[20]);
        $data_21                        =  $this->convert_name2id($C_DEPARTMENTS, $data[21]);
        $data_22                        =  $this->convert_name2id($C_DIVISIONS, $data[22]);
        $data_23                        =  $this->convert_name2id($C_SECTIONS, $data[22]);
        $data_24                        =  $this->convert_name2id($C_GROUPS, $data[24]);
        $data_25                        =  $this->convert_name2id($C_TEAMS, $data[25]);
        $data_26                        =  $this->convert_name2id($C_LINES, $data[26]);
        // $data_23                        =  $this->convert_name2id($C_SECTIONS, $data[23]);
        $data_35                        =  $this->convert_name2id($C_HMOS, $data[35]);

        $sqlold = "SELECT * FROM tbl_employee_infos WHERE col_empl_cmid=?";
        $queryold = $this->db->query($sqlold, array($data[0]));
        $queryold->next_result();
        $old = $queryold->result();
        // return $query->result();
        $current_date = date('Y-m-d H:i:s');
        $setColumns = "edit_date=?";
        $queryData = array($current_date);
        $logs = [];
        foreach ($old[0] as $key => $value) {
            if ($key == "col_last_name" && !empty($data[1]) && $value != $data[1]) {
                $setColumns .= ", $key=?";
                array_push($queryData, $data[1]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[1],
                ]);
            }else if ($key == "col_empl_company" && !empty($data[1]) && $value != $data[1]) {
                $setColumns .= ", $key=?";
                array_push($queryData, $data[1]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[1],
                ]);
            }else if ($key == "col_midl_name" && !empty($data[2]) && $value != $data[2]) {
                $setColumns .= ", $key=?";
                array_push($queryData, $data[2]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[2],
                ]);
            }else if ($key == "col_frst_name" && !empty($data[3]) && $value != $data[3]) {
                $setColumns .= ", $key=?";
                array_push($queryData, $data[3]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[3],
                ]);
            }else if ($key == "col_mart_stat" && !empty($data[4]) && $value != $data_4) {
                $setColumns .= ", $key=?";
                array_push($queryData, $data_4);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[4],
                ]);
            }else if ($key == "col_home_addr" && !empty($data[5]) && $value != $data[5]) {
                $setColumns .= ", $key=?";
                array_push($queryData, $data[5]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[5],
                ]);
            }else if ($key == "col_curr_addr" && !empty($data[6]) && $value != $data[6]) {
                $setColumns .= ", $key=?";
                array_push($queryData, $data[6]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[6],
                ]);
            }else if ($key == "col_birt_date" && !empty($data[7]) && $value != $birth_date) {
                $setColumns .= ", $key=?";
                array_push($queryData, $birth_date);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $birth_date,
                ]);
            }else if ($key == "col_empl_gend" && !empty($data[8]) && $value != $data_8) {
                $setColumns .= ", $key=?";
                array_push($queryData, $data_8);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[8],
                ]);
            }else if ($key == "col_empl_nati" && !empty($data[9]) && $value != $data_9) {
                $setColumns .= ", $key=?";
                array_push($queryData, $data_9);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[9],
                ]);
            }else if ($key == "col_shir_size" && !empty($data[10]) && $value != $data_10) {
                $setColumns .= ", $key=?";
                array_push($queryData, $data_10);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[10],
                ]);
            }else if ($key == "col_empl_emai" && !empty($data[11]) && $value != $data[11]){
                $setColumns .= ", $key=?";
                array_push($queryData, $data[11]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[11],
                ]);
            }else if ($key == "col_mobl_numb" && !empty($data[12]) && $value != $data[12]){
                $setColumns .= ", $key=?";
                array_push($queryData, $data[12]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[12],
                ]);
            }else if ($key == "col_hire_date" && !empty($data[13]) && $value != $hire_date){
                $setColumns .= ", $key=?";
                array_push($queryData, $hire_date);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $hire_date,
                ]);
            }else if ($key == "date_regular" && !empty($data[14]) && $value != $regular_date){
                $setColumns .= ", $key=?";
                array_push($queryData, $regular_date);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $regular_date,
                ]);
            }else if ($key == "resignation_date" && !empty($data[15]) && $value != $resign_date){
                $setColumns .= ", $key=?";
                array_push($queryData, $resign_date);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $resign_date,
                ]);
            }else if ($key == "col_endd_date" && !empty($data[16]) && $value != $endd_date){
                $setColumns .= ", $key=?";
                array_push($queryData, $endd_date);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $endd_date,
                ]);
            }else if ($key == "col_empl_type" && !empty($data[17]) && $value != $data_17){
                $setColumns .= ", $key=?";
                array_push($queryData, $data_17);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[17],
                ]);
            }else if ($key == "col_empl_posi" && !empty($data[18]) && $value != $data_18){
                $setColumns .= ", $key=?";
                array_push($queryData, $data_18);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[18],
                ]);
            }else if ($key == "col_empl_company" && !empty($data[19]) && $value != $data_19){
                $setColumns .= ", $key=?";
                array_push($queryData, $data_19);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[19],
                ]);
            }else if ($key == "col_empl_branch" && !empty($data[20]) && $value != $data_20){
                $setColumns .= ", $key=?";
                array_push($queryData, $data_20);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[20],
                ]);
            }else if ($key == "col_empl_dept" && !empty($data[21]) && $value != $data_21){
                $setColumns .= ", $key=?";
                array_push($queryData, $data_21);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[21],
                ]);
            }else if ($key == "col_empl_divi" && !empty($data[22]) && $value != $data_22){
                $setColumns .= ", $key=?";
                array_push($queryData, $data_22);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[22],
                ]);
            }else if ($key == "col_empl_sect" && !empty($data[23]) && $value != $data_23){
                $setColumns .= ", $key=?";
                array_push($queryData, $data_23);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[23],
                ]);
            }else if ($key == "col_empl_group" && !empty($data[24]) && $value != $data_24){
                $setColumns .= ", $key=?";
                array_push($queryData, $data_24);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[24],
                ]);
            }else if ($key == "col_empl_team" && !empty($data[25]) && $value != $data_25){
                $setColumns .= ", $key=?";
                array_push($queryData, $data_25);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[25],
                ]);
            }else if ($key == "col_empl_line" && !empty($data[26]) && $value != $data_26){
                $setColumns .= ", $key=?";
                array_push($queryData, $data_26);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[26],
                ]);
            }else if ($key == "col_imag_path" && !empty($data[27]) && $value != $data[27]){
                $setColumns .= ", $key=?";
                array_push($queryData, $data[27]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[27],
                ]);
            }else if ($key == "col_empl_sssc" && !empty($data[28]) && $value != $data[28]){
                $setColumns .= ", $key=?";
                array_push($queryData, $data[28]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[28],
                ]);
            }else if ($key == "col_empl_hdmf" && !empty($data[29]) && $value != $data[29]){
                $setColumns .= ", $key=?";
                array_push($queryData, $data[29]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[29],
                ]);
            }else if ($key == "col_empl_phil" && !empty($data[30]) && $value != $data[30]){
                $setColumns .= ", $key=?";
                array_push($queryData, $data[30]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[30],
                ]);
            }else if ($key == "col_empl_btin" && !empty($data[31]) && $value != $data[31]){
                $setColumns .= ", $key=?";
                array_push($queryData, $data[31]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[31],
                ]);
            }else if ($key == "col_empl_driv" && !empty($data[32]) && $value != $data[32]){
                $setColumns .= ", $key=?";
                array_push($queryData, $data[32]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[32],
                ]);
            }else if ($key == "col_empl_naid" && !empty($data[33]) && $value != $data[33]){
                $setColumns .= ", $key=?";
                array_push($queryData, $data[33]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[33],
                ]);
            }else if ($key == "col_empl_pass" && !empty($data[34]) && $value != $data[34]){
                $setColumns .= ", $key=?";
                array_push($queryData, $data[34]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[34],
                ]);
            }else if ($key == "col_empl_hmoo" && !empty($data[35]) && $value != $data_35){
                $setColumns .= ", $key=?";
                array_push($queryData, $data_35);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[35],
                ]);
            }else if ($key == "col_empl_hmon" && !empty($data[36]) && $value != $data[36]){
                $setColumns .= ", $key=?";
                array_push($queryData, $data[36]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[36],
                ]);
            }
            else if ($key == "salary_rate" && !empty($data[37]) && $value != $data[37]){
                $setColumns .= ", $key=?";
                array_push($queryData, $data[37]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[37],
                ]);
            }else if ($key == "salary_type" && !empty($data[38]) && $value != $data[38]){
                $setColumns .= ", $key=?";
                array_push($queryData, $data[38]);
                array_push($logs, [
                    $this->columnCategory($key),
                    $value,
                    $data[38],
                ]);
            }
        }
        
        if (!empty($logs)) {
            try {
                array_push($queryData, $data[0]);
                $sql = "UPDATE tbl_employee_infos SET $setColumns WHERE col_empl_cmid=?";
                $this->db->query($sql,$queryData);
                $edit_id = $edit_id_logs;
                $empl_id = $old[0]->id;
                foreach($logs as $new_row){
                    $category = $new_row[0];
                    $from_val = $new_row[1];
                    $to_val = $new_row[2];
                    $this->ADD_EMPLOYEE_LOGS($edit_id,$empl_id,$category,$from_val,$to_val);
                }
            } catch (Exception $e) {
                return array('query error' => 'Error updating data: '.$e->getMessage());
            }
            
        }
        // return array($old,$logs);
        // $sql = " UPDATE tbl_employee_infos SET edit_date=?, col_last_name=?, col_midl_name=?, col_frst_name=?, col_mart_stat=?, col_home_addr=?, col_curr_addr=?, col_birt_date=?, col_empl_gend=?, col_empl_nati=?, col_shir_size=?, 
        // col_empl_emai=?, col_mobl_numb=?, col_hire_date=?, col_empl_type=?, col_empl_posi=?, col_empl_divi=?, col_empl_group=?, col_empl_line=?, col_empl_dept=?, col_empl_sect=?, col_imag_path=?, col_empl_sssc=?, 
        // col_empl_hdmf=?, col_empl_phil=?, col_empl_btin=?, col_empl_driv=?, col_empl_naid=?, col_empl_pass=?, col_empl_hmoo=?, col_empl_hmon=?, salary_rate=?, salary_type=? 
        // WHERE col_empl_cmid=?";
        // $this->db->query($sql,array($current_date, $data[1],$data[2],$data[3],$data_4,$data[5],$data[6],$birth_date ,$data_8,$data_9,$data_10,$data[11],$data[12],$hire_date,$data_14,$data_15,$data_16,$data_17,$data_18,$data_19,$data_20,$data[21],$data[22],$data[23],$data[24],$data[25],$data[26],$data[27],$data[28],$data_29,$data[30],$data[31],$data[32],$data[0]));
    }

    function GET_SKILL_MATRIX_SPECIFIC($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_skillassign WHERE username = $employee_id AND status = 'Active' AND is_deleted=0 ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
        function DELETE_EMPL_SKILL($id){
            $sql="UPDATE tbl_employee_skillassign SET is_deleted=1 WHERE id=?";
            return $this->db->query($sql, array($id));
        }


    function GET_SKILL_MATRIX_SPECIFIC2($id)
    {
        $sql = "SELECT * FROM tbl_employee_skillassign WHERE id=? AND status = 'Active'";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }

    function GET_SKILL_NAME()
    {
        $sql = "SELECT id,name FROM tbl_std_skillnames";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SKILL_NAME_ACTIVE()
    {
        $sql = "SELECT id,name FROM tbl_std_skillnames WHERE status='Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SKILL_LEVEL()
    {
        $sql = "SELECT id,name FROM tbl_std_skilllevels";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SKILL_LEVEL_ACTIVE()
    {
        $sql = "SELECT id,name FROM tbl_std_skilllevels WHERE status='Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_TEAM(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_teams";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_DISTINCT_BRANCH(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_branches";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display distinct department already being assigned to employees
    function MOD_DISP_DISTINCT_DEPARTMENT(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display distinct department already being assigned to employees
    function MOD_DISP_DISTINCT_DIVISION(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_divisions";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display DISTINCT SECTION
    function MOD_DISP_DISTINCT_SECTION(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

     // Display DISTINCT Group
     function MOD_DISP_DISTINCT_GROUP(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_groups";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    // Display DISTINCT line
    function MOD_DISP_DISTINCT_LINE(){
        $sql = "SELECT DISTINCT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_COMP_STRUCTURE(){
        $sql = "SELECT * FROM tbl_system_setup";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    
    function UPDATE_PERSONAL_DET($first_name,$middlename,$lastname,$marital_status,$mobile_number,$birthdate,$gender,$nationality,$shirt_size,$email,$home_address,$current_address,$user_id){
        $sql = "UPDATE tbl_employee_infos SET col_last_name=?,col_midl_name=?,col_frst_name=?,col_mart_stat=?,col_home_addr=?,col_curr_addr=?,col_birt_date=?,col_empl_gend=?,col_empl_nati=?,col_shir_size=?,col_empl_emai=?,col_mobl_numb=? WHERE id=?";
        $query = $this->db->query($sql, array($lastname,$middlename,$first_name,$marital_status,$home_address,$current_address,$birthdate,$gender,$nationality,$shirt_size,$email,$mobile_number,$user_id));
    }

    function UPDATE_EMPLOYMENT_DET($hired_date,$reg_date,$resign_Date,$end_date,$emp_type,$position,$branch,$dept,$division,$sec,$group,$line,$team,$com_num,$com_email,$hmo_prov,$hmo_num,$user_id){
        $sql = "UPDATE tbl_employee_infos SET date_regular=?,col_hire_date=?,col_endd_date=?,resignation_date=?,col_empl_type=?,col_empl_posi=?,col_empl_branch=?,col_empl_dept=?,col_empl_divi=?,col_empl_sect=?,col_empl_group=?,col_empl_line=?,col_empl_team=?,col_comp_emai=?,col_comp_numb=?,col_empl_hmoo=?,col_empl_hmon=? WHERE id=?";
        $query = $this->db->query($sql, array($reg_date,$hired_date,$end_date,$resign_Date,$emp_type,$position,$branch,$dept,$division,$sec,$group,$line,$team,$com_email,$com_num,$hmo_prov,$hmo_num,$user_id));
    }
    function ADD_EMPLOYEE_LOGS($edit_id,$empl_id,$category,$from_val,$to_val){
        $log_date = date('Y-m-d H:i:s'); 
        $sql = "INSERT INTO tbl_employee_logs (log_date, edit_id,empl_id,category,from_val,to_val) VALUES(?,?,?,?,?,?)";
        $this->db->query($sql,array($log_date,$edit_id,$empl_id,$category,$from_val,$to_val));
    }

    function UPDATE_ID_DET($sss,$hdmf,$philhealth,$tin,$driver_lic,$nat_id,$passport,$user_id){
        $sql = "UPDATE tbl_employee_infos SET col_empl_sssc=?,col_empl_hdmf=?,col_empl_phil=?,col_empl_btin=?,col_empl_driv=?,col_empl_naid=?,col_empl_pass=? WHERE id=?";
        $query = $this->db->query($sql, array($sss,$hdmf,$philhealth,$tin,$driver_lic,$nat_id,$passport,$user_id));
    }

    function UPDATE_COMP_DET($salary_type,$salary_rate,$bank,$branch,$acc_type,$payment_type,$acc_num,$user_id){
        $sql = "UPDATE tbl_employee_infos SET salary_rate=?,salary_type=?,bank_name=?,branch_name=?,account_number=?,account_type=?,payment_type=? WHERE id=?";
        $query = $this->db->query($sql, array($salary_rate,$salary_type,$bank,$branch,$acc_num,$acc_type,$payment_type,$user_id));
    }

    function UPDATE_EDUC_DET($degree,$school,$address,$from_yr,$to_yr,$completion,$educ_id,$user_id,$grade,$level){
        $sql = "UPDATE tbl_employee_education SET col_educ_degree=?, col_educ_school=?, col_educ_from_yr=?, col_educ_to_yr=?,address=?,completion=?,col_educ_grade=?,col_educ_level=? WHERE id=?";
        return $this->db->query($sql, array($degree,$school,$from_yr,$to_yr,$address,$completion,$grade,$level,$educ_id));
    }
    function ADD_NEW_EDUC($degree,$school,$address,$from_yr,$to_yr,$completion,$user_id,$grade,$level){
        $sql="INSERT INTO tbl_employee_education(col_empl_id, col_educ_degree, col_educ_school, col_educ_from_yr, col_educ_to_yr, col_educ_grade, address, completion, col_educ_level)
            VALUE(?,?,?,?,?,?,?,?,?)
        ";
        return $this->db->query($sql, array($user_id,$degree,$school,$from_yr,$to_yr,$grade,$address,$completion,$level));
    }
    function UPDATE_SKILL_DET($title,$level,$skill_id){
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_employee_skillassign SET edit_date=?, name=?, value=?  WHERE id=?";
        return $this->db->query($sql, array($date, $title, $level, $skill_id));
    }
    function ADD_NEW_SKILL($user_id,$level,$skill){
        $date = date('Y-m-d H:i:s');
        $sql="INSERT INTO tbl_employee_skillassign(create_date,edit_date,username,name,value,status) VALUE(?,?,?,?,?,?)";
        return  $this->db->query($sql, array($date, $date, $user_id, $skill, $level,'Active'));
    }
    function ADD_NEW_DEPENDENT($user_id,$full_name,$b_day,$gender,$relationship){
        $sql="INSERT INTO tbl_employee_dependents(col_depe_empid, col_depe_name, col_depe_bday, col_depe_gndr, col_depe_rela) VALUE(?,?,?,?,?)";
        return  $this->db->query($sql, array($user_id,$full_name,$b_day,$gender,$relationship));
    }
    function GET_SPECIFIC_DEPENDENT($id){
        $sql="SELECT * FROM tbl_employee_dependents WHERE id=? LIMIT 1";
        return $this->db->query($sql, array($id))->row_array();
    }
    function UPDATE_SPECIFIC_DEPENDENT($id,$full_name,$b_day,$gender,$relationship){
        $sql="UPDATE tbl_employee_dependents SET col_depe_name=?, col_depe_bday=?, col_depe_gndr=?, col_depe_rela=? WHERE id=?";
        return  $this->db->query($sql, array($full_name,$b_day,$gender,$relationship,$id));
    }
    function DELETE_DEPENDENT($id){
        $sql ="UPDATE tbl_employee_dependents SET is_deleted=? WHERE id=?";
        return $this->db->query($sql, array(1,$id));
    }
    //========================================================== CSV =======================================================

    function UPDTRECORD($filedata)
    {
        if(count($filedata) > 0)
        {
            $newdate = str_replace('/', '-', $filedata[7]);
			$birthday = date("Y-m-d", strtotime($newdate));
            $newdate_2 = str_replace('/', '-', $filedata[15]);
			$hired_on = date("Y-m-d", strtotime($newdate_2));
            if((substr(strval($filedata[13]), 0, 1) == '9') || (substr(strval($filedata[13]), 0, 1) == 9))
            {
                $mobile_number = '0'.strval($filedata[13]);
            } else {
                $mobile_number = ($filedata[13]);
            }
            if((substr(strval($filedata[14]), 0, 1) == '9') || (substr(strval($filedata[14]), 0, 1) == 9))
            {
                $work_phone_number = '0'.strval($filedata[14]);
            } else {
                $work_phone_number = ($filedata[14]);
            }
            $employee_cmid = strval($filedata[0]);
            $employee_id = $this->p020_emplist_mod->MOD_DISP_EMPLOYEE_BASED_CMID($filedata[0]);
            $username = str_pad($employee_cmid,5,"0",STR_PAD_LEFT);
            // $db_reporting_to = $this->P020_EMPLIST_MOD->MOD_DISP_EMPL_KEY($filedata[19]);
            // $reporting_to = $db_reporting_to['id'];
            $sql = "UPDATE tbl_employee_infos SET col_user_name=? ,col_last_name = ?,col_midl_name = ?,col_frst_name = ?,col_mart_stat = ?,col_home_addr = ?,col_curr_addr = ?,col_birt_date = ?,col_empl_gend = ?,col_empl_nati = ?,col_shir_size = ?,col_empl_emai = ?,col_comp_emai = ?,col_mobl_numb = ?,col_comp_numb = ?,col_hire_date = ?,col_empl_type = ?,col_empl_posi = ?,col_empl_group = ?,col_empl_line = ?,col_empl_dept = ?,col_empl_sect = ?,col_imag_path = ?,col_empl_sssc = ?,col_empl_hdmf = ?,col_empl_phil = ?,col_empl_btin = ?,col_empl_driv = ?,col_empl_naid = ?,col_empl_pass = ?,col_empl_hmoo = ?,col_empl_hmon = ?,salary_rate = ?,salary_type = ?,pioneer_allowance = ?,load_allowance = ?,skill_allowance = ?,group_leader_allowance = ?,transpo_allowance = ?,sch1_name=?,sch1_deg=?,sch1_from=?,sch1_to=?,sch1_gwa=?,sch2_name=?,sch2_deg=?,sch2_from=?,sch2_to=?,sch2_gwa=?,sch3_name=?,sch3_deg=?,sch3_from=?,sch3_to=?,sch3_gwa=?,skill_name1=?,skill_lvl1=?,skill_name2=?,skill_lvl2=?,emer_cont_name=?,emer_cont_rel=?,emer_cont_num=?,emer_cont_workphone=?,emer_cont_homephone=?,emer_cont_add=?,dep_name1=?,dep_birth1=?,dep_gend1=?,dep_rel1=?,dep_name2=?,dep_birth2=?,dep_gend2=?,dep_rel2=?,dep_name3=?,dep_birth3=?,dep_gend3=?,dep_rel3=?,dep_name4=?,dep_birth4=?,dep_gend4=?,dep_rel4=? WHERE col_empl_cmid=?";
            $this->db->query($sql,array($username, $filedata[1], $filedata[2], $filedata[3], $filedata[4], $filedata[5], $filedata[6], $birthday, $filedata[8], $filedata[9], $filedata[10], $filedata[11], $filedata[12], $mobile_number, $work_phone_number,$hired_on, $filedata[16], $filedata[17], $filedata[18], $filedata[19], $filedata[20], $filedata[21], $filedata[22], $filedata[23], $filedata[24], $filedata[25], $filedata[26], $filedata[27], $filedata[28], $filedata[29], $filedata[30], $filedata[31], $filedata[32], $filedata[33], $filedata[34], $filedata[35], $filedata[36], $filedata[37], $filedata[38], $filedata[39], $filedata[40], $filedata[41], $filedata[42], $filedata[43], $filedata[44], $filedata[45], $filedata[46], $filedata[47], $filedata[48], $filedata[49], $filedata[50], $filedata[51], $filedata[52], $filedata[53], $filedata[54], $filedata[55], $filedata[56], $filedata[57], $filedata[58], $filedata[59], $filedata[60], $filedata[61], $filedata[62], $filedata[63], $filedata[64], $filedata[65], $filedata[66], $filedata[67], $filedata[68], $filedata[69], $filedata[70], $filedata[71], $filedata[72], $filedata[73], $filedata[74], $filedata[75], $filedata[76], $filedata[77], $filedata[78], $filedata[79], $employee_cmid));
        }
    }

    function CHECKDUPLICATEEMPLID($employee_id){
        $sql = "SELECT col_empl_cmid FROM tbl_employee_infos WHERE col_empl_cmid = ?";
        $query = $this->db->query($sql,array($employee_id));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_EMPLOYEES_LIMIT2($offset, $row, $dept, $sec, $group, $line,$branch,$division,$team, $status, $disabled)
    {
        $filter_q = "";
        if($dept){
            $filter_q .= " AND col_empl_dept=".$dept;
        }
        if($sec){
            $filter_q .= " AND col_empl_sect=".$sec;
        }
        if($group){
            $filter_q .= " AND col_empl_group=".$group;
        }
        if($line){
            $filter_q .= " AND col_empl_line=".$line;
        }
        if($branch){
            $filter_q .= " AND col_empl_branch=".$branch;
        }
        if($division){
            $filter_q .= " AND col_empl_divi=".$division;
        }
        if($team){
            $filter_q .= " AND col_empl_team=".$team;
        }
        if($disabled){
            $filter_q .= " AND disabled=".$disabled;
        }else{
            $filter_q .= " AND disabled=0";
        }
        // $filter_q .= " AND disabled=0";
        
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00'" .$filter_q. " ORDER BY LENGTH(col_empl_cmid), col_empl_cmid  LIMIT ".$offset.", ".$row." ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_ALL_EMPLOYEES_LIMIT($offset, $row, $dept, $sec, $group, $line,$branch,$division,$team, $status)
    {
        $filter_q = "";
        if($dept){
            $filter_q .= " AND col_empl_dept=".$dept;
        }
        if($sec){
            $filter_q .= " AND col_empl_sect=".$sec;
        }
        if($group){
            $filter_q .= " AND col_empl_group=".$group;
        }
        if($line){
            $filter_q .= " AND col_empl_line=".$line;
        }
        if($branch){
            $filter_q .= " AND col_empl_branch=".$branch;
        }
        if($division){
            $filter_q .= " AND col_empl_divi=".$division;
        }
        if($team){
            $filter_q .= " AND col_empl_team=".$team;
        }
        // if($disabled){
        //     $filter_q .= " AND disabled=".$disabled;
        // }else{
        //     $filter_q .= " AND disabled=0";
        // }
        $filter_q .= " AND disabled=0";
        
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00'" .$filter_q. " ORDER BY LENGTH(col_empl_cmid), col_empl_cmid  LIMIT ".$offset.", ".$row." ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_SEARCH_EMPLOYEES($search,$status)
    {
        $sql = "SELECT tbl_employee_infos.* FROM tbl_employee_infos
        LEFT JOIN tbl_std_departments ON tbl_std_departments.id = tbl_employee_infos.col_empl_dept
        LEFT JOIN tbl_std_employeetypes ON tbl_std_employeetypes.id = tbl_employee_infos.col_empl_type
        LEFT JOIN tbl_std_positions ON tbl_std_positions.id = tbl_employee_infos.col_empl_posi
        LEFT JOIN tbl_std_sections ON tbl_std_sections.id = tbl_employee_infos.col_empl_sect
        LEFT JOIN tbl_std_groups ON tbl_std_groups.id = tbl_employee_infos.col_empl_group
        LEFT JOIN tbl_std_lines ON tbl_std_lines.id = tbl_employee_infos.col_empl_line
        WHERE tbl_employee_infos.disabled=$status AND  termination_date = '0000-00-00' AND ( tbl_employee_infos.id  LIKE '%$search%'
        OR tbl_employee_infos.col_last_name LIKE '%$search%'
        OR tbl_employee_infos.col_frst_name LIKE '%$search%'
        OR tbl_employee_infos.col_midl_name LIKE '%$search%'
        OR tbl_std_departments.name LIKE '%$search%'
        OR tbl_std_employeetypes.name LIKE '%$search%'
        OR tbl_std_positions.name LIKE '%$search%'
        OR tbl_std_sections.name LIKE '%$search%'
        OR tbl_std_groups.name LIKE '%$search%'
        OR tbl_std_lines.name LIKE '%$search%' )
        ORDER BY tbl_employee_infos.id DESC";
       
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_SEARCHED_DATA($search)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE col_frst_name LIKE '$search%' OR col_last_name LIKE '$search%' OR col_midl_name LIKE '$search%' OR col_empl_emai LIKE '$search%' OR col_mobl_numb LIKE '$search%' AND isSuperAdmin != 1 AND termination_type=0 ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function SET_ACTIVATION_EMPLOYEE($id,$is_active){
        if (!$is_active) {
            $sqlLimit = "SELECT value FROM tbl_system_setup WHERE setting='max_active_user'";
            $limit = $this->db->query($sqlLimit);
            if (!$limit) {
                return array('messageError'=>'Getting limit Error');
            }
            if (!$limit->row()) {
                return array('messageError'=>'Getting limit Error');
            }
            
            $sqlActiveTotal = "SELECT COUNT(*) as count FROM tbl_employee_infos WHERE disabled=0";
            $activeTotal = $this->db->query($sqlActiveTotal);
            if ($activeTotal && $activeTotal->num_rows() < 1 && $activeTotal->row()->count < 1) {
                return array('messageError' => 'Maximum Active Count is Zero and below');
            }
            $finalLimit = $limit->row()->value;
            $finalActiveTotal = $activeTotal->row()->count;
            if ($finalLimit <= $finalActiveTotal) {
                return array('messageError' => "Activation failed as limit already reached. Limit: ".$finalLimit .". Active Users: ". $finalActiveTotal .".");
            }

            $sql = "UPDATE tbl_employee_infos SET disabled=? WHERE id=?";
            $query = $this->db->query($sql, array($is_active, $id));
            return null;
            // result->close(); // Close the result set when done
        } else {
            $sql = "UPDATE tbl_employee_infos SET disabled=? WHERE id=?";
            $query = $this->db->query($sql, array($is_active, $id));
            return null;
        }
    }
    function CHECK_ACTIVE_LIMIT($type, $active, $add){
        if ($type != 'all' && $type != 'add') {
            return array('messageError', 'Prohibited');
        }
        $finalActiveTotal = null;
        $sqlLimit = "SELECT value FROM tbl_system_setup WHERE setting='max_active_user'";
        $limit = $this->db->query($sqlLimit);
        if (!$limit) {
            return array('messageError'=>'Getting limit Error');
        }
        $finalLimit = $limit->row()->value;
        
        if ($type === 'all') {
            $finalActiveTotal = $active;
            if ($finalLimit < $finalActiveTotal) {
                $difference = $finalActiveTotal - $finalLimit;
                $reduce = $difference;
                return array('messageError' => "Change was not saved. Max user limit. Reduce " . $reduce. " Active ");
            }
        }
        if ($type === 'add') {
            $sqlActiveTotal = "SELECT COUNT(*) as count FROM tbl_employee_infos WHERE disabled=0";
            $activeTotal = $this->db->query($sqlActiveTotal);
            if ($activeTotal && $activeTotal->num_rows() < 1 && $activeTotal->row()->count < 1) {
                return array('messageError' => 'Maximum Active Count is Zero and below');
            }
            $finalActiveTotal = $add + $activeTotal->row()->count;
            if ($finalLimit < $finalActiveTotal) {
                $difference = $finalActiveTotal - $finalLimit;
                $reduce = $difference;
                return array('messageError' => "Add was not saved. Max user limit. Reduce " . $reduce. " Active ");
            }
        }
        // return array('finalLimmit'=>$finalLimit , 'finalActiveTotal'=>$finalActiveTotal );
        return null;
    }
    function MOD_INSRT_EMPLOYEE($empl_cmid, $last_name, $middle_name, $first_name, $email, $birthday, $gender, $mobile_num, $hired_on, $empl_type, $position, $department, $section, $group, $line, $home_address, $current_address, $marital_status, $nationality, $shirt_size, $salary_rate, $salary_type)
    {
        $salt=bin2hex(openssl_random_pseudo_bytes(22));
        $password= ucfirst($last_name.'.'.date_format(date_create($birthday),"Y"));
        $encrypted_password = md5($password.''.$salt);
        $empl_username = str_pad($empl_cmid, 5, "0", STR_PAD_LEFT);
        $sql = "INSERT INTO tbl_employee_infos(col_empl_cmid,col_user_date,col_user_name,col_user_pass,col_salt_key,col_last_name,col_midl_name,col_frst_name,col_empl_emai,col_birt_date,col_empl_gend,col_mobl_numb,col_hire_date,col_empl_type,col_empl_posi,col_empl_dept,col_empl_sect,col_empl_group,col_empl_line,col_home_addr,col_curr_addr,col_mart_stat,col_empl_nati,col_shir_size,salary_rate,salary_type,col_user_access) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($empl_cmid, date('Y-m-d H:i:s'), $empl_username, $encrypted_password,$salt, $last_name, $middle_name, $first_name, $email, $birthday, $gender, $mobile_num, $hired_on, $empl_type, $position, $department, $section, $group, $line, $home_address, $current_address, $marital_status, $nationality, $shirt_size, $salary_rate, $salary_type,$empl_type));
        return $this->db->insert_id();
    }

    function test($first_name,$birthdate){             //JERENZ: NO TEST FUNCTION IN THE EMPLOYEES CONTROLLER
        $salt=bin2hex(openssl_random_pseudo_bytes(22));
        $clean_password= ucfirst($last_name.'@'.date_format(date_create($birthdate),"mdY"));
        $encrypted_password = md5($clean_password.''.$salt);
        echo $salt;
        echo "<br>";
        echo "Encrpted password ".$encrypted_password;
        $decrypted_password = md5($clean_password.''.$salt);
        echo "<br>";
        echo "Decripted Password ".$decrypted_password;

    }
    function INSERT_EMPLOYEE_IMAGE($user_img, $userID)
    {
        $sql = "UPDATE tbl_employee_infos SET col_imag_path=? WHERE id=?";
        $query = $this->db->query($sql, array($user_img, $userID));
    }

    function MOD_GET_FILTER_DATA($department, $line, $group, $section, $status)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE " . $department . " AND " . $line . " AND " . $group . " AND " . $section . " AND " . $status . " AND isSuperAdmin != 1";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_FILTER_DATA_DEPARTMENT($department, $line, $group, $section, $status)
    {
        $sql = "SELECT DISTINCT col_empl_dept FROM tbl_employee_infos WHERE " . $department . " AND " . $line . " AND " . $group . " AND " . $section . " AND " . $status . " AND isSuperAdmin != 1";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_FILTER_DATA_SECTION($department, $line, $group, $section, $status)
    {
        $sql = "SELECT DISTINCT col_empl_sect FROM tbl_employee_infos WHERE " . $department . " AND " . $line . " AND " . $group . " AND " . $section . " AND " . $status . " AND isSuperAdmin != 1";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_FILTER_DATA_GROUP($department, $line, $group, $section, $status)
    {
        $sql = "SELECT DISTINCT col_empl_group FROM tbl_employee_infos WHERE " . $department . " AND " . $line . " AND " . $group . " AND " . $section . " AND " . $status . " AND isSuperAdmin != 1";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_GET_FILTER_DATA_LINE($department, $line, $group, $section, $status)
    {
        $sql = "SELECT DISTINCT col_empl_line FROM tbl_employee_infos WHERE " . $department . " AND " . $line . " AND " . $group . " AND " . $section . " AND " . $status . " AND isSuperAdmin != 1";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_ALL_EMPLOYEES()
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0 ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
        // $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 AND isSuperAdmin != 1 ORDER BY col_empl_cmid DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
       
    }
    function FILTER_EMPLOYEE_COUNT2($dept, $sec, $group, $line,$branch,$division,$team, $status, $disabled){

         $filter_q='';
        if($dept){
            $filter_q .= " AND col_empl_dept=".$dept;
        }
        if($sec){
            $filter_q .= " AND col_empl_sect=".$sec;
        }
        if($group){
            $filter_q .= " AND col_empl_group=".$group;
        }
        if($line){
            $filter_q .= " AND col_empl_line=".$line;
        }
        if($branch){
            $filter_q .= " AND col_empl_branch=".$branch;
        }
        if($division){
            $filter_q .= " AND col_empl_divi=".$division;
        }
        if($team){
            $filter_q .= " AND col_empl_team=".$team;
        }
        if($disabled){
            $filter_q .= " AND disabled=".$disabled;
        }else{
            $filter_q .= " AND disabled= 0";
        }
        // $filter_q .= " AND disabled= 1";
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00'" .$filter_q. " ORDER BY col_empl_cmid ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function FILTER_EMPLOYEE_COUNT($dept, $sec, $group, $line,$branch,$division,$team, $status){

         $filter_q='';
        if($dept){
            $filter_q .= " AND col_empl_dept=".$dept;
        }
        if($sec){
            $filter_q .= " AND col_empl_sect=".$sec;
        }
        if($group){
            $filter_q .= " AND col_empl_group=".$group;
        }
        if($line){
            $filter_q .= " AND col_empl_line=".$line;
        }
        if($branch){
            $filter_q .= " AND col_empl_branch=".$branch;
        }
        if($division){
            $filter_q .= " AND col_empl_divi=".$division;
        }
        if($team){
            $filter_q .= " AND col_empl_team=".$team;
        }
        // if($disabled){
        //     $filter_q .= " AND disabled=".$disabled;
        // }else{
        //     $filter_q .= " AND disabled= 0";
        // }
        $filter_q .= " AND disabled= 0";
        
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00'" .$filter_q. " ORDER BY col_empl_cmid ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_ALL_ACTIVE_COUNT()
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled = 0";
        $query = $this->db->query($sql , array());
        return $query->num_rows();
    }

    function MOD_DISP_SPEC_ACTIVE_COUNT($col_empl_type)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled = 0 AND col_empl_type = $col_empl_type";
        $query = $this->db->query($sql , array());
        return $query->num_rows();
    }


    function MOD_DISP_ALL_EMPLOYEES_PAGINATION($num_start, $num_limit)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 AND isSuperAdmin != 1 ORDER BY LENGTH(col_empl_cmid), col_empl_cmid LIMIT ?,?";
        // $sql = "SELECT * FROM tbl_employee_infos WHERE disabled=0 AND isSuperAdmin != 1 ORDER BY col_empl_cmid DESC";
        $query = $this->db->query($sql, array($num_start, $num_limit));
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_EMPLOYEE($employee_id)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE id=? ORDER BY col_frst_name";
        $query = $this->db->query($sql, array($employee_id));
        $query->next_result();
        return $query->result();
    }


    function GET_EMPL_CMID($empl_cmid)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE col_empl_cmid=? ";
        $query = $this->db->query($sql, array($empl_cmid));
        return $query->num_rows();
    }

    function GET_SYSTEM_SETTING($setting){
        $sql = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
        
    }

    function GET_ALLOWANCE_TYPES(){
        $sql = "SELECT * FROM tbl_std_allowances WHERE status = 'Active' ORDER BY id ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_TAXABLE_ALLOWANCE_TYPES(){
        $sql = "SELECT * FROM tbl_std_allowances_tax WHERE status = 'Active' ORDER BY id ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_NON_TAXABLE_ALLOWANCE_TYPES(){
        $sql = "SELECT * FROM tbl_std_allowances_nontax WHERE status = 'Active' ORDER BY id ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_TAXABLE_DEDUCTION_TYPES(){
        $sql = "SELECT * FROM tbl_std_deductions_tax WHERE status = 'Active' ORDER BY id ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_NON_TAXABLE_DEDUCTION_TYPES(){
        $sql = "SELECT * FROM tbl_std_deductions_nontax WHERE status = 'Active' ORDER BY id ";
        $query = $this->db->query($sql,array());
        $query->next_result();
        return $query->result();
    }

    function GET_CUTOFF_PERIOD_DATE($cutoff){
        $sql = "SELECT * FROM tbl_payroll_period WHERE id=?";
        $query = $this->db->query($sql, array($cutoff));
        return $query->row_array();
        // $query->next_result();
        // return $query->result();
    }

    function GET_APPROVED_OT($cutoff, $id) {
        
        $cutoff_dates = $this->GET_CUTOFF_PERIOD_DATE($cutoff);
        $date_from = $cutoff_dates['date_from'];
        $date_to = $cutoff_dates['date_to'];
  
        $sql = "SELECT empl_id, SUM(hours) AS total_hours FROM tbl_overtimes WHERE empl_id = ? AND date_ot BETWEEN ? AND ? AND status = 'Approved'";
        $query = $this->db->query($sql, array($id, $date_from, $date_to));
        return $query->result_array();
    }


    // function GET_APPROVED_OT($cutoff, $id){
    //     $cutoff_dates = $this->GET_CUTOFF_PERIOD_DATE($cutoff);
    //     $date_from = $cutoff_dates['date_from'];
    //     $date_to = $cutoff_dates['date_to'];

    //     $sql = "SELECT * FROM tbl_overtimes WHERE id=? and (date_ot >= $date_from AND date_ot <= $date_to) AND status='Approved'";
    //     $query = $this->db->query($sql, array($id));
    //     return $query->row_array();
    //     // $query->next_result();
    //     // return $query->result();
    // }

    function GET_FILTERED_EMPLOYEELIST($offset,$row,$branch,$dept,$division,$section,$group,$team,$line){

        if($branch    == "all"){$branch     = "col_empl_branch";}
        if($dept      == "all"){$dept       = "col_empl_dept";}
        if($division  == "all"){$division   = "col_empl_divi";}
        if($section   == "all"){$section    = "col_empl_sect";}
        if($group     == "all"){$group      = "col_empl_group";}
        if($team      == "all"){$team       = "col_empl_team";}
        if($line      == "all"){$line       = "col_empl_line";}

        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,col_empl_line,salary_rate,salary_type FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled = 0
        AND col_empl_branch = $branch
        AND col_empl_dept = $dept
        AND col_empl_divi = $division
        AND col_empl_sect = $section
        AND col_empl_group = $group
        AND col_empl_team = $team
        AND col_empl_line = $line
        ORDER BY col_empl_cmid ASC
        LIMIT ".$offset.", ".$row." ";

        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_FILTERED_EMPLOYEELIST_COUNT($branch,$dept,$division,$section,$group,$team,$line){

        if($branch    == "all"){$branch     = "col_empl_branch";}
        if($dept      == "all"){$dept       = "col_empl_dept";}
        if($division  == "all"){$division   = "col_empl_divi";}
        if($section   == "all"){$section    = "col_empl_sect";}
        if($group     == "all"){$group      = "col_empl_group";}
        if($team      == "all"){$team       = "col_empl_team";}
        if($line      == "all"){$line       = "col_empl_line";}

        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi, col_empl_sect,col_empl_group,col_empl_team,col_empl_line,salary_rate,salary_type FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled = 0
        AND col_empl_branch = $branch
        AND col_empl_dept = $dept
        AND col_empl_divi = $division
        AND col_empl_sect = $section
        AND col_empl_group = $group
        AND col_empl_team = $team
        AND col_empl_line = $line
        ORDER BY col_empl_cmid ASC";

        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    function GET_SEARCHED($search){
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00' AND disabled=0 
        AND (tbl_employee_infos.col_empl_cmid LIKE '%$search%' 
        OR CONCAT(col_last_name, ' ', col_frst_name, ' ', col_midl_name) LIKE '%$search%') 
        ORDER BY id ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_COUNT_EMPLOYEELIST(){   //JERENZ: DISABLED IN THE EMPLOYEES CONTROLLER
        $sql = "SELECT * FROM tbl_employee_infos WHERE termination_date = '0000-00-00'";
        $query = $this->db->query($sql , array());
        return $query->num_rows();
    }

    function GET_YEARS()
    {
        $sql = "SELECT id,name FROM tbl_std_years";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALLOWANCE_DATA($year){
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_allowanceassign WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALLOWANCE_TAX_DATA($year){
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_allowanceassigntax WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ALLOWANCE_NON_TAX_DATA($year){
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_allowanceassignnontax WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_DEDUCTION_TAX_DATA($year){
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_deductionassigntax WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_DEDUCTION_NON_TAX_DATA($year){
        $sql = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_deductionassignnontax WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function MOD_DISP_CUTOFF_PERIOD(){
        $sql = "SELECT * FROM tbl_payroll_period ORDER BY id DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }


    function IS_DUPLICATE($user_id,$year,$type){
        $sql = "SELECT id FROM tbl_employee_allowanceassign WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql,array($user_id,$year,$type));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function IS_DUPLICATE_ALLOWANCE_TAX($user_id,$year,$type){
        $sql = "SELECT id FROM tbl_employee_allowanceassigntax WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql,array($user_id,$year,$type));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function IS_DUPLICATE_ALLOWANCE_NONTAX($user_id,$year,$type){
        $sql = "SELECT id FROM tbl_employee_allowanceassignnontax WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql,array($user_id,$year,$type));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function IS_DUPLICATE_DEDUCTION_TAX($user_id,$year,$type){
        $sql = "SELECT id FROM tbl_employee_deductionassigntax WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql,array($user_id,$year,$type));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function IS_DUPLICATE_DEDUCTION_NONTAX($user_id,$year,$type){
        $sql = "SELECT id FROM tbl_employee_deductionassignnontax WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql,array($user_id,$year,$type));
        $query->next_result();
        $data=$query->result();
        if(empty($data)){
            return 0;
        }
        return 1;
    }

    function ADD_USER_ALLOWANCE($user_id,$allowance_val, $year,$type){

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_allowanceassign (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql,array($create_date,$create_date,$user_id,$type,$allowance_val, $year));
    }

    function UPDATE_USER_ALLOWANCE($user_id,$allowance_val, $year,$type){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_allowanceassign SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql,array($edit_date,$allowance_val,$user_id,$year,$type));
    }

    function ADD_USER_ALLOWANCE_TAX($user_id,$allowance_val, $year,$type){

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_allowanceassigntax (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql,array($create_date,$create_date,$user_id,$type,$allowance_val, $year));
    }

    function UPDATE_USER_ALLOWANCE_TAX($user_id,$allowance_val, $year,$type){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_allowanceassigntax SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql,array($edit_date,$allowance_val,$user_id,$year,$type));
    }

    function ADD_USER_ALLOWANCE_NONTAX($user_id,$allowance_val, $year,$type){

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_allowanceassignnontax (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql,array($create_date,$create_date,$user_id,$type,$allowance_val, $year));
    }

    function UPDATE_USER_ALLOWANCE_NONTAX($user_id,$allowance_val, $year,$type){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_allowanceassignnontax SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql,array($edit_date,$allowance_val,$user_id,$year,$type));
    }

    function ADD_USER_DEDUCTION_TAX($user_id,$allowance_val, $year,$type){

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_deductionassigntax (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql,array($create_date,$create_date,$user_id,$type,$allowance_val, $year));
    }

    function UPDATE_USER_DEDUCTION_TAX($user_id,$allowance_val, $year,$type){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_deductionassigntax SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql,array($edit_date,$allowance_val,$user_id,$year,$type));
    }

    function ADD_USER_DEDUCTION_NONTAX($user_id,$val, $year,$type){

        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_employee_deductionassignnontax (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql,array($create_date,$create_date,$user_id,$type,$val, $year));
    }

    function UPDATE_USER_DEDUCTION_NONTAX($user_id,$val, $year,$type){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_deductionassignnontax SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql,array($edit_date,$val,$user_id,$year,$type));
    }


    function UPDATE_SALARY_DETAILS($user_id,$value){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_infos SET edit_date=?, salary_rate=? WHERE id=?";
        return $this->db->query($sql,array($edit_date,$value,$user_id));
    }

    function UPDATE_SALARY_TYPE_DETAILS($user_id,$value){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_infos SET edit_date=?, salary_type=? WHERE id=?";
        return $this->db->query($sql,array($edit_date,$value,$user_id));
    }

    function UPDATE_SALARY_BULK($id, $salary_amount ,$salary_type){
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_employee_infos SET edit_date=?, salary_rate=?, salary_type=? WHERE id=? ";
        return $this->db->query($sql,array($edit_date, $salary_amount, $salary_type, $id));
    }

    function UPDATE_EMPLOYEE_DISABLED($empl_id, $value){
        $sql = "UPDATE tbl_employee_infos SET disabled=? WHERE id=?";
        $query = $this->db->query($sql, array($value, $empl_id));
    }

    function columnCategory($column){
        switch ($column) {
            case "account_number": return "Bank Account Number";
            case "payment_type": return "Bank Payment Type";
            case "account_type": return "Bank Account Type";
            case "branch_name": return "Bank Branch";
            case "bank_name": return "Bank Name";
            case "col_empl_pass": return "Passport";
            case "col_empl_naid": return "National ID";
            case "col_empl_driv": return "Driver's License";
            case "col_empl_btin": return "TIN";
            case "col_empl_phil": return "Philhealth";
            case "col_empl_hdmf": return "Pagibig";
            case "col_empl_sssc": return "SSS";
            case "col_empl_hmon": return "HMO Number";
            case "col_empl_hmoo": return "HMO Provider";
            case "col_comp_emai": return "Company Email";
            case "col_comp_numb": return "Company Number";
            case "col_empl_team": return "Team";
            case "col_empl_line": return "Line";
            case "col_empl_group": return "Groups";
            case "col_empl_sect": return "Sections";
            case "col_empl_divi": return "Division";
            case "col_empl_dept": return "Department";
            case "col_empl_branch": return "Branch";
            case "col_empl_posi": return "Position";
            case "col_empl_type": return "Employment Type";
            case "col_endd_date": return "Last Day of Work";
            case "resignation_date": return "Resignation";
            case "date_regular": return "Regularization";
            case "col_hire_date": return "Hired Date";
            case "col_curr_addr": return "Current Address";
            case "col_home_addr": return "Home Address";
            case "col_empl_emai": return "Email";
            case "col_shir_size": return "Shirt size";
            case "col_empl_nati": return "Nationality";
            case "col_empl_gend": return "Gender";
            case "col_birt_date": return "Birthdate";
            case "col_mobl_numb": return "Mobile Number";
            case "col_mart_stat": return "Marital Status";
            case "col_last_name": return "Last Name";
            case "col_midl_name": return "Middle Name";
            case "col_frst_name": return "First Name";
            case "salary_rate": return "Salary Rate";
            case "salary_type": return "Salary Type";
            case "col_imag_path": return "Image Path";
            case "col_empl_company": return "Company";
            default: return "Not Found";
          }
    }
}