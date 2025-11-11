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
		$sql="insert into fn_exptransactions(id,voucherno,expenseid,itemid,plotid,paymenttermid,supplierid,purchasemodeid,quantity,tax,discount,amount,total,expensedate,month,year,paid,remarks,memo,documentno,paymentmodeid,bankid,imprestaccountid,chequeno,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->voucherno',$obj->expenseid,$obj->itemid,$obj->plotid,$obj->paymenttermid,$obj->supplierid,$obj->purchasemodeid,'$obj->quantity','$obj->tax','$obj->discount','$obj->amount','$obj->total','$obj->expensedate','$obj->month','$obj->year','$obj->paid','$obj->remarks','$obj->memo','$obj->documentno',$obj->paymentmodeid,$obj->bankid,$obj->imprestaccountid,'$obj->chequeno','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;//echo $sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update fn_exptransactions set voucherno='$obj->voucherno',expenseid=$obj->expenseid,itemid=$obj->itemid,plotid=$obj->plotid,paymenttermid=$obj->paymenttermid,supplierid=$obj->supplierid,purchasemodeid=$obj->purchasemodeid,quantity='$obj->quantity',tax='$obj->tax',discount='$obj->discount',amount='$obj->amount',total='$obj->total',expensedate='$obj->expensedate',month='$obj->month',year='$obj->year',paid='$obj->paid',remarks='$obj->remarks',memo='$obj->memo',documentno='$obj->documentno',paymentmodeid=$obj->paymentmodeid,bankid=$obj->bankid,imprestaccountid=$obj->imprestaccountid,chequeno='$obj->chequeno',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
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

