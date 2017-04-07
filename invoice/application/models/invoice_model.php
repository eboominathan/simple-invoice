<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice_model extends CI_Model{

    Public function get_invoice()
    {
        return $this->db->where('status',1)->get('invoice_main')->result();
    }
    Public function get_invoice_data()
    {
        return $this->db->get_where('invoice_details',array('invoice_id'=>$_POST['invoice_id']))->result();
    }

    Public function insert_invoice()
    {
        
      $item_name = $_POST['item'];
      $rate = $_POST['rate'];
      $quantity = $_POST['quantity'];
      $tax = $_POST['tax'];
      $amount = $_POST['amount'];


      $invoice_id = $this->last_invoice_id();
      $invoice_id++;
      $datas = array(
        'invoice_id' =>$invoice_id,
        'status'=>1
        );
      $this->db->insert('invoice_main',$datas);
      for ($i=0; $i <count($item_name) ; $i++) { 
        $data=array(
            'invoice_id' =>$invoice_id,
            'customer_name'=>'Boomi',
            'date'=>date('d-m-Y'),
            'name'=>$item_name[$i],
            'rate'=>$rate[$i],
            'quantity'=>$quantity[$i],
            'tax'=>$tax[$i],
            'amount'=>$amount[$i],
            'sub_total'=>$_POST['sub_total'],
            'o_tax'=>$_POST['o_tax'],
            'grand_total'=>$_POST['grand_total'],
            'status'=>1
            );

        $this->db->insert('invoice_details',$data);
    }

    
    return($this->db->affected_rows()!=1)?false:true;

}

Public function last_invoice_id()
{
    return $this->db->get('invoice_main')->row()->invoice_id;
}
}