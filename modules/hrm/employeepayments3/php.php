<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../employees/Employees_class.php';
require_once("../employeepaidallowances/Employeepaidallowances_class.php");
require_once("../employeepaiddeductions/Employeepaiddeductions_class.php");
require_once '../employeepaidsurchages/Employeepaidsurchages_class.php';
require_once("../employeepayments/Employeepayments_class.php");
require_once '../assignments/Assignments_class.php';
require_once "../loans/Loans_class.php";
require_once "../employeeloans/Employeeloans_class.php";

require_once 'rotation.php';

$db = new DB();

class PDF extends PDF_Rotate
{
// Page header
function Header()
{
	$this->SetFont('Arial','B',15);
	$this->SetTextColor(224,220,210);
	for($i=1;$i<1000;$i=$i+10){
		for($j=10;$j<1000;$j+=60)
			$this->RotatedText($j,$i,$_SESSION['companyname'],45);
	}
	
    // Logo
    $this->Image('../../../images/logo.png',30,6,30);
    $this->Ln(20);
    // Arial bold 15
    $this->SetFont('Arial','B',12);
    // Move to the right
    $this->Cell(80);
    // Title
    //$w = $this->GetStringWidth(COMPANY_NAME)+6;
    $title=$_SESSION['companyname'];
    //$this->Cell(30,10,COMPANY_NAME,1,0,'C');
    $w = $this->GetStringWidth($title)+10;
    $this->SetX(28);
    $this->SetDrawColor(0,80,180);
    $this->SetFillColor(255,255,255);
    $this->SetTextColor(0,0,0);
    $this->SetLineWidth(0);
    $this->Cell(30,4,$title,10,1,'C',true);
    $this->SetFont('Arial','B',10);
    $this->Cell(30,4,"EMPLOYEE PAYSLIP",10,1);
    // Line break
    //$this->Ln(20);
    
    
}

function RotatedText($x, $y, $txt, $angle)
{
	//Text rotated around its origin
	$this->Rotate($angle,$x,$y);
	$this->Text($x,$y,$txt);
	$this->Rotate(0);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    //$this->SetY(-15);
    // Arial italic 8
    //$this->SetFont('Arial','I',8);
    // Page number
    //$this->Cell(50,10,COMPANY_SLOGAN,0,0,'C');
}
}

function payslip($id,$month,$year){
		
	$printedon=formatDate(Date("Y-m-d"))." ".Date("H :i :s");
	
	$employees = new Employees();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id='$id'";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$emp=$employees->fetchObject;
	
	$employeepayments = new Employeepayments();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where employeeid='$emp->id'";
	$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$pay=$employeepayments->fetchObject;
	
	//$check=retrieveScheduleByEmployee($emp->id);
	
	$assignments = new Assignments();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where id='$emp->assignmentid'";
	$assignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$ass=$assignments->fetchObject;
	
	//$nssf=retrievePaidEmployeeDeduction($id,4,$month,$year);
	
	// Instanciation of inherited class
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(30,4,'Payment for: ',0,0);
	$pdf->Cell(30,4,date("F",mktime(0, 0, 0, $month, 1)).' '.$pay->year,0,1);
	$pdf->Cell(30,4,'Payment Date: ',0,0);
	$pdf->Cell(30,4,formatDate($pay->paydate),0,1);
	$pdf->Cell(30,4,'Name: ',0,0);
	$pdf->Cell(30,4,initialCap($emp->firstname).' '.initialCap($emp->middlename).' '.initialCap($emp->lastname),0,1);
	$pdf->Cell(30,4,'Id No: ',0,0);
	$pdf->Cell(30,4,$emp->idno,0,1);
	$pdf->Cell(30,4,'PF Number: ',0,0);
	$pdf->Cell(4,4,$emp->pfnum,0,1);
	$pdf->Cell(30,4,'Position: ',0,0);
	$pdf->Cell(30,4,$ass->name,0,1);
	$pdf->Cell(30,4,' ',0,1,'R');
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(80,4,'PAYMENTS ',0,1);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(30,4,'Basic Salary: ',0,0);
	$pdf->Cell(30,4,' ',0,0);
	$pdf->Cell(30,4,formatNumber($emp->basic),0,1,'R');
	$pdf->SetFont('Arial','',9);
	
	$employeepaidallowances = new Employeepaidallowances();
	$fields="hrm_employeepaidallowances.*, hrm_allowances.name allowanceid";
	$join=" left join hrm_allowances on hrm_allowances.id=hrm_employeepaidallowances.allowanceid ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where hrm_employeepaidallowances.employeeid='$emp->id' and hrm_employeepaidallowances.month='$month' and hrm_employeepaidallowances.year='$year'";
	$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
	$rs = $employeepaidallowances->result;
	$t=0;
	  while($rw=mysql_fetch_object($rs))
	  {	  	$t+=$rw->amount;
		$pdf->Cell(30,4,initialCap($rw->allowanceid) .': ',0,0);
		$pdf->Cell(30,4,' ',0,0);
		$pdf->Cell(30,4,formatNumber($rw->amount),0,1,'R');
	  }
	 $pdf->Cell(30,4,'',0,0);
	 $pdf->Cell(30,4,' ',0,0);
	 $pdf->SetFont('Arial','B',9);
	 $pdf->Cell(30,4,formatNumber($emp->basic+$t),0,1,'R');
	  $pdf->Cell(20,4,' ',0,1,'R');
	  $pdf->SetFont('Arial','B',10);
	 $pdf->Cell(80,4,'DEDUCTIONS ',0,1);
	 $pdf->SetFont('Arial','',9);
	 
	$total=0;
	$employeepaiddeductions = new Employeepaiddeductions();
	$fields="hrm_employeepaiddeductions.*, hrm_deductions.name deductionid, hrm_deductions.id ded";
	$join=" left join hrm_deductions on hrm_deductions.id=hrm_employeepaiddeductions.deductionid ";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where hrm_employeepaiddeductions.employeeid='$emp->id' and hrm_employeepaiddeductions.month='$month' and hrm_employeepaiddeductions.year='$year'";
	$employeepaiddeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$res = $employeepaiddeductions->result;
	  //$res=retrievePaidEmployeeDeductions($id,$month,$year,$pay->paydate);
	  while($row=mysql_fetch_object($res)){
	  	
	  	if($row->ded==4 or $row->ded==5){
		  $loans = new Loans();
		  $fields="*";
		  $join="";
		  $having="";
		  $groupby="";
		  $orderby="";
		  $where=" where id='$row->loanid' ";
		  $loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		  $loans = $loans->fetchObject;
		  
		  $row->deductionid=$loans->name;
		  
		  if($row->ded==5)
		    $row->deductionid=$loans->name." Interest";
	  	}
		  
		  $total+=$row->amount;
		  if($row->amount>0){
			  $pdf->Cell(30,4,initialCap($row->deductionid) .': ',0,0);
			  $pdf->Cell(30,4,formatNumber($row->amount),0,1,'R');
		  }
	  }
	  
	  $employeepaidsurchages = new Employeepaidsurchages();
	  $fields="hrm_employeepaidsurchages.*, hrm_surchages.name surchageid";
	  $join=" left join hrm_surchages on hrm_surchages.id=hrm_employeepaidsurchages.empsurchageid ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where hrm_employeepaidsurchages.employeeid='$emp->id' and hrm_employeepaidsurchages.month='$month' and hrm_employeepaidsurchages.year='$year'";
	  $employeepaidsurchages->retrieve($fields,$join,$where,$having,$groupby,$orderby);echo mysql_error();
	  $res = $employeepaidsurchages->result;
	 // $res=retrievePaidEmployeeSurchages($pay->employeeid,$pay->month,$pay->year,$pay->paydate);
		  while($row=mysql_fetch_object($res)){
		  	$total+=$row->amount;
		  	$pdf->Cell(30,4,'Surchage - '.initialCap($row->surchageid).': ',0,0);
		  	$pdf->Cell(30,4,formatNumber($row->amount),0,1,'R');
		  }
	$pdf->Cell(30,4,'Total Deductions ',0,0);
	$pdf->Cell(30,4,' ',0,0);
	$pdf->Cell(30,4,formatNumber($total),0,1,'R');
	
	$pdf->Cell(30,4,'Net Pay ',0,0);
	$pdf->Cell(30,4,' ',0,0);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(30,4,formatNumber($emp->basic+$t-$total),0,1,'R');
	$pdf->Cell(20,4,' ',0,1,'R');
	$pdf->SetFont('Arial','B',10);
	 $pdf->Cell(80,4,'STATEMENTS ',0,1);
	 $pdf->SetFont('Arial','',9);
	 
	 $employeeloans = new EmployeeLoans();
	 $fields="hrm_employeeloans.principal, hrm_loans.name loanid";
	  $join=" left join hrm_loans on hrm_loans.id=hrm_employeeloans.loanid ";
	  $having="";
	  $groupby="";
	  $orderby="";
	  $where=" where hrm_employeeloans.employeeid='$emp->id' ";
	  $employeeloans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	  while($r = mysql_fetch_object($employeeloans->result)){
	    $pdf->Cell(30,4,$r->loanid.' TO DATE: ',0,0);
	    $pdf->Cell(30,4,' ',0,0);
	    $pdf->Cell(30,4,formatNumber($r->principal),0,1,'R');
	  }
	 
	 /*$rs=retrieveEmpStatements($id,$month,$year);
		  while($rw=mysql_fetch_object($rs)){
		  	$ded=retrieveDeduction($rw->deductionid);	  
		  	
		  	if($rw->deductionid==17){
		  	$rsl=retrieveEmpLoans($id," and principal>0 and loanid='$rw->loanid' ");
		  	while($lr=mysql_fetch_object($rsl)){
		  		if(!empty($lr->loanid)){
		  			$rw->amount=0;
			  		$loan=retrieveLoanByEmployee($id,$lr->loanid);
			  		$l=retrieveLoan($lr->loanid);
			  		$rw->amount=$loan->principal;
			  		if(!empty($rw->amount)){
				  		$pdf->Cell(30,4,initialCap($l->loan).' TO DATE: ',0,0);
					  	$pdf->Cell(30,4,' ',0,0);
					  	$pdf->Cell(30,4,formatNumber($rw->amount),0,1,'R');
			  		}
			  		
				  	$interest=retrievePaidLoanInterest($lr->loanid,$month,$year);
				  	if(!empty($interest->amount)){
					  	//$pdf->Cell(30,4,initialCap($l->loan).' Interest TO DATE: ',0,0);
					  	//$pdf->Cell(30,4,' ',0,0);
					  	//$pdf->Cell(30,4,formatNumber($interest->amount),0,1,'R');
				  	}
		  		}
		  	}
		  	}
		  	elseif($rw->deductionid==18){
		  		
		  	}
		  	else{
				if($rw->deductionid==1)
					$rw=retrieveEmpStatement($id,$month,$year,1);
					
		  		$pdf->Cell(30,4,initialCap($ded->deduction).' TO DATE: ',0,0);
		  	$pdf->Cell(30,4,' ',0,0);
		  	$pdf->Cell(30,4,formatNumber($rw->amount),0,1,'R');
		  	}
		  }
		  if($pay->paye>0){
		  	$pdf->Cell(20,4,' ',0,1,'R');
		  	$pdf->SetFont('Arial','B',10);
		  	$pdf->Cell(80,4,'TAX DETAILS ',0,1);
		  	$pdf->SetFont('Arial','',9);
		  	$pdf->Cell(30,4,'Taxable Pay: ',0,0);
		  	$pdf->Cell(30,4,' ',0,0);
		  	$pdf->Cell(30,4,formatNumber($pay->payable-$nssf->amount),0,1,'R');
		  	$pdf->Cell(30,4,'PAYE: ',0,0);
		  	$pdf->Cell(30,4,' ',0,0);
		  	$pdf->Cell(30,4,formatNumber($pay->paye),0,1,'R');
		  	$pdf->Cell(30,4,'Tax Relief: ',0,0);
		  	$pdf->Cell(30,4,' ',0,0);
		  	$pdf->Cell(30,4,formatNumber(1162),0,1,'R');
		  }*/
		 
		 $pdf->Cell(80,4,'',0,1);
		 $pdf->Cell(80,10,$_SESSION['companyslogan'],0,1);
		 
	//create a resource folder
	$config = new Config();
	$fields="*";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$where=" where name='DMS_RESOURCE'";
	$config->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$config=$config->fetchObject;
	
	@mkdir($config->value);
	@mkdir($config->value."HRM");
	@mkdir($config->value."HRM/payslips");
	$pdf->Output($config->value."HRM/payslips/".$emp->pfnum.''.getMonth($month).''.$year.'.pdf','F');
}
?>