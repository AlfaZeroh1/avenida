<?php 
require_once("../../../DB.php");
class ReturninwardsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_returninwards";

	function persist($obj){
		$sql="insert into pos_returninwards(id,documentno,creditnoteno,creditnotenos,types,packingno,customerid,currencyid,type,vat,vatable,exchangerate,exchangerate2,remarks,returnedon,memo,invoiceno,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id','$obj->documentno','$obj->creditnoteno','$obj->creditnotenos','$obj->types','$obj->packingno',$obj->customerid,'$obj->currencyid','$obj->type','$obj->vat','$obj->vatable','$obj->exchangerate','$obj->exchangerate2','$obj->remarks','$obj->returnedon','$obj->memo','$obj->invoiceno','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
		$this->sql=$sql; //echo $sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}	echo mysql_error();	
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update pos_returninwards set documentno='$obj->documentno', creditnoteno='$obj->creditnoteno', creditnotenos='$obj->creditnotenos',types='$obj->types',packingno='$obj->packingno',customerid=$obj->customerid,currencyid='$obj->currencyid',vat='$obj->vat', type='$obj->type'vatable='$obj->vatable',exchangerate='$obj->exchangerate',exchangerate2='$obj->exchangerate2',remarks='$obj->remarks',returnedon='$obj->returnedon',memo='$obj->memo',invoiceno='$obj->invoiceno',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_returninwards $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_returninwards $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

