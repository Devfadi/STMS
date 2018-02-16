<?php	
include '../connection.php';

//--------------------------------------------
//			enroll course
//--------------------------------------------
if(isset($_POST["enrollcourseid"])){
	$courseid=$_POST["enrollcourseid"];
	
	$result=$link->query("SELECT* from  enrollment where USERID='$activeuserid' AND VISIBILITY='ACTIVE' AND COURSEID='$courseid'");
	if($result->num_rows>0){
		$_SESSION['user_failure_message'] = "Your have already been added in this course";
		$userurl='index.php?page=view_courses';
		//echo '<script>window.location = "'.$userurl.'";</script>';
	}else{
		mysqli_query($link, "insert into enrollment(USERID,COURSEID,ADDEDDATE)values('$activeuserid','$courseid','$currenttime')");
		$_SESSION['user_success_message'] = "Your have successfully been added to a course";
		$userurl='index.php?page=view_courses';
		//echo '<script>window.location = "'.$userurl.'";</script>';
	}
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
		<li class="active">View Courses</li>
	</ul><!-- /.breadcrumb -->
</div>
<hr>

<div class='row'>
	<div class="col-sm-12">
		<table id="simple-table" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
			<thead>
				<tr>
					<th>Course ID</th>
					<th>Course</th>
					<th class="hidden-480">Description</th>
					<th>
						<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
						Added Date
					</th>
					<th>Teacher</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$result=$link->query("select course.NAME,course.COURSEID,course.DESCRIPTION,course.ADDEDDATE,userdata.FIRSTNAME,userdata.LASTNAME from userdata,course WHERE course.ADDEDBY=userdata.USERID AND course.VISIBILITY='ACTIVE' AND userdata.VISIBILITY='ACTIVE' order by course.COURSEID DESC");
				if($result->num_rows>0){
					while($row=$result->fetch_assoc()){
						echo"
							<tr>
								<td>".$row["COURSEID"]."</td>
								<td>".$row["NAME"]."</td>
								<td class='hidden-480'>".$row["DESCRIPTION"]."</td>
								<td class='hidden-480'>
									<span class='label label-sm label-warning'>".date('F j, Y H:i:s',strtotime($row["ADDEDDATE"]))."</span>
								</td>
								<td class='hidden-480'>".$row["FIRSTNAME"]." ".$row["LASTNAME"]." </td>
								<td>
									<div class='hidden-sm hidden-xs btn-group'>
										<a href='#E".$row["COURSEID"]."' role='button' class='green' data-toggle='modal'> 
											<i class='ace-icon fa fa-random bigger-120'></i>
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
$result=$link->query("select course.COURSEID,course.NAME,course.DESCRIPTION,course.ADDEDDATE,userdata.FIRSTNAME,userdata.LASTNAME from userdata,course WHERE course.ADDEDBY=userdata.USERID AND course.VISIBILITY='ACTIVE' AND userdata.VISIBILITY='ACTIVE'");
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
		echo"
		<div id='E".$row["COURSEID"]."' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header'>
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							Do you want to enroll in the course (".$row["NAME"].")?
						</div>
					</div>
					<form method='post' action='index.php?page=view_courses' style='padding:20px'>
						<input name='enrollcourseid' value='".$row["COURSEID"]."' type='hidden'/>
						
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