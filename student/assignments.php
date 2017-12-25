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
if(isset($_POST["said"])){
	$said=$_POST["said"];
	$title=$_POST["title"];
	$description=$_POST["description"];
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
	mysqli_query($link, "update student_assignments set TITLE='$title',NOTIFICATION='SUBMITTED',DESCRIPTION='$description',FILE='$new_directory',SUBMITTIONDATE='$currenttime' where SAID='$said'");
	$_SESSION['user_success_message'] = "The assignment has successfully been uploaded";
	$userurl='index.php?page=assignments';
	//echo '<script>window.location = "'.$userurl.'";</script>';
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
	<div class="col-sm-12">
		<table id="simple-table" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
			<thead>
				<tr>
					<th>Course</th>
					<th>Assignment</th>
					<th class="hidden-480">Description</th>
					<th>
						<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
						Added Date
					</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$result=$link->query("select student_assignments.MARKS,student_assignments.REMARKS,NOTIFICATION,student_assignments.SAID,assignment.FILE,assignment.DUEDATE,assignment.TITLE,assignment.DESCRIPTION,assignment.ADDEDDATE,course.NAME AS CNAME from assignment,student_assignments,course where assignment.COURSEID=course.COURSEID AND assignment.AID=student_assignments.AID  AND student_assignments.USERID='$activeuserid' order by student_assignments.SAID DESC");
				if($result->num_rows>0){
					while($row=$result->fetch_assoc()){
						echo"
							<tr>
								<td>".$row["CNAME"]."</td>
								<td>".$row["TITLE"]."</td>
								<td class='hidden-480'>";
									if($row['FILE']==""){}else{echo"<a href='../uploads/".$row["FILE"]."' target='_blank'>Attachment</a><br>";}
										echo $row["DESCRIPTION"]."</td>
								<td>
									<span class='label label-sm label-warning'>".date('F j, Y H:i:s',strtotime($row["ADDEDDATE"]))."</span><br><br>
									<b>Due Date:</b> <br>".date('F j, Y',strtotime($row["DUEDATE"]))."
								</td>
								<td>".$row["NOTIFICATION"]." <hr>".$row["MARKS"]."<br>".$row["REMARKS"]."</td>
								<td>
									<div class='hidden-sm hidden-xs btn-group'>";
                    $date =date('Y-m-d'); if($date > $row['DUEDATE']){
                                        echo "<a href='#S".$row["SAID"]."' role='button' class='btn disabled' style='font-size:30px;'> 
											<i class='ace-icon fa fa-floppy-o bigger-120'></i>
										</a>";   
                                        }
                        else
                        {	echo "<a href='#S".$row["SAID"]."' role='button' class='btn btn-primary' data-toggle='modal' style='font-size:30px;'> 
											<i class='ace-icon fa fa-floppy-o bigger-120'></i>
										</a>
									</div>
								</td>
							</tr>
						";}
					}
				}else{}
				?>
				
			</table>
	</div>
</div>
<!-----------------------------------------------------------------------
				submit an assignment
<!----------------------------------------------------------------------->
<?php
$result=$link->query("select student_assignments.SAID,student_assignments.TITLE AS STITLE,student_assignments.DESCRIPTION AS SDESCRIPTION,student_assignments.FILE AS SFILE,assignment.FILE,assignment.DUEDATE,assignment.TITLE,assignment.DESCRIPTION,assignment.ADDEDDATE from assignment,student_assignments where assignment.AID=student_assignments.AID AND student_assignments.USERID='$activeuserid'");
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
		echo"
		<div id='S".$row["SAID"]."' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					
					<form method='post' action='index.php?page=assignments'  enctype='multipart/form-data' style='padding:20px'>
						<input name='said' value='".$row["SAID"]."' type='hidden'/>
						
						<label>Title</label><br>
						<input type='text' name='title' value='".$row["STITLE"]."' placeholder='Enter Assignment Name' /><br>
						
						<label>Description</label><br>
						<textarea name='description' rows='5' placeholder='Enter Assignment description'>".$row["SDESCRIPTION"]."</textarea><br>
						
						<label>File</label><br>
						<input type='file' name='photo' />";
						if($row["FILE"]==""){
						}else{
							echo "<a href='../uploads/".$row["SFILE"]."' target='-blank'>Attachment</a>";
						}echo"
								
							<hr>
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