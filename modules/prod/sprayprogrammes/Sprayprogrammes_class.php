<?php 
require_once("SprayprogrammesDBO.php");
class Sprayprogrammes
{				
	var $id;			
	var $areaid;			
	var $varietyid;			
	var $chemicalid;			
	var $ingredients;			
	var $quantity;			
	var $watervol;			
	var $blockid;
	var $greenhouseid;
	var $nozzleid;			
	var $target;			
	var $spraymethodid;			
	var $spraydate;			
	var $time;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $sprayprogrammesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->areaid))
			$obj->areaid='NULL';
		$this->areaid=$obj->areaid;
		if(empty($obj->varietyid))
			$obj->varietyid='NULL';
		$this->varietyid=$obj->varietyid;
		if(empty($obj->chemicalid))
			$obj->chemicalid='NULL';
		$this->chemicalid=$obj->chemicalid;
		$this->ingredients=str_replace("'","\'",$obj->ingredients);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->watervol=str_replace("'","\'",$obj->watervol);
		if(empty($obj->blockid))
			$obj->blockid='NULL';
		$this->blockid=$obj->blockid;
		if(empty($obj->greenhouseid))
			$obj->greenhouseid='NULL';
		$this->greenhouseid=$obj->greenhouseid;
		if(empty($obj->nozzleid))
			$obj->nozzleid='NULL';
		$this->nozzleid=$obj->nozzleid;
		$this->target=str_replace("'","\'",$obj->target);
		if(empty($obj->spraymethodid))
			$obj->spraymethodid='NULL';
		$this->spraymethodid=$obj->spraymethodid;
		$this->spraydate=str_replace("'","\'",$obj->spraydate);
		$this->time=str_replace("'","\'",$obj->time);
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

	//get areaid
	function getAreaid(){
		return $this->areaid;
	}
	//set areaid
	function setAreaid($areaid){
		$this->areaid=$areaid;
	}

	//get varietyid
	function getVarietyid(){
		return $this->varietyid;
	}
	//set varietyid
	function setVarietyid($varietyid){
		$this->varietyid=$varietyid;
	}

	//get chemicalid
	function getChemicalid(){
		return $this->chemicalid;
	}
	//set chemicalid
	function setChemicalid($chemicalid){
		$this->chemicalid=$chemicalid;
	}

	//get ingredients
	function getIngredients(){
		return $this->ingredients;
	}
	//set ingredients
	function setIngredients($ingredients){
		$this->ingredients=$ingredients;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get watervol
	function getWatervol(){
		return $this->watervol;
	}
	//set watervol
	function setWatervol($watervol){
		$this->watervol=$watervol;
	}

	//get blockid
	function getBlockid(){
		return $this->blockid;
	}
	//set blockid
	function setBlockid($blockid){
		$this->blockid=$blockid;
	}
	
	
	//get blockid
	function getGreenhouseid(){
		return $this->greenhouseid;
	}
	//set blockid
	function setgetGreenhouseid($blockid){
		$this->greenhouseid=$greenhouseid;
	}

	//get nozzleid
	function getNozzleid(){
		return $this->nozzleid;
	}
	//set nozzleid
	function setNozzleid($nozzleid){
		$this->nozzleid=$nozzleid;
	}

	//get target
	function getTarget(){
		return $this->target;
	}
	//set target
	function setTarget($target){
		$this->target=$target;
	}

	//get spraymethodid
	function getSpraymethodid(){
		return $this->spraymethodid;
	}
	//set spraymethodid
	function setSpraymethodid($spraymethodid){
		$this->spraymethodid=$spraymethodid;
	}

	//get spraydate
	function getSpraydate(){
		return $this->spraydate;
	}
	//set spraydate
	function setSpraydate($spraydate){
		$this->spraydate=$spraydate;
	}

	//get time
	function getTime(){
		return $this->time;
	}
	//set time
	function setTime($time){
		$this->time=$time;
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
		$sprayprogrammesDBO = new SprayprogrammesDBO();
		if($sprayprogrammesDBO->persist($obj)){
			$this->id=$sprayprogrammesDBO->id;
			$this->sql=$sprayprogrammesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$sprayprogrammesDBO = new SprayprogrammesDBO();
		if($sprayprogrammesDBO->update($obj,$where)){
			$this->sql=$sprayprogrammesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$sprayprogrammesDBO = new SprayprogrammesDBO();
		if($sprayprogrammesDBO->delete($obj,$where=""))		
			$this->sql=$sprayprogrammesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$sprayprogrammesDBO = new SprayprogrammesDBO();
		$this->table=$sprayprogrammesDBO->table;
		$sprayprogrammesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$sprayprogrammesDBO->sql;
		$this->result=$sprayprogrammesDBO->result;
		$this->fetchObject=$sprayprogrammesDBO->fetchObject;
		$this->affectedRows=$sprayprogrammesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->varietyid)){
			$error="Variety should be provided";
		}
		else if(empty($obj->chemicalid)){
			$error="Chemical should be provided";
		}
		else if(empty($obj->spraydate)){
			$error="Spray Date should be provided";
		}
		else if(empty($obj->time)){
			$error="Spray Time should be provided";
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
