
<script>
function submit_data()
{
    var id=$('#id').val();
    var item_name = $("#item_name").val();
    var rate = $("#rate").val();
    var tax = $("#tax").val();   
    var submit = $("#form_add").attr('action');   

    $.ajax({
        type: "POST",
        url: submit,
        data: {"id":id,"item_name":item_name
                ,"rate":rate,"tax":tax},
        success: function(resp){   
            var obj = jQuery.parseJSON(resp);
            $("#myResponDeptLabel").html(obj.msg);
            if(obj.stat==="1"){
                $('#mod_add').modal('hide');
                location.reload();
            }
        },
        error:function(event, textStatus, errorThrown) {
            $("#myResponDeptLabel").html('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
}

function cancel(){
       
    $("#item_name").val('');
    $("#tax").val('');
    $("#rate").val('');
  
}

function set_data(id){
    $.ajax({
        type: "POST",
        url: "<?=site_url('ajaxform/set_data');?>",
        data: {"id":id},
        success: function(resp){
            var obj = jQuery.parseJSON(resp);
            $("#id").val(obj.id);      
            $("#item_name").val(obj.item_name);
            $("#rate").val(obj.rate);
            $("#tax").val(obj.tax);
            $('#mod_add').modal({
                backdrop: 'static'
              });
            $('#mod_add').modal('show'); 
        },
        error:function(event, textStatus, errorThrown) {
            $("#myResponDeptLabel").html('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
}

function del_data(id){
    var r=confirm("Are you sure to Delete data ?");
    if (r===true)
      {
          $.ajax({
                type: "POST",
                url: "<?=site_url('ajaxform/submit');?>",
                data: {"id":id,"stat":"delete"},
                success: function(resp){
                    var obj = jQuery.parseJSON(resp);
                    alert(obj.msg);
                    if(obj.stat==="1"){
                        location.reload();
                    }
                },
                error:function(event, textStatus, errorThrown) {
                    $("#myResponDeptLabel").html('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
      }
}
</script>

<div class="box box-primary">
    <div class="box-header">
      <h3 class="box-title">Item Details</h3>
    </div><!-- /.box-header -->
      <div class="box-body">
          <table class="table table-bordered table-hover">
              <thead>
                  <tr>
                    <td style="width: 10px;">Id</td>
                    <td style="width: 250px;">Item Name</td>
                    <td style="width: 10px;">Rate</td>
                    <td style="width: 10px;">Tax</td>                
                    <td style="width: 10px;">Edit</td>
                    <td style="width: 10px;">Delete</td>
                </tr>
              </thead>
              <tbody>
                  <?php
                  $i=1;
                    if(!empty($tabel)){
                        foreach ($tabel as $val){
                            echo "<tr>";
                                echo "<td>".$i++."</td>";
                                echo "<td>".$val->item_name."</td>";
                                echo "<td>".$val->rate."</td>";
                                echo "<td>".$val->tax."</td>";
                                echo "<td><button data-toggle=\"modal\" data-target=\"#mod_add\" data-backdrop=\"static\" "
                                    . " class=\"btn btn-default btn-sm btn-block\" onclick=\"set_data(".$val->id.");\">Edit</button></td>";
                                echo "<td><button class=\"btn btn-danger btn-sm btn-block\" onclick=\"del_data(".$val->id.");\">Delete</button></td>";
                            echo "</tr>";
                        }
                    }
                  ?>    
              </tbody>
          </table>
      </div><!-- /.box-body -->
      <div class="box-footer">
        <button data-toggle="modal" data-target="#mod_add" data-backdrop="static" class="btn btn-primary">Add</button>
        <button class="btn btn-default" onclick="location.reload();">Refresh</button>
    </div>
  </div><!-- /.box -->
  
  <div class="modal fade" id="mod_add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <?php
            $attributes = array('role' => 'form'
                , 'id' => 'form_add', 'name' => 'form_add');
            echo form_open('ajaxform/submit',$attributes); 
        ?>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLocationLabel">
              <i class="fa fa-fw fa-cloud"></i>
              Item Details
          </h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="col-xs-12">
                    <div id="myResponDeptLabel" class=" animated fadeInDown"></div>
                    </div>
                </div>
            </div>            
            <div class="row">
                <div class="col-lg-12">  
                    <input type="hidden" id="id" name="id" />
                    <div class="col-xs-12">
                        <div class="form-group">
                          <label for="item_name">Item Name</label>
                          <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-fw fa-cloud"></i>
                            </div>
                            <input type="text" class="form-control" id="item_name" name="item_name" 
                                     placeholder="Item Name" >
                          </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                          <label for="rate">Item Rate</label>
                          <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-fw fa-usd"></i>
                            </div>
                            <input type="text" class="form-control" id="rate" name="rate" 
                                     placeholder="Item Rate" >
                          </div>
                        </div>
                    </div>
                     <div class="col-xs-12">
                        <div class="form-group">
                          <label for="tax">Item Tax</label>
                          <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-fw fa-fire"></i>
                            </div>
                            <input type="text" class="form-control" id="tax" name="tax" 
                                     placeholder="Item Tax" >
                          </div>
                        </div>
                    </div>
                    
                </div>  
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="button" onclick="submit_data();">Submit</button>
            <button class="btn btn-default" type="button" data-dismiss="modal" aria-hidden="true" onclick="cancel();">Cancel</button>
        </div>
        <?php echo form_close(); ?>
      </div>
    </div>
</div>