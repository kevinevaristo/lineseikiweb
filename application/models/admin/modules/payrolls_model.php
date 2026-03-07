<?php
class payrolls_model extends CI_Model
{

    function update_settings($input_data)
    {
        try {
            foreach ($input_data as $key => $value) {
                // $updateData = array('value' => $value);
                // if ($key === 'payroll_rankandfile' || $key === 'payroll_managers') {
                //     $value = implode(",", $value);
                // }
                $this->db->set('value', $value);
                $this->db->where('setting', $key);
                $this->db->update('tbl_system_setup');
            }
            return true;
            // return $input_data;
        } catch (Exception $e) {
            return false;
        }
    }

    function get_system_setup_by_setting($setting, $value)
    {
        $query_select = "SELECT * FROM tbl_system_setup WHERE setting=?";
        $result = $this->db->query($query_select, array($setting))->row_array();
        if (!$result) {
            $query_insert = "INSERT INTO tbl_system_setup (setting, value) VALUES (?, ?)";
            $this->db->query($query_insert, array($setting, $value));
            $query_select_new = "SELECT * FROM tbl_system_setup WHERE setting=?";
            $result = $this->db->query($query_select_new, array($setting))->row_array();
        }
        return $result ? $result['value'] : null;
    }

    public function acknowledge_payslips($payslip_ids)
    {
        if (is_array($payslip_ids) && !empty($payslip_ids)) {
            $payslip_ids = array_map('intval', $payslip_ids);

            log_message('debug', 'Payslip IDs: ' . implode(', ', $payslip_ids));

            // Update the database
            $this->db->where_in('id', $payslip_ids);
            $this->db->update('tbl_payroll_payslips', ['is_acknowledged' => 1]);

            $affected_rows = $this->db->affected_rows();
            log_message('debug', 'Affected Rows: ' . $affected_rows);

            return $affected_rows > 0;
        }
        return false;
    }

    function GET_PAYROLL_MONTHLY_CONSTANT()
    {
        $sql = "SELECT value FROM tbl_system_setup where setting = 'payroll_monthly_constant' ";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
    }

    function GET_USER_ACCESS_PAGE($id)
    {
        $query = $this->db
            ->select('user_page')
            ->where('id', $id)
            ->get('tbl_system_useraccess');
        return $query->row_array();
    }

    function GET_PAYROLL_DATA()
    {
        $date  = "SELECT MAX(payroll_period) FROM tbl_payroll_payslips";
        $sql   = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=?";
        $query = $this->db->query($sql, array($date));
        $query->next_result();
        return $query->result();
    }
    function GET_MAYA_THEME()
    {
        $query = "SELECT * FROM tbl_system_setup WHERE setting = 'maiya_reset'";
        return $this->db->query($query)->row_array();
    }
    function DELETE_PAYSLIP_DATA($ids)
    {
        $this->db->where_in('id', $ids);
        return $this->db->delete('tbl_payroll_payslips');
    }
    function UPDATE_BULK_ACTIVATE($loan_data, $table_name)
    {
        return $this->db->update_batch($table_name, $loan_data, 'id');
    }
    function GET_PAYSLIP_RECORDS($period)
    {
        $this->db->select('col_empl_cmid,col_suffix,col_last_name,col_frst_name,col_midl_name,col_empl_posi,col_empl_type,tbl_payroll_payslips.id as id');
        $this->db->from('tbl_payroll_payslips');
        $this->db->join('tbl_employee_infos', 'tbl_payroll_payslips.empl_id = tbl_employee_infos.id');
        $this->db->where('PAYSLIP_PERIOD', $period);
        $query = $this->db->get();
        return $query->result_array();
    }
    function GET_COMPANY_NAME()
    {
        $this->db->select('value');
        $this->db->from('tbl_system_setup');
        $this->db->where('id', 1);
        $query = $this->db->get();
        return $query->row();
    }
    function GET_OTHERDEDUCTIONS_DATA($payroll_id)
    {
        $sql   = "SELECT * FROM tbl_payroll_otherdeductions WHERE payroll_period = $payroll_id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_OTHERDEDUCTIONS_EMPL_DATA()
    {
        $sql   = "SELECT id,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function UPDATE_OTHERDEDUCTIONS_DATA($data, $payroll_id)
    {
        $id                             = $data[0];
        $empl_id                        = $data[1];
        $payroll_period                 = $payroll_id;
        $coop                           = $data[3];
        $vaccine                        = $data[4];
        $vac                            = $data[5];
        $funeral                        = $data[6];
        $cmcl                           = $data[7];
        $rcbc                           = $data[8];
        $canteen                        = $data[9];
        $sql = " UPDATE tbl_payroll_otherdeductions SET empl_id=?, payroll_period=?, coop=?, vaccine=?, vac=?, funeral=?, cmcl=?, rcbc=?, canteen=? WHERE id = ?";
        $this->db->query($sql, array($empl_id, $payroll_period, $coop, $vaccine, $vac, $funeral, $cmcl, $rcbc, $canteen, $id));
    }
    function INSERT_OTHERDEDUCTIONS_DATA($data, $payroll_id)
    {
        $id                             = $data[0];
        $empl_id                        = $data[1];
        $payroll_period                 = $payroll_id;
        $coop                           = $data[3];
        $vaccine                        = $data[4];
        $vac                            = $data[5];
        $funeral                        = $data[6];
        $cmcl                           = $data[7];
        $rcbc                           = $data[8];
        $canteen                        = $data[9];
        $sql = "INSERT INTO tbl_payroll_otherdeductions (empl_id, payroll_period, coop, vaccine, vac, funeral, cmcl, rcbc, canteen) VALUES (?,?,?,?,?,?,?,?,?)";
        $this->db->query($sql, array($empl_id, $payroll_period, $coop, $vaccine, $vac, $funeral, $cmcl, $rcbc, $canteen));
    }
    function GET_PAYSLIP_DATA($id)
    {
        $this->db->select('col_empl_cmid,col_suffix,col_last_name,col_frst_name,col_midl_name,col_empl_posi,col_empl_type,tbl_payroll_payslips.id as id,tbl_employee_infos.salary_type as salary_type,tbl_employee_infos.salary_rate as salary_rate,tbl_payroll_payslips.*,tbl_std_positions.name as position,tbl_std_departments.name as department,tbl_std_sections.name as section,tbl_payroll_period.name as PAYSLIP_PERIOD,tbl_payroll_period.payout as PAYSLIP_PAYOUT');
        $this->db->from('tbl_payroll_payslips');
        $this->db->join('tbl_employee_infos', 'tbl_payroll_payslips.empl_id = tbl_employee_infos.id', 'left');
        $this->db->join('tbl_std_positions', 'tbl_std_positions.id = tbl_employee_infos.col_empl_posi', 'left');
        $this->db->join('tbl_std_departments', 'tbl_std_departments.id = tbl_employee_infos.col_empl_dept', 'left');
        $this->db->join('tbl_std_sections', 'tbl_std_sections.id = tbl_employee_infos.col_empl_sect', 'left');
        $this->db->join('tbl_payroll_period', 'tbl_payroll_period.id = tbl_payroll_payslips.PAYSLIP_PERIOD', 'left');
        $this->db->where('tbl_payroll_payslips.id', $id);
        $query = $this->db->get();
        return $query->result_object();
    }
    function GET_USER_PASSWORD($id)
    {
        $sql = "SELECT col_last_name, col_birt_date FROM tbl_employee_infos WHERE id=?";
        $query = $this->db->query($sql, array($id));
        return $query->result_object();
    }
    function GET_PAYROLL_DATA_FILTER($period)
    {
        $sql   = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=?";
        $query = $this->db->query($sql, array($period));
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEE_LIST()
    {
        $sql   = "SELECT * FROM tbl_employee_infos WHERE disabled = '0' ORDER BY col_empl_cmid +0 ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEE_INFO()
    {
        $sql   = "SELECT * FROM tbl_employee_infos";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEE_INFO_SPECIFIC($empl_id)
    {
        if (!$empl_id || $empl_id == 'undefined') {
            return false;
        }
        $sql = "SELECT * FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND id = $empl_id";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_PERIOD_LIST()
    {
        $sql   = "SELECT * FROM tbl_payroll_period";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_CONNECTED_PERIOD_PREVIOUS($empl_id, $period)
    {
        $sql   = "SELECT GROSS_INCOME, SSS_EE_CURRENT, SSS_MPF_EE_CURRENT, PAGIBIG_EE_CURRENT, PHILHEALTH_EE_CURRENT, SSS_ER_CURRENT, SSS_MPF_ER_CURRENT, SSS_EC_ER_CURRENT,PAGIBIG_ER_CURRENT,PHILHEALTH_ER_CURRENT FROM tbl_payroll_payslips WHERE empl_id = '$empl_id' AND PAYSLIP_PERIOD = '$period'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_PERIOD_INFO()
    {
        $sql   = "SELECT * FROM tbl_payroll_period";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_CONN_PERIOD_INFO_SPECIFIC($id)
    {
        $sql    = "SELECT connected_period FROM tbl_payroll_period WHERE id = $id";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result->connected_period;
    }
    function GET_CONVERT_PERIOD2NAME($id)
    {
        $sql    = "SELECT name as names FROM tbl_payroll_period WHERE id = $id";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result->names;
    }
    function GET_PERIOD_LIST_LOCK()
    {
        $sql   = "SELECT DISTINCT period FROM tbl_attendance_records_lock ORDER BY period DESC"; //WHERE status = 0
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_ADJUSTMENT_BENEFITS()
    {
        $sql   = "SELECT DISTINCT name, id FROM tbl_benefits_adjustment_type WHERE is_deleted=0";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_PAYROLL_PERIOD()
    {
        $sql   = "SELECT DISTINCT id FROM tbl_payroll_period ORDER BY id DESC"; //WHERE status = 0
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_NOT_READY_PAYSLIP($peroid)
    {
        $sql   =  "SELECT id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name,
                   col_empl_posi,col_empl_type from tbl_employee_infos
                    WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
                   AND NOT EXISTS(
                   SELECT empl_id from tbl_attendance_records_lock
                   WHERE tbl_attendance_records_lock.empl_id=tbl_employee_infos.id and tbl_attendance_records_lock.period=$peroid
                   )
                   AND 
                   NOT EXISTS (
                   SELECT empl_id from tbl_payroll_payslips WHERE tbl_payroll_payslips.empl_id=tbl_employee_infos.id and
                   tbl_payroll_payslips.PAYSLIP_PERIOD = $peroid)";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result_array();
    }
    function GET_READY_PAYSLIP($period)
    {
        $sql   =  "SELECT id,col_suffix,col_empl_cmid,col_last_name,col_midl_name,col_frst_name,
                   col_empl_posi,col_empl_type FROM tbl_employee_infos
                   WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
                   AND EXISTS(
                   SELECT empl_id from tbl_attendance_records_lock
                   WHERE tbl_attendance_records_lock.empl_id=tbl_employee_infos.id and tbl_attendance_records_lock.period=$period
                   )
                   AND 
                   NOT EXISTS (
                   SELECT empl_id from tbl_payroll_payslips WHERE tbl_payroll_payslips.empl_id=tbl_employee_infos.id and
                   tbl_payroll_payslips.PAYSLIP_PERIOD= $period )";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result_array();
    }
    function GET_EMPLOYEE_LIST_LOCK($period)
    {
        if ($period == 'undefined' || empty($period)) {
            return [];
        }
        $sql   = "SELECT tbl_employee_infos.id as empl_id from tbl_employee_infos 
                  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
                  AND EXISTS(
                  SELECT empl_id from tbl_attendance_records_lock
                  WHERE tbl_attendance_records_lock.empl_id=tbl_employee_infos.id and tbl_attendance_records_lock.period=$period
                  )
                  AND 
                  NOT EXISTS (
                  SELECT empl_id from tbl_payroll_payslips WHERE tbl_payroll_payslips.empl_id=tbl_employee_infos.id and
                  tbl_payroll_payslips.PAYSLIP_PERIOD=$period
                  )";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function ADD_LOAN($loan_info)
    {
        $date = date('Y-m-d H:i:s');
        $data = array(
            'create_date'   => $date,
            'edit_date'     => $date,
            'loan_name'     => $loan_info['insrt_loan_name'],
            'loan_type'     => $loan_info['insrt_loan_type'],
            'loan_date'     => $loan_info['insrt_loan_date'],
            'loan_amount'   => $loan_info['insrt_loan_amount'],
            'loan_terms'    => $loan_info['insrt_loan_terms'],
            'empl_id'       => $loan_info['insrt_employee'],
            'initial_paid'  => $loan_info['insrt_inital_payment'],
        );
        return $this->db->insert('tbl_payroll_loan', $data);
    }
    function UPDATE_LOAN($loan_info, $id)
    {
        $date = date('Y-m-d H:i:s');
        $data = array(
            'edit_date'     => $date,
            'loan_name'     => $loan_info['insrt_loan_name'],
            'loan_type'     => $loan_info['insrt_loan_type'],
            'loan_date'     => $loan_info['insrt_loan_date'],
            'loan_amount'   => $loan_info['insrt_loan_amount'],
            'loan_terms'    => $loan_info['insrt_loan_terms'],
            'empl_id'       => $loan_info['insrt_employee'],
            'initial_paid'  => $loan_info['insrt_inital_payment'],
        );
        $this->db->where('id', $id);
        return $this->db->update('tbl_benefits_loan', $data);
    }
    function ADD_DEDUCTION($loan_info)
    {
        $date = date('Y-m-d H:i:s');
        $data = array(
            'create_date'   => $date,
            'edit_date'     => $date,
            'loan_name'     => $loan_info['insrt_name'],
            'loan_date'     => $loan_info['insrt_date'],
            'loan_amount'   => $loan_info['insrt_amount'],
            'loan_terms'    => $loan_info['insrt_terms'],
            'empl_id'       => $loan_info['insrt_employee'],
            'initial_paid'  => $loan_info['insrt_inital_payment'],
        );
        return $this->db->insert('tbl_payroll_deductions', $data);
    }
    function UPDATE_DEDUCTION($loan_info, $id)
    {
        $data = array(
            'loan_name'     => $loan_info['insrt_name'],
            'loan_date'     => $loan_info['insrt_date'],
            'loan_amount'   => $loan_info['insrt_amount'],
            'loan_terms'    => $loan_info['insrt_terms'],
            'empl_id'       => $loan_info['insrt_employee'],
            'initial_paid'  => $loan_info['insrt_inital_payment'],
        );
        $this->db->where('id', $id);
        return $this->db->update('tbl_payroll_deductions', $data);
    }
    function ADD_CASH_ADV($loan_info)
    {
        $date = date('Y-m-d H:i:s');
        $data = array(
            'create_date'   => $date,
            'edit_date'     => $date,
            'loan_name'     => $loan_info['insrt_name'],
            'loan_date'     => $loan_info['insrt_date'],
            'loan_amount'   => $loan_info['insrt_amount'],
            'loan_terms'    => $loan_info['insrt_terms'],
            'empl_id'       => $loan_info['insrt_employee'],
            'initial_paid'  => $loan_info['insrt_inital_payment'],
        );
        return $this->db->insert('tbl_payroll_cashadvance', $data);
    }
    function UPDATE_CASH_ADV($loan_info, $id)
    {
        $data = array(
            'loan_name'     => $loan_info['insrt_name'],
            'loan_date'     => $loan_info['insrt_date'],
            'loan_amount'   => $loan_info['insrt_amount'],
            'loan_terms'    => $loan_info['insrt_terms'],
            'empl_id'       => $loan_info['insrt_employee'],
            'initial_paid'  => $loan_info['insrt_inital_payment'],
        );
        $this->db->where('id', $id);
        return $this->db->update('tbl_payroll_cashadvance', $data);
    }
    function GET_SPEC_LOAN($id)
    {
        $query = $this->db
            ->select('*')
            ->where('id', $id)
            ->get('tbl_benefits_loan');
        return $query->row();
    }
    function GET_SPEC_DEDUCTION($id)
    {
        $query = $this->db
            ->select('*')
            ->where('id', $id)
            ->get('tbl_payroll_deductions');
        return $query->row();
    }
    function GET_SPEC_CASH_ADV($id)
    {
        $query = $this->db
            ->select('*')
            ->where('id', $id)
            ->get('tbl_payroll_cashadvance');
        return $query->row();
    }
    function GET_ATTENDANCE_LOCK($empl_id, $period)
    {
        if ($empl_id == 'undefined' || $period == 'undefined' || !$empl_id || !$period) {
            return false;
        }
        $sql = "SELECT * FROM tbl_attendance_records_lock WHERE empl_id = $empl_id AND period = $period";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_ATTENDANCE_LOCK_BENEFITS($id)
    {
        $sql = "SELECT type, value FROM tbl_attendance_records_lock_benefits WHERE attendance_lock_id = ?";
        $query = $this->db->query($sql, array($id));
        return $query->result();
    }
    function GET_ALL_ATTENDANCE_LOCK($period)
    {
        if ($period == 'undefined' || !$period) {
            return false;
        }
        $sql = "SELECT * FROM tbl_attendance_records_lock WHERE period = $period";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIFIC_EMPLOYEE($id)
    {
        $sql   = "SELECT col_last_name,col_frst_name,col_empl_sect,col_empl_dept,col_empl_type,col_empl_posi,col_empl_cmid FROM tbl_employee_infos WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->row();
    }
    function GET_SPECIFIC_EMPLOYEE_TYPE($id)
    {
        $sql   = "SELECT name FROM tbl_std_employeetypes WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->row();
    }
    function GET_STD_ADJUSTMENTS()
    {
        $sql   = "SELECT * FROM tbl_std_adjustments WHERE status='Active'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    // function GET_STD_TAX_ALLOWANCE_LIST()
    // {
    //     $sql   = "SELECT id,name,type FROM tbl_std_allowances_tax WHERE status='Active'";
    //     $query = $this->db->query($sql);
    //     $query->next_result();
    //     return $query->result();
    // }
    function GET_TAX_ALLOWANCE_EMPL($tax_id, $employee)
    {
        if ($employee == 'undefined' || !$employee) {
            return false;
        }
        $sql   = "SELECT value as val FROM tbl_employee_allowanceassigntax WHERE name = $tax_id AND username = $employee";
        $query = $this->db->query($sql);
        $query->next_result();
        $result = $query->result_array();
        if (empty($result)) {
            return 0;
        } else {
            return $result[0]["val"];
        }
    }
    function edit_allowance_assign_tax($EMPL_ID, $NAME, $VAL)
    {
        $sql = "UPDATE tbl_employee_allowanceassigntax SET value=? WHERE username=? AND name=?";
        $query = $this->db->query($sql, array($VAL, $EMPL_ID, $NAME));
    }
    function edit_allowance_assign_nontax($EMPL_ID, $NAME, $VAL)
    {
        $sql = "UPDATE tbl_employee_allowanceassignnontax SET value=? WHERE username=? AND name=?";
        $query = $this->db->query($sql, array($VAL, $EMPL_ID, $NAME));
    }
    function GET_STD_TAX_DEDUCTION_LIST()
    {
        $sql   = "SELECT id,name,type FROM tbl_std_deductions_tax WHERE status='Active'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_TAX_DEDUCTION_EMPL($tax_id, $employee)
    {
        if ($employee == 'undefined' || !$employee) {
            return false;
        }
        $sql   = "SELECT value as val FROM tbl_employee_deductionassigntax WHERE name = $tax_id AND username = $employee";
        $query = $this->db->query($sql);
        $query->next_result();
        $result = $query->result_array();
        if (empty($result)) {
            return 0;
        } else {
            return $result[0]["val"];
        }
    }
    // function GET_STD_NONTAX_ALLOWANCE_LIST()
    // {
    //     $sql   = "SELECT id,name,type FROM tbl_std_allowances_nontax WHERE status='Active'";
    //     $query = $this->db->query($sql);
    //     $query->next_result();
    //     return $query->result();
    // }
    function GET_NONTAX_ALLOWANCE_EMPL($tax_id, $employee)
    {
        if ($employee == 'undefined' || !$employee) {
            return false;
        }
        $sql   = "SELECT value as val FROM tbl_employee_allowanceassignnontax WHERE name = $tax_id AND username = $employee";
        $query = $this->db->query($sql);
        $query->next_result();
        $result = $query->result_array();
        if (empty($result)) {
            return 0;
        } else {
            return $result[0]["val"];
        }
    }
    function GET_STD_NONTAX_DEDUCTION_LIST()
    {
        $sql   = "SELECT id,name,type FROM tbl_std_deductions_nontax WHERE status='Active'";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_NONTAX_DEDUCTION_EMPL($tax_id, $employee)
    {
        if ($employee == 'undefined' || !$employee) {
            return false;
        }
        $sql   = "SELECT value as val FROM tbl_employee_deductionassignnontax WHERE name = $tax_id AND username = $employee";
        $query = $this->db->query($sql);
        $query->next_result();
        $result = $query->result_array();
        if (empty($result)) {
            return 0;
        } else {
            return $result[0]["val"];
        }
    }
    function GET_SPECIFIC_POSITION($id)
    {
        $sql   = "SELECT name FROM tbl_std_positions WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->row();
    }
    function GET_SPECIFIC_DEPT($id)
    {
        $sql   = "SELECT name FROM tbl_std_departments WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->row();
    }
    function GET_SPECIFIC_SECT($id)
    {
        $sql   = "SELECT name FROM tbl_std_sections WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->row();
    }
    function GET_SPECIFIC_PAYSLIP($id, $cutoff)
    {
        $sql   = "SELECT * FROM tbl_attendance_suminac WHERE user_id=? AND cut_off=? LIMIT 1";
        $query = $this->db->query($sql, array($id, $cutoff));
        $query->next_result();
        return $query->row();
    }
    function GET_PAYROLL_SCHED($year, $pay_frequency)
    {
        $this->db->select("tb1.name, tb1.id,tb2.name as year,month,pay_frequency,DATE_FORMAT(payout,'%b %d') as payout,
        CONCAT_ws(' - ',DATE_FORMAT(date_from,'%b %d'),DATE_FORMAT(date_to,'%b %d')) as date_range", false);
        $this->db->from('tbl_payroll_period as tb1');
        $this->db->join('tbl_std_years as tb2', 'tb1.year=tb2.id', 'left');
        $this->db->where('tb2.name', $year);
        $this->db->where('tb1.pay_frequency', $pay_frequency);
        $this->db->where('tb1.status', 'Active');
        $query = $this->db->get();
        return $query->result();
    }
    function GET_SPECIFIC_PAY_SCHED_DATA($pay_schedule_id)
    {
        $sql   = "SELECT * FROM tbl_payroll_period WHERE id=?";
        $query = $this->db->query($sql, array($pay_schedule_id));
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIFIC_USED_LEAVE($empl_id, $start_date, $end_date)
    {
        $sql   = "SELECT * FROM tbl_leaves_assign WHERE empl_id=? AND create_date>=? AND create_date<=? AND status='Approved' ";
        $query = $this->db->query($sql, array($empl_id, $start_date, $end_date));
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIFIC_PAID_LOAN_BASED_EMPL_AND_CUTOFF($cutoff_period, $empl_cmid)
    {
        $sql   = "SELECT * FROM tbl_loan_payable WHERE cutoff_period=? AND empl_cmid=?";
        $query = $this->db->query($sql, array($cutoff_period, $empl_cmid));
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIC_LOAN_SSS_BALANCE($empl_cmid)
    {
        $sql   = "SELECT * FROM tbl_loan_payable WHERE (loan_type='SSS Salary Loan' OR loan_type='SSS Calamity Loan') AND empl_cmid=? AND status!='Paid'";
        $query = $this->db->query($sql, array($empl_cmid));
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIFIC_LOAN_PAGIBIG_BALANCE($empl_cmid)
    {
        $sql   = "SELECT * FROM tbl_loan_payable WHERE (loan_type='Pag-ibig Salary Loan' OR loan_type='Pag-ibig Calamity Loan') AND empl_cmid=? AND status!='Paid'";
        $query = $this->db->query($sql, array($empl_cmid));
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_PAY_SCHED()
    {
        $sql   = "SELECT * FROM tbl_payroll_period WHERE status='active' ORDER BY id DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_INSRT_PAY_SCHED($date_range, $db_date_range, $payout_sched)
    {
        $sql   = "INSERT INTO tbl_payroll_period (name,db_name,payout,status) VALUES (?,?,?,'active')";
        $query = $this->db->query($sql, array($date_range, $db_date_range, $payout_sched));
        return;
    }
    function MOD_DISP_OTHERTAXABLEINCOME()
    {
        return array();
        $sql   = "SELECT * FROM tbl_payr_othe ORDER BY id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_NONTAXABLEINCOME()
    {
        return;
        $sql   = "SELECT * FROM tbl_payr_nont ORDER BY id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_PAYROLL()
    {
        $sql   = "SELECT * FROM tbl_payroll_payslips ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_PERIOD_CONNECTED($period)
    {
        if (empty($period) || $period == 'undefined') {
            return [];
        }
        $sql   = "SELECT connected_period,connected_period_2,connected_period_3,connected_period_4,connected_period_5 FROM tbl_payroll_period WHERE id = $period";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_PERIOD_NAME($period)
    {
        if (!$period || $period == 'undefined') {
            return false;
        }
        $sql    = "SELECT name FROM tbl_payroll_period WHERE id = $period";
        $query  = $this->db->query($sql, array());
        $result = $query->result_array();
        return $result[0]["name"];
    }
    function GET_PERIOD_YEAR($id)
    {
        if (empty($id) || $id == 'undefined') {
            return false;
        }
        $sql    = "SELECT year as years FROM tbl_payroll_period WHERE id = $id";
        $query  = $this->db->query($sql, array());
        $result = $query->row();
        return $result;
    }
    function GET_PERIOD_DATA($id)
    {
        if (empty($id) || $id == 'undefined') {
            return false;
        }
        $sql    = "SELECT tbl_std_years.name as year,tbl_payroll_period.pay_frequency as pay_frequency FROM tbl_payroll_period INNER JOIN tbl_std_years ON tbl_std_years.id = tbl_payroll_period.year WHERE tbl_payroll_period.id = $id";
        $query  = $this->db->query($sql, array());
        $result = $query->row();
        return $result;
    }
    function MOD_GET_PAY_SCHED_DATA($pay_schedule_id)
    {
        $sql   = "SELECT * FROM tbl_payroll_period WHERE id=?";
        $query = $this->db->query($sql, array($pay_schedule_id));
        $query->next_result();
        return $query->result();
    }
    function MOD_UPDT_PAY_SCHED($updt_date_range, $updt_db_date_range, $updt_payout_sched, $UPDT_PAY_SCHED_INPF_ID)
    {
        $sql   = "UPDATE tbl_payroll_period SET name=?,db_name=?,payout=? WHERE id=?";
        $query = $this->db->query($sql, array($updt_date_range, $updt_db_date_range, $updt_payout_sched, $UPDT_PAY_SCHED_INPF_ID));
    }
    function MOD_DLT_PAY_SCHED($pay_schedule_id)
    {
        $sql   = "UPDATE tbl_payroll_period SET status='archive' WHERE id=?";
        $query = $this->db->query($sql, array($pay_schedule_id));
    }
    function MOD_DISP_ALL_EMPLOYEES()
    {
        $sql   = "SELECT * FROM tbl_employee_infos ORDER BY LENGTH(col_empl_cmid), col_empl_cmid";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_EMP_BASED_ON_HIRE_DATE($startDate, $endDate)
    {
        $query = $this->db->select('*')->from('tbl_employee_infos')
            ->where('DATE(termination_date) > ', $startDate)
            ->or_where('DATE(termination_date)', '0000-00-00')
            ->where("disabled =", 0)
            ->get();
        return $query->result();
    }
    function MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2($limitData)
    {
        $date  = "SELECT MAX(payroll_period) FROM tbl_payroll_payslips";
        $sql   = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD = ? ORDER BY empl_id + 0";
        $query = $this->db->query($sql, array($date));
        $query->next_result();
        return $query->result();
    }
    function MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2_COUNT()
    {
        $date  = "SELECT MAX(payroll_period) FROM tbl_payroll_payslips";
        $sql   = "SELECT PAYSLIP_PERIOD FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD = ?";
        $query = $this->db->query($sql, array($date));
        $query->next_result();
        return $query->result();
    }
    function MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2_TOTAL()
    {
        $date  = "SELECT MAX(payroll_period) FROM tbl_payroll_payslips";
        $sql   = "SELECT SUM(NET_INCOME) as NET_INCOME FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD = ?";
        $query = $this->db->query($sql, array($date));
        $query->next_result();
        return $query->result();
    }
    function MOD_ALL_DISP_PAYROLL_DATA_LIMIT($date, $limitData)
    {
        $sql   = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD = ? ORDER BY empl_id + 0";
        $query = $this->db->query($sql, array($date));
        $query->next_result();
        return $query->result();
    }
    function MOD_ALL_DISP_PAYROLL_DATA_LIMIT_COUNT($date)
    {
        $sql   = "SELECT PAYSLIP_PERIOD FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD = ? ";
        $query = $this->db->query($sql, array($date));
        $query->next_result();
        return $query->result();
    }
    function MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED2_TOTAL2($date)
    {
        $sql   = "SELECT SUM(REPLACE(NET_INCOME, ',', '')) as NET_INCOME FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD = ?";
        $query = $this->db->query($sql, array($date));
        $query->next_result();
        return $query->result();
    }
    function MOD_ALL_DISP_PAYROLL_DATA_LIMIT_FILTERED($date, $limitData)
    {
        $sql   = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD = ? ORDER BY empl_id + 0";
        $query = $this->db->query($sql, array($date));
        $query->next_result();
        return $query->result();
    }
    function MON_DISP_EMPL_NO_PAYSLIP()
    {
        $sql   = "SELECT empl_id FROM (SELECT DISTINCT empl_id FROM tbl_payroll_payslips)result ORDER BY empl_id + 0";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_LOAN_PAYABLE()
    {
        $sql   = "SELECT DISTINCT loan_id FROM tbl_loan_payable ORDER BY id DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_LOAN_LIMIT_COUNT()
    {
        $sql   = "SELECT DISTINCT loan_id FROM tbl_loan_payable ORDER BY id DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_ALL_REQUEST()
    {
        $sql   = "SELECT * FROM tbl_payroll_reimbursement ORDER BY id DESC LIMIT 10";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_ALL_DATA_COUNT()
    {
        $sql   = "SELECT COUNT(id) as count FROM tbl_payroll_reimbursement";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_DEPARTMENT()
    {
        $sql = "SELECT DISTINCT col_empl_dept FROM tbl_employee_infos ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_SECTION()
    {
        $sql = "SELECT DISTINCT col_empl_sect FROM tbl_employee_infos WHERE isSuperAdmin != 1";
        $sql = "SELECT DISTINCT col_empl_sect FROM tbl_employee_infos ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_SSS()
    {
        $sql   = "SELECT * FROM tbl_payroll_sss ORDER BY year DESC LIMIT 20";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SSS_VALUE($income)
    {
        $sql   = "SELECT * FROM tbl_payroll_sss WHERE salary_min <= $income AND salary_max > $income";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SSS_VALUE_PAYSLIP($income, $year)
    {
        if($year == "2024"){
            $sql   = "SELECT * FROM tbl_payroll_sss WHERE salary_min <= $income AND salary_max > $income AND year = $year";
        }
        if($year == "2025"){
            $sql   = "SELECT * FROM tbl_payroll_sss_2025 WHERE salary_min <= $income AND salary_max > $income AND year = $year";
        }
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_PAGIBIG_VALUE_PAYSLIP($year)
    {
        $sql   = "SELECT * FROM tbl_payroll_hdmf WHERE year = $year";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_PHILHEALTH_VALUE()
    {
        $sql   = "SELECT * FROM tbl_payroll_philhealth";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_PHILHEALTH_VALUE_PAYSLIP($year)
    {
        $sql   = "SELECT * FROM tbl_payroll_philhealth WHERE year = $year";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_TAX_VALUE_PAYSLIP($income, $frequency)
    {
        $sql   = "SELECT * FROM tbl_payroll_tax WHERE salary_min <= $income AND salary_max > $income AND pay_frequency = '$frequency'";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    function GET_TAX_VALUE($income)
    {
        $sql   = "SELECT * FROM tbl_payroll_tax WHERE salary_min <= $income AND salary_max > $income";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    function MOD_DISP_DATA_COUNT()
    {
        $sql   = "SELECT COUNT(id) as anc_count FROM tbl_payroll_sss";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_UNIQUE()
    {
        $sql   = "SELECT DISTINCT year FROM tbl_payroll_sss ORDER BY year DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_PHILHEALTH()
    {
        $sql   = "SELECT * FROM tbl_contribution_philhealth ORDER BY year DESC LIMIT 20";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DATA_COUNT_PHIL_HEALTH()
    {
        $sql   = "SELECT COUNT(id) as anc_count FROM tbl_contribution_philhealth";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_UNIQUE_PHIL_HEALTH()
    {
        $sql   = "SELECT DISTINCT year FROM tbl_contribution_philhealth ORDER BY year DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_HDMF()
    {
        $sql   = "SELECT * FROM tbl_payroll_hdmf ORDER BY year DESC LIMIT 20";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DATA_COUNT_HDMF()
    {
        $sql   = "SELECT COUNT(id) as anc_count FROM tbl_payroll_hdmf";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_UNIQUE_HDMF()
    {
        $sql   = "SELECT DISTINCT year FROM tbl_payroll_hdmf ORDER BY year DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_WTH_TAX()
    {
        $sql   = "SELECT * FROM tbl_payroll_tax ORDER BY year DESC LIMIT 20";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DATA_COUNT_WITH_TAX()
    {
        $sql   = "SELECT COUNT(id) as anc_count FROM tbl_payroll_tax";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_UNIQUE_WITH_TAX()
    {
        $sql   = "SELECT DISTINCT year FROM tbl_payroll_tax ORDER BY year DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_FILTERED_EMPLOYEELIST($offset, $row, $branch, $dept, $division, $clubhouse, $section, $group, $team, $line)
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
        if ($clubhouse  == "all") {
            $clubhouse   = "col_empl_club";
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
        $sql = "SELECT id,col_suffix,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi,col_empl_club, col_empl_sect,col_empl_group,col_empl_team,col_empl_line,salary_rate,salary_type FROM tbl_employee_infos WHERE (termination_date IS NULL OR termination_date='0000-00-00') AND disabled=0
        AND col_empl_branch = $branch
        AND col_empl_dept   = $dept
        AND col_empl_divi   = $division
        -- AND col_empl_club   = $clubhouse
        AND col_empl_sect   = $section
        AND col_empl_group  = $group
        AND col_empl_team   = $team
        AND col_empl_line   = $line
        ORDER BY col_last_name ASC
        LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_SEARCHED_ALL_EMPL()
    {
        $sql = "SELECT * FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        ORDER BY col_empl_cmid +0 ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_COUNT_FILTERED_EMPLOYEE($branch, $dept, $division, $clubhouse, $section, $group, $team, $line)
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
        if ($clubhouse  == "all") {
            $clubhouse   = "col_empl_club";
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
        $sql = "SELECT id,col_empl_posi,col_empl_cmid,col_last_name,col_imag_path,col_midl_name,col_frst_name,col_empl_branch,col_empl_dept,col_empl_divi,col_empl_club, col_empl_sect,col_empl_group,col_empl_team,col_empl_line,salary_rate,salary_type FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND col_empl_branch = $branch
        AND col_empl_dept   = $dept
        AND col_empl_divi   = $division
        -- AND col_empl_club   = $clubhouse
        AND col_empl_sect   = $section
        AND col_empl_group  = $group
        AND col_empl_team   = $team
        AND col_empl_line   = $line
        ORDER BY col_empl_cmid ASC";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function GET_SEARCHED_DATA($tab, $search, $table)
    {
        $sql = "SELECT $table.*,col_empl_cmid,col_last_name,col_frst_name,col_midl_name FROM $table 
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = $table.empl_id
        WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 AND $table.status=?
        AND (tbl_employee_infos.col_empl_cmid LIKE '%$search%' 
        OR CONCAT(col_last_name, ', ', col_frst_name, ' ', col_midl_name) LIKE '%$search%'
        OR CONCAT(col_last_name, ' ', col_frst_name, ' ', col_midl_name) LIKE '%$search%'
        OR $table.id LIKE '%$search%'
        OR $table.loan_name LIKE '%$search%'
        OR $table.loan_date LIKE '%$search%'
        OR $table.loan_amount LIKE '%$search%'
        OR $table.loan_terms LIKE '%$search%'
        OR $table.status LIKE '%$search%') 
        ORDER BY $table.id ASC";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function GET_SEARCHED($search)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND (tbl_employee_infos.col_empl_cmid LIKE '%$search%' 
        OR CONCAT(col_last_name, ' ', col_frst_name, ' ', col_midl_name) LIKE '%$search%'
        OR CONCAT(col_last_name, ', ', col_frst_name, ' ', col_midl_name) LIKE '%$search%') 
        ORDER BY id ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEE_SEARCHED($search)
    {
        $sql = "SELECT * FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0
        AND tbl_employee_infos.id=?
        ORDER BY col_empl_cmid + 0 ASC";
        $query = $this->db->query($sql, array($search));
        $query->next_result();
        return $query->result();
    }
    function GET_YEARS()
    {
        $sql   = "SELECT id,name FROM tbl_std_years ORDER BY name ASC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_YEAR_NAME($id)
    {
        $sql   = "SELECT name FROM tbl_std_years WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }
    function GET_CUSTOM_CONTRIBUTION_TYPES()
    {
        $sql   = "SELECT * FROM tbl_std_custom_contribution ORDER BY id ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_COUNT_EMPLOYEELIST()
    {
        $sql   = "SELECT * FROM tbl_employee_infos ";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }
    function GET_CUSTOM_CONTRIBUTION_DATA($year)
    {
        $sql   = "SELECT year,username,name,SUM(value) as value FROM tbl_payroll_custom_contribution WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_CUSTOM_SSS_CONTRIBUTION_DATA($year)
    {
        $sql   = "SELECT * FROM tbl_custom_sss_contribution WHERE year = $year GROUP BY employee_id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_CUSTOM_PAGIBIG_CONTRIBUTION_DATA($year)
    {
        $sql   = "SELECT * FROM tbl_custom_pagibig_contribution WHERE year = $year GROUP BY employee_id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_CUSTOM_PHILHEALTH_CONTRIBUTION_DATA($year)
    {
        $sql   = "SELECT * FROM tbl_custom_philhealth_contribution WHERE year = $year GROUP BY employee_id";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_DEPARTMENT_2()
    {
        $sql   = "SELECT DISTINCT id,name FROM tbl_std_departments";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_DIVISION_2()
    {
        $sql   = "SELECT DISTINCT id,name FROM tbl_std_divisions";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_CLUBHOUSE_2()
    {
        $sql   = "SELECT DISTINCT id,name FROM tbl_std_clubhouse";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_SECTION_2()
    {
        $sql   = "SELECT DISTINCT id,name FROM tbl_std_sections";
        $query = $this->db->query($sql, array());
        if ($query->num_rows() > 0) {
            $query->next_result();
            return $query->result();
        } else {
            return [];
        }
    }
    function MOD_DISP_DISTINCT_BRANCH_2()
    {
        $sql   = "SELECT DISTINCT id,name FROM tbl_std_branches";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_GROUP_2()
    {
        $sql   = "SELECT DISTINCT id,name FROM tbl_std_groups";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_TEAM_2()
    {
        $sql   = "SELECT DISTINCT id,name FROM tbl_std_teams";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_DISP_DISTINCT_LINE_2()
    {
        $sql   = "SELECT DISTINCT id,name FROM tbl_std_lines";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SYSTEM_SETTING($setting)
    {
        $sql    = "SELECT value FROM tbl_system_setup WHERE setting = '$setting' ";
        $query  = $this->db->query($sql);
        $result = $query->row();
        return $result->value;
    }
    function IS_DUPLICATE_CUSTOM_CONTRIBUTION($user_id, $year, $type)
    {
        $sql   = "SELECT id FROM tbl_payroll_custom_contribution WHERE username=? AND year=? AND name=?";
        $query = $this->db->query($sql, array($user_id, $year, $type));
        $query->next_result();
        $data  = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }
    function ADD_USER_CUSTOM_CONTRIBUTION($user_id, $allowance_val, $year, $type)
    {
        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_payroll_custom_contribution (create_date,edit_date,username,name,value,year) VALUES(?,?,?,?,?,?)";
        return $this->db->query($sql, array($create_date, $create_date, $user_id, $type, $allowance_val, $year));
    }
    function UPDATE_USER_CUSTOM_CONTRIBUTION($user_id, $allowance_val, $year, $type)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_payroll_custom_contribution SET edit_date=?,value=? WHERE username=? AND year=? AND name=?";
        return $this->db->query($sql, array($edit_date, $allowance_val, $user_id, $year, $type));
    }
    function IS_DUPLICATE_CUSTOM_SSS_CONTRIBUTION($user_id, $year)
    {
        $sql   = "SELECT id FROM tbl_custom_sss_contribution WHERE employee_id=? AND year=?";
        $query = $this->db->query($sql, array($user_id, $year));
        $query->next_result();
        $data = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }
    function update_custom_contribution_data($data, $year)
    {
        $empl_id                = $data[0];
        $sss                    = $data[2];
        $pagibig                = $data[3];
        $philHealth             = $data[4];
        $current_date = date('Y-m-d H:i:s');
        if (!empty($sss) || $sss != "") {
            $sss_response = $this->IS_DUPLICATE_CUSTOM_SSS_CONTRIBUTION($empl_id, $year);
            if ($sss_response == 0) {
                $sql = "INSERT INTO tbl_custom_sss_contribution (create_date,edit_date,employee_id,contibution_amount,year) VALUES(?,?,?,?,?)";
                $this->db->query($sql, array($current_date, $current_date, $empl_id, $sss, $year));
            } else {
                $sql = " UPDATE tbl_custom_sss_contribution SET edit_date=?,contibution_amount=? WHERE employee_id=? AND year=? ";
                $this->db->query($sql, array($current_date, $sss, $empl_id, $year));
            }
        }
        if (!empty($pagibig) || $pagibig != "") {
            $pagibig_response = $this->IS_DUPLICATE_CUSTOM_PAGIBIG_CONTRIBUTION($empl_id, $year);
            if ($pagibig_response == 0) {
                $sql = "INSERT INTO  tbl_custom_pagibig_contribution (create_date,edit_date,employee_id,contibution_amount,year) VALUES(?,?,?,?,?)";
                $this->db->query($sql, array($current_date, $current_date, $empl_id, $pagibig, $year));
            } else {
                $sql = " UPDATE  tbl_custom_pagibig_contribution SET edit_date=?,contibution_amount=? WHERE employee_id=? AND year=? ";
                $this->db->query($sql, array($current_date, $pagibig, $empl_id, $year));
            }
        }
        if (!empty($philHealth) || $philHealth != "") {
            $philhealth_response = $this->IS_DUPLICATE_CUSTOM_PHILHEALTH_CONTRIBUTION($empl_id, $year);
            if ($philhealth_response == 0) {
                $sql = "INSERT INTO  tbl_custom_philhealth_contribution (create_date,edit_date,employee_id,contibution_amount,year) VALUES(?,?,?,?,?)";
                $this->db->query($sql, array($current_date, $current_date, $empl_id, $philHealth, $year));
            } else {
                $sql = " UPDATE  tbl_custom_philhealth_contribution SET edit_date=?,contibution_amount=? WHERE employee_id=? AND year=? ";
                $this->db->query($sql, array($current_date, $philHealth, $empl_id, $year));
            }
        }
    }
    function ADD_USER_CUSTOM_SSS_CONTRIBUTION($user_id, $val, $year)
    {
        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_custom_sss_contribution (create_date,edit_date,employee_id,contibution_amount,year) VALUES(?,?,?,?,?)";
        return $this->db->query($sql, array($create_date, $create_date, $user_id, $val, $year));
    }
    function UPDATE_USER_CUSTOM_SSS_CONTRIBUTION($user_id, $val, $year)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_custom_sss_contribution SET edit_date=?,contibution_amount=? WHERE employee_id=? AND year=? ";
        return $this->db->query($sql, array($edit_date, $val, $user_id, $year));
    }
    function IS_DUPLICATE_CUSTOM_PAGIBIG_CONTRIBUTION($user_id, $year)
    {
        $sql   = "SELECT id FROM  tbl_custom_pagibig_contribution WHERE employee_id=? AND year=?";
        $query = $this->db->query($sql, array($user_id, $year));
        $query->next_result();
        $data  = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }
    function ADD_USER_CUSTOM_PAGIBIG_CONTRIBUTION($user_id, $val, $year)
    {
        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO  tbl_custom_pagibig_contribution (create_date,edit_date,employee_id,contibution_amount,year) VALUES(?,?,?,?,?)";
        return $this->db->query($sql, array($create_date, $create_date, $user_id, $val, $year));
    }
    function UPDATE_USER_CUSTOM_PAGIBIG_CONTRIBUTION($user_id, $val, $year)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE  tbl_custom_pagibig_contribution SET edit_date=?,contibution_amount=? WHERE employee_id=? AND year=? ";
        return $this->db->query($sql, array($edit_date, $val, $user_id, $year));
    }
    function IS_DUPLICATE_CUSTOM_PHILHEALTH_CONTRIBUTION($user_id, $year)
    {
        $sql   = "SELECT id FROM tbl_custom_philhealth_contribution WHERE employee_id=? AND year=?";
        $query = $this->db->query($sql, array($user_id, $year));
        $query->next_result();
        $data  = $query->result();
        if (empty($data)) {
            return 0;
        }
        return 1;
    }
    function ADD_USER_CUSTOM_PHILHEALTH_CONTRIBUTION($user_id, $val, $year)
    {
        $create_date = date('Y-m-d H:i:s');
        $sql = "INSERT INTO  tbl_custom_philhealth_contribution (create_date,edit_date,employee_id,contibution_amount,year) VALUES(?,?,?,?,?)";
        return $this->db->query($sql, array($create_date, $create_date, $user_id, $val, $year));
    }
    function UPDATE_USER_CUSTOM_PHILHEALTH_CONTRIBUTION($user_id, $val, $year)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE  tbl_custom_philhealth_contribution SET edit_date=?,contibution_amount=? WHERE employee_id=? AND year=? ";
        return $this->db->query($sql, array($edit_date, $val, $user_id, $year));
    }
    function GET_ATTENDANCE_RECORD_LOCK($cutoff, $offset, $row)
    {
        if ($cutoff) {
            $q_find = 'WHERE period = ' . $cutoff;
        } else {
            $q_find = "";
        }
        $sql = "SELECT * FROM tbl_attendance_records_lock " . $q_find . " ORDER BY id DESC LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_COUNT_ATTENDANCE_RECORD($cutoff)
    {
        if ($cutoff) {
            $q_find = 'WHERE period = ' . $cutoff;
        } else {
            $q_find = "";
        }
        $sql   = "SELECT * FROM tbl_attendance_records_lock " . $q_find . " ORDER BY id DESC ";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }
    function GET_TOTAL_COUNT_ATTENDANCE_RECORD()
    {
        $sql   = "SELECT * FROM tbl_attendance_records_lock ";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }
    function GET_PAYROLL_PAYSLIP($cutoff, $offset, $row)
    {
        if ($cutoff) {
            $q_find = 'WHERE PAYSLIP_PERIOD = ' . $cutoff;
        } else {
            $q_find = "";
        }
        $sql   = "SELECT * FROM tbl_payroll_payslips " . $q_find . " ORDER BY id DESC LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_COUNT_PAYROLL_PAYSLIP($cutoff, $offset, $row)
    {
        if ($cutoff) {
            $q_find = 'WHERE PAYSLIP_PERIOD = ' . $cutoff;
        } else {
            $q_find = "";
        }
        $sql = "SELECT * FROM tbl_payroll_payslips " . $q_find . " ORDER BY id DESC LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql, array());
        return $query->num_rows();
    }
    function GET_CUTOFF()
    {
        $sql   = "SELECT id,name FROM tbl_payroll_period ORDER BY id DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function MOD_INSRT_PAYROLL_DATA($data)
    {
        $this->db->insert("tbl_payroll_payslips", $data);
        return true;
    }
    function MOD_PAY_LOAN_PAYABLE($amount, $empl_cmid, $cutoff_period, $loan_type)
    {
        $sql   = "UPDATE tbl_loan_payable SET status='', amount_paid=? WHERE empl_cmid=? AND cutoff_period=? AND loan_type=?";
        $query = $this->db->query($sql, array($amount, $empl_cmid, $cutoff_period, $loan_type));
    }
    function MOD_ALL_DISP_PAYROLL_DATA_PER_CUTOFF($payroll_id)
    {
        $sql   = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=?";
        $query = $this->db->query($sql, array($payroll_id));
        $query->next_result();
        return $query->result();
    }
    function MOD_GET_EMPL_READY_FOR_PAYSLIP($period_id)
    {
        $sql   = "SELECT * FROM tbl_attendance_records_lock WHERE period=?";
        $query = $this->db->query($sql, array($period_id));
        $query->next_result();
        return $query->result();
    }
    function MON_DISP_ALL_EMPL_PAYROLL($payroll_id)
    {
        $sql   = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=?";
        $query = $this->db->query($sql, array($payroll_id));
        $query->next_result();
        return $query->result();
    }
    function GET_DEDUCTION_TAX_DATA($year)
    {
        $sql   = "SELECT year,username,name,SUM(value) as value FROM tbl_employee_deductionassigntax WHERE year = $year GROUP BY name,year,username";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function UPDATE_PAYROLL_ASSIGNMENT($user_id, $value)
    {
        $edit_date = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_payroll_assignment SET edit_date=?, value=? WHERE empl_id=?";
        return $this->db->query($sql, array($edit_date, $value, $user_id));
    }
    function INSERT_PAYROLL_ASSIGNMENT($user_id, $value)
    {
        $date  = date('Y-m-d H:i:s');
        $sql   = "INSERT INTO tbl_payroll_assignment (create_date,edit_date,empl_id,value) VALUES (?,?,?,?)";
        $query = $this->db->query($sql, array($date, $date, $user_id, $value));
        return;
    }
    function update_assignment_data($data_row)
    {
        $id         =  $data_row['id'];
        $value      =  $data_row['assignment'];
        $date = date('Y-m-d H:i:s');
        $result = $this->GET_SPECIFIC_PAYROLL_ASSIGNMENT($id);
        if ($result > 0) {
            $sql = " UPDATE tbl_payroll_assignment SET edit_date=?, value=? WHERE empl_id=?";
            $this->db->query($sql, array($date, $value, $id));
        } else {
            $sql = "INSERT INTO tbl_payroll_assignment (create_date,edit_date,empl_id,value) VALUES (?,?,?,?)";
            $query = $this->db->query($sql, array($date, $date, $id, $value));
        }
    }
    function GET_ALL_PAYROLL_ASSIGNMENT()
    {
        $sql   = "SELECT * FROM tbl_payroll_assignment ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIFIC_PAYROLL_ASSIGNMENT($empl_id)
    {
        $sql   = "SELECT * FROM tbl_payroll_assignment WHERE empl_id = ?";
        $query = $this->db->query($sql, array($empl_id));
        return $query->num_rows();
    }
    function GET_PAYROLL_LOAN_DATA($tab, $row, $offset)
    {
        $sql = "SELECT *,tbl_benefits_loan.id as id FROM tbl_benefits_loan 
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_benefits_loan.empl_id
         WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 AND tbl_benefits_loan.status=? LIMIT $row OFFSET $offset";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function GET_COUNT_PAYROLL_LOAN_DATA($tab)
    {
        $sql   = "SELECT *,tbl_benefits_loan.id as id FROM tbl_benefits_loan 
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_benefits_loan.empl_id
         WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 AND tbl_benefits_loan.status=?";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function GET_SEARCHED_LOAN_DATA($tab, $search)
    {
        $sql = "SELECT tbl_payroll_loan.*,col_empl_cmid,col_last_name,col_frst_name,col_midl_name FROM tbl_payroll_loan
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_payroll_loan.empl_id
         WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 AND tbl_payroll_loan.status=?
        AND (tbl_employee_infos.col_empl_cmid LIKE '%$search%' 
        OR CONCAT(col_last_name, ', ', col_frst_name, ' ', col_midl_name) LIKE '%$search%'
        OR CONCAT(col_last_name, ' ', col_frst_name, ' ', col_midl_name) LIKE '%$search%'
        OR tbl_payroll_loan.id LIKE '%$search%'
        OR tbl_payroll_loan.loan_name LIKE '%$search%'
        OR tbl_payroll_loan.loan_date LIKE '%$search%'
        OR tbl_payroll_loan.loan_amount LIKE '%$search%'
        OR tbl_payroll_loan.loan_terms LIKE '%$search%'
        OR tbl_payroll_loan.status LIKE '%$search%') 
        ORDER BY tbl_payroll_loan.id ASC";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function GET_DATA($tab, $row, $offset, $table_name)
    {
        $sql   = "SELECT *,$table_name.id as id FROM $table_name 
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = $table_name.empl_id
        WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 AND 
        status=? ORDER BY $table_name.id DESC  LIMIT $row OFFSET $offset";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function GET_DATA_COUNT($tab, $table_name)
    {
        $sql   = "SELECT * FROM $table_name 
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = $table_name.empl_id
         WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 AND
        status=? ";
        $query = $this->db->query($sql, array($tab));
        return $query->num_rows();
    }
    function GET_PAYROLL_LOAN_DATA_COUNT($tab)
    {
        $sql   = "SELECT * FROM tbl_benefits_loan
        LEFT JOIN tbl_employee_infos ON tbl_employee_infos.id = tbl_benefits_loan.empl_id
         WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 AND status=? ";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function GET_LOAN_TYPE_DATA()
    {
        $sql   = "SELECT * FROM tbl_std_loantypes ";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_LOAN_TYPE()
    {
        $sql   = "SELECT name FROM tbl_std_loantypes WHERE status='Active'";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_SPECIFIC_LOAN_TYPE($id)
    {
        $sql   = "SELECT name FROM tbl_std_loantypes WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        return $result ? $result->name : null;
    }
    function GET_COUNT_LOAN_ID($id)
    {
        $sql   = "SELECT id FROM tbl_payroll_payslips WHERE LOAN_ID = ?";
        $query = $this->db->query($sql, array($id));
        return $query->num_rows();
    }
    function GET_COUNT_CA_ID($id)
    {
        $sql   = "SELECT id FROM tbl_payroll_payslips WHERE CA_ID = ?";
        $query = $this->db->query($sql, array($id));
        return $query->num_rows();
    }
    function GET_COUNT_DEDUCT_ID($id)
    {
        $sql   = "SELECT id FROM tbl_payroll_payslips WHERE DEDUCT_ID = ?";
        $query = $this->db->query($sql, array($id));
        return $query->num_rows();
    }

    function GET_ALL_PAYROLL_PAYSLIP_LOAN_DATA($payslip_id)
    {
        if (empty($payslip_id) || $payslip_id == null) {
            return [];
        }
        $sql   = "SELECT payslip_id, loan_id, code, start, payable, deducted, balance FROM tbl_payroll_payslip_loan WHERE payslip_id=$payslip_id";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_PAYROLL_PAYSLIP_ADJUSTMENT($payslip_id)
    {
        if (empty($payslip_id) || $payslip_id == null) {
            return [];
        }
        $sql   = "SELECT payslip_id, adjustment_id, description, adj_amount FROM tbl_payroll_payslip_adjustment WHERE payslip_id=$payslip_id";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_PAYROLL_PAYSLIP_OTHERDEDUCTIONS($payslip_id){
        if (empty($payslip_id) || $payslip_id == null) {
           return []; 
        }
        $sql = "SELECT payslip_id, deduction_id, code, value FROM tbl_payroll_payslip_otherdeductions WHERE payslip_id=?";
        $query = $this->db->query($sql, array($payslip_id));
        $query->next_result();
        return $query->result();
    }


    function GET_ALL_PAYSLIP_OTHER_DEDUCTIONS($payslip_id)
    {
        if (empty($payslip_id) || $payslip_id == null) {
            return [];
        }
        $sql   = "SELECT payslip_id, deduction_id, code, value FROM tbl_payroll_payslip_otherdeductions WHERE payslip_id=$payslip_id";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_SUM_LOANS($loan_id)
    {
        $sql   = "SELECT COUNT(*) AS Loan_count  FROM tbl_payroll_payslip_loan WHERE loan_id=?";
        $query = $this->db->query($sql, array($loan_id));
        $result = $query->row();
        if ($result) {
            return $result->Loan_count;
        } else {
            return null;
        }
    }

    function GET_ALL_PAYROLL_TAXABLE_DATA($payroll_id)
    {
        if (empty($payroll_id) || $payroll_id == null) {
            return [];
        }
        $sql   = "SELECT * FROM tbl_payrolls_taxable WHERE payroll_id=$payroll_id";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_PAYROLL_NONTAXABLE_DATA($payroll_id)
    {
        if (empty($payroll_id) || $payroll_id == null) {
            return [];
        }
        $sql   = "SELECT * FROM tbl_payrolls_nontaxable WHERE payroll_id=$payroll_id";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_PAYROLL_LOAN_DATA_EMPL($user_id)
    {
        if (empty($user_id) || $user_id == null) {
            return [];
        }
        $sql   = "SELECT * FROM tbl_benefits_loan WHERE empl_id = $user_id AND status='Active' ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_PAYROLL_LOAN_DATA_EMPL($user_id, $period)
    {
        if (empty($user_id) || $user_id == null) {
            return [];
        }
        $sql   = "SELECT * FROM tbl_benefits_loan WHERE empl_id = ? AND status='Active' AND is_deleted='0' AND start_period <= ? ";
        $query = $this->db->query($sql, array($user_id, $period));
        $query->next_result();
        return $query->result();
    }
    // function GET_PAYROLL_CA_DATA_EMPL($user_id)
    // {
    //     if (empty($user_id) || $user_id == null) {
    //         return [];
    //     }
    //     $sql   = "SELECT * FROM tbl_payroll_cashadvance WHERE empl_id = $user_id";
    //     $query = $this->db->query($sql);
    //     $query->next_result();
    //     return $query->result();
    // }
    // function GET_PAYROLL_DEDUCT_DATA_EMPL($user_id)
    // {
    //     if (empty($user_id) || $user_id == null) {
    //         return [];
    //     }
    //     $sql   = "SELECT * FROM tbl_payroll_deductions WHERE empl_id = $user_id";
    //     $query = $this->db->query($sql);
    //     $query->next_result();
    //     return $query->result();
    // }
    function MOD_DISP_PAY_SCHED_LATEST()
    {
        $sql   = "SELECT * FROM tbl_payroll_period WHERE status='active' ORDER BY id DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        $result = $query->result();
        if (!empty($result)) {
            $latestId = $result[0]->id;
            return $latestId;
        } else {
            return null;
        }
    }
    function GET_EXPORT_PAYROLL_PAYSLIP($period)
    {
        $response = array();
        $this->db->select('id, PAYSLIP_EMPLOYEE_CMID, PAYSLIP_EMPLOYEE_NAME, PAYSLIP_SALARY_RATE, PAYSLIP_SALARY_TYPE, INITIAL_DAILY_RATE, INITIAL_HOURLY_RATE, PAYSLIP_PERIOD,
        TOT_PRESENT, TOT_ABSENT, TOT_TARDINESS, TOT_UNDERTIME, TOT_PAID_LEAVE, TOT_REG_HOURS, TOT_REG_OT, TOT_REG_ND, TOT_REG_NDOT, TOT_REST_HOURS, TOT_REST_OT, TOT_REST_ND,
        TOT_REST_NDOT, TOT_LEG_HOURS, TOT_LEG_OT, TOT_LEG_ND, TOT_LEG_NDOT, TOT_LEGREST_HOURS, TOT_LEGREST_OT, TOT_LEGREST_ND, TOT_LEGREST_NDOT, TOT_SPE_HOURS, TOT_SPE_OT,
        TOT_SPE_ND, TOT_SPE_NDOT, TOT_SPEREST_HOURS, TOT_SPEREST_OT, TOT_SPEREST_ND, TOT_SPEREST_NDOT, EARNINGS, DEDUCTIONS, WTAX, NET_INCOME, LOAN_ID, GROSS_INCOME, 
        SSS_EE_CURRENT, PAGIBIG_EE_CURRENT, PHILHEALTH_EE_CURRENT, SSS_ER_CURRENT, SSS_EC_ER_CURRENT, PAGIBIG_ER_CURRENT, PHILHEALTH_ER_CURRENT, CA_ID, DEDUCT_ID, 
        status, LOAN_LIST, CA_LIST, DEDUCT_LIST');
        $this->db->where('PAYSLIP_PERIOD', $period);
        $sql = $this->db->get('tbl_payroll_payslips');
        $response = $sql->result_array();
        return $response;
    }
    function GET_PAYROLL_SSS($year)
    {
        if (!empty($year)) {
            $this->db->where('year', $year);
        }
        $this->db->where('status', 'Active');
        $query = "";
        if($year == "2025"){
            $query = $this->db->get('tbl_payroll_sss_2025');
        }
        if($year == "2024"){
            $query = $this->db->get('tbl_payroll_sss');
        }
        return $query->result();
    }


    function GET_PAYROLL_SSS_YEAR()
    {
        $this->db->distinct();
        $this->db->select('year');
        $this->db->where('status', 'Active');
        $this->db->order_by('year', 'desc');
        $query = $this->db->get('tbl_payroll_sss');
        return $query->result();
    }
    function GET_PAYROLL_TAX($year)
    {
        if (!empty($year)) {
            $this->db->where('year', $year);
        }
        $this->db->where('status', 'Active');
        $query = $this->db->get('tbl_payroll_tax');
        return $query->result();
    }
    function GET_PAYROLL_TAX_YEAR()
    {
        $this->db->distinct();
        $this->db->select('year');
        $this->db->where('status', 'Active');
        $this->db->order_by('year', 'desc');
        $query = $this->db->get('tbl_payroll_tax');
        return $query->result();
    }
    function GET_PAYROLL_PHILHEALTH($year)
    {
        if (!empty($year)) {
            $this->db->where('year', $year);
        }
        $this->db->where('status', 'Active');
        $query = $this->db->get('tbl_payroll_philhealth');
        return $query->result();
    }
    function GET_PAYROLL_PHILHEALTH_YEAR()
    {
        $this->db->distinct();
        $this->db->select('year');
        $this->db->where('status', 'Active');
        $this->db->order_by('year', 'desc');
        $query = $this->db->get('tbl_payroll_philhealth');
        return $query->result();
    }
    function GET_PAYROLL_HDMF($year)
    {
        if (!empty($year)) {
            $this->db->where('year', $year);
        }
        $this->db->where('status', 'Active');
        $query = $this->db->get('tbl_payroll_hdmf');
        return $query->result();
    }
    function GET_PAYROLL_HDMF_YEAR()
    {
        $this->db->distinct();
        $this->db->select('year');
        $this->db->where('status', 'Active');
        $this->db->order_by('year', 'desc');
        $query = $this->db->get('tbl_payroll_hdmf');
        return $query->result();
    }
    function GET_ALL_PAYROLL_SCHEDULE()
    {
        $sql = "SELECT * FROM tbl_payroll_period  ORDER BY id DESC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_PAYROLL_SCHEDULE($tab, $offset, $row)
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE is_deleted=0 AND status=? ORDER BY id DESC
        LIMIT " . $offset . ", " . $row . "";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function GET_PAYROLL_SCHEDULE_COUNT($tab)
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE is_deleted=0 AND status=? ORDER BY id DESC";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function GET_PAYROLL_SCHEDULE_NAME()
    {
        $sql = "SELECT id, name FROM tbl_payroll_period";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function INSERT_PAYROLL_SCHEDULE($title, $year, $month, $start_date, $end_date, $payout_date, $payslip_schedule_viewing, $pay_freq, $con_period_1, $con_period_2, $con_period_3, $con_period_4, $con_period_5, $status, $input_sss, $input_phil, $input_pagibig, $input_wtax, $input_tax_allowance, $input_nontax_allowance, $input_loans, $input_adjustment, $input_tard)
    {
        $date  = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_payroll_period (month,create_date,edit_date, name, date_from, payout, payslip_sched, date_to, status, connected_period, connected_period_2, connected_period_3, connected_period_4, connected_period_5, year, pay_frequency, chk_sss, chk_philhealth, chk_pagibig, chk_withholding, chk_taxable, chk_nontaxable, chk_loans, chk_adjustment, chk_tardiness) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($month, $date, $date, $title, $start_date, $payout_date, $payslip_schedule_viewing, $end_date, $status, $con_period_1, $con_period_2, $con_period_3, $con_period_4, $con_period_5, $year, $pay_freq, $input_sss, $input_phil, $input_pagibig, $input_wtax, $input_tax_allowance, $input_nontax_allowance, $input_loans, $input_adjustment, $input_tard));
    }
    function EDIT_PAYROLL_SCHEDULE($title, $year, $month, $start_date, $end_date, $payout_date, $payslip_schedule, $pay_freq, $con_period_1, $con_period_2, $con_period_3, $con_period_4, $con_period_5, $status, $input_sss, $input_phil, $input_pagibig, $input_wtax, $input_tax_allowance, $input_nontax_allowance, $input_loans, $input_adjustment, $input_tard, $id)
    {
        $date  = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_payroll_period SET edit_date=?,month=?, name=?, date_from=?, payout=?, payslip_sched=?, date_to=?, status=?, connected_period=?, connected_period_2=?, connected_period_3=?, connected_period_4=?, connected_period_5=?, year=?, pay_frequency=?, chk_sss=?, chk_philhealth=?, chk_pagibig=?, chk_withholding=?, chk_taxable=?, chk_nontaxable=?, chk_loans=?, chk_adjustment=?, chk_tardiness=? WHERE id=?";
        $this->db->query($sql, array($date, $month, $title, $start_date, $payout_date, $payslip_schedule, $end_date, $status, $con_period_1, $con_period_2, $con_period_3, $con_period_4, $con_period_5, $year, $pay_freq, $input_sss, $input_phil, $input_pagibig, $input_wtax, $input_tax_allowance, $input_nontax_allowance, $input_loans, $input_adjustment, $input_tard, $id));
    }
    function EDIT_PAYROLL_SCHEDULE_CONTRIBUTION($input_sss, $input_phil, $input_pagibig, $input_wtax, $input_tax_allowance, $input_nontax_allowance, $input_loans, $input_adjustment, $input_tard, $id)
    {
        $date  = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_payroll_period SET edit_date=?, chk_sss=?, chk_philhealth=?, chk_pagibig=?, chk_withholding=?, chk_taxable=?, chk_nontaxable=?, chk_loans=?, chk_adjustment=?, chk_tardiness=? WHERE id=?";
        $this->db->query($sql, array($date, $input_sss, $input_phil, $input_pagibig, $input_wtax, $input_tax_allowance, $input_nontax_allowance, $input_loans, $input_adjustment, $input_tard, $id));
    }
    function GET_PAYROLL_SCHEDULE_CONTRIBUTION($period)
    {
        $sql = "SELECT name, chk_sss, chk_philhealth, chk_pagibig, chk_withholding, chk_taxable, chk_nontaxable, chk_loan_deduction, chk_tardiness FROM tbl_payroll_period WHERE id=?";
        $query = $this->db->query($sql, array($period));
        $query->next_result();
        return $query->result();
    }
    function GET_SPECIFIC_PAYROLL_SCHEDULE($id)
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE id=?";
        $query = $this->db->query($sql, array($id));
        // $query->next_result();
        return $query->row();
    }

    function GET_NAME_PAYROLL_SCHEDULE($id)
    {
        $sql = "SELECT name FROM tbl_payroll_period WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();

        if ($result) {
            return $result->name;
        } else {
            return null;
        }
    }

    function UPDATE_ACTIVE_PAYROLL_SCHED($id, $status)
    {
        $sql = "UPDATE tbl_payroll_period SET status=? WHERE id=? ";
        $query = $this->db->query($sql, array($status, $id));
    }
    function GET_PAYROLL_SCHED_ACTIVE_COUNT($tab)
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE is_deleted=0 AND status=?";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function GET_PAYROLL_SCHED_INACTIVE_COUNT($tab)
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE is_deleted=0 AND status=?";
        $query = $this->db->query($sql, array($tab));
        $query->next_result();
        return $query->result();
    }
    function GET_EMPLOYEELIST($offset, $row)
    {
        $sql = "SELECT id, col_empl_cmid, 
        CONCAT_WS('',COALESCE(col_last_name, ''), 
        CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS fullname,
        salary_rate, salary_type FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 ORDER BY col_empl_cmid + 0 ASC LIMIT " . $offset . ", " . $row . " ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    
    function GET_EMPLOYEELIST_2()
    {
        $sql = "SELECT id, col_empl_cmid, 
        CONCAT_WS('',COALESCE(col_last_name, ''), 
        CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS fullname,
        salary_rate, salary_type, bank_name, account_number FROM tbl_employee_infos WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 ORDER BY col_empl_cmid + 0 ASC ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    // function GET_EMPLOYEELIST_3()
    // {
    //     $year = 2;
    //     $sql = "SELECT tb1.id, tb1.col_empl_cmid, 
    //     CONCAT_WS('',COALESCE(tb1.col_last_name, ''), 
    //     CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
    //     CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
    //     CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
    //     ) AS fullname,
    //     tb1.salary_rate, tb1.salary_type, tb1.col_empl_sssc, tb1.col_empl_hdmf, tb1.col_empl_phil, tb1.col_empl_btin, tb1.col_empl_dept, tb1.bank_name, tb1.account_number, tb2.days FROM tbl_employee_infos AS tb1 
    //     INNER JOIN tbl_employee_work_days AS tb2 ON tb1.id = tb2.empl_id

    //     WHERE tb2.year = $year AND tb1.termination_date IS NULL AND disabled=0 ORDER BY tb1.col_empl_cmid + 0 ASC ";
    //     $query = $this->db->query($sql);
    //     $query->next_result();
    //     return $query->result();
    // }

    function GET_EMPLOYEELIST_3()
    {
        $year = 2;
        $sql = "SELECT tb1.id, tb1.col_empl_cmid, 
        CONCAT_WS('',COALESCE(tb1.col_last_name, ''), 
        CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
        CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
        CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname,
        tb1.salary_rate, tb1.salary_type, tb1.col_empl_sssc, tb1.col_empl_hdmf, tb1.col_empl_phil, tb1.col_empl_btin, tb1.col_empl_dept, tb1.bank_name, tb1.account_number, tb2.days FROM tbl_employee_infos AS tb1 
        INNER JOIN tbl_employee_work_days AS tb2 ON tb1.id = tb2.empl_id
        
        WHERE (tb1.termination_date IS NULL || tb1.termination_date = '0000-00-00') AND tb1.disabled=0 ORDER BY tb1.col_empl_cmid + 0 ASC ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEELIST_3_BY_SALARY_TYPE($salary_type)
    {
        $year = 2;
        $sql = "SELECT tb1.id, tb1.col_empl_cmid, 
        CONCAT_WS('',COALESCE(tb1.col_last_name, ''), 
        CASE WHEN tb1.col_suffix IS NOT NULL AND tb1.col_suffix != '' THEN CONCAT(' ', tb1.col_suffix) ELSE '' END,
        CASE WHEN tb1.col_frst_name IS NOT NULL AND tb1.col_frst_name != '' THEN CONCAT(', ', tb1.col_frst_name) ELSE '' END,
        CASE WHEN tb1.col_midl_name IS NOT NULL AND tb1.col_midl_name != '' THEN CONCAT(' ', LEFT(tb1.col_midl_name, 1), '.') ELSE '' END
        ) AS fullname, tb1.col_empl_posi,
        tb1.salary_rate, tb1.salary_type, tb1.col_empl_sssc, tb1.col_empl_hdmf, tb1.col_empl_phil, tb1.col_empl_btin, tb1.col_empl_dept, tb1.bank_name, tb1.account_number, tb2.days FROM tbl_employee_infos AS tb1 
        INNER JOIN tbl_employee_work_days AS tb2 ON tb1.id = tb2.empl_id
        
        WHERE (tb1.termination_date IS NULL || tb1.termination_date = '0000-00-00') AND tb1.salary_type=? AND tb1.disabled=0 ORDER BY tb1.col_empl_cmid + 0 ASC ";
        $query = $this->db->query($sql, array($salary_type));
        $query->next_result();
        return $query->result();
    }

    function convert_department_id_to_name($id)
    {
        $sql = "SELECT * FROM tbl_std_departments WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        $result = $query->result();
        if (!empty($result)) {
            return $result[0]->name;
        } else {
            return null;
        }
    }

    function convert_position_id_to_name($id)
    {
        $sql = "SELECT name FROM tbl_std_positions WHERE id = ?";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        $result = $query->result();
        if (!empty($result)) {
            return $result[0]->name;
        } else {
            return null;
        }
    }

    // function GET_GENERATED_EMPLOYEELIST()
    // {
    //     $sql = "SELECT id, col_empl_cmid, 
    //     CONCAT_WS('',COALESCE(col_last_name, ''), 
    //     CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
    //     CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
    //     CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
    //     ) AS fullname,
    //     salary_rate, salary_type FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 ORDER BY col_empl_cmid + 0 ASC ";
    //     $query = $this->db->query($sql);
    //     $query->next_result();
    //     return $query->result();
    // }


    function GET_GENERATED_EMPLOYEELIST()
    {
        $sql = "SELECT id, col_empl_cmid, 
        CONCAT_WS('',COALESCE(col_last_name, ''), 
        CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS fullname,
        salary_rate, salary_type FROM tbl_employee_infos  WHERE disabled=0 ORDER BY col_empl_cmid + 0 ASC ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

        function GET_ALL_EMPLOYEELIST()
    {
        $sql = "SELECT id, col_empl_cmid, 
        CONCAT_WS('',COALESCE(col_last_name, ''), 
        CASE WHEN col_suffix IS NOT NULL AND col_suffix != '' THEN CONCAT(' ', col_suffix) ELSE '' END,
        CASE WHEN col_frst_name IS NOT NULL AND col_frst_name != '' THEN CONCAT(', ', col_frst_name) ELSE '' END,
        CASE WHEN col_midl_name IS NOT NULL AND col_midl_name != '' THEN CONCAT(' ', LEFT(col_midl_name, 1), '.') ELSE '' END
        ) AS fullname,
        salary_rate, salary_type FROM tbl_employee_infos ORDER BY col_empl_cmid + 0 ASC ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEELIST_COUNT()
    {
        $sql = "SELECT id, col_empl_cmid, CONCAT(col_last_name,', ',col_frst_name) as fullname FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    function GET_CUTOFF_LIST()
    {
        $sql = "SELECT * FROM tbl_payroll_period WHERE status = 'Active' ORDER BY date_to DESC";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_SPECIFIC_CUTOFF($id)
    {
        $sql = "SELECT id FROM tbl_payroll_period WHERE id=? AND status = 'Active' ORDER BY date_to DESC";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result->id;
        } else {
            return null;
        }
    }
    function GET_EMPLOYEELIST_DATA()
    {
        $sql = "SELECT * FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 ORDER BY col_empl_cmid + 0 ASC ";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function GET_EMPLOYEELIST_BY_SALARY_TYPE($salary_type)
    {
        $sql = "SELECT * FROM tbl_employee_infos  WHERE (termination_date IS NULL || termination_date = '0000-00-00') AND salary_type=? AND disabled=0 ORDER BY col_empl_cmid + 0 ASC ";
        $query = $this->db->query($sql, array($salary_type));
        $query->next_result();
        return $query->result();
    }


    function GET_SPECIFIC_EMPLOYEE_DATA($id)
    {
        $sql = "SELECT * FROM tbl_employee_infos WHERE id=? AND termination_date IS NULL || termination_date = '0000-00-00' AND disabled=0 ORDER BY col_empl_cmid + 0 ASC ";
        $query = $this->db->query($sql, array($id));
        $query->next_result();
        return $query->row();
    }
    function GET_PAYROLL_PAYSLIPS_GENERATED($period)
    {
        $sql   = "SELECT id, empl_id, PAYSLIP_EMPLOYEE_CMID, PAYSLIP_EMPLOYEE_NAME, PAYSLIP_PERIOD, NET_INCOME, LOAN_ID, LOAN_LIST, OTHER_DEDUCTION_LIST FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=? AND status='Generated' ";
        $query = $this->db->query($sql, array($period));
        $query->next_result();
        return $query->result();
    }

    function GET_PAYROLL_PAYSLIPS_GENERATED_2($period, $salary_type)
    {
        $sql   = "SELECT id, empl_id, PAYSLIP_EMPLOYEE_CMID, PAYSLIP_EMPLOYEE_NAME, PAYSLIP_PERIOD, NET_INCOME, LOAN_ID, LOAN_LIST, OTHER_DEDUCTION_LIST FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=? AND status='Generated' AND PAYSLIP_SALARY_TYPE=? ";
        $query = $this->db->query($sql, array($period, $salary_type));
        $query->next_result();
        return $query->result();
    }

    function GET_LOAN_BENEFITS($id)
    {
        $sql   = "SELECT LOAN_ID FROM tbl_payroll_payslips WHERE id=? ";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result->LOAN_ID;
        } else {
            return null;
        }
    }
    function GET_PAYROLL_PAYSLIPS_PUBLISHED($period)
    {
        $sql   = "SELECT id, empl_id, PAYSLIP_EMPLOYEE_CMID, PAYSLIP_EMPLOYEE_NAME, PAYSLIP_PERIOD, NET_INCOME, is_acknowledged FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=? AND status='Published' ";
        $query = $this->db->query($sql, array($period));
        $query->next_result();
        return $query->result();
    }

    function GET_PAYROLL_PAYSLIPS_PUBLISHED_2($period, $salary_type)
    {
        $sql   = "SELECT id, empl_id, PAYSLIP_EMPLOYEE_CMID, PAYSLIP_EMPLOYEE_NAME, PAYSLIP_PERIOD, NET_INCOME, is_acknowledged FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=? AND status='Published' AND PAYSLIP_SALARY_TYPE=?";
        $query = $this->db->query($sql, array($period, $salary_type));
        $query->next_result();
        return $query->result();
    }



    function GET_PAYROLL_PAYSLIPS($empl_id, $period)
    {
        $sql   = "SELECT * FROM tbl_payroll_payslips WHERE empl_id=? AND PAYSLIP_PERIOD=? AND status='Generated' ";
        $query = $this->db->query($sql, array($empl_id, $period));
        return $query->row();
    }
    function EDIT_GENERATED_PAYSLIP($data)
    {
        $date = date('Y-m-d H:i:s');
        $values = array(
            $date,
            $data['count_present'],
            $data['count_absent'],
            $data['count_tardiness'],
            $data['count_undertime'],
            $data['count_paid_leave'],
            $data['count_reg_hours'],
            $data['count_reg_ot'],
            $data['count_reg_nd'],
            $data['count_reg_ndot'],
            $data['count_rest_hours'],
            $data['count_rest_ot'],
            $data['count_rest_nd'],
            $data['count_rest_ndot'],
            $data['count_leg_hours'],
            $data['count_leg_ot'],
            $data['count_leg_nd'],
            $data['count_leg_ndot'],
            $data['count_legrest_hours'],
            $data['count_legrest_ot'],
            $data['count_legrest_nd'],
            $data['count_legrest_ndot'],
            $data['count_spe_hours'],
            $data['count_spe_ot'],
            $data['count_spe_nd'],
            $data['count_spe_ndot'],
            $data['count_sperest_hours'],
            $data['count_sperest_ot'],
            $data['count_sperest_nd'],
            $data['count_sperest_ndot'],
            $data['id'],
        );
        $sql = "UPDATE tbl_payroll_payslips SET edit_date=?, COUNT_PRESENT=?, COUNT_ABSENT=?, COUNT_TARDINESS=?, COUNT_UNDERTIME=?, COUNT_PAID_LEAVE=?, 
        COUNT_REG_HOURS=?, COUNT_REG_OT=?, COUNT_REG_ND=?, COUNT_REG_NDOT=?, COUNT_REST_HOURS=?, COUNT_REST_OT=?, COUNT_REST_ND=?, COUNT_REST_NDOT=?, 
        COUNT_LEG_HOURS=?, COUNT_LEG_OT=?, COUNT_LEG_ND=?, COUNT_LEG_NDOT=?, COUNT_LEGREST_HOURS=?, COUNT_LEGREST_OT=?, COUNT_LEGREST_ND=?, COUNT_LEGREST_NDOT=?, 
        COUNT_SPE_HOURS=?, COUNT_SPE_OT=?, COUNT_SPE_ND=?, COUNT_SPE_NDOT=?, COUNT_SPEREST_HOURS=?, COUNT_SPEREST_OT=?, COUNT_SPEREST_ND=?, COUNT_SPEREST_NDOT=? WHERE id=?";
        $query = $this->db->query($sql, $values);
    }
    function ADD_PAYSLIP_PUBLISHED($id)
    {
        $date = date('Y-m-d H:i:s');
        $sql = "UPDATE tbl_payroll_payslips SET edit_date=?, status='Published' WHERE id=?";
        $query = $this->db->query($sql, array($date, $id));
    }
    function GET_ALL_PAYROLL_PAYSLIPS($period)
    {
        $sql   = "SELECT id, empl_id, PAYSLIP_EMPLOYEE_CMID, PAYSLIP_EMPLOYEE_NAME, status FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=?";
        $query = $this->db->query($sql, array($period));
        $query->next_result();
        return $query->result();
    }
    
    function GET_ALL_PAYROLL_PAYSLIPS_2($period, $salary_type)
    {
        $sql   = "SELECT id, empl_id, PAYSLIP_EMPLOYEE_CMID, PAYSLIP_EMPLOYEE_NAME, status FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=? AND PAYSLIP_SALARY_TYPE=?";
        $query = $this->db->query($sql, array($period, $salary_type));
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_ATTENDACE_RECORD_LOCK($period)
    {
        $sql = "SELECT empl_id FROM tbl_attendance_records_lock WHERE period=?";
        $query = $this->db->query($sql, array($period));
        return $query->result();
    }
    function GET_ALL_EMPLOYEE_TYPE()
    {
        $sql   = "SELECT * FROM tbl_std_employeetypes";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function GET_ALL_POSITION()
    {
        $sql   = "SELECT * FROM tbl_std_positions";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }
    function IS_DUPLICATE_PAYROLL_PAYSLIP($id, $period)
    {
        $status = "Generated";
        $sql   = "SELECT * FROM tbl_payroll_payslips WHERE empl_id=? AND PAYSLIP_PERIOD=? AND status=?";
        $query = $this->db->query($sql, array($id, $period, $status));
        return $query->num_rows();
    }


    function columnsExist($requiredColumns, $tableName)
    {
        // Query to get the columns of the table
        $sql = "SHOW COLUMNS FROM $tableName";
        $query = $this->db->query($sql);
        $columns = $query->result_array();

        // Extract column names
        $existingColumns = array_column($columns, 'Field');

        // Check if all required columns exist
        $missingColumns = array_diff($requiredColumns, $existingColumns);

        return $missingColumns;
    }


    function GENERATE_PAYSLIP($data)
    {

        $vacationLeaveValue = '';
        $sickLeaveValue = '';

        if (isset($data['leave_entitlement'])) {
            $leaveEntitlements = $data['leave_entitlement'];
            $sickLeaveValue = (isset($leaveEntitlements['Sick Leave'])) ? $leaveEntitlements['Sick Leave'] : '';
            $vacationLeaveValue = (isset($leaveEntitlements['Vacation Leave'])) ? $leaveEntitlements['Vacation Leave'] : '';
        }

        $datetime               = date('Y-m-d H:i:s');
        $result = $this->IS_DUPLICATE_PAYROLL_PAYSLIP($data['id'], $data['period']);

        // insert into tbl_payroll_payslips
        if ($result <= 0) {
            $values = array(

                $datetime,
                $datetime,
                $data['id'],
                $data['cmid'],
                $data['fullname'],
                $data['position'],
                $data['designation'],
                $data['salary_rate'],
                $data['salary_type'],
                $data['bank_name'],
                $data['bank_account'],
                $data['pagibig_id'],
                $data['philhealth_id'],
                $data['tin_id'],
                $data['sss_id'],
                (float) str_replace(',', '', $data['monthly_salary']),
                (float) str_replace(',', '', $data['daily_salary']),
                (float) str_replace(',', '', $data['hourly_salary']),
                $data['leaves_list'],
                $vacationLeaveValue,
                $sickLeaveValue,
                $data['period'],
                $data['count_present'],
                $data['count_absent'],
                $data['count_tardiness'],
                $data['count_undertime'],
                $data['count_underbreak'],
                $data['count_overbreak'],
                $data['count_paid_leave'],
                $data['count_bday_leave_hrs'],
                $data['count_reg_hours'],
                $data['count_reg_ot'],
                $data['count_reg_nd'],
                $data['count_reg_ndot'],
                $data['count_rest_hours'],
                $data['count_rest_ot'],
                $data['count_rest_nd'],
                $data['count_rest_ndot'],
                $data['count_leg_hours'],
                $data['count_leg_ot'],
                $data['count_leg_nd'],
                $data['count_leg_ndot'],
                $data['count_legrest_hours'],
                $data['count_legrest_ot'],
                $data['count_legrest_nd'],
                $data['count_legrest_ndot'],
                $data['count_spe_hours'],
                $data['count_spe_ot'],
                $data['count_spe_nd'],
                $data['count_spe_ndot'],
                $data['count_sperest_hours'],
                $data['count_sperest_ot'],
                $data['count_sperest_nd'],
                $data['count_sperest_ndot'],
                $data['mul_present'],
                $data['mul_absent'],
                $data['mul_tardiness'],
                $data['mul_undertime'],
                $data['mul_paid_leave'],
                $data['mul_reg_hours'],
                $data['mul_reg_ot'],
                $data['mul_reg_nd'],
                $data['mul_reg_ndot'],
                $data['mul_rest_hours'],
                $data['mul_rest_ot'],
                $data['mul_rest_nd'],
                $data['mul_rest_ndot'],
                $data['mul_leg_hours'],
                $data['mul_leg_ot'],
                $data['mul_leg_nd'],
                $data['mul_leg_ndot'],
                $data['mul_legrest_hours'],
                $data['mul_legrest_ot'],
                $data['mul_legrest_nd'],
                $data['mul_legrest_ndot'],
                $data['mul_spe_hours'],
                $data['mul_spe_ot'],
                $data['mul_spe_nd'],
                $data['mul_spe_ndot'],
                $data['mul_sperest_hours'],
                $data['mul_sperest_ot'],
                $data['mul_sperest_nd'],
                $data['mul_sperest_ndot'],
                // (float) str_replace(',', '', $data['present']),
                (float) str_replace(',', '', $data['absent']),
                (float) str_replace(',', '', $data['tardiness_total']),
                (float) str_replace(',', '', $data['undertime']),
                (float) str_replace(',', '', $data['underbreak']),
                (float) str_replace(',', '', $data['overbreak']),
                (float) str_replace(',', '', $data['basic_pay']),
                (float) str_replace(',', '', $data['paid_leave_total']),
                (float) str_replace(',', '', $data['tot_bday_leave_hrs']),
                (float) str_replace(',', '', $data['regular_pay']),
                (float) str_replace(',', '', $data['reg_ot']),
                (float) str_replace(',', '', $data['reg_nd']),
                (float) str_replace(',', '', $data['reg_ndot']),
                (float) str_replace(',', '', $data['rest_hour']),
                (float) str_replace(',', '', $data['rest_ot']),
                (float) str_replace(',', '', $data['rest_nd']),
                (float) str_replace(',', '', $data['rest_ndot']),
                (float) str_replace(',', '', $data['leg_hours']),
                (float) str_replace(',', '', $data['leg_ot']),
                (float) str_replace(',', '', $data['leg_nd']),
                (float) str_replace(',', '', $data['leg_ndot']),
                (float) str_replace(',', '', $data['legrest_hours']),
                (float) str_replace(',', '', $data['legrest_ot']),
                (float) str_replace(',', '', $data['legrest_nd']),
                (float) str_replace(',', '', $data['legrest_ndot']),
                (float) str_replace(',', '', $data['spe_hours']),
                (float) str_replace(',', '', $data['spe_ot']),
                (float) str_replace(',', '', $data['spe_nd']),
                (float) str_replace(',', '', $data['spe_ndot']),
                (float) str_replace(',', '', $data['sperest_hours']),
                (float) str_replace(',', '', $data['sperest_ot']),
                (float) str_replace(',', '', $data['sperest_nd']),
                (float) str_replace(',', '', $data['sperest_ndot']),
                (float) str_replace(',', '', $data['total_ndot_pay']),

                (float) str_replace(',', '', $data['pioneer_allowance']),
                (float) str_replace(',', '', $data['skills_allowance']),
                (float) str_replace(',', '', $data['position_allowance']),
                (float) str_replace(',', '', $data['skills_allowance_fix']),
                (float) str_replace(',', '', $data['position_allowance_fix']),

                (float) str_replace(',', '', $data['tax_allowance_total']),
                (float) str_replace(',', '', $data['nightmeal']),
                (float) str_replace(',', '', $data['spemeal']),
                (float) str_replace(',', '', $data['nontax_allowance_total']),
                (float) str_replace(',', '', $data['benefits_adjustment']),

                (float) str_replace(',', '', $data['other_deductions_sum']),
                (float) str_replace(',', '', $data['taxable_income']),
                (float) str_replace(',', '', $data['deduct_total']),
                (float) str_replace(',', '', $data['wtax']),
                (float) str_replace(',', '', $data['net_income']),
                (float) str_replace(',', '', $data['loan_total']),
                (float) str_replace(',', '', $data['gross_income']),

                (float) str_replace(',', '', $data['sss_ee_current']),
                (float) str_replace(',', '', $data['sss_mpf_ee_current']),
                
                (float) str_replace(',', '', $data['pagibig_ee_current']),
                (float) str_replace(',', '', $data['philhealth_ee_current']),
                (float) str_replace(',', '', $data['ytd_gross_tax']),
                (float) str_replace(',', '', $data['ytd_exclusion']),
                (float) str_replace(',', '', $data['ytd_wtax']),

                $data['leave_vaction_used'],
                $data['leave_vaction_bal'],
                $data['leave_sick_used'],
                $data['leave_sick_bal'],

                (float) str_replace(',', '', $data['sss_er_current']),
                (float) str_replace(',', '', $data['sss_mpf_er_current']),
                (float) str_replace(',', '', $data['sss_ec_er_current']),
                (float) str_replace(',', '', $data['pagibig_er_current']),
                (float) str_replace(',', '', $data['philhealth_er_current']),
                (float) str_replace(',', '', $data['_13th_month_pay_this_cutoff']),
                (float) str_replace(',', '', $data['_13th_month_pay_total']),
                
                // $data['ca_list'],$data['deduct_list'],$data['id_sss'],$data['id_pagibig'],$data['id_philhealth'],$data['id_tin']
            );

            $requiredColumns = array(
                'create_date',
                'edit_date',
                'empl_id',
                'PAYSLIP_EMPLOYEE_CMID',
                'PAYSLIP_EMPLOYEE_NAME',
                'PAYSLIP_EMPLOYEE_POSITION',
                'PAYSLIP_EMPLOYEE_DESIGNATION',
                'PAYSLIP_SALARY_RATE',
                'PAYSLIP_SALARY_TYPE',
                'BANK_NAME',
                'BANK_ACCOUNT',
                'ID_PAGIBIG',
                'ID_PHILHEALTH',
                'ID_TIN',
                'ID_SSS',
                'INITIAL_MONTHLY_RATE',
                'INITIAL_DAILY_RATE',
                'INITIAL_HOURLY_RATE',
                'LEAVE_LIST',
                'VACATION_LEAVE',
                'SICK_LEAVE',
                'PAYSLIP_PERIOD',
                'COUNT_PRESENT',
                'COUNT_ABSENT',
                'COUNT_TARDINESS',
                'COUNT_UNDERTIME',
                'COUNT_UNDERBREAK',
                'COUNT_OVERBREAK',
                'COUNT_PAID_LEAVE',
                'COUNT_BDAY_LEAVE_HRS',
                'COUNT_REG_HOURS',
                'COUNT_REG_OT',
                'COUNT_REG_ND',
                'COUNT_REG_NDOT',
                'COUNT_REST_HOURS',
                'COUNT_REST_OT',
                'COUNT_REST_ND',
                'COUNT_REST_NDOT',
                'COUNT_LEG_HOURS',
                'COUNT_LEG_OT',
                'COUNT_LEG_ND',
                'COUNT_LEG_NDOT',
                'COUNT_LEGREST_HOURS',
                'COUNT_LEGREST_OT',
                'COUNT_LEGREST_ND',
                'COUNT_LEGREST_NDOT',
                'COUNT_SPE_HOURS',
                'COUNT_SPE_OT',
                'COUNT_SPE_ND',
                'COUNT_SPE_NDOT',
                'COUNT_SPEREST_HOURS',
                'COUNT_SPEREST_OT',
                'COUNT_SPEREST_ND',
                'COUNT_SPEREST_NDOT',
                'MUL_PRESENT',
                'MUL_ABSENT',
                'MUL_TARDINESS',
                'MUL_UNDERTIME',
                'MUL_PAID_LEAVE',
                'MUL_REG_HOURS',
                'MUL_REG_OT',
                'MUL_REG_ND',
                'MUL_REG_NDOT',
                'MUL_REST_HOURS',
                'MUL_REST_OT',
                'MUL_REST_ND',
                'MUL_REST_NDOT',
                'MUL_LEG_HOURS',
                'MUL_LEG_OT',
                'MUL_LEG_ND',
                'MUL_LEG_NDOT',
                'MUL_LEGREST_HOURS',
                'MUL_LEGREST_OT',
                'MUL_LEGREST_ND',
                'MUL_LEGREST_NDOT',
                'MUL_SPE_HOURS',
                'MUL_SPE_OT',
                'MUL_SPE_ND',
                'MUL_SPE_NDOT',
                'MUL_SPEREST_HOURS',
                'MUL_SPEREST_OT',
                'MUL_SPEREST_ND',
                'MUL_SPEREST_NDOT',
                'TOT_ABSENT',
                'TOT_TARDINESS',
                'TOT_UNDERTIME',
                'TOT_UNDERBREAK',
                'TOT_OVERBREAK',
                'TOTAL_BASIC',
                'TOT_PAID_LEAVE',
                'TOT_PAID_BDAY_LEAVE',
                'TOT_REG_HOURS',
                'TOT_REG_OT',
                'TOT_REG_ND',
                'TOT_REG_NDOT',
                'TOT_REST_HOURS',
                'TOT_REST_OT',
                'TOT_REST_ND',
                'TOT_REST_NDOT',
                'TOT_LEG_HOURS',
                'TOT_LEG_OT',
                'TOT_LEG_ND',
                'TOT_LEG_NDOT',
                'TOT_LEGREST_HOURS',
                'TOT_LEGREST_OT',
                'TOT_LEGREST_ND',
                'TOT_LEGREST_NDOT',
                'TOT_SPE_HOURS',
                'TOT_SPE_OT',
                'TOT_SPE_ND',
                'TOT_SPE_NDOT',
                'TOT_SPEREST_HOURS',
                'TOT_SPEREST_OT',
                'TOT_SPEREST_ND',
                'TOT_SPEREST_NDOT',
                'TOTAL_OTND',
                'PIONEER_ALLO',
                'SKILLS_ALLO',
                'POSITION_ALLO',
                'SKILLS_ALLO_FIX',
                'POSITION_ALLO_FIX',
                'OTHER_TOTAL_TAX',
                'NIGHT_MEAL',
                'SPECIAL_MEAL',
                'OTHER_TOTAL_NONTAX',
                'ADJUSTMENT_TOTAL',
                'OTHER_DEDUCTIONS',
                'TAXABLE_INCOME',
                'DEDUCTIONS',
                'WTAX',
                'NET_INCOME',
                'LOAN_TOTAL',
                'GROSS_INCOME',
                'SSS_EE_CURRENT',
                'SSS_MPF_EE_CURRENT',
                'PAGIBIG_EE_CURRENT',
                'PHILHEALTH_EE_CURRENT',
                'YTD_GROSSTAX',
                'YTD_EXCLUSION',
                'YTD_WTAX',
                'VAC_USED',
                'VAC_BAL',
                'SICK_USED',
                'SICK_BAL',
                'SSS_ER_CURRENT',
                'SSS_MPF_ER_CURRENT',
                'SSS_EC_ER_CURRENT',
                'PAGIBIG_ER_CURRENT',
                'PHILHEALTH_ER_CURRENT',
                '_13th_MONTH_PAY',
                '_13th_MONTH_PAY_TOTAL',
            );

            // Check if all required columns exist in the table
            $missingColumns = $this->columnsExist($requiredColumns, 'tbl_payroll_payslips');

            // If there are missing columns, return them
            if (!empty($missingColumns)) {
                $error_message = "Error: The following required columns are missing in the database table: " . implode(', ', $missingColumns);
                return json_encode(array("error" => $error_message));
            }

            $numColumns = count($requiredColumns);
            $valuePlaceholders = implode(', ', array_fill(0, $numColumns, '?'));

            $sql = "INSERT INTO tbl_payroll_payslips (" . implode(', ', $requiredColumns) . ") VALUES (" . $valuePlaceholders . ")";
            $this->db->query($sql, $values);
            $new_inserted_id = $this->db->insert_id();

            // $sql = "INSERT INTO tbl_payroll_payslips (create_date, edit_date, empl_id, PAYSLIP_EMPLOYEE_CMID, PAYSLIP_EMPLOYEE_NAME, PAYSLIP_EMPLOYEE_DESIGNATION, PAYSLIP_SALARY_RATE, PAYSLIP_SALARY_TYPE, BANK_NAME, BANK_ACCOUNT, 
            // ID_PAGIBIG, ID_PHILHEALTH, ID_TIN, ID_SSS,
            // INITIAL_MONTHLY_RATE, INITIAL_DAILY_RATE, INITIAL_HOURLY_RATE, LEAVE_LIST, VACATION_LEAVE, SICK_LEAVE, PAYSLIP_PERIOD, 
            // COUNT_PRESENT, COUNT_ABSENT, COUNT_TARDINESS, COUNT_UNDERTIME, COUNT_UNDERBREAK, COUNT_OVERBREAK, COUNT_PAID_LEAVE,COUNT_REG_HOURS, COUNT_REG_OT, COUNT_REG_ND, COUNT_REG_NDOT,
            // COUNT_REST_HOURS, COUNT_REST_OT, COUNT_REST_ND, COUNT_REST_NDOT, COUNT_LEG_HOURS, COUNT_LEG_OT, COUNT_LEG_ND, COUNT_LEG_NDOT,
            // COUNT_LEGREST_HOURS, COUNT_LEGREST_OT, COUNT_LEGREST_ND, COUNT_LEGREST_NDOT, COUNT_SPE_HOURS, COUNT_SPE_OT, COUNT_SPE_ND, COUNT_SPE_NDOT,
            // COUNT_SPEREST_HOURS, COUNT_SPEREST_OT, COUNT_SPEREST_ND, COUNT_SPEREST_NDOT,
            // MUL_PRESENT, MUL_ABSENT, MUL_TARDINESS, MUL_UNDERTIME, MUL_PAID_LEAVE, MUL_REG_HOURS, MUL_REG_OT, MUL_REG_ND, MUL_REG_NDOT,
            // MUL_REST_HOURS, MUL_REST_OT, MUL_REST_ND, MUL_REST_NDOT, MUL_LEG_HOURS, MUL_LEG_OT, MUL_LEG_ND, MUL_LEG_NDOT,
            // MUL_LEGREST_HOURS, MUL_LEGREST_OT, MUL_LEGREST_ND, MUL_LEGREST_NDOT, MUL_SPE_HOURS, MUL_SPE_OT, MUL_SPE_ND, MUL_SPE_NDOT, 
            // MUL_SPEREST_HOURS, MUL_SPEREST_OT, MUL_SPEREST_ND, MUL_SPEREST_NDOT,
            // TOT_ABSENT, TOT_TARDINESS, TOT_UNDERTIME, TOT_UNDERBREAK, TOT_OVERBREAK, TOTAL_BASIC, TOT_PAID_LEAVE,
            // TOT_REG_HOURS, TOT_REG_OT, TOT_REG_ND, TOT_REG_NDOT,
            // TOT_REST_HOURS, TOT_REST_OT, TOT_REST_ND, TOT_REST_NDOT,
            // TOT_LEG_HOURS, TOT_LEG_OT, TOT_LEG_ND, TOT_LEG_NDOT,
            // TOT_LEGREST_HOURS, TOT_LEGREST_OT, TOT_LEGREST_ND, TOT_LEGREST_NDOT, 
            // TOT_SPE_HOURS, TOT_SPE_OT, TOT_SPE_ND, TOT_SPE_NDOT, 
            // TOT_SPEREST_HOURS, TOT_SPEREST_OT, TOT_SPEREST_ND, TOT_SPEREST_NDOT, OTHER_TOTAL_TAX, OTHER_TOTAL_NONTAX, OTHER_DEDUCTIONS, TAXABLE_INCOME,
            // DEDUCTIONS, WTAX, NET_INCOME,  LOAN_TOTAL, GROSS_INCOME, 
            // SSS_EE_CURRENT, PAGIBIG_EE_CURRENT, PHILHEALTH_EE_CURRENT, YTD_GROSSTAX, YTD_EXCLUSION, YTD_WTAX, VAC_USED, VAC_BAL, SICK_USED, SICK_BAL, 
            // SSS_ER_CURRENT, SSS_EC_ER_CURRENT,  PAGIBIG_ER_CURRENT, PHILHEALTH_ER_CURRENT) VALUES (?,?,?,?,?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            // $this->db->query($sql, $values);
            // $new_inserted_id = $this->db->insert_id();
        }

        // Non-taxable Allowance
        // if (!empty($new_inserted_id)) {
        //     foreach ($data['benefits_col'] as $benefit) {
        //         $type = $benefit['type'];
        //         $value = $benefit['value'];
        //         $sql = "INSERT INTO tbl_payrolls_nontaxable (payroll_id, description, amount) VALUES (?,?,?)";
        //         $query = $this->db->query($sql, array($new_inserted_id, $type, $value));
        //     }
        // }

        if (!empty($new_inserted_id)) {
            foreach ($data['benefits_nontax_allowance'] as $benefit) {
                $type = $benefit['type'];
                $value = $benefit['value'];
                $sql = "INSERT INTO tbl_payrolls_nontaxable (payroll_id, description, amount) VALUES (?,?,?)";
                $query = $this->db->query($sql, array($new_inserted_id, $type, $value));
            }
        }

        // Taxable Allowance
        if (!empty($new_inserted_id)) {
            foreach ($data['benefits_tax_allowance'] as $taxable_allowance) {
                $type = $taxable_allowance['type'];
                $value = $taxable_allowance['value'];
                $sql = "INSERT INTO tbl_payrolls_taxable (payroll_id, description, amount) VALUES (?,?,?)";
                $query = $this->db->query($sql, array($new_inserted_id, $type, $value));
            }
        }

        $adj_benefit_list = $data['adj_benefit_results'];
        $adjustment_Ids = [];

        if(isset($adj_benefit_list) && !empty($new_inserted_id)){
            foreach ($adj_benefit_list as $adj) {
                $adjId                      = $adj['id'];
                $adjDescription             = $adj['name'];
                $adjValue                   = $adj['value'];

                $adjustment_Ids[] = $this->INSERT_ADJUSTMENT_LIST($new_inserted_id, $adjId, $adjDescription, $adjValue);
            }
        }

        $adjustment_Ids_text = json_encode($adjustment_Ids);
        $this->UPDATE_PAYROLL_PAYSLIP_ADJ($adjustment_Ids_text, $new_inserted_id);
        

        $loanList =  $data['loan_list'];
        $payroll_payslip_Ids = [];
        if (isset($loanList) && !empty($new_inserted_id)) {
            foreach ($loanList as $loan) {
                $loanId                     = $loan['id'];
                $loan_type                  = $loan['loan_type'];
                $start_period               = $loan['start_period_id'];
                $loan_amount                = $loan['loan_amount'];
                $payable                    = $loan['payable'];
                $paid_amount                = $loan['paid_amount'];
                $bal_amount                 = $loan['bal_amount'];
                $loan_terms                 = $loan['loan_terms'];
                $initial_paid               = $loan['initial_paid'];

                $loan_count                 = $this->GET_SUM_LOANS($loanId) + $initial_paid;

                if ($loan_terms > $loan_count) {
                    $payroll_payslip_Ids[]      = $this->INSERT_LOAN_ID($new_inserted_id, $loanId, $loan_type, $start_period, $payable, $loan_amount, $bal_amount);
                }
            }
        }
        $payroll_payslip_Ids_text = json_encode($payroll_payslip_Ids);
        $this->UPDATE_LOAN_ID($payroll_payslip_Ids_text, $new_inserted_id);

        $other_deductions_list = $data['other_deductions_list'];
        $payslip_other_deduction_Ids = [];
        if (isset($other_deductions_list) && !empty($new_inserted_id)) {
            foreach ($other_deductions_list as $other_deduction) {
                $id                                 = $other_deduction['id'];
                $type                               = $other_deduction['type'];
                $value                              = $other_deduction['value'];
                $payslip_other_deduction_Ids[]      = $this->INSERT_OTHER_DEDUCTIONS($new_inserted_id, $id, $type, $value);
            }
        }
        $payslip_other_deduction_Ids_text = json_encode($payslip_other_deduction_Ids);
        $this->OTHER_DEDUCTION_LIST($payslip_other_deduction_Ids_text, $new_inserted_id);
    }
    function INSERT_OTHER_DEDUCTIONS($payslipId, $id, $type, $value)
    {
        $currentDate = date('Y-m-d H:i:s');
        $sql = "INSERT INTO tbl_payroll_payslip_otherdeductions (create_date, edit_date, payslip_id, deduction_id, code, value) VALUES (?,?,?,?,?,?)";
        $this->db->query($sql, array($currentDate, $currentDate, $payslipId, $id, $type, $value));
        return $this->db->insert_id();
    }

    function INSERT_ADJUSTMENT_LIST($payslipId, $adjId, $adjDescription, $adjValue){
        $sql = "INSERT INTO tbl_payroll_payslip_adjustment(payslip_id, adjustment_id, description, adj_amount) VALUES (?,?,?,?)";
        $this->db->query($sql, array($payslipId, $adjId, $adjDescription, $adjValue));
        return $this->db->insert_id();
    }

    function INSERT_LOAN_ID($payslipId, $loanId, $loan_type, $start_period, $payable, $loan_amount, $bal_amount)
    {
        $sql = "INSERT INTO tbl_payroll_payslip_loan (payslip_id, loan_id, code, start, payable, deducted, balance) VALUES (?,?,?,?,?,?,?)";
        $this->db->query($sql, array($payslipId, $loanId, $loan_type, $start_period, $payable, $loan_amount, $bal_amount));
        return $this->db->insert_id();
    }

    function OTHER_DEDUCTION_LIST($array, $id)
    {
        $sql = "UPDATE tbl_payroll_payslips SET OTHER_DEDUCTION_LIST=? WHERE id=?";
        $this->db->query($sql, array($array, $id));
    }
    function UPDATE_LOAN_ID($array, $id)
    {
        $sql = "UPDATE tbl_payroll_payslips SET LOAN_ID=? WHERE id=?";
        $this->db->query($sql, array($array, $id));
    }

    function UPDATE_PAYROLL_PAYSLIP_ADJ($array, $id){
        $sql = "UPDATE tbl_payroll_payslips SET ADJUSTMENT_ID=? WHERE id=?";
        $this->db->query($sql, array($array, $id));
    }

    function GET_EMPLOYEE_LOAN($id, $period)
    {
        $sql   = "SELECT loan_amount FROM tbl_benefits_loan WHERE id=? AND loan_date >= $period AND loan_date <= $period";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        return $result ? $result->loan_amount : null;
    }
    function GET_EMPLOYEE_LOANS($id)
    {
        $sql   = "SELECT loan_name, loan_type, loan_amount, loan_terms, status, initial_paid FROM tbl_benefits_loan WHERE id=? ";
        $query = $this->db->query($sql, array($id));
        return $query->row();
        // return $query->result();
    }
    // function UPDATE_LOAN_BENEFITS($id){
    //     $sql = "UPDATE tbl_benefits_loan SET initial_paid = initial_paid + 1 WHERE id=?";
    //     $query = $this->db->query($sql, array($id));
    // }
    function DELETE_PAYSLIP_LOAN($id)
    {
        $sql = "DELETE FROM tbl_payroll_payslip_loan WHERE id=?";
        $this->db->query($sql, array($id));
    }

    function DELETE_PAYSLIP_OTHER_DEDUCTIONS($id)
    {
        $sql = "DELETE FROM tbl_payroll_payslip_otherdeductions WHERE id=?";
        $this->db->query($sql, array($id));
    }

    function DELETE_PAYSLIP_BY_ID($id)
    {
        $sql = "DELETE FROM tbl_payroll_payslips WHERE id=?";
        $this->db->query($sql, array($id));
    }

    function GET_ALL_LOAN_ID($id)
    {
        $sql   = "SELECT loan_id FROM tbl_payroll_payslip_loan WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        return $result ? $result->loan_id : null;
    }
    function GET_ALL_ID_FIXED_BENEFITS_TYPE($income_type)
    {
        $sql   = "SELECT id FROM tbl_benefits_fixed_type WHERE income_type=?";
        $query = $this->db->query($sql, array($income_type));
        $ids = array_column($query->result_array(), 'id');
        return $ids;
    }
    function GET_SPECIFIC_FIXED_BENEFITS($empl_id, $period, $id)
    {
        $sql   = "SELECT value FROM tbl_benefits_fixed_assign WHERE user_id=? AND period=? AND type=?";
        $query = $this->db->query($sql, array($empl_id, $period, $id));
        $result = $query->row();
        return $result ? $result->value : null;
        // return $query->result_object();
    }
    function GET_SPECIFIC_YEAR_ID($name)
    {
        $sql   = "SELECT id FROM tbl_std_years WHERE name=? ";
        $query = $this->db->query($sql, array($name));
        $result = $query->row();
        return $result ? $result->id : null;
    }
    function GET_SPECIFIC_SSS_CONTRIBUTION($empl_id, $year)
    {
        $sql   = "SELECT contibution_amount FROM tbl_custom_sss_contribution WHERE employee_id=? AND year=?";
        $query = $this->db->query($sql, array($empl_id, $year));
        $result = $query->row();
        return $result ? $result->contibution_amount : null;
    }
    function GET_SPECIFIC_PAGIBIG_CONTRIBUTION($empl_id, $year)
    {
        $sql   = "SELECT contibution_amount FROM tbl_custom_pagibig_contribution WHERE employee_id=? AND year=?";
        $query = $this->db->query($sql, array($empl_id, $year));
        $result = $query->row();
        return $result ? $result->contibution_amount : null;
    }
    function GET_SPECIFIC_PHILHEALTH_CONTRIBUTION($empl_id, $year)
    {
        $sql   = "SELECT contibution_amount FROM tbl_custom_philhealth_contribution WHERE employee_id=? AND year=?";
        $query = $this->db->query($sql, array($empl_id, $year));
        $result = $query->row();
        return $result ? $result->contibution_amount : null;
    }
    function GET_ALL_LEAVE_TYPE()
    {
        $sql = "SELECT name FROM tbl_std_leavetypes";
        $query = $this->db->query($sql);
        return $query->result();
    }
    function GET_SPECIFIC_LEAVE_ENTITLEMENT($empl_id, $year)
    {
        $sql   = "SELECT id, value, type FROM tbl_leave_entitlements WHERE empl_id=? AND year=? ";
        $query = $this->db->query($sql, array($empl_id, $year));
        return $query->result();
    }

    function GET_VALUE_LEAVE_ENTITLEMENT($empl_id, $type, $year)
    {
        $sql   = "SELECT value FROM tbl_leave_entitlements WHERE empl_id=? AND type=? AND year=? ";
        $query = $this->db->query($sql, array($empl_id, $type, $year));
        $result = $query->row();
        return $result ? $result->value : null;
    }
    function GET_EMPLOYEE_LEAVE($empl_id, $start_date, $end_date)
    {
        $sql   = "SELECT id, empl_id, status, duration FROM tbl_leaves_assign WHERE empl_id=? AND leave_date>=? AND leave_date<=? AND status='Approved' ";
        $query = $this->db->query($sql, array($empl_id, $start_date, $end_date));
        $query->next_result();
        return $query->result();
    }

    // function GET_SPECIFIC_TAXABLE_ALLOWANCE($empl_id, $period){
    //     $sql = "SELECT type, category, start_date, end_date FROM tbl_benefits_fixed_assign WHERE user_id=? AND period=?";
    //     $query = $this->db->query($sql, array($empl_id, $period));
    //     $query->next_result();
    //     return $query->result();
    // }

    function GET_SPECIFIC_TAXABLE_ALLOWANCE($empl_id)
    {
        $sql = "SELECT type, category, start_date, end_date, release_date FROM tbl_benefits_fixed_assign WHERE user_id=? ";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }
    function GET_PIONEER_TAXABLE_ALLOWANCE($empl_id)
    {
        $sql = "SELECT tb2.value as value FROM tbl_benefits_fixed_assign as tb1
        INNER JOIN  tbl_benefits_dynamic_std as tb2 ON tb1.category = tb2.id
        WHERE tb1.user_id=? and tb1.type = '4' AND tb1.is_deleted=0";
        $query = $this->db->query($sql, array($empl_id));
        $result = $query->result();

        if($result){
            return ($result[0])->value;
        }
       else{
        return 0;
       }
    }
    function GET_SKILLS_TAXABLE_ALLOWANCE($empl_id)
    {
        $sql = "SELECT tb2.value as value FROM tbl_benefits_fixed_assign as tb1
        INNER JOIN  tbl_benefits_dynamic_std as tb2 ON tb1.category = tb2.id
        WHERE tb1.user_id=? and tb1.type = '5' AND tb1.is_deleted=0";
        $query = $this->db->query($sql, array($empl_id));
        $result = $query->result();

        if($result){
            return ($result[0])->value;
        }
       else{
        return 0;
       }
    }
    function GET_POSITION_TAXABLE_ALLOWANCE($empl_id)
    {
        $sql = "SELECT tb2.value as value FROM tbl_benefits_fixed_assign as tb1
        INNER JOIN  tbl_benefits_dynamic_std as tb2 ON tb1.category = tb2.id
        WHERE tb1.user_id=? and tb1.type = '6' AND tb1.is_deleted=0";
        $query = $this->db->query($sql, array($empl_id));
        $result = $query->result();

        if($result){
            return ($result[0])->value;
        }
       else{
        return 0;
       }
    }

    function GET_SKILLS_TAXABLE_ALLOWANCE_FIX($empl_id)
    {
        $sql = "SELECT tb2.value as value FROM tbl_benefits_fixed_assign as tb1
        INNER JOIN  tbl_benefits_dynamic_std as tb2 ON tb1.category = tb2.id
        WHERE tb1.user_id=? and tb1.type = '7' AND tb1.is_deleted=0";
        $query = $this->db->query($sql, array($empl_id));
        $result = $query->result();

        if($result){
            return ($result[0])->value;
        }
       else{
        return 0;
       }
    }

    function GET_POSITION_TAXABLE_ALLOWANCE_FIX($empl_id)
    {
        $sql = "SELECT tb2.value as value FROM tbl_benefits_fixed_assign as tb1
        INNER JOIN  tbl_benefits_dynamic_std as tb2 ON tb1.category = tb2.id
        WHERE tb1.user_id=? and tb1.type = '8' AND tb1.is_deleted=0";
        $query = $this->db->query($sql, array($empl_id));
        $result = $query->result();

        if($result){
            return ($result[0])->value;
        }
       else{
        return 0;
       }
    }

    // function GET_SPECIFIC_NONTAXABLE_ALLOWANCE($empl_id, $period){
    //     $sql = "SELECT type, category, start_date, end_date FROM tbl_benefits_nontaxable_assign WHERE user_id=? AND period=?";
    //     $query = $this->db->query($sql, array($empl_id, $period));
    //     $query->next_result();
    //     return $query->result();
    // }

    function GET_SPECIFIC_NONTAXABLE_ALLOWANCE($empl_id)
    {
        $sql = "SELECT type, category, start_date, end_date, release_date FROM tbl_benefits_nontaxable_assign WHERE user_id=?";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }

    function GET_SPECIFIC_OTHER_DEDUCTIONS($empl_id, $period)
    {
        $sql = "SELECT * FROM tbl_other_deductions_assign WHERE user_id=? AND period=? AND is_deleted=0 ";
        $query = $this->db->query($sql, array($empl_id, $period));
        $query->next_result();
        return $query->result();
    }

    function GET_OTHER_DEDUCTION_TYPE_NAME($id)
    {
        $sql   = "SELECT name FROM tbl_other_deductions_type WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        return $result ? $result->name : null;
    }

    function GET_ALL_DEDUCTION_TYPE(){
        $sql = "SELECT name FROM tbl_other_deductions_type WHERE is_deleted=0";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function GET_TAXABLE_ALLOWANCE($empl_id)
    {
        $sql = "SELECT type, category FROM tbl_benefits_fixed_assign WHERE user_id=?";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }

    function GET_NONTAXABLE_ALLOWANCE($empl_id)
    {
        $sql = "SELECT type, category FROM tbl_benefits_nontaxable_assign WHERE user_id=?";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }

    function GET_TAXABLE_TYPE_ONETIME_ATTENDANCE($id)
    {
        $sql = "SELECT onetime_attendance FROM tbl_benefits_fixed_type WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        return $result ? $result->onetime_attendance : null;
    }

    function GET_NONTAXABLE_TYPE_ONETIME_ATTENDANCE($id)
    {
        $sql = "SELECT onetime_attendance FROM tbl_benefits_nontaxable_type WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        return $result ? $result->onetime_attendance : null;
    }

    function GET_TAXABLE_TYPE_NAME($id)
    {
        $sql = "SELECT name FROM tbl_benefits_fixed_type WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        return $result ? $result->name : null;
    }

    function GET_TAXABLE_CATEGORY_VALUE($id)
    {
        $sql = "SELECT value FROM tbl_benefits_dynamic_std WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        return $result ? $result->value : null;
    }

    function GET_NIGHSHIFT_CATEGORY_TAX_VALUE($id)
    {
        $sql = "SELECT value FROM tbl_benefits_nightshift_category_tax WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        return $result ? $result->value : null;
    }

    function GET_NIGHSHIFT_CATEGORY_NONTAX_VALUE($id)
    {
        $sql = "SELECT value FROM tbl_benefits_nightshift_category_nontax WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        return $result ? $result->value : null;
    }

    function GET_NONTAXABLE_CATEGORY_VALUE($id)
    {
        $sql = "SELECT value FROM tbl_benefits_nontaxable_std WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        return $result ? $result->value : null;
    }

    function GET_NONTAXABLE_TYPE_NAME($id)
    {
        $sql = "SELECT name FROM tbl_benefits_nontaxable_type WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        return $result ? $result->name : null;
    }

    function get_value_navbar()
    {
        $sql = "SELECT value FROM tbl_system_setup WHERE id = 3";
        // return $this->db->query($sql)->row();
        $query = $this->db->query($sql, array());
        $result = $query->row();
        return $result ? $result->value : null;
    }

    function delete_attendance_lock($empl_id, $cutoffPeriod)
    {
        $sql = "DELETE FROM tbl_attendance_records_lock WHERE empl_id=? AND period=?";
        $this->db->query($sql, array($empl_id, $cutoffPeriod));
    }

    function GET_ENTITLEMENT_DURATION($empl_id, $leave_id, $year)
    {
        $sql = "SELECT SUM(duration) AS total_duration FROM tbl_leaves_assign WHERE empl_id=? AND type=? AND YEAR(leave_date)=? AND status='Approved'";
        $query = $this->db->query($sql, array($empl_id, $leave_id, $year));
        $result = $query->row();

        if ($result) {
            return $result->total_duration;
        } else {
            return 0;
        }
    }

    function GET_LEAVE_ID($name)
    {
        $sql = "SELECT id FROM tbl_std_leavetypes WHERE name=?";
        $query = $this->db->query($sql, array($name));
        $result = $query->row();
        return $result ? $result->id : null;
    }

    function GET_GROSS_TAXABLE_INCOME($empl_id, $year)
    {
        $sql = "SELECT SUM(TAXABLE_INCOME) as taxable_income FROM `tbl_payroll_payslips`
        LEFT JOIN tbl_payroll_period ON tbl_payroll_payslips.PAYSLIP_PERIOD = tbl_payroll_period.id
        WHERE tbl_payroll_payslips.empl_id=? AND YEAR(tbl_payroll_period.date_from)=? ";
        $query = $this->db->query($sql, array($empl_id, $year));
        $result = $query->row();
        if ($result) {
            return $result->taxable_income;
        } else {
            return null;
        }
    }

    function GET_GROSS_NONTAX_INCOME($empl_id, $year)
    {
        $sql = "SELECT SUM(OTHER_TOTAL_NONTAX) as nontaxable_income FROM `tbl_payroll_payslips`
        LEFT JOIN tbl_payroll_period ON tbl_payroll_payslips.PAYSLIP_PERIOD = tbl_payroll_period.id
        WHERE tbl_payroll_payslips.empl_id=? AND YEAR(tbl_payroll_period.date_from)=? ";
        $query = $this->db->query($sql, array($empl_id, $year));
        $result = $query->row();
        if ($result) {
            return $result->nontaxable_income;
        } else {
            return null;
        }
    }


    function GET_GROSS_WTAX($empl_id, $year)
    {
        $sql = "SELECT SUM(WTAX) as wtax FROM `tbl_payroll_payslips`
        LEFT JOIN tbl_payroll_period ON tbl_payroll_payslips.PAYSLIP_PERIOD = tbl_payroll_period.id
        WHERE tbl_payroll_payslips.empl_id=? AND YEAR(tbl_payroll_period.date_from)=? ";
        $query = $this->db->query($sql, array($empl_id, $year));
        $result = $query->row();
        if ($result) {
            return $result->wtax;
        } else {
            return null;
        }
    }

    function GET_ALL_LOANS($empl_id)
    {
        $sql = "SELECT * FROM tbl_benefits_loan WHERE empl_id=?";
        $query = $this->db->query($sql, array($empl_id));
        $query->next_result();
        return $query->result();
    }

    function GET_PAYSLIP($empl_id, $period)
    {

        $periodIds = array();
        foreach ($period as $p) {
            $periodIds[] = $p['id'];
        }
        $periodIdsInClause = implode(",", $periodIds);

        if ($periodIdsInClause == null) {
            return;
        }
        $sql = "SELECT SUM(TOTAL_BASIC) AS BASIC_PAY FROM tbl_payroll_payslips WHERE empl_id=? AND PAYSLIP_PERIOD IN ({$periodIdsInClause})";
        $query = $this->db->query($sql, array($empl_id));
        $result = $query->row();
        if ($result) {
            return $result->BASIC_PAY;
        } else {
            return null;
        }
    }


    function GET_PAYROLL_PERIOD_YEAR($year)
    {
        $sql = "SELECT id FROM tbl_payroll_period WHERE YEAR(date_from)=?";
        $query = $this->db->query($sql, array($year));
        return $query->result_array();
    }

    function GET_PAYSLIP_COORDINATES($setting)
    {
        $sql = "SELECT value FROM tbl_payroll_coordinates WHERE setting=?";
        $query = $this->db->query($sql, array($setting));
        $return = $query->row();
        if ($return) {
            return $return->value;
        } else {
            return null;
        }
    }

    function UPDATE_COORDINATES($coordinates)
    {
        $datetime               = date('Y-m-d H:i:s');
        if ($coordinates) {
            foreach ($coordinates as $key => $value) {
                $sql_check = "SELECT COUNT(*) as count FROM tbl_payroll_coordinates WHERE setting = ?";
                $query_check = $this->db->query($sql_check, array($key));
                $row = $query_check->row();
                $count = $row->count;

                if ($count > 0) {
                    // if(!empty($value)){
                    $sql_update = "UPDATE tbl_payroll_coordinates SET edit_date=?, value=? WHERE setting=?";
                    $query_update = $this->db->query($sql_update, array($datetime, $value, $key));
                    // }
                } else {
                    $sql_insert = "INSERT INTO tbl_payroll_coordinates (create_date, edit_date, setting, value) VALUES (?,?,?,?)";
                    $query_insert = $this->db->query($sql_insert, array($datetime, $datetime, $key, $value));
                }
            }
        }
    }

    function GET_ALL_PAYROLL_PAYSLIP($period, $status)
    {
        $sql = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=? AND status=?";
        $query = $this->db->query($sql, array($period, $status));
        return $query->result();
    }

    // function GET_EMPLOYEE_PAYROLL_PAYSLIP($empl_id, $status)
    // {
    //     $empl_id = 'null';
    //     $sql = "SELECT tbl_payroll_payslips.*, tbl_payroll_period.name AS PERIOD_NAME  FROM tbl_payroll_payslips 
    //     LEFT JOIN tbl_payroll_period ON tbl_payroll_payslips.PAYSLIP_PERIOD=tbl_payroll_period.id
    //     WHERE tbl_payroll_payslips.empl_id = ? 
    //     AND tbl_payroll_payslips.status = ?";

    //     $query = $this->db->query($sql, array($empl_id, $status));
    //     return $query->result();
    // }

    function GET_EMPLOYEE_PAYROLL_PAYSLIP($empl_id, $status, $start_date, $end_date, $salary_type)
    {
        $sql = "SELECT tbl_payroll_payslips.*, tbl_payroll_period.name AS PERIOD_NAME  
                FROM tbl_payroll_payslips 
                LEFT JOIN tbl_payroll_period ON tbl_payroll_payslips.PAYSLIP_PERIOD = tbl_payroll_period.id
                WHERE tbl_payroll_payslips.status = ? ";

        $params = array($status);

        if ($empl_id != 'all') {
            $sql .= " AND tbl_payroll_payslips.empl_id = ?";
            $params[] = $empl_id;
        }

        $sql .= " AND tbl_payroll_period.date_to >= ? AND tbl_payroll_period.date_from <= ? ";
        $params[] = $start_date;
        $params[] = $end_date;

        if($salary_type == 'Daily'){
            $sql .= " AND tbl_payroll_payslips.PAYSLIP_SALARY_TYPE = ? ";
            $params[] = 'Daily';
        }

        $sql .= " ORDER BY PAYSLIP_EMPLOYEE_CMID + 0 ASC, tbl_payroll_payslips.id ASC";

        $query = $this->db->query($sql, $params);
        return $query->result();
    }


    function GET_ALL_PAYROLL_PAYSLIP_2($period, $status, $salary_type)
    {
        $sql = "SELECT * FROM tbl_payroll_payslips WHERE PAYSLIP_PERIOD=? AND status=? AND PAYSLIP_SALARY_TYPE=?";
        $query = $this->db->query($sql, array($period, $status, $salary_type));
        return $query->result();
    }

    function GET_PAYSLIP_FORM($id)
    {
        $sql = "SELECT * FROM tbl_payroll_payslip_image WHERE id=?";
        $query = $this->db->query($sql, array($id));
        $return = $query->row();

        if ($return) {
            return $return->image;
        } else {
            return null;
        }
    }

    function INSERT_PAYSLIP_IMAGE($old_image, $new_img)
    {
        $datetime               = date('Y-m-d H:i:s');

        $sql = "SELECT * FROM tbl_payroll_payslip_image WHERE image=?";
        $query = $this->db->query($sql, array($old_image));
        $result = $query->num_rows();

        if ($result > 0) {
            $sql = "UPDATE tbl_payroll_payslip_image SET image=? WHERE image=?";
            $query = $this->db->query($sql, array($new_img, $old_image));
        } else {
            $sql_insert = "INSERT INTO tbl_payroll_payslip_image (create_date, edit_date, image) VALUES (?,?,?)";
            $query_insert = $this->db->query($sql_insert, array($datetime, $datetime, $new_img));
        }
    }


    function GET_BENEFITS_ADJUSTMENT_ASSIGN($empl_id, $period)
    {
        $sql = "SELECT id,user_id, type, value,value_hour FROM tbl_benefits_adjustment_assign WHERE is_deleted=0 AND user_id=? AND period = ?";
        $query = $this->db->query($sql, array($empl_id, $period));
        return $query->result();
    }

    function GET_BENEFITS_ADJUSTMENT_ASSIGN_2($period, $type)
    {
        $sql = "SELECT id,user_id,value,value_hour FROM tbl_benefits_adjustment_assign WHERE is_deleted=0 AND period=? AND type = ?";
        $query = $this->db->query($sql, array($period, $type));
        $query->next_result();
        return $query->result();
    }

    function GET_ALL_TAX_TANSPORTATION_ALLOWANCE($empl_id)
    {
        $sql = "SELECT nightshift_category FROM tbl_benefits_nightshift_allowance WHERE user_id=?";
        $query = $this->db->query($sql, array($empl_id));
        if ($query) {
            return $query->result();
        } else {
            return null;
        }
    }

    function GET_ALL_NONTAX_TANSPORTATION_ALLOWANCE($empl_id)
    {
        $sql = "SELECT nightshift_category FROM tbl_benefits_nightshift_allowance_nontax WHERE user_id=?";
        $query = $this->db->query($sql, array($empl_id));
        return $query->result();
    }

    function GET_SYSTEM_SETUP_SETTING($setting)
    {
        $query_select = "SELECT value FROM tbl_system_setup WHERE setting=?";
        $result = $this->db->query($query_select, array($setting))->row_array();
        return $result ? $result['value'] : null;
    }

    function GET_ADJUSTMENT_TYPE_LIST()
    {
        $sql = "SELECT * FROM tbl_benefits_adjustment_type";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function GET_ADJUSTMENT_VALUE_TYPE($setting){
        $sql = "SELECT value FROM tbl_system_setup WHERE setting=?";
        $query = $this->db->query($sql, array($setting));
        $result = $query->row_array();
        if($result){
            return $result['value'];
        }else{
            return null;
        }
    }

    function GET_ADJ_EMPLOYEELIST()
    {
        $sql = "SELECT id, col_empl_cmid, CONCAT(col_last_name,', ',col_frst_name) as fullname FROM tbl_employee_infos WHERE (termination_date IS NULL || termination_date = '0000-00-00' ) AND disabled=0 ORDER BY col_empl_cmid ASC";
        $query = $this->db->query($sql);
        $query->next_result();
        return $query->result();
    }

    function UPDATE_ADJUSTMENT_DATA($data, $period, $type)
    {
        $user_id                = $data[1];
        $value                  = $data[2];
        // $value_hour             = $data[3];
        $datetime               = date('Y-m-d H:i:s');

        $currency_hour = $this->GET_ADJUSTMENT_TYPE($type);
        $curr_hour = '';
        if($currency_hour && $currency_hour == 'Currency'){
            $curr_hour  = 'Currency';
        }elseif($currency_hour && $currency_hour == 'Hour'){
            $curr_hour  = 'Hour';
        }
        
        if ($user_id != "") {
            $result = $this->is_adjustment_duplicate_data($user_id, $period, $type);
            if ($result > 0) {
                $sql = " UPDATE tbl_benefits_adjustment_assign SET edit_date=?, value=? WHERE user_id=? AND period=? AND type=? AND value_hour=?";
                $this->db->query($sql, array($datetime, $value, $user_id, $period, $type, $curr_hour));
            } else {
                $sql = "INSERT INTO tbl_benefits_adjustment_assign (create_date, edit_date, user_id, period, type, value, value_hour) VALUES(?,?,?,?,?,?,?)";
                $this->db->query($sql, array($datetime, $datetime, $user_id, $period, $type, $value, $curr_hour));
            }
        }
    }

    function is_adjustment_duplicate_data($user_id, $period, $type)
    {
        $sql = "SELECT id FROM tbl_benefits_adjustment_assign WHERE user_id=? AND period=? AND type=? ";
        $query = $this->db->query($sql, array($user_id, $period, $type));
        return $query->num_rows();
    }

    function GET_ADJUSTMENT_TYPE($id){
        $sql = "SELECT currency_hour FROM tbl_benefits_adjustment_type WHERE id=?" ;
        $query = $this->db->query($sql, array($id));
        $result = $query->row();
        if ($result) {
            return $result->currency_hour;
        } else {
            return null;
        }
    }

    function DELETE_ADJUSTMENT_DATA($data)
    {
        $id                 = $data['id'];
        $delete             = '1';
        $datetime           = date('Y-m-d H:i:s');
        $sql = " UPDATE tbl_benefits_adjustment_assign SET edit_date=?, is_deleted=? WHERE id=?";
        $this->db->query($sql, array($datetime, $delete, $id));
    }

    function GET_BENEFITS_ADJUSTMENT_TYPE()
    {
        $sql = "SELECT id,name,currency_hour FROM tbl_benefits_adjustment_type";
        $query = $this->db->query($sql, array());
        $query->next_result();
        return $query->result();
    }

    function UPDATE_ADJUSTMENT_TYPE($data)
    {
        $id             = $data[0];
        $name           = $data[1];
        $currency_hour  = $data[2];
        $datetime       = date('Y-m-d H:i:s');
        if ($id != null) {
            $sql = " UPDATE tbl_benefits_adjustment_type SET edit_date=?, name=?, currency_hour=? WHERE id=? ";
            $this->db->query($sql, array($datetime, $name, $currency_hour , $id));
        } else {
            $sql = "INSERT INTO tbl_benefits_adjustment_type (create_date, edit_date, name, currency_hour) VALUES(?,?,?,?)";
            $this->db->query($sql, array($datetime, $datetime, $name, $currency_hour));
        }
    }


} // end class payrolls_model extends CI_Model ===========================================
