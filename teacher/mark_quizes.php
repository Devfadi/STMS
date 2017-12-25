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
if(isset($_POST["SQID"])){
	$SQID=$_POST["SQID"];
	$marks=$_POST["marks"];
	$remarks=$_POST["description"];
	$file='';
	//-------------------------------------------
	//----------------------------------------------

	
	//-------------------------------------------
	mysqli_query($link, "update student_quizes set MARKS='$marks',REMARKS='$remarks' where SQID='$SQID'");
	$_SESSION['user_success_message'] = "The quiz has successfully been marked";
	$userurl='index.php?page=mark_quizes';
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
			<a href="#">Marking</a>
		</li>
		<li class="active">Mark Quizes</li>
	</ul><!-- /.breadcrumb -->
</div>
<hr>

<div class='row'>
	<div class="col-sm-12">
		<table id="simple-table" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
			<thead>
				<tr>
					<th>Course</th>
					<th>Quiz</th>
					<th class="hidden-480">Submittion</th>
					<th>
						<i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
						Submittion Date
					</th>
					<th>Student Name</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$result=$link->query("SELECT student_quizes.TITLE,student_quizes.SQID,student_quizes.MARKS,student_quizes.REMARKS,student_quizes.DESCRIPTION,student_quizes.FILE,student_quizes.SUBMITTIONDATE,course.NAME,quiz.TITLE AS ATITLE,userdata.FIRSTNAME,userdata.LASTNAME from course,userdata,student_quizes,quiz WHERE student_quizes.USERID=userdata.USERID AND student_quizes.QID=quiz.QID AND course.COURSEID=quiz.COURSEID AND quiz.ADDEDBY='$activeuserid'");
				if($result->num_rows>0){
					while($row=$result->fetch_assoc()){
						echo"
							<tr>
								<td>".$row["NAME"]."</td>
								<td>".$row["ATITLE"]."</td>
								<td class='hidden-480'>
									<h3>".$row["TITLE"]."</h3><br>";
									if($row['FILE']==""){}else{echo"<a href='../uploads/".$row["FILE"]."' target='_blank'>Attachment</a><br>";}
										echo $row["DESCRIPTION"]."</td>
								<td>".date('F j, Y H:i:s',strtotime($row["SUBMITTIONDATE"]))."</td>
								<td>".$row["FIRSTNAME"]." ".$row["LASTNAME"]."
								<hr>
								<b>Marks:</b> ".$row["MARKS"]."<br>
								<b>Remarks: </b>".$row["REMARKS"]."</b>
								</td>
								<td>
									<div class='hidden-sm hidden-xs btn-group'>
										<a href='#M".$row["SQID"]."' role='button' class='red' data-toggle='modal' style='font-size:30px;'> 
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
</div>
<!-----------------------------------------------------------------------
				submit an quiz
<!----------------------------------------------------------------------->
<?php
$result=$link->query("SELECT student_quizes.TITLE,student_quizes.SQID,student_quizes.REMARKS,student_quizes.MARKS,student_quizes.SUBMITTIONDATE,course.NAME,quiz.TITLE AS ATITLE,userdata.FIRSTNAME,userdata.LASTNAME from course,userdata,student_quizes,quiz WHERE student_quizes.USERID=userdata.USERID AND student_quizes.QID=quiz.QID AND course.COURSEID=quiz.COURSEID AND quiz.ADDEDBY='$activeuserid'");
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
		echo"
		<div id='M".$row["SQID"]."' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header'>
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							Do you want to mark the quiz (".$row["TITLE"].")?
						</div>
					</div>
					<form method='post' action='index.php?page=mark_quizes'  enctype='multipart/form-data' style='padding:20px'>
						<input name='SQID' value='".$row["SQID"]."' type='hidden'/>
						
						<label>Marks</label><br>
						<input type='text' name='marks' value='".$row["MARKS"]."' placeholder='Enter quiz obtained marks' /><br>
						
						<label>Remarks</label><br>
						<textarea name='description' rows='5' placeholder='Enter quiz remarks'>".$row["REMARKS"]."</textarea><br>
						
						
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