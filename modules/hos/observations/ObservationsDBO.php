<?php 
require_once("../../../DB.php");
class ObservationsDBO extends DB{
	var $fetchObject;
	var $result;
	var $affectedRows;
 var $table="hos_observations";

	function persist($obj){
		$sql="insert into hos_observations(id,patientid,patienttreatmentid,observation,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->patientid','$obj->patienttreatmentid','$obj->observation','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function update($obj){			
		$sql="update hos_observations set patientid='$obj->patientid',patienttreatmentid='$obj->patienttreatmentid',observation='$obj->observation',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where id='$obj->id' ";
		if(mysql_query($sql,$this->connection))		
			return true;	
	}			
 
	function delete($obj){			
		$sql="delete from hos_observations where id='$obj->id'";
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_observations $join $where $groupby $having $orderby"; 
 		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

