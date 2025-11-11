function calculateTotal()
{
try{
  
  var quantity=parseFloat(document.getElementById("quantity").value);
  var amount=parseFloat(document.getElementById("amount").value);
  
  var total=quantity*amount;
  var newtotal=Math.round(total*Math.pow(10,4))/Math.pow(10,4);
  
  document.getElementById("total").value=newtotal;
  
  }catch(e){alert(e);}
}