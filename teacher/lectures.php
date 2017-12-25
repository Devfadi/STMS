<?php	
include '../connection.php';
//--------------------------------------------
//			add course
//--------------------------------------------
if(isset($_POST["title"])){
	$title=$_POST["title"];
	$description=$_POST["description"];
	$courseid=$_POST["courseid"];
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
	if($imageFileType != "jpg" && $imageFileType != "ppt"&& $imageFileType != "png"&& $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "pdf" && $imageFileType != "docx" && $imageFileType != "xlxs" && $imageFileType != "txt"
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
	mysqli_query($link, "insert into lecture(TITLE,DESCRIPTION,FILE,COURSEID,ADDEDDATE,ADDEDBY)values('$title','$description','$new_directory','$courseid','$currenttime','$activeuserid')");
	$_SESSION['user_success_message'] = "The lecture has successfully been added";
	$userurl='index.php?page=lectures';
	echo '<script>window.location = "'.$userurl.'";</script>';
}else{}
//--------------------------------------------
//			delete course
//--------------------------------------------
if(isset($_POST["deletecourseid"])){
	$courseid=$_POST["deletecourseid"];
	mysqli_query($link, "update lecture set VISIBILITY='DELETED' where LID='$courseid'");
	$_SESSION['user_success_message'] = "The lecture has successfully been deleted";
	$userurl='index.php?page=lectures';
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
			<a href="#">Lectures</a>
		</li>
		<li class="active">Manage Lectures</li>
	</ul><!-- /.breadcrumb -->
</div>
<hr>

<div class='row'>
	<div class="col-sm-4">
		<form method='post' action='index.php?page=lectures' enctype='multipart/form-data'>
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">
						<i class="ace-icon fa fa-hdd-o"></i>
						Add a Lecture
					</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<div class="control-group">
							<label>Title</label><br>
							<input type="text" name="title" placeholder="Enter Course Name" /><br>
							
							<label>Description</label><br>
							<textarea name="description" rows="5" placeholder="Enter Course description"></textarea><br>
							
							<label>File</label><br>
							<input type="file" name="photo" /><br>
							
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
						<button class="btn btn-primary btn-block">Add Lecture</button>
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
					<th>Lecture</th>
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
				$result=$link->query("SELECT lecture.LID,lecture.TITLE,lecture.FILE,lecture.ADDEDDATE,lecture.DESCRIPTION,course.NAME from lecture,course WHERE lecture.COURSEID=course.COURSEID AND lecture.VISIBILITY='ACTIVE' AND  lecture.ADDEDBY=$activeuserid order by LID DESC");
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
									<span class='label label-sm label-warning'>".date('F j, Y H:i:s',strtotime($row["ADDEDDATE"]))."</span>
								</td>
								<td>
									<div class='hidden-sm hidden-xs btn-group'>
										<a href='#D".$row["LID"]."' role='button' class='red' data-toggle='modal'> 
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
$result=$link->query("SELECT lecture.LID,lecture.TITLE,lecture.FILE,lecture.ADDEDDATE,lecture.DESCRIPTION,course.NAME from lecture,course WHERE lecture.COURSEID=course.COURSEID AND lecture.VISIBILITY='ACTIVE' AND lecture.ADDEDBY=$activeuserid order by LID DESC");
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
		echo"
		<div id='D".$row["LID"]."' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header' style='background:red;'>
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							Do you want to delete the lecture (".$row["TITLE"].")?
						</div>
					</div>
					<form method='post' action='index.php?page=lectures' style='padding:20px'>
						<input name='deletecourseid' value='".$row["LID"]."' type='hidden'/>
						
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