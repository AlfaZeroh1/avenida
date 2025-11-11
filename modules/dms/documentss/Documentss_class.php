<?php 
require_once("DocumentssDBO.php");
class Documentss
{				
	var $id;			
	var $routeid;			
	var $documentno;			
	var $documenttypeid;			
	var $departmentid;			
	var $departmentcategoryid;			
	var $categoryid;			
	var $hrmdepartmentid;			
	var $document;			
	var $link;			
	var $status;			
	var $expirydate;			
	var $description;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $documentssDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->routeid))
			$obj->routeid='NULL';
		$this->routeid=$obj->routeid;
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->documenttypeid))
			$obj->documenttypeid='NULL';
		$this->documenttypeid=$obj->documenttypeid;
		if(empty($obj->departmentid))
			$obj->departmentid='NULL';
		$this->departmentid=$obj->departmentid;
		
		if(empty($obj->departmentcategoryid))
			$obj->departmentcategoryid='NULL';
		$this->departmentcategoryid=$obj->departmentcategoryid;
		if(empty($obj->categoryid))
			$obj->categoryid='NULL';
		$this->categoryid=$obj->categoryid;
		if(empty($obj->hrmdepartmentid))
			$obj->hrmdepartmentid='NULL';
		$this->hrmdepartmentid=$obj->hrmdepartmentid;
		$this->document=str_replace("'","\'",$obj->document);
		$this->link=str_replace("'","\'",$obj->link);
		$this->status=str_replace("'","\'",$obj->status);
		$this->expirydate=str_replace("'","\'",$obj->expirydate);
		$this->description=str_replace("'","\'",$obj->description);
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

	//get routeid
	function getRouteid(){
		return $this->routeid;
	}
	//set routeid
	function setRouteid($routeid){
		$this->routeid=$routeid;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get documenttypeid
	function getDocumenttypeid(){
		return $this->documenttypeid;
	}
	//set documenttypeid
	function setDocumenttypeid($documenttypeid){
		$this->documenttypeid=$documenttypeid;
	}

	//get departmentid
	function getDepartmentid(){
		return $this->departmentid;
	}
	//set departmentid
	function setDepartmentid($departmentid){
		$this->departmentid=$departmentid;
	}

	//get departmentcategoryid
	function getDepartmentcategoryid(){
		return $this->departmentcategoryid;
	}
	//set departmentcategoryid
	function setDepartmentcategoryid($departmentcategoryid){
		$this->departmentcategoryid=$departmentcategoryid;
	}

	//get categoryid
	function getCategoryid(){
		return $this->categoryid;
	}
	//set categoryid
	function setCategoryid($categoryid){
		$this->categoryid=$categoryid;
	}

	//get hrmdepartmentid
	function getHrmdepartmentid(){
		return $this->hrmdepartmentid;
	}
	//set hrmdepartmentid
	function setHrmdepartmentid($hrmdepartmentid){
		$this->hrmdepartmentid=$hrmdepartmentid;
	}

	//get document
	function getDocument(){
		return $this->document;
	}
	//set document
	function setDocument($document){
		$this->document=$document;
	}

	//get link
	function getLink(){
		return $this->link;
	}
	//set link
	function setLink($link){
		$this->link=$link;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
	}

	//get expirydate
	function getExpirydate(){
		return $this->expirydate;
	}
	//set expirydate
	function setExpirydate($expirydate){
		$this->expirydate=$expirydate;
	}

	//get description
	function getDescription(){
		return $this->description;
	}
	//set description
	function setDescription($description){
		$this->description=$description;
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

	function add($obj,$file,$filename){
		$documentssDBO = new DocumentssDBO();
		
		$config = new Config();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where name='DMS_RESOURCE'";
		$config->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$config=$config->fetchObject;
		
		$categorys = new Categorys();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where id='$obj->categoryid' ";
		$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$categorys=$categorys->fetchObject;
		
		$departments = new Departments();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where id='$obj->departmentid' ";
		$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$departments=$departments->fetchObject;
		
		$departmentcategorys = new Departmentcategorys();
		$fields="*";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where id='$obj->departmentcategoryid' ";
		$departmentcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$departmentcategorys=$departmentcategorys->fetchObject;
		
		$documenttypes=new Documenttypes();
		$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$where=" where dms_documenttypes.id ='$obj->documenttypeid' ";
		$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$documenttypes=$documenttypes->fetchObject;
		
		$ext = explode(".",$filename);
		
		$nm=count($ext);
		
		$obj->document=$obj->document.".".$ext[$nm-1];
		
		$obj->file=$file;
		
		$obj->link="";
		
		
		if(!empty($departments->name))
		  $obj->link.=$departments->name."/";
		if(!empty($departmentcategorys->name))
		  $obj->link.=$departmentcategorys->name."/"; 
		if(!empty($categorys->name))
		  $obj->link.=$categorys->name."/"; 			  
		
		  
		if(!empty($obj->extras))
		  $obj->link.=$obj->extras."/";
		  
		if(!empty($documenttypes->name))
		  $obj->link.=$documenttypes->name."/";
			  
		$dir=$config->value;
		
		@mkdir($dir);
		
		$str=explode("/",$obj->link);
		$num=count($str);
		$i=0;
		while($i<$num){
		  $dir.="/".$str[$i];
		  @mkdir($dir);
		  $i++;
		}
		echo $obj->file."<br/>";
		echo $dir."".$obj->document;
		if(copy($obj->file,$dir."".$obj->document)){
		  if($documentssDBO->persist($obj)){
			  $this->id=$documentssDBO->id;
			  $this->sql=$documentssDBO->sql;
			  
			  return true;	
		  }
		}
	}			
	function edit($obj,$where=""){
		$documentssDBO = new DocumentssDBO();
		if($documentssDBO->update($obj,$where)){
			$this->sql=$documentssDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$documentssDBO = new DocumentssDBO();
		if($documentssDBO->delete($obj,$where=""))		
			$this->sql=$documentssDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$documentssDBO = new DocumentssDBO();
		$this->table=$documentssDBO->table;
		$documentssDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$documentssDBO->sql;
		$this->result=$documentssDBO->result;
		$this->fetchObject=$documentssDBO->fetchObject;
		$this->affectedRows=$documentssDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->documenttypeid)){
			$error="Document Type should be provided";
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
