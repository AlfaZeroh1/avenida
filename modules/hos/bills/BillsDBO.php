<?php 
require_once("../../../DB.php");
class BillsDBO extends DB{
	var $fetchObject;
	var $result;
	var $affectedRows;
 var $table="hos_bills";

	function persist($obj){
		$sql="insert into hos_bills(id,name,amount,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->name','$obj->amount','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function update($obj){			
		$sql="update hos_bills set name='$obj->name',amount='$obj->amount',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where id='$obj->id' ";
		if(mysql_query($sql,$this->connection))		
			return true;	
	}			
 
	function delete($obj){			
		$sql="delete from hos_bills where id='$obj->id'";
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_bills $join $where $groupby $having $orderby"; 
 		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

