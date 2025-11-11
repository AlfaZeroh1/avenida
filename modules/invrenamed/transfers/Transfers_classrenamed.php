<?php 
require_once("TransfersDBO.php");
require_once("../../../modules/inv/transferdetails/TransferdetailsDBO.php");
require_once("../../../modules/inv/transferdetails/Transferdetails_class.php");
class Transfers
{				
	var $id;			
	var $documentno;
	var $requisitionno;
	var $brancheid;			
	var $tobrancheid;			
	var $remarks;
	var $version;
	var $transferedon;			
	var $status;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $transfersDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->requisitionno=str_replace("'","\'",$obj->requisitionno);
		if(empty($obj->brancheid))
			$obj->brancheid='NULL';
		$this->brancheid=$obj->brancheid;
		if(empty($obj->tobrancheid))
			$obj->tobrancheid='NULL';
		$this->tobrancheid=$obj->tobrancheid;
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->transferedon=str_replace("'","\'",$obj->transferedon);
		$this->status=str_replace("'","\'",$obj->status);
		$this->version=str_replace("'","\'",$obj->version);
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

	//get brancheid
	function getBrancheid(){
		return $this->brancheid;
	}
	//set brancheid
	function setBrancheid($brancheid){
		$this->brancheid=$brancheid;
	}

	//get tobrancheid
	function getTobrancheid(){
		return $this->tobrancheid;
	}
	//set tobrancheid
	function setTobrancheid($tobrancheid){
		$this->tobrancheid=$tobrancheid;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get transferedon
	function getTransferedon(){
		return $this->transferedon;
	}
	//set transferedon
	function setTransferedon($transferedon){
		$this->transferedon=$transferedon;
	}

	//get status
	function getStatus(){
		return $this->status;
	}
	//set status
	function setStatus($status){
		$this->status=$status;
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
		$transfersDBO = new TransfersDBO();
			if($transfersDBO->persist($obj)){		
				
				$query="update inv_requisitions set status=3 where documentno='$obj->requisitionno'";
				mysql_query($query);
				
				$transferdetails = new Transferdetails();
				$obj->transferid=$transfersDBO->id;
				
				$transferdetails->add($obj,$shop);
			
                        require_once("../../pm/tasks/Tasks_class.php");
			$obj->module="inv";
			$obj->role="transfers";
			
			$brancheid = $_SESSION['brancheid'];
			$tasks = new Tasks();
			$_SESSION['brancheid']=$obj->tobrancheid;
			$tasks->workflow($obj);
			
			
			$this->id=$transfersDBO->id;
			$this->sql=$transfersDBO->sql;
			}
			$_SESSION['brancheid']=$brancheid;
		return true;	
	}			
	function edit($obj,$shop){
	        $transferdetails = new Transferdetails();
	        $transfersDBO = new TransfersDBO();
	        $transfersDBO->update($obj,"documentno='$obj->documentno'");
		$transferdetails->edit($obj,$shop);
		return true;	
	}			
	function delete($obj,$where=""){			
		$transfersDBO = new TransfersDBO();
		if($transfersDBO->delete($obj,$where=""))		
			$this->sql=$transfersDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$transfersDBO = new TransfersDBO();
		$this->table=$transfersDBO->table;
		$transfersDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$transfersDBO->sql;
		$this->result=$transfersDBO->result;
		$this->fetchObject=$transfersDBO->fetchObject;
		$this->affectedRows=$transfersDBO->affectedRows;
	}			
	function validate($obj){
		//check that all installation codes are provided
		$i=0;
		$shptransfers=$_SESSION['shptransfers'];
		$err=false;
		while($i<count($shptransfers)){
		  if($shptransfers[$i]['installationcode']=="Yes" and empty($shptransfers[$i]['instalcode'])){
		    $err=true;
		    break;
		  }
		  $i++;
		}
		if(empty($obj->documentno)){
			$error="Transfer No should be provided";
		}elseif(empty($obj->tobrancheid)){
                        $error="To  should be provided";
                }elseif($err){
			$error="Make sure that all products are tied to Instal Codes Accordingly!";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		//check that all installation codes are provided
		$i=0;
		$shptransfers=$_SESSION['shptransfers'];
		$err=false;
		while($i<count($shptransfers)){
		  if($shptransfers[$i]['installationcode']=="Yes" and empty($shptransfers[$i]['instalcode']) and $obj->version==1){
		    $err=true;
		    break;
		  }
		  $i++;
		}
		if(empty($obj->documentno)){
			$error="Transfer No should be provided";
		}elseif(empty($obj->tobrancheid)){
                        $error="To should be provided";
                }elseif($err){
			$error="Make sure that all products are tied to Instal Codes Accordingly!";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
