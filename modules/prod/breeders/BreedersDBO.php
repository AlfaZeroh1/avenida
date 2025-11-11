<?php 
require_once("../../../DB.php");
class BreedersDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="prod_breeders";

	function persist($obj){
		$sql="insert into prod_breeders(id,code,name,contact,physicaladdress,tel,fax,email,cellphone,status,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->code','$obj->name','$obj->contact','$obj->physicaladdress','$obj->tel','$obj->fax','$obj->email','$obj->cellphone','$obj->status','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update prod_breeders set code='$obj->code',name='$obj->name',contact='$obj->contact',physicaladdress='$obj->physicaladdress',tel='$obj->tel',fax='$obj->fax',email='$obj->email',cellphone='$obj->cellphone',status='$obj->status',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from prod_breeders $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from prod_breeders $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

