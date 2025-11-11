<?php 
require_once("../../../DB.php");
class InctransactionsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="fn_inctransactions";

	function persist($obj,$bool){
		$sql="insert into fn_inctransactions(id,projectid,incomeid,fleetscheduleid,customerid,purchasemodeid,quantity,tax,amount,total,incomedate,remarks,memo,documentno,paymentmodeid,bankid,chequeno,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->projectid, $obj->incomeid,$obj->fleetscheduleid,$obj->customerid,$obj->purchasemodeid,'$obj->quantity','$obj->tax','$obj->amount','$obj->total','$obj->incomedate','$obj->remarks','$obj->memo','$obj->documentno',$obj->paymentmodeid,'$obj->bankid','$obj->chequeno','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";echo mysql_error();	
		$this->sql=$sql;
		if($bool){
		  if(mysql_query($sql,$this->connection)){
		  
			  $incomes = new Incomes();
			  $fields="*";
			  $where=" where id='$obj->incomeid'";
			  $join="";
			  $having="";
			  $groupby="";
			  $orderby="";
			  $incomes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			  $incomes=$incomes->fetchObject;
			  
			  //check VATability
			  if($incomes->vat>0){
			    $vat = new Vats();
			    $vat->documentno=$obj->documentno;
			    $vat->type="Income";
			    $vat->typeid=$obj->incomeid;
			    $vat->vatable=$obj->amount;
			    $vat->vat = $incomes->vat;
			    $vat->amount=$vat->vatable*$incomes->vat/100;
			    $vat->incurredon=$obj->incomedate;
			    $vat->transactionid=$obj->transactionid;
			    
			    $vat = $vat->setObject($vat);
			    $vat->add($vat);
			    
			  }
			  
			  $this->id=mysql_insert_id();
			  return true;	
		  }	
		}
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update fn_inctransactions set incomeid=$obj->incomeid, paymentid=$obj->paymentid,plotid=$obj->plotid,paymenttermid=$obj->paymenttermid,customerid=$obj->customerid,quantity='$obj->quantity',tax='$obj->tax',discount='$obj->discount',amount='$obj->amount',total='$obj->total',incomedate='$obj->incomedate',month='$obj->month',year='$obj->year',paid='$obj->paid',remarks='$obj->remarks',memo='$obj->memo',documentno='$obj->documentno',paymentmodeid=$obj->paymentmodeid,bankid=$obj->bankid,imprestaccountid=$obj->imprestaccountid,chequeno='$obj->chequeno',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from fn_inctransactions $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from fn_inctransactions $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

