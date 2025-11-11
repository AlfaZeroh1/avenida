<?php 
require_once("SuppliersDBO.php");
class Suppliers
{				
	var $id;			
	var $code;			
	var $name;			
	var $contact;			
	var $address;			
	var $telephone;			
	var $fax;			
	var $email;			
	var $mobile;			
	var $status;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $suppliersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->code=str_replace("'","\'",$obj->code);
		$this->name=str_replace("'","\'",$obj->name);
		$this->contact=str_replace("'","\'",$obj->contact);
		$this->address=str_replace("'","\'",$obj->address);
		$this->telephone=str_replace("'","\'",$obj->telephone);
		$this->fax=str_replace("'","\'",$obj->fax);
		$this->email=str_replace("'","\'",$obj->email);
		$this->mobile=str_replace("'","\'",$obj->mobile);
		$this->status=str_replace("'","\'",$obj->status);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get code
	function getCode(){
		return $this->code;
	}
	//set code
	function setCode($code){
		$this->code=$code;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get contact
	function getContact(){
		return $this->contact;
	}
	//set contact
	function setContact($contact){
		$this->contact=$contact;
	}

	//get address
	function getAddress(){
		return $this->address;
	}
	//set address
	function setAddress($address){
		$this->address=$address;
	}

	//get telephone
	function getTelephone(){
		return $this->telephone;
	}
	//set telephone
	function setTelephone($telephone){
		$this->telephone=$telephone;
	}

	//get fax
	function getFax(){
		return $this->fax;
	}
	//set fax
	function setFax($fax){
		$this->fax=$fax;
	}

	//get email
	function getEmail(){
		return $this->email;
	}
	//set email
	function setEmail($email){
		$this->email=$email;
	}

	//get mobile
	function getMobile(){
		return $this->mobile;
	}
	//set mobile
	function setMobile($mobile){
		$this->mobile=$mobile;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj){
		$suppliersDBO = new SuppliersDBO();
		if($suppliersDBO->persist($obj)){
			$this->id=$suppliersDBO->id;
			$this->sql=$suppliersDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$suppliersDBO = new SuppliersDBO();
		if($suppliersDBO->update($obj,$where)){
			$this->sql=$suppliersDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$suppliersDBO = new SuppliersDBO();
		if($suppliersDBO->delete($obj,$where=""))		
			$this->sql=$suppliersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$suppliersDBO = new SuppliersDBO();
		$this->table=$suppliersDBO->table;
		$suppliersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$suppliersDBO->sql;
		$this->result=$suppliersDBO->result;
		$this->fetchObject=$suppliersDBO->fetchObject;
		$this->affectedRows=$suppliersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Name should be provided";
		}
		else if(empty($obj->status)){
			$error="Status should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
