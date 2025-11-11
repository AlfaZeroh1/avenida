<?php 
require_once("../../../DB.php");
class InwardsDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="proc_inwards";

	function persist($obj){
		$sql="insert into proc_inwards(id,documentno,deliverynoteno,lpono,projectid,supplierid,currencyid, rate, eurorate,inwarddate,remarks,file,journals,ipaddress,createdby,createdon,lasteditedby,lasteditedon)
						values('','$obj->documentno','$obj->deliverynoteno','$obj->lpono',$obj->projectid,$obj->supplierid,$obj->currencyid,'$obj->rate','$obj->eurorate','$obj->inwarddate','$obj->remarks','$obj->file','$obj->journals','$obj->ipaddress','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
		$this->sql=$sql;//echo $sql."====".$obj->effectjournals;
		if(empty($obj->effectjournals)){
		  if(mysql_query($sql,$this->connection)){		
			  $this->id=mysql_insert_id();
			  return true;	
		  }
		}else{
		    mysql_query("update proc_inwards set journals='Yes' where documentno='$obj->documentno'");
		  return true;
		}		
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update proc_inwards set documentno='$obj->documentno',deliverynoteno='$obj->deliverynoteno',lpono='$obj->lpono',projectid=$obj->projectid,supplierid=$obj->supplierid, currencyid='$obj->currencyid', rate='$obj->rate',eurorate='$obj->eurorate',inwarddate='$obj->inwarddate',remarks='$obj->remarks', journals='$obj->journals',file='$obj->file',ipaddress='$obj->ipaddress',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from proc_inwards $where ";;
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
		else
		  ;
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from proc_inwards $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

