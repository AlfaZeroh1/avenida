<?php 
require_once("../../../DB.php");
class StocktracksDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_stocktracks";

	function persist($obj){
		$sql="insert into pos_stocktracks(id,itemid,tid,documentno,batchno,quantity,costprice,value,discount,tradeprice,retailprice,tax,expirydate,recorddate,status,remain,transaction,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id',$obj->itemid,'$obj->tid','$obj->documentno','$obj->batchno','$obj->quantity','$obj->costprice','$obj->value','$obj->discount','$obj->tradeprice','$obj->retailprice','$obj->tax','$obj->expirydate','$obj->recorddate','$obj->status','$obj->remain','$obj->transaction','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update pos_stocktracks set itemid=$obj->itemid,tid='$obj->tid',documentno='$obj->documentno',batchno='$obj->batchno',quantity='$obj->quantity',costprice='$obj->costprice',value='$obj->value',discount='$obj->discount',tradeprice='$obj->tradeprice',retailprice='$obj->retailprice',tax='$obj->tax',expirydate='$obj->expirydate',recorddate='$obj->recorddate',status='$obj->status',remain='$obj->remain',transaction='$obj->transaction',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_stocktracks $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_stocktracks $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

