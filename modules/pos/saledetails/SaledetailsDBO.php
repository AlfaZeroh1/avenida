<?php 
require_once("../../../DB.php");
class SaledetailsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_saledetails";

	function persist($obj){
		$sql="insert into pos_saledetails(id,saleid,itemid,quantity,costprice,tradeprice,retailprice,discount,tax,bonus,profit,total,memo,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id',$obj->saleid,$obj->itemid,'$obj->quantity','$obj->costprice','$obj->tradeprice','$obj->retailprice','$obj->discount','$obj->tax','$obj->bonus','$obj->profit','$obj->total','$obj->memo','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;echo $sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update pos_saledetails set saleid=$obj->saleid,itemid=$obj->itemid,quantity='$obj->quantity',costprice='$obj->costprice',tradeprice='$obj->tradeprice',retailprice='$obj->retailprice',discount='$obj->discount',tax='$obj->tax',bonus='$obj->bonus',profit='$obj->profit',total='$obj->total',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_saledetails $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_saledetails $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

