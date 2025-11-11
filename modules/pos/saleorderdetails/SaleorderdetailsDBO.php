<?php 
require_once("../../../DB.php");
class SaleorderdetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_saleorderdetails";

	function persist($obj){
		$sql="insert into pos_saleorderdetails(id,saleorderid,itemid,quantity,costprice,tradeprice,discount,tax,bonus,profit,total,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->saleorderid,'$obj->itemid','$obj->quantity','$obj->costprice','$obj->tradeprice','$obj->discount','$obj->tax','$obj->bonus','$obj->profit','$obj->total','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update pos_saleorderdetails set saleorderid=$obj->saleorderid,itemid='$obj->itemid',quantity='$obj->quantity',costprice='$obj->costprice',tradeprice='$obj->tradeprice',discount='$obj->discount',tax='$obj->tax',bonus='$obj->bonus',profit='$obj->profit',total='$obj->total',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_saleorderdetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_saleorderdetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

