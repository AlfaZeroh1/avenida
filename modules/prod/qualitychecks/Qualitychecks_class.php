<?php 
require_once("QualitychecksDBO.php");
class Qualitychecks
{				
	var $id;			
	var $checkitemid;			
	var $breederdeliverydetailid;			
	var $breederid;			
	var $varietyid;			
	var $checkedon;			
	var $findings;			
	var $remarks;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $qualitychecksDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->checkitemid))
			$obj->checkitemid='NULL';
		$this->checkitemid=$obj->checkitemid;
		if(empty($obj->breederdeliverydetailid))
			$obj->breederdeliverydetailid='NULL';
		$this->breederdeliverydetailid=$obj->breederdeliverydetailid;
		if(empty($obj->breederid))
			$obj->breederid='NULL';
		$this->breederid=$obj->breederid;
		if(empty($obj->varietyid))
			$obj->varietyid='NULL';
		$this->varietyid=$obj->varietyid;
		$this->checkedon=str_replace("'","\'",$obj->checkedon);
		$this->findings=str_replace("'","\'",$obj->findings);
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

	//get checkitemid
	function getCheckitemid(){
		return $this->checkitemid;
	}
	//set checkitemid
	function setCheckitemid($checkitemid){
		$this->checkitemid=$checkitemid;
	}

	//get breederdeliverydetailid
	function getBreederdeliverydetailid(){
		return $this->breederdeliverydetailid;
	}
	//set breederdeliverydetailid
	function setBreederdeliverydetailid($breederdeliverydetailid){
		$this->breederdeliverydetailid=$breederdeliverydetailid;
	}

	//get breederid
	function getBreederid(){
		return $this->breederid;
	}
	//set breederid
	function setBreederid($breederid){
		$this->breederid=$breederid;
	}

	//get varietyid
	function getVarietyid(){
		return $this->varietyid;
	}
	//set varietyid
	function setVarietyid($varietyid){
		$this->varietyid=$varietyid;
	}

	//get checkedon
	function getCheckedon(){
		return $this->checkedon;
	}
	//set checkedon
	function setCheckedon($checkedon){
		$this->checkedon=$checkedon;
	}

	//get findings
	function getFindings(){
		return $this->findings;
	}
	//set findings
	function setFindings($findings){
		$this->findings=$findings;
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
		$qualitychecksDBO = new QualitychecksDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->checkitemid=$shop[$i]['checkitemid'];
			$obj->breederdeliverydetailid=$shop[$i]['breederdeliverydetailid'];
			$obj->checkitemname=$shop[$i]['checkitemname'];
			$obj->varietyid=$shop[$i]['varietyid'];
			$obj->varietyname=$shop[$i]['varietyname'];
			$obj->findings=$shop[$i]['findings'];
			$obj->remarks=$shop[$i]['remarks'];
			if($qualitychecksDBO->persist($obj,$where)){
				$this->sql=$qualitychecksDBO->sql;
			}
			$i++;
		}
		return true;
	}			
	function edit($obj,$where="",$shop){
		$qualitychecksDBO = new QualitychecksDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$qualitychecksDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){
			$obj->checkitemid=$shop['checkitemid'];
			$obj->checkitemname=$shop['checkitemname'];
			$obj->varietyid=$shop['varietyid'];
			$obj->varietyname=$shop['varietyname'];
			$obj->findings=$shop['findings'];
			$obj->remarks=$shop['remarks'];
			if($qualitychecksDBO->update($obj,$where)){
				$this->sql=$qualitychecksDBO->sql;
			}
		}
		return true;	
	}			
	function delete($obj,$where=""){			
		$qualitychecksDBO = new QualitychecksDBO();
		if($qualitychecksDBO->delete($obj,$where=""))		
			$this->sql=$qualitychecksDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$qualitychecksDBO = new QualitychecksDBO();
		$this->table=$qualitychecksDBO->table;
		$qualitychecksDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$qualitychecksDBO->sql;
		$this->result=$qualitychecksDBO->result;
		$this->fetchObject=$qualitychecksDBO->fetchObject;
		$this->affectedRows=$qualitychecksDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->checkitemid)){
			$error="Check Item should be provided";
		}
		else if(empty($obj->breederdeliverydetailid)){
			$error="Delivery should be provided";
		}
		else if(empty($obj->breederid)){
			$error="Breeder should be provided";
		}
		else if(empty($obj->varietyid)){
			$error="Variety should be provided";
		}
		else if(empty($obj->checkedon)){
			$error="Check Date should be provided";
		}
		else if(empty($obj->findings)){
			$error="Findings should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->breederid)){
			$error="Breeder should be provided";
		}
		else if(empty($obj->checkedon)){
			$error="Check Date should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
