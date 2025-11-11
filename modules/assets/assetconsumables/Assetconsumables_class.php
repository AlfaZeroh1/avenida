<?php 
require_once("AssetconsumablesDBO.php");
class Assetconsumables
{				
	var $id;			
	var $assetid;			
	var $consumableid;			
	var $serialno;			
	var $fittedon;			
	var $startmileage;			
	var $currentmileage;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $assetconsumablesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->assetid))
			$obj->assetid='NULL';
		$this->assetid=$obj->assetid;
		if(empty($obj->consumableid))
			$obj->consumableid='NULL';
		$this->consumableid=$obj->consumableid;
		$this->serialno=str_replace("'","\'",$obj->serialno);
		$this->fittedon=str_replace("'","\'",$obj->fittedon);
		$this->startmileage=str_replace("'","\'",$obj->startmileage);
		$this->currentmileage=str_replace("'","\'",$obj->currentmileage);
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

	//get assetid
	function getAssetid(){
		return $this->assetid;
	}
	//set assetid
	function setAssetid($assetid){
		$this->assetid=$assetid;
	}

	//get consumableid
	function getConsumableid(){
		return $this->consumableid;
	}
	//set consumableid
	function setConsumableid($consumableid){
		$this->consumableid=$consumableid;
	}

	//get serialno
	function getSerialno(){
		return $this->serialno;
	}
	//set serialno
	function setSerialno($serialno){
		$this->serialno=$serialno;
	}

	//get fittedon
	function getFittedon(){
		return $this->fittedon;
	}
	//set fittedon
	function setFittedon($fittedon){
		$this->fittedon=$fittedon;
	}

	//get startmileage
	function getStartmileage(){
		return $this->startmileage;
	}
	//set startmileage
	function setStartmileage($startmileage){
		$this->startmileage=$startmileage;
	}

	//get currentmileage
	function getCurrentmileage(){
		return $this->currentmileage;
	}
	//set currentmileage
	function setCurrentmileage($currentmileage){
		$this->currentmileage=$currentmileage;
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
		$assetconsumablesDBO = new AssetconsumablesDBO();
		if($assetconsumablesDBO->persist($obj)){
			$this->id=$assetconsumablesDBO->id;
			$this->sql=$assetconsumablesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$assetconsumablesDBO = new AssetconsumablesDBO();
		if($assetconsumablesDBO->update($obj,$where)){
			$this->sql=$assetconsumablesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$assetconsumablesDBO = new AssetconsumablesDBO();
		if($assetconsumablesDBO->delete($obj,$where=""))		
			$this->sql=$assetconsumablesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$assetconsumablesDBO = new AssetconsumablesDBO();
		$this->table=$assetconsumablesDBO->table;
		$assetconsumablesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$assetconsumablesDBO->sql;
		$this->result=$assetconsumablesDBO->result;
		$this->fetchObject=$assetconsumablesDBO->fetchObject;
		$this->affectedRows=$assetconsumablesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->assetid)){
			$error="Asset should be provided";
		}
		else if(empty($obj->consumableid)){
			$error="Consumable should be provided";
		}
		else if(empty($obj->serialno)){
			$error="Serial No should be provided";
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
