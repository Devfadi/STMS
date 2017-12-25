<?php

if(isset($_POST["attendance"]))
{
    $auid = $_POST["student_id"];
    $status  = $_POST["status"];
    echo $auid;
    $query = mysqli_query($link, "UPDATE `attendance` SET `STATUS`='$status' WHERE `AID`='$auid'");
}
?>