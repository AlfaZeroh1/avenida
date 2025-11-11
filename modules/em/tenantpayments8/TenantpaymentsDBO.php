<?php 
require_once("../../../DB.php");
class TenantpaymentsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_tenantpayments";

	function persist($obj){
		$sql="insert into em_tenantpayments(id,tenantid,houseid,documentno,paymenttermid,paymentmodeid,bankid,chequeno,amount,paidon,month,year,paidby,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->tenantid','$obj->houseid','$obj->documentno','$obj->paymenttermid','$obj->paymentmodeid','$obj->bankid','$obj->chequeno','$obj->amount','$obj->paidon','$obj->month','$obj->year','$obj->paidby','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update em_tenantpayments set tenantid='$obj->tenantid',houseid='$obj->houseid',documentno='$obj->documentno',paymenttermid='$obj->paymenttermid',paymentmodeid='$obj->paymentmodeid',bankid='$obj->bankid',chequeno='$obj->chequeno',amount='$obj->amount',paidon='$obj->paidon',month='$obj->month',year='$obj->year',paidby='$obj->paidby',remarks='$obj->remarks',ipaddress='$obj->ipaddress',createdby='$obj->createdby', createdon='$obj->createdon',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_tenantpayments $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_tenantpayments $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

