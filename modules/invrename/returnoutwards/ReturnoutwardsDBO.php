<?php 
require_once("../../../DB.php");
class ReturnoutwardsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="inv_returnoutwards";

	function persist($obj){
		$sql="insert into inv_returnoutwards(id,supplierid,storeid,documentno,purchaseno,purchasemodeid,returnedon,memo,remarks,createdby,createdon,lasteditedby,lasteditedon,ipaddress,projectid)
						values('$obj->id',$obj->supplierid,$obj->storeid,'$obj->documentno','$obj->purchaseno',$obj->purchasemodeid,'$obj->returnedon','$obj->memo','$obj->remarks','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress',$obj->projectid)";		
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
		$sql="update inv_returnoutwards set supplierid=$obj->supplierid,storeid=$obj->storeid,documentno='$obj->documentno',purchaseno='$obj->purchaseno',purchasemodeid=$obj->purchasemodeid,returnedon='$obj->returnedon',memo='$obj->memo',remarks='$obj->remarks',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress',projectid=$obj->projectid where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from inv_returnoutwards $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from inv_returnoutwards $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

