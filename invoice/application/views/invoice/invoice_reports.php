<style type="text/css">
  .modal-header{
    background-color: #367fa9;
    color: #fff;
  }
</style>
  <!--  Notification  -->
        <?php $msg = $this->session->flashdata('msg1'); if((isset($msg)) && (!empty($msg))) { ?>
        <div class="alert alert-danger" >
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <b><?php print_r($msg); ?></b>
        </div>
        <?php } ?>

    <section class="content">
      <div class="row">
        <div class="col-lg-12">
          <!-- general form elements -->     
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Invoice reports</h3>
            </div><!-- /.box-header -->
            <div class="box-body">  
                <table class="table table-bordered table-hover">
              <thead>
                  <tr>
                    <td>Id</td>
                    <td>Date</td>
                    <td>Invoice Id</td>                     
                    <td>View</td> 
                    <td>Delete</td>
                </tr>
              </thead>
              <tbody>              
                  <?php
                  $i=1;
                    if(!empty($invoice)){
                        foreach ($invoice as $val){
                                echo "<tr>
                                <td>".$i++."</td>
                                <td>".date('d-m-Y h:i A',strtotime($val->last_updated))."</td>
                                <td> INVOICEOOO".$val->invoice_id."</td>                                
                                <td><a href='#' onclick='show(".$val->invoice_id.")' class='btn btn-primary'>View</button></td>       
                                <td><a href='#delete_".$val->id."'class='btn btn-danger' data-toggle='modal'>Delete</button></td>
                              </tr>";
                        }
                    }
                  ?>    
              </tbody>
          </table>
            </div>

            <script type="text/javascript">
              function show(invoice_id){
                $('#invoice_data').html('');  
                $('#myModal').modal('show');
                $.post('<?php echo base_url(); ?>invoice/get_invoice_data',{invoice_id:invoice_id},function(res){
                  var obj=jQuery.parseJSON(res);
                  var tr;
                  $(obj).each(function(){

                   tr += '<tr>'+
                              '<td>'+this.id+'</td>'+
                              '<td>'+this.name+'</td>'+
                              '<td>'+this.rate+'</td>'+
                              '<td>'+this.tax+'</td>'+
                              '<td>'+this.quantity+'</td>'+
                              '<td>'+this.amount+'</td>'+
                            '</tr>'

                  });
                  $('#invoice_data').append(tr);
                });
              }
            </script>

            <!--view  Modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="width:800px;margin-left:-120px">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Invoice Item details</h4>
      </div>
      <div class="modal-body">
       <table class="table table-bordered table-hover">
              <thead>
                  <tr>
                    <td>Id</td>                  
                    <td>Item</td>
                    <td>Rate</td>  
                    <td>Tax</td>  
                    <td>Quantity</td>  
                    <td>Amount</td>  
                   
                </tr>
              </thead>
              <tbody id="invoice_data">              
                    
              </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Happy to help!</button>
       
      </div>
    </div>
  </div>
</div>


<!--Delete Modal -->
<?php if(!empty($invoice)){
                        foreach ($invoice as $v){?>
<div class="modal fade" id="delete_<?php echo $v->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Warning !</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger" align="center">
        Are you sure to delete !
        </div>
        <div align="center">
            <form action="<?php echo site_url('invoice/delete_invoice');?>" method="post">
            <input type="hidden" value="<?php echo $v->id;?>" name="id">
            <button type="submit" class="btn btn-primary">yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
            </form>
        </div>

       </div>
      <div class="modal-footer">
            
      </div>
    </div>
  </div>
</div>
<?php } } ?>