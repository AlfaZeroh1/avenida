<?php 
require_once("BreakdownsDBO.php");
class Breakdowns
{				
	var $id;			
	var $assetid;			
	var $description;			
	var $brokedownon;			
	var $reactivatedon;			
	var $cost;			
	var $refno;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $breakdownsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->assetid=str_replace("'","\'",$obj->assetid);
		$this->description=str_replace("'","\'",$obj->description);
		$this->brokedownon=str_replace("'","\'",$obj->brokedownon);
		$this->reactivatedon=str_replace("'","\'",$obj->reactivatedon);
		$this->cost=str_replace("'","\'",$obj->cost);
		$this->refno=str_replace("'","\'",$obj->refno);
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

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
	}

	//get brokedownon
	function getBrokedownon(){
		return $this->brokedownon;
	}
	//set brokedownon
	function setBrokedownon($brokedownon){
		$this->brokedownon=$brokedownon;
	}

	//get reactivatedon
	function getReactivatedon(){
		return $this->reactivatedon;
	}
	//set reactivatedon
	function setReactivatedon($reactivatedon){
		$this->reactivatedon=$reactivatedon;
	}

	//get cost
	function getCost(){
		return $this->cost;
	}
	//set cost
	function setCost($cost){
		$this->cost=$cost;
	}

	//get refno
	function getRefno(){
		return $this->refno;
	}
	//set refno
	function setRefno($refno){
		$this->refno=$refno;
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
		$breakdownsDBO = new BreakdownsDBO();
		if($breakdownsDBO->persist($obj)){
			$this->id=$breakdownsDBO->id;
			$this->sql=$breakdownsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$breakdownsDBO = new BreakdownsDBO();
		if($breakdownsDBO->update($obj,$where)){
			$this->sql=$breakdownsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$breakdownsDBO = new BreakdownsDBO();
		if($breakdownsDBO->delete($obj,$where=""))		
			$this->sql=$breakdownsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$breakdownsDBO = new BreakdownsDBO();
		$this->table=$breakdownsDBO->table;
		$breakdownsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$breakdownsDBO->sql;
		$this->result=$breakdownsDBO->result;
		$this->fetchObject=$breakdownsDBO->fetchObject;
		$this->affectedRows=$breakdownsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->assetid)){
			$error="Asset should be provided";
		}
		else if(empty($obj->description)){
			$error="Breakdown Description should be provided";
		}
		else if(empty($obj->brokedownon)){
			$error="Break Down Date should be provided";
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
