<?php 
require_once("../../../DB.php");
class LaboratorytestsDBO extends DB{
	var $fetchObject;
	var $result;
	var $affectedRows;
 var $table="hos_laboratorytests";

	function persist($obj){
		$sql="insert into hos_laboratorytests(id,name,remarks,charge)
						values('$obj->id','$obj->name','$obj->remarks','$obj->charge')";		
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function update($obj){			
		$sql="update hos_laboratorytests set name='$obj->name',remarks='$obj->remarks',charge='$obj->charge' where id='$obj->id' ";
		if(mysql_query($sql,$this->connection))		
			return true;	
	}			
 
	function delete($obj){			
		$sql="delete from hos_laboratorytests where id='$obj->id'";
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_laboratorytests $join $where $groupby $having $orderby"; 
 		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

