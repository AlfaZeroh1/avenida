function calculateTotal()
{

  var quantity=parseFloat(document.getElementById("quantity").value);
  var costprice=parseFloat(document.getElementById("costprice").value);
   
  var total=quantity*costprice;
  
  document.getElementById("total").value=total;
  
}