<?php
class assets_model extends CI_model
{
    function ADD_DATA($table_name, $data)
    {
        return $this->db->insert($table_name, $data);
    }

    function MOD_DISP_ASSETS($limit, $offset, $status)
    {
        $this->db->select('id,col_asset_name,col_asset_description,col_asset_serial,col_asset_category,col_asset_location,col_asset_assigned_to,col_asset_warranty_exp, status')
            ->where('status', $status)
            ->where('is_deleted', '0')
            ->limit($limit, $offset)
            ->order_by('id', 'DESC');
        $query = $this->db->get('tbl_asset_assign');
        return $query->result();
    }

    function CHECK_STATUS($table_name)
    {
        $this->db->select('status')
            ->where('is_deleted', '0');
        $query = $this->db->get($table_name);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    function MOD_DISP_ASSET($id)
    {
        $this->db->select('aa.*, ei.col_empl_cmid, ei.col_frst_name, ei.col_last_name, lc.name AS location_name, lc.id AS location_id, ac.name AS asset_category_name, ac.id AS asset_category_id');
        $this->db->from('tbl_asset_assign as aa');
        $this->db->join('tbl_employee_infos as ei', 'aa.col_asset_assigned_to = ei.id', 'left');
        $this->db->join('tbl_std_companylocations as lc', 'aa.col_asset_location = lc.id', 'left');
        $this->db->join('tbl_std_assetcategories as ac', 'aa.col_asset_category = ac.id', 'left');
        $this->db->where('aa.id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    function UPDATE_ASSET($id, $table, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($table, $data);
    }



    function delete_data($id, $table_name)
    {
        $this->db->set('is_deleted', 1);
        $this->db->where('id', $id);
        return $this->db->update($table_name);
    }



    function get_employees()
    {
        $this->db->select('id, col_last_name, col_midl_name, col_frst_name, col_empl_cmid');
        $query = $this->db->get('tbl_employee_infos');
        return $query->result();
    }

    public function get_all_assets_info($limit, $offset, $status, $search_query, $row)
    {
        $this->db->select('aa.*, ei.col_empl_cmid, ei.col_frst_name, ei.col_last_name, lc.name AS location_name, lc.id AS location_id, ac.name AS asset_category_name, ac.id AS asset_category_id');
        $this->db->from('tbl_asset_assign as aa');
        $this->db->join('tbl_employee_infos as ei', 'aa.col_asset_assigned_to = ei.id', 'left');
        $this->db->join('tbl_std_companylocations as lc', 'aa.col_asset_location = lc.id', 'left');
        $this->db->join('tbl_std_assetcategories as ac', 'aa.col_asset_category = ac.id', 'left');

        if ($status) {
            $this->db->where('aa.status', $status);
        }

        if ($search_query) {


            $this->db->like('ei.col_frst_name', $search_query);
            $this->db->or_like('ei.col_last_name', $search_query);
            $this->db->or_like('lc.name', $search_query);
            $this->db->or_like('ac.name', $search_query);
            $this->db->or_like('aa.col_asset_name', $search_query);
            $this->db->or_like('aa.col_asset_serial', $search_query);
        }

        $this->db->order_by('aa.id', 'DESC');
        $this->db->limit($row, $offset);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }



    function GET_ASSETS_COUNT($status, $search_query)
    {
        $this->db->select('aa.*, ei.col_empl_cmid, ei.col_frst_name, ei.col_last_name, lc.name AS location_name, lc.id AS location_id, ac.name AS asset_category_name, ac.id AS asset_category_id');
        $this->db->from('tbl_asset_assign as aa');
        $this->db->join('tbl_employee_infos as ei', 'aa.col_asset_assigned_to = ei.id', 'left');
        $this->db->join('tbl_std_companylocations as lc', 'aa.col_asset_location = lc.id', 'left');
        $this->db->join('tbl_std_assetcategories as ac', 'aa.col_asset_category = ac.id', 'left');

        if ($status) {
            $this->db->where('aa.status', $status);
        }

        if ($search_query) {

            $this->db->like('ei.col_empl_cmid', $search_query);
            $this->db->or_like('ei.col_frst_name', $search_query);
            $this->db->or_like('ei.col_last_name', $search_query);
            $this->db->or_like('lc.name', $search_query);
            $this->db->or_like('ac.name', $search_query);
            $this->db->or_like('aa.col_asset_name', $search_query);
            $this->db->or_like('aa.col_asset_serial', $search_query);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function ADD_ASSET($input_data)
    {
        $this->db->insert('tbl_asset_assign', $input_data);
        return $this->db->insert_id();
    }


    function MOD_DISP_LOCATION($limit, $offset, $status, $search_query)
    {
        $query = $this->db->select('id, name')
            ->where('status', $status)
            ->where('is_deleted', '0');

        if ($search_query) {
            $this->db->like('name', $search_query);
        }
        $this->db->order_by('id', 'DESC')
            ->limit($limit, $offset);

        $query = $this->db->get('tbl_std_companylocations');

        if ($search_query) {
            $this->db->like('name', $search_query);
        }
        return $query->result();
    }

    function MOD_DISP_LOCATIONS()
    {
        $this->db->select('id,name')
            ->where('is_deleted', '0')
            ->order_by('id', 'DESC');
        $query = $this->db->get('tbl_std_companylocations');

        return $query->result();
    }

    function MOD_DISP_LOCATIONS_BY_ID($id)
    {
        $this->db->select('id, name')
            ->where('is_deleted', 0)
            ->where('id', $id);

        $query = $this->db->get('tbl_std_companylocations');

        return $query->row();
    }
    function MOD_DISP_LOCATION_COUNT($status)
    {
        $this->db->select('*')
            ->where('status', $status);
        $query = $this->db->get('tbl_std_companylocations');
        return $query->num_rows();
    }


    function MOD_DISP_STOCKROOM($limit, $offset, $status, $search_query)
    {
        $query = $this->db->select('id, name')
            ->where('status', $status)
            ->where('is_deleted', '0');

        if ($search_query) {
            $this->db->like('name', $search_query);
        }
        $this->db->order_by('id', 'DESC')
            ->limit($limit, $offset);

        $query = $this->db->get('tbl_std_stockrooms');

        if ($search_query) {
            $this->db->like('name', $search_query);
        }
        return $query->result();
    }

    function MOD_DISP_STOCKROOM_BY_ID($id)
    {
        $this->db->select('id, name')
            ->where('is_deleted', 0)
            ->where('id', $id);

        $query = $this->db->get('tbl_std_stockrooms');

        return $query->row();
    }



    function GET_STOCKROOM_ASSETS_COUNT($status)
    {
        $this->db->select('*')
            ->where('status', $status);
        $query = $this->db->get('tbl_std_stockrooms');
        return $query->num_rows();
    }

    function MOD_DISP_AST_CAT($limit, $offset, $status, $search_query)
    {
        $query = $this->db->select('id, name')
            ->where('status', $status)
            ->where('is_deleted', '0');

        if ($search_query) {
            $this->db->like('name', $search_query);
        }
        $this->db->order_by('id', 'DESC')
            ->limit($limit, $offset);

        $query = $this->db->get('tbl_std_assetcategories');

        if ($search_query) {
            $this->db->like('name', $search_query);
        }
        return $query->result();
    }

    function MOD_DISP_AST_CATEGORIES()
    {
        $this->db->select('id,name')
            ->where('is_deleted', '0');
        $query = $this->db->get('tbl_std_assetcategories');
        return $query->result();
    }


    function GET_AST_CAT_COUNT($status)
    {
        $this->db->select('*')
            ->where('status', $status);
        $query = $this->db->get('tbl_std_assetcategories');
        return $query->num_rows();
    }

    function MOD_DISP_CATEGORY_BY_ID($id)
    {
        $this->db->select('id, name')
            ->where('is_deleted', 0)
            ->where('id', $id);

        $query = $this->db->get('tbl_std_assetcategories');

        return $query->row();
    }

    public function search_assets($search)
    {

        $this->db->like('col_asset_name', $search);
        $this->db->or_like('col_asset_serial', $search);
        $query = $this->db->get('tbl_asset_assign');
        return $query->result();
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
}
