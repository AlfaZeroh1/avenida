<?php 
require_once("../../../DB.php");
class VarietystocksDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="prod_varietystocks";

	function persist($obj){
		$sql="insert into prod_varietystocks(id,documentno,varietyid,sizeid,areaid,transaction,quantity,remain,recordedon,actedon,remarks,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->documentno',$obj->varietyid,'$obj->sizeid',$obj->areaid,'$obj->transaction','$obj->quantity','$obj->remain','$obj->recordedon','$obj->actedon','$obj->remarks','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update prod_varietystocks set documentno='$obj->documentno',varietyid=$obj->varietyid,sizeid='$obj->sizeid',areaid=$obj->areaid,transaction='$obj->transaction',quantity='$obj->quantity',remain='$obj->remain',recordedon='$obj->recordedon',actedon='$obj->actedon',remarks='$obj->remarks',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from prod_varietystocks $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from prod_varietystocks $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

