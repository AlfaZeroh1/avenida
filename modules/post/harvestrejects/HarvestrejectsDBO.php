<?php 
require_once("../../../DB.php");
class HarvestrejectsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="post_harvestrejects";

	function persist($obj){
		$sql="insert into post_harvestrejects(id,documentno,rejecttypeid,sizeid,blockid,greenhouseid,datecode,itemid,quantity,gradedon,reportedon,employeeid,barcode,remarks,status,reduce,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values(' ','$obj->documentno',$obj->rejecttypeid,$obj->sizeid,$obj->blockid,$obj->greenhouseid,'$obj->datecode',$obj->itemid,'$obj->quantity','$obj->gradedon','$obj->reportedon',$obj->employeeid,'$obj->barcode','$obj->remarks','$obj->status','$obj->reduce','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update post_harvestrejects set rejecttypeid=$obj->rejecttypeid,documentno=$obj->documentno,sizeid=$obj->sizeid,blockid=$obj->blockid, greenhouseid=$obj->greenhouseid,datecode='$obj->datecode',itemid=$obj->itemid,quantity='$obj->quantity',gradedon='$obj->gradedon',reportedon='$obj->reportedon',employeeid=$obj->employeeid,barcode='$obj->barcode',remarks='$obj->remarks',status='$obj->status',reduce='$obj->reduce',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from post_harvestrejects $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from post_harvestrejects $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

