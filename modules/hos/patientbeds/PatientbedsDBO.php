<?php 
require_once("../../../DB.php");
class PatientbedsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hos_patientbeds";

	function persist($obj){
		$sql="insert into hos_patientbeds(id,bedid,patientid,treatmentid,allocatedon,lefton,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->bedid','$obj->patientid','$obj->treatmentid','$obj->allocatedon','$obj->lefton','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update hos_patientbeds set bedid='$obj->bedid',patientid='$obj->patientid',treatmentid='$obj->treatmentid',allocatedon='$obj->allocatedon',lefton='$obj->lefton',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hos_patientbeds $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_patientbeds $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

