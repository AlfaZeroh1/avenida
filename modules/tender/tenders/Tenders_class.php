<?php 
require_once("TendersDBO.php");
class Tenders
{				
	var $id;			
	var $proposalno;			
	var $name;			
	var $tendertypeid;			
	var $datereceived;			
	var $actionplandate;			
	var $dateofreview;			
	var $dateofsubmission;			
	var $employeeid;			
	var $Statusid;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $tendersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->proposalno=str_replace("'","\'",$obj->proposalno);
		$this->name=str_replace("'","\'",$obj->name);
		if(empty($obj->tendertypeid))
			$obj->tendertypeid='NULL';
		$this->tendertypeid=$obj->tendertypeid;
		$this->datereceived=str_replace("'","\'",$obj->datereceived);
		$this->actionplandate=str_replace("'","\'",$obj->actionplandate);
		$this->dateofreview=str_replace("'","\'",$obj->dateofreview);
		$this->dateofsubmission=str_replace("'","\'",$obj->dateofsubmission);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		if(empty($obj->statusid))
			$obj->statusid='NULL';
		$this->statusid=$obj->statusid;
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

	//get proposalno
	function getProposalno(){
		return $this->proposalno;
	}
	//set proposalno
	function setProposalno($proposalno){
		$this->proposalno=$proposalno;
	}

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get tendertypeid
	function getTendertypeid(){
		return $this->tendertypeid;
	}
	//set tendertypeid
	function setTendertypeid($tendertypeid){
		$this->tendertypeid=$tendertypeid;
	}

	//get datereceived
	function getDatereceived(){
		return $this->datereceived;
	}
	//set datereceived
	function setDatereceived($datereceived){
		$this->datereceived=$datereceived;
	}

	//get actionplandate
	function getActionplandate(){
		return $this->actionplandate;
	}
	//set actionplandate
	function setActionplandate($actionplandate){
		$this->actionplandate=$actionplandate;
	}

	//get dateofreview
	function getDateofreview(){
		return $this->dateofreview;
	}
	//set dateofreview
	function setDateofreview($dateofreview){
		$this->dateofreview=$dateofreview;
	}

	//get dateofsubmission
	function getDateofsubmission(){
		return $this->dateofsubmission;
	}
	//set dateofsubmission
	function setDateofsubmission($dateofsubmission){
		$this->dateofsubmission=$dateofsubmission;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get Statusid
	function getStatusid(){
		return $this->statusid;
	}
	//set Statusid
	function setStatusid($statusid){
		$this->statusid=$statusid;
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
		$tendersDBO = new TendersDBO();
		if($tendersDBO->persist($obj)){
			$this->id=$tendersDBO->id;
			$this->sql=$tendersDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$tendersDBO = new TendersDBO();
		if($tendersDBO->update($obj,$where)){
			$this->sql=$tendersDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$tendersDBO = new TendersDBO();
		if($tendersDBO->delete($obj,$where=""))		
			$this->sql=$tendersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$tendersDBO = new TendersDBO();
		$this->table=$tendersDBO->table;
		$tendersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$tendersDBO->sql;
		$this->result=$tendersDBO->result;
		$this->fetchObject=$tendersDBO->fetchObject;
		$this->affectedRows=$tendersDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Tender Description should be provided";
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
