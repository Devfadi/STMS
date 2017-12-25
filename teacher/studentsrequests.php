<?php	
include '../connection.php';
//--------------------------------------------
//			enroll course
//--------------------------------------------
if(isset($_POST["enrollcourseid"])){
	$eid=$_POST["enrollcourseid"];
	mysqli_query($link, "update enrollment set STATUS='APPROVED' where EID='$eid'");
		$_SESSION['user_success_message'] = "Your have successfully been approved the student's enrollment in  the course";
		$userurl='index.php?page=student_requests';
		//echo '<script>window.location = "'.$userurl.'";</script>';
	
}else{}
//--------------------------------------------
//			enroll course
//--------------------------------------------
if(isset($_POST["deniecourseid"])){
	$eid=$_POST["deniecourseid"];
	mysqli_query($link, "update enrollment set STATUS='DENIED' where EID='$eid'");
		$_SESSION['user_success_message'] = "Your have successfully been denied the student's enrollment in  the course";
		$userurl='index.php?page=student_requests';
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
		<li class="active">Students Requests</li>
	</ul><!-- /.breadcrumb -->
</div>
<hr>

<div class='row'>
	<div class="col-sm-12">
		<table id="simple-table" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
			<thead>
				<tr>
					<th>Course</th>
					<th>
						<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
						Request Date
					</th>
					<th>Student</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$result=$link->query("select course.NAME,enrollment.ADDEDDATE,enrollment.EID,userdata.FIRSTNAME,userdata.LASTNAME from course, userdata, enrollment WHERE course.COURSEID=enrollment.COURSEID AND userdata.USERID=enrollment.USERID AND enrollment.STATUS='PENDING' and enrollment.VISIBILITY='ACTIVE' and course.ADDEDBY='$activeuserid'");
				if($result->num_rows>0){
					while($row=$result->fetch_assoc()){
						echo"
							<tr>
								<td>".$row["NAME"]."</td>
								<td class='hidden-480'>
									<span class='label label-sm label-warning'>".date('F j, Y H:i:s',strtotime($row["ADDEDDATE"]))."</span>
								</td>
								<td>".$row["FIRSTNAME"]." ".$row["LASTNAME"]." </td>
								<td>
									<div class='hidden-sm hidden-xs btn-group'>
										<a href='#E".$row["EID"]."' role='button' class='green' data-toggle='modal'> 
											<i class='ace-icon fa fa-check bigger-120'></i>
										</a>
										<a href='#D".$row["EID"]."' role='button' class='red' data-toggle='modal'> 
											<i class='ace-icon fa fa-trash bigger-120'></i>
										</a>
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
$result=$link->query("select course.NAME,enrollment.EID,enrollment.ADDEDDATE,enrollment.EID,userdata.FIRSTNAME,userdata.LASTNAME from course, userdata, enrollment WHERE course.COURSEID=enrollment.COURSEID AND userdata.USERID=enrollment.USERID AND enrollment.STATUS='PENDING' and enrollment.VISIBILITY='ACTIVE' and course.ADDEDBY='$activeuserid'");
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
		echo"
		<div id='E".$row["EID"]."' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header'>
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							Do you want to enroll ".$row["FIRSTNAME"]." ".$row["LASTNAME"]." in ".$row["NAME"]."?
						</div>
					</div>
					<form method='post' action='index.php?page=student_requests' style='padding:20px'>
						<input name='enrollcourseid' value='".$row["EID"]."' type='hidden'/>
						
						<div class='modal-body no-padding'>
							<div class='modal-footer' style='background:#DDDBDB'>
								<button type='submit' class='btn btn-sm' data-dismiss='modal'>
									<i class='ace-icon fa fa-times'></i> Cancel
								</button>
								<button type='submit' class='btn btn-sm btn-primary'>
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
				deny requests
<!----------------------------------------------------------------------->
<?php
$result=$link->query("select course.NAME,enrollment.EID,enrollment.ADDEDDATE,enrollment.EID,userdata.FIRSTNAME,userdata.LASTNAME from course, userdata, enrollment WHERE course.COURSEID=enrollment.COURSEID AND userdata.USERID=enrollment.USERID AND enrollment.STATUS='PENDING' and enrollment.VISIBILITY='ACTIVE' and course.ADDEDBY='$activeuserid'");
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
		echo"
		<div id='D".$row["EID"]."' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header' style='background:red;'>
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							Do you want to deny ".$row["FIRSTNAME"]." ".$row["LASTNAME"]."'s request to enroll in ".$row["NAME"]."?
						</div>
					</div>
					<form method='post' action='index.php?page=student_requests' style='padding:20px'>
						<input name='deniecourseid' value='".$row["EID"]."' type='hidden'/>
						
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