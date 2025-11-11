<?php 
require_once("ProjectsDBO.php");
class Projects
{				
	var $id;			
	var $tenderid;			
	var $name;			
	var $projecttypeid;			
	var $customerid;			
	var $employeeid;			
	var $regionid;			
	var $subregionid;			
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
	var $projectsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->tenderid))
			$obj->tenderid='NULL';
		$this->tenderid=$obj->tenderid;
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->projecttypeid))
			$obj->projecttypeid='NULL';
		$this->projecttypeid=$obj->projecttypeid;
		if(empty($obj->customerid))
			$obj->customerid='NULL';
		$this->customerid=$obj->customerid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		if(empty($obj->regionid))
			$obj->regionid='NULL';
		$this->regionid=$obj->regionid;
		if(empty($obj->subregionid))
			$obj->subregionid='NULL';
		$this->subregionid=$obj->subregionid;
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
		if(empty($obj->statusid))
			$obj->statusid='NULL';
		$this->statusid=$obj->statusid;
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

	//get tenderid
	function getTenderid(){
		return $this->tenderid;
	}
	//set tenderid
	function setTenderid($tenderid){
		$this->tenderid=$tenderid;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get projecttypeid
	function getProjecttypeid(){
		return $this->projecttypeid;
	}
	//set projecttypeid
	function setProjecttypeid($projecttypeid){
		$this->projecttypeid=$projecttypeid;
	}

	//get customerid
	function getCustomerid(){
		return $this->customerid;
	}
	//set customerid
	function setCustomerid($customerid){
		$this->customerid=$customerid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get regionid
	function getRegionid(){
		return $this->regionid;
	}
	//set regionid
	function setRegionid($regionid){
		$this->regionid=$regionid;
	}

	//get subregionid
	function getSubregionid(){
		return $this->subregionid;
	}
	//set subregionid
	function setSubregionid($subregionid){
		$this->subregionid=$subregionid;
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
		$projectsDBO = new ProjectsDBO();
		if($projectsDBO->persist($obj)){
			$this->id=$projectsDBO->id;
			$this->sql=$projectsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$projectsDBO = new ProjectsDBO();
		if($projectsDBO->update($obj,$where)){
			$this->sql=$projectsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$projectsDBO = new ProjectsDBO();
		if($projectsDBO->delete($obj,$where=""))		
			$this->sql=$projectsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$projectsDBO = new ProjectsDBO();
		$this->table=$projectsDBO->table;
		$projectsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$projectsDBO->sql;
		$this->result=$projectsDBO->result;
		$this->fetchObject=$projectsDBO->fetchObject;
		$this->affectedRows=$projectsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Project Name should be provided";
		}
		else if(empty($obj->customerid)){
			$error="Customer should be provided";
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
		if(empty($obj->customerid)){
			$error="Customer should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
