<?php 
require_once("../../../DB.php");
class ConfirmedorderdetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_confirmedorderdetails";

	function persist($obj){
		$sql="insert into pos_confirmedorderdetails(id,itemid,quantity,packrate,memo,ipaddress,createdby,createdon,lasteditedby,lasteditedon,confirmedorderid,sizeid)
						values('$obj->id',$obj->itemid,'$obj->quantity','$obj->packrate','$obj->memo','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon',$obj->confirmedorderid,$obj->sizeid)";		
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
		$sql="update pos_confirmedorderdetails set itemid=$obj->itemid,quantity='$obj->quantity',packrate='$obj->packrate',memo='$obj->memo',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',confirmedorderid=$obj->confirmedorderid,sizeid=$obj->sizeid where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_confirmedorderdetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_confirmedorderdetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

