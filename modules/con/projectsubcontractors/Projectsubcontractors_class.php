<?php 
require_once("ProjectsubcontractorsDBO.php");
class Projectsubcontractors
{				
	var $id;			
	var $supplierid;			
	var $projectid;			
	var $contractno;			
	var $physicaladdress;			
	var $scope;			
	var $value;			
	var $dateawarded;			
	var $acceptanceletterdate;			
	var $contractsignedon;			
	var $orderdatetocommence;			
	var $startdate;			
	var $expectedenddate;			
	var $actualenddate;			
	var $liabilityperiodtype;			
	var $liabilityperiod;			
	var $remarks;			
	var $statusid;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $projectsubcontractorsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		$this->contractno=str_replace("'","\'",$obj->contractno);
		$this->physicaladdress=str_replace("'","\'",$obj->physicaladdress);
		$this->scope=str_replace("'","\'",$obj->scope);
		$this->value=str_replace("'","\'",$obj->value);
		$this->dateawarded=str_replace("'","\'",$obj->dateawarded);
		$this->acceptanceletterdate=str_replace("'","\'",$obj->acceptanceletterdate);
		$this->contractsignedon=str_replace("'","\'",$obj->contractsignedon);
		$this->orderdatetocommence=str_replace("'","\'",$obj->orderdatetocommence);
		$this->startdate=str_replace("'","\'",$obj->startdate);
		$this->expectedenddate=str_replace("'","\'",$obj->expectedenddate);
		$this->actualenddate=str_replace("'","\'",$obj->actualenddate);
		$this->liabilityperiodtype=str_replace("'","\'",$obj->liabilityperiodtype);
		$this->liabilityperiod=str_replace("'","\'",$obj->liabilityperiod);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->statusid=str_replace("'","\'",$obj->statusid);
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

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
	}

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
	}

	//get contractno
	function getContractno(){
		return $this->contractno;
	}
	//set contractno
	function setContractno($contractno){
		$this->contractno=$contractno;
	}

	//get physicaladdress
	function getPhysicaladdress(){
		return $this->physicaladdress;
	}
	//set physicaladdress
	function setPhysicaladdress($physicaladdress){
		$this->physicaladdress=$physicaladdress;
	}

	//get scope
	function getScope(){
		return $this->scope;
	}
	//set scope
	function setScope($scope){
		$this->scope=$scope;
	}

	//get value
	function getValue(){
		return $this->value;
	}
	//set value
	function setValue($value){
		$this->value=$value;
	}

	//get dateawarded
	function getDateawarded(){
		return $this->dateawarded;
	}
	//set dateawarded
	function setDateawarded($dateawarded){
		$this->dateawarded=$dateawarded;
	}

	//get acceptanceletterdate
	function getAcceptanceletterdate(){
		return $this->acceptanceletterdate;
	}
	//set acceptanceletterdate
	function setAcceptanceletterdate($acceptanceletterdate){
		$this->acceptanceletterdate=$acceptanceletterdate;
	}

	//get contractsignedon
	function getContractsignedon(){
		return $this->contractsignedon;
	}
	//set contractsignedon
	function setContractsignedon($contractsignedon){
		$this->contractsignedon=$contractsignedon;
	}

	//get orderdatetocommence
	function getOrderdatetocommence(){
		return $this->orderdatetocommence;
	}
	//set orderdatetocommence
	function setOrderdatetocommence($orderdatetocommence){
		$this->orderdatetocommence=$orderdatetocommence;
	}

	//get startdate
	function getStartdate(){
		return $this->startdate;
	}
	//set startdate
	function setStartdate($startdate){
		$this->startdate=$startdate;
	}

	//get expectedenddate
	function getExpectedenddate(){
		return $this->expectedenddate;
	}
	//set expectedenddate
	function setExpectedenddate($expectedenddate){
		$this->expectedenddate=$expectedenddate;
	}

	//get actualenddate
	function getActualenddate(){
		return $this->actualenddate;
	}
	//set actualenddate
	function setActualenddate($actualenddate){
		$this->actualenddate=$actualenddate;
	}

	//get liabilityperiodtype
	function getLiabilityperiodtype(){
		return $this->liabilityperiodtype;
	}
	//set liabilityperiodtype
	function setLiabilityperiodtype($liabilityperiodtype){
		$this->liabilityperiodtype=$liabilityperiodtype;
	}

	//get liabilityperiod
	function getLiabilityperiod(){
		return $this->liabilityperiod;
	}
	//set liabilityperiod
	function setLiabilityperiod($liabilityperiod){
		$this->liabilityperiod=$liabilityperiod;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get statusid
	function getStatusid(){
		return $this->statusid;
	}
	//set statusid
	function setStatusid($statusid){
		$this->statusid=$statusid;
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
		$projectsubcontractorsDBO = new ProjectsubcontractorsDBO();
		if($projectsubcontractorsDBO->persist($obj)){
			$this->id=$projectsubcontractorsDBO->id;
			$this->sql=$projectsubcontractorsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectsubcontractorsDBO = new ProjectsubcontractorsDBO();
		if($projectsubcontractorsDBO->update($obj,$where)){
			$this->sql=$projectsubcontractorsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectsubcontractorsDBO = new ProjectsubcontractorsDBO();
		if($projectsubcontractorsDBO->delete($obj,$where=""))		
			$this->sql=$projectsubcontractorsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectsubcontractorsDBO = new ProjectsubcontractorsDBO();
		$this->table=$projectsubcontractorsDBO->table;
		$projectsubcontractorsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectsubcontractorsDBO->sql;
		$this->result=$projectsubcontractorsDBO->result;
		$this->fetchObject=$projectsubcontractorsDBO->fetchObject;
		$this->affectedRows=$projectsubcontractorsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->supplierid)){
			$error="Sub Contractor should be provided";
		}
		else if(empty($obj->projectid)){
			$error="Project should be provided";
		}
		else if(empty($obj->statusid)){
			$error="Status should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->supplierid)){
			$error="Sub Contractor should be provided";
		}
		else if(empty($obj->projectid)){
			$error="Project should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
