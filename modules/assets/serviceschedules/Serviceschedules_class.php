<?php 
require_once("ServiceschedulesDBO.php");
class Serviceschedules
{				
	var $id;			
	var $assetid;			
	var $servicedate;			
	var $servicetypeid;			
	var $description;			
	var $recommendations;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $serviceschedulesDBO;
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
		$this->servicedate=str_replace("'","\'",$obj->servicedate);
		if(empty($obj->servicetypeid))
			$obj->servicetypeid='NULL';
		$this->servicetypeid=$obj->servicetypeid;
		$this->description=str_replace("'","\'",$obj->description);
		$this->recommendations=str_replace("'","\'",$obj->recommendations);
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

	//get servicedate
	function getServicedate(){
		return $this->servicedate;
	}
	//set servicedate
	function setServicedate($servicedate){
		$this->servicedate=$servicedate;
	}

	//get servicetypeid
	function getServicetypeid(){
		return $this->servicetypeid;
	}
	//set servicetypeid
	function setServicetypeid($servicetypeid){
		$this->servicetypeid=$servicetypeid;
	}

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
	}

	//get recommendations
	function getRecommendations(){
		return $this->recommendations;
	}
	//set recommendations
	function setRecommendations($recommendations){
		$this->recommendations=$recommendations;
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
		$serviceschedulesDBO = new ServiceschedulesDBO();
		if($serviceschedulesDBO->persist($obj)){
			$this->id=$serviceschedulesDBO->id;
			$this->sql=$serviceschedulesDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$serviceschedulesDBO = new ServiceschedulesDBO();
		if($serviceschedulesDBO->update($obj,$where)){
			$this->sql=$serviceschedulesDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$serviceschedulesDBO = new ServiceschedulesDBO();
		if($serviceschedulesDBO->delete($obj,$where=""))		
			$this->sql=$serviceschedulesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$serviceschedulesDBO = new ServiceschedulesDBO();
		$this->table=$serviceschedulesDBO->table;
		$serviceschedulesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$serviceschedulesDBO->sql;
		$this->result=$serviceschedulesDBO->result;
		$this->fetchObject=$serviceschedulesDBO->fetchObject;
		$this->affectedRows=$serviceschedulesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->assetid)){
			$error="Asset should be provided";
		}
		else if(empty($obj->servicedate)){
			$error="Service Date should be provided";
		}
		else if(empty($obj->servicetypeid)){
			$error="Service Type should be provided";
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
