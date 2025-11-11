<?php 
require_once("../../../DB.php");
class SupplierpaymentsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="fn_supplierpayments";

	function persist($obj){
		$sql="insert into fn_supplierpayments(id,supplierid,documentno,paidon,amount,paymentmodeid,bankid,chequeno,currencyid,exchangerate, exchangerate2,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->supplierid,'$obj->documentno','$obj->paidon','$obj->amount',$obj->paymentmodeid,$obj->bankid,'$obj->chequeno',$obj->currencyid, '$obj->exchangerate', '$obj->exchangerate2','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update fn_supplierpayments set supplierid=$obj->supplierid,documentno='$obj->documentno',paidon='$obj->paidon',amount='$obj->amount',paymentmodeid=$obj->paymentmodeid,bankid=$obj->bankid,chequeno='$obj->chequeno', currencyid=$obj->currencyid, exchangerate='$obj->exchangerate', exchangerate2='$obj->exchangerate2', remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from fn_supplierpayments $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from fn_supplierpayments $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

