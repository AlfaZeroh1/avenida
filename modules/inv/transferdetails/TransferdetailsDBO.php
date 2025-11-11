<?php 
require_once("../../../DB.php");
class TransferdetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="inv_transferdetails";

	function persist($obj){
		$sql="insert into inv_transferdetails(id,transferid,itemid, itemdetailid,code,instalcode,crdcode,quantity,costprice,total,memo,status,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('',$obj->transferid,$obj->itemid,'$obj->itemdetailid','$obj->code','$obj->instalcode','$obj->crdcode','$obj->quantity','$obj->costprice','$obj->total','$obj->memo','$obj->status','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update inv_transferdetails set transferid=$obj->transferid,itemid=$obj->itemid, itemdetailid=$obj->itemdetailid,code='$obj->code', instalcode='$obj->instalcode', crdcode='$obj->crdcode',quantity='$obj->quantity',costprice='$obj->costprice',total='$obj->total',memo='$obj->memo',status='$obj->status',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from inv_transferdetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from inv_transferdetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

