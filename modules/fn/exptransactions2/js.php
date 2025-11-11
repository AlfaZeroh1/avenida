function calculateTotal()
{

  var taxamount;
  if(document.getElementById("taxamount").value=="")
  {
	  taxamount=0;
      document.getElementById("taxamount").value=="0";
  }
  else
  {
	  taxamount=parseFloat(document.getElementById("taxamount").value);
  }
  var quantity=parseFloat(document.getElementById("quantity").value);
  
	  var retail=parseFloat(document.getElementById("amount").value);
  
  var total=(quantity*retail) + taxamount;
  var newtotal=Math.round(total*Math.pow(10,4))/Math.pow(10,4);
  
  document.getElementById("total").value=newtotal;
}