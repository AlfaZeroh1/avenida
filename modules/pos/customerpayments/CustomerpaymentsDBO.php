<?php 
require_once("../../../DB.php");
class CustomerpaymentsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_customerpayments";

	function persist($obj){
		$sql="insert into pos_customerpayments(id,documentno,invoiceno,customerid,amount,paymentmodeid,bankid,chequeno,paidon,offsetid,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id','$obj->documentno','$obj->invoiceno',$obj->customerid,'$obj->amount',$obj->paymentmodeid,'$obj->bankid','$obj->chequeno','$obj->paidon','$obj->offsetid','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update pos_customerpayments set documentno='$obj->documentno',invoiceno='$obj->invoiceno',customerid=$obj->customerid,amount='$obj->amount',paymentmodeid=$obj->paymentmodeid,bankid='$obj->bankid',chequeno='$obj->chequeno',paidon='$obj->paidon',offsetid='$obj->offsetid',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_customerpayments $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_customerpayments $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

