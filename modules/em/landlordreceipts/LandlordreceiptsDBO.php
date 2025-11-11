<?php 
require_once("../../../DB.php");
class LandlordreceiptsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_landlordreceipts";

	function persist($obj){
		$sql="insert into em_landlordreceipts(id,documentno,landlordid,plotid,paymenttermid,paymentmodeid,bankid,chequeno,amount,paidon,month,year,receivedby,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->documentno','$obj->landlordid','$obj->plotid','$obj->paymenttermid','$obj->paymentmodeid','$obj->bankid','$obj->chequeno','$obj->amount','$obj->paidon','$obj->month','$obj->year','$obj->receivedby','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update em_landlordreceipts set documentno='$obj->documentno',landlordid='$obj->landlordid',plotid='$obj->plotid',paymenttermid='$obj->paymenttermid',paymentmodeid='$obj->paymentmodeid',bankid='$obj->bankid',chequeno='$obj->chequeno',amount='$obj->amount',paidon='$obj->paidon',month='$obj->month',year='$obj->year',receivedby='$obj->receivedby',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_landlordreceipts $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_landlordreceipts $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

