<?php 
require_once("../../../DB.php");
class LandlordpayablesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_landlordpayables";

	function persist($obj){
		$sql="insert into em_landlordpayables(id,documentno,receiptno,landlordid,plotid,paymenttermid,amount,invoicedon,month,year,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->documentno','$obj->receiptno','$obj->landlordid','$obj->plotid','$obj->paymenttermid','$obj->amount','$obj->invoicedon','$obj->month','$obj->year','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}	echo mysql_error();	
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update em_landlordpayables set documentno='$obj->documentno',receiptno='$obj->receiptno',landlordid='$obj->landlordid',plotid='$obj->plotid',paymenttermid='$obj->paymenttermid',amount='$obj->amount',invoicedon='$obj->invoicedon',month='$obj->month',year='$obj->year',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){echo $where;			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_landlordpayables $where ";
		$this->sql=$sql;echo $sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_landlordpayables $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

