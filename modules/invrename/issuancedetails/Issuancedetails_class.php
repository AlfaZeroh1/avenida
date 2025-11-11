<?php 
require_once("IssuancedetailsDBO.php");
class Issuancedetails
{				
	var $id;			
	var $issuanceid;			
	var $itemid;			
	var $quantity;	
	var $costprice;
	var $total;
	var $remarks;	
	var $purpose;
	var $blockid;
	var $sectionid;
	var $greenhouseid;
	var $fleetid;
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $issuancedetailsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->issuanceid=str_replace("'","\'",$obj->issuanceid);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		
		if(empty($obj->blockid))
			$obj->blockid='NULL';
		$this->blockid=$obj->blockid;
		if(empty($obj->sectionid))
			$obj->sectionid='NULL';
		$this->sectionid=$obj->sectionid;
		if(empty($obj->greenhouseid))
			$obj->greenhouseid='NULL';
		$this->greenhouseid=$obj->greenhouseid;
		if(empty($obj->fleetid))
			$obj->fleetid='NULL';
		$this->fleetid=$obj->fleetid;
		
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->total=str_replace("'","\'",$obj->total);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->purpose=str_replace("'","\'",$obj->purpose);
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

	//get issuanceid
	function getIssuanceid(){
		return $this->issuanceid;
	}
	//set issuanceid
	function setIssuanceid($issuanceid){
		$this->issuanceid=$issuanceid;
	}

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
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
		$issuancedetailsDBO = new IssuancedetailsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		
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

		$it=0;
		
		$obj->transactdate=$obj->issuedon;
		$obj->rate=$obj->rate;
		$obj->eurorate=$obj->eurorate;
		$obj->currencyid=$obj->currencyid;
		while($i<$num){
			$obj->quantity=$shop[$i]['quantity'];
			$obj->remarks=$shop[$i]['remarks'];
			$obj->itemid=$shop[$i]['itemid'];
			$obj->id=$shop[$i]['issuanceid'];
			$obj->purpose=$shop[$i]['purpose'];
			$obj->blockid=$shop[$i]['blockid'];
			$obj->sectionid=$shop[$i]['sectionid'];
			$obj->greenhouseid=$shop[$i]['greenhouseid'];
			$obj->fleetid=$shop[$i]['fleetid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->code=$shop[$i]['code'];
			$obj->costprice=$shop[$i]['costprice'];
			$obj->total=($shop[$i]['quantity']*$shop[$i]['costprice']);
			
			$issuancedetails = $this->setObject($obj);
			$issuancedetails->effectjournals=$obj->effectjournals;
			
			if($issuancedetailsDBO->persist($issuancedetails)){	
				
				if(empty($obj->effectjournals)){
				  //reduce stock
				  $stocktrack = new Stocktrack();
				  $obj->recorddate=date("Y-m-d");;
				  $obj->transaction="Issuance";
				  $stocktrack->reduceStock($obj);
				}
				
				$items = new Items();
				  $fields="*, inv_categorys.acctypeid, inv_categorys.refid ";
				  $where=" where inv_items.id = '$obj->itemid' ";
				  $join=" left join inv_categorys on inv_categorys.id=inv_items.categoryid ";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $items=$items->fetchObject;			  
				  
				  //credit inventory account
				  $generaljournalaccounts2 = new Generaljournalaccounts();
				  $fields="*";
				  $where=" where refid = '$items->categoryid' and acctypeid='34' ";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
				  
				  //make credit entry
				  $generaljournal = new Generaljournals();
				  $ob->tid=$inwarddetailsDBO->id;
				  $ob->documentno="$obj->documentno";
				  $ob->remarks="ISSUANCE $obj->documentno";
				  $ob->memo=$inwarddetailsDBO->remarks;
				  $ob->accountid=$generaljournalaccounts2->id;
				  $ob->daccountid=$generaljournalaccounts->id;
				  $ob->transactionid=$transaction->id;
				  $ob->mode="credit";
				  $ob->rate=$obj->rate;
				  $ob->eurorate=$obj->eurorate;
				  $ob->credit=$obj->total;
				  $ob->debit=0;
				  $ob->class=$obj->projectid;
				  $generaljournal = $generaljournal->setObject($ob);

				  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
				  $it++;
				  
				  if($items->acctypeid==4)
				    $items->categoryid=$items->refid;
				  
				  //this gives a cost of sales account
				  //debit inventory account
				  $generaljournalaccounts = new Generaljournalaccounts();
				  $fields="*";
				  $where=" where refid = '$items->categoryid' and acctypeid='$items->acctypeid' ";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  $generaljournalaccounts=$generaljournalaccounts->fetchObject;
				  
				  //a cost of department account that is subsidiary of the cos
				  $generaljournalaccount = new Generaljournalaccounts();
				  $fields="*";
				  $where=" where refid = '$obj->departmentid' and acctypeid='37' and categoryid='$generaljournalaccounts->id' ";
				  $join="";
				  $having="";
				  $groupby="";
				  $orderby="";
				  $generaljournalaccount->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				  if($generaljournalaccount->affectedRows<1){
				    
				    $gn = new Generaljournalaccounts();
				    $gn->refid=$obj->departmentid;
				    $gn->acctypeid=37;
				    $gn->categoryid=$generaljournalaccounts->id;
				    $gn->name=$obj->departmentname;
				    $gn->currencyid=5;
				    $gn->createdby=$_SESSION['userid'];
				    $gn->createdon=date("Y-m-d H:i:s");
				    $gn->lasteditedby=$_SESSION['userid'];
				    $gn->lasteditedon=date("Y-m-d H:i:s");
				    $gn->ipaddress=$_SERVER['REMOTE_ADDR'];
				    
				    $gn = $gn->setObject($gn);
				    $gn->add($gn);
				    
				    $generaljournalaccount->id=$gn->id;
				    
				  }
				  else{
				    $generaljournalaccount=$generaljournalaccount->fetchObject;
				  }
				  
				  //make debit entry
				  $generaljournal = new Generaljournals();
				  $ob->tid=$inwarddetailsDBO->id;
				  $ob->documentno="$obj->documentno";
				  $ob->remarks="ISSUANCE $obj->documentno";
				  $ob->memo=$inwarddetailsDBO->remarks;
				  $ob->accountid=$generaljournalaccount->id;
				  $ob->daccountid=$generaljournalaccounts->id;
				  $ob->transactionid=$transaction->id;
				  $ob->mode="credit";
				  $ob->rate=$obj->rate;
				  $ob->eurorate=$obj->eurorate;
				  $ob->debit=$obj->total;
				  $ob->credit=0;
				  $ob->class=$obj->projectid;
				  $generaljournal = $generaljournal->setObject($ob);

				  $shpgeneraljournals[$it]=array('tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'rate'=>"$generaljournal->rate",'eurorate'=>"$generaljournal->eurorate",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class");
				  $it++;
			}
			$i++;
		}
		$gn= new Generaljournals();
		if($obj->effectjournals==1)
		  $gn->add($obj,$shpgeneraljournals);
		  
		return true;	
	}			
	function edit($obj,$where=""){
		$issuancedetailsDBO = new IssuancedetailsDBO();
		if($issuancedetailsDBO->update($obj,$where)){
			$this->sql=$issuancedetailsDBO->sql;
		}
			return true;	
	}			
	function delete($obj,$where){			
		$issuancedetailsDBO = new IssuancedetailsDBO();
		if($issuancedetailsDBO->delete($obj,$where))		
			$this->sql=$issuancedetailsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$issuancedetailsDBO = new IssuancedetailsDBO();
		$this->table=$issuancedetailsDBO->table;
		$issuancedetailsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$issuancedetailsDBO->sql;
		$this->result=$issuancedetailsDBO->result;
		$this->fetchObject=$issuancedetailsDBO->fetchObject;
		$this->affectedRows=$issuancedetailsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->issuanceid)){
			$error="Issuance should be provided";
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
