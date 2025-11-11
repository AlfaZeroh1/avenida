<?php 
require_once("../../../DB.php");
class PurchaseordersDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="proc_purchaseorders";

	function persist($obj){
		$sql="insert into proc_purchaseorders(id,projectid,documentno,requisitionno,supplierid,currencyid,rate,eurorate,remarks,status,type,orderedon,file,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id',$obj->projectid,'$obj->documentno','$obj->requisitionno',$obj->supplierid,$obj->currencyid,'$obj->rate','$obj->eurorate','$obj->remarks','$obj->status','$obj->type','$obj->orderedon','$obj->file','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update proc_purchaseorders set projectid=$obj->projectid,documentno='$obj->documentno',requisitionno='$obj->requisitionno',supplierid=$obj->supplierid,currencyid=$obj->currencyid,rate='$obj->rate',eurorate='$obj->eurorate',remarks='$obj->remarks',status='$obj->status',type='$obj->type',orderedon='$obj->orderedon',file='$obj->file',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from proc_purchaseorders $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from proc_purchaseorders $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

