<?php 
require_once("SalesDBO.php");
class Sales
{				
	var $id;			
	var $itemid;			
	var $documentno;			
	var $patientid;			
	var $agentid;			
	var $employeeid;			
	var $remarks;			
	var $quantity;			
	var $costprice;			
	var $tradeprice;			
	var $retailprice;			
	var $discount;			
	var $tax;			
	var $bonus;			
	var $profit;			
	var $total;			
	var $mode;			
	var $soldon;			
	var $expirydate;			
	var $memo;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $ipaddress;			
	var $salesDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		if(empty($obj->itemid))
			$obj->itemid='NULL';
		$this->itemid=$obj->itemid;
		$this->documentno=str_replace("'","\'",$obj->documentno);
		if(empty($obj->patientid))
			$obj->patientid='NULL';
		$this->patientid=$obj->patientid;
		if(empty($obj->agentid))
			$obj->agentid='NULL';
		$this->agentid=$obj->agentid;
		if(empty($obj->employeeid))
			$obj->employeeid='NULL';
		$this->employeeid=$obj->employeeid;
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->quantity=str_replace("'","\'",$obj->quantity);
		$this->costprice=str_replace("'","\'",$obj->costprice);
		$this->tradeprice=str_replace("'","\'",$obj->tradeprice);
		$this->retailprice=str_replace("'","\'",$obj->retailprice);
		$this->discount=str_replace("'","\'",$obj->discount);
		$this->tax=str_replace("'","\'",$obj->tax);
		$this->bonus=str_replace("'","\'",$obj->bonus);
		$this->profit=str_replace("'","\'",$obj->profit);
		$this->total=str_replace("'","\'",$obj->total);
		$this->mode=str_replace("'","\'",$obj->mode);
		$this->soldon=str_replace("'","\'",$obj->soldon);
		$this->expirydate=str_replace("'","\'",$obj->expirydate);
		$this->memo=str_replace("'","\'",$obj->memo);
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

	//get itemid
	function getItemid(){
		return $this->itemid;
	}
	//set itemid
	function setItemid($itemid){
		$this->itemid=$itemid;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get patientid
	function getPatientid(){
		return $this->patientid;
	}
	//set patientid
	function setPatientid($patientid){
		$this->patientid=$patientid;
	}

	//get agentid
	function getAgentid(){
		return $this->agentid;
	}
	//set agentid
	function setAgentid($agentid){
		$this->agentid=$agentid;
	}

	//get employeeid
	function getEmployeeid(){
		return $this->employeeid;
	}
	//set employeeid
	function setEmployeeid($employeeid){
		$this->employeeid=$employeeid;
	}

	//get remarks
	function getRemarks(){
		return $this->remarks;
	}
	//set remarks
	function setRemarks($remarks){
		$this->remarks=$remarks;
	}

	//get quantity
	function getQuantity(){
		return $this->quantity;
	}
	//set quantity
	function setQuantity($quantity){
		$this->quantity=$quantity;
	}

	//get costprice
	function getCostprice(){
		return $this->costprice;
	}
	//set costprice
	function setCostprice($costprice){
		$this->costprice=$costprice;
	}

	//get tradeprice
	function getTradeprice(){
		return $this->tradeprice;
	}
	//set tradeprice
	function setTradeprice($tradeprice){
		$this->tradeprice=$tradeprice;
	}

	//get retailprice
	function getRetailprice(){
		return $this->retailprice;
	}
	//set retailprice
	function setRetailprice($retailprice){
		$this->retailprice=$retailprice;
	}

	//get discount
	function getDiscount(){
		return $this->discount;
	}
	//set discount
	function setDiscount($discount){
		$this->discount=$discount;
	}

	//get tax
	function getTax(){
		return $this->tax;
	}
	//set tax
	function setTax($tax){
		$this->tax=$tax;
	}

	//get bonus
	function getBonus(){
		return $this->bonus;
	}
	//set bonus
	function setBonus($bonus){
		$this->bonus=$bonus;
	}

	//get profit
	function getProfit(){
		return $this->profit;
	}
	//set profit
	function setProfit($profit){
		$this->profit=$profit;
	}

	//get total
	function getTotal(){
		return $this->total;
	}
	//set total
	function setTotal($total){
		$this->total=$total;
	}

	//get mode
	function getMode(){
		return $this->mode;
	}
	//set mode
	function setMode($mode){
		$this->mode=$mode;
	}

	//get soldon
	function getSoldon(){
		return $this->soldon;
	}
	//set soldon
	function setSoldon($soldon){
		$this->soldon=$soldon;
	}

	//get expirydate
	function getExpirydate(){
		return $this->expirydate;
	}
	//set expirydate
	function setExpirydate($expirydate){
		$this->expirydate=$expirydate;
	}

	//get memo
	function getMemo(){
		return $this->memo;
	}
	//set memo
	function setMemo($memo){
		$this->memo=$memo;
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
		$salesDBO = new SalesDBO();
		$num=count($shop);
		$i=0;
		$it=0;
		$total=0;
		$shppayments=array();
		while($i<$num){

			$total+=$obj->total;
			$obj->tt=0;

			$obj->quantity=$shop[$i]['quantity'];
			$obj->itemid=$shop[$i]['itemid'];
			$obj->itemname=$shop[$i]['itemname'];
			$obj->code=$shop[$i]['code'];
			$obj->stock=$shop[$i]['stock'];
			$obj->tax=$shop[$i]['tax'];
			$obj->discount=$shop[$i]['discount'];
			$obj->retailprice=$shop[$i]['retailprice'];
			$obj->tradeprice=$shop[$i]['tradeprice'];
			$obj->tt=$obj->quantity*$obj->retailprice;
			
			$shppayments[$it]=array('transactionid'=>"10", 'transactionname'=>"Prescription",'itemid'=>"$obj->itemid", 'itemname'=>"$obj->itemname", 'amount'=>"$obj->tt", 'remarks'=>"$obj->memo", 'total'=>"$obj->tt",'tid'=>"",'payableid'=>"",'departmentid'=>3);
			$it++;
			
			if($salesDBO->persist($obj)){		
				//$this->id=$salesDBO->id;
				//$this->sql=$salesDBO->sql;
				
				//update item quantity
				$items = new Items();
				$fields="*";
				$where=" where id='$obj->itemid'";
				$join="";
				$having="";
				$groupby="";
				$orderby="";
				$items->retrieve($fields, $join, $where, $having, $groupby, $orderby);
				$items=$items->fetchObject;
				$items->quantity=$items->quantity-$obj->quantity;
				
				$obj->transaction="Sales";
				
				$it = new Items();
				//$it->setObject($items);
				$it->reduceStock($obj);
				
			}
			$i++;
		}
                
                
				//Make a journal entry
                $obj->paidon=$obj->soldon;
                $payments=new payments();
                $payments=$payments->setObject($obj);
                $payments->add($obj,$shppayments);
         	//retrieve account to debit
// 		$generaljournalaccounts = new Generaljournalaccounts();
// 		$fields="*";
// 		$where=" where refid='$obj->patientid' and acctypeid='29'";
// 		$join="";
// 		$having="";
// 		$groupby="";
// 		$orderby="";
// 		$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// 		$generaljournalaccounts=$generaljournalaccounts->fetchObject;
// 
// 				//retrieve account to credit
// 		$generaljournalaccounts2 = new Generaljournalaccounts();
// 		$fields="*";
// 		$where=" where refid='1' and acctypeid='25'";
// 		$join="";
// 		$having="";
// 		$groupby="";
// 		$orderby="";
// 		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// 		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;
// 
// 				//Get transaction Identity
// 		$transaction = new Transactions();
// 		$fields="*";
// 		$where=" where lower(replace(name,' ',''))='sales'";
// 		$join="";
// 		$having="";
// 		$groupby="";
// 		$orderby="";
// 		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// 		$transaction=$transaction->fetchObject;
// 
// 		$ob->transactdate=$obj->soldon;
// 		
// 		$it=0;
// 
// 				//make debit entry
// 		$generaljournal = new Generaljournals();
// 		$ob->tid=$sales->id;
// 		$ob->documentno="$obj->documentno";
// 		$ob->remarks="Sale of Invoice $obj->documentno";
// 		$ob->memo=$sales->remarks;
// 		$ob->accountid=$generaljournalaccounts->id;
// 		$ob->daccountid=$generaljournalaccounts2->id;
// 		$ob->transactionid=$transaction->id;
// 		$ob->mode="credit";
// 		$ob->debit=$obj->ttotal;
// 		$ob->credit=0;
// 		$generaljournal->setObject($ob);
// 		//$generaljournal->add($generaljournal);
// 		
// 		$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total");
// 		
// 		$it++;
// 
// 				//make credit entry
// 		$generaljournal2 = new Generaljournals();
// 		$ob->tid=$sales->id;
// 		$ob->documentno=$obj->documentno;
// 		$ob->remarks="Invoice $obj->documentno to $obj->patientname";
// 		$ob->memo=$sales->remarks;
// 		$ob->daccountid=$generaljournalaccounts->id;
// 		$ob->accountid=$generaljournalaccounts2->id;
// 		$ob->transactionid=$transaction->id;
// 		$ob->mode="credit";
// 		$ob->debit=0;
// 		$ob->credit=$obj->ttotal;
// 		$ob->did=$generaljournal->id;
// 		$generaljournal2->setObject($ob);
// 		//$generaljournal2->add($generaljournal2);
// 
// 		$shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total");
// 		
// 		$gn = new Generaljournals();
// 		$gn->add($obj, $shpgeneraljournals);
		
		//$generaljournal->did=$generaljournal2->id;
		//$generaljournal->edit($generaljournal);

		return true;	
	}			
	function edit($obj,$where="",$shop){
		$salesDBO = new SalesDBO();

		//first delete all records under old documentno
		$where=" where documentno='$obj->olddocumentno' and mode='$obj->oldmode'";
		$salesDBO->delete($obj,$where);

		$gn = new GeneralJournals();
		$where=" where documentno='$obj->olddocumentno' and transactionid='2' mode='$obj->oldmode' ";
		$gn->delete($obj,$where);

		$num=count($shop);
		$i=0;
		$total=0;
		while($i<$num){

			$total+=$obj->total;

			$obj->quantity=$shop['quantity'];
			$obj->itemid=$shop['itemid'];
			$obj->itemname=$shop['itemname'];
			$obj->code=$shop['code'];
			$obj->stock=$shop['stock'];
			$obj->tax=$shop['tax'];
			$obj->discount=$shop['discount'];
			$obj->retailprice=$shop['retailprice'];
			$obj->tradeprice=$shop['tradeprice'];
			if($salesDBO->update($obj,$where)){
				$this->sql=$salesDBO->sql;
			}
		}

				//Make a journal entry

				//retrieve account to debit
		$generaljournalaccounts = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='$obj->patientid' and acctypeid='29'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts=$generaljournalaccounts->fetchObject;

				//retrieve account to credit
		$generaljournalaccounts2 = new Generaljournalaccounts();
		$fields="*";
		$where=" where refid='1' and acctypeid='25'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;

				//Get transaction Identity
		$transaction = new Transactions();
		$fields="*";
		$where=" where lower(replace(name,' ',''))='sales'";
		$join="";
		$having="";
		$groupby="";
		$orderby="";
		$transaction->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		$transaction=$transaction->fetchObject;

		$ob->transactdate=$obj->soldon;

				//make debit entry
		$generaljournal = new Generaljournals();
		$ob->tid=$sales->id;
		$ob->documentno="$obj->documentno";
		$ob->remarks="Sale of Invoice $obj->documentno";
		$ob->memo=$sales->remarks;
		$ob->accountid=$generaljournalaccounts->id;
		$ob->daccountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=$total;
		$ob->credit=0;
		$generaljournal->setObject($ob);
		$generaljournal->add($generaljournal);

				//make credit entry
		$generaljournal2 = new Generaljournals();
		$ob->tid=$sales->id;
		$ob->documentno=$obj->documentno;
		$ob->remarks="Invoice $obj->documentno to $obj->patientname";
		$ob->memo=$sales->remarks;
		$ob->daccountid=$generaljournalaccounts->id;
		$ob->accountid=$generaljournalaccounts2->id;
		$ob->transactionid=$transaction->id;
		$ob->mode="credit";
		$ob->debit=0;
		$ob->credit=$total;
		$ob->did=$generaljournal->id;
		$generaljournal2->setObject($ob);
		$generaljournal2->add($generaljournal2);

		$generaljournal->did=$generaljournal2->id;
		$generaljournal->edit($generaljournal);

		return true;	
	}			
	function delete($obj,$where=""){			
		$salesDBO = new SalesDBO();
		if($salesDBO->delete($obj,$where=""))		
			$this->sql=$salesDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$salesDBO = new SalesDBO();
		$this->table=$salesDBO->table;
		$salesDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$salesDBO->sql;
		$this->result=$salesDBO->result;
		$this->fetchObject=$salesDBO->fetchObject;
		$this->affectedRows=$salesDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->itemid)){
			$error="Item should be provided";
		}
		else if(empty($obj->documentno)){
			$error="Document No should be provided";
		}
		else if(empty($obj->patientid)){
			$error="Patient should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
		if(empty($obj->documentno)){
			$error="Document No should be provided";
		}
		else if(empty($obj->patientid) and $obj->mode!='cashretail'){
			$error="Patient should be provided";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
}				
?>
