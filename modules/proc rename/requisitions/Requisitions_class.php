<?php 
require_once("RequisitionsDBO.php");
require_once("../../../modules/proc/requisitiondetails/RequisitiondetailsDBO.php");
class Requisitions
{				
	var $id;			
	var $documentno;
	var $description;
	var $departmentid;			
	var $projectid;			
	var $requisitiondate;			
	var $remarks;	
	var $categoryid;
	var $status;			
	var $file;
	var $employeename;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;
	var $employeeid;
	var $requisitionsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->description=str_replace("'","\'",$obj->description);
		if(empty($obj->departmentid))
			$obj->departmentid='NULL';
		$this->departmentid=$obj->departmentid;
		if(empty($obj->projectid))
			$obj->projectid='NULL';
		$this->projectid=$obj->projectid;
		$this->requisitiondate=str_replace("'","\'",$obj->requisitiondate);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->status=str_replace("'","\'",$obj->status);
		$this->file=str_replace("'","\'",$obj->file);
		$this->employeename=str_replace("'","\'",$obj->employeename);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
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
	
	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
	}

	//get type
	function getType(){
		return $this->type;
	}
	//set type
	function setType($type){
		$this->type=$type;
	}

	//get projectid
	function getProjectid(){
		return $this->projectid;
	}
	//set projectid
	function setProjectid($projectid){
		$this->projectid=$projectid;
	}

	//get requisitiondate
	function getRequisitiondate(){
		return $this->requisitiondate;
	}
	//set requisitiondate
	function setRequisitiondate($requisitiondate){
		$this->requisitiondate=$requisitiondate;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get file
	function getFile(){
		return $this->file;
	}
	//set file
	function setFile($file){
		$this->file=$file;
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

	
	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}
	
	function add($obj,$shop){
		$requisitionsDBO = new RequisitionsDBO();
		
		$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from proc_requisitions"));
		if($defs->documentno == null){
			$defs->documentno=1;
		}
		$obj->documentno=$defs->documentno;
			      
			if($requisitionsDBO->persist($obj)){		
				
				
				$requisitiondetails = new Requisitiondetails();
				$obj->requisitionid=$requisitionsDBO->id;
				$requisitiondetails->add($obj,$shop);

				
				$obj->routeid=1;
				//get routedetailid
				/*$routedetails = new Routedetails();
				$fields="*";
				$join="";
				$where=" where routeid='$obj->routeid' and follows=0";
				$having="";
				$groupby="";
				$orderby="";
				$routedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);//echo $routedetails->sql;
				$routedetails = $routedetails->fetchObject;*/
				
				$obj->workflow=1;	
				$obj->routedetailid=0;
				
				$obj->ownerid=$_SESSION['employeeid'];
				$obj->name="Requisition Approval #". $obj->documentno;
				$obj->projectid-$obj->projectid;
				$obj->projecttype="Requisition";
				$obj->assignmentid=$obj->assignmentid;
				$obj->employeeid=$obj->employeeid;
				$obj->documenttype="Requisition";
				$obj->documentno=$obj->documentno;
				$obj->tracktime="Yes";
				$obj->reqduration=$routedetails->expectedduration;
				$obj->reqdurationtype=$routedetails->durationtype;
				$obj->createdby=$_SESSION['userid'];
				$obj->createdon=date("Y-m-d H:i:s");
				$obj->lasteditedby=$_SESSION['userid'];
				$obj->lasteditedon=date("Y-m-d H:i:s");
				$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
				$obj->statusid=1;
				$obj->subject="Requisition Approval #". $obj->documentno;
				$obj->body="A Requisition has been raised that requires your attention";
				
				$tasks = new Tasks();
				$tasks->processTask($obj);
				
				$this->id=$requisitionsDBO->id;
				$this->sql=$requisitionsDBO->sql;
				
				
			}
		return true;	
	}			
	function edit($obj,$where="",$shop){
		$requisitionsDBO = new RequisitionsDBO();

		$requisitions  = new Requisitions();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where documentno='$obj->documentno'";
		$requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$requisitions=$requisitions->fetchObject;
		
		$requisitiondetails = new Requisitiondetails();
		$where=" where requisitionid='$requisitions->id' ";
		$requisitiondetails->delete($obj,$where);		
		
		//first delete all records under old documentno
		$where=" where documentno='$obj->documentno'";
		$requisitionsDBO->delete($obj,$where);

		if($this->add($obj,$shop))
		  return true;	
	}			
	function delete($obj,$where=""){			
		$requisitionsDBO = new RequisitionsDBO();
		if($requisitionsDBO->delete($obj,$where=""))		
			$this->sql=$requisitionsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$requisitionsDBO = new RequisitionsDBO();
		$this->table=$requisitionsDBO->table;
		$requisitionsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$requisitionsDBO->sql;
		$this->result=$requisitionsDBO->result;
		$this->fetchObject=$requisitionsDBO->fetchObject;
		$this->affectedRows=$requisitionsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->departmentid)){
			$error="Requisition Department should be provided";
		}
		
		else if(empty($obj->description)){
			$error="Req Description should be provided";
		}
		
		else if(empty($obj->employeeid)){
			$error="Requested By  should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
        if(empty($obj->departmentid)){
			$error="Requisition Department should be provided";
		}
		
	else if(empty($obj->description)){
		$error="Req Description should be provided";
	}
	
	else if(empty($obj->employeeid)){
		$error="Requested By  should be provided";
	}
	if(!empty($error))
		return $error;
	else
		return null;
}		
}
?>
