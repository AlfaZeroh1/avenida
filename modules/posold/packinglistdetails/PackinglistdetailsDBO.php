<?php 
require_once("../../../DB.php");
class PackinglistdetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_packinglistdetails";

	function persist($obj){
		$sql="insert into pos_packinglistdetails(id,packinglistid,itemid,sizeid,quantity,memo,ipaddress,createdby,createdon,lasteditedby,lasteditedon,barcode,datecode)
						values('$obj->id',$obj->packinglistid,$obj->itemid,$obj->sizeid,'$obj->quantity','$obj->memo','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->barcode','$obj->datecode')";		
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
		$sql="update pos_packinglistdetails set packinglistid=$obj->packinglistid,itemid=$obj->itemid,quantity='$obj->quantity',memo='$obj->memo',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',barcode='$obj->barcode',datecode='$obj->datecode' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_packinglistdetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_packinglistdetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

