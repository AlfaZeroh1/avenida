<?php 
require_once("../../../DB.php");
class CustomersDBO extends DB{
	var $fetchObject;
	var $sql;
	var $id;
	var $result;
	var $affectedRows;
 var $table="crm_customers";

	function persist($obj){
		$sql="insert into crm_customers(id,code,name,customerid,agentid,departmentid,continentid,countryid,currencyid,vatable,employeeid,idno,pinno,address,tel,fax,email,contactname,contactphone,nextofkin,nextofkinrelation,nextofkinaddress,nextofkinidno,nextofkinpinno,nextofkintel,creditlimit,creditdays,discount,showlogo,freightid,statusid,flo,remarks,createdby,createdon,lasteditedby,lasteditedon,ipaddress)
						values('$obj->id','$obj->code','$obj->name','$obj->customerid','$obj->agentid',$obj->departmentid,$obj->continentid,$obj->countryid,$obj->currencyid,'$obj->vatable',$obj->employeeid,'$obj->idno','$obj->pinno','$obj->address','$obj->tel','$obj->fax','$obj->email','$obj->contactname','$obj->contactphone','$obj->nextofkin','$obj->nextofkinrelation','$obj->nextofkinaddress','$obj->nextofkinidno','$obj->nextofkinpinno','$obj->nextofkintel','$obj->creditlimit','$obj->creditdays','$obj->discount','$obj->showlogo','$obj->freightid',$obj->statusid,'$obj->flo','$obj->remarks','$obj->createdby','$obj->createdon','$obj->lasteditedby','$obj->lasteditedon','$obj->ipaddress')";		
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
		$sql="update crm_customers set code='$obj->code',name='$obj->name',customerid='$obj->customerid',agentid='$obj->agentid',departmentid=$obj->departmentid,continentid=$obj->continentid,countryid=$obj->countryid,currencyid=$obj->currencyid,vatable='$obj->vatable',employeeid=$obj->employeeid,idno='$obj->idno',pinno='$obj->pinno',address='$obj->address',tel='$obj->tel',fax='$obj->fax',email='$obj->email',contactname='$obj->contactname',contactphone='$obj->contactphone',nextofkin='$obj->nextofkin',nextofkinrelation='$obj->nextofkinrelation',nextofkinaddress='$obj->nextofkinaddress',nextofkinidno='$obj->nextofkinidno',nextofkinpinno='$obj->nextofkinpinno',nextofkintel='$obj->nextofkintel',creditlimit='$obj->creditlimit',creditdays='$obj->creditdays',discount='$obj->discount',showlogo='$obj->showlogo',freightid='$obj->freightid',statusid=$obj->statusid,flo='$obj->flo',remarks='$obj->remarks',lasteditedby='$obj->lasteditedby',lasteditedon='$obj->lasteditedon',ipaddress='$obj->ipaddress' where $where ";
		$this->sql=$sql;//echo $sql;
		if(mysql_query($sql,$this->connection)){		
			return true;	
		}
	}			
 
	function delete($obj,$where=""){			
		if(empty($where)){
			$where=" where id='$obj->id' ";
		}
		$sql="delete from crm_customers $where ";
		$this->sql=$sql;echo $sql;
		if(mysql_query($sql,$this->connection))		
				return true;	
	}			
 
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sql="select $fields from crm_customers $join $where $groupby $having $orderby"; 
 		$this->sql=$sql;
		$this->result=mysql_query($sql,$this->connection);
		$this->affectedRows=mysql_affected_rows();
		$this->fetchObject=mysql_fetch_object(mysql_query($sql,$this->connection));
	}			
}			
?>

