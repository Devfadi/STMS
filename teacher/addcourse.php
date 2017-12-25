<?php	
include '../connection.php';

if(isset($_POST["attendance"]))
{
    $auid = $_POST["student_id"];
    $status  = $_POST["status"];
    $query = mysqli_query($link, "UPDATE `attendance` SET `STATUS`='$status' WHERE `AID`='$auid'");
}



//--------------------------------------------
//			add course
//--------------------------------------------
if(isset($_POST["coursename"])){
    $name=$_POST["coursename"];
    $description=$_POST["coursedescription"];

    mysqli_query($link, "insert into course(NAME,DESCRIPTION,ADDEDBY,ADDEDDATE)values('$name','$description','$activeuserid','$currenttime')");
    $_SESSION['user_success_message'] = "A course has successfully been added";
    $userurl='index.php?page=add_course';
    echo '<script>window.location = "'.$userurl.'";</script>';
}else{}
//--------------------------------------------
//			edit course
//--------------------------------------------
if(isset($_POST["editcourseid"])){
    $courseid=$_POST["editcourseid"];
    $name=$_POST["name"];
    $description=$_POST["description"];

    mysqli_query($link, "update course set NAME='$name',DESCRIPTION='$description' where COURSEID='$courseid'");
    $_SESSION['user_success_message'] = "A course has successfully been updated";
    $userurl='index.php?page=add_course';
    //echo '<script>window.location = "'.$userurl.'";</script>';
}else{}
//--------------------------------------------
//			delete course
//--------------------------------------------
if(isset($_POST["deletecourseid"])){
    $courseid=$_POST["deletecourseid"];
    mysqli_query($link, "update course set VISIBILITY='DELETED' where COURSEID='$courseid'");
    $_SESSION['user_success_message'] = "A course has successfully been deleted";
    $userurl='index.php?page=add_course';
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
        <li class="active">Manage Courses</li>
    </ul><!-- /.breadcrumb -->
</div>
<hr>

<div class='row'>
    <div class="col-sm-4">
        <form method='post' action='index.php?page=add_course'>
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">
                        <i class="ace-icon fa fa-book"></i>
                        Add a Course
                    </h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="control-group">
                            <label for="colorpicker1">Course Name</label><br>
                            <input type="text" name="coursename" placeholder="Enter Course Name" /><br><br>

                            <label for="colorpicker1">Course Description</label><br>
                            <textarea name="coursedescription" rows="5" placeholder="Enter Course description"></textarea><br><br>
                        </div>
                        <button class="btn btn-primary btn-block">Add a Course</button>
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
                $result=$link->query("SELECT* from  course where ADDEDBY='$activeuserid' AND VISIBILITY='ACTIVE' order by COURSEID DESC");
                if($result->num_rows>0){
                    while($row=$result->fetch_assoc()){
                        echo"
							<tr>
								<td>".$row["NAME"]."</td>
								<td class='hidden-480'>".$row["DESCRIPTION"]."</td>
								<td class='hidden-480'>
									<span class='label label-sm label-warning'>".date('F j, Y H:i:s',strtotime($row["ADDEDDATE"]))."</span>
								</td>
								<td>
									<div class='hidden-sm hidden-xs btn-group'>
										<a href='#E".$row["COURSEID"]."' role='button' class='blue' data-toggle='modal'> 
											<i class='ace-icon fa fa-pencil bigger-120'></i>
										</a>

										<a href='#D".$row["COURSEID"]."' role='button' class='red' data-toggle='modal'> 
											<i class='ace-icon fa fa-trash bigger-120'></i>
										</a>
                                        <a href='#SHOW".$row["COURSEID"]."' role='button' class='green' data-toggle='modal' title='Full Attendence'> 
											<i class='ace-icon fa fa-barcode bigger-120'></i>
										</a>
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
edit courses
<!----------------------------------------------------------------------->
<?php
$result=$link->query("SELECT* from  course where ADDEDBY='$activeuserid' AND VISIBILITY='ACTIVE' order by COURSEID DESC");
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
							Do you want to edit the course (".$row["NAME"].")?
						</div>
					</div>
					<form method='post' action='index.php?page=add_course' style='padding:20px'>
						<input name='editcourseid' value='".$row["COURSEID"]."' type='hidden'/>
						<div class='row'>
							<div class='col-sm-12' align=''>
								<label><b> Course Name </b></label>
								<input name='name' type='text' value='".$row["NAME"]."'> <br><br>
								<label><b> Description</b></label><br>
								<textarea name='description'> ".$row["DESCRIPTION"]."</textarea><br><br>
							</div>
						</div>
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
delete courses
<!----------------------------------------------------------------------->
<?php
$result=$link->query("SELECT* from  course where ADDEDBY='$activeuserid' AND VISIBILITY='ACTIVE' order by COURSEID DESC");
if($result->num_rows>0){
    while($row=$result->fetch_assoc()){
        echo"
		<div id='D".$row["COURSEID"]."' class='modal fade' tabindex='-1'>
			<div class='modal-dialog'>
				<div class='modal-content'>
					<div class='modal-header no-padding'>
						<div class='table-header' style='background:red;'>
							<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
								<span class='white'>&times;</span>
							</button>
							Do you want to delete the course (".$row["NAME"].")?
						</div>
					</div>
					<form method='post' action='index.php?page=add_course' style='padding:20px'>
						<input name='deletecourseid' value='".$row["COURSEID"]."' type='hidden'/>

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
$result=$link->query("select enrollment.EID,enrollment.STATUS,course.COURSEID,userdata.FIRSTNAME,userdata.LASTNAME,course.NAME,course.DESCRIPTION,enrollment.ADDEDDATE FROM userdata,course,enrollment WHERE userdata.USERID=course.ADDEDBY AND enrollment.COURSEID=course.COURSEID AND enrollment.VISIBILITY='ACTIVE' AND course.VISIBILITY='ACTIVE' AND userdata.VISIBILITY='ACTIVE'  order by enrollment.STATUS");
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
        $resultcheck=$link->query("SELECT
    attendance.AID,
    userdata.USERID,
    userdata.FIRSTNAME,
    userdata.LASTNAME,
    attendance.ADATE,
    attendance.STATUS,
    course.NAME
FROM
    attendance,
    course,
    userdata
WHERE
    attendance.USERID = userdata.USERID AND attendance.CID = course.COURSEID AND attendance.ADDEDBY =".$_SESSION['activeuserid']." AND course.COURSEID = '$courseid'");
        if($resultcheck->num_rows>0){
            echo"<table class='table table-striped table-bordered table-hover no-margin-bottom no-border-top'>
                                <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Date</th>
                                <th> Status</th>
                                </tr>
                                ";
            while($rowcheck=$resultcheck->fetch_assoc()){
                echo"<tr>
                                    <td>".$rowcheck['FIRSTNAME']."</td>
                                    <td>".$rowcheck['LASTNAME']."</td>
                                    <td>".date('F j, Y',strtotime($rowcheck["ADATE"]))."</td>
                                    <td>".$rowcheck["STATUS"]." &nbsp &nbsp <a href='#E".$row["COURSEID"]."' role='button' class='blue' data-toggle='modal'>
                                    </a>
                                        <div>
											
                                            <form></form>
                                            <i href='#' class='ace-icon fa fa-pencil bigger-120'  data-toggle='collapse' data-target='#2'>
                                            
                                            <form action='' method='post' id='2'>
                                            <input type='hidden' name='student_id' value='".$rowcheck["AID"]."'/>
                                                P<input type='radio' name='status' value='P'>
                                                A<input type='radio' name='status' value='A'>
                                                <input type='submit' name='attendance' value='update'>
                                            </form>
                                            </i>
										</div></td>
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
Edit Status
<!----------------------------------------------------------------------->