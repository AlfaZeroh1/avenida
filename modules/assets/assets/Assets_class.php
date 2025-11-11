<?php 
require_once("AssetsDBO.php");
class Assets
{				
	var $id;			
	var $name;			
	var $photo;			
	var $documentno;			
	var $categoryid;			
	var $departmentid;			
	var $employeeid;			
	var $value;			
	var $salvagevalue;			
	var $purchasedon;			
	var $supplierid;			
	var $lpono;			
	var $deliveryno;			
	var $remarks;			
	var $memo;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $assetsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->name=str_replace("'","\'",$obj->name);
		$this->photo=str_replace("'","\'",$obj->photo);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->categoryid))
			$obj->categoryid='NULL';
		$this->categoryid=$obj->categoryid;
		if(empty($obj->departmentid))
			$obj->departmentid='NULL';
		$this->departmentid=$obj->departmentid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->value=str_replace("'","\'",$obj->value);
		$this->salvagevalue=str_replace("'","\'",$obj->salvagevalue);
		$this->purchasedon=str_replace("'","\'",$obj->purchasedon);
		if(empty($obj->supplierid))
			$obj->supplierid='NULL';
		$this->supplierid=$obj->supplierid;
		$this->lpono=str_replace("'","\'",$obj->lpono);
		$this->deliveryno=str_replace("'","\'",$obj->deliveryno);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->memo=str_replace("'","\'",$obj->memo);
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

	//get name
	function getName(){
		return $this->name;
	}
	//set name
	function setName($name){
		$this->name=$name;
	}

	//get photo
	function getPhoto(){
		return $this->photo;
	}
	//set photo
	function setPhoto($photo){
		$this->photo=$photo;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get categoryid
	function getCategoryid(){
		return $this->categoryid;
	}
	//set categoryid
	function setCategoryid($categoryid){
		$this->categoryid=$categoryid;
	}

	//get departmentid
	function getDepartmentid(){
		return $this->departmentid;
	}
	//set departmentid
	function setDepartmentid($departmentid){
		$this->departmentid=$departmentid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get value
	function getValue(){
		return $this->value;
	}
	//set value
	function setValue($value){
		$this->value=$value;
	}

	//get salvagevalue
	function getSalvagevalue(){
		return $this->salvagevalue;
	}
	//set salvagevalue
	function setSalvagevalue($salvagevalue){
		$this->salvagevalue=$salvagevalue;
	}

	//get purchasedon
	function getPurchasedon(){
		return $this->purchasedon;
	}
	//set purchasedon
	function setPurchasedon($purchasedon){
		$this->purchasedon=$purchasedon;
	}

	//get supplierid
	function getSupplierid(){
		return $this->supplierid;
	}
	//set supplierid
	function setSupplierid($supplierid){
		$this->supplierid=$supplierid;
	}

	//get lpono
	function getLpono(){
		return $this->lpono;
	}
	//set lpono
	function setLpono($lpono){
		$this->lpono=$lpono;
	}

	//get deliveryno
	function getDeliveryno(){
		return $this->deliveryno;
	}
	//set deliveryno
	function setDeliveryno($deliveryno){
		$this->deliveryno=$deliveryno;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
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
		$assetsDBO = new AssetsDBO();
		if($assetsDBO->persist($obj)){
			
			//get categoryid
			
			$categorys= new Categorys();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where id='$obj->categoryid' ";
			$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$categorys = $categorys->fetchObject;
			
			$generaljournalaccounts= new Generaljournalaccounts();
			$fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$where=" where acctypeid=7 and refid='$obj->categoryid' and categoryid in (select id from fn_generaljournalaccounts where refid='$categorys->departmentid' and acctypeid=7 and categoryid is null) ";
			$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$generaljournalaccounts = $generaljournalaccounts->fetchObject;
			
			//add account to gj
			$gna = new Generaljournalaccounts();
			$gna->refid=$assetsDBO->id;
			$gna->categoryid=$generaljournalaccounts->id;
			$gna->acctypeid=7;
			$gna->name=$obj->name;
			$gna->currencyid=5;
			$gna = $gna->setObject($gna);
			$gna->add($gna);
			
			$this->id=$assetsDBO->id;
			$this->sql=$assetsDBO->sql;
			return true;	
		}
	}			
	function edit($obj,$where=""){
		$assetsDBO = new AssetsDBO();
		if($assetsDBO->update($obj,$where)){
			$this->sql=$assetsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where=""){			
		$assetsDBO = new AssetsDBO();
		if($assetsDBO->delete($obj,$where=""))		
			$this->sql=$assetsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$assetsDBO = new AssetsDBO();
		$this->table=$assetsDBO->table;
		$assetsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$assetsDBO->sql;
		$this->result=$assetsDBO->result;
		$this->fetchObject=$assetsDBO->fetchObject;
		$this->affectedRows=$assetsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->name)){
			$error="Asset Name should be provided";
		}
		else if(empty($obj->categoryid)){
			$error="Asset Category should be provided";
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
