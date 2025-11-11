<?php 
require_once("../../../DB.php");
class AdmissionsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hos_admissions";

	function persist($obj){
		$sql="insert into hos_admissions(id,bedid,treatmentid,patientid, admissiondate,remarks,status,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->bedid','$obj->treatmentid','$obj->patientid','$obj->admissiondate','$obj->remarks','$obj->status','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update hos_admissions set bedid='$obj->bedid',treatmentid='$obj->treatmentid',patientid='$obj->patientid', admissiondate='$obj->admissiondate',remarks='$obj->remarks',status='$obj->status',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hos_admissions $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_admissions $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

