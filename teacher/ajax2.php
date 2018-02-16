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
                <input class="quiz marks" value='.$quiz.' type="number" name="quiz'.$key.'" min="0" max="5" onchange="calculate_marks(this)">
                </td>
                <td><input class="assignment marks" value='.$assignment.' type="number" name="assignment'.$key.'" min="0" max="5" onchange="calculate_marks(this)"></td>
                
                <td><input  class="attendance marks" value='.$attendance.' type="number" name="attendance'.$key.'" min=0" max="10" onchange="calculate_marks(this)"></td>
                
                <td><input class="mid marks" value='.$mid.' type="number" name="mid'.$key.'" min="0" max="20"  onchange="calculate_marks(this)"></td>
                
                <td><input class="final marks" value='.$final.' type="number" name="final'.$key.'" min="0" max="60" onchange="calculate_marks(this)"></td>
                
                <td><input class="obtained"  value='.$obtained.' type="number" name="obtained'.$key.'" readonly></td>
                    
                
                <td><input class="total"  value="100" type="number" name="total'.$key.'" readonly></td>
                <td><input class="gpa" value='.$gpa.' type="number" name="gpa'.$key.'" step="0.01"></td>
                
                
                
    
    
            </tr>';
    
}
?>
