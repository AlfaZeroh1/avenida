<?php 
require_once("../../../DB.php");
class ExptransactionsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="fn_exptransactions";

	function persist($obj){
		$sql="insert into fn_exptransactions(id,expenseid,assetid,liabilityid,projectid,supplierid,purchasemodeid,quantity,vatclasseid,tax,taxamount,discount,currencyid,exchangerate,exchangerate2,amount,total,expensedate,paid,remarks,memo,documentno,receiptno,requisitionno,paymentmodeid,paymentcategoryid,bankid,employeeid,chequeno,transactionno,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('',$obj->expenseid,$obj->assetid,$obj->liabilityid,$obj->projectid,$obj->supplierid,$obj->purchasemodeid,'$obj->quantity','$obj->vatclasseid','$obj->tax','$obj->taxamount','$obj->discount','$obj->currencyid','$obj->exchangerate','$obj->exchangerate2','$obj->amount','$obj->total','$obj->expensedate','$obj->paid','$obj->remarks','$obj->memo','$obj->documentno','$obj->receiptno','$obj->requisitionno',$obj->paymentmodeid,$obj->paymentcategoryid,$obj->bankid,$obj->employeeid,'$obj->chequeno','$obj->transactionno','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;//echo $sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update fn_exptransactions set expenseid=$obj->expenseid,assetid=$obj->assetid,liabilityid=$obj->liabilityid,projectid=$obj->projectid,supplierid=$obj->supplierid,purchasemodeid=$obj->purchasemodeid,quantity='$obj->quantity',vatclasseid='$obj->vatclasseid',tax='$obj->tax',taxamount='$obj->taxamount',discount='$obj->discount',currencyid='$obj->currencyid',exchangerate='$obj->exchangerate',exchangerate2='$obj->exchangerate2',amount='$obj->amount',total='$obj->total',expensedate='$obj->expensedate',paid='$obj->paid',remarks='$obj->remarks',memo='$obj->memo',documentno='$obj->documentno',receiptno='$obj->receiptno',requisitionno='$obj->requisitionno',paymentmodeid=$obj->paymentmodeid, paymentcategoryid=$obj->paymentcategoryid,bankid=$obj->bankid, employeeid=$obj->employeeid,chequeno='$obj->chequeno',transactionno='$obj->transactionno',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;// echo $sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from fn_exptransactions $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from fn_exptransactions $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

