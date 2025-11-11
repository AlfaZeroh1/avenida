<?php 
require_once("../../../DB.php");
class SuppliersDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="proc_suppliers";

	function persist($obj){
		$sql="insert into proc_suppliers(id,code,name,suppliercategoryid,currencyid,countryid,regionid,subregionid,contact,physicaladdress,tel,pinno,vatno,etrno,fax,email,cellphone,status,createdby,createdon,lasteditedby,lasteditedon)
						values('$obj->id','$obj->code','$obj->name',$obj->suppliercategoryid,$obj->currencyid,$obj->countryid,$obj->regionid,$obj->subregionid,'$obj->contact','$obj->physicaladdress','$obj->tel','$obj->pinno','$obj->vatno','$obj->etrno','$obj->fax','$obj->email','$obj->cellphone','$obj->status','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon')";		
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
		$sql="update proc_suppliers set code='$obj->code',name='$obj->name',suppliercategoryid=$obj->suppliercategoryid,currencyid=$obj->currencyid,countryid=$obj->countryid,regionid=$obj->regionid,subregionid=$obj->subregionid,contact='$obj->contact',physicaladdress='$obj->physicaladdress',tel='$obj->tel',pinno='$obj->pinno',vatno='$obj->vatno',etrno='$obj->etrno',fax='$obj->fax',email='$obj->email',cellphone='$obj->cellphone',status='$obj->status',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon' where $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from proc_suppliers $where ";
		$this->sql=$sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from proc_suppliers $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

