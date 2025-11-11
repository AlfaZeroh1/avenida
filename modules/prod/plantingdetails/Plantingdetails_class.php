<?php 
require_once("PlantingdetailsDBO.php");
class Plantingdetails
{				
	var $id;			
	var $plantingid;			
	var $varietyid;			
	var $areaid;			
	var $quantity;			
	var $memo;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $plantingdetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->plantingid))
			$obj->plantingid='NULL';
		$this->plantingid=$obj->plantingid;
		if(empty($obj->varietyid))
			$obj->varietyid='NULL';
		$this->varietyid=$obj->varietyid;
		if(empty($obj->areaid))
			$obj->areaid='NULL';
		$this->areaid=$obj->areaid;
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->memo=str_replace("'","\'",$obj->memo);
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

	//get plantingid
	function getPlantingid(){
		return $this->plantingid;
	}
	//set plantingid
	function setPlantingid($plantingid){
		$this->plantingid=$plantingid;
	}

	//get varietyid
	function getVarietyid(){
		return $this->varietyid;
	}
	//set varietyid
	function setVarietyid($varietyid){
		$this->varietyid=$varietyid;
	}

	//get areaid
	function getAreaid(){
		return $this->areaid;
	}
	//set areaid
	function setAreaid($areaid){
		$this->areaid=$areaid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
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

	function add($obj,$shop){
		$plantingdetailsDBO = new PlantingdetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->varietyid=$shop[$i]['varietyid'];
			$obj->varietyname=$shop[$i]['varietyname'];
			$obj->areaid=$shop[$i]['areaid'];
			$obj->areaname=$shop[$i]['areaname'];
			$obj->quantity=$shop[$i]['quantity'];
			$obj->memo=$shop[$i]['memo'];
			if($plantingdetailsDBO->persist($obj)){		
				$this->id=$plantingdetailsDBO->id;
				$this->sql=$plantingdetailsDBO->sql;
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where=""){
		$plantingdetailsDBO = new PlantingdetailsDBO();
		if($plantingdetailsDBO->update($obj,$where)){
			$this->sql=$plantingdetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$plantingdetailsDBO = new PlantingdetailsDBO();
		if($plantingdetailsDBO->delete($obj,$where=""))		
			$this->sql=$plantingdetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$plantingdetailsDBO = new PlantingdetailsDBO();
		$this->table=$plantingdetailsDBO->table;
		$plantingdetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$plantingdetailsDBO->sql;
		$this->result=$plantingdetailsDBO->result;
		$this->fetchObject=$plantingdetailsDBO->fetchObject;
		$this->affectedRows=$plantingdetailsDBO->affectedRows;
	}			
	function validate($obj){
	
			return null;
	
	}

	function validates($obj){
	
			return null;
	
	}
}				
?>
