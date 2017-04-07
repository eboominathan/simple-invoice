<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajaxform extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->library('table');
    }
  
    public function index() {
        $this->load->model('ajaxform/qry_ajaxform');
        $data['tabel'] = $this->qry_ajaxform->select_data();
        
        $this->load->view('design/header');
        $this->load->view('ajaxform/index',$data);
        $this->load->view('design/footer');
    }
    
    public function submit() {
        $this->load->model('ajaxform/qry_ajaxform');
        $res = $this->qry_ajaxform->submit();
        echo $res;
    }
    
    public function set_data() {
        $this->load->model('ajaxform/qry_ajaxform');
        $res = $this->qry_ajaxform->set_data();
        echo $res;
    }

    public function autocomplete()
    {
        $item_name=$this->input->post('name');
        
        $this->db->select('*');
        $this->db->from('item_details');
        $this->db->like('item_name',$item_name);
        $this->db->where('status',1);
        $query = $this->db->get();
        $result = $query->result();

        $name       =  array();
        foreach ($result as $d) {
        $json_array             = array();
        $json_array['value']    = $d->item_name;
        $json_array['label']    = $d->item_name;
        $name[]             = $json_array;
        }
        echo json_encode($name);
    }

    public function get_contents()
    {
        
        $item_name=$this->input->post('name');
        
        $this->db->select('*');
        $this->db->from('item_details');
        $this->db->where('item_name',$item_name);
        $this->db->where('status',1);
        $query = $this->db->get();
        $result = $query->result();

        foreach ($result as $d) {
    
        $data['rate']    = $d->rate;
        $data['tax']    = $d->tax;      
        }
        echo json_encode($data);
    }
}
