function calculateTotal(tax,id,quantity,costprice,total,vtamount)
{
try{
  var disc;
  if($("#discount"+id).text()=="")
  {
      disc=0;
      $("#discount"+id).text()=="0";
  }
  else
  {
	  disc=parseFloat($("#discount"+id).text());
  }
  
  var tax;
  if($("#tax"+id).text()=="")
  {
      tax=0;
      $("#tax"+id).text()=="0";
  }
  else
  {
	  tax=parseFloat($("#tax"+id).text());
  }
  
  var quantity=parseFloat(quantity);
  
  var costprice;
  if($("#costprice"+id).text()=="")
  {
      costprice=0;
      $("#costprice"+id).text()=="0";
  }
  else
  {
	  costprice=parseFloat($("#costprice"+id).text());
  }
  var ftotal = parseFloat($("#ftotal").text());
  var initialtotal=parseFloat($("#total"+id).text());
  
  if(disc=='' || disc=='NaN' || isNaN(disc))
    disc=0;
    
  if(tax=='' || tax=='NaN' || isNaN(tax))
    tax=0;
  
  var total=quantity*(costprice*(100-disc)/100 * (100+tax)/100);
  var newtotal=Math.round(total*Math.pow(10,4))/Math.pow(10,4);
  
  var vatamount=parseFloat(quantity*(costprice*(100-disc)/100 * (tax)/100));
  
  var newftotal=ftotal-initialtotal+newtotal;
  
  $("#total"+id).html(newtotal);
  $("#ftotal").html(newftotal);
  
  setval('total',id,newtotal);
  
  setval('vatamount',id,vatamount);
  }catch(e){alert(e);}
}