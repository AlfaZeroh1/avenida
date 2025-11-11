<?php 
require_once("PatientlaboratorytestsDBO.php");
class Patientlaboratorytests
{				
	var $id;			
	var $testno;			
	var $patientid;			
	var $patienttreatmentid;			
	var $laboratorytestid;			
	var $charge;			
	var $labresults;			
	var $testedon;			
	var $consult;				
	var $results;
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $patientlaboratorytestsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	//get id
	function getId(){
		return $this->id;
	}
	//set id
	function setId($id){
		$this->id=$id;
	}

	//get testno
	function getTestno(){
		return $this->testno;
	}
	//set testno
	function setTestno($testno){
		$this->testno=$testno;
	}

	//get patientid
	function getPatientid(){
		return $this->patientid;
	}
	//set patientid
	function setPatientid($patientid){
		$this->patientid=$patientid;
	}

	//get patienttreatmentid
	function getPatienttreatmentid(){
		return $this->patienttreatmentid;
	}
	//set patienttreatmentid
	function setPatienttreatmentid($patienttreatmentid){
		$this->patienttreatmentid=$patienttreatmentid;
	}

	//get laboratorytestid
	function getLaboratorytestid(){
		return $this->laboratorytestid;
	}
	//set laboratorytestid
	function setLaboratorytestid($laboratorytestid){
		$this->laboratorytestid=$laboratorytestid;
	}

	//get charge
	function getCharge(){
		return $this->charge;
	}
	//set charge
	function setCharge($charge){
		$this->charge=$charge;
	}

	//get labresults
	function getLabresults(){
		return $this->labresults;
	}
	//set labresults
	function setLabresults($labresults){
		$this->labresults=$labresults;
	}

	//get testedon
	function getTestedon(){
		return $this->testedon;
	}
	//set testedon
	function setTestedon($testedon){
		$this->testedon=$testedon;
	}

	//get consult
	function getConsult(){
		return $this->consult;
	}
	//set consult
	function setConsult($consult){
		$this->consult=$consult;
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
		if(empty($obj->testno)){
			$patientlaboratorytests = new Patientlaboratorytests();
			$fields=" max(testno) testno ";
			$where="";
			$having="";
			$orderby="";
			$groupby="";
			$patientlaboratorytests->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$patientlaboratorytests = $patientlaboratorytests->fetchObject;
			$obj->testno=$patientlaboratorytests->testno+1;
		}
		$patientlaboratorytestsDBO = new PatientlaboratorytestsDBO();
		if($patientlaboratorytestsDBO->persist($obj)){		
			$this->id=$patientlaboratorytestsDBO->id;
			return true;	
		}
	}			
	function edit($obj){			
		$patientlaboratorytestsDBO = new PatientlaboratorytestsDBO();
		if($patientlaboratorytestsDBO->update($obj))		
			return true;	
	}			
	function delete($obj){			
		$patientlaboratorytestsDBO = new PatientlaboratorytestsDBO();
		if($patientlaboratorytestsDBO->delete($obj))		
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$patientlaboratorytestsDBO = new PatientlaboratorytestsDBO();
		$this->table=$patientlaboratorytestsDBO->table;
		$patientlaboratorytestsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$patientlaboratorytestsDBO->sql;
		$this->result=$patientlaboratorytestsDBO->result;
		$this->fetchObject=$patientlaboratorytestsDBO->fetchObject;
		$this->affectedRows=$patientlaboratorytestsDBO->affectedRows;
	}			
}				
?>
