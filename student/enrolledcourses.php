<?php	
include '../connection.php';
//--------------------------------------------
//			enroll course
//--------------------------------------------
if(isset($_POST["enrollcourseid"])){
	$eid=$_POST["enrollcourseid"];
	mysqli_query($link, "update enrollment set VISIBILITY='DELETED' where EID='$eid'");
		$_SESSION['user_success_message'] = "Your have successfully been withdrawn the course";
		$userurl='index.php?page=enrolled_courses';
		//echo '<script>window.location = "'.$userurl.'";</script>';
	
}else{}
		//----------------------------user panel notification messages---------------------------------->
	if(isset($_SESSION['user_success_message'])){
			echo"<div class='alert alert-block alert-success' style='color:green'>
					<button type='button' class='close' data-dismiss='alert'>
						<i class='ace-icon fa fa-times'></i>
					</button>
						<i class='ace-icon fa fa-check green'></i>
						",$_SESSION['user_success_message'],"
				</div>";
				unset($_SESSION['user_success_message']);
		}else{}
		if(isset($_SESSION['user_failure_message'])){
			echo"<div class='alert alert-block alert-danger'  style='color:red'>
					<button type='button' class='close' data-dismiss='alert'>
						<i class='ace-icon fa fa-times'></i>
					</button>
						<i class='ace-icon fa fa-remove red'></i>
						",$_SESSION['user_failure_message'],"
				</div>";
				unset($_SESSION['user_failure_message']);
		}else{}
		?>

<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
		try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>

	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Home</a>
		</li>

		<li>
			<a href="#">Courses</a>
		</li>
		<li class="active">Enrolled Courses</li>
	</ul><!-- /.breadcrumb -->
</div>
<hr>

<div class='row'>
	<div class="col-sm-12">
		<table id="simple-table" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
			<thead>
				<tr>
					<th>Course</th>
					<th class="hidden-480">Description</th>
					<th>
						<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
						Enrollment Date
					</th>
					<th>Teacher</th>
					<th>Enrollment Status</th>
					<th>Attendance</th>
					<th>Marks</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$result=$link->query("select enrollment.EID,enrollment.STATUS,course.COURSEID,userdata.FIRSTNAME,userdata.LASTNAME,course.NAME,course.DESCRIPTION,enrollment.ADDEDDATE FROM userdata,course,enrollment WHERE userdata.USERID=course.ADDEDBY AND enrollment.COURSEID=course.COURSEID AND enrollment.VISIBILITY='ACTIVE' AND course.VISIBILITY='ACTIVE' AND userdata.VISIBILITY='ACTIVE' AND enrollment.USERID='$activeuserid' order by enrollment.STATUS");
				if($result->num_rows>0){
					while($row=$result->fetch_assoc()){
                        $cid=$row["COURSEID"];
						echo"
							<tr>
								<td>".$row["NAME"]."</td>
								<td class='hidden-480'>".$row["DESCRIPTION"]."</td>
								<td class='hidden-480'>
									<span class='label label-sm label-warning'>".date('F j, Y H:i:s',strtotime($row["ADDEDDATE"]))."</span>
								</td>
								<td>".$row["FIRSTNAME"]." ".$row["LASTNAME"]." </td>
								<td>".$row["STATUS"]." </td>
								<td>";
                        //initialize the total MARKED attendance and Present attendance
                                $tot=$present=0;
                                $result1=$link->query("select STATUS,count(STATUS) AS TOTAL from attendance where USERID='$activeuserid' AND CID='$cid' group by STATUS");
                                if($result1->num_rows>0){
                                    while($row1=$result1->fetch_assoc()){
                                        if($row1["STATUS"]=="P"){
                                            $present=$row1["TOTAL"];
                                        }else{
                                            $present=0;
                                        }
                                        $tot=$tot+$row1["TOTAL"];
                                    }
                                }else{}
                                //avoid the unknown result
                                if($tot==0){
                                    $tot=1;
                                }else{
                                    $tot=$tot;
                                }
                                        
                                //print the attendance percentage
                                echo round(($present*100)/$tot,2)."%
                        <a href='#SHOW".$row["COURSEID"]."' role='button' class='green' data-toggle='modal' title='Full Attendence'> 
											<i class='ace-icon fa fa-barcode bigger-120'></i>
										</a>
                                        
                                         
                        </td>
                        <td>
                                <a href='#SHOW_MARKS".$row["COURSEID"]."' role='button' class='blue' data-toggle='modal' title='Full Attendence'> 
											<i class='ace-icon fa fa-envelope bigger-120'></i>
										</a>
                                </td>
								<td>
									<div class='hidden-sm hidden-xs btn-group'>
										
                                        <a href='#E".$row["EID"]."' role='button' class='red' data-toggle='modal'> 
											<i class='ace-icon fa fa-trash bigger-120'></i>
										</a>";
										if($row["STATUS"]=='APPROVED'){
											echo"
											<a href='#A".$row["EID"]."' role='button' class='green' data-toggle='modal'> 
											</a>";
										}else{}
										echo"
									</div>
								</td>
                                
							</tr>
						";
					}
				}else{}
				?>
				
			</table>
	</div>
	
<!-----------------------------------------------------------------------
				enroll students
<!----------------------------------------------------------------------->
<?php
$result=$link->query("select enrollment.EID,userdata.FIRSTNAME,userdata.LASTNAME,course.NAME,course.DESCRIPTION,enrollment.ADDEDDATE FROM userdata,course,enrollment WHERE userdata.USERID=course.ADDEDBY AND enrollment.COURSEID=course.COURSEID AND enrollment.VISIBILITY='ACTIVE' AND course.VISIBILITY='ACTIVE' AND userdata.VISIBILITY='ACTIVE' AND enrollment.USERID='$activeuserid'");
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
		echo"
		<div id='E".$row["EID"]."' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header' style='background:red;'>
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							Do you want to withdraw the course (".$row["NAME"].")?
						</div>
					</div>
					<form method='post' action='index.php?page=enrolled_courses' style='padding:20px'>
						<input name='enrollcourseid' value='".$row["EID"]."' type='hidden'/>
						
						<div class='modal-body no-padding'>
							<div class='modal-footer' style='background:#DDDBDB'>
								<button type='submit' class='btn btn-sm' data-dismiss='modal'>
									<i class='ace-icon fa fa-times'></i> Cancel
								</button>
								<button type='submit' class='btn btn-sm btn-danger'>
									<i class='ace-icon fa fa-check'></i> Yes, Please
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>";
	}
}else{}
?>
    <!-----------------------------------------------------------------------
				show all course attendance
<!----------------------------------------------------------------------->
<?php
$result=$link->query("select enrollment.EID,enrollment.STATUS,course.COURSEID,userdata.FIRSTNAME,userdata.LASTNAME,course.NAME,course.DESCRIPTION,enrollment.ADDEDDATE FROM userdata,course,enrollment WHERE userdata.USERID=course.ADDEDBY AND enrollment.COURSEID=course.COURSEID AND enrollment.VISIBILITY='ACTIVE' AND course.VISIBILITY='ACTIVE' AND userdata.VISIBILITY='ACTIVE' AND enrollment.USERID='$activeuserid' order by enrollment.STATUS");
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
        $courseid=$row["COURSEID"];
		echo"
		<div id='SHOW".$row["COURSEID"]."' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header'>
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							".$row["NAME"]." Attendance
						</div>
					</div>
					<form method='post' action='index.php?page=enrolled_courses' style='padding:20px'>
						<input name='enrollcourseid' value='".$row["EID"]."' type='hidden'/>
						
						<div class='modal-body no-padding'>";
                            $resultcheck=$link->query("select* from attendance where CID='$courseid' and USERID='$activeuserid'");
                            if($resultcheck->num_rows>0){
                                echo"<table class='table table-striped table-bordered table-hover no-margin-bottom no-border-top'>
                                <tr>
                                <th>Date</th>
                                <th> Status</th>
                                </tr>
                                ";
                                while($rowcheck=$resultcheck->fetch_assoc()){
                                    echo"<tr>
                                    <td>".date('F j, Y',strtotime($rowcheck["ADATE"]))."</td>
                                    <td>".$rowcheck["STATUS"]."</td>
                                    </tr>";
                                }
                                echo"</table>";
                            }else{}
        
                        echo"
						</div>
					</form>
				</div>
			</div>
		</div>";
	}
}else{}
?>
<!-----------------------------------------------------------------------
				Marks
<!----------------------------------------------------------------------->
<?php
$result=$link->query("select enrollment.EID,enrollment.STATUS,course.COURSEID,userdata.FIRSTNAME,userdata.LASTNAME,course.NAME,course.DESCRIPTION,enrollment.ADDEDDATE FROM userdata,course,enrollment WHERE userdata.USERID=course.ADDEDBY AND enrollment.COURSEID=course.COURSEID AND enrollment.VISIBILITY='ACTIVE' AND course.VISIBILITY='ACTIVE' AND userdata.VISIBILITY='ACTIVE' AND enrollment.USERID='$activeuserid' order by enrollment.STATUS");
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
        $courseid=$row["COURSEID"];
		echo"
		<div id='SHOW_MARKS".$row["COURSEID"]."' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header'>
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							".$row["NAME"]." Marks
						</div>
					</div>
					<form method='post' action='index.php?page=enrolled_courses' style='padding:20px'>
						<input name='enrollcourseid' value='".$row["EID"]."' type='hidden'/>
						
						<div class='modal-body no-padding'>";
                            $resultcheck=$link->query("select* from studentmarks where CID='$courseid' and STUDENTID='$activeuserid'");
       /* echo "select* from studentmarks where CID='$courseid' and USERID='$activeuserid'";*/
        
                            if($resultcheck->num_rows>0){
                                echo"<table class='table table-striped table-bordered table-hover no-margin-bottom no-border-top'>
                                <tr>
                                <th>Quiz</th>
                                <th> Assignment</th>
                                <th> Attendence</th>
                                <th> Mid</th>
                                <th> Final</th>
                                <th> Obtain</th>
                                <th> Total</th>
                                <th> GPA</th>
                                </tr>
                                ";
                                while($rowcheck=$resultcheck->fetch_assoc()){
                                    echo"<tr>
                                    <td>".$rowcheck["QUIZ"]."</td>
                                    <td>".$rowcheck["ASSIGNMENT"]."</td>
                                    <td>".$rowcheck["ATTENDANCE"]."</td>
                                    <td>".$rowcheck["MID"]."</td>
                                    <td>".$rowcheck["FINAL"]."</td>
                                    <td>".$rowcheck["OBTAINED"]."</td>
                                    <td>".$rowcheck["TOTAL"]."</td>
                                    <td>".$rowcheck["GPA"]."</td>
                                    </tr>";
                                }
                                echo"</table>";
                            }else{}
        
                        echo"
						</div>
					</form>
				</div>
			</div>
		</div>";
	}
}else{}
?>
<!-----------------------------------------------------------------------
				assingments
<!----------------------------------------------------------------------->
<?php
$result=$link->query("select enrollment.EID,userdata.FIRSTNAME,userdata.LASTNAME,course.NAME,course.COURSEID,enrollment.ADDEDDATE FROM userdata,course,enrollment WHERE userdata.USERID=course.ADDEDBY AND enrollment.COURSEID=course.COURSEID AND enrollment.VISIBILITY='ACTIVE' AND course.VISIBILITY='ACTIVE' AND userdata.VISIBILITY='ACTIVE' AND enrollment.USERID='$activeuserid'");
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
		$courseid=$row["COURSEID"];
		echo"
		<div id='A".$row["EID"]."' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header' >
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							".$row["NAME"]."'s Lectures
						</div>
					</div>
					<table  class='table table-striped table-bordered table-hover no-margin-bottom no-border-top'>
						<thead>
							<tr>
								<th>Title</th>
								<th class='hidden-480'>Description</th>
							</tr>
						</thead>
						<tbody>";
						$result1=$link->query("select* from lecture where COURSEID='$courseid'");
						if($result1->num_rows>0){
							while($row1=$result1->fetch_assoc()){
								echo "<tr>
										<td>".$row1["TITLE"]."</td>
										<td><a href='".$row1["FILE"]."' target='_blank'>Attachment</a><br>".$row1["DESCRIPTION"]."</td>
									</tr>";
							}
						}else{}
					echo"
					</tbody>
					</table>
				</div>
			</div>
		</div>";
	}
}else{}
?>