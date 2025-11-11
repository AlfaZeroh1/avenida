<?php 
require_once("LandlordemergencycontactsDBO.php");
class Landlordemergencycontacts
{				
	var $id;			
	var $landlordid;			
	var $name;			
	var $relation;			
	var $tel;			
	var $email;			
	var $address;			
	var $physicaladdress;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $landlordemergencycontactsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->landlordid))
			$obj->landlordid='NULL';
		$this->landlordid=$obj->landlordid;
		$this->name=str_replace("'","\'",$obj->name);
		$this->relation=str_replace("'","\'",$obj->relation);
		$this->tel=str_replace("'","\'",$obj->tel);
		$this->email=str_replace("'","\'",$obj->email);
		$this->address=str_replace("'","\'",$obj->address);
		$this->physicaladdress=str_replace("'","\'",$obj->physicaladdress);
		$this->remarks=str_replace("'","\'",$obj->remarks);
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

	//get landlordid
	function getLandlordid(){
		return $this->landlordid;
	}
	//set landlordid
	function setLandlordid($landlordid){
		$this->landlordid=$landlordid;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get relation
	function getRelation(){
		return $this->relation;
	}
	//set relation
	function setRelation($relation){
		$this->relation=$relation;
	}

	//get tel
	function getTel(){
		return $this->tel;
	}
	//set tel
	function setTel($tel){
		$this->tel=$tel;
	}

	//get email
	function getEmail(){
		return $this->email;
	}
	//set email
	function setEmail($email){
		$this->email=$email;
	}

	//get address
	function getAddress(){
		return $this->address;
	}
	//set address
	function setAddress($address){
		$this->address=$address;
	}

	//get physicaladdress
	function getPhysicaladdress(){
		return $this->physicaladdress;
	}
	//set physicaladdress
	function setPhysicaladdress($physicaladdress){
		$this->physicaladdress=$physicaladdress;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
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
		$landlordemergencycontactsDBO = new LandlordemergencycontactsDBO();
		if($landlordemergencycontactsDBO->persist($obj)){
			$this->id=$landlordemergencycontactsDBO->id;
			$this->sql=$landlordemergencycontactsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$landlordemergencycontactsDBO = new LandlordemergencycontactsDBO();
		if($landlordemergencycontactsDBO->update($obj,$where)){
			$this->sql=$landlordemergencycontactsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$landlordemergencycontactsDBO = new LandlordemergencycontactsDBO();
		if($landlordemergencycontactsDBO->delete($obj,$where=""))		
			$this->sql=$landlordemergencycontactsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$landlordemergencycontactsDBO = new LandlordemergencycontactsDBO();
		$this->table=$landlordemergencycontactsDBO->table;
		$landlordemergencycontactsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$landlordemergencycontactsDBO->sql;
		$this->result=$landlordemergencycontactsDBO->result;
		$this->fetchObject=$landlordemergencycontactsDBO->fetchObject;
		$this->affectedRows=$landlordemergencycontactsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->landlordid)){
			$error="Landlord should be provided";
		}
		else if(empty($obj->name)){
			$error="Name should be provided";
		}
		else if(empty($obj->relation)){
			$error="Relation should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->landlordid)){
			$error="Landlord should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
