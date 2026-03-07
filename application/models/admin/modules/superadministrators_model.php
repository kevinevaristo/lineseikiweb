<?php
class superadministrators_model extends CI_Model
{
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

    function get_table($table, $filter, $selectColumns) {
        $query = $this->db
        ->where('is_deleted', 0)
        ->order_by('id', 'DESC');
        foreach ($selectColumns as $column) {
            if (array_key_exists('useRaw', $column)) {
                $query->select($column['selectStatement'], false);
            } else {
                $query->select($column['selectStatement']);
            }
        }
        foreach ($filter as $conditions) {
            foreach ($conditions as $key => $value) {
                $query->where($key, $value);
            }
        }
        $query = $query->get($table);
        return $query->result();
    }

    function insert_data_table($table,$input_data){
        try {
        $this->db->insert($table, $input_data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
        } catch (Exception $e) {
            return false;
        }
    }

    function update_data_table($table, $input_data, $id) {
        try {
            $this->db->where('id', $id);
            $this->db->update($table, $input_data);
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    

    function GET_NAME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'CompanyName'";
        return $this->db->query($query)->row_array();
    }
    function UPDATE_MAIYA_THEME()
    {
        $sql = "UPDATE tbl_system_setup SET value =1 WHERE id = 69";
        $query = $this->db->query($sql);

        $sql2 = "UPDATE tbl_system_setup SET value =0 WHERE id = 70";
        $query2 = $this->db->query($sql2);
    }

    function UPDATE_EYEBOX_THEME()
    {
        $sql = "UPDATE tbl_system_setup SET value =0 WHERE id = 69";
        $query = $this->db->query($sql);

        $sql2 = "UPDATE tbl_system_setup SET value =1 WHERE id = 70";
        $query2 = $this->db->query($sql2);
    }

    function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'maiya_reset'";
        return $this->db->query($query)->row_array();
    }

    function GET_LOGO()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'loginLogo'";
        return $this->db->query($query)->row_array();
    }

    function GET_NAVBAR()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'navbarLogo'";
        return $this->db->query($query)->row_array();
    }

    function GET_HEADER()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'headerLogo'";
        return $this->db->query($query)->row_array();
    }

    function GET_MOBILE_BANNER()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'mobileBanner'";
        return $this->db->query($query)->row_array();
    }

    function GET_DESKTOP_BANNER()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'desktopBanner'";
        return $this->db->query($query)->row_array();
    }

    function GET_HEADER_CONTENT()
    {
        $query = "SELECT value FROM tbl_system_setup WHERE setting = 'headerName'";
        return $this->db->query($query)->row_array();
    }

    function GET_FOOTER_CONTENT()
    {
        $query = "SELECT value FROM tbl_system_setup WHERE setting = 'footerName'";
        return $this->db->query($query)->row_array();
    }
    
    function MOD_UPDATE_NAME($value)
    {
        $sql = "UPDATE tbl_system_setup SET value=? WHERE id='1'";
        $query = $this->db->query($sql, array($value));
    }
    

    function UPDATE_MAIYA_NAME()
    {
        $sql = "UPDATE tbl_system_setup SET value='Maiya HRMS' WHERE id='1'";
        $query = $this->db->query($sql);
    }
    function UPDATE_MAIYA_HEADER()
    {
        $sql = "UPDATE tbl_system_setup SET value='Welcome to Maiya HRMS' WHERE id='24'";
        $query = $this->db->query($sql);
    }

    function UPDATE_MAIYA_LOGO()
    {
        $sql = "UPDATE tbl_system_setup SET value='65248bd76c0b8_maiya_complete.png' WHERE id='2'";
        $query = $this->db->query($sql);
    }

    function UPDATE_MAIYA_NAVBAR_LOGO()
    {
        $sql = "UPDATE tbl_system_setup SET value='65248bdb2ccdf_maiya_complete.png' WHERE id='3'";
        $query = $this->db->query($sql);
    }

    function UPDATE_MAIYA__MOBILE_HEADER_LOGO()
    {
        $sql = "UPDATE tbl_system_setup SET value='65248bdb2ccdf_maiya_complete.png' WHERE id='4'";
        $query = $this->db->query($sql);
    }

    function UPDATE_EYEBOX_NAME()
    {
        $sql = "UPDATE tbl_system_setup SET value='Eyebox HRMS' WHERE id='1'";
        $query = $this->db->query($sql);
    }
    function UPDATE_EYEBOX_HEADER()
    {
        $sql = "UPDATE tbl_system_setup SET value='Welcome to Eyebox HRMS' WHERE id='24'";
        $query = $this->db->query($sql);
    }

    function UPDATE_EYEBOX_LOGO()
    {
        $sql = "UPDATE tbl_system_setup SET value='652cb86752c01_logo-2.png' WHERE id='2'";
        $query = $this->db->query($sql);
    }

    function UPDATE_EYEBOX_NAVBAR_LOGO()
    {
        $sql = "UPDATE tbl_system_setup SET value='652cb86752c01_logo-2.png' WHERE id='3'";
        $query = $this->db->query($sql);
    }

    function UPDATE_EYEBOX__MOBILE_HEADER_LOGO()
    {
        $sql = "UPDATE tbl_system_setup SET value='652cb86752c01_logo-2.png' WHERE id='4'";
        $query = $this->db->query($sql);
    }

    function UPDATE_HEADER_CONTENT($value)
    {
        $sql = "UPDATE tbl_system_setup SET value=? WHERE id='24'";
        $query = $this->db->query($sql, array($value));
    }

    function UPDATE_FOOTER_CONTENT($value)
    {
        $sql = "UPDATE tbl_system_setup SET value=? WHERE id='23'";
        $query = $this->db->query($sql, array($value));
    }
    

    function GET_SET_UP_VARIABLES()
    {
        $query = $this->db
            ->select('*')
            ->from('tbl_system_setup')
            ->get();
        return $query->result();
    }

    function UPDATE_SETUP_VARIABLES($data)
    {

        return $this->db->update_batch('tbl_system_setup', $data, 'id');
    }

    function INSERT_LOGO($img)
    {
        $currentDate = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_system_setup SET edit_date=?, value=? WHERE id='2'";
        $query = $this->db->query($sql, array($currentDate,$img));
    }

    function INSERT_NAVBAR($img)
    {
        $sql = "UPDATE tbl_system_setup SET value=? WHERE id='3'";
        $query = $this->db->query($sql, $img);
    }

    function INSERT_HEADER($img)
    {
        $sql = "UPDATE tbl_system_setup SET value=? WHERE id='4'";
        $query = $this->db->query($sql, $img);
    }

    function UPDATE_MOBILE_BANNER($img)
    {
        // $sql = "UPDATE tbl_system_setup SET value=? WHERE id='5'";
        $currentDate = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_system_setup SET edit_date=?, value=? WHERE id='5'";
        $query = $this->db->query($sql, array($currentDate,$img));
    }

    function UPDATE_DESKTOP_BANNER($img)
    {
        $sql = "UPDATE tbl_system_setup SET value=? WHERE id='6'";
        $query = $this->db->query($sql, $img);
    }

    function GET_SADMIN_STATUS1($id)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE id = $id";
        return $this->db->query($sql)->row_array();
    }

    function get_sadmin_status($id)
    {                                       
        $sql = "SELECT * FROM tbl_employee_infos WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_TABLES()
    {
        $tables = $this->db->list_tables();
        return $tables;
    }
function TRUNCATE_ALL_TABLE()
{
    $this->db->truncate('tbl_activity_logs');
    $this->db->truncate('tbl_approvers_leave');
    $this->db->truncate('tbl_approvers_ot');
    $this->db->truncate('tbl_approvers_timeadj');
    $this->db->truncate('tbl_approvers_offset');
    $this->db->truncate('tbl_asset_assign');
    $this->db->truncate('tbl_asset_logs');
    $this->db->truncate('tbl_attendance_adjustments');
    $this->db->truncate('tbl_attendance_offsets');
    $this->db->truncate('tbl_attendance_records');
    $this->db->truncate('tbl_attendance_records_lock');
    $this->db->truncate('tbl_attendance_shiftassign');
    $this->db->truncate('tbl_attendance_shifts');
    $this->db->truncate('tbl_benefits_adjustment_assign');
    $this->db->truncate('tbl_benefits_adjustment_type');
    $this->db->truncate('tbl_benefits_dynamic_assign');
    $this->db->truncate('tbl_benefits_dynamic_count');
    $this->db->truncate('tbl_benefits_dynamic_std');
    $this->db->truncate('tbl_benefits_dynamic_type');
    $this->db->truncate('tbl_benefits_fixed_assign');
    $this->db->truncate('tbl_benefits_fixed_type');
    $this->db->truncate('tbl_benefits_loan');
    $this->db->truncate('tbl_biometrics');
    $this->db->truncate('tbl_custom_pagibig_contribution');
    $this->db->truncate('tbl_custom_philhealth_contribution');
    $this->db->truncate('tbl_custom_sss_contribution');
    $this->db->truncate('tbl_employee_dependents');
    $this->db->truncate('tbl_employee_documents');
    $this->db->truncate('tbl_employee_education');
    $this->db->truncate('tbl_employee_emergency');
    $this->db->truncate('tbl_employee_infos');
    $this->db->truncate('tbl_employee_loanassign');
    $this->db->truncate('tbl_employee_logs');
    $this->db->truncate('tbl_employee_requirements');
    $this->db->truncate('tbl_employee_skillassign');
    $this->db->truncate('tbl_employee_tasks');
    $this->db->truncate('tbl_employee_workhistory');
    $this->db->truncate('tbl_holidaywork');
    $this->db->truncate('tbl_hr_aboutcompany');
    $this->db->truncate('tbl_hr_announcements');
    $this->db->truncate('tbl_hr_complaints');
    $this->db->truncate('tbl_hr_knowledgebases');
    $this->db->truncate('tbl_hr_policies');
    $this->db->truncate('tbl_hr_supports');
    $this->db->truncate('tbl_hr_surveys');
    $this->db->truncate('tbl_hr_warnings');
    $this->db->truncate('tbl_hr_welcomemessage');
    $this->db->truncate('tbl_leave_entitlements');
    $this->db->truncate('tbl_leaves_assign');
    $this->db->truncate('tbl_messaging_sms');
    $this->db->truncate('tbl_notifications');
    $this->db->truncate('tbl_other_deductions_assign');
    $this->db->truncate('tbl_other_deductions_type');
    $this->db->truncate('tbl_overtimes');
    $this->db->truncate('tbl_payroll_assignment');
    $this->db->truncate('tbl_payroll_hdmf');
    $this->db->truncate('tbl_payroll_otherdeductions');
    $this->db->truncate('tbl_payroll_payslip_adjustment');
    $this->db->truncate('tbl_payroll_payslip_loan');
    $this->db->truncate('tbl_payroll_payslip_otherdeductions');
    $this->db->truncate('tbl_payroll_payslip_otherearnings');
    $this->db->truncate('tbl_payroll_payslips');
    $this->db->truncate('tbl_payroll_period');
    $this->db->truncate('tbl_payroll_philhealth');
    $this->db->truncate('tbl_payroll_publish');
    $this->db->truncate('tbl_payroll_reimbursement');
    $this->db->truncate('tbl_payroll_sss');
    $this->db->truncate('tbl_payroll_tax');
    $this->db->truncate('tbl_project_assign');
    $this->db->truncate('tbl_projects');
    $this->db->truncate('tbl_recruitment_entries');
    $this->db->truncate('tbl_recruitment_jobposting');
    $this->db->truncate('tbl_session');
    $this->db->truncate('tbl_std_adjustments');
    $this->db->truncate('tbl_std_assetcategories');
    $this->db->truncate('tbl_std_banks');
    $this->db->truncate('tbl_std_bloodtypes');
    $this->db->truncate('tbl_std_branches');
    $this->db->truncate('tbl_std_companies');
    $this->db->truncate('tbl_std_companylocations');
    $this->db->truncate('tbl_std_departments');
    $this->db->truncate('tbl_std_divisions');
    $this->db->truncate('tbl_std_employeetypes');
    $this->db->truncate('tbl_std_genders');
    $this->db->truncate('tbl_std_groups');
    $this->db->truncate('tbl_std_hmos');
    $this->db->truncate('tbl_std_holidays');
    $this->db->truncate('tbl_std_knowledgearticles');
    $this->db->truncate('tbl_std_knowledgecategories');
    $this->db->truncate('tbl_std_leavetypes');
    $this->db->truncate('tbl_std_lines');
    $this->db->truncate('tbl_std_loantypes');
    $this->db->truncate('tbl_std_maritalstatuses');
    $this->db->truncate('tbl_std_nationalities');
    $this->db->truncate('tbl_std_positions');
    $this->db->truncate('tbl_std_religions');
    $this->db->truncate('tbl_std_requirements');
    $this->db->truncate('tbl_std_resignationtypes');
    $this->db->truncate('tbl_std_sections');
    $this->db->truncate('tbl_std_shirtsizes');
    $this->db->truncate('tbl_std_skilllevels');
    $this->db->truncate('tbl_std_skillnames');
    $this->db->truncate('tbl_std_stockrooms');
    $this->db->truncate('tbl_std_teams');
    $this->db->truncate('tbl_std_terminationtypes');
    $this->db->truncate('tbl_std_years');
    $this->db->truncate('tbl_system_patchlogs');
    $this->db->truncate('tbl_system_setup');
    $this->db->truncate('tbl_system_user_admin');
    $this->db->truncate('tbl_system_user_payroll');
    $this->db->truncate('tbl_system_user_sms');
    $this->db->truncate('tbl_system_useraccess');
    $this->db->truncate('tbl_system_whitelist');
    $this->db->truncate('tbl_uploads');
    $this->db->truncate('tbl_zkteco');

    $this->db->insert('tbl_std_banks', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'BDO', 'status' => 'Active']);
    $this->db->insert('tbl_std_banks', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'BPI', 'status' => 'Active']);
    $this->db->insert('tbl_std_banks', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Unionbank', 'status' => 'Active']);
    $this->db->insert('tbl_std_banks', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Security Bank', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_bloodtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'AB-', 'status' => 'Active']);
    $this->db->insert('tbl_std_bloodtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'AB+', 'status' => 'Active']);
    $this->db->insert('tbl_std_bloodtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'O-', 'status' => 'Active']);
    $this->db->insert('tbl_std_bloodtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'O+', 'status' => 'Active']);
    $this->db->insert('tbl_std_bloodtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'B-', 'status' => 'Active']);
    $this->db->insert('tbl_std_bloodtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'B+', 'status' => 'Active']);
    $this->db->insert('tbl_std_bloodtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'A-', 'status' => 'Active']);
    $this->db->insert('tbl_std_bloodtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'A+', 'status' => 'Active']);
    $this->db->insert('tbl_std_branches', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Main', 'status' => 'Active']);
    $this->db->insert('tbl_std_branches', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Branch A', 'status' => 'Active']);
    $this->db->insert('tbl_std_branches', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Branch B', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_companies', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Company A', 'status' => 'Active']);
    $this->db->insert('tbl_std_companies', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Company B', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_companylocations', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Manila', 'status' => 'Active']);
    $this->db->insert('tbl_std_companylocations', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Laguna', 'status' => 'Active']);
    $this->db->insert('tbl_std_companylocations', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Cavite', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_departments', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Finance', 'status' => 'Active']);
    $this->db->insert('tbl_std_divisions', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Engineering', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_employeetypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Project Based', 'status' => 'Active']);
    $this->db->insert('tbl_std_employeetypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Probationary', 'status' => 'Active']);
    $this->db->insert('tbl_std_employeetypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Regular', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_genders', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Male', 'status' => 'Active']);
    $this->db->insert('tbl_std_genders', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Female', 'status' => 'Active']);
    $this->db->insert('tbl_std_genders', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Other', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_groups', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Group 1', 'status' => 'Active']);
    $this->db->insert('tbl_std_groups', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Group 2', 'status' => 'Active']);
    $this->db->insert('tbl_std_hmos', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Maxicare', 'status' => 'Active']);
    $this->db->insert('tbl_std_hmos', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Medicard', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_leavetypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Leave without Pay (LWOP)', 'status' => 'Active']);
    $this->db->insert('tbl_std_leavetypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Vacation Leave', 'status' => 'Active']);
    $this->db->insert('tbl_std_leavetypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Sick Leave', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_lines', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Line 1', 'status' => 'Active']);
    $this->db->insert('tbl_std_lines', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Line 2', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_loantypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'SSS Salary', 'status' => 'Active']);
    $this->db->insert('tbl_std_loantypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'SSS Calamity', 'status' => 'Active']);
    $this->db->insert('tbl_std_loantypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Pagibig Salary', 'status' => 'Active']);
    $this->db->insert('tbl_std_loantypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Pagibig Calamity', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_maritalstatuses', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Single', 'status' => 'Active']);
    $this->db->insert('tbl_std_maritalstatuses', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Divorced', 'status' => 'Active']);
    $this->db->insert('tbl_std_maritalstatuses', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Annulled', 'status' => 'Active']);
    $this->db->insert('tbl_std_maritalstatuses', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Separated', 'status' => 'Active']);
    $this->db->insert('tbl_std_maritalstatuses', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Married', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_nationalities', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Filipino', 'status' => 'Active']);
    $this->db->insert('tbl_std_nationalities', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'American', 'status' => 'Active']);
    $this->db->insert('tbl_std_nationalities', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Japanese', 'status' => 'Active']);
    $this->db->insert('tbl_std_nationalities', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Chinese', 'status' => 'Active']);
    $this->db->insert('tbl_std_positions', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'CEO', 'status' => 'Active']);
    $this->db->insert('tbl_std_positions', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'President', 'status' => 'Active']);
    $this->db->insert('tbl_std_positions', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Vice-President', 'status' => 'Active']);
    $this->db->insert('tbl_std_positions', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Supervisor', 'status' => 'Active']);
    $this->db->insert('tbl_std_positions', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Staff', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_religions', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Catholic', 'status' => 'Active']);
    $this->db->insert('tbl_std_religions', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Iglesia ni Cristo (INC)', 'status' => 'Active']);
    $this->db->insert('tbl_std_religions', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Islam', 'status' => 'Active']);
    $this->db->insert('tbl_std_religions', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Pentecost', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_requirements', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Government Issued ID', 'status' => 'Active']);
    $this->db->insert('tbl_std_requirements', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'TIN', 'status' => 'Active']);
    $this->db->insert('tbl_std_requirements', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'SSS', 'status' => 'Active']);
    $this->db->insert('tbl_std_requirements', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Philhealth', 'status' => 'Active']);
    $this->db->insert('tbl_std_requirements', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Pagibig', 'status' => 'Active']);
    $this->db->insert('tbl_std_requirements', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Diploma/Transcript of Records', 'status' => 'Active']);
    $this->db->insert('tbl_std_requirements', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Certificate of Employment', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_resignationtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Poor Work-Life Balance', 'status' => 'Active']);
    $this->db->insert('tbl_std_resignationtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Insufficient Compensation and Benefits', 'status' => 'Active']);
    $this->db->insert('tbl_std_resignationtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Lack of Career Growth and Development', 'status' => 'Active']);
    $this->db->insert('tbl_std_resignationtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Toxic Company Culture', 'status' => 'Active']);
    $this->db->insert('tbl_std_resignationtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Ineffective Leadership', 'status' => 'Active']);
    $this->db->insert('tbl_std_resignationtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Police Clearance', 'status' => 'Active']);
    $this->db->insert('tbl_std_resignationtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Pre-employment Test', 'status' => 'Active']);
    $this->db->insert('tbl_std_sections', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Section A', 'status' => 'Active']);
    $this->db->insert('tbl_std_sections', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Section B', 'status' => 'Active']);
    $this->db->insert('tbl_std_shirtsizes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'XS', 'status' => 'Active']);

    $this->db->insert('tbl_std_shirtsizes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'SSS Calamity', 'status' => 'Active']);
    $this->db->insert('tbl_std_shirtsizes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'M', 'status' => 'Active']);
    $this->db->insert('tbl_std_shirtsizes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'L', 'status' => 'Active']);
    $this->db->insert('tbl_std_shirtsizes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'XL', 'status' => 'Active']);
    $this->db->insert('tbl_std_shirtsizes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'XXL', 'status' => 'Active']);
    $this->db->insert('tbl_std_shirtsizes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'XXXL', 'status' => 'Active']);
    $this->db->insert('tbl_std_skilllevels', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Beginner', 'status' => 'Active']);
    $this->db->insert('tbl_std_skilllevels', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Intermediate', 'status' => 'Active']);
    $this->db->insert('tbl_std_skilllevels', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Advanced', 'status' => 'Active']);
    $this->db->insert('tbl_std_skilllevels', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Expert', 'status' => 'Active']);
    $this->db->insert('tbl_std_skilllevels', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Trainor', 'status' => 'Active']);
    $this->db->insert('tbl_std_skillnames', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Driving', 'status' => 'Active']);
    $this->db->insert('tbl_std_skillnames', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Swimming', 'status' => 'Active']);
    $this->db->insert('tbl_std_skillnames', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Photo Editing', 'status' => 'Active']);
    $this->db->insert('tbl_std_skillnames', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Video Editing', 'status' => 'Active']);
    $this->db->insert('tbl_std_skillnames', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Hosting', 'status' => 'Active']);
    $this->db->insert('tbl_std_skillnames', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Singing', 'status' => 'Active']);
    
    $this->db->insert('tbl_std_teams', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Team 1', 'status' => 'Active']);
    $this->db->insert('tbl_std_teams', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Team 2', 'status' => 'Active']);
    $this->db->insert('tbl_std_terminationtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'AWOL', 'status' => 'Active']);
    $this->db->insert('tbl_std_terminationtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Resigned', 'status' => 'Active']);
    $this->db->insert('tbl_std_terminationtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'End of Contract', 'status' => 'Active']);
    $this->db->insert('tbl_std_terminationtypes', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => 'Terminated', 'status' => 'Active']);
    $this->db->insert('tbl_std_years', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => '2023', 'status' => 'Active']);
    $this->db->insert('tbl_std_years', ['create_date' => '2023-01-01 00:00:00', 'edit_date' => '2023-01-01 00:00:00', 'is_deleted' => 0, 'name' => '2024', 'status' => 'Active']);
    $this->db->insert('tbl_attendance_shifts', ['id' => 1, 'is_deleted' => 0, 'code' => 'REST', 'name' => 'REST', 'color' => '#c4c4c4', 'time_regular_enable' => NULL, 'time_regular_start' => NULL, 'time_regular_end' => NULL, 'time_regular_reg' => 0, 'time_regular_nd' => 0, 'time_break_enable' => NULL, 'time_break_start' => '00:00:00', 'time_break_end' => '00:00:00', 'time_break_isexcluded' => NULL, 'time_break_hours' => 0, 'time_overtime_enable' => NULL, 'time_overtime_start' => '00:00:00', 'time_overtime_end' => '00:00:00', 'time_overtime_ot' => 0, 'time_overtime_nd' => 0, 'status' => 'Active', 'time_in' => '00:00:00', 'time_out' => '00:00:00', 'time_in_2' => '00:00:00', 'time_out_2' => '00:00:00', 'time_out_ot' => '00:00:00', 'next_day' => '', 'fixed' => 0, 'lunch_break_start' => NULL, 'lunch_break_end' => NULL, 'disregard_undertime' => 0]);
    $this->db->insert('tbl_attendance_shifts', ['id' => 2, 'is_deleted' => 0, 'code' => 'DS8-5', 'name' => 'Dayshift 8 am - 5 pm', 'color' => '#00ff38', 'time_regular_enable' => 1, 'time_regular_start' => '08:00:00', 'time_regular_end' => '17:00:00', 'time_regular_reg' => 8, 'time_regular_nd' => 0, 'time_break_enable' => 1, 'time_break_start' => '12:00:00', 'time_break_end' => '13:00:00', 'time_break_isexcluded' => 1, 'time_break_hours' => 1, 'time_overtime_enable' => NULL, 'time_overtime_start' => '00:00:00', 'time_overtime_end' => '00:00:00', 'time_overtime_ot' => 0, 'time_overtime_nd' => 0, 'status' => 'Active', 'time_in' => '00:00:00', 'time_out' => '00:00:00', 'time_in_2' => '00:00:00', 'time_out_2' => '00:00:00', 'time_out_ot' => '00:00:00', 'next_day' => '', 'fixed' => 0, 'lunch_break_start' => NULL, 'lunch_break_end' => NULL, 'disregard_undertime' => 0]);
    $this->db->insert('tbl_payroll_period', ['id' => 1, 'create_date' => '2023-07-06 02:33:21', 'edit_date' => '2023-10-05 14:04:11', 'edit_user' => 1, 'is_deleted' => 0, 'name' => 'Jul 16 - 31, 2023', 'date_from' => '2023-07-16', 'date_to' => '2023-07-31', 'payout' => '2023-07-27', 'status' => 'Active', 'connected_period' => 2, 'connected_period_2' => 0, 'connected_period_3' => 0, 'connected_period_4' => 0, 'connected_period_5' => 0, 'db_name' => NULL, 'year' => 1, 'month' => 'July', 'pay_frequency' => 'Semi-Monthly', 'chk_sss' => NULL, 'chk_philhealth' => NULL, 'chk_pagibig' => NULL, 'chk_withholding' => NULL, 'chk_earnings' => NULL, 'chk_deductions' => NULL, 'chk_loans' => NULL, 'chk_adjustment' => NULL, 'chk_tardiness' => NULL]);
    $this->db->insert('tbl_payroll_period', ['id' => 2, 'create_date' => '2023-07-06 04:06:10', 'edit_date' => '2023-12-06 19:10:14', 'edit_user' => 1, 'is_deleted' => 0, 'name' => 'July 1 - 15, 2023', 'date_from' => '2023-07-01', 'date_to' => '2023-07-15', 'payout' => '2023-07-15', 'status' => 'Active', 'connected_period' => 66, 'connected_period_2' => 0, 'connected_period_3' => 0, 'connected_period_4' => 0, 'connected_period_5' => 0, 'db_name' => NULL, 'year' => 1, 'month' => 'July', 'pay_frequency' => 'Semi-Monthly', 'chk_sss' => 1, 'chk_philhealth' => 1, 'chk_pagibig' => 1, 'chk_withholding' => 1, 'chk_earnings' => 1, 'chk_deductions' => 1, 'chk_loans' => NULL, 'chk_adjustment' => 1, 'chk_tardiness' => 1]);
    
    
   }

    function TRUNCATE_ALL_TABLE2()
    {
        $this->db->insert('tbl_payroll_philhealth', ['id' => 1, 'create_date' => '2022-11-22 04:17:06', 'edit_date' => '2023-01-05 18:25:54', 'edit_user' => 0, 'is_deleted' => 0, 'year' => 2023, 'rate' => 4, 'status' => 'Active', 'min_basic' => 10000, 'max_basic' => 80000, 'min_premium' => 400, 'max_premium' => 3200]);
        $this->db->insert('tbl_payroll_philhealth', ['id' => 2, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'year' => 2024, 'rate' => 5, 'status' => 'Active', 'min_basic' => 10000, 'max_basic' => 100000, 'min_premium' => 500, 'max_premium' => 5000]);
        $this->db->insert('tbl_payroll_hdmf', ['id' => 1, 'create_date' => '2023-06-08 02:04:36', 'edit_date' => '2023-06-08 02:04:36', 'edit_user' => 1, 'is_deleted' => 0, 'year' => 2024, 'percent' => 2, 'min_salary' => 10000,'max_contribution' => 200, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_hdmf', ['id' => 2, 'create_date' => '2023-07-15 15:09:52', 'edit_date' => '2023-07-15 15:09:52', 'edit_user' => 1, 'is_deleted' => 0, 'year' => 2023, 'percent' => 1, 'min_salary' => 5000,'max_contribution' => 100, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 1, 'create_date' => '2023-04-14 09:48:52', 'edit_date' => '2023-04-14 09:48:52', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 0.00, 'salary_max' => 4249.00, 'msc_rss_ec' => 4000.00, 'msc_mpf' => 0.00, 'msc_tot' => 4000.00, 'rss_er' => 380.00, 'rss_ee' => 180.00, 'rss_tot' => 560.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 390.00, 'ee' => 180.00, 'tot' => 570.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 2, 'create_date' => '2023-04-14 09:55:14', 'edit_date' => '2023-04-14 09:55:14', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 4250.00, 'salary_max' => 4749.99, 'msc_rss_ec' => 4500.00, 'msc_mpf' => 0.00, 'msc_tot' => 4500.00, 'rss_er' => 427.50, 'rss_ee' => 202.50, 'rss_tot' => 630.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 437.50, 'ee' => 202.50, 'tot' => 640.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 3, 'create_date' => '2023-04-14 10:02:06', 'edit_date' => '2023-04-14 10:02:06', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 4750.00, 'salary_max' => 5249.99, 'msc_rss_ec' => 5000.00, 'msc_mpf' => 0.00, 'msc_tot' => 5000.00, 'rss_er' => 475.00, 'rss_ee' => 225.00, 'rss_tot' => 700.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 485.00, 'ee' => 225.00, 'tot' => 710.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 4, 'create_date' => '2023-04-14 10:05:43', 'edit_date' => '2023-04-14 10:05:43', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 5250.00, 'salary_max' => 5749.99, 'msc_rss_ec' => 5500.00, 'msc_mpf' => 0.00, 'msc_tot' => 5500.00, 'rss_er' => 522.50, 'rss_ee' => 247.50, 'rss_tot' => 770.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 532.50, 'ee' => 247.50, 'tot' => 780.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 5, 'create_date' => '2023-04-14 10:08:27', 'edit_date' => '2023-04-14 10:08:27', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 5750.00, 'salary_max' => 6249.99, 'msc_rss_ec' => 6000.00, 'msc_mpf' => 0.00, 'msc_tot' => 6000.00, 'rss_er' => 570.00, 'rss_ee' => 270.00, 'rss_tot' => 840.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 580.00, 'ee' => 270.00, 'tot' => 850.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 6, 'create_date' => '2023-04-14 10:12:40', 'edit_date' => '2023-04-14 10:12:40', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 6250.00, 'salary_max' => 6749.99, 'msc_rss_ec' => 6500.00, 'msc_mpf' => 0.00, 'msc_tot' => 6500.00, 'rss_er' => 617.50, 'rss_ee' => 292.50, 'rss_tot' => 910.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 627.50, 'ee' => 292.50, 'tot' => 920.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 7, 'create_date' => '2023-04-14 10:14:52', 'edit_date' => '2023-04-14 10:14:52', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 6750.00, 'salary_max' => 7249.99, 'msc_rss_ec' => 7000.00, 'msc_mpf' => 0.00, 'msc_tot' => 7000.00, 'rss_er' => 665.00, 'rss_ee' => 315.00, 'rss_tot' => 980.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 675.00, 'ee' => 315.00, 'tot' => 990.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 8, 'create_date' => '2023-04-14 10:18:12', 'edit_date' => '2023-04-14 10:18:12', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 7250.00, 'salary_max' => 7749.99, 'msc_rss_ec' => 7500.00, 'msc_mpf' => 0.00, 'msc_tot' => 7500.00, 'rss_er' => 712.50, 'rss_ee' => 337.50, 'rss_tot' => 1050.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 722.50, 'ee' => 337.50, 'tot' => 1060.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 9, 'create_date' => '2023-04-14 10:20:33', 'edit_date' => '2023-04-14 10:20:33', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 7750.00, 'salary_max' => 8249.99, 'msc_rss_ec' => 8000.00, 'msc_mpf' => 0.00, 'msc_tot' => 8000.00, 'rss_er' => 760.00, 'rss_ee' => 360.00, 'rss_tot' => 1130.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 770.00, 'ee' => 360.00, 'tot' => 1130.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 10, 'create_date' => '2023-04-14 10:24:13', 'edit_date' => '2023-04-14 10:24:13', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 8250.00, 'salary_max' => 8749.99, 'msc_rss_ec' => 8500.00, 'msc_mpf' => 0.00, 'msc_tot' => 8500.00, 'rss_er' => 807.50, 'rss_ee' => 382.50, 'rss_tot' => 1200.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 817.50, 'ee' => 382.50, 'tot' => 1200.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 11, 'create_date' => '2023-04-14 10:27:30', 'edit_date' => '2023-04-14 10:27:30', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 8750.00, 'salary_max' => 9249.99, 'msc_rss_ec' => 9000.00, 'msc_mpf' => 0.00, 'msc_tot' => 9000.00, 'rss_er' => 855.00, 'rss_ee' => 405.00, 'rss_tot' => 1270.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 865.00, 'ee' => 405.00, 'tot' => 1270.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 12, 'create_date' => '2023-04-14 10:32:28', 'edit_date' => '2023-04-14 10:32:28', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 9250.00, 'salary_max' => 9749.99, 'msc_rss_ec' => 9500.00, 'msc_mpf' => 0.00, 'msc_tot' => 9500.00, 'rss_er' => 902.50, 'rss_ee' => 427.50, 'rss_tot' => 1340.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 912.50, 'ee' => 427.50, 'tot' => 1340.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 13, 'create_date' => '2023-04-14 10:34:15', 'edit_date' => '2023-04-14 10:34:15', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 9750.00, 'salary_max' => 10249.99, 'msc_rss_ec' => 10000.00, 'msc_mpf' => 0.00, 'msc_tot' => 10000.00, 'rss_er' => 950.00, 'rss_ee' => 450.00, 'rss_tot' => 1400.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 960.00, 'ee' => 450.00, 'tot' => 1410.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 14, 'create_date' => '2023-04-14 10:36:33', 'edit_date' => '2023-04-14 10:36:33', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 10250.00, 'salary_max' => 10749.99, 'msc_rss_ec' => 10500.00, 'msc_mpf' => 0.00, 'msc_tot' => 10500.00, 'rss_er' => 997.50, 'rss_ee' => 472.50, 'rss_tot' => 1470.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 1007.50, 'ee' => 472.50, 'tot' => 1480.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 15, 'create_date' => '2023-04-14 10:38:32', 'edit_date' => '2023-04-14 10:38:32', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 10750.00, 'salary_max' => 11249.99, 'msc_rss_ec' => 11000.00, 'msc_mpf' => 0.00, 'msc_tot' => 11000.00, 'rss_er' => 1045.00, 'rss_ee' => 495.00, 'rss_tot' => 1540.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 1055.00, 'ee' => 495.00, 'tot' => 1550.00, 'status' => 'Active']);    
        $this->db->insert('tbl_payroll_sss', ['id' => 16, 'create_date' => '2023-04-14 10:41:20', 'edit_date' => '2023-04-14 10:41:20', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 11250.00, 'salary_max' => 11749.99, 'msc_rss_ec' => 11500.00, 'msc_mpf' => 0.00, 'msc_tot' => 11500.00, 'rss_er' => 1092.50, 'rss_ee' => 517.50, 'rss_tot' => 1610.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 1102.50, 'ee' => 517.50, 'tot' => 1620.00, 'status' => 'Active']);    
        $this->db->insert('tbl_payroll_sss', ['id' => 17, 'create_date' => '2023-04-14 10:34:15', 'edit_date' => '2023-04-14 10:34:15', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 11750.00, 'salary_max' => 12249.99, 'msc_rss_ec' => 12000.00, 'msc_mpf' => 0.00, 'msc_tot' => 12000.00, 'rss_er' => 1140.00, 'rss_ee' => 540.00, 'rss_tot' => 1680.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 1150.00, 'ee' => 540.00, 'tot' => 1690.00, 'status' => 'Active']);    
        $this->db->insert('tbl_payroll_sss', ['id' => 18, 'create_date' => '2023-04-14 10:36:33', 'edit_date' => '2023-04-14 10:36:33', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 12250.00, 'salary_max' => 12749.99, 'msc_rss_ec' => 12500.00, 'msc_mpf' => 0.00, 'msc_tot' => 12500.00, 'rss_er' => 1182.50, 'rss_ee' => 562.50, 'rss_tot' => 1745.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 1192.50, 'ee' => 562.50, 'tot' => 1755.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 19, 'create_date' => '2023-04-14 10:50:26', 'edit_date' => '2023-04-14 10:50:26', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 12750.00, 'salary_max' => 13249.99, 'msc_rss_ec' => 13000.00, 'msc_mpf' => 0.00, 'msc_tot' => 13000.00, 'rss_er' => 1235.00, 'rss_ee' => 585.00, 'rss_tot' => 1820.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 1245.00, 'ee' => 585.00, 'tot' => 1830.00, 'status' => 'Active']);
    
        $this->db->insert('tbl_payroll_sss', ['id' => 20, 'create_date' => '2023-04-14 10:53:21', 'edit_date' => '2023-04-14 10:53:21', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 13250.00, 'salary_max' => 13749.99, 'msc_rss_ec' => 13500.00, 'msc_mpf' => 0.00, 'msc_tot' => 13500.00, 'rss_er' => 1282.50, 'rss_ee' => 607.50, 'rss_tot' => 1890.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 1292.50, 'ee' => 607.50, 'tot' => 1900.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_sss', ['id' => 21, 'create_date' => '2023-04-14 10:54:52', 'edit_date' => '2023-04-14 10:54:52', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 13750.00, 'salary_max' => 14249.99, 'msc_rss_ec' => 14000.00, 'msc_mpf' => 0.00, 'msc_tot' => 14000.00, 'rss_er' => 1330.00, 'rss_ee' => 630.00, 'rss_tot' => 1970.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 1340.00, 'ee' => 630.00, 'tot' => 1970.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_sss', ['id' => 22, 'create_date' => '2023-04-14 11:02:14', 'edit_date' => '2023-04-14 11:02:14', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 14250.00, 'salary_max' => 14749.99, 'msc_rss_ec' => 14500.00, 'msc_mpf' => 0.00, 'msc_tot' => 14500.00, 'rss_er' => 1377.50, 'rss_ee' => 652.50, 'rss_tot' => 2040.00, 'ec_er' => 10.00, 'ec_ee' => 0.00, 'ec_tot' => 10.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 1387.50, 'ee' => 652.50, 'tot' => 2040.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_sss', ['id' => 23, 'create_date' => '2023-04-14 11:04:42', 'edit_date' => '2023-04-14 11:04:42', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 14750.00, 'salary_max' => 15249.99, 'msc_rss_ec' => 15000.00, 'msc_mpf' => 0.00, 'msc_tot' => 15000.00, 'rss_er' => 1425.00, 'rss_ee' => 675.00, 'rss_tot' => 2130.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 0.00, 'er' => 1455.00, 'ee' => 675.00, 'tot' => 2130.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 24, 'create_date' => '2023-04-14 11:07:20', 'edit_date' => '2023-04-14 11:07:20', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 15250.00, 'salary_max' => 15749.99, 'msc_rss_ec' => 15500.00, 'msc_mpf' => 0.00, 'msc_tot' => 15500.00, 'rss_er' => 1472.50, 'rss_ee' => 697.50, 'rss_tot' => 2170.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 30.00, 'er' => 1502.50, 'ee' => 697.50, 'tot' => 2200.00, 'status' => 'Active']);
    
        $this->db->insert('tbl_payroll_sss', ['id' => 25, 'create_date' => '2023-04-14 11:09:37', 'edit_date' => '2023-04-14 11:09:37', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 15750.00, 'salary_max' => 16249.99, 'msc_rss_ec' => 16000.00, 'msc_mpf' => 0.00, 'msc_tot' => 16000.00, 'rss_er' => 1520.00, 'rss_ee' => 720.00, 'rss_tot' => 2240.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 30.00, 'er' => 1550.00, 'ee' => 720.00, 'tot' => 2270.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_sss', ['id' => 26, 'create_date' => '2023-04-14 11:12:59', 'edit_date' => '2023-04-14 11:12:59', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 16250.00, 'salary_max' => 16749.99, 'msc_rss_ec' => 16500.00, 'msc_mpf' => 0.00, 'msc_tot' => 16500.00, 'rss_er' => 1567.50, 'rss_ee' => 742.50, 'rss_tot' => 2310.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 30.00, 'er' => 1597.50, 'ee' => 742.50, 'tot' => 2340.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_sss', ['id' => 27, 'create_date' => '2023-04-14 11:14:49', 'edit_date' => '2023-04-14 11:14:49', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 16750.00, 'salary_max' => 17249.99, 'msc_rss_ec' => 17000.00, 'msc_mpf' => 0.00, 'msc_tot' => 17000.00, 'rss_er' => 1615.00, 'rss_ee' => 765.00, 'rss_tot' => 2380.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 30.00, 'er' => 1645.00, 'ee' => 765.00, 'tot' => 2410.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_sss', ['id' => 28, 'create_date' => '2023-04-14 11:17:09', 'edit_date' => '2023-04-14 11:17:09', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 17250.00, 'salary_max' => 17749.99, 'msc_rss_ec' => 17500.00, 'msc_mpf' => 0.00, 'msc_tot' => 17500.00, 'rss_er' => 1662.50, 'rss_ee' => 787.50, 'rss_tot' => 2450.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 30.00, 'er' => 1692.50, 'ee' => 787.50, 'tot' => 2480.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 29, 'create_date' => '2023-04-14 11:19:48', 'edit_date' => '2023-04-14 11:19:48', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 17750.00, 'salary_max' => 18249.99, 'msc_rss_ec' => 18000.00, 'msc_mpf' => 0.00, 'msc_tot' => 18000.00, 'rss_er' => 1710.00, 'rss_ee' => 810.00, 'rss_tot' => 2520.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 30.00, 'er' => 1740.00, 'ee' => 810.00, 'tot' => 2550.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 30, 'create_date' => '2023-04-14 11:23:40', 'edit_date' => '2023-04-14 11:23:40', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 18250.00, 'salary_max' => 18749.99, 'msc_rss_ec' => 18500.00, 'msc_mpf' => 0.00, 'msc_tot' => 18500.00, 'rss_er' => 1757.50, 'rss_ee' => 832.50, 'rss_tot' => 2590.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 30.00, 'er' => 1787.50, 'ee' => 832.50, 'tot' => 2620.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 31, 'create_date' => '2023-04-14 11:25:16', 'edit_date' => '2023-04-14 11:25:16', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 18750.00, 'salary_max' => 19249.99, 'msc_rss_ec' => 19000.00, 'msc_mpf' => 0.00, 'msc_tot' => 19000.00, 'rss_er' => 1805.00, 'rss_ee' => 855.00, 'rss_tot' => 2660.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 30.00, 'er' => 1835.00, 'ee' => 855.00, 'tot' => 2690.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 32, 'create_date' => '2023-04-14 11:27:51', 'edit_date' => '2023-04-14 11:27:51', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 19250.00, 'salary_max' => 19749.99, 'msc_rss_ec' => 19500.00, 'msc_mpf' => 0.00, 'msc_tot' => 19500.00, 'rss_er' => 1852.50, 'rss_ee' => 877.50, 'rss_tot' => 2730.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 30.00, 'er' => 1882.50, 'ee' => 877.50, 'tot' => 2760.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 33, 'create_date' => '2023-04-14 11:29:55', 'edit_date' => '2023-04-14 11:29:55', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 19750.00, 'salary_max' => 20249.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 0.00, 'msc_tot' => 20000.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 0.00, 'mpf_ee' => 0.00, 'mpf_tot' => 30.00, 'er' => 1930.00, 'ee' => 900.00, 'tot' => 2830.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 34, 'create_date' => '2023-04-14 11:32:36', 'edit_date' => '2023-04-14 11:32:36', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 20250.00, 'salary_max' => 20749.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 500.00, 'msc_tot' => 20500.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 47.50, 'mpf_ee' => 22.50, 'mpf_tot' => 70.00, 'er' => 1977.50, 'ee' => 922.50, 'tot' => 2900.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 35, 'create_date' => '2023-04-14 11:34:17', 'edit_date' => '2023-04-14 11:34:17', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 20750.00, 'salary_max' => 21249.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 1000.00, 'msc_tot' => 21000.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 95.00, 'mpf_ee' => 45.00, 'mpf_tot' => 140.00, 'er' => 2025.00, 'ee' => 945.00, 'tot' => 2970.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 36, 'create_date' => '2023-04-14 11:39:54', 'edit_date' => '2023-04-14 11:39:54', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 21250.00, 'salary_max' => 21749.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 1500.00, 'msc_tot' => 21500.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 142.50, 'mpf_ee' => 67.50, 'mpf_tot' => 210.00, 'er' => 2072.50, 'ee' => 967.50, 'tot' => 3040.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 37, 'create_date' => '2023-04-14 11:44:26', 'edit_date' => '2023-04-14 11:44:26', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 21750.00, 'salary_max' => 22249.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 2000.00, 'msc_tot' => 22000.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 190.00, 'mpf_ee' => 90.00, 'mpf_tot' => 280.00, 'er' => 2120.00, 'ee' => 990.00, 'tot' => 3110.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 38, 'create_date' => '2023-04-14 11:49:02', 'edit_date' => '2023-04-14 11:49:02', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 22250.00, 'salary_max' => 22749.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 2500.00, 'msc_tot' => 22500.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 237.50, 'mpf_ee' => 112.50, 'mpf_tot' => 350.00, 'er' => 2167.50, 'ee' => 1012.50, 'tot' => 3180.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 39, 'create_date' => '2023-04-14 11:51:07', 'edit_date' => '2023-04-14 11:51:07', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 22750.00, 'salary_max' => 23249.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 3000.00, 'msc_tot' => 23000.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 285.00, 'mpf_ee' => 135.00, 'mpf_tot' => 420.00, 'er' => 2215.00, 'ee' => 1035.00, 'tot' => 3250.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 40, 'create_date' => '2023-04-14 11:53:50', 'edit_date' => '2023-04-14 11:53:50', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 23250.00, 'salary_max' => 23749.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 3500.00, 'msc_tot' => 23500.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 332.50, 'mpf_ee' => 157.50, 'mpf_tot' => 490.00, 'er' => 2262.50, 'ee' => 1057.50, 'tot' => 3320.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 41, 'create_date' => '2023-04-14 11:55:35', 'edit_date' => '2023-04-14 11:55:35', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 23750.00, 'salary_max' => 24249.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 4000.00, 'msc_tot' => 24000.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 380.00, 'mpf_ee' => 180.00, 'mpf_tot' => 560.00, 'er' => 2310.00, 'ee' => 1080.00, 'tot' => 3390.00, 'status' => 'Active']);
    
        $this->db->insert('tbl_payroll_sss', ['id' => 42, 'create_date' => '2023-04-14 11:58:05', 'edit_date' => '2023-04-14 11:58:05', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 24250.00, 'salary_max' => 24749.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 4500.00, 'msc_tot' => 24500.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 427.50, 'mpf_ee' => 202.50, 'mpf_tot' => 630.00, 'er' => 2357.50, 'ee' => 1102.50, 'tot' => 3460.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_sss', ['id' => 43, 'create_date' => '2023-04-14 12:03:15', 'edit_date' => '2023-04-14 12:03:15', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 24750.00, 'salary_max' => 25249.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 5000.00, 'msc_tot' => 25000.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 475.00, 'mpf_ee' => 225.00, 'mpf_tot' => 700.00, 'er' => 2405.00, 'ee' => 1125.00, 'tot' => 3530.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_sss', ['id' => 44, 'create_date' => '2023-04-14 12:05:49', 'edit_date' => '2023-04-14 12:05:49', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 25250.00, 'salary_max' => 25749.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 5500.00, 'msc_tot' => 25500.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 522.50, 'mpf_ee' => 247.50, 'mpf_tot' => 770.00, 'er' => 2452.50, 'ee' => 1147.50, 'tot' => 3600.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_sss', ['id' => 45, 'create_date' => '2023-04-14 12:07:50', 'edit_date' => '2023-04-14 12:07:50', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 25750.00, 'salary_max' => 26249.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 6000.00, 'msc_tot' => 26000.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 570.00, 'mpf_ee' => 270.00, 'mpf_tot' => 840.00, 'er' => 2500.00, 'ee' => 1170.00, 'tot' => 3670.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 46, 'create_date' => '2023-04-14 12:12:54', 'edit_date' => '2023-04-14 12:12:54', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 26250.00, 'salary_max' => 26749.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 6500.00, 'msc_tot' => 26500.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 617.50, 'mpf_ee' => 292.50, 'mpf_tot' => 910.00, 'er' => 2547.50, 'ee' => 1192.50, 'tot' => 3740.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_sss', ['id' => 47, 'create_date' => '2023-04-14 12:15:21', 'edit_date' => '2023-04-14 12:15:21', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 26750.00, 'salary_max' => 27249.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 7000.00, 'msc_tot' => 27000.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 665.00, 'mpf_ee' => 315.00, 'mpf_tot' => 980.00, 'er' => 2595.00, 'ee' => 1215.00, 'tot' => 3810.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_sss', ['id' => 48, 'create_date' => '2023-04-14 12:19:36', 'edit_date' => '2023-04-14 12:19:36', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 27250.00, 'salary_max' => 27749.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 7500.00, 'msc_tot' => 27500.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 712.50, 'mpf_ee' => 337.50, 'mpf_tot' => 1050.00, 'er' => 2642.50, 'ee' => 1237.50, 'tot' => 3880.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_sss', ['id' => 49, 'create_date' => '2023-04-14 12:22:00', 'edit_date' => '2023-04-14 12:22:00', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 27750.00, 'salary_max' => 28249.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 8000.00, 'msc_tot' => 28000.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 760.00, 'mpf_ee' => 360.00, 'mpf_tot' => 1120.00, 'er' => 2690.00, 'ee' => 1260.00, 'tot' => 3950.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_sss', ['id' => 50, 'create_date' => '2023-04-14 12:25:08', 'edit_date' => '2023-04-14 12:25:08', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 28250.00, 'salary_max' => 28749.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 8500.00, 'msc_tot' => 28500.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 807.50, 'mpf_ee' => 382.50, 'mpf_tot' => 1190.00, 'er' => 2737.50, 'ee' => 1282.50, 'tot' => 4020.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_sss', ['id' => 51, 'create_date' => '2023-04-14 12:27:45', 'edit_date' => '2023-04-14 12:27:45', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 28750.00, 'salary_max' => 29249.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 9000.00, 'msc_tot' => 29000.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 855.00, 'mpf_ee' => 405.00, 'mpf_tot' => 1260.00, 'er' => 2785.00, 'ee' => 1305.00, 'tot' => 4090.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_sss', ['id' => 52, 'create_date' => '2023-04-14 12:32:30', 'edit_date' => '2023-04-14 12:32:30', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 29250.00, 'salary_max' => 29749.99, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 9500.00, 'msc_tot' => 29500.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 902.50, 'mpf_ee' => 427.50, 'mpf_tot' => 1330.00, 'er' => 2832.50, 'ee' => 1327.50, 'tot' => 4160.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_sss', ['id' => 53, 'create_date' => '2023-04-14 12:34:52', 'edit_date' => '2023-04-14 12:34:52', 'edit_user' => 64, 'is_deleted' => 0, 'year' => 2024, 'salary_min' => 29750.00, 'salary_max' => 9999999.00, 'msc_rss_ec' => 20000.00, 'msc_mpf' => 10000.00, 'msc_tot' => 30000.00, 'rss_er' => 1900.00, 'rss_ee' => 900.00, 'rss_tot' => 2800.00, 'ec_er' => 30.00, 'ec_ee' => 0.00, 'ec_tot' => 30.00, 'mpf_er' => 950.00, 'mpf_ee' => 450.00, 'mpf_tot' => 1400.00, 'er' => 2880.00, 'ee' => 1350.00, 'tot' => 4230.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 1, 'create_date' => '2023-06-29 07:53:24', 'edit_date' => '2023-06-29 07:53:24', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Daily', 'salary_min' => 0.00, 'salary_max' => 685.00, 'fixed' => 0.00, 'c_level' => 0.00, 'c_percent' => 0.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 2, 'create_date' => '2023-06-29 07:57:34', 'edit_date' => '2023-06-29 07:57:34', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Daily', 'salary_min' => 685.00, 'salary_max' => 1096.00, 'fixed' => 0.00, 'c_level' => 685.00, 'c_percent' => 15.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 3, 'create_date' => '2023-06-29 07:58:20', 'edit_date' => '2023-06-29 07:58:20', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Daily', 'salary_min' => 1096.00, 'salary_max' => 2192.00, 'fixed' => 61.65, 'c_level' => 1096.00, 'c_percent' => 20.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_tax', ['id' => 4, 'create_date' => '2023-06-29 07:59:06', 'edit_date' => '2023-06-29 07:59:06', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Daily', 'salary_min' => 2192.00, 'salary_max' => 5479.00, 'fixed' => 280.85, 'c_level' => 2192.00, 'c_percent' => 25.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 5, 'create_date' => '2023-06-29 08:00:20', 'edit_date' => '2023-06-29 08:00:20', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Daily', 'salary_min' => 5479.00, 'salary_max' => 21918.00, 'fixed' => 1102.60, 'c_level' => 5479.00, 'c_percent' => 30.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 6, 'create_date' => '2023-06-29 08:01:54', 'edit_date' => '2023-06-29 08:01:54', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Daily', 'salary_min' => 21918.00, 'salary_max' => 9999999.00, 'fixed' => 6034.30, 'c_level' => 21918.00, 'c_percent' => 35.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 7, 'create_date' => '2023-06-29 07:53:24', 'edit_date' => '2023-06-29 07:53:24', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Weekly', 'salary_min' => 0.00, 'salary_max' => 4808.00, 'fixed' => 0.00, 'c_level' => 0.00, 'c_percent' => 0.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 8, 'create_date' => '2023-06-29 07:57:34', 'edit_date' => '2023-06-29 07:57:34', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Weekly', 'salary_min' => 4808.00, 'salary_max' => 7692.00, 'fixed' => 0.00, 'c_level' => 4808.00, 'c_percent' => 15.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 9, 'create_date' => '2023-06-29 07:58:20', 'edit_date' => '2023-06-29 07:58:20', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Weekly', 'salary_min' => 7692.00, 'salary_max' => 15385.00, 'fixed' => 432.60, 'c_level' => 7692.00, 'c_percent' => 20.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 10, 'create_date' => '2023-06-29 07:59:06', 'edit_date' => '2023-06-29 07:59:06', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Weekly', 'salary_min' => 15385.00, 'salary_max' => 38462.00, 'fixed' => 1971.20, 'c_level' => 15385.00, 'c_percent' => 25.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 11, 'create_date' => '2023-06-29 08:00:20', 'edit_date' => '2023-06-29 08:00:20', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Weekly', 'salary_min' => 38462.00, 'salary_max' => 153846.00, 'fixed' => 7740.45, 'c_level' => 38462.00, 'c_percent' => 30.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 12, 'create_date' => '2023-06-29 08:01:54', 'edit_date' => '2023-06-29 08:01:54', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Weekly', 'salary_min' => 153846.00, 'salary_max' => 9999999.00, 'fixed' => 42355.65, 'c_level' => 153846.00, 'c_percent' => 35.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 13, 'create_date' => '2023-06-29 07:53:24', 'edit_date' => '2023-06-29 07:53:24', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Semi-Monthly', 'salary_min' => 0.00, 'salary_max' => 10417.00, 'fixed' => 0.00, 'c_level' => 0.00, 'c_percent' => 0.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_tax', ['id' => 14, 'create_date' => '2023-06-29 07:57:34', 'edit_date' => '2023-06-29 07:57:34', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Semi-Monthly', 'salary_min' => 10417.00, 'salary_max' => 16667.00, 'fixed' => 0.00, 'c_level' => 10417.00, 'c_percent' => 15.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 15, 'create_date' => '2023-06-29 07:58:20', 'edit_date' => '2023-06-29 07:58:20', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Semi-Monthly', 'salary_min' => 16667.00, 'salary_max' => 33333.00, 'fixed' => 937.50, 'c_level' => 16667.00, 'c_percent' => 20.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 16, 'create_date' => '2023-06-29 07:59:06', 'edit_date' => '2023-06-29 07:59:06', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Semi-Monthly', 'salary_min' => 33333.00, 'salary_max' => 333333.00, 'fixed' => 4270.70, 'c_level' => 33333.00, 'c_percent' => 25.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 17, 'create_date' => '2023-06-29 08:00:20', 'edit_date' => '2023-06-29 08:00:20', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Semi-Monthly', 'salary_min' => 83333.00, 'salary_max' => 333333.00, 'fixed' => 16770.70, 'c_level' => 83333.00, 'c_percent' => 30.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 18, 'create_date' => '2023-06-29 08:01:54', 'edit_date' => '2023-06-29 08:01:54', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Semi-Monthly', 'salary_min' => 333333.00, 'salary_max' => 9999999.00, 'fixed' => 91770.70, 'c_level' => 333333.00, 'c_percent' => 35.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 19, 'create_date' => '2023-06-29 07:53:24', 'edit_date' => '2023-06-29 07:53:24', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Monthly', 'salary_min' => 0.00, 'salary_max' => 20833.00, 'fixed' => 0.00, 'c_level' => 0.00, 'c_percent' => 0.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 20, 'create_date' => '2023-06-29 07:57:34', 'edit_date' => '2023-06-29 07:57:34', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Monthly', 'salary_min' => 20833.00, 'salary_max' => 33333.00, 'fixed' => 0.00, 'c_level' => 20833.00, 'c_percent' => 15.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 21, 'create_date' => '2023-06-29 07:58:20', 'edit_date' => '2023-06-29 07:58:20', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Monthly', 'salary_min' => 33333.00, 'salary_max' => 66667.00, 'fixed' => 1875.00, 'c_level' => 33333.00, 'c_percent' => 20.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 22, 'create_date' => '2023-06-29 07:59:06', 'edit_date' => '2023-06-29 07:59:06', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Monthly', 'salary_min' => 66667.00, 'salary_max' => 166667.00, 'fixed' => 8541.80, 'c_level' => 66667.00, 'c_percent' => 25.00, 'status' => 'Active']);
        $this->db->insert('tbl_payroll_tax', ['id' => 23, 'create_date' => '2023-06-29 08:00:20', 'edit_date' => '2023-06-29 08:00:20', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Monthly', 'salary_min' => 166667.00, 'salary_max' => 666667.00, 'fixed' => 33541.80, 'c_level' => 166667.00, 'c_percent' => 30.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_payroll_tax', ['id' => 24, 'create_date' => '2023-06-29 08:01:54', 'edit_date' => '2023-06-29 08:01:54', 'edit_user' => 68, 'is_deleted' => 0, 'year' => 2024, 'pay_frequency' => 'Monthly', 'salary_min' => 666667.00, 'salary_max' => 9999999.00, 'fixed' => 183541.80, 'c_level' => 666667.00, 'c_percent' => 35.00, 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 1, 'create_date' => '2024-01-03 10:33:48', 'edit_date' => '2024-01-03 10:33:48', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-01-01', 'name' => 'New Year\'s Day', 'col_holi_type' => 'Regular Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 2, 'create_date' => '2024-01-03 10:35:53', 'edit_date' => '2024-01-03 10:35:53', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-02-10', 'name' => 'Chinese New Year', 'col_holi_type' => 'Special Non-Working Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 3, 'create_date' => '2024-01-03 10:38:25', 'edit_date' => '2024-01-03 10:38:25', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-03-28', 'name' => 'Maundy Thursday', 'col_holi_type' => 'Regular Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 4, 'create_date' => '2024-01-03 10:38:50', 'edit_date' => '2024-01-03 10:38:50', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-03-29', 'name' => 'Good Friday', 'col_holi_type' => 'Regular Holiday', 'year' => '2024', 'status' => 'Active']);
        $this->db->insert('tbl_std_holidays', ['id' => 5, 'create_date' => '2024-01-03 10:39:45', 'edit_date' => '2024-01-03 10:39:45', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-03-30', 'name' => 'Black Saturday', 'col_holi_type' => 'Special Non-Working Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 6, 'create_date' => '2024-01-03 10:40:36', 'edit_date' => '2024-01-03 10:40:36', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-04-09', 'name' => 'Araw ng Kagitingan', 'col_holi_type' => 'Regular Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 7, 'create_date' => '2024-01-03 10:41:04', 'edit_date' => '2024-01-03 10:41:04', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-05-01', 'name' => 'Labor Day', 'col_holi_type' => 'Regular Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 8, 'create_date' => '2024-01-03 10:41:34', 'edit_date' => '2024-01-03 10:41:34', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-06-12', 'name' => 'Independence Day', 'col_holi_type' => 'Regular Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 9, 'create_date' => '2024-01-03 10:42:14', 'edit_date' => '2024-01-03 10:42:14', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-08-21', 'name' => 'Ninoy Aquino Day', 'col_holi_type' => 'Special Non-Working Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 10, 'create_date' => '2024-01-03 10:42:46', 'edit_date' => '2024-01-03 10:42:46', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-08-26', 'name' => 'National Heroes Day', 'col_holi_type' => 'Regular Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 11, 'create_date' => '2024-01-03 10:45:22', 'edit_date' => '2024-01-03 10:45:22', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-11-01', 'name' => 'All Saints\' Day', 'col_holi_type' => 'Special Non-Working Holiday', 'year' => '2024', 'status' => 'Active']);
        $this->db->insert('tbl_std_holidays', ['id' => 12, 'create_date' => '2024-01-03 10:46:03', 'edit_date' => '2024-01-03 10:46:03', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-11-02', 'name' => 'All Souls\' Day', 'col_holi_type' => 'Special Non-Working Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 13, 'create_date' => '2024-01-03 10:46:37', 'edit_date' => '2024-01-03 10:46:37', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-11-30', 'name' => 'Bonifacio Day', 'col_holi_type' => 'Regular Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 14, 'create_date' => '2024-01-03 10:48:17', 'edit_date' => '2024-01-03 10:48:17', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-12-08', 'name' => 'Feast of the Immaculate Concepcion of Mary', 'col_holi_type' => 'Special Non-Working Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 15, 'create_date' => '2024-01-03 10:48:58', 'edit_date' => '2024-01-03 10:48:58', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-12-24', 'name' => 'Christmas Eve', 'col_holi_type' => 'Special Non-Working Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 16, 'create_date' => '2024-01-03 10:49:21', 'edit_date' => '2024-01-03 10:49:21', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-12-25', 'name' => 'Christmas Day', 'col_holi_type' => 'Regular Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 17, 'create_date' => '2024-01-03 10:49:44', 'edit_date' => '2024-01-03 10:49:44', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-12-30', 'name' => 'Rizal Day', 'col_holi_type' => 'Regular Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_std_holidays', ['id' => 18, 'create_date' => '2024-01-03 10:50:29', 'edit_date' => '2024-01-03 10:50:29', 'edit_user' => 1, 'is_deleted' => 0, 'col_holi_date' => '2024-12-31', 'name' => 'Last Day of the Year', 'col_holi_type' => 'Special Non-Working Holiday', 'year' => '2024', 'status' => 'Active']);
        
        $this->db->insert('tbl_system_useraccess', ['id' => 1, 'create_date' => '2023-01-26 19:28:13', 'edit_date' => '2023-12-19 09:26:59', 'edit_user' => 0, 'is_deleted' => 0, 'user_access' => 'Default', 'user_page' => 'My Profile, My Attendance Record, My Complaints, My Leaves, My Loans, My Overtimes, My Time Adjustments, My Payslips, My Onboarding, My Survey, Overtime Approval, Time Adjustment Approval, My Team, My Calendar, My Tasks, Remote Attendance, My Support Requests, My Warnings, My Trainings, Activity Logs, Notifications, Leave Approval, My Holiday Work, Holiday Work Approval, Company-About the Company, Company Announcements, Company Policies, Organizational Chart, Company Holidays, Company Knowledge Base, Employee Directory, Allowance Assignment, Taxable Allowance, Taxable Deduction, Deduction Assignment, Skill Assignment, Non-Taxable Allowance, Non-Taxable Deduction, Salary Details, Attendance Records, Attendance Summary, Daily Attendance, Work Shifts, Shift Template, Shift Assignment, Zkteco Code, Import Attendance, Attendance Holidays, Overtime Requests, Time Adjustment List, Offset Request, Overtime Approval Route, Zkteco Attendance, Holiday Work, Leave Request, Leave Entitlement, Leave Approval Route, Leave Types, Overtime-Overtime Request, Overtime-Holiday Work, Promoted Employees, Payslip Generator, Company Contributions, Deductions, Other Deductions, Cash Advance, 13th Month Pay, Reimbursement, Loans, Custom Contributions, Withholding Tax, Payroll Payslips, Payroll Schedule, SSS Rates, Philhealth Rates, HDMF Rates, Custom SSS Contribution, Custom Pagibig Contibution, Custom Philhealth Contribution, Attendance Records Lock, Payroll Assignment, Payroll Summary, Dynamic Benefits, Earnings, Loans Benefits, Adjustments Benefits, Access Management, Home Settings, Activity Logs(Admin), General Settings, User Accessibility, Standard Settings, Company Structure, IP Address', 'user_modules' => 'selfservices_modules, company_modules, employee_modules, attendance_modules, leave_modules, overtime_modules, report_modules, payroll_modules, benefits_modules, administrator_modules']);
        $this->db->insert('tbl_system_useraccess', ['id' => 2, 'create_date' => '2023-01-26 19:28:13', 'edit_date' => '2023-12-19 10:55:24', 'edit_user' => 0, 'is_deleted' => 0, 'user_access' => 'Staff', 'user_page' => 'My Profile, My Attendance Record, My Complaints, My Leaves, My Loans, My Overtimes, My Time Adjustments, My Payslips, My Onboarding, My Survey, Overtime Approval, Time Adjustment Approval, My Team, My Calendar, My Tasks, Remote Attendance, My Support Requests, My Warnings, My Trainings, Activity Logs, Notifications, Leave Approval, My Holiday Work, Holiday Work Approval', 'user_modules' => 'selfservices_modules']);
        
        $this->db->insert('tbl_system_useraccess', ['id' => 3, 'create_date' => '2023-01-26 19:28:13', 'edit_date' => '2023-12-21 18:12:36', 'edit_user' => 0, 'is_deleted' => 0, 'user_access' => 'Administrator', 'user_page' => 'My Profile, My Attendance Record, My Complaints, My Leaves, My Loans, My Overtimes, My Time Adjustments, My Payslips, My Onboarding, My Survey, Overtime Approval, Time Adjustment Approval, My Team, My Calendar, My Tasks, Remote Attendance, My Support Requests, My Warnings, My Trainings, Activity Logs, Notifications, Leave Approval, My Holiday Work, Holiday Work Approval, Company-About the Company, Company Announcements, Company Policies, Organizational Chart, Company Holidays, Company Knowledge Base, Employee Directory, Allowance Assignment, Approval Route, Manage Salary, Setup Organizational Chart, Deduction Assignment, Skill Assignment, Non-Taxable Allowance, Non-Taxable Deduction, Salary Details, Attendance Records, Attendance Summary, Daily Attendance, Work Shifts, Shift Template, Shift Assignment, Zkteco Code, Import Attendance, Attendance Holidays, Overtime Requests, Time Adjustment List, Offset Request, Overtime Approval Route, Zkteco Attendance, Holiday Work, Leave Request, Leave Entitlement, Leave Approval Route, Leave Types, Overtime-Overtime Request, Overtime-Holiday Work, Apply Leaves, Apply Overtimes, Apply Time Adjustments, Apply Holiday Works, Promoted Employees, Payslip Generator, Company Contributions, Deductions, Other Deductions, Cash Advance, 13th Month Pay, Reimbursement, Loans, Custom Contributions, Withholding Tax, Payroll Payslips, Payroll Schedule, SSS Rates, Philhealth Rates, HDMF Rates, Custom SSS Contribution, Custom Pagibig Contribution, Custom Philhealth Contribution, Attendance Records Lock, Payroll Assignment, Payroll Summary, HR Dashboard, HR Announcements, HR Warnings, HR Support, HR Reports, HR Policies, HR About the Company, HR Welcome Messages, HR Forms, HR Complaint, HR Starter Guide, HR Survey, HR Knowledge Base, HR Events, Dynamic Benefits, Earnings, Loans Benefits, Adjustments Benefits, Access Management, Home Settings, General Settings, User Accessibility, Standard Settings, Company Structure, IP Address', 'user_modules' => 'selfservices_modules, company_modules, employee_modules, attendance_modules, leave_modules, overtime_modules, team_modules, report_modules, payroll_modules, hr_modules, benefits_modules, administrator_modules']);
        
        $this->db->insert('tbl_system_setup', ['id' => 1, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-03-15 22:48:13', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'CopanyName', 'value' => 'Eyebox HRMS']);
        
        $this->db->insert('tbl_system_setup', ['id' => 2, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-05 21:14:02', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'loginLogo', 'value' => '652cb86752c01_logo-2.png']);
        
        $this->db->insert('tbl_system_setup', ['id' => 3, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-01-26 19:16:21', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'navbarLogo', 'value' => '652cb86752c01_logo-2.png']);
        
        $this->db->insert('tbl_system_setup', ['id' => 4, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-05 21:36:56', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'headerLogo', 'value' => '652cb86752c01_logo-2.png']);
        
        $this->db->insert('tbl_system_setup', ['id' => 5, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-01-26 19:16:21', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'mobileBanner', 'value' => 'mobile_banner.jpg']);
        $this->db->insert('tbl_system_setup', ['id' => 6, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-01-26 19:16:21', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'desktopBanner', 'value' => 'desktop_banner.jpg']);
        
        $this->db->insert('tbl_system_setup', ['id' => 7, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-03-14 18:28:39', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'Self-Service', 'value' => '1 ,My Profile ,My Time Record ,My Complaints ,My Leaves ,My Overtimes ,My Time Adjustments ,My Payslips ,My Team ,My Calendar ,My Tasks ,My Time InAndOut ,My Support Requests ,My Warnings']);
        $this->db->insert('tbl_system_setup', ['id' => 8, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-16 23:04:54', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'company', 'value' => '1 ,Company About the Company ,Company Announcements ,Company Policies ,Organizational Chart ,Company Holidays ,Company Knowledge Base']);
        
        $this->db->insert('tbl_system_setup', ['id' => 9, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-20 20:56:42', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'employee', 'value' => '1 ,Employee Directory ,Allowance Assignment ,Deduction Assignment ,Skill Assignment']);
        
        $this->db->insert('tbl_system_setup', ['id' => 10, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-03-14 18:40:03', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'hr', 'value' => 'hr_modules ,HR Announcements ,HR Warnings ,HR Support ,HR Reports ,HR Policies ,HR About the Company ,HR Complaint ,HR Survey ,HR Knowledge Base']);
        
        $this->db->insert('tbl_system_setup', ['id' => 11, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-08 21:58:21', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'attendance', 'value' => 'attendance_modules ,Attendance Records ,Daily Attendance ,Work Shifts ,Attendance Holidays ,Attendance Overtime ,Time Adjustment List ,Overtime Approval Route']);
        
        $this->db->insert('tbl_system_setup', ['id' => 12, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-16 10:06:45', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'leave', 'value' => 'Leave Leaves ,Leave Entitlement ,Leave Approval Route ,Leave Types']);
        
        $this->db->insert('tbl_system_setup', ['id' => 13, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-20 22:30:29', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'payroll', 'value' => 'payroll_modules ,Payslip Generator ,Company Contributions ,13th Month Pay ,Reimbursement ,Loans ,Payroll Schedule ,SSS Rates ,Deductions,Philhealth Rates ,HDMF Rates ,Withholding Tax']);
        $this->db->insert('tbl_system_setup', ['id' => 14, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-03-14 18:28:40', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'recruitment', 'value' => '0']);
        
        $this->db->insert('tbl_system_setup', ['id' => 15, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-20 01:04:19', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'learn&develop', 'value' => '0']);
        
        $this->db->insert('tbl_system_setup', ['id' => 16, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-20 01:04:19', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'performance', 'value' => '0']);
        
        $this->db->insert('tbl_system_setup', ['id' => 17, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-20 01:04:19', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'rewards', 'value' => '0']);
        
        $this->db->insert('tbl_system_setup', ['id' => 18, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-20 01:04:19', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'exitManagement', 'value' => '0']);
        
        $this->db->insert('tbl_system_setup', ['id' => 19, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-21 17:36:52', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'asset', 'value' => '0']);
        
        $this->db->insert('tbl_system_setup', ['id' => 20, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-03-06 19:24:47', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'projectManagement', 'value' => '0']);
        
        $this->db->insert('tbl_system_setup', ['id' => 21, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-08 23:09:23', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'administrator', 'value' => 'administrator_modules ,Access Management ,Home Settings ,User Accessibility']);
        $this->db->insert('tbl_system_setup', ['id' => 22, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-01-26 19:16:21', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'superAdmin', 'value' => '1']);
        
        $this->db->insert('tbl_system_setup', ['id' => 23, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-26 19:27:24', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'footerName', 'value' => 'Copyright © 2021-2023 Technos Systems. All Rights Reserved.']);
        
        $this->db->insert('tbl_system_setup', ['id' => 24, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-26 19:26:55', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'headerName', 'value' => 'Welcome to Eyebox HRMS']);
        
        $this->db->insert('tbl_system_setup', ['id' => 25, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-21 03:15:56', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'home_announcement', 'value' => '1']);
        
        $this->db->insert('tbl_system_setup', ['id' => 26, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-03-15 23:32:31', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'home_celebration', 'value' => '1']);
        
        $this->db->insert('tbl_system_setup', ['id' => 27, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-21 03:15:57', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'home_date', 'value' => '1']);
        
        $this->db->insert('tbl_system_setup', ['id' => 28, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-21 03:15:58', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'home_leave_info', 'value' => '1']);
        
        $this->db->insert('tbl_system_setup', ['id' => 29, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-03-15 23:32:32', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'home_whos_out', 'value' => '1']);
        
        $this->db->insert('tbl_system_setup', ['id' => 30, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-21 03:16:09', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'home_start_guide', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 31, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-03-15 23:32:30', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'home_new_member', 'value' => '1']);
        
        $this->db->insert('tbl_system_setup', ['id' => 32, 'create_date' => '2023-02-08 01:02:55', 'edit_date' => '2023-02-21 01:28:48', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'starter_guide', 'value' => '0']);
        
        $this->db->insert('tbl_system_setup', ['id' => 33, 'create_date' => '2023-02-14 19:41:57', 'edit_date' => '2023-03-06 22:23:03', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'com_branch', 'value' => '0']);
        
        $this->db->insert('tbl_system_setup', ['id' => 34, 'create_date' => '2023-02-14 19:42:13', 'edit_date' => '2023-02-21 01:12:01', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'com_Department', 'value' => '1']);
        
        $this->db->insert('tbl_system_setup', ['id' => 35, 'create_date' => '2023-02-14 23:32:14', 'edit_date' => '2023-03-06 22:23:05', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'com_division', 'value' => '0']);
        
        $this->db->insert('tbl_system_setup', ['id' => 36, 'create_date' => '2023-02-14 23:32:14', 'edit_date' => '2023-02-21 01:12:04', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'com_section', 'value' => '0']);
        
        $this->db->insert('tbl_system_setup', ['id' => 37, 'create_date' => '2023-02-14 23:32:26', 'edit_date' => '2023-03-06 22:23:09', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'com_group', 'value' => '0']);
        
        $this->db->insert('tbl_system_setup', ['id' => 38, 'create_date' => '2023-02-14 23:32:26', 'edit_date' => '2023-03-06 22:23:08', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'com_team', 'value' => '0']);
        
        $this->db->insert('tbl_system_setup', ['id' => 39, 'create_date' => '2023-02-14 23:33:53', 'edit_date' => '2023-03-06 22:23:07', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'com_line', 'value' => '0']);
        
        $this->db->insert('tbl_system_setup', ['id' => 40, 'create_date' => '2023-02-14 23:33:55', 'edit_date' => '2023-02-14 23:34:56', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'messaging', 'value' => 'messaging']);
        
        $this->db->insert('tbl_system_setup', ['id' => 41, 'create_date' => '2023-02-22 23:07:35', 'edit_date' => '2023-03-16 18:41:49', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'maintenance', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 42, 'create_date' => '2023-03-16 17:28:37', 'edit_date' => '2023-03-16 18:58:31', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'time_out', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 43, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'activation', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 44, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'employers', 'value' => 'Juan Dela Cruz3']);
        $this->db->insert('tbl_system_setup', ['id' => 45, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'company', 'value' => 'ABC Company']);
        $this->db->insert('tbl_system_setup', ['id' => 46, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'employers_rep', 'value' => 'Juana Bautista']);
        $this->db->insert('tbl_system_setup', ['id' => 47, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'company_tin', 'value' => '25637485987364']);
        $this->db->insert('tbl_system_setup', ['id' => 48, 'create_date' => '2023-06-14 23:19:14', 'edit_date' => '2023-06-14 23:19:14', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'withholding_tax', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 49, 'create_date' => '2023-06-14 23:19:14', 'edit_date' => '2023-06-14 23:19:14', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'sss_contribution', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 50, 'create_date' => '2023-06-14 23:19:14', 'edit_date' => '2023-06-14 23:19:14', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'philhealth_contribution', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 51, 'create_date' => '2023-06-14 23:19:14', 'edit_date' => '2023-06-14 23:19:14', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'pagibig_contribution', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 52, 'create_date' => '2023-06-14 23:19:14', 'edit_date' => '2023-06-14 23:19:14', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'loans', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 53, 'create_date' => '2023-06-14 23:45:34', 'edit_date' => '2023-06-14 23:45:34', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'site_access', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 54, 'create_date' => '2023-06-14 23:45:34', 'edit_date' => '2023-06-14 23:45:34', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'remote_attendance', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 55, 'create_date' => '2023-06-14 23:45:34', 'edit_date' => '2023-06-14 23:45:34', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'forgot_password', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 56, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'in_out_count', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 57, 'create_date' => '2023-07-24 15:57:22', 'edit_date' => '2023-07-24 15:57:22', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'ip_address', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 58, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'reports', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 59, 'create_date' => '2023-09-12 09:47:28', 'edit_date' => '2023-09-12 09:47:28', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'com_company', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 60, 'create_date' => '2023-09-14 16:40:44', 'edit_date' => '2023-09-14 16:40:44', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'vacation_leave', 'value' => '3']);
        $this->db->insert('tbl_system_setup', ['id' => 61, 'create_date' => '2023-09-14 16:41:56', 'edit_date' => '2023-09-14 16:41:56', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'sick_leave', 'value' => '15']);
        $this->db->insert('tbl_system_setup', ['id' => 62, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'max_active_user', 'value' => '100']);
        $this->db->insert('tbl_system_setup', ['id' => 63, 'create_date' => '2023-09-20 16:38:23', 'edit_date' => '2023-09-20 16:38:23', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'benefits', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 64, 'create_date' => '2023-09-26 09:32:21', 'edit_date' => '2023-09-26 09:32:21', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'home_holiday', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 65, 'create_date' => '2023-10-03 14:36:10', 'edit_date' => '2023-10-03 14:36:10', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'leave_setting', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 66, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'overtimes', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 67, 'create_date' => '2023-10-23 15:29:50', 'edit_date' => '2023-10-23 15:29:50', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'awol', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 68, 'create_date' => '2023-10-23 16:03:16', 'edit_date' => '2023-10-23 16:03:16', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'lwop', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 69, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'maiya_reset', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 70, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'eyebox_reset', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 71, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'home_my_time_record', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 72, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'home_attendance_summary', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 73, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'home_requests', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 74, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'home_approval', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 75, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'home_upcoming_holidays', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 76, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'remoteCamera', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 77, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'remoteGPS', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 78, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'requireApprovers', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 79, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'employers_add', 'value' => '245 Trump Tower 234 ST.Pan']);
        $this->db->insert('tbl_system_setup', ['id' => 80, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'employers_email', 'value' => 'test@e3mail.com']);
        $this->db->insert('tbl_system_setup', ['id' => 81, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'rdo_code', 'value' => '124']);
        $this->db->insert('tbl_system_setup', ['id' => 82, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'company_website', 'value' => 'web4site.com']);
        $this->db->insert('tbl_system_setup', ['id' => 83, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'employers_zip_code', 'value' => '1245']);
        $this->db->insert('tbl_system_setup', ['id' => 84, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'employers_sss', 'value' => '1234567891234']);
        $this->db->insert('tbl_system_setup', ['id' => 85, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'employers_tel_num', 'value' => '5558374635']);
        $this->db->insert('tbl_system_setup', ['id' => 86, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'employers_mob_num', 'value' => '09505002103']);
        $this->db->insert('tbl_system_setup', ['id' => 87, 'create_date' => '2023-01-26 19:16:21', 'edit_date' => '2023-02-16 10:06:45', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'offset', 'value' => 'Offset Offsets ,Offset Entitlement ,Offset Approval Route ,Offset Types']);
        $this->db->insert('tbl_system_setup', ['id' => 88, 'create_date' => '2023-10-03 14:36:10', 'edit_date' => '2023-10-03 14:36:10', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'offset_setting', 'value' => '1']);
        $this->db->insert('tbl_system_setup', ['id' => 89, 'create_date' => '2023-09-14 16:40:44', 'edit_date' => '2023-09-14 16:40:44', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'offset_vacation_leave', 'value' => '5']);
        $this->db->insert('tbl_system_setup', ['id' => 90, 'create_date' => '2023-09-14 16:41:56', 'edit_date' => '2023-09-14 16:41:56', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'offset_sick_leave', 'value' => '17']);
        $this->db->insert('tbl_system_setup', ['id' => 91, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'teams', 'value' => '']);
        $this->db->insert('tbl_system_setup', ['id' => 92, 'create_date' => '2023-12-17 16:41:56', 'edit_date' => '2023-12-17 16:41:56', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'system_administrator', 'value' => '2']);
        $this->db->insert('tbl_system_setup', ['id' => 93, 'create_date' => '2023-12-17 16:41:56', 'edit_date' => '2023-12-17 16:41:56', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'hr_administrator', 'value' => '4']);
        $this->db->insert('tbl_system_setup', ['id' => 94, 'create_date' => '2023-12-17 16:41:56', 'edit_date' => '2023-12-17 16:41:56', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'payroll_administrator', 'value' => '5']);
        $this->db->insert('tbl_system_setup', ['id' => 95, 'create_date' => '2023-12-17 16:41:56', 'edit_date' => '2023-12-17 16:41:56', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'allow_admin_access_payroll', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 96, 'create_date' => '2023-12-17 16:41:56', 'edit_date' => '2023-12-17 16:41:56', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'allow_payroll_access_hr', 'value' => '0']);
        $this->db->insert('tbl_system_setup', ['id' => 97, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'min_hours_present', 'value' => '6']);
        $this->db->insert('tbl_system_setup', ['id' => 98, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'payroll_rankandfile', 'value' => '']);
        $this->db->insert('tbl_system_setup', ['id' => 99, 'create_date' => '0000-00-00 00:00:00', 'edit_date' => '0000-00-00 00:00:00', 'edit_user' => 0, 'is_deleted' => 0, 'setting' => 'payroll_managers', 'value' => '']);
        $this->db->insert('tbl_employee_infos', [
            'id' => 1,
            'create_date' => '0000-00-00 00:00:00',
            'edit_date' => '2024-01-03 16:29:10',
            'edit_user' => 1,
            'is_deleted' => 0,
            'col_empl_cmid' => 'ABC00001',
            'isRegular' => 0,
            'disabled' => 0,
            'real_pass' => 1,
            'remote_att' => 1,
            'reporting_to' => NULL,
            'col_user_name' => 'ABC00001',
            'col_user_pass' => '$2y$10$xtA1xmRV0kfwzDMbBOQ5de6VEIKwcyAC2imV0.mMIS8RdfDxI5IK2',
            'col_salt_key' => '$2y$10$mAZOFfDPQtTO3LM8jvIMHeAHFqclhWu9eL0rXUChiEuzVSYo/znAO',
            'col_user_type' => '',
            'col_user_access' => 3,
            'col_user_date' => '2023-08-24 10:19:39',
            'col_last_name' => 'Ñunez',
            'col_midl_name' => 'Arnold',
            'col_frst_name' => 'John Tristan',
            'col_suffix' => 'Jr',
            'col_mart_stat' => '5',
            'col_home_addr' => '111 Guava Court, Barangay Guadalupe, Cebu City, Cebu',
            'col_curr_addr' => '112 Guava Court, Barangay Guadalupe, Cebu City, Cebu',
            'col_imag_path' => 'Max-R_Headshot.jpg',
            'col_birt_date' => '2023-10-29',
            'col_empl_gend' => '2',
            'col_empl_nati' => '1',
            'col_shir_size' => '2',
            'col_empl_emai' => 'kevinevaristo@gmail.com',
            'col_mobl_numb' => '09274884134',
            'col_hire_date' => '2023-10-21',
            'col_hire_date' => '2023-10-21',
        'date_regular' => '2023-10-22',
        'resignation_date' => '2023-10-23',
        'resignation_reason' => 0,
        'col_endd_date' => '2023-10-24',
        'col_empl_type' => 3,
        'col_empl_posi' => 3,
        'col_empl_company' => 1,
        'col_empl_branch' => 1,
        'col_empl_dept' => 2,
        'col_empl_divi' => 2,
        'col_empl_sect' => 1,
        'col_empl_group' => 1,
        'col_empl_line' => 5,
        'col_empl_team' => 3,
        'col_empl_repo' => '',
        'col_empl_onbw' => '',
        'col_comp_emai' => '',
        'col_comp_numb' => '',
        'col_empl_hmoo' => '',
        'col_empl_hmon' => '',
        'col_empl_sssc' => '',
        'col_empl_hdmf' => '',
        'col_empl_phil' => '',
        'col_empl_btin' => '',
        'col_empl_driv' => '',
        'col_empl_naid' => '',
        'col_empl_pass' => '',
        'col_project' => '',
        'col_empl_biom_tl' => '',
        'col_empl_biom_tr' => '',
        'col_empl_biom_il' => '',
        'col_empl_biom_ir' => '',
        'salary_rate' => 756,
        'salary_type' => 'Monthly',
        'bank_name' => 'BPI',
        'branch_name' => 'Sto. Tomas',
        'account_number' => '123456',
        'account_type' => 'Payroll',
        'payment_type' => '1',
        'termination_type' => 0,
        'termination_date' => NULL,
        'termination_reason' => '',
        'password_attempt' => 0,
        'last_logged_in' => '2023-11-30 15:50:12',
        'extra_posi' => 'Lead Developer'
        ]);
            
        $this->db->insert('tbl_employee_infos', [
            'id' => 2,
            'create_date' => '0000-00-00 00:00:00',
            'edit_date' => '2024-01-03 16:25:58',
            'edit_user' => 1,
            'is_deleted' => 0,
            'col_empl_cmid' => 'ABC00002',
            'isRegular' => 0,
            'disabled' => 0,
            'real_pass' => 1,
            'remote_att' => 1,
            'reporting_to' => '1',
            'col_user_name' => 'ABC00002',
            'col_user_pass' => '$2y$10$0aKYvpT0cDiQKlwvjaVifuIf4Aj6FtsciGZZKnlb5yXyvav5oy5d2',
            'col_salt_key' => '$2y$10$lD4d6NxIs948OZUgwqzJ/ewAeRT7HM4SBbG9u.sb.0PZMNydsmk8G',
            'col_user_type' => '',
            'col_user_access' => 3,
            'col_user_date' => '2023-08-24 10:19:39',
            'col_last_name' => 'Doe',
            'col_last_name' => 'Ñunez',
            'col_midl_name' => 'Arnold',
            'col_frst_name' => 'John Tristan',
            'col_suffix' => 'Jr',
            'col_mart_stat' => '5',
            'col_home_addr' => '111 Guava Court, Barangay Guadalupe, Cebu City, Cebu',
            'col_curr_addr' => '112 Guava Court, Barangay Guadalupe, Cebu City, Cebu',
            'col_imag_path' => 'Max-R_Headshot.jpg',
            'col_birt_date' => '2023-10-29',
            'col_empl_gend' => '2',
            'col_empl_nati' => '1',
            'col_shir_size' => '2',
            'col_empl_emai' => 'kevinevaristo@gmail.com',
            'col_mobl_numb' => '09274884134',
            'col_hire_date' => '2023-10-21',
            'date_regular' => NULL,
            'resignation_date' => NULL,
            'resignation_reason' => '',
            'col_endd_date' => '2023-02-02',
            'col_empl_type' => 0,
            'col_empl_posi' => '2023-02-02',
            'col_empl_company' => 1,
            'col_empl_branch' => 1,
            'col_empl_dept' => 0,
            'col_empl_divi' => 2,
            'col_empl_sect' => 1,
            'col_empl_group' => 1,
            'col_empl_line' => 1,
            'col_empl_team' => 2,
            'col_empl_repo' => 2,
            'col_empl_onbw' => 2,
            'col_comp_emai' => 'example@example.com',
            'col_comp_numb' => '',
            'col_empl_hmoo' => '',
            'col_empl_hmon' => '',
            'col_empl_sssc' => '',
            'col_empl_hdmf' => 4,
            'col_empl_phil' => 'Daily',
            'col_empl_btin' => '',
            'col_empl_driv' => '',
            'col_empl_naid' => '',
            'col_empl_pass' => '',
            'col_project' => '',
            'col_empl_biom_tl' => '',
            'col_empl_biom_tr' => '',
            'col_empl_biom_il' => '',
            'col_empl_biom_ir' => '',
            'salary_rate' => 0,
            'salary_type' => '',
            'bank_name' => '',
            'branch_name' => '',
            'account_number' => '0',
            'account_type' => '',
            'payment_type' => '',
            'termination_type' => '0',
            'termination_date' => '',
            'termination_reason' => '',
            'password_attempt' => '0',
            'last_logged_in' => '',
            'extra_posi' => NULL
        
        ]);
        $this->db->insert('tbl_employee_infos', [
            'id' => 3,
            'create_date' => '0000-00-00 00:00:00',
            'edit_date' => '2024-01-03 16:25:58',
            'edit_user' => 1,
            'is_deleted' => 0,
            'col_empl_cmid' => 'ABC00003',
            'isRegular' => 0,
            'disabled' => 0,
            'real_pass' => 1,
            'remote_att' => 0,
            'reporting_to' => '1',
            'col_user_name' => 'ABC00003',
            'col_user_pass' => '$2y$10$VqcqvUtP4Jx08pyn3anq0.Y9Dv1PP/ueJ428Xe8zPZXzZzp4AHbyK',
            'col_salt_key' => '$2y$10$yLOezCRgJ.jio58B..OEp.8UjEyitHUSEuuOcrSWH5M2JRbxdQypK',
            'col_user_type' => '',
            'col_user_access' => 2,
            'col_user_date' => '2023-08-24 10:19:39',
            'col_last_name' => 'Hufancia',
            'col_midl_name' => 'Daco',
            'col_frst_name' => 'Joseph',
            'col_suffix' => '',
            'col_mart_stat' => '5',
            'col_home_addr' => '888 Watermelon Lane, Barangay Banilad, Cebu City, Cebu',
            'col_curr_addr' => '889 Watermelon Lane, Barangay Banilad, Cebu City, Cebu',
            'col_imag_path' => '3.png',
            'col_birt_date' => '0000-00-00',
            'col_empl_gend' => '1',
            'col_empl_nati' => '1',
            'col_shir_size' => '3',
            'col_empl_emai' => 'lumonicatrinidad@gmail.com',
            'col_mobl_numb' => '09192327586',
            'col_hire_date' => '2023-02-02',
            'date_regular' => '2023-02-02',
            'resignation_date' => '2023-02-02',
            'resignation_reason' => '',
            'col_endd_date' => '2023-02-02',
            'col_empl_type' => 0,
            'col_empl_posi' => 0,
            'col_empl_company' => 0,
            'col_empl_branch' => 0,
            'col_empl_dept' => 0,
            'col_empl_divi' => 0,
            'col_empl_sect' => 0,
            'col_empl_group' => 0,
            'col_empl_line' => 0,
            'col_empl_team' => 0,
            'col_empl_repo' => 0,
            'col_empl_onbw' => 0,
            'col_comp_emai' => '',
            'col_comp_numb' => '',
            'col_empl_hmoo' => '',
            'col_empl_hmon' => '',
            'col_empl_sssc' => '',
            'col_empl_hdmf' => '',
            'col_empl_phil' => '',
            'col_empl_btin' => '',
            'col_empl_driv' => '',
            'col_empl_naid' => '',
            'col_empl_pass' => '',
            'col_project' => '',
            'col_empl_biom_tl' => '',
            'col_empl_biom_tr' => '',
            'col_empl_biom_il' => '',
            'col_empl_biom_ir' => '',
            'salary_rate' => 0,
            'salary_type' => '',
            'bank_name' => '',
            'branch_name' => '',
            'account_number' => '',
            'account_type' => '',
            'payment_type' => '',
            'termination_type' => 0,
            'termination_date' => NULL,
            'termination_reason' => '',
            'password_attempt' => 0,
            'last_logged_in' => NULL,
            'extra_posi' => '']);
            $this->db->insert('tbl_system_user_admin', ['id' => 1, 'create_date' => '0000-00-00 00:00:00', 'username' => 'administrator', 'password' => 'Technos@123']);
        
    
    }

    function INSERT_CUT_OFF()
    {
        $today          = date('Y-m-d');

        $year           = date('Y');
        $month          = date('m');
        $firstday       = date('d');
        $lastday        = date('t');

        $month_name     = substr(date('F'),0,3);
        
        $name           = $month_name . ' 1 - ' . $month_name . ' '. $lastday;
        $date_from      = date('Y-m-1');
        $date_to        = date('Y-m-t');
        $date_payout    = date('Y-m-t');
        $date_today     = date('Y-m-d H:i:s');

      $sql = "INSERT INTO `tbl_payroll_period` (`id`, `create_date`, `edit_date`, `edit_user`, `is_deleted`, `name`, `date_from`, `date_to`, `payout`, `status`, `connected_period`, `connected_period_2`, `connected_period_3`, `connected_period_4`, `connected_period_5`, `db_name`, `year`, `pay_frequency`) VALUES
        (1, '$date_today', '$date_today', 1, 0, '$name', '$date_from', '$date_to', '$date_payout', 'Active', 0, 0, 0, 0, 0, NULL, 2023, 'Semi-Monthly')";
        $query = $this->db->query($sql, array());

    }

    function get_system_setup_by_setting($setting){

        $query = "SELECT * FROM tbl_system_setup WHERE setting=?";

        return $this->db->query($query, array($setting))->row_array();

    }

    function DB_RESET($db_name)
    {
        return $this->db->truncate($db_name);
    }

    function GET_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'Self-Service'";
        return $this->db->query($query)->row_array();
    }

    function GET_COMPANY_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'company'";
        return $this->db->query($query)->row_array();
    }

    function GET_TEAMS_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'teams'";
        return $this->db->query($query)->row_array();
    }

    function GET_BENEFITS_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'benefits'";
        return $this->db->query($query)->row_array();
    }

    function GET_EMPLOYEE_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'employee'";
        return $this->db->query($query)->row_array();
    }

    function GET_HR_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'hr'";
        return $this->db->query($query)->row_array();
    }

    function GET_ATTENDANCE_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'attendance'";
        return $this->db->query($query)->row_array();
    }

    function GET_LEAVE_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'leave'";
        return $this->db->query($query)->row_array();
    }

    function GET_PAYROLL_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'payroll'";
        return $this->db->query($query)->row_array();
    }

    function GET_REC_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'recruitment'";
        return $this->db->query($query)->row_array();
    }

    function GET_LEARN_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'learn&develop'";
        return $this->db->query($query)->row_array();
    }

    function GET_PERFORMANCE_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'performance'";
        return $this->db->query($query)->row_array();
    }

    function GET_REWARDS_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'rewards'";
        return $this->db->query($query)->row_array();
    }

    function GET_EXIT_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'exitManagement'";
        return $this->db->query($query)->row_array();
    }

    function GET_ASSET_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'asset'";
        return $this->db->query($query)->row_array();
    }

    function GET_PROJ_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'projectManagement'";
        return $this->db->query($query)->row_array();
    }

    function GET_ADMIN_STATUS()
    {
        $query = "SELECT id,value FROM tbl_system_setup WHERE setting = 'administrator'";
        return $this->db->query($query)->row_array();
    }
    function GET_SYSTEM_SETUP($setting){
        $this->db->select('id,value');
        $this->db->where('setting',$setting);
        $query=$this->db->get('tbl_system_setup');
        return $query->row_array();
    }
    function MOD_UPDATE_STATUS($stat, $id)
    {
        $sql = "UPDATE tbl_system_setup SET value=? WHERE id=?";
        $query = $this->db->query($sql, array($stat, $id));
    }
    
    function GET_MAINTENANCE()
    {
        $sql = "SELECT * FROM tbl_system_setup";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_TIME_OUT()
    {
        $sql = "SELECT id,value FROM tbl_system_setup WHERE setting='time_out'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->row();
    }
    function checkUserPassword($username, $password)
    {
        $sql = "SELECT * FROM tbl_system_user_admin WHERE username=? AND password=?";
        $query = $this->db->query($sql, array($username, $password));
        if ($query->num_rows() > 0) {
            return true; 
        } else {
            return false;
        }
    }

    function UPDATE_SYSTEM_SETUP_VALUE($setting, $value){
        $sql = "UPDATE tbl_system_setup SET value=? WHERE setting=?";
        $query = $this->db->query($sql, array($value, $setting));
    }

    function UPDATE_HOME_SETTINGS($settings){
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

    function MOD_UPDATE_TIME_OUT($id, $value)
    {
        $sql = "UPDATE tbl_system_setup SET value=? WHERE id=?";
        $query = $this->db->query($sql, array($value, $id));
    }

    function MOD_INSRT_ANNOUNCEMENTS($attachment)
    {
        $sql = "INSERT INTO tbl_test (attachment) VALUES (?)";
        $query = $this->db->query($sql, array($attachment));
        return $query;
    }

    function TRUNCATE_DATABASE_TABLE($table_name)
    {
        return $this->db->query('TRUNCATE TABLE ' . $table_name);
    }
    
    function INSERT_DEFAULT_DATA($table_name, $data)
    {
        return $this->db->insert_batch($table_name, $data);
    }

    function UPDATE_END_TRIAL($value, $setting){
        $selectSql = "SELECT * FROM tbl_system_setup WHERE setting=?";
        $selectQuery = $this->db->query($selectSql, array($setting));
        $result = $selectQuery->num_rows();
        if($result > 0){
            $sql = "UPDATE tbl_system_setup SET value=? WHERE setting=?";
            $query = $this->db->query($sql, array($value, $setting));
        }else{
            $insert = "INSERT INTO tbl_system_setup (setting, value) VALUES (?, ?)";
            $this->db->query($insert, array($setting,$value));
        }
    }
}
