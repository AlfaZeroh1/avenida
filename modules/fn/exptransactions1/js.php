function calculateTotal(){
try{
	var quantity;
	var amount;
	var total;
	
  if(document.getElementById("quantity").value=="")
  {
      quantity=0;
      document.getElementById("quantity").value=="0";
  }
  else{
  	quantity=document.getElementById("quantity").value;
  }
  
  if(document.getElementById("amount").value=="")
  {
      amount=0;
      document.getElementById("amount").value=="0";
  }
  else{
  	amount=document.getElementById("amount").value;
  }
  
  total=quantity*amount;
  document.getElementById("total").value=total;
  }catch(e){alert(e);}
}