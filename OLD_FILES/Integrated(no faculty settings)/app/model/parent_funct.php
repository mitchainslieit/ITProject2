<?php
require 'app/model/connection.php';
class ParentFunct
{
    
    public function __construct()
    {
        $this->conn = new Connection;
        $this->conn = $this->conn->connect();
    }

    /************** PROFILE PAGE **********************/
    
    public function getWholeName()
    {
        $query = $this->conn->prepare("SELECT CONCAT(guar_fname, ' ',guar_midname, ' ', guar_lname) as 'Name' FROM guardian WHERE acc_idx = " . $_SESSION['accid'] . "");
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0) {
            while ($row = $query->fetch()) {
                echo " 
                <td> " . $row[0] . " </td> 
                ";
            }
        }
    }
    
    public function getUsername()
    {
        $query = $this->conn->prepare("SELECT username FROM accounts WHERE acc_id = " . $_SESSION['accid'] . "");
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0) {
            while ($row = $query->fetch()) {
                echo " 
                <td> " . $row[0] . " </td> 
                ";
            }
        }
    }
    
    public function getPosition()
    {
        $query = $this->conn->prepare("SELECT acc_type FROM accounts WHERE acc_id = " . $_SESSION['accid'] . "");
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0) {
            while ($row = $query->fetch()) {
                echo " 
                <td> " . $row[0] . " </td> 
                ";
            }
        }
    }

    /************** DASHBOARD PAGE **********************/

    public function getAnnouncements()
    {
        $admin_id = $_SESSION['accid'];
        $sql = $this->conn->prepare("SELECT * FROM announcements WHERE (view_lim like '%2%' or view_lim='0') AND post IS NOT NULL") or die("failed!");
        $sql->bindParam(1, $admin_id);
        $sql->execute();
        $result = $sql->fetchAll();
        foreach ($result as $row) {
            $html = '<tr>';
            $html .= '<td class="tleft custPad2 longText">';
            $html .= '<h3 class="att_title">' . $row['post'] . '</h3>';
            $html .= $row['attachment'] !== null ? '<p class="tright attachment"><a href="public/letter/' . $row['attachment'] . '" download">Download Attachment</a></p>' : '';
            $html .= '</td>';
            $html .= '</tr>';
            echo $html;
        }
    }
    
    public function showEvents()
    {
        $admin_id = $_SESSION['accid'];
        $sql = $this->conn->prepare("SELECT ann_id, title, DATE_FORMAT(date(date_start), '%M %e, %Y') as date_start_1, DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end_1, date_start, date_end, post, view_lim, attachment FROM announcements WHERE (view_lim like '%2%' or view_lim='0') AND title IS NOT NULL AND holiday='No'") or die("failed!");
        $sql->bindParam(1, $admin_id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            while ($r = $sql->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $r;
            }
            return $data;
        }
        return $sql;
    }
    
    public function showHolidays()
    {
        $admin_id = $_SESSION['accid'];
        $sql = $this->conn->prepare("SELECT ann_id, title, DATE_FORMAT(date(date_start), '%M %e') as date_start_1,  DATE_FORMAT(date(date_end), '%M %e, %Y') as date_end_1, DAY(CURDATE()), DAY(date_start) FROM announcements WHERE (view_lim like '%2%' or view_lim='0') AND title IS NOT NULL AND holiday='Yes' AND (MONTH(date_start)=MONTH(CURDATE()) AND DAY(date_start) >= DAY(CURDATE()));") or die("failed!");
        $sql->bindParam(1, $admin_id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            while ($r = $sql->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $r;
            }
            return $data;
        }
        return $sql;
    }
    

    /************** STATEMENT OF ACCOUNTS PAGE **********************/

    /*********Filter School Year*********/
    public function getYears($lrno)
    {
        $query = $this->conn->prepare("SELECT 
            DATE_FORMAT(DATE(pay_date), '%Y')
            FROM
            payment pm
            JOIN
            balance bal ON pm.balb_id = bal.bal_id
            JOIN
            student st ON st.stud_id = bal.stud_idb
            JOIN
            guardian pr ON st.guar_id = pr.guar_id
            WHERE
            pr.acc_idx = '" . $_SESSION['accid'] . "' AND st.stud_lrno='" . $lrno . "'");
        $query->execute();
        $rowCount = $query->rowCount();
        
    }
    
    public function filterPaymentYear()
    {
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
        foreach ($query->fetchAll() as $row) {
            echo '<option value="' . $row[0] . '">' . $row[0] . '</option>';
        }
    }
    public function getSchoolYear()
    {
        $query = $this->conn->prepare("SELECT school_year 'sy' FROM student group by 1");
        $query->execute();
        $rowCount  = $query->fetch();
        $rowCount1 = $rowCount['sy'] + 1;
        echo " " . $rowCount['sy'] . "-" . $rowCount1 . " ";
    }

    /*********Miscellaneous Fees*********/
    
    public function getMiscellaneousFee()
    {
        $query = $this->conn->prepare("SELECT FORMAT(sum(total_amount), 2) from budget_info");
        $query->execute();
        $rowCount = $query->fetch();
        if ($rowCount > 0){
            return "&#x20B1;  " . $rowCount[0] . " ";
        }
    }
    
    public function getBalance()
    {
        $query = $this->conn->prepare("SELECT 
            bal_amt, stud_lrno
            FROM
            balance
            JOIN
            student ON stud_idb = stud_id
            JOIN
            guardian gr ON gr.guar_id = student.guar_id
            WHERE
            student.stud_id = student.stud_id
            AND gr.acc_idx = '" . $_SESSION['accid'] . "'
            AND stud_status IN ('Officially Enrolled', 'Temporarily Enrolled')
            AND bal_status = 'Not Cleared' 
            UNION SELECT 
            CASE
            WHEN
            stud_id IN (SELECT 
            stud_idb
            FROM
            payment
            JOIN
            balance ON balb_id = bal_id)
            THEN
            (SELECT 
            bal_amt
            FROM
            balance
            JOIN
            payment ON payment.balb_id = balance.bal_id
            JOIN
            student st ON balance.stud_idb = st.stud_id
            JOIN
            guardian pr ON st.guar_id = pr.guar_id
            WHERE
            st.stud_id = stu.stud_id
            GROUP BY 1)
            WHEN
            stud_id NOT IN (SELECT 
            stud_idb
            FROM
            payment
            JOIN
            balance ON balb_id = bal_id)
            THEN
            (SELECT 
            bal_amt
            FROM
            balance
            JOIN
            student ON stud_idb = stud_id
            JOIN
            guardian gr ON gr.guar_id = student.guar_id
            WHERE
            student.stud_id = stu.stud_id)
            END 'bal_amt',
            stud_lrno
            FROM
            balance
            JOIN
            payment ON payment.balb_id = balance.bal_id
            JOIN
            student stu ON balance.stud_idb = stu.stud_id
            JOIN
            guardian pr ON stu.guar_id = pr.guar_id
            JOIN
            accounts ac ON ac.acc_id = pr.acc_idx
            WHERE
            pr.acc_idx = '" . $_SESSION['accid'] . "'
            AND stud_status IN ('Officially Enrolled','Temporarily Enrolled')
            AND bal_status = 'Not Cleared'
            GROUP BY 2");
        $query->execute();
        $rowCount = $query->rowCount();
        $today    = date("F d, Y");
        if ($rowCount > 0) {
            while ($row = $query->fetch()) {
                echo "<span class=\"wlrno\"data-lrno=\"" . $row['stud_lrno'] . "\">&#x20B1; " . number_format($row['bal_amt'], 2) . " as of " . $today . "</span>";
            }
        } else {
            echo "<span class=\"wlrno\"data-lrno=\"" . $row['stud_lrno'] . "\">&#x20B1; No balance yet.</span>";
        }
    }
    
    public function getPaymentHistory()
    {
        $query = $this->conn->prepare("SELECT 
            DATE_FORMAT(DATE(pay_date), '%M %e, %Y'), 
            FORMAT(sum(pay_amt), 2),
            stud_lrno,
            DATE_FORMAT(DATE(pay_date), '%Y')
            FROM
            payment pm
            JOIN
            balance bal ON pm.balb_id = bal.bal_id
            JOIN
            student st ON st.stud_id = bal.stud_idb
            JOIN
            guardian pr ON st.guar_id = pr.guar_id
            WHERE
            pr.acc_idx = '" . $_SESSION['accid'] . "'
            and stud_status IN ('Officially Enrolled','Temporarily Enrolled') GROUP by pm.orno");
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0) {
            while ($row = $query->fetch()) {
                echo "
                <tr>
                <td>" . $row[0] . "</td>
                <td>" . $row[1] . "</td>
                <td>" . $row[2] . "</td>
                <td>" . $row[3] . "</td>
                </tr>";
            }
        }
    }

    public function getBreakdownOfFees()
    {
        $query = $this->conn->prepare("SELECT budget_name, FORMAT(total_amount, 2) FROM budget_info");
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0)
            while ($row = $query->fetch()) {
                echo "<tr>
            <td> " . $row[0] . "</td>
            <td> " . $row[1] . "</td>
            </tr>";
            } else{
                echo '<td colspan="2" style="text-align: center;">No information yet.</td>';
            }
    }
        public function getTotalBDOF()
    {
        $query = $this->conn->prepare("SELECT FORMAT(sum(total_amount), 2) from budget_info");
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0)
            while ($row = $query->fetch()) {
                echo "&#x20B1;&nbsp;" . $row[0] . "";
            } else {
                echo '&#x20B1;0';
            }
    }
    
    public function getTotalPayment()
    {
        $query = $this->conn->prepare("SELECT FORMAT(sum(pay_amt), 2), stud_lrno FROM
            payment pm
            JOIN
            balance bal ON pm.balb_id = bal.bal_id
            JOIN
            student st ON st.stud_id = bal.stud_idb
            JOIN
            guardian pr ON st.guar_id = pr.guar_id
            WHERE
            pr.acc_idx = '" . $_SESSION['accid'] . "' GROUP by stud_id");
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0){
            while ($row = $query->fetch()) {
                echo "<span class=\"wlrno\" data-lrno=\"" . $row[1] . "\">&#x20B1;&nbsp;" . $row[0] . "</span>";
            }
        }
    }

    /*********Name of Student*********/
    
    public function getNameOfStud()
    {
        $query = $this->conn->prepare("SELECT stud_lrno, CONCAT(first_name,
            ' ',
            middle_name,
            ' ',
            last_name) as 'name', CONCAT('Grade ', year_level, '-', sec_name) 'section', stud_status
            FROM
            student st
            JOIN
            guardian pr ON st.guar_id = pr.guar_id
            JOIN 
            accounts ac on ac.acc_id = pr.acc_idx
            JOIN 
            section on section.sec_id = st.secc_id
            WHERE
            pr.acc_idx = " . $_SESSION['accid'] . "
            AND st.stud_status = 'Officially Enrolled'");
        $query->execute();
        if($query->rowCount() > 0){
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return $data;
        }
        return $query;
    }
    
    public function getLRNOfStud()
    {
        $query = $this->conn->prepare("SELECT  
            stud_lrno
            FROM
            student st
            JOIN
            guardian pr ON st.guar_id = pr.guar_id
            JOIN 
            accounts ac on ac.acc_id = pr.acc_idx
            WHERE
            pr.acc_idx = '" . $_SESSION['accid'] . "' and stud_status IN ('Officially Enrolled','Temporarily Enrolled') order by stud_lrno");
        $query->execute();
        if ($query->rowCount() > 0) {
            foreach ($query->fetchAll() as $result) {
                echo '<span class="wlrno" data-lrno="' . $result['stud_lrno'] . '">' . $result['stud_lrno'] . '</span>';
            }
        } else {
            echo 'No results found.';
        }
    }
    
    public function getLRNOfStud2()
    {
        $query = $this->conn->prepare("SELECT  
            stud_lrno
            FROM
            student st
            JOIN
            guardian pr ON st.guar_id = pr.guar_id
            JOIN 
            accounts ac on ac.acc_id = pr.acc_idx
            WHERE
            pr.acc_idx = " . $_SESSION['accid'] . "
            AND stud_status = 'Officially Enrolled'");
        $query->execute();
        $rowCount = $query->fetch();
        return " " . $rowCount[0] . " ";
    }
    
    
    /************** ATTENDANCE PAGE **********************/

    public function getAttDateRemarks()
    {
        $query = $this->conn->prepare("SELECT 
         DATE_FORMAT(DATE(att_date), '%M %e, %Y') as 'att_date', subj_name, type, att_remarks, remarks, att_id, att_attachment, att_remarks, stud_lrno
         FROM
         attendance att
         JOIN
         student st ON att.stud_ida = st.stud_id
         JOIN
         guardian pr ON st.guar_id = pr.guar_id
         JOIN
         accounts ac ON ac.acc_id = pr.acc_idx
         JOIN
         subject ON att.subjatt_id = subject.subj_id
         WHERE
         pr.acc_idx= '" . $_SESSION['accid'] . "' AND st.stud_lrno = 'Officially Enrolled' order by stud_lrno") or die("failed!");
        $query->execute();
        if ($query->rowCount() > 0) {
            while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $r;
            }
            return $data;
        } else {
            echo '<tr>
        <td colspan="6">NO LATE/ABSENCES! KEEP IT UP!</td>
        </tr>';
        }
        return $query;
    }
    
    public function getLate()
    {
        $query = $this->conn->prepare("SELECT count(type) as 'att_type', stud_lrno from attendance att 
            JOIN 
            student st on att.stud_ida = st.stud_id 
            JOIN
            guardian pr ON st.guar_id = pr.guar_id
            JOIN
    		subject ON subject.subj_id = att.subjatt_id
            JOIN
            accounts ac on ac.acc_id = pr.acc_idx where 
            pr.acc_idx = '" . $_SESSION['accid'] . "' AND type = 'Late' AND st.stud_lrno = 'Officially Enrolled' order by stud_lrno");
        $query->execute();
        $rowCount = $query->fetchAll();
        foreach ($rowCount as $row) {
            echo "<span class=\"wlrno\" data-lrno=\"" . $row['stud_lrno'] . "\">" . $row['att_type'] . "</span> ";
        }
    }
    public function getAbsent()
    {
        $query = $this->conn->prepare("SELECT count(type) as 'att_type', stud_lrno from attendance att 
            JOIN 
            student st on att.stud_ida = st.stud_id  
            JOIN
            guardian pr ON st.guar_id = pr.guar_id
            JOIN
   		 	subject ON subject.subj_id = att.subjatt_id
            JOIN 
            accounts ac on ac.acc_id = pr.acc_idx
            WHERE
            pr.acc_idx = '" . $_SESSION['accid'] . "' and type = 'Absent' AND st.stud_lrno = 'Officially Enrolled' order by stud_lrno");
        $query->execute();
        $rowCount = $query->fetchAll();
        foreach ($rowCount as $row) {
            echo "<span class=\"wlrno\" data-lrno=\"" . $row['stud_lrno'] . "\">" . $row['att_type'] . "</span> ";
        }
    }
    
    public function applyReason($att_id, $remarks, $attachment, $lrno)
    {
        try {
            $stud_id = $_SESSION['accid'];
            $sql     = $this->conn->prepare("UPDATE attendance SET remarks=:remarks, att_attachment=:att_attachment, apply_reason = 'Parent' WHERE att_id=:att_id");
            if ($sql->execute(array(
                'att_id' => $att_id,
                'remarks' => $remarks,	
                ':att_attachment' => (empty($attachment['name']) ? null : $attachment['name'])
            ))) {
                $sql2 = $this->conn->prepare("SELECT * from attendance WHERE stud_ida=?");
                $sql2->bindParam(1, $stud_id);
                $sql2->execute();
                $row2   = $sql2->fetch(PDO::FETCH_ASSOC);
                $att_id = $row2['att_id'];
                $this->alert("Success!", "Reason has been updated", "success", "parent-attendance");
            } else {
                $this->alert("Error!", "Failed to add reason", "error", "parent-attendance");
            }
        }
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        $file         = $attachment['name'];
        $size         = $attachment['size'];
        $temp1        = $attachment['tmp_name'];
        $pathWithFile = "public/letter/" . $file; //set upload folder path
        
        $sql2 = $this->conn->prepare("SELECT * FROM attendance");
        $sql2->execute();
        $row       = $sql2->fetch(PDO::FETCH_ASSOC);
        $id        = $row['att_id'];
        $fileToDel = trim(strval($row['att_attachment']));
        $new_path  = realpath('public/letter/' . $fileToDel);
        /*@unlink($new_path);*/
        
        $temp2       = $attachment['tmp_name'];
        $staticValue = "attachment";
        $path        = "public/letter/";
        $underScore  = "_";
        $tmp         = explode('.', $file);
        $ext         = end($tmp);
        $filename    = "$file";
        $newname     = $path . $filename;
        if (!empty($attachment['name'])) {
            if (!file_exists($newname)) {
                if ($size < 10000000) { //check file size of 10mb
                    /*move_uploaded_file($temp1, $pathWithFile);*/ //move temporary file to your folder
                    move_uploaded_file($temp2, $newname);
                    $sql3 = $this->conn->prepare("UPDATE attendance SET att_attachment=:att_attachment WHERE att_id=:att_id");
                    $sql3->execute(array(
                        ':att_attachment' => $filename,
                        ':att_id' => $id
                    ));
                } else {
                    $this->alert("Error!", "Failed! Maximum file size 20 mb", "error", "parent-attendance");
                }
            } else {
                $this->alert("Success!", "Successfully updated the attachment.", "success", "parent-attendance");
            }
        }
    }
    
    public function alert($title, $message, $type, $page)
    {
        $newUrl = URL . $page;
        echo "<script>
            swal({
                title: \"" . $title . "\",
                text: \"" . $message . "\",
                icon: \"" . $type . "\"
            }).then(function() {
                 window.location = '" . $newUrl . "';
            });
        </script>";
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
                $this->alert("Success!", "The attachment has been deleted", "success", "parent-attendance");
            }else{  
                $this->alert("Error!", "Failed to delete attachment", "error", "parent-attendance");
            }
        } catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
}
    
  
    /************* CORE VALUES PAGE *************/

    public function getCV($lrno)
    {
        $query = $this->conn->prepare("SELECT cv_name FROM core_values UNION SELECT cv_name FROM core_values 
                JOIN 
                behavior on cv_id = core_values
                JOIN
                student st on stud_id = stud_idy
                JOIN 
                guardian g on st.guar_id = g.guar_id 
                JOIN 
                accounts ac on ac.acc_id = g.acc_idx 
                WHERE acc_idx = :acc_id and stud_lrno = :stud_lrno AND stud_status = 'Officially Enrolled'group by 1");
        $query->execute(array(
            ":acc_id" => $_SESSION['accid'],
            ":stud_lrno" => $lrno
        ));
        $cv_name = $query->fetchAll();
        $acc_id  = $_SESSION['accid'];
        for ($c = 0; $c < count($cv_name); $c++) {
            $cvname = $cv_name[$c]['cv_name'];
            $first  = $this->getCVGrade($lrno, $cvname, '1st');
            $second = $this->getCVGrade($lrno, $cvname, '2nd');
            $third  = $this->getCVGrade($lrno, $cvname, '3rd');
            $fourth = $this->getCVGrade($lrno, $cvname, '4th');
            echo '<tr>';
            echo '<td>' . $cvname . '</td>';
            echo $first === 0 ? '<td></td>' : '<td>' . $first . '</td>';
            echo $second === 0 ? '<td></td>' : '<td>' . $second . '</td>';
            echo $third === 0 ? '<td></td>' : '<td>' . $third . '</td>';
            echo $fourth === 0 ? '<td></td>' : '<td>' . $fourth . '</td>';
            echo '<td>'.$lrno.'</td>';
            echo '</tr>';
        }
    }
    
    private function getCVGrade($lrno, $cvname, $bhv_grading)
    {
        $query = $this->conn->prepare("SELECT 
				bhv_remarks, core_values.cv_name, bhv_grading, behavior.bhv_id
				FROM
				behavior
				JOIN
				student st ON behavior.stud_idy = st.stud_id
				JOIN
				core_values ON behavior.core_values = core_values.cv_id
				JOIN 
				guardian g on st.guar_id = g.guar_id 
				JOIN 
				accounts ac on ac.acc_id = g.acc_idx 
                WHERE
                stud_lrno = :stud_lrno 
                AND
                acc_idx = :acc_id 
                AND 
                bhv_grading = :bhv_grading 
                AND 
                cv_name = :cv_name
                AND stud_status = 'Officially Enrolled'
                ORDER BY 3");
        $query->execute(array(
            ':stud_lrno' => $lrno,
            ':acc_id' => $_SESSION['accid'],
            ':bhv_grading' => $bhv_grading,
            ':cv_name' => $cvname
        ));
        $result = $query->fetch();
        return $query->rowCount() > 0 ? $result['bhv_remarks'] : 0;
    }
    
    /************* GRADES PAGE *************/

    public function getChildGrade($lrno)
    {
        /*******************Get subject name*******************/
        $query = $this->conn->prepare("SELECT subj_dept, subj_name
        FROM
            schedsubj ss
                JOIN
            section sec ON ss.sw_id = sec.sec_id
                JOIN
            student st ON st.secc_id = sec.sec_id
                JOIN
            subject sub ON sub.subj_id = ss.schedsubjb_id 
            join guardian g on st.guar_id = g.guar_id 
            join accounts ac on ac.acc_id = g.acc_idx 
            where acc_idx = :acc_id
        and stud_lrno = :stud_lrno
        AND
        stud_status = 'Officially Enrolled'");
        $query->execute(array(
            ":acc_id" => $_SESSION['accid'],
            ":stud_lrno" => $lrno
        ));
        $subjects = $query->fetchAll();
        
        /*******************Get student grade*******************/
        for ($c = 0; $c < count($subjects); $c++) {
            $subject_name = $subjects[$c]['subj_name'];
            $first        = $this->getGrade($lrno, $subject_name, '1st');
            $second       = $this->getGrade($lrno, $subject_name, '2nd');
            $third        = $this->getGrade($lrno, $subject_name, '3rd');
            $fourth       = $this->getGrade($lrno, $subject_name, '4th');
            $fourth		  = (($fourth === null || $fourth === '') ? 0 : $fourth);
            $average      = round(($first + $second + $third + $fourth) / 4);
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
                $checker = $this->getGrade($lrno, $subject_name, '4th');
                if ($checker === null || $checker === '') {
                	echo '<td><font color="orange"><b>INC<b></font></td>';
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
					echo '<td><font color="red"><b>FAILED</b></font></td>';
					echo '<td></td>';
                } else {
					echo '<td></td>';
					echo '<td></td>';
                }
            } else if ($average >= 75){
            	echo '<td><font color="green"><b>PASSED</b></font></td>';
            	echo '<td></td>';	
            }

            if ($average <= 2 === 'Failed'){
                echo '<td>sample</td>';
            }
                       

            echo '<td>'.$lrno.'</td>';
        	echo '</tr>';	
            
        }
    }
                    
    private function getGrade($lrno, $subject, $grading)
    {
        $query = $this->conn->prepare("SELECT  CONCAT(first_name, ' ', last_name) 'Student', grade, subj_name 'subject', grading, remarks FROM grades JOIN student ON grades.studd_id = student.stud_id JOIN facsec fs ON grades.secd_id = fs.sec_idy JOIN schedsubj ss ON (grades.facd_id = ss.fw_id && grades.secd_id = ss.sw_id) JOIN subject ON (ss.schedsubjb_id = subject.subj_id && grades.subj_ide = subject.subj_id) WHERE student.stud_lrno = :stud_lrno AND subj_name = :subject AND grading = :grading AND stud_status = 'Officially Enrolled' GROUP BY 2 ORDER BY 3");
        $query->execute(array(
            ':stud_lrno' => $lrno,
            ':subject' => $subject,
            ':grading' => $grading
        ));
        $result = $query->fetch();
        return $query->rowCount() > 0 ? $result['grade'] : 0;
    }

    /******* Get Final Average (GWA) ********/
    public function getGeneralAverage($lrno)
    {
        $query = $this->conn->prepare("SELECT ROUND(SUM(average)/4,2) as Ave from 
        (SELECT 
            CONCAT(first_name, ' ', last_name) 'Student',
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
            JOIN 
            guardian g on student.guar_id = g.guar_id
        WHERE
            stud_lrno = :stud_lrno AND g.acc_idx = :acc_id
        AND stud_status = 'Officially Enrolled'
        GROUP BY 3
        ORDER BY 3) t1");
        $query->execute(array(
            ":stud_lrno" => $lrno,
            ":acc_id" => $_SESSION['accid']
        ));     
        $row = $query->fetch();
        $studSubj = $this->conn->prepare("SELECT  * FROM schedsubj ss JOIN subject ON schedsubjb_id = subj_id JOIN section ON sw_id = sec_id JOIN student ON secc_id = sw_id JOIN accounts ON accc_id = acc_id WHERE stud_lrno = :lrno");
        $studSubj->execute(array(
            ':lrno' => $lrno
        ));
        $studGrid = $this->conn->prepare("SELECT * FROM accounts JOIN student on acc_id = accc_id JOIN grades ON stud_id = studd_id WHERE stud_lrno = :lrno GROUP BY subj_ide");
        $studGrid->execute(array(
            ':lrno' => $lrno
        ));

        $checkIfPassedAll = $this->conn->prepare("SELECT * FROM accounts JOIN student on acc_id = accc_id JOIN grades on stud_id = studd_id WHERE grading = '4th' AND  stud_lrno = :lrno AND remarks = 'Failed' GROUP BY subj_ide");
        $checkIfPassedAll->execute(array(':lrno' => $lrno));

        if ($studSubj->rowCount() === $studGrid->rowCount()) {
            if ($row[0] === null) {
                echo '<span class="wlrno" data-lrno="'.$lrno.'">No average yet</span>';
            } else {
                echo '<span class="wlrno" data-lrno="'.$lrno.'">' . $row[0] . '</span>';
            }
        } else {
            /*echo '<span class="wlrno" data-lrno="'.$lrno.'">Grades are not yet complete</span>';*/
        }
    }

     public function getGeneralAverageRemarks($lrno)
    {
        $query = $this->conn->prepare("SELECT ROUND(SUM(average)/4,2) as Ave from 
        (SELECT 
            CONCAT(first_name, ' ', last_name) 'Student',
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
            JOIN 
            guardian g on student.guar_id = g.guar_id
        WHERE
            stud_lrno = :stud_lrno AND g.acc_idx = :acc_id
        AND stud_status = 'Officially Enrolled'
        GROUP BY 3
        ORDER BY 3) t1");
        $query->execute(array(
            ":stud_lrno" => $lrno,
            ":acc_id" => $_SESSION['accid']
        ));     
        $row = $query->fetch();
        $studSubj = $this->conn->prepare("SELECT  * FROM schedsubj ss JOIN subject ON schedsubjb_id = subj_id JOIN section ON sw_id = sec_id JOIN student ON secc_id = sw_id JOIN accounts ON accc_id = acc_id WHERE stud_lrno = :lrno");
        $studSubj->execute(array(
            ':lrno' => $lrno
        ));
        $studGrid = $this->conn->prepare("SELECT * FROM accounts JOIN student on acc_id = accc_id JOIN grades ON stud_id = studd_id WHERE stud_lrno = :lrno GROUP BY subj_ide");
        $studGrid->execute(array(
            ':lrno' => $lrno
        ));

        $checkIfPassedAll = $this->conn->prepare("SELECT * FROM accounts JOIN student on acc_id = accc_id JOIN grades on stud_id = studd_id WHERE grading = '4th' AND  stud_lrno = :lrno AND remarks = 'Failed' GROUP BY subj_ide");
        $checkIfPassedAll->execute(array(':lrno' => $lrno));

        if ($studSubj->rowCount() === $studGrid->rowCount()) {
            if ($checkIfPassedAll->rowCount() > 0) {
                echo '';
            } else if ($row[0] != null && $row[0] >= 75) {
                echo '<span class="wlrno" data-lrno="'.$lrno.'"><font color="green"><b>PASSED</b></font></span>';
            } else if ($row[0] != null && $row[0] < 75) {
                echo '<span class="wlrno" data-lrno="'.$lrno.'"><font color="red"><b>FAILED</b></font></span>';
            }
        }
    }

    /******* Promotion ********/
    public function getPromotion($lrno)
    {
        $query = $this->conn->prepare("SELECT ROUND(SUM(average)/4,2) as Ave from 
        (SELECT 
            CONCAT(first_name, ' ', last_name) 'Student',
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
            JOIN 
            guardian g on student.guar_id = g.guar_id
        WHERE
            stud_lrno = :stud_lrno AND g.acc_idx = :acc_id
        AND stud_status = 'Officially Enrolled'
        GROUP BY 3
        ORDER BY 3) t1");
        $query->execute(array(
            ":stud_lrno" => $lrno,
            ":acc_id" => $_SESSION['accid']
        ));     
        $row = $query->fetch();
        $studSubj = $this->conn->prepare("SELECT  * FROM schedsubj ss JOIN subject ON schedsubjb_id = subj_id JOIN section ON sw_id = sec_id JOIN student ON secc_id = sw_id JOIN accounts ON accc_id = acc_id WHERE stud_lrno = :lrno");
        $studSubj->execute(array(
            ':lrno' => $lrno
        ));
        $studGrid = $this->conn->prepare("SELECT * FROM accounts JOIN student on acc_id = accc_id JOIN grades ON stud_id = studd_id WHERE stud_lrno = :lrno GROUP BY subj_ide");
        $studGrid->execute(array(
            ':lrno' => $lrno
        ));

        if ($studSubj->rowCount() === $studGrid->rowCount()) {
            $checkIfPassedAll = $this->conn->prepare("SELECT * FROM accounts JOIN student on acc_id = accc_id JOIN grades on stud_id = studd_id WHERE grading = '4th' AND stud_lrno = :lrno AND remarks = 'Failed' GROUP BY subj_ide");
            $checkIfPassedAll->execute(array(':lrno' => $lrno));

            if ($row[0] === null) {
                 echo '<span class="wlrno" data-lrno="'.$lrno.'">Not Yet Available</span>';
            } else if ($checkIfPassedAll->rowCount() > 0) {
                    echo '<span style="color: rgb(255, 0, 0);" class="wlrno" data-lrno="'.$lrno.'">Failure to pass some of subjects.<br></span><span class="wlrno" data-lrno="'.$lrno.'">Please consult your adviser for summer term to finish failed subjects.</span>';         
            } else if ($row[0] >= 75){
                echo '<span class="wlrno" data-lrno="'.$lrno.'"><b>Promoted to next grade level</b></span>';
            }
        } else {
            echo '<span class="wlrno" data-lrno="'.$lrno.'"><b>Grades are not yet complete</b></span>';
        }
    }
   
    /************* SCHEDULE PAGE *************/
    public function getChildSchedule($lrno)
    {
        $querySchedule = $this->conn->query("SELECT 
                '09:40:00' AS 'time_start',
                '10:00:00' AS 'time_end',
                '<b>RECESS</b>' AS subj_name,
                '' AS 'stud_sec',
                '' AS 'facultyname',
                '<b>RECESS</b>' AS 'subject'

                UNION SELECT 
                '12:00:00' AS 'time_start',
                '13:00:00' AS 'time_end',
                '<b>LUNCH</b>' AS subj_name,
                '' AS 'stud_sec',
                '' AS 'facultyname',
                '<b>LUNCH</b>' AS 'subject'

                UNION SELECT
                time_start,
                time_end,
                subj_name,
                CONCAT('G', year_level, ' - ', sec_name) AS 'stud_sec',
                CONCAT(fac_fname,
                ' ',
                fac_midname,
                '. ',
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
                faculty ON section.fac_idv = faculty.fac_id
                JOIN
                schedsubj ss ON ss.fw_id = faculty.fac_id
                JOIN
                subject ON subject.subj_id = ss.schedsubjb_id
                JOIN
                student st ON section.sec_id = st.secc_id
                JOIN
                guardian gd ON gd.guar_id = st.guar_id
                JOIN
                accounts acc ON acc.acc_id = gd.acc_idx
                WHERE
                (stud_lrno = '" . $lrno . "' AND acc_id = '" . $_SESSION['accid'] . "') GROUP by 1)
                GROUP BY time_start
                ORDER BY 1") or die("FAILED");
        $result     = $querySchedule->fetchAll();
        $time_start = array(
            '07:40:00',
            '08:40:00',
            '09:40:00',
            '10:00:00',
            '11:00:00',
            '12:00:00',
            '13:00:00',
            '14:00:00',
            '15:00:00'
        );
        $time_end   = array(
            '08:40:00',
            '09:40:00',
            '10:00:00',
            '11:00:00',
            '12:00:00',
            '13:00:00',
            '14:00:00',
            '15:00:00',
            '16:00:00'
        );
        
        echo '<div class="widgetcontent" data-lrno="'.$lrno.'">
            <table class="table-children-schedule" class="display">
            <thead>
                <th>Schedule</th>
                <th>Teacher and Subject</th>
            </thead>
            <tbody>';
        for ($c = 0; $c < count($time_start); $c++) {
            echo '<tr>';
            $subj_name      = '';
            $faculty        = isset($result[$c]['facultyname']) ? ($result[$c]['facultyname']) : '';
            $new_time_start = date('h:i A', strtotime($time_start[$c]));
            $new_time_end   = date('h:i A', strtotime($time_end[$c]));
            foreach ($result as $row) {
                if ($time_start[$c] == $row['time_start']) {
                    $subj_name = $row['subject'];
                    $section   = $row['stud_sec'];
                }
            }
            echo '<td>' . $new_time_start . ' - ' . $new_time_end . ' Daily</td>';
            echo '<td>' . ($subj_name !== '' ? '<div>' . $subj_name . '<br>' . $faculty . '</div>' : 'Unassigned') . '</td>';
            echo '</tr>';
        }
        echo '
            </tbody>
            </table>
            </div>
        ';
        
    }

    public function getAllChildTranscript($lrno) {
        $query = $this->conn->prepare("SELECT * FROM student JOIN transcript_archive ON stud_id = tt_stud WHERE stud_lrno = :lrno AND stud_status = 'Officially Enrolled'");
        $query->execute(array(
            ':lrno' => $lrno
        ));
        foreach($query->fetchAll() as $row) {
            echo '<tr>';
            echo '<td>'.$row['subject'].'</td>';
            echo '<td>'.$row['grade'].'</td>';
            echo '<td>'.$row['trans_remarks'].'</td>';
            echo '<td>'.$row['sy_grades'].'</td>';
            echo '<td>'.$lrno.'</td>';
            echo '</tr>';
        }
    }

     public function getAllYearsHistory() {
        $query = $this->conn->prepare("SELECT * FROM accounts JOIN student ON acc_id = accc_id JOIN transcript_archive ON stud_id = tt_stud WHERE stud_status = 'Officially Enrolled' GROUP BY sy_grades");
        $query->execute(array(
            ':accid' => $_SESSION['accid']
        ));
        foreach($query->fetchAll() as $row) {
            echo '<option value="'.$row['sy_grades'].'">'.$row['sy_grades'].'</option>';
        }
    }
    
    /*END OF CODE*/
}

?>