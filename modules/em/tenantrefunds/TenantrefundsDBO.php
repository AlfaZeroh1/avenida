<?php 
require_once("../../../DB.php");
class TenantrefundsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_tenantrefunds";

	function persist($obj){
		$sql="insert into em_tenantrefunds(id,documentno,tenantid,houseid,paymenttermid,amount,refundedon,paymentmodeid,bankid,chequeno,month,year,receivedby,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->documentno','$obj->tenantid','$obj->houseid','$obj->paymenttermid','$obj->amount','$obj->refundedon','$obj->paymentmodeid','$obj->bankid','$obj->chequeno','$obj->month','$obj->year','$obj->receivedby','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update em_tenantrefunds set documentno='$obj->documentno',tenantid='$obj->tenantid',houseid='$obj->houseid',paymenttermid='$obj->paymenttermid',amount='$obj->amount',refundedon='$obj->refundedon',paymentmodeid='$obj->paymentmodeid',bankid='$obj->bankid',chequeno='$obj->chequeno',month='$obj->month',year='$obj->year',receivedby='$obj->receivedby',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_tenantrefunds $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_tenantrefunds $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

