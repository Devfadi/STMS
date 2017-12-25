<head>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script>
</head>
  
  
  <?php	
include '../connection.php';
//--------------------------------------------
//			add course
//--------------------------------------------
if(isset($_POST["title"])){
	$title=$_POST["title"];
	$description=$_POST["description"];
	$courseid=$_POST["courseid"];
	$duedate=date('Y-m-d',strtotime($_POST["duedate"]));
	$file='';
	//-------------------------------------------
	//----------------------------------------------
	$target_dir = "../uploads/";
	$origional_file_name=basename($_FILES["photo"]["name"]); //image name
	$imageFileType = pathinfo($origional_file_name,PATHINFO_EXTENSION); //image type

	$now = DateTime::createFromFormat('U.u', microtime(true)); 	//current time
	$new_directory=$now->format("m.d.Y-H.i.s-u").".".$imageFileType; //add time and directory

	$target_file = $target_dir . $new_directory;
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	if(isset($_POST["photo"])) {
		$check = getimagesize($_FILES["image1"]["tmp_name"]);
		if($check !== false) {
			$uploadOk = 1;
		} else {
			$uploadOk = 0;
		}
	}
	if (file_exists($target_file)) {
		$uploadOk = 0;
	}
	if ($_FILES["photo"]["size"] > 500000000) {
		$uploadOk = 0;
	}
	if($imageFileType != "jpg" && $imageFileType != "png"&& $imageFileType != "ppt"&& $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "pdf" && $imageFileType != "docx" && $imageFileType != "xlxs" && $imageFileType != "txt"
	&& $imageFileType != "gif" ) {
		$uploadOk = 0;
	}
	if ($uploadOk == 0) {
	} else {
		if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
		} else {
		}
	}
	
	//-------------------------------------------
	//ASSIGNMENT ID
	$result=$link->query("SELECT max(AID) AS ID from assignment");
	if($result->num_rows>0){
		while($row=$result->fetch_assoc()){
			$aid=$row["ID"]+1;
			
			$result1=$link->query("SELECT* from enrollment where COURSEID='$courseid' AND VISIBILITY='ACTIVE' AND STATUS='APPROVED'");
			if($result1->num_rows>0){
				while($row1=$result1->fetch_assoc()){
					$uid=$row1["USERID"];
					mysqli_query($link,"insert into student_assignments(AID,USERID)values('$aid','$uid')");
				}
			}else{}
		}
	}else{}
	
	//-------------------------------------------
	mysqli_query($link, "insert into assignment(AID,TITLE,DESCRIPTION,FILE,COURSEID,ADDEDDATE,ADDEDBY,DUEDATE)values('$aid','$title','$description','$new_directory','$courseid','$currenttime','$activeuserid','$duedate')");
	$_SESSION['user_success_message'] = "The assignment has successfully been added";
	$userurl='index.php?page=assignments';
	echo '<script>window.location = "'.$userurl.'";</script>';
}else{}
//--------------------------------------------
//			delete course
//--------------------------------------------
if(isset($_POST["deletecourseid"])){
	$courseid=$_POST["deletecourseid"];
	mysqli_query($link, "update assignment set VISIBILITY='DELETED' where AID='$courseid'");
	$_SESSION['user_success_message'] = "The assignment has successfully been deleted";
	$userurl='index.php?page=assignments';
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
			<a href="#">Assignments</a>
		</li>
		<li class="active">Manage Assignments</li>
	</ul><!-- /.breadcrumb -->
</div>
<hr>

<div class='row'>
	<div class="col-sm-4">
		<form method='post' action='index.php?page=assignments' enctype='multipart/form-data'>
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">
						<i class="ace-icon fa fa-random"></i>
						Add an Assignment
					</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<div class="control-group">
							<label>Title</label><br>
							<input type="text" name="title" placeholder="Enter Assignment Name" /><br>
							
							<label>Description</label><br>
							<textarea name="description" rows="5" placeholder="Enter Assignment description"></textarea><br>
							
							<label>File</label><br>
							<input type="file" name="photo" /><br>
							
							<label>Due Date</label><br>
							<input type="text" name="duedate" id="datepicker" /><br>
							
							<label>Course</label><br>
							<select name="courseid">
								<?php
								$result=$link->query("SELECT* from  course where ADDEDBY='$activeuserid' AND VISIBILITY='ACTIVE' order by COURSEID DESC");
								if($result->num_rows>0){
									while($row=$result->fetch_assoc()){
									echo "<option value=".$row["COURSEID"].">".$row["NAME"]."</option>";
									}
								}else{}
						
									?>
							</select><br><hr>
						</div>
						<button class="btn btn-primary btn-block">Add assignment</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="col-sm-8">
		<table id="simple-table" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
			<thead>
				<tr>
					<th>Course</th>
					<th>assignment</th>
					<th class="hidden-480">Description</th>
					<th>
						<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
						Added Date
					</th>
					<th class="hidden-480">Status</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$result=$link->query("SELECT assignment.AID,assignment.TITLE,assignment.DUEDATE,assignment.FILE,assignment.ADDEDDATE,assignment.DESCRIPTION,course.NAME from assignment,course WHERE assignment.COURSEID=course.COURSEID AND assignment.VISIBILITY='ACTIVE' AND  assignment.ADDEDBY=$activeuserid order by AID DESC");
				if($result->num_rows>0){
					while($row=$result->fetch_assoc()){
						echo"
							<tr>
								<td>".$row["NAME"]."</td>
								<td>".$row["TITLE"]."</td>
								<td class='hidden-480'>";
									if($row['FILE']==""){}else{echo"<a href='../uploads/".$row["FILE"]."' target='_blank'>Attachment</a><br>";}
										echo $row["DESCRIPTION"]."</td>
								<td class='hidden-480'>
									<span class='label label-sm label-warning'>".date('F j, Y H:i:s',strtotime($row["ADDEDDATE"]))."</span><br><br>
									<b>Due Date:</b> <br>".date('F j, Y',strtotime($row["DUEDATE"]))."
								</td>
								<td>
									<div class='hidden-sm hidden-xs btn-group'>
										<a href='#D".$row["AID"]."' role='button' class='red' data-toggle='modal'> 
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
</div>
<!-----------------------------------------------------------------------
				delete courses
<!----------------------------------------------------------------------->
<?php
$result=$link->query("SELECT assignment.AID,assignment.TITLE,assignment.FILE,assignment.ADDEDDATE,assignment.DESCRIPTION,course.NAME from assignment,course WHERE assignment.COURSEID=course.COURSEID AND assignment.VISIBILITY='ACTIVE' AND assignment.ADDEDBY=$activeuserid order by AID DESC");
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
		echo"
		<div id='D".$row["AID"]."' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header' style='background:red;'>
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							Do you want to delete the assignment (".$row["TITLE"].")?
						</div>
					</div>
					<form method='post' action='index.php?page=assignments' style='padding:20px'>
						<input name='deletecourseid' value='".$row["AID"]."' type='hidden'/>
						
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