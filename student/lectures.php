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
if(isset($_POST["SLID"])){
	$SQID=$_POST["SLID"];
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
	mysqli_query($link, "update student_quizes set TITLE='$title',NOTIFICATION='SUBMITTED',DESCRIPTION='$description',FILE='$new_directory',SUBMITTIONDATE='$currenttime' where SQID='$SQID'");
	$_SESSION['user_success_message'] = "The quiz has successfully been uploaded";
	$userurl='index.php?page=quizes';
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
			<a href="#">Quizes</a>
		</li>
		<li class="active">Manage Quizes</li>
	</ul><!-- /.breadcrumb -->
</div>
<hr>

<div class='row'>
	<div class="col-sm-12">
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
				</tr>
			</thead>
			<tbody>
				<?php
				$result=$link->query("
							SELECT
								course.NAME AS CNAME,
								lecture.FILE,
								lecture.TITLE,
								lecture.DESCRIPTION,
								lecture.ADDEDDATE
							FROM
								enrollment,
								course,
								lecture,
								userdata
							WHERE
								enrollment.COURSEID = course.COURSEID && lecture.COURSEID = course.COURSEID && userdata.USERID = enrollment.USERID && userdata.USERID='$activeuserid'");
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
									<span class='label label-sm label-warning'>".date('F j, Y H:i:s',strtotime($row["ADDEDDATE"]))."
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

