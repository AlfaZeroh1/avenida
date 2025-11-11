<?php 
require_once("../../../DB.php");
class InvoicesDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="pos_invoices";

	function persist($obj){
		$sql="insert into pos_invoices(id,documentno, saletypeid,packingno,customerid,agentid,currencyid,vatable,vat,exchangerate,exchangerate2,consignee,actualweight,volweight,awbno,dropoffpoint,shippedon,remarks,soldon,memo,invoiceno,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id','$obj->documentno','$obj->saletypeid','$obj->packingno',$obj->customerid,$obj->agentid,'$obj->currencyid','$obj->vatable','$obj->vat','$obj->exchangerate','$obj->exchangerate2','$obj->consignee','$obj->actualweight','$obj->volweight','$obj->awbno','$obj->dropoffpoint','$obj->shippedon','$obj->remarks','$obj->soldon','$obj->memo','$obj->invoiceno','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
		$this->sql=$sql;echo $sql;
		if(mysql_query($sql,$this->connection)){		
			$this->id=mysql_insert_id();
			return true;	
		}	echo mysql_error();	
	}		
 
	function update($obj,$where=""){			
		if(empty($where)){
			$where="id='$obj->id'";
		}
		$sql="update pos_invoices set documentno='$obj->documentno', saletypeid='$obj->saletypeid',packingno='$obj->packingno',customerid=$obj->customerid,agentid=$obj->agentid,currencyid='$obj->currencyid',vat='$obj->vat', vatable='$obj->vatable',exchangerate='$obj->exchangerate',exchangerate2='$obj->exchangerate2',consignee='$obj->consignee',actualweight='$obj->actualweight',volweight='$obj->volweight',awbno='$obj->awbno',dropoffpoint='$obj->dropoffpoint',shippedon='$obj->shippedon',remarks='$obj->remarks',soldon='$obj->soldon',memo='$obj->memo',invoiceno='$obj->invoiceno',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from pos_invoices $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from pos_invoices $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

