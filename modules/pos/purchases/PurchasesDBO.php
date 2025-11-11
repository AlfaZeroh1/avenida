<?php 
require_once("../../../DB.php");
class PurchasesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_purchases";

	function persist($obj){
		$sql="insert into pos_purchases(id,itemid,documentno,supplierid,description,quantity,costprice,tradeprice,discount,tax,bonus,total,mode,boughton,memo,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id',$obj->itemid,'$obj->documentno',$obj->supplierid,'$obj->description','$obj->quantity','$obj->costprice','$obj->tradeprice','$obj->discount','$obj->tax','$obj->bonus','$obj->total','$obj->mode','$obj->boughton','$obj->memo','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update pos_purchases set itemid=$obj->itemid,documentno='$obj->documentno',supplierid=$obj->supplierid,description='$obj->description',quantity='$obj->quantity',costprice='$obj->costprice',tradeprice='$obj->tradeprice',discount='$obj->discount',tax='$obj->tax',bonus='$obj->bonus',total='$obj->total',mode='$obj->mode',boughton='$obj->boughton',memo='$obj->memo',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_purchases $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_purchases $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

