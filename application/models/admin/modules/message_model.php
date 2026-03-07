<?php
class message_model extends CI_Model
{
    function GET_MESSAGES($limit,$offset,$tab){
        $this->db->select('id, create_date,title,message,mobile_number,schedule_date,status');
        $this->db->from('tbl_messaging_sms');
        $this->db->where('status',$tab);
        $this->db->limit($limit, $offset);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result_object();
    }
    function GET_MESSAGES_INFO_SEARCH($limit,$offset,$tab,$search){
        $find = array('title' => $search, 'message' => $search, 'mobile_number' => $search);
        $this->db->select('id, col_last_name,col_midl_name,col_frst_name,col_empl_cmid,title,message,mobile_number,schedule_date,status');
        $this->db->from('tbl_messaging_sms');
        $this->db->or_like($find);

        $this->db->limit($limit, $offset);
        $this->db->order_by('tb1.id', 'desc');
        $query = $this->db->get();
        return $query->result_object();
    }
    function GET_COUNT_MESSAGES($tab){
        $this->db->select('tb1.id as id, col_last_name,col_midl_name,col_frst_name,col_empl_cmid,title,message,mobile_number,schedule_date,tb1.status as status');
        $this->db->from('tbl_messaging_sms as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id');
        $this->db->where('tb1.status',$tab);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function GET_COUNT_MESSAGES_SEARCH($tab,$search){
        $find = array('title' => $search, 'message' => $search, 'mobile_number' => $search);
        $this->db->select('tb1.id as id, col_last_name,col_midl_name,col_frst_name,col_empl_cmid,title,message,mobile_number,schedule_date,tb1.status as status');
        $this->db->from('tbl_messaging_sms as tb1');
        $this->db->join('tbl_employee_infos as tb2', 'tb1.empl_id=tb2.id');
        $this->db->or_like($find);
        $this->db->where('tb1.status',$tab);
        $query = $this->db->get();
    }
    function ADD_NEW_MESSAGE($message_info){

        // Get the current datetime
$currentDateTime = new DateTime();

// Add 15 hours to the datetime
$newDateTime = $currentDateTime->sub(new DateInterval('PT0H'));

// Print the new datetime
$datetime =  $newDateTime->format('Y-m-d H:i:s');

        $data = array(
        'title'         => $message_info['insrt_title'],
        'message'       => $message_info['insrt_message'],
        'mobile_number' => $message_info['insrt_mobile_num'],
        'empl_id'       => $message_info['insrt_employee'],
        'create_date'       => $datetime,
        );
        return $this->db->insert('tbl_messaging_sms', $data);
    }
    function UPDATE_BULK_ACTIVATE($data,$table){
         return $this->db->update_batch('tbl_messaging_sms',$data, 'id');
    }
    function GET_SPE_MESSAGE($id){
        $query = $this->db->get('tbl_messaging_sms');
        return $query->row();
        
        
    }
}