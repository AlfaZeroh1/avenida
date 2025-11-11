<?php 
require_once("../../../DB.php");
class PatientlaboratorytestdetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hos_patientlaboratorytestdetails";

	function persist($obj){
		$sql="insert into hos_patientlaboratorytestdetails(id,patientlaboratorytestid,laboratorytestdetailid,result,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->patientlaboratorytestid,$obj->laboratorytestdetailid,'$obj->result','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update hos_patientlaboratorytestdetails set patientlaboratorytestid=$obj->patientlaboratorytestid,laboratorytestdetailid=$obj->laboratorytestdetailid,result='$obj->result',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hos_patientlaboratorytestdetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_patientlaboratorytestdetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

