<?php
session_start();
include 'connection.php';

if (isset($_POST['email'], $_POST['password'])){
$email=$_POST['email'];
$password=md5($_POST['password']);

$sql ="SELECT * FROM userdata WHERE EMAIL='".$email."' AND (PASSWORD='".$password."' OR TEMPASSWORD='".$password."')  AND VISIBILITY='ACTIVE' AND STATUS='ACTIVE' ";
$result = $link->query($sql);
if ($result->num_rows > 0) {
    // echo "YOU'RE SUCCESSFULLY LOGIN";
while($row = $result->fetch_assoc()){
	$_SESSION['activeuserid']=$row["USERID"];
	$_SESSION['account']=$row["ACCOUNT"];
	
	if($row["ACCOUNT"]=="TEACHER" || $row["ACCOUNT"]=="ADMIN"){
		$url='teacher/index.php';
		echo '<script>window.location = "'.$url.'";</script>';
	}elseif($row["ACCOUNT"]=="STUDENT"){
		$url='student/index.php';
		echo '<script>window.location = "'.$url.'";</script>';
	}else{}
}
//..............................................................
	
} //if get information
else{
	$_SESSION["loginfailed"]="*Please enter the right information to access this portal";
	$url='index.php';
	echo '<script>window.location = "'.$url.'";</script>';
exit;
}
}else{
	$_SESSION["loginfailed"]="*Please enter your login information";
	$url='index.php';
	echo '<script>window.location = "'.$url.'";</script>';
}
$link->close();
?>