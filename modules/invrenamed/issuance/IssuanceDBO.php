<?php 
require_once("../../../DB.php");
class IssuanceDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="inv_issuance";

	function persist($obj){
		$sql="insert into inv_issuance(id,departmentid,employeeid,issuedon,documentno,requisitionno,remarks,memo,currencyid,rate,eurorate,received,journals,receivedon,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id',$obj->departmentid,$obj->employeeid,'$obj->issuedon','$obj->documentno','$obj->requisitionno','$obj->remarks','$obj->memo','$obj->currencyid','$obj->rate','$obj->eurorate','$obj->received','$obj->journals','$obj->receivedon','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
		$this->sql=$sql;
		if(empty($obj->effectjournals)){
		  if(mysql_query($sql,$this->connection)){		
			  $this->id=mysql_insert_id();
			  return true;	
		  }
		}else{
		    mysql_query("update inv_issuance set journals='Yes' where documentno='$obj->documentno'");
		  return true;
		}			
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update inv_issuance set departmentid='$obj->departmentid',employeeid='$obj->employeeid',issuedon='$obj->issuedon',documentno='$obj->documentno',requisitionno='$obj->requisitionno',remarks='$obj->remarks',memo='$obj->memo',received='$obj->received',journals='$obj->journals',receivedon='$obj->receivedon',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from inv_issuance $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from inv_issuance $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

