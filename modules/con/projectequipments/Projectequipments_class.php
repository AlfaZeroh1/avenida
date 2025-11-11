<?php 
require_once("ProjectequipmentsDBO.php");
class Projectequipments
{				
	var $id;			
	var $equipmentid;			
	var $projectworkscheduleid;			
	var $projectweek;			
	var $week;			
	var $month;			
	var $year;			
	var $type;			
	var $rate;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $projectequipmentsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->equipmentid))
			$obj->equipmentid='NULL';
		$this->equipmentid=$obj->equipmentid;
		if(empty($obj->projectworkscheduleid))
			$obj->projectworkscheduleid='NULL';
		$this->projectworkscheduleid=$obj->projectworkscheduleid;
		$this->projectweek=str_replace("'","\'",$obj->projectweek);
		$this->week=str_replace("'","\'",$obj->week);
		$this->month=str_replace("'","\'",$obj->month);
		$this->year=str_replace("'","\'",$obj->year);
		$this->type=str_replace("'","\'",$obj->type);
		$this->rate=str_replace("'","\'",$obj->rate);
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

	//get equipmentid
	function getEquipmentid(){
		return $this->equipmentid;
	}
	//set equipmentid
	function setEquipmentid($equipmentid){
		$this->equipmentid=$equipmentid;
	}

	//get projectworkscheduleid
	function getProjectworkscheduleid(){
		return $this->projectworkscheduleid;
	}
	//set projectworkscheduleid
	function setProjectworkscheduleid($projectworkscheduleid){
		$this->projectworkscheduleid=$projectworkscheduleid;
	}

	//get projectweek
	function getProjectweek(){
		return $this->projectweek;
	}
	//set projectweek
	function setProjectweek($projectweek){
		$this->projectweek=$projectweek;
	}

	//get week
	function getWeek(){
		return $this->week;
	}
	//set week
	function setWeek($week){
		$this->week=$week;
	}

	//get month
	function getMonth(){
		return $this->month;
	}
	//set month
	function setMonth($month){
		$this->month=$month;
	}

	//get year
	function getYear(){
		return $this->year;
	}
	//set year
	function setYear($year){
		$this->year=$year;
	}

	//get type
	function getType(){
		return $this->type;
	}
	//set type
	function setType($type){
		$this->type=$type;
	}

	//get rate
	function getRate(){
		return $this->rate;
	}
	//set rate
	function setRate($rate){
		$this->rate=$rate;
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
		$projectequipmentsDBO = new ProjectequipmentsDBO();
		if($projectequipmentsDBO->persist($obj)){
			$this->id=$projectequipmentsDBO->id;
			$this->sql=$projectequipmentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectequipmentsDBO = new ProjectequipmentsDBO();
		if($projectequipmentsDBO->update($obj,$where)){
			$this->sql=$projectequipmentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectequipmentsDBO = new ProjectequipmentsDBO();
		if($projectequipmentsDBO->delete($obj,$where=""))		
			$this->sql=$projectequipmentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectequipmentsDBO = new ProjectequipmentsDBO();
		$this->table=$projectequipmentsDBO->table;
		$projectequipmentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectequipmentsDBO->sql;
		$this->result=$projectequipmentsDBO->result;
		$this->fetchObject=$projectequipmentsDBO->fetchObject;
		$this->affectedRows=$projectequipmentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->equipmentid)){
			$error="Equipment should be provided";
		}
		else if(empty($obj->projectworkscheduleid)){
			$error="Work Schedule should be provided";
		}
		else if(empty($obj->projectweek)){
			$error="Project Week should be provided";
		}
		else if(empty($obj->week)){
			$error="Calendar Week should be provided";
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
