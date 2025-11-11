<?php 
require_once("../../../DB.php");
class ItemstocksDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_itemstocks";

	function persist($obj){
		$sql="insert into pos_itemstocks(id,documentno,datecode,itemid,sizeid,customerid,transaction,quantity,remain,recordedon,actedon,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->documentno','$obj->datecode',$obj->itemid,'$obj->sizeid',$obj->customerid,'$obj->transaction','$obj->quantity','$obj->remain','$obj->recordedon','$obj->actedon','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update pos_itemstocks set documentno='$obj->documentno',datecode='$obj->datecode',itemid=$obj->itemid,sizeid='$obj->sizeid',customerid=$obj->customerid,transaction='$obj->transaction',quantity='$obj->quantity',remain='$obj->remain',recordedon='$obj->recordedon',actedon='$obj->actedon',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_itemstocks $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_itemstocks $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

