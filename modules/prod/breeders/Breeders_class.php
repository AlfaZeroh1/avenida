<?php 
require_once("BreedersDBO.php");
class Breeders
{				
	var $id;			
	var $code;			
	var $name;			
	var $contact;			
	var $physicaladdress;			
	var $tel;			
	var $fax;			
	var $email;			
	var $cellphone;			
	var $status;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $breedersDBO;
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
		$this->physicaladdress=str_replace("'","\'",$obj->physicaladdress);
		$this->tel=str_replace("'","\'",$obj->tel);
		$this->fax=str_replace("'","\'",$obj->fax);
		$this->email=str_replace("'","\'",$obj->email);
		$this->cellphone=str_replace("'","\'",$obj->cellphone);
		$this->status=str_replace("'","\'",$obj->status);
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

	//get physicaladdress
	function getPhysicaladdress(){
		return $this->physicaladdress;
	}
	//set physicaladdress
	function setPhysicaladdress($physicaladdress){
		$this->physicaladdress=$physicaladdress;
	}

	//get tel
	function getTel(){
		return $this->tel;
	}
	//set tel
	function setTel($tel){
		$this->tel=$tel;
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

	//get cellphone
	function getCellphone(){
		return $this->cellphone;
	}
	//set cellphone
	function setCellphone($cellphone){
		$this->cellphone=$cellphone;
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

	function add($obj){
		$breedersDBO = new BreedersDBO();
		if($breedersDBO->persist($obj)){
			$this->id=$breedersDBO->id;
			$this->sql=$breedersDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$breedersDBO = new BreedersDBO();
		if($breedersDBO->update($obj,$where)){
			$this->sql=$breedersDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$breedersDBO = new BreedersDBO();
		if($breedersDBO->delete($obj,$where=""))		
			$this->sql=$breedersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$breedersDBO = new BreedersDBO();
		$this->table=$breedersDBO->table;
		$breedersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$breedersDBO->sql;
		$this->result=$breedersDBO->result;
		$this->fetchObject=$breedersDBO->fetchObject;
		$this->affectedRows=$breedersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Breeder should be provided";
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
		if(empty($obj->status)){
			$error="Status should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
