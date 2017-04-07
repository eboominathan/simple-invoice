<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Invoice extends CI_Controller{
   
 public function __construct()
    {
        parent::__construct();
        $this->load->model('invoice_model');
        date_default_timezone_set('Asia/Calcutta');
    }

    
   
    public function index() {
        
        $this->load->view('design/header');
        $this->load->view('invoice/index');
        $this->load->view('design/footer');
    }

    public function insert_invoice()
    {
    	
    	$result=$this->invoice_model->insert_invoice();
    	if($result)
    	{
    		$this->session->set_flashdata('msg','Invoice Added Successfully');
    		redirect('invoice');
    	}
    	else
    	{
    		$this->session->set_flashdata('Msg','Invoice Adding Failed ');
    		redirect('invoice');
    	}
    }
    public function invoice_reports()
    {
        $data['invoice'] = $this->invoice_model->get_invoice();     
        $this->load->view('design/header',$data);
        $this->load->view('invoice/invoice_reports');
        $this->load->view('design/footer');
    }
    public function get_invoice_data()
    {
        $invoice = $this->invoice_model->get_invoice_data();  
        $j=1;
        foreach($invoice as $i){
            $data['id'] = $j++;
            $data['name'] = $i->name;
            $data['rate'] = $i->rate;
            $data['tax'] = $i->tax;
            $data['quantity'] = $i->quantity;
            $data['amount'] = $i->amount;
            $result[]=$data;
        }  	
        echo json_encode($result);
    	
    }
    public function delete_invoice()
    {
    	$this->db->where('id',$_POST['id']);
    	$this->db->update('invoice_main',array('status'=>0));
    	$result=($this->db->affected_rows()!=1)?false:true;
    	if($result)
    	{
    		$this->session->set_flashdata('msg1','Invoice deleted Successfully');
    		redirect('invoice/invoice_reports');
    	}
    	else
    	{
    		$this->session->set_flashdata('Msg1','Invoice delete Failed ');
    		redirect('invoice/invoice_reports');
    	}
    }
}

