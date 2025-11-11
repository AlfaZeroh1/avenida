<?php 
require_once("IssuanceDBO.php");
class Issuance
{				
	var $id;			
	var $departmentid;			
	var $employeeid;
	var $costprice;
	var $issuedon;			
	var $documentno;	
	var $requisitionno;
	var $remarks;			
	var $memo;			
	var $received;	
	var $journals;
	var $receivedon;
	var $currencyid;
	var $rate;
	var $eurorate;
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $issuanceDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
				
		if(empty($obj->departmentid))
			$obj->departmentid=NULL;
		$this->departmentid=$obj->departmentid;		
		
		if(empty($obj->employeeid))
			$obj->employeeid=NULL;
		$this->employeeid=$obj->employeeid;
		
		if(empty($obj->currencyid))
			$obj->currencyid=NULL;
		$this->currencyid=$obj->currencyid;
		
		$this->rate=str_replace("'","\'",$obj->rate);
		$this->eurorate=str_replace("'","\'",$obj->eurorate);		
		$this->issuedon=str_replace("'","\'",$obj->issuedon);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->requisitionno=str_replace("'","\'",$obj->requisitionno);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->received=str_replace("'","\'",$obj->received);
		$this->receivedon=str_replace("'","\'",$obj->receivedon);
		$this->journals=str_replace("'","\'",$obj->journals);
		$this->createdby=str_replace("'","\'",$obj->createdby);
		$this->createdon=str_replace("'","\'",$obj->createdon);
		$this->lasteditedby=str_replace("'","\'",$obj->lasteditedby);
		$this->lasteditedon=str_replace("'","\'",$obj->lasteditedon);
		$this->ipaddress=str_replace("'","\'",$obj->ipaddress);
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

	//get issuedon
	function getIssuedon(){
		return $this->issuedon;
	}
	//set issuedon
	function setIssuedon($issuedon){
		$this->issuedon=$issuedon;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
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

	//get received
	function getReceived(){
		return $this->received;
	}
	//set received
	function setReceived($received){
		$this->received=$received;
	}

	//get receivedon
	function getReceivedon(){
		return $this->receivedon;
	}
	//set receivedon
	function setReceivedon($receivedon){
		$this->receivedon=$receivedon;
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

	//get ipaddress
	function getIpaddress(){
		return $this->ipaddress;
	}
	//set ipaddress
	function setIpaddress($ipaddress){
		$this->ipaddress=$ipaddress;
	}

	function add($obj,$shop){
		$issuanceDBO = new IssuanceDBO();
		
		if(empty($obj->retrieve) and empty($obj->effectjournals)){ 
		$defs=mysql_fetch_object(mysql_query("select (max(documentno)+1) documentno from inv_issuance"));
		if($defs->documentno == null){
			$defs->documentno=1;
		}
		$obj->documentno=$defs->documentno;
		}
		
		$ob = $this->setObject($obj);
		$ob->effectjournals=$obj->effectjournals;
		
		if($issuanceDBO->persist($ob)){ 
		  $issuancedetails = new Issuancedetails(); 
		  
		//get departmentname 
		$dep = new Departments();
		$fields="*";
		$where=" where id= '$obj->departmentid' ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$dep->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $generaljournalaccounts->sql."\n";
		$dep=$dep->fetchObject;
		
		$obj->issuanceid=$issuanceDBO->id;
		$obj->currencyid=$obj->currencyid;
		$obj->exchangerate=$obj->rate;
		$obj->exchangerate2=$obj->eurorate;
		$obj->departmentname=$dep->name;
		
		
		$issuancedetails->add($obj,$shop);
		}
		return true;
	}			
	function edit($obj,$where="",$shop){
		$issuanceDBO = new IssuanceDBO();
		
		if(!empty($obj->documentno)){
		      $issuancedetails = new Issuancedetails();
		      $fields=" inv_issuancedetails.*";
		      $where=" where issuanceid=(select id from inv_issuance where documentno='$obj->documentno') ";
		      $join="";
		      $having="";
		      $groupby="";
		      $orderby="";
		      $issuancedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);// echo $issuancedetails->sql;
		      $shpissuance=array();
		      $it=0;
		      while($row=mysql_fetch_object($issuancedetails->result)){
			
			$ob = $row;
			
			$items = new Items();
			$fields=" * ";
			$where=" where id='$row->itemid'";
			$join="";
			$having="";
			$groupby="";
			$orderby="";
			$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$items=$items->fetchObject;
			
			$shpissuance[$it]=array('id'=>"$ob->id",'documentno'=>"$ob->documentno",'costprice'=>"$ob->costprice",'total'=>"$ob->total", 'itemid'=>"$ob->itemid", 'itemname'=>"$items->name", 'quantity'=>"$ob->quantity", 'blockname'=>"$ob->blockname", 'remarks'=>"$ob->remarks", 'purpose'=>"$ob->purpose", 'sectionname'=>"$ob->sectionname",'greenhousename'=>"$ob->greenhousename",'employeename'=>"$ob->employeename",'employeeid'=>"$ob->employeeid",'total'=>"$ob->total",'categoryid'=>"$ob->categoryid", 'categoryname'=>"$ob->category");
			$it++;
			
			
		  }
		  }
		$num=count($shpissuance);
		$i=0;
		$total=0;
		$it=0;
		
                while($i<$num){
			  $objs->quantity=$shpissuance[$i]['quantity'];
			  $objs->remarks=$shpissuance[$i]['remarks'];
			  $objs->itemid=$shpissuance[$i]['itemid'];
			  $objs->id=$shpissuance[$i]['issuanceid'];
			  $objs->purpose=$shpissuance[$i]['purpose'];
			  $objs->blockid=$shpissuance[$i]['blockid'];
			  $objs->sectionid=$shpissuance[$i]['sectionid'];
			  $objs->greenhouseid=$shpissuance[$i]['greenhouseid'];
			  $objs->fleetid=$shpissuance[$i]['fleetid'];
			  $objs->itemname=$shpissuance[$i]['itemname'];
			  $objs->code=$shpissuance[$i]['code'];
			  $objs->costprice=$shpissuance[$i]['costprice'];
			  $objs->total=$shpissuance[$i]['total'];
			  
			  
				  $items = new Items();
				  $fields="*";
				  $where=" where id='$objs->itemid'";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);//echo $items->sql;
				  $items=$items->fetchObject;
				  
				 if($items->reducing=="Yes"){ //echo "HERE";				  
				    //insert into stock track  
				     $stocktrack = new Stocktrack();
				     $objs->recorddate=date("Y-m-d");
				     $objs->transaction="Issuance Update";
				     $objs->documentno=$obj->documentno;
				     $stocktrack->addStock($objs);			  	    
				  }			  
				
				$i++;
			  }

		//Get transaction Identity
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='issuance'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;
		
		$issuancess = new Issuance();
		$fields="*";
		$where=" where documentno='$obj->documentno' ";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$issuancess->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$issuancess=$issuancess->fetchObject;
		
		$obj->createdby=$issuancess->createdby;
		$obj->createdon=$issuancess->createdon;
		
		$issuancedetails = new Issuancedetails();
		$where=" where issuanceid=(select id from inv_issuance where documentno='$obj->documentno') ";
		$issuancedetails->delete($obj,$where);//echo $issuancedetails->sql;
		
		//first delete all records under old documentno
		$where=" where documentno='$obj->documentno'";
		$issuanceDBO->delete($obj,$where);		

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->documentno' and transactionid='$transaction->id' ";
		$gn->delete($obj,$where);
                
                $obj->retrieve=1;
		$issuance= new Issuance();
		if($issuance->add($obj,$shop))
		  return true;		
	}			
	function delete($obj,$where=""){			
		$issuanceDBO = new IssuanceDBO();
		if($issuanceDBO->delete($obj,$where=""))		
			$this->sql=$issuanceDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$issuanceDBO = new IssuanceDBO();
		$this->table=$issuanceDBO->table;
		$issuanceDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$issuanceDBO->sql;
		$this->result=$issuanceDBO->result;
		$this->fetchObject=$issuanceDBO->fetchObject;
		$this->affectedRows=$issuanceDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->itemid)){
			$error="Item should be provided";
		}elseif(empty($obj->departmentid)){
			$error="Department should be provided";
		}elseif(empty($obj->employeeid)){
		    $error="Employee should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}else if(empty($obj->rate)){
			$error="Rate should be provided";
		}else if(empty($obj->eurorate)){
			$error="Euro Rate should be provided";
		}
		
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	
		if(empty($obj->departmentid)){
			$error="Department should be provided";
		}elseif(empty($obj->employeeid)){
		    $error="Employee should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}else if(empty($obj->rate)){
			$error="Rate should be provided";
		}else if(empty($obj->eurorate)){
			$error="Euro Rate should be provided";
		}
		
		
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
