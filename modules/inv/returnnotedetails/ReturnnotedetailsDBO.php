<?php 
require_once("../../../DB.php");
class ReturnnotedetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="inv_returnnotedetails";

	function persist($obj){
		$sql="insert into inv_returnnotedetails(id,returnnoteid,itemid,quantity,costprice,tax,discount,total,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->returnnoteid,$obj->itemid,'$obj->quantity','$obj->costprice','$obj->tax','$obj->discount','$obj->total','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update inv_returnnotedetails set returnnoteid=$obj->returnnoteid,itemid=$obj->itemid,quantity='$obj->quantity',costprice='$obj->costprice',tax='$obj->tax',discount='$obj->discount',total='$obj->total',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from inv_returnnotedetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from inv_returnnotedetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

