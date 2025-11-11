<?php 
require_once("PricingcreatedeleteDBO.php");
class Pricingcreatedelete
{				
	var $id;			
	var $fieldname;			
	var $fieldsize;			
	var $category;			
	var $status;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $pricingcreatedeleteDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->fieldname=str_replace("'","\'",$obj->fieldname);
		$this->fieldsize=str_replace("'","\'",$obj->fieldsize);
		$this->category=str_replace("'","\'",$obj->category);
		$this->status=str_replace("'","\'",$obj->status);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		return $this;
	
	}
	//get id
	function getId(){
		return $this->id;
	}
	//set id
	function setId($id){
		$this->id=$id;
	}

	//get fieldname
	function getFieldname(){
		return $this->fieldname;
	}
	//set fieldname
	function setFieldname($fieldname){
		$this->fieldname=$fieldname;
	}

	//get fieldsize
	function getFieldsize(){
		return $this->fieldsize;
	}
	//set fieldsize
	function setFieldsize($fieldsize){
		$this->fieldsize=$fieldsize;
	}

	//get category
	function getCategory(){
		return $this->category;
	}
	//set category
	function setCategory($category){
		$this->category=$category;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	//get createdby
	function getCreatedby(){
		return $this->createdby;
	}
	//set createdby
	function setCreatedby($createdby){
		$this->createdby=$createdby;
	}

	//get createdon
	function getCreatedon(){
		return $this->createdon;
	}
	//set createdon
	function setCreatedon($createdon){
		$this->createdon=$createdon;
	}

	//get lasteditedby
	function getLasteditedby(){
		return $this->lasteditedby;
	}
	//set lasteditedby
	function setLasteditedby($lasteditedby){
		$this->lasteditedby=$lasteditedby;
	}

	//get lasteditedon
	function getLasteditedon(){
		return $this->lasteditedon;
	}
	//set lasteditedon
	function setLasteditedon($lasteditedon){
		$this->lasteditedon=$lasteditedon;
	}

	function add($obj){
		switch ($obj->fieldsize) {
			case 'Boolean':
				$fType = 'BINARY';
				break;
			case 'Small_Text':
				$fType = 'VARCHAR(32)';
				break;
			case 'Medium_Text':
				$fType = 'VARCHAR(255)';
				break;
			case 'Large':
				$fType = 'BLOB';
				break;
			case 'Numeric':
				$fType = 'DOUBLE';
				break;
			case 'List':
				$fType = 'VARCHAR(32)';
				break;
		}
		      
		if(@mysql_query("alter table prices_pricings add column $obj->fieldname $fType")){		
		
		  $pricingcreatedeleteDBO = new PricingcreatedeleteDBO();
		  if($pricingcreatedeleteDBO->persist($obj)){
			  $this->id=$pricingcreatedeleteDBO->id;
			  $this->sql=$pricingcreatedeleteDBO->sql;
			  return true;	
		  }
		  }
		  else{echo mysql_error();
		    return false;
		  }
	}				
	function edit($obj,$where=""){
	if(mysql_query("alter table prices_pricings drop $obj->fieldname")){
		$pricingcreatedeleteDBO = new PricingcreatedeleteDBO();
		if($pricingcreatedeleteDBO->update($obj,$where)){
			$this->sql=$pricingcreatedeleteDBO->sql;
		}
			return true;	
	}
	else{	
	    return false;
	}
	}		
	function delete($obj,$where=""){			
		$pricingcreatedeleteDBO = new PricingcreatedeleteDBO();
		if($pricingcreatedeleteDBO->delete($obj,$where=""))		
			$this->sql=$pricingcreatedeleteDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$pricingcreatedeleteDBO = new PricingcreatedeleteDBO();
		$this->table=$pricingcreatedeleteDBO->table;
		$pricingcreatedeleteDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$pricingcreatedeleteDBO->sql;
		$this->result=$pricingcreatedeleteDBO->result;
		$this->fetchObject=$pricingcreatedeleteDBO->fetchObject;
		$this->affectedRows=$pricingcreatedeleteDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
