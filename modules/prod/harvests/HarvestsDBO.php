<?php 
require_once("../../../DB.php");
class HarvestsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="prod_harvests";

	function persist($obj){
		$sql="insert into prod_harvests(id,varietyid,sizeid,plantingdetailid,greenhouseid,quantity,harvestedon,employeeid,barcode,remarks,status,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->varietyid,$obj->sizeid,'$obj->plantingdetailid',$obj->greenhouseid,'$obj->quantity','$obj->harvestedon',$obj->employeeid,'$obj->barcode','$obj->remarks','$obj->status','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}	echo mysql_error();	
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update prod_harvests set varietyid=$obj->varietyid,sizeid=$obj->sizeid,plantingdetailid=$obj->plantingdetailid,greenhouseid=$obj->greenhouseid,quantity='$obj->quantity',harvestedon='$obj->harvestedon',employeeid=$obj->employeeid,barcode='$obj->barcode',remarks='$obj->remarks',status='$obj->status',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from prod_harvests $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from prod_harvests $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

