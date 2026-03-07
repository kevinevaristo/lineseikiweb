<?php 

    class uploaders_model extends CI_Model 
    {
        
        function ADD_DATA_FILE($data){
            return $this->db->insert('tbl_uploads',$data);
        }
        function GET_ALL_UPLOADS($limit, $offset,$user_id,$file_location) {
            $this->db->where('empl_id',$user_id);
            $this->db->like('file_name',$file_location);
            $this->db->limit($limit, $offset);
            $this->db->order_by('id','desc');
            $query = $this->db->get('tbl_uploads');
            return $query->result();
        }
        function GET_FILES_COUNT($user_id,$file_location){
            $this->db->where('empl_id',$user_id);
            $this->db->like('file_name',$file_location);
            $query=$this->db->get('tbl_uploads');
            return $query->num_rows();
        }
        function SEARCH_FILES($query,$location,$user_id){
            $this->db->where("empl_id = '$user_id' AND file_name LIKE '%$location%' AND
            ( file_original_name LIKE '%$query%' OR type LIKE '%$query%' OR extension LIKE '%$query%' )");
            // $this->db->where('empl_id',$user_id);
            // $this->db->like('file_name',$location);
            // $ths->db->group_start();
            //     $this->db->like('file_original_name',$query);
            //     $this->db->or_like('type', $query);
            // $ths->db->group_end();
            $query = $this->db->get('tbl_uploads');
            return $query->result();
        }
        function DELET_DATA_FILE($file,$user_id){
            $this->db->where('empl_id',$user_id);
            $this->db->where('file_name',$file);
            return $this->db->delete('tbl_uploads');
        }
    }