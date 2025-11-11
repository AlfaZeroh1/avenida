function calculateTotal()
{
  var quantity;
  quantity = parseFloat(document.getElementById("wquantity").value);
  if(!quantity)
    quantity = parseFloat(document.getElementById("quantity").value);
  
	  var retail=parseFloat(document.getElementById("costprice").value);
  
  var total=quantity*retail;
  var newtotal=Math.round(total*Math.pow(10,4))/Math.pow(10,4);
  
  document.getElementById("total").value=newtotal;
}