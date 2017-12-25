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

if(isset($_POST['submit_marks'])){
    $cid=$_POST['course_id'];
    $adate=$_POST['click_marks'];
    $result = mysqli_query($link,"select userdata.FIRSTNAME,userdata.LASTNAME,userdata.USERID,course.COURSEID,course.NAME from course,userdata,enrollment WHERE course.COURSEID=enrollment.COURSEID AND userdata.USERID=enrollment.USERID AND enrollment.VISIBILITY='ACTIVE' AND enrollment.STATUS='APPROVED' AND userdata.VISIBILITY='ACTIVE' AND enrollment.COURSEID= $cid ");
    

    while($row = mysqli_fetch_array($result)){
        $userid=$row['USERID'];
        $cid=$row['COURSEID'];
        $quiz=$_POST["quiz".$cid."s".$userid];
        $assignment=$_POST["assignment".$cid."s".$userid];
        $attendance=$_POST["attendance".$cid."s".$userid];
        $mid=$_POST["mid".$cid."s".$userid];
        $final=$_POST["final".$cid."s".$userid];
        $obtained=$_POST["obtained".$cid."s".$userid];
        $total=$_POST["total".$cid."s".$userid];
        $gpa=$_POST["gpa".$cid."s".$userid];

       //--------------------------------
        //check if attendance has already been done, if yes then update
        $result1=$link->query("SELECT* from studentmarks where STUDENTID='$userid' AND CID='$cid'");
        if($result1->num_rows>0){
            while($row1=$result1->fetch_assoc()){
                $smid=$row1['SMID'];
                mysqli_query($link,
                            "update studentmarks set
                             QUIZ='$quiz',
                             ASSIGNMENT='$assignment',
                             ATTENDANCE='$attendance',
                             MID='$mid',
                             FINAL='$final',
                             OBTAINED='$obtained',
                             TOTAL='$total',
                             GPA='$gpa'
                             where SMID='$smid'"                
                );
            }
        }else{
            mysqli_query($link,"insert into studentmarks(STUDENTID,CID,QUIZ,ASSIGNMENT,ATTENDANCE,MID,FINAL,OBTAINED,TOTAL,GPA,ADDEDBY)values('$userid','$cid','$quiz','$assignment','$attendance','$mid','$final','$obtained','$total','$gpa','$activeuserid')");
        }
       //--------------------------------
        
        $userurl='index.php?page=marks';
        echo '<script>window.location = "'.$userurl.'";</script>';
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
			<a href="#">Marks</a>
		</li>
		<li class="active">Manage Marks</li>
	</ul><!-- /.breadcrumb -->
</div>
<hr>

<div class='row'>
	<div class="col-sm-4">
		<form method='post' action='index.php?page=quizes' enctype='multipart/form-data'>
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">
						<i class="ace-icon fa fa-bar-chart-o"></i>
						Select Course
					</h4>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<div class="control-group">
<!--
							<label>Title</label><br>
							<input type="text" name="title" placeholder="Enter Quiz Title" /><br>
							
							<label>Description</label><br>
							<textarea name="description" rows="5" placeholder="Enter Quiz description"></textarea><br>
							
							<label>File</label><br>
							<input type="file" name="photo" /><br>
							
							<label>Due Date</label><br>
							<input type="text" name="duedate" id="datepicker" /><br>
-->
							
							<label>Course</label><br>
							<select name="courseid" onchange="showstudents(this.value)">
							    <option>Course</option>
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
<!--						<button class="btn btn-primary btn-block">Add Quiz</button>-->
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="col-sm-8">
	<form action="index.php?page=marks" method="post">
		<table id="simple-table" class="table table-striped table-bordered table-hover no-margin-bottom no-border-top">
			<thead>
				<tr>
					<th>Name</th>
                    <th>Last Name</th>
					
					
					<th>Quiz<br>Max:5</th>
					<th>Assignment<br>Max:5</th>
					<th>Attendence<br>Max:10</th>
					<th>Mid<br>Max:20</th>
					<th>Final<br>Max:60</th>
					<th>Obtain</th>
					<th>Total<br>Max:100</th>
					<th>GPA<br>Max:4.00</th>
				</tr>
			</thead>
			<tbody id="student-table">
				<input type="submit" name="submit_marks" value="Submit" class="btn btn-primary">
            </tbody>
			</table>
			</form>
	</div>
</div>
<!-----------------------------------------------------------------------
				delete courses
<!----------------------------------------------------------------------->
<?php
$result=$link->query("SELECT quiz.QID,quiz.TITLE,quiz.FILE,quiz.ADDEDDATE,quiz.DESCRIPTION,course.NAME from quiz,course WHERE quiz.COURSEID=course.COURSEID AND quiz.VISIBILITY='ACTIVE' AND quiz.ADDEDBY=$activeuserid order by QID DESC");
if($result->num_rows>0){
	while($row=$result->fetch_assoc()){
		echo"
		<div id='D".$row["QID"]."' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header' style='background:red;'>
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							Do you want to delete the quiz (".$row["TITLE"].")?
						</div>
					</div>
					<form method='post' action='index.php?page=quizes' style='padding:20px'>
						<input name='deletecourseid' value='".$row["QID"]."' type='hidden'/>
						
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
<script>
    
    function showstudents(val){
    
    if(val  == ""){
        
        var op = document.createElement("");
        var t = document.createTextNode("");
        op.appendChild(t);
        document.getElementById("student-table").appendChild(op);
        
        return;
    }
    else{
        
        if(window.XMLHttpRequest){
            
            xmlhttp = new XMLHttpRequest();
        }
        else{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            
            if (this.readyState == 4 && this.status == 200) {
            
                document.getElementById("student-table").innerHTML = this.responseText;
            }
        };
        
        xmlhttp.open("GET","ajax2.php?q="+val,true);
        xmlhttp.send();
    }
}

</script>



<script src='assets/js/jquery.2.1.1.min.js'></script>
<script src='assets/js/bootstrap.min.js'></script>


<script type="text/javascript">
$(document).ready(function()){
          alert('dasdsa');        
    $(".calculate").each(function()){
          //----
      /*  alert('dasdsa');
        var calculate=$(this);
        var quiz=calculate.find($('.quiz')).val();
        var assignment=calculate.find($('.assignment')).val();
        var attendance=calculate.find($('.attendance')).val();
        var mid=calculate.find($('.mid')).val();
        var final=calculate.find($('.final')).val();
        var total=quiz+$assignment+$attendance+mid+final;
        calculate.find($('.obtained')).val($total);
    */
        //------
    /*    $(this).find($('.quiz')).on('change',function()){
                                      alert('ppppppppa');
        var quiz=calculate.find($('.quiz')).val();
        var assignment=calculate.find($('.assignment')).val();
        var attendance=calculate.find($('.attendance')).val();
        var mid=calculate.find($('.mid')).val();
        var final=calculate.find($('.final')).val();
        var total=quiz+$assignment+$attendance+mid+final;
        calculate.find($('.obtained')).val($total);                       }
        */
                         alert('sdas');
    }              
}
                  
</script>
