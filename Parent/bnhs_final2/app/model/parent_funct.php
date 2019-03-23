<?php
require 'app/model/connection.php';
class ParentFunct
{
    
    public function __construct()
    {
        $this->conn = new Connection;
        $this->conn = $this->conn->connect();
    }
    
    public function getAnnouncements()
    {
        $query = $this->conn->prepare("SELECT DATE_FORMAT(date(date_start), '%M %e %Y'), post from announcements an join accounts ac on an.post_adminid = ac.acc_id");
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0) {
            while ($row = $query->fetch()) {
                echo " 
                <tr>
                <td> " . $row[0] . " </td> 
                <td> " . $row['post'] . " </td>
                </tr>
                ";
            }
        } else {
            echo "No announcements yet.";
        }
    }
    
    public function getMiscellaneousFee()
    {
        $query = $this->conn->prepare("select * from balance");
        $query->execute();
        $rowCount = $query->fetch();
        echo " " . $rowCount['misc_fee'] . " ";
    }
    
    public function getPaymentHistory()
    {
        $query = $this->conn->prepare("SELECT 
            stud_lrno,
            init_bal,
            pay_amt,
            DATE_FORMAT(DATE(pay_date), '%M %e %Y') 
            FROM
            payment pm
            JOIN
            balance bal ON pm.balb_id = bal.bal_id
            JOIN
            student st ON st.stud_id = bal.stud_idb
            WHERE
            st.stud_id = 1");
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0) {
            while ($row = $query->fetch()) {
                echo "<tr>    
                <td>" . $row[0] . "</td>
                <td> &#x20B1;&nbsp;" . $row[1] . "</td>
                <td> &#x20B1;&nbsp;" . $row[2] . "</td>
                <td>" . $row[3] . "</td>
                </tr>";
            }
        } else {
            echo "No payments has been made yet.";
        }
    }
    public function getNameOfStud()
    {
        $query = $this->conn->prepare("SELECT CONCAT(first_name,
            ' ',
            middle_name,
            ' ',
            last_name)
            FROM
            student st
            JOIN
            parent pr ON st.stud_id = pr.stude_id
            JOIN
            accounts acc ON pr.pr_id = acc.acc_id
            WHERE
            pr.acc_idx = " . $_SESSION['accid'] . "");
        $query->execute();
        $rowCount = $query->fetch();
        echo " " . $rowCount[0] . " ";
    }
    
    public function getBreakdownOfFees()
    {
        $query = $this->conn->prepare("SELECT * FROM budget_info");
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0)
            while ($row = $query->fetch()) {
                echo "<tr>    
                <td>" . $row[1] . "</td>
                <td> &#x20B1;&nbsp;" . $row[2] . "</td>
                </tr>";
            }
        
    }
    
    public function getChildName()
    {
        $query = $this->conn->prepare("SELECT CONCAT(first_name,
                ' ',
                middle_name,
                ' ',
                last_name)
                FROM
                student st
                JOIN
                parent pr ON st.stud_id = pr.stude_id
                JOIN
                accounts acc ON pr.pr_id = acc.acc_id
                WHERE
                pr.acc_idx = " . $_SESSION['accid'] . "");
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0) {
            while ($row = $query->fetch()) {
                echo " " . $row[0] . " ";
            }
        }
    }
    
    public function getChildLevel()
    {
        $query = $this->conn->prepare("SELECT year_level
                FROM
                student st
                JOIN
                parent pr ON st.stud_id = pr.stude_id
                JOIN
                accounts acc ON pr.pr_id = acc.acc_id
                WHERE
                pr.acc_idx = " . $_SESSION['accid'] . "");
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0) {
            while ($row = $query->fetch()) {
                echo " " . $row[0] . " ";
            }
        }
    }
    
    public function getChildSection()
    {
        $query = $this->conn->prepare("SELECT 
                sec_name
                FROM
                student st
                JOIN
                parent pr ON st.stud_id = pr.stude_id
                JOIN
                accounts acc ON pr.pr_id = acc.acc_id
                JOIN
                attendance att ON att.stud_ida = st.stud_id
                JOIN
                facsec fs ON att.fac_idb = fac_idy
                JOIN
                section sec ON sec.sec_id = fs.sec_idy
                WHERE
                pr.acc_idx = " . $_SESSION['accid'] . "  and (st.year_level = sec.grade_lvl)");
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0) {
            while ($row = $query->fetch()) {
                echo " " . $row[0] . " ";
            }
        }
    }
    
    public function getNoOfDaysPresent()
    {
        $query = $this->conn->prepare("SELECT count(remarks) from attendance att JOIN student st on att.stud_ida = st.stud_id JOIN
                parent pr ON st.stud_id = pr.stude_id
                JOIN
                accounts acc ON pr.pr_id = acc.acc_id where 
                acc_id = 1 and remarks = 'Present' ");
        $query->execute();
        $rowCount = $query->fetch();
        echo " " . $rowCount[0] . " ";
    }
    
    public function getNoOfDaysAbsent()
    {
        $query = $this->conn->prepare("SELECT count(remarks) from attendance att JOIN student st on att.stud_ida = st.stud_id JOIN
                parent pr ON st.stud_id = pr.stude_id
                JOIN
                accounts acc ON pr.pr_id = acc.acc_id where 
                acc_id = 1 and remarks = 'Late' ");
        $query->execute();
        $rowCount = $query->fetch();
        echo " " . $rowCount[0] . " ";
    }
    
    
    
    public function getTotalBDOF()
    {
        $query = $this->conn->prepare("SELECT sum(acc_amount) from budget_info");
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0)
            while ($row = $query->fetch()) {
                echo "&#x20B1;&nbsp;" . $row[0] . "";
            }
        
    }
    
    public function getChildGrade()
    {
        /*******************Get subject name*******************/
        $query = $this->conn->prepare("SELECT 
                    subj_name
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
                    subject ON (ss.schedsubjb_id = subject.subj_id && grades.subj_ide = subject.subj_id)
                    WHERE
                    student.stud_id = 1 
                    group by 1 ORDER BY 1;");
        $query->execute();
        $subjects = $query->fetchAll();
        $stud_id  = 1; //sample
        /*$rowCount1 = $query1->rowCount();*/
        
        /*******************Get student grade*******************/
        for ($c = 0; $c < count($subjects); $c++) {
            $subject_name = $subjects[$c]['subj_name'];
            $first        = $this->getGrade($stud_id, $subject_name, '1st');
            $second       = $this->getGrade($stud_id, $subject_name, '2nd');
            $third        = $this->getGrade($stud_id, $subject_name, '3rd');
            $fourth       = $this->getGrade($stud_id, $subject_name, '4th');
            $average      = ($first + $second + $third + $fourth) / 4;
            echo '<tr>';
            echo '<td>' . $subject_name . '</td>';
            echo $first === 0 ? '<td></td>' : '<td>' . $first . '</td>';
            echo $second === 0 ? '<td></td>' : '<td>' . $second . '</td>';
            echo $third === 0 ? '<td></td>' : '<td>' . $third . '</td>';
            echo $fourth === 0 ? '<td></td>' : '<td>' . $fourth . '</td>';
            if ($first === 0 || $second === 0 || $third === 0 || $fourth === 0) {
                echo '<td></td>';
            } else {
                echo '<td>' . $average . '</td>';
            }
            echo '</tr>';
        }
    }
    
    private function getGrade($stud_id, $subject, $grading)
    {
        $query = $this->conn->prepare("SELECT  CONCAT(first_name, ' ', last_name) 'Student', grade, subj_name 'subject', grading FROM grades JOIN student ON grades.studd_id = student.stud_id JOIN facsec fs ON grades.secd_id = fs.sec_idy JOIN schedsubj ss ON (grades.facd_id = ss.fw_id && grades.secd_id = ss.sw_id) JOIN subject ON (ss.schedsubjb_id = subject.subj_id && grades.subj_ide = subject.subj_id) WHERE student.stud_id = :stud_id AND subj_name = :subject AND grading = :grading GROUP BY 2 ORDER BY 3");
        $query->execute(array(
            ':stud_id' => $stud_id,
            ':subject' => $subject,
            ':grading' => $grading
        ));
        $result = $query->fetch();
        return $query->rowCount() > 0 ? $result['grade'] : 0;
    }
    
    public function getChildSchedule()
    {
        $query = $this->conn->prepare("SELECT 
                time, subj_name, day
                FROM
                schedsubj ss
                JOIN
                subject ON ss.schedsubjb_id = subject.subj_id
                JOIN
                facsec fs ON (fs.fac_idy = ss.fw_id
                && fs.sec_idy = ss.sw_id)
                JOIN
                section ON fs.sec_idy = section.sec_id
                /*WHERE
                ss.fw_id = 1*/");
        $query->execute();
        $rowCount = $query->rowCount();
        if ($rowCount > 0)
            while ($row = $query->fetch()) {
                echo "<tr>    
                        <td>" . $row[0] . "</td>
                        <td>" . $row[1] . "</td>
                        <td>" . $row[2] . "</td>
                        </tr>";
            }
    }
    /*END OF CODE*/
}
?>