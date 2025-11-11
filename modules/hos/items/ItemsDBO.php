<?php 
require_once("../../../DB.php");
class ItemsDBO extends DB{
	var $fetchObject;
	var $result;
	var $affectedRows;
 var $table="hos_items";

	function persist($obj){
		$sql="insert into hos_items(id,code,name,manufacturer,strength,costprice,discount,tradeprice,retailprice,applicabletax,reorderlevel,quantity,status,expirydate,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->code','$obj->name','$obj->manufacturer','$obj->strength','$obj->costprice','$obj->discount','$obj->tradeprice','$obj->retailprice','$obj->applicabletax','$obj->reorderlevel','$obj->quantity','$obj->status','$obj->expirydate','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function update($obj){			
		$sql="update hos_items set code='$obj->code',name='$obj->name',manufacturer='$obj->manufacturer',strength='$obj->strength',costprice='$obj->costprice',discount='$obj->discount',tradeprice='$obj->tradeprice',retailprice='$obj->retailprice',applicabletax='$obj->applicabletax',reorderlevel='$obj->reorderlevel',quantity='$obj->quantity',status='$obj->status',expirydate='$obj->expirydate',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where id='$obj->id' ";
		if(mysql_query($sql,$this->connection))		
			return true;	
	}			
 
	function delete($obj){			
		$sql="delete from hos_items where id='$obj->id'";
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from hos_items $join $where $groupby $having $orderby"; echo $sql;
 		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

