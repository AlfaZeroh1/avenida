function calculateTotal()
{
try{
  var disc;
  if(document.getElementById("discount").value=="")
  {
      disc=0;
      document.getElementById("discount").value=="0";
  }
  else
  {
	  disc=parseFloat(document.getElementById("discount").value);
  }

  var tax;
  if(document.getElementById("tax").value=="")
  {
	  tax=0;
      document.getElementById("tax").value=="0";
  }
  else
  {
	  tax=parseFloat(document.getElementById("tax").value);
  }
  var quantity=parseFloat(document.getElementById("quantity").value);
  
	  var retail=parseFloat(document.getElementById("costprice").value);
    
  var total=quantity*(retail*(100-disc)/100 * (100+tax)/100);
  var newtotal=Math.round(total*Math.pow(10,4))/Math.pow(10,4);
  
  document.getElementById("total").value=newtotal;
  }catch(e){alert(e);}
}