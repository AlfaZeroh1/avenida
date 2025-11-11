<?php 
require_once("../../../DB.php");
class PurchasepaymentsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="inv_purchasepayments";

	function persist($obj){
		$sql="insert into inv_purchasepayments(id,supplierid,amount,paymentmodeid,bank,chequeno,paymentdate,offsetid,createdby,createdon,lasteditedby,lasteditedon,documentno,ipaddress)
						values('$obj->id','$obj->supplierid','$obj->amount','$obj->paymentmodeid','$obj->bank','$obj->chequeno','$obj->paymentdate','$obj->offsetid','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->documentno','$obj->ipaddress')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update inv_purchasepayments set supplierid='$obj->supplierid',amount='$obj->amount',paymentmodeid='$obj->paymentmodeid',bank='$obj->bank',chequeno='$obj->chequeno',paymentdate='$obj->paymentdate',offsetid='$obj->offsetid',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',documentno='$obj->documentno',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from inv_purchasepayments $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from inv_purchasepayments $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

