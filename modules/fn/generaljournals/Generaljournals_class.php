<?php 
require_once("GeneraljournalsDBO.php");
class Generaljournals
{				
	var $id;
	var $companyid;
	var $accountid;			
	var $daccountid;			
	var $tid;			
	var $documentno;			
	var $mode;			
	var $transactionid;			
	var $remarks;			
	var $memo;			
	var $transactdate;
	var $currencyid;
	var $exchangerate;
	var $exchangerate2;
	var $debit;	
	var $categoryid;
	var $credit;
	var $debiteuro;			
	var $crediteuro;
	var $debitorig;			
	var $creditorig;
	var $rate;
	var $eurorate;
	var $drtotals;
	var $crtotals;
	var $jvno;			
	var $chequeno;			
	var $did;			
	var $reconstatus;
	var $balance;
	var $recondate;			
	var $class;			
	var $ipaddress;			
	var $createdby;			
	var $createdon;			
	var $lasteditedby;			
	var $lasteditedon;			
	var $generaljournalsDBO;
	var $fetchObject;
	var $sql;
	var $result;
	var $table;
	var $affectedRows;

	function setObject($obj){
		$this->id=str_replace("'","\'",$obj->id);
		$this->companyid=$_SESSION['companyid'];
		if(empty($obj->accountid))
			$obj->accountid='NULL';
		$this->accountid=$obj->accountid;
		$this->daccountid=str_replace("'","\'",$obj->daccountid);
		$this->tid=str_replace("'","\'",$obj->tid);
		$this->documentno=str_replace("'","\'",$obj->documentno);
		$this->mode=str_replace("'","\'",$obj->mode);
		$this->transactionid=str_replace("'","\'",$obj->transactionid);
		$this->currencyid=str_replace("'","\'",$obj->currencyid);
		$this->exchangerate=str_replace("'","\'",$obj->exchangerate);
		$this->exchangerate2=str_replace("'","\'",$obj->exchangerate2);
		$this->remarks=str_replace("'","\'",$obj->remarks);
		$this->memo=str_replace("'","\'",$obj->memo);
		$this->transactdate=str_replace("'","\'",$obj->transactdate);
		$this->debit=str_replace("'","\'",$obj->debit);
		$this->categoryid=str_replace("'","\'",$obj->categoryid);
		$this->credit=str_replace("'","\'",$obj->credit);		
		$this->debitorig=str_replace("'","\'",$obj->debitorig);
		$this->creditorig=str_replace("'","\'",$obj->creditorig);
		$this->debiteuro=str_replace("'","\'",$obj->debiteuro);
		$this->crediteuro=str_replace("'","\'",$obj->crediteuro);
		$this->crtotals=str_replace(",","",$obj->crtotals);
		$this->drtotals=str_replace(",","",$obj->drtotals);
		$this->rate=str_replace("'","\'",$obj->rate);
		$this->eurorate=str_replace("'","\'",$obj->eurorate);
		$this->jvno=str_replace("'","\'",$obj->jvno);
		$this->chequeno=str_replace("'","\'",$obj->chequeno);
		$this->did=str_replace("'","\'",$obj->did);
		$this->reconstatus=str_replace("'","\'",$obj->reconstatus);
		$this->balance=str_replace("'","\'",$obj->balance);
		$this->recondate=str_replace("'","\'",$obj->recondate);
		$this->class=str_replace("'","\'",$obj->class);
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

	//get accountid
	function getAccountid(){
		return $this->accountid;
	}
	//set accountid
	function setAccountid($accountid){
		$this->accountid=$accountid;
	}

	//get daccountid
	function getDaccountid(){
		return $this->daccountid;
	}
	//set daccountid
	function setDaccountid($daccountid){
		$this->daccountid=$daccountid;
	}

	//get tid
	function getTid(){
		return $this->tid;
	}
	//set tid
	function setTid($tid){
		$this->tid=$tid;
	}

	//get documentno
	function getDocumentno(){
		return $this->documentno;
	}
	//set documentno
	function setDocumentno($documentno){
		$this->documentno=$documentno;
	}

	//get mode
	function getMode(){
		return $this->mode;
	}
	//set mode
	function setMode($mode){
		$this->mode=$mode;
	}

	//get transactionid
	function getTransactionid(){
		return $this->transactionid;
	}
	//set transactionid
	function setTransactionid($transactionid){
		$this->transactionid=$transactionid;
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

	//get transactdate
	function getTransactdate(){
		return $this->transactdate;
	}
	//set transactdate
	function setTransactdate($transactdate){
		$this->transactdate=$transactdate;
	}

	//get debit
	function getDebit(){
		return $this->debit;
	}
	//set debit
	function setDebit($debit){
		$this->debit=$debit;
	}

	//get credit
	function getCredit(){
		return $this->credit;
	}
	//set credit
	function setCredit($credit){
		$this->credit=$credit;
	}

	//get jvno
	function getJvno(){
		return $this->jvno;
	}
	//set jvno
	function setJvno($jvno){
		$this->jvno=$jvno;
	}

	//get chequeno
	function getChequeno(){
		return $this->chequeno;
	}
	//set chequeno
	function setChequeno($chequeno){
		$this->chequeno=$chequeno;
	}

	//get did
	function getDid(){
		return $this->did;
	}
	//set did
	function setDid($did){
		$this->did=$did;
	}

	//get reconstatus
	function getReconstatus(){
		return $this->reconstatus;
	}
	//set reconstatus
	function setReconstatus($reconstatus){
		$this->reconstatus=$reconstatus;
	}

	//get recondate
	function getRecondate(){
		return $this->recondate;
	}
	//set recondate
	function setRecondate($recondate){
		$this->recondate=$recondate;
	}

	//get class
	function getClass(){
		return $this->class;
	}
	//set class
	function setClass($class){
		$this->class=$class;
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
	
	function searchArray($shp, $shop){
	  //check if accountid aexists with corresponding debit or credit
	  $i=0;
	  while($i<count($shp)){
	    if($shp[$i]['accountid']==$shop['accountid']){
	      //found
	      return $i;
	    }
	    $i++;
	  }
	  return -1;
	}

	function add($obj,$shop, $bool=true,$consolidate=false, $bl=false){print_r($shop);
		
// 		if($obj->transactdate<=$_SESSION['startdate']){
// 		  showError("Incorrect Period!");
// 		  return false;
// 		}
		
		$this->companyid=$_SESSION['companyid'];
		
		if($obj->transactdate>$_SESSION['enddate']){
		  showError("Transaction beyond current Period!");
		}
		
		$generaljournalsDBO = new GeneraljournalsDBO();
		
		if(!$consolidate){
		  $shp = array();
		  //consolidate the array
		  $x=0;
		  $k=0;
		  while($x<count($shop)){
		    if(($key = $this->searchArray($shp,$shop[$x]))<0){
		      //if not found, add new record
		      $shp[$k]=$shop[$x];
		      $k++;
		    }else{
		      $shp[$key]['debit']+=$shop[$x]['debit'];
		      $shp[$key]['credit']+=$shop[$x]['credit'];
		      if(!empty($shop[$x]['memo']))
			$shp[$key]['memo'].=", ".$shop[$x]['memo'];
		    }
		    $x++;
		  }
		  
		  $shop = $shp;
		}
		
		$num=count($shop);
		$i=0;
		$total=0;
		
		//get jvno
		if(empty($obj->jvno) or $bl==true){
		  $generaljournals = new Generaljournals();
		  $fields="case when max(jvno+1) is null then 1 else max(jvno+1) end jvno";
		  $join="";
		  $where="";
		  $having="";
		  $orderby="";
		  $groupby="";
		  $generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $generaljournals=$generaljournals->fetchObject;
		  $obj->jvno=$generaljournals->jvno;
		}
		
		$obj->createdby=$_SESSION['userid'];
		$obj->createdon=date("Y-m-d H:i:s");
		$obj->lasteditedby=$_SESSION['userid'];
		$obj->lasteditedon=date("Y-m-d H:i:s");
		$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
		if($bool){
		  $obj->currencyid=$obj->currencyid;
		  $obj->rate=$obj->exchangerate;
		  $obj->eurorate=$obj->exchangerate2;
		}
	
		while($i<$num){
			$obj->id=$shop[$i]['id'];
			$obj->accountid=$shop[$i]['accountid'];
			$obj->accountname=$shop[$i]['accountname'];
			$obj->memo=$shop[$i]['memo'];
			$obj->debit=$shop[$i]['debit'];
			$obj->credit=$shop[$i]['credit'];
			$obj->debiteuro=$shop[$i]['debiteuro'];
			$obj->crediteuro=$shop[$i]['crediteuro'];
			$obj->debitorig=$shop[$i]['debitorig'];
			$obj->creditorig=$shop[$i]['creditorig'];
			if(!$bool){
			  $obj->currencyid=$shop[$i]['currencyid'];
			  $obj->rate=$shop[$i]['rate'];
			  $obj->eurorate=$shop[$i]['eurorate'];
			  //$obj->transactdate=$shop[$i]['transactdate'];
			}
			
			$obj->currencyid=5;
			$obj->rate=1;
			
			$obj->memo=$shop[$i]['memo'];
			$obj->remarks=$shop[$i]['remarks'];
// 			$obj->jvno=$shop[$i]['jvno'];
			$obj->transactionid=$shop[$i]['transactionid'];
			$obj->class=$shop[$i]['class'];
			$obj->documentno=$shop[$i]['documentno'];
			$obj->mode=$shop[$i]['mode'];
			$obj->balance=$shop[$i]['balance'];
			if($obj->debit!=0 or $obj->credit!=0){
			  if($generaljournalsDBO->persist($obj)){		
				  //$this->id=$generaljournalsDBO->id;
// 				  $this->sql=$generaljournalsDBO->sql;
			  }
			}
			$i++;
		}
		return true;	
	}			
	function edit($obj,$where="",$shop, $bl=true, $consolidate=false){		
		if($obj->transactdate<=$_SESSION['startdate']){
		  showError("Incorrect Period!");
		  return false;
		}
		
		
		//select jvno
		
		$generaljournalsDBO = new GeneraljournalsDBO();
		$num=count($shop);
		$i=0;
		$total=0;
		
		if(!$consolidate){
		  $shp = array();
		  //consolidate the array
		  $x=0;
		  $k=0;
		  while($x<count($shop)){
		    if(($key = $this->searchArray($shp,$shop[$x]))<0){
		      //if not found, add new record
		      $shp[$k]=$shop[$x];
		      $k++;
		    }else{
		      $shp[$key]['debit']+=$shop[$x]['debit'];
		      $shp[$key]['credit']+=$shop[$x]['credit'];
		      if(!empty($shop[$x]['memo']))
			$shp[$key]['memo'].=", ".$shop[$x]['memo'];
		    }
		    $x++;
		  }
		  
		  $shop = $shp;
		}
			
		if(empty($obj->jvno)){
		  $generaljournals = new Generaljournals();
		  $fields="case when max(jvno+1) is null then 1 else max(jvno+1) end jvno";
		  $join="";
		  $where="";
		  $having="";
		  $orderby="";
		  $groupby="";
		  $generaljournals->retrieve($fields, $join, $where, $having, $groupby, $orderby);
		  $generaljournals=$generaljournals->fetchObject;
		  $obj->jvno=$generaljournals->jvno;
		}
		
		$obj->createdby=$_SESSION['userid'];
		$obj->createdon=date("Y-m-d H:i:s");
		$obj->lasteditedby=$_SESSION['userid'];
		$obj->lasteditedon=date("Y-m-d H:i:s");
		if($bl){
		  $obj->currencyid=$obj->currencyid;
		  $obj->rate=$obj->exchangerate;
		  $obj->eurorate=$obj->exchangerate2;
		}
	        $acc="0";
	        $remarks="";
		while($i<$num){
		        $obj->id=$shop[$i]['id'];
			$obj->accountid=$shop[$i]['accountid'];
			$obj->accountname=$shop[$i]['accountname'];
			$obj->memo=$shop[$i]['memo'];
			$obj->debit=$shop[$i]['debit'];
			$obj->credit=$shop[$i]['credit'];
			$obj->debiteuro=$shop[$i]['debiteuro'];
			$obj->crediteuro=$shop[$i]['crediteuro'];
			$obj->debitorig=$shop[$i]['debitorig'];
			$obj->creditorig=$shop[$i]['creditorig'];
			if(!$bl){
			  $obj->currencyid=$shop[$i]['currencyid'];
			  $obj->rate=$shop[$i]['rate'];
			  $obj->eurorate=$shop[$i]['eurorate'];
			}
			$obj->memo=$shop[$i]['memo'];
			$obj->remarks=$shop[$i]['remarks'];
// 			$obj->jvno=$shop[$i]['jvno'];
// 			$obj->transactdate=$shop[$i]['transactdate'];
			$obj->transactionid=$shop[$i]['transactionid'];
			$obj->class=$shop[$i]['class'];
			$obj->documentno=$shop[$i]['documentno'];
			$obj->mode=$shop[$i]['mode'];
			$obj->balance=$shop[$i]['balance'];
			$obj->reconstatus=$shop[$i]['reconstatus'];
			$obj->recondate=$shop[$i]['recondate'];
			$obj->recontime=$shop[$i]['recontime'];
			$remarks.="'".$obj->remarks."',";
			
			if($obj->debit!=0 or $obj->credit!=0){
		        $generaljournal=new GeneralJournals();
		        $fields="*";
			$join="";
			$having="";
			$groupby="";
			$orderby=" limit 1 ";
			if($obj->transactionid==12)
			  $where=" where accountid='$obj->accountid' and id not in ($acc) and documentno='$obj->documentno' and transactionid='$obj->transactionid' and remarks='$obj->remarks' ";
			elseif(empty($obj->documentno))
			  $where=" where accountid='$obj->accountid' and id not in ($acc) and jvno='$obj->jvno'";
			else
			  $where=" where accountid='$obj->accountid' and id not in ($acc) and documentno='$obj->documentno' and transactionid='$obj->transactionid' ";
			$generaljournal->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			
// 			echo $generaljournal->sql."<br/>";
			
			if($generaljournal->affectedRows>0)
			{     
			      $generaljournal=$generaljournal->fetchObject;
			
			      $obj->jvno=$generaljournal->jvno;
			      $where=" id='$generaljournal->id' ";
			      $generaljournalsDBO=new GeneraljournalsDBO();			      
			      $generaljournalsDBO->update($obj,$where);
			      $acc.=",".$generaljournal->id;
			}
			else{  
			      $generaljournalsDBO=new GeneraljournalsDBO();
			      $generaljournalsDBO->persist($obj);
			      //$this->id=$generaljournalsDBO->id;
			      $this->sql=$generaljournalsDBO->sql;
			      $acc.=",".$generaljournalsDBO->id;
			}
		}
			$i++;
		      }
		 $wid=substr($remarks,0,-1);
		 if(empty($obj->documentno))
		 {
		 $where=" where jvno='$obj->jvno' and id not in ($acc)  ";
		 }
		 else
		 {
		 $where=" where id not in ($acc) and documentno='$obj->documentno' and transactionid='$obj->transactionid'  ";
		 }
		 $generaljournalsDBO->delete($obj,$where);
		return true;	
	}			
	function delete($obj,$where){			
		$generaljournalsDBO = new GeneraljournalsDBO();
		if($generaljournalsDBO->delete($obj,$where))		
			$this->sql=$generaljournalsDBO->sql;
			return true;	
	}			
	function retrieve($fields,$join,$where,$having,$groupby,$orderby){			
		$generaljournalsDBO = new GeneraljournalsDBO();
		$this->table=$generaljournalsDBO->table;
		$generaljournalsDBO->retrieve($fields,$join,$where,$having,$groupby,$orderby);		
		$this->sql=$generaljournalsDBO->sql;
		$this->result=$generaljournalsDBO->result;
		$this->fetchObject=$generaljournalsDBO->fetchObject;
		$this->affectedRows=$generaljournalsDBO->affectedRows;
	}			
	function validate($obj){
		if(empty($obj->jvno)){
			$error="JV No. should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}elseif($obj->crtotals!=$obj->drtotals and $obj->jvno!=253 and $obj->jvno!=79620){
			$error="Check that the debit and credit totals tally";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}

	function validates($obj){
	       if(empty($obj->jvno)){
			$error="JV No. should be provided";
		}else if(empty($obj->currencyid)){
			$error="Currency should be provided";
		}elseif($obj->crtotals!=$obj->drtotals and $obj->jvno!=253 and $obj->jvno!=79620){
			$error="Check that the debit and credit totals tally";
		}
	
		if(!empty($error))
			return $error;
		else
			return null;
	
	}
	function retrieveBalances($obj,$acctypeid,$type)
	{
	        $rwhere=" fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
		$generaljournals = new Generaljournals();
		if($obj->currencyid==5)
		  $fields=" sum(fn_generaljournals.debit*rate) as debit,sum(fn_generaljournals.credit*rate) as credit, fn_generaljournalaccounts.name accname ";
		elseif($obj->currencyid==1)
		  $fields=" sum(fn_generaljournals.debit*eurorate) as debit,sum(fn_generaljournals.credit*eurorate) as credit, fn_generaljournalaccounts.name accname ";
		else
		  $fields=" sum(fn_generaljournals.debit) as debit,sum(fn_generaljournals.credit) as credit, fn_generaljournalaccounts.name accname ";
		if($type=="opening")
		  $where=" where fn_generaljournals.transactdate<='$obj->fromdate' and fn_generaljournalaccounts.acctypeid='$acctypeid' and $rwhere ";
		elseif($type=="closing")
		  $where=" where fn_generaljournals.transactdate<='$obj->todate' and fn_generaljournalaccounts.acctypeid='$acctypeid' and $rwhere ";
		else
		  $where=" where fn_generaljournals.transactdate>='$obj->fromdate' and fn_generaljournals.transactdate<='$obj->todate' and fn_generaljournalaccounts.acctypeid='$acctypeid' and $rwhere ";
		  
		$join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid ";
		$having="";
		$groupby="";
		$orderby="";
		$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);/*if($acctypeid==25){echo $generaljournals->sql;}*/
		return $generaljournals->fetchObject;
	}
	
	function retrieveBalance($obj,$acctypeid,$type)
	{
	        $rwhere=" fn_generaljournals.transactdate>='2015-07-01' and fn_generaljournals.transactdate!='0000-00-00' ";
		$generaljournals = new Generaljournals();
		if($obj->currencyid==5)
		  $fields=" sum(fn_generaljournals.debit*rate) as debit,sum(fn_generaljournals.credit*rate) as credit, fn_generaljournalaccounts.name accname, fn_generaljournalaccounts.categoryid ";
		elseif($obj->currencyid==1)
		   $fields=" sum(fn_generaljournals.debit*eurorate) as debit,sum(fn_generaljournals.credit*eurorate) as credit, fn_generaljournalaccounts.name accname, fn_generaljournalaccounts.categoryid ";
		else
		   $fields=" sum(fn_generaljournals.debit) as debit,sum(fn_generaljournals.credit) as credit, fn_generaljournalaccounts.name accname, fn_generaljournalaccounts.categoryid ";
		if($type=="opening")
		  $where=" where fn_generaljournals.transactdate<='$obj->fromdate' and fn_generaljournalaccounts.acctypeid='$acctypeid' and $rwhere ";
		elseif($type=="closing")
		  $where=" where fn_generaljournals.transactdate<='$obj->todate' and fn_generaljournalaccounts.acctypeid='$acctypeid' and $rwhere ";
		else
		  $where=" where fn_generaljournals.transactdate>='$obj->fromdate' and fn_generaljournals.transactdate<='$obj->todate' and fn_generaljournalaccounts.acctypeid='$acctypeid' and $rwhere ";
		 
		if($acctypeid==25 and !empty($obj->departmentid)){
		  $query="select * from pos_saletypes where departmentid='$obj->departmentid'";
		  $r = mysql_fetch_object(mysql_query($query));
		  
		  $where.=" and fn_generaljournalaccounts.refid='$r->id' ";
		}
		
		elseif(!empty($obj->departmentid)){
					  
		  $where.=" and fn_generaljournalaccounts.refid='$obj->departmentid' ";
		  
		}
		
		$join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid ";
		$having="";
		$groupby=" group by fn_generaljournalaccounts.id ";
		$orderby="";
		$generaljournals->retrieve($fields,$join,$where,$having,$groupby,$orderby);//if($acctypeid==34){echo $generaljournals->sql."<br/>";}
		
		return $generaljournals->result;
	}
	
	function getAccountTB($accounttype, $obj, $in="", $notin="",$show=false){
	//get sub account types
	
	    $subaccountypes = new Subaccountypes();
	    $fields="*";
	    $where=" where fn_subaccountypes.accounttypeid='$accounttype'";
	    $join="";
	    $having="";
	    $groupby="";
	    $orderby="";
	    $subaccountypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	    $tdrsubaccountypes=0;
	    $tcrsubaccountypes=0;
	    $tttotal=0;
	    while($subaccountypess = mysql_fetch_object($subaccountypes->result)){$in="";
		//get account types
		    $acctypes = new Acctypes();
		    $fields="*";
		    $where=" where sys_acctypes.subaccountypeid='$subaccountypess->id'";
		    if(!empty($in))
		      $where.=" and sys_acctypes.id in($in)";
		    if(!empty($notin))
		      $where.=" and sys_acctypes.id not in($notin)";
		    $join="";
		    $having="";
		    $groupby="";
		    $orderby=" order by priority, id ";
		    $acctypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		    if($acctypes->affectedRows>0 and $show==true){
		  ?>
		  <tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td><?php echo strtoupper($subaccountypess->name); ?></td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			  <td align="right">&nbsp;</td>
		  </tr>
		    <?php
		    }
		    $ttotal=0;
		    while($acctypess = mysql_fetch_object($acctypes->result)){$ttotal=0;
			$generaljournalaccounts=new Generaljournalaccounts ();
			$fields=" fn_generaljournalaccounts.id, fn_generaljournalaccounts.name, sys_acctypes.name acctypeid, sys_acctypes.balance, case when fn_generaljournalaccounts.acctypeid=5 then (select priority from fn_expensetypes where id=fn_generaljournalaccounts.refid) else '' end priority ";
			$where=" where fn_generaljournalaccounts.acctypeid='$acctypess->id' ";
    // 		    if($obj->grp){
			  if(empty($where))
			    $where.=" where ";
			  else
			    $where.=" and ";
			  $where.=" (fn_generaljournalaccounts.categoryid is null or fn_generaljournalaccounts.categoryid=0) ";
    // 		    }
			
			$groupby="  ";
			$having="";
			$orderby=" order by priority asc ";
			$join=" left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid  ";
			$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);//if($in=="26")echo $generaljournalaccounts->sql."<br/>";
			$res=$generaljournalaccounts->result;
			if($generaljournalaccounts->affectedRows>0 and $show==true){//if($acctypess->id==26)echo $generaljournalaccounts->sql;
			?>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><?php echo $acctypess->name; ?></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td>
			</tr>
			<?php
			}
			$tdebit=0;
			$tcredit=0;	    
			
			$tdracctypes=0;
			$tcracctypes=0;
			
			while($row=mysql_fetch_object($res)){
			$total=0;
			$rptwhere=" and transactdate>='$obj->fromdate' and transactdate<='$obj->todate' ";
			
			$query="select case when sum(debit*rate) is null then 0 else sum(debit*rate) end debit from fn_generaljournals where accountid in($row->id) $rptwhere";
			$db=mysql_fetch_object(mysql_query($query));
			
			$query="select case when sum(credit*rate) is null then 0 else sum(credit*rate) end credit from fn_generaljournals where accountid in($row->id) $rptwhere";
			$dbs=mysql_fetch_object(mysql_query($query));
			if (strtolower($row->balance)=='dr'){
				$debit=$db->debit-$dbs->credit;
				$credit=0;
			}
			else{
				$credit=$dbs->credit-$db->debit;
				$debit=0;
			}
			
			$mtotal=($debit+$credit);
			$ttotal+=($debit+$credit);
			$tttotal+=($debit+$credit);
			
// 			$gn = new Generaljournals();
			
			$in = $this->getCategoryAccounts("",$row->id);
			
			if(!empty($in) and $in!=''){
			  $in.=",".$row->id;
			}
			else{
			  $in=$row->id;
			}
			
			$generaljournal = new Generaljournals();
			$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.name, sys_acctypes.name acctypeid, sys_acctypes.balance, case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end debit, case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end credit";
			$where=" where fn_generaljournalaccounts.categoryid in($in) ".$rptwhere;
			$join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid  ";
			$having="";
			$groupby="";
			$orderby="  ";
			$generaljournal->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$generaljournal = $generaljournal->fetchObject;
			if(($generaljournal->debit<>0 or $generaljournal->credit<>0 or $mtotal<>0) and $show==true){
			?>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><?php if($mtotal<>0){ ?><a href="account.php?id=<?php echo $row->id; ?>&class=<?php echo $obj->class; ?>" target="_blank"><?php echo initialCap($row->name); ?></a><?php }else{ ?> <?php echo initialCap($row->name); } ?></td>
				<?php
				if (strtolower($row->balance)=='dr'){
				?>
				<td align="right"><?php if($mtotal<>0)echo formatNumber($mtotal); ?></td>
				<td>&nbsp;</td>
				<?php }else{ ?>
				<td>&nbsp;</td>
				<td align="right"><?php if($mtotal<>0)echo formatNumber($mtotal); ?></td>
				<?php
				}
				?>
			</tr>
			<?php
			}
			//get accounts that belong to the categoryid
			$generaljournal = new Generaljournals();
			$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.name, sys_acctypes.name acctypeid, sys_acctypes.balance, case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end debit, case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end credit, gna.name categoryid ";
			$where=" where fn_generaljournalaccounts.categoryid in($in) ".$rptwhere;
			$join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid left join fn_generaljournalaccounts gna on gna.id=fn_generaljournalaccounts.categoryid   ";
			$having="";
			$groupby=" group by fn_generaljournalaccounts.categoryid ";
			$orderby="";
			$generaljournal->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$xtotal=0;
			while($wr=mysql_fetch_object($generaljournal->result)){
			
			$total=0;
			
			  if(strtolower($wr->balance)=="dr")
			    $total=($wr->debit-$wr->credit);
			  else
			    $total=($wr->credit-$wr->debit);
			    
			  $xtotal+=$total;
			  $ttotal+=$total;
			  $tttotal+=$total;
			  
			  if($total<>0 and $show==true){
			  ?>
				  <tr>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;&nbsp;&nbsp;<a href="account.php?id=<?php echo $wr->id; ?>&class=<?php echo $obj->class; ?>" target="_blank">XX<?php echo $wr->categoryid; ?></a></td>
					  <?php
					  if (strtolower($row->balance)=='dr'){
					  ?>
					  <td align="right"><?php echo formatNumber($total); ?></td>
					  <td>&nbsp;</td>
					  <?php }else{?>
					  <td>&nbsp;</td>
					  <td align="right"><?php echo formatNumber($total); ?></td>
					  <?php } ?>
				  </tr>
			  <?php 
			  }
			}   
			if($xtotal!=0 and $show==true){
		?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><?php echo $wr->id; ?>Total <?php echo $row->name; ?></td>
			<?php
			if (strtolower($row->balance)=='dr'){
			?>
			<td align="right" style="text-decoration: overline;"><?php echo formatNumber($xtotal); ?></td>
			<td>&nbsp;</td>
			<?php }else{ ?>
			<td>&nbsp;</td>
			<td align="right" style="text-decoration: overline;"><?php echo formatNumber($xtotal); ?></td>
			<?php } ?>
		</tr>
	    <?
	    }
		}
		if($ttotal!=0 and $show==true){
		?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>Total <?php echo $acctypess->name; ?></td>
			<td>&nbsp;</td>
			<?php
			if (strtolower($acctypess->balance)=='dr'){
			?>
			<td align="right" style="text-decoration: overline;"><?php echo formatNumber($ttotal); ?></td>
			<td>&nbsp;</td>
			<?php }else{ ?>
			<td>&nbsp;</td>
			<td align="right" style="text-decoration: overline;"><?php echo formatNumber($ttotal); ?></td>
			<?php } ?>
		</tr>
	    <?
	    }
	    $tdrsubaccountypes+=$tdracctypes;
	    $tcrsubaccountypes+=$tcracctypes;
	    }
	    $tdraccounttypes+=$tdrsubaccountypes;
	    $tcraccounttypes+=$tcrsubaccountypes;
      }
      return $tttotal;
    }
	
	function getAccountInc($accounttype, $obj, $in="", $notin="",$show=false){
	//get sub account types
		
	    $subaccountypes = new Subaccountypes();
	    $fields="*";
	    $where=" where fn_subaccountypes.accounttypeid='$accounttype'";
	    $join="";
	    $having="";
	    $groupby="";
	    $orderby="";
	    $subaccountypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	    $tdrsubaccountypes=0;
	    $tcrsubaccountypes=0;
	    $tttotal=0;
	    while($subaccountypess = mysql_fetch_object($subaccountypes->result)){
		//get account types
		    $acctypes = new Acctypes();
		    $fields="*";
		    $where=" where sys_acctypes.subaccountypeid='$subaccountypess->id'";
		    if(!empty($in))
		      $where.=" and sys_acctypes.id in($in)";
		    if(!empty($notin))
		      $where.=" and sys_acctypes.id not in($notin)";
		    $join="";
		    $having="";
		    $groupby="";
		    $orderby="";
		    $acctypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		    if($acctypes->affectedRows>0 and $show==true){
		?>
		
		    <?php
		    }
		    $ttotal=0;
		    $x=0;
		    while($acctypess = mysql_fetch_object($acctypes->result)){$ttotal=0;
			$wh="";
			if($acctypess->id==25 and !empty($obj->departmentid)){
			  $query="select * from pos_saletypes where departmentid='$obj->departmentid'";
			  $r = mysql_fetch_object(mysql_query($query));
			  
			  $wh=" and fn_generaljournalaccounts.refid='$r->id' ";
			}
			
			if($acctypess->id==4 and !empty($obj->departmentid)){
			  			  
			  $wh=" and fn_generaljournalaccounts.refid='$obj->departmentid' ";
			  
			}
			
			$generaljournalaccounts=new Generaljournalaccounts ();
			$fields=" fn_generaljournalaccounts.id, fn_generaljournalaccounts.name, sys_acctypes.name acctypeid, sys_acctypes.balance, case when fn_generaljournalaccounts.acctypeid=5 then (select priority from fn_expensetypes where id=fn_generaljournalaccounts.refid) else '' end priority ";
			$where=" where fn_generaljournalaccounts.acctypeid='$acctypess->id' ";
    // 		    if($obj->grp){
			  if(empty($where))
			    $where.=" where ";
			  else
			    $where.=" and ";
			  $where.=" (fn_generaljournalaccounts.categoryid is null or fn_generaljournalaccounts.categoryid=0) ";
    // 		    }
			$where.=$wh;
			$groupby="  ";
			$having="";
			$orderby=" order by priority asc ";
			$join=" left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid  ";
			$generaljournalaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);//if($in=="26")echo $generaljournalaccounts->sql."<br/>";
// 			if($acctypess->id==25 or $acctypess->id==4){
// 			  echo $generaljournalaccounts->sql."<br/>";
// 			}
			$res=$generaljournalaccounts->result;
			
			if($x==0){
			?>
			<tr>
				<td>&nbsp;</td>
				<td><?php echo strtoupper($subaccountypess->name); ?></td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td>
			</tr>
			<?
			}
			
			$x++;
			
			if($generaljournalaccounts->affectedRows>0 and $show==true){//if($acctypess->id==26)echo $generaljournalaccounts->sql;
			?>
			<tr>
				<td>&nbsp;</td>
				<td><?php echo initialCap($acctypess->name); ?></td>
				<td>&nbsp;</td>
				<td align="right">&nbsp;</td>
			</tr>
			<?php
			}
			$tdebit=0;
			$tcredit=0;	    
			
			$tdracctypes=0;
			$tcracctypes=0;
			
			while($row=mysql_fetch_object($res)){
			$total=0;
			$rptwhere=" and transactdate>='$obj->fromdate' and transactdate<='$obj->todate' and reconstatus!='cancelled' ";
			
			$query="select case when sum(debit*rate) is null then 0 else sum(debit*rate) end debit from fn_generaljournals where accountid in($row->id) $rptwhere";
			$db=mysql_fetch_object(mysql_query($query));
			
			$query="select case when sum(credit*rate) is null then 0 else sum(credit*rate) end credit from fn_generaljournals where accountid in($row->id) $rptwhere";
			$dbs=mysql_fetch_object(mysql_query($query));
			if (strtolower($row->balance)=='dr'){
				$debit=$db->debit-$dbs->credit;
				$credit=0;
			}
			else{
				$credit=$dbs->credit-$db->debit;
				$debit=0;
			}
			
			$mtotal=($debit+$credit);
			$ttotal+=($debit+$credit);
			$tttotal+=($debit+$credit);
			
// 			$gn = new Generaljournals();
			
			$in = $this->getCategoryAccounts("",$row->id);
			
			if(!empty($in) and $in!=''){
			  $in.=",".$row->id;
			}
			else{
			  $in=$row->id;
			}
			
			$generaljournal = new Generaljournals();
			$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.name, sys_acctypes.name acctypeid, sys_acctypes.balance, case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end debit, case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end credit";
			$where=" where fn_generaljournalaccounts.categoryid in($in) ".$rptwhere;
			$join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid  ";
			$having="";
			$groupby="";
			$orderby="  ";
			$generaljournal->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$generaljournal = $generaljournal->fetchObject;
			if(($generaljournal->debit<>0 or $generaljournal->credit<>0 or $mtotal<>0) and $show==true){
			?>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><?php if($mtotal<>0){ ?><a href="account.php?id=<?php echo $row->id; ?>&tb=true&class=<?php echo $obj->class; ?>" target="_blank"><?php echo initialCap($row->name); ?></a><?php }else{ ?> <?php echo initialCap($row->name); } ?></td>					
				<td align="right"><?php if($mtotal<>0)echo formatNumber($mtotal); ?></td>
			</tr>
			<?php
			}
			//get accounts that belong to the categoryid
			$generaljournal = new Generaljournals();
			$fields="fn_generaljournalaccounts.id, fn_generaljournalaccounts.name, sys_acctypes.name acctypeid, sys_acctypes.balance, case when sum(fn_generaljournals.debit*rate) is null then 0 else sum(fn_generaljournals.debit*rate) end debit, case when sum(fn_generaljournals.credit*rate) is null then 0 else sum(fn_generaljournals.credit*rate) end credit, gna.name categoryid, gna.id category ";
			$where=" where fn_generaljournalaccounts.categoryid in($in) ".$rptwhere;
			$join=" left join fn_generaljournalaccounts on fn_generaljournalaccounts.id=fn_generaljournals.accountid left join sys_acctypes on sys_acctypes.id=fn_generaljournalaccounts.acctypeid left join fn_generaljournalaccounts gna on gna.id=fn_generaljournalaccounts.categoryid   ";
			$having="";
			$groupby=" group by fn_generaljournalaccounts.id ";
			$orderby="";
			$generaljournal->retrieve($fields,$join,$where,$having,$groupby,$orderby);
			$xtotal=0;
			while($wr=mysql_fetch_object($generaljournal->result)){
			
			$total=0;
			
			  if(strtolower($wr->balance)=="dr")
			    $total=($wr->debit-$wr->credit);
			  else
			    $total=($wr->credit-$wr->debit);
			    
			  $xtotal+=$total;
			  $ttotal+=$total;
			  $tttotal+=$total;
			  
			  if($total<>0 and $show==true){
			  ?>
				  <tr>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;&nbsp;&nbsp;<a href="account.php?categoryid=<?php echo $wr->category; ?>&tb=true&class=<?php echo $obj->class; ?>" target="_blank"><?php echo $wr->name; ?></a></td>			
					  <td align="right"><?php echo formatNumber($total); ?></td>
				  </tr>
			  <?php 
			  }
			}   
			if($xtotal!=0 and $show==true){
		?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><?php echo $wr->id; ?>Total <?php echo $row->name; ?></td>
			<td align="right" style="text-decoration: overline;"><?php echo formatNumber($xtotal); ?></td>
		</tr>
	    <?
	    }
		}
		if($ttotal!=0 and $show==true){
		?>
		<tr>
			<td>&nbsp;</td>
			<td>Total <?php echo initialCap($acctypess->name); ?></td>
			<td>&nbsp;</td>
			<td align="right" style="text-decoration: overline;"><?php echo formatNumber($ttotal); ?></td>
		</tr>
	    <?
	    }
	    $tdrsubaccountypes+=$tdracctypes;
	    $tcrsubaccountypes+=$tcracctypes;
	    }
	    $tdraccounttypes+=$tdrsubaccountypes;
	    $tcraccounttypes+=$tcrsubaccountypes;
      }
      return $tttotal;
    }
    
    function getChildren(&$categories, $id) {
      $result = mysql_query("SELECT * FROM fn_generaljournalaccounts WHERE categoryid = '$id'");
      
      while ($row = mysql_fetch_array($result)) {
	$categories[] = $row['id'];
	$this->getChildren($categories, $row['id']);
      }
    }

    function getCategory($var) {
      $categories = array();

      $this->getChildren($categories, $var);
      return $categories;
    }

    function getCategoryAccounts($id,$accountid){
      if(!empty($id))
	$query="select * from fn_generaljournalaccounts where acctypeid='$id' and (categoryid is null or categoryid='' or categoryid=0)";
      else	
	$query="select $accountid as id";
	
      $res=mysql_query($query);
      $array=array();
      while($row=mysql_fetch_object($res)){
	$arr = $this->getCategory($row->id);
	if(count($arr)>0)
	  $array[]=$arr;
      }
      
      //convert array to a string
      $i=0;
      $j=0;
      $str="";
      while($i<count($array)){
	while($j<count($array[$i])){
	  $str.=$array[$i][$j].",";
	  $j++;
	}
	$i++;
      }
      $str=substr($str,0,-1);
      if(empty($str))
	$str.="";
      return $str;
    }
    
    function getJvNos($documentno, $transactionid){
      $query="select * from fn_generaljournals where documentno='$documentno' and transactionid='$transactionid'";
      $row=mysql_fetch_object(mysql_query($query));
      
      return $row->jvno;
    }
}				
?>
