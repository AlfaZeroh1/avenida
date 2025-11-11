<?php 
require_once("DocumentsDBO.php");
class Documents
{				
	var $id;			
	var $tenderid;			
	var $documenttypeid;			
	var $title;			
	var $file;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $documentsDBO;
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
		if(empty($obj->documenttypeid))
			$obj->documenttypeid='NULL';
		$this->documenttypeid=$obj->documenttypeid;
		$this->title=str_replace("'","\'",$obj->title);
		$this->file=str_replace("'","\'",$obj->file);
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

	//get tenderid
	function getTenderid(){
		return $this->tenderid;
	}
	//set tenderid
	function setTenderid($tenderid){
		$this->tenderid=$tenderid;
	}

	//get documenttypeid
	function getDocumenttypeid(){
		return $this->documenttypeid;
	}
	//set documenttypeid
	function setDocumenttypeid($documenttypeid){
		$this->documenttypeid=$documenttypeid;
	}

	//get title
	function getTitle(){
		return $this->title;
	}
	//set title
	function setTitle($title){
		$this->title=$title;
	}

	//get file
	function getFile(){
		return $this->file;
	}
	//set file
	function setFile($file){
		$this->file=$file;
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
		$obj->departmentid=1;
		$obj->categoryid=2;
		
		$config = new Config();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where name='DMS_RESOURCE'";
		$config->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$config=$config->fetchObject;
		
		$tender = new Tenders();
		$fields=" tender_tenders.id, tender_tendertypes.name, tender_tenders.proposalno ";
		$join=" left join tender_tendertypes on tender_tendertypes.id=tender_tenders.tendertypeid left join tender_checklists on tender_checklists.tenderid=tender_tenders.id ";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where tender_tenders.id='$obj->tenderid' ";
		$tender->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$tender=$tender->fetchObject;
		
		$extras = $tender->name."/".$tender->proposalno;
		
		$documentss = new Documentss();
		$documentss->setObject($obj);
		$documentss->extras=$extras;
		$file=$config->value."/".$obj->document;
		$filename=$obj->file;
		$documentss->add($documentss,$file,$filename);
		$documentsDBO = new DocumentsDBO();
		
		$documentsDBO = new DocumentsDBO();
		if($documentsDBO->persist($obj)){
			$this->id=$documentsDBO->id;
			$this->sql=$documentsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$documentsDBO = new DocumentsDBO();
		if($documentsDBO->update($obj,$where)){
			$this->sql=$documentsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$documentsDBO = new DocumentsDBO();
		if($documentsDBO->delete($obj,$where=""))		
			$this->sql=$documentsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$documentsDBO = new DocumentsDBO();
		$this->table=$documentsDBO->table;
		$documentsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$documentsDBO->sql;
		$this->result=$documentsDBO->result;
		$this->fetchObject=$documentsDBO->fetchObject;
		$this->affectedRows=$documentsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->tenderid)){
			$error="Tender should be provided";
		}
		else if(empty($obj->documenttypeid)){
			$error="Document Type should be provided";
		}
		else if(empty($obj->title)){
			$error="Title should be provided";
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
