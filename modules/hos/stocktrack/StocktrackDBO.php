<?php 
require_once("../../../DB.php");
class StocktrackDBO extends DB{
	var $fetchObject;
	var $result;
	var $affectedRows;
 var $table="hos_stocktrack";

	function persist($obj){
		$sql="insert into hos_stocktrack(id,itemid,tid,batchno,quantity,costprice,value,discount,tradeprice,retailprice,applicabletax,expirydate,recorddate,status,remain,transaction,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->itemid','$obj->tid','$obj->batchno','$obj->quantity','$obj->costprice','$obj->value','$obj->discount','$obj->tradeprice','$obj->retailprice','$obj->applicabletax','$obj->expirydate','$obj->recorddate','$obj->status','$obj->remain','$obj->transaction','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function update($obj){			
		$sql="update hos_stocktrack set itemid='$obj->itemid',tid='$obj->tid',batchno='$obj->batchno',quantity='$obj->quantity',costprice='$obj->costprice',value='$obj->value',discount='$obj->discount',tradeprice='$obj->tradeprice',retailprice='$obj->retailprice',applicabletax='$obj->applicabletax',expirydate='$obj->expirydate',recorddate='$obj->recorddate',status='$obj->status',remain='$obj->remain',transaction='$obj->transaction',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where id='$obj->id' ";
		if(mysql_query($sql,$this->connection))		
			return true;	
	}			
 
	function delete($obj){			
		$sql="delete from hos_stocktrack where id='$obj->id'";
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_stocktrack $join $where $groupby $having $orderby"; 
 		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

