 <!-- Success Notification  -->

        <?php 
        $msg = $this->session->flashdata('msg'); if((isset($msg)) && (!empty($msg))) { ?>
        <div class="alert alert-success" >
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <b><?php print_r($msg); ?></b>
        </div>
        <?php } ?>
        
  <!-- Failure Notification  -->
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
              <h3 class="box-title">Invoice System</h3>
            </div><!-- /.box-header -->
                <form method="post" action="<?php echo site_url('invoice/insert_invoice');?>" id="form">
                        <div class="box-body">  
                            <table class="table">
                                <tr>
                                  <th>Item</th>
                                  <th>Rate</th>
                                   <th>Tax</th>
                                  <th>Quantity</th>                   
                                  <th>Amount</th>
                                  <th></th>
                              </tr>
                              <tbody>
                               <tr>
                                  <td><input type="text" name="item[]" class="form-control" id="item1" Placeholder="Enter Item name here ">
                                  <div id="item_valid1"></div></td>

                                  <td><input type="text" name="rate[]" id="rate1" class="form-control" Placeholder="Enter rate here ">
                                  <div id="rate_valid1"></div></td>

                                  <td><input type="text" name="tax[]" id="tax1" class="form-control" Placeholder="Enter  tax here ">
                                  <div id="tax_valid1"></div></td>

                                  <td><input type="text" name="quantity[]" id="quantity1" class="form-control" Placeholder="Enter quantity here ">
                                  <div id="quantity_valid1"></div></td> 

                                  <td><input type="text" name="amount[]"  id="amount1" class="form-control" Placeholder="Amount">
                                  <div id="amount_valid1"></div></td>

                                  <td><button type="button" class="btn btn-danger remove"> Remove</button type="button"></td>
                              </tr>
                              </tbody>
                              <tbody id="append"></tbody>
                        </table> 
              <input type="hidden" value="1" id="hide">
              <div class="pull-right">
              <button type="button" class="btn btn-primary add" >+Add Row</button type="button">   
              </div>
              <br><br>
              
                <table >
                  <tr>
                    <th>Sub Total</th>
                    <td><input type="text" name="sub_total" id="sub_total"class="form-control"></td>
                    <td></td>
                  </tr>
                   <tr>
                    <td></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td></td>
                  </tr>
                  <tr>
                    <th>Service Tax(10%)&nbsp;</th>
                    <td><input type="text" name="o_tax" id="o_tax" class="form-control"></td>
                    <td></td>
                  </tr>
                   <tr>
                    <td></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td></td>
                  </tr>
                  <tr>
                    <th>Grand Total</th>
                    <td><input type="text" name="grand_total" id="grand_total" class="form-control"></td>
                    <td></td>
                  </tr>
                </table>                    
              
          </div><!-- /.box-body -->
          </form>
      </div><!-- /.box -->
    </div>
  </div>   <!-- /.row -->
</section><!-- /.content -->

      <div align="center">
        <button class="btn btn-primary submit">Make Invoice</button>
      </div>

<script type="text/javascript">
  $(document).ready(function(){

        
    //Append new rows

    $('.add').click(function(){
        var start=$('#hide').val();
        var total=Number(start)+1;
        $('#hide').val(total);
        var tbody=$('#append');
        $('<tr><td><input type="text" name="item[]" class="form-control" id="item'+total+'" Placeholder="Enter Item name here "><div id="item_valid'+total+'"></td><td><input type="text" name="rate[]" id="rate'+total+'" class="form-control" Placeholder="Enter rate here "><div id="rate_valid'+total+'"></div></td><td><input type="text" name="tax[]" id="tax'+total+'" class="form-control" Placeholder="Enter tax here "><div id="tax_valid'+total+'"></div></td><td><input type="text" name="quantity[]" id="quantity'+total+'" class="form-control" Placeholder="Enter quantity here "><div id="quantity_valid'+total+'"></div></td><td><input type="text" name="amount[]" id="amount'+total+'" class="form-control" Placeholder="Amount"><div id="amount_valid'+total+'"></div></td><td><button type="button" class="btn btn-danger remove">Remove</button type="button"></td></tr>').appendTo(tbody);

   
    /*Remove the rows */

    $('.remove').click(function(){     
       $(this).parents('tr').remove(); 
       var sub_tot=0;
              $('input[name^="amount"]').each(function(){
              sub_tot +=Number($(this).val());          
              var fina=sub_tot.toFixed(2);         
              $('#sub_total').val(fina);
              var gst1=(parseFloat(fina)*10/100);
              var gtax1=gst1.toFixed(2);
              $('#o_tax').val(gtax1);
              var grand1=parseFloat(gtax1)+parseFloat(fina);
              var gt1=grand1.toFixed(2);
              $('#grand_total').val(gt1);
             });
    });


     $( "#item"+total+"" ).autocomplete({

        source: function(request, response) {
          $.ajax({ 
            url: "<?php echo site_url('ajaxform/autocomplete'); ?>",
            data: { name: $("#item"+total+"").val()},
            dataType: "json",
            type: "POST",
            success: function(data){              
             //alert(data);
              response(data);
            }    
          });
        },
      });

/*Ajax content fills */
     $('#item'+total+'').blur(function(){
      $.post('<?php echo site_url('ajaxform/get_contents');?>',{name:$('#item'+total+'').val()},function(res){
          var obj=jQuery.parseJSON(res);
          $('#rate'+total+'').val(obj.rate);
          $('#tax'+total+'').val(obj.tax);
          $('#quantity'+total+'').focus();
      });
        });  


     //on enter the quantity  for appended rows
    $('#quantity'+total+'').keyup(function(){
      var qty =$(this).val();
     var price =$('#rate'+total+'').val();

     /*quantity and price present*/

     if(qty && price)
    {
      var amount=parseFloat(qty)*parseFloat(price);
      var result=amount.toFixed(2);
      $('#amount'+total+'').val(result);

      var tot=0;

      $('input[name^="amount"]').each(function(){
        tot +=Number($(this).val());         
         var fin=tot.toFixed(2);       

         $('#sub_total').val(fin);
         var o_tax=(parseFloat(fin)*10/100);
         var gtax=o_tax.toFixed(2);
         $('#o_tax').val(gtax);

         var grand=parseFloat(gtax)+parseFloat(fin);
         var gt=grand.toFixed(2);
         $('#grand_total').val(gt);

         var tax=$('#tax'+total+'').val();

          if(tax)//If tax present
         {
            var wtax=parseFloat(result)+(parseFloat(result)*parseFloat(tax)/100); 
            var tax_amount=wtax.toFixed(2);
            $('#amount'+total+'').val(tax_amount);
                  var sub_tot=0;
                 $('input[name^="amount"]').each(function(){
                  sub_tot +=Number($(this).val());          
                   var fina=sub_tot.toFixed(2);         
                   $('#sub_total').val(fina);
                   var o_tax1=(parseFloat(fina)*10/100);
                   var gtax1=o_tax1.toFixed(2);
                   $('#o_tax').val(gtax1);
                   var grand1=parseFloat(gtax1)+parseFloat(fina);
                   var gt1=grand1.toFixed(2);
                    $('#grand_total').val(gt1);
                 });

         }         
      });
    }
    });



 });

/*Submit ther form */
      $('.submit').click(function(){

      for(var i=1;i<=$('#hide').val();i++)
    {
        var item=$('#item'+i+'').val();
        var rate=$('#rate'+i+'').val();
        var tax=$('#tax'+i+'').val();
        var quantity=$('#quantity'+i+'').val();
        var amount=$('#amount'+i+'').val();

        if(item=='')
        {
          $('#item'+i+'').focus();       

          $('#item_valid'+i+'').html('<div><font color="red">Enter The Item name</font><div>');
          $('#item'+i+'').css("border-color", "red");  
          $('#item'+i+'').focus();
          $('#item'+i+'').keyup(function(){      
          $(this).css("border-color", "green");
  
            });
           return false;
        }
        else
        {
        $('#item_valid'+i+'').hide();
        }
         if(rate=='')
        {
          $('#rate'+i+'').focus();       

          $('#rate_valid'+i+'').html('<div><font color="red">Enter the Rate</font><div>');
          $('#rate'+i+'').css("border-color", "red");  
          $('#rate'+i+'').focus();
          $('#rate'+i+'').keyup(function(){      
          $(this).css("border-color", "green");
  
            });
           return false;
        }
        else
        {
          $('#rate_valid'+i+'').hide();
        }
         if(tax=='')
        {
          $('#tax'+i+'').focus();       

          $('#tax_valid'+i+'').html('<div><font color="red">Enter the Tax </font><div>');
          $('#tax'+i+'').css("border-color", "red");  
          $('#tax'+i+'').focus();
          $('#tax'+i+'').keyup(function(){      
          $(this).css("border-color", "green");
  
            });
           return false;
        }
        else
        {
          $('#tax_valid'+i+'').hide();

        }
         if(rate=='')
        {
          $('#rate'+i+'').focus();       

          $('#rate_valid'+i+'').html('<div><font color="red">Enter the Rate</font><div>');
          $('#rate'+i+'').css("border-color", "red");  
          $('#rate'+i+'').focus();
          $('#rate'+i+'').keyup(function(){      
          $(this).css("border-color", "green");
  
            });
           return false;
        }
        else
        {
          $('#rate_valid'+i+'').hide();
        }
        
         if(quantity=='')
        {
          $('#quantity'+i+'').focus();       

          $('#quantity_valid'+i+'').html('<div><font color="red">Enter The Quantity</font><div>');
          $('#quantity'+i+'').css("border-color", "red");  
          $('#quantity'+i+'').focus();
          $('#quantity'+i+'').keyup(function(){      
          $(this).css("border-color", "green");
  
            });
           return false;
        }
        else
        {
           $('#quantity_valid'+i+'').hide();
        }
         if(amount=='')
        {
          $('#amount'+i+'').focus();       

          $('#amount_valid'+i+'').html('<div><font color="red">Enter The Amount</font><div>');
          $('#amount'+i+'').css("border-color", "red");  
          $('#amount'+i+'').focus();
          $('#amount'+i+'').keyup(function(){      
          $(this).css("border-color", "green");
  
            });
           return false;
        }
        else
        {
          $('#amount_valid'+i+'').hide();
        }
      }
      $('#form').submit();

      });
//item name for first row

    $( "#item1" ).autocomplete({

        source: function(request, response) {
          $.ajax({ 
            url: "<?php echo site_url('ajaxform/autocomplete'); ?>",
            data: { name: $("#item1").val()},
            dataType: "json",
            type: "POST",
            success: function(data){              
             //alert(data);
              response(data);
            }    
          });
        },
      });
    
    // get matched contents to text box
       
    $('#item1').blur(function(){
      $.post('<?php echo site_url('ajaxform/get_contents');?>',{name:$("#item1").val()},function(res){
          var obj=jQuery.parseJSON(res);
          $('#rate1').val(obj.rate);
          $('#tax1').val(obj.tax);
          $('#quantity1').focus();
      });
    });  

    //on enter the quantity 
    $('#quantity1').keyup(function(){
      var qty =$(this).val();
     var price =$('#rate1').val();

     /*quantity and price present*/

     if(qty && price)
    {
      var amount=parseFloat(qty)*parseFloat(price);
      var result=amount.toFixed(2);
      $('#amount1').val(result);

      var tot=0;

      $('input[name^="amount"]').each(function(){
        tot +=Number($(this).val());         
         var fin=tot.toFixed(2);       

         $('#sub_total').val(fin);
         var o_tax=(parseFloat(fin)*10/100);
         var gtax=o_tax.toFixed(2);
         $('#o_tax').val(gtax);

         var grand=parseFloat(gtax)+parseFloat(fin);
         var gt=grand.toFixed(2);
         $('#grand_total').val(gt);

         var tax=$('#tax1').val();

          if(tax)//If tax present
         {
            var wtax=parseFloat(result)+(parseFloat(result)*parseFloat(tax)/100); 
            var tax_amount=wtax.toFixed(2);
            $('#amount1').val(tax_amount);
              var sub_tot=0;
              $('input[name^="amount"]').each(function(){
                  sub_tot +=Number($(this).val());          
                   var fina=sub_tot.toFixed(2);         
                   $('#sub_total').val(fina);
                   var o_tax1=(parseFloat(fina)*10/100);
                   var gtax1=o_tax1.toFixed(2);
                   $('#o_tax').val(gtax1);
                   var grand1=parseFloat(gtax1)+parseFloat(fina);
                   var gt1=grand1.toFixed(2);
                    $('#grand_total').val(gt1);
                 });

         }         
      });
    }
    });
           


     
  });
</script>