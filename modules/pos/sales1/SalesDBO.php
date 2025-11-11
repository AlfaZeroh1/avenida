<?php 
require_once("../../../DB.php");
class SalesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_sales";

	function persist($obj){
		$sql="insert into pos_sales(id,itemid,documentno,patientid,agentid,employeeid,remarks,quantity,costprice,tradeprice,retailprice,discount,tax,bonus,profit,total,mode,soldon,expirydate,memo,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id',$obj->itemid,'$obj->documentno',$obj->patientid,$obj->agentid,$obj->employeeid,'$obj->remarks','$obj->quantity','$obj->costprice','$obj->tradeprice','$obj->retailprice','$obj->discount','$obj->tax','$obj->bonus','$obj->profit','$obj->total','$obj->mode','$obj->soldon','$obj->expirydate','$obj->memo','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
		$this->sql=$sql;//echo $sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}		echo mysql_error();
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update pos_sales set itemid=$obj->itemid,documentno='$obj->documentno',patientid=$obj->patientid,agentid=$obj->agentid,employeeid=$obj->employeeid,remarks='$obj->remarks',quantity='$obj->quantity',costprice='$obj->costprice',tradeprice='$obj->tradeprice',retailprice='$obj->retailprice',discount='$obj->discount',tax='$obj->tax',bonus='$obj->bonus',profit='$obj->profit',total='$obj->total',mode='$obj->mode',soldon='$obj->soldon',expirydate='$obj->expirydate',memo='$obj->memo',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_sales $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_sales $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

