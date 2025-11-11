<?php 
require_once("../../../DB.php");
class EstimatedetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="bom_estimatedetails";

	function persist($obj){
		$sql="insert into bom_estimatedetails(id,estimateid,itemid,quantity,unitid,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id',$obj->estimateid,$obj->itemid,'$obj->quantity',$obj->unitid,'$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update bom_estimatedetails set estimateid=$obj->estimateid,itemid=$obj->itemid,quantity='$obj->quantity',unitid=$obj->unitid,lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from bom_estimatedetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from bom_estimatedetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

