<?php
require 'app/model/connection.php';

class studentFunct {

    public function __construct() {
        $this->conn = new Connection;
        $this->conn = $this->conn->connect();
    }

    public function getSchoolYear(){
        $query = $this->conn->prepare("SELECT school_year 'sy' FROM student join accounts ac on student.accc_id = ac.acc_id where ac.acc_id = ? group by 1");
        $query->bindParam(1, $_SESSION['accid']);
        $query->execute();
        $rowCount = $query->fetch();
        $rowCount1 = $rowCount['sy'] + 1;
        echo " " . $rowCount['sy'] . "-" . $rowCount1 . " ";
    }

    public function getLRNOfStud(){
        $query = $this->conn->prepare("SELECT  
            stud_lrno
            FROM
            student st
            JOIN 
            accounts on accounts.acc_id = st.accc_id
            WHERE
            accounts.acc_id = " . $_SESSION['accid'] . "" );
        $query->execute();
        if ($query->rowCount() > 0) {
            foreach ($query->fetchAll() as $result) {
                echo '<span class="wlrno" data-lrno="'.$result['stud_lrno'].'">'.$result['stud_lrno'].'</span>';
            }
        } else {
            echo '';
        }
    }

    /************** DASHBOARD **********************/

    public function getStatus() {
      $query = $this->conn->prepare("SELECT * from student join accounts on accc_id = acc_id join section on secc_id = sec_id where acc_id = :id");
      $query->execute(array(
        ':id' => $_SESSION['accid']
      ));
      $getRowCount = $query->rowCount();
      while($row = $query->fetch()) {
        $status = $row['stud_status'];
        $attendancelink = URL.'student-attendance';
        echo "<div class='contin'>
        <p>".$row['stud_status']." in this school year: <span class='text-bold'> ".$row['school_year']."</span></p>
        <p>Grade ".$row['grade_lvl']." - ".$row["sec_name"]."</p>
        <p>See <a href='$attendancelink'>absences/tardiness!</a></p>
        </div> ";
    }
}
  public function getCurrentStatusofStudentLoggedin() {
        $search = $this->conn->prepare("SELECT stud_status, school_year FROM student JOIN accounts ON acc_id = accc_id WHERE acc_id = :accid");
        $search->execute(array(
            ':accid' => $_SESSION['accid']
        ));
        $result = $search->fetch();
        return array($result['stud_status'], $result['school_year']);
    }

public function getNotifCount() {
    $query = $this->conn->prepare("SELECT * from notification");
    $query->execute(); 
    $count = $query->rowCount();
    echo $count;
}

public function getAnnouncement() {
    $query1 = $this->conn->prepare("SELECT secc_id from student join accounts ac on student.accc_id = ac.acc_id where ac.acc_id = ?");
    $query1->bindParam(1, $_SESSION['accid']);
    $query1->execute(); 
    $secc_id = $query1->fetch();
    $query = $this->conn->prepare("SELECT 
        title,
        post,
        CONCAT(adm_fname, ' ', adm_midname) 'name',
        attachment
        FROM
        announcements ann
        JOIN
        admin ON ann.post_adminid = admin.admin_id
        WHERE
        view_lim = '0' 
        UNION SELECT 
        title,
        post,
        CONCAT(fac_fname, ' ', fac_lname) 'name',
        attachment
        FROM
        announcements ann
        JOIN
        faculty ON faculty.fac_id = ann.post_facid
        JOIN
        schedsubj ss ON ss.fw_id = faculty.fac_id
        JOIN
        section ON ss.sw_id = sec_id
        JOIN
        student ON student.secc_id = ann.gr_sec
        JOIN
        accounts ON acc_id = accc_id
        WHERE
        view_lim LIKE '%3%' AND gr_sec = ?
        AND accc_id = ?");
    $query->bindParam(1, $_SESSION['accid']);
    $query->bindParam(2, $secc_id);
    $query->execute(); 
    $result = $query->fetchAll();
    $count = $query->rowCount();
    if($count > 0){
        foreach ($result as $row) {
            $html =
            '<div id="announcements">';
            $html .=
            '<h2 class="title">'.$row['title'].'</h2>
            <p class="description">'.$row['post'].'</p>
            <p class="description">'.$row['name'].'</p>';

            $html .= $row['attachment'] !== null ? '<p>View - <a href="public/letter/'.$row['attachment'].'" view>attachment</a></p>' : '';
            $html .= '</div>';
            echo $html;
        }
    }else {
        echo "<p>No announcements</p>";
    }
}

public function getPerformance(){
    $query = $this->conn->prepare("SELECT 
        gr_level, average, rank
        FROM
        rank
        JOIN
        student ON student.stud_id = rank.stud_idf
        JOIN
        accounts ON student.accc_id = accounts.acc_id
        WHERE
        accounts.acc_id = ?
        ORDER BY gr_level ");
    $query->bindParam(1,$_SESSION['accid']);
    $query->execute();
    $getRowNum = $query->rowCount();
    if($getRowNum > 0){
        echo "<table>
        <tr>
        <th>Grade Level</th>
        <th>Average</th>
        <th>Rank</th>
        </tr>";
        while($row = $query->fetch()){
            echo "
            <tr>
            <td><span>Grade ".$row['gr_level']."</span></td>
            <td><span> ".$row['average']." </span></td>
            <td><span>".$row['rank']."</span></td>
            </tr>";
        }
        echo "</table>";
    }
}



/************** ATTENDANCE **********************/
public function studAttendance(){
  $query = $this->conn->prepare("SELECT att_id, remarks, att_attachment, date_format(att_date, '%M %d, %Y') as 'att_date', type, subject.subj_name, remarks, att_remarks, apply_reason FROM attendance att JOIN student stud ON stud.stud_id = att.stud_ida JOIN subject ON subject.subj_id = att.subjatt_id JOIN accounts acc ON stud.accc_id = acc.acc_id where acc.acc_id = ? AND stud_status IN ('Officially Enrolled', 'Temporarily Enrolled') ORDER BY 4") or die("failed!");
  $query->bindParam(1, $_SESSION['accid']);
  $query->execute();
  if($query->rowCount()>0){
        while($r = $query->fetch(PDO::FETCH_ASSOC)){
               $data[]=$r;
        }
         return $data;
     }else{
        echo '<td colspan="7"><p><b>No late/absences!</b></p></td>';
    }
    return $query;       
 }

 public function getLate(){
    $query = $this->conn->prepare("SELECT COUNT(type) as att_type FROM attendance att JOIN student stud ON stud.stud_id = att.stud_ida JOIN subject ON subject.subj_id = att.subjatt_id JOIN accounts acc ON stud.accc_id = acc.acc_id where acc.acc_id = ? and type = 'Late' AND stud_status IN ('Officially Enrolled', 'Temporarily Enrolled')");
    $query->bindParam(1, $_SESSION['accid']);
    $query->execute();
    $rowCount=$query->fetch();
        echo " ". $rowCount['att_type']. " ";
}
public function getAbsent(){
    $query = $this->conn->prepare("SELECT COUNT(type) AS att_type FROM attendance att JOIN student stud ON stud.stud_id = att.stud_ida JOIN subject ON subject.subj_id = att.subjatt_id JOIN accounts acc ON stud.accc_id = acc.acc_id where acc.acc_id = ? and type = 'Absent' AND stud_status IN ('Officially Enrolled', 'Temporarily Enrolled')");
    $query->bindParam(1, $_SESSION['accid']);
    $query->execute();
    $rowCount=$query->fetch();
        echo " ". $rowCount['att_type']. " ";
}
    
public function applyReason($att_id, $remarks, $attachment){
        if(!empty($attachment['name'])) {           
            $file = $attachment['name'];
            $size = $attachment['size'];
            $temp = $attachment['tmp_name'];
            $path = "public/letter/".$file; //set upload folder path
        
            if(!file_exists($path)){
                if($size < 10000000){
                    $sql2= $this->conn->prepare("SELECT * from attendance WHERE att_id =:att_id ");
                    $sql2->execute(array(
                        ':att_id' => $att_id
                    )); 
                    $row=$sql2->fetch(PDO::FETCH_ASSOC);
                    $id=$row['att_id'];
                    $fileToDel = trim(strval($row['att_attachment']));
                    $new_path = realpath('public/letter/'.$fileToDel);
                    @unlink($new_path);
                    /*move_uploaded_file($temp, $path); */
                    
                    $temp2 = $attachment['tmp_name'];
                    $staticValue="attachment";
                    $path = "public/letter/";
                    
                    $underScore="_";
                    $tmp = explode('.', $file);
                    $ext = end($tmp);
                    $filename = "$staticValue$underScore$id.".$ext;
                        $newname = $path.$filename;
                        move_uploaded_file($temp2, $newname);
                        $sql3 = $this->conn->prepare("UPDATE attendance SET remarks=:remarks, att_attachment=:att_attachment, apply_reason ='Student' WHERE att_id=:att_id");
                    if($sql3->execute(array(
                        ':remarks' => $remarks,
                        ':att_attachment' => $filename,
                        ':att_id' => $id
                    ))){
                    $this->alert("Success!", "Successfully updated the reason", "success", "student-attendance");
                }else{
                    $this->alert("Error!", "Failed! Check file size (maximum of 10 mb)", "error", "student-attendance");
                }
             }
        }
    } else{
         $sql2= $this->conn->prepare("SELECT * from attendance WHERE att_id =:att_id ");
                    $sql2->execute(array(
                        ':att_id' => $att_id
                    )); 
                    $row=$sql2->fetch(PDO::FETCH_ASSOC);
                    $id=$row['att_id'];
        $sql3 = $this->conn->prepare("UPDATE attendance SET remarks=:remarks, att_attachment=:att_attachment, apply_reason ='Student' WHERE att_id=:att_id");
                    if($sql3->execute(array(
                        ':remarks' => $remarks,
                        ':att_attachment' => null,
                        ':att_id' => $id
                    ))){
        $this->alert("Success!", "Successfully updated the reason", "success", "student-attendance");
    } else{
            $this->alert("Error!", "Cannot update the reason!", "error", "student-attendance");
        }
    }
    } 
    


public function deleteAttachment($att_id){
     try {
            $sql1= $this->conn->prepare('SELECT att_attachment FROM attendance WHERE att_id =:att_id');
            $sql1->execute(array(':att_id' => $att_id));   
            $row=$sql1->fetch(PDO::FETCH_ASSOC);
            $file = $row['att_attachment'];
            $dir = "public/letter/".$file;
            chmod($dir, 0777);
            @unlink($dir);
            $sql2=$this->conn->prepare("UPDATE attendance SET att_attachment = NULL WHERE att_id=:att_id");
            if($sql2->execute(array(
                ':att_id' => $att_id
            ))){
                $this->alert("Success!", "The attachment has been deleted", "success", "student-attendance");
            }else{  
                $this->alert("Error!", "Failed to delete attachment", "error", "student-attendance");
            }
        } catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
}

/************** Statements of Account **********************/
public function getBalance() {
  $query = $this->conn->prepare("SELECT * from balance join student on balance.stud_idb = student.stud_id join accounts on student.accc_id = accounts.acc_id where accounts.acc_id = ? and stud_status in ('Officially Enrolled','Temporarily Enrolled') and bal_status = 'Not Cleared'");
  $query->bindParam(1, $_SESSION['accid']);
  $query->execute();
  $getRowCount = $query->rowCount();
  $today = date("F d, Y");
  if ($getRowCount > 0) {
      while($row = $query->fetch()) {
         echo "Balance: <b> &#x20B1; ".number_format($row['bal_amt'], 2)."</b> as of ".$today." ";
     }
 }else{
    echo "";
 }
}

public function getPaymentHisto() {
    $query = $this->conn->prepare("SELECT date_format(p.pay_date, '%M %d, %Y') as 'pay_date', SUM(p.pay_amt) as 'amt_paid', date_format(p.pay_date, '%Y') 'year'  from balance b join payment p on p.balb_id = b.bal_id join student s on b.stud_idb = s.stud_id join accounts a on s.accc_id = a.acc_id where a.acc_id = :acc_id and stud_status in ('Officially Enrolled','Temporarily Enrolled')
    GROUP by p.orno");
    $query->execute(array(":acc_id" => $_SESSION['accid']));
    $getRowCount = $query->rowCount();
    if ($getRowCount > 0) {
        while($row = $query->fetch()) {
            echo "<tr>
            <td>" . $row[0] . "</td>
            <td class='align-right'>&nbsp;" . number_format($row[1], 2) . "</td>
            <td>" . $row[2] . "</td>
            </tr>";
        }       
    }  
}


public function getTotal(){
    $query = $this->conn->prepare("SELECT sum(p.pay_amt) as 'total', date_format(p.pay_date, '%Y') 'year' from balance b join payment p on p.balb_id = b.bal_id join student s on b.stud_idb = s.stud_id join accounts a on s.accc_id = a.acc_id where a.acc_id = :acc_id GROUP by 2");
    $query->execute(array(":acc_id" => $_SESSION['accid']));
    $row = $query->fetchAll();
    echo '<tr> 
    <td class="bold total">Total</td>
    <td class="bold total align-right" colspan ="2">
    ';
    foreach($row as $result){
    $total = $result['total'];
    echo '<span class="year" data-year=\''.$result['year'].'\'>&#8369;&nbsp;'.number_format($total, 2).'</span>';
    }
    echo"</td></tr>";
}

public function getBreakdown() {
  $query= $this->conn->prepare("SELECT budget_name, total_amount from budget_info join student join accounts on acc_id = accc_id WHERE stud_status IN ('Officially Enrolled','Temporarily Enrolled') and acc_id = ? group by 1");
  $query->bindParam(1, $_SESSION['accid']);
  $query->execute();
  $getRowCount = $query->rowCount();
  $array = array();
  if($getRowCount > 0){
    while($row = $query->fetchAll()){
      for($c = 0; $c < count($row); $c++){
        $budgetAmount = $row[$c]['total_amount'];
        $budgetName = $row[$c]['budget_name'];
        array_push($array, $budgetAmount);
        echo '<tr>
        <td>'.$budgetName.'</td>
        <td class="align-right">&nbsp;'.number_format($budgetAmount, 2).'</td>
        </tr>';
}
    $total = array_sum($array);
    echo '<tr><td class="bold total">Total</td><td class="bold total align-right">&#8369;&nbsp;'.number_format($total, 2).'</td></tr>';
}
}else{
    echo '<tr><td colspan="2">Not yet available</td></tr>';
}
}

public function getPayYear() {
    $query= $this->conn->prepare("SELECT 
    DATE_FORMAT(pay_date, '%Y') AS 'year'
FROM
    balance
        JOIN
    student ON balance.stud_idb = student.stud_id
        JOIN
    payment ON payment.balb_id = balance.bal_id
        JOIN
    accounts ON student.accc_id = accounts.acc_id
WHERE
    accounts.acc_id = ?
    group by 1 order by 1 desc");
    $query->bindParam(1, $_SESSION['accid']);
    $query->execute();
    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    return $query->rowCount() > 0 ? $data : false;
}

public function filterPaymentYear() {
        $query = $this->conn->prepare("SELECT
            DISTINCT(DATE_FORMAT(DATE(pay_date), '%Y'))
            FROM
            payment pm
            JOIN
            balance bal ON pm.balb_id = bal.bal_id
            JOIN
            student st ON st.stud_id = bal.stud_idb
            JOIN
            guardian pr ON st.guar_id = pr.guar_id
            WHERE
            pr.acc_idx = '" . $_SESSION['accid'] . "' GROUP by pm.orno");
        $query->execute();
        $rowCount = $query->rowCount();
        foreach($query->fetchAll() as $row) {
            echo '<option value="'.$row[0].'">'.$row[0].'</option>';
        }
    }

public function getChildGrade($id){
    /*******************Get subject name******************CASE WHEN subj_name LIKE ('%Music%') OR subj_name LIKE ('%(PE)%') OR subj_name LIKE ('%Physical Education%') OR subj_name LIKE ('%Health%') OR subj_name LIKE ('%Arts%') THEN (CASE WHEN subj_level = '7' THEN 'MAPEH 1' WHEN subj_level = '8' THEN 'MAPEH 2' WHEN subj_level = '9' THEN 'MAPEH 3' WHEN subj_level = '10' THEN 'MAPEH 4' ELSE 'MAPEH' END) ELSE subj_name END AS subject, subj_dept, GROUP BY subj_dept */
    $query = $this->conn->prepare("SELECT subj_name
        FROM
            schedsubj ss
                JOIN
            section sec ON ss.sw_id = sec.sec_id
                JOIN
            student st ON st.secc_id = sec.sec_id
                JOIN
            subject sub ON sub.subj_id = ss.schedsubjb_id 
            join accounts ac on ac.acc_id = st.accc_id
            where accc_id = :acc_id AND 
            stud_status IN ('Officially Enrolled','Temporarily Enrolled')");
          $query->execute(array(
            ":acc_id" => $_SESSION['accid']
            ));
        $subjects = $query->fetchAll();
        $acc_id  = $id; //sample
        /*$rowCount1 = $query1->rowCount();*/
        
        /*******************Get student grade*******************/
        for ($c = 0; $c < count($subjects); $c++) {
            $subject_name = $subjects[$c]['subj_name'];
            $first        = $this->getGrade($acc_id, $subject_name, '1st');
            $second       = $this->getGrade($acc_id, $subject_name, '2nd');
            $third        = $this->getGrade($acc_id, $subject_name, '3rd');
            $fourth       = $this->getGrade($acc_id, $subject_name, '4th');
            $fourth       = (($fourth === null || $fourth === '') ? 0 : $fourth);
            $average      = round(($first + $second + $third + $fourth) / 4);
            // $remarks = $this->getRemarks($average);
            echo '<tr>';
            echo '<td>' . $subject_name . '</td>';
            echo $first === 0 ? '<td></td>' : '<td>' . $first . '</td>';
            echo $second === 0 ? '<td></td>' : '<td>' . $second . '</td>';
            echo $third === 0 ? '<td></td>' : '<td>' . $third . '</td>';
            echo $fourth === 0 ? '<td></td>' : '<td>' . $fourth . '</td>';
            
            if ($first === 0 || $second === 0 || $third === 0 || $fourth === 0) {
                echo '<td></td>';
            } else if ($first === 0 || $second === 0 || $third === 0 || $fourth === 0 || $average === 0){     
                echo '<td></td>';
            } else {
                echo '<td>' . $average . '</td>';
            }

                if ($average === 0) {
                    echo '<td></td>
                    <td></td>';
                } else if ($average < 75) {
                    $checker = $this->getGrade($acc_id, $subject_name, '4th');
                    if ($checker === null || $checker === '') {
                        echo '<td><font color="orange"><b>INC</b></font></td>';
                            echo '
                                <td class="details">
                                    <div name="content">
                                        <button class="customButton" name="opener" onclick="">
                                            <div class="tooltip">
                                                <i class="fas fa-edit"></i>
                                                    <span class="tooltiptext">View Details</span>
                                            </div>
                                        </button>
                                        <div name="dialog" title="Details for Incomplete Mark">
                                        <center><span><font color="red" size="5">Incomplete Requirements for this subject.<br> Please consult your adviser/teacher.</font><span></center>
                                        </div>
                                    </div>
                                </td>
                                ';
                    } else if ($fourth !== 0) {
                        echo '<td><font color="red"><b>Failed</b></font></td>';
                        echo '<td></td>';
                    } else {
                        echo '<td></td>';
                        echo '<td></td>';
                    }
                } else if ($average >= 75){
                    echo '<td><font color="green"><b>Passed</b></font></td>';
                    echo '<td></td>';   
                }
                echo '</tr>'; 
    }
}

    private function getGrade($acc_id, $subject, $grading)
    {
        $query = $this->conn->prepare("SELECT  CONCAT(first_name, ' ', last_name) 'Student', grade, subj_name 'subject', grading FROM grades JOIN student ON grades.studd_id = student.stud_id JOIN facsec fs ON grades.secd_id = fs.sec_idy JOIN schedsubj ss ON (grades.facd_id = ss.fw_id && grades.secd_id = ss.sw_id) JOIN subject ON (ss.schedsubjb_id = subject.subj_id && grades.subj_ide = subject.subj_id) JOIN accounts ac ON student.accc_id = ac.acc_id WHERE ac.acc_id = :acc_id AND subj_name = :subject AND grading = :grading GROUP BY 2 ORDER BY 3");
        $query->execute(array(
            ':acc_id' => $acc_id,
            ':subject' => $subject,
            ':grading' => $grading
        ));
        $result = $query->fetch();
        return $query->rowCount() > 0 ? $result['grade'] : 0;
    }

    public function getGeneralAverage(){
        $query = $this->conn->prepare("SELECT ROUND(SUM(average)/4,2) General_Average from 
                    (SELECT CONCAT(first_name, ' ', last_name) 'Student',
                        ROUND(avg(grade),2) as average,
                        grading
                    FROM
                        grades
                            JOIN
                        student ON grades.studd_id = student.stud_id
                            JOIN
                        facsec fs ON grades.secd_id = fs.sec_idy
                            JOIN
                        schedsubj ss ON (grades.facd_id = ss.fw_id
                            && grades.secd_id = ss.sw_id)
                            JOIN
                        subject ON (ss.schedsubjb_id = subject.subj_id
                            && grades.subj_ide = subject.subj_id)
                            JOIN
                        accounts ac ON student.accc_id = ac.acc_id
                    WHERE
                        ac.acc_id = :accid
                    AND stud_status IN ('Officially Enrolled','Temporarily Enrolled')
                    GROUP BY 3
                    ORDER BY 3) t1");
        $query->execute(array(
            ':accid' => $_SESSION['accid']
        ));
        $row = $query->fetch();

        $studSubj = $this->conn->prepare("SELECT  * FROM schedsubj ss JOIN subject ON schedsubjb_id = subj_id JOIN section ON sw_id = sec_id JOIN student ON secc_id = sw_id JOIN accounts ON accc_id = acc_id WHERE acc_id = :accid");
        $studSubj->execute(array(
            ':accid' => $_SESSION['accid'] 
        ));
        $studGrid = $this->conn->prepare("SELECT * FROM accounts JOIN student on acc_id = accc_id JOIN grades ON stud_id = studd_id WHERE acc_id = :accid GROUP BY subj_ide");
        $studGrid->execute(array(
            ':accid' => $_SESSION['accid']
        ));

        $checkIfPassedAll = $this->conn->prepare("SELECT * FROM accounts JOIN student on acc_id = accc_id JOIN grades on stud_id = studd_id WHERE grading = '4th' AND acc_id = :accid AND remarks = 'Failed' GROUP BY subj_ide");
        $checkIfPassedAll->execute(array(':accid' => $_SESSION['accid']));


        /*echo '<span class="wlrno" data-lrno="'.$lrno.'">'.$row[0].'</span>';*/
        if ($studSubj->rowCount() === $studGrid->rowCount()) {
            if ($row[0] === null) {
                echo '<td colspan="3">Not yet available</td>';
            } else {
                echo '<td>' . $row[0] . '</td>';
            }
            if ($checkIfPassedAll->rowCount() > 0) {
                echo '<td></td>';
            } else if ($row[0] != null && $row[0] >= 75) {
                echo '<td colspan="2"><font color="green"><b>Passed</b></font></td>';
            } else if ($row[0] != null && $row[0] < 75) {
                echo '<td colspan="2"><font color="red"><b>Failed</b></font></td>';
            }
        } else {
            echo '<td colspan="5">Not yet available</td>';
        }
    }

    public function getPromotion(){
        $query = $this->conn->prepare("SELECT ROUND(SUM(average)/4,2) General_Average from 
                    (SELECT CONCAT(first_name, ' ', last_name) 'Student',
                        ROUND(avg(grade),2) as average,
                        grading
                    FROM
                        grades
                            JOIN
                        student ON grades.studd_id = student.stud_id
                            JOIN
                        facsec fs ON grades.secd_id = fs.sec_idy
                            JOIN
                        schedsubj ss ON (grades.facd_id = ss.fw_id
                            && grades.secd_id = ss.sw_id)
                            JOIN
                        subject ON (ss.schedsubjb_id = subject.subj_id
                            && grades.subj_ide = subject.subj_id)
                            JOIN
                        accounts ac ON student.accc_id = ac.acc_id
                    WHERE
                        ac.acc_id = :accid
                    AND stud_status IN ('Officially Enrolled','Temporarily Enrolled')
                    GROUP BY 3
                    ORDER BY 3) t1");
        $query->execute(array(
            ':accid' => $_SESSION['accid']
        ));
        $row = $query->fetch();

        $studSubj = $this->conn->prepare("SELECT  * FROM schedsubj ss JOIN subject ON schedsubjb_id = subj_id JOIN section ON sw_id = sec_id JOIN student ON secc_id = sw_id JOIN accounts ON accc_id = acc_id WHERE acc_id = :accid");
        $studSubj->execute(array(
            ':accid' => $_SESSION['accid']
        ));
        $studGrid = $this->conn->prepare("SELECT * FROM accounts JOIN student on acc_id = accc_id JOIN grades ON stud_id = studd_id WHERE acc_id = :accid GROUP BY subj_ide");
        $studGrid->execute(array(
            ':accid' => $_SESSION['accid']
        ));
        /*echo '<span class="wlrno" data-lrno="'.$lrno.'">'.$row[0].'</span>';*/
        if ($studSubj->rowCount() === $studGrid->rowCount()) {
            $checkIfPassedAll = $this->conn->prepare("SELECT * FROM accounts JOIN student on acc_id = accc_id JOIN grades on stud_id = studd_id WHERE grading = '4th' AND acc_id = :accid AND remarks = 'Failed' GROUP BY subj_ide");
            $checkIfPassedAll->execute(array(':accid' => $_SESSION['accid']));

             if ($row[0] === null) {
                 echo '<td colspan="5">Not yet available</td>';
            } else if ($checkIfPassedAll->rowCount() > 0) {
                echo '<td style="text-align: center;" colspan="5"><span style="color: rgb(255, 0, 0);">Failure to pass some of subjects.</span><br> Please consult your adviser for summer term to finish failed subjects.</td>';         
            } else if ($row[0] >= 75){
                echo '<td colspan="5"><b>Promoted to next grade level</b></td>';
            }
        } else {
            echo '<td colspan="5">Not yet available</td>';
        }

    }

    public function getTranscript() {
        $checkYear = $this->conn->prepare("SELECT * FROM accounts JOIN student ON acc_id = accc_id JOIN transcript_archive ON stud_id = tt_stud WHERE acc_id = :accid GROUP BY sy_grades");
        $checkYear->execute(array(
            ':accid' => $_SESSION['accid']
        ));
        if ($checkYear->rowCount() > 0) {
            foreach($checkYear->fetchAll() as $res) {
                $yr = (int) $res['sy_grades'] - 1;
                echo '<tr><td colspan="3" class="text-left font-weight-bold">School Year: '.$yr.' - '.$res['sy_grades'].'</td></tr>';
                $query = $this->conn->prepare("SELECT * FROM accounts JOIN student ON acc_id = accc_id JOIN transcript_archive ON stud_id = tt_stud WHERE acc_id = :accid AND sy_grades = :sy");
                $query->execute(array(
                    ':accid' => $_SESSION['accid'],
                    ':sy' => $res['sy_grades']
                ));
                foreach($query->fetchAll() as $row) {
                    echo '<tr>';
                    echo '<td>'.$row['subject'].'</td>';
                    echo '<td>'.$row['grade'].'</td>';
                    echo '<td>'.$row['trans_remarks'].'</td>';
                    echo '</tr>';
                }
            }
        } else {
            echo '<tr><td colspan=3>There are no data yet.</td></tr>';
        }
    }

    public function getAllYearsHistory() {
        $query = $this->conn->prepare("SELECT * FROM accounts JOIN student ON acc_id = accc_id JOIN transcript_archive ON stud_id = tt_stud WHERE acc_id = :accid GROUP BY sy_grades");
        $query->execute(array(
            ':accid' => $_SESSION['accid']
        ));
        foreach($query->fetchAll() as $row) {
            echo '<option value="'.$row['sy_grades'].'">'.$row['sy_grades'].'</option>';
        }
    }


    public function getCV($id){
        $query = $this->conn->prepare("SELECT cv_name FROM core_values");
        $query->execute();
        $cv_name = $query->fetchAll();
        $acc_id  = $id;
        $query2 = $this->conn->prepare("SELECT stud_status from student join accounts where accc_id = :acc_id");
        $query->execute(array(
            ":acc_id" => $_SESSION['accid']
            ));
        $stud_status = $query->fetchAll();
        
            for ($c = 0; $c < count($cv_name); $c++) {
                $cvname = $cv_name[$c]['cv_name'];
                $first        = $this->getCVGrade($acc_id, $cvname, '1st');
                $second       = $this->getCVGrade($acc_id, $cvname, '2nd');
                $third        = $this->getCVGrade($acc_id, $cvname, '3rd');
                $fourth       = $this->getCVGrade($acc_id, $cvname, '4th');

                echo '<tr>';
                echo '<td style="font-weight: 700;">' . $cvname . '</td>';
                echo $first === 0 ? '<td></td>' : '<td>' . $first . '</td>';
                echo $second === 0 ? '<td></td>' : '<td>' . $second . '</td>';
                echo $third === 0 ? '<td></td>' : '<td>' . $third . '</td>';
                echo $fourth === 0 ? '<td></td>' : '<td>' . $fourth . '</td>';
                echo '</tr>';
        
   }
}

    
    private function getCVGrade($acc_id, $cvname, $bhv_grading)
    {
        $query = $this->conn->prepare("SELECT 
            bhv_remarks, core_values.cv_name, bhv_grading
            FROM
            behavior
            JOIN
            student ON behavior.stud_idy = student.stud_id
            JOIN
            core_values ON behavior.core_values = core_values.cv_id
            join accounts ac on ac.acc_id = student.accc_id
            WHERE student.stud_status IN ('Officially Enrolled', 'Temporarily Enrolled') AND ac.acc_id = :acc_id AND core_values.cv_name = :cvname AND bhv_grading = :bhv_grading GROUP BY 1 ORDER BY 3");
        $query->execute(array(
            ':acc_id' => $acc_id,
            ':cvname' => $cvname,
            ':bhv_grading' => $bhv_grading
        ));
        $result = $query->fetch();
        return $query->rowCount() > 0 ? $result['bhv_remarks'] : 0;
    }

    public function getSchedule($accid) {
        $querySchedule = $this->conn->prepare("SELECT 
            '09:40:00' AS 'time_start',
            '10:00:00' AS 'time_end',
            'RECESS' AS subj_name,
            '' AS 'stud_sec',
            '' AS 'facultyname',
            'RECESS' AS 'subject'

            UNION SELECT 
            '12:00:00' AS 'time_start',
            '13:00:00' AS 'time_end',
            'LUNCH' AS subj_name,
            '' AS 'stud_sec',
            '' AS 'facultyname',
            'LUNCH' AS 'subject'

            UNION SELECT 
            time_start,
            time_end,
            subj_name,
            CONCAT('G', year_level, ' - ', sec_name) AS 'stud_sec',
            CONCAT(fac_fname,
            ' ',
            fac_midname,
            ' ',
            fac_lname) AS 'facultyname',
            CASE WHEN subj_name LIKE ('%Music%') OR subj_name LIKE ('%(PE)%') OR subj_name LIKE ('%Physical Education%') OR subj_name LIKE ('%Health%') OR subj_name LIKE ('%Arts%') THEN (CASE WHEN subj_level = '7' THEN 'MAPEH 1' WHEN subj_level = '8' THEN 'MAPEH 2' WHEN subj_level = '9' THEN 'MAPEH 3' WHEN subj_level = '10' THEN 'MAPEH 4' ELSE 'MAPEH' END) ELSE subj_name END 'subject'
            FROM
            schedsubj ss
            JOIN
            subject ON ss.schedsubjb_id = subject.subj_id
            JOIN
            facsec fs ON (fs.fac_idy = ss.fw_id
            && fs.sec_idy = ss.sw_id)
            JOIN
            faculty ON fac_idy = fac_id
            JOIN
            section ON fs.sec_idy = section.sec_id
            JOIN
            student ON secc_id = sec_id
            JOIN
            accounts ON acc_idz = acc_id
            WHERE
            sec_id = (SELECT 
            sec_id
            FROM
            section
            JOIN
            student ON section.sec_id = student.secc_id
            JOIN
            schedsubj ss ON ss.sw_id = student.secc_id
            JOIN
            subject ON subject.subj_id = ss.schedsubjb_id
            JOIN
            accounts ON accounts.acc_id = student.accc_id
            WHERE
            acc_id = ?
            GROUP BY 1)
            GROUP BY time_start
            order by 1") or die ("FAILED");
        $querySchedule->bindParam(1, $_SESSION['accid']);
        $querySchedule->execute();
        $result = $querySchedule->fetchAll();
        $time_start = array('07:40:00', '08:40:00', '09:40:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00');
        $time_end = array('08:40:00', '09:40:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00');


        for ($c = 0; $c < count($time_start); $c++) {
            echo '<tr>';
            $subj_name = '';
            $faculty = '';
            $new_time_start = date('h:i A', strtotime($time_start[$c]));
            $new_time_end = date('h:i A', strtotime($time_end[$c]));
            foreach($result as $row) {
                if ($time_start[$c] == $row['time_start']) {
                    $subj_name = $row['subject'];
                    $faculty = $row['facultyname'];
                }
            }
            echo '<td>'.$new_time_start.' - '.$new_time_end.' Daily</td>';
            echo '<td colspan="5">'.($subj_name  !== '' ? '<div>'.$subj_name.'<br>'.$faculty.'</div>' : 'Unassigned').'</td>';
            echo '</tr>';
        }
        
    }
    /****************************STUDENT INFORMATION*******************************/
    public function studGeneralInfo(){
        $query = $this->conn->prepare("SELECT stud_lrno,
            gender,
            CONCAT(MONTHNAME(stud_bday),
            ' ',
            DAY(stud_bday)) AS 'Birthday',
            stud_address,
            Ethnicity,
            nationality,
            blood_type,
            medical_stat
            FROM
            accounts
            JOIN
            student ON acc_id = accc_id
            JOIN
            guardian g ON student.guar_id = g.guar_id
            WHERE
            accounts.acc_id =?");
        
        $query->bindParam(1, $_SESSION['accid']);
        $query->execute();
        $getRowCount = $query->rowCount();
        if ($getRowCount > 0) {
            while($row = $query->fetch()) {
                echo '
                <div class="continue">
                <form>
                <label for="lrnfield"><span>LRN:</span><input type="text" name="" value="'.$row['stud_lrno'].'"disabled></label>
                <label for="sexfield"><span>Gender:</span><input type="text" name="" value="'.$row['gender'].'"disabled></label>
                <label for="religion"><span>Ethnicity:</span><input type="text" name="" value="'.$row['Ethnicity'].'" disabled></label>
                <label for="nationality"><span>Nationality:</span><input type="text" name="" value="'.$row['nationality'].'" disabled></label>
                <label for="nationality"><span>Blood Type:</span><input type="text" name="" value="'.$row['blood_type'].'" disabled></label>
                <label for="nationality"><span>Medical Condition:</span><input type="text" name="" value="'.$row['medical_stat'].'" disabled></label>
                <br>
                <br>
                </form>
                </div>
                ';
            }
        } else {
            echo '
            <div class="continue">
            <form>             
            <label for="birthday"><span>Birthday:</span><input type="text" name="" value="" disabled></label>
            <label for="religion"><span>Religion:</span><input type="text" name="" value="" disabled></label>
            <label for="nationality"><span>Nationality:</span><input type="text" name="" value="" disabled></label>
            <label for="nationality"><span>Blood Type:</span><input type="text" name="" value="" disabled></label>
            <label for="nationality"><span>Medical Condition:</span><input type="text" name="" value="" disabled></label>
            </form>
            </div>
            ';
        }
    }

    public function studContactInfo() { 
        $query = $this->conn->prepare("SELECT 
            stud_address,
            CONCAT(g.guar_fname,
            ' ',
            g.guar_midname,
            ' ',
            g.guar_lname) AS guardian,
            g.guar_mobno,
            mother_name,
            father_name
            FROM
            accounts
            JOIN
            student ON acc_id = accc_id
            JOIN
            guardian g ON student.guar_id = g.guar_id
            WHERE
            accounts.acc_id =?");
        
        $query->bindParam(1, $_SESSION['accid']);
        $query->execute();
        $getRowCount = $query->rowCount();
        if ($getRowCount > 0) {
            while($row = $query->fetch()) {
                echo '
                <div class="continue">
                <form>
                <label for="address"><span>Address:</span><input type="text" name="" value="'.$row['stud_address'].'" disabled></label>
                <label for="fname"><span>Father Name:</span><input type="text" name="" value="'.$row['father_name'].'" disabled></label>
                <label for="mname"><span>Mother Name:</span><input type="text" name="" value="'.$row['mother_name'].'" disabled></label>
                <label for="guardian"><span>Guardian:</span><input type="text" name="" value="'.$row['guardian'].'" disabled></label>
                <label for="cpno"><span>Cellphone Number:</span><input type="text" name="" value="'.$row['guar_mobno'].'" disabled></label>
                <br>
                <br>
                </form>
                </div>    
                ';
            }
            } else { echo '
            <div class="continue">
            <form>
            <label for="address"><span>Address:</span><input type="text" name="" value="" disabled></label>
            <label for="fname"><span>Father Name:</span><input type="text" name="" value="" disabled></labelf>
            <label for="mname"><span>Mother Name:</span><input type="text" name="" value="" disabled></label>
            <label for="guardian"><span>Guardian:</span><input type="text" name="" value="" disabled></label>
            <label for="telno"><span>Telephone Number:</span><input type="text" name="" value="" disabled></label>
            <label for="cpno"><span>Cellphone Number:</span><input type="text" name="" value="" disabled></label>
            <br>
            <br>
            </form>
            </div>
            ';
        }

    }

    public function getName() { 
        $query = $this->conn->prepare("SELECT concat(first_name,' ', left(middle_name, 1), '.', ' ', last_name) as Name from accounts join student on acc_id = accc_id where accounts.acc_id=?");
        
        $query->bindParam(1, $_SESSION['accid']);
        $query->execute();
        $getRowCount = $query->rowCount();
        if ($getRowCount > 0) {
            while($row = $query->fetch()) {
                echo ' '.$row['Name'].' ';
            }

        }
    }

    public function getAccountInfo() { 
        $query = $this->conn->prepare("SELECT username, concat(first_name, ' ', left(middle_name,1), '.', ' ', last_name) as Name, year_in from accounts join student on acc_id = accc_id where accounts.acc_id=?");
        $query->bindParam(1, $_SESSION['accid']);
        $query->execute();
        $getRowCount = $query->rowCount();
        if ($getRowCount > 0) {
            while($row = $query->fetch()) {
                echo ' <div class="continue">
                <form>             
                <label for="username"><span>Username:</span><input type="text" name="" value="'.$row['username'].'"disabled></label> 
                <label for="accountName"><span>Account Name:</span><input type="text" name="" value="'.$row['Name'].'" disabled></label>
                <label for="dateRegistered"><span>Year entered:</span><input type="text" name="" value="'.$row['year_in'].'" disabled></label>
                </form>
                </div> ';
            }

        }
    }

    public function changePassword($currentPass, $newPass, $retypePass){ 
        $query = $this->conn->prepare("select password from accounts where acc_id = ?");
        $userid = $_SESSION['accid'];
        $query->bindParam(1, $userid);
        $query->execute(); 
        $row = $query->fetch();
        if(password_verify($currentPass, $row['password']) and ($newPass == $retypePass) and ($currentPass!=$newPass)){
            $queryUpdate = $this->conn->prepare("UPDATE accounts SET password =? WHERE acc_id=?");
            $newPassword = password_hash($newPass, PASSWORD_DEFAULT);
            $queryUpdate->bindParam(1, $newPassword);
            $queryUpdate->bindParam(2, $userid);
            $queryUpdate->execute();

            if($queryUpdate){
                echo "<script type='text/javascript'>alert('Password has been changed successfully!');</script>";
            }else{
                echo "<script type='text/javascript'>alert('Change password failed');</script>";
            }
        }else{
            echo "<script type='text/javascript'>alert('Change password failed');</script>";
        }
    }

    public function showHolidays(){
        $admin_id = $_SESSION['accid'];
        $sql = $this->conn->prepare("SELECT ann_id, title, DATE_FORMAT(date(date_start), '%M %e') as date_start_1,  DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end_1, DAY(CURDATE()), DAY(date_start) FROM announcements WHERE (view_lim like '%3%' or view_lim like '%0%') AND title IS NOT NULL AND holiday='Yes' AND (date_start between now() and adddate(now(), +15))") or die ("failed!");
        $sql->bindParam(1, $admin_id);
        $sql->execute();
        if($sql->rowCount()>0){
            while($r = $sql->fetch(PDO::FETCH_ASSOC)){
                $data[]=$r;
            }
            return $data;
        }
        return $sql;
    }   

    public function getAnnouncements() {
        $sql = $this->conn->prepare("SELECT * FROM announcements join student where post IS NOT NULL and stud_status IN ('Officially Enrolled','Temporarily Enrolled') group by ann_id") or die ("failed!");
        $sql->execute();
        $result = $sql->fetchAll();
        foreach($result as $row) {
            $query = $this->conn->prepare("SELECT *, CONCAT(fac_fname,' ',SUBSTRING(fac_midname,1,1),'. ',fac_lname) as 'f_name' FROM faculty WHERE fac_id = :id");
            $query->execute(array(
                ':id' => $row['post_facid']
            ));
            $queryR = $query->fetch();
            $html = '<tr>';
            $html .= '<td class="tleft custPad2 longText">';
            if ($queryR['f_name'] === NULL || !isset($queryR['f_name'])) {
                $html .= '<h3 class="att_title" style="text-align: left;">'.$row['post'].'</h3>';
            } else {
                $html .= '<h3 class="att_title" style="text-align: left;">'.$row['post'].' - '.$queryR['f_name'].'</h3>';
            }
            $html .= $row['attachment'] !== null ? '<p class="tright attachment"><a href="public/attachment/'.$row['attachment'].'" view">View attachment</a></p>' : '';
            $html .= '</td>';
            $html .= '</tr>';
            echo $html;
        }
    }

    public function showEvents(){
        $sql = $this->conn->prepare("SELECT ann_id, title, DATE_FORMAT(date(date_start), '%M %e, %Y') as date_start_1, DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end_1, date_start, date_end, post, view_lim, attachment FROM announcements JOIN student JOIN accounts WHERE title IS NOT NULL AND holiday='No' AND stud_status IN ('Officially Enrolled','Temporarily Enrolled') AND acc_id = ? GROUP BY 1") or die ("failed!");
        $sql->bindParam(1, $_SESSION['accid']);
        $sql->execute();
        if($sql->rowCount()>0){
            while($r = $sql->fetch(PDO::FETCH_ASSOC)){
                $data[]=$r;
            }
            return $data;
        }
        return $sql;
    }

    public function alert($title, $message, $type, $page) {
        $newUrl = URL.$page;
        echo "<script>
            swal({
                title: \"".$title."\",
                text: \"".$message."\",
                icon: \"".$type."\"
            }).then(function() {
                 window.location = '".$newUrl."';
            });
        </script>";
    }

}
?>