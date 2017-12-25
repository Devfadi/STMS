<input name='click_marks' type='hidden' value="<?php echo date('Y-m-d');?>"/>
<input name='course_id' type='hidden' value="<?php echo $_GET['q'];?>"/>
<?php 

include '../connection.php';
$id = $_GET['q'];

$result = mysqli_query($link,"select userdata.FIRSTNAME,userdata.LASTNAME,userdata.USERID,course.COURSEID,course.NAME from course,userdata,enrollment WHERE course.COURSEID=enrollment.COURSEID AND userdata.USERID=enrollment.USERID AND enrollment.VISIBILITY='ACTIVE' AND enrollment.STATUS='APPROVED' AND userdata.VISIBILITY='ACTIVE' AND enrollment.COURSEID= $id ");
    

while($row = mysqli_fetch_array($result)){
    
    $courseid=$row['COURSEID'];
    $userid=$row['USERID'];
    $key=$courseid."s".$userid;
    //---------------------------------
    
    $resulte=$link->query("SELECT* from  studentmarks where STUDENTID='$userid' AND CID='$courseid'");
    if($resulte->num_rows>0){
      while($rowe=$resulte->fetch_assoc()){
            $quiz=$rowe['QUIZ'];
            $assignment=$rowe['ASSIGNMENT'];
            $attendance=$rowe['ATTENDANCE'];
            $mid=$rowe['MID'];
            $final=$rowe['FINAL'];
            $obtained=$rowe['OBTAINED'];
            $total=$rowe['TOTAL'];
            $gpa=$rowe['GPA'];
      }
    }else{
         $quiz=$assignment=$attendance=$mid=$final=$obtained=$total=$gpa=0;
    }
    //---------------------------------
    echo '<tr class="calculate">
    
                <td>'.$row['FIRSTNAME'].'</td>
                <td>'.$row['LASTNAME'].'</td>
                <td>
                <input class="quiz" value='.$quiz.' type="text" name="quiz'.$key.'">
                </td>
                <td><input class="assignment" value='.$assignment.' type="text" name="assignment'.$key.'"></td>
                
                <td><input  class="attendance" value='.$attendance.' type="text" name="attendance'.$key.'"></td>
                
                <td><input class="mid" value='.$mid.' type="text" name="mid'.$key.'"></td>
                
                <td><input class="final" value='.$final.' type="text" name="final'.$key.'"></td>
                
                <td><input class="obtained"  value='.$obtained.' type="text" name="obtained'.$key.'"></td>
                    
                
                <td><input class="total"  value="100" type="text" name="total'.$key.'" readonly></td>
                <td><input class="gpa" value='.$gpa.' type="text" name="gpa'.$key.'"></td>
                
                
                
    
    
            </tr>';
    
}
?>