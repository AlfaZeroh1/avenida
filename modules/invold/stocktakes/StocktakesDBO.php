<?php 
require_once("../../../DB.php");
class StocktakesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="inv_stocktakes";

	function persist($obj){
		$sql="insert into inv_stocktakes(id,documentno,openedon,closedon,remarks,status,createdby,createdon,lasteditedon,lasteditedby,ipaddress)
						values('$obj->id','$obj->documentno','$obj->openedon','$obj->closedon','$obj->remarks','$obj->status','$obj->createdby','$obj->createdon','$obj->lasteditedon','$obj->lasteditedby','$obj->ipaddress')";		
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
		$sql="update inv_stocktakes set documentno='$obj->documentno',openedon='$obj->openedon',closedon='$obj->closedon',remarks='$obj->remarks',status='$obj->status',lasteditedon='$obj->lasteditedon',lasteditedby='$obj->lasteditedby',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from inv_stocktakes $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from inv_stocktakes $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

