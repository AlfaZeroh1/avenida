<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once '../../sch/studentexamresults/Studentexamresults_class.php';
require_once '../../sch/students/Students_class.php';
require_once '../../sch/subjects/Subjects_class.php';
require_once("../../sch/classsubjects/Classsubjects_class.php");
require_once("../../sch/formsubjects/Formsubjects_class.php");
require_once("../../sch/studentsubjects/Studentsubjects_class.php");
require_once '../../sch/classes/Classes_class.php';
require_once '../../sys/terms/Terms_class.php';
require_once '../../sch/exams/Exams_class.php';
require_once '../../sch/grades/Grades_class.php';
require_once '../../sys/forms/Forms_class.php';
require_once '../../sch/weightedaverages/Weightedaverages_class.php';

$page_title="Results";
//connect to db
$db=new DB();
include"../../../header2.php";


$obj = (object)$_POST;

$delid=$_GET['delid'];

if(!empty($delid)){
	
}

if(!empty($obj->districtid)){
  
}
?>
<div class="buttons"><a class="positive" href="javascript: expandCollapse('boxB','over');" style="vertical-align:text-top;">Open Popup To Filter</a></div>
<div id="boxB" class="sh" style="left: 100px; top: 63px; display: none; z-index: 500;">  
                <div id="box2"><div class="bar2" onmousedown="dragStart(event, 'boxB')"><span><strong>Choose Criteria</strong></span>
                  <a href="#" onclick="expandCollapse('boxB','over')">Close</a></div>
		  <form  action="results.php" method="post" name="">
		    <table width="100%" border="0" align="center">
		      
		      	<tr>
                  <td><div align="right"><strong>Form</strong></div></td>
                  <td><select name="formid">
                  		<option value="">select...</option>
						<?php 
						$forms=new Forms();
						$fields=" * " ;
						$where="";
						$join="";
						$forms->retrieve($fields,$join,$where,$having,$groupby,$orderby);
						while($rw=mysql_fetch_object($forms->result)){
							?>
							<option value="<?php echo $rw->id; ?>>" <?php if($rw->id==$obj->formid){echo"selected";}?>><?php echo $rw->name; ?></option>
							<?php 
						}
						?>
					</select>
                  </tr>   
                  
                  <tr>
                  <td><div align="right"><strong>Class</strong></div></td>
                  <td><select name="classeid">
                  		<option value="">select...</option>
						<?php 
						$classes=new Classes();
						$fields="*";
						$where="";
						$classes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
						while($rw=mysql_fetch_object($classes->result)){
							?>
							<option value="<?php echo $rw->id; ?>>" <?php if($rw->id==$obj->classeid){echo"selected";}?>>Form <?php echo $rw->name; ?></option>
							<?php 
						}
						?>
					</select>
                  </tr>        
                      
                  <tr>
					<td align="right">Term: </td>
					<td><select name="termid">
					<option value="">Select...</option>
					<?php
					$terms=new Terms();
					$fields="*";
					$where="";
					$terms->retrieve($fields, $join, $where, $having, $groupby, $orderby);
					while($rw=mysql_fetch_object($terms->result)){
					?>
						<option value="<?php echo $rw->id; ?>" <?php if($obj->termid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
					<?php
					}
					?>
					</select></td>
				</tr>      
				<tr>
					<td align="right">Exam: </td>
					<td><select name="examid">
					<option value="">Select...</option>
					<?php
					$exams=new Exams();
					$fields="*";
					$where="";
					$exams->retrieve($fields, $join, $where, $having, $groupby, $orderby);
					while($rw=mysql_fetch_object($exams->result)){
					?>
						<option value="<?php echo $rw->id; ?>" <?php if($obj->examid==$rw->id){echo "selected";}?>><?php echo initialCap($rw->name);?></option>
					<?php
					}
					?>
					<option value="-1" <?php if($obj->examid==4){echo "selected";}?>>Overall</option>
					</select></td>
			</tr>                  
                  
                  <tr>
                    <td colspan="2"><div align="center">
                        <input type="submit" name="action" id="action" value="Filter" />
                    </div></td>
                  </tr>
                </table>
		        <div align="right"></div></td>
            <td width="100%" valign="top"><table class="tgrid gridd" width="125%" border="0" align="left">
                    
                   
                    <tr>
                    <td>
                    <table class="tgrid gridd" width="100%" border="0" align="left">
                    
            <tr>
                      <th colspan="2"><div align="left"><strong>Group By (For Summarised Reports)</strong>: </div></th>
                      </tr>
                      <tr>
                      <td width="36%"><input name="grdistrict" type="checkbox"  id="grdistrict" value="grdistrict" />
                        District </td>
                      <td width="30%">&nbsp;</td>
                      </tr>
                      
                </table>
                </td>
                </tr>
                
                    
                </table>

                
                </td>
              </tr>
	        </table>
            </form>
		  </div>
  </div>
<table style="clear:both;" class="table display" width="100%" border="0" cellspacing="0" cellpadding="2" align="center" >
	<thead>
		<tr>
			<th>#</th>
			<th>AdmNo</th>
			<th>Student</th>
			<th>&nbsp;</th>
			<?php 
			$subjects = new Subjects();
			$fields="*";
			$where="";
			$subjects->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			while($rw=mysql_fetch_object($subjects->result)){
				?>
					<th><?php echo firstThree($rw->name); ?></th>
				<?php 
			}
			?>
			<th><?php echo firstThree("Total Mark"); ?></th>
			<th><?php echo firstThree("Subjects"); ?></th>
			<th><?php echo firstThree("Average Mark");?></th>
			<th><?php echo firstThree("Total Points");?></th>
			<th><?php echo firstThree("Grade");?></th>
			<th><?php echo firstThree("Overall Position");?></th>
			<th><?php echo firstThree("Class Position");?></th>
		</tr>
	</thead>
	<tbody>
	<?php
	$sql="";
	if($obj->action=="Filter"){
		
	
		$i=0;
		$students = new Students();
		$where="";
		if(!empty($obj->classeid))
			$where=" where sch_students.classeid='$obj->classeid'";
		
		if(!empty($obj->formid)){
			if(!empty($where))
				$where.=" and ";
			else 
				$where.=" where ";
			
			$where.=" sch_classes.formid='$obj->formid' ";
		}
		$fields=" sch_students.*,sch_classes.name as classname ";
		$join=" left join sch_classes on sch_students.classeid=sch_classes.id  left join sys_genders on sch_students.genderid=sys_genders.id  left join sch_studentstatuss on sch_students.studentstatusid=sch_studentstatuss.id ";
		$students->retrieve($fields,$join,$where,$having,$groupby,$orderby);
		$res=$students->result;
		$i=0;
		$noofsubjects=0;
		while($row=mysql_fetch_object($res)){
		$i++;
		$noofsubjects=$studentresults->getStudentSubjects($row->id);
	?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row->regno; ?></td>
			<td><?php echo ltrim($row->surname); ?>&nbsp;<?php echo trim($row->othernames); ?></td>			
			<td><?php echo $row->classname; ?></td>
			<?php 
			$total=0;
			$totalpoints=0;
			$subjects = new Subjects();
			$fields="*";
			$where="";
			$join="";
			$groupby="";
			$marks="";
			$num=0;
			$subs=0;
			$average=0;
			$subjects->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			while($rw=mysql_fetch_object($subjects->result)){
				$studentresults=new Studentexamresults();
				
				$num++;
				if($obj->examid==-1){
					$groupby=" group by sch_studentexamresults.studentid,sch_studentexamresults.subjectid,sch_studentexamresults.year ";
					$fields=" sch_studentexamresults.studentid,sch_studentexamresults.subjectid,sch_studentexamresults.termid,sch_studentexamresults.year,sch_studentexamresults.examid,sum(sch_studentexamresults.mark*sch_weightedaverages.weight) as mark";
					$join=" left join sch_weightedaverages on sch_studentexamresults.examid=sch_weightedaverages.examid and sch_studentexamresults.subjectid=sch_weightedaverages.subjectid ";
				}
				else {
					$groupby=" group by studentid,subjectid,termid,examid,year ";
					$fields=" studentid,subjectid,termid,year,examid,sum(mark) as mark";
					$join="";
				}
				$where=" where sch_studentexamresults.subjectid='$rw->id' and sch_studentexamresults.studentid='$row->id'";
				if(!empty($obj->termid)){
					$where.=" and sch_studentexamresults.termid='$obj->termid' ";
				}
				if(!empty($obj->examid) and $obj->examid>0){
					$where.=" and sch_studentexamresults.examid='$obj->examid' ";
				}
				$studentresults->retrieve($fields,$join,$where,$having,$groupby,$orderby);				
				$mark=$studentresults->fetchObject;
				
				
				if($studentresults->affectedRows>0 and $mark->mark !=null){					
					$marks=round($mark->mark);
					$total+=$mark->mark;
					$marks=str_pad($marks,2,'0',STR_PAD_LEFT);
					$subs++;
				}
				else
					$marks="-";
				
				if($marks!="-"){
					$grade=$studentresults->getMarkGrade($marks,$rw->gradingid);//$grades->fetchObject;
					$totalpoints+=$studentresults->checkPoints($grade->grade);
				}
				else 
					$grade->grade="";
				?>
					<td><?php echo $marks; ?>&nbsp;<?php echo $grade->grade; ?></td>
				<?php 
				
			}
			$average=$total/$noofsubjects;
			$grades = new Grades();
			$join="";
			$fields = "sch_grades.grade";
			$where=" where sch_grades.gradingid='4' and startmark<='$average' and endmark>='$average'";
			$groupby="";
			$grades->retrieve($fields, $join, $where, $having, $groupby, $orderby);
			$grade2=$grades->fetchObject;
			?>
			<td><?php echo $total; ?></td>
			<td><?php echo $subs; ?></td>
			<td><?php echo formatNumber($average); ?></td>
			<td><?php echo $totalpoints; ?></td>
			<td><?php if($noofsubjects>$subs){echo "Y";}else{echo $grade2->grade;} ?></td>
			<td></td>
			<td></td>
		</tr>
	<?php 
	}
	}
	?>
	</tbody>
</table>
<?php
function checkGrade($points){
	if($points==12)
		$grade="A";
	elseif($points==11)
	$grade="A-";
	elseif($points==10)
	$grade="B+";
	elseif($points==9)
	$grade="B";
	elseif($points==8)
	$grade="B-";
	elseif($points==7)
	$grade="C+";
	elseif($points==6)
	$grade="C";
	elseif($points==5)
	$grade="C-";
	elseif($points==4)
	$grade="D+";
	elseif($points==3)
	$grade="D";
	elseif($points==2)
	$grade="D-";
	elseif($points==1)
	$grade="E";

	return $grade;
}

include"../../../footer.php";
?>
