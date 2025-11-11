<?php 
require_once("../../../DB.php");
class AssetsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="assets_assets";

	function persist($obj){
		$sql="insert into assets_assets(id,name,photo,documentno,categoryid,departmentid,employeeid,value,salvagevalue,purchasedon,supplierid,lpono,deliveryno,remarks,memo,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->name','$obj->photo','$obj->documentno',$obj->categoryid,$obj->departmentid,$obj->employeeid,'$obj->value','$obj->salvagevalue','$obj->purchasedon',$obj->supplierid,'$obj->lpono','$obj->deliveryno','$obj->remarks','$obj->memo','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}	echo mysql_error();	
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update assets_assets set name='$obj->name',photo='$obj->photo',documentno='$obj->documentno',categoryid=$obj->categoryid,departmentid=$obj->departmentid,employeeid=$obj->employeeid,value='$obj->value',salvagevalue='$obj->salvagevalue',purchasedon='$obj->purchasedon',supplierid=$obj->supplierid,lpono='$obj->lpono',deliveryno='$obj->deliveryno',remarks='$obj->remarks',memo='$obj->memo',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from assets_assets $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from assets_assets $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

