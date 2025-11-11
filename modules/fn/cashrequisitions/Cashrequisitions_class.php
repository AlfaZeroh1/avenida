<?php 
require_once("CashrequisitionsDBO.php");
require_once("../../../modules/fn/cashrequisitiondetails/CashrequisitiondetailsDBO.php");
class Cashrequisitions
{				
	var $id;			
	var $documentno;			
	var $projectid;			
	var $employeeid;			
	var $description;			
	var $status;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $cashrequisitionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		$this->employeeid=str_replace("'","\'",$obj->employeeid);
		$this->description=str_replace("'","\'",$obj->description);
		$this->status=str_replace("'","\'",$obj->status);
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

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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

	function add($obj,$shop){
		$cashrequisitionsDBO = new CashrequisitionsDBO();
			if($cashrequisitionsDBO->persist($obj)){		
				$cashrequisitiondetails = new Cashrequisitiondetails();
				$obj->cashrequisitionid=$cashrequisitionsDBO->id;
				$cashrequisitiondetails->add($obj,$shop);
				
				$obj->module="fn";
			$obj->role="cashrequisitions";
			
			$tasks = new Tasks();
			$tasks->workFlow($obj);

				$this->id=$cashrequisitionsDBO->id;
				$this->sql=$cashrequisitionsDBO->sql;
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$cashrequisitionsDBO = new CashrequisitionsDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->documentno' ";
		$cashrequisitionsDBO->delete($obj,$where);
		$this->add($obj,$shop);
		
		return true;	
	}			
	function delete($obj,$where=""){			
		$cashrequisitionsDBO = new CashrequisitionsDBO();
		if($cashrequisitionsDBO->delete($obj,$where=""))		
			$this->sql=$cashrequisitionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$cashrequisitionsDBO = new CashrequisitionsDBO();
		$this->table=$cashrequisitionsDBO->table;
		$cashrequisitionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$cashrequisitionsDBO->sql;
		$this->result=$cashrequisitionsDBO->result;
		$this->fetchObject=$cashrequisitionsDBO->fetchObject;
		$this->affectedRows=$cashrequisitionsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documentno)){
			$error="Requisition No should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Requested By should be provided";
		}
		else if(empty($obj->description)){
			$error="Req Description should be provided";
		}
		else if(empty($obj->status)){
			$error="Status should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Requisition No should be provided";
		}
		else if(empty($obj->employeeid)){
			$error="Requested By should be provided";
		}
		else if(empty($obj->description)){
			$error="Req Description should be provided";
		}
		else if(empty($obj->status)){
			$error="Status should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
