<?php 
require_once("../../../DB.php");
class GradedDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="post_graded";

	function persist($obj){
		$sql="insert into post_graded(id,datecode,greenhouseid,sizeid,itemid,quantity,gradedon,employeeid,downsize,barcode,remarks,status,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->datecode',$obj->greenhouseid,$obj->sizeid,$obj->itemid,'$obj->quantity','$obj->gradedon',$obj->employeeid,'$obj->downsize','$obj->barcode','$obj->remarks','$obj->status','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update post_graded set greenhouseid=$obj->greenhouseid,sizeid=$obj->sizeid,itemid=$obj->itemid,quantity='$obj->quantity',gradedon='$obj->gradedon',employeeid=$obj->employeeid, downsize='$obj->downsize',barcode='$obj->barcode',remarks='$obj->remarks',status='$obj->status',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from post_graded $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from post_graded $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

