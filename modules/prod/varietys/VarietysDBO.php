<?php 
require_once("../../../DB.php");
class VarietysDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="prod_varietys";

	function persist($obj){
		$sql="insert into prod_varietys(id,name,typeid,colourid,duration,quantity,stems,remarks,type,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->name',$obj->typeid,$obj->colourid,'$obj->duration','$obj->quantity','$obj->stems','$obj->remarks','$obj->type','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update prod_varietys set name='$obj->name',typeid=$obj->typeid,colourid=$obj->colourid,duration='$obj->duration',quantity='$obj->quantity',stems='$obj->stems',remarks='$obj->remarks',type='$obj->type',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from prod_varietys $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from prod_varietys $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

