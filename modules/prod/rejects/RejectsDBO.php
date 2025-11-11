<?php 
require_once("../../../DB.php");
class RejectsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="prod_rejects";

	function persist($obj){
		$sql="insert into prod_rejects(id,rejecttypeid,sizeid,greenhouseid,varietyid,quantity,harvestedon,reportedon,employeeid,barcode,remarks,status,reduce,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->rejecttypeid,$obj->sizeid,$obj->greenhouseid,$obj->varietyid,'$obj->quantity','$obj->harvestedon','$obj->reportedon',$obj->employeeid,'$obj->barcode','$obj->remarks','$obj->status','$obj->reduce','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update prod_rejects set rejecttypeid=$obj->rejecttypeid,sizeid=$obj->sizeid,greenhouseid=$obj->greenhouseid,varietyid=$obj->varietyid,quantity='$obj->quantity',harvestedon='$obj->harvestedon',reportedon='$obj->reportedon',employeeid=$obj->employeeid,barcode='$obj->barcode',remarks='$obj->remarks',status='$obj->status',reduce='$obj->reduce',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from prod_rejects $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from prod_rejects $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

