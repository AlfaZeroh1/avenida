<?php 
require_once("../../../DB.php");
class PatientstatussDBO extends DB{
	var $fetchObject;
	var $result;
	var $affectedRows;
 var $table="hos_patientstatuss";

	function persist($obj){
		$sql="insert into hos_patientstatuss(id,name)
						values('$obj->id','$obj->name')";		
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function update($obj){			
		$sql="update hos_patientstatuss set name='$obj->name' where id='$obj->id' ";
		if(mysql_query($sql,$this->connection))		
			return true;	
	}			
 
	function delete($obj){			
		$sql="delete from hos_patientstatuss where id='$obj->id'";
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_patientstatuss $join $where $groupby $having $orderby"; 
 		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

