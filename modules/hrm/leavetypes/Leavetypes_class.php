<?php 
require_once("LeavetypesDBO.php");
class Leavetypes
{				
	var $id;			
	var $name;			
	var $noofdays;			
	var $type;			
	var $maxcf;			
	var $earningrate;			
	var $per;			
	var $gender;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $leavetypesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->noofdays=str_replace("'","\'",$obj->noofdays);
		$this->type=str_replace("'","\'",$obj->type);
		$this->maxcf=str_replace("'","\'",$obj->maxcf);
		$this->earningrate=str_replace("'","\'",$obj->earningrate);
		$this->per=str_replace("'","\'",$obj->per);
		$this->gender=str_replace("'","\'",$obj->gender);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get noofdays
	function getNoofdays(){
		return $this->noofdays;
	}
	//set noofdays
	function setNoofdays($noofdays){
		$this->noofdays=$noofdays;
	}

	//get type
	function getType(){
		return $this->type;
	}
	//set type
	function setType($type){
		$this->type=$type;
	}

	//get maxcf
	function getMaxcf(){
		return $this->maxcf;
	}
	//set maxcf
	function setMaxcf($maxcf){
		$this->maxcf=$maxcf;
	}

	//get earningrate
	function getEarningrate(){
		return $this->earningrate;
	}
	//set earningrate
	function setEarningrate($earningrate){
		$this->earningrate=$earningrate;
	}

	//get per
	function getPer(){
		return $this->per;
	}
	//set per
	function setPer($per){
		$this->per=$per;
	}

	//get gender
	function getGender(){
		return $this->gender;
	}
	//set gender
	function setGender($gender){
		$this->gender=$gender;
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
		$leavetypesDBO = new LeavetypesDBO();
		if($leavetypesDBO->persist($obj)){
			$this->id=$leavetypesDBO->id;
			$this->sql=$leavetypesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$leavetypesDBO = new LeavetypesDBO();
		if($leavetypesDBO->update($obj,$where)){
			$this->sql=$leavetypesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$leavetypesDBO = new LeavetypesDBO();
		if($leavetypesDBO->delete($obj,$where=""))		
			$this->sql=$leavetypesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$leavetypesDBO = new LeavetypesDBO();
		$this->table=$leavetypesDBO->table;
		$leavetypesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$leavetypesDBO->sql;
		$this->result=$leavetypesDBO->result;
		$this->fetchObject=$leavetypesDBO->fetchObject;
		$this->affectedRows=$leavetypesDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
