<?php 
require_once("../../../DB.php");
class PatientclassesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="hos_patientclasses";

	function persist($obj){
		$sql="insert into hos_patientclasses(id,name,fee,remarks,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->name','$obj->fee','$obj->remarks','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update hos_patientclasses set name='$obj->name',fee='$obj->fee',remarks='$obj->remarks',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from hos_patientclasses $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_patientclasses $join $where $groupby $having $orderby"; 
 		$this->sql=$sql; //echo $sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

