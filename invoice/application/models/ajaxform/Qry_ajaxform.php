<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qry_ajaxform extends CI_Model{
   
    protected $res = "";
    protected $stat = "";

    public function __construct() {
        parent::__construct();
    }
    
    public function select_data() {
        $this->db->where('status',1);
        $query = $this->db->get('item_details');
        if ($query->num_rows() > 0)
        {
            return $query->result();
        } else {
            return false;
        }

    }
    
    public function set_data() {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->where('status',1);
        $query = $this->db->get('item_details');
        
        foreach ($query->result_array() as $row)
        {
            $res=array(
                'id' => $row['id'],
                'item_name' => $row['item_name'],
                'rate' => $row['rate'],
                'tax' => $row['tax']               
            );
        }
        return json_encode($res); 
    }
    
    public function submit() {
        try {
               
                $id=$this->input->post('id');
                $stat=$this->input->post('stat');
                $data = array( 
                    'date'=>date('d-m-Y'),
                    'item_name' => $this->input->post('item_name'),
                    'rate' => $this->input->post('rate'),
                    'tax' => $this->input->post('tax'),
                    'status'=>1                   
                );  

                if(empty($id)){
                    $resl = $this->db->insert('item_details', $data);
                    if( ! $resl){
                        $err = $this->db->error();
                        $this->res = "<i class=\"fa fa-fw fa-warning\"></i> Error : ". $this->apps->err_code($err['message']);
                        $this->stat = "0";
                    }else{
                        $this->res = "<label class=\"label label-success\">Date Inserted Successfully</label>";
                        $this->stat = "1";
                    }
                    
                }
                elseif(!empty($id) && empty($stat))
                {

                    $this->db->where('id', $id);
                    $resl = $this->db->update('item_details', $data);
                    if( ! $resl){
                        $err = $this->db->error();
                        $this->res = "<i class=\"fa fa-fw fa-warning\"></i> Error : ". $this->apps->err_code($err['message']);
                        $this->stat = "0";
                    }else{
                        $this->res = "<label class=\"label label-success\">Data Updated</label>";
                        $this->stat = "1";
                    }

                }elseif(!empty($id) && !empty($stat)){
                    $this->db->where('id', $id);
                    $resl = $this->db->update('item_details',array('status'=>0));

                    if( ! $resl){
                        $err = $this->db->error();
                        $this->res = "Error : ". $this->apps->err_code($err['message']);
                        $this->stat = "0";
                    }else{
                        $this->res = "Data deleted!";
                        $this->stat = "1";
                    }
                    
                }else{
                    $this->res = "<label class=\"label label-danger\">Failed</label>";
                    $this->stat = "0";
                }

        }
        catch (Exception $e) {            
            $this->res = "<label class=\"label label-danger\">".$e->getMessage()."</label>";
            $this->stat = "0";
        }
        
        $arr = array(
            'stat' => $this->stat, 
            'msg' => $this->res,
            );
        
        return  json_encode($arr);
    }
}
