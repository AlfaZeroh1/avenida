<?php 
require_once("../../../DB.php");
class EstimationdetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="bom_estimationdetails";

	function persist($obj){
		$sql="insert into bom_estimationdetails(id,estimationid,itemid,quantity,type,types,unitofmeasureid,remarks,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id',$obj->estimationid,$obj->itemid,'$obj->quantity', '$obj->type','$obj->types',$obj->unitofmeasureid,'$obj->remarks','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
		$this->sql=$sql; echo $sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update bom_estimationdetails set estimationid=$obj->estimationid,itemid=$obj->itemid,quantity='$obj->quantity', type='$obj->type',types='$obj->types',unitofmeasureid=$obj->unitofmeasureid,remarks='$obj->remarks',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from bom_estimationdetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from bom_estimationdetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

