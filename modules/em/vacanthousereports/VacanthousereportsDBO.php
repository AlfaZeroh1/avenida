<?php 
require_once("../../../DB.php");
class VacanthousereportsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="em_vacanthousereports";

	function persist($obj){
		$sql="insert into em_vacanthousereports(id,houseid,vacatedon,remarks,status,remarks2,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id','$obj->houseid','$obj->vacatedon','$obj->remarks','$obj->status','$obj->remarks2','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update em_vacanthousereports set houseid='$obj->houseid',vacatedon='$obj->vacatedon',remarks='$obj->remarks',status='$obj->status',remarks2='$obj->remarks2',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from em_vacanthousereports $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from em_vacanthousereports $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

