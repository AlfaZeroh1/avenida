<?php 
require_once("../../../DB.php");
class PackinglistreturnsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_packinglistreturns";

	function persist($obj){
		$sql="insert into pos_packinglistreturns(id,documentno,packingno,orderno,boxno,customerid,packedon,fleetid,employeeid,remarks,returns,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->documentno','$obj->packingno','$obj->orderno','$obj->boxno',$obj->customerid,'$obj->packedon',$obj->fleetid,$obj->employeeid,'$obj->remarks','$obj->returns','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update pos_packinglistreturns set documentno='$obj->documentno',orderno='$obj->orderno',boxno='$obj->boxno',customerid=$obj->customerid,packedon='$obj->packedon',fleetid=$obj->fleetid,employeeid=$obj->employeeid,remarks='$obj->remarks', returns='$obj->returns',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_packinglistreturns $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_packinglistreturns $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

