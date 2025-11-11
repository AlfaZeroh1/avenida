function calculateTotal()
{
  var quantity=parseFloat(document.getElementById("quantity").value);
  
	  var retail=parseFloat(document.getElementById("costprice").value);
  
  var total=quantity*retail;
  var newtotal=Math.round(total*Math.pow(10,4))/Math.pow(10,4);
  
  document.getElementById("total").value=newtotal;
}

function calculateTotals(i)
{
  var quantity=parseFloat($("#quantity"+i).val());  
  var retail=parseFloat($("#costprice"+i).text());
  
  var taxamount;
  var tax;
  if($("#tax"+i).val()=="")
  {
      tax=0;
      taxamount=0;
      $("#tax"+i).val(tax);
      $("#taxamount"+i).val(taxamount);
  }
  else
  {       taxamount=parseFloat($("#tax"+i).val())*retail*quantity/100;
	  tax=parseFloat($("#tax"+i).val());
  }
   var discount;
  if($("#discount"+i).val()=="")
  {
      discount=0;
      $("#discount"+i).val(discount);
  }
  else
  {
	  discount=parseFloat($("#discount"+i).val());
  }
   
  var discountamount=(quantity*retail)*(discount/100);
  var ttotal=(quantity*retail)-discountamount;
  var newtaxamount=ttotal*(tax/100);
  
  
  var total=(ttotal+newtaxamount);
  var newtotal=Math.round(total*Math.pow(10,2))/Math.pow(10,2);
  var newdiscountamount=Math.round(discountamount*Math.pow(10,2))/Math.pow(10,2);
  var taxamounts=Math.round(newtaxamount*Math.pow(10,2))/Math.pow(10,2);
  
  var tt=$("#total"+i).text();
  tt = parseFloat(tt.replace(/[^0-9-.]/g, ''));
  
  $("#discountamount"+i).text(newdiscountamount);
  $("#taxamount"+i).val(taxamounts);
  $("#total"+i).text(newtotal);
   
  var total = parseFloat($("#ttotal").val());
  var data = parseFloat(newtotal);
  var ntotal = total-tt+data;
  ntotal=Math.round(ntotal*Math.pow(10,2))/Math.pow(10,2);
  $("#ttotal").val(ntotal);
}
