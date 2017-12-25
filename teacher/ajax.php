<input name='mark_attendance' type='hidden' value="<?php echo date('Y-m-d');?>"/>
<input name='course_id' type='hidden' value="<?php echo $_GET['q'];?>"/>
<?php 

include '../connection.php';
$id = $_GET['q'];

$result = mysqli_query($link,"select userdata.FIRSTNAME,userdata.LASTNAME,userdata.USERID,course.COURSEID,course.NAME from course,userdata,enrollment WHERE course.COURSEID=enrollment.COURSEID AND userdata.USERID=enrollment.USERID AND enrollment.VISIBILITY='ACTIVE' AND enrollment.STATUS='APPROVED' AND userdata.VISIBILITY='ACTIVE' AND enrollment.COURSEID= $id ");
    

while($row = mysqli_fetch_array($result)){

    $courseid=$row['COURSEID'];
    $userid=$row['USERID'];
    $key=$courseid."s".$userid;
    echo '<tr>
    
                <td>'.$row['FIRSTNAME'].'</td>
                <td>'.$row['LASTNAME'].'</td>
                <td><input type="radio" value="P" name="'.$key.'" checked="checked"></td>
                <td><input type="radio" value="A" name="'.$key.'"></td>
                <td><input type="radio" value="L" name="'.$key.'"></td>
                
                
                
    
    
            </tr>';
    
}



?>